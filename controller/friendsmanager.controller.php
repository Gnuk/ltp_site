<?php
namespace gnk\controller;
use \gnk\config\Page;
use \gnk\config\Model;
use \gnk\config\Module;
use \gnk\modules\form\Form;
Model::load('friendsmanager');

/**
* Contrôleur des amis
*/
class FriendsManager{
	private $model;
	private $add;
	
	public function __construct(){
 		$this->model = new \gnk\model\FriendsManager();
		$this->addFriend();
	}
	
	public function getForm($get){
		Module::load('form');
		$form = new Form('form_'.$get, 'POST', Page::getLink(array($get => null), true, false));
		$form->add('label', 'label_login_'.$get, 'login', T_('Utilisateur : '));
		$obj = & $form->add('text', 'login');
		$obj->set_rule(array(
			'required'  =>  array('error', T_('Vous indiquer votre identifiant.')),

		));
		$form->add('submit', 'btnsubmit', T_('Ajouter'));
		return $form;
	}
	
	public function addFriend(){
		if(
			isset($_POST['login'])
		)
		{
			if(isset($_GET['want'])){
				$this->add = $this->model->addFriendWanted($_POST['login']);
			}
			else if(isset($_GET['seeme'])){
				$this->add = $this->model->addFriendSeeMe($_POST['login']);
			}
			return $this->add;
		}
		return false;
	}
}

?>