<table class="table table-bordered table-condensed table-hover">
    <thead>
    <tr>
        <th>Pays</th>
        <th>Iso</th>
        <th><span class="fa fa-trash-o"></span></th>
    </tr>
    </thead>
    <tbody id="list_page">
    {if is_array($getItemsData) && !empty($getItemsData)}
    {foreach $getItemsData as $key}
    <tr id="item_{$key.idcountry}">
        <td>{#$key.iso#|ucfirst}</td>
        <td>{$key.iso|upper}</td>
        <td><a class="toggleModal" data-toggle="modal" data-target="#deleteModal" href="#{$key.idcountry}"><span class="fa fa-trash-o"></span></a></td>
    </tr>
    {/foreach}
    {/if}
    {include file="country/no-entry.tpl"}
    </tbody>
</table>