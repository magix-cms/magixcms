<div class="navbar navbar-dark navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{geturl}/{baseadmin}/">Magix CMS</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                {if {employee_access type="view_access" class_name="backend_controller_config"} eq 1}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="fa fa-cogs"></span> Configuration <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/{baseadmin}/config.php">
                                    <span class="fa fa-cog"></span> {#parameters#|ucfirst}
                                </a>
                            </li>
                            <li>
                                <a href="/{baseadmin}/config.php?section=editor">
                                    <span class="fa fa-list-alt"></span> {#wysiwyg_editor#|ucfirst}
                                </a>
                            </li>
                            <li>
                                <a href="/{baseadmin}/config.php?section=imagesize">
                                    <span class="fa fa-picture-o"></span> {#image_sizes#|ucfirst}
                                </a>
                            </li>
                            <li>
                                <a href="/{baseadmin}/config.php?section=cache">
                                    <span class="fa fa-folder-open"></span> {#cache_management#|ucfirst}
                                </a>
                            </li>
                        </ul>
                    </li>
                {/if}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-users"></span> {#users#|ucfirst} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        {if {employee_access type="view_access" class_name="backend_controller_employee"} eq 1}
                        <li{if {script_name} eq "employee"} class="active"{/if}>
                            <a href="/{baseadmin}/employee.php?action=list">
                                <span class="fa fa-user"></span> {#users#|ucfirst}
                            </a>
                        </li>
                        {/if}
                        {if {employee_access type="view_access" class_name="backend_controller_access"} eq 1}
                        <li{if {script_name} eq "access"} class="active"{/if}>
                            <a href="/{baseadmin}/access.php?action=list">
                                <span class="fa fa-key"></span> {#roles#|ucfirst}
                            </a>
                        </li>
                        {/if}
                    </ul>
                </li>
                {if {role_admin items='administrator'}}
                    <li{if {script_name} eq "theming"} class="active"{/if}>
                        <a href="/{baseadmin}/theming.php">
                            <span class="fa fa-columns"></span> {#theming#|ucfirst}</a>
                    </li>
                {/if}
                {if {employee_access type="view_access" class_name="backend_controller_lang"} eq 1 AND $config_lang eq 1}
                    <li{if {script_name} eq "lang"} class="active"{/if}>
                        <a href="/{baseadmin}/lang.php?action=list">
                            <span class="fa fa-flag"></span> {#languages#|ucfirst}
                        </a>
                    </li>
                {/if}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-wrench"></span> {#tools#|ucfirst} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/{baseadmin}/googletools.php">
                                <span class="fa fa-google-plus-square"></span> Google Tools
                            </a>
                        </li>
                        <li><a href="/{baseadmin}/sitemap.php">
                                <span class="fa fa-sitemap"></span> Sitemap
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header"><span class="fa fa-bolt"></span> SEO</li>
                        {if $config_metasrewrite eq 1}
                            {foreach $array_lang as $key => $value nocache}
                                <li>
                                    <a tabindex="-1" href="/{baseadmin}/seo.php?getlang={$key}&amp;action=list">
                                        {$value|upper}
                                    </a>
                                </li>
                            {/foreach}
                        {/if}
                    </ul>
                </li>
            </ul>
            <p class="navbar-text navbar-right">
                <select id="admin-language" title="{#select_admin_language#}">
                    <option {if {iso} == "fr"}selected="selected" {/if} value="fr">
                        FR
                    </option>
                </select>
                <a href="{geturl}/admin/dashboard.php?logout" class="navbar-link">
                    <span class="fa fa-off"></span> Logout
                </a>
            </p>
        </div>
    </div>
</div>