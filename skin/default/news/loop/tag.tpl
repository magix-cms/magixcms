{if isset($listing.id)}
    {$listing = [$listing]}
{/if}
{if is_array($listing) && !empty($listing)}
    {foreach $listing as $item}
        {$choose = false}
        {if is_array($active)}
            {foreach $active as $tag}
                {if $tag.id == $item.id}
                    {$choose = true}
                {/if}
            {/foreach}
        {else}
            {if $item.id == $active}
                {$choose = true}
            {/if}
        {/if}
        <li>
            <a class="btn btn-box btn-flat btn-{if $choose}main-theme{else}default{/if} tag" href="{$item.url}" data-ref="tag-{$item.name|replace:' ':'-'}" title="{$item.name|ucfirst}">
                {$item.name|ucfirst}
            </a>
        </li>
    {/foreach}
{/if}