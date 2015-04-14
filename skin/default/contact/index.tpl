{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>#seo_t_static_plugin_contact#]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>#seo_d_static_plugin_contact#]}{/block}
{block name='body:id'}contact{/block}

{block name="article:content"}
    <h1>{#contact_root_h1#}</h1>
    <form id="contact-form" method="post" action="{$smarty.server.REQUEST_URI}" class="form-horizontal">
        <legend>{#contact_fiels_resquest#|ucfirst}</legend>
        <div class="form-group">
            <label class="col-md-3" for="lastname">
                {#pn_contact_lastname#|ucfirst}* :
            </label>
            <div class="col-md-6">
                <input id="lastname" type="text" name="lastname" value="" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="firstname">
                {#pn_contact_firstname#|ucfirst}* :
            </label>
            <div class="col-md-6">
                <input id="firstname" type="text" name="firstname" value="" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="email">
                {#pn_contact_mail#|ucfirst}* :
            </label>
            <div class="col-md-6">
                <input id="email" type="text" name="email" value="" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="tel">
                {#pn_contact_phone#|ucfirst} :
            </label>
            <div class="col-md-6">
                <input id="phone" type="text" name="phone" value="" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="adress">
                {#pn_contact_address#|ucfirst} :
            </label>
            <div class="col-md-6">
                <input id="adress" type="text" name="adress" value="" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="title">
                {#pn_contact_programme#|ucfirst} :
            </label>
            <div class="col-md-6">
                <input id="title" type="text" name="title" value="{$smarty.post.moreinfo}" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="content">
                {#pn_contact_message#|ucfirst} :
            </label>
            <div class="col-md-6">
                <textarea id="content" name="content" rows="5" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group">
            <p class="col-md-3">
                &nbsp;
            </p>
            <div class="col-md-6">
                <input type="submit" class="btn btn-primary" value="{#pn_contact_send#|ucfirst}" />
            </div>
        </div>
        <div class="mc-message"></div>
    </form>
{/block}
{block name='aside:content' append}
    {widget_news_data
        conf =[
        'context' =>  'last-news',
        'limit' => 3
        ]
        assign='newsData'
    }
    <div class="news-list-last sidebar-list row">
        {include file="news/loop/sidebar.tpl" data=$newsData}
    </div>
{/block}
{block name="foot" append}
    {capture name="scriptContact"}{strip}
        /min/?f=
        {if {getlang} eq 'fr'}libjs/vendor/localization/messages_{getlang}.js,{/if}
        plugins/contact/js/public.0.3.js
    {/strip}{/capture}
    {script src=$smarty.capture.scriptContact concat=$concat type="javascript"}
    <script type="text/javascript">
        $.nicenotify.notifier = {
            box:"",
            elemclass : '.mc-message'
        };
        var iso = '{getlang}';
        $(function(){
            if (typeof MC_plugins_contact == "undefined")
            {
                console.log("MC_plugins_contact is not defined");
            }else{
                MC_plugins_contact.run(iso);
            }
        });
    </script>
{/block}