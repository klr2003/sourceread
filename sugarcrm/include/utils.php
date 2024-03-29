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
/*********************************************************************************

 * Description:  Includes generic helper functions used throughout the application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/SugarObjects/SugarConfig.php');
require_once('include/utils/external_cache.php');
require_once('include/utils/security_utils.php');



function make_sugar_config(&$sugar_config)
{
	/* used to convert non-array config.php file to array format */
	global $admin_export_only;
	global $cache_dir;
	global $calculate_response_time;
	global $create_default_user;
	global $dateFormats;
	global $dbconfig;
	global $dbconfigoption;
	global $default_action;
	global $default_charset;
	global $default_currency_name;
	global $default_currency_symbol;
	global $default_currency_iso4217;
	global $defaultDateFormat;
	global $default_language;
	global $default_module;
	global $default_password;
	global $default_permission_mode;
	global $default_theme;
	global $defaultTimeFormat;
	global $default_user_is_admin;
	global $default_user_name;
	global $disable_export;
	global $disable_persistent_connections;
	global $display_email_template_variable_chooser;
	global $display_inbound_email_buttons;
	global $history_max_viewed;
	global $host_name;
	global $import_dir;
	global $languages;
	global $list_max_entries_per_page;
	global $lock_default_user_name;
	global $log_memory_usage;
	global $requireAccounts;
	global $RSS_CACHE_TIME;
	global $session_dir;
	global $site_URL;
	global $site_url;
	global $sugar_version;
	global $timeFormats;
	global $tmp_dir;
	global $translation_string_prefix;
	global $unique_key;
	global $upload_badext;
	global $upload_dir;
	global $upload_maxsize;
	global $import_max_execution_time;
	global $list_max_entries_per_subpanel;
	global $passwordsetting;

	// assumes the following variables must be set:
	// $dbconfig, $dbconfigoption, $cache_dir, $import_dir, $session_dir, $site_URL, $tmp_dir, $upload_dir

	$sugar_config = array (
	'admin_export_only' => empty($admin_export_only) ? false : $admin_export_only,
	'export_delimiter' => empty($export_delimiter) ? ',' : $export_delimiter,
	'cache_dir' => empty($cache_dir) ? $_GLOBALS['sugar_config']['cache_dir'] : $cache_dir,
	'calculate_response_time' => empty($calculate_response_time) ? true : $calculate_response_time,
	'create_default_user' => empty($create_default_user) ? false : $create_default_user,
	'date_formats' => empty($dateFormats) ? array(
	'Y-m-d'=>'2010-12-23',
	'd-m-Y' => '23-12-2010',
	'm-d-Y'=>'12-23-2010',
	'Y/m/d'=>'2010/12/23',
	'd/m/Y' => '23/12/2010',
	'm/d/Y'=>'12/23/2010',
	'Y.m.d' => '2010.12.23',
	'd.m.Y' => '23.12.2010',
	'm.d.Y' => '12.23.2010'
		) : $dateFormats,
	'dbconfig' => $dbconfig,  // this must be set!!
	'dbconfigoption' => $dbconfigoption,  // this must be set!!
	'default_action' => empty($default_action) ? 'index' : $default_action,
	'default_charset' => empty($default_charset) ? 'UTF-8' : $default_charset,
	'default_currency_name' => empty($default_currency_name) ? 'US Dollar' : $default_currency_name,
	'default_currency_symbol' => empty($default_currency_symbol) ? '$' : $default_currency_symbol,
	'default_currency_iso4217' => empty($default_currency_iso4217) ? '$' : $default_currency_iso4217,
	'default_date_format' => empty($defaultDateFormat) ? 'm/d/Y' : $defaultDateFormat,
	'default_language' => empty($default_language) ? 'en_us' : $default_language,
	'default_module' => empty($default_module) ? 'Home' : $default_module,
	'default_password' => empty($default_password) ? '' : $default_password,
	'default_permissions' => array (
		'dir_mode' => 02770,
		'file_mode' => 0660,
		'chown' => '',
		'chgrp' => '',
	),
    'default_theme' => empty($default_theme) ? 'Sugar' : $default_theme,
	'default_time_format' => empty($defaultTimeFormat) ? 'h:ia' : $defaultTimeFormat,
	'default_user_is_admin' => empty($default_user_is_admin) ? false : $default_user_is_admin,
	'default_user_name' => empty($default_user_name) ? '' : $default_user_name,
	'disable_export' => empty($disable_export) ? false : $disable_export,
    'disable_persistent_connections' => empty($disable_persistent_connections) ? false : $disable_persistent_connections,
	'display_email_template_variable_chooser' => empty($display_email_template_variable_chooser) ? false : $display_email_template_variable_chooser,
	'display_inbound_email_buttons' => empty($display_inbound_email_buttons) ? false : $display_inbound_email_buttons,
	'history_max_viewed' => empty($history_max_viewed) ? 10 : $history_max_viewed,
	'host_name' => empty($host_name) ? 'localhost' : $host_name,
	'import_dir' => $import_dir,  // this must be set!!
	'import_max_records_per_file' => 100,
	'languages' => empty($languages) ? array('en_us' => 'English (US)') : $languages,
	'list_max_entries_per_page' => empty($list_max_entries_per_page) ? 20 : $list_max_entries_per_page,
	'list_max_entries_per_subpanel' => empty($list_max_entries_per_subpanel) ? 10 : $list_max_entries_per_subpanel,
	'lock_default_user_name' => empty($lock_default_user_name) ? false : $lock_default_user_name,
	'log_memory_usage' => empty($log_memory_usage) ? false : $log_memory_usage,
    'portal_view' => 'single_user',
	'resource_management' => array (
	    'special_query_limit' => 50000,
	    'special_query_modules' => array('Reports', 'Export', 'Import', 'Administration', 'Sync'),
	    'default_limit' => 1000,
    ),
	'require_accounts' => empty($requireAccounts) ? true : $requireAccounts,
	'rss_cache_time' => empty($RSS_CACHE_TIME) ? '10800' : $RSS_CACHE_TIME,
	'session_dir' => $session_dir,  // this must be set!!
	'site_url' => empty($site_URL) ? $site_url : $site_URL,  // this must be set!!
	'showDetailData' => true, // if true, read-only ACL fields will still appear on EditViews as non-editable
	'showThemePicker' => true,
	'sugar_version' => empty($sugar_version) ? 'unknown' : $sugar_version,
	'time_formats' => empty($timeFormats) ? array (
	'H:i'=>'23:00', 'h:ia'=>'11:00 pm', 'h:iA'=>'11:00PM',
	'H.i'=>'23.00', 'h.ia'=>'11.00 pm', 'h.iA'=>'11.00PM' ) : $timeFormats,
	'tmp_dir' => $tmp_dir,  // this must be set!!
	'translation_string_prefix' => empty($translation_string_prefix) ? false : $translation_string_prefix,
	'unique_key' => empty($unique_key) ? md5(create_guid()) : $unique_key,
	'upload_badext' => empty($upload_badext) ? array (
	'php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py',
	'asp', 'cfm', 'js', 'vbs', 'html', 'htm' ) : $upload_badext,
	'upload_dir' => $upload_dir,  // this must be set!!
	'upload_maxsize' => empty($upload_maxsize) ? 3000000 : $upload_maxsize,
	'import_max_execution_time' => empty($import_max_execution_time) ? 3600 : $import_max_execution_time,
	'lock_homepage' => false,
	'lock_subpanels' => false,
	'max_dashlets_homepage' => 15,
	'dashlet_display_row_options' => array('1','3','5','10'),
	'default_max_tabs' => empty($max_tabs) ? '12' : $max_tabs,
	'default_max_subtabs' => empty($max_subtabs) ? '12' : $max_subtabs,
	'default_subpanel_tabs' =>  empty($subpanel_tabs) ? true : $subpanel_tabs,
	'default_subpanel_links' => empty($subpanel_links) ? false : $subpanel_links,
	'default_swap_last_viewed' => empty($swap_last_viewed) ? false : $swap_last_viewed,
	'default_swap_shortcuts' => empty($swap_shortcuts) ? false : $swap_shortcuts,
	'default_navigation_paradigm' => empty($navigation_paradigm) ? 'gm' : $navigation_paradigm,
	'js_lang_version' => 1,

	'passwordsetting' => empty($passwordsetting) ? array (
	    'SystemGeneratedPasswordON' => '',
	    'generatepasswordtmpl' => '',
	    'lostpasswordtmpl' => '',
	    'forgotpasswordON' => false,
    	'linkexpiration' => '1',
    	'linkexpirationtime' => '30',
    	'linkexpirationtype' => '1',
	    'systexpiration' => '0',
	    'systexpirationtime' => '',
	    'systexpirationtype' => '0',
	    'systexpirationlogin' => '',
		) : $passwordsetting,

































	);
}

function get_sugar_config_defaults() {
	global $locale;
	/**
	 * used for getting base values for array style config.php.  used by the
	 * installer and to fill in new entries on upgrades.  see also:
	 * sugar_config_union
	 */

	$sugar_config_defaults = array (
	'admin_export_only' => false,
	'export_delimiter' => ',',
	'calculate_response_time' => true,
	'create_default_user' => false,
	'date_formats' => array (
	'Y-m-d' => '2010-12-23', 'm-d-Y' => '12-23-2010', 'd-m-Y' => '23-12-2010',
	'Y/m/d' => '2010/12/23', 'm/d/Y' => '12/23/2010', 'd/m/Y' => '23/12/2010',
	'Y.m.d' => '2010.12.23', 'd.m.Y' => '23.12.2010', 'm.d.Y' => '12.23.2010',),
	'dbconfigoption' => array (
	'persistent' => true,
	'autofree' => false,
	'debug' => 0,
	'seqname_format' => '%s_seq',
	'portability' => 0,
	'ssl' => false ),
	'default_action' => 'index',
	'default_charset' => return_session_value_or_default('default_charset',
	'UTF-8'),
	'default_currency_name' => return_session_value_or_default('default_currency_name', 'US Dollar'),
	'default_currency_symbol' => return_session_value_or_default('default_currency_symbol', '$'),
	'default_currency_iso4217' => return_session_value_or_default('default_currency_iso4217', 'USD'),
	'default_date_format' => 'm/d/Y',
	'default_language' => return_session_value_or_default('default_language',
	'en_us'),
	'default_module' => 'Home',
	'default_password' => '',
	'default_permissions' => array (
		'dir_mode' => 02770,
		'file_mode' => 0660,
		'user' => '',
		'group' => '',
	),
	'default_theme' => return_session_value_or_default('site_default_theme', 'Sugar'),
	'default_time_format' => 'h:ia',
	'default_user_is_admin' => false,
	'default_user_name' => '',
	'disable_export' => false,
	'disable_persistent_connections' =>
	return_session_value_or_default('disable_persistent_connections',
	'false'),
	'display_email_template_variable_chooser' => false,
	'display_inbound_email_buttons' => false,
	'dump_slow_queries' => false,
	'email_default_editor' => 'html',
	'email_default_client' => 'sugar',
	'email_default_delete_attachments' => true,
	'email_num_autoreplies_24_hours' => 10,
	'history_max_viewed' => 10,
	'installer_locked' => true,
	'import_max_records_per_file' => 100,
	'languages' => array('en_us' => 'English (US)'),
	'large_scale_test' => false,
	'list_max_entries_per_page' => 20,
	'list_max_entries_per_subpanel' => 10,




	'lock_default_user_name' => false,
	'log_memory_usage' => false,
	'login_nav' => false,
	'portal_view' => 'single_user',
    'resource_management' => array (
	    'special_query_limit' => 50000,
	    'special_query_modules' => array('Reports', 'Export', 'Import', 'Administration', 'Sync'),
	    'default_limit' => 1000,
    ),
	'require_accounts' => true,
	'rss_cache_time' => return_session_value_or_default('rss_cache_time',
	'10800'),
	'save_query' => 'all',
	'showDetailData' => true, // if true, read-only ACL fields will still appear on EditViews as non-editable
	'showThemePicker' => true,
	'slow_query_time_msec' => '100',
	'sugarbeet' => true,
	'time_formats' => array (
	'H:i'=>'23:00', 'h:ia'=>'11:00pm', 'h:iA'=>'11:00PM',
	'H.i'=>'23.00', 'h.ia'=>'11.00pm', 'h.iA'=>'11.00PM' ),
	'translation_string_prefix' =>
	return_session_value_or_default('translation_string_prefix', false),
	'upload_badext' => array (
	'php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py',
	'asp', 'cfm', 'js', 'vbs', 'html', 'htm' ),
	'upload_maxsize' => 3000000,
	'import_max_execution_time' => 3600,
	'use_php_code_json' => returnPhpJsonStatus(),
	'verify_client_ip' => true,
	'js_custom_version' => '',
	'js_lang_version' => 1,
	'default_number_grouping_seperator' => ',',
	'default_decimal_seperator' => '.',
	'lock_homepage' => false,
	'lock_subpanels' => false,
	'max_dashlets_homepage' => '15',
	'default_max_tabs' => '12',
	'default_max_subtabs' => '12',
	'dashlet_display_row_options' => array('1','3','5','10'),
	'default_subpanel_tabs' =>  true,
	'default_subpanel_links' => false,
	'default_swap_last_viewed' => false,
	'default_swap_shortcuts' => false,
	'default_navigation_paradigm' => 'gm',
	'admin_access_control' => false,
  	'use_common_ml_dir'	=> false,
  	'common_ml_dir' => '',
	'vcal_time' => '2',

	'passwordsetting' => empty($passwordsetting) ? array (
	    'SystemGeneratedPasswordON' => '',
	    'generatepasswordtmpl' => '',
	    'lostpasswordtmpl' => '',
	    'forgotpasswordON' => false,
    	'linkexpiration' => '1',
    	'linkexpirationtime' => '30',
    	'linkexpirationtype' => '1',
	    'systexpiration' => '0',
	    'systexpirationtime' => '',
	    'systexpirationtype' => '0',
	    'systexpirationlogin' => '',
		) : $passwordsetting,






































	);

	if(!is_object($locale)) {
		if(!class_exists('Localization')) {
			
		}
		$locale = new Localization();
	}

	$sugar_config_defaults['default_currencies'] = $locale->getDefaultCurrencies();

	$sugar_config_defaults = sugarArrayMerge($locale->getLocaleConfigDefaults(), $sugar_config_defaults);
	return( $sugar_config_defaults );
}


function load_menu($path){
	global $module_menu;

	if(file_exists($path . 'Menu.php'))
	{
		require_once($path . 'Menu.php');
	}
	if(file_exists('custom/' . $path . 'Ext/Menus/menu.ext.php'))
	{
		require_once('custom/' . $path . 'Ext/Menus/menu.ext.php');
	}
	if(file_exists('custom/application/Ext/Menus/menu.ext.php'))
	{
		require_once('custom/application/Ext/Menus/menu.ext.php');
	}
	return $module_menu;
}

function sugar_config_union( $default, $override ){
	// a little different then array_merge and array_merge_recursive.  we want
	// the second array to override the first array if the same value exists,
	// otherwise merge the unique keys.  it handles arrays of arrays recursively
	// might be suitable for a generic array_union
	if( !is_array( $override ) ){
		$override = array();
	}
	foreach( $default as $key => $value ){
		if( !array_key_exists($key, $override) ){
			$override[$key] = $value;
		}
		else if( is_array( $key ) ){
			$override[$key] = sugar_config_union( $value, $override[$key] );
		}
	}
	return( $override );
}

