<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;

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

 * Description: This file is used to override the default Meta-data EditView behavior
 * to provide customization specific to the Calls module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once ('include/MVC/View/views/view.edit.php') ;
require_once ('modules/ModuleBuilder/parsers/ParserFactory.php') ;
require_once ('modules/ModuleBuilder/MB/AjaxCompose.php') ;
require_once 'modules/ModuleBuilder/parsers/constants.php' ;

//require_once('include/Utils.php');


class ViewLayoutView extends ViewEdit
{

    function ViewLayoutView ()
    {
        $GLOBALS [ 'log' ]->debug ( 'in ViewLayoutView' ) ;
        $this->editModule = $_REQUEST [ 'view_module' ] ;
        $this->editLayout = $_REQUEST [ 'view' ] ;
        $this->package = null;
        $this->fromModuleBuilder = isset ( $_REQUEST [ 'MB' ] ) || !empty($_REQUEST [ 'view_package' ]);
        if ($this->fromModuleBuilder)
        {
            $this->package = $_REQUEST [ 'view_package' ] ;
        } else
        {
            global $app_list_strings ;
            $moduleNames = array_change_key_case ( $app_list_strings [ 'moduleList' ] ) ;
            $this->translatedEditModule = $moduleNames [ strtolower ( $this->editModule ) ] ;
        }
    }

    // DO NOT REMOVE - overrides parent ViewEdit preDisplay() which attempts to load a bean for a non-existent module
    function preDisplay ()
    {
    }

