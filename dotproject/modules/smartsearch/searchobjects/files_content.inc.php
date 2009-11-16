<?php /* SMARTSEARCH$Id: files_content.inc.php 5690 2008-04-30 00:50:20Z merlinyoda $ */
if (!defined('DP_BASE_DIR')){
  die('You should not access this file directly.');
}

/*
 Files_content class
*/
class files_content extends smartsearch 
{
	var $table = 'files_index';
	var $table_module = 'files';
	var $table_key = 'file_id';
	var $table_link = 'fileviewer.php?file_id=';
	var $table_title = 'Files Content';
	var $table_orderby = 'word_placement';
	var $follow_up_link = 'fileviewer.php?file_id=';
	var $search_fields = array('word');
	var $display_fields = array('word');

	function cfiles_content (){
		return new files_content();
	}
}
?>
