<form id="forms_home_add" method="post" action="">
    <div class="form-group">
        <label for="subject">{#label_title#|ucfirst} *</label>
        <input type="text" placeholder="{#label_title#|ucfirst}" class="form-control" id="subject" name="subject" value="" size="50" />
    </div>
        <div class="form-group">
        <label for="idlang">{#label_language#|ucfirst} *</label>
        {$select_lang}
    </div>
</form>