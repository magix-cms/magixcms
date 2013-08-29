{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>#seo_d_static_plugin_contact#]}}
    <title>{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>#seo_t_static_plugin_contact#]}</title>
{include file="section/css.tpl"}
</head>
<body id="contact">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
        <div id="article" class="span12">
            <div id="article-inner" class="span10">
            <div class="mc-message clearfix"></div>
            <h1>{#contact_root_h1#}</h1>
            <form id="contact-form" method="post" action="{$smarty.server.REQUEST_URI}" class="form-horizontal">
                <legend>{#contact_fiels_resquest#}</legend>
                <div class="control-group">
                    <label class="control-label" for="nom">
                        {#pn_contact_lastname#}* :
                    </label>
                    <div class="controls">
                        <input id="nom" type="text" name="nom" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="prenom">
                        {#pn_contact_firstname#}* :
                    </label>
                    <div class="controls">
                        <input id="prenom" type="text" name="prenom" value="" size="40" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">
                        {#pn_contact_mail#}* :
                    </label>
                    <div class="controls">
                        <input id="email" type="text" name="email" value="" size="40" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="tel">
                    {#pn_contact_phone#} :
                    </label>
                    <div class="controls">
                        <input id="tel" type="text" name="tel" value="" size="20" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="adresse">
                    {#pn_contact_address#} :
                    </label>
                    <div class="controls">
                        <input id="adresse" type="text" name="adresse" value="" size="40" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="programme">
                    {#pn_contact_programme#} :
                    </label>
                    <div class="controls">
                        <input id="programme" type="text" name="programme" value="{$smarty.post.moreinfo}" size="40" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="programme">
                    {#pn_contact_message#} :
                    </label>
                    <div class="controls">
                        <textarea id="message" name="message" rows="5" cols="50"></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <p class="control-label">
                        &nbsp;
                    </p>
                    <div class="controls">
                        <input id="getLanguage" type="hidden" name="getLanguage" value="{getlang}" />
                        <input type="submit" class="btn btn-primary" value="{#pn_contact_send#|firststring}" />
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
{script src="/min/?f=libjs/plugins/localization/messages_{getlang}.js,plugins/contact/js/public.0.3.js" concat=$concat type="javascript"}
<script type="text/javascript">
    $(function(){
        if (typeof MC_plugins_contact == "undefined")
        {
            console.log("MC_plugins_contact is not defined");
        }else{
            MC_plugins_contact.run(iso);
        }
    });
</script>
</body>
</html>