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
 * *******************************************************************************/
/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/

$dictionary['OutboundEmail'] = array ('table' => 'outbound_email',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'id',
			'required' => true,
			'reportable' => false,
		),
		'name' => array (
			'name' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'varchar',
			'len' => 50,
			'required' => true,
			'reportable' => false,
		),
		'type' => array (
			'name' => 'type',
			'vname' => 'LBL_TYPE',
			'type' => 'varchar',
			'len' => 6,
			'required' => true,
			'default' => 'user',
			'reportable' => false,
		),
		'user_id' => array (
			'name' => 'user_id',
			'vname' => 'LBL_USER_ID',
			'type' => 'id',
			'required' => true,
			'reportable' => false,
		),
		'mail_sendtype' => array(
			'name' => 'mail_sendtype',
			'vname' => 'LBL_MAIL_SENDTYPE',
			'type' => 'varchar',
			'len' => 8,
			'required' => true,
			'default' => 'sendmail',
			'reportable' => false,
		),
		'mail_smtpserver' => array(
			'name' => 'mail_smtpserver',
			'vname' => 'LBL_MAIL_SMTPSERVER',
			'type' => 'varchar',
			'len' => 100,
			'required' => false,
			'reportable' => false,
		),
		'mail_smtpport' => array(
			'name' => 'mail_smtpport',
			'vname' => 'LBL_MAIL_SMTPPORT',
			'type' => 'int',
			'len' => 5,
			'reportable' => false,
		),
		'mail_smtpuser' => array(
			'name' => 'mail_smtpuser',
			'vname' => 'LBL_MAIL_SMTPUSER',
			'type' => 'varchar',
			'len' => 100,
			'reportable' => false,
		),
		'mail_smtppass' => array(
			'name' => 'mail_smtppass',
			'vname' => 'LBL_MAIL_SMTPPASS',
			'type' => 'varchar',
			'len' => 100,
			'reportable' => false,
		),
		'mail_smtpauth_req' => array(
			'name' => 'mail_smtpauth_req',
			'vname' => 'LBL_MAIL_SMTPAUTH_REQ',
			'type' => 'bool',
			'default' => 0,
			'reportable' => false,
		),
		'mail_smtpssl' => array(
			'name' => 'mail_smtpssl',
			'vname' => 'LBL_MAIL_SMTPSSL',
			'type' => 'int',
			'len' => 1,
			'default' => 0,
			'reportable' => false,
		),
	),
	'indices' => array (
		array(
			'name' => 'outbound_email_pk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
		array(
			'name' => 'oe_user_id_idx',
			'type' =>'index',
			'fields' => array(
				'id',
				'user_id',
			)
		),
	), /* end indices */
);

