{if isset($data.id)}
    {$data = [$data]}
{/if}
{if is_array($data) && !empty($data)}
    <nav class="page-navigation">
        <ul class="pagination">
        {foreach $paginationData as $item}
            {if $item@first}
                <li class="page-item{if !$smarty.get.page || $smarty.get.page == 1} disabled{/if}">
                    <a class="page-link" href="{$item.url}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">{#previous#|ucfirst}</span>
                    </a>
                </li>
            {/if}
            {if is_int($item.name)}
                <li class="page-item{if $smarty.get.page == $item.name || (!$smarty.get.page && $item.name == 1)} active{/if}">
                    <a class="page-link" href="{$item.url}" title="{#show_page#}">
                        {$item.name}
                    </a>
                </li>
            {/if}
            {if $item@last}
                <li class="page-item {if ($smarty.get.page == $item.name)} disabled{/if}">
                    <a class="page-link" href="{$item.url}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            {/if}
        {/foreach}
        </ul>
    </nav>
{/if}