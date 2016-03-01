{if $type eq 'head'}
{if is_array($data) && !empty($data)}
{foreach $data as $item}
<link rel="alternate" href="{geturl}/{$item.iso}/" hreflang="{$item.iso}" />
{/foreach}
{/if}
{elseif $type eq 'nav'}
    {if is_array($data) && !empty($data)}
        {if $display eq 'list'}
            <ul class="lang-nav list-inline">
                {foreach $data as $item}
                    <li>
                        <a{if $smarty.get.strLangue eq $item.iso} class="active"{/if} href="/{$item.iso}/" hreflang="{$item.iso}" title="{#go_to_version#|ucfirst}: {$item.language|var_dump}">
                            {$item.iso|upper}
                        </a>
                    </li>
                {/foreach}
            </ul>
        {elseif $display eq 'menu'}
        <div class="dropdown">
            <a class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                {if $smarty.get.strLangue}
                    {$smarty.get.strLangue|upper}
                {else}
                    {$defaultLang.iso|upper}
                {/if}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="menu-language">
                {foreach $data as $item}
                    <li>
                        <a{if (isset($smarty.get.strLangue) && $item.iso eq $smarty.get.strLangue) || (!isset($smarty.get.strLangue) && $item.iso eq $defaultLang.iso)} class="active"{/if} href="/{$item.iso}/" hreflang="{$item.iso}" title="{#go_to_version#|ucfirst}: {$item.language|var_dump}">
                            {$item.iso|upper}
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>
        {/if}
    {/if}
{/if}