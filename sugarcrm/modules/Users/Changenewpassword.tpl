{*

/**
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



*}
{literal}
<head><title>SugarCRM</title></head><body>



<script type='text/javascript' src='include/javascript/sugar_3.js'></script>
<script type='text/javascript'>
var ERR_RULES_NOT_MET = '{/literal}{$MOD.ERR_RULES_NOT_MET}{literal}';
var ERR_ENTER_OLD_PASSWORD = '{/literal}{$MOD.ERR_ENTER_OLD_PASSWORD}{literal}';
var ERR_ENTER_NEW_PASSWORD = '{/literal}{$MOD.ERR_ENTER_NEW_PASSWORD}{literal}';
var ERR_ENTER_CONFIRMATION_PASSWORD = '{/literal}{$MOD.ERR_ENTER_CONFIRMATION_PASSWORD}{literal}';
var ERR_REENTER_PASSWORDS = '{/literal}{$MOD.ERR_REENTER_PASSWORDS}{literal}';
</script>
<script type='text/javascript' src='modules/Users/PasswordRequirementBox.js'></script>

<script type="text/javascript" language="JavaScript">
function set_focus() {
	if (document.DetailView.user_name.value != '') {
		document.DetailView.user_password.focus();
		document.DetailView.user_password.select();
	}
	else document.DetailView.user_name.focus();
}

	</script>
	<style type="text/css">
	
	.body { 
		font-size: 12px;
		}
		
	.buttonLogin {
		border: 1px solid #444444;
		font-size: 11px;
		color: #ffffff;
		background-color: #666666;
		font-weight: bold;
		}
		
	table.tabForm td {
	border: none;
	}
		
	table,td {
		}
	
	p {
		MARGIN-TOP: 0px;
		MARGIN-BOTTOM: 10px;
		}
		
	form {
		margin: 0px;
		}
		
		
	#recaptcha_image {
        height: 47.5px !important;
        width: 250px !important;
		}

	#recaptcha_image img {
        height: 47.5px;
        width: 250px;
		} 	
{/literal}
	</style><br>
	<br>
	
<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0">
<tr>
<td>
<table cellpadding="0"  cellspacing="0" border="0" align="center">
<form action="index.php" method="post" name="form" id="form" onsubmit="return document.getElementById('cant_login').value == ''">
<tr>
<td style="padding-bottom: 10px;" ><b>{$MOD.LBL_LOGIN_WELCOME_TO}</b><br>
<IMG src="{$sugar_md}" alt="Sugar" width="340" height="25"></td>
</tr>
<tr>
<td class="edit view" align="center">

		<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
		<tr>
			<td scope="row" colspan="2" width="100%" style="font-size: 12px; padding-bottom: 5px; font-weight: normal;">{$INSTRUCTION}</td>
		</tr>
			<input type="hidden" name="entryPoint" value="{$ENTRY_POINT}">
			<input type='hidden' name='action' value="{$ACTION}"/>
			<input type='hidden' name='module' value="{$MODULE}"/>
			<input type="hidden" name="guid" value="{$GUID}">
			<input type="hidden" name="return_module" value="Home">
			<input type="hidden" name="login" value="1">
			<input type="hidden" name="is_admin" value="{$IS_ADMIN}">
			<input type="hidden" name="cant_login" id="cant_login" value="">
			<input type="hidden" name="old_password" id="old_password" value="">
			<input type="hidden" name="password_change" id="password_change" value="true">
			<input type="hidden" value="" name="user_password" id="user_password"/>
			<input type="hidden" name="page" value="Change">
			<input type="hidden" name="return_id" value="{$ID}">
			<input type="hidden" name="return_action" value="{$return_action}">
			<input type="hidden" name="record" value="{$ID}">
			<input type="hidden" name="user_name" value="{$USER_NAME}">
			<input type='hidden' name='saveConfig' value='0'/>
		<tr>
			<td scope="row" colspan='2'><span id='post_error' class="error">{$EXPIRATION_TYPE}&nbsp;</span></td>
		</tr>
		
		<tr>
		{if $OLD_PASSWORD_FIELD == '' &&  $USERNAME_FIELD == '' }
		<td scope="row" width="30%"></td><td></td>
		{/if}
			{$OLD_PASSWORD_FIELD}
			{$USERNAME_FIELD}





		</tr>
		<tr>
			<td scope="row">{$MOD.LBL_NEW_PASSWORD}:</td>
			<td width="30%"><input type="password" size="26" tabindex="2" id="new_password" name="new_password" value="" onkeyup="password_confirmation();newrules('{$PWDSETTINGS.minpwdlength}','{$PWDSETTINGS.maxpwdlength}','{$REGEX}');"</td>
		</tr>
		<tr>
			<td scope="row">{$MOD.LBL_NEW_PASSWORD2}:</td>
			<td width="30%"><input type="password" size="26" tabindex="2" id="confirm_pwd" name="confirm_pwd" value="" onkeyup="password_confirmation();"> <div id="comfirm_pwd_match" class="error" style="display: none;">mis-match</div></td>
		</tr>
			{$CAPTCHA}
		</tr>
		</tr><td>&nbsp;</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			{$SUBMIT_BUTTON}
			</td>		
		</tr>
		</table>
	</td>
	</form>
</tr>
</table>
</td>
</tr>

</table><br>
<br>
