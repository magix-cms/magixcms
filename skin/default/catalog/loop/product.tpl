{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$effect}
    {if !$classCol}
        {$classCol = 'thumbnail col-sm-6 col-md-4 col-lg-4'}
    {/if}
    {if is_array($data) && !empty($data)}
        {foreach $data as $item}
            {if $classCat && is_bool($classCat)}
                {$classCat =  "thumbcat-{$item.id}"}
            {/if}
            <div{if $classCol} class="{$classCol}{if $classCat} {$classCat}{/if}" {/if}>
                <div class="caption">
                    <a class="img" href="{$item.url}" title="{$item.name|ucfirst}">
                        {if $item.imgSrc.medium}
                            <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
                        {else}
                            <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                        {/if}
                    </a>
                    <h3>
                        <a href="{$item.url}" title="{$item.name|ucfirst}">
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
    {else}
    {if !$classCol}
        {$classCol = 'thumbnail col-xs-6 col-sm-6 col-md-4 col-lg-4'}
    {/if}
    {if is_array($data) && !empty($data)}
        {foreach $data as $item}
            {if $classCat && is_bool($classCat)}
                {$classCat =  "thumbcat-{$item.id}"}
            {/if}
            <div{if $classCol} class="{$classCol}{/if}">
                <figure class="effect-apollo">
                    {if $item.imgSrc.medium}
                        <img class="img-responsive" src="{$item.imgSrc.medium}" alt="{$item.name|ucfirst}"/>
                    {else}
                        <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                    {/if}
                    <figcaption>
                        <h3>{$item.name|ucfirst}</h3>
                        {if $item.content}
                            <p>
                                {$item.content|strip_tags|truncate:100:'...'}
                            </p>
                        {/if}
                        <a href="{$item.url}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {/foreach}
    {/if}
{/if}