<?php

/**
 * -------------------------------------------------------------------------------
 * PoGo - Organize and Manage your Projects like a Chief
 * Copyright (c) 2014 by Florian BETIL <fbetil@gmail.com>
 *
 * This file is part of PoGo.
 *
 * PoGo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PoGo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PoGo.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Authors:
 *
 * Florian BETIL : <fbetil@gmail.com>
 * -------------------------------------------------------------------------------
 */

if ( ! defined("BASEPATH")) exit("No direct script access allowed");

// Application
$lang["app_name"] = "PoGo";
$lang["app_title"] = "PoGo::projects\n\nOrganisez et gérez vos projets comme un chef !";

// Globals
$lang['january'] = "Janvier";
$lang['february'] = "Février";
$lang['march'] = "Mars";
$lang['april'] = "Avril";
$lang['may'] = "Mai";
$lang['june'] = "Juin";
$lang['july'] = "Juillet";
$lang['august'] = "Août";
$lang['september'] = "Septembre";
$lang['october'] = "Octobre";
$lang['november'] = "Novembre";
$lang['december'] = "Décembre";
$lang['monday_short'] = "Lu";
$lang['tuesday_short'] = "Ma";
$lang['wednesday_short'] = "Me";
$lang['thursday_short'] = "Je";
$lang['friday_short'] = "Ve";
$lang['saturday_short'] = "Sa";
$lang['sunday_short'] = "Di";

$lang["goback"] = "Revenir";
$lang['wait'] = "Merci de patienter...";
$lang['modification_in_progress'] = "Modification de \"%s\"";
$lang['creation_in_progress'] = "Création de \"%s\"";
$lang['valid'] = "Valider";
$lang['cancel'] = "Annuler";
$lang['identifier'] = "Identifiant";

// Header, breadcrumb, footer
$lang["app_footer_1"] = "© 2014 Florian BETIL";
$lang["app_footer_2"] = "page générée en %s secondes - %s Mio";

$lang["app_nav_1"] = "Tableau de bord";
$lang["app_nav_2"] = "Projets";

$lang["app_menu_1"] = "Revenir";

//Dashboard
$lang["dashboard_home_title"] = "Tableau de bord";

$lang["dashboard_home_h_1"] = "Tableau de bord";
$lang["dashboard_home_h_2"] = "Projets";
$lang["dashboard_home_h_3"] = "Gestion";
$lang["dashboard_home_h_4"] = "Administration";

$lang["dashboard_home_p_1"] = "Bienvenue dans votre espace de travail";

//Core
$lang["core_mailgate_p_1"] = "PoGo: Erreur d'intégration email";
$lang["core_mailgate_p_2"] = "Vous n'êtes pas enregistré sur PoGo.";
$lang["core_mailgate_p_3"] = "Vous ne disposez pas du droit d'édition des notes.";
$lang["core_mailgate_p_4"] = "Votre message ne contient pas de code projet.";
$lang["core_mailgate_p_5"] = "Vous n'êtes pas associé au projet %s.";
$lang["core_mailgate_p_6"] = "PoGo: Nouvelle note créée";
$lang["core_mailgate_p_7"] = "Votre note vient d'être ajoutée au projet %s.<br><br>Voir la note: %s";
$lang["core_mailgate_p_8"] = "Vous ne disposez pas du droit d'édition des fichiers joints.";
$lang["core_mailgate_p_9"] = "Importés";
$lang["core_mailgate_p_10"] = "Votre fichier vient d'être ajouté au projet %s.<br><br>Voir le fichier: %s";
$lang["core_mailgate_p_11"] = "PoGo: Nouveau fichier créé";

//Project
$lang["project_view_h_1"] = "Projet";
$lang["project_view_h_2"] = "Planning";
$lang["project_view_h_3"] = "Fichiers";
$lang["project_view_h_4"] = "Acteurs";
$lang["project_view_h_5"] = "Jalons";
$lang["project_view_h_6"] = "Tâches";
$lang["project_view_h_7"] = "Notes";

