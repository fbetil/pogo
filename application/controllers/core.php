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

class Core extends CI_Controller {

    public function Php(){
        //Verify authorization
        $this->pogo->auth->checkRole('AdminEditor');

        phpinfo();
    }

    public function test(){
        var_dump($this->pogo->calculateProjectProgression(1));
    }

    public function Propel($task = false) {
        //Verify authorization
        $this->pogo->auth->checkRole('AdminEditor');

        $tasks = array();
        if (!$task) {
            $tasks = array('sql', 'om', 'convert-conf', 'diff');
        }else{
            $tasks = array($task);
        }
        foreach ($tasks as $task) {
            $cwd = 'D:\\Programmes\\PoGo';
            putenv('PHING_COMMAND=D:\\Programmes\\PoGo\\WEB\\application\\vendor\\phing\\phing\\bin\\phing.bat');
            putenv('PROPEL_GEN_HOME=D:\\Programmes\\PoGo\\WEB\\application\\vendor\\propel\\propel1\\generator\\');
            putenv('PHING_HOME=D:\\Programmes\\PoGo\\WEB\\application\\vendor\\phing\\phing\\');
            putenv('PHP_COMMAND=D:\\Programmes\\PoGo\\PHP_54_x86\php.exe');

            $cmd = 'D:\\Programmes\\PoGo\\WEB\\application\\vendor\\propel\\propel1\\generator\\bin\\propel-gen.bat D:\\Programmes\\PoGo\\WEB\\application\\propel '.$task; //.' -verbose';

            $output = array();
            $error = array();
            $descriptorspec = array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w"));
            $process = proc_open($cmd, $descriptorspec, $pipes, $cwd);
            if (is_resource($process)) {
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $output = (preg_split('/\r\n/', $output));
                $error = stream_get_contents($pipes[2]);
                fclose($pipes[2]);
                $error = (preg_split('/\r\n/', $error));
            }
            $retval = proc_close($process);
            echo '<h2>' . $task . ': ' . $retval . '</h2><pre>';
            print_r($output);
            print_r($error);
            echo '</pre>';
        }
    }

    public function Mailgate(){
        //Verify authorization
        $this->pogo->auth->checkRole('AdminEditor');

        try{
            //Open imap session
            $mbox = imap_open('{'.$this->config->item('pogo_imap_host').$this->config->item('pogo_imap_connectionstring').'}', $this->config->item('pogo_imap_user'), $this->config->item('pogo_imap_password'), NULL, 1, $this->config->item('pogo_imap_options'));

            //Verify mailbox
            $verify = imap_check($mbox);

            // Fetch an message for all messages in INBOX
            $messages = imap_fetch_overview($mbox, '1:'.$verify->Nmsgs, 0);

            foreach ($messages as $message) {
                //Retrieve message data
                $msgdata = $this->pogo->imap->getMsg($mbox, $message->msgno);
                $from = $msgdata['from'];
                $subject = $msgdata['subject'];
                $date = $msgdata['date'];
                $body = (empty($msgdata['plainmsg'])) ? $msgdata['htmlmsg'][0] : $msgdata['plainmsg'][0];

                //Check if sender exist as user
                $user = PoGo\UserQuery::create()->findOneByEmail($msgdata['from']);

                //Mark message as deleted and loop
                if (!$user) {
                    $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_1'), lang('core_mailgate_p_2'));
                    imap_delete ($mbox, $message->msgno);
                    continue;
                }

                //Check if user have authorization
                $is_noteeditor = false;
                $is_fileeditor = false;

                foreach($user->getUserProfiles() as $userprofile){
                    foreach ($userprofile->getProfile()->getProfileRoles() as $profilerole) {
                        switch ($profilerole->getRole()->getName()){
                            case 'NoteEditor':
                                $is_noteeditor = true;
                                break;
                            case 'FileEditor':
                                $is_fileeditor = true;
                                break;
                        }
                    }
                }

                //Mark message as deleted and loop
                if (!$is_noteeditor) {
                    $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_1'), lang('core_mailgate_p_3'));
                    imap_delete ($mbox, $message->msgno);
                    continue;
                }

                //Check if body contains a pogo project code in subject or body
                $code = array();
                preg_match ('/(POGO\\.[0-9]{4}\\.[A-Z]{4})/m', $subject." ".$body, $code);

                //Mark message as deleted and loop
                if (empty($code)) {
                    $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_1'), lang('core_mailgate_p_4'));
                    imap_delete ($mbox, $message->msgno);
                    continue;
                }

                //Check if user if linked to project
                $project = PoGo\ProjectQuery::create()
                    ->useProjectActorQuery()
                        ->filterByActorId($user->getActorId())
                    ->endUse()
                    ->findOneByCode($code[0]);

                //Mark message as deleted and loop
                if (!$project) {
                    $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_1'), sprintf(lang('core_mailgate_p_5'), $code[0]));
                    imap_delete ($mbox, $message->msgno);
                    continue;
                }

                //Add new note and link to project if message if not empty
                if ($body != $code[0]) {
                    $note = new PoGo\Note();
                    $note->setName($subject)
                        ->setContent($body)
                        ->setActorId($user->getActorId())
                        ->setProjectId($project->getId())
                        ->setPublishedAt($date)
                        ->save();

                    //Send notification to sender
                    $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_6'), sprintf(lang('core_mailgate_p_7'), $code[0], site_url()."/note/view/".$note->getId()));

                }

                //Check attachments
                foreach ($msgdata['attachments'] as $attachment) {
                    if (!$is_fileeditor) {
                        $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_1'), lang('core_mailgate_p_8'));
                        break;
                    }

                    //generate version number
                    $fileversion = PoGo\FileQuery::create()
                        ->filterByName($attachment['filename'])
                        ->filterByProjectId($project->getId())
                        ->orderByVersion('desc')
                        ->findOne();
                    $fileversion = ($fileversion) ? $fileversion->getVersion() + 1 : 1;

                    //Store file
                    $file = new PoGo\File();
                    $file->setName($attachment['filename'])
                        ->setContent($attachment['content'])
                        ->setMimetype($attachment['mime'])
                        ->setSize(mb_strlen($attachment['content']))
                        ->setVersion($fileversion)
                        ->setFolder(lang('core_mailgate_p_9'))
                        ->setProjectId($project->getId())
                        ->setActorId($user->getActorId());

                    //Save
                    $file->save();

                    //Send notification to sender
                    $this->pogo->sendMail($this->config->item('pogo_smtp_address'), $from, lang('core_mailgate_p_11'), sprintf(lang('core_mailgate_p_10'), $code[0], site_url()."/file/view/".$file->getId()));

                }

                //Mark message as deleted
                imap_delete ($mbox, $message->msgno);
            
            }

            //Delete message
            imap_expunge($mbox);

            //Close imap session and clear errors
            imap_close($mbox);
            imap_errors();

        }catch(Exception $e){
            $this->pogo->html->end($e->getMessage());
        }
    }

}