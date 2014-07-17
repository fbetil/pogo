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

    public function View($projectid) {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectViewer');

        //get project or exit if not linked to project
        ($project = $this->pogo->auth->getProject($projectid)) ?: $this->pogo->html->e401();

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

    public function Gantt($projectid){
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectViewer');

        //get project or exit if not linked to project
        ($project = $this->pogo->auth->getProject($projectid)) ?: $this->pogo->html->e401();

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
        $this->form_validation->set_rules('Id', 'lang:identifier', 'required|integer');
        $this->form_validation->set_rules('Code', 'lang:projects_view_p_4', 'required');
        $this->form_validation->set_rules('Name', 'lang:projects_view_p_2', 'required');
        $this->form_validation->set_rules('Description', 'lang:projects_view_p_3', 'required');

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
                    ($project = $this->pogo->auth->getProject($inputdata['Id'])) ?: $this->pogo->html->e401();
                }

                //Try to retrieve existing project
                $project = PoGo\ProjectsQuery::create()
                    ->filterById($inputdata['Id'])
                    ->findOneOrCreate();
                
                //Load input data into project and save
                $project->fromArray($inputdata);

                //Save
                $project->save();

                //send success
                $this->pogo->html->success($project->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }
    
}

