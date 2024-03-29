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

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



if(!is_admin($current_user)){
    sugar_die('Admin Only');
}
function clearPasswordSettings() {
	    $_POST['passwordsetting_SystemGeneratedPasswordON'] = '';
	    $_POST['passwordsetting_generatepasswordtmpl'] = '';
	    $_POST['passwordsetting_lostpasswordtmpl'] = '';
	    $_POST['passwordsetting_forgotpasswordON'] = '0';
	    $_POST['passwordsetting_linkexpiration'] = '1';
	    $_POST['passwordsetting_linkexpirationtime'] = '30';
	    $_POST['passwordsetting_linkexpirationtype'] = '1';
	    $_POST['passwordsetting_systexpiration'] = '0';
	    $_POST['passwordsetting_systexpirationtime'] = '';
	    $_POST['passwordsetting_systexpirationtype'] = '0';
	    $_POST['passwordsetting_systexpirationlogin'] = '';



















}
require_once('modules/Administration/Forms.php');
echo get_module_title(
                $mod_strings['LBL_MODULE_NAME'], 
                $mod_strings['LBL_MANAGE_PASSWORD_TITLE'], 
                true
                );
require_once('modules/Configurator/Configurator.php');
$configurator = new Configurator();
$sugarConfig = SugarConfig::getInstance();
$focus = new Administration();
$configurator->parseLoggerSettings();
$valid_public_key= true;
if(!empty($_POST['saveConfig'])){
    if ($_POST['captcha_on'] == '1'){
		$handle = @fopen("http://api.recaptcha.net/challenge?k=".$_POST['captcha_public_key']."&cachestop=35235354", "r");
		$buffer ='';
		if ($handle) {
		    while (!feof($handle)) {
		        $buffer .= fgets($handle, 4096);
		    }
		    fclose($handle);
		}
		$valid_public_key= substr($buffer, 1, 4) == 'var '? true : false;
	}
	if ($valid_public_key){
		if (isset($_REQUEST['system_ldap_enabled']) && $_REQUEST['system_ldap_enabled'] == 'on') {
			$_POST['system_ldap_enabled'] = 1;
			clearPasswordSettings();
		}
		else 
			$_POST['system_ldap_enabled'] = 0;

		if (isset($_REQUEST['ldap_group_checkbox']) && $_REQUEST['ldap_group_checkbox'] == 'on') 
			$_POST['ldap_group'] = 1;
		else
			$_POST['ldap_group'] = 0;
			
		if (isset($_REQUEST['ldap_authentication_checkbox']) && $_REQUEST['ldap_authentication_checkbox'] == 'on') 
			$_POST['ldap_authentication'] = 1;
		else
			$_POST['ldap_authentication'] = 0;
		
		$configurator->saveConfig();
		$focus->saveConfig();
		header('Location: index.php?module=Administration&action=index');
	}
}

$focus->retrieveSettings();


require_once('include/SugarLogger/SugarLogger.php');
$sugar_smarty = new Sugar_Smarty();

// if no IMAP libraries available, disable Save/Test Settings
if(!function_exists('imap_open')) $sugar_smarty->assign('IE_DISABLED', 'DISABLED');

$config_strings=return_module_language($GLOBALS['current_language'],'Configurator');
$sugar_smarty->assign('CONF', $config_strings);
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('config', $configurator->config);
$sugar_smarty->assign('error', $configurator->errors);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("settings", $focus->settings);

if(!function_exists('mcrypt_cbc')){
	$sugar_smarty->assign("LDAP_ENC_KEY_READONLY", 'readonly');
	$sugar_smarty->assign("LDAP_ENC_KEY_DESC", $config_strings['LDAP_ENC_KEY_NO_FUNC_DESC']);
}else{
	$sugar_smarty->assign("LDAP_ENC_KEY_DESC", $config_strings['LBL_LDAP_ENC_KEY_DESC']);
}
$sugar_smarty->assign("settings", $focus->settings);

if ($valid_public_key){
	if(!empty($focus->settings['captcha_on'])){
		$sugar_smarty->assign("CAPTCHA_CONFIG_DISPLAY", 'inline');
	}else{
		$sugar_smarty->assign("CAPTCHA_CONFIG_DISPLAY", 'none');
	}
}else{
	$sugar_smarty->assign("CAPTCHA_CONFIG_DISPLAY", 'inline');
}
$sugar_smarty->assign("VALID_PUBLIC_KEY", $valid_public_key);

	

$res=$GLOBALS['sugar_config']['passwordsetting'];


require_once('include/SugarPHPMailer.php');   
$mail = new SugarPHPMailer();
$mail->setMailerForSystem();
if($mail->Mailer == 'smtp' && $mail->Host ==''){
	$sugar_smarty->assign("SMTP_SERVER_NOT_SET", '1');
	}
else
	$sugar_smarty->assign("SMTP_SERVER_NOT_SET", '0');
	
$focus = new InboundEmail();
$focus->checkImap();
$storedOptions = unserialize(base64_decode($focus->stored_options));	
$email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name', '','name',true);
$create_case_email_template = (isset($storedOptions['create_case_email_template'])) ? $storedOptions['create_case_email_template'] : "";
$TMPL_DRPDWN_LOST =get_select_options_with_id($email_templates_arr, $res['lostpasswordtmpl']); 
$TMPL_DRPDWN_GENERATE =get_select_options_with_id($email_templates_arr, $res['generatepasswordtmpl']);

$sugar_smarty->assign("TMPL_DRPDWN_LOST", $TMPL_DRPDWN_LOST);
$sugar_smarty->assign("TMPL_DRPDWN_GENERATE", $TMPL_DRPDWN_GENERATE);





$sugar_smarty->display('modules/Administration/PasswordManager.tpl');
?>
