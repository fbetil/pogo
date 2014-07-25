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
{block name="title"}{lang('app_name')} - {lang('projectactor_view_a_1')}{/block}
{block name="page"}
	<!-- Project details -->
	<section id="project" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('projectactor_view_h_1')}</p>
		<p><b>{lang('projectactor_view_p_6')} :</b> <span class="inbl"><span class="progressbar_holder" title="{sprintf(lang('projectactor_view_p_7'), $project->getProgress(), $project->getProgressScore()|number_format:2)}"><span class="progressbar {$project->getProgressScore()|score_project}" style="width: {$project->getProgress()}%"></span></span></span>
		<p><b>{lang('projectactor_view_p_1')}: </b>{$project->getCode()}</p>
		<p><b>{lang('projectactor_view_p_2')}: </b>{$project->getName()}</p>
		<p><b>{lang('projectactor_view_p_3')}: </b><br>{$project->getDescription()|nl2br}</p>
	</section>

	<!-- Actor -->
	<section id="actor" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_script"></i>{lang('projectactor_view_h_2')}
			{if isset($user_roles['ProjectActorEditor']) && !$projectactor->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="ajax('/projectactor/delete/{$projectactor->getId()}', '{$url_index}/project/view/{$project->getId()}');" title="{lang('projectactor_view_a_2')}"><i class="fam fam_user_delete"></i></a>{/if}
			{if isset($user_roles['ProjectActorEditor']) && !$projectactor->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="eipStart('projectactor')" title="{lang('projectactor_view_a_1')}"><i class="fam fam_pencil"></i></a>{/if}
		</p>
		<div data-eip-name="projectactor" data-eip-url="{$url_index}/projectactor/post" data-eip-label="{lang('projectactor_add_a_1')}" >
			<span data-eip-field-name="Id" data-eip-field-type="hidden" data-eip-field-value="{$projectactor->getId()}"></span>
			<span data-eip-field-name="ProjectId" data-eip-field-type="hidden" data-eip-field-value="{$project->getId()}"></span>
			<p><b>{lang('projectactor_view_p_4')} : </b>
				<span data-eip-field-name="ActorId" data-eip-field-type="select" data-eip-field-value="{$projectactor->getActorId()}" data-eip-field-class="required" data-eip-field-options="{$actors|escape}">{if !$projectactor->isNew()}{$projectactor->getActor()->getFirstName()} {$projectactor->getActor()->getName()}{/if}</span>
			</p>
			<p><b>{lang('projectactor_view_p_5')} : </b>
				<span data-eip-field-name="Role" data-eip-field-value="{$projectactor->getRole()}" data-eip-field-class="required">{$projectactor->getRole()}</span>
			</p>
		    <span data-eip-field-name="csrf_test_name" data-eip-field-type="hidden" data-eip-field-value="{$csrf_hash}"></span>
	</section>

	{if $projectactor->isNew()}
		<script>
			/*Start eip*/
			$(document).ready(function() { eipStart('projectactor', '{$url_index}/project/view/{$project->getId()}', '{$url_index}/project/view/{$project->getId()}'); });
		</script>
	{/if}
{/block}
{/strip}