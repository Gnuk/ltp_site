<?php
	$params = array(
		'home' => array(
			'title' => T_('Accueil'),
			'rights' => 0
		),
		'inscription' => array(
			'title' => T_('Inscription'),
			'rights' => -3
		),
		'forgetpassword' => array(
			'title' => T_('Mot de passe oublié ?'),
			'rights' => -3
		),
		'friends' => array(
			'title' => T_('Amis'),
			'rights' => 3,
			'menu' => array(
				'myfriends' => array(
					'title' => T_('Mes Amis'),
					'rights' => 3,
					'menu' => array(
						'newfriend' => array(
							'title' => T_('Nouvel Ami'),
							'rights' => 3
						)
					)
				),
				'yourfriends' => array(
					'title' => T_('Vos amis'),
					'rights' => 3,
				)
			)
		),
		'status' => array(
			'title' => T_('Statuts'),
			'rights' => 3
		)
	);
	
?>