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
                {widget_lang_data assign="dataLangNav"}
                <div class="nav navbar-right lang-header">
                    {include file="section/loop/lang.tpl" data=$dataLangNav type="nav"}
                </div>
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
            {widget_share_data
                assign="shareData"
            }
            <ul id="share-box" class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-share">&nbsp;</span>
                    <span class="dropdown-text">
                        {#share#|ucfirst}
                    </span>
                    </a>
                    <ul id="share-nav" class="dropdown-menu">
                        {include file="section/loop/share.tpl" data=$shareData}
                    </ul>
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