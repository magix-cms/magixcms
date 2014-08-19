{autoload_i18n}
{switch $message}
{case 'add' break}
{capture name="alert"}
    {#request_success_add#}
{/capture}
{case 'update' break}
{capture name="alert"}
    {#request_success_update#}
{/capture}
{/switch}
<p class="col-sm-6 alert alert-success fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="icon-ok"></span> {$smarty.capture.alert}
</p>