<h3>{#add_access#}</h3>
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
    <div class="form-group">
        <label>
            <input type="checkbox" id="selectAll" /> Select All
        </label>
    </div>
    <label class="checkbox-inline">
        <input type="checkbox" name="view_access" id="view_access" class="checkbox-access" value="1" /> {#view#}
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="add_access" id="add_access" class="checkbox-access" value="1" /> {#add#}
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="edit_access" id="edit_access" class="checkbox-access" value="1" /> {#edit#}
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="delete_access" id="delete_access" class="checkbox-access" value="1" /> {#remove#}
    </label>
    <div class="input-btn">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>