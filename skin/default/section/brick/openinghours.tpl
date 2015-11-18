{$open_days = array()}
{$open = ''}
{$close = ''}
{foreach $companyData.specifications as $day => $specific}
    {if $specific.open_day}
        {$open_days[] = $day}

        {if $open == '' || $specific.open_time < $open}
            {$open = $specific.open_time}
        {/if}

        {if $close == '' || $specific.close_time > $close}
            {$close = $specific.close_time}
        {/if}
    {/if}
{/foreach}
{$open_days = ','|implode:$open_days}

<time itemprop="openingHours" datetime="{$open_days} {$open}-{$close}"></time>

<table class="table table-bordered">
    <thead>
    <tr>
        <th><span class="fa fa-clock-o"></span></th>
        <th>entre</th>
        <th>et entre</th>
    </tr>
    </thead>
    <tbody>
    {foreach $companyData.specifications as $day => $specific}
        {$dayOfWeek = 'opening_'|cat:$day}
        {if $specific.open_day}
            <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
                <td itemprop="dayOfWeek" content="{$day}">{#$dayOfWeek#}</td>
                {if $specific.noon_time}
                <td>
                    <span itemprop="opens" content="{$specific.open_time}">{$specific.open_time}</span> -
                    <span itemprop="closes" content="{$specific.noon_start}">{$specific.noon_start}</span>
                </td>
                <td>
                    <span itemprop="opens" content="{$specific.noon_end}">{$specific.noon_end}</span> -
                    <span itemprop="closes" content="{$specific.close_time}">{$specific.close_time}</span>
                </td>
                {else}
                <td>
                    <span itemprop="opens" content="{$specific.open_time}">{$specific.open_time}</span> -
                    <span itemprop="closes" content="{$specific.close_time}">{$specific.close_time}</span>
                </td>
                <td>
                    -
                </td>
                {/if}
            </tr>
        {else}
            <tr>
                <td>{#$dayOfWeek#}</td>
                <td colspan="2"><strong>Fermé</strong></td>
            </tr>
        {/if}
    {/foreach}
    </tbody>
</table>