function make_not_writable( $file ){
	// Returns true if the given file/dir has been made not writable
	$ret_val = false;
	if( is_file($file) || is_dir($file) ){
		if( !is_writable($file) ){
			$ret_val = true;
		}
		else {
			$original_fileperms = fileperms($file);

			// take away writable permissions
			$new_fileperms = $original_fileperms & ~0x0092;
			@sugar_chmod($file, $new_fileperms);

			if( !is_writable($file) ){
				$ret_val = true;
			}
		}
	}
	return $ret_val;
}


/** This function returns the name of the person.
 * It currently returns "first last".  It should not put the space if either name is not available.
 * It should not return errors if either name is not available.
 * If no names are present, it will return ""
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function return_name($row, $first_column, $last_column)
{
	$first_name = "";
	$last_name = "";
	$full_name = "";

	if(isset($row[$first_column]))
	{
		$first_name = stripslashes($row[$first_column]);
	}

	if(isset($row[$last_column]))
	{
		$last_name = stripslashes($row[$last_column]);
	}

	$full_name = $first_name;

	// If we have a first name and we have a last name
	if($full_name != "" && $last_name != "")
	{
		// append a space, then the last name
		$full_name .= " ".$last_name;
	}
	// If we have no first name, but we have a last name
	else if($last_name != "")
	{
		// append the last name without the space.
		$full_name .= $last_name;
	}

	return $full_name;
}


function get_languages()
{
	global $sugar_config;
	return $sugar_config['languages'];
}

function get_language_display($key)
{
	global $sugar_config;
	return $sugar_config['languages'][$key];
}

function get_assigned_user_name($assigned_user_id, $is_group = '') {
	static $saved_user_list = null;

	if(empty($saved_user_list)) {
		$saved_user_list = get_user_array(false, '', '', false, null, $is_group);
	}

	if(isset($saved_user_list[$assigned_user_id])) {
		return $saved_user_list[$assigned_user_id];
	}

	return '';
}






















































































/**
 * retrieves the user_name column value (login)
 * @param string id GUID of user
 * @return string
 */
function get_user_name($id) {
	global $db;

	if(empty($db))
	$db = DBManagerFactory::getInstance();

	$q = "SELECT user_name FROM users WHERE id='{$id}'";
	$r = $db->query($q);
	$a = $db->fetchByAssoc($r);

	return (empty($a)) ? '' : $a['user_name'];
}


//TODO Update to use global cache
function get_user_array($add_blank=true, $status="Active", $assigned_user="", $use_real_name=false, $user_name_begins = null, $is_group=' AND portal_only=0 ', $from_cache = true) {
	global $locale;
	global $sugar_config;

	if(empty($locale)) {
		
		$locale = new Localization();
	}
	if($from_cache)
		$user_array = get_register_value('user_array', $add_blank. $status . $assigned_user);

	if(!isset($user_array)) {
		$db = DBManagerFactory::getInstance();
		$temp_result = Array();
		// Including deleted users for now.
		if (empty($status)) {
			$query = "SELECT id, first_name, last_name, user_name from users WHERE 1=1".$is_group;
		}
		else {
			$query = "SELECT id, first_name, last_name, user_name from users WHERE status='$status'".$is_group;
		}

		if (!empty($user_name_begins)) {
			$query .= " AND user_name LIKE '$user_name_begins%' ";
		}
		if (!empty($assigned_user)) {
			$query .= " OR id='$assigned_user'";
		}
		$query = $query.' ORDER BY user_name ASC';
		$GLOBALS['log']->debug("get_user_array query: $query");
		$result = $db->query($query, true, "Error filling in user array: ");

		if ($add_blank==true) {
			// Add in a blank row
			$temp_result[''] = '';
		}

		// Get the id and the name.
		while($row = $db->fetchByAssoc($result)) {
			if($use_real_name == true || showFullName()) {
				if(isset($row['last_name'])) { // cn: we will ALWAYS have both first_name and last_name (empty value if blank in db)
					$temp_result[$row['id']] = $locale->getLocaleFormattedName($row['first_name'],$row['last_name']);
				} else {
					$temp_result[$row['id']] = $row['user_name'];
				}
			} else {
				$temp_result[$row['id']] = $row['user_name'];
			}
		}

		$user_array = $temp_result;
		if($from_cache)
			set_register_value('user_array', $add_blank. $status . $assigned_user, $temp_result);
	}


	return $user_array;
}


/**
 * uses a different query to return a list of users than get_user_array()
 * @param args string where clause entry
 * @return array Array of Users' details that match passed criteria
 */
function getUserArrayFromFullName($args) {
	global $locale;
	$db = DBManagerFactory::getInstance();

	$argArray = array();
	if(strpos($args, " ")) {
		$argArray = explode(" ", $args);
	} else {
		$argArray[] = $args;
	}

	$inClause = '';
	foreach($argArray as $arg) {
		if(!empty($inClause)) {
			$inClause .= ' OR ';
		}
		if(empty($arg))
		continue;

		$inClause .= "first_name LIKE '{$arg}%' OR last_name LIKE '{$arg}%'";
	}

	$query  = "SELECT id, first_name, last_name, user_name FROM users WHERE status='Active' AND deleted=0 AND ";
	$query .= $inClause;
	$query .= " ORDER BY last_name ASC";

	$r = $db->query($query);
	$ret = array();
	while($a = $db->fetchByAssoc($r)) {
		$ret[$a['id']] = $locale->getLocaleFormattedName($a['first_name'], $a['last_name']);
	}

	return $ret;
}

/**
 *
 * based on user pref then system pref
 */
function showFullName() {
	global $sugar_config;
	global $current_user;
	static $showFullName = null;

	if (is_null($showFullName)) {
		$sysPref = (isset($sugar_config['use_real_names']) && $sugar_config['use_real_names'] == true) ? true : false;
		$userPref = (is_object($current_user)) ? $current_user->getPreference('use_real_names') : null;

		if($userPref != null) {
			$bool = ($userPref == 'on') ? true : false;
			$showFullName = $bool;
		} else {
			$showFullName = $sysPref;
		}
	}

	return $showFullName;
}

function clean($string, $maxLength)
{
	$string = substr($string, 0, $maxLength);
	return escapeshellcmd($string);
}

/**
 * Copy the specified request variable to the member variable of the specified object.
 * Do no copy if the member variable is already set.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function safe_map($request_var, & $focus, $always_copy = false)
{
	safe_map_named($request_var, $focus, $request_var, $always_copy);
}

/**
 * Copy the specified request variable to the member variable of the specified object.
 * Do no copy if the member variable is already set.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function safe_map_named($request_var, & $focus, $member_var, $always_copy)
{
	if (isset($_REQUEST[$request_var]) && ($always_copy || is_null($focus->$member_var))) {
		$GLOBALS['log']->debug("safe map named called assigning '{$_REQUEST[$request_var]}' to $member_var");
		$focus->$member_var = $_REQUEST[$request_var];
	}
}

/** This function retrieves an application language file and returns the array of strings included in the $app_list_strings var.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_app_list_strings_language($language) {
	global $app_list_strings;
	global $sugar_config;

	$cache_key = 'app_list_strings.'.$language;

	// Check for cached value
	$cache_entry = sugar_cache_retrieve($cache_key);
	if(!empty($cache_entry))
	{
		return $cache_entry;
	}

	$default_language = $sugar_config['default_language'];
	$temp_app_list_strings = $app_list_strings;
	$language_used = $language;

	include("include/language/en_us.lang.php");	
   
	$en_app_list_strings = array();
	if($language_used != $default_language){
	    require("include/language/$default_language.lang.php");

        if(file_exists("include/language/$default_language.lang.override.php")) {
            include("include/language/$default_language.lang.override.php");
        }

        if(file_exists("include/language/$default_language.lang.php.override")) {
            include("include/language/$default_language.lang.php.override");
        }
       
	    $en_app_list_strings = $app_list_strings;
	}
	
	include("include/language/$language.lang.php");

	if(file_exists("include/language/$language.lang.override.php")) {
		include("include/language/$language.lang.override.php");
	}

	if(file_exists("include/language/$language.lang.php.override")) {
		include("include/language/$language.lang.php.override");
	}
	
	// cn: bug 6048 - merge en_us with requested language
    if (!empty($en_app_list_strings)) {
        $app_list_strings = sugarArrayMerge($en_app_list_strings, $app_list_strings);
    }

    if (file_exists("custom/application/Ext/Language/en_us.lang.ext.php")){
		$app_list_strings =  _mergeCustomAppListStrings("custom/application/Ext/Language/en_us.lang.ext.php" , $app_list_strings) ;	
   }

   if($language_used != $default_language){
    	 if(file_exists("custom/application/Ext/Language/$default_language.lang.ext.php")) {
        	$app_list_strings =  _mergeCustomAppListStrings("custom/application/Ext/Language/$default_language.lang.ext.php" , $app_list_strings);
            $GLOBALS['log']->info("Found extended language file: $default_language.lang.ext.php");
        }
        if(file_exists("custom/include/language/$default_language.lang.php")) {
            include("custom/include/language/$default_language.lang.php");
            $GLOBALS['log']->info("Found custom language file: $default_language.lang.php");
        }
    }

	if(file_exists("custom/application/Ext/Language/$language.lang.ext.php")) {		
		$app_list_strings = _mergeCustomAppListStrings("custom/application/Ext/Language/$language.lang.ext.php" , $app_list_strings);
	   $GLOBALS['log']->info("Found extended language file: $language.lang.ext.php");
	}

	if(file_exists("custom/include/language/$language.lang.php")) {
		include("custom/include/language/$language.lang.php");
		$GLOBALS['log']->info("Found custom language file: $language.lang.php");
	}
	
	if(!isset($app_list_strings)) {
		$GLOBALS['log']->warn("Unable to find the application language file for language: ".$language);
		$language_used = $default_language;
		$app_list_strings = $en_app_list_strings;
	}

	if(!isset($app_list_strings)) {
		$GLOBALS['log']->fatal("Unable to load the application language file for the selected language($language) or the default language($default_language)");
		return null;
	}
	
	$return_value = $app_list_strings;
	$app_list_strings = $temp_app_list_strings;

	sugar_cache_put($cache_key, $return_value);

	return $return_value;
}

/**
* The dropdown items in custom language files is $app_list_strings['$key']['$second_key'] = $value not 
* $GLOBALS['app_list_strings']['$key'] = $value, so we have to delete the original ones in app_list_strings and relace it with the custom ones.
 * @param file string the language that you want include, 
 * @param app_list_strings array the golbal strings 
 * @return array
 */
 //jchi 25347
function _mergeCustomAppListStrings($file , $app_list_strings){
	$app_list_strings_original = $app_list_strings;
	unset($app_list_strings);
	include($file);
	if(!isset($app_list_strings) || !is_array($app_list_strings)){
		return $app_list_strings_original;
	}
	//Bug 25347: We should not merge custom dropdown fields unless they relate to parent fields or the module list.
	foreach($app_list_strings as $key=>$value)
	{
		$exemptDropdowns = array("moduleList", "parent_type_display", "record_type_display", "record_type_display_notes");
		if (!in_array($key, $exemptDropdowns) && array_key_exists($key, $app_list_strings_original)) 
		{	   		
	   		unset($app_list_strings_original["$key"]);
		}
   }
   $app_list_strings = sugarArrayMergeRecursive($app_list_strings_original , $app_list_strings);
   return $app_list_strings;
}

