{if $data.title != null}
    <p>{$smarty.config.subject_contact|sprintf:$data.title:$smarty.config.website}</p>
{/if}
<ul>
    <li>{$data.lastname}</li>
    <li>{$data.firstname}</li>
    <li>{$data.email}</li>
    {if $data.phone != null}
    <li>{$data.phone}</li>
    {/if}
    {if $data.adress != null}
    <li>{$data.adress}</li>
    {/if}
    <li>{$data.content|replace:'\n':'<br />'}</li>
</ul>