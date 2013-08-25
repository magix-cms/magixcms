{include file="section/head.tpl"}
<title>Magix CMS | Login</title>
</head>
<body class="module-login">
<div class="container">
    <div class="box-login">
        <h2 class="text-center">
            <img src="/{baseadmin}/template/img/logo-magix_cms.png" alt="Magix CMS" />
        </h2>
        {$login_message}
        <form id="forms-log" method="post" action="{geturl}/{baseadmin}/login.php">
            <p class="input-group">
                <span class="input-group-addon">
                    <span class="icon-envelope"></span>
                </span>
                <input type="text" class="form-control" placeholder="{#placeholder_login#|ucfirst}" id="acmail" name="acmail" value="" />
            </p>
            <p class="input-group">
                <span class="input-group-addon">
                    <span class="icon-key"></span>
                </span>
                <input type="password" class="form-control" placeholder="{#placeholder_password#|ucfirst}" id="acpass" name="acpass" value="" />
            </p>
            <p>
                <input type="hidden" id="hashtoken" name="hashtoken" value="{$hashpass}" />
                <input type="submit" class="btn btn-primary" value="{#login#|ucfirst}" />
            </p>
        </form>
    </div>
</div>
{include file="login/section/js.tpl"}
</body>
</html>