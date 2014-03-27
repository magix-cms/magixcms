<div class="row">
    <div class="col-sm-4">
        <h3>{#user_data#}</h3>
        <form id="forms_user_data_edit" method="post" action="">
            <div class="form-group">
                <input type="text" placeholder="{#username#|ucfirst}" class="form-control" id="pseudo_admin" name="pseudo_admin" value="{$pseudo_admin}" size="50" />
            </div>
            <div class="form-group">
                <input type="text" placeholder="{#lastname#|ucfirst}" class="form-control" id="lastname_admin" name="lastname_admin" value="{$lastname_admin}" size="50" />
            </div>
            <div class="form-group">
                <input type="text" placeholder="{#firstname#|ucfirst}" class="form-control" id="firstname_admin" name="firstname_admin" value="{$firstname_admin}" size="50" />
            </div>
            <div class="form-group">
                <input type="text" placeholder="Email" class="form-control" id="email_admin" name="email_admin" value="{$email_admin}" size="50" />
            </div>

            <div>
                <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
            </div>
        </form>
    </div>
    <div class="col-sm-5">
        <h3>Rôle</h3>
        <form id="forms_user_data_role" method="post" action="">
            <div class="form-group">
                {$role_select}
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
            </div>
        </form>
        <h3>{#change_password#}</h3>
        <form id="forms_user_password_edit" method="post" action="">
            <div class="form-group">
                <input type="password" placeholder="{#password#|ucfirst}" class="form-control" id="passwd_admin" name="passwd_admin" value="" size="50" />
            </div>
            <div class="form-group">
                <input type="password" placeholder="{#confirm_password#|ucfirst}" class="form-control" id="passwd_confirm" name="passwd_confirm" value="" size="50" />
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
            </div>
        </form>
        {if {role_admin items='administrator'}}
        <h3>Status du profil</h3>
        <form id="forms_user_data_active" method="post" action="">
            <label class="radio-inline">
                <input type="radio" name="active_admin" class="active_admin" {if $active_admin eq "0"}checked="checked" {/if}value="0" /> Désactiver
            </label>
            <label class="radio-inline">
                <input type="radio" name="active_admin" class="active_admin" {if $active_admin eq "1"}checked="checked" {/if}value="1" /> Activer
            </label>
        </form>
        {/if}
    </div>
</div>