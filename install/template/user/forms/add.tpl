<form id="forms_user_add" method="post" action="">
    <div class="form-group">
        <label for="lastname_admin">{#label_lastname#} *</label>
        <input type="text" placeholder="{#label_lastname#|ucfirst}" class="form-control" id="lastname_admin" name="lastname_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="firstname_admin">{#label_firstname#} *</label>
        <input type="text" placeholder="{#label_firstname#|ucfirst}" class="form-control" id="firstname_admin" name="firstname_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="pseudo_admin">{#label_username#} *</label>
        <input type="text" placeholder="{#label_username#}" class="form-control" id="pseudo_admin" name="pseudo_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="email_admin">Email *</label>
        <input type="text" placeholder="Email" class="form-control" id="email_admin" name="email_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="passwd_admin">{#label_password#} *</label>
        <input type="password" placeholder="{#label_password#}" class="form-control" id="passwd_admin" name="passwd_admin" value="" size="50" />
    </div>
    <div class="form-group">
        <label for="passwd_confirm">{#label_confirm_password#} *</label>
        <input type="password" placeholder="{#label_confirm_password#}" class="form-control" id="passwd_confirm" name="passwd_confirm" value="" size="50" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>