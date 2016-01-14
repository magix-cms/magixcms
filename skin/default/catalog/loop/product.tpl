{strip}
{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-12 col-sm-6'}
{/if}
{if !$truncate}
    {$truncate = 250}
{/if}
{/strip}
{if is_array($data) && !empty($data)}
    {if isset($effect) && $effect eq "bob"}
        {foreach $data as $item}
            {if $classCat && is_bool($classCat)}
                {$classCat =  "thumbcat-{$item.id}"}
            {/if}
            <div{if $classCol} class="{$classCol}{/if}">
                <figure class="effect-bob thumbnail">
                    <div class="round-div"></div>
                    <div class="center-img">
                        {if $item.imgSrc.medium}
                            <img src="{$item.imgSrc.medium}" alt="{$item.name|ucfirst}"/>
                        {else}
                            <img src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                        {/if}
                    </div>
                    <figcaption>
                        <h3>{$item.name|ucfirst}</h3>
                        <div class="desc">
                            {if $item.content}
                                <p>
                                    {$item.content|strip_tags|truncate:$truncate:'...'}
                                </p>
                            {/if}
                        </div>
                        <a href="{$item.url}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {/foreach}
    {else}
        {foreach $data as $item}
            {if $classCat && is_bool($classCat)}
                {$classCat =  "thumbcat-{$item.id}"}
            {/if}
            <div{if $classCol} class="{$classCol}{/if}" itemprop="{if $similar}isRelatedTo{else}itemListElement{/if}" itemscope itemtype="http://schema.org/Product">
                <figure class="{if $effect}effect-{$effect} {/if}thumbnail">
                    {if $item.imgSrc.medium}
                        <img class="img-responsive" src="{$item.imgSrc.medium}" alt="{$item.name|ucfirst}" itemprop="image"/>
                    {else}
                        <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                    {/if}
                    <figcaption>
                        <h3 itemprop="name">{$item.name|ucfirst}</h3>
                        <div itemprop="description" class="desc">
                            {if $item.content}
                                <p>
                                    {$item.content|strip_tags|truncate:$truncate:'...'}
                                </p>
                            {/if}
                        </div>
                        <a itemprop="url" href="{$item.url}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {/foreach}
    {/if}
{/if}