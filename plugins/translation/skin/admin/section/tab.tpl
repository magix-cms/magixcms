<ul class="nav nav-tabs clearfix">
    <li{if !$smarty.get.tab AND $smarty.get.action eq 'list'} class="active"{/if}>
        <a href="/{baseadmin}/plugins.php?name=translation&amp;getlang={$smarty.get.getlang}&amp;action=list">{#home#}</a>
    </li>
    {if $smarty.get.section}
    <li{if !$smarty.get.tab AND $smarty.get.action eq 'edit'} class="active"{/if}>
        <a href="/{baseadmin}/plugins.php?name=translation&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;section={$smarty.get.section}{if $smarty.get.plugin}&amp;plugin={$smarty.get.plugin}{/if}">Edition</a>
    </li>
    {/if}
    <li{if $smarty.get.tab eq 'about'} class="active"{/if}>
        <a href="/{baseadmin}/plugins.php?name=translation&amp;getlang={$smarty.get.getlang}&amp;tab=about">About</a>
    </li>
</ul>