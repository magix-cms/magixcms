{$listing = $data}
{if is_array($listing) && !empty($listing)}
    <ul class="nav nav-pills nav-stacked">
        {foreach $listing as $key => $value}
            <li{if $smarty.get.idclc == $value.id} class="active"{/if}>
                <a href="{$value.url}" title="{#show_page#|ucfirst}">
                    {$value.name|ucfirst}
                </a>
                {if $value.subdata != null}
                    <ul>
                        {foreach $value.subdata as $subkey => $item}
                            <li>
                                <a href="{$item.url}" title="{#show_page#|ucfirst}">
                                    {$item.name|ucfirst}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}