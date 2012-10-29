# LocalizeTeaPot Website

## Introduction

Le site LocalizeTeaPot utilise le Framework GNK Website et les fonctionnalités sont développées par Open Team Map.

## Le Framework GNK Website

Le Framework GNK Website est inclus dans LocalizeTeaPot et permet d'utiliser facilement des bibliothèques. Il utilise d'ailleurs nativement Gettext et Doctrine2.

## Bibliothèques

### Gettext

Gettext est une bibliothèque libre permettant de traduire du texte dans différente langues.

#### Fonctionnement

##### Dans le php

* Tous les textes doivent s'écrire de la forme T_('Mon texte') pour pouvoir être traduits.
* Pour les termes ou expressions contenant un pluriel dépendant d'une variable, on utilise T_ngettext :
 * Cas particulier: inclusion d'une variable. Pour inclure une variable dans T_ngettext, on utilise sprintf puisque la variable ne peut être passée en paramètre de traduction.

~~~~~~~~~~~~~{.php}
sprintf(T_ngettext('%d élément', '%d éléments', $numberElements), $numberElements);
~~~~~~~~~~~~~

* Les traductions des textes (utilisant la fonction T_ et T_ngettext) se font dans des fichiers po puis sont compilés en mo

##### Les fichiers mo et po

* Après avoir codé en prenant en compte gettext, il s'agit maintenant de générer des fichiers pour la traduction
* Pour ce site, les fichiers en question sont dans le dossier locale/<identifiantLocale>/LC_MESSAGES/
* Leurs noms sont messages.mo et messages.po
* Les po sont des fichiers textes contenant les traductions et les mo sont les fichiers compilés des po

##### Poedit

* Veuillez installer Poedit (http://www.poedit.net/)
* Veuillez préciser dans les configurations de Poedit de compiler (Poedit->Edition->Préférences->Éditeur [x] Compiler automatiquement les fichiers .mo lors de l'enregistrement)
* Si le po de votre langue existe, vous pouvez le modifier en ajoutant des modifications avec Poedit
 * Ouvrir le fichier po avec Poedit
 * Mettre à jour la base de langues
 * Traduire
 * Enregistrer
* Si le po de votre langue n'existe pas, veuillez créer, dans le dossier locale, un dossier comprenant l'identifiant de votre Locale (vous pouvez connaître le dossier à créer en utilisant la méthode Config::showLocale())
 * Créer ensuite un dossier LC_MESSAGES
 * Ouvrir Poedit->Fichier->Nouveau catalogue depuis un fichier POT…
 * Sélectionner le fichier locale/default/pot/messages.pot
 * Indiquer éventuellement l'équipe de traduction
 * Ajouter la forme plurielle correspondante à votre langue (http://translate.sourceforge.net/wiki/l10n/pluralforms) sans oublier le ; à la fin (il n'y est pas dans la page)
 * Enregistrer le fichier avec le nom messages.po dans locale/<identifiantLocale>/LC_MESSAGES/
 * Traduire
 * Enregistrer
* Voila, vous pouvez maintenant voir vos textes traduits, pour tester une autre langue, vous pouvez utiliser ?lang=<identifiantLocale> pour tester

### Doctrine

Ce Framework, utilise Doctrine2 : http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/index.html

### Zebra Form

Zebra Form permet de créer des formulaires facilement, cependant sa version comportait quelques erreurs, elle a donc besoin d'un module et d'une retouche pour fonctionner, c'est pourquoi le module Form est disponnible pour palier au problème.

Plus d'informations sur Zerba Form : http://stefangabos.ro/php-libraries/zebra-form

### OpenLayers

#### À propos

OpenLayers permet de créer des cartes sous formes de calques. Son API permet d'interagir avec OpenStreetMap et ainsi afficher une carte Javascript OpenStreetMap.

#### Utilisation du module OSM

Voici un exemple d'utilisation du module OSM affichant une carte avec OpenLayers

~~~~~~~~~~~~~{.php}
use \gnk\config\Module;
use \gnk\modules\osm\Osm;
use \gnk\modules\osm\Marker;
# Chargement du module osm
Module::load('osm');
# Déclaration de la carte
$osm = new Osm('carte');
# Création du calque de marqueurs
$marker = new Marker('Mon calque de marqueurs');
# Ajout d'un marqueur (Le html en 3ème argument est facultatif)
# Ici :
# - Longitude = 4.2
# - Latitude = 42.42
$marker->add(4.2 ,42.24, '<h1>Ma Popup</h1>');
# Ajout du calque de marqueurs à la carte
$osm->addMarker($marker);
# Affichage de la zone de carte
$osm->showDiv();
# Affichage du script de la carte (Pour l'afficher dans la zone de carte)
$osm->showJS();
~~~~~~~~~~~~~