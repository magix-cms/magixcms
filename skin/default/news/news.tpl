{extends file="news/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$news.name] record=$news.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$news.name] record=$news.name}{/block}
{block name='body:id'}new-record{/block}

{block name='article'}
    <article id="article" class="col-xs-12 col-sm-8 col-md-9" itemprop="mainEntity" itemscope itemtype="http://schema.org/Article">
    {block name='article:content'}
        <meta itemprop="mainEntityOfPage" content="{geturl}{$news.uri}"/>
        <h1 itemprop="headline">{$news.name}</h1>
        <meta itemprop="wordCount" content="{$news.content|count_words}" />
        <small>
            <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                {#news_by#|ucfirst} <span itemprop="name">{$news.author}</span>
            </span>
            {#published_on#|ucfirst} <time itemprop="datePublished" datetime="{$news.date.register}">{$news.date.register|date_format:"%e %B %Y"}</time>
            {if $news.date.publish|date_format:"%d-%m-%Y" != $news.date.register|date_format:"%d-%m-%Y"}
                {#updated_on#} <time itemprop="dateModified" datetime="{$news.date.publish}">{$news.date.publish|date_format:"%e %B %Y"}</time>
            {/if}
        </small>
        <meta itemprop="description" content="{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$news.name] record=$news.name}"/>
        <div itemprop="publisher" itemscope itemtype="https://schema.org/{$companyData.type}">
            <meta itemprop="name" content="{$companyData.name}">
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="url" content="{geturl}/skin/{template}/img/logo/{#logo_img#}">
                <meta itemprop="width" content="269">
                <meta itemprop="height" content="50">
            </div>
        </div>
        <div itemprop="articleBody">
            {if $news.imgSrc.small}
                <figure{if $news.imgSrc.small} itemprop="image" itemscope itemtype="http://schema.org/ImageObject"{/if}>
                    {if $news.imgSrc.small}
                        <meta itemprop="url" content="{geturl}{$news.imgSrc.medium}" />
                        <meta itemprop="height" content="480" />
                        <meta itemprop="width" content="360" />
                        <a href="{$news.imgSrc.medium}" class="img-zoom" title="{$news.name}" itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                            <img src="{$news.imgSrc.small}" alt="{$news.name}" class="img-responsive pull-right" itemprop="contentUrl"/>
                        </a>
                    {else}
                        <img src="/skin/{template}/img/catalog/news-default.png" alt="{$news.name}" />
                    {/if}
                </figure>
            {/if}
            {$news.content}
        </div>
        {strip}
        {if !empty($news.tagData)}
            <p class="tag-list">
                <span>{#news_theme#|ucfirst}&nbsp;:</span>
                {foreach $news.tagData as $tag}
                    <span itemprop="articleSection">
                        <a href="{$tag.url}" title="{#see_more_news_about#} {$tag.name|ucfirst}">
                            {$tag.name}
                        </a>
                    </span>
                    {if !$tag@last}, {/if}
                {/foreach}
            </p>
        {/if}
        {/strip}
    {/block}
    </article>
{/block}