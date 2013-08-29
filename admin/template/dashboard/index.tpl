{extends file="layout.tpl"}
{block name='body:id'}module-dashboard{/block}
{block name="article:content"}
    <div class="row">
        <div class="col-sm-6 col-lg-6">
            <h2><span class="icon-certificate"></span> {#h2_install_analyse#}</h2>
            <div class="alert alert-info">
                <span class="icon-info-sign"></span> {#alert_magixcms_version#}
                <span id="version"></span>
            </div>
            <p>
                {#p_magixcms_version#}
            </p>
            <ul class="list-inline">
                <li>
                    <a href="#">
                        <span class="icon-external-link"></span> {#website#|ucfirst}
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon-info-sign"></span> Documentation
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon-wrench"></span> API
                    </a>
                </li>
                <li>
                    <a class="targetblank" href="https://github.com/gtraxx/magixcms">
                        <span class="icon-github"></span> Github
                    </a>
                </li>
            </ul>
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <h3><span class="icon-user"></span> {#users#|ucfirst}</h3>
                    {foreach $array_stats_user as $key => $value nocache}
                        <p>
                            <span class="badge badge-info">{$value}</span> {$key|ucfirst}
                        </p>
                    {/foreach}
                </div>
                <div class="col-sm-6 col-lg-6">
                    <h3><span class="icon-flag"></span> {#languages#|ucfirst}</h3>
                    <ul class="list-inline">
                        {foreach $array_lang as $key => $value nocache}
                            <li>
                                <span class="badge badge-info">{$value|upper}</span>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-lg-6">
            <h2><span class="icon-bolt"></span> {#h2_quick_links#}</h2>
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <h3><span class="icon-file-alt"></span> Pages</h3>
                    <ul class="list-unstyled">
                        <li>
                            <ul class="list-inline">
                                {foreach $array_lang as $key => $value nocache}
                                    <li>
                                        <a href="/{baseadmin}/cms.php?getlang={$key}&amp;action=list">
                                            <span class="badge badge-info">{$value|upper}</span>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <h3><span class="icon-home"></span> {#home#|ucfirst}</h3>
                    <ul class="list-unstyled">
                        <li>
                            <a href="/{baseadmin}/home.php?action=list">
                                <span class="badge badge-info"><span class="icon-list-ul"></span> {#list#|ucfirst}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <h3><span class="icon-shopping-cart"></span> {#catalog#|ucfirst}</h3>
                    <ul class="list-unstyled">
                        <li>
                            <h4><span class="icon-folder-open-alt"></span> {#category#|ucfirst}</h4>
                            <ul class="list-inline">
                                {foreach $array_lang as $key => $value nocache}
                                    <li>
                                        <a href="/{baseadmin}/catalog.php?section=category&amp;getlang={$key}">
                                            <span class="badge badge-info">{$value|upper}</span>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                        <li>
                            <h4><span class="icon-shopping-cart"></span> {#products#|ucfirst}</h4>
                            <ul class="list-inline">
                                {foreach $array_lang as $key => $value nocache}
                                    <li>
                                        <a href="/{baseadmin}/catalog.php?section=product&amp;getlang={$key}">
                                            <span class="badge badge-info">{$value|upper}</span>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <h3><span class="icon-rss"></span> {#news#|ucfirst}</h3>
                    <ul class="list-unstyled">
                        <li>
                            <ul class="list-inline">
                                {foreach $array_lang as $key => $value nocache}
                                    <li>
                                        <a href="/{baseadmin}/news.php?getlang={$key}&amp;action=list">
                                            <span class="badge badge-info">{$value|upper}</span>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-6">
            <h2>
                <span class="icon-bar-chart"></span> {#h2_statistics_pages#|ucfirst}
            </h2>
            <div id="graphPages"></div>
        </div>
        <div class="col-sm-6 col-lg-6">
            <h2><span class="icon-external-link"></span> {#h2_links#|ucfirst}</h2>
            <ul class="list-unstyled">
                <li>
                    <a class="targetblank" href="http://getbootstrap.com/">
                        Twitter Bootstrap
                    </a>
                </li>
                <li>
                    <a class="targetblank" href="http://addyosmani.github.com/jquery-ui-bootstrap/">
                        jQuery UI Bootstrap
                    </a>
                </li>
                <li>
                    <a class="targetblank" href="http://fortawesome.github.io/Font-Awesome/">
                        Font Awesome
                    </a>
                </li>
            </ul>
        </div>
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="dashboard/section/js.tpl"}
{/block}