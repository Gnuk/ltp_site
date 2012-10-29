<?php
class Fonctions{

	/**
	* Fonction permettant formater le message affiché à l'internaute
	* @param boolean $message_erreur Erreur ou non.
	* @param string $message Une variable contenant le message à afficher.
	* @return string $retour Le message formaté.
	* @deprecated Not used at this time
	*/
	public function retourMessage($message_erreur,$message)
	{
		if($message_erreur == true)
		{
			$retour = '<div id="message_erreur"><span><img src="imagesSite/supprimer.png" title="Erreur" alt="Erreur" class="icon" height="16" width="16" /> '.$message.'</span></div>';
		}
		else
		{
			$retour = '<div id="message_accept"><span><img src="imagesSite/accepter.png" title="Accepter" alt="Accepter" class="icon" height="16" width="16" /> '.$message.'</span></div>';
		}
		return $retour;
	}

	/**
	* Fonction permettant de générer une chaine de caractères alpha-numérique aléatoire
	* @param int $longueur La taille de la chaine de caractères à générer.
	* @return string $chaine La chaine de caractères alpha-numérique générée aléatoirement.
	* @deprecated Not used at this time
	*/
	public function alea($longueur)
	{
		$list = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chaine = $list[mt_rand(0, strlen($list)-1)];

		while( strlen( $chaine )< $longueur )
		{
			$list = str_shuffle($list);
			$chaine .= $list[mt_rand(0, strlen($list)-1)];
		}
		return $chaine;
	}

	/**
	* Fonction permettant de découper un temps en secondes au format JJj HHh:MMm:SSs
	* Cette fonction est utilisée pour l'affichage des comptes non validés
	* @param int $t Le temps en secondes.
	* @param string $heure Le temps au format JJj HHh:MMm:SSs.
	* @deprecated Not used at this time
	*/
	public function affichageHeure($t)
	{
		$s = $t%60;
		$m = floor($t/60)%60;
		$h = floor($t/3600)%24;
		$d = floor($t/86400);
		return $heure = $d.'j '.$h.'h:'.$m.'m:'.$s.'s';
	}

	/**
	* Affiche le menu
	* @return string $inscription
	* @deprecated Not used at this time
	*/
	public function afficheMenu()
	{
		if(!isset($_SESSION['login']))
		{
			$inscription = '<td class="caseMenu" ><a class="menu" href="index.php?page=inscription" >Inscription</a></td>';
			return $inscription;
		}
		else
		{
			$strSQL = 'SELECT `statut` FROM `utilisateur` WHERE `pseudo` = "'.$_SESSION['login'].'"';
			$resultat = requeteSQL($strSQL);
			$tabl_result = mysql_fetch_array($resultat);
			if($tabl_result['statut'] == 42)
			{
				$inscription = '<td class="caseMenu" style="font-weight: bold; color: white;" > --------- Super Administrateur --------- </td>';
			}
			elseif($tabl_result['statut'] == 5)
			{
				$inscription = '<td class="caseMenu" style="font-weight: bold; color: white;" > --------- Administrateur --------- </td>';
			}
			return $inscription;
		}
	}

	//##################################################################################################################################//
	//###############----------------------FONCTIONS--POUR--LA--PARTIE--ADMINISTRATION--DU--SITE-------------------------###############//
	//##################################################################################################################################//

