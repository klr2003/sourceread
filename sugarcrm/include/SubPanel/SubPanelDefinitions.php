<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
	die ( 'Not A Valid Entry Point' ) ;
/**
 * Subpanel definition classes to ease the use of metadata/subpaneldefs.php
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




//input
//	module directory
//constructor
//	open the layout_definitions file.
//
class aSubPanel
{

	var $name ;
	var $_instance_properties ;

	var $mod_strings ;
	var $panel_definition ;
	var $sub_subpanels ;
	var $parent_bean ;

	//module's table name and column fields.
	var $table_name ;
	var $db_fields ;
	var $bean_name ;
	var $template_instance ;

	function aSubPanel ( $name , $instance_properties , $parent_bean , $reload = false , $original_only = false )
	{

		$this->_instance_properties = $instance_properties ;
		$this->name = $name ;
		$this->parent_bean = $parent_bean ;

		//set language
		global $current_language ;
		if (! isset ( $parent_bean->mbvardefs ))
		{
			$mod_strings = return_module_language ( $current_language, $parent_bean->module_dir ) ;
		}
		$this->mod_strings = $mod_strings ;

		if ($this->isCollection ())
		{
			$this->load_sub_subpanels () ; //load sub-panel definition.
		} else
		{
			if (!is_dir('modules/' . $this->_instance_properties [ 'module' ])){
				_pstack_trace();
			}
			$def_path = 'modules/' . $this->_instance_properties [ 'module' ] . '/metadata/subpanels/' . $this->_instance_properties [ 'subpanel_name' ] . '.php' ;
			require ($def_path) ;

			if (! $original_only && isset ( $this->_instance_properties [ 'override_subpanel_name' ] ) && file_exists ( 'custom/modules/' . $this->_instance_properties [ 'module' ] . '/metadata/subpanels/' . $this->_instance_properties [ 'override_subpanel_name' ] . '.php' ))
			{
				$cust_def_path = 'custom/modules/' . $this->_instance_properties [ 'module' ] . '/metadata/subpanels/' . $this->_instance_properties [ 'override_subpanel_name' ] . '.php' ;

				require ($cust_def_path) ;
			}

			// check that the loaded subpanel definition includes a $subpanel_layout section - some, such as projecttasks/default do not...
			$this->panel_definition = array () ;
			if (isset($subpanel_layout))
			{
				$this->panel_definition = $subpanel_layout ;




			}
			$this->load_module_info () ; //load module info from the module's bean file.
		}

	}

	function distinct_query ()
	{
		if (isset ( $this->_instance_properties [ 'get_distinct_data' ] ))
		{

			if (! empty ( $this->_instance_properties [ 'get_distinct_data' ] ))
			return true ; else
			return false ;
		}
		return false ;
	}

	//return the translated header value.
	function get_title ()
	{
		if (empty ( $this->mod_strings [ $this->_instance_properties [ 'title_key' ] ] ))
		{
			return translate ( $this->_instance_properties [ 'title_key' ], $this->_instance_properties [ 'module' ] ) ;
		}
		return $this->mod_strings [ $this->_instance_properties [ 'title_key' ] ] ;
	}

	//return the definition of buttons. looks for buttons in 2 locations.
	function get_buttons ()
	{
		$buttons = array ( ) ;
		if (isset ( $this->_instance_properties [ 'top_buttons' ] ))
		{
			//this will happen only in the case of sub-panels with multiple sources(activities).
			$buttons = $this->_instance_properties [ 'top_buttons' ] ;
		} else
		{
			$buttons = $this->panel_definition [ 'top_buttons' ] ;
		}

		// permissions. hide SubPanelTopComposeEmailButton from activities if email module is disabled.
		//only email is  being tested becuase other submodules in activites/history such as notes, tasks, meetings and calls cannot be disabled.
		//as of today these are the only 2 sub-panels that use the union clause.
		$mod_name = $this->get_module_name () ;
		if ($mod_name == 'Activities' or $mod_name = 'History')
		{
			global $modListHeader ;
			global $modules_exempt_from_availability_check ;
			if (isset ( $modListHeader ) && (! (array_key_exists ( 'Emails', $modListHeader ) or array_key_exists ( 'Emails', $modules_exempt_from_availability_check ))))
			{
				foreach ( $buttons as $key => $button )
				{
					foreach ( $button as $property => $value )
					{
						if ($value == 'SubPanelTopComposeEmailButton' or $value == 'SubPanelTopArchiveEmailButton')
						{
							//remove this button from the array.
							unset ( $buttons [ $key ] ) ;
						}
					}
				}
			}
		}

		return $buttons ;
	}

	//call this function for sub-panels that have unions.
	function load_sub_subpanels ()
	{

		global $modListHeader ;
		// added a check for security of tabs to see if an user has access to them
		// this prevents passing an "unseen" tab to the query string and pulling up its contents
		if (! isset ( $modListHeader ))
		{
			global $current_user ;
			if (isset ( $current_user ))
			{
				$modListHeader = query_module_access_list ( $current_user ) ;
			}
		}

		global $modules_exempt_from_availability_check ;

		if (empty ( $this->sub_subpanels ))
		{
			$panels = $this->get_inst_prop_value ( 'collection_list' ) ;
			foreach ( $panels as $panel => $properties )
			{
				if (array_key_exists ( $properties [ 'module' ], $modListHeader ) or array_key_exists ( $properties [ 'module' ], $modules_exempt_from_availability_check ))
				{
					$this->sub_subpanels [ $panel ] = new aSubPanel ( $panel, $properties, $this->parent_bean ) ;
				}
			}

		}
	}

	function isDatasourceFunction ()
	{
		if (strpos ( $this->get_inst_prop_value ( 'get_subpanel_data' ), 'function' ) === false)
		{
			return false ;
		}
		return true ;
	}
	function isCollection ()
	{
		if ($this->get_inst_prop_value ( 'type' ) == 'collection')
		return true ; else
		return false ;
	}

	//get value of a property defined at the panel instance level.
	function get_inst_prop_value ( $name )
	{
		if (isset ( $this->_instance_properties [ $name ] ))
		return $this->_instance_properties [ $name ] ; else
		return null ;
	}
	//get value of a property defined at the panel definition level.
	function get_def_prop_value ( $name )
	{
		if (isset ( $this->panel_definition [ $name ] ))
		{
			return $this->panel_definition [ $name ] ;
		} else
		{
			return null ;
		}
	}

	//if datasource is of the type function then return the function name
	//else return the value as is.
	function get_function_parameters ()
	{
		$parameters = array ( ) ;
		if ($this->isDatasourceFunction ())
		{
			$parameters = $this->get_inst_prop_value ( 'function_parameters' ) ;
		}
		return $parameters ;
	}

	function get_data_source_name ( $check_set_subpanel_data = false )
	{
		$prop_value = null ;
		if ($check_set_subpanel_data)
		{
			$prop_value = $this->get_inst_prop_value ( 'set_subpanel_data' ) ;
		}
		if (! empty ( $prop_value ))
		{
			return $prop_value ;
		} else
		{
			//fall back to default behavior.
		}
		if ($this->isDatasourceFunction ())
		{
			return (substr_replace ( $this->get_inst_prop_value ( 'get_subpanel_data' ), '', 0, 9 )) ;
		} else
		{
			return $this->get_inst_prop_value ( 'get_subpanel_data' ) ;
		}
	}

	//returns the where clause for the query.
	function get_where ()
	{
		return $this->get_def_prop_value ( 'where' ) ;
	}

	function is_fill_in_additional_fields ()
	{
		// do both. inst_prop returns values from metadata/subpaneldefs.php and def_prop returns from subpanel/default.php
		$temp = $this->get_inst_prop_value ( 'fill_in_additional_fields' ) || $this->get_def_prop_value ( 'fill_in_additional_fields' ) ;
		return $temp ;
	}

	function get_list_fields ()
	{
		if (isset ( $this->panel_definition [ 'list_fields' ] ))
		{
			return $this->panel_definition [ 'list_fields' ] ;
		} else
		{
			return array ( ) ;
		}
	}

	function get_module_name ()
	{
		return $this->get_inst_prop_value ( 'module' ) ;
	}

	function get_name ()
	{
		return $this->name ;
	}

	//load subpanel mdoule's table name and column fields.
	function load_module_info ()
	{
		global $beanList ;
		global $beanFiles ;

		$module_name = $this->get_module_name () ;
		if (! empty ( $module_name ))
		{

			$bean_name = $beanList [ $this->get_module_name () ] ;

			$this->bean_name = $bean_name ;

			include_once ($beanFiles [ $bean_name ]) ;
			$this->template_instance = new $bean_name ( ) ;
			$this->template_instance->force_load_details = true ;
			$this->table_name = $this->template_instance->table_name ;
			//$this->db_fields=$this->template_instance->column_fields;
		}
	}
	//this function is to be used only with sub-panels that are based
	//on collections.
	function get_header_panel_def ()
	{
		if (! empty ( $this->sub_subpanels ))
		{
			if (! empty ( $this->_instance_properties [ 'header_definition_from_subpanel' ] ) && ! empty ( $this->sub_subpanels [ $this->_instance_properties [ 'header_definition_from_subpanel' ] ] ))
			{
				return $this->sub_subpanels [ $this->_instance_properties [ 'header_definition_from_subpanel' ] ] ;
			} else
			{
				reset ( $this->sub_subpanels ) ;
				return current ( $this->sub_subpanels ) ;
			}
		}
		return null ;
	}

	/**
	 * Returns an array of current properties of the class.
	 * It will simply give the class name for instances of classes.
	 */
	function _to_array ()
	{
		return array ( '_instance_properties' => $this->_instance_properties , 'db_fields' => $this->db_fields , 'mod_strings' => $this->mod_strings , 'name' => $this->name , 'panel_definition' => $this->panel_definition , 'parent_bean' => get_class ( $this->parent_bean ) , 'sub_subpanels' => $this->sub_subpanels , 'table_name' => $this->table_name , 'template_instance' => get_class ( $this->template_instance ) ) ;
	}
}
;

