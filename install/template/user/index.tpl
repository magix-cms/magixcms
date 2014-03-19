{extends file="layout.tpl"}
{block name='body:id'}install-config{/block}
{block name="main:content"}
{block name="main:breadcrumb"}
    {$breadcrumb = ['index.php' => $smarty.config.start,'analysis.php' => $smarty.config.analysis,
    'config.php' => $smarty.config.configuration,'database.php' => $smarty.config.database]}
    {call name=breadcrumb data=$breadcrumb active=$smarty.config.administrator}
{/block}
    <div class="mc-message clearfix"></div>
    {include file="user/forms/add.tpl"}
    {block name="main:pager"}
        <ul class="pager">
            <li class="previous">
                <a href="/install/database.php">&larr; {#previous#}</a>
            </li>
            <li class="next">
                <a href="/install/clear.php">{#next#} &rarr;</a>
            </li>
        </ul>
    {/block}
{/block}
{block name="javascript"}
    {include file="user/section/js.tpl"}
{/block}