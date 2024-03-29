<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * MassUpdate for ListViews
 *
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



/**
 * MassUpdate class for updating multiple records at once
 */
 require_once('include/EditView/EditView2.php');
class MassUpdate
{
	/*
	 * internal sugarbean reference
	 */
	var $sugarbean = null;

	/**
	  * set the sugar bean to its internal member
	  * @param sugar bean reference
	  */
	function setSugarBean($sugar)
	{
		$this->sugarbean = $sugar;
	}

	/**
	 * get the massupdate form
	 * @param bool boolean need to execute the massupdate form or not
	 * @param multi_select_popup booleanif it is a multi-select value
	 */
	function getDisplayMassUpdateForm($bool, $multi_select_popup = false)
	{

		require_once('include/formbase.php');

		if(!$multi_select_popup)
		$form = '<form action="index.php" method="post" name="displayMassUpdate" id="displayMassUpdate">' . "\n";
		else
		$form = '<form action="index.php" method="post" name="MassUpdate" id="MassUpdate">' . "\n";

		if($bool)
		{
			$form .= '<input type="hidden" name="mu" value="false" />' . "\n";
		}
		else
		{
			$form .= '<input type="hidden" name="mu" value="true" />' . "\n";
		}

		$form .= getAnyToForm('mu', true);
		if(!$multi_select_popup) $form .= "</form>\n";

		return $form;
	}
	/**
	 * returns the mass update's html form header
	 * @param multi_select_popup boolean if it is a mult-select or not
	 */
	function getMassUpdateFormHeader($multi_select_popup = false)
	{
		global $sugar_version;
		global $sugar_config;
		global $current_user;

        $query = base64_encode(serialize($_REQUEST));
		
        $bean = loadBean($_REQUEST['module']);
       $order_by_name = $bean->module_dir.'2_'.strtoupper($bean->object_name).'_ORDER_BY' ; 
       $lvso = isset($_REQUEST['lvso'])?$_REQUEST['lvso']:"";
       $request_order_by_name = isset($_REQUEST[$order_by_name])?$_REQUEST[$order_by_name]:"";
		if($multi_select_popup)
		$tempString = '';
		else
		$tempString = "<form action='index.php' method='post' name='MassUpdate'  id='MassUpdate' onsubmit=\"return check_form('MassUpdate');\">\n"
		. "<input type='hidden' name='return_action' value='{$_REQUEST['action']}' />\n"
        . "<input type='hidden' name='return_module' value='{$_REQUEST['module']}' />\n"
		. "<input type='hidden' name='massupdate' value='true' />\n"
		. "<input type='hidden' name='delete' value='false' />\n"
		. "<input type='hidden' name='merge' value='false' />\n"
        . "<input type='hidden' name='current_query_by_page' value='{$query}' />\n"
        . "<input type='hidden' name='module' value='{$_REQUEST['module']}' />\n"
        . "<input type='hidden' name='action' value='MassUpdate' />\n"
        . "<input type='hidden' name='lvso' value='{$lvso}' />\n"
        . "<input type='hidden' name='{$order_by_name}' value='{$request_order_by_name}' />\n";

		// cn: bug 9103 - MU navigation in emails is broken
		if($_REQUEST['module'] == 'Emails') {
			$type = "";
			// determine "type" - inbound, archive, etc.
			if (isset($_REQUEST['type'])) {
				$type = $_REQUEST['type'];
			}
			// determine owner
			$tempString .=<<<eoq
				<input type='hidden' name='type' value="{$type}" />
				<input type='hidden' name='ie_assigned_user_id' value="{$current_user->id}" />
eoq;
		}

		return $tempString;
	}

