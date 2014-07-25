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

class Note extends CI_Controller {

    public function View($noteid) {
        //Verify authorization
        $this->pogo->auth->checkRole('NoteViewer');

        //get note or exit if note not exists
        ($note = PoGo\NoteQuery::create()->findPk($noteid)) ?: $this->pogo->html->e401();

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($note->getProjectId())) ?: $this->pogo->html->e401();

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav($note->getName(), site_url('/note/view/'.$noteid));

        //$this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('note/note.php', array('project'=>$project, 'note'=>$note));

	}

    public function Add($projectid) {
        //Verify authorization
        $this->pogo->auth->checkRole('NoteEditor');

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectid)) ?: $this->pogo->html->e401();

        //generate new Note
        $note = new PoGo\Note();
        $note->setPublishedAt('now')
            ->setActorId($this->session->userdata('actor_id'));

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav(lang('note_add_a_1'), site_url('/note/add/'.$project->getId()));

        //$this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('note/note.php', array('project'=>$project, 'note'=>$note));

    }

    public function Post() {
        //Verify authorization
        $this->pogo->auth->checkRole('NoteEditor');

        //Set form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ProjectId', 'lang:identifier', 'required|integer');
        $this->form_validation->set_rules('Name', 'lang:note_view_p_4', 'required');
        $this->form_validation->set_rules('Content', 'lang:note_view_p_7', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->pogo->html->error(validation_errors());
        }else{
            try{
                //Getting input data and set Id to Null if empty
                $inputdata = $this->input->post(null);
                if($inputdata['Id'] == '') $inputdata['Id'] = null;

                //get linked project or exit if not linked to project
                ($project = $this->pogo->getLinkedProject($inputdata['ProjectId'])) ?: $this->pogo->html->error(lang('error_not_allowed'));

                //Set author and published date
                $inputdata['ActorId'] = $this->session->userdata('actor_id');
                $inputdata['PublishedAt'] = new DateTime();

                //Try to retrieve existing note
                $note = PoGo\NoteQuery::create()
                    ->filterById($inputdata['Id'])
                    ->findOneOrCreate();

                //Load input data into note and save
                $note->fromArray($inputdata);

                //Save
                $note->save();

                //send success
                $this->pogo->html->success($note->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }

    public function Delete($noteid){
        //Verify authorization
        $this->pogo->auth->checkRole('NoteEditor');

        //get note or exit if not linked to project
        ($note = PoGo\NoteQuery::create()->findPk($noteid)) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($note->getProjectId())) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //delete note and link
        $note->delete();
        
        //return success
        $this->pogo->html->success();
    }

}

