{extends file="contact/mail/layout.tpl"}
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
{block name='body:content'}
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
        <td valign="top">
            <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
            <table cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td width="600" style="background: #222222;padding:5px;" valign="top">
                        <!-- Gmail/Hotmail image display fix -->
                        <a href="http://www.magix-cms.com" target ="_blank" title="Magix CMS">
                            <img class="image_fix" src="http://www.magix-cms.com/skin/magixcms2/img/logo-magix_cms.png" alt="Magix CMS" title="Magix CMS" width="269" height="50" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="600" style="background: #FFFFFF;padding:5px;" valign="top">
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
                    </td>
                </tr>
            </table>
            <!-- End example table -->
            {*
            <!-- Working with telephone numbers (including sms prompts).  Use the "mobile" class to style appropriately in desktop clients
            versus mobile clients. -->
            <span class="mobile_link">123-456-7890</span>
            *}
        </td>
    </tr>
</table>
{/block}
<!-- End of wrapper table -->