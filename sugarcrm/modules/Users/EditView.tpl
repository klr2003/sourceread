<!--
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

 ********************************************************************************/
-->

{$ROLLOVER}
<script type="text/javascript" lang="Javascript" src="modules/InboundEmail/InboundEmail.js"></script>
<link rel='stylesheet' type="text/css" href='modules/Users/PasswordRequirementBox.css'>
<script type='text/javascript' src='include/javascript/sugar_grp_overlib.js'></script>
<script type='text/javascript'>
var ERR_RULES_NOT_MET = '{$MOD.ERR_RULES_NOT_MET}';
var ERR_ENTER_OLD_PASSWORD = '{$MOD.ERR_ENTER_OLD_PASSWORD}';
var ERR_ENTER_NEW_PASSWORD = '{$MOD.ERR_ENTER_NEW_PASSWORD}';
var ERR_ENTER_CONFIRMATION_PASSWORD = '{$MOD.ERR_ENTER_CONFIRMATION_PASSWORD}';
var ERR_REENTER_PASSWORDS = '{$MOD.ERR_REENTER_PASSWORDS}';
</script>
<script type='text/javascript' src='modules/Users/PasswordRequirementBox.js'></script>
{$ERROR_STRING}
<form name="EditView" id="EditView" method="POST" action="index.php">
	<input type="hidden" name="display_tabs_def">
	<input type="hidden" name="hide_tabs_def">
	<input type="hidden" name="remove_tabs_def">
	<input type="hidden" name="module" value="Users">
	<input type="hidden" name="record" id="record" value="{$ID}">
	<input type="hidden" name="action">
	<input type="hidden" name="page" value="EditView">
	<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
	<input type="hidden" name="return_id" value="{$RETURN_ID}">
	<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
	<input type="hidden" name="password_change" id="password_change" value="false">
    <input type="hidden" name="required_password" id="required_password" value='{$REQUIRED_PASSWORD}' >
	<input type="hidden" name="user_name" value="{$USER_NAME}">
	<input type="hidden" name="type" value="{$REDIRECT_EMAILS_TYPE}">
	<input type="hidden" id="is_group" name="is_group" value='{$IS_GROUP}' {$IS_GROUP_DISABLED}>
	<input type="hidden" id='portal_only' name='portal_only' value='{$IS_PORTALONLY}' {$IS_PORTAL_ONLY_DISABLED}>
	<input type="hidden" name="is_admin" id="is_admin" value='{$IS_FOCUS_ADMIN}' {$IS_ADMIN_DISABLED} >
	<input type="hidden" name="is_current_admin" id="is_current_admin" value='{$IS_ADMIN}' >
	<input type="hidden" name="required_email_address" id="required_email_address" value='{$REQUIRED_EMAIL_ADDRESS}' >
	<div id="popup_window"></div>
						

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<input	id="Save" title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" 
					class="button" onclick="if (!set_password(form,newrules('{$PWDSETTINGS.minpwdlength}','{$PWDSETTINGS.maxpwdlength}','{$REGEX}'))) return false; if (!Admin_check()) return false; this.form.action.value='Save'; {$CHOOSER_SCRIPT} {$REASSIGN_JS} if(verify_data(EditView)) this.form.submit();"
					type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
			<input	title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" 
					class="button" onclick="this.form.action.value='{$RETURN_ACTION}'; this.form.module.value='{$RETURN_MODULE}'; this.form.record.value='{$RETURN_ID}'; this.form.submit()" 
					type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
		</td>
		<td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
</table>