$lang["project_view_a_1"] = "Afficher en plein écran";
$lang["project_view_a_2"] = "Télécharger";
$lang["project_view_a_3"] = "Clôturer";
$lang["project_view_a_4"] = "Ajouter";
$lang["project_view_a_5"] = "Note du %s";
$lang["project_view_a_6"] = "Fichier du %s";
$lang["project_view_a_7"] = "Supprimer";
$lang["project_view_a_8"] = "Modifier";

$lang["project_view_p_1"] = "Aucun enregistrement";
$lang["project_view_p_2"] = "Nom";
$lang["project_view_p_3"] = "Description";
$lang["project_view_p_4"] = "Code";

$lang["project_view_p_5"] = "Vous pouvez ajouter automatiquement une note\nen adressant un email contenant\nle code '%s' à l'adresse '%s'.";
$lang["project_view_p_6"] = "Vous pouvez ajouter un fichier dans un dossier\nen le déposant sur le nom du dossier.\n\nVous pouvez également ajouter des fichiers\nen adressant un email contenant des pièces-jointes et\nle code '%s' à l'adresse '%s'.";

$lang["project_view_p_7"] = "Racine";

//File
$lang["file_view_h_1"] = "Projet";
$lang["file_view_h_2"] = "Fichier";
$lang["file_view_h_3"] = "Aperçu";

$lang["file_view_p_1"] = "Code";
$lang["file_view_p_2"] = "Nom";
$lang["file_view_p_3"] = "Description";
$lang["file_view_p_4"] = "Nom";
$lang["file_view_p_5"] = "Taille";
$lang["file_view_p_6"] = "Version";
$lang["file_view_p_7"] = "Auteur";
$lang["file_view_p_8"] = "Dossier";

$lang["file_view_a_1"] = "Modifier";

$lang["file_upload_p_1"] = "Projet";
$lang["file_upload_p_2"] = "Dossier";

//Task
$lang["task_view_h_1"] = "Projet";
$lang["task_view_h_2"] = "Tâche";
$lang["task_view_h_3"] = "Acteurs";

$lang["task_view_p_1"] = "Code";
$lang["task_view_p_2"] = "Nom";
$lang["task_view_p_3"] = "Description";
$lang["task_view_p_4"] = "Nom";
$lang["task_view_p_5"] = "Description";
$lang["task_view_p_6"] = "Début";
$lang["task_view_p_7"] = "Cible";
$lang["task_view_p_8"] = "Progression";
$lang["task_view_p_9"] = "Aucun enregistrement";

$lang["task_view_a_1"] = "Modifier";

$lang["task_add_a_1"] = "Nouvelle tâche";

$lang["task_add_p_1"] = "Nouvelle tâche";

//Milestone
$lang["milestone_view_h_1"] = "Projet";
$lang["milestone_view_h_2"] = "Jalon";

$lang["milestone_view_p_1"] = "Code";
$lang["milestone_view_p_2"] = "Nom";
$lang["milestone_view_p_3"] = "Description";
$lang["milestone_view_p_4"] = "Nom";
$lang["milestone_view_p_5"] = "Description";
$lang["milestone_view_p_6"] = "Cible";

$lang["milestone_view_a_1"] = "Modifier";

$lang["milestone_add_a_1"] = "Nouveau jalon";

$lang["milestone_add_p_1"] = "Nouveau jalon";

//Note
$lang["note_view_h_1"] = "Projet";
$lang["note_view_h_2"] = "Note";

$lang["note_view_p_1"] = "Code";
$lang["note_view_p_2"] = "Nom";
$lang["note_view_p_3"] = "Description";
$lang["note_view_p_4"] = "Nom";
$lang["note_view_p_5"] = "Publiée";
$lang["note_view_p_6"] = "Auteur";
$lang["note_view_p_7"] = "Contenu";

$lang["note_view_a_1"] = "Modifier";

$lang["note_add_a_1"] = "Nouvelle note";

$lang["note_add_p_1"] = "Nouvelle note";

//Errors
$lang["error_processing_json"] = "Erreur d'interprétation de la chaîne JSON.";
$lang["error_not_allowed"] = "Vous n'êtes pas autorisé à accéder à cette page.";
$lang["error_unable_to_execute"] = "Impossible d'exécuter l'action demandée.";
$lang["error_sql"] = "Erreur de traitement SQL.";
