{if $smarty.config.good_choice != '0'}
<div id="good-choice" class="clearfix">
    <div class="container">
        <div class="row">
            {widget_cms_data
                conf = [
                    'select' => [{getlang} => {#good_choice#}],
                    'context' => 'child'
                    ]
                assign="pages"
            }
            {foreach $pages as $page}
                {$icon = 'icon_'|cat:{$page@index+1}}
                <div class="col-sm-4">
                    <div class="media">
                        <div class="media-left text-center">
                            <p class="fa-stack fa-lg">
                                <span class="fa fa-circle fa-stack-2x"></span>
                                <span class="fa fa-{#$icon#} fa-stack-1x fa-inverse"></span>
                            </p>
                        </div>
                        <div class="media-body">
                            <h4>{$page.name}</h4>
                            {$page.content|truncate:180:'...'}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>
{/if}