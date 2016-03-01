{widget_advantage_data}
{strip}
{if !isset($orientation)}
    {assign var="orientation" value="left"}
{/if}
{if !isset($links)}
    {assign var="links" value=false}
{/if}
{$char = [2=>400,3=>250,4=>400]}
{/strip}
{if isset($advantages) && $advantages != null}
    <section id="advantages" class="clearfix">
        <div class="container">
            <div class="row">
                {strip}
                {$nb = $advantages|count}
                {if $nb == 4}
                    {capture name="class"}
                        col-sm-6
                    {/capture}
                {else}
                    {$class = (12/$nb)}
                    {capture name="class"}
                        col-sm-{$class}
                    {/capture}
                {/if}
                {/strip}
                {foreach $advantages as $adv}
                    <div class="{$smarty.capture.class}">
                        <div class="media">
                            {if $orientation == 'right' or $orientation == 'bottom'}
                                <div class="media-body">
                                    <h4>{$adv.title}</h4>
                                    {if $nb != 1}
                                        {$adv.content = $adv.content|truncate:{$char[$nb]}:'...'}
                                    {/if}
                                    <p>{$adv.content}</p>
                                </div>
                            {/if}
                            <div class="media-{$orientation} text-center">
                                <p class="fa-stack fa-lg">
                                    <span class="fa fa-circle fa-stack-2x"></span>
                                    <span class="fa fa-{$adv.icon} fa-stack-1x fa-inverse"></span>
                                </p>
                            </div>
                            {if $orientation == 'left' or $orientation == 'top'}
                                <div class="media-body">
                                    <h4>{$adv.title}</h4>
                                    {if $nb != 1}
                                        {$adv.content = $adv.content|truncate:{$char[$nb]}:'...'}
                                    {/if}
                                    <p>{$adv.content}</p>
                                </div>
                            {/if}
                            {if $adv.url && $links}
                                <a href="{$adv.url}" title="{#read_more#} {$adv.title}"><span class="sr-only">{$adv.title}</span></a>
                            {/if}
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </section>
{/if}