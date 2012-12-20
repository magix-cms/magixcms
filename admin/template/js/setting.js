/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
    $('a.showit').jmShowIt({
        showcontener : 'div.showcontent',
        open: 'open',
        debug: false
    });
    $('.dropdown-toggle').dropdown();
    $('.nav-collapse > .brand').on('click',function(event){
        event.preventDefault();
        return false;
    });
    $('.unlocked').on('click',function(event){
        event.preventDefault();
        var lock = $('span.icon-lock',this);
        var unlock = $('span.icon-unlock',this);
        if (lock.length != 0) {
            $(this).prev().removeAttr("readonly");
            lock.removeClass('icon-lock').addClass('icon-unlock');
        } else {
            $(this).prev().attr("readonly","readonly");
            unlock.removeClass('icon-unlock').addClass('icon-lock');
        }
    });
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
            }/*else if ( element.is("select")){
                if(element.next().is(":submit")){
                    error.insertAfter(element.next());
                    $("<br />").insertBefore(error);
                }else{
                    error.insertAfter(element);
                    $("<br /><br />").insertBefore(error);
                }
            }*/else if ( element.is(".checkMail") ){
                error.insertAfter(element.next());
            }else if ( element.is("#cryptpass") ){
                error.insertAfter(element.next());
                $("<br />").insertBefore(error);
            }else{
                if(element.next().is(":button") || element.next().is(":file") || element.is("textarea")){
                    error.insertAfter(element);
                    $("<br />").insertBefore(error);
                }else if ( element.next().is(":submit") ){
                    error.insertAfter(element.next());
                    $("<br />").insertBefore(error);
                }else{
                    error.insertAfter(element);
                }
            }
        },
        errorClass: "alert alert-error",
        errorElement:"div",
        validClass: "success",
        // set this class to error-labels to indicate valid fields
        success: function(label) {
            // set &nbsp; as text for IE
            label.remove();
        }
    });
});