<div id="basic">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="17%" scope="row"><slot>{$MOD.LBL_USER_NAME}: <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></slot></td>
					<td width="33%" ><slot><input name='sugar_user_name' type="text" {$USER_NAME_DISABLED} tabindex='1' size='15' maxlength='25' value='{$USER_NAME}' /></slot></td>
					<td width="17%" id='name_lbl' style='display:{$HIDE_FOR_NORMAL_AND_ADMIN}'  scope="row"><slot>{$MOD.LBL_LIST_NAME}: <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></slot></td>
					<td width="33%" id='name_field' style='display:{$HIDE_FOR_NORMAL_AND_ADMIN}'><slot><input id='unique_name' name='unique_name' {$LAST_NAME_DISABLED} tabindex='2' size='25' maxlength='25' type="text" value="{$LAST_NAME}" onblur="document.getElementById('last_name').value=this.value"></slot></td>
					<td width="17%" id='first_name_lbl' scope="row"  style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'><slot>{$MOD.LBL_FIRST_NAME}:</slot></td>
					<td width="33%" id='first_name_field'  style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'><slot><input id='first_name' name='first_name' {$FIRST_NAME_DISABLED} tabindex='1' size='25' maxlength='25' type="text" value="{$FIRST_NAME}"></slot></td>
				
				</tr>
				<tr>
					{$USER_STATUS_OPTIONS}	
					<td width="17%" scope="row" style='display:{$HIDE_STATIC_USERTYPE}'><slot>{$MOD.LBL_USER_TYPE}:</slot></td>
					<td scope="row" style='display:{$HIDE_STATIC_USERTYPE}'><slot>{$USER_TYPE_LABEL}&nbsp;{sugar_help text=$USER_TYPE_DESC WIDTH=250}</slot></td>
					<td id='last_name_lbl' scope="row"  style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'><slot>{$MOD.LBL_LAST_NAME}: <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></slot></td>
					<td id='last_name_field'  style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'><slot><input id='last_name' name='last_name' type="text" {$LAST_NAME_DISABLED} tabindex='1' size='25' maxlength='25' value="{$LAST_NAME}"></slot></td>
				</tr>
				<tr>
					<td colspan='4' style='display:{$HIDE_CHANGE_USERTYPE}'>
						<table width="100%" cellspacing="0" cellpadding="0">
						<tr><td width="17%" scope="row"><slot>{$MOD.LBL_USER_TYPE}:</slot></td>
						{if $USER_ADMIN}
							<td width="20%"><select id="UserType" name="UserType" onchange="user_status_display(this);" value='' disabled>
								<option value="RegularUser">{$MOD.LBL_REGULAR_USER}</option>
							</select></td>
						{elseif $ADMIN_EDIT_SELF}
							<td width="20%"><select id="UserType" name="UserType" onchange="user_status_display(this);" value='' disabled>
								<option value="Administrator">{$MOD.LBL_ADMIN_USER}</option>
							</select></td>
						{else}
							<td width="20%"><select id="UserType" name="UserType" onchange="user_status_display(this);" value='' tabindex='1' >
								<option value="RegularUser">{$MOD.LBL_REGULAR_USER}</option>
								<option value="Administrator" {if $IS_FOCUS_ADMIN} SELECTED {/if}>{$MOD.LBL_ADMIN_USER}</option>
  							</select></td>
  						{/if}
							<td colspan='4' scope="row">
								<div id='UserTypeDesc'>{$USER_TYPE_DESC}</div>
							</td></tr>
						</table>
					</td>
				</tr>

			</table>
		</td>
			
	</tr>
</table>
</div>

