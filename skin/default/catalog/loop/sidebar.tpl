{$listing = $data}
{if is_array($listing) && !empty($listing)}
    <ul class="panel-group list-group list-unstyled" id="accordion" role="tablist">
        {foreach $listing as $key => $value}
            <li class="panel list-group-item{if $smarty.get.idclc == $value.id} active{/if}" role="tab" id="heading{$key}">
                <div class="panel-heading">
                    <p class="panel-title">
                        <a href="{$value.url}" title="{$value.name|ucfirst}">
                            {$value.name|ucfirst}
                        </a>
                        {if $value.subdata != null}
                            <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$key}" aria-expanded="true" aria-controls="collapse{$key}">
                                <span class="fa"></span>
                            </a>
                        {/if}
                    </p>
                </div>
                {if $value.subdata != null}
                <div id="collapse{$key}" class="panel-collapse collapse{if $smarty.get.idclc == $value.id} in{/if}" role="tabpanel" aria-labelledby="heading{$key}">
                    <ul class="list-group">
                        {foreach $value.subdata as $subkey => $item}
                            <li{if $smarty.get.idcls == $item.id} class="active"{/if}>
                                <a{if $smarty.get.idclc == $value.id} itemprop="relatedLink"{/if} class="list-group-item" href="{$item.url}" title="{$item.name|ucfirst}">
                                    {$item.name|ucfirst}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}