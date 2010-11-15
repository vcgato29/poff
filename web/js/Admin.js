var Admin={
    // -------------------------- Common ------------------------------
    // dom window
    closePopUp : function ()
    {
        $('fixedAjaxDOMWindow').closeDOMWindow();
    },
    // tabs
    switchTabs : function (obj)
    {

        var id = obj.attr("rel");
	    $('.tab-content').hide();
	    $('.tabs div.tab_label').removeClass("selected");

	    $('.tabs a.active_button').removeClass("active_button").addClass('button');

        Common.toggleElement($('#'+id));
	    obj.parent().addClass("selected");
	    obj.removeClass("button").addClass("active_button");
    },
    // --------------------------- Left menu ----------------------------
    toggleMenuItem : function (el, mark_active)
    {   // open subitems

        $(el).parent().next("div.menu_body").slideToggle(0).siblings("div.menu_body").slideUp(0);
        // deal with open close folders icons
        if ($(el).hasClass('menu_folder'))
        {
            $(el).removeClass('menu_folder').addClass('menu_folder_opened');
        }

        $(el).siblings('a.menu_folder_opened').removeClass('menu_folder_opened').addClass('menu_folder');

        if (mark_active)
        {
            $(el).addClass('active_menu_link');
            $(el).siblings('a.active_menu_link').removeClass('active_menu_link');
        }
    },
    toggleFromSublink : function (el, mark_active)
    {   // toggle recursively to beginning from given element
        this.toggleMenuItem(el, mark_active);
        if (!el.parent().parent().hasClass('menu_list'))
        {
            this.toggleFromSublink (el.parent().parent().prev().children(), mark_active);
        }
    },
    openMenuItem : function (el)
    {
        
        // deal with link opening
        if($(el).attr('href') != '')
        {   // link not empty
            window.location.href = GlobalVars.base_url+'/'+$(el).attr('href');
        }else{
        	//this.toggleMenuItem (el);
        }
        return false;
    },
    initMenu : function (el)
    {
        var links = $('div.menu_list').find('a.menu_link');

        var compare_string;
        var id;
        var matched_href = '';

        for (var i = 0; i < links.length; i++)
        {
            compare_string ='';
            if (links[i].href.length <= window.location.href.length && links[i].href != GlobalVars.base_url+'/')
            {
                if (links[i].href.length < window.location.href.length)
                {
                    compare_string = window.location.href.substr(0, links[i].href.length)
                }
                else
                {
                    compare_string = window.location.href;
                }
                if (matched_href.length < compare_string.length && links[i].href == compare_string && links[i].id)
                {
                    id = links[i].id;
                    matched_href = compare_string;
                }
            }
        }
        if (id)
        {
            this.toggleFromSublink ($('#' + id), 1);
        }
    },

    itemsSort : function (el, field, form_id)
    {
        if ($('#sort_input').val() == field)
        {
            if ($('#sort_order_input').val() == 'desc')
            {
                $('#sort_order_input').val('asc');
            }
            else
            {
                $('#sort_order_input').val('desc');
            }
        }
        else
        {
            $('#sort_order_input').val('asc');
        }
        $('#sort_input').val(field);
        $('#'+form_id).submit();
    },

    // -------------------------- Structure ------------------------------------
    // structure menu tabs
    switchStructureTabs : function (obj)
    {
        var id = obj.attr("rel");
        var items = Common.getCheckBoxDataInArray('checked_structure_items');

        if (id != 'add_tab' && $('.tabs a.active_button').attr("rel") == 'rights_tab')
            return;

        if (id == 'add_tab' && $('.tabs a.active_button').attr("rel") == 'add_tab')
            return;

        if (!items && (id =='copy_tab' || id =='move_tab' || id =='delete_tab'))
        {
            Common.openDomWindow('200','', {type:'inline',id:'#no_str_selection'}, GlobalVars['translations']['error'], 1, {selector:'.'+id,left:-10,top:40});
        }

        if (id == 'delete_tab')
        {
            if (items)
            {
                Common.openDomWindow('200','', {type:'inline',id:'#confirm_delete_all'}, GlobalVars['translations']['confirm'], 1, {selector:'.delete_tab',left:-10,top:40});
            }
            return;
        }
        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.postRequest('admin/users/setrights', 'html', 'rights_tab', null, 'object_type=structure&object_id=' + $.getURLParam("nodeid"))
            }
        }
        if (id == 'copy_tab')
        {

            if (items)
            {
                Common.openDomWindow('560','','admin/structure/copy?'+$('.checked_item_radio').fieldSerialize(), GlobalVars['translations']['copy_title']);
            }
            return;
        }

        if (id == 'move_tab')
        {
            if (items)
            {
                Common.openDomWindow('560','','admin/structure/move?'+$('.checked_item_radio').fieldSerialize(), GlobalVars['translations']['move_title']);
            }
            return;
        }

        this.switchTabs(obj);
    },

    clickBrowseMenuItem : function (el)
    {
        if (el.id)
        {
            $('#selected_folder_name').text($('#'+el.id).text());
            $('#destination_node_id').val(el.id);
        }
        this.toggleMenuItem (el);
        $("#DOMWindow").vAlign();
        $("#DOMWindow").hAlign();
        return false;
    },
    addComponentNode : function (form, component, callback)
    {
        if (callback && typeof(callback) != 'undefined')
        {
            callback();
        }
        Common.postEditForm ('admin/structure/addnode', 'node_add_messages', form, 'nodetype='+component);
    },
    autoFillUrl:function(title_id, url_id)
	{
        if ($('#'+title_id) && $('#'+title_id).val())
        {
            $('#' + url_id).val(Common.convertStringToUrl($('#'+title_id).val()));
        }
	},
    onOpenComponentEdit : function (el)
    {
        if (typeof el != undefined && el.rel)
        {
            Common.load (
                'admin/structure/editnode',
                'edit_'+el.id.substr(2),
                'nodetype='+el.rel+'&id='+el.id.substr(2)
            );
        }
    },

    // ------------ admin users ---------------------------
    switchAdminUsersTabs : function (obj, init)
    {
        var id = obj.attr("rel");
        var items = Common.getCheckBoxDataInArray('checked_users');

        if (id != 'add_tab' && $('.tabs a.active_button').attr("rel") == 'rights_tab')
            return;

        if (!items && id =='delete_tab')
        {
            Common.openDomWindow('200','', {type:'inline',id:'#no_str_selection'}, GlobalVars['translations']['error'], 1, {selector:'.'+id,left:-10,top:40});
        }

        if (id == 'delete_tab')
        {
            if (items)
            {
                Common.openDomWindow('200','', {type:'inline',id:'#confirm_delete_all'}, GlobalVars['translations']['confirm'], 1, {selector:'.delete_tab',left:-10,top:40});
            }
            return;
        }
        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.load('admin/users/setrights', 'rights_tab', 'object_type=admins');
            }
        }
        if (id == 'add_tab')
        {
            if ($('#'+id).css('display') == 'block' && !init)
            {
                Common.openDomWindow('470', '', 'admin/users/addadmin', GlobalVars['translations']['add_admin_user']);
            }
        }
	    this.switchTabs(obj);
    } ,
    openEditAdminUser : function (el)
    {
        if (el && typeof el != undefined)
        {
            Common.load ('admin/users/editadmin', 'edit_'+el.id.substr(2), 'userid='+el.id.substr(2));
        }
    },
    // ------------ public users ---------------------------
    switchPublicUsersTabs : function (obj, init)
    {
        var id = obj.attr("rel");
        var items = Common.getCheckBoxDataInArray('checked_users');

        if (id != 'add_tab' && $('.tabs a.active_button').attr("rel") == 'rights_tab')
            return;

        if (!items && id =='delete_tab')
        {
            Common.openDomWindow('200','', {type:'inline',id:'#no_str_selection'}, GlobalVars['translations']['error'], 1, {selector:'.'+id,left:-10,top:40});
        }

        if (id == 'delete_tab')
        {
            if (items)
            {
                Common.openDomWindow('200','', {type:'inline',id:'#confirm_delete_all'}, GlobalVars['translations']['confirm'], 1, {selector:'.delete_tab',left:-10,top:40});
            }
            return;
        }
        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.load('admin/users/setrights', 'rights_tab', 'object_type=users');
            }
        }
        if (id == 'add_tab')
        {
            if ($('#'+id).css('display') == 'block' && !init)
            {
                Common.openDomWindow('480', '', 'admin/users/addpublicuser', GlobalVars['translations']['add_public_user']);
            }
        }
	    this.switchTabs(obj);
    } ,
    openEditPublicUser : function (el)
    {
        if (el && typeof el != undefined)
        {
            Common.load ('admin/users/editpublicuser', 'edit_'+el.id.substr(2), 'userid='+el.id.substr(2));
        }
    },
    // --------------- user groups -------------------------------
    switchUserGroupsTabs : function (obj, init)
    {
        var id = obj.attr("rel");
        var items = Common.getCheckBoxDataInArray('checked_groups');

        if (id != 'add_tab' && $('.tabs a.active_button').attr("rel") == 'rights_tab')
            return;

        if (!items && id =='delete_tab')
        {
            Common.openDomWindow('200','', {type:'inline',id:'#no_str_selection'}, GlobalVars['translations']['error'], 1, {selector:'.'+id,left:-10,top:40});
        }

        if (id == 'delete_tab')
        {
            if (items)
            {
                Common.openDomWindow('200','', {type:'inline',id:'#confirm_delete_all'}, GlobalVars['translations']['confirm'], 1, {selector:'.delete_tab',left:-10,top:40});
            }
            return;
        }
        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.load('admin/users/setrights', 'rights_tab', 'object_type=user_groups');
            }
        }
        if (id == 'add_tab')
        {
            if ($('#'+id).css('display') == 'block' && !init)
            {
                Common.openDomWindow('480', '', 'admin/users/addusergroup',GlobalVars['translations']['add_group']);
            }
        }
	    this.switchTabs(obj);
    } ,
    openEditUserGroup : function (el)
    {
        if (el && typeof el != undefined)
        {
            Common.load ('admin/users/editusergroup', 'edit_'+el.id.substr(2), 'groupid='+el.id.substr(2));
        }
    },
	// -------------------------- Translations ------------------------------------
    // translations tabs
    switchTranslationsTabs : function (obj, init)
    {
        var id = obj.attr("rel");

        var items = Common.getCheckBoxDataInArray('checked_translation_groups');

        if (id != 'add_tab' && $('.tabs a.active_button').attr("rel") == 'rights_tab')
            return;

        if (!items && id =='delete_tab')
        {
            Common.openDomWindow('200','', {type:'inline',id:'#no_str_selection'}, GlobalVars['translations']['error'], 1, {selector:'.'+id,left:-10,top:40});
        }

        if (id == 'delete_tab')
        {
            if (items)
            {
                Common.openDomWindow('200','', {type:'inline',id:'#confirm_delete_all'}, GlobalVars['translations']['confirm'], 1, {selector:'.delete_tab',left:-10,top:40});
            }
            return;
        }
        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.load('admin/users/setrights', 'rights_tab', 'object_type=translations');
            }
        }
	    this.switchTabs(obj);
    },
    stringEscapeSpecSymbols : function (string)
    {
        if (string)
        {
            return string.replace(/%/g, '\\%');
        }
    },
    openTranslationGroupRow : function (el)
    {
        var id = this.stringEscapeSpecSymbols('edit_'+el.id.substr(2));
        if (el && typeof el != undefined)
        {
            Common.load ('admin/settings/translationgroup', id, 'group='+el.id.substr(2));
        }
    },

    // -------------------------- Languages ------------------------------------
    // translations tabs
    switchLanguagesTabs : function (obj, init)
    {
        var id = obj.attr("rel");
        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.load('admin/users/setrights', 'rights_tab', 'object_type=languages');
            }
        }
        if (id == 'add_tab')
        {
            if ($('#'+id).css('display') == 'block' && !init)
            {
                Common.openDomWindow('480', '', 'admin/settings/addlanguage', GlobalVars['translations']['add_language']);
            }
        }
	    this.switchTabs(obj);
    },
    openLanguageRow : function (el)
    {
        if (el && typeof el != undefined)
        {
            Common.load ('admin/settings/languageedit', 'edit_'+el.id.substr(2), 'languageid='+el.id.substr(2));
        }
    },
    //-------------- Common settings --------------------------
    switchCommonSettingsTabs : function (obj, init)
    {
        var id = obj.attr("rel");

        if (id == 'rights_tab')
        {
            if (!$('#rights_tab').html())
            {
                Common.load('admin/users/setrights', 'rights_tab', 'object_type=common_settings');
            }
        }
	    this.switchTabs(obj);
    },
    //-------------------------- accordion toggle rows --------------------------
    toggleAccordionRow : function (el, content_div_class, close_other)
    {
        var nextDiv = $(el).parent().parent().parent().parent().next();
        if (close_other)
        {
            $('div.'+content_div_class+':visible').each(function () {
                if (this.id != nextDiv.attr('id'))
                    jQuery(this).css('display', 'none');
            });
        }
        if (Common.browser.name == 'msie')
        {
            Common.toggleElement(nextDiv);
        }
        else
        {
            nextDiv.slideToggle('fast');
        }
    },
    // accordion toggle rows
    toggleAccordionRow2 : function (el, content_div_class, close_other)
    {
        var nextDiv = $(el).parent().next();
        if ($(el).parent().hasClass('item_section_opened'))
        {
            $(el).parent().removeClass('item_section_opened').addClass('item_section_closed');
        }
        else
        {
            if ($(el).parent().hasClass('item_section_closed'))
            {
                $(el).parent().removeClass('item_section_closed').addClass('item_section_opened');
            }
        }
        if (close_other)
        {
            $('div.'+content_div_class+':visible').each(function () {
                if (this.id != nextDiv.attr('id'))
                    jQuery(this).css('display', 'none');
            });
        }
        if (Common.browser.name == 'msie')
        {
            Common.toggleElement(nextDiv);
        }
        else
        {
            nextDiv.slideToggle('fast');
        }
    },

    toggleAccordionRow3 : function (el, content_div_class, close_other)
    {
        var nextDiv = $(el).parent().parent().next();
        if ($(el).parent().parent().hasClass('item_sub_section_opened'))
        {
            $(el).parent().parent().removeClass('item_sub_section_opened').addClass('item_sub_section_closed');
        }
        else
        {
            if ($(el).parent().parent().hasClass('item_sub_section_closed'))
            {
                $(el).parent().parent().removeClass('item_sub_section_closed').addClass('item_sub_section_opened');
            }
        }
        if (close_other)
        {
            $('div.'+content_div_class+':visible').each(function () {
                if (this.id != nextDiv.attr('id'))
                    jQuery(this).css('display', 'none');
            });
        }
        if (Common.browser.name == 'msie')
        {
            Common.toggleElement(nextDiv);
        }
        else
        {
            nextDiv.slideToggle('fast');
        }
    },

    deleteGalleryPictures: function (node_id)
    {
        var items = Common.getCheckBoxDataInArray('checked_picture_items');
        if (!items)
        {
            Common.openDomWindow('200','', {type:'inline',id:'#no_gallery_pics_str_selection_'+node_id}, GlobalVars['translations']['error'], 1, {selector:'.delete_gallery_pictures_button_'+node_id,left:-40,top:-90});
        }
        else
        {
            Common.openDomWindow('200','', {type:'inline',id:'#confirm_gallery_pics_delete_all_'+node_id}, GlobalVars['translations']['confirm'], 1, {selector:'.delete_gallery_pictures_button_'+node_id,left:-70,top:-130});
        }
    }


};