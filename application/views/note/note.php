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
{block name="title"}{lang('app_name')} - {$note->getName()}{/block}
{block name="page"}
	<!-- Project details -->
	<section id="project" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('note_view_h_1')}</p>
		<p><b>{lang('note_view_p_1')}: </b>{$project->getCode()}</p>
		<p><b>{lang('note_view_p_2')}: </b>{$project->getName()}</p>
		<p><b>{lang('note_view_p_3')}: </b><br>{$project->getDescription()|nl2br}</p>
	</section>

	<!-- Note details -->
	<section id="note" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_note"></i>{lang('note_view_h_2')}
			{if isset($user_roles['NoteEditor'])}<a class="right mrs" href="javascript:void(0)" onclick="eipStart('note')" title="{lang('note_view_a_1')}"><i class="fam fam_pencil"></i></a>{/if}
		</p>
		<div data-eip-name="note" data-eip-url="{$url_index}/note/post" data-eip-label="{if $note->isNew()}{sprintf(lang('creation_in_progress'), lang('note_add_p_1'))|escape}{else}{sprintf(lang('modification_in_progress'), $note->getName())|escape}{/if}" >
			<span data-eip-field-name="Id" data-eip-field-type="hidden" data-eip-field-value="{$note->getId()}"></span>
			<span data-eip-field-name="ProjectId" data-eip-field-type="hidden" data-eip-field-value="{$project->getId()}"></span>
			<p><b>{lang('note_view_p_5')} : </b>
				{$note->getPublishedAt('d/m/Y H:i:s')}
			</p>
			<p><b>{lang('note_view_p_6')} : </b>
				{$note->getActor()->getFirstName()} {$note->getActor()->getName()}
			</p>
			<p><b>{lang('note_view_p_4')} : </b>
				<span data-eip-field-name="Name" data-eip-field-value="{$note->getName()|escape}" data-eip-field-class="required">{$note->getName()}</span>
			</p>
			<p><b>{lang('note_view_p_7')} : </b>
				<span data-eip-field-name="Content" data-eip-field-type="textarea" data-eip-field-value="{$note->getContent()|escape}" data-eip-field-class="required"><br>{$note->getContent()|nl2br}</span>
			</p>
		    <span data-eip-field-name="csrf_test_name" data-eip-field-type="hidden" data-eip-field-value="{$csrf_hash}"></span>
	</section>

	{if $note->isNew()}
		<script>
			/*Start eip*/
			$(document).ready(function() { eipStart('note', '{$url_index}/project/view/{$project->getId()}', '{$url_index}/project/view/{$project->getId()}'); });
		</script>
	{/if}
{/block}
{/strip}