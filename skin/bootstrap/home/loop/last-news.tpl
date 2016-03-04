{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-12 col-sm-6 col-md-12'}
{/if}
{if is_array($data) && !empty($data)}
    {*{foreach $data as $item}
        {if $classCat && is_bool($classCat)}
            {$classCat =  "thumbcat-{$item.id}"}
        {/if}
        <div class="{$classCol}" data-filter="{foreach $item.tagData as $tag}{$tag.name|replace:' ':'-'} {/foreach}">
            <div class="media row">
	            <figure class="col-xs-12 col-md-4 pull-right">
		            {if $item.imgSrc.small}
			            <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
		            {else}
			            <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
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
    {/foreach}*}

    {foreach $data as $item}
        {if $item@first && ($item@total == 1 || ($item@total > 2 && $item@total != 5))}
            <div class="row-1 col-xs-12">
                {*<div class="media row">
                    <figure class="col-xs-12 col-md-4 pull-right">
                        {if $item.imgSrc.small}
                            <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                        {else}
                            <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                        {/if}
                    </figure>
                    <div class="caption col-xs-12 col-md-8">
                        <h4>{$item.name|ucfirst}</h4>
                        <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                        <p>{$item.content|strip_tags|truncate:500:"..."}</p>
                    </div>
                    <a href="{$item.uri}" title="{#read_more#|ucfirst} {$item.name|ucfirst}"><span class="sr-only">{$item.name|ucfirst}</span></a>
                </div>*}
                <figure class="effect-clark thumbnail">
                    {if $item.imgSrc.small}
                        <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                    {else}
                        <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                    {/if}
                    <figcaption>
                        <h4>{$item.name|ucfirst}</h4>
                        <div class="desc">
                            <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                            {if $item.content}
                                <p>{$item.content|strip_tags|truncate:500:'...'}</p>
                            {/if}
                        </div>
                        <a href="{$item.uri}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {elseif ($item@index > 0 && $item@index < 3 && ($item@total == 3 || $item@total == 6)) || ($item@index < 2 && ($item@total == 2 || $item@total == 5))}
            <div class="row-2 col-xs-12 col-md-6">
                {*<div class="media row">
                    <figure class="col-xs-12 col-md-4 pull-right">
                        {if $item.imgSrc.small}
                            <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                        {else}
                            <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                        {/if}
                    </figure>
                    <div class="caption col-xs-12 col-md-8">
                        <h4>{$item.name|ucfirst}</h4>
                        <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                        <p>{$item.content|strip_tags|truncate:255:"..."}</p>
                    </div>
                    <a href="{$item.uri}" title="{#read_more#|ucfirst} {$item.name|ucfirst}"><span class="sr-only">{$item.name|ucfirst}</span></a>
                </div>*}
                <figure class="effect-clark thumbnail">
                    {if $item.imgSrc.small}
                        <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                    {else}
                        <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                    {/if}
                    <figcaption>
                        <h4>{$item.name|ucfirst}</h4>
                        <div class="desc">
                            <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                            {if $item.content}
                                <p>{$item.content|strip_tags|truncate:255:'...'}</p>
                            {/if}
                        </div>
                        <a href="{$item.uri}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {elseif ($item@total > 3)}
            <div class="row-3 hidden-sm-down col-md-4">
                {*<div class="media row">
                    <figure class="col-xs-12 col-md-4 pull-right">
                        {if $item.imgSrc.small}
                            <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                        {else}
                            <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                        {/if}
                    </figure>
                    <div class="caption col-xs-12 col-md-8">
                        <h4>{$item.name|ucfirst}</h4>
                        <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                        <p>{$item.content|strip_tags|truncate:140:"..."}</p>
                    </div>
                    <a href="{$item.uri}" title="{#read_more#|ucfirst} {$item.name|ucfirst}"><span class="sr-only">{$item.name|ucfirst}</span></a>
                </div>*}
                <figure class="effect-clark thumbnail">
                    {if $item.imgSrc.small}
                        <img class="img-fluid" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                    {else}
                        <img class="img-fluid" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}" width="480" height="360"/>
                    {/if}
                    <figcaption>
                        <h4>{$item.name|ucfirst}</h4>
                        <div class="desc">
                            <time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time>
                            {if $item.content}
                                <p>{$item.content|strip_tags|truncate:100:'...'}</p>
                            {/if}
                        </div>
                        <a href="{$item.uri}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {/if}
    {/foreach}
{/if}