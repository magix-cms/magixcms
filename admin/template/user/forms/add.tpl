<form id="forms_user_add" method="post" action="">
    <div class="form-group">
        <input type="text" placeholder="{#username#|ucfirst}" class="form-control" id="pseudo_admin" name="pseudo_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="text" placeholder="{#lastname#|ucfirst}" class="form-control" id="lastname_admin" name="lastname_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="text" placeholder="{#firstname#|ucfirst}" class="form-control" id="firstname_admin" name="firstname_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="text" placeholder="Email" class="form-control" id="email_admin" name="email_admin" value="" size="50" />
    </div>
    <div class="form-group">
    {$role_select}
    </div>
    <div class="form-group">
        <input type="password" placeholder="Mot de passe" class="form-control" id="passwd_admin" name="passwd_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="password" placeholder="Confirmer le mot de passe" class="form-control" id="passwd_confirm" name="passwd_confirm" value="" size="50" />
    </div>
</form>