	/**
	  * Executes the massupdate form
	  * @param displayname Name to display in the popup window
      * @param varname name of the variable
	  */
	function handleMassUpdate(){

		require_once('include/formbase.php');
		global $current_user, $db;

		/*
		 C.L. - Commented this out... not sure why it's here
		if(!is_array($this->sugarbean) && $this->sugarbean->bean_implements('ACL') && !ACLController::checkAccess($this->sugarbean->module_dir, 'edit', true))
		{

		}
        */

		foreach($_POST as $post=>$value){
			if(is_array($value)){
				if(empty($value)){
					unset($_POST[$post]);
				}
			}elseif(strlen($value) == 0){
				unset($_POST[$post]);
			}
			if(is_string($value)
				 && isset($this->sugarbean->field_defs[$post]) &&
				 ($this->sugarbean->field_defs[$post]['type'] == 'bool'
				 	|| (!empty($this->sugarbean->field_defs[$post]['custom_type']) && $this->sugarbean->field_defs[$post]['custom_type'] == 'bool'
				 	))){


				 		if(strcmp($value, '2') == 0)$_POST[$post] = 0;
				 		if(!empty($this->sugarbean->field_defs[$post]['dbType']) && strcmp($this->sugarbean->field_defs[$post]['dbType'], 'varchar') == 0 ){
				 			if(strcmp($value, '1') == 0 )$_POST[$post] = 'on';
				 			if(strcmp($value, '2') == 0)$_POST[$post] = 'off';
				 		}
			}
		}

		if(!empty($_REQUEST['uid'])) $_POST['mass'] = explode(',', $_REQUEST['uid']); // coming from listview
		elseif(isset($_REQUEST['entire']) && empty($_POST['mass'])) {
			if(empty($order_by))$order_by = '';
			$ret_array = create_export_query_relate_link_patch($_REQUEST['module'], $this->searchFields, $this->where_clauses);
			$query = $this->sugarbean->create_export_query($order_by, $ret_array['where'], $ret_array['join']);
			$result = $db->query($query,true);
			$new_arr = array();
			while($val = $db->fetchByAssoc($result,-1,false))
			{
				array_push($new_arr, $val['id']);
			}
			$_POST['mass'] = $new_arr;
		}

		if(isset($_POST['mass']) && is_array($_POST['mass'])  && $_REQUEST['massupdate'] == 'true'){
			$count = 0;
			





			
			foreach($_POST['mass'] as $id){
                if(empty($id)) {
                    continue;
                }
				if(isset($_POST['Delete'])){
					$this->sugarbean->retrieve($id);
					if($this->sugarbean->ACLAccess('Delete')){
					//Martin Hu Bug #20872
						if($this->sugarbean->object_name == 'EmailMan'){
							$query = "DELETE FROM emailman WHERE id = '" . $this->sugarbean->id . "'";
							$db->query($query);
						} else {
							









							$this->sugarbean->mark_deleted($id);
						}
					}
				}
				else {
					if($this->sugarbean->object_name == 'Contact' && isset($_POST['Sync'])){ // special for contacts module
						if($_POST['Sync'] == 'true') {
							$this->sugarbean->retrieve($id);
							if($this->sugarbean->ACLAccess('Save')){
								if($this->sugarbean->object_name == 'Contact'){

									$this->sugarbean->contacts_users_id = $current_user->id;
									$this->sugarbean->save(false);
								}
							}
						}
						elseif($_POST['Sync'] == 'false') {
							$this->sugarbean->retrieve($id);
							if($this->sugarbean->ACLAccess('Save')){
								if($this->sugarbean->object_name == 'Contact'){
									if (!isset($this->sugarbean->users))
									{
										$this->sugarbean->load_relationship('user_sync');
									}
									$this->sugarbean->contacts_users_id = null;
									$this->sugarbean->user_sync->delete($this->sugarbean->id, $current_user->id);
								}
							}
						}
					} //end if for special Contact handling

					if($count++ != 0) {
					   //Create a new instance to clear values and handle additional updates to bean's 2,3,4...
                       $className = get_class($this->sugarbean);
                       $this->sugarbean = new $className();
					}

					$this->sugarbean->retrieve($id);

					foreach($_POST as $field=>$value){
                        if (isset($this->sugarbean->field_defs[$field])) {
                            if($this->sugarbean->field_defs[$field]['type'] == 'datetime') {
                                $_POST[$field] = $this->date_to_dateTime($field, $value);
                            }
                            if ($this->sugarbean->field_defs[$field]['type'] == 'bool') {
                                $this->checkClearField($field, $value);
                            }
                        }
                    }











					if($this->sugarbean->ACLAccess('Save')){
						$_POST['record'] = $id;
						$_GET['record'] = $id;
						$_REQUEST['record'] = $id;
						$newbean=$this->sugarbean;
						//Call include/formbase.php, but do not call retrieve again
						populateFromPost('', $newbean, true);
						$newbean->save_from_post = false;
						if (!isset($_POST['parent_id']))
							$newbean->parent_type = null;

						$check_notify = FALSE;

						if (isset( $this->sugarbean->assigned_user_id)) {
							$old_assigned_user_id = $this->sugarbean->assigned_user_id;
							if (!empty($_POST['assigned_user_id'])
							&& ($old_assigned_user_id != $_POST['assigned_user_id'])
							&& ($_POST['assigned_user_id'] != $current_user->id)) {
								$check_notify = TRUE;
							}
						}
	                    $email_address_id = '';
	                    if (!empty($_POST['optout_primary'])) {
	                    	$optout_flag_value = 0;
	                    	if ($_POST['optout_primary'] == 'true') {
	                    		$optout_flag_value = 1;
	                    	} // if
	                    	if (isset($this->sugarbean->emailAddress)) {
	                    		if (!empty($this->sugarbean->emailAddress->addresses)) {
	                    			foreach($this->sugarbean->emailAddress->addresses as $key =>$emailAddressRow) {
	                    				if ($emailAddressRow['primary_address'] == '1') {
	                    					$email_address_id = $emailAddressRow['email_address_id'];
	                    					break;
										} // if
									} // foreach
								} // if
	                    		
							} // if
	                    } // if
						$newbean->save($check_notify);
						if (!empty($email_address_id)) {
	    					$query = "UPDATE email_addresses SET opt_out = {$optout_flag_value} where id = '{$emailAddressRow['email_address_id']}'";
	    					$GLOBALS['db']->query($query);
							
						} // if
					}
				}
			}
			






		}
			
	}
	/**
  	  * Displays the massupdate form
  	  */
	function getMassUpdateForm(){
		global $app_strings;
		global $current_user;

		if($this->sugarbean->bean_implements('ACL') && !ACLController::checkAccess($this->sugarbean->module_dir, 'edit', true)){
			return '';
		}
		$lang_delete = translate('LBL_DELETE');
		$lang_update = translate('LBL_UPDATE');
		$lang_confirm= translate('NTC_DELETE_CONFIRMATION_MULTIPLE');
		$lang_sync = translate('LBL_SYNC_CONTACT');
		$lang_oc_status = translate('LBL_OC_STATUS');
		$lang_unsync = translate('LBL_UNSYNC');
		$lang_archive = translate('LBL_ARCHIVE');
		$lang_optout_primaryemail = $app_strings['LBL_OPT_OUT_FLAG_PRIMARY'];	
		


//		if(!isset($this->sugarbean->field_defs) || count($this->sugarbean->field_defs) == 0) {
//			$html = "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td>";
//
//			if($this->sugarbean->ACLAccess('Delete', true) ){
//				$html .= "<input type='submit' name='Delete' value='{$lang_delete}' onclick=\"return confirm('{$lang_confirm}')\" class='button'>";
//			}
//			$html .= "</td></tr></table>";
//			return $html;
//		}

		$should_use = false;

		$html = "<div id='massupdate_form'>" . get_form_header($app_strings['LBL_MASS_UPDATE'], '', false);
        $html .= "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='buttons'><input onclick='return sListView.send_mass_update(\"selected\", \"{$app_strings['LBL_LISTVIEW_NO_SELECTED']}\")' type='submit' id='update_button' name='Update' value='{$lang_update}' class='button'>";
		// TODO: allow ACL access for Delete to be set false always for users
//		if($this->sugarbean->ACLAccess('Delete', true) && $this->sugarbean->object_name != 'User') {
//			global $app_list_strings;
//			$html .=" <input id='delete_button' type='submit' name='Delete' value='{$lang_delete}' onclick='return confirm(\"{$lang_confirm}\") && sListView.send_mass_update(\"selected\", \"{$app_strings['LBL_LISTVIEW_NO_SELECTED']}\", 1)' class='button'>";
//		}

		// only for My Inbox views - to allow CSRs to have an "Archive" emails feature to get the email "out" of their inbox.
		if($this->sugarbean->object_name == 'Email'
		&& (isset($_REQUEST['assigned_user_id']) && !empty($_REQUEST['assigned_user_id']))
		&& (isset($_REQUEST['type']) && !empty($_REQUEST['type']) && $_REQUEST['type'] == 'inbound')) {
			$html .=<<<eoq
			<input type='button' name='archive' value="{$lang_archive}" class='button' onClick='setArchived();'>
			<input type='hidden' name='ie_assigned_user_id' value="{$current_user->id}">
			<input type='hidden' name='ie_type' value="inbound">
eoq;
		}

		$html .= "</td></tr></table><table cellpadding='0' cellspacing='0' border='0' width='100%' class='edit view' id='mass_update_table'><tr><td><table width='100%' border='0' cellspacing='0' cellpadding='0'>";

		$even = true;
		if($this->sugarbean->object_name == 'Contact'){
			$html .= "<tr><td width='15%' scope='row'>$lang_sync</td><td width='35%' class='dataField'><select name='Sync'><option value=''>{$GLOBALS['app_strings']['LBL_NONE']}</option><option value='false'>{$GLOBALS['app_list_strings']['checkbox_dom']['2']}</option><option value='true'>{$GLOBALS['app_list_strings']['checkbox_dom']['1']}</option></select></td>";
			$even = false;
		}

		if($this->sugarbean->object_name == 'Employee'){
			$this->sugarbean->field_defs['employee_status']['type'] = 'enum';
			$this->sugarbean->field_defs['employee_status']['massupdate'] = true;
			$this->sugarbean->field_defs['employee_status']['options'] = 'employee_status_dom';
		}
		if($this->sugarbean->object_name == 'InboundEmail'){
			$this->sugarbean->field_defs['status']['type'] = 'enum';
			$this->sugarbean->field_defs['status']['options'] = 'user_status_dom';
		}

		static $banned = array('date_modified'=>1, 'date_entered'=>1, 'created_by'=>1, 'modified_user_id'=>1, 'deleted'=>1,'modified_by_name'=>1,);
		foreach($this->sugarbean->field_defs as $field){
		



			 if(!isset($banned[$field['name']]) && (!isset($field['massupdate']) || !empty($field['massupdate']))){
				$newhtml = '';
				if($even){
					$newhtml .= "<tr>";
				}
				if(isset($field['vname'])){
					$displayname = translate($field['vname']);
				}else{
					$displayname = '';

				}
				if(isset($field['type']) && $field['type'] == 'relate' && isset($field['id_name']) && $field['id_name'] == 'assigned_user_id')
					$field['type'] = 'assigned_user_name';
				if(isset($field['custom_type']))$field['type'] = $field['custom_type'];
				if(isset($field['type']))
				{
					switch($field["type"]){
						case "relate":
							// bug 14691: avoid laying out an empty cell in the <table>
							$handleRelationship = $this->handleRelationship($displayname, $field);
							if ($handleRelationship != '') {
								$even = !$even;
								$newhtml .= $handleRelationship;
							}
							break;
						case "parent":$even = !$even; $newhtml .=$this->addParent($displayname, $field); break;
						case "int":
							if(!empty($field['massupdate']) && empty($field['auto_increment'])){
								$even = !$even; $newhtml .=$this->addInputType($displayname, $field);
							}
							 break;
						case "contact_id":$even = !$even; $newhtml .=$this->addContactID($displayname, $field["name"]); break;
						case "assigned_user_name":$even = !$even; $newhtml .= $this->addAssignedUserID($displayname,  $field["name"]); break;
						case "account_id":$even = !$even; $newhtml .= $this->addAccountID($displayname,  $field["name"]); break;
						case "account_name":$even = !$even; $newhtml .= $this->addAccountID($displayname,  $field["id_name"]); break;
						case "bool": $even = !$even; $newhtml .= $this->addBool($displayname,  $field["name"]); break;
						case "enum":
						case "multienum":
							if(!empty($field['isMultiSelect'])){
								$even = !$even; $newhtml .= $this->addStatusMulti($displayname,  $field["name"], translate($field["options"])); break;
							}else if(!empty($field['options'])) {
								$even = !$even; $newhtml .= $this->addStatus($displayname,  $field["name"], translate($field["options"])); break;
							}else if(!empty($field['function'])){
								$functionValue = $this->getFunctionValue($this->sugarbean, $field);
								$even = !$even; $newhtml .= $this->addStatus($displayname,  $field["name"], $functionValue); break;
							}
							break;
						case "datetime":
						case "date":$even = !$even; $newhtml .= $this->addDate($displayname,  $field["name"]); break;



					}
				}
				if($even){
					$newhtml .="</tr>";
				}else{
					$should_use = true;
				}
				if(!in_array($newhtml, array('<tr>', '</tr>', '<tr></tr>', '<tr><td></td></tr>'))){
					$html.=$newhtml;
				}
			}
		}
		













		if ($this->sugarbean->object_name == 'Contact' || 
			$this->sugarbean->object_name == 'Account' || 
			$this->sugarbean->object_name == 'Lead' ||
			$this->sugarbean->object_name == 'Prospect') {
				
			$html .= "<tr><td width='15%'  scope='row' class='dataLabel'>$lang_optout_primaryemail</td><td width='35%' class='dataField'><select name='optout_primary'><option value=''>{$GLOBALS['app_strings']['LBL_NONE']}</option><option value='false'>{$GLOBALS['app_list_strings']['checkbox_dom']['2']}</option><option value='true'>{$GLOBALS['app_list_strings']['checkbox_dom']['1']}</option></select></td></tr>";
				
			}
		$html .="</table></td></tr></table></div>";


		if($should_use){
			return $html;
		}else{
			if($this->sugarbean->ACLAccess('Delete', true)){
				return "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td><input type='submit' name='Delete' value='$lang_delete' onclick=\"return confirm('{$lang_confirm}')\" class='button'></td></tr></table>";
			}else{
				return '';
			}
		}
	}

