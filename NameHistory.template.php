<?php
/**********************************************************************************
* NameHistory.template.php                                                        *
***********************************************************************************
* NameHistory on Profile                                                          *
* =============================================================================== *
* Version:                    1.0                                                 *
* Author:                     SychO (M.S)                                         *
* Copyright 2018:             SychO (M.S)                                         *
* Contact me @:               http://sycho.22web.org                              *
***********************************************************************************
* Licensed under the Apache License, Version 2.0 (the "License");                 *
* You may not use this file except in compliance with the License.                *
* You may obtain a copy of the License (See LICENSE.txt)                          *
* OR at http://www.apache.org/licenses/LICENSE-2.0                                *
*                                                                                 *
* Unless required by applicable law or agreed to in writing, software             *
* distributed under the License is distributed on an "AS IS" BASIS,               *
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.        *
* See the License for the specific language governing permissions and             *
* limitations under the License.                                                  *
**********************************************************************************/

function template_namehistory($namehistory)
{
	global $context, $scripturl, $txt, $modSettings;

	if (!empty($namehistory))
	{
		
		echo'<hr>
			<div class="cat_bar"><h3 class="catbg">', $txt['namehistory_title'], ' ', allowedTo('admin_forum') ? '<a class="floatright" href="'.$scripturl.'?action=admin;area=modsettings;sa=namehistory">'.$txt['settings'].'</a>' : '', '</h3></div>
			<table width="100%" style="background: transparent" class="nh-table">
				<tbody>';
		$i = 0;
		foreach ($namehistory as $nams)
		{
				if($i==count($namehistory)-1 && $modSettings['namehistory_limit']<count($namehistory))
					continue;
				
				echo '<tr>
						<td style="max-width: 290px;overflow-x: hidden;text-overflow: ellipsis;white-space: nowrap;" >
							<span style="overflow-x: hidden;text-overflow: ellipsis;white-space: nowrap;display: block;">', $nams['before'], '</span>
						</td>
						<td style="text-align:right;">
							<span>', $i==count($namehistory)-1 ? '' : $namehistory[$i+1]['time'], '</span>
						</td>
					</tr>';
			$i++;
		}
		
		echo'	</tbody>
			</table>';
	}
}

function template_namehistory_dropmenu($namehistory)
{
	global $context, $scripturl, $txt, $settings, $modSettings;

	if (!empty($namehistory))
	{
		echo'<div class="dropmenu nh-dropmenu" style="padding:0;margin: -16px 0 0 0;display:inline;position:absolute;width:30px;height: 30px;line-height:0;">
			<ul style="padding:0;margin:0;display:inline;line-height:0;font-size:11px;">
				<li>
					<img style="cursor:pointer;" src="', $settings['theme_url'], '/images/sort_down.gif" />
					<ul>';
				
				$i=0;
				foreach ($namehistory as $nams)
				{	
					if($i==count($namehistory)-1 && $modSettings['namehistory_limit']<count($namehistory))
					continue;
				
					echo '<li><span style="padding: 0px 4px;line-height: 22px;height: auto;">', $nams['before'], '</span></li>';
					$i++;
				}
		
				echo'</ul>
				</li>
			</ul>
		</div>';
	}
}

?>