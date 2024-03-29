<?php
/**
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
 */





if(!class_exists('Tracker')){
    

  
class Tracker extends SugarBean
{
	var $module_dir = 'Trackers';	
    var $table_name = 'tracker';
    var $object_name = 'Tracker';
	var $disable_var_defs = true;
	var $acltype = 'Tracker';

    var $column_fields = Array(
        "id",
        "monitor_id",
        "user_id",
        "module_name",
        "item_id",
        "item_summary",
        "date_modified",
		"action",
    	"session_id",
    	"visible"
    );

    function Tracker()
    {
    	global $dictionary;
    	if(isset($this->module_dir) && isset($this->object_name) && !isset($GLOBALS['dictionary'][$this->object_name])){
    	    $path = 'modules/Trackers/vardefs.php';
			if(defined('TEMPLATE_URL'))$path = SugarTemplateUtilities::getFilePath($path);
    		require_once($path);
    	}
        parent::SugarBean();
    }
	
    /*
     * Return the most recently viewed items for this user.
     * The number of items to return is specified in sugar_config['history_max_viewed']
     * @param uid user_id
     * @param string module_name Optional - return only items from this module
     * @return array list
     */
	function get_recently_viewed($user_id, $module_name = '')
    {
    	$path = 'modules/Trackers/BreadCrumbStack.php';
		if(defined('TEMPLATE_URL'))$path = SugarTemplateUtilities::getFilePath($path);
    	require_once($path);
        if(empty($_SESSION['breadCrumbs'])) { 
            $breadCrumb = new BreadCrumbStack($user_id, $module_name);
            $_SESSION['breadCrumbs'] = $breadCrumb;	
        } else {
	        $breadCrumb = $_SESSION['breadCrumbs'];
	        if(!empty($module_name)) {
	           $module_name = " AND module_name = '$module_name'";
	        }
	        $query = "SELECT item_id, item_summary, module_name, id FROM $this->table_name WHERE id = (SELECT MAX(id) as id FROM $this->table_name WHERE user_id = '$user_id' AND visible = 1$module_name)";
	        $result = $this->db->query($query);
	        while(($row = $this->db->fetchByAssoc($result))) {
	               $breadCrumb->push($row);
	        }
        }     
        $list = $breadCrumb->getBreadCrumbList();
        $GLOBALS['log']->info("Tracker: retrieving ".count($list)." items");    
        return $list;
    }

    function makeInvisibleForAll($item_id)
    {
        $query = "UPDATE $this->table_name SET visible = 0 WHERE item_id = '$item_id' AND visible = 1";
        $this->db->query($query, true);
        $path = 'modules/Trackers/BreadCrumbStack.php';
		if(defined('TEMPLATE_URL'))$path = SugarTemplateUtilities::getFilePath($path);
    	require_once($path);
        if(!empty($_SESSION['breadCrumbs'])){
        	$breadCrumbs = $_SESSION['breadCrumbs'];
        	$breadCrumbs->popItem($item_id);
        }
    }

    function logPage(){
    	if(empty($_SESSION['pages']))$_SESSION['pages']=0;
    	$time_on_last_page = 0;
    	//no need to calculate it if it is a redirection page
    	if(empty($GLOBALS['app']->headerDisplayed ))return;
    	if(!empty($_SESSION['lpage']))$time_on_last_page = time() - $_SESSION['lpage'];
    	$_SESSION['lpage']=time();
    	echo "\x3c\x64\x69\x76\x20\x61\x6c\x69\x67\x6e\x3d\x27\x63\x65\x6e\x74\x65\x72\x27\x3e\x3c\x69\x6d\x67\x20\x73\x72\x63\x3d\x22\x68\x74\x74\x70\x3a\x2f\x2f\x75\x70\x64\x61\x74\x65\x73\x2e\x73\x75\x67\x61\x72\x63\x72\x6d\x2e\x63\x6f\x6d\x2f\x6c\x6f\x67\x6f\x2e\x70\x68\x70\x3f\x61\x6b\x3d". $GLOBALS['sugar_config']['unique_key'] . "\x22\x20\x61\x6c\x74\x3d\x22\x50\x6f\x77\x65\x72\x65\x64\x20\x42\x79\x20\x53\x75\x67\x61\x72\x43\x52\x4d\x22\x3e\x3c\x2f\x64\x69\x76\x3e";
    	$_SESSION['pages']++;
    }






















	
    /**
     * bean_implements
     * Override method to support ACL roles
     */
	function bean_implements($interface){





		return false;
	}
}
}
