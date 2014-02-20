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
    <ul class="nav nav-pills nav-stacked">
        {foreach $listing as $item}
            <li{if $item.id == $active} class="active"{/if}>
                <a href="{$item.url}" title="{#show_page#|ucfirst}">
                    {$item.name|ucfirst}
                </a>
            </li>
        {/foreach}
    </ul>
{/if}