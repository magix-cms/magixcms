<div id="block-newsletter" class="col-xs-12 col-sm-4 block">
    <h4>{#mailchimp_title#}</h4>
    <form id="maillingchimp-form" method="post" action="{$smarty.server.REQUEST_URI}">
        <div class="form-group">
            <input id="lastname_chimp" type="text" name="lastname_chimp" value="" class="form-control" placeholder="{#lastname#|ucfirst}"  />
        </div>
        <div class="form-group">
            <input id="firstname_chimp" type="text" name="firstname_chimp" value="" class="form-control" placeholder="{#firstname#|ucfirst}" />
        </div>
        <div class="form-group">
            <input id="email_chimp" type="text" name="email_chimp" value="" class="form-control" placeholder="{#email#|ucfirst}" />
        </div>
        <div class="form-group">
            <div class="input-send"></div>
            <input type="submit" class="btn btn-wsw-white pull-right" value="{#sign_on#|ucfirst}" />
        </div>
        <div class="clearfix mc-message"></div>
    </form>
</div>