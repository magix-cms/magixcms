{if $menuData}
    {assign var='class_current' value=' class="active"'}
    {foreach $menuData as $key => $item}
        <li class="menu-item{if $key == 'catalog'} mgdropdown{/if}{if $item.active && !(isset($smarty.get.idclc) && $smarty.get.idclc == {#id_mainCat#} && $key == 'catalog')} active{/if}">
            {if $item.subdata}
                <button type="button" class="navbar-toggle{if $item.active} open{/if}" data-toggle="collapse" data-target="#nav-{$menu}-{$item@index}">
                    <span class="fa fa-plus"></span>
                </button>
            {/if}
            <a{if $microData} itemprop="url"{/if} href="{$item.url}" title="{$item.title|ucfirst}"{if $item.subdata} class="has-dropdown"{/if}>
                <span{if $microData} itemprop="name"{/if}>{$item.name|ucfirst}</span>
            </a>
            {if $item.subdata && $key == 'catalog'}
                <div class="dropdown hidden-xs {$key}"{if $microData} itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement"{/if}>
                    {foreach $item.subdata as $child}
                        <div class="col-sm-3">
                            <h5{if $child.active}{$class_current}{/if}{if $microData} itemprop="name"{/if}>
                                <a{if $microData} itemprop="url"{/if} href="{$child.url}" title="{$child.title|ucfirst}">{$child.name|ucfirst}</a>
                            </h5>
                            {if $child.subdata}
                                <ul class="nav"{if $microData} itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement"{/if}>
                                    {foreach $child.subdata as $subitem}
                                        <li{if $subitem.active}{$class_current}{/if}{if $microData} itemprop="name"{/if}>
                                            <a{if $microData} itemprop="url"{/if} href="{$subitem.url}" title="{$subitem.title|ucfirst}">{$subitem.name|ucfirst}</a>
                                        </li>
                                    {/foreach}
                                </ul>
                            {/if}
                        </div>
                    {/foreach}
                </div>
            {else}
                <ul class="dropdown hidden-xs"{if $microData} itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement"{/if}>
                    {foreach $item.subdata as $child}
                        <li{if $child.active}{$class_current}{/if}{if $microData} itemprop="name"{/if}><a{if $microData} itemprop="url"{/if} href="{$child.url}" title="{$child.title|ucfirst}">{$child.name|ucfirst}</a></li>
                    {/foreach}
                </ul>
            {/if}
            {if $item.subdata}
                <nav id="nav-{$menu}-{$item@index}" class="collapse navbar-collapse{if $item.active} in{/if}">
                    <ul>
                        {foreach $item.subdata as $child}
                            <li{if $child.active}{$class_current}{/if}>
                                <a href="{$child.url}" title="{$child.title|ucfirst}">{$child.name|ucfirst}</a>
                            </li>
                        {/foreach}
                    </ul>
                </nav>
            {/if}
        </li>
    {/foreach}
{/if}