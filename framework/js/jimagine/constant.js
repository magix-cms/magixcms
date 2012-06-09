/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Jimagine.
# Toolbox for jQuery
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
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
*/
/**
 * MAGIX DEV
 * @copyright  MAGIX DEV Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-dev.be
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name constant
 * @exemple :
 * jm_constant.define("lang",jm_lang._init());
	if(jm_constant.defined("lang") == false){
		console.log("Constant is not defined");
	}else{
		console.log(jm_constant.get("lang"));
	}
 * check if defined
 * jm_constant.defined("test"); //false
 * define
 * jm_constant.define("test","mon test"); //true
 * check again
 * jm_constant.defined("test"); //true
 * attempt to redefine
 * jm_constant.define("test","mon test 2");
 * was it constant or it changed ?
 * get da, get da, get da value;
 * jm_constant.get("test"); //mon test
 */
"use strict";
var jm_constant = (function($, undefined){
	var constants = {},
	ownProp = Object.prototype.hasOwnProperty,
	allowed = {
			string : 1,
			number : 1,
			boolean : 1
	};
	return {
		define : function(name, value){
			if(this.defined(name)){
				return false;
			}
			if(!ownProp.call(allowed,typeof value)){
				return false;
			}
			constants[name] = value;
			return true;
		},
		defined: function (name){
			return ownProp.call(constants, name);
		},
		get: function(name){
			if(this.defined(name)){
				return constants[name];
			}else{
                		console.warn('Constants:'+name+' is not defined');
            		}
			return null;
		}
	};
})(jQuery);