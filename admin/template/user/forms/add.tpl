<form id="forms_user_add" method="post" action="">
    <div class="form-group">
        <input type="text" placeholder="Nom d'utilisateur" class="form-control" id="pseudo" name="pseudo" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="text" placeholder="Email" class="form-control" id="email" name="email" value="" size="50" />
    </div>
    <div class="form-group">
    {$role_select}
    </div>
    <div class="form-group">
        <input type="password" placeholder="Mot de passe" class="form-control" id="cryptpass" name="cryptpass" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="password" placeholder="Confirmer le mot de passe" class="form-control" id="cryptpass_confirm" name="cryptpass_confirm" value="" size="50" />
    </div>
</form>