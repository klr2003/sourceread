<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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



require_once( 'include/utils/progress_bar_utils.php' );
require_once( 'include/utils/zip_utils.php' );



global $skip_md5_diff;
$skip_md5_diff = false;

set_time_limit(3600);
// get all needed globals
global $app_strings;
global $app_list_strings;
global $mod_strings;

global $theme;


global $db;
if(empty($db)) {

	$db = DBManagerFactory::getInstance();
}

global $current_user;
if(!is_admin($current_user)){
	die($mod_strings['LBL_DIAGNOSTIC_ACCESS']);
}
global $sugar_config;
global $beanFiles;



//get sugar version and flavor
global $sugar_version;
global $sugar_flavor;


//guid used for directory path
global $sod_guid;
$sod_guid = create_guid();

//GET CURRENT DATETIME STAMP TO USE IN FILENAME
global $curdatetime;
$curdatetime = date("Ymd-His");


global $progress_bar_percent;
$progress_bar_percent = 0;
global $totalweight;
$totalweight = 0;
global $totalitems;
$totalitems = 0;
global $currentitems;
$currentitems = 0;
define("CONFIG_WEIGHT", 1);
define("CUSTOM_DIR_WEIGHT", 1);
define("PHPINFO_WEIGHT", 1);
define("MYSQL_DUMPS_WEIGHT", 2);
define("MYSQL_SCHEMA_WEIGHT", 3);
define("MYSQL_INFO_WEIGHT", 1);
define("MD5_WEIGHT", 5);
define("BEANLISTBEANFILES_WEIGHT", 1);
define("SUGARLOG_WEIGHT", 2);
define("VARDEFS_WEIGHT", 2);

//THIS MUST CHANGE IF THE NUMBER OF DIRECTORIES TRAVERSED TO GET TO
//   THE DIAGNOSTIC CACHE DIR CHANGES
define("RETURN_FROM_DIAG_DIR", "../../../..");

global $getDumpsFrom;
$getDumpsFrom = Array();

global $cacheDir;
$cacheDir = "";

function sodUpdateProgressBar($itemweight){
    global $progress_bar_percent;
    global $totalweight;
    global $totalitems;
    global $currentitems;

    $currentitems++;
    if($currentitems == $totalitems)
      update_progress_bar("diagnostic", 100, 100);
    else
    {
      $progress_bar_percent += ($itemweight / $GLOBALS['totalweight'] * 100);
      update_progress_bar("diagnostic", $progress_bar_percent, 100);
    }
}


// expects a string containing the name of the table you would like to get the dump of
// expects there to already be a connection to mysql and the 'use database_name' to be done
// returns a string containing (in html) the dump of all rows
function getFullTableDump($tableName){

	global $db;

	$returnString = "<table border=\"1\">";
	$returnString .= "<tr><b><center>Table ".$tableName."</center></b></tr>";
	//get table field definitions
	$definitions = array();
	$def_result = $db->query("describe ".$tableName);
	if(!$def_result)
	{
		return mysql_error();
	}
	else
	{
		$returnString .= "<tr><td><b>Row Num</b></td>";
		$def_count = 0;
		while($row = $db->fetchByAssoc($def_result))
		{
			$row = array_values($row);
			$definitions[$def_count] = $row[0];
			$def_count++;
			$returnString .= "<td><b>".$row[0]."</b></td>";
		}
		$returnString .= "</tr>";
	}

	$td_result = $db->query("select * from ".$tableName);
	if(!$td_result)
	{
		return mysql_error();
	}
	else
	{
		$row_counter = 1;
		while($row = $db->fetchByAssoc($td_result))
		{
			$row = array_values($row);
			$returnString .= "<tr>";
			$returnString .= "<td>".$row_counter."</td>";
			for($counter = 0; $counter < $def_count; $counter++){

			$replace_val = false;
			//perform this check when counter is set to two, which means it is on the 'value' column
			if($counter == 2){
				//if the previous "name" column value was set to smtppass, set replace_val to true 
				if(strcmp($row[$counter - 1], "smtppass") == 0  )
					$replace_val = true;
				
				//if the previous "name" column value was set to smtppass, 
				//and the "category" value set to ldap, set replace_val to true
				if (strcmp($row[$counter - 2], "ldap") == 0 && strcmp($row[$counter - 1], "admin_password") == 0)
					$replace_val = true;
					
				//if the previous "name" column value was set to password, 
				//and the "category" value set to proxy, set replace_val to true
				if(strcmp($row[$counter - 2], "proxy") == 0 && strcmp($row[$counter - 1], "password") == 0 )
					$replace_val = true;				
			}

			if($replace_val)				
					$returnString .= "<td>********</td>";
				else
					$returnString .= "<td>".($row[$counter] == "" ? "&nbsp;" : $row[$counter])."</td>";
			}
			$row_counter++;
			$returnString .= "</tr>";
		}
	}
	$returnString .= "</table>";

	return $returnString;

}

