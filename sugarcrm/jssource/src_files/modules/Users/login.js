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

function set_focus() {
	if (document.DetailView.user_name.value != '') {
		document.DetailView.user_password.focus();
		document.DetailView.user_password.select();
	}
	else document.DetailView.user_name.focus();
}

function toggleDisplay(id){

	if(this.document.getElementById(id).style.display=='none'){
		this.document.getElementById(id).style.display='inline'
		if(this.document.getElementById(id+"link") != undefined){
			this.document.getElementById(id+"link").style.display='none';
		}
        document.getElementById(id+"_options").src = 'index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=basic_search.gif';		
	}else{
		this.document.getElementById(id).style.display='none'
		if(this.document.getElementById(id+"link") != undefined){
			this.document.getElementById(id+"link").style.display='inline';
		}
	document.getElementById(id+"_options").src = 'index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=advanced_search.gif';	
	}
}


function generatepwd(){
	document.getElementById('generate_pwd_button').value='Please Wait';
	document.getElementById('generate_pwd_button').disabled =1;
	document.getElementById('wait_pwd_generation').innerHTML = '<img src="themes/default/images/img_loading.gif" >';
var callback;
       callback = {
			success: function(o){
			document.getElementById('generate_pwd_button').value=LBL_LOGIN_SUBMIT;
        	document.getElementById('generate_pwd_button').disabled =0;
        	document.getElementById('wait_pwd_generation').innerHTML = '';
			checkok=o.responseText;
			if (checkok.charAt(0) != '1')
				document.getElementById('generate_success').innerHTML =checkok;
			if (checkok.charAt((checkok.length)-1) == '1')
				document.getElementById('generate_success').innerHTML =LBL_REQUEST_SUBMIT;
			},
            failure: function(o){
            document.getElementById('generate_pwd_button').value= LBL_LOGIN_SUBMIT;
        	document.getElementById('generate_pwd_button').disabled =0;
			document.getElementById('wait_pwd_generation').innerHTML = '';
			alert("Ajax failure");
            }
        }   
    postData = '&to_pdf=1&module=Home&action=index&entryPoint=GeneratePassword&username='+document.getElementById("fp_user_name").value+'&user_email='+document.getElementById("fp_user_mail").value+'&link=1';
    YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);   
}
