<?php 
/**********************************************************************************
* Subs-NameHistory.php                                                            *
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

if (!defined('SMF'))
	die('Hacking attempt...');


function nameHistory($memID)
{
	global $smcFunc, $txt, $scripturl, $context, $modSettings;
	
	if(empty($modSettings['namehistory_limit']) || $modSettings['namehistory_limit'] < 0)
		$modSettings['namehistory_limit'] = 10;
	else
		$modSettings['namehistory_limit'] = (int)$modSettings['namehistory_limit'];
	
	// Get a list of the name changes log
	$request = $smcFunc['db_query']('', '
		SELECT
			id_action, id_member, log_time, action, extra
		FROM {db_prefix}log_actions
		WHERE id_log = {int:log_type}
			AND id_member = {int:owner}
			AND action = "real_name"
		ORDER BY log_time DESC
		LIMIT {int:lim}',
		array(
			'log_type' => 2,
			'owner' => $memID,
			'lim' => $modSettings['namehistory_limit']+1,
		)
	);
	$edits = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		$extra = unserialize($row['extra']);
		
		$edits[] = array(
			'id' => $row['id_action'],
			'id_member' => $row['id_member'],
			'before' => !empty($extra['previous']) ? $extra['previous'] : '',
			'after' => !empty($extra['new']) ? $extra['new'] : '',
			'time' => timeformat($row['log_time']),
		);
	}
	$smcFunc['db_free_result']($request);
	
	return $edits;
}
// Admin Area Hook
// integrate_admin_areas
function namehistory_admin_hook(&$admin_areas) {
   
	global $txt, $modSettings, $scripturl, $sc;
	
    $admin_areas['config']['areas']['modsettings']['subsections'] += array(
		'namehistory' => array($txt['namehistory_modsettings']),
	);
}

// Modification Settings Hook
// integrate_modify_modifications
function namehistory_modsettings_hook(&$subActions) {
   
	global $txt, $modSettings, $scripturl, $sc;
	
    $subActions += array(
		'namehistory' => 'ModifyNameHistory',
	);
}

// Modification Settings Function
// ManageSettings
function ModifyNameHistory($return_config = false)
{
	global $txt, $scripturl, $context, $settings, $sc, $modSettings;

	$config_vars = array(
		array('check', 'namehistory_show'),
		array('check', 'namehistory_dropmenu'),
		array('text', 'namehistory_limit'),
	);

	if ($return_config)
		return $config_vars;

	$context['post_url'] = $scripturl . '?action=admin;area=modsettings;save;sa=namehistory';
	$context['settings_title'] = $txt['namehistory_modsettings'];

	// Save Settings
	if (isset($_GET['save']))
	{
		checkSession();
		
		$save_vars = $config_vars;
		saveDBSettings($save_vars);
		redirectexit('action=admin;area=modsettings;sa=namehistory');
	}
	
	prepareDBSettingContext($config_vars);
}
?>