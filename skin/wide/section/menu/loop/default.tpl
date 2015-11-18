{if $menuData}
    {assign var='class_current' value=' class="active"'}
    {foreach $menuData as $item}
        <li{if $item.active}{$class_current}{/if}>
            <a href="{$item.url}" title="{$item.title|ucfirst}">
                {$item.name|ucfirst}
            </a>
        </li>
    {/foreach}
{/if}