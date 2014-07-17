/*

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

function ajax(url, onSuccess, block, method, data){
    event.stopPropagation();
    event.preventDefault();

    /*Set default*/
    if (block == undefined) block = true;
    if (method == undefined) method = 'GET';
    if (data == undefined) data = {};

    /*Retrieve if already blocked*/
    var isUIBlocked = $('.blockUI').length > 0;

    if ((!isUIBlocked) && (block == true)) $.blockUI({ message: lang.wait });
    
    $.ajax({
        type: method,
        dataType: 'json',
        url: url_index+url,
        data: data,
        cache: false,
        success: function(data){
            switch(data.result){
                case 'success':
                    if (!onSuccess) location.reload();
                    switch(typeof(onSuccess)){
                        case 'function':
                            onSuccess(data);
                            break;
                        case 'string':
                            location.href = onSuccess;
                            break;
                    }
                    break;
                case 'error':
                    $.unblockUI();
                    alert(data.error);
                    break;
            }
        },
        error: function(data){
            $.unblockUI();
            if (typeof data.responseText == 'string' && data.responseText != '') alert(data.responseText);
        }
    });
}

function uploadHandleDrop(files, projectid, folder, csrf_hash){
   for (var i = 0; i < files.length; i++){
        var fd = new FormData();
        fd.append('File', files[i]);
        fd.append('ProjectId', projectid);
        fd.append('Folder', folder);
        fd.append('csrf_test_name', csrf_hash);
 
        uploadSend(fd);
   }
}

function uploadSend(formData){
    $.ajax({
        url: url_index+"/file/upload/",
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        success: function(data){
        	var json = jQuery.parseJSON(data);
        	if (json.result == 'error') {
                alert(json.error);
            }else{
                location.reload(true);
            }
        },
		error: function(jqXHR, textStatus) {
			alert(jqXHR.responseText);
		}
    });
}

