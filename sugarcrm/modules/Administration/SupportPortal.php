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






global $mod_strings;
global $app_list_strings;
global $app_strings;
global $theme;
global $current_user;
global $currentModule;

switch ($_REQUEST['view']) {
	case "support_portal":
		if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");
		$GLOBALS['log']->info("Administration SupportPortal");

		$iframe_url = add_http("www.sugarcrm.com/network/redirect.php?tmpl=network");
        $mod_title = $mod_strings['LBL_SUPPORT_TITLE'];

        echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_title, true);
        
        $sugar_smarty = new Sugar_Smarty();
        $sugar_smarty->assign('iframeURL', $iframe_url);
        echo $sugar_smarty->fetch('modules/Administration/SupportPortal.tpl');

		break;
	default:

		$send_version = isset($_REQUEST['version']) ? $_REQUEST['version'] : "";
		$send_edition = isset($_REQUEST['edition']) ? $_REQUEST['edition'] : "";
		$send_lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : "";
		$send_module = isset($_REQUEST['help_module']) ? $_REQUEST['help_module'] : "";
		$send_action = isset($_REQUEST['help_action']) ? $_REQUEST['help_action'] : "";
		$send_key = isset($_REQUEST['key']) ? $_REQUEST['key'] : "";
		$send_anchor = '';
		// awu: Fixes the ProjectTasks pluralization issue -- must fix in later versions.
		if ($send_module == 'ProjectTasks')
			$send_module = 'ProjectTask';
        if ($send_module == 'ProductCatalog')
                $send_module = 'ProductTemplates';
        if ($send_module == 'TargetLists')
                $send_module = 'ProspectLists';
        if ($send_module == 'Targets')
                $send_module = 'Prospects';                            

		$helpPath = 'modules/'.$send_module.'/language/'.$send_lang.'.help.'.$send_action.'.html';

		$sugar_smarty = new Sugar_Smarty();

		//if the language is english then be sure to skip this check, otherwise go to the support
		//portal if the file is not found.
		if ($send_lang != 'en_us' && file_exists($helpPath))
		{
			$sugar_smarty->assign('helpFileExists', TRUE);
			$sugar_smarty->assign('helpPath', $helpPath);
			$sugar_smarty->assign('helpBar', getHelpBar($send_module));
			$sugar_smarty->assign('bookmarkScript', bookmarkJS());
			$sugar_smarty->assign('title', $mod_strings['LBL_SUGARCRM_HELP'] . " - " . $send_module);
			$sugar_smarty->assign('styleSheet', SugarThemeRegistry::current()->getCSS());
			$sugar_smarty->assign('table', getTable());
			$sugar_smarty->assign('endtable', endTable());
			$sugar_smarty->assign('charset', $app_strings['LBL_CHARSET']);
			echo $sugar_smarty->fetch('modules/Administration/SupportPortal.tpl');			
			
		} else {
			if(empty($send_module)){
				$send_module = 'toc';
			}
			
			$dev_status = 'GA';
			//If there is an alphabetic portion between the decimal prefix and integer suffix, then use the
			//value there as the dev_status value
			$dev_status = getVersionStatus($GLOBALS['sugar_version']);
			$send_version = getMajorMinorVersion($GLOBALS['sugar_version']);
			$editionMap = array('ENT' => 'Enterprise', 'PRO' => 'Professional', 'CE' => 'Community_Edition');
			if(!empty($editionMap[$send_edition])){
				$send_edition = $editionMap[$send_edition];
			}
			
			//map certain modules
			$sendModuleMap = array(
								'administration' => array(
													array('name' => 'Administration', 'action' => 'supportportal', 'anchor' => '1111871'),
													array('name' => 'Administration', 'action' => 'updater', 'anchor' => '1111871'),
													array('name' => 'Administration', 'action' => 'licensesettings', 'anchor' => '1111871'),
													array('name' => 'Administration', 'action' => 'diagnostic', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'listviewofflineclient', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'enablewirelessmodules', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'backups', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'upgrade', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'locale', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'themesettings', 'anchor' => '1111949'),
													array('name' => 'Administration', 'action' => 'passwordmanager', 'anchor' => '1446494'),
													array('name' => 'Administration', 'action' => 'upgradewizard', 'anchor' => '1168410'),
													array('name' => 'Administration', 'action' => 'configuretabs', 'anchor' => '1168410'),
													array('name' => 'Administration', 'action' => 'configuresubpanels', 'anchor' => '1168410'),
												),
								'calls' => array(array('name' => 'Activities')), 
								'tasks' => array(array('name' => 'Activities')), 
								'meetings' => array(array('name' => 'Activities')), 
								'notes' => array(array('name' => 'Activities')),
								'configurator' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'upgradewizard' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'schedulers' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'sugarfeed' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'connectors' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'trackers' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'currencies' => array(array('name' => 'Administration', 'anchor' => '1111949')),
								'aclroles' => array(array('name' => 'Administration', 'anchor' => '1446494')),
								'roles' => array(array('name' => 'Administration', 'anchor' => '1446494')),
								'teams' => array(array('name' => 'Administration', 'anchor' => '1446494')),
								'users' => array(array('name' => 'Administration', 'anchor' => '1446494'), array('name' => 'Getting_Started', 'action' => 'detailview')),
								'modulebuilder' => array(array('name' => 'Administration', 'anchor' => '1168410')),
								'studio' => array(array('name' => 'Administration', 'anchor' => '1168410')),
								'workflow' => array(array('name' => 'Administration', 'anchor' => '1168410')),
								'producttemplates' => array(array('name' => 'Administration', 'anchor' => '1839811')),
								'productcategories' => array(array('name' => 'Administration', 'anchor' => '1839811')),
								'producttypes' => array(array('name' => 'Administration', 'anchor' => '1839811')),
								'manufacturers' => array(array('name' => 'Administration', 'anchor' => '1839811')),
								'shippers' => array(array('name' => 'Administration', 'anchor' => '1839811')),
								'taxrates' => array(array('name' => 'Administration', 'anchor' => '1839811')),
								'releases' => array(array('name' => 'Administration', 'anchor' => '1113968')),
								'timeperiods' => array(array('name' => 'Administration', 'anchor' => '1840043')),
								'contracttypes' => array(array('name' => 'Administration', 'anchor' => '1840081')),
								'contracttype' => array(array('name' => 'Administration', 'anchor' => '1840081')),
								'emailman' => array(array('name' => 'Administration', 'anchor' => '1445484')),
								'inboundemail' => array(array('name' => 'Administration', 'anchor' => '1445484')),
								'emailtemplates' => array(array('name' => 'Emails')),
								'prospects' => array(array('name' => 'Campaigns')),
								'prospectlists' => array(array('name' => 'Campaigns')),
								'reportmaker' => array(array('name' => 'Reports')),
								'customqueries' => array(array('name' => 'Reports')),
								'quotas' => array(array('name' => 'Forecasts')),
								'projecttask' => array(array('name' => 'Projects')),
								'project' => array(array('name' => 'Projects'), array('name' => 'Dashboard', 'action' => 'dashboard'), ),
								'projecttemplate' => array(array('name' => 'Projects')),
								'datasets' => array(array('name' => 'Reports')),
								'dataformat' => array(array('name' => 'Reports')),
								'kbdocuments' => array(array('name' => 'Administration', 'action' => 'kbadminview')),
							 );
							 
			if(!empty($sendModuleMap[strtolower($send_module)])){
				$mappings = $sendModuleMap[strtolower($send_module)];
				
				foreach($mappings as $map){
					if(!empty($map['action'])){
						if($map['action'] == strtolower($send_action)){
							$send_module = $map['name'];
							if(!empty($map['anchor'])){
								$send_anchor = $map['anchor'];
							}
						}
					}else{
						$send_module = $map['name'];
						if(!empty($map['anchor'])){
								$send_anchor = $map['anchor'];
						}
					}
				}
				//$send_module = $sendModuleMap[strtolower($send_module)];
			}
			$sendUrl = "http://www.sugarcrm.com/crm/product_doc.php?edition={$send_edition}&version={$send_version}&lang={$send_lang}&module={$send_module}&help_action={$send_action}&status={$dev_status}&key={$send_key}&anchor={$send_anchor}";
			if(!empty($send_anchor)){
				$sendUrl .= "&anchor=".$send_anchor;
			}
			$iframe_url = $sendUrl;
			
			header("Location: {$iframe_url}");
			
			//$sugar_smarty->assign('helpFileExists', FALSE);
			//$sugar_smarty->assign('iframeURL', $iframe_url);
		}
		break;
}


