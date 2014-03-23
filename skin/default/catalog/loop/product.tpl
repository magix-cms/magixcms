{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'thumbnail col-sm-6 col-md-4 col-lg-3'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <div{if $classCol} class="{$classCol}" {/if}>
            <a class="img" href="{$item.url}" title="{#show_page#|ucfirst}">
                {if $item.imgSrc.medium}
                    <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
                {else}
                    <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                {/if}
            </a>
            <div class="caption">
                <h3>
                    <a href="{$item.url}" title="{#show_page#|ucfirst}">
                        {$item.name|ucfirst}
                    </a>
                </h3>
                <p>
                    {if $item.content}
                        {$item.content|strip_tags|truncate:250:'...'}
                    {/if}
                </p>
            </div>
        </div>
    {/foreach}
{/if}