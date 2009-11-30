/**
 * style.js javascript file
 *
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
 


/**
 * Handles changing the sub menu items when using grouptabs
 */
YAHOO.util.Event.onAvailable('subModuleList',IKEADEBUG);
function IKEADEBUG()
{
    var moduleLinks = document.getElementById('moduleList').getElementsByTagName("a");
    moduleLinkMouseOver = function() 
        {
            var matches      = /grouptab_([0-9]+)/i.exec(this.id);
            var tabNum       = matches[1];
            var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span"); 
            for (var i = 0; i < moduleGroups.length; i++) { 
                if ( i == tabNum ) {
                    moduleGroups[i].className = 'selected';
                }
                else {
                    moduleGroups[i].className = '';
                }
            }
            
            var groupList = document.getElementById('moduleList').getElementsByTagName("li");
			var currentGroupItem = tabNum;
            for (var i = 0; i < groupList.length; i++) {
                var aElem = groupList[i].getElementsByTagName("a")[0];
                if ( aElem == null ) {
                    // This is the blank <li> tag at the start of some themes, skip it
                    continue;
                }
                // notCurrentTabLeft, notCurrentTabRight, notCurrentTab
                var classStarter = 'notC';
                if ( aElem.id == "grouptab_"+tabNum ) {
                    // currentTabLeft, currentTabRight, currentTab
                    classStarter = 'c';
					currentGroupItem = i;
                }
                var spanTags = groupList[i].getElementsByTagName("span");
                for (var ii = 0 ; ii < spanTags.length; ii++ ) {
                    if ( spanTags[ii].className == null ) { continue; }
                    var oldClass = spanTags[ii].className.match(/urrentTab.*/);
                    spanTags[ii].className = classStarter + oldClass;
                }
            }
            ////////////////////////////////////////////////////////////////////////////////////////
			////update submenu position
			//get sub menu dom node
			var menuHandle = moduleGroups[tabNum];
			
			//get group tab dom node
			var parentMenu = groupList[currentGroupItem];

			if(menuHandle && parentMenu){
				updateSubmenuPosition(menuHandle , parentMenu);
			}
			////////////////////////////////////////////////////////////////////////////////////////
        };
    for (var i = 0; i < moduleLinks.length; i++) {
        moduleLinks[i].onmouseover = moduleLinkMouseOver;
    }
};

function updateSubmenuPosition(menuHandle , parentMenu){	
	var left='';
	if (left == "") {
		p = parentMenu;
		var left = 0;
		while(p&&p.tagName.toUpperCase()!='BODY'){
			left+=p.offsetLeft;
			p=p.offsetParent;
		}
	}

	//get browser width
	var bw = checkBrowserWidth();
	
	//If the mouse over on 'MoreMenu' group tab, stop the following function
	if(!parentMenu){
		return;
	}
	//Calculate left position of the middle of current group tab .
	var groupTabLeft = left + (parentMenu.offsetWidth / 2);
	var subTabHalfLength = 0;
	var children = menuHandle.getElementsByTagName('li');
	for(var i = 0; i< children.length; i++){
		//offsetWidth = width + padding + border
		if(children[i].className == 'subTabMore' || children[i].parentNode.className == 'cssmenu'){
			continue;
		}
		subTabHalfLength += parseInt(children[i].offsetWidth);
	}
	
	if(subTabHalfLength != 0){
		subTabHalfLength = subTabHalfLength / 2;
	}
	
	var totalLengthInTheory = subTabHalfLength + groupTabLeft;
	if(subTabHalfLength>0 && groupTabLeft >0){
		if(subTabHalfLength >= groupTabLeft){
			left = 1;
		}else{
			left = groupTabLeft - subTabHalfLength;
		}
	}
	
	//If the sub menu length > browser length
	if(totalLengthInTheory > bw){
		var differ = totalLengthInTheory - bw;
		left = groupTabLeft - subTabHalfLength - differ - 2;
	}
	
	if (left >=0){
		menuHandle.style.marginLeft = left+'px';
	}
}
/**
 * Handles loading the sitemap popup
 */
YAHOO.util.Event.onAvailable('sitemapLinkSpan',function()
{
    document.getElementById('sitemapLinkSpan').onclick = function()
    {
        ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING_PAGE'));
    
        var smMarkup = '';
        var callback = {
             success:function(r) {     
                 ajaxStatus.hideStatus();
                 document.getElementById('sm_holder').innerHTML = r.responseText;
                 with ( document.getElementById('sitemap').style ) {
                     display = "block";
                     position = "absolute";
                     right = 0;
                     top = 80;
                 }
                 document.getElementById('sitemapClose').onclick = function()
                 {
                     document.getElementById('sitemap').style.display = "none";
                 }
             } 
        } 
        postData = 'module=Home&action=sitemap&GetSiteMap=now&sugar_body_only=true';    
        YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);
    }
});

