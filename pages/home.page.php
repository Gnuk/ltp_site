<?php
	use \gnk\config\Page;
	use \gnk\config\Config;
	use \gnk\config\Module;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	use \gnk\config\Template;
	use \gnk\modules\form\Form;
	if(Page::haveRights()){
		Module::load('osm');
		$osm = new Osm('carte');
		if(Config::isUser()){
			$marker = new Marker('Amis');
			$marker->add(5.92 ,45.57, '<h1>José</h1>');
			$marker->add(5.8714950, 45.6470858, '<h1>Hugues</h1>');
			$osm->addMarker($marker);
			$mark2 = new Marker('Love');
			$mark2->add(5.93 ,45.57);
			$mark2->add(5.88, 45.6470858);
			$osm->addMarker($mark2);
		}
		Module::load('form');
		$form = new Form('form', $method = 'POST', $action = '?connection');
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
		$template->show('header_full');
		if(!$form->validate() OR !Config::isUser()){
			if(count($info = Config::getInfo())){ ?>
		<ul>
<?php
				foreach ($info as $nInfo => $valueInfo){ ?>
			<li><?php echo htmlspecialchars($valueInfo, ENT_QUOTES); ?></li>
<?php
			} ?>
		</ul>
<?php
			}
			$form->render();
?>
		<p>
			<a href="?p=forgetpassword" title="<?php echo T_('Mot de passe oublié'); ?>"><?php echo T_('Mot de passe oublié'); ?></a> | <a href="?inscription" title="<?php echo T_('S\'inscrire'); ?>"><?php echo T_('S\'inscrire'); ?></a>
		</p>
<?php
		}
		else{ ?>
		<p><a href="?disconnection"><?php echo T_('Se déconnecter'); ?></a></p>
<?php
		}
		$osm->showDiv();
		?>
		<footer>
<?php
		$template->show('footer');
?>
		</footer>
<?php
		$template->show('foot');
		$osm->showJS();
?>
	</body>
</html>
<?php
	}
	else{
		Page::showDefault();
	}
?>