{autoload_i18n}
{switch $message}
{case 'save' break}
{capture name="alert"}
    {#request_success_save#}
{/capture}
{capture name="type"}
    alert-success
{/capture}
{case 'refresh_lang' break}
{capture name="alert"}
    {#request_success_refresh#}
{/capture}
{capture name="type"}
    alert-success
{/capture}
{/switch}
<p class="col-sm-12 alert {$smarty.capture.type} fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="icon-ok"></span> {$smarty.capture.alert|ucfirst}
</p>