{*

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
 
*}

{extends file="layout.php"}
{strip}
{block name="title"}{lang('app_name')} - {lang('dashboard_home_title')}{/block}
{block name="page"}
	<!-- Welcome -->
	<section id="welcome" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_application_view_tile"></i>{lang('dashboard_home_h_1')}</p>
		<p>{lang('dashboard_home_p_1')}</p>
	</section>

	<!-- Projects -->
	<section id="projects" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('dashboard_home_h_2')}</p>
		<ul class="unstyled">
		{foreach from=$projects item=project}
			<li class="pointer list" onclick="window.location.href = '{$url_index}/project/view/{$project->getId()}'">[{$project->getCode()}] <div class="mls inbl"><i>{$project->getName()}</i></div><div class="inbl list_actions right"></div></li>
		{/foreach}
		</ul>
	</section>

	<!-- Manage -->
	<section id="manage" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_color_swatch"></i>{lang('dashboard_home_h_3')}</p>
	</section>

	<!-- Administration -->
	<section id="administration" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_plugin"></i>{lang('dashboard_home_h_4')}</p>
	</section>
{/block}
{/strip}