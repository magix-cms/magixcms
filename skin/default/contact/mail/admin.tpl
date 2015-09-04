{extends file="contact/mail/layout.tpl"}
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
{block name='body:content'}
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
        <td valign="top">
            <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
            <table cellpadding="0" cellspacing="0" border="0" align="center" style="border: 1px solid #959595;">
                <tr>
                    <td width="800" style="background: #222;padding: 15px;/*border-bottom: 1px solid #333;*/" valign="top">
                        <!-- Gmail/Hotmail image display fix -->
                        <a href="{geturl}" target ="_blank" title="{#website#}" style="text-decoration: none;font-size: 46px;">
                            <img src="{geturl}/skin/{template}/img/{#logo_img_small#}" alt="{#logo_img_alt#|ucfirst}" height="50" width="269"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="800" style="background: #ffffff;padding:15px;" valign="top">
                        <h2>{#mail_from#|ucfirst} {$data.firstname}&nbsp;{$data.lastname}</h2>
                        <p>{$data.content|replace:'\n':'<br />'}</p>
                    </td>
                </tr>
                <tr>
                    <td width="400" style="background: #ffffff;padding:15px;" valign="top">
                        <h3>{#mail_from_coor#|ucfirst}</h3>
                        <ul style="padding: 0;list-style-type: none">
                            <li style="padding: 5px 0;">{$data.adress|ucfirst}, {$data.postcode} {$data.city}</li>
                            <li style="padding: 5px 0;">{#mail_email#|ucfirst}&nbsp;: {$data.email}</li>
                            {if $data.phone != null}
                                <li style="padding: 5px 0;">{#mail_phone#|ucfirst}&nbsp;: {$data.phone}</li>
                            {/if}
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