{strip}
    {if !isset($adjust)}
        {assign var="adjust" value="clip"}
    {/if}
    {* facebook, news, cms, contact, newsletter*}
    {if !isset($blocks)}
        {assign var="blocks" value=['news','contact']}
    {/if}
    {widget_share_data assign="shareData"}
{/strip}
<footer id="footer"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
    {include file="section/footer/sharebar.tpl"}
    <section id="footer-blocks">
    {if $adjust == 'clip'}
        <div class="container">
            <div class="row">
            {/if}
            {foreach $blocks as $block}
                {include file="section/footer/block/$block.tpl"}
            {/foreach}
            {if $adjust == 'clip'}
            </div>
        </div>
    {/if}
    </section>
    <section id="colophon">
    {if $adjust == 'clip'}
        <div class="container">
            <div class="row">
            {/if}
            {include file="section/footer/about.tpl"}
            {if $adjust == 'clip'}
            </div>
        </div>
    {/if}
    </section>
</footer>
{include file="section/footer/footbar.tpl"}