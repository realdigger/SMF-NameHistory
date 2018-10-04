<?php
/**********************************************************************************
* hooks.php                                                                       *
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
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
  require_once(dirname(__FILE__) . '/SSI.php');
// Hmm... no SSI.php and no SMF?
elseif (!defined('SMF'))
  die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');
  
// Install Settings.
updateSettings(array('namehistory_show' => 1));
updateSettings(array('namehistory_dropmenu' => 0));
updateSettings(array('namehistory_limit' => 10));
	
	
// Define the hooks
$hook_functions = array(
	'integrate_pre_include' => '$sourcedir/Subs-NameHistory.php',
	'integrate_admin_areas' => 'namehistory_admin_hook',
	'integrate_modify_modifications' => 'namehistory_modsettings_hook',
);

// Adding or removing them?
if (!empty($context['uninstalling']))
	$call = 'remove_integration_function';
else
	$call = 'add_integration_function';

foreach ($hook_functions as $hook => $function)
	$call($hook, $function);

	
?>