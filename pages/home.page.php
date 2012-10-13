<?php
	use \gnk\Page;
	use \gnk\Module;
	use \module\Osm;
	use \module\osm\Marker;
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
		<img id="iconeAccueil" src="images/icone_accueil.png" alt="iconeAccueil" />
		<form name="form1" method="post" action="?connection" >
			<label for="login"><?php echo T_('Identifiant :');?></label><input type="text" name="login" maxlength="32" id="login" /><br/>
			<label for="password"><?php echo T_('Mot de passe :');?></label><input type="password" name="password" maxlength="64" id="password" /><br/>
			<input type="submit" value="<?php echo T_('Connexion');?>" name="boutonConnexion" class="submit" id="connexion" />
		</form>
		<span id="recupInscrip" ><a href="index.php?page=recupMDP" ><?php echo T_('Mot de passe oublié ?');?></a> - <a href="index.php?page=inscription" ><?php echo T_('Inscription');?></a></span>
		<div id="carte" style=" width:425px; height:350px;">
<!--			<iframe id="carteOSM" width="425" height="350" src="http://www.openstreetmap.org/export/embed.html?bbox=5.6528,45.5355,6.0689,45.7594&amp;layer=mapnik"></iframe>
			<p id="droitsAuteurs">
				<?php echo T_('© 2012 M1 STIC Informatique. Tous droits réservés.'); ?>
			</p>-->
		</div>
		<?php
			Module::load('osm');
			$osm = new Osm('carte');
			$marker = new Marker('Amis');
			$marker->add(5.92 ,45.57, '<h1>José</h1>');
			$marker->add(5.8714950, 45.6470858, '<h1>Hugues</h1>');
			$osm->addMarker($marker);
			$mark2 = new Marker('Love');
			$mark2->add(5.93 ,45.57);
			$mark2->add(5.88, 45.6470858);
			$osm->addMarker($mark2);
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