// Deletes the directory recursively
function deleteDir($dir)
{
   if (substr($dir, strlen($dir)-1, 1) != '/')
       $dir .= '/';

   if ($handle = opendir($dir))
   {
       while ($obj = readdir($handle))
       {
           if ($obj != '.' && $obj != '..')
           {
               if (is_dir($dir.$obj))
               {
                   if (!deleteDir($dir.$obj))
                       return false;
               }
               elseif (is_file($dir.$obj))
               {
                   if (!unlink($dir.$obj))
                       return false;
               }
           }
       }

       closedir($handle);

       if (!@rmdir($dir))
           return false;
       return true;
   }
   return false;
}


function prepareDiag()
{
	global $getDumpsFrom;
	global $cacheDir;
	global $curdatetime;
	global $progress_bar_percent;
	global $skip_md5_diff;
	global $sod_guid;
	global $mod_strings;

	echo get_module_title("Administration", $mod_strings['LBL_DIAGNOSTIC_TITLE'], true);
	echo "<BR>";
	echo $mod_strings['LBL_DIAGNOSTIC_EXECUTING'];
	echo "<BR>";


	//determine if files.md5 exists or not
	if(file_exists('files.md5'))
		$skip_md5_diff = false;
	else
		$skip_md5_diff = true;

	// array of all tables that we need to pull rows from below
	$getDumpsFrom = array('config' => 'config',
	                      'fields_meta_data' => 'fields_meta_data',
	                      'upgrade_history' => 'upgrade_history',
	                      'versions' => 'versions',
	                      );


	//Creates the diagnostic directory in the cache directory
    $cacheDir = create_cache_directory("diagnostic/");
    $cacheDir = create_cache_directory("diagnostic/".$sod_guid);
    $cacheDir = create_cache_directory("diagnostic/".$sod_guid."/diagnostic".$curdatetime."/");

	display_progress_bar("diagnostic", $progress_bar_percent, 100);

	ob_flush();
}

function executesugarlog()
{
    //BEGIN COPY SUGARCRM.LOG
    //Copies the Sugarcrm log to our diagnostic directory
    global $cacheDir;
	require_once('include/SugarLogger/SugarLogger.php');
	$logger = new SugarLogger();
    if(!copy($logger->getLogFileNameWithPath(), $cacheDir.'/'.$logger->getLogFileName())) {
      echo "Couldn't copy sugarcrm.log to cacheDir.<br>";
    }
    //END COPY SUGARCRM.LOG

    //UPDATING PROGRESS BAR
    sodUpdateProgressBar(SUGARLOG_WEIGHT);
}

function executephpinfo()
{
    //BEGIN GETPHPINFO
    //This gets phpinfo, writes to a buffer, then I write to phpinfo.html
    global $cacheDir;

    ob_start();
    phpinfo();
    $phpinfo = ob_get_contents();
    ob_clean();

    $handle = sugar_fopen($cacheDir."phpinfo.html", "w");
    if(fwrite($handle, $phpinfo) === FALSE){
      echo "Cannot write to file ".$cacheDir."phpinfo.html<br>";
    }
    fclose($handle);
    //END GETPHPINFO

    //UPDATING PROGRESS BAR
    sodUpdateProgressBar(PHPINFO_WEIGHT);
}

