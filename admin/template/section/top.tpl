<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{geturl}/{baseadmin}/">Magix CMS</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                {if {role_admin items='administrator'}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="icon-cogs"></span> Configuration <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/{baseadmin}/config.php">
                                    <span class="icon-cog"></span> {#parameters#|ucfirst}
                                </a>
                            </li>
                            <li>
                                <a href="/{baseadmin}/config.php?section=editor">
                                    <span class="icon-list-alt"></span> {#wysiwyg_editor#|ucfirst}
                                </a>
                            </li>
                            <li>
                                <a href="/{baseadmin}/config.php?section=imagesize">
                                    <span class="icon-picture"></span> {#image_sizes#|ucfirst}
                                </a>
                            </li>
                            <li>
                                <a href="/{baseadmin}/config.php?section=cache">
                                    <span class="icon-folder-open-alt"></span> {#cache_management#|ucfirst}
                                </a>
                            </li>
                        </ul>
                    </li>
                {/if}
                <li{if {script_name} eq "users"} class="active"{/if}>
                    <a href="/{baseadmin}/users.php?action=list">
                        <span class="icon-user"></span> {#users#|ucfirst}
                    </a>
                </li>
                {if {role_admin items='administrator'}}
                    <li{if {script_name} eq "theming"} class="active"{/if}>
                        <a href="/{baseadmin}/theming.php">
                            <span class="icon-columns"></span> {#theming#|ucfirst}</a>
                    </li>
                {/if}
                {if $config_lang eq 1}
                    <li{if {script_name} eq "lang"} class="active"{/if}>
                        <a href="/{baseadmin}/lang.php?action=list">
                            <span class="icon-flag"></span> {#languages#|ucfirst}
                        </a>
                    </li>
                {/if}
                {if {role_admin items='administrator'}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="icon-wrench"></span> {#tools#|ucfirst} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/{baseadmin}/googletools.php">
                                    <span class="icon-google-plus-sign"></span> Google Tools
                                </a>
                            </li>
                            <li><a href="/{baseadmin}/sitemap.php">
                                    <span class="icon-sitemap"></span> Sitemap
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li class="dropdown-header"><span class="icon-bolt"></span> SEO</li>
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
                {/if}
            </ul>
            <p class="navbar-text pull-right">
                <select id="admin-language" title="{#select_admin_language#}">
                    <option {if {iso} == "fr"}selected="selected" {/if} value="fr">
                        FR
                    </option>
                </select>
                <a href="{geturl}/admin/dashboard.php?acsclose" class="navbar-link">
                    <span class="icon-off"></span> Logout
                </a>
            </p>
        </div>
    </div>
</div>