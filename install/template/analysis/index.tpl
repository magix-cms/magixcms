{extends file="layout.tpl"}
{block name='body:id'}install-analysis{/block}
{block name="main:content"}
    {block name="main:breadcrumb"}
        {$breadcrumb = ['index.php' => $smarty.config.start]}
        {call name=breadcrumb data=$breadcrumb active=$smarty.config.analysis}
    {/block}
    <div id="list_checking"></div>
    <div id="list_chmod"></div>
    {block name="main:pager"}
        <ul class="pager">
            <li class="previous">
                <a href="/install/index.php">&larr; {#previous#}</a>
            </li>
            <li class="next">
                <a href="/install/config.php">{#next#} &rarr;</a>
            </li>
        </ul>
    {/block}
{/block}
{block name="javascript"}
    {include file="analysis/section/js.tpl"}
{/block}