	function getFunctionValue($focus, $vardef){
		$function = $vardef['function'];
	    if(is_array($function) && isset($function['name'])){
	    	$function = $vardef['function']['name'];
	    }else{
	       	$function = $vardef['function'];
	    }
		if(!empty($vardef['function']['returns']) && $vardef['function']['returns'] == 'html'){
			if(!empty($vardef['function']['include'])){
				require_once($vardef['function']['include']);
			}
			return $function($focus, $vardef['name'], '', 'MassUpdate');
		}else{
			return $function($focus, $vardef['name'], '', 'MassUpdate');
		}
	}

	/**
	  * Returns end of the massupdate form
	  */
	function endMassUpdateForm(){
		return '</form>';
	}

	/**
	  * Decides which popup HTML code is needed for mass updating
	  * @param displayname Name to display in the popup window
	  * @param field name of the field to update
	  */
	function handleRelationship($displayname, $field)
	{
		$ret_val = '';
		if(isset($field['module']))
		{
			switch($field['module'])
			{
				case 'Accounts':
					$ret_val = $this->addAccountID($displayname, $field['name'], $field['id_name']);
					break;
				case 'Contacts':
					$ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Contacts");
					break;
				case 'Users':
					$ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Users");
					break;
				case 'Employee':
					$ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Employee");
					break;
				case 'Releases':
					$ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Releases");
					break;
				default:
					if(!empty($field['massupdate'])){
						$ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], $field['module']); 
					}
					break;
			}
		}

		return $ret_val;
	}
	/**
	  * Add a parent selection popup window
	  * @param displayname Name to display in the popup window
	  * @param field_name name of the field
	  */
	function addParent($displayname, $field){
		global $app_strings, $app_list_strings;

		///////////////////////////////////////
		///
		/// SETUP POPUP

		$popup_request_data = array(
		'call_back_function' => 'set_return',
		'form_name' => 'MassUpdate',
		'field_to_name_array' => array(
			'id' => "parent_id",
			'name' => "parent_name",
			),
			);

			$json = getJSONobj();
			$encoded_popup_request_data = $json->encode($popup_request_data);
            
            $qsName = array(  
			            'form' => 'MassUpdate',
						'method' => 'query',
                        'modules' => array("Accounts"),
                        'group' => 'or',
						'field_list' => array('name', 'id'),
						'populate_list' => array("mass_parent_name", "mass_parent_id"),
						'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')),
						'limit' => '30','no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
                $qsName = $json->encode($qsName);

			//
			///////////////////////////////////////

			$change_parent_button = " <input title='".$app_strings['LBL_SELECT_BUTTON_TITLE']."' accessKey='".$app_strings['LBL_SELECT_BUTTON_KEY']."'  type='button' class='button' value='".$app_strings['LBL_SELECT_BUTTON_LABEL']
			."' name='button_parent_name' onclick='open_popup(document.MassUpdate.{$field['type_name']}.value, 600, 400, \"\", true, false, {$encoded_popup_request_data});'  />";
			$parent_type = $field['parent_type'];
            $parent_types = $app_list_strings[$parent_type];
            $disabled_parent_types = ACLController::disabledModuleList($parent_types,false, 'list');
            foreach($disabled_parent_types as $disabled_parent_type)
                if($disabled_parent_type != $focus->parent_type)
				    unset($parent_types[$disabled_parent_type]);
			$types = get_select_options_with_id($parent_types, '');
			//BS Fix Bug 17110
			$pattern = "/\n<OPTION.*".$app_strings['LBL_NONE']."<\/OPTION>/";
			$types = preg_replace($pattern, "", $types);
			// End Fix
            
            $json = getJSONobj();
            $disabled_parent_types = $json->encode($disabled_parent_types);
            
			return <<<EOHTML
