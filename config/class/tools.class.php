<?php
	namespace gnk\config;
	/**
	* Divers outils utilitaires
	* @author Anthony REY <anthony.rey@mailoo.org>
	* @since 23/10/2012
	*/
	class Tools{
		private static $mail = array();
		/**
		* Envoi d'un mail
		* @param string $to Le destinataire
		* @param string $subject Le sujet
		* @param string $message Le message
		* @param string $from_user Le nom de l'envoyeur
		* @param string $from_email L'adresse de messagerie de l'envoyeur
		* @param string $contentType Le type du mail
		*/
		public static function sendmail($to, $subject = '(No subject)', $message = '', $from_user=null, $from_email=null, $contentType='plain')
		{
			if(isset($from_user) AND isset($from_email)){
				self::$mail['sender_name'] = $from_user;
				self::$mail['sender_mail'] = $from_email;
			}
			$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
			if(isset(self::$mail['sender_name']) AND isset(self::$mail['sender_mail'])){
				$from_user = '=?UTF-8?B?'.base64_encode($from_user).'?=';
				$headers = 'From: =?UTF-8?B?'.base64_encode(self::$mail['sender_name']).'?= <'.self::$mail['sender_mail'].'>'."\r\n". 
						'MIME-Version: 1.0' . "\r\n" . 
						'Content-type: text/'.$contentType.'; charset="UTF-8"' . "\r\n"; 
				return mail($to, $subject, $message, $headers);
			}
			return mail($to, $subject, $message);

		}
		
		/**
		* Indique l'envoyeur par défaut
		* @param string $name Son nom
		* @param string $mail Son adresse mail
		*/
		public static function setMailDefaultSender($name, $mail){
			self::$mail['sender_name'] = $name;
			self::$mail['sender_mail'] = $mail;
		}
	}
?>