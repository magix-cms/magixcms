{* Smarty var for adding class on current element *}
{assign var='class_current' value=' class="active"'}
{if $smarty.server.SCRIPT_NAME == '/index.php'}
    {assign var='home_current' value=$class_current}
{elseif $smarty.server.SCRIPT_NAME == '/catalog.php'}
    {assign var='catalog_current' value=$class_current}
{elseif $smarty.server.SCRIPT_NAME == '/news.php'}
    {assign var='news_current' value=$class_current}
{elseif $smarty.server.SCRIPT_NAME == '/plugins.php'}
    {if $smarty.get.magixmod == 'contact'}
        {assign var='contact_current' value=$class_current}
    {/if}
{/if}
<li{$home_current}>
    <a href="{geturl}/{getlang}/" title="{#show_home#|firststring}">
        {#home#|firststring}
    </a>
</li>
<li{$catalog_current}>
    <a href="{geturl}/{getlang}/{#nav_catalog_uri#}/" title="{#show_catalog#|firststring}">
        {#catalog#|firststring}
    </a>
</li>
<li{$news_current}>
    <a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|firststring}">
        {#news#|firststring}
    </a>
</li>
<li{$contact_current}>
    <a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|firststring}">
        {#contact#|firststring}
    </a>
</li>