class SubPanelDefinitions
{

	var $_focus ;
	var $_visible_tabs_array ;
	var $panels ;
	var $layout_defs ;

	/**
	 * Enter description here...
	 *
	 * @param BEAN $focus - this is the bean you want to get the data from
	 * @param STRING $layout_def_key - if you wish to use a layout_def defined in the default metadata/subpaneldefs.php that is not keyed off of $bean->module_dir pass in the key here
	 * @param ARRAY $layout_def_override - if you wish to override the default loaded layout defs you pass them in here.
	 * @return SubPanelDefinitions
	 */
	function SubPanelDefinitions ( $focus , $layout_def_key = '' , $layout_def_override = '' )
	{
		$this->_focus = $focus ;
		if (! empty ( $layout_def_override ))
		{
			$this->layout_defs = $layout_def_override ;

		} else
		{
			$this->open_layout_defs ( false, $layout_def_key ) ;
		}
	}

	/**
	 * This function returns an ordered list of all "tabs", actually subpanels, for this module
	 * The source list is obtained from the subpanel layout contained in the layout_defs for this module,
	 * found either in the modules metadata/subpaneldefs.php file, or in the modules custom/.../Ext/Layoutdefs/layoutdefs.ext.php file
	 * and filtered through an ACL check.
	 * Note that the keys for the resulting array of tabs are in practice the name of the underlying source relationship for the subpanel
	 * So for example, the key for a custom module's subpanel with Accounts might be 'one_one_accounts', as generated by the Studio Relationship Editor
	 * Although OOB module subpanels have keys such as 'accounts', which might on the face of it appear to be a reference to the related module, in fact 'accounts' is still the relationship name
	 * @param boolean 	Optional - include the subpanel title label in the return array (false)
	 * @return array	All tabs that pass an ACL check
	 */
	function get_available_tabs ($FromGetModuleSubpanels=false)
	{
		global $modListHeader ;
		global $modules_exempt_from_availability_check ;

		if (isset ( $this->_visible_tabs_array ))
			return $this->_visible_tabs_array ;

		if (empty($modListHeader))
		    $modListHeader = query_module_access_list($GLOBALS['current_user']);

		$this->_visible_tabs_array = array ( ) ; // bug 16820 - make sure this is an array for the later ksort

		if (isset ( $this->layout_defs [ 'subpanel_setup' ] )) // bug 17434 - belts-and-braces - check that we have some subpanels first
		{
			//retrieve list of hidden subpanels
			$hidden_panels = $this->get_hidden_subpanels();
			
			//activities is a special use case in that if it is hidden, 
			//then the history tab should be hidden too.
			if(!empty($hidden_panels) && is_array($hidden_panels) && in_array('activities',$hidden_panels)){
				//add history to list hidden_panels
				$hidden_panels['history'] = 'history';
			}

			foreach ( $this->layout_defs [ 'subpanel_setup' ] as $key => $values_array )
			{
				//exclude if this subpanel is hidden from admin screens
                $module = $key;
                if ( isset($values_array['module']) )
                    $module = strtolower($values_array['module']);
				 if ($hidden_panels && is_array($hidden_panels) && (in_array($module, $hidden_panels) || array_key_exists($module, $hidden_panels)) ){				 	
				 	//this panel is hidden, skip it	
				 	continue;
				 }
				
				// make sure the module attribute is set, else none of this works...
				if ( !isset($values_array [ 'module' ])) {
					$GLOBALS['log']->debug("SubPanelDefinitions->get_available_tabs(): no module defined in subpaneldefs for '$key' =>" . var_export($values_array,true) . " - ingoring subpanel defintion") ;
					continue;
				}

				//check permissions.
				$exempt = array_key_exists ( $values_array [ 'module' ], $modules_exempt_from_availability_check ) ;
				$ok = $exempt || ( (! ACLController::moduleSupportsACL ( $values_array [ 'module' ] ) || ACLController::checkAccess ( $values_array [ 'module' ], 'list', true ) ) ) ;

				$GLOBALS [ 'log' ]->debug ( "SubPanelDefinitions->get_available_tabs(): " . $key . "= " . ( $exempt ? "exempt " : "not exempt " .( $ok ? " ACL OK" : "" ) ) ) ;

				if ( $ok )
				{
					while ( ! empty ( $this->_visible_tabs_array [ $values_array [ 'order' ] ] ) )
					{
						$values_array [ 'order' ] ++ ;
					}

					$this->_visible_tabs_array [ $values_array ['order'] ] = ($FromGetModuleSubpanels) ? array($key=>$values_array['title_key']) : $key ;
				}
			}
		}

		ksort ( $this->_visible_tabs_array ) ;
		return $this->_visible_tabs_array ;
	}

