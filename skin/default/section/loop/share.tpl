{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <li class="share-{$item.name}">
            <a class="targetblank" href="{$item.url}" title="{#share_on#|ucfirst} {$item.name|ucfirst}">
                <div>
                    <p>
                        <span>
                            <img src="/skin/{template}/img/share/socials.png" alt="{$item.name|ucfirst}" width="28" height="140"/>
                        </span>
                        <span class="sr-only">{$item.name|ucfirst}</span>
                    </p>
                </div>
            </a>
        </li>
    {/foreach}
{/if}