{if ($CHANGE_PWD) == '1'} 
<div id="generate_password">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
    <tr>
        <td width='40%'>
            <table width='100%' cellspacing='0' cellpadding='0' border='0' >
                <tr>
                    <th align="left" scope="row" colspan="4">
                        <h4>{$MOD.LBL_CHANGE_PASSWORD_TITLE}</h4><br>
                        {$ERROR_PASSWORD}
                    </th>
                </tr>
            </table>
            	<!-- hide field if user is admin -->
	            <div id='generate_password_old_password' {if ($IS_ADMIN)} style='display:none' {/if}>
		             <table width='100%' cellspacing='0' cellpadding='0' border='0' >
		                <tr>
		                    <td width='35%' scope="row">
		                        {$MOD.LBL_OLD_PASSWORD}
		                    </td>
		                    <td >
		                        <input name='old_password' id='old_password' type='password' tabindex='2' onkeyup="password_confirmation();" >
		                    </td>
                            <td width='40%'>
                   			</td>
		                </tr>
		             </table>
				</div>
			<table width='100%' cellspacing='0' cellpadding='0' border='0' >
                <tr>
                    <td width='35%' scope="row" snowrap>
                        {$MOD.LBL_NEW_PASSWORD}
                        <span class="required" id="mandatory_pwd">{if ($REQUIRED_PASSWORD)}{$APP.LBL_REQUIRED_SYMBOL}{/if}</span>
                    </td>
                    <td class='dataField'>
                        
                        <input name='new_password' id= "new_password" type='password' tabindex='2' onkeyup="password_confirmation();newrules('{$PWDSETTINGS.minpwdlength}','{$PWDSETTINGS.maxpwdlength}','{$REGEX}');" />
                    </td>
                    <td width='40%'>
                    </td>
                </tr>
                <tr>
                    <td scope="row" width='35%'>
                        {$MOD.LBL_CONFIRM_PASSWORD}
                    </td>
                    <td class='dataField'>
                        <input name='confirm_new_password' id='confirm_pwd' style ='' type='password' tabindex='2' onkeyup="password_confirmation();"  >
                    </td>
                    <td width='40%'>
                    <div id="comfirm_pwd_match" class="error" style="display: none;">{$MOD.ERR_PASSWORD_MISMATCH}</div>
                         {*<span id="ext-gen63" class="x-panel-header-text">
                            Requirements
                            <span id="Filter.1_help" onmouseout="return nd();" onmouseover="return overlib(help(), FGCLASS, 'olFgClass', CGCLASS, 'olCgClass', BGCLASS, 'olBgClass', TEXTFONTCLASS, 'olFontClass', CAPTIONFONTCLASS, 'olCapFontClass', CLOSEFONTCLASS, 'olCloseFontClass' );">
                                <img src="themes/default/images/help.gif"/>
                            </span>
                        </span>*}
                    </td>
                </tr>
                <tr>
                    <td class='dataLabel'></td>
                    <td class='dataField'></td>
                </td>                    
            </table>

            <table width='17%' cellspacing='0' cellpadding='1' border='0'>
                <tr>
                    <td width='50%'>
                        <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey='{$APP.LBL_SAVE_BUTTON_KEY}' class='button' id='save_new_pwd_button' LANGUAGE=javascript onclick='if (set_password(this.form)) window.close(); else return false;' type='submit' name='button' style='display:none;' value='{$APP.LBL_SAVE_BUTTON_LABEL}'>
                    </td>
                    <td width='50%'>
                    </td>
                </tr>
            </table>
        </td>
        <td width='60%' style="vertical-align:middle;">





        </td>
    </tr>
</table>

</div>

{else}
<div id="generate_password">
	<input name='old_password' id='old_password' type='hidden'>
	<input name='new_password' id= "new_password" type='hidden'>
	<input name='confirm_new_password' id='confirm_pwd' type='hidden'>
</div>
{/if}

<div id="email_options">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
	<tr>
		<td>
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	        	<tr>
	        		<th align="left" scope="row" colspan="4">
	        			<h4>{$MOD.LBL_MAIL_OPTIONS_TITLE} {if $REQUIRED_EMAIL_ADDRESS}<span class="required" id="mandatory_email">{$APP.LBL_REQUIRED_SYMBOL}</span> {/if}</h4>
	        		</th>
	        	</tr>
	        	<tr>
	        	    <td scope="row" width="17%">
	        	    {$MOD.LBL_EMAIL}:
	        	    </td>
					<td scope="row">
						{$NEW_EMAIL}
					</td>
				</tr>
				<tr id="email_options_link_type" style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'>
			        <td scope="row" width="17%">
			        	{$MOD.LBL_EMAIL_LINK_TYPE}:&nbsp;{sugar_help text=$MOD.LBL_EMAIL_LINK_TYPE_HELP WIDTH=450}
			        </td>
			        <td scope="row">
			        	<select name="email_link_type" tabindex='410'>
			        	{$EMAIL_LINK_TYPE}
			        	</select>
			        </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>

