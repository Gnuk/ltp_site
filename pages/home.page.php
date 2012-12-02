<?php
	use \gnk\config\Page;
	use \gnk\config\Config;
	use \gnk\config\Module;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	use \gnk\config\Template;
	use \gnk\modules\form\Form;
	if(Page::haveRights()){
		if(Config::isUser()){
			Module::load('osm');
			$osm = new Osm('carte');
			$osm->setJS();
		}
		Module::load('form');
		$form = new Form('form', $method = 'POST', $action = Page::getLink(array('connection' => null), true, false));
		$form->add('label', 'label_login', 'login', T_('Identifiant : '));
		$obj = & $form->add('text', 'login');
		$obj->set_rule(array(
			'required'  =>  array('error', T_('Vous indiquer votre identifiant.')),

		));
		// "password"
		$form->add('label', 'label_password', 'password', T_('Mot de passe : '));
		$obj = & $form->add('password', 'password');
		$obj->set_rule(array(
			'required'  => array('error', T_('Veuillez indiquer votre mot de passe.'))
		));
		
		$form->add('submit', 'btnsubmit', T_('Se connecter'));
		$template = new Template();
		$template->addTitle(T_('Accueil'));
		$template->show('header_full');
?>
			<article>
<?php
		if(Config::isUser()){
?>
				<h1><?php echo Page::htmlEncode(sprintf(T_('Bienvenue %s'), Page::htmlEncode($_SESSION['user'])));?></h1>
				<p><a href="?disconnection"><?php echo T_('Se déconnecter'); ?></a></p>
<?php
		}
		else{
?>
				<h1><?php echo T_('Connexion');?></h1>
<?php
			if($form->validate()){
				if(count($info = Config::getInfo())){ ?>
				<ul class="form_error">
<?php
					foreach ($info as $nInfo => $valueInfo){ ?>
					<li><?php echo Page::htmlEncode($valueInfo); ?></li>
<?php
					} ?>
				</ul>
<?php
				}
			}
			$form->render();
?>
				<p>
					<a href="<?php echo Page::createPageLink('connection'); ?>" title="<?php echo Page::htmlEncode(T_('Mot de passe oublié')); ?>"><?php echo Page::htmlEncode(T_('Mot de passe oublié')); ?></a> | <a href="<?php echo Page::createPageLink('inscription'); ?>" title="<?php echo Page::htmlEncode(T_('S\'inscrire')); ?>"><?php echo Page::htmlEncode(T_('S\'inscrire')); ?></a>
				</p>
<?php
		}
		if(Config::isUser()){
			$osm->showDiv();
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