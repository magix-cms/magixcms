<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">{#catalog#|ucfirst}</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li{if !$smarty.get.section} class="active" {/if}><a href="/{baseadmin}/catalog.php">{#statistics#|ucfirst}</a></li>
            {if $smarty.get.getlang}
            <li{if $smarty.get.section eq 'category'} class="active" {/if}><a href="/{baseadmin}/catalog.php?section=category&amp;getlang={$smarty.get.getlang}">{#categories#|ucfirst}</a></li>
            <li{if $smarty.get.section eq 'product'} class="active" {/if}><a href="/{baseadmin}/catalog.php?section=product&amp;getlang={$smarty.get.getlang}">{#products#|ucfirst}</a></li>
            {/if}
        </ul>
        {if $smarty.get.section}
        <form action="" class="navbar-form navbar-right">
            {if $smarty.get.section eq 'category'}
            <span class="input-group">
                <span class="input-group-addon">
                    <span class="icon-search"></span>
                </span>
                <input type="text" id="name_category" name="name_category" placeholder="Search" class="form-control">
            </span>
            {elseif $smarty.get.section eq 'product'}
            <span class="input-group">
                <span class="input-group-addon">
                    <span class="icon-search"></span>
                </span>
                <input type="text" id="name_product" name="name_product" placeholder="Search" class="form-control">
            </span>
            {/if}
        </form>
        {/if}
    </div>
</nav>