/** This function retrieves an application language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_application_language($language) {
	global $app_strings, $sugar_config;

	$cache_key = 'app_strings.'.$language;

	// Check for cached value
	$cache_entry = sugar_cache_retrieve($cache_key);
	if(!empty($cache_entry))
	{
		return $cache_entry;
	}

	$temp_app_strings = $app_strings;
	$language_used = $language;
	$default_language = $sugar_config['default_language'];

	// cn: bug 6048 - merge en_us with requested language
	include("include/language/en_us.lang.php");
	if(file_exists("custom/include/language/en_us.lang.php")) {
		include("custom/include/language/en_us.lang.php");
	}
	$en_app_strings = array();
	if($language_used != $default_language)
	$en_app_strings = $app_strings;

	if(!empty($language)) {
		include("include/language/$language.lang.php");
	}

	if(file_exists("include/language/$language.lang.override.php")) {
		include("include/language/$language.lang.override.php");
	}
	if(file_exists("include/language/$language.lang.php.override")) {
		include("include/language/$language.lang.php.override");
	}
	if(file_exists("custom/application/Ext/Language/$language.lang.ext.php")) {
		include("custom/application/Ext/Language/$language.lang.ext.php");
		$GLOBALS['log']->info("Found extended language file: $language.lang.ext.php");
	}
	if(file_exists("custom/include/language/$language.lang.php")) {
		include("custom/include/language/$language.lang.php");
		$GLOBALS['log']->info("Found custom language file: $language.lang.php");
	}


	if(!isset($app_strings)) {
		$GLOBALS['log']->warn("Unable to find the application language file for language: ".$language);
		require("include/language/$default_language.lang.php");
		if(file_exists("include/language/$default_language.lang.override.php")) {
			include("include/language/$default_language.lang.override.php");
		}
		if(file_exists("include/language/$default_language.lang.php.override")) {
			include("include/language/$default_language.lang.php.override");
		}

		if(file_exists("custom/application/Ext/Language/$default_language.lang.ext.php")) {
			include("custom/application/Ext/Language/$default_language.lang.ext.php");
			$GLOBALS['log']->info("Found extended language file: $default_language.lang.ext.php");
		}
		$language_used = $default_language;
	}

	if(!isset($app_strings)) {
		$GLOBALS['log']->fatal("Unable to load the application language file for the selected language($language) or the default language($default_language)");
		return null;
	}

	// cn: bug 6048 - merge en_us with requested language
	$app_strings = sugarArrayMerge($en_app_strings, $app_strings);

	// If we are in debug mode for translating, turn on the prefix now!
	if($sugar_config['translation_string_prefix']) {
		foreach($app_strings as $entry_key=>$entry_value) {
			$app_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}
	if(isset($_SESSION['show_deleted'])) {
		$app_strings['LBL_DELETE_BUTTON'] = $app_strings['LBL_UNDELETE_BUTTON'];
		$app_strings['LBL_DELETE_BUTTON_LABEL'] = $app_strings['LBL_UNDELETE_BUTTON_LABEL'];
		$app_strings['LBL_DELETE_BUTTON_TITLE'] = $app_strings['LBL_UNDELETE_BUTTON_TITLE'];
		$app_strings['LBL_DELETE'] = $app_strings['LBL_UNDELETE'];
	}

	$app_strings['LBL_ALT_HOT_KEY'] = get_alt_hot_key();
	
	$return_value = $app_strings;
	$app_strings = $temp_app_strings;

	sugar_cache_put($cache_key, $return_value);
	return $return_value;
}

/** This function retrieves a module's language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are in the current module, do not call this function unless you are loading it for the first time */
function return_module_language($language, $module, $refresh=false) {
	global $mod_strings;
	global $sugar_config;
	global $currentModule;

	// Jenny - Bug 8119: Need to check if $module is not empty
	if (empty($module)) {
		$stack  = debug_backtrace();
		$GLOBALS['log']->warn("Variable module is not in return_module_language ". var_export($stack, true));
		return array();
	}

	// Store the current mod strings for later
	$temp_mod_strings = $mod_strings;
	$loaded_mod_strings = array();
	$language_used = $language;
	$default_language = $sugar_config['default_language'];

	if(empty($language)) {
		$language = $default_language;
	}

	// Bug 21559 - So we can get all the strings defined in the template, refresh
	// the vardefs file if the cached language file doesn't exist.
    if(!file_exists($GLOBALS['sugar_config']['cache_dir'].'modules/'. $module . '/language/'.$language.'.lang.php') 
			&& !empty($GLOBALS['beanList'][$module])){
		$object = $GLOBALS['beanList'][$module];
		if ($object == 'aCase')
            $object = 'Case';
		VardefManager::refreshVardefs($module,$object);
	}
    
	$loaded_mod_strings = LanguageManager::loadModuleLanguage($module, $language,$refresh);

	// cn: bug 6048 - merge en_us with requested language
	if($language != $sugar_config['default_language'])
        $loaded_mod_strings = sugarArrayMerge(
            LanguageManager::loadModuleLanguage($module, $sugar_config['default_language'],$refresh),
                $loaded_mod_strings
            );
    
	// If we are in debug mode for translating, turn on the prefix now!
	if($sugar_config['translation_string_prefix']) {
		foreach($loaded_mod_strings as $entry_key=>$entry_value) {
			$loaded_mod_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$return_value = $loaded_mod_strings;
	if(!isset($mod_strings)){
		$mod_strings = $return_value;
	}
	else
		$mod_strings = $temp_mod_strings;

	return $return_value;
}


/** This function retrieves an application language file and returns the array of strings included in the $mod_list_strings var.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_mod_list_strings_language($language,$module) {
	global $mod_list_strings;
	global $sugar_config;
	global $currentModule;

	$cache_key = "mod_list_str_lang.".$language.$module;

	// Check for cached value
	$cache_entry = sugar_cache_retrieve($cache_key);
	if(!empty($cache_entry))
	{
		return $cache_entry;
	}

	$language_used = $language;
	$temp_mod_list_strings = $mod_list_strings;
	$default_language = $sugar_config['default_language'];

	if($currentModule == $module && isset($mod_list_strings) && $mod_list_strings != null) {
		return $mod_list_strings;
	}

	// cn: bug 6351 - include en_us if file langpack not available
	// cn: bug 6048 - merge en_us with requested language
	include("modules/$module/language/en_us.lang.php");
	$en_mod_list_strings = array();
	if($language_used != $default_language)
	$en_mod_list_strings = $mod_list_strings;

	if(file_exists("modules/$module/language/$language.lang.php")) {
		include("modules/$module/language/$language.lang.php");
	}

	if(file_exists("modules/$module/language/$language.lang.override.php")){
		include("modules/$module/language/$language.lang.override.php");
	}

	if(file_exists("modules/$module/language/$language.lang.php.override")){
		echo 'Please Change:<br>' . "modules/$module/language/$language.lang.php.override" . '<br>to<br>' . 'Please Change:<br>' . "modules/$module/language/$language.lang.override.php";
		include("modules/$module/language/$language.lang.php.override");
	}

	// cn: bug 6048 - merge en_us with requested language
	$mod_list_strings = sugarArrayMerge($en_mod_list_strings, $mod_list_strings);

	// if we still don't have a language pack, then log an error
	if(!isset($mod_list_strings)) {
		$GLOBALS['log']->fatal("Unable to load the application list language file for the selected language($language) or the default language($default_language) for module({$module})");
		return null;
	}

	$return_value = $mod_list_strings;
	$mod_list_strings = $temp_mod_list_strings;

	sugar_cache_put($cache_key, $return_value);
	return $return_value;
}


/** This function retrieves a theme's language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function return_theme_language($language, $theme)
{
	global $mod_strings, $sugar_config, $currentModule;

	$language_used = $language;
	$default_language = $sugar_config['default_language'];

	include(SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.php");
	if(file_exists(SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.override.php")){
		include(SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.override.php");
	}
	if(file_exists(SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.php.override")){
		echo 'Please Change:<br>' . SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.php.override" . '<br>to<br>' . 'Please Change:<br>' . SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.override.php";
		include(SugarThemeRegistry::get($theme)->getFilePath()."/language/$current_language.lang.php.override");
	}
	if(!isset($theme_strings))
	{
		$GLOBALS['log']->warn("Unable to find the theme file for language: ".$language." and theme: ".$theme);
		require(SugarThemeRegistry::get($theme)->getFilePath()."/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($theme_strings))
	{
		$GLOBALS['log']->fatal("Unable to load the theme($theme) language file for the selected language($language) or the default language($default_language)");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($sugar_config['translation_string_prefix'])
	{
		foreach($theme_strings as $entry_key=>$entry_value)
		{
			$theme_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	return $theme_strings;
}



/** If the session variable is defined and is not equal to "" then return it.  Otherwise, return the default value.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function return_session_value_or_default($varname, $default)
{
	if(isset($_SESSION[$varname]) && $_SESSION[$varname] != "")
	{
		return $_SESSION[$varname];
	}

	return $default;
}

/**
 * Creates an array of where restrictions.  These are used to construct a where SQL statement on the query
 * It looks for the variable in the $_REQUEST array.  If it is set and is not "" it will create a where clause out of it.
 * @param &$where_clauses - The array to append the clause to
 * @param $variable_name - The name of the variable to look for an add to the where clause if found
 * @param $SQL_name - [Optional] If specified, this is the SQL column name that is used.  If not specified, the $variable_name is used as the SQL_name.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function append_where_clause(&$where_clauses, $variable_name, $SQL_name = null)
{
	if($SQL_name == null)
	{
		$SQL_name = $variable_name;
	}

	if(isset($_REQUEST[$variable_name]) && $_REQUEST[$variable_name] != "")
	{
		array_push($where_clauses, "$SQL_name like '".$GLOBALS['db']->quote($_REQUEST[$variable_name])."%'");
	}
}

/**
 * Generate the appropriate SQL based on the where clauses.
 * @param $where_clauses - An Array of individual where clauses stored as strings
 * @returns string where_clause - The final SQL where clause to be executed.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function generate_where_statement($where_clauses)
{
	$where = "";
	foreach($where_clauses as $clause)
	{
		if($where != "")
		$where .= " and ";
		$where .= $clause;
	}

	$GLOBALS['log']->info("Here is the where clause for the list view: $where");
	return $where;
}

/**
 * determines if a passed string matches the criteria for a Sugar GUID
 * @param string $guid
 * @return bool False on failure
 */
function is_guid($guid) {
	if(strlen($guid) != 36) {
		return false;
	}

	if(preg_match("/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/i", $guid)) {
		return true;
	}

	return true;;
}


/**
 * A temporary method of generating GUIDs of the correct format for our DB.
 * @return String contianing a GUID in the format: aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
 *
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function create_guid()
{
	$microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = dechex($a_dec* 1000000);
	$sec_hex = dechex($a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);

	return $guid;

}

function create_guid_section($characters)
{
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= dechex(mt_rand(0,15));
	}
	return $return;
}

function ensure_length(&$string, $length)
{
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
}

function microtime_diff($a, $b) {
	list($a_dec, $a_sec) = explode(" ", $a);
	list($b_dec, $b_sec) = explode(" ", $b);
	return $b_sec - $a_sec + $b_dec - $a_dec;
}

// check if Studio is displayed.
function displayStudioForCurrentUser(){















    

	return true;

}

function displayWorkflowForCurrentUser(){




























    $_SESSION['display_workflow_for_user'] = false;            
    return false;
}

// return an array with all modules where the user is an admin.
function get_admin_modules_for_user($user) {
    global $beanList;
    $admin_modules = array();























    
    return ($admin_modules);    
}

 function get_workflow_admin_modules_for_user($user){
    if (isset($_SESSION['get_workflow_admin_modules_for_user'])) {
        return $_SESSION['get_workflow_admin_modules_for_user'];
    }

    global $moduleList;
    $workflow_mod_list = array();
    foreach($moduleList as $module){
		$workflow_mod_list[$module] = $module;	
	}
	
	// This list is taken from teh previous version of workflow_utils.php
    $workflow_mod_list['Tasks'] = "Tasks";
    $workflow_mod_list['Calls'] = "Calls";
    $workflow_mod_list['Meetings'] = "Meetings";
    $workflow_mod_list['Notes'] = "Notes";
    $workflow_mod_list['ProjectTask'] = "Project Tasks";	
	$workflow_mod_list['Leads'] = "Leads";
	$workflow_mod_list['Opportunities'] = "Opportunities";	    
	// End of list
    
    $workflow_admin_modules = array();
    if(empty($user)) {
    	return $workflow_admin_modules;
    }
    $actions = ACLAction::getUserActions($user->id);
    //check for ForecastSchedule because it doesn't exist in $workflow_mod_list
    if (isset($actions['ForecastSchedule']['module']['admin']['aclaccess']) && ($actions['ForecastSchedule']['module']['admin']['aclaccess']==ACL_ALLOW_DEV || 
        $actions['ForecastSchedule']['module']['admin']['aclaccess']==ACL_ALLOW_ADMIN_DEV)) {
        $workflow_admin_modules['Forecasts'] = 'Forecasts';  
    }
    foreach ($workflow_mod_list as $key=>$val) {      
        if(!in_array($val, $workflow_admin_modules) && ($val!='iFrames' && $val!='Feeds' && $val!='Home' && $val!='Dashboard'
            && $val!='Calendar' && $val!='Activities' && $val!='Reports') && 
            (is_admin_for_module($user,$key))) { 
                $workflow_admin_modules[$key] = $val;
        }
    }
    $_SESSION['get_workflow_admin_modules_for_user'] = $workflow_admin_modules;
    return ($workflow_admin_modules);  
}

// Check if user is admin for at least one module.
function is_admin_for_any_module($user) {


















    return false;   
}


// Check if user is admin for a specific module.
function is_admin_for_module($user,$module) {















    return false;
}


/**
 * Check if user id belongs to a system admin.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function is_admin($user) {
	if(!empty($user) && ($user->is_admin == '1' || $user->is_admin === 'on')){
		return true;
	}

	return false;
}

/**
 * Return the display name for a theme if it exists.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 *
 * @deprecated use SugarThemeRegistry::get($theme)->name instead
 */
function get_theme_display($theme) 
{
	return SugarThemeRegistry::get($theme)->name;
}

/**
 * Return an array of directory names.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 *
 * @deprecated use SugarThemeRegistry::availableThemes() instead.
 */
function get_themes() 
{
    return SugarThemeRegistry::availableThemes();
}

/**
 * THIS FUNCTION IS DEPRECATED AND SHOULD NOT BE USED; USE get_select_options_with_id()
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.
 * param $option_list - the array of strings to that contains the option list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_select_options ($option_list, $selected) {
	return get_select_options_with_id($option_list, $selected);
}

/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.  The values are the display strings.
 * param $option_list - the array of strings to that contains the option list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_select_options_with_id ($option_list, $selected_key) {
	return get_select_options_with_id_separate_key($option_list, $option_list, $selected_key);
}


/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.  The values are the display strings.
 * param $label_list - the array of strings to that contains the option list
 * param $key_list - the array of strings to that contains the values list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_select_options_with_id_separate_key ($label_list, $key_list, $selected_key) {
	global $app_strings;
	$select_options = "";

	//for setting null selection values to human readable --None--
	$pattern = "/'0?'></";
	$replacement = "''>".$app_strings['LBL_NONE']."<";

	if (empty($key_list)) $key_list = array();
	//create the type dropdown domain and set the selected value if $opp value already exists
	foreach ($key_list as $option_key=>$option_value) {

		$selected_string = '';
		// the system is evaluating $selected_key == 0 || '' to true.  Be very careful when changing this.  Test all cases.
		// The bug was only happening with one of the users in the drop down.  It was being replaced by none.
		if (($option_key != '' && $selected_key == $option_key) || ($selected_key == '' && $option_key == '') || (is_array($selected_key) &&  in_array($option_key, $selected_key)))
		{
			$selected_string = 'selected ';
		}

		$html_value = $option_key;

		$select_options .= "\n<OPTION ".$selected_string."value='$html_value'>$label_list[$option_key]</OPTION>";
	}
	$select_options = preg_replace($pattern, $replacement, $select_options);
	return $select_options;
}


/**
 * Call this method instead of die().
 * Then we call the die method with the error message that is passed in.
 */
function sugar_die($error_message)
{
	global $focus;
	sugar_cleanup();
	die($error_message);
}


/**
 * Create javascript to clear values of all elements in a form.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_clear_form_js () {
	$the_script = <<<EOQ
<script type="text/javascript" language="JavaScript">
function clear_form(form) {
	var newLoc = 'index.php?action=' + form.action.value + '&module=' + form.module.value + '&query=true&clear_query=true';
	if(typeof(form.advanced) != 'undefined'){
		newLoc += '&advanced=' + form.advanced.value;
	}
	document.location.href= newLoc;
}
</script>
EOQ;

	return $the_script;
}

/**
 * Create javascript to set the cursor focus to specific field in a form
 * when the screen is rendered.  The field name is currently hardcoded into the
 * the function.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_set_focus_js () {
	//TODO Clint 5/20 - Make this function more generic so that it can take in the target form and field names as variables
	$the_script = <<<EOQ
<script type="text/javascript" language="JavaScript">
<!-- Begin
function set_focus() {
	if (document.forms.length > 0) {
		for (i = 0; i < document.forms.length; i++) {
			for (j = 0; j < document.forms[i].elements.length; j++) {
				var field = document.forms[i].elements[j];
				if ((field.type == "text" || field.type == "textarea" || field.type == "password") &&
						!field.disabled && (field.name == "first_name" || field.name == "name" || field.name == "user_name" || field.name=="document_name")) {
					field.focus();
                    if (field.type == "text") {
                        field.select();
                    }
					break;
	    		}
			}
      	}
   	}
}
//  End -->
</script>
EOQ;

	return $the_script;
}

/**
 * Very cool algorithm for sorting multi-dimensional arrays.  Found at http://us2.php.net/manual/en/function.array-multisort.php
 * Syntax: $new_array = array_csort($array [, 'col1' [, SORT_FLAG [, SORT_FLAG]]]...);
 * Explanation: $array is the array you want to sort, 'col1' is the name of the column
 * you want to sort, SORT_FLAGS are : SORT_ASC, SORT_DESC, SORT_REGULAR, SORT_NUMERIC, SORT_STRING
 * you can repeat the 'col',FLAG,FLAG, as often you want, the highest prioritiy is given to
 * the first - so the array is sorted by the last given column first, then the one before ...
 * Example: $array = array_csort($array,'town','age',SORT_DESC,'name');
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function array_csort() {
	$args = func_get_args();
	$marray = array_shift($args);
	$i = 0;

	$msortline = "return(array_multisort(";
	foreach ($args as $arg) {
		$i++;
		if (is_string($arg)) {
			foreach ($marray as $row) {
				$sortarr[$i][] = $row[$arg];
			}
		} else {
			$sortarr[$i] = $arg;
		}
		$msortline .= "\$sortarr[".$i."],";
	}
	$msortline .= "\$marray));";

	eval($msortline);
	return $marray;
}

/**
 * Converts localized date format string to jscalendar format
 * Example: $array = array_csort($array,'town','age',SORT_DESC,'name');
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function parse_calendardate($local_format) {
	preg_match("/\(?([^-]{1})[^-]*-([^-]{1})[^-]*-([^-]{1})[^-]*\)/", $local_format, $matches);
	$calendar_format = "%" . $matches[1] . "-%" . $matches[2] . "-%" . $matches[3];
	return str_replace(array("y", "�", "a", "j"), array("Y", "Y", "Y", "d"), $calendar_format);
}





function translate($string, $mod='', $selectedValue=''){
	//$test_start = microtime();
	//static $mod_strings_results = array();
	if(!empty($mod)){
		global $current_language;
		$mod_strings = return_module_language($current_language, $mod);
	}else{
		global $mod_strings;
	}

	$returnValue = '';
	global $app_strings, $app_list_strings;

	if(isset($mod_strings[$string]))
	$returnValue = $mod_strings[$string];
	else if(isset($app_strings[$string]))
	$returnValue = $app_strings[$string];
	else if(isset($app_list_strings[$string]))
	$returnValue = $app_list_strings[$string];
	else if(isset($app_list_strings['moduleList']) && isset($app_list_strings['moduleList'][$string]))
	$returnValue = $app_list_strings['moduleList'][$string];


	//$test_end = microtime();
	//
	//    $mod_strings_results[$mod] = microtime_diff($test_start,$test_end);
	//
	//    echo("translate results:");
	//    $total_time = 0;
	//    $total_strings = 0;
	//    foreach($mod_strings_results as $key=>$value)
	//    {
	//        echo("Module $key \t\t time $value \t\t<br>");
	//        $total_time += $value;
	//    }
	//
	//    echo("Total time: $total_time<br>");



	if(empty($returnValue)){
		return $string;
	}

	if(is_array($returnValue) && ! empty($selectedValue) && isset($returnValue[$selectedValue]) ){
		return $returnValue[$selectedValue];
	}

	return $returnValue;
}

function unTranslateNum($num) {
        static $dec_sep;
        static $num_grp_sep;
        global $current_user, $sugar_config;

        if($dec_sep == null) {
            $user_dec_sep = $current_user->getPreference('dec_sep');
            $dec_sep = (empty($user_dec_sep) ? $sugar_config['default_decimal_seperator'] : $user_dec_sep);
        }
        if($num_grp_sep == null) {
            $user_num_grp_sep = $current_user->getPreference('num_grp_sep');
            $num_grp_sep = (empty($user_num_grp_sep) ? $sugar_config['default_number_grouping_seperator'] : $user_num_grp_sep);
        }

        $num = preg_replace("'" . preg_quote($num_grp_sep) . "'", '', $num);
        $num = preg_replace("'" . preg_quote($dec_sep) . "'", '.', $num);
        return $num;

}

function add_http($url) {
	if(!eregi("://", $url)) {
		$scheme = "http";
		if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
			$scheme = 'https';
		}

		return "{$scheme}://{$url}";
	}

	return $url;
}

/**
 * returns a default array of XSS tags to clean
 * @return array
 */
function getDefaultXssTags() {
	$tmp = array(
	"applet" => "applet",
	"base" => "base",
	"embed" => "embed",
	"form" => "form",
	"frame" => "frame",
	"frameset" => "frameset",
	"iframe" => "iframe",
	"import" => "\?import",
	"layer" => "layer",
	"link" => "link",
	"object" => "object",
	"script" => "script",
	"xmp" => "xmp",
	);

	$ret = base64_encode(serialize($tmp));

	return $ret;
}

/**
 * Detects typical XSS attack patterns
 * @param string str String to search for XSS attack vectors
 * @param bool cleanImg Flag to allow <img> tags to survive - only used by InboundEmail for inline images.
 * @return array Array of matches, empty on clean string
 */
function clean_xss($str, $cleanImg=true) {
	global $sugar_config;

	if(empty($sugar_config['email_xss']))
	$sugar_config['email_xss'] = getDefaultXssTags();

	$arr = unserialize(base64_decode($sugar_config['email_xss']));

	$regex = '';
	foreach($arr as $v) {
		if(!empty($regex)) {
			$regex .= "|";
		}
		$regex .= $v;
	}

	$tag_regex        = "#<({$regex})[^>]*>?#sim";

	// cn: bug 13079 - "on\w" matched too many non-events (cONTact, strONG, etc.)
	$jsEvents  = "onblur|onfocus|oncontextmenu|onresize|onscroll|onunload|ondblclick|onclick|";
	$jsEvents .= "onmouseup|onmouseover|onmousedown|onmouseenter|onmouseleave|onmousemove|onload|onchange|";
	$jsEvents .= "onreset|onselect|onsubmit|onkeydown|onkeypress|onkeyup|onabort|onerror";

	$attribute_regex	= "#<[^/>][^>]+({$jsEvents}|data\w+)[^=>]*=[^>]*>#sim";
	$javascript_regex	= '@<[^/>][^>]+(expression|j\W*a\W*v\W*a|v\W*b\W*s\W*c\W*r|&#|/\*|\*/)[^>]*>@sim';
	$imgsrc_regex		= '#<[^>]+src[^=]*=([^>]*?http://[^>]*)>#sim';
	$css_url			= "#url\(.*\.\w+\)#";


	$str = str_replace("\t", "", $str);

	$matches = array_merge(
	xss_check_pattern($tag_regex, $str),
	xss_check_pattern($javascript_regex, $str),
	xss_check_pattern($attribute_regex, $str)
	);

	if($cleanImg) {
		$matches = array_merge($matches,
		xss_check_pattern($imgsrc_regex, $str)
		);
	}

	// cn: bug 13498 - custom white-list of allowed domains that vet remote images
	preg_match_all($css_url, $str, $cssUrlMatches, PREG_PATTERN_ORDER);

	if(isset($sugar_config['security_trusted_domains']) && !empty($sugar_config['security_trusted_domains']) && is_array($sugar_config['security_trusted_domains'])) {
		if(is_array($cssUrlMatches) && count($cssUrlMatches) > 0) {
			// normalize whitelist
			foreach($sugar_config['security_trusted_domains'] as $k => $v) {
				$sugar_config['security_trusted_domains'][$k] = strtolower($v);
			}

			foreach($cssUrlMatches[0] as $match) {
				$domain = strtolower(substr(strstr($match, "://"), 3));
				$baseUrl = substr($domain, 0, strpos($domain, "/"));

				if(!in_array($baseUrl, $sugar_config['security_trusted_domains'])) {
					$matches[] = $match;
				}
			}
		}
	} else {
		$matches = array_merge($matches, $cssUrlMatches[0]);
	}

	return $matches;
}

/**
 * Helper function used by clean_xss() to parse for known-bad vectors
 * @param string pattern Regex pattern to use
 * @param string str String to parse for badness
 * @return array
 */
function xss_check_pattern($pattern, $str) {
	preg_match_all($pattern, $str, $matches, PREG_PATTERN_ORDER);
	return $matches[1];
}

// Designed to take a string passed in the URL as a parameter and clean all "bad" data from it
// The second argument is a string, "filter," which corresponds to a regular expression
function clean_string($str, $filter = "STANDARD") {
	global  $sugar_config;

	$filters = Array(
	"STANDARD"        => "#[^A-Z0-9\-_\.\@]#i",
	"STANDARDSPACE"   => "#[^A-Z0-9\-_\.\@\ ]#i",
	"FILE"            => "#[^A-Z0-9\-_\.]#i",
	"NUMBER"          => "#[^0-9\-]#i",
	"SQL_COLUMN_LIST" => "#[^A-Z0-9,_\.]#i",
	"PATH_NO_URL"     => "#://#i",
	"SAFED_GET"		  => "#[^A-Z0-9\@\=\&\?\.\/\-_~]#i", /* range of allowed characters in a GET string */
	"UNIFIED_SEARCH"	=> "#[\\x00]#", /* cn: bug 3356 & 9236 - MBCS search strings */
	"AUTO_INCREMENT"	=> "#[^0-9\-,\ ]#i",
	"ALPHANUM"        => "#[^A-Z0-9\-]#i",
	);

	if (preg_match($filters[$filter], $str)) {
		if (isset($GLOBALS['log']) && is_object($GLOBALS['log'])) {
			$GLOBALS['log']->fatal("SECURITY: bad data passed in; string: {$str}");
		}
		die("Bad data passed in; <a href=\"{$sugar_config['site_url']}\">Return to Home</a>");
	}
	else {
		return $str;
	}
}

function clean_special_arguments() {
	if(isset($_SERVER['PHP_SELF'])) {
		if (!empty($_SERVER['PHP_SELF'])) clean_string($_SERVER['PHP_SELF'], 'SAFED_GET');
	}
	if (!empty($_REQUEST) && !empty($_REQUEST['login_theme'])) clean_string($_REQUEST['login_theme'], "STANDARD");
	if (!empty($_REQUEST) && !empty($_REQUEST['ck_login_theme_20'])) clean_string($_REQUEST['ck_login_theme_20'], "STANDARD");
	if (!empty($_SESSION) && !empty($_SESSION['authenticated_user_theme'])) clean_string($_SESSION['authenticated_user_theme'], "STANDARD");
	if (!empty($_REQUEST) && !empty($_REQUEST['module_name'])) clean_string($_REQUEST['module_name'], "STANDARD");
	if (!empty($_REQUEST) && !empty($_REQUEST['module'])) clean_string($_REQUEST['module'], "STANDARD");
	if (!empty($_POST) && !empty($_POST['parent_type'])) clean_string($_POST['parent_type'], "STANDARD");
	if (!empty($_REQUEST) && !empty($_REQUEST['mod_lang'])) clean_string($_REQUEST['mod_lang'], "STANDARD");
	if (!empty($_SESSION) && !empty($_SESSION['authenticated_user_language'])) clean_string($_SESSION['authenticated_user_language'], "STANDARD");
	if (!empty($_SESSION) && !empty($_SESSION['dyn_layout_file'])) clean_string($_SESSION['dyn_layout_file'], "PATH_NO_URL");
	if (!empty($_GET) && !empty($_GET['from'])) clean_string($_GET['from']);
	if (!empty($_GET) && !empty($_GET['gmto'])) clean_string($_GET['gmto'], "NUMBER");
	if (!empty($_GET) && !empty($_GET['case_number'])) clean_string($_GET['case_number'], "AUTO_INCREMENT");
	if (!empty($_GET) && !empty($_GET['bug_number'])) clean_string($_GET['bug_number'], "AUTO_INCREMENT");
	if (!empty($_GET) && !empty($_GET['quote_num'])) clean_string($_GET['quote_num'], "AUTO_INCREMENT");
	clean_superglobals('stamp', 'ALPHANUM'); // for vcr controls
	clean_superglobals('offset', 'ALPHANUM');
	clean_superglobals('return_action');
	clean_superglobals('return_module');
	return TRUE;
}

/**
 * cleans the given key in superglobals $_GET, $_POST, $_REQUEST
 */
function clean_superglobals($key, $filter = 'STANDARD') {
	if(isset($_GET[$key])) clean_string($_GET[$key], $filter);
	if(isset($_POST[$key])) clean_string($_POST[$key], $filter);
	if(isset($_REQUEST[$key])) clean_string($_REQUEST[$key], $filter);
}

function set_superglobals($key, $val){
	$_GET[$key] = $val;
	$_POST[$key] = $val;
	$_REQUEST[$key] = $val;
}

// Works in conjunction with clean_string() to defeat SQL injection, file inclusion attacks, and XSS
function clean_incoming_data() {
	global $sugar_config;

	if (get_magic_quotes_gpc() == 1) {
		$req  = array_map("preprocess_param", $_REQUEST);
		$post = array_map("preprocess_param", $_POST);
		$get  = array_map("preprocess_param", $_GET);
	} else {
		
		$req  = array_map("securexss", $_REQUEST);
		$post = array_map("securexss", $_POST);
		$get  = array_map("securexss", $_GET);
	}

	// PHP cannot stomp out superglobals reliably
	foreach($post as $k => $v) { $_POST[$k] = $v; }
	foreach($get  as $k => $v) { $_GET[$k] = $v; }
	foreach($req  as $k => $v) {
		 $_REQUEST[$k] = $v;
		 //ensure the keys are safe as well 
		 securexsskey($k);
	}
	// Any additional variables that need to be cleaned should be added here
	if (isset($_REQUEST['login_theme'])) clean_string($_REQUEST['login_theme']);
	if (isset($_REQUEST['login_language'])) clean_string($_REQUEST['login_language']);
	if (isset($_REQUEST['action'])) clean_string($_REQUEST['action']);
	if (isset($_REQUEST['module'])) clean_string($_REQUEST['module']);
	if (isset($_REQUEST['record'])) clean_string($_REQUEST['record'], 'STANDARDSPACE');
	if (isset($_SESSION['authenticated_user_theme'])) clean_string($_SESSION['authenticated_user_theme']);
	if (isset($_SESSION['authenticated_user_language'])) clean_string($_SESSION['authenticated_user_language']);
	if (isset($_REQUEST['language'])) clean_string($_REQUEST['language']);
	if (isset($sugar_config['default_theme'])) clean_string($sugar_config['default_theme']);
	if (isset($_REQUEST['offset'])) clean_string($_REQUEST['offset']);
	if (isset($_REQUEST['stamp'])) clean_string($_REQUEST['stamp']);

	if(isset($_REQUEST['lvso'])){
			set_superglobals('lvso', (strtolower($_REQUEST['lvso']) === 'desc')?'desc':'asc');
	}
	// Clean "offset" and "order_by" parameters in URL
	foreach ($_REQUEST as $key => $val) {
		if (str_end($key, "_offset")) {
			clean_string($_REQUEST[$key], "ALPHANUM"); // keep this ALPHANUM for disable_count_query
			set_superglobals($key, $_REQUEST[$key]);
		}
		elseif (str_end($key, "_ORDER_BY")) {
			clean_string($_REQUEST[$key], "SQL_COLUMN_LIST");
			set_superglobals($key, $_REQUEST[$key]);
		}
	}
	

	return 0;
}

// Returns TRUE if $str begins with $begin
function str_begin($str, $begin) {
	return (substr($str, 0, strlen($begin)) == $begin);
}

// Returns TRUE if $str ends with $end
function str_end($str, $end) {
	return (substr($str, strlen($str) - strlen($end)) == $end);
}

function securexss($value) {
	if(is_array($value)){
    	$new = array();
        foreach($value as $key=>$val){
       		$new[$key] = securexss($val);
        }
        return $new;
    } 
	static $xss_cleanup=  array('"' =>'&quot;', "'" =>  '&#039;' , '<' =>'&lt;' , '>'=>'&gt;');
	$value = preg_replace(array('/javascript:/i', '/\0/'), array('java script:', ''), $value);
	$value = preg_replace('/javascript:/i', 'java script:', $value);
	return str_replace(array_keys($xss_cleanup), array_values($xss_cleanup), $value);
}

function securexsskey($value, $die=true){
	global $sugar_config;
	$matches = array();
	preg_match("/[\'\"\<\>]/", $value, $matches);
	if(!empty($matches)){
		if($die){
			die("Bad data passed in; <a href=\"{$sugar_config['site_url']}\">Return to Home</a>");
		}else{
			unset($_REQUEST[$value]);
			unset($_POST[$value]);
			unset($_GET[$value]);
		}
	}
}

function preprocess_param($value){
	if(is_string($value)){
		if(get_magic_quotes_gpc() == 1){
			$value = stripslashes($value);
		}
		
		$value = securexss($value);
	}
	
	
	return $value;


}

function set_register_value($category, $name, $value){
    return sugar_cache_put("{$category}:{$name}", $value);
}

function get_register_value($category,$name){
    return sugar_cache_retrieve("{$category}:{$name}");
}

// this function cleans id's when being imported
function convert_id($string)
{
	return preg_replace_callback( '|[^A-Za-z0-9\-]|',
	create_function(
	// single quotes are essential here,
	// or alternative escape all $ as \$
	'$matches',
	'return ord($matches[0]);'
         ) ,$string);
}

/**
 * @deprecated use SugarTheme::getImage()
 */
function get_image($image,$other_attributes,$width="",$height="")
{
    return SugarThemeRegistry::current()->getImage(basename($image),
        $other_attributes,
        empty($width) ? null : $width,
        empty($height) ? null : $height
        );
}
/**
 * @deprecated use SugarTheme::getImageURL()
 */
function getImagePath($image_name)
{
    return SugarThemeRegistry::current()->getImageURL($image_name);
}

function getWebPath($relative_path){
	//if it has  a :// then it isn't a relative path
	if(substr_count($relative_path, '://') > 0) return $relative_path;
	if(defined('TEMPLATE_URL'))$relative_path = SugarTemplateUtilities::getWebPath($relative_path);
	return $relative_path;
}

function getJSPath($relative_path, $additional_attrs=''){
	if(defined('TEMPLATE_URL'))$relative_path = SugarTemplateUtilities::getWebPath($relative_path);
	if(empty($GLOBALS['sugar_config']['js_custom_version']))$GLOBALS['sugar_config']['js_custom_version'] = 1;
	$js_version_key = isset($GLOBALS['js_version_key'])?$GLOBALS['js_version_key']:'';
	$path = $relative_path . '?s=' . $js_version_key . '&c=' . $GLOBALS['sugar_config']['js_custom_version'] ;
	if ( inDeveloperMode() ) $path .= '&developerMode='.mt_rand();
	if(!empty($additonal_attrs)) $path .= '&' . $additional_attrs;
	return $path;
}

function getSWFPath($relative_path, $additional_params=''){
	$path = $relative_path;
	if (!empty($additional_params)){
		$path .= '?' . $additional_params;
	}
	if (defined('TEMPLATE_URL')){
		$path = TEMPLATE_URL . '/' . $path;
	}
	return $path;
}





function getSQLDate($date_str)
{
	if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/',$date_str,$match))
	{
		if ( strlen($match[2]) == 1)
		{
			$match[2] = "0".$match[2];
		}
		if ( strlen($match[1]) == 1)
		{
			$match[1] = "0".$match[1];
		}
		return "{$match[3]}-{$match[1]}-{$match[2]}";
	}
	else if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/',$date_str,$match))
	{
		if ( strlen($match[2]) == 1)
		{
			$match[2] = "0".$match[2];
		}
		if ( strlen($match[1]) == 1)
		{
			$match[1] = "0".$match[1];
		}
		return "{$match[3]}-{$match[1]}-{$match[2]}";
	}
	else
	{
		return "";
	}
}

function clone_history(&$db, $from_id,$to_id, $to_type)
{
	global $timedate;
	$old_note_id=null;
	$old_filename=null;
	require_once('include/upload_file.php');
	$tables = array('calls'=>'Call', 'meetings'=>'Meeting', 'notes'=>'Note', 'tasks'=>'Task');

	$location=array('Email'=>"modules/Emails/Email.php",
	'Call'=>"modules/Calls/Call.php",
	'Meeting'=>"modules/Meetings/Meeting.php",
	'Note'=>"modules/Notes/Note.php",
	'Tasks'=>"modules/Tasks/Task.php",
	);


	foreach($tables as $table=>$bean_class)
	{

		if (!class_exists($bean_class))
		{
			require_once($location[$bean_class]);
		}

		$bProcessingNotes=false;
		if ($table=='notes')
		{
			$bProcessingNotes=true;
		}
		$query = "SELECT id FROM $table WHERE parent_id='$from_id'";
		$results = $db->query($query);
		while($row = $db->fetchByAssoc($results))
		{
			//retrieve existing record.
			$bean= new $bean_class();
			$bean->retrieve($row['id']);
			//process for new instance.
			if ($bProcessingNotes)
			{
				$old_note_id=$row['id'];
				$old_filename=$bean->filename;
			}
			$bean->id=null;
			$bean->parent_id=$to_id;
			$bean->parent_type=$to_type;
			if ($to_type=='Contacts' and in_array('contact_id',$bean->column_fields))
			{
				$bean->contact_id=$to_id;
			}
			$bean->update_date_modified = false;
            $bean->update_modified_by = false;
            if(isset($bean->date_modified))
                $bean->date_modified = $timedate->to_db($bean->date_modified);
            if(isset($bean->date_entered))
                $bean->date_entered = $timedate->to_db($bean->date_entered);
			//save
			$new_id=$bean->save();

			//duplicate the file now. for notes.
			if ($bProcessingNotes && !empty($old_filename))
			{
				UploadFile::duplicate_file($old_note_id,$new_id,$old_filename);
			}
			//reset the values needed for attachment duplication.
			$old_note_id=null;
			$old_filename=null;
		}
	}
}

function values_to_keys($array)
{
	$new_array = array();
	if(!is_array($array))
	{
		return $new_array;
	}
	foreach($array as $arr){
		$new_array[$arr] = $arr;
	}
	return $new_array;
}

function clone_relationship(&$db, $tables = array(), $from_column, $from_id, $to_id)
{
	foreach($tables as $table)
	{

		if ($table == 'emails_beans') {
			$query = "SELECT * FROM $table WHERE $from_column='$from_id' and bean_module='Leads'";
		} else {
			$query = "SELECT * FROM $table WHERE $from_column='$from_id'";
		}
		$results = $db->query($query);
		while($row = $db->fetchByAssoc($results))
		{
			$query = "INSERT INTO $table ";
			$names = '';
			$values = '';
			$row[$from_column] = $to_id;
			$row['id'] = create_guid();
			if ($table=='emails_beans') {
				$row['bean_module'] =='Contacts';
			}

			foreach($row as $name=>$value)
			{

				if(empty($names))
				{
					$names .= $name;
					$values .= "'$value'";
				} else
				{
					$names .= ', '. $name;
					$values .= ", '$value'";
				}
			}
			$query .= "($names)	VALUES ($values)";
			$db->query($query);
		}
	}
}

function get_unlinked_email_query($type, $bean) {
    global $current_user;

    $return_array['select']='SELECT emails.id ';
    $return_array['from']='FROM emails ';
    $return_array['where']="";
	$return_array['join'] = " JOIN (select distinct email_id from emails_email_addr_rel eear

	join email_addr_bean_rel eabr on eabr.bean_id ='$bean->id' and eabr.bean_module = '$bean->module_dir' and
	eabr.email_address_id = eear.email_address_id and eabr.deleted=0
	where eear.deleted=0 and eear.email_id not in
	(select eb.email_id from emails_beans eb where eb.bean_module ='$bean->module_dir' and eb.bean_id = '$bean->id' and eb.deleted=0)
	) derivedemails on derivedemails.email_id = emails.id";
    $return_array['join_tables'][0] = '';

	if (isset($type) and isset($type['return_as_array']) and $type['return_as_array']==true) {
		return $return_array;
	}

	return $return_array['select'] . $return_array['from'] . $return_array['where'];
} // fn

/**
 * Check to see if the number is empty or non-zero
 * @param $value
 * @return boolean
 **/
function number_empty($value)
{
	return empty($value) && $value != '0';
}

function get_bean_select_array($add_blank=true, $bean_name, $display_columns, $where='', $order_by='', $blank_is_none=false)
{
	global $beanFiles;
	require_once($beanFiles[$bean_name]);
	$focus = new $bean_name();
	$user_array = array();
	$user_array = get_register_value('select_array',$bean_name. $display_columns. $where . $order_by);
	if(!$user_array)
	{

		$db = DBManagerFactory::getInstance();
		$temp_result = Array();
		$query = "SELECT id, {$display_columns} as display from {$focus->table_name} where ";
		if ( $where != '')
		{
			$query .= $where." AND ";
		}

		$query .=  " deleted=0";

		if ( $order_by != '')
		{
			$query .= ' order by '.$order_by;
		}

		$GLOBALS['log']->debug("get_user_array query: $query");
		$result = $db->query($query, true, "Error filling in user array: ");

		if ($add_blank==true){
			// Add in a blank row
			if($blank_is_none == true) { // set 'blank row' to "--None--"
				global $app_strings;
				$temp_result[''] = $app_strings['LBL_NONE'];
			} else {
				$temp_result[''] = '';
			}
		}

		// Get the id and the name.
		while($row = $db->fetchByAssoc($result))
		{
			$temp_result[$row['id']] = $row['display'];
		}

		$user_array = $temp_result;
		set_register_value('select_array',$bean_name. $display_columns. $where . $order_by,$temp_result);
	}

	return $user_array;

}
/**
 *
 *
 * @param unknown_type $listArray
 */
// function parse_list_modules
// searches a list for items in a user's allowed tabs and returns an array that removes unallowed tabs from list
function parse_list_modules(&$listArray)
{
	global $modListHeader;
	$returnArray = array();

	foreach($listArray as $optionName => $optionVal)
	{
		if(array_key_exists($optionName, $modListHeader))
		{
			$returnArray[$optionName] = $optionVal;
		}
		// special case for products
		if(array_key_exists('Products', $modListHeader))
		{
			$returnArray['ProductTemplates'] = $listArray['ProductTemplates'];
		}

		// special case for projects
		if(array_key_exists('Project', $modListHeader))
		{
			$returnArray['ProjectTask'] = $listArray['ProjectTask'];
		}
	}
	$acldenied = ACLController::disabledModuleList($listArray,false);
	foreach($acldenied as $denied){
		unset($returnArray[$denied]);
	}
	asort($returnArray);

	return $returnArray;
}

function display_notice($msg = false){
	global $error_notice;
	//no error notice - lets just display the error to the user
	if(!isset($error_notice)){
		echo '<br>'.$msg . '<br>';
	}else{
		$error_notice .= $msg . '<br>';
	}
}

/* checks if it is a number that atleast has the plus at the beggining
 */
function skype_formatted($number){
	//kbrill - BUG #15375
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="Popup") {
		return false;
	} else {
		return substr($number, 0, 1) == '+' || substr($number, 0, 2) == '00' || substr($number, 0, 3) == '011';
	}
//	return substr($number, 0, 1) == '+' || substr($number, 0, 2) == '00' || substr($number, 0, 2) == '011';
}