	/**
	* Fonction permettant d'afficher les comptes non validés avec l'adresse mail
	* @deprecated Not used at this time
	*/
	public function affichageCompteNonValide()
	{
		echo '<div><form name="form" method="post">';
		
		if (isset($_POST['effacer']) && isset($_POST['select']))
		{
			$ids = implode(",",$_POST['select']);
			$supprimer='DELETE  FROM `utilisateur` WHERE id_utilisateur IN('.$ids.')';
			$requete = mysql_query($supprimer) or die(mysql_error());
		}
		
		$strSQL = 'SELECT `pseudo`, `adresse_mail`, `adresse_ip`, `statut`, `date_creation`, `id_utilisateur` FROM `utilisateur` WHERE `compte_valide`=False ';
		$resultat = requeteSQL($strSQL);
		$i = 0;
		
		if(isset($_GET['checked']))
		{
			$check = 'checked="checked"';
		}
		else
		{
			$check = '';
		}
		
		echo 'Affichage des comptes n\'ayant pas été activé';
		while($tabl_result = mysql_fetch_array($resultat))
		{
			if($i == 0)
			{
				echo '<table>';
				echo '<thead><tr><th></th><th>Pseudo</th><th>Adresse mail</th><th>Adresse IP</th><th>Statut</th><th>Date de creation</th><th>Id de l\'utilisateur</th><th>Temps depuis l\'envoie du mail</th></tr></thead>';
			}
			$input = '';
			$secondes = time()-$tabl_result['date_creation'];
			$heureRetard = affichageHeure($secondes);
			if($secondes <= 43200)
			{
				$retard = 'green';
			}
			elseif($secondes > 43200 && $secondes <= 72000)
			{
				$retard = 'yellow';
			}
			elseif($secondes >72000 && $secondes <= 86400)
			{
				$retard = 'orange';
			}
			elseif($secondes > 86400)
			{
				$retard = '#B71520';
				$input = '<input name="select[]" value="'.$tabl_result['id_utilisateur'].'" type="checkbox" '.$check.' >';
			}
			if($i%2 ==0)
			{
				$mod = 'paire';
			}
			else
			{
				$mod = 'impaire';
			}
			echo '<tr><td class="'.$mod.'" >'.$input.'</td><td class="'.$mod.'" >'.$tabl_result['pseudo'].'</td><td class="'.$mod.'" >'.$tabl_result['adresse_mail'].'</td><td class="'.$mod.'" >'.$tabl_result['adresse_ip'].'</td><td class="'.$mod.'" >'.$tabl_result['statut'].'</td><td class="'.$mod.'" >'.date('H:i:s d-m-Y',$tabl_result['date_creation']).'</td><td class="'.$mod.'" >'.$tabl_result['id_utilisateur'].'</td><td class="'.$mod.'" style="color: '.$retard.';" >'.$heureRetard.'</td></tr>';
			$i++;
			if(!$tabl_result)
			{
				echo '</table>';
			}
		}
		echo '</form></div>';
		echo '<div id="test" ><a href="http://localhost/Plateforme/index.php?checked" >Tout cocher</a> / ';
		echo '<a href="http://localhost/Plateforme/index.php?unchecked" >Tout décocher</a>';
		echo '<button class="mult_submit" type="submit" name="effacer" value="Effacer" title="Effacer" >
		<img src="imagesSite/supprimer.png" title="Effacer" alt="Effacer" class="icon" height="16" width="16" ></button></div>';
	}
	//##################################################################################################################################//
	//##################################################################################################################################//
	//###############-----------------------------FONCTION--POUR--GENERER--UN--NOUVEAU--MDP------------------------------###############//
	//##################################################################################################################################//

	/**
	* Fonction permettant vérifier les informations de l'internaute pour la génération d'un nouveau mot de passe
	* @return boolean
	* @return string Un message d'erreur en fonction des données entrées dans les différents champs.
	* @deprecated Not used at this time
	*/
	public function genererMDP()
	{
		$message_erreur = true;
		$pseudo = mysql_real_escape_string($_POST['recup_pseudo']);
		$adresse_recup = mysql_real_escape_string($_POST['recup_adresse']);
		$strSQL  = 'SELECT COUNT(*) AS `nombre` FROM `utilisateur` WHERE `pseudo` = "'.$pseudo.'"';
		$resultat = requeteSQL($strSQL);
		$tabl_pseudo = mysql_fetch_array($resultat);
		$strSQL  = 'SELECT COUNT(*) AS `nombre` FROM `utilisateur` WHERE `adresse_mail` = "'.$adresse_recup.'"';
		$resultat = requeteSQL($strSQL);
		$tabl_adresse = mysql_fetch_array($resultat);
		$strSQL  = 'SELECT `pseudo`, `adresse_mail` FROM `utilisateur` WHERE `pseudo` = "'.$pseudo.'"';
		$resultat = requeteSQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		if(!empty($pseudo))
		{
			if(!empty($adresse_recup))
			{
				if($tabl_result['pseudo'] == $pseudo && $tabl_result['adresse_mail'] == $adresse_recup)
				{
					$retour = envoieMDP();
					$message_erreur = $retour[0];
					$message = $retour[1];
				}
				else{$message = 'Les informations rentrées sont erronées.';}
			}
			else{$message = 'Veuillez renseigner une adresse mail.';}
		}
		else{$message = 'Veuillez renseigner un pseudo.';}
		return retourMessage($message_erreur,$message);
	}
	//##################################################################################################################################//





