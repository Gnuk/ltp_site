<?php
namespace gnk\modules\rest;
use \gnk\config\Module;

require_once(Module::getLink('rest') . 'services.class.php');
class Rest{
	public function __construct(){
		$user = new \gnk\modules\rest\services\User("Gnuk", "lol@ptdr.xd");
		echo '<pre>';
		var_dump($user->toArray());
		echo '</pre>';
	}
}

?>