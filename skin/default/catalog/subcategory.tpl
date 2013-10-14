{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'2','idmetas'=>'1','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'2','idmetas'=>'2','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}{/block}
{block name='body:id'}catalog-subcat{/block}

{block name="article:content"}
    <h1>{$subcat.name}</h1>
    {$subcat.content}
    {widget_catalog_display
    pattern = 'product'
    }
{/block}