{if $main}
    <p class="h2">
        {if $main.url}<a href="{$main.url}" title="{#show_page#|ucfirst}">{/if}
            {$main.name|ucfirst}
            {if $main.url}</a>{/if}
    </p>
{/if}
{if isset($listing.id)}
    {$listing = [$listing]}
{/if}
{if is_array($listing) && !empty($listing)}
    {foreach $listing as $item}
        <a class="btn btn-xs btn-{if $item.id == $active}primary{else}default{/if}" href="{$item.url}" title="{#show_more#|ucfirst}">
            {$item.name|ucfirst}
        </a>
    {/foreach}
{/if}