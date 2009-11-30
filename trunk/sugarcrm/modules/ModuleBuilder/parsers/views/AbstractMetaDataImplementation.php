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
 *********************************************************************************/

require_once 'modules/ModuleBuilder/parsers/constants.php' ;

/*
 * Abstract base clase for Parser Implementations (using a Bridge Pattern)
 * The Implementations hide the differences between :
 * - Deployed modules (such as OOB modules and deployed ModuleBuilder modules) that are located in the /modules directory and have metadata in modules/<name>/metadata and in the custom directory
 * - WIP modules which are being worked on in ModuleBuilder and that are located in custom
 */


require_once 'modules/ModuleBuilder/parsers/views/History.php' ;

abstract class AbstractMetaDataImplementation
{
	protected $_view ;
	protected $_moduleName ;
	protected $_viewdefs ;
	protected $_originalViewdefs = array();
	protected $_fielddefs ;
	protected $_sourceFilename = '' ; // the name of the file from which we loaded the definition we're working on - needed when we come to write out the historical record
	// would like this to be a constant, but alas, constants cannot contain arrays...
	protected $_fileVariables = array (
	MB_DASHLETSEARCH 			=> 'dashletData',
	MB_DASHLET 		 			=> 'dashletData',
	MB_LISTVIEW 	 			=> 'listViewDefs',
	MB_BASICSEARCH 	 			=> 'searchdefs',
	MB_ADVANCEDSEARCH 	 		=> 'searchdefs',
	MB_EDITVIEW 	 			=> 'viewdefs',
	MB_DETAILVIEW 	 			=> 'viewdefs',
	MB_QUICKCREATE 	 			=> 'viewdefs',







	) ;

	/*
	 * Getters for the definitions loaded by the Constructor
	 */
	function getViewdefs ()
	{
		$GLOBALS['log']->debug( get_class ( $this ) . '->getViewdefs:'.print_r($this->_viewdefs,true) ) ;
		return $this->_viewdefs ;
	}

	function getOriginalViewdefs() {
		return $this->_originalViewdefs;
	}

	function getFielddefs ()
	{
		return $this->_fielddefs ;
	}

	/*
	 * Obtain a new accessor for the history of this layout
	 * Ideally the History object would be a singleton; however given the use case (modulebuilder/studio) it's unlikely to be an issue
	 */
	function getHistory ()
	{
		return $this->_history ;
	}

	/*
	 * Load a layout from a file, given a filename
	 * Doesn't do any preprocessing on the viewdefs - just returns them as found for other classes to make sense of
	 * @param string filename       The full path to the file containing the layout
	 * @return array                The layout, null if the file does not exist
	 */
	protected function _loadFromFile ($filename)
	{
		// BEGIN ASSERTIONS
		if (! file_exists ( $filename ))
		{
			return null ;
		}
		// END ASSERTIONS
		$GLOBALS['log']->debug(get_class($this)."->_loadFromFile(): reading from ".$filename );
		require $filename ; // loads the viewdef - must be a require not require_once to ensure can reload if called twice in succession

		// Check to see if we have the module name set as a variable rather than embedded in the $viewdef array
		// If we do, then we have to preserve the module variable when we write the file back out
		// This is a format used by ModuleBuilder templated modules to speed the renaming of modules
		// OOB Sugar modules don't use this format

		$moduleVariables = array ( 'module_name' , '_module_name' , 'OBJECT_NAME' , '_object_name' ) ;

		$variables = array ( ) ;
		foreach ( $moduleVariables as $name )
		{
			if (isset ( $$name ))
			{
				$variables [ $name ] = $$name ;
			}
		}

		// Extract the layout definition from the loaded file - the layout definition is held under a variable name that varies between the various layout types (e.g., listviews hold it in listViewDefs, editviews in viewdefs)
		$viewVariable = $this->_fileVariables [ $this->_view ] ;
		$defs = $$viewVariable ;

		// Now tidy up the module name in the viewdef array
		// MB created definitions store the defs under packagename_modulename and later methods that expect to find them under modulename will fail

		if (isset ( $variables [ 'module_name' ] ))
		{
			$mbName = $variables [ 'module_name' ] ;
			if ($mbName != $this->_moduleName)
			{
				$defs [ $this->_moduleName ] = $defs [ $mbName ] ;
				unset ( $defs [ $mbName ] ) ;
			}
		}
		$this->_variables = $variables ;
		// now remove the modulename preamble from the loaded defs
		reset($defs);
		$temp = each($defs);

		$GLOBALS['log']->debug( get_class ( $this ) . "->_loadFromFile: returning ".print_r($temp['value'],true)) ;
		return $temp['value']; // 'value' contains the value part of 'key'=>'value' part
	}

