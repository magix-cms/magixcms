{extends file="layout.tpl"}
{block name='body:id'}module-dashboard{/block}
{block name="article:content"}
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2><span class="fa fa-certificate"></span> {#h2_install_analyse#}</h2>
            <div class="alert alert-info">
                <span class="fa fa-info-circle"></span> {#alert_magixcms_version#}
                <span id="version"></span>
            </div>
            <p>
                {#p_magixcms_version#}
            </p>
            <ul class="list-inline">
                <li>
                    <a class="targetblank" href="http://www.magix-cms.com">
                        <span class="fa fa-external-link"></span> {#website#|ucfirst}
                    </a>
                </li>
                <li>
                    <a class="targetblank" href="http://www.magix-cms.com/fr/catalogue/">
                        <span class="fa fa-info-circle"></span> {#integrator#|ucfirst}
                    </a>
                </li>
                <li>
                    <a class="targetblank" href="http://www.magix-cms.com/fr/catalogue/6-qu-est-ce-qu-un-plugin/">
                        <span class="fa fa-wrench"></span> {#developer#|ucfirst}
                    </a>
                </li>
                <li>
                    <a class="targetblank" href="https://github.com/magix-cms/magixcms">
                        <span class="fa fa-github"></span> Github
                    </a>
                </li>
            </ul>
            <div class="row">
                {if {employee_access type="view_access" class_name="backend_controller_employee"} eq 1}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h3><span class="fa fa-user"></span> {#users#|ucfirst}</h3>
                    {foreach $array_stats_user as $key => $value nocache}
                        <p>
                            <span class="badge badge-info">{$value}</span> {$key|ucfirst}
                        </p>
                    {/foreach}
                </div>
                {/if}
                {if {employee_access type="view_access" class_name="backend_controller_lang"} eq 1 AND $config_lang eq 1}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h3><span class="fa fa-flag"></span> {#languages#|ucfirst}</h3>
                    <ul class="list-inline">
                        {foreach $array_lang as $key => $value nocache}
                            <li>
                                <span class="badge badge-info">{$value|upper}</span>
                            </li>
                        {/foreach}
                    </ul>
                </div>
                {/if}
            </div>

        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2><span class="fa fa-bolt"></span> {#h2_quick_links#}</h2>
            <div class="row">
                {if {employee_access class_name="backend_controller_cms"} eq 1 AND $config_cms eq 1}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h3><span class="fa fa-file-text-o"></span> Pages</h3>
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
                {/if}
                {if {employee_access class_name="backend_controller_home"} eq 1}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h3><span class="fa fa-home"></span> {#home#|ucfirst}</h3>
                    <ul class="list-unstyled">
                        <li>
                            <a href="/{baseadmin}/home.php?action=list">
                                <span class="badge badge-info"><span class="fa fa-list-ul"></span> {#list#|ucfirst}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {/if}
            </div>
            <div class="row">
                {if {employee_access class_name="backend_controller_catalog"} eq 1 AND $config_catalog eq 1}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h3><span class="fa fa-shopping-cart"></span> {#catalog#|ucfirst}</h3>
                    <ul class="list-unstyled">
                        <li>
                            <h4><span class="fa fa-folder-open-alt"></span> {#category#|ucfirst}</h4>
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
                            <h4><span class="fa fa-shopping-cart"></span> {#products#|ucfirst}</h4>
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
                {/if}
                {if {employee_access class_name="backend_controller_news"} eq 1 AND $config_news eq 1}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h3><span class="fa fa-rss"></span> {#news#|ucfirst}</h3>
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
                {/if}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2>
                <span class="fa fa-bar-chart"></span> {#h2_statistics_pages#|ucfirst}
            </h2>
            <div id="graphPages"></div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2><span class="fa fa-external-link"></span> {#h2_links#|ucfirst}</h2>
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