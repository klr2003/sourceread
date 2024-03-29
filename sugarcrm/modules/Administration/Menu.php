<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
/*********************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings;
global $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $current_user;

$module_menu = Array();
if(is_admin($current_user) || is_admin_for_module($GLOBALS['current_user'],'Users')){
	$module_menu[] = Array("index.php?module=Users&action=EditView&return_module=Users&return_action=DetailView", $mod_strings['LNK_NEW_USER'],"CreateUsers");
	$module_menu[] = Array("index.php?module=Users&action=index", $mod_strings['LBL_USERS_TITLE'],"Users");




}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "SupportPortal") {



	$module_menu[] = Array("index.php?module=Administration&action=SupportPortal&view=documentation&help_module=Administration&edition={$sugar_flavor}&key={$server_unique_key}&language={$current_language}", $mod_strings['LBL_DOCUMENTATION_TITLE'],"OnlineDocumentation");
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "UpgradeFields") {
	$module_menu[] = array('index.php?module=EditCustomFields&action=index',$mod_strings['LNK_SELECT_CUSTOM_FIELD'], 'Administration');
	$module_menu[] = array('index.php?module=Administration&action=UpgradeFields',$mod_strings['LNK_REPAIR_CUSTOM_FIELD'], 'Administration');
}

?>
