<?php
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
class ViewPopup extends SugarView{
	var $type ='list';
	function ViewPopup(){
		parent::SugarView();
	}
	
	function display(){		
		global $popupMeta, $mod_strings;
        
        if(($this->bean instanceOf SugarBean) && !$this->bean->ACLAccess('list')){
            ACLController::displayNoAccess();
            sugar_cleanup(true);
        }
        
		if(isset($_REQUEST['metadata']) && strpos($_REQUEST['metadata'], "..") !== false)
			die("Directory navigation attack denied.");
		if(!empty($_REQUEST['metadata']) && $_REQUEST['metadata'] != 'undefined' && file_exists('modules/' . $this->module . '/metadata/' . $_REQUEST['metadata'] . '.php')) // if custom metadata is requested
			require_once('modules/' . $this->module . '/metadata/' . $_REQUEST['metadata'] . '.php');
		elseif(file_exists('custom/modules/' . $this->module . '/metadata/popupdefs.php'))
	    	require_once('custom/modules/' . $this->module . '/metadata/popupdefs.php');
	    elseif(file_exists('modules/' . $this->module . '/metadata/popupdefs.php'))
	    	require_once('modules/' . $this->module . '/metadata/popupdefs.php');	
	    
	    if(!empty($popupMeta) && !empty($popupMeta['listviewdefs'])){
	    	if(is_array($popupMeta['listviewdefs'])){
	    		//if we have an array, then we are not going to include a file, but rather the 
	    		//listviewdefs will be defined directly in the popupdefs file
	    		$listViewDefs[$this->module] = $popupMeta['listviewdefs'];
	    	}else{
	    		//otherwise include the file
	    		require_once($popupMeta['listviewdefs']);
	    	}
	    }elseif(file_exists('custom/modules/' . $this->module . '/metadata/listviewdefs.php')){
			require_once('custom/modules/' . $this->module . '/metadata/listviewdefs.php');
		}elseif(file_exists('modules/' . $this->module . '/metadata/listviewdefs.php')){
			require_once('modules/' . $this->module . '/metadata/listviewdefs.php');
		}
		
		//check for searchdefs as well
		if(empty($searchdefs) && file_exists('custom/modules/'.$this->module.'/metadata/searchdefs.php')){
			require_once('custom/modules/'.$this->module.'/metadata/searchdefs.php');
		}elseif(!empty($popupMeta) && !empty($popupMeta['searchdefs'])){
	    	if(is_array($popupMeta['searchdefs'])){
	    		//if we have an array, then we are not going to include a file, but rather the 
	    		//searchdefs will be defined directly in the popupdefs file
	    		$searchdefs[$this->module]['layout']['advanced_search'] = $popupMeta['searchdefs'];
	    	}else{
	    		//otherwise include the file
	    		require_once($popupMeta['searchdefs']);
	    	}
	    }else if(empty($searchdefs) && file_exists('modules/'.$this->module.'/metadata/searchdefs.php')){
	    	require_once('modules/'.$this->module.'/metadata/searchdefs.php');
		}
		
        if(!empty($this->bean) && isset($_REQUEST[$this->module.'2_'.strtoupper($this->bean->object_name).'_offset'])) {//if you click the pagination button, it will poplate the search criteria here
            if(!empty($_REQUEST['current_query_by_page'])) {
                $blockVariables = array('mass', 'uid', 'massupdate', 'delete', 'merge', 'selectCount', 'lvso', 'sortOrder', 'orderBy', 'request_data', 'current_query_by_page');
                $current_query_by_page = unserialize(base64_decode($_REQUEST['current_query_by_page']));
                foreach($current_query_by_page as $search_key=>$search_value) {
                    if($search_key != $this->module.'2_'.strtoupper($this->bean->object_name).'_offset' && !in_array($search_key, $blockVariables)) {
						if (!is_array($search_value)) {
                        	$_REQUEST[$search_key] = $GLOBALS['db']->quoteForEmail($search_value);
						}
                        else {
                    		foreach ($search_value as $key=>&$val) {
                    			$val = $GLOBALS['db']->quoteForEmail($val);
                    		}
                    		$_REQUEST[$search_key] = $search_value;
                        }                        
                    }
                }
            }
        }
        
		if(!empty($listViewDefs) && !empty($searchdefs)){
			require_once('include/Popups/PopupSmarty.php');
			$displayColumns = array();
			$filter_fields = array();
			$popup = new PopupSmarty($this->bean, $this->module);
			foreach($listViewDefs[$this->module] as $col => $params) {
	        	$filter_fields[strtolower($col)] = true;
				 if(!empty($params['related_fields'])) {
                    foreach($params['related_fields'] as $field) {
                        //id column is added by query construction function. This addition creates duplicates
                        //and causes issues in oracle. #10165
                        if ($field != 'id') {
                            $filter_fields[$field] = true;
                        }
                    }
                }
	        	if(!empty($params['default']) && $params['default'] && $col != 'TEAM_NAME')
	           		$displayColumns[$col] = $params;
	    	}
	    	$popup->displayColumns = $displayColumns;
	    	$popup->filter_fields = $filter_fields;
	    	$popup->mergeDisplayColumns = true;
	    	//check to see if popupdes contains searchdefs
	    	$popup->_popupMeta = $popupMeta;
            $popup->listviewdefs = $listViewDefs;
	    	$popup->searchdefs = $searchdefs;
	    	
	    	if(isset($_REQUEST['query'])){
				$popup->searchForm->populateFromRequest(); 	
	    	}
	    	
			$massUpdateData = '';
			if(isset($_REQUEST['mass'])) {
				foreach(array_unique($_REQUEST['mass']) as $record) {
					$massUpdateData .= "<input style='display: none' checked type='checkbox' name='mass[]' value='$record'>\n";
				}		
			}
			$popup->massUpdateData = $massUpdateData;
			
			$popup->setup('include/Popups/tpls/PopupGeneric.tpl');
			
            insert_popup_header();		
			echo $popup->display();

		}else{
			if(file_exists('modules/' . $this->module . '/Popup_picker.php')){
				require_once('modules/' . $this->module . '/Popup_picker.php');
			}else{
				require_once('include/Popups/Popup_picker.php');
			}
		
			$popup = new Popup_Picker();
			$popup->_hide_clear_button = true;
			echo $popup->process_page();
		}
	}
}
?>
