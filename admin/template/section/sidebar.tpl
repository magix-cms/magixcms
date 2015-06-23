<ul class="nav">
    {* -- START PAGES -- *}
    {if {employee_access class_name="backend_controller_home"} eq 1}
    <li class="nav-header"><span class="fa fa-file-text-o"></span> Pages</li>
    <li>
        <a href="#home" class="showit{if {script_name} eq "home"} open{/if}">
            <span class="fa fa-plus-square-o"></span> {#home#|ucfirst}
        </a>
        <div class="collapse-item{if {script_name} eq "home"} on{/if}" id="home">
            <div class="lang-group">
                {if {script_name} eq "home"}
                    {if {script_name} eq "home"}{$langActive = ' active'}{else}{$langActive = ''}{/if}
                {else}
                    {$langActive = ''}
                {/if}
                <a class="badge {$langActive}" href="/{baseadmin}/home.php?action=list">
                    <span class="fa fa-list-ul"></span> {#list#|ucfirst}
                </a>
            </div>
        </div>
    </li>
    {/if}
    {if {employee_access class_name="backend_controller_cms"} eq 1 AND $config_cms eq 1}
        <li>
            <a href="#cms" class="showit{if {script_name} eq "cms"} open{/if}">
                <span class="fa fa-plus-square-o"></span> Pages
            </a>
            <div class="collapse-item{if {script_name} eq "cms"} on{/if}" id="cms">
                <div class="lang-group">
                    {foreach $array_lang as $key => $value nocache}
                        {if {script_name} eq "cms"}
                            {if $smarty.get.getlang == $key}{$langActive = ' active'}{else}{$langActive = ''}{/if}
                        {else}
                            {$langActive = ''}
                        {/if}
                        <a class="badge{$langActive}" href="/{baseadmin}/cms.php?getlang={$key}&amp;action=list">{$value|upper}</a>
                    {/foreach}
                </div>
            </div>
        </li>
    {/if}
    {* -- END PAGES -- *}
</ul>
{if {employee_access class_name="backend_controller_news"} eq 1 AND $config_news eq 1}
    <ul class="nav">
        {* -- START NEWS -- *}
        <li class="nav-header"><span class="fa fa-rss"></span> {#news#|ucfirst}</li>
        <li>
            <a href="#news" class="showit{if {script_name} eq "news"} open{/if}">
                <span class="fa fa-plus-square-o"></span> {#article#|ucfirst}
            </a>
            <div class="collapse-item{if {script_name} eq "news"} on{/if}" id="news">
                <div class="lang-group">
                    {foreach $array_lang as $key => $value nocache}
                        {if {script_name} eq "news"}
                            {if $smarty.get.getlang == $key}{$langActive = ' active'}{else}{$langActive = ''}{/if}
                        {else}
                            {$langActive = ''}
                        {/if}
                        <a class="badge{$langActive}" href="/{baseadmin}/news.php?getlang={$key}&amp;action=list">{$value|upper} </a>
                    {/foreach}
                </div>
            </div>
        </li>
        {* -- END NEWS -- *}
    </ul>
{/if}
{if {employee_access class_name="backend_controller_catalog"} eq 1 AND $config_catalog eq 1}
    <ul class="nav">
        {* -- START CATALOG -- *}
        <li class="nav-header"><span class="fa fa-shopping-cart"></span> {#catalog#|ucfirst}</li>
        <li>
            <a href="#catalog-category" class="showit{if {script_name} eq "catalog:category" OR {script_name} eq "catalog:subcategory"} open{/if}">
                <span class="fa fa-plus-square-o"></span> {#category#|ucfirst}
            </a>
            <div class="collapse-item{if {script_name} eq "catalog:category" OR {script_name} eq "catalog:subcategory"} on{/if}" id="catalog-category">
                <div class="lang-group">
                    {foreach $array_lang as $key => $value nocache}
                        {if {script_name} eq "catalog:category" OR {script_name} eq "catalog:subcategory"}
                            {if $smarty.get.getlang == $key}{$langActive = ' active'}{else}{$langActive = ''}{/if}
                        {else}
                            {$langActive = ''}
                        {/if}
                        <a class="badge{$langActive}" href="/{baseadmin}/catalog.php?section=category&amp;getlang={$key}">{$value|upper} </a>
                    {/foreach}
                </div>
            </div>
        </li>
        <li>
            <a href="#catalog-product" class="showit{if {script_name} eq "catalog:product"} open{/if}">
                <span class="fa fa-plus-square-o"></span> {#products#|ucfirst}
            </a>
            <div class="collapse-item{if {script_name} eq "catalog:product"} on{/if}" id="catalog-product">
                <div class="lang-group">
                    {foreach $array_lang as $key => $value nocache}
                        {if {script_name} eq "catalog:product"}
                            {if $smarty.get.getlang == $key}{$langActive = ' active'}{else}{$langActive = ''}{/if}
                        {else}
                            {$langActive = ''}
                        {/if}
                        <a class="badge{$langActive}" href="/{baseadmin}/catalog.php?section=product&amp;getlang={$key}">{$value|upper}</a>
                    {/foreach}
                </div>
            </div>
        </li>
        {* -- END CATALOG -- *}
    </ul>
{/if}
{if $config_plugins eq 1}
    <ul class="nav">
        {* -- START PLUGINS -- *}
        <li class="nav-header"><span class="fa fa-puzzle-piece"></span> Plugins</li>
        {widget_plugins_nav}
        {* -- END NEWS -- *}
    </ul>
{/if}