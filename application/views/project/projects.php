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
{block name="title"}{lang('app_name')} - {lang('project_index_h_1')}{/block}
{block name="page"}
	<!-- Projects -->
	<section id="projects" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('project_index_h_2')}
			{if isset($user_roles['ProjectEditor'])}<a class="right mrs" href="{$url_index}/project/add" title="{lang('project_index_a_1')}"><i class="fam fam_add"></i></a>{/if}
			<a class="right mrs" href="javascript:void(0)" title="{lang('dashboard_home_p_7')}"><i class="fam fam_information"></i></a>
		</p>
		<ul class="unstyled">
		{foreach from=$projects item=project}
			<li class="pointer list" onclick="window.location.href = '{$url_index}/project/view/{$project->getId()}'">
				[{$project->getCode()}]
				<div class="mls inbl">{$project->getName()}</div>
				<div class="inbl right">
					<span class="progressbar_holder" title="{sprintf(lang('project_index_p_2'), $project->getProgress(), $project->getProgressScore()|number_format:2)}"><span class="progressbar {$project->getProgressScore()|score_project}" style="width: {$project->getProgress()}%"></span></span>
				</div>
				<div class="inbl list_actions right">
					{if isset($user_roles['ProjectEditor'])}<a href="javascript:void(0)" onclick="ajax('/project/delete/{$project->getId()}');" title="{lang('project_index_a_2')}"><i class="fam fam_delete"></i></a>{/if}
				</div>
			</li>
		{foreachelse}
			<li class="small"><i>{lang('project_index_p_1')}</i></li>
		{/foreach}
		</ul>
	</section>
{/block}
{/strip}