{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
{widget_news_data
	conf =[
		'level' => 'last-news',
		'select' => [{getlang} => 'promo'],
		'limit' => 2
		]
	assign='newsData'
}
<section id="last-news"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
    {if $adjust == 'clip'}
    <div class="container">
        {/if}
        <h3><a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|ucfirst}">{#last_news#|ucfirst}</a></h3>
        <div class="news-list">
            {if $newsData}
                <div class="row">
                    {include file="news/loop/last-news.tpl" data=$newsData}
                </div>
            {/if}
        </div>
        {if $adjust == 'clip'}
    </div>
    {/if}
</section>