	/**
	 * Load the definition of the a sub-panel.
	 * Also the sub-panel is added to an array of sub-panels.
	 * use of reload has been deprecated, since the subpanel is initialized every time.
	 */
	function load_subpanel ( $name , $reload = false , $original_only = false )
	{
		if (!is_dir('modules/' . $this->layout_defs [ 'subpanel_setup' ][ strtolower ( $name ) ] [ 'module' ]))
		  return false;
		return new aSubPanel ( $name, $this->layout_defs [ 'subpanel_setup' ] [ strtolower ( $name ) ], $this->_focus, $reload, $original_only ) ;
	}

	/**
	 * Load the layout def file and associate the definition with a variable in the file.
	 */
	function open_layout_defs ( $reload = false , $layout_def_key = '' , $original_only = false )
	{
		$layout_defs [ $this->_focus->module_dir ] = array ( ) ;
		$layout_defs [ $layout_def_key ] = array ( ) ;

		if (empty ( $this->layout_defs ) || $reload || (! empty ( $layout_def_key ) && ! isset ( $layout_defs [ $layout_def_key ] )))
		{
			if (file_exists ( 'modules/' . $this->_focus->module_dir . '/metadata/subpaneldefs.php' ))
				require ('modules/' . $this->_focus->module_dir . '/metadata/subpaneldefs.php') ;

			if (! $original_only && file_exists ( 'custom/modules/' . $this->_focus->module_dir . '/Ext/Layoutdefs/layoutdefs.ext.php' ))
				require ('custom/modules/' . $this->_focus->module_dir . '/Ext/Layoutdefs/layoutdefs.ext.php') ;

			if (! empty ( $layout_def_key ))
				$this->layout_defs = $layout_defs [ $layout_def_key ] ;
			else
				$this->layout_defs = $layout_defs [ $this->_focus->module_dir ] ;

		}

	}

