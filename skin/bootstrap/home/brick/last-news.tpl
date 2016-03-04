{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
{$conf = ['level' => 'last-news', 'limit' => 6]}
{if isset($filter) && $filter != 'none' && $filter != false}
    {$conf['select'] = [{getlang} => $filter]}
{/if}
{if isset($limit) && $limit && $limit < 7}
    {$conf['limit'] = $limit}
{/if}
{widget_news_data
	conf = $conf
	assign='newsData'
}
{if $newsData != null}
<section id="last-news"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
    {if $adjust == 'clip'}
    <div class="container">
        {/if}
        <div class="row">
            <div class="col-xs-12 col-lg-10 col-xl-9 center-block">
                <h3><a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|ucfirst}">{#last_news#|ucfirst}</a></h3>
                <div class="news-list">
                    {if $newsData}
                        <div class="no-gutter">
                            <div class="row">
                                {include file="home/loop/last-news.tpl" data=$newsData}
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
        {if $adjust == 'clip'}
    </div>
    {/if}
</section>
{/if}