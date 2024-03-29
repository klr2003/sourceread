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

require_once('include/MVC/View/SugarView.php');
class ConfiguratorViewAddFontResult extends SugarView {
   var $log="";
    /**
     * Constructor
     */
    public function AddFontResult(){
        parent::SugarView();
    }
    /** 
     * display the form
     */
    public function display(){
        global $mod_strings, $app_list_strings, $app_strings, $current_user;
        if(!is_admin($current_user)){
            sugar_die('Admin Only');    
        }
        $error = $this->addFont();
        
        $this->ss->assign("MODULE_TITLE", 
            get_module_title(
                $mod_strings['LBL_MODULE_ID'], 
                $mod_strings['LBL_ADDFONTRESULT_TITLE'], 
                false
                )
            );
        if($error){
            $this->ss->assign("error", $this->log);
        }else{
            $this->ss->assign("info", $this->log);
        }
        $this->ss->assign("MOD", $mod_strings);
        $this->ss->assign("APP", $app_strings);
//display
        $this->ss->display('modules/Configurator/tpls/addFontResult.tpl');
    }
    
    /**
     * This method prepares the received data and call the addFont method of the fontManager
     * @return boolean true on success
     */
    private function addFont(){
        $this->log="";
        $error=false;
        require_once('include/upload_file.php'); 
        $files = array("pdf_metric_file","pdf_font_file");
        foreach($files as $k){
            // handle uploaded file
            $uploadFile = new UploadFile($k);
            if (isset($_FILES[$k]) && $uploadFile->confirm_upload()){
                $uploadFile->final_move(basename($_FILES[$k]['name']));
                $uploadFileNames[$k] = $uploadFile->get_upload_path(basename($_FILES[$k]['name']));
            }else{
                $this->log = translate('ERR_PDF_NO_UPLOAD', "Configurator");
                $error=true;
            }
        }
        if(!$error){
            require_once('include/Sugarpdf/FontManager.php');
            $fontManager = new FontManager();
            $error = $fontManager->addFont($uploadFileNames["pdf_font_file"],$uploadFileNames["pdf_metric_file"], $_REQUEST['pdf_embedded'], $_REQUEST['pdf_encoding_table'], eval($_REQUEST['pdf_patch']), htmlspecialchars_decode($_REQUEST['pdf_cidinfo'],ENT_QUOTES), $_REQUEST['pdf_style_list']);
            $this->log .= $fontManager->log;
            if($error){
                $this->log .= implode("\n",$fontManager->errors);
            }
        }
        return $error;
    }
}
    
