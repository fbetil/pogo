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
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('dashboard_home_h_2')}
			{if isset($user_roles['ProjectEditor'])}<a class="right mrs" href="{$url_index}/project/add" title="{lang('dashboard_home_a_1')}"><i class="fam fam_add"></i></a>{/if}
			<a class="right mrs" href="javascript:void(0)" title="{lang('dashboard_home_p_7')}"><i class="fam fam_information"></i></a>
		</p>
		<ul class="unstyled">
		{foreach from=$projects item=project}
			<li class="pointer list" onclick="window.location.href = '{$url_index}/project/view/{$project->getId()}'">
				[{$project->getCode()}]
				<div class="mls inbl">{$project->getName()}</div>
				<div class="inbl right">
					<span class="progressbar_holder" title="{sprintf(lang('dashboard_home_p_4'), $project->getProgress(), {$project->getProgressScore()|number_format:2})}"><span class="progressbar {$project->getProgressScore()|score_project}" style="width: {$project->getProgress()}%"></span></span>
				</div>
				<div class="inbl list_actions right">
					{if isset($user_roles['ProjectEditor'])}<a href="javascript:void(0)" onclick="ajax('/project/delete/{$project->getId()}');" title="{lang('dashboard_home_a_2')}"><i class="fam fam_delete"></i></a>{/if}
				</div>
			</li>
		{foreachelse}
			<li class="small"><i>{lang('dashboard_home_p_2')}</i></li>
		{/foreach}
		</ul>
		{if !empty($projects)}
		<p>{sprintf(lang('dashboard_home_p_3'), "{$url_index}/project")}</p>
		{/if}
	</section>

	<!-- Tasks -->
	{if isset($user_roles['TaskViewer'])}
	<section id="tasks" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_script"></i>{lang('dashboard_home_h_5')}
			<a class="right mrs" href="javascript:void(0)" title="{lang('dashboard_home_p_6')}"><i class="fam fam_information"></i></a>
		</p>
		<ul class="unstyled">
		{foreach from=$tasks item=task}
			<li class="pointer list" title="{$task->getProject()->getName()|escape}{"\n"}{"\n"}{foreach from=$task->getTaskActors() item=taskactor}{$taskactor->getActor()->getFirstName()} {$taskactor->getActor()->getName()}{"\n"}{/foreach}{"\n"}{$task->getDescription()}" onclick="window.location.href = '{$url_index}/task/view/{$task->getId()}'">
				[{$task->getStartDate('d/m/Y')} -> {$task->getDueDate('d/m/Y')}]
				<div class="mls inbl">{$task->getName()}</div>
				<div class="inbl right">
					<span class="progressbar_holder" title="{sprintf(lang('dashboard_home_p_5'), $task->getProgress(), $task->getProgressScore()|number_format:2)}"><span class="progressbar {$task->getProgressScore()|score_task}" style="width: {$task->getProgress()}%"></span></span>
				</div>
				<div class="inbl list_actions right">
					{if isset($user_roles['TaskEditor'])}<a href="javascript:void(0)" onclick="ajax('/task/close/{$task->getId()}');" title="{lang('dashboard_home_a_3')}"><i class="fam fam_script_go"></i></a>{/if}
				</div>
			</li>
		{foreachelse}
			<li class="small"><i>{lang('project_view_p_1')}</i></li>
		{/foreach}
		</ul>
	</section>
	{/if}

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

