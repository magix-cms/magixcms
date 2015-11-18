{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-12 col-sm-6 col-md-12'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        {if $classCat && is_bool($classCat)}
            {$classCat =  "thumbcat-{$item.id}"}
        {/if}
        <div class="{$classCol}" data-filter="{foreach $item.tagData as $tag}{$tag.name|replace:' ':'-'} {/foreach}">
            <div class="media row">
	            <figure class="col-xs-12 col-md-4 pull-right">
		            {if $item.imgSrc.small}
			            <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
		            {else}
			            <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
		            {/if}
	            </figure>
                <div class="caption col-xs-12 col-md-8">
	                <h4>{$item.name|ucfirst}</h4>
                    <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                    <p>{$item.content|strip_tags|truncate:255:"..."}</p>
                </div>
                <a href="{$item.uri}" title="{#read_more#|ucfirst} {$item.name|ucfirst}"><span class="sr-only">{$item.name|ucfirst}</span></a>
            </div>
        </div>
    {/foreach}
{/if}