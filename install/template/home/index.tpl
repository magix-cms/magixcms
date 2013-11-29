{extends file="layout.tpl"}
{block name='body:id'}install{/block}
{block name="page"}
<div class="container-started">
    <div class="jumbotron">
        <h1>{#h1_home#}</h1>
        <p class="lead">
            {#p_lead_home#}
        </p>
        <a class="btn btn-lng btn-success" href="/install/analysis.php">
            {#start#}
        </a>
    </div>
</div>
{/block}