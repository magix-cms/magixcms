{strip}
{* Default Meta => Home *}
{capture name="ogType"}website{/capture}

{switch $smarty.server.SCRIPT_NAME}
{* Catalogue *}
{case '/catalog.php' break}
{if $smarty.get.idclc}
    {if $smarty.get.idcls OR $smarty.get.idproduct}
        {if $smarty.get.idproduct}
            {capture name="ogType"}article{/capture}
            {* /Produits *}
        {/if}
    {/if}
{/if}
{* /Catalogue *}

{* Actualités *}
{case '/news.php' break}
{if $smarty.get.tag OR $smarty.get.uri_get_news}
    {if $smarty.get.uri_get_news}
        {* News *}
        {capture name="ogType"}article{/capture}
        {* /News *}
    {/if}
{/if}
{* /Actualités *}
{/switch}
prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# {$smarty.capture.ogType}: http://ogp.me/ns/{$smarty.capture.ogType}#"{/strip}