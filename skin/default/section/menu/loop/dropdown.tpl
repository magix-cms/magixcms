{if $menuData}
    {assign var='class_current' value=' class="active"'}
    {foreach $menuData as $item}
        <li{if $item.active}{$class_current}{/if}>
            {if $item.subdata}
                <button type="button" class="navbar-toggle{if $item.active} open{/if}" data-toggle="collapse" data-target="#nav-menu-{$item@index}">
                    <span class="fa fa-plus"></span>
                </button>
            {/if}
            <a{if $microData} itemprop="url"{/if} href="{$item.url}" title="{$item.title|ucfirst}"{if $item.subdata} class="has-dropdown"{/if}>
                <span{if $microData} itemprop="name"{/if}>{$item.name|ucfirst}</span>
            </a>
            {if $item.subdata}
                <ul class="dropdown hidden-xs"{if $microData} itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement"{/if}>
                    {foreach $item.subdata as $child}
                        <li{if $child.active}{$class_current}{/if}{if $microData} itemprop="name"{/if}><a{if $microData} itemprop="url"{/if} href="{$child.url}" title="{$child.title|ucfirst}">{$child.name|ucfirst}</a></li>
                    {/foreach}
                </ul>
            {/if}
            {if $item.subdata}
                <nav id="nav-menu-{$item@index}" class="collapse navbar-collapse{if $item.active} in{/if}">
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