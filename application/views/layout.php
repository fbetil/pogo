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

<!DOCTYPE html>
{strip}
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name="title"}{/block}</title>

    <link rel="shortcut icon" href="{$url_base}assets/img/favicon.ico"/>
    <!-- Core CSS - Include with every page -->
    <link rel="stylesheet" href="{$url_base}assets.php?css=
        ./assets/vendor/jquery.gantt/css/style.css,
        ./assets/css/famfamfamsilk.css,
        ./assets/css/fileicon.css,
    	./assets/css/style.css
    	">
    <!-- Core JS - Include with every page -->
    <script src="{$url_base}assets.php?js=
        ./assets/vendor/jquery/jquery-1.11.1.min.js
        ">
    </script>
</head>
<body>
    <div class="w960p center">
        <!-- header  -->
        <header title="{lang('app_title')}" class="txtright smaller">
            {$pogo_version}
        </header>

        <!-- Nav bar -->
        <nav class="pas">
            {foreach from=$nav item=item name=nav}
                <a href="{$item.url}">{$item.label}</a>
                {if not $smarty.foreach.nav.last}  ::  {/if}
            {/foreach}
        </nav>

        <!-- Menu bar -->
        <menu class="mts small" >
            {foreach from=$menu item=item name=menu}
                <a href="{$item.url}">{$item.label}</a>
            {/foreach}
        </menu>

        <!-- Page  -->
        <div id="page">
            {block name="page"}{/block}
        </div>

        <!-- Footer  -->
        <footer class="txtright mtl mbs smaller">
            {sprintf(lang('app_footer_1'),date('Y',time()))} - {sprintf(lang('app_footer_2'), sprintf('%.3f', microtime(true) - $php_begintime), number_format(memory_get_peak_usage(true)/1024/1024,2))}</p>
        </footer>
    </div>

    <div id="eip-actions-bottom" ></div>

    <!-- Core Scripts - Include with every page -->
	<script>
	   var url_index = "{$url_index}";
	   var url_base = "{$url_base}";
	   var lang = new Object();
       lang.app_title = "{lang('app_title')|escape:javascript}";
       lang.wait = "{lang('wait')|escape:javascript}";
       lang.valid = "{lang('valid')|escape:javascript}";
       lang.cancel = "{lang('cancel')|escape:javascript}";
       lang.modification_in_progress = "{lang('modification_in_progress')|escape:javascript}";
	   lang.creation_in_progress = "{lang('creation_in_progress')|escape:javascript}";

	</script>
	<script src="{$url_base}assets.php?minify=true&js=
        ./assets/vendor/jquery.blockui/jquery.blockUI.min.js,
        ./assets/vendor/jquery.gantt/js/jquery.fn.gantt.min.js,
		./assets/js/scripts.js
		">
	</script>
</body>
</html>
{/strip}