<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">{#localization#}</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            {if {employee_access type="view_access" class_name="backend_controller_lang"} eq 1 AND $config_lang eq 1}
            <li><a href="/{baseadmin}/lang.php?action=list">{#languages#|ucfirst}</a></li>
            {/if}
            {if {employee_access type="view_access" class_name="backend_controller_country"} eq 1}
            <li><a href="/{baseadmin}/country.php">{#country#|ucfirst}</a></li>
            {/if}
        </ul>
    </div>
</nav>