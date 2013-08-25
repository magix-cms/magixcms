{extends file="layout.tpl"}
{block name='body:id'}install-config{/block}
{block name="main:content"}
    {block name="main:breadcrumb"}
        {$breadcrumb = ['index.php' => $smarty.config.start,'analysis.php' => $smarty.config.analysis]}
        {call name=breadcrumb data=$breadcrumb active=$smarty.config.configuration}
    {/block}
    <div class="mc-message clearfix"></div>
    <div class="row">
        <div class="col-sm-8">
        {include file="config/forms/add.tpl"}
        </div>
    </div>
    {block name="main:pager"}
        <ul class="pager">
            <li class="previous">
                <a href="/install/analysis.php">&larr; {#previous#}</a>
            </li>
            <li class="next">
                <a href="/install/database.php">{#next#} &rarr;</a>
            </li>
        </ul>
    {/block}
{/block}
{block name="javascript"}
    {include file="config/section/js.tpl"}
{/block}