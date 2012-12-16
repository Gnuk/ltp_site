# Documentation REST

## Introduction

LocalizeTeaPot est une application permettant à ses usagers de renseigner leur position ainsi que de récupérer celles
de leurs amis. 

L'application propose une API REST pour la communication entre le client et le serveur dont voici les fonctionnalitées :

## Authentification

Pour s'authentifier, l'API utilise les méthodes d'authentifications HHTP.

* Lorsque l'authentification échoue, une erreur 403 est envoyée. 
* Losrque aucune authentification n'est effectuée, une erreur 404 est envoyée.

## Liste des sites implémentant l'API

* LocalizeTeaPot Serveur
 * URL de l'api : https://jibiki.univ-savoie.fr/ltpdev/rest.php

## Les statuts

### Récupération

* **URL** /api/1/statuses
* **Méthode** GET
* **Return**
 * 200 OK & list
 * 204 No Content
 * 403 Forbidden
 * 404 Not Found

#### Exemple

##### JSON

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"LocalizeTeaPot server",
		"statuses":
		[
			{
				"lon" : "24.242424",
				"lat" : "2.4",
				"content" : "Je suis maintenant là.",
				"time":"2012-11-17T18:26:00+01:00"
			}
			,
			{
				"lon" : "42.424242",
				"lat" : "4.2",
				"content" : "Je suis ici.",
				"time":"2012-11-16T15:13:14+01:00"
			}
		]
	}
}
~~~~~~~~~~~~~

##### Exemple d'utilisation

    curl --user Utilisateur https://jibiki.univ-savoie.fr/ltpdev/rest.php/api/1/statuses

### Nouveau statut

* **URL** /api/1/statuses
* **Méthode** POST
* **Return**
 * 200 OK
 * 400 Bad Request
 * 403 Forbidden
 * 404 Not Found

#### Exemple

##### JSON

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"status":
		{
			"lon" : "2.4",
			"lat" : "24.242424",
			"content" : "Mon nouveau statut."
		}
	}
}
~~~~~~~~~~~~~

##### Exemple d'utilisation

    curl --user Utilisateur https://jibiki.univ-savoie.fr/ltpdev/rest.php/api/1/statuses -X POST -d '{"ltp":{"application":"Client LTP","status":{"lon" : "2.4","lat" : "24.242424","content" : "Mon nouveau statut."}}}'

## Le tracker

### Nouvelle position

* **URL** /api/1/track
* **Méthode** PUT
* **Return**
 * 200 OK
 * 400 Bad Request
 * 403 Forbidden
 * 404 Not Found

#### Exemple

##### JSON

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"track":
		{
			"lon" : "2.4",
			"lat" : "24.242424"
		}
	}
}
~~~~~~~~~~~~~

##### Exemple d'utilisation

    curl --user Utilisateur https://jibiki.univ-savoie.fr/ltpdev/rest.php/api/1/track -X POST -d '{"ltp":{"application":"Client LTP","track":{"lon" : "2.4","lat" : "24.242424"}}}'

## Les Amis

### Récupération

* **URL** /api/1/friends
* **Méthode** GET
* **Return**
 * 200 OK & liste
 * 403 Forbidden
 * 404 Not Found

#### Exemple

##### JSON

En cours d'implémentation

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"LocalizeTeaPot server",
		"friends":
		[
			{
				"username":"Gnuk",
				"lon" : "2.4",
				"lat" : "24.242424",
				"content" : "Je suis maintenant là.",
				"time":"2012-11-17T18:26:00+01:00"
			}
			,
			{
				"username":"Giu",
				"lon" : "4.2",
				"lat" : "42.424242",
				"time":"2012-12-13T17:12:00+01:00"
			}
			,
			{
				"username":"James"
			}
		]
	}
}
~~~~~~~~~~~~~

    curl --user Utilisateur https://jibiki.univ-savoie.fr/ltpdev/rest.php/api/1/friends

### Demande d'amis

* **URL** /api/1/friends/want
* **Méthode** POST

#### Exemple

##### JSON

Non implémenté pour le moment

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"mail": "gnuk@mail.org"
	}
}
~~~~~~~~~~~~~

Ou

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"username": "Gnuk"
	}
}
~~~~~~~~~~~~~

### Autoriser à me voir

* **URL** /api/1/friends/seeme
* **Méthode** POST

#### Exemple

##### JSON

Non implémenté pour le moment

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"mail": "james@mail.org"
	}
}
~~~~~~~~~~~~~

Ou

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"username": "James"
	}
}
~~~~~~~~~~~~~

## La gestion de l'utilisateur

### Récupération de l'utilisateur

* **URL** /api/1/user
* **Méthode** GET
* **Return**
 * 200 OK & liste
 * 403 Forbidden
 * 404 Not Found

#### Exemple

##### JSON

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"LocalizeTeaPot server",
		"profile":
		{
			"username" : "Gnuk",
			"mail" : "gnuk@mail.org",
			"language" : "fr"
		}
	}
}
~~~~~~~~~~~~~

##### Exemple d'utilisation

    curl --user Utilisateur https://jibiki.univ-savoie.fr/ltpdev/rest.php/api/1/user

### Inscription

* **URL** /api/1/user
* **Méthode** POST

#### Exemple

##### JSON

Non implémenté pour le moment

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"profile":
		{
			"username" : "Gnuk",
			"password" : "monmotdepasse",
			"mail" : "gnuk@mail.org",
			"language" : "fr"
		}
	}
}
~~~~~~~~~~~~~
