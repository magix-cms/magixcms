{if is_array($data) && !empty($data)}
{widget_country_data}
{if is_array($countryData) && !empty($countryData)}
<select class="{$data.class}" id="{$data.id}" name="{$data.name}">
    {foreach $countryData as $key nocache}
        <option value="{$key.country}">{#$key.iso#|ucfirst}</option>
    {/foreach}
</select>
{/if}
{/if}