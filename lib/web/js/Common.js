var Common={

    browser : '',

    // --------------  ajax ------------------------
    postRequest : function (address, response_type, result_div_id, form, additional_payload, start_callback, finish_callback, reload_on_success, reload_on_finish, success_callback)
    {
        if (start_callback)
        {
            eval('if (typeof('+start_callback+') == "function") '+start_callback+'();');
        }
        var payload = '';
        if (form)
        {
            payload += $(form).serialize();
        }
        if (additional_payload)
        {
            if (payload)
            {
                payload += '&';
            }
            payload += additional_payload;
        }

        if (response_type && (response_type == 'html' || response_type == 'json'))
        {}
        else
        {
            response_type = 'html';
        }
        $.post(
            GlobalVars.base_url+'/'+address,
            payload,
            function(data){
                if (response_type == 'html')
                {
                    if (result_div_id)
                    {
                        if (data.search(/^\{.*\}$/igm) != -1)
                        {
                            if (Common.ajaxRedirect($.evalJSON(data))) return;
                        }

                        $('#'+result_div_id).html(data);
                    }
                }
                if (response_type == 'json')
                {
                    if (Common.ajaxRedirect(data)) return;

                    if (typeof data == 'object' && (data.saved || data.result))
                    {
                        if (data.message)
                        {
                            $('#'+result_div_id).html(data.message);
                        }
                        if (typeof success_callback == "function"){
                            success_callback();
                        }
                        if (reload_on_success)
                        {
                            Common.smartReload();
                        }
                    }
                    else
                    {
                        if (result_div_id)
                        {
                            $('#'+result_div_id).html(data.errors);
                        }
                    }
                }

                if (typeof finish_callback == "function"){
                    finish_callback();
                }

                if (reload_on_finish)
                {
                    Common.smartReload();
                }
            },
            response_type
        );
    },
    postNoReload : function (address, form, payload, finish_callback)
    {
        this.postRequest (address, 'html', null, form, payload, null, finish_callback);
    },
    postAndReload : function (address, form, payload)
    {
        this.postRequest (address, 'html', null, form, payload, null, null, null, 1);
    },
    postEditForm : function (address, result_div_id, form, additional_payload, start_callback)
    {
        this.postRequest (address, 'json', result_div_id, form, additional_payload, start_callback, null, 1);
    },
    postEditFormNoReload : function (address, result_div_id, form, additional_payload, start_callback, success_callback)
    {
        this.postRequest (address, 'json', result_div_id, form, additional_payload, start_callback, null, null, null, success_callback);
    },
    load : function (address, result_div_id, payload, finish_callback)
    {
        this.postRequest (address, 'html', result_div_id, null, payload, null, finish_callback);
    },
    // -------------------------- Common functions ------------------------------

    getBrowser : function ()
    {
        var browser;
        jQuery.each(jQuery.browser, function(i, val) {
             if(val == true)
             {
                 browser = {name:i,version:jQuery.browser.version};
             }
        });
        this.browser = browser;
    },
    toggleElement: function (el)
    {
        if (!el) return;
        if (el.css('display') == 'none')
        {
            el.css('display','');
        }
        else
        {
            el.css('display','none');
        }
    },

    slideElement: function (el)
    {
        if (!el) return;
        if (Common.browser.name == 'msie')
        {
            Common.toggleElement(el);
        }
        else
        {
            el.slideToggle('fast');
        }
    },

    // Dom window wrapper
    openDomWindow : function (w_width, w_height, w_source, title, overlay_opacity, anchor)
	{
	    var source_type;

	    if (!overlay_opacity)
	    {
	        overlay_opacity = 85;
	    }
	    else
	    {
	       	if (this.browser.name == 'msie' && this.browser.version > 7)
                if (overlay_opacity ==1) overlay_opacity = 8;
            if (this.browser.name == 'msie' && this.browser.version > 6 && this.browser.version < 8)
                if (overlay_opacity ==1) overlay_opacity = 12;
	    }
	    if (typeof w_source == 'string')
	    {
	        source_type = 'ajax'
	    }

	    if (typeof w_source == 'object')
	    {
	        source_type = w_source.type;
	    }

	    var dom_settings = {
           height: w_height,
           width: w_width,
           loader: 0,
           overlayOpacity: overlay_opacity,
           positionType:'centered',
           windowTitle: title
        }

        if (anchor)
        {
            if (typeof anchor == 'string')
            {
	           dom_settings.anchoredSelector = anchor;
	           dom_settings.positionType = 'anchoredSingleWindow';
            }
            else
            {
                if (typeof anchor == 'object' && anchor.selector)
                {
	                dom_settings.anchoredSelector = anchor.selector;
	                dom_settings.positionType = 'anchoredSingleWindow';
	                if (anchor.left)
	                   dom_settings.positionLeft = anchor.left;
	                if (anchor.top)
	                   dom_settings.positionTop = anchor.top;
                }
            }
        }

        switch (source_type)
	    {
	        case 'ajax':
                dom_settings.windowSourceURL = w_source,
                dom_settings.windowSource = 'ajax';
                dom_settings.functionCallOnOpen = function () {
                    $("#DOMWindow").vAlign();
                    $("#DOMWindow").hAlign();
                }
	            break;
	        case 'inline':
	            dom_settings.windowSourceID = w_source.id
	            break;
	    }
	    $.openDOMWindow(dom_settings);
	},


	// ------------  ck editor --------------------
	createCkEditorOnTextArea : function(textarea_id, ck_width, callback_on_ready, callback_on_resize)
    {
        if (!ck_width)
        {
            ck_width = 650;
        }
        if (GlobalVars['ck_editor'] && typeof GlobalVars['ck_editor'][textarea_id] == 'object')
        {
            this.removeCkEditor(textarea_id);
        }
        GlobalVars['ck_editor'][textarea_id] = CKEDITOR.replace(textarea_id , {customConfig : 'js/ckeditor_config.js', width: ck_width} );

        GlobalVars['ck_editor'][textarea_id].on(
            'instanceReady',
            function (e)
            {
                if (callback_on_ready && typeof(callback_on_ready) == 'function')
                {
                    callback_on_ready();
                }
            }
        );

        GlobalVars['ck_editor'][textarea_id].on(
            'resize',
            function (e)
            {
                if (callback_on_resize && typeof(callback_on_resize) == 'function')
                {
                    callback_on_resize();
                }
            }
        );
    },
    removeCkEditor : function (el_id)
    {   // Destroy the editor.
        if (typeof GlobalVars['ck_editor'][el_id] == 'object')
        {
	       GlobalVars['ck_editor'][el_id].destroy(el_id);
	       delete GlobalVars['ck_editor'][el_id];
        }
    },
    getCkEditorContents : function (el_id)
    {
        if (typeof GlobalVars['ck_editor'][el_id] == 'object')
        {
	        return GlobalVars['ck_editor'][el_id].getData();
        }
    },
	setCkEditorContents : function (el_id)
    {
        $('#'+el_id).val(this.getCkEditorContents(el_id));
    },


	ajaxRedirect : function (json_data)
	{
	    if (typeof json_data == 'object' && json_data.ajax_redirect)
        {
            if (json_data.ajax_redirect == 'admin_login')
            {
                window.location.replace(GlobalVars.base_url+'/admin/login');
                return true;
            }
        }
	},

    smartReload : function ()
    {
        window.location.replace(window.location.href);
    },

	convertStringToUrl:function(strTitle)
	{
	    var replaces=new Object();
	    replaces['ä']=['a'];
	    replaces['ü']=['u'];
	    replaces['õ']=['o'];
	    replaces['ö']=['o'];
	    replaces['š']=['s'];
	    replaces['ž']=['z'];
	    replaces['ё']=['e'];
	    replaces['й']=['j'];
	    replaces['ц']=['c'];
	    replaces['у']=['u'];
	    replaces['к']=['k'];
	    replaces['е']=['e'];
	    replaces['н']=['n'];
	    replaces['г']=['g'];
	    replaces['ш']=['sh'];
	    replaces['щ']=['sch'];
	    replaces['з']=['z'];
	    replaces['х']=['x'];
	    replaces['ъ']=[''];
	    replaces['ф']=['f'];
	    replaces['ы']=['y'];
	    replaces['в']=['v'];
	    replaces['а']=['a'];
	    replaces['п']=['p'];
	    replaces['р']=['r'];
	    replaces['о']=['o'];
	    replaces['л']=['l'];
	    replaces['д']=['d'];
	    replaces['ж']=['zh'];
	    replaces['э']=['e'];
	    replaces['я']=['ja'];
	    replaces['ч']=['ch'];
	    replaces['с']=['s'];
	    replaces['м']=['m'];
	    replaces['и']=['i'];
	    replaces['т']=['t'];
	    replaces['ь']=[''];
	    replaces['б']=['b'];
	    replaces['ю']=['ju'];
	    replaces['Ä']=['A'];
	    replaces['Ü']=['U'];
	    replaces['Õ']=['O'];
	    replaces['Ö']=['O'];
	    replaces['Š']=['S'];
	    replaces['Ž']=['Z'];
	    replaces['Ё']=['E'];
	    replaces['Й']=['J'];
	    replaces['Ц']=['C'];
	    replaces['У']=['U'];
	    replaces['К']=['K'];
	    replaces['Е']=['E'];
	    replaces['Н']=['N'];
	    replaces['Г']=['G'];
	    replaces['Ш']=['SH'];
	    replaces['Щ']=['SCH'];
	    replaces['З']=['Z'];
	    replaces['Х']=['X'];
	    replaces['Ъ']=[''];
	    replaces['Ф']=['F'];
	    replaces['Ы']=['Y'];
	    replaces['В']=['V'];
	    replaces['А']=['A'];
	    replaces['П']=['P'];
	    replaces['Р']=['R'];
	    replaces['О']=['O'];
	    replaces['Л']=['L'];
	    replaces['Д']=['D'];
	    replaces['Ж']=['ZH'];
	    replaces['Э']=['E'];
	    replaces['Я']=['JA'];
	    replaces['Ч']=['CH'];
	    replaces['С']=['S'];
	    replaces['М']=['M'];
	    replaces['И']=['I'];
	    replaces['Т']=['T'];
	    replaces['Ь']=[''];
	    replaces['Б']=['B'];
	    replaces['Ю']=['JU'];

	    var reg_search;
	    for(var repl in replaces)
	    {
	        regSearch=new RegExp(repl,"g");
	        strTitle=strTitle.replace(regSearch,replaces[repl]);
	    }
        regSearch=new RegExp("[^A-Za-z0-9]","g");
        strTitle=strTitle.replace(regSearch,"-");
        if(strTitle.length>2)
        {
            if(strTitle.substr(-1,1)=="-")
            {
                if(strTitle.substr(-2,1)=="-")
                {}
                else
                {
                    strTitle=strTitle.substr(0,strTitle.length-1);
                }
            }
        }
        return strTitle;
	},

	expressTranslation : function (el)
	{
	    if (el && typeof el != undefined && el.id)
	    this.openDomWindow ('','', 'admin/settings/expresstranslation?translation_id='+el.id);

	},
	// ------------ forms-------------------------
	getCheckBoxDataInArray : function (element_name)
	{
	   if (element_name)
	   {
	        var items = new Array();
	        var counter = 0;
            $(':input[name='+element_name+'[]]').each(function () {
                if (this.checked)
                {
                    items[counter] = this.value;
                    counter++;
                }
            });
            if (counter == 0)
            {
                return;
            }
            return items;
	   }
	},

	buttonsUpDownClick : function ()
	{
        $("a.button").mouseup(function(){
            $(this).removeClass('active_button').addClass('button');
        }).mousedown(function(){
            $(this).removeClass('button').addClass('active_button');
        });
        $("a.button2").mouseup(function(){
            $(this).removeClass('active_button2').addClass('button2');
        }).mousedown(function(){
            $(this).removeClass('button2').addClass('active_button2');
        });
        $("a.button3").mouseup(function(){
            $(this).removeClass('active_button3').addClass('button3');
        }).mousedown(function(){
            $(this).removeClass('button3').addClass('active_button3');
        });
	}
};
Common.getBrowser();

$(document).ready(function(){
    Common.buttonsUpDownClick();
});