	/**
	 * Removes a tab from the list of loaded tabs.
	 * Returns true if successful, false otherwise.
	 * Hint: Used by Campaign's DetailView.
	 */
	function exclude_tab ( $tab_name )
	{
		$result = false ;
		//unset layout definition
		if (! empty ( $this->layout_defs [ 'subpanel_setup' ] [ $tab_name ] ))
		{
			unset ( $this->layout_defs [ 'subpanel_setup' ] [ $tab_name ] ) ;
		}
		//unset instance from _visible_tab_array
		if (! empty ( $this->_visible_tabs_array ))
		{
			$key = array_search ( $tab_name, $this->_visible_tabs_array ) ;
			if ($key !== false)
			{
				unset ( $this->_visible_tabs_array [ $key ] ) ;
			}
		}
		return $result ;
	}
	

	/**
	 * return all available subpanels that belong to the list of tab modules.  You can optionally return all
	 * available subpanels, and also optionally group by module (prepends the key with the bean class name). 
	 */
	function get_all_subpanels( $return_tab_modules_only = true, $group_by_module = false )
	{
		global $moduleList, $beanFiles, $beanList, $module;
	
		//use tab controller function to get module list with named keys
		require_once("modules/MySettings/TabController.php");
		$modules_to_check = TabController::get_key_array($moduleList);

		//change case to match subpanel processing later on
		$modules_to_check = array_change_key_case($modules_to_check);

	
		$spd = '';
		$spd_arr = array();
		//iterate through modules and build subpanel array	
		foreach($modules_to_check as $mod_name){
			
			//skip if module name is not in bean list, otherwise get the bean class name
			if(!isset($beanList[$mod_name])) continue;
			$class = $beanList[$mod_name];

			//skip if class name is not in file list, otherwise require the bean file and create new class
			if(!isset($beanFiles[$class]) || !file_exists($beanFiles[$class])) continue;
			
			//retrieve subpanels for this bean
			require_once($beanFiles[$class]);
			$bean_class = new $class();

			//create new subpanel definition instance and get list of tabs
			$spd = new SubPanelDefinitions($bean_class) ;
			$sub_tabs = $spd->get_available_tabs();
	
			//add each subpanel to array of total subpanles 
			foreach( $sub_tabs as $panel_key){
				$panel_key = strtolower($panel_key);
                $panel_module = $panel_key;
                if ( isset($spd->layout_defs['subpanel_setup'][$panel_key]['module']) )
                    $panel_module = strtolower($spd->layout_defs['subpanel_setup'][$panel_key]['module']);
                //if module_only flag is set, only if it is also in module array
				if($return_tab_modules_only && !array_key_exists($panel_module, $modules_to_check)) continue;
				$panel_key_name = $panel_module;

				//group_by_key_name is set to true, then array will hold an entry for each
				//subpanel, with the module name prepended in the key
				if($group_by_module) $panel_key_name = $class.'_'.$panel_key_name;
				//add panel name to subpanel array
				$spd_arr[$panel_key_name] = $panel_module;
			}
		}
		return 	$spd_arr;
	}
	
