{extends file="layout.tpl"}
{block name='body:id'}upgrade{/block}
{block name="page"}
    <div class="container-started">
        <div class="jumbotron">
            <h1>{#h1_upgrade#}</h1>
            <p class="lead">
                {#p_lead_upgrade#}
            </p>
            <form id="forms_upgrade_version" method="post" action="">
                <p>
                    <select id="version" name="version">
                        <option value="">
                            Choisissez la version
                        </option>
                        <option value="2.4.2">
                            Magix CMS 2.3.6 => 2.4.2
                        </option>
                        <option value="2.6.0">
                            Magix CMS 2.4.2 => 2.6.0
                        </option>
                        <option value="2.6.5">
                            Magix CMS 2.6.0 => 2.6.5
                        </option>
                    </select>
                </p>
                <p>
                    <input type="submit" class="btn btn-lg btn-success" value="{#p_start_upgrade#}" />
                </p>
            </form>
            <div class="mc-message mc-success clearfix"></div>
            <div id="upgrade_table"></div>
        </div>
    </div>
{/block}
{block name="javascript"}
    {include file="upgrade/section/js.tpl"}
{/block}