<div id="information" style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th align="left" scope="row" colspan="4"><h4><slot>{$MOD.LBL_USER_INFORMATION}</slot></h4></th>
				</tr>
				<tr>
					<td width="17%" scope="row"><slot>{$MOD.LBL_EMPLOYEE_STATUS}:</slot></td>
					<td width="33%" ><slot>{$EMPLOYEE_STATUS_OPTIONS}</slot></td>
					<td scope="row"><slot>&nbsp;</slot></td>
					<td  ><slot>&nbsp;</slot></td>
				</tr>
				<tr>
					<td width="17%" scope="row"><slot>{$MOD.LBL_TITLE}:</slot></td>
					<td width="33%" ><slot><input name='title' type="text" tabindex='5' size='15' maxlength='25' value='{$TITLE}' {$IS_ADMIN_DISABLED}></slot></td>
					<td width="17%" scope="row"><slot>{$MOD.LBL_OFFICE_PHONE}:</slot></td>
					<td width="33%" ><slot><input name='phone_work' type="text" tabindex='6' size='20' maxlength='25' value='{$PHONE_WORK}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>{$MOD.LBL_DEPARTMENT}:</slot></td>
					<td  ><slot><input name='department' type="text" tabindex='5' size='25' maxlength='100' value='{$DEPARTMENT}' {$IS_ADMIN_DISABLED}></slot></td>
					<td scope="row"><slot>{$MOD.LBL_MOBILE_PHONE}:</slot></td>
					<td  ><slot><input name='phone_mobile' type="text" tabindex='6' size='20' maxlength='25' value='{$PHONE_MOBILE}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>{$MOD.LBL_REPORTS_TO}:</slot></td>
					<td ><slot><input type="text" class="sqsEnabled" tabindex='5' name="reports_to_name" id="reports_to_name" value="{$REPORTS_TO_NAME}" autocomplete="off" {$IS_ADMIN_DISABLED}/>
						<input type="hidden" name="reports_to_id" id="reports_to_id" value="{$REPORTS_TO_ID}" tabindex="240"/>
						{$REPORTS_TO_CHANGE_BUTTON}</slot></td>
					<td scope="row"><slot>{$MOD.LBL_OTHER_PHONE}:</slot></td>
					<td  ><slot><input name='phone_other' type="text" tabindex='6' size='20' maxlength='25' value='{$PHONE_OTHER}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>&nbsp;</slot></td>
					<td  ><slot>&nbsp;</slot></td>
					<td scope="row"><slot>{$MOD.LBL_FAX}:</slot></td>
					<td  ><slot><input name='phone_fax' type="text" tabindex='6' size='20' maxlength='25' value='{$PHONE_FAX}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>&nbsp;</slot></td>
					<td  ><slot>&nbsp;</slot></td>
					<td scope="row"><slot>{$MOD.LBL_HOME_PHONE}:</slot></td>
					<td  ><slot><input name='phone_home' type="text" tabindex='6' size='20' maxlength='25' value='{$PHONE_HOME}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>{$MOD.LBL_MESSENGER_TYPE}:</slot></td>
					<td  ><slot>{$MESSENGER_TYPE_OPTIONS}</slot></td>
					<td scope="row"><slot>{$MOD.LBL_MESSENGER_ID}:</slot></td>
					<td  ><slot><input name='messenger_id' type="text" tabindex='6' size='35' maxlength='100' value='{$MESSENGER_ID}'></slot></td>
				</tr>
				{*<tr>
					<th align="left" scope="row" colspan="4"><h4><slot>{$MOD.LBL_ADDRESS_INFORMATION}</slot></h4></th>
				</tr>*}
				<tr>
					<td width="17%" scope="row"><slot>{$MOD.LBL_PRIMARY_ADDRESS}:</slot></td>
					<td width="33%" ><slot><textarea name='address_street' rows="2" tabindex='8' cols="30">{$ADDRESS_STREET}</textarea></slot></td>
					<td width="17%" scope="row"><slot>{$MOD.LBL_CITY}:</slot></td>
					<td width="33%" ><slot><input name='address_city' tabindex='8' size='15' maxlength='100' value='{$ADDRESS_CITY}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>{$MOD.LBL_STATE}:</slot></td>
					<td  ><slot><input name='address_state' tabindex='9' size='15' maxlength='100' value='{$ADDRESS_STATE}'></slot></td>
					<td scope="row"><slot>{$MOD.LBL_POSTAL_CODE}:</slot></td>
					<td  ><slot><input name='address_postalcode' tabindex='9' size='10' maxlength='20' value='{$ADDRESS_POSTALCODE}'></slot></td>
				</tr>
				<tr>
					<td scope="row"><slot>{$MOD.LBL_COUNTRY}:</slot></td>
					<td  ><slot><input name='address_country' tabindex='10' size='10' maxlength='20' value='{$ADDRESS_COUNTRY}'></slot></td>
				</tr>
				<tr>
					<td valign="top" scope="row"><slot>{$MOD.LBL_NOTES}:</slot></td>
					<td colspan="4"><slot><textarea name='description' tabindex='11' cols='100%' rows="4">{$DESCRIPTION}</textarea></slot></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>