/**
 * Hides a part of the left column 
 */
YAHOO.util.Event.onAvailable('lastviewicon',function()
{
    if (document.getElementById('lastviewicon').style.display != 'none') {
        document.getElementById('lastviewicon').onclick = function()
        {
            document.getElementById('ul_lastview').style.display = 'none';
            document.getElementById('lastviewicon').style.display = 'none';
            document.getElementById('lastviewicon_1').style.display = 'inline';
            Set_Cookie('hide_leftlastview','true',30,'/','','');
        }
        document.getElementById('lastviewicon_1').onclick = function()
        {
            document.getElementById('ul_lastview').style.display = 'inline';
            document.getElementById('lastviewicon').style.display = 'inline';
            document.getElementById('lastviewicon_1').style.display = 'none';
            Set_Cookie('hide_leftlastview','false',30,'/','','');
        }
        if (!Get_Cookie('hide_leftlastview')) {
            Set_Cookie('hide_leftlastview','false',30,'/','','');
        }
        else {
            if ( Get_Cookie('hide_leftlastview') == 'true' ) {
                document.getElementById('lastviewicon').onclick();
            }
        }
    }
});
YAHOO.util.Event.onAvailable('newrecordicon',function()
{
    if (document.getElementById('newrecordicon').style.display != 'none') {
        document.getElementById('newrecordicon').onclick = function()
        {
            document.getElementById('newRecordForm').style.display = 'none';
            document.getElementById('newrecordicon').style.display = 'none';
            document.getElementById('newrecordicon_1').style.display = 'inline';
            Set_Cookie('hide_newrecord','true',30,'/','','');
        }
        document.getElementById('newrecordicon_1').onclick = function()
        {
            document.getElementById('newRecordForm').style.display = 'inline';
            document.getElementById('newrecordicon').style.display = 'inline';
            document.getElementById('newrecordicon_1').style.display = 'none';
            Set_Cookie('hide_newrecord','false',30,'/','','');
        }
        if (!Get_Cookie('hide_newrecord')) {
            Set_Cookie('hide_newrecord','false',30,'/','','');
        }
        else {
            if ( Get_Cookie('hide_newrecord') == 'true' ) {
                document.getElementById('newrecordicon').onclick();
            }
        }
 	}
});
YAHOO.util.Event.onAvailable('shortcuts_img',function()
{
 	if (document.getElementById('shortcuts_img').style.display != 'none') {
        document.getElementById('shortcuts_img').onclick = function()
        {
            document.getElementById('ul_shortcuts').style.display = 'none';
            document.getElementById('shortcuts_img').style.display = 'none';
            document.getElementById('shortcuts_img_1').style.display = 'inline';
            Set_Cookie('hide_leftshortcuts','true',30,'/','','');
        }
        document.getElementById('shortcuts_img_1').onclick = function()
        {
            document.getElementById('ul_shortcuts').style.display = 'inline';
            document.getElementById('shortcuts_img_1').style.display = 'none';
            document.getElementById('shortcuts_img').style.display = 'inline';
            Set_Cookie('hide_leftshortcuts','false',30,'/','','');
        }
        if (!Get_Cookie('hide_leftshortcuts')) {
            Set_Cookie('hide_leftshortcuts','false',30,'/','','');
        }
        else {
            if ( Get_Cookie('hide_leftshortcuts') == 'true' ) {
                document.getElementById('shortcuts_img').onclick();
            }
        }
    }
});

/**
 * hides and shows the left column menu, as well as shows mouseover popup when the menu isn't being shown
 */
YAHOO.util.Event.onContentReady('HideHandle',function()
{
    document.getElementById('HideHandle').onclick = function()
    {
        document.getElementById('HideMenu').style.visibility = 'hidden';
        if (document.getElementById("leftColumn").style.display == 'none') {
            document.getElementById("leftColumn").style.display = 'inline';
            document.getElementById("content").className = '';
            Set_Cookie('showLeftCol','true',30,'/','','');
            document['HideHandle'].src = SUGAR.themes.hide_image;
        }
        else {
            document.getElementById("leftColumn").style.display='none';
            document.getElementById("content").className = 'noLeftColumn';
            Set_Cookie('showLeftCol','false',30,'/','','');
            document['HideHandle'].src = SUGAR.themes.show_image;
        }
    }
    
    document.getElementById('HideHandle').onmouseover = function()
    {
        if(document.getElementById("leftColumn").style.display=='none'){
            tbButtonMouseOver('HideHandle',135,'',10);
        }
    }
});

