{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-6 col-md-6 col-lg-6'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <div{if $classCol} class="{$classCol}" {/if}>
            <a class="img-gallery" rel="productGallery" href="{$item.imgSrc.medium}" title="{$product.name|ucfirst}">
                {if $item.imgSrc.medium}
                    <img class="img-thumbnail img-responsive" src="{$item.imgSrc.small}" alt="{$product.name|ucfirst}"/>
                {else}
                    <img class="img-thumbnail img-responsive" src="{$item.imgSrc.default}" alt="{$product.name|ucfirst}"/>
                {/if}
            </a>
        </div>
    {/foreach}
{/if}