<div id="settings" style="display:{$HIDE_FOR_GROUP_AND_PORTAL}">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th width="100%" align="left" scope="row" colspan="4"><h4><slot>{$MOD.LBL_USER_SETTINGS}</slot></h4></th>
				</tr>
				<tr>
					<td scope="row" width="17%"><slot>{$MOD.LBL_RECEIVE_NOTIFICATIONS}:</slot>&nbsp;{sugar_help text=$MOD.LBL_RECEIVE_NOTIFICATIONS_TEXT}</td>
					<td width="33%"><slot><input name='receive_notifications' class="checkbox" tabindex='12' type="checkbox" value="12" {$RECEIVE_NOTIFICATIONS}></slot></td>
					<td scope="row"  valign="top"><slot>{$MOD.LBL_EXPORT_DELIMITER}:</slot>&nbsp;{sugar_help text=$MOD.LBL_EXPORT_DELIMITER_DESC }</td>
                    <td ><slot><input type="text" tabindex='12' name="export_delimiter" value="{$EXPORT_DELIMITER}" size="5"></slot></td>
                </tr>

				<tr>
					<td  scope="row" valign="top"><slot>{$MOD.LBL_REMINDER}:</slot>&nbsp;{sugar_help text=$MOD.LBL_REMINDER_TEXT }</td>
					<td valign="top"  nowrap><slot>
						<input tabindex='12' name='mailmerge_on' type='hidden' value='0'>
						<input name='should_remind' size='2' maxlength='2' tabindex='12' onclick='toggleDisplay("should_remind_list");' type="checkbox" class="checkbox" value='1' {$REMINDER_CHECKED}>
						<div id='should_remind_list' style='display:{$REMINDER_TIME_DISPLAY}'>
							<select tabindex='12' name='reminder_time'  >{$REMINDER_TIME_OPTIONS}</select></div></slot></td>
					<td scope="row" valign="top"><slot>{$MOD.LBL_EXPORT_CHARSET}:</slot>&nbsp;{sugar_help text=$MOD.LBL_EXPORT_CHARSET_DESC }</td>
                  	<td ><slot><select tabindex='12' name="default_export_charset">{$EXPORT_CHARSET}</select></slot></td>
                </tr>
				<tr>
					<td scope="row" valign="top"><slot>{$MOD.LBL_USE_REAL_NAMES}:</slot>&nbsp;{sugar_help text=$MOD.LBL_USE_REAL_NAMES_DESC }</td>
                 	<td ><slot><input tabindex='12' type="checkbox" name="use_real_names" {$USE_REAL_NAMES}></slot></td>
                 	<td scope="row" valign="top"><slot>{$MOD.LBL_MAILMERGE}:</slot>&nbsp;{sugar_help text=$MOD.LBL_MAILMERGE_TEXT }</td>
					<td valign="top"  nowrap><slot><input tabindex='12' name='mailmerge_on' class="checkbox" type="checkbox" {$MAILMERGE_ON}></slot></td>
				</tr>


























				<!--{if !empty($EXTERNAL_AUTH_CLASS) && !empty($IS_ADMIN)}-->
					<tr>
						{capture name=SMARTY_LBL_EXTERNAL_AUTH_ONLY}&nbsp;{$MOD.LBL_EXTERNAL_AUTH_ONLY} {$EXTERNAL_AUTH_CLASS_1}{/capture}
						<td scope="row" nowrap><slot>{$EXTERNAL_AUTH_CLASS} {$MOD.LBL_ONLY}:</slot>&nbsp;{sugar_help text=$smarty.capture.SMARTY_LBL_EXTERNAL_AUTH_ONLY}</td>
						<td ><input type='hidden' value='0' name='external_auth_only'><input type='checkbox' value='1' name='external_auth_only' {$EXTERNAL_AUTH_ONLY_CHECKED}></td>
						<td ></td>
						<td ></td>
					</tr>
				<!--{/if}-->
			</table>
		</td>
	</tr>