function format_skype($number) {
    return preg_replace('/[^\+0-9]/','',$number);
}

function insert_charset_header() {
	header('Content-Type: text/html; charset=UTF-8');
}

function getCurrentURL()
{
	$href = "http:";
	if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	{
		$href = 'https:';
	}

	$href.= "//".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
	return $href;
}

function javascript_escape($str) {
	$new_str = '';

	for($i = 0; $i < strlen($str); $i++) {

		if(ord(substr($str, $i, 1))==10){
			$new_str .= '\n';
		}elseif(ord(substr($str, $i, 1))==13){
			$new_str .= '\r';
		}
		else {
			$new_str .= $str{$i};
		}
	}

	$new_str = str_replace("'", "\\'", $new_str);

	return $new_str;
}

function js_escape($str, $keep=true){
	$str = html_entity_decode(str_replace("\\", "", $str), ENT_QUOTES);

	if($keep){
		$str = javascript_escape($str);
	}
	else {
		$str = str_replace("'", " ", $str);
		$str = str_replace('"', " ", $str);
	}

	return $str;

	//end function js_escape
}

function br2nl($str) {
	$regex = "#<[^>]+br.+?>#";
	preg_match_all($regex, $str, $matches);

	foreach($matches[0] as $match) {
		$str = str_replace($match, "<br>", $str);
	}

	$brs = array('<br>','<br/>', '<br />');
	$str = str_replace("\r\n", "\n", $str); // make from windows-returns, *nix-returns
	$str = str_replace("\n\r", "\n", $str); // make from windows-returns, *nix-returns
	$str = str_replace("\r", "\n", $str); // make from windows-returns, *nix-returns
	$str = str_replace($brs, "\n", $str); // to retrieve it

	return $str;
}

