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
<input type="text" name="{{sugarvar key='name'}}"  class={{if empty($displayParams.class) }}"sqsEnabled"{{else}} "{{$displayParams.class}}" {{/if}} tabindex="{{$tabindex}}" id="{{sugarvar key='name'}}" size="{{$displayParams.size}}" value="{{sugarvar key='value'}}" title='{{$vardef.help}}' autocomplete="off" {{$displayParams.readOnly}} {{$displayParams.field}}>
<input type="hidden" {{if $displayParams.useIdSearch}}name="{{sugarvar memberName='vardef.id_name' key='name'}}"{{/if}} id="{{sugarvar memberName='vardef.id_name' key='name'}}" value="{{sugarvar memberName='vardef.id_name' key='value'}}">
{{if empty($displayParams.hideButtons) }}
{{if empty($displayParams.clearOnly) }}
<input type="button" name="btn_{{sugarvar key='name'}}" tabindex="{{$tabindex}}" title="{$APP.LBL_SELECT_BUTTON_TITLE}" accessKey="{$APP.LBL_SELECT_BUTTON_KEY}" class="button" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("{{sugarvar key='module'}}", 600, 400, "", true, false, {{$displayParams.popupData}}, "single", true);'>
{{/if}}
{{if empty($displayParams.selectOnly) }}
<input type="button" name="btn_clr_{{sugarvar key='name'}}" tabindex="{{$tabindex}}" title="{$APP.LBL_CLEAR_BUTTON_TITLE}" accessKey="{$APP.LBL_CLEAR_BUTTON_KEY}" class="button" onclick="this.form.{{sugarvar key='name'}}.value = ''; this.form.{{sugarvar memberName='vardef.id_name' key='name'}}.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">
{{/if}}
{{/if}}
{{if !empty($displayParams.allowNewValue) }}
<input type="hidden" name="{{sugarvar key='name'}}_allow_new_value" id="{{sugarvar key='name'}}_allow_new_value" value="true">
{{/if}}