</table>
</div>
<div id="edit_tabs" style="display:{$HIDE_FOR_GROUP_AND_PORTAL}">
<table class="edit view" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_LAYOUT_OPTIONS}</h4></th>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
			    		<td colspan="3">
			    			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			    				<tr>
						    		<td scope="row" align="left" style="padding-bottom: 2em;">{$TAB_CHOOSER}</td>
									<td width="90%" valign="top"><BR>&nbsp;</td>
								</tr>
							</table>
			    		</td>
					</tr>
					{capture name=SMARTY_SWAP_LAST_VIEWED_DESC}&nbsp;{$MOD.LBL_SWAP_LAST_VIEWED_DESCRIPTION} <i>{$MOD.LBL_SUPPORTED_THEME_ONLY}</i>{/capture}
					<tr>
						<td width="17%" scope="row"><span scope="row">{$MOD.LBL_MAX_TAB}:</span>&nbsp;{sugar_help text=$MOD.LBL_MAX_TAB_DESCRIPTION }</td>
						<td width="33%" ><input type="text" size="2" maxlength="2" name="user_max_tabs" value="{$MAX_TAB}" tabindex='12'></td>
						<td width="17%" scope="row"><span scope="row">{$MOD.LBL_SWAP_LAST_VIEWED_POSITION}:</span>&nbsp;{sugar_help text=$smarty.capture.SMARTY_SWAP_LAST_VIEWED_DESC }</td>
						<td width="33%"><input type="checkbox" name="user_swap_last_viewed" {$SWAP_LAST_VIEWED} tabindex='13'></td>
					</tr>
					{capture name=SMARTY_SWAP_SHORTCUT_DESC}&nbsp;{$MOD.LBL_SWAP_SHORTCUT_DESCRIPTION}<i>{$MOD.LBL_SUPPORTED_THEME_ONLY}</i>{/capture}
					<tr>
						<td scope="row"><span>{$MOD.LBL_MAX_SUBTAB}:</span>&nbsp;{sugar_help text=$MOD.LBL_MAX_SUBTAB_DESCRIPTION }</td>
						<td ><input type="text" size="2" maxlength="2" name="user_max_subtabs" value="{$MAX_SUBTAB}" tabindex='12'></td>
						<td scope="row"><span>{$MOD.LBL_SWAP_SHORTCUT_POSITION}:</span>&nbsp;{sugar_help text=$smarty.capture.SMARTY_SWAP_SHORTCUT_DESC }</td>
						<td ><input type="checkbox" name="user_swap_shortcuts" {$SWAP_SHORTCUT} tabindex='13'></td>
					</tr>
					{capture name=SMARTY_NAVIGATION_PARADIGM_DESC}&nbsp;{$MOD.LBL_NAVIGATION_PARADIGM_DESCRIPTION}<i>{$MOD.LBL_SUPPORTED_THEME_ONLY}</i>{/capture}
					<tr>
						<td scope="row"><span>{$MOD.LBL_SUBPANEL_TABS}:</span>&nbsp;{sugar_help text=$MOD.LBL_SUBPANEL_TABS_DESCRIPTION }</td>
						<td ><input type="checkbox" name="user_subpanel_tabs" {$SUBPANEL_TABS} tabindex='13'></td>
						<td scope="row"><span>{$MOD.LBL_SUBPANEL_LINKS}:</span>&nbsp;{sugar_help text=$MOD.LBL_SUBPANEL_LINKS_DESCRIPTION }</td>
						<td ><input type="checkbox" name="user_subpanel_links" {$SUBPANEL_LINKS} tabindex='13'></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</div>

