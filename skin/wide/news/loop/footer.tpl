{if isset($data.id)}
    {$data = [$data]}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <a href="{$item.uri}" title="{$item.name|ucfirst}">
        <div class="media-footer">
            <h5>{$item.name|ucfirst}</h5>
            <p>
                {$item.content|strip_tags|truncate:100:"..."}
            </p>
            <small><time datetime="{$item.date.publish}">{$item.date.publish|date_format:"%e %B %Y"}</time></small>
        </div>
        </a>
    {/foreach}
{/if}