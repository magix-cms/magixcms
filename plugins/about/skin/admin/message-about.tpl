{autoload_i18n}
{switch $message}
{case 'save' break}
{capture name="alert"}
    {#request_success_save#}
{/capture}
{capture name="type"}
    alert-success
{/capture}
{capture name="icon"}
    fa-check
{/capture}
{case 'refresh_lang' break}
{capture name="alert"}
    {#request_success_refresh#}
{/capture}
{capture name="type"}
    alert-success
{/capture}
{capture name="icon"}
    fa-check
{/capture}
{case 'already_exist' break}
{capture name="alert"}
    {#request_warning_exist#}
{/capture}
{capture name="type"}
    alert-warning
{/capture}
{capture name="icon"}
    fa-warning
{/capture}
{case 'delete' break}
{capture name="alert"}
    {#request_success_delete#}
{/capture}
{capture name="type"}
    alert-success
{/capture}
{capture name="icon"}
    fa-check
{/capture}
{/switch}
<p class="col-sm-12 alert {$smarty.capture.type} fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="fa {$smarty.capture.icon}"></span> {$smarty.capture.alert|ucfirst}
</p>