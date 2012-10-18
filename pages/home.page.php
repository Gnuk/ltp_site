<?php
	use \gnk\config\Page;
	use \gnk\config\Config;
	use \gnk\config\Module;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	if(Page::haveRights()){
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="styles/style.css" />
		<link rel="shortcut icon" href="images/icone.png" />
		<title><?php echo T_('LocalizeTeaPot');?></title>
		<style>
			.olPopup{
				box-shadow: 0px 2px 5px rgba(0,0,0,0.5);
			}
			.olPopup, .olPopupContent{
				border-radius: 10px;
			}
			.olPopupContent{
				
			}
		</style>
	</head>
	
	<body>
		<header>
			<h1>
				<img id="iconeAccueil" src="images/icone_accueil.png" alt="Accueil" />
			</h1>
		</header>
<?php 
	if(!Config::isUser()){
		if(count($info = Config::getInfo())){ ?>
		<ul>
<?php
			foreach ($info as $nInfo => $valueInfo){ ?>
			<li><?php echo htmlspecialchars($valueInfo, ENT_QUOTES); ?></li>
<?php
			} ?>
		</ul>
<?php
		}?>
		<form name="form1" method="post" action="?connection" >
			<p>
				<label for="login"><?php echo T_('Identifiant :');?></label>
				<input type="text" name="login" maxlength="32" id="login" />
			</p>
			<p>
				<label for="password"><?php echo T_('Mot de passe :');?></label>
				<input type="password" name="password" maxlength="64" id="password" />
			</p>
			<p>
				<input type="submit" value="<?php echo T_('Connexion');?>" name="boutonConnexion" class="submit" id="connexion" />
			</p>
		</form>
		<p>
			<a href="index.php?p=forgetpassword" ><?php echo T_('Mot de passe oublié ?');?></a> - <a href="index.php?p=inscription" ><?php echo T_('Inscription');?></a>
		</p>
<?php
	}
	else{ ?>
		<p><a href="?disconnection"><?php echo T_('Se déconnecter'); ?></a></p>
<?php
	} ?>
		<div id="carte" style=" width:800px; height:600px;"><p>Veuillez activer javascript pour voir la carte</p></div>
		<footer>
			<?php echo T_('Copyright © 2012 Open Team Map'); ?>
		</footer>
		<?php
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
			$osm->show();
		?>
	</body>
</html>
<?php
	}
	else{
		Page::showDefault();
	}
?>