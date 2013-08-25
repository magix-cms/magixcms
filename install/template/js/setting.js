/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 sc-box.com <support@magix-cms.com>
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
 * Date: 24/02/13
 * Time: 20:47
 * License: Dual licensed under the MIT or GPL Version
 */
$(function(){
    // jmShowIt config
    $('a.showit').jmShowIt({
        open: 'open',
        contenerClass : 'div.collapse-item',
        activeClass : 'on',
        debug : false
    });
    // dropdown config
    $('.dropdown-toggle').dropdown();

    //Prevent link brand
    $('.nav-collapse .nav .brand').on('click',function(event){
        event.preventDefault();
        return false;
    });

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