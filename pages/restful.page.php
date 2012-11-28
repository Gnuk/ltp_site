<?php
	use \gnk\config\Page;
	use \gnk\config\Module;
	use \gnk\modules\rest\Rest;
	if(Page::haveRights()){
		echo $_SERVER["PATH_INFO"];
		Module::load('rest');
		$rest = new Rest();
	}
?>