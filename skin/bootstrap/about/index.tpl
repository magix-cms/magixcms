{extends file="layout.tpl"}
{block name="title"}{cms_seo config_param=['seo'=>$page.seoTitle,'default'=>$page.title]}{/block}
{block name="description"}{cms_seo config_param=['seo'=>$page.seoDescr,'default'=>$page.title]}{/block}
{block name='body:id'}about{/block}
{block name="webType"}{if isset($parent)}WebPage{else}AboutPage{/if}{/block}

{block name='article'}
    <div class="container">
        <div class="row">
            <article id="article" class="col-xs-12 col-md-8 col-lg-9" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
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
            <div class="col-xs-12 col-md-4 col-lg-3">
                <figure class="hidden-sm-down">
                    <picture>
                        <!--[if IE 9]><video style="display: none;"><![endif]-->
                        <source type="image/webp"
                                media="(min-width: 768px)"
                                srcset="{geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@167.webp 167w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@200.webp 200w 2x,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@269.webp 269w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@333.webp 333w 2x,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@400.webp 400w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@537.webp 537w 2x">
                        <source media="(min-width: 768px)"
                                srcset="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png 167w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png 200w 2x,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png 269w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png 333w 2x,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@400.png 400w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@537.png 537w 2x">
                        <!--[if IE 9]></video><![endif]-->
                        <img src="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png"
                             srcset="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png 167w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png 200w 2x,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png 269w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png 333w 2x,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@400.png 400w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@537.png 537w 2x"
                             alt="{#logo_img_alt#|ucfirst} {$companyData.name}"
                             class="img-fluid" />
                    </picture>
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
        </div>
    </div>
{/block}