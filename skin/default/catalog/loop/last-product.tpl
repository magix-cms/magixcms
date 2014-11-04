{if isset($data.id)}
    {$data = [$data]}
{/if}
{if is_array($data) && !empty($data)}
    <p class="lead">{#last_products#}</p>
    {foreach $data as $item}
        <a class="thumbnail text-center col-xs-6 col-sm-12" href="{$item.url}" title="{$item.name|ucfirst}">
            {if $item.imgSrc.small}
                <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
            {else}
                <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
            {/if}
            <span class="panel-title">{$item.name|ucfirst}</span>
            {if $item.price}
            <span class="price label label-primary">{$item.price}</span>
            {/if}
        </a>
    {/foreach}
{/if}