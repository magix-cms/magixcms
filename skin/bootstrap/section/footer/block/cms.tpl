{if !$classCol}
    {assign var="classCol" value="col-xs-12 col-md-4"}
{/if}
{if {#block_cms_pages#}}
<div id="block-cms" class="{$classCol} block">
    {widget_cms_data
        conf = [
            'select' => [{getlang} => {#block_cms_pages#}],
            'context' => 'mix'
            ]
        assign="pages"
    }
    <h4>{#block_cms#|ucfirst}</h4>
    <ul class="list-unstyled">
        {foreach $pages as $page}
            <li>
                <a href="{$page.url}" title="{$page.name|ucfirst}">{$page.name|ucfirst}</a>
            </li>
        {/foreach}
    </ul>
</div>
{/if}