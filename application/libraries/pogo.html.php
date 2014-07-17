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

class PoGoHtml {
    private $codeigniter;
    private $pogo;
    public $htmlNav;
    public $htmlMenu;

    function __construct(&$pogo) {
        $this->codeigniter = & get_instance();
        $this->pogo = & $pogo;
        $this->htmlNav = array();
        $this->htmlMenu = array();
    }

    /* Dump variable */

    public function dump($variable){
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
    }

    /* Html Elements */
    public function addToNav($label, $url) {
        $this->htmlNav[] = array('label'=>$label, 'url'=>$url);
    }

    public function addToMenu($label, $url) {
        $this->htmlMenu[] = array('label'=>$label, 'url'=>$url);
    }

    /* Render smarty template */

    public function view($view, $data = array()){

        $this->codeigniter->load->library('smarty');

        $title = ((isset($data['title'])) ? lang('layout_title') . ' - ' . $data['title'] : lang('layout_title'));
        unset($data['title']);

        $data = array_merge(array(
            'csrf_hash'=>$this->codeigniter->security->get_csrf_hash(),
            'url_index'=>site_url(),
            'url_base'=>base_url(),
            'title'=>$title,
            'nav'=>$this->htmlNav,
            'menu'=>$this->htmlMenu,
            'user_name'=>$this->codeigniter->session->userdata('user_name'),
            'user_profiles'=>$this->codeigniter->session->userdata('profiles'),
            'user_current_profile'=>$this->codeigniter->session->userdata('currentprofile'),
            'user_default_profile'=>$this->codeigniter->session->userdata('defaultprofile'),
            'user_roles'=>$this->codeigniter->session->userdata('profiles')[$this->codeigniter->session->userdata('currentprofile')]['roles'],
            'user_markers'=>$this->codeigniter->session->userdata('markers'),
            'user_history'=>$this->codeigniter->session->userdata('history'),
            'php_begintime'=>$this->codeigniter->config->item('php_begintime'),
            'pogo_version'=>$this->codeigniter->config->item('pogo_version'),
            'pogo_smtp_address'=>$this->codeigniter->config->item('pogo_smtp_address')
            ), $data
        );
        
        //Render view
        $this->codeigniter->smarty->view($view, $data);
    }

    /* Send message to browser */
    
    public function send($title, $message) {
        ob_end_clean();
        header("Connection: close");
        ob_start();
        
        echo json_encode(array('message'=>$message, 'title'=>$title), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();
        flush();
    }

    public function file($filename, $mimetype, $stream, $download = false) {
        header('Content-type: '.$mimetype.'; filename="'.$filename.'"');

        if ($download) header('Content-Disposition: attachment; filename="'.$filename.'"');

        echo stream_get_contents($stream);
    }

    public function error($message = '') {
        die(json_encode(array('result'=>'error', 'message'=>$message)));
    }

    public function success($message = '') {
        die(json_encode(array('result'=>'success', 'message'=>$message)));
    }

    public function end($message = '') {
        die(utf8_decode($message));
    }

    public function json($json = array()){
        header('Content-type: application/json');
        die(json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));
    }

    /* Render html errors */

    public function e401($mode = 'html') {
        header("HTTP/1.1 401 Authorization Required");
        switch ($mode){
            case 'ajax':
                die(json_encode(array('result'=>'error', 'error'=>lang('error_not_allowed'))));
                break;
            case 'html':
                die(utf8_decode(lang('error_not_allowed')));
                break;
        }
    }

    public function e403($mode = 'html') {
        header("HTTP/1.1 403 Forbidden");
        switch ($mode){
            case 'ajax':
                die(json_encode(array('result'=>'error', 'error'=>lang('error_unable_to_execute'))));
                break;
            case 'html':
                die(utf8_decode(lang('error_unable_to_execute')));
                break;
        }
    }
}
        