/**
 * Private helper function for displaying the contents of a given variable.
 * This function is only intended to be used for SugarCRM internal development.
 * The ppd stands for Pre Print Die.
 */
function _ppd($mixed)
{














}


/**
 * Private helper function for displaying the contents of a given variable in
 * the Logger. This function is only intended to be used for SugarCRM internal
 * development. The pp stands for Pre Print.
 * @param $mixed var to print_r()
 * @param $die boolean end script flow
 * @param $displayStackTrace also show stack trace
 */
function _ppl($mixed, $die=false, $displayStackTrace=false, $loglevel="fatal") {

























}

/**
 * private helper function to quickly show the major, direct, field attributes of a given bean.
 * The ppf stands for Pre[formatted] Print Focus [object]
 * @param object bean The focus bean
 */
function _ppf($bean, $die=false) {




















}



/**
 * Private helper function for displaying the contents of a given variable.
 * This function is only intended to be used for SugarCRM internal development.
 * The pp stands for Pre Print.
 */
function _pp($mixed)
{











}

/**
 * Private helper function for displaying the contents of a given variable.
 * This function is only intended to be used for SugarCRM internal development.
 * The pp stands for Pre Print.
 */
function _pstack_trace($mixed=NULL)
{










}

/**
 * Private helper function for displaying the contents of a given variable.
 * This function is only intended to be used for SugarCRM internal development.
 * The pp stands for Pre Print Trace.
 */
function _ppt($mixed, $textOnly=false)
{






}

/**
 * Private helper function for displaying the contents of a given variable.
 * This function is only intended to be used for SugarCRM internal development.
 * The pp stands for Pre Print Trace Die.
 */
function _pptd($mixed)
{







}

/**
 * Private helper function for decoding javascript UTF8
 * This function is only intended to be used for SugarCRM internal development.
 */
function decodeJavascriptUTF8($str) {






}

/**
 * Will check if a given PHP version string is supported (tested on this ver),
 * unsupported (results unknown), or invalid (something will break on this
 * ver).  Do not pass in any pararameter to default to a check against the
 * current environment's PHP version.
 *
 * @return 1 implies supported, 0 implies unsupported, -1 implies invalid
 */
