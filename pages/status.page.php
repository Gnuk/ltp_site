<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('statusmanager');
	
	if(Page::haveRights(3)){
		$controller = new \gnk\controller\StatusManager();
		$osm = $controller->getMap();
		if(isset($_GET['add'])){
			$form = $controller->getAddForm($osm->getLongitude(), $osm->getLatitude());
		}
		else if(isset($_GET['edit'])){
			$form = $controller->getEditForm();
		}
		$template = new Template();
		$template->addTitle(T_('Statuts'));
		$template->setDescription(T_('Gestion du status.'));
		$template->addKeywords(array(T_('status')));
		$template->show('header_full');
?>
	<article>
		<h1><?php echo T_("Status");?></h1>
		<?php
			$osm->showDiv();
			if(isset($_GET['add']) OR isset($_GET['edit'])){
?>
		<ul>
			<li><a href="<?php echo Page::getLink(); ?>"><?php echo T_('Revenir aux statuts');?></a></li>
		</ul>
<?php
				$form->render();
			}
			else{
?>
		<ul>
			<li><a href="<?php echo Page::getLink() . '&amp;add'; ?>">Ajouter un statut</a></li>
		</ul>
<?php
			}
		?>
	</article>
<?php
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>