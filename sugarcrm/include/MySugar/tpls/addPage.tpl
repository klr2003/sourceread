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
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top: 0px none; margin-bottom: 4px;">
<tr>
<td>
<!-- BEGIN PAGE RENDERING -->
    <table cellspacing='5' cellpadding='0' border='0' valign='top' width='100%'>
 	<tr>
 		{if $numCols > 2}
	 	<td>
		&nbsp;
		</td>
	
		<td rowspan="3">
				<img src='{sugar_getimagepath file='blank.gif'}' width='15' height='1' border='0'>
		</td>
		{/if}
		{if $numCols > 1}
		<td>
		&nbsp;
		</td>
		<td rowspan="3">
				<img src='{sugar_getimagepath file='blank.gif'}' width='15' height='1' border='0'>
		</td>
		{/if}	
		<td align='right'>
	 		<a href='index.php?module=Administration&action=SupportPortal&view=documentation&version={$sugarVersion}&edition={$sugarFlavor}&lang={$currentLanguage}&help_module=Home&help_action=index&key={$serverUniqueKey}' class='utilsLink' target='_blank'>
				<img src='{sugar_getimagepath file="help.gif"}' width='13' height='13' alt='{$lblLnkHelp}' border='0' align='absmiddle'>
				{$lblLnkHelp}
			</a>
		</td>
	</tr>


    <tr>
    {counter assign=hiddenCounter start=0 print=false}
    {foreach from=$columns key=colNum item=data}
    <td valign='top' width={$data.width}>
        <ul class='noBullet' id='col_{$pageNum}_{$colNum}'>
            <li id='hidden{$hiddenCounter}b' style='height: 5px' class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
            <li id='hidden{$hiddenCounter}' style='height: 5px' class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
        </ul>
    </td>
    {counter}
    {/foreach}
    </tr>
    </table>
<!-- END PAGE RENDERING -->
</td>
</tr>
</table>

{literal}
<script type="text/javascript">
newPage_{/literal}{$pageNum}{literal}_dd = new Array();
activePage = {/literal}{$pageNum}{literal};
j = 0;
for(var wp = 0; wp <= {/literal}{$hiddenCounter}{literal}; wp++) {
    newPage_{/literal}{$pageNum}{literal}_dd[j++] = new ygDDListBoundary('hidden' + wp);
}
{/literal}
YAHOO.util.DDM.mode = 1;

</script>
