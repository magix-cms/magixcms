<h3>Ajouter des permissions</h3>
<form id="forms_access_add" method="post" action="">
    <div class="form-group">
        <label for="class_name">Module</label>
        <select id="class_name" name="class_name" class="form-control">
            {foreach $selectAccess as $key => $value nocache}
                <option value="{$key}">
                    {$value}
                </option>
            {/foreach}
        </select>
    </div>
    <label class="checkbox-inline">
        <input type="checkbox" name="view_access" id="view_access" value="1" /> Voir
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="add_access" id="add_access" value="1" /> Ajouter
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="edit_access" id="edit_access" value="1" /> Editer
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="delete_access" id="delete_access" value="1" /> Supprimer
    </label>
    <div class="form-group">
        <label for="plugins">plugins</label>
        <input type="text" id="plugins" name="plugins" class="form-control" value="" />
    </div>
    <div>
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>