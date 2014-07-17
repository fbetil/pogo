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

class PoGo {
    public $codeigniter;
	
    function __construct() {
        //Define constants
        define('DS', DIRECTORY_SEPARATOR);

        //Instanciate CI instance
        $this->codeigniter = & get_instance();

        //Load composer packages
        require APPPATH.'vendor'.DS.'autoload.php';

        //Load functionnalities
        foreach (array('auth','html','imap') as $functionnality) {
            require APPPATH.'libraries/pogo.'.$functionnality.'.php';
            $classname = 'PoGo'.ucfirst($functionnality);
            $this->$functionnality = new $classname($this);
        }

        //Initialize Propel
        Propel::init(APPPATH.'propel'.DS.'pogo-conf.php');
        set_include_path(APPPATH.'models'.PATH_SEPARATOR.get_include_path());

        //Authentification
        $this->auth->init();
    }

    public function Json_check($json) {
        return ((json_decode($json) == null) ? false : true);
    }
    public function Cron_check($json) {
        if (!$this->Json_check($json)) return false;
        $json = json_decode($json);
        if(is_array($json)){
            foreach ($json as $jsonitem) {
                if (!isset($jsonitem->Planning) || !isset($jsonitem->Planning->months) || !isset($jsonitem->Planning->weekdays) || !isset($jsonitem->Planning->days) || !isset($jsonitem->Planning->hours) || !isset($jsonitem->Planning->minutes)) return false;
            }
        }else{
            if (!isset($json->Planning) || !isset($json->Planning->months) || !isset($json->Planning->weekdays) || !isset($json->Planning->days) || !isset($json->Planning->hours) || !isset($json->Planning->minutes)) return false;
        }
        return true;
    }
    public function Alpha_extended_check($string) {
        return ((preg_match("/^[a-z'àáâãäåçèéêëìíîïðòóôõöùúûüýÿ -_0-9]*$/i", $string) == 1) ? true : false);
    }
    public function Alpha_extended2_check($string) {
        return ((preg_match("/^[a-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_0-9]*$/i", $string) == 1) ? true : false);
    }
    public function Date_check($date) {
        $d0 = DateTime::createFromFormat('d/m/Y', '01/01/1901');
        $d1 = DateTime::createFromFormat('d/m/Y', $date);
        return ((($d1 != false) && ($d1->diff($d0)->invert == 1)) ? true : false);
    }
    public function DateGreaterThan_check($date1, $date2) {
        $d1 = DateTime::createFromFormat('d/m/Y', $date1);
        $d2 = DateTime::createFromFormat('d/m/Y', $date2);

        if ($d1 == false || $d2 == false) return false;
        return ($d1->diff($d2)->invert || $d1 == $d2) ? true : false;
    }
    //Test for empty value
    public function is_empty($var) {
        return empty($var);
    }
	
    public function sendMail($from, $to, $subject, $body, $attachments = array()) {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->codeigniter->config->item('pogo_smtp_host'), 25);
        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);
        // Create the message
        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(array($from))
            ->setTo(array($to))
            ->setBody($body, 'text/html', 'utf-8');

        foreach ($attachments as $attachment) {
            $message->attach(Swift_Attachment::fromPath($attachment));
        }

        // Send the message
        $result = $mailer->send($message);
    }


}
        