<div id="locale" style="display:{$HIDE_FOR_GROUP_AND_PORTAL}">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th width="100%" align="left" scope="row" colspan="4">
                        <h4><slot>{$MOD.LBL_USER_LOCALE}</slot></h4></th>
                </tr>
                <tr>
                    <td width="17%" scope="row"><slot>{$MOD.LBL_DATE_FORMAT}:</slot>&nbsp;{sugar_help text=$MOD.LBL_DATE_FORMAT_TEXT }</td>
                    <td width="33%"><slot><select tabindex='14' name='dateformat'>{$DATEOPTIONS}</select></slot></td>
                    <!-- END: prompttz -->

	                <!-- BEGIN: currency -->
	                <td width="17%" scope="row"><slot>{$MOD.LBL_CURRENCY}:</slot>&nbsp;{sugar_help text=$MOD.LBL_CURRENCY_TEXT }</td>
	                    <td ><slot>
	                        <select tabindex='14' id='currency_select' name='currency' onchange='setSymbolValue(this.selectedIndex);setSigDigits();'>{$CURRENCY}</select>
	                        <input type="hidden" id="symbol" value="">
	                    </slot></td>
	                <!-- END: currency -->

                </tr>
                <tr>
                    <td scope="row"><slot>{$MOD.LBL_TIME_FORMAT}:</slot>&nbsp;{sugar_help text=$MOD.LBL_TIME_FORMAT_TEXT }</td>
                    <td ><slot><select tabindex='14' name='timeformat'>{$TIMEOPTIONS}</select></slot></td>

	                <!-- BEGIN: currency -->
	                <td width="17%" scope="row"><slot>
                        {$MOD.LBL_CURRENCY_SIG_DIGITS}:
                    </slot></td>
                    <td ><slot>
                        <select id='sigDigits' onchange='setSigDigits(this.value);' name='default_currency_significant_digits'>{$sigDigits}</select>
                    </slot></td>
	                <!-- END: currency -->

                </tr>
                <tr>
                    <td scope="row"><slot>{$MOD.LBL_TIMEZONE}:</slot>&nbsp;{sugar_help text=$MOD.LBL_TIMEZONE_TEXT }</td>
                    <td ><slot><select tabindex='14' name='timezone'>{$TIMEZONEOPTIONS}</select></slot></td>

	                <!-- BEGIN: currency -->
	                <td width="17%" scope="row"><slot>
                        <i>{$MOD.LBL_LOCALE_EXAMPLE_NAME_FORMAT}</i>:
                    </slot></td>
                    <td ><slot>
                        <input type="text" disabled id="sigDigitsExample" name="sigDigitsExample">
                    </slot></td>
	                <!-- END: currency -->

                </tr>
                {if ($IS_ADMIN)} 
                <tr>
                    <td scope="row"><slot>{$MOD.LBL_PROMPT_TIMEZONE}:</slot>&nbsp;{sugar_help text=$MOD.LBL_PROMPT_TIMEZONE_TEXT }</td>
                    <td ><slot><input type="checkbox" tabindex='14'class="checkbox" name="ut" value="0" {$PROMPTTZ}></slot></td>
                	<td width="17%" scope="row"><slot>{$MOD.LBL_NUMBER_GROUPING_SEP}:</slot>&nbsp;{sugar_help text=$MOD.LBL_NUMBER_GROUPING_SEP_TEXT }</td>
                    <td ><slot>
                        <input tabindex='14' name='num_grp_sep' id='default_number_grouping_seperator'
                            type='text' maxlength='1' size='1' value='{$NUM_GRP_SEP}' 
                            onkeydown='setSigDigits();' onkeyup='setSigDigits();'>
                    </slot></td></tr>
                {else}
                	<input type='hidden' name='num_grp_sep' id='default_number_grouping_seperator' value='{$NUM_GRP_SEP}'>
                {/if}
                {capture name=SMARTY_LOCALE_NAME_FORMAT_DESC}&nbsp;{$MOD.LBL_LOCALE_NAME_FORMAT_DESC}<br />{$MOD.LBL_LOCALE_NAME_FORMAT_DESC_2}{/capture}
				<tr>
                    <td  scope="row" valign="top">{$MOD.LBL_LOCALE_DEFAULT_NAME_FORMAT}:&nbsp;{sugar_help text=$smarty.capture.SMARTY_LOCALE_NAME_FORMAT_DESC }</td>
                    <td   valign="top">
                        <input onkeyup="setPreview();" onkeydown="setPreview();" id="default_locale_name_format" type="text" tabindex='14' name="default_locale_name_format" value="{$default_locale_name_format}">
                    </td>
                     <td width="17%" scope="row"><slot>{$MOD.LBL_DECIMAL_SEP}:</slot>&nbsp;{sugar_help text=$MOD.LBL_DECIMAL_SEP_TEXT }</td>
                    <td ><slot>
                        <input tabindex='14' name='dec_sep' id='default_decimal_seperator' 
                            type='text' maxlength='1' size='1' value='{$DEC_SEP}'
                            onkeydown='setSigDigits();' onkeyup='setSigDigits();'>
                    </slot></td>
                </tr>
                <tr>
                    <td  scope="row" valign="top"><i>{$MOD.LBL_LOCALE_EXAMPLE_NAME_FORMAT}:</i> </td>
                    <td   valign="top"><input tabindex='14' name="no_value" id="nameTarget" value="" disabled size="50"></td>        
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>








































