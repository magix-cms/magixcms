{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <div{if $classCol} class="{$classCol}{/if}">
            <figure class="effect-{$effect} thumbnail">
                {if $item.imgSrc.medium}
                    <img class="img-fluid" src="{$item.imgSrc.medium}" alt="{$item.name|ucfirst}" />
                {else}
                    <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" />
                {/if}
                <figcaption>
                    <h3>{$item.name|ucfirst}</h3>
                    <div class="desc">
                        {if $item.content}
                            <p>{$item.content|strip_tags|truncate:100:'...'}</p>
                        {/if}
                    </div>
                    <a href="{$item.url}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                </figcaption>
            </figure>
        </div>
    {/foreach}
{/if}