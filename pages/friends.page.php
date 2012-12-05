<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('friendsmanager');
	
	if(Page::haveRights(3)){
		$controller = new \gnk\controller\FriendsManager();
		$formWant = $controller->getForm('want');
		$formSeeMe = $controller->getForm('seeme');
		$template = new Template();
		$template->addTitle(T_('Amis'));
		$template->setDescription(T_('Gestion des amis.'));
		$template->addKeywords(array(T_('amis')));
		$template->show('header_full');
?>
	<article>
		<h1><?php echo T_("Amis");?></h1>
		<section id="myfriends">
			<h2><?php echo T_('Mes Amis') ;?></h2>
			<p>Not Implemented</p>
		</section>
		<section id="friendswantme">
			<h2><?php echo T_('Demandes en cours') ;?></h2>
			<?php
				$formWant->render();
			?>
			<p>Not Implemented</p>
		</section>
		<section id="friendsseeme">
			<h2><?php echo T_('Me voient') ;?></h2>
			<?php
				$formSeeMe->render();
			?>
			<p>Not Implemented</p>
		</section>
	</article>
<?php
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>