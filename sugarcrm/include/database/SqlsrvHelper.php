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

* Description: This file handles the Data base functionality for the application specific
* to SQL Server database using the php_sqlsrv extension. It is called by the DBManager class to generate various sql statements.
*
* All the functions in this class will work with any bean which implements the meta interface.
* Please refer the DBManager documentation for the details.
*
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
* All Rights Reserved.
* Contributor(s): ______________________________________..
********************************************************************************/
require_once('include/database/MssqlHelper.php');

class SqlsrvHelper extends MssqlHelper
{
	/**
     * @see DBHelper::getColumnType()
     */
    public function getColumnType(
        $type, 
        $name = '', 
        $table = ''
        )
    {
		$columnType = parent::getColumnType($type,$name,$table);
        // Bug 30184 - Comment out this code for the time being until we have better UTF-8 support in the driver
        //if ( in_array($columnType,array('char','varchar')) )
		//	$columnType = 'n'.$columnType;
		
        // Bug 30876 - Comment out this code for the time being until we have better UTF-8 support in the driver
        // Use varbinary field for storage of text and blob field types
        //if ( in_array($columnType,array('ntext','text','image')) )
        //    $columnType = 'varbinary';
        
		return $columnType;
    }
	
	/**
	 * @see DBHelper::massageValue()
	 */
	public function massageValue(
        $val, 
        $fieldDef
        )
    {
        if (!$val) 
            return "''";
        
        $type = $this->getFieldType($fieldDef);
        
		switch ($type) {
		case 'int':
		case 'double':
		case 'float':
		case 'uint':
		case 'ulong':
		case 'long':
		case 'short':
		case 'tinyint':
            return $val;
            break;
        }
        
        $qval = $this->quote($val);

        switch ($type) {
        case 'varchar':
        case 'nvarchar':
        case 'char':
        case 'nchar':
        case 'enum':
        case 'multienum':
        case 'id':
            return $qval;
            break;
        case 'date':
            return "$qval";
            break;
        case 'datetime':
            return $qval;
            break;
        case 'time':
            return "$qval";
            break;
        case 'text':
        case 'ntext':		  
        case 'blob':
        case 'longblob':
        case 'clob':
        case 'longtext':
			return $qval;
            break;
        // Bug 30876 - Comment out this code for the time being until we have better UTF-8 support in the driver
        /*
		case 'varbinary':
        case 'image':
            return "CONVERT(varbinary,$qval)";
            break;
		*/
		}
        
        return $val;
	}
}
?>