function executeconfigphp()
{
    //BEGIN COPY CONFIG.PHP
    //store db_password in temp var so we can get config.php w/o making anyone angry
    global $cacheDir;    global $sugar_config;

    $tempPass = $sugar_config['dbconfig']['db_password'];
    $sugar_config['dbconfig']['db_password'] = '********';
    //write config.php to a file
    write_array_to_file("Diagnostic", $sugar_config, $cacheDir."config.php");
    //restore db_password so everything still works
    $sugar_config['dbconfig']['db_password'] = $tempPass;
    //END COPY CONFIG.PHP

    //UPDATING PROGRESS BAR
    sodUpdateProgressBar(CONFIG_WEIGHT);
}

function executemysql($getinfo, $getdumps, $getschema)
{
    //BEGIN GET DB INFO
    global $getDumpsFrom;
    global $curdatetime;
    global $sugar_config;
    global $progress_bar_percent;
    global $sod_guid;
    global $db;

    if($db->dbType != "mysql") {
        if($getinfo) sodUpdateProgressBar(MYSQL_INFO_WEIGHT);
        if($getschema) sodUpdateProgressBar(MYSQL_SCHEMA_WEIGHT);
        if($getdumps) sodUpdateProgressBar(MYSQL_DUMPS_WEIGHT);
        return;
    }
    
    $mysqlInfoDir = create_cache_directory("diagnostic/".$sod_guid."/diagnostic".$curdatetime."/MySQL/");


    //create directory for table definitions
    if($getschema)
      $tablesSchemaDir = create_cache_directory("diagnostic/".$sod_guid."/diagnostic".$curdatetime."/MySQL/TableSchema/");

    //BEGIN GET MYSQL INFO
    //make sure they checked the box to get basic info
    if($getinfo)
    {
      ob_start();
      echo "MySQL Version: ".(function_exists('mysqli_get_client_info') ? @mysqli_get_client_info() : @mysql_get_client_info())."<BR>";
      echo "MySQL Host Info: ".(function_exists('mysqli_get_host_info') ? @mysqli_get_host_info($db->getDatabase()) : @mysql_get_host_info())."<BR>";
      echo "MySQL Server Info: ".(function_exists('mysqli_get_client_info') ? @mysqli_get_client_info() : @mysql_get_client_info())."<BR>";
      echo "MySQL Client Encoding: ".(function_exists('mysqli_character_set_name') ? @mysqli_character_set_name($db->getDatabase()) : @mysql_client_encoding())."<BR>";

      /* Uncomment to get current processes as well
      echo "<BR>MySQL Processes<BR>";
      $res = $db->query('SHOW PROCESSLIST');
      echo "<table border=\"1\"><tr><th>Id</th><th>Host</th><th>db</th><th>Command</th><th>Time</th></tr>";
      if($db->getRowCount($res) > 0)
      {
        while($row = $db->fetchByAssoc($res))
        {
          printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                 $row['Id'], $row['Host'], $row['db'], $row['Command'], $row['Time']
                 );
        }
        echo "</table><br>";
      }
      else
      {
        echo "</table>";
        echo "No processes running<br>";
      }
      */

      echo "<BR>MySQL Character Set Settings<BR>";
      $res = $db->query("show variables like 'character\_set\_%'");
      echo "<table border=\"1\"><tr><th>Variable Name</th><th>Value</th></tr>";
      while($row = $db->fetchByAssoc($res))
      {
        printf("<tr><td>%s</td><td>%s</td></tr>",
               $row['Variable_name'], $row['Value']
               );
      }
      echo "</table>";

      $content = ob_get_contents();
      ob_clean();

      $handle = sugar_fopen($mysqlInfoDir."MySQL-General-info.html", "w");
      if(fwrite($handle, $content) === FALSE){
        echo "Cannot write to file ".$mysqlInfoDir."_MySQL-General-info.html<br>";
      }
      fclose($handle);
      //BEGIN UPDATING PROGRESS BAR
      sodUpdateProgressBar(MYSQL_INFO_WEIGHT);
      //END UPDATING PROGRESS BAR
    }
    //END GET MYSQL INFO


    if($getschema)
    {
        //BEGIN GET ALL TABLES SCHEMAS
        $all_tables = $db->getTablesArray();

        global $theme_path;

		ob_start();
		echo "<style>";
		echo file_get_contents($theme_path."style.css");
		echo "</style>";
        foreach($all_tables as $tablename){
			//setting up table header for each file
			echo "<table border=\"0\" cellpadding=\"0\" class=\"tabDetailView\">";
			echo "<tr>MySQL ".$tablename." Definitions:</tr>".
				"<tr><td class=\"tabDetailViewDL\"><b>Field</b></td>".
					"<td class=\"tabDetailViewDL\">Type</td>".
					"<td class=\"tabDetailViewDL\">Null</td>".
					"<td class=\"tabDetailViewDL\">Key</td>".
					"<td class=\"tabDetailViewDL\">Default</td>".
					"<td class=\"tabDetailViewDL\">Extra</td></tr>";
			$describe = $db->query("describe ".$tablename);
			while($inner_row = $db->fetchByAssoc($describe)){
				$inner_row = array_values($inner_row);
				echo "<tr><td class=\"tabDetailViewDF\"><b>".$inner_row[0]."</b></td>";
				echo	 "<td class=\"tabDetailViewDF\">".$inner_row[1]."</td>";
				echo	 "<td class=\"tabDetailViewDF\">".$inner_row[2]."</td>";
				echo	 "<td class=\"tabDetailViewDF\">".$inner_row[3]."</td>";
				echo	 "<td class=\"tabDetailViewDF\">".$inner_row[4]."</td>";
				echo	 "<td class=\"tabDetailViewDF\">".$inner_row[5]."</td></tr>";
			}
			echo "</table>";
			echo "<BR><BR>";
		}

		$content = ob_get_contents();
		ob_clean();

		$handle = sugar_fopen($tablesSchemaDir."MySQLTablesSchema.html", "w");
		if(fwrite($handle, $content) === FALSE){
		  echo "Cannot write to file ".$tablesSchemaDir."MySQLTablesSchema.html<br>";
		}
		fclose($handle);

		//END GET ALL TABLES SCHEMAS
		//BEGIN UPDATING PROGRESS BAR
		sodUpdateProgressBar(MYSQL_SCHEMA_WEIGHT);
		//END UPDATING PROGRESS BAR
    }

    if($getdumps)
    {
		//BEGIN GET TABLEDUMPS
		$tableDumpsDir = create_cache_directory("diagnostic/".$sod_guid."/diagnostic".$curdatetime."/MySQL/TableDumps/");


		foreach ($getDumpsFrom as $table)
		{
			ob_start();
			//calling function defined above to get the string for dump
			echo getFullTableDump($table);
			$content = ob_get_contents();
			ob_clean();
			$handle = sugar_fopen($tableDumpsDir.$table.".html", "w");
			if(fwrite($handle, $content) === FALSE){
			  echo "Cannot write to file ".$tableDumpsDir.$table."html<br>";
			}
			fclose($handle);
		}
		//END GET TABLEDUMPS
		//BEGIN UPDATING PROGRESS BAR
		sodUpdateProgressBar(MYSQL_DUMPS_WEIGHT);
		//END UPDATING PROGRESS BAR
	}


    //END GET DB INFO
}


