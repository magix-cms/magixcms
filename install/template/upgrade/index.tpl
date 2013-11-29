{extends file="layout.tpl"}
{block name='body:id'}upgrade{/block}
{block name="page"}
    <div class="container-started">
        <div class="jumbotron">
            <h1>{#h1_upgrade#}</h1>
            <p class="lead">
                {#p_lead_upgrade#}
            </p>
            <p>
                Magix CMS 2.3.6 => 2.4.1
            </p>
            <a class="btn btn-lg btn-success" id="upgrade_db" href="#">
                {#p_start_upgrade#}
            </a>
            <div class="mc-message mc-success clearfix"></div>
            <div id="upgrade_table"></div>
        </div>
    </div>
{/block}
{block name="javascript"}
    {include file="upgrade/section/js.tpl"}
{/block}