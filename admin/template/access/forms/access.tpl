<h3>Ajouter des permissions</h3>
<form id="forms_access_add" method="post" action="">
    <div class="form-group">
        <label for="id_module">Module</label>
        <select id="id_module" name="id_module" class="form-control">
            {foreach $selectAccess as $key nocache}
                <option value="{$key.id_module}">
                    {$key.name}
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
    <div>
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>