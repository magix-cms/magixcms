<section id="admin-panel">
    <div class="dropdown">
        <button class="btn btn-box btn-flat btn-dark-theme dropdown-toggle" type="button" id="adminmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-user"></span>
            <span class="hidden-xs">{$displayAdminPanel.pseudo_admin}</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="adminmenu">
            <li>
                <a href="{geturl}/admin/dashboard.php">
                    <span class="fa fa-dashboard"></span> Dashboard
                </a>
            </li>
            <li>
                <a href="{geturl}/admin/dashboard.php?logout">
                    <span class="fa fa-sign-out"></span> Logout
                </a>
            </li>
        </ul>
    </div>
</section>