{*
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
*}
<form method='POST' name='EditView' id='ACLEditView'>
<input type='hidden' name='record' value='{$ROLE.id}'>
<input type='hidden' name='module' value='ACLRoles'>
<input type='hidden' name='action' value='Save'>
<input type='hidden' name='return_record' value='{$RETURN.record}'>
<input type='hidden' name='return_action' value='{$RETURN.action}'>
<input type='hidden' name='return_module' value='{$RETURN.module}'> 
<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value='Save';aclviewer.save('ACLEditView');return false;" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " > &nbsp;
<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"   class='button' accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" type='button' name='save' value="  {$APP.LBL_CANCEL_BUTTON_LABEL} " class='button' onclick='aclviewer.view("{$ROLE.id}", "All");'>
</p>
<p>
</p>
<TABLE width='100%' class='detail view' border='0' cellpadding=0 cellspacing = 1  >
<TR>
<td></td>

{foreach from=$ACTION_NAMES item="ACTION_NAME" }
	<td align='center'><div align='center'><b>{$ACTION_NAME}</b></div></td>
{foreachelse}

          <td colspan="2">&nbsp;</td>

{/foreach}
</TR>
{literal}

	{/literal}
{foreach from=$CATEGORIES item="TYPES" key="CATEGORY_NAME"}

	{if $APP_LIST.moduleList[$CATEGORY_NAME]!='Users'}

	<TR>
	<td nowrap width='1%'><b>
	{if $APP_LIST.moduleList[$CATEGORY_NAME]=='Users'}
	   {$MOD.LBL_USER_NAME_FOR_ROLE}
	{elseif !empty($APP_LIST.moduleList[$CATEGORY_NAME])}
	   {$APP_LIST.moduleList[$CATEGORY_NAME]}
	{else}
        {$CATEGORY_NAME}
	{/if}
	</b></td>
	{foreach from=$ACTION_NAMES item="ACTION_LABEL" key="ACTION_NAME"}
		{assign var='ACTION_FIND' value='false'}
		{foreach from=$TYPES item="ACTIONS"}
			{foreach from=$ACTIONS item="ACTION" key="ACTION_NAME_ACTIVE"}
				{if $ACTION_NAME==$ACTION_NAME_ACTIVE}
					<td nowrap width='{$TDWIDTH}%' style="text-align: center;">
					<div  style="display: none" id="{$ACTION.id}">
					{if $APP_LIST.moduleList[$CATEGORY_NAME]==$APP_LIST.moduleList.Users && $ACTION_LABEL !='Access Type'}
					<select DISABLED name='act_guid{$ACTION.id}' id = 'act_guid{$ACTION.id}' onblur="document.getElementById('{$ACTION.id}link').innerHTML=this.options[this.selectedIndex].text; aclviewer.toggleDisplay('{$ACTION.id}');" >
                    {html_options options=$ACTION.accessOptions selected=$ACTION.aclaccess }
                    </select>
					{else}
					<select name='act_guid{$ACTION.id}' id = 'act_guid{$ACTION.id}' onblur="document.getElementById('{$ACTION.id}link').innerHTML=this.options[this.selectedIndex].text; aclviewer.toggleDisplay('{$ACTION.id}');" >
					{html_options options=$ACTION.accessOptions selected=$ACTION.aclaccess }
					</select>
					{/if}
					</div>
					{if $ACTION.accessLabel == 'dev' || $ACTION.accessLabel == 'admin_dev'}
					   <div class="aclAdmin"  id="{$ACTION.id}link" onclick="aclviewer.toggleDisplay('{$ACTION.id}')">{$ACTION.accessName}</div>
					{else}
                       <div class="acl{$ACTION.accessName}"  id="{$ACTION.id}link" onclick="aclviewer.toggleDisplay('{$ACTION.id}')">{$ACTION.accessName}</div>
                    {/if}
					</td>
					{assign var='ACTION_FIND' value='true'}
				{/if}
			{/foreach}
		{/foreach}
		{if $ACTION_FIND=='false'}
			<td nowrap width='{$TDWIDTH}%' style="text-align: center;">
			<div><font color='red'>N/A</font></div>
			</td>
		{/if}
	{/foreach}
	</TR>

    {/if}

{foreachelse}
    <tr> <td colspan="2">No Actions Defined</td></tr>
{/foreach}
</TABLE>
<div style="padding-top:10px;">
&nbsp;<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value='Save';aclviewer.save('ACLEditView');return false;" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " > &nbsp;
<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"   class='button' accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" type='button' name='save' value="  {$APP.LBL_CANCEL_BUTTON_LABEL} " class='button' onclick='aclviewer.view("{$ROLE.id}", "All");'>
</div>
</form>
