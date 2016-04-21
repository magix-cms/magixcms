<table class="table table-bordered table-condensed table-hover">
    <thead>
    <tr>
        <th>Pays</th>
        <th>Iso</th>
        <th><span class="fa fa-trash-o"></span></th>
    </tr>
    </thead>
{if is_array($getItemsData) && !empty($getItemsData)}
    <tbody>
{foreach $getItemsData as $key}

{/foreach}
    </tbody>
{/if}
</table>