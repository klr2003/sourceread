<?php
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 1;
$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
$mtypesid = isset($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
	$cInfos = $dsql->GetOne("Select * From `#@__channeltype`  where id='$channelid'; ");

	//如果限制了会员级别或类型，则允许游客投稿选项无效
	if($cInfos['sendrank']>0 || $cInfos['usertype']!='')
	{
		CheckRank(0,0);
	}

	//检查会员等级和类型限制
	if($cInfos['sendrank'] > $cfg_ml->M_Rank)
	{
		$row = $dsql->GetOne("Select membername From `#@__arcrank` where rank='".$cInfos['sendrank']."' ");
		ShowMsg("对不起，需要[".$row['membername']."]才能在这个频道发布文档！","-1","0",5000);
		exit();
	}
	if($cInfos['usertype']!='' && $cInfos['usertype'] != $cfg_ml->M_MbType)
	{
		ShowMsg("对不起，需要[".$cInfos['usertype']."帐号]才能在这个频道发布文档！","-1","0",5000);
		exit();
	}
	include(DEDEMEMBER."/templets/article_add.htm");
	exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
	include(DEDEMEMBER.'/inc/archives_check.php');

	//分析处理附加表数据
	$inadd_f = $inadd_v = '';
	if(!empty($dede_addonfields))
	{
		$addonfields = explode(';',$dede_addonfields);
		$inadd_f = '';
		$inadd_v = '';
		if(is_array($addonfields))
		{
			foreach($addonfields as $v)
			{
				if($v=='')
				{
					continue;
				}
				$vs = explode(',',$v);
				if(!isset(${$vs[0]}))
				{
					${$vs[0]} = '';
				}
				${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],0);
				$inadd_f .= ','.$vs[0];
				$inadd_v .= " ,'".${$vs[0]}."' ";
			}
		}
	}

	//处理图片文档的自定义属性
	if($litpic!='')
	{
		$flag = 'p';
	}
	$body = AnalyseHtmlBody($body,$description);
	$body = HtmlReplace($body,-1);

	//生成文档ID
	$arcID = GetIndexKey($arcrank,$typeid,$sortrank,$channelid,$senddate,$mid);
	if(empty($arcID))
	{
		ShowMsg("无法获得主键，因此无法进行后续操作！","-1");
		exit();
	}

	//保存到主表
	$inQuery = "INSERT INTO `#@__archives`(id,typeid,sortrank,flag,ismake,channel,arcrank,click,money,title,shorttitle,
color,writer,source,litpic,pubdate,senddate,mid,description,keywords,mtype)
VALUES ('$arcID','$typeid','$sortrank','$flag','$ismake','$channelid','$arcrank','0','$money','$title','$shorttitle',
'$color','$writer','$source','$litpic','$pubdate','$senddate','$mid','$description','$keywords','$mtypesid'); ";
	if(!$dsql->ExecuteNoneQuery($inQuery))
	{
		$gerr = $dsql->GetError();
		$dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID' ");
		ShowMsg("把数据保存到数据库主表 `#@__archives` 时出错，请联系管理员。","javascript:;");
		exit();
	}

	//保存到附加表
	$addtable = trim($cInfos['addtable']);
	if(empty($addtable))
	{
		$dsql->ExecuteNoneQuery("Delete From `#@__archives` where id='$arcID'");
		$dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
		ShowMsg("没找到当前模型[{$channelid}]的主表信息，无法完成操作！。","javascript:;");
		exit();
	}
	else
	{
		$inquery = "INSERT INTO `{$addtable}`(aid,typeid,userip,redirecturl,templet,body{$inadd_f}) Values('$arcID','$typeid','$userip','','','$body'{$inadd_v})";
		if(!$dsql->ExecuteNoneQuery($inquery))
		{
			$gerr = $dsql->GetError();
			$dsql->ExecuteNoneQuery("Delete From `#@__archives` where id='$arcID'");
			$dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
			ShowMsg("把数据保存到数据库附加表 `{$addtable}` 时出错，请联系管理员！","javascript:;");
			exit();
		}
	}

	//增加积分
	$dsql->ExecuteNoneQuery("Update `#@__member` set scores=scores+{$cfg_sendarc_scores} where mid='".$cfg_ml->M_ID."' ; ");
	//更新统计
	countArchives($channelid);

	//生成HTML
	InsertTags($tags,$arcID);
	$artUrl = MakeArt($arcID,true);
	if($artUrl=='')
	{
		$artUrl = $cfg_phpurl."/view.php?aid=$arcID";
	}
	
	#api{{
	if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')
	{
		//推送事件
		$feed['icon'] = 'thread';
		$feed['title_template'] = '<b>{username} 在网站发布了一篇文章</b>';
		$feed['title_data'] = array('username' => $cfg_ml->M_UserName);
		$feed['body_template'] = '<b>{subject}</b><br>{message}';
		$url = !strstr($artUrl,'http://') ? ($cfg_basehost.$artUrl) : $artUrl;
		$feed['body_data'] = array('subject' => "<a href=\"".$url."\">$title</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $description)), 150));		
		$feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);
		uc_feed_note($cfg_ml->M_LoginID,$feed);

		$row = $dsql->GetOne("SELECT `scores`,`userid` FROM `#@__member` WHERE `mid`='".$cfg_ml->M_ID."' AND `matt`<>10");
		uc_credit_note($row['userid'], $cfg_sendarc_scores);
	}
	#/aip}}
	
	//返回成功信息
	$msg =
	"请选择你的后续操作：
	<a href='article_add.php?cid=$typeid'><u>继续发布文章</u></a>
	&nbsp;&nbsp;
	<a href='$artUrl' target='_blank'><u>查看文章</u></a>
	&nbsp;&nbsp;
	<a href='article_edit.php?channelid=$channelid&aid=$arcID'><u>更改文章</u></a>
	&nbsp;&nbsp;
	<a href='content_list.php?channelid={$channelid}'><u>已发布文章管理</u></a>";
	$wintitle = "成功发布文章！";
	$wecome_info = "文章管理::发布文章";
	$win = new OxWindow();
	$win->AddTitle("成功发布文章：");
	$win->AddMsgItem($msg);
	$winform = $win->GetWindow("hand","&nbsp;",false);
	$win->Display();
}
?>