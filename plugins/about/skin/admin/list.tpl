{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>Mailling Chimp <small>- {#account_list#|ucfirst}</small></h1>
    <!-- Notifications Messages -->
    {if isset($message)}
        <div class="mc-message clearfix">
            {include file="message-maillingchimp.tpl"}
        </div>
    {/if}

    {if $list}
        {$data = $getListCall.data}
        <p class="lead">{#list#|ucfirst} : <strong>{$list.list_id}</strong> <a class="toggleModal" data-toggle="modal" data-target="#deleteModal" href="#"><span class="fa fa-trash-o"></span></a></p>
        <table class="table table-bordered table-condensed table-hover">
            <thead>
            <tr>
                <th>{#email#|ucfirst}</th>
            </tr>
            </thead>
            <tbody>
            {if is_array($data) && !empty($data)}
                {foreach $data as $item}
                    <tr>
                        <td>
                            {$item.merges.EMAIL}
                        </td>
                    </tr>
                {/foreach}
            {else}
                <tr>
                    <td class="text-center">
                        -
                    </td>
                </tr>
            {/if}
            </tbody>
        </table>

        {include file="modal/deleteList.tpl" id=$list.idlist}
    {else}
        {include file="form/list.tpl"}
    {/if}
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}