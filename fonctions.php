<?php
class Fonctions{
	/**
	* Connexion à la Base de donnée
	* @param string $nameDB Nom de la base de donnée
	* @deprecated Not used at this time
	*/
	public function connexion_DB($name_DB)
	{
		$host = "localhost";  
		$user = "root";
		$bdd = $name_DB;
		$passwd  = "";

		mysql_connect($host, $user, $passwd) or die("Erreur de connexion au serveur");
		mysql_select_db($bdd) or die("Erreur de connexion a la base de donnees");
	}

	/**
	* Déconnection de la BDD
	* @deprecated Not used at this time
	*/
	public function deconnexion_DB()
	{
		mysql_close();
	}

	/**
	* Fonction qui exécute une requète SQL. Si la requête ne passe pas, elle renvoie le message d'erreur MySQL
	* @param string $strSQL Chaîne SQL
	* @result mysql_query $result Correspond aux enregistrements correspondants
	* @deprecated Not used at this time
	*/
	public function requeteSQL($strSQL)
	{
		$result = mysql_query($strSQL);
		if (!$result)
		{
			$message  = 'Erreur SQL : ' . mysql_error() . "<br>\n";
			$message .= 'SQL string : ' . $strSQL . "<br>\n";
			$message .= "Erreur lors de la requete";
			die($message);
		}
		return $result;
	}


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
	//###############-------------------FONCTIONS--POUR--LA--CONNEXION/DECONNEXION--D'UN--UTILISATEUR--------------------###############//
	//##################################################################################################################################//

	/**
	* Fonction permettant d'afficher soit le formulaire de connection (pour l'internaute venant d'arriver sur la page), soit un bouton de déconnection pour l'utilisateur déjà connecté.
	* @deprecated Not used at this time
	*/
	public function connect()
	{
		if(isset($_SESSION['login']))
		{
			$connect = '<label> ----- '.$_SESSION['login'].' ----- </label><div class="connection" >
						<a href="#" >Mon profil</a>
						<form name="form1" method="post" >
							<input type="submit" value="Déconnexion" name="boutonDeconnexion" class="submit" />
						</form></div>';
		}
		else
		{
			$connect = '<label>Se connecter</label><div class="connection" >
						<form name="form1" method="post" action="index.php" >
							<label for="pseudo">Pseudo :</label><input type="text" name="pseudo" maxlength="32" id="pseudo" /><br/>
							<label for="password">Mot de passe :</label><input type="password" name="password" maxlength="64" id="password" /><br/>
							<input type="submit" value="Connexion" name="boutonConnexion" class="submit" id="connexion" />
						</form>
						<span id="recupInscrip" ><a href="index.php?page=recupMDP" >Mot de passe oublié?</a> - <a href="index.php?page=inscription" >Inscription</a></span></div>';
		}
		return $connect;
	}