	/*
	 * Save a layout to a file
	 * Must be the exact inverse of _loadFromFile
	 * Obtains the additional variables, such as module_name, to include in beginning of the file (as required by ModuleBuilder) from the internal variable _variables, set in the Constructor
	 * @param string filename       The full path to the file to contain the layout
	 * @param array defs        	Array containing the layout definition; the top level should be the definition itself; not the modulename or viewdef= preambles found in the file definitions
	 * @param boolean useVariables	Write out with placeholder entries for module name and object name - used by ModuleBuilder modules
	 */
	protected function _saveToFile ($filename , $defs , $useVariables = true )
	{

		mkdir_recursive ( dirname ( $filename ) ) ;

		$useVariables = (count ( $this->_variables ) > 0) && $useVariables ; // only makes sense to do the variable replace if we have variables to replace...

		// create the new metadata file contents, and write it out
		$out = "<?php\n" ;
		if ($useVariables)
		{
			// write out the $<variable>=<modulename> lines
			foreach ( $this->_variables as $key => $value )
			{
				$out .= "\$$key = '" . $value . "';\n" ;
			}
		}

		$viewVariable = $this->_fileVariables [ $this->_view ] ;
		$out .= "\$$viewVariable [".(($useVariables) ? '$module_name' : "'$this->_moduleName'")."] = \n" . var_export_helper ( $defs ) ;
		$out .= ";\n?>\n" ;

		if ( file_put_contents ( $filename, $out ) === false)
			$GLOBALS [ 'log' ]->fatal ( get_class($this).": could not write new viewdef file " . $filename ) ;
	}

	/*
	 * Fielddefs are obtained from two locations:
	 *
	 * 1. The starting point is the module's fielddefs, sourced from the Bean
	 * 2. Second comes any overrides from the layouts themselves. Note though that only visible fields are included in a layoutdef, which
	 * 	  means fields that aren't present in the current layout may have a layout defined in a lower-priority layoutdef, for example, the base layoutdef
	 *
	 * Thus to determine the current fielddef for any given field, we take the fielddef defined in the module's Bean and then override with first the base layout,
	 * then the customlayout, then finally the working layout...
	 *
	 * The complication is that although generating these merged fielddefs is naturally a method of the implementation, not the parser,
	 * we therefore lack knowledge as to which type of layout we are merging - EditView or ListView. So we can't use internal knowledge of the
	 * layout to locate the field definitions. Instead, we need to look for sections of the layout that match the template for a field definition...
	 */
	function _mergeFielddefs ( &$fielddefs , $layout )
	{
		foreach ( $layout as $key => $def )
		{

			if ( (string) $key == 'templateMeta' )
			continue ;

			if ( is_array ( $def ) )
			{
				if ( isset ( $def [ 'name' ] ) && ! is_array ( $def [ 'name' ] ) ) // found a 'name' definition, that is not the definition of a field called name :)
				{
					// if this is a module field, then merge in the definition, otherwise this is a new field defined in the layout, so just take the definition
					$fielddefs [ $def [ 'name'] ] = ( isset ($fielddefs [ $def [ 'name' ] ] ) ) ? array_merge ( $fielddefs [ $def [ 'name' ] ], $def ) : $def ;
				}
				else if ( isset ( $def [ 'label' ] ) || isset ( $def [ 'vname' ] ) || isset($def ['widget_class']) ) // dealing with a listlayout which lacks 'name' keys, but which does have 'label' keys
				{
					$key = strtolower ( $key ) ;
					$fielddefs [ $key ] = ( isset ($fielddefs [ $key ] ) ) ? array_merge ( $fielddefs [ $key ], $def ) : $def ;
				}
				else
				$this->_mergeFielddefs( $fielddefs , $def ) ;
			}
		}

	}

}

?>
