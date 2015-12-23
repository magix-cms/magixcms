<div class="modal fade" id="add-page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">{#modal_add_page#|ucfirst}</h4>
            </div>
            <form id="add_about_page" class="forms_plugins_travel" method="post" action="">
                <div class="modal-body row">
                    <div class="form-group col-xs-12">
                        <label for="subject">{#page_title#|ucfirst}&nbsp;*</label>
                        <input id="subject" class="form-control" type="text" size="150" value="" name="subject" placeholder="{#page_title_ph#|ucfirst}">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="idlang">{#page_lang#|ucfirst}&nbsp;*</label>
                        <select id="idlang" class="form-control" name="idlang">
                            <option value="">{#choose_lang#|ucfirst}</option>
                            {foreach $languages as $lang}
                                <option value="{$lang.idlang}">{$lang.iso|upper} ({$lang.language|ucfirst})</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{#cancel#|ucfirst}</button>
                    <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}"/>
                </div>
            </form>
        </div>
    </div>
</div>