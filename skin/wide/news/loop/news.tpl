{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-sm-6 col-md-6 col-lg-6'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        {if $classCat && is_bool($classCat)}
            {$classCat =  "thumbcat-{$item.id}"}
        {/if}
        <div class="media">
            <a class="media-link-object pull-left" href="{$item.uri}" title="{$item.name|ucfirst}">
                {if $item.imgSrc.small}
                    <img class="media-object" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
                {else}
                    <img class="media-object" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                {/if}
            </a>
            <div class="media-body">
                <h4 class="media-heading">
                    <span class="date label label-default pull-right">
                        <span class="day">{$item.date.publish|date_format:"%d"}</span>
                        <span class="month">{$item.date.publish|date_format:"/%m"}</span>
                        <span class="year">{$item.date.publish|date_format:"/%Y"}</span>
                    </span>
                    <a href="{$item.uri}" title="{#show_more#|ucfirst}">
                        {$item.name|ucfirst}
                    </a>
                </h4>
                {capture name="linkMore"}<br /><a class="link" href="{$item.uri}" title="{$item.name|ucfirst}">{#read_more#|ucfirst}</a>{/capture}
                {$trunLength = ($smarty.capture.linkMore|strlen + 230)}
                <p>
                    {$item.content|strip_tags|truncate:$trunLength:"... {$smarty.capture.linkMore}"}
                </p>
            </div>
        </div>
    {/foreach}
{/if}