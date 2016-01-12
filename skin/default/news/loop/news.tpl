{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-12'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        {if $classCat && is_bool($classCat)}
            {$classCat =  "thumbcat-{$item.id}"}
        {/if}
        <div class="{$classCol}">
            <div class="media row">
                <figure class="col-xs-12 col-md-4 pull-left">
                    <span>
                    {if $item.imgSrc.small}
                        <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
                    {else}
                        <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                    {/if}
                    </span>
                </figure>
                <div class="caption col-xs-12 col-md-8">
                    <h4>{$item.name|ucfirst}</h4>
                    <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                    <p>{$item.content|strip_tags|truncate:200:"..."}</p>
                    {if !empty($item.tagData)}
                        <p class="tag-list">
                            {foreach $item.tagData as $tag}
                                <a href="{$tag.url}" title="{#see_more_news_about#} {$tag.name|ucfirst}">{$tag.name}</a>{if !$tag@last}, {/if}
                            {/foreach}
                        </p>
                    {/if}
                </div>
                <a href="{$item.uri}" title="{$item.name|ucfirst}"><span class="sr-only">{$item.name|ucfirst}</span></a>
            </div>
        </div>
    {/foreach}
{/if}