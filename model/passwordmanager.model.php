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
	namespace gnk\model;
	use \gnk\config\Model;
	use \gnk\config\Config;
	use \gnk\config\Page;
	use \gnk\config\Tools;
	use \gnk\database\entities\ConfirmPassword;

	class PasswordManager extends Model{
	
		private $user;
		private $key;
		private $message;
		private $id;
		private $subject;
	
		public function __construct(){
			parent::__construct();
		}
		
		public function sendPassword($login){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('u'))
				->from('\gnk\database\entities\Users', 'u')
				->where('u.login LIKE :login');
			$qb->setParameters(array('login' => $login));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				$this->user = $result[0];
				return $this->addConfirmPassword();
			}
			else{
				$this->addError(T_('Aucun utilisateur n\'a ce login'));
				return false;
			}
		}
		
		public function isConfirm($id, $key){
			$qb = $this->em->createQueryBuilder();
			$qb->select($qb->expr()->count('c'))
				->from('\gnk\database\entities\ConfirmPassword', 'c')
				->where('c.user = :id')
				->andWhere('c.userkey = :ukey');
			$qb->setParameters(array('id' => $id, 'ukey' => sha1($key)));
			$query = $qb->getQuery();
			$result = $query->getSingleResult();
			if($result[1] == 1){
				return true;
			}
			return false;
		}
		
		private function getConfirm(){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('c'))
				->from('\gnk\database\entities\ConfirmPassword', 'c')
				->where('c.user = :user');
			$qb->setParameters(array('user' => $this->user));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				$confirm = $result[0];
				$confirm->setUserKey($this->key);
			}
			else{
				$confirm = new ConfirmPassword($this->user, $this->key);
				$this->em->persist($confirm);
			}
			$this->em->flush();
			return $confirm;
		}
		
		private function addConfirmPassword(){
			$this->key = sha1(uniqid(rand(), true));
			$confirm = $this->getConfirm();
			$this->id = $this->user->getId();
			$this->mail = $this->user->getMail();
			if($this->sendMail()){
				return true;
			}
			else{
				$this->em->remove($confirm);
				$this->em->flush();
				$this->addError(T_('L\'envoi du mail a échoué, veuillez retenter une nouvelle fois'));
				return false;
			}
		}
		
		public function changePassword($id, $key, $pass){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('c'))
				->from('\gnk\database\entities\ConfirmPassword', 'c')
				->where('c.user = :id')
				->andWhere('c.userkey = :ukey');
			$qb->setParameters(array('id' => $id, 'ukey' => sha1($key)));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				$user = $result[0]->getUser();
				$user->setActive(true);
				$user->setPassword($pass);
				$this->em->remove($result[0]);
				$this->em->flush();
			}
			else{
				$this->addError(T_('Les données ne correspondent pas'));
				return false;
			}
		}
		
		private function sendMail(){
			$global = Config::getWebsiteConfig();
			if(isset($global['title'])){
				$this->subject = sprintf(T_("Récupération du mot de passe de  %s"), $global['title']);
				$this->message = sprintf(T_("Vous avez demandé de récupérer le mot de passe de  %s"), $global['title']) . "\n\n";
			}
			else{
				$this->subject = sprintf(T_("Récupération du mot de passe"), $global['title']);
				$this->message = T_("Demande de récupération de mot de passe") . "\n";
			}
			$url = 'http';
			if(isset($_SERVER['HTTPS'])){
				$url .= 's';
			}
			$url .=  '://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			if(Page::getMethod() == 'get'){
				if(isset($_GET)){
					$url .= '&';
				}
				else{
					$url .= '?';
				}
			}
			else{
				$url .= '?';
			}
			$url .= 'id='.$this->id.'&key='.$this->key;
			$this->message .= sprintf(T_("Vous pouvez modifier votre mot de passe en cliquant sur : \n%s"), $url);
			$this->message .= "\n";
			$this->message .= sprintf(T_("Ou annuler la demande de récupération en cliquant sur : \n%s"), $url.'&unconfirm');
			$this->message .= "\n\n";
			$this->message .= "---------\n";
			if(isset($global['title'])){
				$this->message .= sprintf(T_('L\'équipe du site %s'), $global['title']) . "\n";
			}
			else{
				$this->message .= T_('L\'équipe du site') . "\n";
			}
			$this->message .= T_('Merci de ne pas répondre à ce mail auto généré');
			return Tools::sendmail($this->mail, $this->subject, $this->message);
		}
	}
?>