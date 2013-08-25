<form id="forms_user_add" method="post" action="">
    <div class="form-group">
        <label for="pseudo">{#label_username#} *</label>
        <input type="text" placeholder="{#label_username#}" class="form-control" id="pseudo" name="pseudo" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="email">Email *</label>
        <input type="text" placeholder="Email" class="form-control" id="email" name="email" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="cryptpass">{#label_password#} *</label>
        <input type="password" placeholder="{#label_password#}" class="form-control" id="cryptpass" name="cryptpass" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="cryptpass_confirm">{#label_confirm_password#} *</label>
        <input type="password" placeholder="{#label_confirm_password#}" class="form-control" id="cryptpass_confirm" name="cryptpass_confirm" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>