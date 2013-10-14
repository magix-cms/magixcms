{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>$cat.name]  category=$cat.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>$cat.name] category=$cat.name}{/block}
{block name='body:id'}catalog-cat{/block}

{block name="article:content"}
    <h1>{$cat.name}</h1>
    {$cat.content}
    {widget_catalog_display}
    {widget_catalog_display
    conf =[
    'context' =>  'product'
    ]
    pattern = 'product'
    }
{/block}