<div class="row">
    <div class="col-sm-4">
        <h3>{#user_data#}</h3>
        <form id="forms_user_data_edit" method="post" action="">
            <div class="form-group">
                <input type="text" placeholder="{#username#|ucfirst}" class="form-control" id="pseudo" name="pseudo" value="{$pseudo}" size="50" />
            </div>
            <div class="form-group">
                <input type="text" placeholder="Email" class="form-control" id="email" name="email" value="{$email}" size="50" />
            </div>
            <div class="form-group">
                {$role_select}
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
            </div>
        </form>
    </div>
    <div class="col-sm-5">
        <h3>{#change_password#}</h3>
        <form id="forms_user_password_edit" method="post" action="">
            <div class="form-group">
                <input type="password" placeholder="{#password#|ucfirst}" class="form-control" id="cryptpass" name="cryptpass" value="" size="50" />
            </div>
            <div class="form-group">
                <input type="password" placeholder="{#confirm_password#|ucfirst}" class="form-control" id="cryptpass_confirm" name="cryptpass_confirm" value="" size="50" />
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
            </div>
        </form>
    </div>
</div>