	//##################################################################################################################################//
	//###############-------------------------FONCTIONS--D'ENVOIE--DE--MESSAGES--ELECTRONIQUES---------------------------###############//
	//##################################################################################################################################//

	/**
	* Fonction permettant de d'envoyer un message à l'utilisateur ayant oublié son mot de passe
	* @return boolean
	* @return string Un message d'erreur ou non lors de l'envoie du mail.
	* @deprecated Not used at this time
	*/
	public function envoieMDP()
	{
		ini_set('SMTP','smtp.club-internet.fr');
		$code = alea(12);
		
		$strSQL = 'SELECT `pseudo`, `adresse_mail`, `id_utilisateur`, `adresse_ip` FROM `utilisateur` WHERE `pseudo` = "'.$_POST['recup_pseudo'].'"';
		$resultat = requeteSQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		
		$destinataire = $tabl_result['adresse_mail'];
		$subject = "Nouveau mot de passe";
		$subject = '=?iso8859-1?B?'.base64_encode($subject).'?=';	//Ligne permettant pallier aux problèmes d'affichage des accents dans le
																	//champ <objet> sur certaines messageries
		//En-tête
		$limite = "_----------=_parties_".alea(32);
		$headers = "From: \"Mon Site\"<monsite@monserveur.fr>\n";
		$headers .= "Reply-To: <monsite@monserveur.fr>\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"".$limite."\"";
		
		//Message TEXTE
		$text =
		$tabl_result['pseudo'].",
		
		Ce courriel vous a été envoyé depuis le site : http://www.monsite.fr.
		La personne utilisant l'adresse ip ".$tabl_result['adresse_ip'].",
		a générée un nouveau mot de passe.
		Votre nouveau mot de passe a été généré : ".$code.".
		
		Passez un bon moment sur notre site!
		
		Cordialement,
		
		L'équipe de Mon Site.";
		$message = "--".$limite."\n";
		$message .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $text;
		
		//Message HTML
		$html = 
		"<div style=\" font-family: 'Trebuchet MS', Calibri, sans-serif; \">".$tabl_result['pseudo'].",
		<br/>
		Ce courriel vous a été envoyé depuis le site : <a href=\"http://www.monsite.fr\">http://www.monsite.fr</a>.<br/>
		La personne utilisant l'adresse ip ".$tabl_result['adresse_ip'].",<br/>
		a généré un nouveau mot de passe.<br/>
		Votre nouveau mot de passe a été généré : ".$code.".
		<br/>
		Passez un bon moment sur notre site!<br/>
		<br/>
		Cordialement,<br/>
		<br/>
		L'équipe de Mon Site.<div>";
		$message .= "\n\n--".$limite."\n";
		$message .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $html;

		$message .= "\n--".$limite."--";
		
		if(mail($destinataire,$subject,$message,$headers))
		{
			$sql = 'UPDATE `utilisateur` SET password="'.$code.'" WHERE id_utilisateur="'.$tabl_result['id_utilisateur'].'"';
			$requete = mysql_query($sql) or die(mysql_error());
			$message = "Le nouveau mot de passe a été envoyé à l'adresse de messagerie.";
			$message_erreur = false;
		}
		else
		{
			$message = "Une erreur c'est produite lors de l'envois de l'email.";
			$message_erreur = true;
		}
		return array($message_erreur,$message);
	}

