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

class File extends CI_Controller {

    public function View($fileid) {
        //Verify authorization
        $this->pogo->auth->checkRole('FileViewer');

        //get file or exit if file not exists
        ($file = PoGo\FileQuery::create()->findPk($fileid)) ?: $this->pogo->html->e401();

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($file->getProjectId())) ?: $this->pogo->html->e401();

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav($file->getName(), site_url('/file/view/'.$fileid));

        //$this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('file/file.php', array('project'=>$project, 'file'=>$file));

	}

    public function Send($fileid, $download = false) {
        //Verify authorization
        $this->pogo->auth->checkRole('FileViewer');

        //get file or exit if file not exists
        ($file = PoGo\FileQuery::create()->findPk($fileid)) ?: $this->pogo->html->e401();

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($file->getProjectId())) ?: $this->pogo->html->e401();

        //send to browser
        $this->pogo->html->file($file->getName(), $file->getMimeType(), $file->getContent(), $download);
    }

    public function Post() {
        //Verify authorization
        $this->pogo->auth->checkRole('FileEditor');

        //Set form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ProjectId', 'lang:identifier', 'required|integer');
        $this->form_validation->set_rules('Name', 'lang:file_view_p_4', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->pogo->html->error(validation_errors());
        }else{
            try{
                //Getting input data and set Id to Null if empty
                $inputdata = $this->input->post(null);
                if($inputdata['Id'] == '') $inputdata['Id'] = null;

                //get linked project or exit if not linked to project
                ($project = $this->pogo->getLinkedProject($inputdata['ProjectId'])) ?: $this->pogo->html->error(lang('error_not_allowed'));

                //Try to retrieve existing file
                $file = PoGo\FileQuery::create()
                    ->filterById($inputdata['Id'])
                    ->findOneOrCreate();

                //generate version number
                $fileversion = PoGo\FileQuery::create()
                    ->filterById($inputdata['Id'], Criteria::NOT_EQUAL)
                    ->filterByProjectId($inputdata['ProjectId'])
                    ->filterByName($inputdata['Name'])
                    ->orderByVersion('desc')
                    ->findOne();
                    
                $inputdata['Version'] = ($fileversion) ? $fileversion->getVersion() + 1 : 1;

                //Load input data into file and save
                $file->fromArray($inputdata);

                //Save
                $file->save();

                //send success
                $this->pogo->html->success($file->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }

    public function Delete($fileid){
        //Verify authorization
        $this->pogo->auth->checkRole('FileEditor');

        //get file or exit if file not exists
        ($file = PoGo\FileQuery::create()->findPk($fileid)) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($file->getProjectId())) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //file
        $file->delete();

        //return success
        $this->pogo->html->success();
    }

    public function Upload(){
        //Verify authorization
        $this->pogo->auth->checkRole('FileEditor');

        //Set form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ProjectId', 'lang:files_upload_p_1', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->pogo->html->error(validation_errors());
        }elseif(!isset($_FILES["File"])){
            $this->pogo->html->error(lang('error_unable_to_execute'));
        }else{
            try{
                //get linked project or exit if not linked to project
                ($project = $this->pogo->getLinkedProject($this->input->post('ProjectId'))) ?: $this->pogo->html->error(lang('error_not_allowed'));

                //read file info
                $filesize = filesize($_FILES["File"]["tmp_name"]);
                $filename = $_FILES["File"]["name"];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $filemimetype = finfo_file($finfo, $_FILES["File"]["tmp_name"]);
                $filecontent = fopen($_FILES["File"]["tmp_name"], "rb");

                //generate version number
                $fileversion = PoGo\FileQuery::create()
                    ->filterByProjectId($this->input->post('ProjectId'))
                    ->filterByName($filename)
                    ->orderByVersion('desc')
                    ->findOne();
                $fileversion = ($fileversion) ? $fileversion->getVersion() + 1 : 1;

                //Store file
                $file = new PoGo\File();
                $file->setName($filename)
                    ->setContent($filecontent)
                    ->setMimetype($filemimetype)
                    ->setSize($filesize)
                    ->setVersion($fileversion)
                    ->setFolder($this->input->post('Folder'))
                    ->setProjectId($this->input->post('ProjectId'))
                    ->setActorId($this->session->userdata('actor_id'));

                //Save
                $file->save();

                //send success
                $this->pogo->html->success($file->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }

}

