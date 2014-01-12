<div class="mc-info clearfix">
    <div class="col-sm-7 alert alert-info">
        <span class="fa fa-info-sign"></span> {#alert_info_analytics#}
    </div>
</div>
<form id="forms_googletools_analytics_edit" class="forms-googletools form-inline" method="post" action="">
    <p>
        <label for="analytics">Profil Analytics:</label>
    </p>
    <div class="form-group">
        <input type="text" class="form-control" id="analytics" name="analytics" size="30" value="{$analytics}" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-sm" value="{#send#|ucfirst}" />
    </div>
</form>
<div class="mc-info clearfix">
    <div class="col-sm-7 alert alert-info">
        <span class="fa fa-info-sign"></span> {#alert_info_webmaster_tools#}
    </div>
</div>
<form id="forms_googletools_webmaster_edit" class="forms-googletools form-inline" method="post" action="">
    <p>
        <label for="webmaster">Profil Webmaster:</label>
    </p>
    <div class="form-group">
        <input type="text" class="form-control" id="webmaster" name="webmaster" size="30" value="{$webmaster}" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-sm" value="{#send#|ucfirst}" />
    </div>
</form>
<div class="mc-info clearfix">
    <div class="col-sm-7 alert alert-info">
        <span class="fa fa-info-sign"></span> {#alert_info_googleplus#}
    </div>
</div>
<form id="forms_googletools_plus_edit" class="forms-googletools form-inline" method="post" action="">
    <p>
        <label for="googleplus">Profil Google plus:</label>
    </p>
    <div class="form-group">
        <input type="text" class="form-control" id="googleplus" name="googleplus" size="30" value="{$googleplus}" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-sm" value="{#send#|ucfirst}" />
    </div>
</form>
<form id="forms_robots_edit" class="forms-googletools form-inline" method="post" action="">
    <p>
        <label for="googleplus">Robots:</label>
    </p>
    <div class="form-group">
        {$select_robots}
        </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-sm" value="{#send#|ucfirst}" />
    </div>
</form>