function executebeanlistbeanfiles()
{
    //BEGIN CHECK BEANLIST FILES ARE AVAILABLE
    global $cacheDir;
    global $beanList;
    global $beanFiles;
    global $mod_strings;

    ob_start();

    echo $mod_strings['LBL_DIAGNOSTIC_BEANLIST_DESC'];
    echo "<BR>";
    echo "<font color=green>";
    echo $mod_strings['LBL_DIAGNOSTIC_BEANLIST_GREEN'];
    echo "</font>";
    echo "<BR>";
    echo "<font color=orange>";
    echo $mod_strings['LBL_DIAGNOSTIC_BEANLIST_ORANGE'];
    echo "</font>";
    echo "<BR>";
    echo "<font color=red>";
    echo $mod_strings['LBL_DIAGNOSTIC_BEANLIST_RED'];
    echo "</font>";
    echo "<BR><BR>";

	foreach ($beanList as $beanz)
	{
		if(!isset($beanFiles[$beanz]))
		{
			echo "<font color=orange>NO! --- ".$beanz." is not an index in \$beanFiles</font><br>";
		}
		else
		{
			if(file_exists($beanFiles[$beanz]))
				echo "<font color=green>YES --- ".$beanz." file \"".$beanFiles[$beanz]."\" exists</font><br>";
			else
				echo "<font color=red>NO! --- ".$beanz." file \"".$beanFiles[$beanz]."\" does NOT exist</font><br>";
		}
	}

	$content = ob_get_contents();
	ob_clean();

	$handle = sugar_fopen($cacheDir."beanFiles.html", "w");
	if(fwrite($handle, $content) === FALSE){
    	echo "Cannot write to file ".$cacheDir."beanFiles.html<br>";
    }
    fclose($handle);
    //END CHECK BEANLIST FILES ARE AVAILABLE
    //BEGIN UPDATING PROGRESS BAR
    sodUpdateProgressBar(BEANLISTBEANFILES_WEIGHT);
    //END UPDATING PROGRESS BAR
}

