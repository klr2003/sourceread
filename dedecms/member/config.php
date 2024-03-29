<?php
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(DEDEINC.'/filter.inc.php');
require_once(DEDEINC.'/memberlogin.class.php');
require_once(DEDEINC.'/dedetemplate.class.php');

//获得当前脚本名称，如果你的系统被禁用了$_SERVER变量，请自行更改这个选项
$dedeNowurl = $s_scriptName = '';
$dedeNowurl = GetCurUrl();
$dedeNowurls = explode('?', $dedeNowurl);
$s_scriptName = $dedeNowurls[0];

//检查是否开放会员功能
if($cfg_mb_open=='N')
{
	ShowMsg("系统关闭了会员功能，因此你无法访问此页面！","javascript:;");
	exit();
}
$keeptime = isset($keeptime) && is_numeric($keeptime) ? $keeptime : -1;
$cfg_ml = new MemberLogin($keeptime);

//判断用户是否登录
$myurl = '';
if($cfg_ml->IsLogin())
{
	$myurl = $cfg_memberurl."/index.php?uid=".urlencode($cfg_ml->M_LoginID);
	if(!ereg('^http:',$myurl))
	{
		$myurl = $cfg_basehost.$myurl;
	}
}

//检查用户是否有权限进行某个操作
function CheckRank($rank=0, $money=0)
{
	global $cfg_ml,$cfg_memberurl;
	if(!$cfg_ml->IsLogin())
	{
		header("Location:{$cfg_memberurl}/login.php?gourl=".urlencode(GetCurUrl()));
		exit();
	}
	else
	{
		if($cfg_ml->M_Rank < $rank)
		{
			$needname = "";
			if($cfg_ml->M_Rank==0)
			{
				$row = $dsql->GetOne("Select membername From #@__arcrank where rank='$rank'");
				$myname = "普通会员";
				$needname = $row['membername'];
			}
			else
			{
				$dsql->SetQuery("Select membername From #@__arcrank where rank='$rank' Or rank='".$cfg_ml->M_Rank."' order by rank desc");
				$dsql->Execute();
				$row = $dsql->GetObject();
				$needname = $row->membername;
				if($row = $dsql->GetObject())
				{
					$myname = $row->membername;
				}
				else
				{
					$myname = "普通会员";
				}
			}
			ShowMsg("对不起，需要：<span style='font-size:11pt;color:red'>$needname</span> 才能访问本页面。<br>你目前的等级是：<span style='font-size:11pt;color:red'>$myname</span> 。","-1",0,5000);
			exit();
		}
		else if($cfg_ml->M_Money < $money)
		{
			ShowMsg("对不起，需要花费金币：<span style='font-size:11pt;color:red'>$money</span> 才能访问本页面。<br>你目前拥有的金币是：<span style='font-size:11pt;color:red'>".$cfg_ml->M_Money."</span>  。","-1",0,5000);
			exit();
		}
	}
}

//更新文档统计
function countArchives($channelid)
{
	global $cfg_ml,$dsql;
	$id = (int)$channelid;
	if($cfg_ml->IsLogin())
	{
		$channeltype = array(1 => 'article',2 => 'album',3 => 'soft',-8 => 'infos');
		if(isset($channeltype[$id]))
		{
			$_field = $channeltype[$id];
		}
		else
		{
			$_field = 'articles';
		}
		$row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM #@__archives WHERE channel='$id' AND mid='".$cfg_ml->M_ID."'");
		
		$dsql->ExecuteNoneQuery("UPDATE #@__member_tj SET ".$_field."='".$row['nums']."' WHERE mid='".$cfg_ml->M_ID."'");
	}
	else
	{
		return false;
	}
}

?>