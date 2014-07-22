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
 * -------------------------------------------------------------------------------
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class PoGoWebdav {
    private $codeigniter;
    private $pogo;

    function __construct(&$pogo) {
        $this->codeigniter = & get_instance();
        $this->pogo = & $pogo;
    }

    function sanitize($name){
        return str_replace(array('/'), "_", $name);
    }

    function vcard($projectactorid){
        //Get projectactor or exit
        $projectactor = PoGo\ProjectActorQuery::create()->findPk($projectactorid);
        if (!$projectactor) return "";

        //get user
        $user = PoGo\UserQuery::create()->findOneByActorId($projectactor->getActorId());

        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "PRODID:-//Florian BETIL//PoGo::project//FR\r\n";
        $vcard .= "FN;CHARSET=utf-8:".$projectactor->getActor()->getFirstName().' '.$projectactor->getActor()->getName()."\r\n";
        $vcard .= "N;CHARSET=utf-8:".$projectactor->getActor()->getName().';'.$projectactor->getActor()->getFirstName()."\r\n";
        if ($user) $vcard .= "EMAIL;TYPE=work:".$user->getEmail()."\r\n";
        $vcard .= "ORG;CHARSET=utf-8:".$projectactor->getActor()->getOrganization()."\r\n";
        $vcard .= "NOTE;CHARSET=utf-8:".sprintf(lang('webdav_projects_p_5'), $projectactor->getRole(),$projectactor->getProject()->getName())."\r\n";
        $vcard .= "UID:PROJECTACTOR".$projectactor->getId()."\r\n";
        $vcard .= "END:VCARD\r\n";

        return $vcard;
    }

    function icalendar($projectid){
        //Get project or exit
        $project = PoGo\ProjectQuery::create()->findPk($projectid);
        if (!$project) return "";

        $icalendar = "BEGIN:VCALENDAR\r\n";
        $icalendar .= "VERSION:2.0\r\n";
        $icalendar .= "PRODID:-//Florian BETIL//PoGo::project//FR\r\n";
        $icalendar .= "URL:".site_url('/webdav/index/'.$project->getCode().'/'.urlencode(lang('webdav_projects_p_4')))."\r\n";
        $icalendar .= "NAME;CHARSET=utf-8:".$project->getName()."\r\n";
        $icalendar .= "X-WR-CALNAME;CHARSET=utf-8:".$project->getName()."\r\n";
        $icalendar .= "DESCRIPTION;CHARSET=utf-8:".str_replace("\n", "\\n", $project->getDescription())."\r\n";
        $icalendar .= "X-WR-CALDESC;CHARSET=utf-8:".str_replace("\n", "\\n", $project->getDescription())."\r\n";
        $icalendar .= "REFRESH-INTERVAL;VALUE=DURATION:PT6H\r\n";

        //Add tasks
        foreach ($project->getTasks() as $task) {
            $icalendar .= "BEGIN:VEVENT\r\n";
            $icalendar .= "UID:TASK".$task->getId()."\r\n";
            $icalendar .= "DTSTART:".$task->getStartDate('Ymd\T000000')."\r\n";
            $icalendar .= "DTEND:".$task->getDueDate('Ymd\T235959')."\r\n";
            $icalendar .= "SUMMARY;CHARSET=utf-8:".$task->getName()."\r\n";
            $icalendar .= "DESCRIPTION;CHARSET=utf-8:".str_replace("\n", "\\n\r\n", $task->getDescription())."\r\n";
            $icalendar .= "END:VEVENT\r\n";
        }

        //Add milestones
        foreach ($project->getMilestones() as $milestone) {
            $icalendar .= "BEGIN:VEVENT\r\n";
            $icalendar .= "UID:MILESTONE".$milestone->getId()."\r\n";
            $icalendar .= "DTSTART:".$milestone->getDueDate('Ymd\T000000')."\r\n";
            $icalendar .= "DTEND:".$milestone->getDueDate('Ymd\T235959')."\r\n";
            $icalendar .= "SUMMARY;CHARSET=utf-8:".$milestone->getName()."\r\n";
            $icalendar .= "DESCRIPTION;CHARSET=utf-8:".str_replace("\n", "\\n", $milestone->getDescription())."\r\n";
            $icalendar .= "END:VEVENT\r\n";
        }

        $icalendar .= "END:VCALENDAR\r\n";

        return $icalendar;
    }
}
        
