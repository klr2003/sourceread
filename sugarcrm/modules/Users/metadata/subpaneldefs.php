<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Layout definition for Users
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
 


$layout_defs['Users'] = array(
	// default subpanel provided by this SugarBean
	'subpanel_setup' => array(
		'holidays' => array(
			'order' => 30,
			'sort_by' => 'holiday_date',
			'sort_order' => 'asc',
			'module' => 'Holidays',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'holidays',
			'refresh_page'=>1,
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopButtonQuickCreate', 'view' => 'UsersQuickCreate',),
			),
			'title_key' => 'LBL_USER_HOLIDAY_SUBPANEL_TITLE',
		),
	),
	'default_subpanel_define' => array(
		'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
		'sort_by' => 'name',
		'sort_order' => 'asc',
		'top_buttons' => array(
			array('widget_class' => 'SubPanelTopCreateButton'),
			array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Users', 'mode' => 'MultiSelect'),
		),
		'list_fields' => array(
			'Users' => array(
				'columns' => array(
					array(
						'name' => 'first_name',
			 		 	'usage' => 'query_only',
					),
					array(
						'name' => 'last_name',
			 		 	'usage' => 'query_only',
					),
					array(
						'name' => 'name',
						'vname' => 'LBL_LIST_NAME',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'module' => 'Users',
		 		 		'width' => '25%',
					),
					array(
						'name' => 'user_name',
						'vname' => 'LBL_LIST_USER_NAME',
						'width' => '25%',
					),
					array(
						'name'=>'email1',
						'vname' => 'LBL_LIST_EMAIL',
						'width' => '25%',
					),
					array (
						'name' => 'phone_work',
						'vname' => 'LBL_LIST_PHONE',
						'width' => '21%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelRemoveButton',
			 		 	'module' => 'Users',
						'width' => '4%',
						'linked_field' => 'users',
					),
				),
			),
		),
	),
);
$layout_defs['UserRoles'] = array(
	// sets up which panels to show, in which order, and with what linked_fields
	'subpanel_setup' => array(
        'aclroles' => array(
			'top_buttons' => array(array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'ACLRoles', 'mode' => 'MultiSelect'),),
			'order' => 20,
			'sort_by' => 'name',
			'sort_order' => 'asc',
			'module' => 'ACLRoles',
			'refresh_page'=>1,
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'aclroles',
			'add_subpanel_data' => 'role_id',
			'title_key' => 'LBL_ROLES_SUBPANEL_TITLE',
		),
	),
	);
global $current_user;
if(is_admin($current_user)|| is_admin_for_module($current_user, 'Users')){
	$layout_defs['UserRoles']['subpanel_setup']['aclroles']['subpanel_name'] = 'admin';
}else{
	$layout_defs['UserRoles']['subpanel_setup']['aclroles']['top_buttons'] = array();
}

//remove the administrator create button holiday for the user admin only
$result = $GLOBALS['db']->query("SELECT is_admin FROM users WHERE id='$_REQUEST[record]'");
$row = $GLOBALS['db']->fetchByAssoc($result);
if(!is_admin($current_user)&& is_admin_for_module($current_user,'Users')&& $row['is_admin']==1){
	$layout_defs['Users']['subpanel_setup']['holidays']['top_buttons']= array();
}
?>
