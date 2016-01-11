{if $menuData}
    {assign var='class_current' value=' class="active"'}
    {foreach $menuData as $item}
        <li{if $item.active}{$class_current}{/if}>
            <a{if $microData} itemprop="url"{/if} href="{$item.url}" title="{$item.title|ucfirst}">
                <span{if $microData} itemprop="name"{/if}>{$item.name|ucfirst}</span>
            </a>
        </li>
    {/foreach}
{/if}