function eipStart(eipname, onSuccess, onCancel){
    if (!eipname) eipname = 'eip';
    if (!onSuccess) onSuccess = '';
    if (!onCancel) onCancel = window.location.href;

    /*Get eip node*/
    var eip = $('div[data-eip-name='+eipname+']');
    
    /*Function callback*/
    var fieldCallback = Array();

    /*Transform field to field*/
    eip.find('span[data-eip-field-name]').each(function(){
        var field_name = $(this).attr('data-eip-field-name');
        var field_type = $(this).attr('data-eip-field-type')?$(this).attr('data-eip-field-type'):'text';
        var field_value = $(this).attr('data-eip-field-value')?$(this).attr('data-eip-field-value'):'';
        var field_style = $(this).attr('data-eip-field-style')?$(this).attr('data-eip-field-style'):'';
        var field_class = $(this).attr('data-eip-field-class')?'eip_'+$(this).attr('data-eip-field-class'):'';
        var field_append_after = $(this).find('span[data-eip-field-append="after"]').html()?$(this).find('span[data-eip-field-append="after"]').html():'';
        var field_append_before = $(this).find('span[data-eip-field-append="before"]').html()?$(this).find('span[data-eip-field-append="before"]').html():'';

        switch(field_type){
            case 'hidden':
            case 'text':
            case 'radio':
            case 'number':
                $(this).html(field_append_before+'<input type="'+field_type+'" name="'+field_name+'" value="" class="eip_field_common '+field_class+'" style="'+field_style+'">'+field_append_after);
                /*Add callback to put properly field's value*/
                fieldCallback.push(function(){
                    $("input[name="+field_name+"]").val(field_value);
                });
                break;
            case 'date':
                $(this).html(field_append_before+'<input type="text" name="'+field_name+'" value="'+field_value+'" class="eip_field_common '+field_class+'" style="'+field_style+'">'+field_append_after);
                /*Add callback to put properly field's value*/
                fieldCallback.push(function(){
                    $("input[name="+field_name+"]").val(field_value);
                });
                break;
            case 'textarea':
                $(this).html(field_append_before+'<textarea name="'+field_name+'" class="top eip_field_textarea '+field_class+'" style="'+field_style+'" wrap="off">'+field_value+'</textarea>'+field_append_after);
                break;
            case 'select':
            case 'multiselect':
                var html = field_append_before+'<select name="'+((field_type == 'multiselect')?field_name+'[]':field_name)+'" class="eip_field_common '+field_class+'" style="'+field_style+'" '+((field_type == 'multiselect')?'multiple="multiple"':'')+'>';
                var options = jQuery.parseJSON($(this).attr('data-field-options'));
                if (field_type == 'multiselect') var field_values = jQuery.parseJSON(field_value);
                $(options).each(function(){
                    html += '<option value="'+$(this).attr('Id')+'" ';
                    if (field_type == 'multiselect'){
                        html += (($.inArray($(this).attr('Id'), field_values) >= 0)?'selected':'');
                    }else{
                        html += (($(this).attr('Id') == field_value)?'selected':'');
                    }
                    html += ' class="'+(($(this).attr('Class'))?$(this).attr('Class'):'')+'">'+$(this).attr('Label')+'</option>';
                });
                html += '</select>'+field_append_after;
                
                $(this).html(html);

                break;
        }
    });

    /*Setting new html content*/
    var height = eip.attr('data-eip-height')?eip.attr('data-eip-height'):'auto';
    form = '<div id="'+eipname+'-error" class="eip_error"></div><form name="'+eipname+'" method="post" action="'+eip.attr('data-eip-url')+'" style="height:'+height+'; overflow-y:'+((height == 'auto')?'auto':'scroll')+';">'+eip.html()+'</form>';
    
    /*Popup if necessary*/
    if (eip.attr('data-eip-target') == 'popup') {
        var width = eip.attr('data-eip-width')?eip.attr('data-eip-width'):500;
        var left = (screen.width - width)/2;    
    
        popup = '<div id="box" style="border: 0px;"><h3>'+eip.attr('data-eip-label')+'</h3>'+form+'</div>';
        popup += '<div id="eip-actions-popup"><a onclick="eipSend(\''+eipname+'\','+((typeof(onSuccess) == 'function') ? onSuccess : '\''+onSuccess+'\'')+')"><i class="mrs fam fam_tick"></i>'+lang.valid+'</a><a href="'+onCancel+'"><i class="mrs fam fam_cancel"></i>'+lang.cancel+'</a></div>';
        
        $.blockUI({ message: popup, css: {'cursor': 'default', 'text-align': 'left', 'width':width, 'left':left,'top': '250px'} });
    }else{
        /*Prepare action toolbar*/
        $('#eip-actions-bottom').html(eip.attr('data-eip-label')+'<a onclick="eipSend(\''+eipname+'\','+((typeof(onSuccess) == 'function') ? onSuccess : '\''+onSuccess+'\'')+')"><i class="mrs fam fam_tick"></i>'+lang.valid+'</a><a href="'+onCancel+'"><i class="mrs fam fam_cancel"></i>'+lang.cancel+'</a></div>');

        /*Set eip html*/
        eip.html(form).prepend();
        
        /*Show bottom panel*/
        $('#eip-actions-bottom').show();
    }

    /*Call Callbacks*/
    $(fieldCallback).each(function() {this();});

}


function eipSend(eipname, onSuccess){
    if (!eipname) eipname = 'eip';

    /*Retrieve if already blocked*/
    var isUIBlocked = $('.blockUI').length > 0;

    if (!isUIBlocked) $.blockUI({ message: lang.wait });
    
    /*Get eip node and fields*/
    var eip = $('form[name='+eipname+']');
    var data = {};
    data['form'] = eipname;
    $(eip).find('[data-eip-field-name]').each(function(){
        var input = $(this).find('[name='+$(this).attr('data-eip-field-name')+']');
        data[$(input).attr('name')] = $(input).val();
    });

    /*Send data*/
    $.ajax({
        type: $(eip).attr('method'),
        dataType: 'json',
        url: $(eip).attr('action'),
        data: data,
        cache: false,
        success: function(data) {
            if (!isUIBlocked) $.unblockUI();
            switch(data.result){
                case 'success':
                    if (!onSuccess) location.reload();
                    switch(typeof(onSuccess)){
                        case 'function':
                            onSuccess(data);
                            break;
                        case 'string':
                            (onSuccess != '') ? location.href = onSuccess.replace('$id', data.message) : location.reload();
                            break;
                    }
                    break;
                case 'error':
                    $('#'+eipname+'-error').html(data.message).show();
                    window.scrollTo(0,0);
                    break;
            }
        },
    });
}
