{if is_array($data) && !empty($data)}
{foreach $data as $item}
    <li>
        <a class="targetblank" href="{$item.url}" title="{#share_on#|ucfirst} {$item.name|ucfirst}">
            <img src="/skin/{template}/img/share/{$item.img}" alt="{$item.name|ucfirst}" />
        </a>
    </li>
{/foreach}
{/if}
