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
if(typeof(SimpleList) == 'undefined'){
	var Dom = YAHOO.util.Dom;
    SimpleList = function(){
        var editImage;
        var deleteImage;
        var ul_list;
        var jstransaction;
        var lastEdit;
        var isIE = isSupportedIE();
        return {
    init: function(editImage, deleteImage) {
        var ul = document.getElementById('ul1', 'drpdwn');
        SimpleList.lastEdit = null; // Bug 14662
        SimpleList.editImage = editImage;
        SimpleList.deleteImage = deleteImage;
        new YAHOO.util.DDTarget("ul1");
           
        for (i=0;i<SimpleList.ul_list.length;i++){
            if ( typeof SimpleList.ul_list[i] != "number" && SimpleList.ul_list[i] == "" ) {
                SimpleList.ul_list[i] = SUGAR.language.get('ModuleBuilder', 'LBL_BLANK');
            }
            new Studio2.ListDD(SimpleList.ul_list[i], 'drpdwn', false);
        }
        YAHOO.util.Event.on("dropdownaddbtn", "click", this.addToList);
        SimpleList.jstransaction = new JSTransaction();
        SimpleList.jstransaction.register('deleteDropDown', SimpleList.undoDeleteDropDown, SimpleList.undoDeleteDropDown);
        SimpleList.jstransaction.register('changeDropDownValue', SimpleList.undoDropDownChange, SimpleList.redoDropDownChange);

    },
    addToList : function(){
        var drop_name = document.getElementById('drop_name');
        var drop_value = document.getElementById('drop_value');

            var ul1=YAHOO.util.Dom.get("ul1");

            var items = ul1.getElementsByTagName("li");
            for (i=0;i<items.length;i=i+1) {
                if(items[i].id == drop_name.value){
                    alert("Key already exists in list");
                    return;
                }
            }

            liObj = document.createElement('li');
            liObj.className = "draggable";
            if(drop_name.value == '' || !drop_name.value){
                liObj.id = SUGAR.language.get('ModuleBuilder', 'LBL_BLANK');
            }else{
                liObj.id = drop_name.value;
            }

            var text1 = document.createElement('input');
            text1.type = 'hidden';
            text1.id = 'value_' + liObj.id;
            text1.name = 'value_' + liObj.id;
            text1.value = drop_value.value;

            var html = "<table width='100%'><tr><td><b>"+liObj.id+"</b><input id='value_"+liObj.id+"' value=\""+drop_value.value+"\" type = 'hidden'><span class='fieldValue' id='span_"+liObj.id+"'>";
            if(drop_value.value == ""){
                html += "[" + SUGAR.language.get('ModuleBuilder', 'LBL_BLANK') + "]";
            }else{
                html += "["+drop_value.value+"]";
            }
            html += "</span>";
            html += "<span class='fieldValue' id='span_edit_"+liObj.id+"' style='display:none'>";
            html += "<input type='text' id='input_"+liObj.id+"' value=\""+drop_value.value+"\" onchange='SimpleList.setDropDownValue(\""+liObj.id+"\", unescape(this.value), true)' >";
            html += "</span>";
            html += "</td><td align='right'><a href='javascript:void(0)' onclick='SimpleList.editDropDownValue(\""+liObj.id+"\", true)'>"+SimpleList.editImage+"</a>";
            html += "&nbsp;<a href='javascript:void(0)' onclick='SimpleList.deleteDropDownValue(\""+liObj.id+"\", true)'>"+SimpleList.deleteImage+"</a>";
            html += "</td></tr></table>";

            liObj.innerHTML = html;
            ul1.appendChild(liObj);
            new Studio2.ListDD(liObj, 'drpdwn', false);
            drop_value.value = "";
            drop_name.value = "";
            drop_name.focus();

    },
 
    sortAscending: function ()
    {
        // now sort using a Shellsort - do this rather than by using the inbuilt sort function as we need to sort a complex DOM inplace
        var parent = YAHOO.util.Dom.get("ul1");
        var items = parent.getElementsByTagName("li") ;
        var increment = Math.floor ( items.length / 2 ) ;
        
        function swapItems(itemA, itemB) {
        	var placeholder = document.createElement ( "li" ) ;
            Dom.insertAfter(placeholder, itemA);
            Dom.insertBefore(itemA, itemB);
            Dom.insertBefore(itemB, placeholder);
            
            //Cleanup the placeholder element
            parent.removeChild(placeholder);
        }
        
        while ( increment > 0 )
        {
        	for (var i = increment; i < items.length; i++)
        	{
            	var j = i;
            	var id = items[i].id;
            	var iValue = document.getElementById( 'input_' + id ).value.toLowerCase() ;
              
            	while ( ( j >= increment ) && ( document.getElementById( 'input_' + items [j-increment].id ).value.toLowerCase() > iValue ) )
            	{
            		// logically, this is what we need to do: items [j] = items [j - increment];
            		// but we're working with the DOM through a NodeList (items) which is readonly, so things aren't that simple
            		// A placeholder will be used to keep track of where in the DOM the swap needs to take place
            		// especially with IE which enforces the prohibition on duplicate Ids, so copying nodes is problematic
            		swapItems(items [j], items [j - increment]);
                	j = j - increment;
            	}
            }
             
            if (increment == 2)
            	increment = 1;
            else 
            	increment = Math.floor (increment / 2.2);
        }
    },
    sortDescending: function ()
    {
        this.sortAscending();
        var reverse = function ( children )
        {
            var parent = children [ 0 ] . parentNode ;
            var start = 0;
            if ( children [ 0 ].id == '-blank-' ) // don't include -blank- element in the sort
                start = 1 ;
            for ( var i = children.length - 1 ; i >= start ; i-- )
            {
                parent.appendChild ( children [ i ] ) ;
            }
        };
        reverse ( YAHOO.util.Dom.get("ul1").getElementsByTagName("li") ) ;
    },
    handleSave:function(){
         var parseList = function(ul, title) {
            var items = ul.getElementsByTagName("li");
            var out = [];
            for (i=0;i<items.length;i=i+1) {
                var name = items[i].id;
                var value = document.getElementById('input_'+name).value;
                out[i] = [ name , value ];
            }
            return YAHOO.lang.JSON.stringify(out);
        };
        var ul1=YAHOO.util.Dom.get("ul1");
        for(j = 0; j < SimpleList.jstransaction.JSTransactions.length; j++){
            if(SimpleList.jstransaction.JSTransactions[j]['transaction'] == 'deleteDropDown'){
                var liEl = new YAHOO.util.Element(SimpleList.jstransaction.JSTransactions[j]['data']['id']);
                if(liEl && liEl.hasClass('deleted'))
                	ul1.removeChild(liEl.get("element"));
            }
        }
        var list = document.getElementById('list_value');

        var out = parseList(ul1, "List 1");
        list.value = out;
        ModuleBuilder.refreshDD_name = document.getElementById('dropdown_name').value;
        if (document.forms.popup_form)
        {
            ModuleBuilder.handleSave("dropdown_form", ModuleBuilder.refreshDropDown);
        }
        else
        {
            ModuleBuilder.handleSave("dropdown_form", ModuleBuilder.refreshGlobalDropDown);
        }
    },
    deleteDropDownValue : function(id, record){
        var field = new YAHOO.util.Element(id);
        if(record != null){
            SimpleList.jstransaction.record('deleteDropDown',{'id': id });
        }
        if (field.hasClass('deleted'))
            field.removeClass('deleted');
        else
            field.addClass('deleted');
    },
    editDropDownValue : function(id, record){
        //Close any other dropdown edits
        if (SimpleList)
            SimpleList.endCurrentDropDownEdit();
        var dispSpan = document.getElementById('span_'+id);
        var editSpan = document.getElementById('span_edit_'+id);
        dispSpan.style.display = 'none';

        if(SimpleList.isIE){
            editSpan.style.display = 'inline-block';
        }else{
            editSpan.style.display = 'inline';
        }
        var textbox = document.getElementById('input_'+id);
        textbox.focus();
        SimpleList.lastEdit = id;
    },
    endCurrentDropDownEdit : function() {
        if (SimpleList.lastEdit != null)
        {
            var valueLastEdit = unescape(document.getElementById('input_'+SimpleList.lastEdit).value);
            SimpleList.setDropDownValue(SimpleList.lastEdit,valueLastEdit,true);
        }
    },
    setDropDownValue : function(id, val, record){

        if(record){
            SimpleList.jstransaction.record('changeDropDownValue', {'id':id, 'new':val, 'old':document.getElementById('value_'+ id).value});
        }
        var dispSpan = document.getElementById('span_'+id);
        var editSpan = document.getElementById('span_edit_'+id);
        var textbox = document.getElementById('input_'+id);

        dispSpan.style.display = 'inline';
        editSpan.style.display = 'none';
        dispSpan.innerHTML = "["+val+"]";
        document.getElementById('value_'+ id).value = val;
        SimpleList.lastEdit = null; // Bug 14662 - clear the last edit point behind us
    },
    undoDeleteDropDown : function(transaction){

        SimpleList.deleteDropDownValue(transaction['id'], false);
    },
    undoDropDownChange : function(transaction){
        SimpleList.setDropDownValue(transaction['id'], transaction['old'], false);
    },
    redoDropDownChange : function(transaction){
        SimpleList.setDropDownValue(transaction['id'], transaction['new'], false);
    },
    undo : function(){
        SimpleList.jstransaction.undo();
    },
    redo : function(){
        SimpleList.jstransaction.redo();
    }
}//return
}();
}