	/**
	* Fonction permettant d'envoyer un mail à l'utilisateur pour qu'il valide son inscription
	* @return boolean
	* @return string Un message d'erreur ou non lors de l'envoie du mail.
	* @deprecated Not used at this time
	*/
	public function envoieCourriel()
	{
		ini_set('SMTP','smtp.club-internet.fr');
		$code = alea(32);

		$strSQL = 'SELECT `pseudo`, `adresse_mail`, `id_utilisateur` FROM `utilisateur` WHERE `pseudo` = "'.$_POST['inscription_pseudo'].'"';
		$resultat = requeteSQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		
		//On remplace en français l'écriture des mois anglais 
		$mois = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
		$nombre = date('m')-1;
		
		$destinataire = $tabl_result['adresse_mail'];
		$subject = "Incription à Mon Site";
		$subject = '=?iso8859-1?B?'.base64_encode($subject).'?=';	//Ligne permettant pallier aux problèmes d'affichage des accents dans le
																	//champ <objet> sur certaines messageries
		//En-tête
		$limite = "_----------=_parties_".alea(32);
		$headers = "From: \"Mon Site\"<monsite@monserveur.fr>\n";
		$headers .= "Reply-To: <monsite@monserveur.fr>\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"".$limite."\"";
		
		//Message TEXTE
		$text =
		$tabl_result['pseudo'].",
		
		Ce courriel vous a été envoyé depuis le site : http://www.monsite.fr.
		Vous avez reçu ce message car votre adresse mail a été utilisée lors
		d'une inscription sur notre site le ".date('d ').$mois[$nombre].date(' Y à G:i').".
		
		Si vous ne vous êtes pas inscrit sur ce site,
		merci de ne pas tenir compte de ce message.
		
		Pour activer votre compte, cliquez sur le lien suivant
		(ou copiez le lien dans votre barre d'adresse) :
		
		http://localhost/Plateforme/index.php?id=".$tabl_result['id_utilisateur']."&code=".$code."
		
		Merci de votre inscription, passez un bon moment sur notre site!
		
		Cordialement,
		
		L'équipe de Mon Site.";
		$message = "--".$limite."\n";
		$message .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $text;
		
		//Message HTML
		$html = 
		"<div style=\" font-family: 'Trebuchet MS', Calibri, sans-serif; \">".$tabl_result['pseudo'].",
		<br/>
		Ce courriel vous a été envoyé depuis le site : <a href=\"http://www.monsite.fr\">http://www.monsite.fr</a>.<br/>
		Vous avez reçu ce message car votre adresse mail a été utilisée lors<br/>
		d'une inscription sur notre site le ".date('d ').$mois[$nombre].date(' Y à G:i').".<br/>
		<br/>
		Si vous ne vous êtes pas inscrit sur ce site,<br/>
		merci de ne pas tenir compte de ce message.<br/>
		<br/>
		Pour activer votre compte, cliquez sur le lien suivant<br/>
		(ou copiez le lien dans votre barre d'adresse) :<br/>
		<br/>
		<a href=\"http://localhost/Plateforme/index.php?id=".$tabl_result['id_utilisateur']."&code=".$code."\">http://localhost/Plateforme/index.php?id=".$tabl_result['id_utilisateur']."&code=".$code."</a><br/>
		<br/>
		Merci de votre inscription, passez un bon moment sur notre site!<br/>
		<br/>
		Cordialement,<br/>
		<br/>
		L'équipe de Mon Site.<div>";
		$message .= "\n\n--".$limite."\n";
		$message .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $html;

		$message .= "\n--".$limite."--";
		
		if(mail($destinataire,$subject,$message,$headers))
		{
			$sql = 'UPDATE `utilisateur` SET code_validation="'.$code.'" WHERE id_utilisateur="'.$tabl_result['id_utilisateur'].'"';
			$requete = mysql_query($sql) or die(mysql_error());
			$message = "Un message a été envoyé à l'adresse de messagerie spécifiée lors de l'inscription. Vous avez 24h pour valider votre inscription, passé ce délai, le compte sera supprimé.";
			$message_erreur = false;
		}
		else
		{
			$message = "Une erreur c'est produite lors de l'envois de l'email.";
			$message_erreur = true;
		}
		return array($message_erreur,$message);
	}
	//##################################################################################################################################//





	//##################################################################################################################################//
	//###############--------------------------FONCTIONS--UTILISEES--POUR--L'IMAGE--ANTI-ROBOTS--------------------------###############//
	//##################################################################################################################################//

	/**
	* Fonction permettant de formatter l'adresse ip de l'utilisateur au format : XXX.XXX.XXX.XXX
	* @return string L'adresse IP formatter.
	* @deprecated Not used at this time
	*/
	public function adresseIP()
	{
		list($aIP1,$aIP2,$aIP3,$aIP4) = preg_split('[\.]', $_SERVER['REMOTE_ADDR']);
		$tabaIP = array($aIP1,$aIP2,$aIP3,$aIP4);
		$adresseIP = "";
		for($i=0;$i<=3;$i++)
		{
			while(strlen($tabaIP[$i]) != 3)
			{
				$tabaIP[$i] = '0'.$tabaIP[$i];
			}
			$adresseIP = $adresseIP.'.'.$tabaIP[$i];
		}
		return $adresseIP = preg_replace("[\.]","", $adresseIP,1);
	}

	/**
	* Fonction permettant de tester l'intégrité du fichier "verif.txt" ainsi que de le créer s'il n'existe pas
	* Si le fichier "verif.txt" dépasse 100 lignes (2700 octets) il est alors recréé (afin d'éviter que le serveur travaille avec de trop gros fichiers).
	* Cette fonction gère l'écriture et le réécriture simultanée de plusieurs codes correspond aux adresses ip 
	* @param string $chaine L'image générée.
	* @deprecated Not used at this time
	*/
	public function testVerifIP($chaine)
	{
		if (!file_exists("verif.txt"))
		{
			creerVerifIP($chaine);
		}
		elseif(filesize("verif.txt")%27 != 0)
		{
			creerVerifIP($chaine);
		}
		elseif(filesize("verif.txt")>2700)
		{
			creerVerifIP($chaine);
		}
		else
		{
			ecrireVerifIP($chaine);
		}
	}

	/**
	* creerVerifIP
	* @param string $chaine
	* @deprecated Not used at this time
	*/
	public function creerVerifIP($chaine)
	{
		if(!$fp = fopen("verif.txt",'w')){exit;}
		else
		{
			fclose($fp);
			ecrireVerifIP($chaine);
		}
	}

	/**
	* Fonction permettant d'écrire l'adresse ip de l'utilisateur ainsi que le code correspond
	* Cette fonction gère l'écriture et le réécriture simultanée de plusieurs codes correspond aux adresses ip 
	* @param string $chaine variable de type chaine de caractère correspond au code de l'image générée.
	* @deprecated Not used at this time
	*/
	public function ecrireVerifIP($chaine)
	{
		if(!$fp = fopen("verif.txt",'r+')){exit;}
		else
		{
			$adresseIP = adresseIP();
			$adresseIP2 = "";
			$existIP = false;
			$ligne = $adresseIP.':'.$chaine."\n";
			while(!feof($fp) && $adresseIP2 != $adresseIP)
			{
				list($adresseIP2) = preg_split('[:]', fgets($fp,255));
				if($adresseIP2 == $adresseIP)
				{
					fseek($fp, ftell($fp)-strlen($ligne));
					fwrite($fp,$ligne);
					$existIP = true;
				}
			}
			if($existIP == false)
			{
				fwrite($fp,$ligne);
			}
		}
		fclose($fp);
	}

	/**
	* Fonction permettant de vérifier si le code rentré par l'utilisateur est correct par rapport à l'image
	* @param string $chaine variable de type chaine de caractère correspond au code rentré par l'utilisateur.
	* @return boolean $code un booléen qui dit si le code est valide (true) ou non (false)..
	* @deprecated Not used at this time
	*/
	public function lireVerifIP($chaine)
	{
		if(!$fp = fopen("verif.txt",'r')){exit;}
		else
		{
			$adresseIP = adresseIP();
			$ligneVerif = "";
			$code = false;
			$ligne = $adresseIP.':'.$chaine."\n";
			while(!feof($fp) && $ligne != $ligneVerif)
			{
				$ligneVerif = fgets($fp,255);
				if($ligne == $ligneVerif)
				{
					$code = true;
				}
			}
		}
		fclose($fp);
		return $code;
	}
	//##################################################################################################################################//
}

?>