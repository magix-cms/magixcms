{extends file="layout.tpl"}
{block name='body:id'}install-config{/block}
{block name="main:content"}
{block name="main:breadcrumb"}
    {$breadcrumb = ['index.php' => $smarty.config.start,'analysis.php' => $smarty.config.analysis,
    'config.php' => $smarty.config.configuration]}
    {call name=breadcrumb data=$breadcrumb active=$smarty.config.database}
{/block}
    <div class="mc-message clearfix"></div>
    <div class="mc-info clearfix">
        <div class="col-sm-6 alert alert-info">
            <span class="fa fa-info-circle"></span> {#info_database#}
        </div>
    </div>
    <a href="#" class="btn btn-primary" id="process_db">
        <span class="fa fa-gear"></span> {#install_table#}
    </a>
    <div id="install_table"></div>
    {block name="main:pager"}
        <ul class="pager">
            <li class="previous">
                <a href="/install/config.php">&larr; {#previous#}</a>
            </li>
            <li class="next">
                <a href="/install/employee.php">{#next#} &rarr;</a>
            </li>
        </ul>
    {/block}
{/block}
{block name="javascript"}
    {include file="database/section/js.tpl"}
{/block}