<td width="15%" scope="row">{$displayname} </td>
<td>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td valign='top'>
            <select name='{$field['type_name']}' id='mass_{$field['type_name']}'>
                $types
            </select>
        </td>
        <td valign='top'>
			<input name='{$field['id_name']}' id='mass_{$field['id_name']}' type='hidden' value=''>
			<input name='parent_name' id='mass_parent_name' class='sqsEnabled' autocomplete='off' 
                type='text' value=''>
            $change_parent_button
        </td>
    </tr>
    </table>
</td>
<script type="text/javascript">
<!--
var disabledModules='{$disabled_parent_types}';
if(typeof sqs_objects == 'undefined'){
    var sqs_objects = new Array;
}
sqs_objects['MassUpdate_parent_name'] = $qsName; 
registerSingleSmartInputListener(document.getElementById('mass_parent_name'));
addToValidateBinaryDependency('MassUpdate', 'parent_name', 'alpha', false, '{$app_strings['ERR_SQS_NO_MATCH_FIELD']} {$app_strings['LBL_ASSIGNED_TO']}','parent_id');

document.getElementById('mass_{$field['type_name']}').onchange = function()
{
    document.MassUpdate.parent_name.value="";
    document.MassUpdate.parent_id.value="";
    
	new_module = document.forms["MassUpdate"].elements["parent_type"].value;

	if(typeof(disabledModules[new_module]) != 'undefined') {
		sqs_objects["MassUpdate_parent_name"]["disable"] = true;
		document.forms["MassUpdate"].elements["parent_name"].readOnly = true;
	} else {
		sqs_objects["MassUpdate_parent_name"]["disable"] = false;
		document.forms["MassUpdate"].elements["parent_name"].readOnly = false;
	}
	sqs_objects["MassUpdate_parent_name"]["modules"] = new Array(new_module);
    enableQS(false);
    
    checkParentType(document.MassUpdate.parent_type.value, document.MassUpdate.button_parent_name);
}
-->
</script>
EOHTML;
	}
	
	/**
	  * Add a generic input type='text' field
	  * @param displayname Name to display in the popup window
	  * @param field_name name of the field
	  */
	function addInputType($displayname, $varname){
		$html = <<<EOQ
	<td scope="row" width="20%">$displayname</td>
	<td class='dataField' width="30%"><input type="text" name='$varname' size="12" id='{$varname}' maxlength='10' value=""></td>
	<script> addToValidate('MassUpdate','$varname','int',false,'$displayname');</script>
EOQ;
		return $html;

	}
	/**
	  * Add a generic module popup selection popup window HTML code.
	  * Currently supports Contact and Releases
	  * @param displayname Name to display in the popup window
	  * @param varname name of the variable
	  * @param id_name name of the id in vardef
	  * @param mod_type name of the module, either "Contact" or "Releases" currently
	  */
	function addGenericModuleID($displayname, $varname, $id_name='', $mod_type){
		global $app_strings;

		if(empty($id_name))
		$id_name = strtolower($mod_type)."_id";

		///////////////////////////////////////
		///
		/// SETUP POPUP

		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'MassUpdate',
			'field_to_name_array' => array(
				'id' => "{$id_name}",
				'name' => "{$varname}",
				),
				);

				$json = getJSONobj();
				$encoded_popup_request_data = $json->encode($popup_request_data);

                $qsName = array(  
			            'form' => 'MassUpdate',
						'method' => 'query',
                        'modules' => array("{$mod_type}"),
                        'group' => 'or',
						'field_list' => array('name', 'id'),
						'populate_list' => array("mass_{$varname}", "mass_{$id_name}"),
						'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')),
						'limit' => '30','no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
                $qsName = $json->encode($qsName);
				//
				///////////////////////////////////////

            return <<<EOHTML
