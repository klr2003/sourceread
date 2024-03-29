<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
/**
 * SugarWidgetField
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



require_once ('include/generic/SugarWidgets/SugarWidget.php');

class SugarWidgetField extends SugarWidget {

	function SugarWidgetField(&$layout_manager) {
        parent::SugarWidget($layout_manager);
    }
	
	function display($layout_def) {
		//print $layout_def['start_link_wrapper']."===";
		$context = $this->layout_manager->getAttribute('context'); //_ppd($context);
		$func_name = 'display'.$context;

		if (!empty ($context) && method_exists($this, $func_name)) {
			return $this-> $func_name ($layout_def);
		} else {
			return 'display not found:'.$func_name;
		}
	}

	function _get_column_alias($layout_def) {
		$alias_arr = array ();

		if (!empty ($layout_def['name']) && $layout_def['name'] == 'count') {
			return 'count';
		}

		if (!empty ($layout_def['table_alias'])) {
			array_push($alias_arr, $layout_def['table_alias']);
		}

		if (!empty ($layout_def['name'])) {
			array_push($alias_arr, $layout_def['name']);
		}

		return implode("_", $alias_arr);
	}

	function & displayDetailLabel(& $layout_def) {

		return '';
	}

	function & displayDetail($layout_def) {

		return '';
	}
	function displayHeaderCellPlain($layout_def) {
		$module_name = $this->layout_manager->getAttribute('module_name');
		$header_cell_text = '';
		$key = '';

		if (!empty ($layout_def['label'])) {
			$header_cell_text = $layout_def['label'];
		}
		elseif (!empty ($layout_def['vname'])) {
			$key = $layout_def['vname'];

			if (empty ($key)) {
				$header_cell_text = $layout_def['name'];
			} else {
				$header_cell_text = translate($key, $module_name);
			}
		}
		return $header_cell_text;
	}

	function displayHeaderCell($layout_def) {
		$module_name = $this->layout_manager->getAttribute('module_name');
		
		$this->local_current_module = $_REQUEST['module'];
		$this->is_dynamic = true;
		// don't show sort links if name isn't defined
		if (empty ($layout_def['name'])) {
			return $layout_def['label'];
		}
		if (isset ($layout_def['sortable']) && !$layout_def['sortable']) {
			return $this->displayHeaderCellPlain($layout_def);
		}

		$header_cell_text = '';
		$key = '';

		if (!empty ($layout_def['vname'])) {
			$key = $layout_def['vname'];
		}

		if (empty ($key)) {
			$header_cell_text = $layout_def['name'];
		} else {
			$header_cell_text = translate($key, $module_name);
		}

		$subpanel_module = $layout_def['subpanel_module'];
		if (empty ($this->base_URL)) {
			$this->base_URL = ListView :: getBaseURL('CELL');
			$split_url = explode('&to_pdf=true&action=SubPanelViewer&subpanel=', $this->base_URL);
			$this->base_URL = $split_url[0];
			$this->base_URL .= '&inline=true&to_pdf=true&action=SubPanelViewer&subpanel=';
		}
		$sort_by_name = $layout_def['name'];
		if (isset ($layout_def['sort_by'])) {
			$sort_by_name = $layout_def['sort_by'];
		}

		$sort_by = ListView :: getSessionVariableName('CELL', "ORDER_BY").'='.$sort_by_name;

		$start = (empty ($layout_def['start_link_wrapper'])) ? '' : $layout_def['start_link_wrapper'];
		$end = (empty ($layout_def['end_link_wrapper'])) ? '' : $layout_def['end_link_wrapper'];

		$header_cell = "<a class=\"listViewThLinkS1\" href=\"".$start.$this->base_URL.$subpanel_module.'&'.$sort_by.$end."\">";
		$header_cell .= $header_cell_text;
		$header_cell .= "</a>";
		
		$imgArrow = '';

		if (isset ($layout_def['sort'])) {
			$imgArrow = $layout_def['sort'];
		}
		$arrow_start = ListView :: getArrowUpDownStart($imgArrow);
		
		$header_cell .= " ".$arrow_start;

		return $header_cell;

	}

	function displayList($layout_def) {
		return $this->displayListPlain($layout_def);
	}

	function displayListPlain($layout_def) {
		$value= $this->_get_list_value($layout_def);
		if (isset($layout_def['widget_type']) && $layout_def['widget_type'] =='checkbox') {
			if ($value != '' &&  ($value == 'on' || intval($value) == 1 || $value == 'yes'))  
			{
				return "<input name='checkbox_display' class='checkbox' type='checkbox' disabled='true' checked>";
			}
			return "<input name='checkbox_display' class='checkbox' type='checkbox' disabled='true'>";
		}
		return $value;
	}

	function _get_list_value(& $layout_def) {
		$key = '';
		$value = '';

		if (isset ($layout_def['varname'])) {
			$key = strtoupper($layout_def['varname']);
		} else {
			$key = $this->_get_column_alias($layout_def);
			$key = strtoupper($key);
		}

		if (isset ($layout_def['fields'][$key])) {
			return $layout_def['fields'][$key];
		}
		return $value;

	}

	function & displayEditLabel($layout_def) {
		return '';
	}

	function & displayEdit($layout_def) {
		return '';
	}

	function & displaySearchLabel($layout_def) {
		return '';
	}

	function & displaySearch($layout_def) {
		return '';
	}

	function displayInput($layout_def) {
		return ' -- Not Implemented --';
	}
}
?>


