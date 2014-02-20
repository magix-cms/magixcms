{extends file="news/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$news.name] record=$news.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$news.name] record=$news.name}{/block}
{block name='body:id'}new-record{/block}

{block name="article:content"}
    <h1>{$news.name}</h1>
    <small>
        {#published_on#|ucfirst} {$news.date.register|date_format:"%d-%m-%Y"}
        {if $news.date.publish|date_format:"%d-%m-%Y" != $news.date.register|date_format:"%d-%m-%Y"}
            {#updated_on#} {$news.date.publish|date_format:"%d-%m-%Y"}
        {/if}
    </small>
    {if $news.imgSrc.small}
        <a href="{$news.imgSrc.medium}" class="img-zoom" title="{#zoom_in#}">
            <img src="{$news.imgSrc.small}" alt="{$news.name}" class="pull-right img-polaroid" />
        </a>
    {/if}
    {$news.content}
{/block}