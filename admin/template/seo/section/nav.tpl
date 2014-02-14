<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/{baseadmin}/seo.php">SEO</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
             <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">Langues <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    {foreach $array_lang as $key => $value nocache}
                        <li>
                            <a href="/{baseadmin}/seo.php?getlang={$key}&amp;action=list">
                                {$value|upper}
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </li>
        </ul>
    </div>
</nav>