function executecustom_dir()
{
    //BEGIN ZIP AND SAVE CUSTOM DIRECTORY
    global $cacheDir;

    zip_dir("custom", $cacheDir."custom_directory.zip");
    //END ZIP AND SAVE CUSTOM DIRECTORY
    //BEGIN UPDATING PROGRESS BAR
    sodUpdateProgressBar(CUSTOM_DIR_WEIGHT);
    //END UPDATING PROGRESS BAR
}

function executemd5($filesmd5, $md5calculated)
{
	//BEGIN ALL MD5 CHECKS
	global $curdatetime;
	global $skip_md5_diff;
	global $sod_guid;
	if(file_exists('files.md5'))
        include( 'files.md5');
	//create dir for md5s
	$md5_directory = create_cache_directory("diagnostic/".$sod_guid."/diagnostic".$curdatetime."/md5/");

	//skip this if the files.md5 didn't exist
	if(!$skip_md5_diff)
	{
		//make sure the files.md5
		if($filesmd5)
			if(!copy('files.md5', $md5_directory."files.md5"))
				echo "Couldn't copy files.md5 to ".$md5_directory."<br>Skipping md5 checks.<br>";
	}

	$md5_string_calculated = generateMD5array('./');

	if($md5calculated)
		write_array_to_file('md5_string_calculated', $md5_string_calculated, $md5_directory."md5_array_calculated.php");


	//if the files.md5 didn't exist, we can't do this
	if(!$skip_md5_diff)
	{
		$md5_string_diff = array_diff($md5_string_calculated, $md5_string);

		write_array_to_file('md5_string_diff', $md5_string_diff, $md5_directory."md5_array_diff.php");
	}
	//END ALL MD5 CHECKS
    //BEGIN UPDATING PROGRESS BAR
    sodUpdateProgressBar(MD5_WEIGHT);
    //END UPDATING PROGRESS BAR
}

