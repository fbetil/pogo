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

class ProjectActor extends CI_Controller {

    public function View($projectactorid) {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectActorViewer');

        //get projectactor or exit if projectactor not exists
        ($projectactor = PoGo\ProjectActorQuery::create()->findPk($projectactorid)) ?: $this->pogo->html->e401();

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectactor->getProjectId())) ?: $this->pogo->html->e401();

        //get list of actors
        $actors = PoGo\ActorQuery::create('Actor')->select(array('Id','Label'))->withColumn('CONCAT(Actor.FirstName, \' \', Actor.Name)','Label')->orderByFirstName()->orderByName()->find()->toArray();
        array_unshift($actors, array('Id'=>0, 'Label'=>'---'));
        $actors = json_encode($actors , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav($projectactor->getActor()->getFirstName().' '.$projectactor->getActor()->getName(), site_url('/projectactor/view/'.$projectactorid));

        $this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('projectactor/projectactor.php', array('project'=>$project, 'actors'=>$actors, 'projectactor'=>$projectactor));
	}

    public function Add($projectid) {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectActorEditor');

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectid)) ?: $this->pogo->html->e401();

        //get list of actors
        $actors = PoGo\ActorQuery::create('Actor')->select(array('Id','Label'))->withColumn('CONCAT(Actor.FirstName, \' \', Actor.Name)','Label')->orderByFirstName()->orderByName()->find()->toArray();
        array_unshift($actors, array('Id'=>0, 'Label'=>'---'));
        $actors = json_encode($actors , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        //generate new projectactor
        $projectactor = new PoGo\ProjectActor();
        $projectactor->setProjectId($project->getId())
            ->setActorId(0);

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav(lang('projectactor_add_a_1'), site_url('/projectactor/add/'.$project->getId()));

        $this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('projectactor/projectactor.php', array('project'=>$project, 'actors'=>$actors, 'projectactor'=>$projectactor));
    }

    public function Post() {
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectActorEditor');

        //Set form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ProjectId', 'lang:identifier', 'required|integer');
        $this->form_validation->set_rules('ActorId', 'lang:projectactor_view_p_4', 'required|integer');
        $this->form_validation->set_rules('Role', 'lang:projectactor_view_p_5', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->pogo->html->error(validation_errors());
        }else{
            try{
                //Getting input data and set Id to Null if empty
                $inputdata = $this->input->post(null);
                if($inputdata['Id'] == '') $inputdata['Id'] = null;

                //get linked project or exit if not linked to project
                ($project = $this->pogo->getLinkedProject($inputdata['ProjectId'])) ?: $this->pogo->html->error(lang('error_not_allowed'));

                //Try to retrieve existing projectactor
                $projectactor = PoGo\ProjectActorQuery::create()
                    ->filterById($inputdata['Id'])
                    ->findOneOrCreate();

                //Load input data into projectactor and save
                $projectactor->fromArray($inputdata);

                //Save
                $projectactor->save();

                //send success
                $this->pogo->html->success($projectactor->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }

    public function Delete($projectactorid){
        //TODO: réassocier tous les objects liés..
        
        //Verify authorization
        $this->pogo->auth->checkRole('ProjectActorEditor');

        //get projectactor or exit if not linked to project
        ($projectactor = PoGo\ProjectActorQuery::create()->findPk($projectactorid)) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectactor->getProjectId())) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //delete projectactor
        $projectactor->delete();

        //return success
        $this->pogo->html->success();
    }
}

