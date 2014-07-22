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

use Sabre\DAV;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webdav extends CI_Controller {

    public function __construct(){
        parent::__construct();

        //Load functionnalities
        require APPPATH.'libraries/pogo.webdav.php';
        require APPPATH.'libraries/pogo.webdav.directory.php';
        require APPPATH.'libraries/pogo.webdav.file.php';

        //instanciate
        $this->pogo->webdav = new PoGoWebdav($this->pogo);
    }

    public function Index($path = array()){
        //Verify authorization
        $this->pogo->auth->checkRole('WebdavViewer');

        $path = func_get_args();

        $root = new PoGoWebdavDirectory($this->pogo, $path);

        // The object tree needs in turn to be passed to the server class
        $server = new DAV\Server($root);

        // We're required to set the base uri, it is recommended to put your webdav server on a root of a domain
        $server->setBaseUri('/index.php/webdav/index');

        // And off we go!
        $server->exec();

    }

}