function check_php_version($sys_php_version = '') {
	$sys_php_version = empty($sys_php_version) ? constant('PHP_VERSION') : $sys_php_version;
	// versions below $min_considered_php_version considered invalid by default,
	// versions equal to or above this ver will be considered depending
	// on the rules that follow
	$min_considered_php_version = '5.2.1';

	// only the supported versions,
	// should be mutually exclusive with $invalid_php_versions
	$supported_php_versions = array (
	'5.2.1', '5.2.2', '5.2.3', '5.2.4', '5.2.5', '5.2.6', '5.2.8',
	);
	//Find out what Database the system is using.
	global $sugar_config;
	$dbType = '';
	if (isset($_REQUEST['setup_db_type'])) {
		$dbType = $_REQUEST['setup_db_type'];
	} else if (isset ($sugar_config['dbconfig']) && isset ($sugar_config['dbconfig']['db_type'])) {
		$dbType = $sugar_config['dbconfig']['db_type'];
	}

	// invalid versions above the $min_considered_php_version,
	// should be mutually exclusive with $supported_php_versions

	// SugarCRM prohibits install on PHP 5.1.x on all platforms 
	$invalid_php_versions = array('5.2.7');

	// default unsupported
	$retval = 0;

	// versions below $min_considered_php_version are invalid
	if(1 == version_compare($sys_php_version, $min_considered_php_version, '<')) {
		$retval = -1;
	}

	// supported version check overrides default unsupported
	foreach($supported_php_versions as $ver) {
		if(1 == version_compare($sys_php_version, $ver, 'eq') || strpos($sys_php_version,$ver) !== false) {
			$retval = 1;
			break;
		}
	}

	// invalid version check overrides default unsupported
	foreach($invalid_php_versions as $ver) {
		if(1 == version_compare($sys_php_version, $ver, 'eq') && strpos($sys_php_version,$ver) !== false) {
			$retval = -1;
			break;
		}
	}

    //allow a redhat distro to install, regardless of version.  We are assuming the redhat naming convention is followed
    //and the php version contains 'rh' characters
    if(strpos($sys_php_version, 'rh') !== false) {
        $retval = 1;
    }

	return $retval;
}

/**
 * Will check if a given IIS version string is supported (tested on this ver),
 * unsupported (results unknown), or invalid (something will break on this
 * ver).  
 *
 * @return 1 implies supported, 0 implies unsupported, -1 implies invalid
 */
function check_iis_version($sys_iis_version = '') {
	
	$server_software = $_SERVER["SERVER_SOFTWARE"];
	$iis_version = '';
	if(strpos($server_software,'Microsoft-IIS') !== false && preg_match_all("/^.*\/(\d+\.?\d*)$/",  $server_software, $out))
	    $iis_version = $out[1][0];	    
	
    $sys_iis_version = empty($sys_iis_version) ? $iis_version : $sys_iis_version;
    
    // versions below $min_considered_iis_version considered invalid by default,
    // versions equal to or above this ver will be considered depending
    // on the rules that follow
    $min_considered_iis_version = '6.0';

    // only the supported versions,
    // should be mutually exclusive with $invalid_iis_versions
    $supported_iis_versions = array ('6.0', '7.0',);
    $unsupported_iis_versions = array();
    $invalid_iis_versions = array('5.0',);

    // default unsupported
    $retval = 0;

    // versions below $min_considered_iis_version are invalid
    if(1 == version_compare($sys_iis_version, $min_considered_iis_version, '<')) {
        $retval = -1;
    }

    // supported version check overrides default unsupported
    foreach($supported_iis_versions as $ver) {
        if(1 == version_compare($sys_iis_version, $ver, 'eq') || strpos($sys_iis_version,$ver) !== false) {
            $retval = 1;
            break;
        }
    }

    // unsupported version check overrides default unsupported
    foreach($unsupported_iis_versions as $ver) {
        if(1 == version_compare($sys_iis_version, $ver, 'eq') && strpos($sys_iis_version,$ver) !== false) {
            $retval = 0;
            break;
        }
    }
    
    // invalid version check overrides default unsupported
    foreach($invalid_iis_versions as $ver) {
        if(1 == version_compare($sys_iis_version, $ver, 'eq') && strpos($sys_iis_version,$ver) !== false) {
            $retval = -1;
            break;
        }
    }    

    return $retval;
}

function pre_login_check(){
	global $action, $login_error;
	if(!empty($action)&& $action == 'Login'){

		if(!empty($login_error)){
			$login_error = htmlentities($login_error);
			$login_error = str_replace(array("&lt;pre&gt;","&lt;/pre&gt;","\r\n", "\n"), "<br>", $login_error);
			$_SESSION['login_error'] = $login_error;
			echo '<script>
						function set_focus() {}
						if(document.getElementById("post_error")) {
							document.getElementById("post_error").innerHTML="'. $login_error. '";
							document.getElementById("cant_login").value=1;
							document.getElementById("login_button").disabled = true;
							document.getElementById("user_name").disabled = true;
							//document.getElementById("user_password").disabled = true;
						}
						</script>';
		}
	}
}



function sugar_cleanup($exit = false) {
	static $called = false;
	if($called)return;
	$called = true;
	set_include_path(realpath(dirname(__FILE__) . '/..') . PATH_SEPARATOR . get_include_path());
	chdir(realpath(dirname(__FILE__) . '/..'));
	global $sugar_config;
	LogicHook::initialize();
	$GLOBALS['logic_hook']->call_custom_logic('', 'server_round_trip');

	//added this check to avoid errors during install.
	if (empty($sugar_config['dbconfig'])) {
		if ($exit) exit; else return;
	}
    
    if (!class_exists('Tracker', true)) {
		require_once 'modules/Trackers/Tracker.php';
	}
	Tracker::logPage();
	// Now write the cached tracker_queries






	if(!empty($GLOBALS['savePreferencesToDB']) && $GLOBALS['savePreferencesToDB']) {
		if (!class_exists('UserPreference', true)) {
			
		}
		UserPreference::savePreferencesToDB();
	}
		
	pre_login_check();
	if(class_exists('DBManagerFactory')) {
		$db = DBManagerFactory::getInstance();
		$db->disconnect();
		if($exit) {
			exit;
		}
	}
}

register_shutdown_function('sugar_cleanup');


/*
 check_logic_hook - checks to see if your custom logic is in the logic file
 if not, it will add it. If the file isn't built yet, it will create the file

 */
function check_logic_hook_file($module_name, $event, $action_array){
	require_once('include/utils/logic_utils.php');
	$add_logic = false;

	if(file_exists("custom/modules/$module_name/logic_hooks.php")){

		$hook_array = get_hook_array($module_name);

		if(check_existing_element($hook_array, $event, $action_array)==true){
			//the hook at hand is present, so do nothing
		} else {
			$add_logic = true;

			$logic_count = count($hook_array[$event]);
			if($action_array[0]==""){
				$action_array[0] = $logic_count  + 1;
			}
			$hook_array[$event][] = $action_array;

		}
		//end if the file exists already
	} else {
		$add_logic = true;
		if($action_array[0]==""){
			$action_array[0] = 1;
		}
		$hook_array = array();
		$hook_array[$event][] = $action_array;
		//end if else file exists already
	}
	if($add_logic == true){

		//reorder array by element[0]
		//$hook_array = reorder_array($hook_array, $event);
		//!!!Finish this above TODO

		$new_contents = replace_or_add_logic_type($hook_array);
		write_logic_file($module_name, $new_contents);

		//end if add_element is true
	}

	//end function check_logic_hook_file
}

function remove_logic_hook($module_name, $event, $action_array) {
    require_once('include/utils/logic_utils.php');
	$add_logic = false;

	if(file_exists("custom/modules/".$module_name."/logic_hooks.php")){
        // The file exists, let's make sure the hook is there
		$hook_array = get_hook_array($module_name);

		if(check_existing_element($hook_array, $event, $action_array)==true){
            // The hook is there, time to take it out.

            foreach ( $hook_array[$event] as $i => $hook ) {
                // We don't do a full comparison below just in case the filename changes
                if ( $hook[0] == $action_array[0] 
                     && $hook[1] == $action_array[1] 
                     && $hook[3] == $action_array[3] 
                     && $hook[4] == $action_array[4] ) {
                    unset($hook_array[$event][$i]);
                }
            }

            $new_contents = replace_or_add_logic_type($hook_array);
            write_logic_file($module_name, $new_contents);

        }        
    }
}

function display_stack_trace($textOnly=false){

	$stack  = debug_backtrace();

	echo "\n\n display_stack_trace caller, file: " . $stack[0]['file']. ' line#: ' .$stack[0]['line'];

	if(!$textOnly)
	echo '<br>';

	$first = true;
	$out = '';

	foreach($stack as $item) {
		$file  = '';
		$class = '';
		$line  = '';
		$function  = '';

		if(isset($item['file']))
		$file = $item['file'];
		if(isset($item['class']))
		$class = $item['class'];
		if(isset($item['line']))
		$line = $item['line'];
		if(isset($item['function']))
		$function = $item['function'];

		if(!$first) {
			if(!$textOnly) {
				$out .= '<font color="black"><b>';
			}

			$out .= $file;

			if(!$textOnly) {
				$out .= '</b></font><font color="blue">';
			}

			$out .= "[L:{$line}]";

			if(!$textOnly) {
				$out .= '</font><font color="red">';
			}

			$out .= "({$class}:{$function})";

			if(!$textOnly) {
				$out .= '</font><br>';
			} else {
				$out .= "\n";
			}
		} else {
			$first = false;
		}
	}

	echo $out;
}

function StackTraceErrorHandler($errno, $errstr, $errfile,$errline, $errcontext) {
	$error_msg = " $errstr occured in <b>$errfile</b> on line $errline [" . date("Y-m-d H:i:s") . ']';
	$halt_script = true;
	switch($errno){
		case 2048: return; //depricated we have lots of these ignore them
		case E_USER_NOTICE:
		case E_NOTICE:
			$halt_script = false;
			$type = 'Notice';
			break;
		case E_USER_WARNING:
		case E_COMPILE_WARNING:
		case E_CORE_WARNING:
		case E_WARNING:

			$halt_script = false;
			$type = "Warning";
			break;

		case E_USER_ERROR:
		case E_COMPILE_ERROR:
		case E_CORE_ERROR:
		case E_ERROR:

			$type = "Fatal Error";
			break;

		case E_PARSE:

			$type = "Parse Error";
			break;

		default:
			//don't know what it is might not be so bad
			$halt_script = false;
			$type = "Unknown Error ($errno)";
			break;
	}
	$error_msg = '<b>'.$type.'</b>:' . $error_msg;
	echo $error_msg;
	display_stack_trace();
	if($halt_script){
		exit -1;
	}



}


if(isset($sugar_config['stack_trace_errors']) && $sugar_config['stack_trace_errors']){

	set_error_handler('StackTraceErrorHandler');
}
function get_sub_cookies($name){
	$cookies = array();
	if(isset($_COOKIE[$name])){
		$subs = explode('#', $_COOKIE[$name]);
		foreach($subs as $cookie){
			if(!empty($cookie)){
				$cookie = explode('=', $cookie);

				$cookies[$cookie[0]] = $cookie[1];
			}
		}
	}
	return $cookies;

}


function mark_delete_components($sub_object_array, $run_second_level=false, $sub_sub_array=""){

	if(!empty($sub_object_array)){

		foreach($sub_object_array as $sub_object){

			//run_second level is set to true if you need to remove sub-sub components
			if($run_second_level==true){

				mark_delete_components($sub_object->get_linked_beans($sub_sub_array['rel_field'],$sub_sub_array['rel_module']));

				//end if run_second_level is true
			}
			$sub_object->mark_deleted($sub_object->id);
			//end foreach sub component
		}
		//end if this is not empty
	}

	//end function mark_delete_components
}

/**
 * For translating the php.ini memory values into bytes.  e.g. input value of '8M' will return 8388608.
 */
function return_bytes($val)
{
	$val = trim($val);
	$last = strtolower($val{strlen($val)-1});

	switch($last)
	{
		// The 'G' modifier is available since PHP 5.1.0
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}

	return $val;
}

/**
 * Adds the href HTML tags around any URL in the $string
 */
function url2html($string) {
	//
	$return_string = preg_replace('/(\w+:\/\/)(\S+)/', ' <a href="\\1\\2" target="_new"  style="font-weight: normal;">\\1\\2</a>', $string);
	return $return_string;
}
// End customization by Julian

/**
 * tries to determine whether the Host machine is a Windows machine
 */
function is_windows() {
    static $is_windows = null;
    if (!isset($is_windows)) {
        $is_windows = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN';
    }
    return $is_windows;
}

/**
 * equivalent for windows filesystem for PHP's is_writable()
 * @param string file Full path to the file/dir
 * @return bool true if writable
 */
function is_writable_windows($file) {
	if($file{strlen($file)-1}=='/') {
		return is_writable_windows($file.uniqid(mt_rand()).'.tmp');
	}

	// the assumption here is that Windows has an inherited permissions scheme
	// any file that is a descendant of an unwritable directory will inherit
	// that property and will trigger a failure below.
	if(is_dir($file)) {
		return true;
	}

	$file = str_replace("/", '\\', $file);

	if(file_exists($file)) {
		if (!($f = @sugar_fopen($file, 'r+')))
		return false;
		fclose($f);
		return true;
	}

	if(!($f = @sugar_fopen($file, 'w')))
	return false;
	fclose($f);
	unlink($file);
	return true;
}


/**
 * best guesses Timezone based on webserver's TZ settings
 */
function lookupTimezone($userOffset = 0){
	require_once('include/timezone/timezones.php');

	$defaultZones= array('America/New_York'=>1, 'America/Los_Angeles'=>1,'America/Chicago'=>1, 'America/Denver'=>1,'America/Anchorage'=>1, 'America/Phoenix'=>1, 'Europe/Amsterdam'=>1,'Europe/Athens'=>1,'Europe/London'=>1, 'Australia/Sydney'=>1, 'Australia/Perth'=>1);
	global $timezones;
	$serverOffset = date('Z');
	if(date('I')) {
		$serverOffset -= 3600;
	}
	if(!is_int($userOffset)) {
		return '';
	}
	$gmtOffset = $serverOffset/60 + $userOffset * 60;
	$selectedZone = ' ';
	foreach($timezones as $zoneName=>$zone) {

		if($zone['gmtOffset'] == $gmtOffset) {
			$selectedZone = $zoneName;
		}
		if(!empty($defaultZones[$selectedZone]) ) {
			return $selectedZone;
		}
	}
	return $selectedZone;
}

function convert_module_to_singular($module_array){
	global $beanList;

	foreach($module_array as $key => $value){
		if(!empty($beanList[$value])) $module_array[$key] = $beanList[$value];


		if($value=="Cases") $module_array[$key] = "Case";
		if($key=="projecttask"){
			$module_array['ProjectTask'] = "Project Task";
			unset($module_array[$key]);
		}
	}

	return $module_array;

	//end function convert_module_to_singular
}

/*
 * Given the bean_name which may be plural or singular return the singular
 * bean_name. This is important when you need to include files.
 */
function get_singular_bean_name($bean_name){
	global $beanFiles, $beanList;
	if(array_key_exists($bean_name, $beanList)){
		return $beanList[$bean_name];
	}
	else{
		return $bean_name;
	}
}

function get_label($label_tag, $temp_module_strings){
	global $app_strings;
	if(!empty($temp_module_strings[$label_tag])){

		$label_name = $temp_module_strings[$label_tag];
	} else {
		if(!empty($app_strings[$label_tag])){
			$label_name = $app_strings[$label_tag];
		} else {
			$label_name = $label_tag;
		}
	}
	return $label_name;

	//end function get_label
}


