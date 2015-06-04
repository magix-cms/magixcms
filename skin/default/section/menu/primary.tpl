{* Smarty switch to detect current element *}
{switch $smarty.server.SCRIPT_NAME}
    {* Home *}
{case '/index.php' break}
{assign var="home_current" value=1}
    {* Pages *}
{case '/cms.php' break}
{if isset($smarty.get.getidpage_p)}
    {assign var="pageSection" value=$smarty.get.getidpage_p}
{else}
    {assign var="pageSection" value=$smarty.get.getidpage}
{/if}
{assign var="activePage" value=$smarty.get.getidpage}
    {* Catalogue *}
{case '/catalog.php' break}
{if isset($smarty.get.idclc)}
    {assign var="parentCat" value=$smarty.get.idclc}
{/if}
{if isset($smarty.get.idcls)}
    {assign var="subCat" value=$smarty.get.idcls}
{/if}
    {* Actualités *}
{case '/news.php' break}
{assign var="news_current" value=1}
    {* Plugins *}
{case '/plugins.php' break}
{switch $smarty.get.magixmod}
    {* Contact *}
{case 'contact' break}
{assign var="contact_current" value=1}
    {* Gmap *}
{case 'gmap' break}
{assign var="gmap_current" value=1}
{/switch}
{/switch}


{* --- Array Menu --- *}
{assign var=menu value=array()}

{* --- Check Active Roots --- *}
{if !isset($root)}
    {$root = [
    'home'      => true,
    'catalog'   => true,
    'news'      => true,
    'contact'   => true
    ]}
{else}
    {$basic_root = ['home','catalog','news','contact']}
    {foreach $basic_root as $section}
        {if !isset($root[$section])}
            {$root[$section] = true}
        {/if}
    {/foreach}
{/if}

{* --- Disable Gmap link --- *}
{if !isset($gmap)}
    {$gmap = false}
{/if}


{* --- Menu Home --- *}
{if $root.home}
    {$menu[] = [
    'name'      => {#home#},
    'url'       => "{geturl}/{getlang}/",
    'title'     => {#show_home#},
    'active'    => $home_current
    ]}
{/if}


{* --- Menu Pages --- *}
{if {#menu_pages#}}
    {widget_cms_data
    conf = [
    'select' => [{getlang} => {#menu_pages#}],
'context' => 'all'
]
assign="pageList"
}
    {foreach $pageList as $page}
        {if $pageSection && $page.id == $pageSection}
            {$active = 1}
        {else}
            {$active = 0}
        {/if}
        {$item = [
        'name'      => {$page.name},
        'url'       => {$page.url},
        'title'     => {$page.name},
        'active'    => {$active}
        ]}
        {$submenu = 0}
        {if $page.subdata}
            {assign var=submenu value=array()}
            {foreach $page.subdata as $child}
                {if $pageSection && $child.id == $activePage}
                    {$subactive = 1}
                {else}
                    {$subactive = 0}
                {/if}
                {$submenu[] = [
                'name'      => {$child.name},
                'url'       => {$child.url},
                'title'     => {$child.name},
                'active'    => {$subactive}
                ]}
            {/foreach}
            {$item['subdata'] = $submenu}
        {/if}
        {$item['subdata'][] = [
        'name'      => {#news#},
        'url'       => "{geturl}/{getlang}/{#nav_news_uri#}/",
        'title'     => {#show_news#},
        'active'    => {$news_current}
        ]}
        {$menu[] = $item}
    {/foreach}
{/if}


{* --- Menu Catalog --- *}
{if {#menu_catalog#}}
    {widget_catalog_data
    conf = [
    'context' => ['category' => 'subcategory'],
    'select' => [{getlang} => {#menu_catalog#}]
]
assign="categoryList"
}
    {foreach $categoryList as $category}
        {if $parentCat && $categories.id == $parentCat}
            {$active = 1}
        {else}
            {$active = 0}
        {/if}
        {$item = [
        'name'      => {$category.name},
        'url'       => {$category.url},
        'title'     => {$category.name},
        'active'    => {$active}
        ]}
        {$submenu = 0}
        {if $category.subdata}
            {assign var=submenu value=array()}
            {foreach $category.subdata as $child}
                {if $subCat && $child.id == $subCat}
                    {$subactive = 1}
                {else}
                    {$subactive = 0}
                {/if}
                {$submenu[] = [
                'name'      => {$child.name},
                'url'       => {$child.url},
                'title'     => {$child.name},
                'active'    => {$subactive}
                ]}
            {/foreach}
            {$item['subdata'] = $submenu}
        {/if}
        {$menu[] = $item}
    {/foreach}
{elseif $root.catalog}
    {widget_catalog_data
    conf = [
    'context' => 'category'
    ]
    assign="categoryList"
    }

    {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
        {$active = 1}
    {else}
        {$active = 0}
    {/if}

    {$item = [
    'name'      => {#catalog#},
    'url'       => "{geturl}/{getlang}/{#nav_catalog_uri#}/",
    'title'     => {#catalog#},
    'active'    => {$active}
    ]}
    {if $categoryList != null}
        {assign var=submenu value=array()}
        {foreach $categoryList as $category}
            {if $parentCat && $categories.id == $parentCat}
                {$subactive = 1}
            {else}
                {$subactive = 0}
            {/if}

            {$submenu[] = [
            'name'      => {$category.name},
            'url'       => {$category.url},
            'title'     => {$category.name},
            'active'    => {$subactive}
            ]}
        {/foreach}
        {$item['subdata'] = $submenu}
    {/if}

    {$menu[] = $item}
{/if}


{* --- Menu News --- *}
{if $root.news}
    {$menu[] = [
    'name'      => {#news#},
    'url'       => "{geturl}/{getlang}/{#nav_news_uri#}/",
    'title'     => {#show_news#},
    'active'    => {$news_current}
    ]}
{/if}


{* --- Menu Contact --- *}
{if $root.contact}
    {$contact = [
    'name'      => {#contact#},
    'url'       => "{geturl}/{getlang}/contact/",
    'title'     => {#show_contact_form#},
    'active'    => $contact_current
    ]}
    {if $gmap}
        {$contact['subdata'] = [
        [
        'name'      => {#plan_acces#},
        'url'       => "{geturl}/{getlang}/gmap/",
        'title'     => {#plan_acces#},
        'active'    => $gmap_current
        ]
        ]
        }
    {/if}
    {$menu[] = $contact}
{/if}

{* --- Create Menu HTML --- *}
<nav{if isset($id)} id="{$id}"{/if} class="collapse navbar-collapse{if isset($type)} menu-{$type}{/if}">
    <ul class="nav-primary nav navbar-nav pull-right">{*root=['news' => false]*}
        {include file="section/menu/loop/$type.tpl" menuData=$menu gmap=false}
    </ul>
</nav>