<div id="calendar_options" style="display:{$HIDE_FOR_GROUP_AND_PORTAL}">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
	<tr>
		<th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_CALENDAR_OPTIONS}</h4></th>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="17%" scope="row"><slot>{$MOD.LBL_PUBLISH_KEY}:</slot>&nbsp;{sugar_help text=$MOD.LBL_CHOOSE_A_KEY}</td>
					<td width="20%" ><slot><input name='calendar_publish_key' tabindex='17' size='25' maxlength='25' type="text" value="{$CALENDAR_PUBLISH_KEY}"></slot></td>
					<td width="63%" ><slot>&nbsp;</slot></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>


<div style="padding-top:2px;">
	<input	id="Save" title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button" onclick="if (!set_password(form,newrules('{$PWDSETTINGS.minpwdlength}','{$PWDSETTINGS.maxpwdlength}','{$REGEX}'))) return false;Admin_check(); this.form.action.value='Save'; {$CHOOSER_SCRIPT} {$REASSIGN_JS} if(verify_data(EditView)) this.form.submit();" 
			type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " />
	<input	title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="this.form.action.value='{$RETURN_ACTION}'; this.form.module.value='{$RETURN_MODULE}'; this.form.record.value='{$RETURN_ID}'; this.form.submit();" 
			type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " />
</div>
<script type="text/javascript" language="Javascript">
{literal}

function Admin_check(){
	if (('{/literal}{$IS_FOCUS_ADMIN}{literal}') && document.getElementById('is_admin').value=='0'){
		r=confirm('{/literal}{$MOD.LBL_CONFIRM_REGULAR_USER}{literal}');
		return r;
		}
	else
		return true;
}

function user_status_display(field){
		switch (field.value){
		case 'Administrator':
		document.getElementById('UserTypeDesc').innerHTML="{/literal}{$MOD.LBL_ADMIN_DESC}{literal}";
		document.getElementById('is_admin').value='1';
		break;
		case 'RegularUser':
			document.getElementById('is_admin').value='0';
			document.getElementById('UserTypeDesc').innerHTML="{/literal}{$MOD.LBL_REGULAR_DESC}{literal}";
		break;
	}
}
{/literal}

</script>
{$JAVASCRIPT}
{literal}
<script type="text/javascript" language="Javascript">
{/literal}
{$getNameJs}
{$getNumberJs}
{$currencySymbolJs}
setSymbolValue(document.getElementById('currency_select').selectedIndex);
setSigDigits();

{$confirmReassignJs}
</script>

</form>
