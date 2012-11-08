<?php
	use \gnk\config\Tools;
	echo T_('Test Send');
	echo '<pre>';
 	var_dump(Tools::sendmail('gnuk@mailoo.org', 'Salut', 'Salut mon gars'));
 	echo '</pre>';
?>