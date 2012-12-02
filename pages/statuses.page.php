<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('statusmanager');
	
	if(Page::haveRights(3)){
		$controller = new \gnk\controller\StatusManager();
		$osm = $controller->getMap('status_map');
		if(isset($_GET['add'])){
			$form = $controller->getAddForm($osm->getLongitude(), $osm->getLatitude());
		}
		else if(isset($_GET['edit'])){
			$form = $controller->getEditForm();
		}
		$template = new Template();
		$template->addTitle(T_('Statuts'));
		$template->setDescription(T_('Gestion des statuts.'));
		$template->addKeywords(array(T_('statuses')));
		$template->show('header_full');
?>
	<article>
		<h1><?php echo T_("Mes statuts");?></h1>
		<div id="status">
<?php
			$osm->showDiv();
?>
			<div id="statuses">
<?php

			if(isset($_GET['add']) OR isset($_GET['edit'])){
?>
			<ul class="action">
				<li><a href="<?php echo Page::getLink(); ?>"><?php echo T_('Revenir aux statuts');?></a></li>
			</ul>
<?php
				$form->render();
			}
			else{
?>
			<ul class="action">
				<li><a href="<?php echo Page::getLink(array('add' => '')) ; ?>">Ajouter un statut</a></li>
			</ul>
<?php
			}
			if(!isset($_GET['add']) AND !isset($_GET['edit'])){
				foreach($controller->getStatuses() as $nStatus => $stat){
?>
				<section>
					<h1><?php echo Page::htmlEncode(date_format($stat['date'], "d/m/Y H:i:s"));?></h1>
					<p>
						<?php echo Page::htmlEncode($stat['message']);?>
					</p>
					<ul>
						<li>
							
							<a href="<?php echo Page::getLink(array('edit' => $stat['id']));?>">
								<?php echo T_('Éditer');?>
							</a>
						</li>
						<li>
							<a href="<?php echo Page::getLink(array('delete' => $stat['id']));?>">
								<?php echo T_('Supprimer');?>
							</a>
						</li>
					</li>
				</section>
<?php
				}
			}
		?>
			</div>
		</div>
	</article>
<?php
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>