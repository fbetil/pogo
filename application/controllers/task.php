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

class Task extends CI_Controller {

    public function View($taskid) {
        //Verify authorization
        $this->pogo->auth->checkRole('TaskViewer');

        //get task or exit if task not exists
        ($task = PoGo\TaskQuery::create('Task')->withColumn('CalculateTaskProgressScore(Task.Id)', 'ProgressScore')->findPk($taskid)) ?: $this->pogo->html->e401();

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($task->getProjectId())) ?: $this->pogo->html->e401();

        //get actors
        $taskactors = $taskactorsnames = $taskactorsall = array();
        foreach ($task->getTaskActors() as $taskactor) {
            $actor = $taskactor->getActor();
            $taskactors[] = (string) $actor->getId();
            $taskactorsnames[] = $actor->getFirstName().' '.$actor->getName();
        }
        $taskactors = json_encode($taskactors , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $taskactorsnames = (implode(', ', $taskactorsnames)) ?: lang('task_view_p_9') ;
        $taskactorsall = json_encode(PoGo\ActorQuery::create('Actor')->select(array('Id','Label'))->withColumn('CONCAT(Actor.FirstName, \' \', Actor.Name)','Label')->filterById(PoGo\ProjectActorQuery::create()->select('ActorId')->filterByProjectId($project->getId())->find()->toArray())->orderByFirstName()->orderByName()->find()->toArray() , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav($task->getName(), site_url('/task/view/'.$taskid));

        //$this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('task/task.php', array('project'=>$project, 'task'=>$task, 'taskactors'=>$taskactors, 'taskactorsnames'=>$taskactorsnames, 'taskactorsall'=>$taskactorsall));

	}

    public function Add($projectid) {
        //Verify authorization
        $this->pogo->auth->checkRole('TaskEditor');

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($projectid)) ?: $this->pogo->html->e401();

        //generate new Task
        $task = new PoGo\Task();
        $task->setProgress(0)
            ->setStartDate('now')
            ->setDueDate('+1 days');

        //get actors
        $taskactors = $taskactorsnames = $taskactorsall = array();
        foreach ($task->getTaskActors() as $taskactor) {
            $actor = $taskactor->getActor();
            $taskactors[] = (string) $actor->getId();
            $taskactorsnames[] = $actor->getFirstName().' '.$actor->getName();
        }
        $taskactors = json_encode($taskactors , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $taskactorsnames = (implode(', ', $taskactorsnames)) ?: lang('task_view_p_9') ;
        $taskactorsall = json_encode(PoGo\ActorQuery::create('Actor')->select(array('Id','Label'))->withColumn('CONCAT(Actor.FirstName, \' \', Actor.Name)','Label')->filterById(PoGo\ProjectActorQuery::create()->select('ActorId')->filterByProjectId($project->getId())->find()->toArray())->orderByFirstName()->orderByName()->find()->toArray() , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));
        $this->pogo->html->addToNav(lang('app_nav_2'), site_url('/project'));
        $this->pogo->html->addToNav($project->getCode(), site_url('/project/view/'.$project->getId()));
        $this->pogo->html->addToNav(lang('task_add_a_1'), site_url('/task/add/'.$project->getId()));

        //$this->pogo->html->addToMenu('<= '.lang('app_menu_1'), site_url('/project/view/'.$project->getId()));

        //render
        $this->pogo->html->view('task/task.php', array('project'=>$project, 'task'=>$task, 'taskactors'=>$taskactors, 'taskactorsnames'=>$taskactorsnames, 'taskactorsall'=>$taskactorsall));

    }

    public function Post() {
        //Verify authorization
        $this->pogo->auth->checkRole('TaskEditor');

        //Set form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ProjectId', 'lang:identifier', 'required|integer');
        $this->form_validation->set_rules('Progress', 'lang:task_view_p_8', 'required|integer');
        $this->form_validation->set_rules('Name', 'lang:task_view_p_4', 'required');
        $this->form_validation->set_rules('Description', 'lang:task_view_p_5', 'required');
        $this->form_validation->set_rules('StartDate', 'lang:task_view_p_6', 'required|callback_date_check');
        $this->form_validation->set_rules('DueDate', 'lang:task_view_p_7', 'required|callback_dategreaterthan_check['.$this->input->post('StartDate').']');
        $this->form_validation->set_rules('Actors', 'lang:task_view_p_10', 'required|is_array');

        if ($this->form_validation->run() == FALSE) {
            $this->pogo->html->error(validation_errors());
        }else{
            try{
                //Getting input data and set Id to Null if empty
                $inputdata = $this->input->post(null);
                if($inputdata['Id'] == '') $inputdata['Id'] = null;

                //get linked project or exit if not linked to project
                ($project = $this->pogo->getLinkedProject($inputdata['ProjectId'])) ?: $this->pogo->html->error(lang('error_not_allowed'));
                
                //Reformat Dates and Index
                foreach (array('StartDate','DueDate') as $field) {
                    if (isset($inputdata[$field]) && !empty($inputdata[$field])) $inputdata[$field] = DateTime::createFromFormat ('d/m/Y', $inputdata[$field]);
                }

                //Try to retrieve existing task
                $task = PoGo\TaskQuery::create()
                    ->filterById($inputdata['Id'])
                    ->findOneOrCreate();

                //Load input data into task and save
                $task->fromArray($inputdata);

                //Save
                $task->save();

                //Update actors
                PoGo\TaskActorQuery::create()->filterByTaskId($task->getId())->delete();
                $actors = array_filter($inputdata['Actors']);
                foreach ($actors as $actorid) {
                    //check if actor exists and is linked to project
                    if (!PoGo\ProjectActorQuery::create()->select('ActorId')->filterByProjectId($project->getId())->filterByActorId($actorid)->count()) continue;

                    $taskactor = new PoGo\TaskActor();
                    $taskactor->setTaskId($task->getId())->setActorId($actorid)->save();
                }

                //send success
                $this->pogo->html->success($task->getId());
            }catch(Exception $e) {
                //send error
                $this->pogo->html->error($e->getMessage());
            }
        }
    }

    public function Delete($taskid){
        //Verify authorization
        $this->pogo->auth->checkRole('TaskEditor');

        //get task or exit if not linked to project
        ($task = PoGo\TaskQuery::create()->findPk($taskid)) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($task->getProjectId())) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //delete task
        $task->delete();

        //return success
        $this->pogo->html->success();
    }

    public function Close($taskid){
        //Verify authorization
        $this->pogo->auth->checkRole('TaskEditor');

        //get task or exit if not linked to project
        ($task = PoGo\TaskQuery::create()->findPk($taskid)) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //get linked project or exit if not linked to project
        ($project = $this->pogo->getLinkedProject($task->getProjectId())) ?: $this->pogo->html->error(lang('error_not_allowed'));

        //set progression  task
        $task->setProgress(100)->save();

        //return success
        $this->pogo->html->success();
    }

    public function Date_check($date) {
        return $this->pogo->Date_check($date);
    }

    public function DateGreaterThan_check($date1, $date2) {
        return $this->pogo->DateGreaterThan_check($date1, $date2);
    }

}

