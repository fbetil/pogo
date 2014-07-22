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

class PoGoWebdavFile extends DAV\File {
    private $codeigniter;
    private $pogo;
    private $path;
    private $project;
    private $itempk;

    function __construct(&$pogo, $path) {
        $this->codeigniter = & get_instance();
        $this->pogo = & $pogo;
        $this->path = $path;

		//get project
		$project = PoGo\ProjectQuery::create()->findOneByCode($this->path[0]);
		if (!$project) throw new DAV\Exception\NotFound('Access denied');

		//Retrieve project and item pk
		$this->project = $project;
		$matches = array();
		preg_match('/^(\d*)\..*/', $this->getName(), $matches);
		if (!empty($matches)) $this->itempk = $matches[1];
    }

	function getName() {
		return end(array_values($this->path));
	}

	function get() {
		switch(urldecode($this->path[1])){
			case lang('webdav_projects_p_1'): //Notes
				//Verify authorization
				if (!$this->pogo->auth->haveRole('NoteViewer')) throw new DAV\Exception\NotFound('Access denied');

				$note = PoGo\NoteQuery::create()->findPk($this->itempk);
				if (!$note) return "";

				return str_replace("\n", "\r\n", $note->getContent());
				break;
			case lang('webdav_projects_p_2'): //Files
				//Verify authorization
				if (!$this->pogo->auth->haveRole('FileViewer')) throw new DAV\Exception\NotFound('Access denied');

				$file = PoGo\FileQuery::create()->findPk($this->itempk);
				if (!$file) return "";

				return stream_get_contents($file->getContent());
				break;
			case lang('webdav_projects_p_3'): //Actors
				//Verify authorization
				if (!$this->pogo->auth->haveRole('ProjectActorViewer')) throw new DAV\Exception\NotFound('Access denied');

				return $this->pogo->webdav->vcard($this->itempk);
				break;
			case lang('webdav_projects_p_4'): //Gantt
				//Verify authorization
				if (!$this->pogo->auth->haveRole('TaskViewer') || !$this->pogo->auth->haveRole('MilestoneViewer')) throw new DAV\Exception\NotFound('Access denied');

				return $this->pogo->webdav->icalendar($this->project->getId());
				break;
		}
	}

	function getSize() {
		switch(urldecode($this->path[1])){
			case lang('webdav_projects_p_1'): //Notes
			case lang('webdav_projects_p_3'): //Actors
			case lang('webdav_projects_p_4'): //Gantt
				return strlen($this->get());
				break;
			case lang('webdav_projects_p_2'): //Files
				$file = PoGo\FileQuery::create()->findPk($this->itempk);
				if (!$file) return 0;

				return $file->getSize();
				break;
		}
	}

	function getETag() {
		return md5($this->get());
	}

	function getContentType(){
		switch(urldecode($this->path[1])){
			case lang('webdav_projects_p_1'): //Notes
				return 'text/plain';
				break;
			case lang('webdav_projects_p_2'): //Files
				$file = PoGo\FileQuery::create()->findPk($this->itempk);
				if (!$file) return 'text/plain';

				return $file->getMimetype();
				break;
			case lang('webdav_projects_p_3'): //Actors
				return 'text/x-vcard';
				break;
			case lang('webdav_projects_p_4'): //Gantt
				return 'text/calendar';
				break;
		}
	}

}
        
