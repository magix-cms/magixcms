<section id="sharebar" class="hidden-xs">
    {if $adjust == 'clip'}
    <div class="container">
        {/if}
        <span class="label">{#share#|ucfirst}&nbsp;:</span>
        <ul class="list-unstyled list-inline share-nav">
            {include file="section/loop/share.tpl" data=$shareData}
        </ul>
        {if $adjust == 'clip'}
    </div>
    {/if}
</section>