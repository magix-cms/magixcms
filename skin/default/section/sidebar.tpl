<div id="primary-sidebar" class="span3">
    {* # Pages *}
    {if $smarty.server.SCRIPT_NAME == '/cms.php' OR $smarty.server.SCRIPT_NAME == '/index.php'}
        {* ## Navigation *}
        {widget_cms_nav
            conf = [
                'context' => 'all',
                'level' => 'all'
            ]
            htmlAttribut=[
                'id_container' => 'secondary-nav',
                'class_container' => 'nav nav-list well',
                'class_current'     => 'active'
            ]
        }
    {/if}
    {* # Catalogue *}
    {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
        {* ## Navigation *}
        {widget_catalog_nav
            conf = [
                'context' => ['category' => 'subcategory']
            ]
            htmlAttribut=[
                'id_container' => 'secondary-nav',
                'class_container' => 'nav nav-list well',
                'class_current'     => 'active'
            ]
        prepend="<li class='nav-header'>{#catalog_navigation#}</li>"
        }
        {* ## Dernier produit *}
        {widget_catalog_display
            conf = [
                'context' => 'last-product',
                'limit' => 2
            ]
            pattern = 'sidebar'
            prepend = "<li class='nav-header'>{#last_products#}</li>"
        }
    {/if}
    {* # Actualités *}
    {if $smarty.server.SCRIPT_NAME == '/news.php'}
        {* ## Navigation *}
        {widget_news_nav
            htmlAttribut=[
                'id_container' => 'secondary-nav',
                'class_container' => 'nav nav-list well',
                'class_current'     => 'active'
            ]
            prepend="<li class='nav-header'>{#news_by_theme#}</li>"
        }
        {* ## Dernières actualités *}
        {widget_news_display
            conf    =   [
                'level' => 'last-news',
                'limit' => 3
            ]
            pattern = 'sidebar'
            prepend = "<li class='nav-header'>{#last_news#}</li>"
        }
    {/if}
</div>