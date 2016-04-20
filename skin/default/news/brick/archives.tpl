{widget_news_data archives={getlang}}
{if $archives}
    <nav id="archives-menu" class="nav-sidebar" role="tablist">
        <h4>Archives</h4>
        {foreach $archives as $k => $arch}
            <div>
                <div class="year" role="tab">
                    <p>
                        <a href="{geturl}/{getlang}/{#nav_news_uri#}/{$arch['year']}/">{$arch['year']}</a>
                        <a {if {'Y'|date} != $arch['year']}class="collapsed"{/if} aria-controls="year{$k}" aria-expanded="{if {'Y'|date} != $arch['year']}true{else}false{/if}" href="#year{$k}" data-toggle="collapse" role="button">
                            <span class="fa"></span>
                        </a>
                    </p>
                </div>
                <div id="year{$k}" class="months collapse {if {'Y'|date} == $arch['year']}in{/if}" role="tabpanel" aria-expanded="{if {'Y'|date} != $arch['year']}true{else}false{/if}" style="">
                    <ul class="list-unstyled">
                        {if !empty($arch['months'])}
                            {foreach $arch['months'] as $month}
                                <li class="month">
                                    <a href="{geturl}/{getlang}/{#nav_news_uri#}/{$arch['year']}/{"%02d"|sprintf:$month['month']}/">
                                        {$arch['year']|cat:"-%02d-01"|sprintf:$month['month']|date_format:'%B'|ucfirst}
                                        <small>(&thinsp;{$month['nbr']}&thinsp;)</small>
                                    </a>
                                </li>
                            {/foreach}
                        {/if}
                    </ul>
                </div>
            </div>
        {/foreach}
    </nav>
{/if}