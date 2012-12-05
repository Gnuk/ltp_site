# Documentation REST

## Introduction

## Authentification

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
				"lat" : "24.242424",
				"lon" : "2.4",
				"content" : "Je suis maintenant là.",
				"time":"2012-11-17T18:26:00+01:00"
			}
			,
			{
				"lat" : "42.424242",
				"lon" : "4.2",
				"content" : "Je suis ici.",
				"time":"2012-11-16T15:13:14+01:00"
			}
		]
	}
}
~~~~~~~~~~~~~

##### XML

### Nouveau statut

* **URL** /api/1/statuses
* **Méthode** POST
* **Return**
 * 200 OK & list
 * 204 No Content
 * 403 Forbidden
 * 404 Not Found

#### Exemple

##### JSON

Non implémenté pour le moment

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"Client LTP",
		"status":
		{
			"lat" : "24.242424",
			"lon" : "2.4",
			"content" : "Mon nouveau statut."
		}
	}
}
~~~~~~~~~~~~~

##### XML

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

Non implémenté pour le moment

~~~~~~~~~~~~~{.json}
{
	"ltp":
	{
		"application":"LocalizeTeaPot server",
		"friends":
		[
			{
				"username":"Gnuk",
				"lat" : "24.242424",
				"lon" : "2.4",
				"content" : "Je suis maintenant là.",
				"time":"2012-11-17T18:26:00+01:00"
			}
			,
			{
				"username":"Giu",
				"lat" : "42.424242",
				"lon" : "4.2",
				"content" : "Je suis ici.",
				"time":"2012-11-16T15:13:14+01:00"
			}
		]
	}
}
~~~~~~~~~~~~~

##### XML


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

##### XML

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

##### XML

## La gestion de l'utilisateur

### Récupération de l'utilisateur

* **URL** /api/1/user/
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

##### XML

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

##### XML