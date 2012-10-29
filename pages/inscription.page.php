<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('inscription');
	
	# Récupération du contrôleur
	$controller = new \gnk\controller\Inscription();
	$form = $controller->getForm();
	$template = new Template();
	$template->addTitle(T_('Inscription'));
	$template->setDescription(T_('Inscription à LocalizeTeaPots.'));
	$template->addKeywords(array(T_('inscription')));
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
		<p class="form_info">
			<?php echo Page::htmlEncode($info);?>
		</p>
<?php
		}
	}
	else{
		$form = $controller->getForm();
		$displayForm = true;
?>
		<h1 id="inscription">Inscription</h1>
<?php
		if($form->validate()){
			# Récupération du modèle
			if($controller->addUser()){
?>
		<p class="form_info">
			<?php echo T_('Vous êtes maintenant inscrit, veuillez regarder vos messages.');?>
		</p>
<?php
				$displayForm = false;
			}
			else{
				if(count($errors = $controller->getError()) > 0){
					foreach($errors AS $nError => $error){
?>
		<p class="form_error">
			<?php echo $error;?>
		</p>
<?php
					}
				}
				else{
?>
		<p class="form_error">
			<?php echo T_('Une erreur non répertoriée est survenue.');?>
		</p>
<?php
				}
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