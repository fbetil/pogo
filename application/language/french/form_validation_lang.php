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

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$lang['required']			= "Le champ \"%s\" est obligatoire.";
$lang['isset']				= "Le champ \"%s\" doit être renseigné.";
$lang['valid_email']		= "Le champ \"%s\" doit contenir une adresse email valide.";
$lang['valid_emails']		= "Le champ \"%s\" doit contenir des adresses emails valides.";
$lang['valid_url']			= "Le champ \"%s\" doit contenir une URL valide.";
$lang['valid_ip']			= "Le champ \"%s\" doit contenir une adresse IP valide.";
$lang['min_length']			= "Le champ \"%s\" doit contenir au moins %s caractères.";
$lang['max_length']			= "Le champ \"%s\" doit contenir au maximum %s caractères.";
$lang['exact_length']		= "Le champ \"%s\" doit contenir exactement %s caractères.";
$lang['alpha']				= "Le champ \"%s\" doit contenir uniquement des caractères alphabétiques.";
$lang['alpha_numeric']		= "Le champ \"%s\" doit contenir uniquement des caractères alpha-numériques.";
$lang['alpha_dash']			= "Le champ \"%s\" doit contenir uniquement des caractères alpha-numériques, underscores et tirets.";
$lang['numeric']			= "Le champ \"%s\" doit être numérique.";
$lang['is_numeric']			= "Le champ \"%s\" doit contenir uniquement des caractères numériques.";
$lang['integer']			= "Le champ \"%s\" doit être un nombre entier.";
$lang['regex_match']		= "Le champ \"%s\" ne correspond pas au format attendu.";
$lang['matches']			= "Le champ \"%s\" different du champ\"%s\".";
$lang['is_unique'] 			= "Le champ \"%s\" doit contenir une valeur unique.";
$lang['is_natural']			= "Le champ \"%s\" doit contenir une valeur positive.";
$lang['is_natural_no_zero']	= "Le champ \"%s\" doit contenir une valeur supérieure à 0.";
$lang['decimal']			= "Le champ \"%s\" doit contenir une valeur décimale.";
$lang['less_than']			= "Le champ \"%s\" doit contenir une valeur inférieure à %s.";
$lang['greater_than']		= "Le champ \"%s\" doit contenir une valeur supérieure à %s.";
$lang['json_check']			= "Le champ \"%s\" ne contient pas une chaine JSON correctement formatée.";
$lang['cron_check']			= "Le champ \"%s\" ne contient pas une planification correcte.";
$lang['alpha_extended_check']	= "Le champ \"%s\" doit contenir uniquement des caractères alphabétiques, tirets, apostrophes et espaces.";
$lang['alpha_extended2_check']	= "Le champ \"%s\" doit contenir uniquement des caractères alphabétiques et underscores.";
$lang['date_check']			= "Le champ \"%s\" doit contenir une date au format 'dd/mm/aaaa'.";
$lang['dategreaterthan_check']	= "La date \"%s\" doit être supérieure à \"%s\".";
$lang['projectcode_check']	= "Le code de project \"%s\" ne correspond pas au format 'POGO.YYMM.WXYZ'.";
$lang['isunique_projectcode_check']	= "Le code de project \"%s\" est déjà utilisé par un autre projet.";
