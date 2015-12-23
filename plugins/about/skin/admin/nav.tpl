<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#about-navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bar"></span>
            <span class="fa fa-bar"></span>
            <span class="fa fa-bar"></span>
        </button>
        <a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=index" class="navbar-brand">{#root_about#|ucfirst}</a>
    </div>
    <div id="about-navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li>
                <a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=page"><span class="fa fa-file-text-o"></span> {#page_admin#|ucfirst}</a>
            </li>
            {if isset($smarty.get.parent) || isset($page) && ($page.idpage_p != 0)}
                {if isset($smarty.get.parent)}
                    {$parent = $smarty.get.parent}
                {else}
                    {$parent = $page.idpage_p}
                {/if}
                <li>
                    <a href="{$pluginUrl}&amp;tab=page&amp;action=getchild&amp;parent={$parent}"><span class="fa fa-file-text-o"></span> {#subpage_admin#|ucfirst}</a>
                </li>
            {/if}
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="pull-right">
                <a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=about"><span class="fa fa-info-circle"></span> {#plugin_about#|ucfirst}</a>
            </li>
        </ul>
    </div>
</nav>