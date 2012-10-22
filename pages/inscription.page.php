<?php
	use \gnk\config\Module;
	use \gnk\config\Page;
	use \gnk\modules\form\Form;
	Module::load('form');

	$form = new Form('form');

    // the label for the "first name" element
    $form->add('label', 'label_login', 'login', T_('Identifiant : '));

    // add the "first name" element
    // the "&" symbol is there so that $obj will be a reference to the object in PHP 4
    // for PHP 5+ there is no need for it
    $obj = & $form->add('text', 'login');

    // set rules
    $obj->set_rule(array(

        // error messages will be sent to a variable called "error", usable in custom templates
        'required'  =>  array('error', T_('Vous devez préciser un identifiant.')),

    ));

    // "email"
    $form->add('label', 'label_email', 'email', T_('Adresse de messagerie électronique :'));
    $obj = & $form->add('text', 'email');
    $obj->set_rule(array(
        'required'  => array('error', T_('Veuillez entrer une adresse de messagerie électronique.')),
        'email'     => array('error', T_('Cette adresse est invalide.'))
    ));

    // attach a note to the email element
    $form->add('note', 'note_email', 'email', T_('Veuillez entrer une adresse de messagerie électronique, vous recevrez message électronique pour valider votre compte.'), array('style'=>'width:200px'));

    // "password"
    $form->add('label', 'label_password', 'password', T_('Mot de passe : '));
    $obj = & $form->add('password', 'password');
    $passFrom = 6;
    $passTo = 50;
    $obj->set_rule(array(
        'required'  => array('error', T_('Password is required!')),
        'length'    => array($passFrom, $passTo, 'error', sprintf(T_('Votre mot passe doit être composé de %d à %d caractères.'), $passFrom, $passTo)),
    ));
    $form->add('note', 'note_password', 'password', sprintf(T_('Votre mot passe doit être composé de %d à %d caractères.'), $passFrom, $passTo));

    // "confirm password"
    $form->add('label', 'label_confirm_password', 'confirm_password', T_('Confirmation de mot de passe :'));
    $obj = & $form->add('password', 'confirm_password');
    $obj->set_rule(array(
        'compare' => array('password', 'error', T_('Les mots de passes ne correspondent pas.'))
    ));

    // "captcha"
    $form->add('captcha', 'captcha_image', 'captcha_code');
    $form->add('label', 'label_captcha_code', 'captcha_code', T_('Êtes-vous un être humain ?'));
    $obj = & $form->add('text', 'captcha_code');
    $form->add('note', 'note_captcha', 'captcha_code', T_('Vous devez entrer les caractères de couleur noire'), array('style'=>'width: 200px'));
    $obj->set_rule(array(
        'captcha' => array('error', T_('Les caractères ne correspondent pas !'))
    ));

    // "submit"
    $form->add('submit', 'btnsubmit', T_('S\'enregistrer'));


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Zebra_Form Example</title>
        <script>window.jQuery || document.write('<script src="lib/jquery/jquery.min.js"><\/script>')</script>
<?php
	Page::showCSS();
	Page::showJS();
?>
    </head>
    <body>
<?php 
    if($form->validate()){
		echo "Formulaire valide, traitement DQL souhaité";
    }
    else{
		$form->render();
	}
?>
    </body>
</html>