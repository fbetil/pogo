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
{block name="title"}{lang('app_name')} - {$task->getName()}{/block}
{block name="page"}
	<!-- Project details -->
	<section id="project" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('task_view_h_1')}</p>
		<p><b>{lang('task_view_p_11')} :</b> <span class="inbl"><span class="progressbar_holder" title="{sprintf(lang('task_view_p_12'), $project->getProgress(), $project->getProgressScore()|number_format:2)}"><span class="progressbar {$project->getProgressScore()|score_project}" style="width: {$project->getProgress()}%"></span></span></span>
		<p><b>{lang('task_view_p_1')}: </b>{$project->getCode()}</p>
		<p><b>{lang('task_view_p_2')}: </b>{$project->getName()}</p>
		<p><b>{lang('task_view_p_3')}: </b><br>{$project->getDescription()|nl2br}</p>
	</section>

	<!-- Task details -->
	<section id="task" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_script"></i>{lang('task_view_h_2')}
			{if isset($user_roles['TaskEditor']) && !$task->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="ajax('/task/delete/{$task->getId()}', '{$url_index}/project/view/{$project->getId()}');" title="{lang('task_view_a_2')}"><i class="fam fam_script_delete"></i></a>{/if}
			{if isset($user_roles['TaskEditor']) && !$task->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="ajax('/task/close/{$task->getId()}', '{$url_index}/project/view/{$project->getId()}');" title="{lang('task_view_a_3')}"><i class="fam fam_script_go"></i></a>{/if}
			{if isset($user_roles['TaskEditor']) && !$task->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="eipStart('task')" title="{lang('task_view_a_1')}"><i class="fam fam_pencil"></i></a>{/if}
		</p>
		<div data-eip-name="task" data-eip-url="{$url_index}/task/post" data-eip-label="{if $task->isNew()}{sprintf(lang('creation_in_progress'), lang('task_add_p_1'))|escape}{else}{sprintf(lang('modification_in_progress'), $task->getName())|escape}{/if}" >
			<span data-eip-field-name="Id" data-eip-field-type="hidden" data-eip-field-value="{$task->getId()}"></span>
			<span data-eip-field-name="ProjectId" data-eip-field-type="hidden" data-eip-field-value="{$project->getId()}"></span>
			<p><b>{lang('task_view_p_8')} : </b>
				<span data-eip-field-name="Progress" data-eip-field-value="{$task->getProgress()}" data-eip-field-class="required">
					<span class="inbl"><span class="progressbar_holder" title="{sprintf(lang('task_view_p_13'), $task->getProgress(), "{if !$task->isNew()}{$task->getProgressScore()|number_format:2}{else}0{/if}")}"><span class="progressbar {if !$task->isNew()}{$task->getProgressScore()|score_task}{else}{0|score_task}{/if}" style="width: {$task->getProgress()}%"></span></span></span>
				</span>
			</p>
			<p><b>{lang('task_view_p_4')} : </b>
				<span data-eip-field-name="Name" data-eip-field-value="{$task->getName()|escape}" data-eip-field-class="required">{$task->getName()}</span>
			</p>
			<p><b>{lang('task_view_p_5')} : </b>
				<span data-eip-field-name="Description" data-eip-field-type="textarea" data-eip-field-value="{$task->getDescription()|escape}" data-eip-field-class="required"><br>{$task->getDescription()|nl2br}</span>
			</p>
			<p><b>{lang('task_view_p_6')} : </b>
				<span data-eip-field-name="StartDate" data-eip-field-type="date" data-eip-field-value="{$task->getStartDate('d/m/Y')}" data-eip-field-class="required">{$task->getStartDate('d/m/Y')}</span>
			</p>
			<p><b>{lang('task_view_p_7')} : </b>
				<span data-eip-field-name="DueDate" data-eip-field-type="date" data-eip-field-value="{$task->getDueDate('d/m/Y')}" data-eip-field-class="required">{$task->getDueDate('d/m/Y')}</span>
			</p>
			<p><b>{lang('task_view_p_10')} : </b>
				<span data-eip-field-name="Actors" data-eip-field-type="multiselect" data-eip-field-options="{$taskactorsall|escape}" data-eip-field-value="{$taskactors|escape}" >{$taskactorsnames}</span>
			</p>
		    <span data-eip-field-name="csrf_test_name" data-eip-field-type="hidden" data-eip-field-value="{$csrf_hash}"></span>
	</section>

	{if $task->isNew()}
		<script>
			/*Start eip*/
			$(document).ready(function() { eipStart('task', '{$url_index}/task/view/$id', '{$url_index}/project/view/{$project->getId()}'); });
		</script>
	{/if}
{/block}
{/strip}