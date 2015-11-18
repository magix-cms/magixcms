{*<h2>{#info_opening#|ucfirst}</h2>*}
<form id="enable_op_form" class="form-inline" method="post" action="{$smarty.server.REQUEST_URI}">
    <div class="checkbox">
        <label>
            <input id="enable_op" data-toggle="toggle" type="checkbox" name="enable_op" {if $companyData.openinghours} checked{/if}>
            Afficher l'horaire
        </label>
    </div>
    <input type="hidden" name="switch_op" value="active">
</form>

{*<pre>{$companyData.specifications|var_dump}</pre>*}

<form action="{$smarty.server.REQUEST_URI}" id="info_opening_form" method="post" class="forms_plugins_informations{if $companyData.openinghours} collapse{else} collapse in{/if}">
    <fieldset>
        <legend>Heures d'ouverture de votre entreprise</legend>

        <table id="openingHours" class="table table-bordered">
            <thead>
            <tr>
                <th>Jour</th>
                <th class="text-center">Ouvert</th>
                <th class="text-center">Ouvert de</th>
                <th class="text-center">à</th>
                <th class="text-center">
                    <span class="fa fa-coffee"></span>
                    <a href="#" class="text-info" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="Permet d'indiquer une fermeture de type 'temps de midi'">
                        <span class="fa fa-question-circle"></span>
                    </a>
                </th>
                <th class="text-center">de</th>
                <th class="text-center">à</th>
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
                <button type="submit" class="btn btn-block btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</form>