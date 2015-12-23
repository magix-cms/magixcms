{extends file="layout.tpl"}
{block name="title"}{cms_seo config_param=['seo'=>$page.seoTitle,'default'=>$page.title]}{/block}
{block name="description"}{cms_seo config_param=['seo'=>$page.seoDescr,'default'=>$page.title]}{/block}
{block name='body:id'}about{/block}
{block name="webType"}{if isset($parent)}WebPage{else}AboutPage{/if}{/block}

{block name='article'}
    <article id="article" class="col-xs-12 col-sm-9 pull-right" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
        {block name='article:content'}
            <h1 itemprop="name">{$page.title}</h1>
            <time datetime="{$page.date.register}" itemprop="datePublished"></time>
            {if $page.date.update}
                <time datetime="{$page.date.update}" itemprop="dateModified"></time>
            {/if}
            <div itemprop="text">
                {$page.content}
            </div>
        {/block}
    </article>
    <div class="col-sm-3 pull-left">
        <figure>
            <img class="img-responsive" src="{geturl}/skin/{template}/img/{#logo_img#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="269" height="50" />
        </figure>
        <a{if isset($smarty.get.pnum1)} itemprop="relatedLink"{else} class="active"{/if} href="{geturl}/{getlang}/about/" title="{#show_page#}: {$about.title}">{$about.title}</a>
        {if isset($about.childs) && $about.childs != null && !empty($about.childs)}
        <nav class="child-nav">
            <ul class="list-unstyled">
                {foreach $about.childs as $child}
                    <li{if $smarty.get.pnum1 == $child.id} class="active"{/if}><a{if $smarty.get.pnum1 != $child.id} itemprop="relatedLink"{/if} href="{geturl}/{getlang}/about/{$child.uri}-{$child.id}/" title="{#show_page#}: {$child.title}">{$child.title}</a></li>
                {/foreach}
            </ul>
        </nav>
        {/if}
    </div>
{/block}