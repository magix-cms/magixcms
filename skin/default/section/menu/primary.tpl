{strip}
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
    {* About *}
{case 'about' break}
{assign var="about_current" value=1}
    {* FAQ *}
{case 'faq' break}
{assign var="faq_current" value=1}
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
    'about'     => false,
    'catalog'   => true,
    'news'      => true,
    'contact'   => true
    ]}
{else}
    {$basic_root = ['home','about','catalog','news','contact']}
    {foreach $basic_root as $section}
        {if !isset($root[$section])}
            {if $section != 'about'}
                {$root[$section] = true}
            {else}
                {$root[$section] = false}
            {/if}
        {/if}
    {/foreach}
{/if}

{* --- Disable submenu links --- *}
{$dropmenu = ['dropdown','tabs','tabs-arrow']}
{if (isset($submenu) && $submenu) || $menu|in_array:$dropmenu}
    {$getPage = 'all'}
    {$getCat = ['category' => 'subcategory']}
{else}
    {$getPage = 'parent'}
    {$getCat = 'category'}
{/if}

{* --- Disable Gmap link --- *}
{if !isset($gmap)}
    {$gmap = false}
{/if}

{* --- Disable FAQ link --- *}
{if !isset($faq)}
    {$faq = false}
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
            'context' => {$getPage}
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
        {$menu[] = $item}
    {/foreach}
{/if}


{* --- Menu Catalog --- *}
{if {#menu_catalog#}}
    {widget_catalog_data
        conf = [
            'context' => {$getCat},
            'select' => [{getlang} => {#menu_catalog#}]
            ]
        assign="categoryList"
    }
    {foreach $categoryList as $category}
        {if $parentCat && $category.id == $parentCat}
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

    {if isset($submenu) && $submenu || $menu|in_array:$dropmenu}
        {widget_catalog_data
            conf = [
                'context' => 'category'
                ]
            assign="categoryList"
        }
        {if $categoryList != null}
            {assign var=submenu value=array()}
            {foreach $categoryList as $category}
                {if $parentCat && $category.id == $parentCat}
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
    {/if}

    {$menu[] = $item}
{/if}


{* --- Menu Pages --- *}
{if {#menu_pages_2#}}
    {widget_cms_data
        conf = [
            'select' => [{getlang} => {#menu_pages_2#}],
            'context' => {$getPage}
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
        {$menu[] = $item}
    {/foreach}
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


{* --- Menu About --- *}
{if $root.about && $about != null}
    {$item = [
    'name'      => {#about_label#},
    'url'       => "{geturl}/{getlang}/about/",
    'title'     => "{#about_title#} {#website_name#}",
    'active'    => $about_current
    ]}
    {if $about.childs != null && (isset($submenu) && $submenu)}
        {assign var=submenu value=array()}
        {foreach $about.childs as $child}
            {if isset($smarty.get.pnum1) && $smarty.get.pnum1 == $child.id}
                {$subactive = 1}
            {else}
                {$subactive = 0}
            {/if}

            {$submenu[] = [
            'name'      => {$child.title},
            'url'       => "{geturl}/{getlang}/about/{$child.uri}-{$child.id}/",
            'title'     => {$child.title},
            'active'    => {$subactive}
            ]}
        {/foreach}
        {$item['subdata'] = $submenu}
    {/if}
    {$menu[] = $item}
{/if}


{* --- Menu FAQ --- *}
{if $faq}
    {$contact = [
    'name'      => {#faq_label#},
    'url'       => "{geturl}/{getlang}/faq/",
    'title'     => {#faq_title#},
    'active'    => $faq_current
    ]}
    {$menu[] = $contact}
{/if}


{* --- Menu Contact --- *}
{if $root.contact}
    {$contact = [
    'name'      => {#contact#},
    'url'       => "{geturl}/{getlang}/contact/",
    'title'     => {#show_contact_form#},
    'active'    => $contact_current
    ]}
    {if $gmap && (isset($submenu) && $submenu)}
        {$contact['subdata'][] = [
        'name'      => {#plan_acces#},
        'url'       => "{geturl}/{getlang}/gmap/",
        'title'     => {#plan_acces#},
        'active'    => $gmap_current
        ]}
    {/if}
    {$menu[] = $contact}
{/if}
{/strip}
{* --- Create Menu HTML --- *}
<nav{if isset($id)} id="{$id}"{/if} class="menu collapse navbar-collapse{if isset($type)} menu-{$type}{/if}{if $menubar} menubar{/if}"{if $microData} itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement"{/if}>
    {if $adjust == 'clip' && $menubar}
    <div class="container">
        {/if}
        <a href="#search" class="sr-only skip-menu" role="link">Passer le menu</a>
        <ul class="nav{if isset($justified) &&$justified } nav-justified{/if}">
            {if isset($submenu) && $submenu || $menu|in_array:$dropmenu}
                {include file="section/menu/loop/dropdown.tpl" menuData=$menu gmap=$gmap microData=$microData}
            {else}
                {include file="section/menu/loop/default.tpl" menuData=$menu gmap=$gmap microData=$microData}
            {/if}
        </ul>
        {if $adjust == 'clip' && $menubar}
    </div>
    {/if}
</nav>