function search_filter_rel_info(& $focus, $tar_rel_module, $relationship_name){

	$rel_list = array();

	foreach($focus->relationship_fields as $rel_key => $rel_value){
		if($rel_value == $relationship_name){
			$temp_bean = get_module_info($tar_rel_module);
			echo $focus->$rel_key;
			$temp_bean->retrieve($focus->$rel_key);
			if($temp_bean->id!=""){

				$rel_list[] = $temp_bean;
				return $rel_list;
			}
		}
	}

	foreach($focus->field_defs as $field_name => $field_def){
		//Check if the relationship_name matches a "relate" field
		if(!empty($field_def['type']) && $field_def['type'] == 'relate' 
		&& !empty($field_def['id_name']) && !empty($focus->field_defs[$field_def['id_name']]) 
		&& !empty($focus->field_defs[$field_def['id_name']]['relationship'])
		&& $focus->field_defs[$field_def['id_name']]['relationship'] == $relationship_name)
		{
			$temp_bean = get_module_info($tar_rel_module);
			echo $focus->$field_def['id_name'];
			$temp_bean->retrieve($focus->$field_def['id_name']);
			if($temp_bean->id!=""){

				$rel_list[] = $temp_bean;
				return $rel_list;
			}
		//Check if the relationship_name matches a "link" in a relate field
		} else if(!empty($rel_value['link']) && !empty($rel_value['id_name']) && $rel_value['link'] == $relationship_name){
			$temp_bean = get_module_info($tar_rel_module);
			echo $focus->$rel_value['id_name'];
			$temp_bean->retrieve($focus->$rel_value['id_name']);
			if($temp_bean->id!=""){

				$rel_list[] = $temp_bean;
				return $rel_list;
			}
		}
	}
	return $rel_list;

	//end function search_filter_rel_info
}

function get_module_info($module_name){
	global $beanList;
	global $dictionary;

	//Get dictionary and focus data for module
	$vardef_name = $beanList[$module_name];

	if($vardef_name=="aCase"){
		$class_name = "Case";
	} else {
		$class_name = $vardef_name;
	}
	if(!file_exists('modules/'. $module_name . '/'.$class_name.'.php')){
		return;
	}

	include_once('modules/'. $module_name . '/'.$class_name.'.php');

	$module_bean = new $vardef_name();
	return $module_bean;
	//end function get_module_table
}

/**
 * In order to have one place to obtain the proper object name. aCase for example causes issues throughout the application.
 *
 * @param string $moduleName
 */
function get_valid_bean_name($module_name){
	global $beanList;

	$vardef_name = $beanList[$module_name];
	if($vardef_name=="aCase"){
		$bean_name = "Case";
	} else {
		$bean_name = $vardef_name;
	}
	return $bean_name;
}



function  checkAuthUserStatus(){

	//authUserStatus();
}


/**
 * This function returns an array of phpinfo() results that can be parsed and
 * used to figure out what version we run, what modules are compiled in, etc.
 * @param	$level			int		info level constant (1,2,4,8...64);
 * @return	$returnInfo		array	array of info about the PHP environment
 * @author	original by "code at adspeed dot com" Fron php.net
 * @author	customized for Sugar by Chris N.
 */
function getPhpInfo($level=-1) {
	/**	Name (constant)		Value	Description
		INFO_GENERAL		1		The configuration line, php.ini location, build date, Web Server, System and more.
		INFO_CREDITS		2		PHP Credits. See also phpcredits().
		INFO_CONFIGURATION	4		Current Local and Master values for PHP directives. See also ini_get().
		INFO_MODULES		8		Loaded modules and their respective settings. See also get_loaded_extensions().
		INFO_ENVIRONMENT	16		Environment Variable information that's also available in $_ENV.
		INFO_VARIABLES		32		Shows all predefined variables from EGPCS (Environment, GET, POST, Cookie, Server).
		INFO_LICENSE		64		PHP License information. See also the license FAQ.
		INFO_ALL			-1		Shows all of the above. This is the default value.
	 */
	ob_start();
	phpinfo($level);
	$phpinfo = ob_get_contents();
	ob_end_clean();

	$phpinfo	= strip_tags($phpinfo,'<h1><h2><th><td>');
	$phpinfo	= preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$phpinfo);
	$phpinfo	= preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$phpinfo);
	$parsedInfo	= preg_split('/(<h.?>[^<]+<\/h.>)/', $phpinfo, -1, PREG_SPLIT_DELIM_CAPTURE);
	$match		= '';
	$version	= '';
	$returnInfo	= array();

	if(preg_match('/<h1 class\=\"p\">PHP Version ([^<]+)<\/h1>/', $phpinfo, $version)) {
		$returnInfo['PHP Version'] = $version[1];
	}


	for ($i=1; $i<count($parsedInfo); $i++) {
		if (preg_match('/<h.>([^<]+)<\/h.>/', $parsedInfo[$i], $match)) {
			$vName = trim($match[1]);
			$parsedInfo2 = explode("\n",$parsedInfo[$i+1]);

			foreach ($parsedInfo2 AS $vOne) {
				$vPat	= '<info>([^<]+)<\/info>';
				$vPat3	= "/$vPat\s*$vPat\s*$vPat/";
				$vPat2	= "/$vPat\s*$vPat/";

				if (preg_match($vPat3,$vOne,$match)) { // 3cols
					$returnInfo[$vName][trim($match[1])] = array(trim($match[2]),trim($match[3]));
				} elseif (preg_match($vPat2,$vOne,$match)) { // 2cols
					$returnInfo[$vName][trim($match[1])] = trim($match[2]);
				}
			}
		} elseif(true) {

		}
	}

	return $returnInfo;
}

/**
 * This function will take a string that has tokens like {0}, {1} and will replace
 * those tokens with the args provided
 * @param	$format string to format
 * @param	$args args to replace
 * @return	$result a formatted string
 */
function string_format($format, $args){
	$result = $format;
	for($i = 0; $i < count($args); $i++){
		$result = str_replace('{'.$i.'}', $args[$i], $result);
	}
	return $result;
}

/**
 * Generate a string for displaying a unique identifier that is composed
 * of a system_id and number.  This is use to allow us to generate quote
 * numbers using a DB auto-increment key from offline clients and still
 * have the number be unique (since it is modified by the system_id.
 *
 * @param	$num of bean
 * @param	$system_id from system
 * @return	$result a formatted string
 */
function format_number_display($num, $system_id){
	global $sugar_config;
	if(isset($num) && !empty($num)){
		$num=unformat_number($num);
		if(isset($system_id) && $system_id == 1){
			return sprintf("%d", $num);
		}
		else{
			return sprintf("%d-%d", $num, $system_id);
		}
	}
}
function checkLoginUserStatus(){
}

/**
 * This function will take a number and system_id and format
 * @param	$url URL containing host to append port
 * @param	$port the port number - if '' is passed, no change to url
 * @return	$resulturl the new URL with the port appended to the host
 */
function appendPortToHost($url, $port)
{
	$resulturl = $url;

	// if no port, don't change the url
	if($port != '')
	{
		$split = explode("/", $url);
		//check if it starts with http, in case they didn't include that in url
		if(str_begin($url, 'http'))
		{
			//third index ($split[2]) will be the host
			$split[2] .= ":".$port;
		}
		else // otherwise assumed to start with host name
		{
			//first index ($split[0]) will be the host
			$split[0] .= ":".$port;
		}

		$resulturl = implode("/", $split);
	}

	return $resulturl;
}

/**
 * Singleton to return JSON object
 * @return	JSON object
 */
function getJSONobj() {
	static $json = null;
	if(!isset($json)) {
		require_once('include/JSON.php');
		$json = new JSON(JSON_LOOSE_TYPE);
	}
	return $json;
}

require_once('include/utils/db_utils.php');
require_once('include/utils/user_utils.php');
//check to see if custom utils exists
if(file_exists('custom/include/custom_utils.php')){
	include_once('custom/include/custom_utils.php');
}


/**
 * Set default php.ini settings for entry points
 */
function setPhpIniSettings() {
	// zlib module
	if(function_exists('gzclose') && headers_sent() == false) {
		ini_set('zlib.output_compression', 1);
	}
	// mbstring module
	//nsingh: breaks zip/unzip functionality. Commenting out 4/23/08

	/*if(function_exists('mb_strlen')) {
		ini_set('mbstring.func_overload', 7);
		ini_set('mbstring.internal_encoding', 'UTF-8');
	}*/


	// http://us3.php.net/manual/en/ref.pcre.php#ini.pcre.backtrack-limit
	// starting with 5.2.0, backtrack_limit breaks JSON decoding
	$backtrack_limit = ini_get('pcre.backtrack_limit');
	if(!empty($backtrack_limit)) {
		ini_set('pcre.backtrack_limit', '-1');
	}

	// mssql only
	if(ini_get("mssql.charset")) {
		ini_set('mssql.charset', "UTF-8");
	}
}

/**
 * like array_merge() but will handle array elements that are themselves arrays;
 * PHP's version just overwrites the element with the new one.
 *
 * @internal Note that this function deviates from the internal array_merge()
 *           functions in that it does does not treat numeric keys differently
 *           than string keys.  Additionally, it deviates from
 *           array_merge_recursive() by not creating an array when like values
 *           found.
 *
 * @param array gimp the array whose values will be overloaded
 * @param array dom the array whose values will pwn the gimp's
 * @return array beaten gimp
 */
function sugarArrayMerge($gimp, $dom) {
	if(is_array($gimp) && is_array($dom)) {
		foreach($dom as $domKey => $domVal) {
			if(array_key_exists($domKey, $gimp)) {
				if(is_array($domVal)) {
					$tempArr = array();
                    foreach ( $domVal as $domArrKey => $domArrVal )
                        $tempArr[$domArrKey] = $domArrVal;
                    foreach ( $gimp[$domKey] as $gimpArrKey => $gimpArrVal )
                        if ( !array_key_exists($gimpArrKey, $tempArr) )
                            $tempArr[$gimpArrKey] = $gimpArrVal;
                    $gimp[$domKey] = $tempArr;
				} else {
					$gimp[$domKey] = $domVal;
				}
			} else {
				$gimp[$domKey] = $domVal;
			}
		}
	}
    // if the passed value for gimp isn't an array, then return the $dom
    elseif(is_array($dom))
        return $dom;
    
	return $gimp;
}

/**
 * Similiar to sugarArrayMerge except arrays of N depth are merged.
 *
 * @param array gimp the array whose values will be overloaded
 * @param array dom the array whose values will pwn the gimp's
 * @return array beaten gimp
 */
function sugarArrayMergeRecursive($gimp, $dom) {
	if(is_array($gimp) && is_array($dom)) {
		foreach($dom as $domKey => $domVal) {
			if(array_key_exists($domKey, $gimp)) {
				if(is_array($domVal) && is_array($gimp[$domKey])) {
					$gimp[$domKey] = sugarArrayMergeRecursive($gimp[$domKey], $domVal);
				} else {
					$gimp[$domKey] = $domVal;
				}
			} else {
				$gimp[$domKey] = $domVal;
			}
		}
	}
    // if the passed value for gimp isn't an array, then return the $dom
    elseif(is_array($dom))
        return $dom;
    
	return $gimp;
}

/**
 * finds the correctly working versions of PHP-JSON
 * @return bool True if NOT found or WRONG version
 */
function returnPhpJsonStatus() {
	$goodVersions = array('1.1.1',);

	if(function_exists('json_encode')) {
		$phpInfo = getPhpInfo(8);

		if(!in_array($phpInfo['json']['json version'], $goodVersions)) {
			return true; // bad version found
		} else {
			return false; // all requirements met
		}
	}
	return true; // not found
}


/**
 * returns a 20-char or less string for the Tracker to display in the header
 * @param string name field for a given Object
 * @return string 20-char or less name
 */
function getTrackerSubstring($name) {
	$strlen = function_exists('mb_strlen') ? mb_strlen($name) : strlen($name);

	if($strlen > 20) {
		$chopped = function_exists('mb_substr') ? mb_substr($name, 0, 15) : substr($name, 0, 15);
	} else {
		$chopped = $name;
	}

	return $chopped;
}
function generate_search_where ($field_list=array(),$values=array(),&$bean,$add_custom_fields=false,$module='') {
	$where_clauses= array();
	$like_char='%';
	$table_name=$bean->object_name;
	foreach ($field_list[$module] as $field=>$parms) {
		if(isset($values[$field]) && $values[$field] != "") {
			$operator='like';
			if (!empty($parms['operator'])) {
				$operator=$parms['operator'];
			}
			if (is_array($values[$field])) {
				$operator='in';
				$field_value='';
				foreach ($values[$field] as $key => $val) {
					if ($val != ' ' and $val != '') {
						if (!empty($field_value)) {
							$field_value.=',';
						}
						$field_value .= "'".$GLOBALS['db']->quote($val)."'";
					}
				}
			} else {
				$field_value=$GLOBALS['db']->quote($values[$field]);
			}
			//set db_fields array.
			if (!isset($parms['db_field']) )  {
				$parms['db_field'] = array($field);
			}
			if (isset($parms['my_items']) and $parms['my_items'] == true) {
				global $current_user;
				$field_value = $GLOBALS['db']->quote($current_user->id);
				$operator='=';
			}

			$where='';
			$itr=0;
			if ($field_value != '') {

				foreach ($parms['db_field'] as $db_field) {
					if (strstr($db_field,'.')===false) {
						$db_field=$bean->table_name.".".$db_field;
					}
					if ($GLOBALS['db']->dbType=='oci8' &&  isset($parms['query_type']) && $parms['query_type']=='case_insensitive') {
						$db_field='upper('.$db_field.")";
						$field_value=strtoupper($field_value);
					}

					$itr++;
					if (!empty($where)) {
						$where .= " OR ";
					}
					switch (strtolower($operator)) {
						case 'like' :
							$where .=  $db_field . " like '".$field_value.$like_char."'";
							break;
						case 'in':
							$where .=  $db_field . " in (".$field_value.')';
							break;
						case '=':
							$where .=  $db_field . " = '".$field_value ."'";
							break;
					}
				}
			}
			if (!empty($where)) {
				if ($itr>1) {
					array_push($where_clauses, '( '.$where.' )');
				} else {
					array_push($where_clauses, $where);
				}
			}
		}
	}
	if ($add_custom_fields) {
		require_once('modules/DynamicFields/DynamicField.php');
		$bean->setupCustomFields($module);
		$bean->custom_fields->setWhereClauses($where_clauses);
	}
	return $where_clauses;
}

function add_quotes($str) {
	return "'{$str}'";
}

/**
 * This function will rebuild the config file
 * @param	$sugar_config
 * @param	$sugar_version
 * @return	bool true if successful
 */
function rebuildConfigFile($sugar_config, $sugar_version) {
	// add defaults to missing values of in-memory sugar_config
	$sugar_config = sugarArrayMerge(get_sugar_config_defaults(), $sugar_config );

	// need to override version with default no matter what
	$sugar_config['sugar_version'] = $sugar_version;

	ksort( $sugar_config );

	if( write_array_to_file( "sugar_config", $sugar_config, "config.php" ) ){
		return true;
	}
	else {
		return false;
	}
}

/**
 * getJavascriptSiteURL
 * This function returns a URL for the client javascript calls to access
 * the site.  It uses $_SERVER['HTTP_REFERER'] in the event that Proxy servers
 * are used to access the site.  Thus, the hostname in the URL returned may
 * not always match that of $sugar_config['site_url'].  Basically, the
 * assumption is that however the user accessed the website is how they
 * will continue to with subsequent javascript requests.  If the variable
 * $_SERVER['HTTP_REFERER'] is not found then we default to old algorithm.
 * @return $site_url The url used to refer to the website
 */
