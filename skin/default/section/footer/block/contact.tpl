<div id="block-contact" class="col-xs-12 col-sm-4 pull-right block">
    <h4>{#contact_label_title#|ucfirst}</h4>
    <p>
        {#contact_label_content#} <a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}">
            {#contact_label_link#}
        </a>
    </p>

    <ul class="contact-list-footer list-unstyled">
        {if $companyData.contact.phone}
            <li>
                <span class="fa fa-phone"></span> <strong>{$companyData.contact.phone}</strong>
            </li>
        {/if}
        {if $companyData.contact.mobile}
            <li>
                <span class="fa fa-mobile"></span> <strong>{$companyData.contact.mobile}</strong>
            </li>
        {/if}
        {if $companyData.contact.fax}
            <li>
                <span class="fa fa-fax"></span> <strong>{$companyData.contact.fax}</strong>
            </li>
        {/if}
    </ul>
    {if $companyData.contact.mail}
        <p class="mailto">
            {#contact_label_mail#}
            {mailto address={$companyData.contact.mail} encode="hex"}
        </p>
    {/if}
</div>