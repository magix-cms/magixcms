<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#about-navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bar"></span>
            <span class="fa fa-bar"></span>
            <span class="fa fa-bar"></span>
        </button>
        <a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=index" class="navbar-brand">À Propos</a>
    </div>
    <div id="about-navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li class="pull-right">
                <a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=about"><span class="fa fa-info-circle"></span> {#plugin_about#|ucfirst}</a>
            </li>
        </ul>
    </div>
</nav>