function getJavascriptSiteURL() {
	global $sugar_config;
	if(!empty($_SERVER['HTTP_REFERER'])) {
		$url = parse_url($_SERVER['HTTP_REFERER']);
		$replacement_url = $url['scheme']."://".$url['host'];
		if(!empty($url['port']))
		$replacement_url .= ':'.$url['port'];
		$site_url = preg_replace('/^http[s]?\:\/\/[^\/]+/',$replacement_url,$sugar_config['site_url']);
	} else {
		$site_url = preg_replace('/^http(s)?\:\/\/[^\/]+/',"http$1://".$_SERVER['HTTP_HOST'],$sugar_config['site_url']);
		if(!empty($_SERVER['SERVER_PORT']) &&$_SERVER['SERVER_PORT'] == '443') {
			$site_url = preg_replace('/^http\:/','https:',$site_url);
		}
	}
	$GLOBALS['log']->debug("getJavascriptSiteURL(), site_url=".  $site_url);
	return $site_url;
}

// works nicely with array_map() -- can be used to wrap single quotes around each element in an array
function add_squotes($str) {
	return "'" . $str . "'";
}


// recursive function to count the number of levels within an array
function array_depth($array, $depth_count=-1, $depth_array=array()){
	$depth_count++;
	if (is_array($array)){
		foreach ($array as $key => $value){
			$depth_array[] = array_depth($value, $depth_count);
		}
	}
	else{
		return $depth_count;
	}
	foreach ($depth_array as $value){
		$depth_count = $value > $depth_count ? $value : $depth_count;
	}
	return $depth_count;
}

/**
 * Creates a new Group User
 * @param string $name Name of Group User
 * @return string GUID of new Group User
 */
function createGroupUser($name) {
	

	$group = new User();
	$group->user_name	= $name;
	$group->last_name	= $name;
	$group->is_group	= 1;
	$group->deleted		= 0;
	$group->status		= 'Active'; // cn: bug 6711
	$timezone = lookupTimezone();
	$group->setPreference('timezone', $timezone);
	$group->save();

	return $group->id;
}

/*
 * Helper function to locate an icon file given only a name
 * Searches through the various paths for the file
 * @param string iconFileName   The filename of the icon
 * @return string Relative pathname of the located icon, or '' if not found
 */

function _getIcon($iconFileName)
{
    $iconPath = SugarThemeRegistry::current()->getImageURL("icon_{$iconFileName}.gif");
    if ( empty($iconPath) )
        $iconPath = SugarThemeRegistry::current()->getImageURL("{$iconFileName}.gif");
    
  	return $iconPath;
}
/**
 * Function to grab the correct icon image for Studio
 * @param string $iconFileName Name of the icon file
 * @param string $altfilename Name of a fallback icon file (displayed if the imagefilename doesn't exist)
 * @param string $width Width of image
 * @param string $height Height of image
 * @param string $align Alignment of image
 * @return string $string <img> tag with corresponding image
 */

function getStudioIcon($iconFileName='', $altFileName='', $width='48', $height='48', $align='baseline' )
{
	global $app_strings, $theme;

    $iconPath = _getIcon($iconFileName);
 	if(empty($iconPath)){
 	    $iconPath = _getIcon($altFileName);
 	    if (empty($iconPath))
 	    {
            return $app_strings['LBL_NO_IMAGE'];
 	    }
 	}
	return '<img border="0" src="'.$iconPath.'" width="'.$width.'" height="'.$height.'" align="'.$align.'">';
}

/**
 * Function to grab the correct icon image for Dashlets Dialog
 * @param string $filename Location of the icon file
 * @param string $module Name of the module to fall back onto if file does not exist
 * @param string $width Width of image
 * @param string $height Height of image
 * @param string $align Alignment of image
 * @return string $string <img> tag with corresponding image
 */

function get_dashlets_dialog_icon($module='', $width='32', $height='32', $align='absmiddle'){
	global $app_strings, $theme;
 	$icon_path = _getIcon($module . "_32");
 	if (empty($icon_path))
 	{
 		$icon_path = _getIcon($module);
 	}
 	if(empty($icon_path)){
 		$icon = $app_strings['LBL_NO_IMAGE'];
 	}
	else{
		$icon = '<img border="0" src="'.$icon_path.'" width="'.$width.'" height="'.$height.'" align="'.$align.'">';
	}
	return $icon;
}

// works nicely to change UTF8 strings that are html entities - good for PDF conversions
function html_entity_decode_utf8($string)
{
    static $trans_tbl;
    // replace numeric entities
    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'code2utf(hexdec("\\1"))', $string);
    $string = preg_replace('~&#([0-9]+);~e', 'code2utf(\\1)', $string);
    // replace literal entities
    if (!isset($trans_tbl))
    {
        $trans_tbl = array();
        foreach (get_html_translation_table(HTML_ENTITIES) as $val=>$key)
            $trans_tbl[$key] = utf8_encode($val);
    }
    return strtr($string, $trans_tbl);
}

// Returns the utf string corresponding to the unicode value
function code2utf($num)
{
    if ($num < 128) return chr($num);
    if ($num < 2048) return chr(($num >> 6) + 192) . chr(($num & 63) + 128);
    if ($num < 65536) return chr(($num >> 12) + 224) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
    if ($num < 2097152) return chr(($num >> 18) + 240) . chr((($num >> 12) & 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
    return '';
}

function str_split_php4($string, $length = 1) {
	$string_length = strlen($string);
	$return = array();
	$cursor = 0;
	if ($length > $string_length) {
		// use the string_length as the string is shorter than the length
		$length = $string_length;
	}
	for ($cursor = 0; $cursor < $string_length; $cursor = $cursor + $length) {
		$return[] = substr($string, $cursor, $length);
	}
	return $return;
}

if (version_compare(phpversion(), '5.0.0', '<')) {
	function str_split($string, $length = 1) {
		return str_split_php4($string, $length);
	}
}

/*
 * Invoked when connected to mssql. checks if we have freetds version of mssql library.
 * the response is put into a global variable.
 */
function is_freetds() {

	$ret=false;
	if (isset($GLOBALS['mssql_library_version'])) {
		if ($GLOBALS['mssql_library_version']=='freetds') {
			$ret=true;
		} else {
			$ret=false;
		}
	} else {
		ob_start();
		phpinfo();
		$info=ob_get_contents();
		ob_end_clean();

		if (strpos($info,'FreeTDS') !== false) {
			$GLOBALS['mssql_library_version']='freetds';
			$ret=true;
		} else {
			$GLOBALS['mssql_library_version']='regular';
			$ret=false;
		}
	}
	return $ret;
}

/*
 *  stripos - Find position of first occurrence of a case-insensitive string
 *
 *  The function is being defined for systems with PHP version < 5.
 *
 */
if (!function_exists("stripos")){
	function stripos($haystack,$needle,$offset=0){
      return strpos(strtolower($haystack),strtolower($needle),$offset);
	}
}

/**
 * Chart dashlet helper function that returns the correct CSS file, dependent on the current theme.
 *
 * @todo this won't work completely right until we impliment css compression and combination
 *       for now, we'll just include the last css file found.
 *
 * @return chart.css file to use
 */
function chartStyle()
{
    return SugarThemeRegistry::current()->getCSSURL('chart.css');
}

/**
 * Chart dashlet helper functions that returns the correct XML color file for charts, 
 * dependent on the current theme.
 *
 * @return sugarColors.xml to use
 */
function chartColors()
{
	if (SugarThemeRegistry::current()->getCSSURL('sugarColors.xml')=='')
	return SugarThemeRegistry::current()->getImageURL('sugarColors.xml');
    return SugarThemeRegistry::current()->getCSSURL('sugarColors.xml');
}
/* End Chart Dashlet helper functions */

/**
 * This function is designed to set up the php enviroment
 * for AJAX requests.
 */

function ajaxInit() {
	ini_set('display_errors', 'false');
}

/**
 * Returns an absolute path from the given path, determining if it is relative or absolute
 *
 * @param  string $path
 * @return string
 */
function getAbsolutePath(
    $path,
    $currentServer = false
    )
{
    $path = trim($path);

    // try to match absolute paths like \\server\share, /directory or c:\
    if ( ( substr($path,0,2) == '\\\\' )
            || ( $path[0] == '/' )
            || preg_match('/^[A-z]:/i',$path)
            || $currentServer )
        return $path;

    return getcwd().'/'.$path;
}

/**
 * Returns the bean object of the given module
 *
 * @param  string $module
 * @return object
 */
function loadBean(
    $module
    )
{
    global $beanList, $beanFiles;
    
    if ( !isset($beanList) || !isset($beanFiles) )
        require('include/modules.php');

    if ( isset($beanList[$module]) ) {
        $bean = $beanList[$module];
        if(isset($beanFiles[$bean])){
        	require_once($beanFiles[$bean]);
        	$focus = new $bean();
        }else {
        	return false;
    	}
    }
    else {
        return false;
    }

    return $focus;
}


































































/**
 * Returns the shortcut keys to access the shortcut links.  Shortcut
 * keys vary depending on browser versions and operating systems.
 * @return String value of the shortcut keys
 */
function get_alt_hot_key() {
	$ua = '';
    if ( isset($_SERVER['HTTP_USER_AGENT']) )
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	$isMac = strpos($ua, 'mac') !== false;
	$isLinux = strpos($ua, 'linux') !== false;
	
	if(!$isMac && !$isLinux && strpos($ua, 'mozilla') !== false) {
	   if(preg_match('/firefox\/(\d)?\./', $ua, $matches)) {
	   	  return $matches[1] < 2 ? 'Alt+' : 'Alt+Shift+';
	   }
	}
	return $isMac ? 'Ctrl+' : 'Alt+';
}

function can_start_session(){
	if(!empty($_GET['PHPSESSID'])) {
	   return true;
	}
	$session_id = session_id();
	return empty($session_id) ? true : false;
}

function load_link_class($properties){
	$class = 'Link';
	if(!empty($properties['link_class']) && !empty($properties['link_file'])){
    	require_once($properties['link_file']);
    	$class = $properties['link_class'];
    }
    return $class;
}








function inDeveloperMode()
{
    return isset($GLOBALS['sugar_config']['developerMode']) && $GLOBALS['sugar_config']['developerMode'];
}

/**
 * The function is used because currently we are not supporting mbstring.func_overload
 * For some user using mssql without FreeTDS, they may store multibyte charaters in varchar using latin_general collation. It cannot store so many mutilbyte characters, so we need to use strlen.
 * The varchar in MySQL, Orcale, and nvarchar in FreeTDS, we can store $length mutilbyte charaters in it. we need mb_substr to keep more info.
* @returns the substred strings.
 */
function sugar_substr($string, $length, $charset='UTF-8') {
    if($GLOBALS['db']->dbType == 'mssql' && empty($GLOBALS['db']->isFreeTDS)) {
        if(strlen($string) > $length) {
            $string = trim(substr(trim($string),0,$length));
        }
    }
    else {
        if(mb_strlen($string,$charset) > $length) {
            $string = trim(mb_substr(trim($string),0,$length,$charset));
        }
    }
    return $string;
}

/**
 * The function is used because on FastCGI enviroment, the ucfirst(Chinese Characters) will produce bad charcters.
 * This will work even without setting the mbstring.*encoding
 */
function sugar_ucfirst($string, $charset='UTF-8') {
    return mb_strtoupper(mb_substr($string, 0, 1, $charset), $charset) . mb_substr($string, 1, mb_strlen($string), $charset);
}


/**
 * 
 */
function unencodeMultienum($string) {
	if (is_array($string))
	{
	   return $string;	
	}
	if (substr($string, 0 ,1) == "^" && substr($string, -1) == "^") {
          $string = substr(substr($string, 1), 0, strlen($string) -2);
	}
	
	return explode('^,^', $string);
}

function encodeMultienumValue($arr) {
    if (!is_array($arr))
        return $arr;
        
    if (empty($arr))
        return "";
        
	$string = "^" . implode('^,^', $arr) . "^";
    
    return $string;
}

/**
 * create_export_query is used for export and massupdate
 * We haven't handle the these fields: $field['type'] == 'relate' && isset($field['link']
 * This function will correct the where clause and output necessary join condition for them
 * @param $module: the module name
 * @param $searchFields: searchFields which is got after $searchForm->populateFromArray()
 * @param $where: where clauses
 * @return $ret_array['where']: corrected where clause
 * @return $ret_array['join']: extra join condition
 */
function create_export_query_relate_link_patch($module, $searchFields, $where){
	if(file_exists('modules/'.$module.'/SearchForm.html')){
		$ret_array['where'] = $where;
		return $ret_array;
	}
	$seed = loadBean($module);
    foreach($seed->field_defs as $name=>$field)
	{

		if( $field['type'] == 'relate' && isset($field['link']) && !empty($searchFields[$name]['value']) ){
			$seed->load_relationship($field['link']);
			$params = array();
			if(empty($join_type))
			{
				$params['join_type'] = ' LEFT JOIN ';
			}
			else
			{
				$params['join_type'] = $join_type;
			}
			if(isset($data['join_name']))
			{
				$params['join_table_alias'] = $field['join_name'];
			}
			else
			{
				$params['join_table_alias']	= 'join_'.$field['name'];
			
			}
			if(isset($data['join_link_name']))
			{
				$params['join_table_link_alias'] = $field['join_link_name'];
			}
			else
			{
				$params['join_table_link_alias'] = 'join_link_'.$field['name'];
			}
			$join = $seed->$field['link']->getJoin($params, true);
			$join_table_alias = 'join_'.$field['name'];
			if(isset($field['db_concat_fields'])){
				$db_field = db_concat($join_table_alias, $field['db_concat_fields']);
				$where = preg_replace('/'.$field['name'].'/', $db_field, $where);
			}else{
				$where = preg_replace('/(^|[\s(])' . $field['name'] . '/', '${1}' . $join_table_alias . '.'.$field['rname'], $where);
			}
		}
	}
	$ret_array = array('where'=>$where, 'join'=>$join['join']);
	return $ret_array;
}

/**
  * We need to clear all the js cache files, including the js language files  in serval places in MB. So I extract them into a util function here.
  * @Depends on QuickRepairAndRebuild.php
  * @Relate bug 30642  ,23177
  */
function clearAllJsAndJsLangFilesWithoutOutput(){
		global $current_language , $mod_strings;
		$MBmodStrings = $mod_strings;
        $mod_strings = return_module_language ( $current_language, 'Administration' ) ;
        include_once ('modules/Administration/QuickRepairAndRebuild.php') ;
        $repair = new RepairAndClear();
        $repair->module_list = array();
		$repair->show_output = false;
		$repair->clearJsLangFiles();    		
		$repair->clearJsFiles();
		$mod_strings = $MBmodStrings;
}

/**
 * Given a version such as 5.5.0RC1 return RC. If we have a version such as: 5.5 then return GA
 *
 * @param string $version
 * @return string RC, BETA, GA
 */
function getVersionStatus($version){
	if(preg_match('/^[\d\.]+?([a-zA-Z]+?)[\d]*?$/si', $version, $matches)) {
		return strtoupper($matches[1]);
	}else{
		return 'GA';
	}
}

/**
 * Return the numeric portion of a version. For example if passed 5.5.0RC1 then return 5.5. If given
 * 5.5.1RC1 then return 5.5.1
 *
 * @param string $version
 * @return version
 */
function getMajorMinorVersion($version){
	if(preg_match('/^([\d\.]+).*$/si', $version, $matches2)){
		$version = $matches2[1];
		$arr = split('\.', $version);
		if(count($arr) > 2){
			if($arr[2] == '0'){
				$version = substr($version, 0, 3);
			}
		}
	}
	return $version;
}
?>