	/**
	* Fonction permettant de vérifier les identifiants d'un utilisateur
	* @see retourMessage
	* @return string L'utilisateur accède au contenu qui lui est destiné en fonction de son statut si les identifiants sont corrects, ou on affiche un message d'erreur.
	* @deprecated Not used at this time
	*/
	public function verifierConnexion()
	{
		$pseudo = mysql_real_escape_string($_POST['pseudo']);
		$password = mysql_real_escape_string($_POST['password']);
		$strSQL = 'SELECT `pseudo`, `password`, `date_connexion`, `statut`, `essais`, `compte_valide` FROM `utilisateur` WHERE `pseudo` = "'.$pseudo.'"';
		$resultat = requeteSQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		
		if(!empty($pseudo) && $pseudo == $tabl_result['pseudo'] && $password == $tabl_result['password'] && $tabl_result['compte_valide'] == true && ($tabl_result['statut'] == 1 || $tabl_result['statut'] == 42))
		{
			$sql = 'UPDATE `utilisateur` SET essais = 0, date_connexion = '.time().' WHERE pseudo="'.$tabl_result['pseudo'].'"';
			$requete = mysql_query($sql) or die(mysql_error());
			$_SESSION['login'] = $tabl_result['pseudo'];
			$message = 'Bienvenue '.$tabl_result['pseudo'].' !';
			$message_erreur = false;
		}
		elseif(!empty($pseudo) && $pseudo == $tabl_result['pseudo'] && $tabl_result['compte_valide'] == true && $tabl_result['statut'] == 0)
		{
			$message = 'Ce compte a été vérouillé car le nombre essais de mots de passe a été suppérieur à 3. Un message a été envoyé sur la messagerie correspondant au compte.';
			$message_erreur = true;
		}
		elseif(!empty($pseudo) && $pseudo == $tabl_result['pseudo'] && $tabl_result['compte_valide'] == true && $tabl_result['statut'] == -1)
		{
			$message = 'Ce compte a été vérouillé car son utilisateur a été banni.';
			$message_erreur = true;
		}
		else
		{
			if($pseudo == $tabl_result['pseudo'] && $tabl_result['compte_valide'] == true)
			{
				$sql = 'UPDATE `utilisateur` SET essais = essais+1 WHERE pseudo="'.$tabl_result['pseudo'].'"';
				$requete = mysql_query($sql) or die(mysql_error());
				if($tabl_result['essais'] >= 3)
				{
					$sql = 'UPDATE `utilisateur` SET essais = 0, statut = 0 WHERE pseudo="'.$tabl_result['pseudo'].'"';
					$requete = mysql_query($sql) or die(mysql_error());
				}
			}
			$message = 'Le mot de passe est erroné ou le compte n\'existe pas.';
			$message_erreur = true;
		}
		return retourMessage($message_erreur,$message);
	}

	/**
	* Fonction permettant de déconnecter un utilisateur
	* @see retourMessage
	* @return Destruction de la session de l'utilisateur.
	* @deprecated Not used at this time
	* @warning Peut-on remplacer @session_destroy() par session_destroy() ?
	*/
	public function deconnexion()
	{
		unset($_SESSION);
		$_SESSION = array();
		@session_destroy();
		$message = 'Vous êtes déconnecté.';
		$message_erreur = false;
		return retourMessage($message_erreur,$message);
	}
	//##################################################################################################################################//





	//##################################################################################################################################//
	//###############--------------------------FONCTIONS--POUR--L'INSCRIPTION--D'UN--UTILISATEUR-------------------------###############//
	//##################################################################################################################################//

	/**
	* Fonction permettant de valider l'inscription de l'utilisateur grâce à son identifiant et au code généré lors de l'envoie du mail
	* @see retourMessage
	* @return boolean Écriture d'un booléen (true) dans la base de données si les informations sont justes et création d'un dossier pour l'utilisateur (le dossier prendra comme nom celui de l'utilisateur)
	* @return string Sinon on affiche un message d'erreur.
	* @deprecated Not used at this time
	*/
	public function validationIncription()
	{
		$strSQL = 'SELECT `pseudo`, `id_utilisateur`, `code_validation`, `compte_valide` FROM `utilisateur` WHERE `id_utilisateur` = "'.$_GET['id'].'"';
		$resultat = requeteSQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		if($tabl_result['id_utilisateur'] == $_GET['id'] && $tabl_result['code_validation'] == $_GET['code'] && $tabl_result['compte_valide'] == False)
		{
			$sql = 'UPDATE `utilisateur` SET compte_valide=True WHERE id_utilisateur="'.$tabl_result['id_utilisateur'].'"';
			$requete = mysql_query($sql) or die(mysql_error());
			$message = "Votre compte a été validé.";
			mkdir('./RepertoireUtilisateur/'.$tabl_result['pseudo'].'', 0777);
			$message_erreur = false;
		}
		else
		{
			$message = "Erreur, ce lien ne correspond pas à une validation de compte, le compte a déjà été validé ou le compte a été supprimé.";
			$message_erreur = true;
		}
		return retourMessage($message_erreur,$message);
	}

