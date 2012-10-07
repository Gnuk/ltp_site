<?php
	if(Page::haveRights()){
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="styles/style.css" />
		<link rel="shortcut icon" href="images/icone.png" />
		<title><?php echo T_('LocalizeTeaPot');?></title>
	</head>
	
	<body>
		<img id="iconeAccueil" src="images/icone_accueil.png" alt="iconeAccueil" />
		<form name="form1" method="post" action="index.php" >
			<label for="pseudo"><?php echo T_('Identifiant :');?></label><input type="text" name="pseudo" maxlength="32" id="pseudo" /><br/>
			<label for="password"><?php echo T_('Mot de passe :');?></label><input type="password" name="password" maxlength="64" id="password" /><br/>
			<input type="submit" value="<?php echo T_('Connexion');?>" name="boutonConnexion" class="submit" id="connexion" />
		</form>
		<span id="recupInscrip" ><a href="index.php?page=recupMDP" ><?php echo T_('Mot de passe oublié ?');?></a> - <a href="index.php?page=inscription" ><?php echo T_('Inscription');?></a></span>
		<div id="carte">
			<iframe id="carteOSM" width="425" height="350" src="http://www.openstreetmap.org/export/embed.html?bbox=5.6528,45.5355,6.0689,45.7594&amp;layer=mapnik"></iframe>
			<p id="droitsAuteurs">
				<?php echo T_('© 2012 M1 STIC Informatique. Tous droits réservés.'); ?>
			</p>
		</div>
	</body>
	<?php
		Module::load('osm');
		$osm = new ModOsm('carte');
		$marker = new ModOsmMarker('friends', 'Amis');
		$marker->add(5.92 ,45.57, 'José', 'Description de José');
		$marker->add(5.8714950, 45.6470858, 'Hugues', 'Description de Hugues');
		$osm->addMarker($marker);
	?>
</html>
<?php
	}
	else{
		Page::showDefault();
	}
?>