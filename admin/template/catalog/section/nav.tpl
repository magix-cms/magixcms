<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/{baseadmin}/catalog.php">{#catalog#|ucfirst}</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            {if $smarty.get.getlang}
            <li{if $smarty.get.section eq 'category'} class="active" {/if}><a href="/{baseadmin}/catalog.php?section=category&amp;getlang={$smarty.get.getlang}">{#categories#|ucfirst}</a></li>
            <li{if $smarty.get.section eq 'product'} class="active" {/if}><a href="/{baseadmin}/catalog.php?section=product&amp;getlang={$smarty.get.getlang}">{#products#|ucfirst}</a></li>
            {/if}
        </ul>
        {if $smarty.get.section}
        <form action="" class="navbar-form navbar-right" role="search">
            {if $smarty.get.section eq 'category'}
            <div class="form-group has-feedback">
                <input type="text" id="name_category" name="name_category" placeholder="{#search#}" class="form-control">
                <span class="fa fa-search form-control-feedback"></span>
            </div>
            {elseif $smarty.get.section eq 'product'}
            <div class="form-group has-feedback">
                <input type="text" id="name_product" name="name_product" placeholder="{#search#}" class="form-control">
                <span class="fa fa-search form-control-feedback"></span>
            </div>
            {/if}
        </form>
        {/if}
    </div>
</nav>