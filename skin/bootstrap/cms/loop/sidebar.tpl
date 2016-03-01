{if isset($data.id)}
    {$data = [$data]}
{/if}
{$active = $smarty.get.getidpage}
{if is_array($data) && !empty($data)}
    <ul id="secondary-nav" class="nav nav-pills nav-stacked">
        {foreach $data as $item}
            <li{if $item.id == $parent} class="active"{/if}>
                <a href="{$item.url}" title="{$item.name|ucfirst}">
                    {$item.name|ucfirst}
                </a>
                {if $item.subdata}
                    <ul class="hidden-sm">
                    {foreach $item.subdata as $subitem}
                        <li{if $subitem.id == $active} class="active"{/if}>
                            <a href="{$subitem.url}" title="{$subitem.name|ucfirst}">
                                {$subitem.name|ucfirst}
                            </a>
                        </li>
                    {/foreach}
                    </ul>
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}