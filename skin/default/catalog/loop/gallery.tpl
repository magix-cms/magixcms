{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$classCol}
    {$classCol = 'col-xs-6'}
{/if}
{if is_array($data) && !empty($data)}
    {foreach $data as $item}
        <div{if $classCol} class="{$classCol}" {/if}>
            <a class="img-gallery" rel="productGallery" href="{$item.imgSrc.medium}" title="{$product.name|ucfirst}">
                <img itemprop="image" class="img-responsive" src="{$item.imgSrc.small}" alt="{$product.name|ucfirst}"/>
            </a>
        </div>
    {/foreach}
{/if}