function getHelpBar($moduleName)
{
	global $mod_strings;

	$helpBar = "<table width='100%'><tr><td align='right'>" .
			"<a href='javascript:window.print()'>" . $mod_strings['LBL_HELP_PRINT'] . "</a> - " .
			"<a href='mailto:?subject=" . $mod_strings['LBL_SUGARCRM_HELP'] . "&body=" . rawurlencode(getCurrentURL()) . "'>" . $mod_strings['LBL_HELP_EMAIL'] . "</a> - " .
			"<a href='#' onmousedown=\"createBookmarkLink('" . $mod_strings['LBL_SUGARCRM_HELP'] . " - " . $moduleName . "', '" . getCurrentURL() . "'" .")\">" . $mod_strings['LBL_HELP_BOOKMARK'] . "</a>" .
			"</td></tr></table>";

	return $helpBar;
}

function getTable()
{
	$table = "<table class='tabForm'><tr><td>";

	return $table;
}

function endTable()
{
	$endtable = "</td></tr></table>";

	return $endtable;
}

function bookmarkJS() {

$script =
<<<EOQ
<script type="text/javascript" language="JavaScript">
<!-- Begin
function createBookmarkLink(title, url){
	if (document.all)
		window.external.AddFavorite(url, title);
	else if (window.sidebar)
		window.sidebar.addPanel(title, url, "")
}
//  End -->
</script>
EOQ;

return $script;
}

?>
