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
 *
 */

use Sabre\DAV;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class PoGoWebdavDirectory extends DAV\Collection {
    private $codeigniter;
    private $pogo;
    private $path;

    function __construct(&$pogo, $path) {
        $this->codeigniter = & get_instance();
        $this->pogo = & $pogo;
        $this->path = array_filter($path);
    }

	function getChildren() {
		$children = array();

		switch (count($this->path)) {
			case 0:
		        //get user linked projects
		        $projects = PoGo\ProjectQuery::create()
		            ->useProjectActorQuery()
		                ->filterByActorId($this->codeigniter->session->userdata('actor_id'))
		            ->endUse()
		            ->find();

		        foreach($projects as $project) {
		        	$path = array($this->pogo->webdav->sanitize($project->getCode()));
		        	$children[] = new PoGoWebdavDirectory($this->pogo, $path);
		        }

				break;
			
			case 1:
				//get project
				$project = PoGo\ProjectQuery::create()->findOneByCode($this->path[0]);
				if (!$project) throw new DAV\Exception\NotFound('Access denied');

				//generate folders
				$folders = array();
				if ($this->pogo->auth->haveRole('NoteViewer')) $folders[] = 'webdav_projects_p_1';
				if ($this->pogo->auth->haveRole('FileViewer')) $folders[] = 'webdav_projects_p_2';
				if ($this->pogo->auth->haveRole('ProjectActorViewer')) $folders[] = 'webdav_projects_p_3';

				foreach ($folders as $folder) {
					$path = array($this->pogo->webdav->sanitize($project->getCode()), $this->pogo->webdav->sanitize(lang($folder)));
					$children[] = new PoGoWebdavDirectory($this->pogo, $path);
				}

				//Add global gantt ical
				if ($this->pogo->auth->haveRole('TaskViewer') && $this->pogo->auth->haveRole('MilestoneViewer')) {
					$path = array($this->pogo->webdav->sanitize($project->getCode()), $this->pogo->webdav->sanitize(lang('webdav_projects_p_4')));
					$children[] = new PoGoWebdavFile($this->pogo, $path);
				}

				break;

			default:
				//get project
				$project = PoGo\ProjectQuery::create()->findOneByCode($this->path[0]);
				if (!$project) throw new DAV\Exception\NotFound('Access denied');

				switch($this->path[1]){
					case lang('webdav_projects_p_1'): //Notes
						//Verify authorization
						if (!$this->pogo->auth->haveRole('NoteViewer')) throw new DAV\Exception\NotFound('Access denied');

						foreach ($project->getNotes() as $note) {
							$path = $this->path;
							$path[] = $note->getId().'. '.$this->pogo->webdav->sanitize($note->getName().'.txt');
							$children[] = new PoGoWebdavFile($this->pogo, $path);
						}
						break;
					case lang('webdav_projects_p_2'): //Files

						//Verify authorization
						if (!$this->pogo->auth->haveRole('FileViewer')) throw new DAV\Exception\NotFound('Access denied');
						
						if(count($this->path) == 2){
							$folders = array();

							foreach ($project->getFiles() as $file) {
								if($file->getFolder() != ""){
									$folders[] = $file->getFolder();

									$path = $this->path;
									$path[] = $this->pogo->webdav->sanitize($file->getFolder());
									$children[] = new PoGoWebdavDirectory($this->pogo, $path);
								}else{
									$path = $this->path;
									$path[] = $file->getId().'. '.$this->pogo->webdav->sanitize($file->getName());
									$children[] = new PoGoWebdavFile($this->pogo, $path);	
								}
							}
						}else{
							foreach ($project->getFiles() as $file) {
								if($file->getFolder() == urldecode($this->path[2])){
									$path = $this->path;
									$path[] = $file->getId().'. '.$this->pogo->webdav->sanitize($file->getName());
									$children[] = new PoGoWebdavFile($this->pogo, $path);	
								}
							}
						}

						break;
					case lang('webdav_projects_p_3'): //Actors
						//Verify authorization
						if (!$this->pogo->auth->haveRole('ProjectActorViewer')) throw new DAV\Exception\NotFound('Access denied');

						foreach ($project->getProjectActors() as $projectactor) {
							$path = $this->path;
							$path[] = $projectactor->getId().'. '.$this->pogo->webdav->sanitize($projectactor->getActor()->getFirstName().' '.$projectactor->getActor()->getName().' - '.$projectactor->getRole().'.vcf');
							$children[] = new PoGoWebdavFile($this->pogo, $path);
						}
						break;
				}

				break;

		}
		return $children;
	}

	function getChild($name) {
		$matches = array();
		preg_match('/^(\d*)\.\s.*/', $name, $matches);

		$isfile = (
				$name == lang('webdav_projects_p_4')
				|| count($matches) == 2
			);

		return ($isfile) ? new PoGoWebdavFile($this->pogo, $this->path) : new PoGoWebdavDirectory($this->pogo, $this->path);	
	}

	function childExists($name) {
		return true;
	}

	function getName() {
		return end(array_values($this->path));
	}

}
        
