<ul class="nav nav-tabs clearfix">
    <li{if !$smarty.get.tab} class="active"{/if}>
        <a href="/{baseadmin}/plugins.php?name=clearcache">Accueil</a>
    </li>
    <li{if $smarty.get.tab eq 'about'} class="active"{/if}>
        <a href="/{baseadmin}/plugins.php?name=clearcache&amp;tab=about">About</a>
    </li>
</ul>