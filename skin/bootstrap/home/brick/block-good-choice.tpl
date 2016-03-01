{if !isset($orientation)}
    {assign var="orientation" value="left"}
{/if}
{if !isset($icon)}
    {assign var="icon" value="icons"}
    {if !isset($icon)}
        {assign var="icon_size" value="100"}
    {/if}
{/if}
{if !isset($links)}
    {assign var="links" value=false}
{/if}
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
                {$index = 1}
                {foreach $pages as $page}
                    {$valid = ','|explode:{#valid_child#}}
                    {if ($valid && in_array($page.id,$valid)) || $page@index <= 3}
                        {$icon_name = 'icon_'|cat:{$index}}
                        <div class="col-sm-4">
                            <div class="media">
                                {if $orientation == 'right' or $orientation == 'bottom'}
                                    <div class="media-body">
                                        <h4 class="text-center">{$page.name}</h4>
                                        {$page.content|truncate:180:'...'}
                                    </div>
                                {/if}
                                <div class="media-{$orientation} text-center">
                                    {if $icon == 'icons'}
                                        <p class="fa-stack fa-lg">
                                            <span class="fa fa-circle fa-stack-2x"></span>
                                            <span class="fa fa-{#$icon_name#} fa-stack-1x fa-inverse"></span>
                                        </p>
                                    {elseif $icon == 'images'}
                                        <img src="{geturl}/{getlang}/skin/{template}/img/goodchoice/{#$icon_name#}" alt="{$page.name}" height="{$icon_size}" width="{$icon_size}" />
                                    {/if}
                                </div>
                                {if $orientation == 'left' or $orientation == 'top'}
                                    <div class="media-body">
                                        <h4 class="text-center">{$page.name}</h4>
                                        {$page.content|truncate:180:'...'}
                                    </div>
                                {/if}
                                {if $links}
                                    <a href="{$page.url}" title="{#read_more#} {$page.name}"><span class="sr-only">{$page.name}</span></a>
                                {/if}
                            </div>
                        </div>
                        {$index = $index+1}
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
{/if}