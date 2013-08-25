<form id="forms_config_add" action="" method="post">
    <div class="form-group">
        <label for="M_DBHOST">Host *</label>
        <input type="text" placeholder="Host" class="form-control" id="M_DBHOST" name="M_DBHOST" value="localhost" />
    </div>
    <div class="form-group">
        <label for="M_DBDRIVER">Driver *</label>
        <select id="M_DBDRIVER" name="M_DBDRIVER" class="form-control">
            <option value="mysql">Mysql</option>
        </select>
    </div>
    <div class="form-group">
        <label for="M_DBUSER">{#label_users#} </label>
        <input type="text" placeholder="{#label_users#}" class="form-control" id="M_DBUSER" name="M_DBUSER" value="" />
    </div>
    <div class="form-group">
        <label for="M_DBPASSWORD">{#label_password#} </label>
        <input type="password" placeholder="{#label_password#}" class="form-control" id="M_DBPASSWORD" name="M_DBPASSWORD" value="" />
    </div>
    <div class="form-group">
        <label for="M_DBNAME">{#label_database#} *</label>
        <input type="text" placeholder="{#label_database#}" class="form-control" id="M_DBNAME" name="M_DBNAME" value="" />
    </div>
    <div class="form-group">
        <label for="M_LOG">Log *</label>
        <select name="M_LOG" id="M_LOG" class="form-control">
            <option value="log">LOG</option>
            <option value="debug">DEBUG</option>
            <option value="false" selected="selected">OFF</option>
        </select>
    </div>
    <div class="form-group">
        <label for="M_FIREPHP">FirePHP *</label>
        <select name="M_FIREPHP" id="M_FIREPHP" class="form-control">
            <option value="true">ON</option>
            <option value="false" selected="selected">OFF</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        <input type="button" id="test_connexion" class="btn btn-info" value="{#connexion_test#|ucfirst}" />
    </div>
</form>