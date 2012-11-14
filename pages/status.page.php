<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('statusmanager');
	
	if(Page::haveRights(3)){
		$controller = new \gnk\controller\StatusManager();
		$osm = $controller->getMap();
		$form = $controller->getForm($osm->getLongitude(), $osm->getLatitude());
		$template = new Template();
		$template->addTitle(T_('Status'));
		$template->setDescription(T_('Gestion du status.'));
		$template->addKeywords(array(T_('status')));
		$template->show('header_full');
?>
	<article>
		<h1><?php echo T_("Status");?></h1>
		<?php
			$osm->showDiv();
			$form->render();
		?>
	</article>
<?php
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>