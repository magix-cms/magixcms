    {* # CMS *}
    {if $smarty.server.SCRIPT_NAME == '/cms.php' OR $smarty.server.SCRIPT_NAME == '/index.php'}
        {* ## Navigation *}
        {widget_cms_nav
            conf = [
                'context' => 'all',
                'level' => 'all'
            ]
            htmlAttribut=[
                'id_container' => 'secondary-nav',
                'class_container' => 'nav nav-pills nav-stacked',
                'class_current'     => 'active'
            ]
        }
    {/if}
    {* # Catalog *}
    {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
        {* ## Navigation *}
        {widget_catalog_nav
            conf = [
                'context' => ['category' => 'subcategory']
            ]
            htmlAttribut=[
                'id_container' => 'secondary-nav',
                'class_container' => 'nav nav-pills nav-stacked',
                'class_current'     => 'active'
            ]
        }
    {/if}
    {* # News *}
    {if $smarty.server.SCRIPT_NAME == '/news.php'}
        {* ## Navigation *}
        {widget_news_nav
            htmlAttribut=[
                'id_container' => 'secondary-nav',
                'class_container' => 'nav nav-pills nav-stacked',
                'class_current'     => 'active'
            ]
            prepend="<p class='lead'>{#news_by_theme#}</p>"
        }
    {/if}