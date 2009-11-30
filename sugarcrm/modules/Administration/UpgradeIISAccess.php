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
global $sugar_config;

$setup_site_log_dir  = isset($_SESSION['setup_site_custom_log_dir']) ? $_SESSION['setup_site_log_dir'] : '.';
$setup_site_log_file = 'sugarcrm.log';  // may be an option later
require_once('include/domit/xml_domit_include.php');
$uploadDir='';
$uploadHta='';

if (empty($GLOBALS['sugar_config']['upload_dir'])) {
    $GLOBALS['sugar_config']['upload_dir']='cache/upload/';
}
   
$prefix = $setup_site_log_dir.empty($setup_site_log_dir)?'':'/';

$config_array = array(
array('1'=> $prefix.str_replace('.','\\.',$setup_site_log_file).'\\.*' ,'2'=>'log_file_restricted.html'),
array('1'=> $prefix.'install.log' ,'2'=>'log_file_restricted.html'),
array('1'=> $prefix.'upgradeWizard.log' ,'2'=>'log_file_restricted.html'),
array('1'=> $prefix.'emailman.log' ,'2'=>'log_file_restricted.html'),
array('1'=>'not_imported_.*.txt' ,'2'=>'log_file_restricted.html'),
array('1'=>'XTemplate/(.*)/(.*).php' ,'2'=>'index.php'),
array('1'=>'data/(.*).php' ,'2'=>'index.php'),
array('1'=>'examples/(.*).php' ,'2'=>'index.php'),
array('1'=>'include/(.*).php' ,'2'=>'index.php'),
array('1'=>'include/(.*)/(.*).php' ,'2'=>'index.php'),
array('1'=>'log4php/(.*).php' ,'2'=>'index.php'),
array('1'=>'log4php/(.*)/(.*)' ,'2'=>'index.php'),
array('1'=>'metadata/(.*)/(.*).php' ,'2'=>'index.php'),
array('1'=>'modules/(.*)/(.*).php' ,'2'=>'index.php'),
array('1'=>'soap/(.*).php' ,'2'=>'index.php'),
array('1'=>'emailmandelivery.php' ,'2'=>'index.php'),
array('1'=>'cron.php' ,'2'=>'index.php'),
array('1'=> $sugar_config['upload_dir'].'.*' ,'2'=>'index.php'),
);

$xmldoc = new DOMIT_Document(); 

//var_dump($config_array);

//create XML declaration
$xmlDecl = $xmldoc->createProcessingInstruction('xml', 'version="1.0" encoding="UTF-8"');
$xmldoc->appendChild($xmlDecl);
$rootElement = $xmldoc->createElement('configuration');
$xmldoc->appendChild($rootElement);
$system_webserver = $xmldoc->createElement('system.webServer');   
$rewrite = $xmldoc->createElement('rewrite');
$rules = $xmldoc->createElement('rules');
$rule = array();
$match = array();
$rule_action = array();
for($i=0; $i<count($config_array); $i++) {
    $rule[$i] = $xmldoc->createElement('rule');
    $rule[$i]->setAttribute('name', $i);
    $rule[$i]->setAttribute('stopProcessing', 'true');
    $match[$i] =  $xmldoc->createElement('match');
    $match[$i]->setAttribute('url', $config_array[$i]['1']);   
       $rule[$i]->appendChild($match[$i]);  
    $rule_action[$i] = $xmldoc->createElement('action');
    $rule_action[$i]->setAttribute('type', 'Redirect');
    $rule_action[$i]->setAttribute('url', $config_array[$i]['2']);
        $rule[$i]->appendChild($rule_action[$i]);  
    $rules->appendChild($rule[$i]);   
}
$rewrite->appendChild($rules);    
$system_webserver->appendChild($rewrite);
$rootElement->appendChild($system_webserver);
    
$xmldoc->saveXML('web.config', true);
?>