function executevardefs()
{
    //BEGIN DUMP OF SUGAR SCHEMA (VARDEFS)

    //END DUMP OF SUGAR SCHEMA (VARDEFS)
    //BEGIN UPDATING PROGRESS BAR
    //This gets the vardefs, writes to a buffer, then I write to vardefschema.html
    global $cacheDir;
    global $beanList;
    global $beanFiles;
    global $dictionary;
    global $sugar_version;
    global $sugar_db_version;
    global $sugar_flavor;

    ob_start();
    foreach ( $beanList as $beanz ) {
      // echo "Module: ".$beanz."<br>";

	$path_parts = pathinfo( $beanFiles[ $beanz ] );
	$vardefFileName = $path_parts[ 'dirname' ]."/vardefs.php";
	  if( file_exists( $vardefFileName )) {
	    // echo "<br>".$vardefFileName."<br>";
	    include_once( $vardefFileName );
	  }
    }

    echo "<html>";
    echo "<BODY>";
    echo "<H1>Schema listing based on vardefs</H1>";
    echo "<P>Sugar version:  ".$sugar_version." / Sugar DB version:  ".$sugar_db_version." / Sugar flavor:  ".$sugar_flavor;
    echo "</P>";

    echo "<style> th { text-align: left; } </style>";

    $tables = array();
    foreach($dictionary as $vardef) {
	$tables[] = $vardef['table'];
	$fields[$vardef['table']] = $vardef['fields'];
	$comments[$vardef['table']] = $vardef['comment'];
    }

    asort($tables);

    foreach($tables as $t) {
	$name = $t;
	if ( $name == "does_not_exist" )
	  continue;
	$comment = $comments[$t];
	echo "<h2>Table: $t</h2>
		<p><i>{$comment}</i></p>";
	echo "<table border=\"0\" cellpadding=\"3\" class=\"tabDetailView\">";
	echo '<TR BGCOLOR="#DFDFDF">
		<TD NOWRAP ALIGN=left class=\"tabDetailViewDL\">Column</TD>
		<TD NOWRAP class=\"tabDetailViewDL\">Type</TD>
		<TD NOWRAP class=\"tabDetailViewDL\">Length</TD>
		<TD NOWRAP class=\"tabDetailViewDL\">Required</TD>
		<TD NOWRAP class=\"tabDetailViewDL\">Comment</TD>
	</TR>';

	ksort( $fields[ $t ] );

	foreach($fields[$t] as $k => $v) {
	  // we only care about physical tables ('source' can be 'non-db' or 'nondb' or 'function' )
	  if ( isset( $v[ 'source' ] ))
	    continue;
	  $columnname = $v[ 'name' ];
	  $columntype = $v[ 'type' ];
	  $columndbtype = $v[ 'dbType' ];
	  $columnlen = $v[ 'len' ];
	  $columncomment = $v[ 'comment' ];
	  $columnrequired = $v[ 'required' ];

	  if ( empty( $columnlen ) ) $columnlen = '<i>n/a</i>';
	  if ( empty( $columncomment ) ) $columncomment = '<i>(none)</i>';
	  if ( !empty( $columndbtype ) ) $columntype = $columndbtype;
	  if ( empty( $columnrequired ) || ( $columnrequired == false ))
	    $columndisplayrequired = 'no';
	  else
	    $columndisplayrequired = 'yes';

	  echo '<TR BGCOLOR="#FFFFFF" ALIGN=left>
			<TD ALIGN=left class=\"tabDetailViewDF\">'.$columnname.'</TD>
	  		<TD NOWRAP class=\"tabDetailViewDF\">'.$columntype.'</TD>
			<TD NOWRAP class=\"tabDetailViewDF\">'.$columnlen.'</TD>
			<TD NOWRAP class=\"tabDetailViewDF"\">'.$columndisplayrequired.'</TD>
			<TD WRAP class=\"tabDetailViewDF\">'.$columncomment.'</TD></TR>';
	}

	echo "</table></p>";
    }

    echo "</body></html>";

    $vardefFormattedOutput = ob_get_contents();
    ob_clean();

    $handle = sugar_fopen($cacheDir."vardefschema.html", "w");
    if(fwrite($handle, $vardefFormattedOutput) === FALSE){
      echo "Cannot write to file ".$cacheDir."vardefschema.html<br>";
    }
    fclose($handle);
    sodUpdateProgressBar(VARDEFS_WEIGHT);
    //END UPDATING PROGRESS BAR
}

function finishDiag(){
	//BEGIN ZIP ALL FILES AND EXTRACT IN CACHE ROOT
	global $cacheDir;
	global $curdatetime;
	global $sod_guid;
	global $mod_strings;

	chdir($cacheDir);
	zip_dir(".", "../diagnostic".$curdatetime.".zip");
	//END ZIP ALL FILES AND EXTRACT IN CACHE ROOT
	chdir(RETURN_FROM_DIAG_DIR);

	deleteDir($cacheDir);

	print "<a href=\"{$GLOBALS['sugar_config']['cache_dir']}diagnostic/".$sod_guid."/diagnostic".$curdatetime.".zip\">".$mod_strings['LBL_DIAGNOSTIC_DOWNLOADLINK']."</a><BR>";

	print "<a href=\"index.php?module=Administration&action=DiagnosticDelete&file=diagnostic".$curdatetime."&guid=".$sod_guid."\">".$mod_strings['LBL_DIAGNOSTIC_DELETELINK']."</a><br>";

}

