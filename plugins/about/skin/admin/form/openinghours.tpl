<form id="enable_op_form" class="form-inline" method="post" action="{$smarty.server.REQUEST_URI}">
    <div class="checkbox">
        <label>
            <input id="enable_op" data-toggle="toggle" type="checkbox" name="enable_op" {if $companyData.openinghours} checked{/if}>
            {#op_enabled#|ucfirst}
        </label>
    </div>
    <input type="hidden" name="switch_op" value="active">
</form>

<form action="{$smarty.server.REQUEST_URI}" id="info_opening_form" method="post" class="forms_plugins_informations{if $companyData.openinghours} collapse{else} collapse in{/if}">
    <fieldset>
        <legend>{#op_legend#|ucfirst}</legend>

        <table id="openingHours" class="table table-bordered">
            <thead>
            <tr>
                <th>{#op_day#|ucfirst}</th>
                <th class="text-center">{#op_open#|ucfirst}</th>
                <th class="text-center">{#op_open#|ucfirst}&nbsp;{#op_from#}</th>
                <th class="text-center">{#op_to#}</th>
                <th class="text-center">
                    <span class="fa fa-coffee"></span>
                    <a href="#" class="text-info" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="{#op_noon_ph#|ucfirst}">
                        <span class="fa fa-question-circle"></span>
                    </a>
                </th>
                <th class="text-center">{#op_from#}</th>
                <th class="text-center">{#op_to#}</th>
            </tr>
            </thead>
            <tbody>
                {include file="form/loop/days.tpl"}
            </tbody>
        </table>
    </fieldset>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-block btn-primary">{#save#|ucfirst}</button>
            </div>
        </div>
    </div>
</form>