<ol id="breadcrumb" class="breadcrumb container">
{if $smarty.server.SCRIPT_NAME != '/index.php'}
    <li>
        <a href="{geturl}/{getlang}/" title="{#show_home#|firststring}">
            {#home#|firststring}
        </a>
    </li>
        {* # Pages *}
    {if $smarty.server.SCRIPT_NAME == '/cms.php'}
        {if $smarty.get.getidpage_p}
            <li>
                <a href="{geturl}/{$parent.url}" title="{#show_page#|firststring}: {$parent.name}">
                    {$parent.name}
                </a>
            </li>
        {/if}
        <li>
            {$page.name}
        </li>
    {/if}
        {* # Catalogue *}
    {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
        {if $smarty.get.idclc}
                {* ## Root *}
            <li>
                <a href="{geturl}/{getlang}/{#nav_catalog_uri#}" title="{#show_catalog#|firststring}">
                    {#catalog#|firststring}
                </a>
            </li>
            {if $smarty.get.idcls OR $smarty.get.idproduct}
                {* ## Catégories *}
                <li>
                    <a href="{geturl}/{$cat.url}/" title="{#show_category#|firststring}}: {$cat.name}">
                        {$cat.name}
                    </a>
                    </li>
                {if $smarty.get.idcls AND $smarty.get.idproduct}
                    {* ## Sous-catégories *}
                    <li>
                        <a href="{geturl}/{$subcat.url}/" title="{#show_subcategory#|firststring}}: {$subcat.name}">
                            {$subcat.name}
                        </a>
                            </li>
                {elseif $smarty.get.idcls}
                    <li>
                        {$subcat.name}
                    </li>
                    {* /sous-catégories *}
                {/if}
                {if $smarty.get.idproduct}
                    {* ## Produits *}
                    <li>
                        {$product.name}
                    </li>
                {/if}
            {else}
                <li>
                    {$cat.name}
                </li>
                {* /Catégories *}
            {/if}
        {else}
            <li>
                {#catalog#|firststring}
            </li>
            {* /root *}
        {/if}
        {**** /catalog ****}
    {/if}
        {* # Actualités *}
    {if $smarty.server.SCRIPT_NAME == '/news.php'}
            <li>
                {if $smarty.get.tag OR $smarty.get.uri_get_news}
                    <a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|firststring}">
                        {#news#|firststring}
                    </a>
                        {else}
                    {#news#|firststring}
                {/if}
            </li>
            {if $smarty.get.uri_get_news}
                <li>
                    {$news.name}
                </li>
            {/if}
            {if $smarty.get.tag}
                <li>
                   {#theme#|firststring}: {$tag.name}
                </li>
            {/if}
    {/if}
        {**** Plugins ****}
    {if $smarty.server.SCRIPT_NAME == '/plugins.php'}
        {if $smarty.get.magixmod == 'contact'}
            <li>
                {#contact_form#|firststring}
            </li>
        {/if}
    {/if}
    {else}
    <li>
        {#home#|firststring}
    </li>
{/if}
</ol>