<?php

/**
 * Enter description here...
 *
 * @author Administrator
 * @package defaultPackage
 * @rcsfile 	$RCSfile: story_list_content.php,v $
 * @revision 	$Revision: 1.1 $
 * @date 	$Date: 2009/08/04 04:06:27 $
 */

require_once(dirname(__FILE__)."/../member/config.php");
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
CheckRank(0,0);
if(!isset($action))
{
	$action = '';
}
if(!isset($booktype))
{
	$booktype = '-1';
}
if(!isset($keyword))
{
	$keyword = "";
}
if(!isset($orderby))
{
	$orderby = 0;
}
if(!isset($bookid))
{
	$bookid = 0;
}

if(!isset($chapid))

{
	$chapid = 0;
}
$addquery = "";
$orderby = " order by ct.id desc ";
if($booktype!='-1')
{
	$addquery .= " And ct.booktype='$booktype' ";
}
if($keyword!="")
{
	$addquery .= " And (ct.bookname like '%$keyword%' Or ct.title like '%$keyword%') ";
}
if($bookid!=0)
{
	$addquery .= " And ct.bookid='$bookid' ";
}
if($chapid!=0)
{
	$addquery .= " And ct.chapterid='$chapid' ";
}
if(empty($bookname))
{
	$bookname = '';
}
if(empty($booktype))
{
	$booktype = '0';
}
$query = "
   Select ct.id,ct.title,ct.bookid,ct.chapterid,ct.sortid,ct.bookname,ct.addtime,ct.booktype,c.chaptername,c.chapnum From #@__story_content  ct
   left join #@__story_chapter c on c.id = ct.chapterid where c.mid=$cfg_ml->M_ID and ct.id>0 $addquery $orderby
";
$row = $dsql->GetOne("SELECT bookname,booktype FROM  #@__story_books WHERE id = '$bookid'");
if(is_array($row)){
$bookname = $row['bookname'];
$booktype = $row['booktype'];
}
//echo $query;
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("keyword",$keyword);
$dlist->SetParameter("booktype",$booktype);
$dlist->SetParameter("bookit",$bookid);
$dlist->SetParameter("chapid",$chapid);
$dlist->SetTemplate(dirname(__FILE__)."/templets/book/story_list_content.htm");
$dlist->SetSource($query);
$dlist->Display();
$dlist->Close();
?>