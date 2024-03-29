<?php

/**
 * Enter description here...
 *
 * @author Administrator
 * @package defaultPackage
 * @rcsfile 	$RCSfile: story_photo_edit.php,v $
 * @revision 	$Revision: 1.1 $
 * @date 	$Date: 2009/08/04 04:06:27 $
 */

require_once(dirname(__FILE__)."/../member/config.php");
CheckRank(0,0);
if(!isset($action))
{
	$action = '';
}
if(empty($cid))
{
	ShowMsg("参数错误！","-1");
	exit();
}

//读取所有栏目
$dsql->SetQuery("Select id,classname,pid,rank From #@__story_catalog order by rank asc");
$dsql->Execute();
$ranks = Array();
$btypes = Array();
$stypes = Array();
while($row = $dsql->GetArray())
{
	if($row['pid']==0)
	{
		$btypes[$row['id']] = $row['classname'];
	}
	else
	{
		$stypes[$row['pid']][$row['id']] = $row['classname'];
	}
	$ranks[$row['id']] = $row['rank'];
}
$lastid = $row['id'];
$contents = $dsql->GetOne("Select * From #@__story_content where id='$cid' ");
$bookinfos = $dsql->GetOne("Select catid,bcatid,bookname,booktype From #@__story_books where id='{$contents['bookid']}' ");
if(!is_array($bookinfos))
{
	ShowMsg('图书ID错误，请返回','-1');
	exit;
}
$catid = $bookinfos['catid'];
$bcatid = $bookinfos['bcatid'];
$bookname = $bookinfos['bookname'];
$booktype = $bookinfos['booktype'];
$bookid = $contents['bookid'];
$dsql->SetQuery("Select id,chapnum,chaptername From #@__story_chapter where bookid='{$contents['bookid']}' order by chapnum desc");
$dsql->Execute();
$chapters = Array();
$chapnums = Array();
while($row = $dsql->GetArray()){
	$chapters[$row['id']] = $row['chaptername'];
	$chapnums[$row['id']] = $row['chapnum'];
}
require_once(dirname(__FILE__)."/templets/book/story_photo_edit.htm");
?>