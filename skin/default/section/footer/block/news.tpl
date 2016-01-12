<div id="block-last-news" class="col-xs-12 col-sm-4 block">
    {widget_news_data
        conf =[
            'context' =>  'last-news',
            'limit' => 2
            ]
        assign='newsFooterData'
    }
    <h4><a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|ucfirst}">{#last_news#|ucfirst}</a></h4>
    <div class="news-list-last">
        {include file="news/loop/footer.tpl" data=$newsFooterData}
    </div>
</div>