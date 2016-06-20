{extends file="layout.tpl"}
{block name='body:id'}module-webservice{/block}
{block name="article:content"}
    <h1>Web service</h1>
    <form id="forms_webservice" class="form-horizontal" method="post" action="">
        <div class="mc-message clearfix"></div>
        <div class="clearfix">
            <label for="status_key" class="control-label">Clé API</label>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="key" id="ws_key" name="ws_key" value="{$getItemData.ws_key}" size="50">
                        <span class="input-group-btn">
                            <button class="btn btn-success" id="key_generator" type="button">Key generator</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
            <label for="status_key" class="control-label">Status</label>
            <div class="form-group">
                <div class="col-sm-4">
                    <div class="checkbox">
                        <label>
                            <input {if $getItemData.status_key eq '1'} checked{/if} type="checkbox" name="status_key" id="status_key" value="1" data-toggle="toggle" data-on="oui" data-off="non" data-onstyle="primary" data-offstyle="default">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">{#save#|ucfirst}</button>
            </div>
        </div>
    </form>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="webservice/section/js.tpl"}
{/block}