<?php
if(!defined('DEDEMEMBER'))	exit('dedecms');

include_once(DEDEINC.'/image.func.php');
include_once(DEDEINC.'/oxwindow.class.php');
if(!$cfg_ml->IsLogin() || $cfg_vdcode_member=='Y')
{
	$svali = GetCkVdValue();
	if(strtolower($vdcode)!=$svali || $svali=='')
	{
		ResetVdValue();
		ShowMsg('验证码错误！', '-1');
		exit();
	}
}

$flag = '';
$autokey = $remote = $dellink = $autolitpic = 0;
$userip = GetIP();

if($typeid==0)
{
	ShowMsg('请指定文档隶属的栏目！', '-1');
	exit();
}

$query = "Select tp.ispart,tp.channeltype,tp.issend,ch.issend as cissend,ch.sendrank,ch.arcsta,ch.addtable,ch.usertype
          From `#@__arctype` tp left join `#@__channeltype` ch on ch.id=tp.channeltype where tp.id='$typeid' ";
$cInfos = $dsql->GetOne($query);

//检测栏目是否有投稿权限
if($cInfos['issend']!=1 || $cInfos['ispart']!=0  || $cInfos['channeltype']!=$channelid || $cInfos['cissend']!=1)
{
	ShowMsg("你所选择的栏目不支持投稿！","-1");
	exit();
}

//检查频道设定的投稿许可权限
if($cInfos['sendrank'] > $cfg_ml->M_Rank )
{
	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$cInfos['sendrank']."' ");
	ShowMsg("对不起，需要[".$row['membername']."]才能在这个频道发布文档！","-1","0",5000);
	exit();
}

if($cInfos['usertype'] !='' && $cInfos['usertype'] != $cfg_ml->M_MbType)
{
	ShowMsg("对不起，需要[".$cInfos['usertype']."]才能在这个频道发布文档！","-1","0",5000);
	exit();
}

//文档的默认状态
if($cInfos['arcsta']==0)
{
	$ismake = 0;
	$arcrank = 0;
}
else if($cInfos['arcsta']==1)
{
	$ismake = -1;
	$arcrank = 0;
}
else
{
	$ismake = 0;
	$arcrank = -1;
}

//对保存的内容进行处理
$money = 0;
$flag = $shorttitle = $color = $source = '';
$sortrank = $senddate = $pubdate = time();
$title = cn_substrR(HtmlReplace($title,1),$cfg_title_maxlen);
$writer =  cn_substrR(HtmlReplace($writer,1),20);
if(empty($description)) $description = '';
$description = cn_substrR(HtmlReplace($description,1),250);
$keywords = cn_substrR(HtmlReplace($tags,1),30);
$mid = $cfg_ml->M_ID;

//处理上传的缩略图
$litpic = MemberUploads('litpic','',$cfg_ml->M_ID,'image','',$cfg_ddimg_width,$cfg_ddimg_height,false);
if($litpic!='')
{
	SaveUploadInfo($title,$litpic,1);
}

//检测文档是否重复
if($cfg_mb_cktitle=='Y')
{
	$row = $dsql->GetOne("Select * From `#@__archives` where title like '$title' ");
	if(is_array($row))
	{
		ShowMsg("对不起，请不要发布重复文档！","-1","0",5000);
		exit();
	}
}

?>