<td width='15%'  scope='row' class='dataLabel'>$displayname</td>
<td width='35%' class='dataField'>
    <input name='{$varname}' id='mass_{$varname}' class='sqsEnabled' autocomplete='off' type='text' value=''>
    <input name='{$id_name}' id='mass_{$id_name}' type='hidden' value=''>&nbsp;
    <input title='{$app_strings['LBL_SELECT_BUTTON_TITLE']}'
        accessKey='{$app_strings['LBL_SELECT_BUTTON_KEY']}'
        type='button' class='button' value='{$app_strings['LBL_SELECT_BUTTON_LABEL']}' name='button' 
        onclick='open_popup("$mod_type", 600, 400, "", true, false, {$encoded_popup_request_data});' 
        />
</td>
<script type="text/javascript">
<!--
if(typeof sqs_objects == 'undefined'){
    var sqs_objects = new Array;
}
sqs_objects['MassUpdate_{$varname}'] = $qsName; 
registerSingleSmartInputListener(document.getElementById('mass_{$varname}'));
addToValidateBinaryDependency('MassUpdate', '{$varname}', 'alpha', false, '{$app_strings['ERR_SQS_NO_MATCH_FIELD']} {$app_strings['LBL_ASSIGNED_TO']}','{$id_name}');
-->
</script>
EOHTML;
	}
	/**
	  * Add Account selection popup window HTML code
	  * @param displayname Name to display in the popup window
	  * @param varname name of the variable
	  * @param id_name name of the id in vardef
	  */
	function addAccountID($displayname, $varname, $id_name=''){
		global $app_strings;

		$json = getJSONobj();

		if(empty($id_name))
		$id_name = "account_id";

		///////////////////////////////////////
		///
		/// SETUP POPUP

		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'MassUpdate',
			'field_to_name_array' => array(
				'id' => "{$id_name}",
				'name' => "{$varname}",
				),
				);

				$encoded_popup_request_data = $json->encode($popup_request_data);

				//
				///////////////////////////////////////

				$qsParent = array(  
							'form' => 'MassUpdate',
							'method' => 'query',
							'modules' => array('Accounts'),
							'group' => 'or',
							'field_list' => array('name', 'id'),
							'populate_list' => array('parent_name', 'parent_id'),
							'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')),
							'order' => 'name',
							'limit' => '30',
							'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']
							);
							$qsParent['populate_list'] = array('mass_'. $varname, 'mass_' . $id_name);

							$html = '<td scope="row">' . $displayname . " </td>\n"
							. '<td><input class="sqsEnabled" type="text" autocomplete="off" id="mass_' . $varname .'" name="' . $varname . '" value="" /><input id="mass_' . $id_name . '" type="hidden" name="'
							. $id_name . '" value="" />&nbsp;<input type="button" name="btn1" class="button" title="'
							. $app_strings['LBL_SELECT_BUTTON_LABEL'] . '" accesskey="'
							. $app_strings['LBL_SELECT_BUTTON_KEY'] . '" value="' . $app_strings['LBL_SELECT_BUTTON_LABEL'] . '" onclick='
							. "'open_popup(\"Accounts\",600,400,\"\",true,false,{$encoded_popup_request_data});' /></td>\n";
							$html .= '<script type="text/javascript" language="javascript">if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}sqs_objects[\'MassUpdate_' . $varname . '\'] = ' .
							$json->encode($qsParent) . '; registerSingleSmartInputListener(document.getElementById(\'mass_' . $varname . '\'));
					addToValidateBinaryDependency(\'MassUpdate\', \''.$varname.'\', \'alpha\', false, \'' . $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $app_strings['LBL_ACCOUNT'] . '\',\''.$id_name.'\');
					</script>';

							return $html;
	}

















	/**
	  * Add AssignedUser popup window HTML code
	  * @param displayname Name to display in the popup window
	  * @param varname name of the variable
	  */
	function addAssignedUserID($displayname, $varname){
		global $app_strings;

		$json = getJSONobj();

		$popup_request_data = array(
		'call_back_function' => 'set_return',
		'form_name' => 'MassUpdate',
		'field_to_name_array' => array(
			'id' => 'assigned_user_id',
			'user_name' => 'assigned_user_name',
			),
			);
			$encoded_popup_request_data = $json->encode($popup_request_data);
			$qsUser = array(  
			            'form' => 'MassUpdate',
						'method' => 'get_user_array', // special method
						'field_list' => array('user_name', 'id'),
						'populate_list' => array('assigned_user_name', 'assigned_user_id'),
						'conditions' => array(array('name'=>'user_name','op'=>'like_custom','end'=>'%','value'=>'')),
						'limit' => '30','no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);

						$qsUser['populate_list'] = array('mass_assigned_user_name', 'mass_assigned_user_id');
						$html = <<<EOQ
		<td width="15%" scope="row">$displayname</td>
		<td ><input class="sqsEnabled" autocomplete="off" id="mass_assigned_user_name" name='assigned_user_name' type="text" value=""><input id='mass_assigned_user_id' name='assigned_user_id' type="hidden" value="" />
		<input title="{$app_strings['LBL_SELECT_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_SELECT_BUTTON_KEY']}" type="button" class="button" value='{$app_strings['LBL_SELECT_BUTTON_LABEL']}' name=btn1
				onclick='open_popup("Users", 600, 400, "", true, false, $encoded_popup_request_data);' />
		</td>
EOQ;
						$html .= '<script type="text/javascript" language="javascript">if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}sqs_objects[\'MassUpdate_assigned_user_name\'] = ' .
						$json->encode($qsUser) . '; registerSingleSmartInputListener(document.getElementById(\'mass_assigned_user_name\'));
				addToValidateBinaryDependency(\'MassUpdate\', \'assigned_user_name\', \'alpha\', false, \'' . $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $app_strings['LBL_ASSIGNED_TO'] . '\',\'assigned_user_id\');
				</script>';

						return $html;
	}
	/**
	  * Add Status selection popup window HTML code
	  * @param displayname Name to display in the popup window
	  * @param varname name of the variable
	  * @param options array of options for status
	  */
	function addStatus($displayname, $varname, $options){
		global $app_strings, $app_list_strings;

		// cn: added "mass_" to the id tag to diffentieate from the status id in StoreQuery
		$html = '<td scope="row" width="15%">'.$displayname.'</td><td>';
		if(is_array($options)){
			if(!isset($options['']) && !isset($options['0'])){
			   $new_options = array();
			   $new_options[''] = '';
			   foreach($options as $key=>$value) {
			   	   $new_options[$key] = $value;
			   }
			   $options = $new_options;
			}
			$options = get_select_options_with_id($options, '');
			$html .= '<select id="mass_'.$varname.'" name="'.$varname.'">'.$options.'</select>';
		}else{
			$html .= $options;
		}
		$html .= '</td>';
		return $html;
	}

/**
	  * Add Status selection popup window HTML code
	  * @param displayname Name to display in the popup window
	  * @param varname name of the variable
	  * @param options array of options for status
	  */
	function addBool($displayname, $varname){
		global $app_strings, $app_list_strings;
		return $this->addStatus($displayname, $varname, $app_list_strings['checkbox_dom']);
	}
	function addStatusMulti($displayname, $varname, $options){
		global $app_strings, $app_list_strings;

		if(!isset($options['']) && !isset($options['0'])){
		   $new_options = array();
		   $new_options[''] = '';
		   foreach($options as $key=>$value) {
		   	   $new_options[$key] = $value;
		   }
		   $options = $new_options;
		}
		$options = get_select_options_with_id($options, '');

		// cn: added "mass_" to the id tag to diffentieate from the status id in StoreQuery
		$html = '<td scope="row" width="15%">'.$displayname.'</td>
			 <td><select id="mass_'.$varname.'" name="'.$varname.'[]" size="5" MULTIPLE>'.$options.'</select></td>';
		return $html;
	}
	/**
	  * Add Date selection popup window HTML code
	  * @param displayname Name to display in the popup window
	  * @param varname name of the variable
	  */
	function addDate($displayname, $varname){
		global $timedate;
		$userformat = '('. $timedate->get_user_date_format().')';
		$cal_dateformat = $timedate->get_cal_date_format();
		global $app_strings, $app_list_strings, $theme;

		$javascriptend = <<<EOQ
		 <script type="text/javascript">
		Calendar.setup ({
			inputField : "${varname}jscal_field", daFormat : "$cal_dateformat", ifFormat : "$cal_dateformat", showsTime : false, button : "${varname}jscal_trigger", singleClick : true, step : 1, weekNumbers:false
		});
		</script>
EOQ;
        $jscalendarImage = SugarThemeRegistry::current()->getImageURL('jscalendar.gif');
		$html = <<<EOQ
	<td scope="row" width="20%">$displayname</td>
	<td class='dataField' width="30%"><input onblur="parseDate(this, '$cal_dateformat')" type="text" name='$varname' size="12" id='{$varname}jscal_field' maxlength='10' value="">
    <img src="$jscalendarImage" id="{$varname}jscal_trigger" align="absmiddle" title="{$app_strings['LBL_MASSUPDATE_DATE']}" alt='{$app_strings['LBL_MASSUPDATE_DATE']}'>&nbsp;<span class="dateFormat">$userformat</span>
	$javascriptend</td>
	<script> addToValidate('MassUpdate','$varname','date',false,'$displayname');</script>
EOQ;
		return $html;

	}

	function date_to_dateTime($field, $value) {
		global $timedate;
	    //Check if none was set
        if (isset($this->sugarbean->field_defs[$field]['group'])) {
            $group =  $this->sugarbean->field_defs[$field]['group'];
            if (isset($this->sugarbean->field_defs[$group."_flag"]) && isset($_POST[$group."_flag"])
                && $_POST[$group."_flag"] == 1) {
                return "";
            }
        }

        $oldDateTime = $this->sugarbean->$field;
        $oldTime = split(" ", $oldDateTime);
        if (isset($oldTime[1])) {
        	$oldTime = $oldTime[1];
        } else {
        	$oldTime = $timedate->to_display_time($timedate->get_gmt_db_datetime());
        }
        $value = split(" ", $value);
        $value = $value[0];
	    return $value." ".$oldTime;
	}

	function checkClearField($field, $value) {
	    if ($value == 1 && strpos($field, '_flag')) {
	        $fName = substr($field, -5);
            if (isset($this->sugarbean->field_defs[$field]['group'])) {
                $group =  $this->sugarbean->field_defs[$field]['group'];
                if (isset($this->sugarbean->field_defs[$group])) {
                    $_POST[$group] = "";
                }
            }
	    }
	}

    function generateSearchWhere($module, $query) {//this function is similar with function prepareSearchForm() in view.list.php
        $seed = loadBean($module);
        $this->use_old_search = true;
        if(file_exists('modules/'.$module.'/SearchForm.html')){
            if(file_exists('modules/' . $module . '/metadata/SearchFields.php')) {
                require_once('include/SearchForm/SearchForm.php');
                $searchForm = new SearchForm($module, $seed);
            }
            elseif(!empty($_SESSION['export_where'])) { //bug 26026, sometimes some module doesn't have a metadata/SearchFields.php, the searchfrom is generated in the ListView.php. 
            //So currently massupdate will not gernerate the where sql. It will use the sql stored in the SESSION. But this will cause bug 24722, and it cannot be avoided now.
                $where = $_SESSION['export_where'];
                $whereArr = explode (" ", trim($where));
                if ($whereArr[0] == trim('where')) {
                    $whereClean = array_shift($whereArr);
                }
                $this->where_clauses = implode(" ", $whereArr);
                return;
            }
            else {
                $this->where_clauses = '';
                return;
            }
        }
        else{
            $this->use_old_search = false;
            require_once('include/SearchForm/SearchForm2.php');
            if (file_exists('custom/modules/'.$module.'/metadata/searchdefs.php'))
            {
                require_once('custom/modules/'.$module.'/metadata/searchdefs.php');
            }
            elseif (!empty($metafiles[$module]['searchdefs']))
            {
                require_once($metafiles[$module]['searchdefs']);
            }
            elseif (file_exists('modules/'.$module.'/metadata/searchdefs.php'))
            {
                require_once('modules/'.$module.'/metadata/searchdefs.php');
            }
                
                
            if(!empty($metafiles[$module]['searchfields']))
                require_once($metafiles[$module]['searchfields']);
            elseif(file_exists('modules/'.$module.'/metadata/SearchFields.php'))
                require_once('modules/'.$module.'/metadata/SearchFields.php');
            if(empty($searchdefs) || empty($searchFields)) {
               $this->where_clauses = ''; //for some modules, such as iframe, it has massupdate, but it doesn't have search function, the where sql should be empty.
               return;
            }
            $searchForm = new SearchForm($seed, $module);
            $searchForm->setup($searchdefs, $searchFields, 'include/SearchForm/tpls/SearchFormGeneric.tpl');
        }
        $searchForm->populateFromArray(unserialize(base64_decode($query)));
        $this->searchFields = $searchForm->searchFields;
        $where_clauses = $searchForm->generateSearchWhere(true, $module);
        if (count($where_clauses) > 0 ) {
            $this->where_clauses = '('. implode(' ) AND ( ', $where_clauses) . ')';
            $GLOBALS['log']->info("MassUpdate Where Clause: {$this->where_clauses}");
        }
    }
}

?>
