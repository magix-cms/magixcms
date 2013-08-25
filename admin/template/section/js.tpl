{script src="/{baseadmin}/min/?g=adminjs,jimagine,globalize" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/plugins/modernizr.2.6.2.js,{baseadmin}/template/js/cultures/{iso}.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    $.nicenotify.notifier = {
        box:"",
        elemclass : '.mc-message'
    };
    var editor_version = "{$smarty.const.VERSION_EDITOR}";
    var baseadmin = "{baseadmin}";
    var edit = "{$smarty.get.edit}";
    var getlang = "{$smarty.get.getlang}";
    var iso = "{iso}";
</script>