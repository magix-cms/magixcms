{include file="section/head.tpl"}
<title>Magix CMS | Upgrade</title>
</head>
<body class="install">
<div class="container-started">
    <div class="jumbotron">
        <h1>{#h1_upgrade#}</h1>
        <p class="lead">
            {#p_lead_upgrade#}
        </p>
        <p>
            Magix CMS 2.3.6 => 2.4.0
        </p>
        <a class="btn btn-lg btn-success" id="upgrade_db" href="#">
            {#p_start_upgrade#}
        </a>
        <div class="mc-message mc-success clearfix"></div>
        <div id="upgrade_table"></div>
    </div>
</div>
{include file="section/js.tpl"}
{include file="upgrade/section/js.tpl"}
</body>
</html>