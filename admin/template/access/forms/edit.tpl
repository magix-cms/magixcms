<h3>{#profile_name#}</h3>
<form id="forms_role_update" method="post" action="">
    <div class="form-group">
        <input type="text" placeholder="{#role_name#|ucfirst}" class="form-control" {if $role_name eq 'administrator'}disabled="disabled"{/if} id="role_name" name="role_name" value="{$role_name}" size="50" />
    </div>
    <div>
        <input type="submit" class="btn btn-primary" {if $role_name eq 'administrator'}disabled="disabled"{/if} value="{#send#|ucfirst}" />
    </div>
</form>