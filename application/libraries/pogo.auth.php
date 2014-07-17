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

class PoGoAuth {
    private $codeigniter;
    private $pogo;

    function __construct(&$pogo) {
        $this->codeigniter = & get_instance();
        $this->pogo = & $pogo;
    }

    /* Session initialization */

    public function init() {
        //Set default environment
        $this->setDefaults();

        //Retrieve login and remove domain
        $login = (isset($_SERVER['REMOTE_USER'])) ? str_replace(array('CH-CHOLET\\', '@ch-cholet.intra'), array('', ''), $_SERVER['REMOTE_USER']) : false;

        //Load logged user
        if ($login && $this->codeigniter->session->userdata('user_id') != false) {
            //Retrieve User            
            $user = PoGo\UserQuery::create()->filterByLogin($login)->findPk($this->codeigniter->session->userdata('user_id'));
            if ($user) {
                $this->logIn($user);
                return true;
            }
        } elseif ($login) {
            //Try to log user (SSO)
            $user = PoGo\UserQuery::create()->findOneByLogin($login);
            if ($user) {
                $this->logIn($user);
                return true;
            }
        }

        //Exit if user is not configured
        return false;
    }

    public function setDefaults() {
        $this->codeigniter->session->set_userdata('islogged', false);
        $this->codeigniter->session->set_userdata('user_id', false);
        $this->codeigniter->session->set_userdata('user_name', lang('layout_anonymous'));
        $this->codeigniter->session->set_userdata('actor_id', false);
        $this->codeigniter->session->set_userdata('language', 'fr_FR');
        $this->codeigniter->session->set_userdata('theme', 'default');
        $this->codeigniter->session->set_userdata('profiles', array());
        $this->codeigniter->session->set_userdata('currentprofile', null);
        $this->codeigniter->session->set_userdata('markers', array());
        $this->codeigniter->session->set_userdata('history', array());
        $this->codeigniter->session->set_userdata('homepage', '/dashboard/home');
    }

    /* Login / logout functions */

    public function logIn($user) {
        $this->codeigniter->session->set_userdata('islogged', true);
        $this->codeigniter->session->set_userdata('user_id', $user->getId());
        $this->codeigniter->session->set_userdata('user_name', $user->getName() . ' ' . $user->getFirstName());
        $this->codeigniter->session->set_userdata('actor_id', $user->getActorId());
        $properties = json_decode($user->getProperties(), true);
        $this->codeigniter->session->set_userdata('language', $properties['language']);
        $this->codeigniter->session->set_userdata('theme', $properties['theme']);
        $this->codeigniter->session->set_userdata('defaultprofile', $properties['defaultprofile']);
        $this->codeigniter->session->set_userdata('homepage', $properties['homepage']);

        //Load Profiles
        $this->loadProfiles($user);

        //Load markers and history
        if (isset($properties['markers'])) {
            $this->codeigniter->session->set_userdata('markers', $properties['markers']);
        } else {
            $this->codeigniter->session->set_userdata('markers', array());
        }
        if (isset($properties['history'])) {
            $this->codeigniter->session->set_userdata('history', $properties['history']);
        } else {
            $this->codeigniter->session->set_userdata('history', array());
        }

		//create user temp folder
		if (!file_exists($this->codeigniter->config->item('pogo_path_temp').'\\'.$this->codeigniter->session->userdata('user_id'))) mkdir($this->codeigniter->config->item('pogo_path_temp').'\\'.$this->codeigniter->session->userdata('user_id'));
    }

    public function logOut() {
        $this->codeigniter->session->unset_userdata('user_id');

        //Set default environment
        $this->setDefaults();
    }

    /* Profiles management */

    private function loadProfiles($user) {
        if ($this->codeigniter->session->userdata('islogged') == true) {
            $uprofiles = array();
            $userprofiles = PoGo\UserProfileQuery::create()->findByUserId($user->getId());
            foreach ($userprofiles as $userprofile) {
                $uroles = array();
                $profileroles = PoGo\ProfileRoleQuery::create()->findByProfileId($userprofile->getProfileId());
                foreach ($profileroles as $profilerole) {
                    //Add Role
                    $uroles[$profilerole->getRole()->getName() ] = array('id' => $profilerole->getId(), 'comment' => $profilerole->getRole()->getComment());
			   }
                //Add profile
                $uprofiles[$userprofile->getProfile()->getId() ] = array('name' => $userprofile->getProfile()->getName(), 'comment' => $userprofile->getProfile()->getComment(), 'roles' => $uroles);
                //Set current profile
                if ($this->codeigniter->session->userdata('currentprofile') == null) $this->codeigniter->session->set_userdata('currentprofile', $this->codeigniter->session->userdata('defaultprofile'));
            }
            $this->codeigniter->session->set_userdata('profiles', $uprofiles);
        }
    }

