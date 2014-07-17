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

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['php_begintime'] = microtime(true);

//Folders
$config['pogo_path_temp'] = '/tmp';
//Smtp
$config['pogo_smtp_address'] = 'pogo@domain.com';
$config['pogo_smtp_host'] = 'mailserver.domain.com';
$config['pogo_smtp_user'] = 'pogo';
$config['pogo_smtp_password'] = 'mypassword';

$config['pogo_imap_host'] = 'mailserver.domain.com';
$config['pogo_imap_connectionstring'] = '/novalidate-cert/ssl';
$config['pogo_imap_options'] = array('DISABLE_AUTHENTICATOR' => 'GSSAPI');
$config['pogo_imap_user'] = 'pogo';
$config['pogo_imap_password'] = 'mypassword';
//Version
$config['pogo_version'] = 'v0.0.1';