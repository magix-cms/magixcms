    <div id="header-inner" class="navbar navbar-default" role="navigation">
        <div class="container">
            <div id="navbar-header" class="navbar-header">

                {* Show Nav Button (xs ad sm only) *}
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-primary-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                {* Language Nav *}
                <ul id="lang-box" class="nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle clearfix" data-toggle="dropdown" title="{#choose_language#|ucfirst}">
                            <span class="glyphicon glyphicon-flag navbar-left">&nbsp;</span>
                            <span class="visible-md visible-lg navbar-left">
                                {#choose_language#|ucfirst}
                            </span>
                        </a>
                        {widget_lang_display
                            htmlStructure=[
                                'container' => [
                                'before' => '<ul id="nav-lang" class="dropdown-menu">'
                                ]
                            ]
                        }
                    </li>
                </ul>

                {* Brand && Headline *}
                <a id="navbar-brand" class="navbar-brand" href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                        <img src="/skin/{template}/img/logo-magix_cms.png" alt="{#logo_img_alt#|ucfirst}" />
                 </a>
{*
                <p id="navbar-headline" class="navbar-text pull-left visible-md visible-lg">
                    Uncomment && place headline here
                </p>
*}
            </div>

            {* Share tools *}
            <ul id="share-box" class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-share">&nbsp;</span>
                    <span class="dropdown-text">
                        {#share#|ucfirst}
                    </span>
                    </a>
                    {widget_share_display
                    htmlStructure=[
                    'container' => [
                    'before' => '<ul id="share-nav" class="dropdown-menu">',
                    'after' => '</ul>'
                    ]
                    ]
                    }
                </li>
            </ul>

            {* Primary Nav *}
            <nav id="nav-primary-collapse" class="collapse navbar-collapse">
                <ul id="nav-primary" class="nav navbar-nav">
                    {include file="section/nav/primary.tpl"}
                </ul>
            </nav>

        </div>
    </div>