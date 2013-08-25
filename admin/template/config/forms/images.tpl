<div id="conf-img-size">
{if $smarty.get.tab eq "news"}
    <h2>{#news#|ucfirst}</h2>
    {foreach $imgsize.news as $key => $value nocache}
        {if $value@first}
            <div class="row">
                {elseif ($value@iteration - 1) is div by 3}
            </div>
            <div class="row">
        {/if}
        <form class="forms-config form-inline" method="post" action="" id="si_{$value.attr_name}_{$value.config_size_attr}_{$value.type}">
            <div class="well">
                <h3 class="col-lg-2">{$smarty.config.{$value.img_size_type}}</h3>
                <div class="form-group">
                    <label>{#width#|ucfirst} :</label>
                    <input type="text" class="input-small spincount" name="width" value="{$value.width}" size="50" />
                </div>
                <div class="form-group">
                    <label>{#height#|ucfirst} :</label>
                    <input type="text" class="input-small spincount" name="height" value="{$value.height}" size="50" />
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" name="img_resizing" value="basic" {if $value.img_resizing eq 'basic'} checked="checked"{/if} />
                        Basic
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="img_resizing" value="adaptive" {if $value.img_resizing eq 'adaptive'} checked="checked"{/if} />
                        Adaptive
                    </label>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id_size_img" value="{$value.id_size_img}" />
                    <input type="submit" class="btn btn-primary btn-sm" value="{#save#|ucfirst}" />
                </div>
            </div>
        </form>
        {if $value@last}
            </div>
        {/if}
    {/foreach}
{elseif $smarty.get.tab eq "plugins"}
    <h2>Plugins</h2>
    {if $imgsize.plugins != NULL}
        {$section = null}
    {foreach $imgsize.plugins as $key => $value nocache}
        {if $value@first}
            {if $value.config_size_attr != $section }
                <h3>{{$value.config_size_attr|ucfirst}}</h3>
                {$section = $value.config_size_attr}
            {/if}
            <div class="row">
                {elseif ($value@iteration - 1) is div by 3}
            </div>
            {if $value.config_size_attr != $section }
                <h3>{{$value.config_size_attr|ucfirst}}</h3>
                {$section = $value.config_size_attr}
            {/if}
            <div class="row">
                {else}
            </div>
            {if $value.config_size_attr != $section }
                <h3>{{$value.config_size_attr|ucfirst}}</h3>
                {$section = $value.config_size_attr}
            {/if}
            <div class="row">
        {/if}
        <form class="forms-config form-inline" method="post" action="" id="si_{$value.attr_name}_{$value.config_size_attr}_{$value.type}">
            <div class="well">
                <h3 class="col-lg-2">{$smarty.config.{$value.img_size_type}}</h3>
                <div class="form-group">
                    <label>{#width#|ucfirst} :</label>
                    <input type="text" class="input-small spincount" name="width" value="{$value.width}" size="50" />
                </div>
                <div class="form-group">
                    <label>{#height#|ucfirst} :</label>
                    <input type="text" class="input-small spincount" name="height" value="{$value.height}" size="50" />
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" name="img_resizing" value="basic" {if $value.img_resizing eq 'basic'} checked="checked"{/if} />
                        Basic
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="img_resizing" value="adaptive" {if $value.img_resizing eq 'adaptive'} checked="checked"{/if} />
                        Adaptive
                    </label>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id_size_img" value="{$value.id_size_img}" />
                    <input type="submit" class="btn btn-primary btn-sm" value="{#save#|ucfirst}" />
                </div>
            </div>
        </form>
        {if $value@last}
            </div>
        {/if}
    {/foreach}
    {/if}
{else}
    <h2>{#catalog#|ucfirst}</h2>
    {$section = null}
    {foreach $imgsize.catalog as $key => $value nocache}
        {if $value@first}
            {if $value.config_size_attr != $section }
                <h3>{$smarty.config.{$value.config_size_attr}|ucfirst}</h3>
                {$section = $value.config_size_attr}
            {/if}
            <div class="row">
        {elseif ($value@iteration - 1) is div by 3}
            </div>
            {if $value.config_size_attr != $section }
                <h3>{$smarty.config.{$value.config_size_attr}|ucfirst}</h3>
                {$section = $value.config_size_attr}
            {/if}
            <div class="row">
        {else}
            </div>
            {if $value.config_size_attr != $section }
                <h3>{$smarty.config.{$value.config_size_attr}|ucfirst}</h3>
                {$section = $value.config_size_attr}
            {/if}
            <div class="row">
        {/if}
        <form class="forms-config form-inline" method="post" action="" id="si_{$value.attr_name}_{$value.config_size_attr}_{$value.type}">
            <div class="well">
                <h3 class="col-lg-2">{$smarty.config.{$value.img_size_type}}</h3>
                <div class="form-group">
                    <label>{#width#|ucfirst} :</label>
                    <input type="text" class="input-small spincount" name="width" value="{$value.width}" size="50" />
                </div>
                <div class="form-group">
                    <label>{#height#|ucfirst} :</label>
                    <input type="text" class="input-small spincount" name="height" value="{$value.height}" size="50" />
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" name="img_resizing" value="basic" {if $value.img_resizing eq 'basic'} checked="checked"{/if} />
                        Basic
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="img_resizing" value="adaptive" {if $value.img_resizing eq 'adaptive'} checked="checked"{/if} />
                        Adaptive
                    </label>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id_size_img" value="{$value.id_size_img}" />
                    <input type="submit" class="btn btn-primary btn-sm" value="{#save#|ucfirst}" />
                </div>
            </div>
        </form>
        {if $value@last}
        </div>
        {/if}
    {/foreach}
{/if}
</div>