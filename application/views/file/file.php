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
{block name="title"}{lang('app_name')} - {$file->getName()}{/block}
{block name="page"}
	<!-- Project details -->
	<section id="project" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_briefcase"></i>{lang('file_view_h_1')}</p>
		<p><b>{lang('file_view_p_9')} :</b> <span class="inbl"><span class="progressbar_holder" title="{sprintf(lang('file_view_p_10'), $project->getProgress(), $project->getProgressScore()|number_format:2)}"><span class="progressbar {$project->getProgressScore()|score_project}" style="width: {$project->getProgress()}%"></span></span></span>
		<p><b>{lang('file_view_p_1')}: </b>{$project->getCode()}</p>
		<p><b>{lang('file_view_p_2')}: </b>{$project->getName()}</p>
		<p><b>{lang('file_view_p_3')}: </b><br>{$project->getDescription()|nl2br}</p>
	</section>

	<!-- File details -->
	<section id="file" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_folder_page"></i>{lang('file_view_h_2')}
			{if isset($user_roles['FileEditor']) && !$file->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="ajax('/file/delete/{$file->getId()}', '{$url_index}/project/view/{$project->getId()}');" title="{lang('file_view_a_2')}"><i class="fam fam_page_delete"></i></a>{/if}
			{if isset($user_roles['FileEditor']) && !$file->isNew()}<a class="right mrs" href="javascript:void(0)" onclick="eipStart('file')" title="{lang('file_view_a_1')}"><i class="fam fam_pencil"></i></a>{/if}
		</p>
		<div data-eip-name="file" data-eip-url="{$url_index}/file/post" data-eip-label="{sprintf(lang('modification_in_progress'), $file->getName())|escape}" >
			<span data-eip-field-name="Id" data-eip-field-type="hidden" data-eip-field-value="{$file->getId()}"></span>
			<span data-eip-field-name="ProjectId" data-eip-field-type="hidden" data-eip-field-value="{$project->getId()}"></span>
			<p><b>{lang('file_view_p_7')} : </b>
				{$file->getActor()->getFirstName()} {$file->getActor()->getName()}
			</p>
			<p><b>{lang('file_view_p_5')} : </b>
				{sprintf(($file->getSize()/1024)|number_format:0:"":" ")} ko
			</p>
			<p><b>{lang('file_view_p_6')} : </b>
				{$file->getVersion()}
			</p>
			<p><b>{lang('file_view_p_4')} : </b>
				<span data-eip-field-name="Name" data-eip-field-value="{$file->getName()|escape}" data-eip-field-class="required">{$file->getName()}</span>
			</p>
			<p><b>{lang('file_view_p_8')} : </b>
				<span data-eip-field-name="Folder" data-eip-field-value="{$file->getFolder()|escape}" >{$file->getFolder()}</span>
			</p>
		    <span data-eip-field-name="csrf_test_name" data-eip-field-type="hidden" data-eip-field-value="{$csrf_hash}"></span>
	</section>

	<!-- File preview -->
	<section id="filepreview" class="mts mbm">
		<p class="h5-like"><i class="mrs fam fam_magnifier"></i>{lang('file_view_h_3')}</p>
	</section>

{/block}
{/strip}