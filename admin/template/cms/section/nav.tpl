<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/{baseadmin}/cms.php">CMS</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            {if $smarty.get.getlang}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {#pages_management#|ucfirst} <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/{baseadmin}/cms.php?getlang={$smarty.get.getlang}&amp;action=list">
                            {#list_of_parent_pages#|ucfirst}
                        </a>
                    </li>
                    {if $idcat_p > 0 OR $smarty.get.get_page_p}
                        {if $idcat_p}
                            {assign var="parent_id" value=$idcat_p}
                        {else}
                            {assign var="parent_id" value=$smarty.get.get_page_p}
                        {/if}
                    <li class="divider"></li>
                    <li class="dropdown-header">{$parent_title}</li>
                    <li>
                        <a href="/{baseadmin}/cms.php?getlang={$smarty.get.getlang}&amp;action=list&amp;get_page_p={$parent_id}">
                            {#list_of_child_pages#|ucfirst}
                        </a>
                    </li>
                    {/if}
                </ul>
            </li>
            {else}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {#pages_management#|ucfirst} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        {foreach $array_lang as $key => $value nocache}
                        <li>
                            <a href="/{baseadmin}/cms.php?getlang=1&amp;action=list">
                                {$value|upper}
                            </a>
                        </li>
                        {/foreach}
                    </ul>
                </li>
            {/if}
        </ul>
        {if $smarty.get.getlang}
        <form class="navbar-form navbar-right" role="search">
            <div class="form-group has-feedback">
                <input type="text" id="title_search" name="title_search" placeholder="{#search#}" class="form-control">
                <span class="fa fa-search form-control-feedback"></span>
            </div>
        </form>
        {/if}
    </div>
</nav>