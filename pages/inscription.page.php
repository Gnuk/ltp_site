<?php
	use \gnk\config\Page;
	use \gnk\config\Template;
	use \gnk\config\Controller;
	use \gnk\config\Model;
	Controller::load('inscription');
	Model::load('inscription');
	
	# Récupération du contrôleur
	$controller = new \gnk\controller\Inscription();
	$form = $controller->getForm();
	$displayForm = true;
	
	$template = new Template();
	$template->show('header_full');
?>
	<article>
		<h1>Inscription</h1>
<?php
    if($form->validate()){
		# Récupération du modèle
		$model = new \gnk\model\Inscription();
		if($model->addUser($_POST['login'], $_POST['password'], $_POST['email'])){
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
?>
	</article>
<?php
	$template->show('footer_full');
	
?>