    function display ($preview = false)
    {

        global $mod_strings ;
        $parser = ParserFactory::getParser($this->editLayout,$this->editModule,$this->package);
        $history = $parser->getHistory () ;
        $smarty = new Sugar_Smarty ( ) ;
        //Add in the module we are viewing to our current mod strings
		if (! $this->fromModuleBuilder) {
			global $current_language;
			$editModStrings = return_module_language($current_language, $this->editModule);
			$mod_strings = sugarArrayMerge($editModStrings, $mod_strings);
		}
        $smarty->assign('mod', $mod_strings);
		$smarty->assign('MOD', $mod_strings);
        // assign buttons
        $images = array ( 'icon_save' => 'studio_save' , 'icon_publish' => 'studio_publish' , 'icon_address' => 'icon_Address' , 'icon_emailaddress' => 'icon_EmailAddress' , 'icon_phone' => 'icon_Phone' ) ;
        foreach ( $images as $image => $file )
        {
            $smarty->assign ( $image, SugarThemeRegistry::current()->getImage($file) ) ;
        }

        $buttons = array ( ) ;

        if ($preview)
        {
            $smarty->assign ( 'layouttitle', translate ( 'LBL_LAYOUT_PREVIEW', 'ModuleBuilder' ) ) ;
        } else
        {
            $smarty->assign ( 'layouttitle', translate ( 'LBL_CURRENT_LAYOUT', 'ModuleBuilder' ) ) ;
            if (! $this->fromModuleBuilder)
            {
                $buttons [] = array ( 'id' => 'saveBtn' , 'text' => translate ( 'LBL_BTN_SAVE' ) , 'actionScript' => "onclick='if (countGridFields()==0) ModuleBuilder.layoutValidation.popup() ; else Studio2.handleSave();'" ) ;
                $buttons [] = array ( 'id' => 'publishBtn' , 'text' => translate ( 'LBL_BTN_SAVEPUBLISH' ) , 'actionScript' => "onclick='if (countGridFields()==0) ModuleBuilder.layoutValidation.popup() ; else Studio2.handlePublish();'" ) ;
                $buttons [] = array ( 'id' => 'spacer' , 'width' => '50px' ) ;
                $buttons [] = array ( 'id' => 'historyBtn' , 'text' => translate ( 'LBL_HISTORY' ) , 'actionScript' => "onclick='ModuleBuilder.history.browse(\"{$this->editModule}\", \"{$this->editLayout}\")'") ;
                $buttons [] = array ( 'id' => 'historyDefault' , 'text' => translate ( 'LBL_RESTORE_DEFAULT' ) , 'actionScript' => "onclick='ModuleBuilder.history.revert(\"{$this->editModule}\", \"{$this->editLayout}\", \"{$history->getLast()}\", \"\")'" ) ;
            } else
            {
                $buttons [] = array ( 'id' => 'saveBtn' , 'text' => $GLOBALS [ 'mod_strings' ] [ 'LBL_BTN_SAVE' ] , 'actionScript' => "onclick='if (countGridFields()==0) ModuleBuilder.layoutValidation.popup() ; else Studio2.handlePublish();'" ) ;
                $buttons [] = array ( 'id' => 'spacer' , 'width' => '50px' ) ;
                $buttons [] = array ( 'id' => 'historyBtn' , 'text' => translate ( 'LBL_HISTORY' ) , 'actionScript' => "onclick='ModuleBuilder.history.browse(\"{$this->editModule}\", \"{$this->editLayout}\")'" ) ;
                $buttons [] = array ( 'id' => 'historyDefault' , 'text' => translate ( 'LBL_RESTORE_DEFAULT' ) , 'actionScript' => "onclick='ModuleBuilder.history.revert(\"{$this->editModule}\", \"{$this->editLayout}\", \"{$history->getLast()}\", \"\")'" ) ;
            }
        }

        $html = "" ;
        foreach ( $buttons as $button )
        {
            if ($button['id'] == "spacer") {
            	$html .= "<td style='width:{$button['width']}'> </td>";
            } else {
        	    $html .= "<td><input id='{$button['id']}' type='button' valign='center' class='button' style='cursor:pointer' "
        	       . "onmousedown='this.className=\"buttonOn\";return false;' onmouseup='this.className=\"button\"' "
        	       . "onmouseout='this.className=\"button\"' {$button['actionScript']} value = '{$button['text']}' ></td>" ;
            }
        }

        $smarty->assign ( 'buttons', $html ) ;

        // assign fields and layout
        $smarty->assign ( 'available_fields', $parser->getAvailableFields () ) ;
        $smarty->assign ( 'layout', $parser->getLayout () ) ;
        $smarty->assign ( 'view_module', $this->editModule ) ;
        $smarty->assign ( 'view', $this->editLayout ) ;
        $smarty->assign ( 'maxColumns', $parser->getMaxColumns() ) ;
        $smarty->assign ( 'nextPanelId', $parser->getFirstNewPanelId() ) ;
        $smarty->assign ( 'fieldwidth', 150 ) ;
        $smarty->assign ( 'translate', true ) ;

        if ($this->fromModuleBuilder)
        {
            $smarty->assign ( 'fromModuleBuilder', $this->fromModuleBuilder ) ;
            $smarty->assign ( 'view_package', $this->package ) ;
        }

        $labels = array (
        			MB_EDITVIEW => 'LBL_EDITVIEW' ,
        			MB_DETAILVIEW => 'LBL_DETAILVIEW' ,
        			MB_QUICKCREATE => 'LBL_QUICKCREATE',




        			) ;

        $layoutLabel = 'LBL_LAYOUTS' ;
        $layoutView = 'layouts' ;










        $ajax = new AjaxCompose ( ) ;
        $viewType;

        $translatedViewType = '' ;
		if ( isset ( $labels [ strtolower ( $this->editLayout ) ] ) )
			$translatedViewType = translate ( $labels [ strtolower( $this->editLayout ) ] , 'ModuleBuilder' ) ;

        if ($this->fromModuleBuilder)
        {
            $ajax->addCrumb ( translate ( 'LBL_MODULEBUILDER', 'ModuleBuilder' ), 'ModuleBuilder.main("mb")' ) ;
            $ajax->addCrumb ( $this->package, 'ModuleBuilder.getContent("module=ModuleBuilder&action=package&package=' . $this->package . '")' ) ;
            $ajax->addCrumb ( $this->editModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=module&view_package=' . $this->package . '&view_module=' . $this->editModule . '")' ) ;
            $ajax->addCrumb ( translate ( $layoutLabel, 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&MB=true&action=wizard&view='.$layoutView.'&view_module=' . $this->editModule . '&view_package=' . $this->package . '")' ) ;
            $ajax->addCrumb ( $translatedViewType, '' ) ;
        } else
        {
            $ajax->addCrumb ( translate ( 'LBL_STUDIO', 'ModuleBuilder' ), 'ModuleBuilder.main("studio")' ) ;
            $ajax->addCrumb ( $this->translatedEditModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=' . $this->editModule . '")' ) ;
            $ajax->addCrumb ( translate ( $layoutLabel, 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view='.$layoutView.'&view_module=' . $this->editModule . '")' ) ;
            $ajax->addCrumb ( $translatedViewType, '' ) ;
        }

        // set up language files
        $smarty->assign ( 'language', $parser->getLanguage() ) ; // for sugar_translate in the smarty template
        $smarty->assign('from_mb',$this->fromModuleBuilder);

        $ajax->addSection ( 'center', $translatedViewType, $smarty->fetch ( 'modules/ModuleBuilder/tpls/layoutView.tpl' ) ) ;
        if ($preview) {
        	echo $smarty->fetch ( 'modules/ModuleBuilder/tpls/Preview/layoutView.tpl' );
		} else {
			echo $ajax->getJavascript () ;
    	}
    }

}
?>
