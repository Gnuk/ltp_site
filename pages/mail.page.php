<?php
	use \gnk\config\Tools;
	echo T_('Test Send');
 	Tools::sendmail('gnuk@mailoo.org', 'Salut', 'Salut mon gars');
?>