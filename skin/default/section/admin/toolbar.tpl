<section id="admin-panel" class="affix affix-top">
    <div class="dropdown">
        <button class="btn btn-flat btn-dark-theme dropdown-toggle" type="button" id="adminmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-user"></span>
            {$displayAdminPanel.pseudo_admin}
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