//BEGIN check for what we are executing
$doconfigphp = ((empty($_POST['configphp']) || $_POST['configphp'] == 'off') ? false : true);
$docustom_dir = ((empty($_POST['custom_dir']) || $_POST['custom_dir'] == 'off') ? false : true);
$dophpinfo = ((empty($_POST['phpinfo']) || $_POST['phpinfo'] == 'off') ? false : true);
$domysql_dumps = ((empty($_POST['mysql_dumps']) || $_POST['mysql_dumps'] == 'off') ? false : true);
$domysql_schema = ((empty($_POST['mysql_schema']) || $_POST['mysql_schema'] == 'off') ? false : true);
$domysql_info = ((empty($_POST['mysql_info']) || $_POST['mysql_info'] == 'off') ? false : true);
$domd5 = ((empty($_POST['md5']) || $_POST['md5'] == 'off') ? false : true);
$domd5filesmd5 = ((empty($_POST['md5filesmd5']) || $_POST['md5filesmd5'] == 'off') ? false : true);
$domd5calculated = ((empty($_POST['md5calculated']) || $_POST['md5calculated'] == 'off') ? false : true);
$dobeanlistbeanfiles = ((empty($_POST['beanlistbeanfiles']) || $_POST['beanlistbeanfiles'] == 'off') ? false : true);
$dosugarlog = ((empty($_POST['sugarlog']) || $_POST['sugarlog'] == 'off') ? false : true);
$dovardefs = ((empty($_POST['vardefs']) || $_POST['vardefs'] == 'off') ? false : true);
//END check for what we are executing


//BEGIN items to calculate progress bar
$totalitems = 0;
$totalweight = 0;
if($doconfigphp) {$totalweight += CONFIG_WEIGHT; $totalitems++;}
if($docustom_dir) {$totalweight += CUSTOM_DIR_WEIGHT; $totalitems++;}
if($dophpinfo) {$totalweight += PHPINFO_WEIGHT; $totalitems++;}
if($domysql_dumps) {$totalweight += MYSQL_DUMPS_WEIGHT; $totalitems++;}
if($domysql_schema) {$totalweight += MYSQL_SCHEMA_WEIGHT; $totalitems++;}
if($domysql_info) {$totalweight += MYSQL_INFO_WEIGHT; $totalitems++;}
if($domd5) {$totalweight += MD5_WEIGHT; $totalitems++;}
if($dobeanlistbeanfiles) {$totalweight += BEANLISTBEANFILES_WEIGHT; $totalitems++;}
if($dosugarlog) {$totalweight += SUGARLOG_WEIGHT; $totalitems++;}
if($dovardefs) {$totalweight += VARDEFS_WEIGHT; $totalitems++;}
//END items to calculate progress bar

//prepare initial steps
prepareDiag();


if($doconfigphp)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETCONFPHP']."<BR>";
  executeconfigphp();
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($docustom_dir)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETCUSTDIR']."<BR>";
  executecustom_dir();
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($dophpinfo)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETPHPINFO']."<BR>";
  executephpinfo();
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($domysql_info || $domysql_dumps || $domysql_schema)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETTING'].
                 ($domysql_info ? "... ".$mod_strings['LBL_DIAGNOSTIC_GETMYSQLINFO'] : " ").
                 ($domysql_dumps ? "... ".$mod_strings['LBL_DIAGNOSTIC_GETMYSQLTD'] : " ").
                 ($domysql_schema ? "... ".$mod_strings['LBL_DIAGNOSTIC_GETMYSQLTS'] : "...").
                 "<BR>";
  executemysql($domysql_info, $domysql_dumps, $domysql_schema);
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($domd5)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETMD5INFO']."<BR>";
  executemd5($domd5filesmd5, $domd5calculated);
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($dobeanlistbeanfiles)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETBEANFILES']."<BR>";
  executebeanlistbeanfiles();
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($dosugarlog)
{
  echo $mod_strings['LBL_DIAGNOSTIC_GETSUGARLOG']."<BR>";
  executesugarlog();
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}
if($dovardefs)
{
  echo $mod_strings['LBL_DIAGNOSTIC_VARDEFS']."<BR>";
  executevardefs();
  echo $mod_strings['LBL_DIAGNOSTIC_DONE']."<BR><BR>";
}

//finish up the last steps
finishDiag();

?>
