<?php
	namespace gnk\model;
	use \gnk\config\Tools;
	use \gnk\config\Config;
	use \gnk\config\Model;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\VerifyUsers;
	
	/**
	* Modèle d'inscription
	* @author Anthony REY <anthony.rey@mailoo.org>
	* @todo Traitement du formulaire de récupération de mot de passe
	*/
	class Inscription extends Model{
		private $username;
		private $mail;
		private $subject;
		private $message;
		private $id;
		
		/**
		* Constructeur
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Indique si l'utilisateur existe déjà ou non
		* @return boolean
		*/
		private function isUser(){
			$qb = $this->em->createQueryBuilder();
			$qb->select($qb->expr()->count('u.id'))
				->from('\gnk\database\entities\Users', 'u')
				->where($qb->expr()->orX(
					$qb->expr()->like('u.login', '?1'),
					$qb->expr()->like('u.mail', '?2')
				));
			$qb->setParameters(array(1 => $this->username, 2 => $this->mail));
			$query = $qb->getQuery();
			$result = $query->getSingleResult();
			if($result[1] > 0){
				return true;
			}
			return false;
		}
		
		public function activeUser($id, $key){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('v'))
				->from('\gnk\database\entities\VerifyUsers', 'v')
				->where('v.user = :id')
				->andWhere('v.userkey = :userkey');
			$qb->setParameters(array('id' => $id, 'userkey' => sha1($key)));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result)>0){
				$result[0]->getUser()->setActive(true);
				$this->addIndication(T_('Vous pouvez maintenant vous connecter'));
				$this->em->persist($result[0]->getUser());
				$this->em->remove($result[0]);
				$this->em->flush();
			}
		}
		public function deleteUser($id, $key){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('v'))
				->from('\gnk\database\entities\VerifyUsers', 'v')
				->where('v.user = :id')
				->andWhere('v.userkey = :userkey');
			$qb->setParameters(array('id' => $id, 'userkey' => sha1($key)));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result)>0){
				$this->em->remove($result[0]->getUser());
				$this->em->remove($result[0]);
				$this->em->flush();
				$this->addIndication(T_('Utilisateur supprimé de la base de donnée'));
			}
		}
		
		/**
		* Ajoute un utilisateur en lui demandant une confirmation par mail
		* @param string $username
		* @param string $password
		* @param string $mail
		*/
		public function addUser($username, $password, $mail, $language=null){
			$this->username = $username;
			$this->mail=$mail;
			$this->key = sha1(uniqid(rand(), true));
			if(!$this->isUser()){
				$user=new Users($username, $password, $mail, $language);
				$this->em->persist($user);
				$this->em->flush();
				return $this->verificationUser($user);
			}
			else{
				$this->addError(T_('Un utilisateur porte déjà cet identifiant ou cette adresse de messagerie.'));
				return false;
			}
		}
		
		/**
		* Envoi un mail de vérification à l'utilisateur
		*/
		private function verificationUser($user){
			$verif=new VerifyUsers($user, $this->key);
			$this->em->persist($verif);
			$this->em->flush();
			$this->id = $user->getId();
			//Envoi du message
			$this->getSubject();
			$this->getMessage();
			if(Tools::sendmail($this->mail, $this->subject, $this->message)){
				return true;
			}
			else{
				$this->em->remove($verif);
				$this->em->flush();
				$this->addError(T_('Envoi du mail échoué, veuillez récupérer votre mot de passe via le formulaire de mots de passes oubliés.'));
				return false;
			}
		}
		
		/**
		* Permet de récupérer le sujet du message
		*/
		private function getSubject(){
			$global = Config::getWebsiteConfig();
			if(isset($global['title'])){
				$this->subject = sprintf(T_('Inscription à %s'), $global['title']);
			}
			else{
				$this->subject = T_('Inscription');
			}
			
		}
		
		/**
		* Permet de définir le message à envoyer à la personne qui s'inscrit
		*/
		private function getMessage(){
			$global = Config::getWebsiteConfig();
			if(isset($global['title'])){
				$this->message = sprintf(T_("Bienvenue sur %s"), $global['title']) . "\n";
			}
			else{
				$this->message = T_("Bienvenue") . "\n";
			}
			$this->message .= T_('Vous pouvez terminer votre inscription en cliquant sur')."\n";
			$url = 'http';
			if(isset($_SERVER['HTTPS'])){
				$url .= 's';
			}
			$url .=  '://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			if(isset($_GET)){
				$url .= '&';
			}
			else{
				$this->message .= '?';
			}
			$url .= 'id='.$this->id.'&key='.$this->key;
			$this->message .= $url . "\n";
			$this->message .= T_('Ou l\'annuler en cliquant sur') . "\n";
			$this->message .= $url . '&unsubscribe';
		}
	}
?>