    public function setProfile($profileid) {
        $profiles = $this->codeigniter->session->userdata('profiles');

        //Verify that user has profile
        if (isset($profiles[$profileid])) {
            $this->codeigniter->session->set_userdata('currentprofile', $profileid);
            return true;
        }

        //Return false because user don't have profile
        $this->codeigniter->session->set_userdata('currentprofile', null);
        return false;
    }

    /* Roles checkers */

    public function haveRole($role, $restriction = false) {
        $profiles = $this->codeigniter->session->userdata('profiles');
        //Check role with no restriction and return value
        if (!$restriction) return isset($profiles[$this->codeigniter->session->userdata('currentprofile') ]['roles'][$role]);
        //Analyze restriction
    }
    public function checkRole($role) {
        if (!$this->haveRole($role)) $this->pogo->html->e401();
    }

    /* User properties getter/setter */

    public function setUserProperty($userid, $propertyname, $value) {
        //get user
        $user = PoGo\UserQuery::create()->findPk($userid);
        if (!$user) return false;

        //Update property
        $properties = json_decode($user->getProperties());
        $properties->$propertyname = $value;
        $user->setProperties(json_encode($properties, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))->save();
    }

    public function getUserProperty($userid, $propertyname) {
        //get user
        $user = PoGo\UserQuery::create()->findPk($userid);
        if (!$user) return false;

        //return property or false
        $properties = json_decode($user->getProperties());
        return ((isset($properties->$propertyname)) ? $properties->$propertyname : false);
    }

    public function setDefaultProfile($profileId) {
        $profiles = $this->codeigniter->session->userdata('profiles');
        $profile = PoGo\ProfileQuery::create()->findPk($profileId);

        //Save currentprofile in session
        if ($profile && isset($profiles[$profileId])) {
            $this->codeigniter->session->set_userdata('currentprofile', $profile->getId());

            $this->codeigniter->session->set_userdata('defaultprofile', $profile->getId());
            $this->setUserProperty($this->codeigniter->session->userdata('user_id'), 'defaultprofile', $profile->getId());

            return true;
        }

        return false;
    }
    
	public function setHomepage($url) {
		//Save homepage in session and database
		$this->codeigniter->session->set_userdata('homepage', $url);
		$this->setUserProperty($this->codeigniter->session->userdata('user_id'), 'homepage', $url);
	}

	public function addMarker($label, $href) {
		$markers = $this->codeigniter->session->userdata('markers');
		//add item in top of array if not already in markers
		$needadd = true;
		foreach ($markers as $link) {
			if ($link['href'] == $href) {
				$needadd = false;
				break;
			}
		}
		if ($needadd) array_unshift($markers,array('label'=>$label,'href'=>$href));

		//add markers in session and database
		$this->codeigniter->session->set_userdata('markers',$markers);
		$this->setUserProperty($this->codeigniter->session->userdata('user_id'), 'markers', $markers);
	}

	public function removeMarker($marker) {
		$markers = $this->codeigniter->session->userdata('markers');
		unset($markers[$marker]);

		//delete markers in session and database
		$this->codeigniter->session->set_userdata('markers',$markers);
		$this->setUserProperty($this->codeigniter->session->userdata('user_id'), 'markers', $markers);
	}

    public function addToHistory($type, $label, $href = false) {
        if (!$href) $href = 'http://' . $_SERVER["SERVER_NAME"] . ':' . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        //Get current history
        $history = $this->codeigniter->session->userdata('history');
        //Add item in top of array if not already in history
        $needadd = true;
        foreach ($history as $link) {
            if ($link['href'] == $href) {
                $needadd = false;
                break;
            }
        }
        if ($needadd) array_unshift($history, array('type' => $type, 'label' => $label, 'href' => $href));

        //Delete surplus item
        if (count($history) > 10) array_pop($history);

        //Save history in session and database
        $this->codeigniter->session->set_userdata('history', $history);
        $this->setUserProperty($this->codeigniter->session->userdata('user_id'), 'history', $history);
    }

    /* Linked objects */

    public function getProject($projectid){
        //Load linked projects
        return PoGo\ProjectQuery::create()
            ->useProjectActorQuery()
            ->filterByActorId($this->codeigniter->session->userdata('actor_id'))
            ->endUse()
            ->findPk($projectid);
    }

}
        
