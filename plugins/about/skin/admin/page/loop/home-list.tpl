<table class="table table-bordered table-condensed table-hover">
    <thead>
    <tr>
        <th><span class="fa fa-key"></span></th>
        <th>{#page_title#|ucfirst}</th>
        <th>{#page_content#|ucfirst}</th>
        <th>{#page_seo_title#|ucfirst}</th>
        <th>{#page_seo_desc#|ucfirst}</th>
        <th><span class="fa fa-users"></span></th>
        <th><span class="fa fa-edit"></span></th>
        <th><span class="fa fa-trash-o"></span></th>
    </tr>
    </thead>
    <tbody id="list_page">
    {if !isset($child)}
        {$child = true}
    {/if}
    {if !empty($pages)}
        {foreach $pages as $page}
            <tr id="item_{$page.id}">
                <td>{$page.id}</td>
                <td><a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=page&amp;action=edit&amp;edit={$page.id}">{$page.title}</a></td>
                <td>{if $page.content}<span class="fa fa-check"></span>{else}<span class="fa fa-warning"></span>{/if}</td>
                <td>{if $page.seo_title_page}<span class="fa fa-check"></span>{else}<span class="fa fa-warning"></span>{/if}</td>
                <td>{if $page.seo_desc_page}<span class="fa fa-check"></span>{else}<span class="fa fa-warning"></span>{/if}</td>
                {if $child}<td><a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=page&amp;action=getchild&amp;parent={$page.id}"><span class="fa fa-users"></span></a></td>{/if}
                <td><a href="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=page&amp;action=edit&amp;edit={$page.id}"><span class="fa fa-edit"></span></a></td>
                <td><a class="toggleModal" data-toggle="modal" data-target="#deleteModal" href="#{$page.id}"><span class="fa fa-trash-o"></span></a></td>
            </tr>
        {/foreach}
    {/if}
    {include file="page/no-entry.tpl"}
    </tbody>
</table>