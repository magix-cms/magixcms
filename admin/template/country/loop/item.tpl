{foreach $getItemData as $key}
    <tr id="item_{$key.idcountry}">
        <td>{#$key.iso#|ucfirst}</td>
        <td>{$key.iso|upper}</td>
        <td><a class="toggleModal" data-toggle="modal" data-target="#deleteModal" href="#{$key.idcountry}"><span class="fa fa-trash-o"></span></a></td>
    </tr>
{/foreach}