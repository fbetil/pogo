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
{block name="title"}{lang('app_name')} - {$project->getName()}{/block}
{block name="page"}
{strip}
	<!-- Project details -->
	{if isset($user_roles['ProjectViewer'])}
	<section id="project" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('project_view_h_1')}
			{if isset($user_roles['ProjectEditor'])}<a class="right mrs" href="javascript:void(0)" onclick="eipStart('project')" title="{lang('project_view_a_8')}"><i class="fam fam_pencil"></i></a>{/if}
		</p>
		<div data-eip-name="project" data-eip-url="{$url_index}/project/post" data-eip-label="{sprintf(lang('modification_in_progress'), $project->getName())|escape}" >
			<span data-eip-field-name="Id" data-eip-field-type="hidden" data-eip-field-value="{$project->getId()}"></span>
			<p><b>{lang('project_view_p_4')} : </b>
				<span data-eip-field-name="Code" data-eip-field-value="{$project->getCode()}" data-eip-field-class="required">{$project->getCode()}</span>
			</p>
			<p><b>{lang('project_view_p_2')} : </b>
				<span data-eip-field-name="Name" data-eip-field-value="{$project->getName()|escape}" data-eip-field-class="required">{$project->getName()}</span>
			</p>
			<p><b>{lang('project_view_p_3')} : </b>
				<span data-eip-field-name="Description" data-eip-field-type="textarea" data-eip-field-value="{$project->getDescription()|escape}" data-eip-field-class="required" ><br>{$project->getDescription()|nl2br}</span>
			</p>
		    <span data-eip-field-name="csrf_test_name" data-eip-field-type="hidden" data-eip-field-value="{$csrf_hash}"></span>
	    </div>
	</section>
	{/if}

	<!-- Project calendar -->
	{if isset($user_roles['ProjectViewer'])}
	<section id="calendar" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_calendar"></i>{lang('project_view_h_2')}</p>
		<div class="gantt"></div>
	</section>
	{/if}

	<!-- Project milestones -->
	{if isset($user_roles['MilestoneViewer'])}
	<section id="milestones" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_timeline_marker"></i>{lang('project_view_h_5')}
			{if isset($user_roles['MilestoneEditor'])}<a class="right mrs" href="{$url_index}/milestone/add/{$project->getId()}" title="{lang('project_view_a_4')}"><i class="fam fam_add"></i></a>{/if}
		</p>
		<ul class="unstyled">
		{foreach from=$project->getMilestones() item=milestone}
			<li class="pointer list" title="{$milestone->getDescription()}" onclick="window.location.href = '{$url_index}/milestone/view/{$milestone->getId()}'">
				[{$milestone->getDueDate('d/m/Y')}]
				<div class="mls inbl">{$milestone->getName()}</div>
				<div class="inbl list_actions right">
					{if isset($user_roles['MilestoneEditor'])}<a href="javascript:void(0)" onclick="ajax('/milestone/delete/{$milestone->getId()}');" title="{lang('project_view_a_7')}"><i class="fam fam_delete"></i></a>{/if}
				</div>
			</li>
		{foreachelse}
			<li class="small"><i>{lang('project_view_p_1')}</i></li>
		{/foreach}
		</ul>
	</section>
	{/if}

	<!-- Project tasks -->
	{if isset($user_roles['TaskViewer'])}
	<section id="tasks" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_script"></i>{lang('project_view_h_6')}
			{if isset($user_roles['TaskEditor'])}<a class="right mrs" href="{$url_index}/task/add/{$project->getId()}" title="{lang('project_view_a_4')}"><i class="fam fam_script_add"></i></a>{/if}
		</p>
		<ul class="unstyled">
		{foreach from=$project->getTasks() item=task}
			<li class="pointer list" title="{$task->getDescription()}" onclick="window.location.href = '{$url_index}/task/view/{$task->getId()}'">
				[{$task->getStartDate('d/m/Y')} -> {$task->getDueDate('d/m/Y')}]
				<div class="mls inbl">{$task->getName()}</div>
				<div class="inbl list_actions right">
					{if isset($user_roles['TaskEditor'])}<a href="javascript:void(0)" onclick="ajax('/task/delete/{$task->getId()}');" title="{lang('project_view_a_7')}"><i class="fam fam_script_delete"></i></a>{/if}
				</div>
			</li>
		{foreachelse}
			<li class="small"><i>{lang('project_view_p_1')}</i></li>
		{/foreach}
		</ul>
	</section>
	{/if}

	<!-- Project notes -->
	{if isset($user_roles['NoteViewer'])}
	<section id="notes" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_note"></i>{lang('project_view_h_7')}
			{if isset($user_roles['NoteEditor'])}<a class="right mrs" href="mailto:{$pogo_smtp_address}?subject={sprintf(lang('project_view_a_5'), $smarty.now|date_format:"%d/%m/%Y %H:%M")}&body={$project->getCode()}" title="{sprintf(lang('project_view_p_5'), $project->getCode(), $pogo_smtp_address)}"><i class="fam fam_wand"></i></a>{/if}
			{if isset($user_roles['NoteEditor'])}<a class="right mrs" href="{$url_index}/note/add/{$project->getId()}" title="{lang('project_view_a_4')}"><i class="fam fam_note_add"></i></a>{/if}
		</p>
		<ul class="unstyled">
		{foreach from=$project->getNotes() item=note}
			<li class="pointer list" title="{$note->getContent()}" onclick="window.location.href = '{$url_index}/note/view/{$note->getId()}'">
				[{$note->getPublishedAt('d/m/Y H:i')} - {$note->getActor()->getFirstName()} {$note->getActor()->getName()}]
				<div class="mls inbl">{$note->getName()}</div>
				<div class="inbl list_actions right">
					{if isset($user_roles['NoteEditor'])}<a href="javascript:void(0)" onclick="ajax('/note/delete/{$note->getId()}');" title="{lang('project_view_a_7')}"><i class="fam fam_note_delete"></i></a>{/if}
				</div>
			</li>
		{foreachelse}
			<li class="small"><i>{lang('project_view_p_1')}</i></li>
		{/foreach}
		</ul>
	</section>
	{/if}

	<!-- Project files -->
	{if isset($user_roles['FileViewer'])}
	<section id="files" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_folder_page"></i>{lang('project_view_h_3')}
			{if isset($user_roles['FileEditor'])}<a class="right mrs" href="mailto:{$pogo_smtp_address}?subject={sprintf(lang('project_view_a_6'), $smarty.now|date_format:"%d/%m/%Y %H:%M")}&body={$project->getCode()}" title="{sprintf(lang('project_view_p_6'), $project->getCode(), $pogo_smtp_address)}"><i class="fam fam_wand"></i></a>{/if}
		</p>
		{assign folder null}
		{foreach from=$files item=file}
			{if $file->getFolder() != $folder}
				{if !$file@first}</ul>{/if}
				<p class="strong{if isset($user_roles['FileEditor'])} dropzone{/if}" data-folder="{$file->getFolder()}" >{$file->getFolder()|default:lang("project_view_p_7")}</p>
				{$folder = $file->getFolder()}
				<ul class="unstyled">
			{/if}
			<li class="pointer list h24p" onclick="window.location.href = '{$url_index}/file/view/{$file->getId()}'">
				<i class="fileicon24 fileicon24_{$file->getName()|pathinfo:4}"></i>
				{$file->getName()} <em class="fg-gray small">({sprintf("version %s", $file->getVersion())})</em>
				<div class="inbl list_actions right">
					<a href="{$url_index}/file/send/{$file->getId()}" title="{lang('project_view_a_1')}"><i class="fam fam_eye"></i></a>
					<a href="{$url_index}/file/send/{$file->getId()}/1" title="{lang('project_view_a_2')}"><i class="fam fam_drive_web"></i></a>
					{if isset($user_roles['FileEditor'])}<a href="javascript:void(0)" onclick="ajax('/file/delete/{$file->getId()}');" title="{lang('project_view_a_7')}"><i class="fam fam_page_delete"></i></a>{/if}
				</div>
			</li>
			{if $file@last}</ul>{/if}
		{foreachelse}
			<ul class="unstyled">
				<li class="small"><i>{lang('project_view_p_1')}</i></li>
			</ul>
		{/foreach}
	</section>
	{/if}

	<!-- Project actors -->
	{if isset($user_roles['ActorViewer'])}
	<section id="actors" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_user_gray"></i>{lang('project_view_h_4')}
			{if isset($user_roles['ActorEditor'])}<a class="right mrs" href="{$url_index}/actor/add/{$project->getId()}" title="{lang('project_view_a_4')}"><i class="fam fam_user_add"></i></a>{/if}
		</p>
		<ul class="unstyled">
		{foreach from=$project->getProjectActors() item=projectactor}
			<li>{$projectactor->getActor()->getFirstName()} {$projectactor->getActor()->getName()} - <i>{$projectactor->getRole()}</i></li>
		{foreachelse}
			<li class="small"><i>{lang('project_view_p_1')}</i></li>
		{/foreach}
		</ul>
	</section>
	{/if}

	<script>
		$(document).ready(function(){

		{if isset($user_roles['ProjectViewer'])}
			/*Gantt rendering*/
			$(".gantt").gantt({
				source: "{$url_index}/project/gantt/{$project->getId()}",
				itemsPerPage: 5,
				months: [
					"{lang('january')}","{lang('february')}", "{lang('march')}","{lang('april')}", "{lang('may')}",
					"{lang('june')}", "{lang('july')}", "{lang('august')}", "{lang('september')}", "{lang('october')}",
					"{lang('november')}", "{lang('december')}"
					],
				dow: [
					"{lang('monday_short')}", "{lang('tuesday_short')}", "{lang('wednesday_short')}", "{lang('thursday_short')}",
					"{lang('friday_short')}", "{lang('saturday_short')}", "{lang('sunday_short')}"
					],
				navigate: 'scroll', 
				scale: 'days', 
				maxScale: 'months', 
				minScale: 'hours'
			});
		{/if}

		{if isset($user_roles['FileEditor'])}
			/*Drag & drop*/
			var dropzone = $(".dropzone");

			dropzone.on('dragenter', function (e) {
			    e.stopPropagation();
			    e.preventDefault();
			    $(this).addClass('dropzone_hover');
			});

			dropzone.on('dragover', function (e) {
				e.stopPropagation();
				e.preventDefault();
			});

			dropzone.on('dragleave', function (e) {
				e.stopPropagation();
				e.preventDefault();
			    $(this).removeClass('dropzone_hover');
			});

			dropzone.on('drop', function (e){
				e.preventDefault();
				$(this).removeClass('dropzone_hover');

				var files = e.originalEvent.dataTransfer.files;

				/*Send dropped file*/
				uploadHandleDrop(files, {$project->getId()}, $(this).attr('data-folder'), '{$csrf_hash}');
			});
		{/if}

		});

	</script>
{/strip}
{/block}
