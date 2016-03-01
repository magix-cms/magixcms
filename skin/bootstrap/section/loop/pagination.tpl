{if isset($data.id)}
    {$data = [$data]}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $paginationData as $item}
        {if is_int($item.name)}
            <li{if $smarty.get.page == $item.name || (!$smarty.get.page && $item.name == 1)} class="active"{/if}>
                <a href="{$item.url}" title="{#show_page#}">
                        {$item.name}
                </a>
            </li>
        {/if}
    {/foreach}
{/if}