{if isset($data.id)}
    {$data = [$data]}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
    <a class="text-center col-xs-6 col-sm-12" href="{$item.uri}" title="{$item.name|ucfirst}">
        {if $item.imgSrc.small}
            <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
        {else}
            <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
        {/if}
        <span class="panel-title">{$item.name|ucfirst}</span>
        <span class="date label label-default">
				<span class="day">{$item.date.publish|date_format:"%d"}</span>
				<span class="month">{$item.date.publish|date_format:"/%m"}</span>
				<span class="year">{$item.date.publish|date_format:"/%Y"}</span>
			</span>
    </a>
    {/foreach}
{/if}