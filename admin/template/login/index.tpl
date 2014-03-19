{extends file="layout.tpl"}
{block name='body:id'}module-login{/block}
{block name="body:container"}
<main class="container">
    <div class="box-login">
        <h2 class="text-center">
            <img src="/{baseadmin}/template/img/logo-magix_cms.png" alt="Magix CMS" />
        </h2>
        {$login_message}
        <form id="forms-log" method="post" action="{geturl}/{baseadmin}/login.php">
            <p class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-envelope"></span>
                </span>
                <input type="text" class="form-control" placeholder="{#placeholder_login#|ucfirst}" id="email_admin" name="email_admin" value="" />
            </p>
            <p class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-key"></span>
                </span>
                <input type="password" class="form-control" placeholder="{#placeholder_password#|ucfirst}" id="passwd_admin" name="passwd_admin" value="" />
            </p>
            <p>
                <input type="hidden" id="hashtoken" name="hashtoken" value="{$hashpass}" />
                <input type="submit" class="btn btn-block btn-primary" value="{#login#|ucfirst}" />
            </p>
        </form>
    </div>
</main>
{block name='javascript'}
    {include file="section/js.tpl"}
{/block}
{/block}