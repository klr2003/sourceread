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
require_once('modules/DynamicFields/templates/Fields/TemplateEnum.php');
require_once('include/utils/array_utils.php');
class TemplateMultiEnum extends TemplateEnum{
	var $type = 'text';

	function get_html_edit(){
		$this->prepare();
		$xtpl_var = strtoupper( $this->name);
		// MFH BUG#13645
		return "<input type='hidden' name='". $this->name. "' value='0'><select name='". $this->name . "[]' size='5' title='{" . $xtpl_var ."_HELP}' MULTIPLE=true>{OPTIONS_".$xtpl_var. "}</select>";
	}

	function get_db_type(){
		if ($GLOBALS['db']->dbType=='oci8') {
			return " CLOB ";
		} else {
			return " TEXT ";
		}
	}

	function get_xtpl_edit(){
		$name = $this->name;
		$value = '';
		if(isset($this->bean->$name)){
			$value = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				$value= $this->default_value;
			}
		}
		if(!empty($this->help)){
		    $returnXTPL[strtoupper($this->name . '_help')] = translate($this->help, $this->bean->module_dir);
		}

		global $app_list_strings;
		$returnXTPL = array();

		$returnXTPL[strtoupper($this->name)] = str_replace('^,^', ',', $value);
		if(empty($this->ext1)){
			$this->ext1 = $this->options;
		}
		$returnXTPL[strtoupper('options_'.$this->name)] = get_select_options_with_id($app_list_strings[$this->ext1], unencodeMultienum( $value));

		return $returnXTPL;


	}
	function prepSave(){

	}
	function get_xtpl_list(){
		return $this->get_xtpl_detail();

	}
	function get_xtpl_detail(){

		$name = $this->name;
		$value = '';
		if(isset($this->bean->$name)){
			$value = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				$value= $this->default_value;
			}
		}
		$returnXTPL = array();
		if(empty($value)) return $returnXTPL;
		global $app_list_strings;

        $values = unencodeMultienum( $value);
        $translatedValues = array();

        foreach($values as $val){
            $translated = translate($this->options, '', $val);
            if(is_string($translated))$translatedValues[] = $translated;
        }

		$returnXTPL[strtoupper($this->name)] = implode(', ', $translatedValues);
		return $returnXTPL;




}

	function get_field_def(){
		$def = parent::get_field_def();
		if ( isset ( $this->ext4 ) )
		{
			// turn off error reporting in case we are unpacking a value that hasn't been packed...
			// this is kludgy, but unserialize doesn't throw exceptions correctly
			$oldErrorReporting = error_reporting ( 0 );
			$unpacked = unserialize ( $this->ext4 ) ;
			error_reporting ( $oldErrorReporting ) ;

			// if we have a new error, then unserialize must have failed => we don't have a packed ext4
			// safe to assume that false means the unpack failed, as ext4 will either contain an imploded string of default values, or an array, not a boolean false value
			if ( $unpacked === false )
				$def [ 'default' ] = $this->ext4 ;
			else
			{
				// we have a packed representation containing one or both of default and dependency
				if ( isset ( $unpacked [ 'default' ] ) )
					$def [ 'default' ] = $unpacked [ 'default' ] ;
				if ( isset ( $unpacked [ 'dependency' ] ) )
					$def [ 'dependency' ] = $unpacked [ 'dependency' ] ;
			}
		}
		//$def['default'] = isset($this->ext4)? $this->ext4 : $def['default'];
		$def['isMultiSelect'] = true;
		return $def;
	}

	function get_db_default(){
    	return '';
	}

	function save($df) {
		if ( isset ( $this->default ) )
		{
			if ( is_array ( $this->default ) )
				$this->default = encodeMultienumValue($this->default);
			$this->ext4 = ( isset ( $this->dependency ) ) ? serialize ( array ( 'default' => $this->default , 'dependency' => $this->dependency ) )  : $this->default ;
		} else
		{
			if ( isset ( $this->dependency ) )
				$this->ext4 = serialize ( array ( 'dependency' => $this->dependency ) ) ;
		}
		parent::save($df);
	}
}


?>
