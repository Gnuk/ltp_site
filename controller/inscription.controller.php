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

	namespace gnk\controller;
	use \gnk\modules\form\Form;
	use \gnk\config\Module;
	use \gnk\config\Controller;
	use \gnk\config\Config;
	/**
	* Classe inscription
	* @author Anthony REY <anthony.rey@mailoo.org>
	*/
	class Inscription extends Controller{
	
		private $areParams=false;
		private $confirm;
		private $id;
		private $key;
		private $model;
		private $unsubscribe = false;
		
		/**
		* Constructeur du contrôleur
		*/
		public function __construct(){
			$this->loadModel('inscription');
			$this->model = new \gnk\model\Inscription();
			$this->getParams();
		}
		
		/**
		* Ajout de l'utilisateur
		*/
		public function addUser(){
			if(isset($_POST['language']) AND $_POST['language'] != ''){
				return $this->model->addUser($_POST['login'], $_POST['password'], $_POST['email'], $_POST['language']);
			}
			else{
				return $this->model->addUser($_POST['login'], $_POST['password'], $_POST['email']);
			}
		}
		
		/**
		* Récupération des paramètres de l'URL (pour l'activation de compte)
		*/
		private function getParams(){
			if(isset($_GET)){
				if(isset($_GET['id']) AND isset($_GET['key'])){
					$this->areParams = true;
					$this->id=$_GET['id'];
					$this->key=$_GET['key'];
					if(isset($_GET['unsubscribe'])){
						$this->unsubscribe = true;
					}
					$this->updateUser();
				}
			}
		}
		
		/**
		* Mise à jour de l'utilisateur
		*/
		private function updateUser(){
			if($this->unsubscribe){
				$this->model->deleteUser($this->id, $this->key);
			}
			else{
				$this->model->activeUser($this->id, $this->key);
			}
		}
		
		/**
		* Récupération des informations du modèle
		*/
		public function getInfo(){
			return $this->model->getIndications();
		}
		
		/**
		* Récupération des erreurs du modèle
		*/
		public function getError(){
			return $this->model->getErrors();
		}
		
		/**
		* Formulaire d'inscription
		* @return Form $form Le formulaire
		*/
		public function getForm(){
			Module::load('form');
			$form = new Form('form');

			// the label for the "first name" element
			$form->add('label', 'label_login', 'login', T_('Identifiant : '));

			// add the "first name" element
			// the "&" symbol is there so that $obj will be a reference to the object in PHP 4
			// for PHP 5+ there is no need for it
			$obj = & $form->add('text', 'login');

			// set rules
			$obj->set_rule(array(

				// error messages will be sent to a variable called "error", usable in custom templates
				'required'  =>  array('error', T_('Vous devez préciser un identifiant.')),

			));

			// "email"
			$form->add('label', 'label_email', 'email', T_('Adresse de messagerie électronique :'));
			$obj = & $form->add('text', 'email');
			$obj->set_rule(array(
				'required'  => array('error', T_('Veuillez entrer une adresse de messagerie électronique.')),
				'email'     => array('error', T_('Cette adresse est invalide.'))
			));

			// attach a note to the email element
			$form->add('note', 'note_email', 'email', T_('Veuillez entrer une adresse de messagerie électronique, vous recevrez message électronique pour valider votre compte.'), array('style'=>'width:200px'));
			
			 // language
			$form->add('label', 'label_language', 'language', T_('Langue :'));
			$obj = & $form->add('select', 'language', '');
			$obj->add_options(Config::getLanguages());

			// "password"
			$form->add('label', 'label_password', 'password', T_('Mot de passe : '));
			$obj = & $form->add('password', 'password');
			$passFrom = 6;
			$passTo = 50;
			$obj->set_rule(array(
				'required'  => array('error', T_('Le mot de passe est demandé.')),
				'length'    => array($passFrom, $passTo, 'error', sprintf(T_('Votre mot passe doit être composé de %d à %d caractères.'), $passFrom, $passTo)),
			));
			$form->add('note', 'note_password', 'password', sprintf(T_('Votre mot passe doit être composé de %d à %d caractères.'), $passFrom, $passTo));

			// "confirm password"
			$form->add('label', 'label_confirm_password', 'confirm_password', T_('Confirmation de mot de passe :'));
			$obj = & $form->add('password', 'confirm_password');
			$obj->set_rule(array(
				'compare' => array('password', 'error', T_('Les mots de passes ne correspondent pas.'))
			));

			// "captcha"
			$form->add('captcha', 'captcha_image', 'captcha_code');
			$form->add('label', 'label_captcha_code', 'captcha_code', T_('Êtes-vous un être humain ?'));
			$obj = & $form->add('text', 'captcha_code');
			$form->add('note', 'note_captcha', 'captcha_code', T_('Vous devez entrer les caractères de couleur noire'), array('style'=>'width: 200px'));
			$obj->set_rule(array(
				'captcha' => array('error', T_('Les caractères ne correspondent pas !'))
			));

			// "submit"
			$form->add('submit', 'btnsubmit', T_('S\'enregistrer'));
			return $form;
		}
	}
?>