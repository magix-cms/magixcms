{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <li class="share-{$item.name}">
            <a class="targetblank" href="{$item.url}" title="{#share_on#|ucfirst} {$item.name|ucfirst}">
                <div>
                    <p>
                        <span class="fa fa-{$item.name}{if $item.name == 'google'}-plus{/if}"></span>
                        <span class="sr-only">{$item.name|ucfirst}</span>
                    </p>
                </div>
            </a>
        </li>
    {/foreach}
{/if}