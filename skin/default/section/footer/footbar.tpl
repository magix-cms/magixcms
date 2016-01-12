<section id="footbar" data-spy="affix" data-offset-top="0">
    <div class="wrapper">
        <div class="dropup pull-left">
            <button class="btn btn-flat btn-main-theme dropdown-toggle" type="button" id="menu-share" data-toggle="dropdown" {*aria-haspopup="true" aria-expanded="true"*}>
                <span class="fa fa-share-alt"></span>
                {#share#|ucfirst}
            </button>
        </div>
        <ul class="list-unstyled share-nav" aria-labelledby="menu-share">
            {include file="section/loop/share.tpl" data=$shareData}
        </ul>
        {include file="section/nav/btt.tpl" align="right" affix='none' btn=true}
    </div>
</section>