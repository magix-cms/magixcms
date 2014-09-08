{autoload_i18n}
{switch $message}
{********* Success *********}
{case 'add' break}
    {** Add **}
{capture name="alert_type"}{strip}
    success
{/strip}{/capture}
{capture name="icon"}{strip}
    check
{/strip}{/capture}
{capture name="alert_message"}
    {#request_success_add#}
{/capture}
    {** Update **}
{case 'update' break}
{capture name="alert_type"}{strip}
    success
{/strip}{/capture}
{capture name="icon"}{strip}
    check
{/strip}{/capture}
{capture name="alert_message"}
    {#request_success_update#}
{/capture}
    {** Pinguer **}
{case 'pinguer' break}
{capture name="alert_type"}{strip}
    success
{/strip}{/capture}
{capture name="icon"}{strip}
    check
{/strip}{/capture}
{capture name="alert_message"}
    {#request_pinguer#}
{/capture}
{case 'install_plugin' break}
    {** Add **}
{capture name="alert_type"}{strip}
    success
{/strip}{/capture}
{capture name="icon"}{strip}
    check
{/strip}{/capture}
{capture name="alert_message"}
    {#request_install_plugin#}
{/capture}
{case 'update_plugin' break}
    {** Add **}
{capture name="alert_type"}{strip}
    success
{/strip}{/capture}
{capture name="icon"}{strip}
    check
{/strip}{/capture}
{capture name="alert_message"}
    {#request_update_plugin#}
{/capture}
{********* Warning *********}
    {** Empty **}
{case 'empty' break}
{capture name="alert_type"}{strip}
    warning
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_empty#}
{/capture}
    {** lang_exist **}
{case 'lang_exist' break}
{capture name="alert_type"}{strip}
    warning
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_lang_exist#}
{/capture}
    {** lang_exist **}
{case 'lang_default' break}
{capture name="alert_type"}{strip}
    warning
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_lang_default#}
{/capture}
{case 'child_exist' break}
{capture name="alert_type"}{strip}
    warning
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_child_exist#}
{/capture}
{case 'no_images' break}
{capture name="alert_type"}{strip}
    warning
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_no_images#}
{/capture}
{case 'error_writable' break}
{capture name="alert_type"}{strip}
    warning
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_error_writable#}
{/capture}
{********* Error *********}
    {** error_login **}
{case 'error_login' break}
{capture name="alert_type"}{strip}
    danger
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_error_login#}
{/capture}
{case 'error_hash' break}
{capture name="alert_type"}{strip}
    danger
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_hash#}
{/capture}
    {** access_denied **}
{case 'access_denied' break}
{capture name="alert_type"}{strip}
    danger
{/strip}{/capture}
{capture name="icon"}{strip}
    warning
{/strip}{/capture}
{capture name="alert_message"}
    {#request_access_denied#}
{/capture}
{/switch}
<p class="{if $message neq 'error_login' AND $message neq 'error_hash'}col-sm-6{/if} alert alert-{$smarty.capture.alert_type} fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="fa fa-{$smarty.capture.icon} fa-lg"></span> {$smarty.capture.alert_message}
</p>