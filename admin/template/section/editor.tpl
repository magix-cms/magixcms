{if $config_catalog eq 1}
<script type="text/javascript">
    var catalog_tinymce_plugin = " mc_catalog";
    var catalog_tinymce_button = " mc_catalog";
</script>
    {else}
<script type="text/javascript">
    var catalog_tinymce_plugin = "";
    var catalog_tinymce_button = "";
</script>
{/if}
{if $editor eq 'moxiemanager'}
<script type="text/javascript">
    var manager_tinymce_plugin = " moxiemanager";
    var manager_tinymce_button = " insertfile";
</script>
    {elseif $editor eq 'openFilemanager'}
<script type="text/javascript">
    var manager_tinymce_plugin = " responsivefilemanager";
    var manager_tinymce_button = " responsivefilemanager";
</script>
{/if}
<script type="text/javascript">
    {capture name="tinyMCEstyleSheet"}/{baseadmin}/template/css/tinymce-content.css,{/capture}
    content_css = "{if $content_css != ''}{$smarty.capture.tinyMCEstyleSheet}{$content_css}{/if}";
</script>