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

class Dashboard extends CI_Controller {

    public function Index() {
		//redirect to user homepage
		header('location: '.site_url($this->session->userdata('homepage')));
	}

    public function Home(){
		//Verify authorization
        $this->pogo->auth->checkRole('DashboardViewer');

        //generate nav & menu
        $this->pogo->html->addToNav(lang('app_nav_1'), site_url('/dashboard'));

        //get user linked recents projects
        $projects = PoGo\ProjectQuery::create('Project')
            ->useProjectActorQuery()
                ->filterByActorId($this->session->userdata('actor_id'))
            ->endUse()
            ->withColumn('CalculateProjectProgress(Project.Id)', 'Progress')
            ->withColumn('CalculateProjectProgressScore(Project.Id)', 'ProgressScore')
            ->orderByCode('desc')
            ->limit(20)
            ->find();

        //get user affected tasks
        if ($this->pogo->auth->haveRole('TaskViewer')){
            $tasks = PoGo\TaskQuery::create('Task')
                ->useTaskActorQuery()
                    ->filterByActorId($this->session->userdata('actor_id'))
                ->endUse()
                ->withColumn('CalculateTaskProgressScore(Task.Id)', 'ProgressScore')
                ->filterByProgress(100, Criteria::NOT_EQUAL)
                ->orderByStartDate()
                ->find();
            }else{
                $tasks = array();
            }


        //render
        $this->pogo->html->view('dashboard/home.php', array('projects'=>$projects, 'tasks'=>$tasks));
    }
    
}

