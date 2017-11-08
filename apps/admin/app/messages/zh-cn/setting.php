<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */
return [
    'menuList' => '<tr class="gradeX">
                    <td class="text-center">%id</td>
                    <td>%rank%title</td>
                    <td>%url</td>
                    <td><i class="menu-icon glyphicon %icon"></i></td>
                    <td>%status</td>
                    <td><span class="badge">%orderby</span></td>
                    <td class="center">
                        %edit
                        %delete
                    </td>
                    </tr>',
    'menuOption' => '<option value="%id" %selected>%rank%title</option>',
    'actionList' => '<tr class="gradeX list_%pid %top">
                        <td width="3%">
                            <label><input type="checkbox" class="check_menu checkAll" value="%url" name="power[%id][url][]" data-pid="%data-pid" %checked></label>
                        </td>
                        <td width="17%">%rank%title</td>
                        <td width="80%" class="padding-label">%label</td>
                    </tr>',
    'actionLabel' => '<label>
                        <input type="hidden" name="power[%menu][name][]" value="%title" %checked>
                        <input type="checkbox" class="check_action checkSign" name="power[%menu][url][]" value="%value" %checked> %title
                     </label>',
];
