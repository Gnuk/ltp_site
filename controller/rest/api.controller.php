<?php
/*
*
* Copyright (c) 2012 OpenTeamMap
*
* This file is part of LocalizeTeaPot.
*
* LocalizeTeaPot is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* LocalizeTeaPot is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace gnk\controller\rest;
use \gnk\config\Module;
use \gnk\config\Model;
use \gnk\config\Page;
use \gnk\modules\rest\Rest;
use \gnk\controller\rest\services\User;
use \gnk\controller\rest\services\Friends;
use \gnk\controller\rest\services\Statuses;
use \gnk\controller\rest\services\Status;
use \gnk\controller\rest\services\Track;
use \gnk\model\RestManager;
Module::load('rest');
Model::load('restmanager');
require_once(LINK_CONTROLLER . 'rest/services.class.php');

/**
* Définition de l'API REST
* @author Anthony REY <anthony.rey@mailoo.org>
* @namespace gnk\controller\rest
*/
class Api extends Rest{
	public function __construct(){
		parent::__construct();
	}
	
	public function run(){
		$this->model = new \gnk\model\RestManager();
		if($this->isApi() AND isset($this->pathInfo[2])){
			switch($this->pathInfo[2]){
				case 'user':
					$this->launchUser();
					break;
				case 'statuses':
					$this->launchStatuses();
					break;
				case 'status':
					$this->launchStatuses();
					break;
				case 'friends':
					$this->launchFriends();
					break;
				case 'track':
					$this->launchTrack();
					break;
			}
		}
	}
	
	public function launchFriends(){
		if($this->getMethod() == 'get'){
			if(isset($this->login) AND isset($this->password)){
				if(count($user = $this->model->getUserProfile($this->login, $this->password)) == 1){
					$friends = $this->model->getFriends($user[0]['id']);
					if(count($friends) > 0){
						$rest = new Friends($friends);
						$this->setArray($rest->toArray());
						$this->get();
					}
					else{
						/**
						* Aucun contenu
						*/
						Page::setHTTPCode(204);
					}
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
	}
	
	/**
	* Action REST de gestion de l'utilisateur
	*/
	public function launchUser(){
		if($this->getMethod() == 'get'){
			if(isset($this->login) AND isset($this->password)){
				$profile = $this->model->getUserProfile($this->login, $this->password);
				if(count($profile) == 1){
					if(isset($profile[0]['language'])){
						$user = new User($profile[0]['login'], $profile[0]['mail'], $profile[0]['language']);
					}
					else{
						/**
						* Si l'utilisateur n'a pas de langage définit
						*/
						$user = new User($profile[0]['login'], $profile[0]['mail']);
					}
					$this->setArray($user->toArray());
					$this->get();
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
		else if($this->getMethod() == 'post'){
			Page::setHTTPCode(404);
			echo 'Pas implémenté';
		}
		else{
			Page::setHTTPCode(404);
		}
	}
	
	/**
	* Action REST de gestion des statuts
	*/
	public function launchStatuses(){
		if($this->getMethod() == 'get'){
			if(isset($this->login) AND isset($this->password)){
				if(count($user = $this->model->getUserProfile($this->login, $this->password)) == 1){
					$statuses = $this->model->getStatuses($user[0]['id']);
					if(count($statuses) > 0){
						$rest = new Statuses($statuses);
						$this->setArray($rest->toArray());
						$this->get();
					}
					else{
						/**
						* Aucun contenu
						*/
						Page::setHTTPCode(204);
					}
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
		else if($this->getMethod() == 'post'){
			if(isset($this->login) AND isset($this->password)){
				if(count($user = $this->model->getUser($this->login, $this->password)) == 1){
					$this->recieve();
					$array = $this->getArray();
					if($status = Status::createStatus($array, $user[0])){
						$status->save();
					}
					else{
						/**
						* Requête malformée
						*/
						Page::setHTTPCode(400);
					}
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
		else{
			Page::setHTTPCode(404);
		}
	}
	
	public function launchTrack(){
		if($this->getMethod() == 'put'){
			if(isset($this->login) AND isset($this->password)){
				if(count($user = $this->model->getUser($this->login, $this->password)) == 1){
					$this->recieve();
					$array = $this->getArray();
					if($track = Track::createTrack($array, $user[0])){
						$track->save();
					}
					else{
						/**
						* Requête malformée
						*/
						Page::setHTTPCode(400);
					}
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
		else{
			Page::setHTTPCode(404);
		}
	}
}
?>