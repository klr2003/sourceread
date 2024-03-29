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
<iframe id="yui-history-iframe" src="index.php?entryPoint=getImage&imageName=sugar-yui-sprites-grey.png"></iframe>
<input id="yui-history-field" type="hidden"> 
<div class='ytheme-gray' id='mblayout' style="position:relative; height:0px; overflow:visible;">
</div>
<div id='mbcenter'>
<div id='mbtabs'></div>
{$CENTER}
</div>

<div id='mbeast' class="x-layout-inactive-content">
{$PROPERTIES}
</div>
<div id='mbeast2' class="x-layout-inactive-content">
</div>
<div id='mbhelp' class="x-hidden"></div>
<div id='mbwest' class="x-hidden">
<div id='package_tree' class="x-hidden"></div>
{$TREE}
</div>
<div id='mbsouth' class="x-hidden">
</div>
{$tiny}
<script>
ModuleBuilder.setMode('{$TYPE}');
closeMenus();
{literal}
//document.getElementById('HideHandle').parentNode.style.display = 'none';
var MBLoader = new YAHOO.util.YUILoader({
    require : ["layout", "element", "tabview", "treeview", "history", "cookie", "sugarwidgets"],
    loadOptional: true,



    skin: "",
    onSuccess: ModuleBuilder.init,
    allowRollup: true,
    base: "include/javascript/yui/build/"
});
MBLoader.addModule({
    name :"sugarwidgets",
    type : "js",
    fullpath: "include/javascript/sugarwidgets/SugarYUIWidgets.js",
    varName: "YAHOO.SUGAR",
    requires: ["datatable", "dragdrop", "treeview", "tabview"]
});
MBLoader.insert();
{/literal}
</script>
<div id="footerHTML" class="y-hidden">
    <table width="100%" cellpadding="0" cellspacing="0"><tr><td>
    <input type="button" class="button" value="{$mod.LBL_HOME}" onclick="ModuleBuilder.main('home');">
    {if $TEST_STUDIO == true}
    <input type="button" class="button" value="{$mod.LBL_STUDIO}" onclick="ModuleBuilder.main('studio');">
    {/if}
    {if $ADMIN == true}
    <input type="button" class="button" value="{$mod.LBL_MODULEBUILDER}" onclick="ModuleBuilder.main('mb');">



    {/if}
    <input type="button" class="button" value="{$mod.LBL_DROPDOWNEDITOR}" onclick="ModuleBuilder.main('dropdowns');">
    </td><td align="right">



        <img height="18" width="83" class="img" src="include/images/powered_by_sugarcrm.gif" border="0" align="absmiddle"/>



    {$app_strings.LBL_SUGAR_COPYRIGHT}
    </td></tr></table>
</div>
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}
