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