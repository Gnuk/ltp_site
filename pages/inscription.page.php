<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('inscription');
	
	# Récupération du contrôleur
	$controller = new \gnk\controller\Inscription();
	$form = $controller->getForm();
	$template = new Template();
	$template->show('header_full');
?>
	<article>
<?php
	if(count($infos = $controller->getInfo())>0){
?>
		<h1><?php echo T_("Confirmation d'inscription");?></h1>
<?php
		foreach($infos AS $nInfo => $info){
?>
		<p>
			<?php echo Page::htmlEncode($info);?>
		</p>
<?php
		}
	}
	else{
		$form = $controller->getForm();
		$displayForm = true;
?>
		<h1>Inscription</h1>
<?php
		if($form->validate()){
			# Récupération du modèle
			if($controller->addUser()){
?>
		<p>
			<?php echo T_('Vous êtes maintenant inscrit, veuillez regarder vos messages.');?>
		</p>
<?php
				$displayForm = false;
			}
			else{
?>
		<p>
			<?php echo T_('Un utilisateur porte déjà cet identifiant ou cette adresse de messagerie.');?>
		</p>
<?php
				$displayForm = true;
			}
		}
		if($displayForm){
			$form->render();
		}
	}
?>
	</article>
<?php
	$template->show('footer_full');
	
?>