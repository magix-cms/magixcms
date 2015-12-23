{$days = ['Mo','Tu','We','Th','Fr','Sa','Su']}
{foreach $days as $day}
    {$day_name = 'opening_'|cat:$day}
    {$day_opt = $companyData.specifications[$day]}
    <tr id="opening_{$day}">
        <td>
            {#$day_name#}
        </td>
        <td>
            <div class="checkbox">
                <label>
                    <input {if $day_opt.open_day}checked {/if}class="open_day" name="openinghours[{$day}][open_day]" data-day="{$day}" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="success" data-offstyle="danger" >
                </label>
            </div>
        </td>
        <td>
            <div class="input-group open_hours">
                <label for="{$day}-op-h" class="sr-only">{#op_hrs#|ucfirst}</label>
                <input id="{$day}-op-h" placeholder="hh" name="openinghours[{$day}][open][hh]" type="text" value="{if $day_opt.open_time && !empty($day_opt.open_time[0])}{$day_opt.open_time[0]}{else}00{/if}" size="2" class="form-control input-hours" {if !$day_opt.open_day}disabled{/if}>
                <span class="input-group-addon">:</span>
                <label for="{$day}-op-m" class="sr-only">{#op_mns#|ucfirst}</label>
                <input id="{$day}-op-m" placeholder="mm" name="openinghours[{$day}][open][mm]" type="text" value="{if $day_opt.open_time && !empty($day_opt.open_time[1])}{$day_opt.open_time[1]}{else}00{/if}" size="2" class="form-control input-minutes" {if !$day_opt.open_day}disabled{/if}>
            </div>
        </td>
        <td>
            <div class="input-group open_hours">
                <label for="{$day}-cl-h" class="sr-only">{#op_hrs#|ucfirst}</label>
                <input id="{$day}-cl-h" placeholder="hh" name="openinghours[{$day}][close][hh]" type="text" value="{if $day_opt.close_time && !empty($day_opt.close_time[0])}{$day_opt.close_time[0]}{else}00{/if}" size="2" class="form-control input-hours" {if !$day_opt.open_day}disabled{/if}>
                <span class="input-group-addon">:</span>
                <label for="{$day}-cl-m" class="sr-only">{#op_mns#|ucfirst}</label>
                <input id="{$day}-cl-m" placeholder="mm" name="openinghours[{$day}][close][mm]" type="text" value="{if $day_opt.close_time && !empty($day_opt.close_time[1])}{$day_opt.close_time[1]}{else}00{/if}" size="2" class="form-control input-minutes" {if !$day_opt.open_day}disabled{/if}>
            </div>
        </td>
        <td>
            <div class="checkbox">
                <label>
                    <input {if $day_opt.noon_time}checked {/if}class="noon_time" name="openinghours[{$day}][noon_time]" data-day="{$day}" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="success" data-offstyle="danger" {if !$day_opt.open_day}disabled{/if}>
                </label>
            </div>
        </td>
        <td>
            <div class="input-group noon_hours">
                <label for="{$day}-ns-h" class="sr-only">{#op_hrs#|ucfirst}</label>
                <input id="{$day}-ns-h" placeholder="hh" name="openinghours[{$day}][noon_start][hh]" type="text" value="{if $day_opt.noon_start && !empty($day_opt.noon_start[0])}{$day_opt.noon_start[0]}{else}00{/if}" size="2" class="form-control input-hours" {if !$day_opt.open_day || !$day_opt.noon_time}disabled{/if}>
                <span class="input-group-addon">:</span>
                <label for="{$day}-ns-m" class="sr-only">{#op_mns#|ucfirst}</label>
                <input id="{$day}-ns-m" placeholder="mm" name="openinghours[{$day}][noon_start][mm]" type="text" value="{if $day_opt.noon_start && !empty($day_opt.noon_start[1])}{$day_opt.noon_start[1]}{else}00{/if}" size="2" class="form-control input-minutes" {if !$day_opt.open_day || !$day_opt.noon_time}disabled{/if}>
            </div>
        </td>
        <td>
            <div class="input-group noon_hours">
                <label for="{$day}-ne-h" class="sr-only">{#op_hrs#|ucfirst}</label>
                <input id="{$day}-ne-h" placeholder="hh" name="openinghours[{$day}][noon_end][hh]" type="text" value="{if $day_opt.noon_end && !empty($day_opt.noon_end[0])}{$day_opt.noon_end[0]}{else}00{/if}" size="2" class="form-control input-hours" {if !$day_opt.open_day || !$day_opt.noon_time}disabled{/if}>
                <span class="input-group-addon">:</span>
                <label for="{$day}-ne-m" class="sr-only">{#op_mns#|ucfirst}</label>
                <input id="{$day}-ne-m" placeholder="mm" name="openinghours[{$day}][noon_end][mm]" type="text" value="{if $day_opt.noon_end && !empty($day_opt.noon_end[1])}{$day_opt.noon_end[1]}{else}00{/if}" size="2" class="form-control input-minutes" {if !$day_opt.open_day || !$day_opt.noon_time}disabled{/if}>
            </div>
        </td>
    </tr>
{/foreach}