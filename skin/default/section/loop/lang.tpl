{if $type eq 'head'}
{if is_array($data) && !empty($data)}
{foreach $data as $item}
<link rel="alternate" href="{geturl}/{$item.iso}/" hreflang="{$item.iso}" />
{/foreach}
{/if}
{elseif $type eq 'nav'}
    {if is_array($data) && !empty($data)}
        <ul class="lang-nav list-inline">
        {foreach $data as $item}
            <li>
                <a{if $smarty.get.strLangue eq $item.iso} class="active"{/if} href="/{$item.iso}/" hreflang="{$item.iso}" title="{#go_to_version#|ucfirst}: {$item.language}">
                    {$item.iso|upper}
                </a>
            </li>
        {/foreach}
        </ul>
    {/if}
{/if}