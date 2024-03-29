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
 * $Id$
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
$viewdefs = array (
  'Accounts' => 
  array (
    'QuickCreate' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'buttons' => 
          array (
            0 => 'SAVE',
            1 => 'CANCEL',
          ),
        ),
        'maxColumns' => '2',
        'widths' => 
        array (
          0 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
          1 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
        ),
        'includes' => 
        array (
          0 => 
          array (
            'file' => 'modules/Accounts/Account.js',
          ),
        ),
      ),
      'panels' => 
      array (
        'LBL_ACCOUNT_INFORMATION' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'name',
              'displayParams'=>array('required'=>true),
            ),
            1 => 
            array (
              'name' => 'phone_office',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'website',
            ),
            1 => 
            array (
              'name' => 'phone_alternate',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'parent_name',
            ),
            1 => 
            array (
              'name' => 'phone_fax',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'industry',
            ),
            1 => 
            array (
              'name' => 'account_type',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'team_name',
            ),
            1 => 
            array (
              'name' => 'assigned_user_name',
            ),
          ),
        ),
        'lbl_email_addresses' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'email1',
            ),
          ),
        ),
      ),
    ),
  ),
);
?>
