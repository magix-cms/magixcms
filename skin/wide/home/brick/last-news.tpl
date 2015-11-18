{widget_news_data
	conf =[
		'level' => 'last-news',
		'select' => [{getlang} => 'promo'],
		'limit' => 2
		]
	assign='newsData'
}
<section class="container">
	<div class="row">
		<div id="gold-value" class="col-xs-12 col-md-4 pull-right">
			<h3><a href="#" data-target="#modal-sell-gold" data-toggle="modal" title="Vendez votre or au plus haut prix, demandez une expertise en ligne">Cours de l'or</a></h3>
			<p>Valeur actuelle de l'or en bourse, au {#gold_mesure#}, en Belgique</p>
			<p class="lead">{#gold_value#} €/{#gold_mesure#}</p>
		</div>
		<div id="last-news" class="col-xs-12 col-md-8">
			<h3><a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|ucfirst}">{#last_news#|ucfirst}</a></h3>
			<div class="news-list">
				{if $newsData}
					<div class="row">
						{include file="news/loop/last-news.tpl" data=$newsData}
					</div>
				{/if}
			</div>
		</div>
	</div>
</section>