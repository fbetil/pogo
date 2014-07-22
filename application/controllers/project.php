<?php

/**
 * -------------------------------------------------------------------------------
 * PoGo - Organize and Manage your Projects like a Chief
 * Copyright (c) 2014 by Florian BETIL <fbetil@gmail.com>
 *
 * This file is part of PoGo.
 *
 * PoGo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PoGo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PoGo.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Authors:
 *
 * Florian BETIL : <fbetil@gmail.com>
 * -------------------------------------------------------------------------------
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    public function Index(){
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectViewer');

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));

        //get user linked projects
        $projects = PoGo\ProjectQuery::create()
            ->useProjectActorQuery()
                ->filterByActorId($this->session->userdata('actor_id'))
            ->endUse()
            ->orderByCode('desc')
            ->find();

        //render
        $this->pogo->html->view('project/projects.php', array('projects'=>$projects));
    }

    public function View($projectid) {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectViewer');

        //get project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectid)) ?: $this->pogo->html->e401();

        //get ordered linked files
        $files = PoGo\FileQuery::create()
            ->filterByProjectId($projectid)
            ->orderByFolder()
            ->orderByName()
            ->orderByVersion('desc')
            ->find();

        //generate nav
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$projectid));

        //render
        $this->pogo->html->view('project/project.php', array('project'=>$project, 'files'=>$files));
	}

    public function Add() {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectEditor');

        //generate new project
        $project = new PoGo\Project();
        $project->setCode('POGO.'.date('ym').'.');

        //generate nav
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav(lang('project_add_a_1'), site_url('/project/add'));

        $this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project'));

        //render
        $this->pogo->html->view('project/project.php', array('project'=>$project, 'files'=>array()));
    }

    public function Gantt($projectid){
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectViewer');

        //get project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectid)) ?: $this->pogo->html->e401();

        //generate gantt xml data
        $gantt = array();

        //get tasks
        foreach($project->getTasks() as $task){
            $gantt[] = array(
                "name" => "<div class='smaller'>".$task->getName()."</div>",
                "values" => array(
                        array(
                            "id" => "t".$task->getId(),
                            "from" => "/Date(".$task->getStartDate('U')."000)/",
                            "to" => "/Date(".$task->getDueDate('U')."000)/",
                            "desc" => "<div class='smaller'><b>".$task->getName()."</b><br>".$task->getDescription()."</div>",
                            "customClass" => "pointer"
                            )
                    )
            );
        }

        //get milestones
        foreach($project->getMilestones() as $milestone){
            $gantt[] = array(
                "name" => "<div class='smaller'>".$milestone->getName()."</div>",
                "values" => array(
                        array(
                            "id" => "m".$milestone->getId(),
                            "from" => "/Date(".$milestone->getDueDate('U')."000)/",
                            "to" => "/Date(".$milestone->getDueDate('U')."000)/",
                            "desc" => "<div class='smaller'><b>".$milestone->getName()."</b><br>".$milestone->getDescription()."</div>",
                            "customClass" => "pointer gantt_milestone"
                            )
                    )
            );
        }

        //Send in json format
        $this->pogo->html->json($gantt);

    }

    public function Post() {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectEditor');

        //Set form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Code', 'lang:project_view_p_4', 'required|callback_projectcode_check|callback_isunique_projectcode_check['.$this->input->post('Id').']');
        $this->form_validation->set_rules('Name', 'lang:project_view_p_2', 'required');
        $this->form_validation->set_rules('Description', 'lang:project_view_p_3', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->pogo->html->error(validation_errors());
        }else{
            try{
                //Getting input data and set Id to Null if empty
                $inputdata = $this->input->post(null);
                if($inputdata['Id'] == '') $inputdata['Id'] = null;

                //get project if not a new project
                if ($inputdata['Id']){
                    //get project or exit if not linked to project
                    ($project = $this->pogo->getLinkedProject($inputdata['Id'])) ?: $this->pogo->html->e401();
                }

                //Try to retrieve existing project
                $project = PoGo\ProjectQuery::create()
                    ->filterById($inputdata['Id'])
                    ->findOneOrCreate();
                
                //Load input data into project and save
                $project->fromArray($inputdata);

                //Save
                $isnew = $project->isNew();
                $project->save();

                //Link user to project
                if($isnew){
                    $projectactor = new PoGo\ProjectActor();
                    $projectactor->setProjectId($project->getId())
                        ->setActorId($this->session->userdata('actor_id'))
                        ->setRole(lang('project_add_p_2'))
                        ->save();
                }

                //send success
                $this->pogo->html->success($project->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }

    public function Delete($projectid){
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectEditor');

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectid)) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //delete all linked project
        PoGo\FileQuery::create()->filterByProjectId($projectid)->delete();
        PoGo\MilestoneQuery::create()->filterByProjectId($projectid)->delete();
        PoGo\NoteQuery::create()->filterByProjectId($projectid)->delete();

        $tasks = PoGo\TaskQuery::create()->filterByProjectId($projectid)->find();
        foreach ($tasks as $task) {
            PoGo\TaskActorQuery::create()->filterByTaskId($task->getId())->delete();
            $task->delete();
        }

        PoGo\ProjectActorQuery::create()->filterByProjectId($projectid)->delete();
        
        //then delete project
        $project->delete();

        //return success
        $this->pogo->html->success();
    }

    public function ProjectCode_check($projectcode) {
        return $this->pogo->ProjectCode_check($projectcode);
    }

    public function IsUnique_ProjectCode_check($projectcode, $projectid) {
        return $this->pogo->IsUnique_ProjectCode_check($projectcode, $projectid);
    }
    
}

