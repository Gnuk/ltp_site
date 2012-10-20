<?php
	use \gnk\config\Page;
	use \gnk\config\Form;
	function sendmail($to, $from_user, $from_email, $subject = '(No subject)', $message = '', $contentType='plain')
	{ 
		$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
		$subject = "=?UTF-8?B?".base64_encode($subject)."?=";

		$headers = "From: $from_user <$from_email>\r\n". 
				"MIME-Version: 1.0" . "\r\n" . 
				"Content-type: text/$contentType; charset=UTF-8" . "\r\n"; 

		return mail($to, $subject, $message, $headers); 
	}
	if(!empty($_GET) AND isset($_GET['mail']) AND $_GET['mail'] == 'send'){
		$message = array();
		if(empty($_POST['formFrom']) OR !Form::isMail($_POST['formFrom'])){
			$message[] = T_('Votre adresse est mal formée');
		}
		else if(empty($_POST['formTo']) OR !Form::isMail($_POST['formTo'])){
			$message[] = T_('L\'adresse du destinataire est mal formée');
		}
		else if(empty($_POST['formSubject'])){
			$message[] = T_('Le sujet n\'existe pas');
		}
		else if(empty($_POST['formMessage'])){
			$message[] = T_('Le message n\'existe pas');
		}
		else{
			sendmail($_POST['formTo'], 'Serveur LTP', $_POST['formFrom'], $_POST['formSubject'], $_POST['formMessage']);
			$message[] = T_('Message envoyé');
		}
	}
?>
<html>
	<head>
		<title><?php echo T_('Envoyer un mail') ;?></title>
	</head>
	<body>
		<header>
			<h1><?php echo T_('Envoyer un mail') ;?></h1>
<?php
	if(!empty($message) AND (count($message) > 0)){
		foreach($message AS $nMessage => $warning){
?>
			<p><?php echo htmlspecialchars($warning, ENT_QUOTES);?></p>
<?php
		}
	}
?>
		</header>
		<div id="corps">
			<form action="<?php echo Page::getLink(array('mail'=>'send')) ?>" method="post">
				<p>
					<label for="formFrom"><?php echo T_('De : ') ;?></label>
					<input id="formFrom" name="formFrom" type="mail" value="gnuk.server@mailoo.org"/>
				</p>
				<p>
					<label for="formTo" ><?php echo T_('À : ') ;?></label>
					<input id="formTo" name="formTo" type="mail"/>
				</p>
				<p>
					<label for="formSubject"><?php echo T_('Sujet : ') ;?></label>
					<input id="formSubject" name="formSubject" type="text" value="Message serveur"/>
				</p>
				<p>
					<label for="formMessage"><?php echo T_('Message') ;?></label>
					<textarea id="formMessage" name="formMessage"></textarea>
				</p>
				<p>
					<input type="submit" value="<?php echo T_('Envoyer') ?>"/>
				</p>
			</form>
		</div>
		<footer>
			<p></p>
		</footer>
	</body>
</html>