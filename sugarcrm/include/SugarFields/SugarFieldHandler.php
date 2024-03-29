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
 * *******************************************************************************/
class SugarFieldHandler {
    var $sugarFieldObjects = array();
    
    function SugarFieldHandler() {
    }
    
    /**
     * return the singleton of the SugarField
     * 
     * @param field string field type
     */
    function getSugarField($field, $returnNullIfBase=false) {
        $field = ucfirst($field);
        if(!isset($this->sugarFieldObjects[$field])) {
        	//check custom directory
        	if(file_exists('custom/include/SugarFields/Fields/' . $field . '/SugarField' . $field. '.php')){
        		$file = 'custom/include/SugarFields/Fields/' . $field . '/SugarField' . $field. '.php';
                $type = $field;
			//else check the fields directory
			}else if(file_exists('include/SugarFields/Fields/' . $field . '/SugarField' . $field. '.php')){
           		$file = 'include/SugarFields/Fields/' . $field . '/SugarField' . $field. '.php';
                $type = $field;
        	}else{
        		if($returnNullIfBase)return null;
        		$file = 'include/SugarFields/Fields/Base/SugarFieldBase.php';
                $type = 'Base';
        	}
			require_once($file);
			
			$class = 'SugarField' . $type;
			//could be a custom class check it 
			$customClass = 'Custom' . $class;
        	if(class_exists($customClass)){
        		$this->sugarFieldObjects[$field] = new $customClass($field); 
        	}else{
        		$this->sugarFieldObjects[$field] = new $class($field); 
				
        	}
            
            
        }
        return $this->sugarFieldObjects[$field];
    }
        
    /**
     * Returns the smarty code to be used in a template built by TemplateHandler
     * The SugarField class is choosen dependant on the vardef's type field.
     * 
     * @param parentFieldArray string name of the variable in the parent template for the bean's data
     * @param vardef vardef field defintion
     * @param displayType string the display type for the field (eg DetailView, EditView, etc)
     * @param displayParam parameters for displayin
     *      available paramters are:
     *      * labelSpan - column span for the label
     *      * fieldSpan - column span for the field 
     */
    function displaySmarty($parentFieldArray, $vardef, $displayType, $displayParams = array(), $tabindex = 1) {
        $string = '';
        $displayType = 'get' . $displayType . 'Smarty'; // getDetailViewSmarty, getEditViewSmarty, etc...
		
		// This will handle custom type fields.
		// The incoming $vardef Array may have custom_type set.  
		// If so, set $vardef['type'] to the $vardef['custom_type'] value
		if(isset($vardef['custom_type'])) {
		   $vardef['type'] = $vardef['custom_type'];	
		}
		/*if($vardef['type'] == 'link'){
		_ppd($vardef);
		}
		die;*/
        if(!empty($vardef['type'])) {
        	$type = $vardef['type'];
            switch($vardef['type']) {
               case 'float':
               case 'int':
                    $type = 'int';
                    break;
               case 'date':
                    $type = 'datetime';
                    break;
               case 'url':
               		$type = 'link';
               		break;   
            }
            $field = $this->getSugarField(ucfirst($type));
            $string = $field->$displayType($parentFieldArray, $vardef, $displayParams, $tabindex);

        }
        
        return $string;
    }
 
    
}


?>
