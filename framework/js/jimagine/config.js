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
 * @version    0.1
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name config
 * 
 */
(function(){
    if (typeof Object.create === 'function') {
        return;
    }
    function F(){}
    Object.create = function( o ) {
        F.prototype = o;
        return new F();
    };
})();
$(function(){
	//usage : log('inside',this,arguments);
	/*var test = $("#logo img").attr("src");
	log(test, $("#header"), arguments);*/
	window.log = function(){
		log.history = log.history || [];
		log.history.push(arguments);
		if(this.console){
			arguments.callee = arguments.callee.caller;
			var newarr = [].slice.call(arguments);
			(typeof console.log === 'object' ? log.apply.call(console.log,console, newarr) : console.log.apply(console, newarr));
		}
	};
	// make if safe to use console.log always
	(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try{console.log();return window.console;}catch(err){return window.console={};}})());
});