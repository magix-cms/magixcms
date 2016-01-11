/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 3/12/12
 * Time: 23:47
 * License: Dual licensed under the MIT or GPL Version
 */
$(function(){
    // Disable certain links in docs
    /*$('[href^=#]').click(function(e) {
        e.preventDefault()
    });*/
    // *** targetblank in JS for W3C validation
    $('a.targetblank').on('click', function() {
        window.open($(this).attr('href'));
        return false;
    });
    // jmShowIt sidebar
    $('a.showit').jmShowIt({
        open: 'open',
        contenerClass : 'div.collapse-item',
        activeClass : 'on',
        debug : false
    });


    // Navigation avec mémoir de menu en local storage :D
    // by sire-sam and highly commented for gtraxx ;)
    // --------------------------------------------------
    /**
     * Initialize localstorage or display his data for sidebar menu
     */
    /*function lauchMenustorage()
    {
        // set localstorage key
        var menuStorage =   localStorage.getItem('menuStorage');

        // If localStorage is NOT SET
        if (menuStorage == null) {
            // set json structure
            var json = {'active':[]};
            // convert to string and assign to localstorage
            localStorage.setItem('menuStorage',JSON.stringify(json));

            // If localStorage IS SET, ensures that all elements are visible
        } else {
            // convert (string)localstorage to json
            var menuJson    =   JSON.parse(menuStorage);
            // show each target on localstorage
            $.each(menuJson.active,function (key,val)
            {
                $(val).show();
            });
        }
    }

    /**
     * Set localStorage on sidebar menu
     * @TODO ajouter la gestion de l'icon
     * @TODO ajouter la valeur d'IdProfil dans le nom du localStorage, si plusieurs compte utilisent le même navigateur
     */
//    localStorage.removeItem('menuStorage'); // reset local storage (for debuging)
    /*if (Modernizr.localstorage) {
        // Init localStorage on load
        lauchMenustorage();
        // reset handler on sidebar links
        $('#sidebar .showit').addClass('menuStorage').removeClass('showit').off('click');

        // set handler on sidebar links
        $('.menuStorage').on('click', function(event)
        {
            event.preventDefault();

            // set node to show/hide
            var target  =   $(this).attr('href');

            // get local storage
            var menuStorage =   localStorage.getItem('menuStorage');
            if (menuStorage == null) {
                lauchMenustorage();
            }

            // (string)locastorage to json
            var menuJson    =   JSON.parse(menuStorage);

            var itemWasOpen   =   false;
            // search if target exist in localstorage
            $.each(menuJson.active,function (key,val)
            {
                // if target existe in localstorage, hide node, remove value
                if (val == target) {
                    itemWasOpen   =   true;
                    $(target).hide();
                    menuJson.active.splice(key,1);
                    console.log("menujson Removed =  %o",menuJson.active);
                }
            });

            if (itemWasOpen == false) {
                    // if target was'nt in localstorage, show node, add value
                    $(target).show();
                    menuJson.active.push(target);
            }
            // update localstorage
            localStorage.setItem('menuStorage',JSON.stringify(menuJson));
        });
    }*/


    // jmShowIt metas
    $('a.view-metas').jmShowIt({
        open: 'open',
        contenerClass : 'div.collapse-metas',
        activeClass : 'on',
        debug : false
    });
    // jmShowIt block
    $('a.view-block').jmShowIt({
        open: 'open',
        contenerClass : 'div.collapse-block',
        activeClass : 'on',
        debug : false
    });
    // dropdown config
    $('.dropdown-toggle').dropdown();

    //Prevent link brand
    $('.nav-collapse .nav .navbar-brand').on('click',function(event){
        event.preventDefault();
        return false;
    });
    //Unlock input text
    $('.unlocked').on('click',function(event){
        event.preventDefault();
        var lock = $('span.fa-lock',this);
        var unlock = $('span.fa-unlock',this);
        if (lock.length != 0) {
            $(this).parent().prev().removeAttr("readonly");
            $(this).parent().prev().removeAttr("disabled");
            lock.removeClass('fa-lock').addClass('fa-unlock');
        } else {
            $(this).parent().prev().attr("readonly","readonly");
            $(this).parent().prev().attr("disabled","disabled");
            unlock.removeClass('fa-unlock').addClass('fa-lock');
        }
    });
    function selectCurrentIso(id,adminurl){
        if ( typeof adminurl === "string" ) {
            $(document).on('change','select#'+id,function(){
                var $currentOption = $(this).find('option:selected').val();
                window.location.href = adminurl+$currentOption;
            });
        }else{
            console.error("Error url is not string");
        }
    }
    selectCurrentIso(
        'admin-language',
        '/'+baseadmin+'/dashboard.php?adminLanguage='
    );
    //$(".alert").alert('close');
    /*$("a[rel=popover]").popover({
        placement: 'right',
        offset: 15,
        trigger: 'manual',
        delay: { show: 350, hide: 100 },
        html: true,
        title: 'Twitter Bootstrap Popover',
        content: function(){
            return $(this).next('.nav-lang').html();
        }
    });
    var timer,
        popover_parent;
    function hidePopover(elem) {
        $(elem).popover('hide');
    }
    $("a[rel=popover]").hover(
        function() {
            var self = this;
            clearTimeout(timer);
            $('.popover').hide(); //Hide any open popovers on other elements.
            popover_parent = self
            $(self).popover('show');
        },
        function() {
            var self = this;
            timer = setTimeout(function(){hidePopover(self)},300);
        }
    );
    $(document).on({
        mouseenter: function() {
            clearTimeout(timer);
        },
        mouseleave: function() {
            var self = this;
            timer = setTimeout(function(){hidePopover(popover_parent)},300);
        }
    }, '.popover');*/

    // Tooltip configuration
    $(document).on({
        mouseenter: function() {
            //stuff to do on mouseover
            $(this).tooltip({
                placement:'top'
            });
        },
        mouseleave: function() {
            //stuff to do on mouseleave
            $(this).tooltip('hide');
        }

    },'thead th span[rel=tooltip]');

    // Fancybox config
    $("a.post-preview").fancybox({
        type: 'iframe',
        autoSize : false,
        width : '90%',
        padding : 5
    });

    // Holder config
    Holder.add_theme(
        "bright",
        { background: "white", foreground: "gray", size: 12 }
    );
    /*####################Formulaire Validation######################*/
    $.validator.setDefaults({
        debug: false,
        highlight: function(element, errorClass, validClass) {
            if($(element).parent().is("p")){
                $(element).parent().addClass("error");
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            if($(element).parent().is("p")){
                $(element).parent().removeClass("error");
            }
        },
        // the errorPlacement has to take the table layout into account
        errorPlacement: function(error, element) {
            if ( element.is(":radio") ){
                error.insertAfter(element);
            }else if ( element.is(":checkbox") ){
                error.insertAfter(element);
            }else if ( element.is("select")){
                if(element.next().is(":submit")){
                    if($('.mc-error').length == 0){
                        $(document.createElement("div"))
                            .addClass('mc-error clearfix')
                            .insertAfter(element.next())
                            .append(
                            error
                        );
                    }

                    //error.insertAfter(element.next()).appendTo('')
                }else{
                    error.insertAfter(element);
                }/*else{
                    error.insertAfter(element);
                    $("<br /><br />").insertBefore(error);
                }*/

            }else if ( element.next().is(".input-group-btn") ){
                error.insertAfter(element.parent());
            }else if ( element.is(".checkMail") ){
                error.insertAfter(element.next());
            }else if ( element.is("#cryptpass") ){
                error.insertAfter(element.next());
                $("<br />").insertBefore(error);
            }else{
                if(element.next().is(":button") || element.next().is(":file")){
                    error.insertAfter(element);
                    $("<br />").insertBefore(error);
                }else if ( element.next().is(":submit") ){
                    error.insertAfter(element.parent());
                    //$("<br />").insertBefore(error);
                }else{
                    error.insertAfter(element);
                }
            }
        },
        errorClass: "alert alert-warning",
        errorElement:"div",
        validClass: "success",
        // set this class to error-labels to indicate valid fields
        success: function(label) {
            // set &nbsp; as text for IE
            label.remove();
            if($('.mc-error').length != 0){
                $('.mc-error').remove();
            }
        }
    });
});