	/**
	* Fonction permettant de vérifier les différents champs rentrés par l'utilisateur
	* @return  Écriture des informations dans la base de données (si les champs rentrés par l'utilisateur sont valides sinon on retourne un message d'erreur).
	* @deprecated Not used at this time
	*/
	public function verifierChamps()
	{
		$message_erreur = true;
		$pseudo = mysql_real_escape_string($_POST['inscription_pseudo']);
		$password = mysql_real_escape_string($_POST['password']);
		$passwordVerif = mysql_real_escape_string($_POST['passwordVerif']);
		$inscrip_adresse = mysql_real_escape_string($_POST['adresse']);
		$saisieCodeVerif = mysql_real_escape_string($_POST['saisieCodeVerif']);
		$strSQL  = 'SELECT COUNT(*) AS `nombre` FROM `utilisateur` WHERE `pseudo` = "'.$pseudo.'"';
		$resultat = requeteSQL($strSQL);
		$tabl_pseudo = mysql_fetch_array($resultat);
		$strSQL  = 'SELECT COUNT(*) AS `nombre` FROM `utilisateur` WHERE `adresse_mail` = "'.$inscrip_adresse.'"';
		$resultat = requeteSQL($strSQL);
		$tabl_adresse = mysql_fetch_array($resultat);
		if(strlen($pseudo) >= 3 && strlen($pseudo) <= 32){
		$pseudoVerif = verifierPseudo($pseudo);
			if($pseudoVerif == true){
				if($tabl_pseudo['nombre'] == 0){
					if(strlen($password) >= 8 && strlen($password) <= 64){
						if(!empty($passwordVerif)){
							if($password == $passwordVerif)
							{
							$adresse = verifierAdresseMail($inscrip_adresse);
								if($adresse == true){
									if($tabl_adresse['nombre'] == 0)
									{
										if(!$fp = fopen('verif.txt','r')){exit;}
										else
										{
											$code = lireVerifIP($saisieCodeVerif);
											if($code == true)
											{
												$sql = 'INSERT INTO `utilisateur` (`pseudo`,`password`,`adresse_mail`,`adresse_ip`, `date_creation`, `statut`,`compte_valide`) VALUES ("'.$pseudo.'","'.$password.'","'.$inscrip_adresse.'","'.$_SERVER['REMOTE_ADDR'].'","'.time().'","1",False)';
												$requete = mysql_query($sql) or die(mysql_error());
												$retour = envoieCourriel();
												$message_erreur = $retour[0];
												$message = $retour[1];
											}
											else
											{
												$message = 'Erreur lors de la saisie des caractères.';
											}
										}
										fclose($fp);
									}
									else{$message = 'Cette adresse mail est déjà associée à un compte.';}
								}
								else{$message = 'Votre adresse mail est erronée.';}
							}
							else{$message = 'La saisie du mot de passe est erronée.';}
						}
						else{$message = 'N\'oubliez pas de confirmer la saisie de votre mot de passe.';}
					}
					else{$message = 'La taille de votre mot de passe doit être comprise entre 8 et 64 caracteres.';}
				}
				else{$message = 'Ce pseudo est déjà associée à un compte.';}
			}
			else{$message = 'Le pseudo contient des caractères interdits. Caractères autorisés : minuscules, MAJUSCULES, chiffres et les tirets (exemple : Mon_Pseudo-23)';}
		}
		else{$message = 'La taille de votre pseudo doit être comprise entre 3 et 32 caractères.';}
		return retourMessage($message_erreur,$message);
	}

	/**
	* Fonction permettant de vérifier si le pseudo est valide ou non
	* @param string $pseudoVerif L'adresse mail entrée par l'utilisateur dans le formulaire.
	* @return boolean Un booléen qui dit si le pseudo est valide (true) ou non (false).
	* @deprecated Not used at this time
	*/
	public function verifierPseudo($pseudoVerif)
	{
		$Syntaxe='#^[\w_-]{3,32}$#';
		if(preg_match($Syntaxe,$pseudoVerif))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* Fonction permettant de vérifier si une adresse mail est valide ou non
	* @param string $adresse L'adresse mail entrée par l'utilisateur dans le formulaire.
	* @return boolean Un booléen qui dit si l'adresse est valide (true) ou non (false).
	* @deprecated Not used at this time
	*/
	public function verifierAdresseMail($adresse)
	{
		$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
		if(preg_match($Syntaxe,$adresse))
		{
			return true;
		}
		else
		{
			return false;
		}
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