	/*
	 * save array of hidden panels to mysettings category in config table 
	 */
	function set_hidden_subpanels($panels){
		$administration = new Administration();
		$serialized = base64_encode(serialize($panels));
		$administration->saveSetting('MySettings', 'hide_subpanels', $serialized);
	}

	/*
	 * retrieve hidden subpanels
	 */
	function get_hidden_subpanels(){
		global $moduleList;

		//create variable as static to minimize queries
		static $hidden_subpanels = null;
		
		// if the static value is not already cached, then retrieve it.
		if(empty($hidden_subpanels))
		{
			
			//create Administration object and retrieve any settings for panels
			$administration = new Administration();
			$administration->retrieveSettings('MySettings');

			if(isset($administration->settings) && isset($administration->settings['MySettings_hide_subpanels'])){
				$hidden_subpanels = $administration->settings['MySettings_hide_subpanels'];
				$hidden_subpanels = trim($hidden_subpanels);

				//make sure serialized string is not empty
				if (!empty($hidden_subpanels)){
					//decode and unserialize to retrieve the array
					$hidden_subpanels = base64_decode($hidden_subpanels);
					$hidden_subpanels = unserialize($hidden_subpanels);

					//Ensure modules saved in the preferences exist.
					//get user preference
					//unserialize and add to array if not empty 
					$pref_hidden = array();
					foreach($pref_hidden as $id => $pref_hidden_panel) {
						$hidden_subpanels[] = $pref_hidden_panel;
					}

					
				}else{
					//no settings found, return empty
					return $hidden_subpanels;
				}
			}
			else
			{	//no settings found, return empty
				return $hidden_subpanels;
			}
		}

		return $hidden_subpanels;
	}
	
	
}
?>
