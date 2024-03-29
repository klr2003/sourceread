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
var focus_obj=false;var label=SUGAR.language.get('app_strings','LBL_DEFAULT_LINK_TEXT');function remember_place(obj){focus_obj=obj;}
function showVariable(){document.EditView.variable_text.value=document.EditView.variable_name.options[document.EditView.variable_name.selectedIndex].value;}
function addVariables(the_select,the_module){the_select.options.length=0;for(var i=0;i<field_defs[the_module].length;i++){var new_option=document.createElement("option");new_option.value="$"+field_defs[the_module][i].name;new_option.text=field_defs[the_module][i].value;the_select.options.add(new_option,i);}
showVariable();}
function toggle_text_only(firstRun){if(typeof(firstRun)=='undefined')
firstRun=false;var text_only=document.getElementById('text_only');if(firstRun){setTimeout("tinyMCE.execCommand('mceAddControl', false, 'body_text');",500);var tiny=tinyMCE.getInstanceById('body_text');}
if(document.getElementById('toggle_textonly').checked==true){document.getElementById('body_text_div').style.display='none';document.getElementById('toggle_textarea_option').style.display='none';document.getElementById('toggle_textarea_elem').checked=true;document.getElementById('text_div').style.display='inline';text_only.value=1;}else{document.getElementById('body_text_div').style.display='inline';document.getElementById('toggle_textarea_option').style.display='inline';document.getElementById('toggle_textarea_elem').checked=false;document.getElementById('text_div').style.display='none';text_only.value=0;}}
function setTinyHTML(text){var tiny=tinyMCE.getInstanceById('body_text');if(tiny.getContent()!=null){tiny.setContent(text)}else{setTimeout(setTinyHTML(text),1000);}}
function stripTags(str){var theText=new String(str);if(theText!='undefined'){return theText.replace(/<\/?[^>]+>/gi,'');}}
function insert_variable_text(myField,myValue){if(document.selection){myField.focus();sel=document.selection.createRange();sel.text=myValue;}
else if(myField.selectionStart||myField.selectionStart=='0'){var startPos=myField.selectionStart;var endPos=myField.selectionEnd;myField.value=myField.value.substring(0,startPos)
+myValue
+myField.value.substring(endPos,myField.value.length);}else{myField.value+=myValue;}}
function insert_variable_html(text){var inst=tinyMCE.getInstanceById("body_text");if(inst)
inst.getWin().focus();inst.execCommand('mceInsertRawHTML',false,text);}
function insert_variable_html_link(text){the_label=document.getElementById('url_text').value;if(typeof(the_label)=='undefined'){the_label=label;}
var thelink="<a href='"+text+"' > "+the_label+" </a>";insert_variable_html(thelink);}
function insert_variable(text){if(document.getElementById('toggle_textonly').checked==true){insert_variable_text(document.getElementById('body_text_plain'),text);}else{insert_variable_html(text);}}