/**
 * Checks on load if we should show the left column or not based on the cookie values
 */
YAHOO.util.Event.onContentReady('content',function()
{
   	if (!Get_Cookie('showLeftCol')) {
        Set_Cookie('showLeftCol','true',30,'/','','');
    }
    else {
        if ( Get_Cookie('showLeftCol') == 'false' && document.getElementById('HideHandle') != null) {
            document.getElementById('HideHandle').onclick();
        }
    }
});

/**
 * Hides the left column, but does not reset the cookie. Used when we need the extra screen space
 */
SUGAR.themes.tempHideLeftCol = function()
{
    document.getElementById('HideMenu').style.visibility = 'hidden';
    document.getElementById("leftColumn").style.display='none';
    document.getElementById("content").className = 'noLeftColumn';
    document['HideHandle'].src = SUGAR.themes.show_image;
}


SUGAR.themes.changeColor = function(colorName)
{
    document.getElementById('usercolor').value = colorName;
    document.getElementById('themepickerDialogForm').submit();
}

SUGAR.themes.changeFont = function(fontName)
{
    document.getElementById('userfont').value = fontName;
    document.getElementById('themepickerDialogForm').submit();
}

SUGAR.themes.hasIE6compat = function(themeName)
{
    return SUGAR.themes.allThemes[themeName]['ie6compat'];
}

/**
 * Handles loading the theme picker popup
 */
YAHOO.util.Event.onDOMReady(function()
{
	if (document.getElementById('themepickerDialog')) {
		SUGAR.themes.themepickerDialog = new YAHOO.widget.Dialog("themepickerDialog", { 
	        width: "250px",
	        //constraintoviewport: true,
	        visible: false, 
	        draggable: false,
	        modal: true
	        });
	                                                                             
	    SUGAR.themes.themepickerDialog.callback = 
	    {
	        success: function()
	        {
	            document.getElementById('themepickerDialogForm').submit();
	        }, 
	        failure: function()
	        {
	            SUGAR.themes.themepickerDialog.hide();
	        } 
	    };
	    
	    document.getElementById('themepickerDialog').style.display = '';                                            
	    SUGAR.themes.themepickerDialog.render();
	    
	    document.getElementById('themepickerLinkSpan').onclick = function()
	    {
	        SUGAR.themes.themepickerDialog.show();        	
	        SUGAR.themes.themepickerDialog.configFixedCenter(null, false) ;
	    }
        
        document.getElementById('usertheme').onchange = function()
        {
            if ( !(YAHOO.env.ua.ie > 5 && YAHOO.env.ua.ie < 7) 
                    || SUGAR.themes.hasIE6compat(this.value) 
                    || confirm(SUGAR.language.get('app_strings', 'LBL_THEME_PICKER_IE6COMPAT_CHECK')) )
                document.getElementById('usertheme').value = this.value;
                document.getElementById('themepickerDialogForm').submit();
        }
        
        document.getElementById('userthemegrouptabs').onchange = function()
        {
            document.getElementById('userthemegrouptabs').value = this.value;
            document.getElementById('themepickerDialogForm').submit();
        }
	}
    
    // open print dialog if we requested the print view
    if ( location.href.indexOf('print=true') > -1 )
        setTimeout("window.print();",  1000);
	
	////////////////////////////////////////////////////////////////////////////////////////
	////update current submenu position
	var moduleListDom = document.getElementById('moduleList');
	var parentTabLis = moduleListDom.getElementsByTagName("li");
	var tabNum = 0;
	for(var ii = 0; ii < parentTabLis.length; ii++){
		var spans = parentTabLis[ii].getElementsByTagName("span");
		for(var jj =0; jj < spans.length; jj++){
			if(spans[jj].className.match(/currentTab.*/)){
				tabNum = ii;
			}
		}
	}
	var parentMenu = parentTabLis[tabNum];
	
	var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span"); 
	for(var i = 0; i < moduleGroups.length; i++){
		if(moduleGroups[i].className.match(/selected/)){
			tabNum = i;
		}
	}
	var menuHandle = moduleGroups[tabNum];
	
	if(menuHandle && parentMenu){
		updateSubmenuPosition(menuHandle , parentMenu);
	}
	////////////////////////////////////////////////////////////////////////////////////////
});
