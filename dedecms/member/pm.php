<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
if($cfg_mb_lit=='Y')
{
	ShowMsg('由于系统开启了精简版会员空间，你不能向其它会员发短信息，不过你可以向他留言！','-1');
	exit();
}

#api{{
if(defined('UC_API') && @include_once DEDEROOT.'/uc_client/client.php')
{
	if($data = uc_get_user($cfg_ml->M_LoginID)) uc_pm_location($data[0]);
}
#/aip}}

if(!isset($dopost))
{
	$dopost = '';
}
//检查用户是否被禁言
CheckNotAllow();
/*--------------------
function __send(){  }
----------------------*/
if($dopost=='send')
{
	/** 好友记录 **/
	$sql = "Select * From `#@__member_friends` where  mid='{$cfg_ml->M_ID}' And ftype!='-1'  order by addtime desc limit 20";
	$friends = array();
	$dsql->SetQuery($sql);
	$dsql->Execute();
	while ($row = $dsql->GetArray()) {
		$friends[] = $row;
	}

	include_once(dirname(__FILE__).'/templets/pm-send.htm');
	exit();
}

/*-----------------------
function __read(){  }
----------------------*/
else if($dopost=='read')
{
	$sql = "Select * From `#@__member_friends` where  mid='{$cfg_ml->M_ID}' And ftype!='-1'  order by addtime desc limit 20";
	$friends = array();
	$dsql->SetQuery($sql);
	$dsql->Execute();
	while ($row = $dsql->GetArray()) {
		$friends[] = $row;
	}
	$row = $dsql->GetOne("Select * From `#@__member_pms` where id='$id' And (fromid='{$cfg_ml->M_ID}' Or toid='{$cfg_ml->M_ID}')");
	if(!is_array($row))
	{
		ShowMsg('对不起，你指定的消息不存在或你没权限查看！','-1');
		exit();
	}
	$dsql->ExecuteNoneQuery("Update `#@__member_pms` set hasview=1 where id='$id' And folder='inbox' And toid='{$cfg_ml->M_ID}'");
	$dsql->ExecuteNoneQuery("Update `#@__member_pms` set hasview=1 where folder='outbox' And toid='{$cfg_ml->M_ID}'");
	include_once(dirname(__FILE__).'/templets/pm-read.htm');
	exit();
}

/*-----------------------
function __savesend(){  }
----------------------*/
else if($dopost=='savesend')
{
	if($subject=='')
	{
		ShowMsg("请填写信息标题!","-1");
		exit();
	}
	$msg = CheckUserID($msgtoid,"用户名",false);
	if($msg!='ok')
	{
		ShowMsg($msg,"-1");
		exit();
	}
	$row = $dsql->GetOne("Select * From `#@__member` where userid like '$msgtoid' ");
	if(!is_array($row))
	{
		ShowMsg("你指定的用户不存在,不能发送信息!","-1");
		exit();
	}
	$subject = cn_substrR(HtmlReplace($subject,1),60);
	$message = cn_substrR(HtmlReplace($message,0),1024);
	$sendtime = $writetime = time();

	//发给收件人(收件人可管理)
	$inquery1 = "INSERT INTO `#@__member_pms` (`floginid`,`fromid`,`toid`,`tologinid`,`folder`,`subject`,`sendtime`,`writetime`,`hasview`,`isadmin`,`message`)
      VALUES ('{$cfg_ml->M_LoginID}','{$cfg_ml->M_ID}','{$row['mid']}','{$row['userid']}','inbox','$subject','$sendtime','$writetime','0','0','$message'); ";

	//保留到自己的发件箱(自己可管理)
	$inquery2 = "INSERT INTO `#@__member_pms` (`floginid`,`fromid`,`toid`,`tologinid`,`folder`,`subject`,`sendtime`,`writetime`,`hasview`,`isadmin`,`message`)
      VALUES ('{$cfg_ml->M_LoginID}','{$cfg_ml->M_ID}','{$row['mid']}','{$row['userid']}','outbox','$subject','$sendtime','$writetime','0','0','$message'); ";
	$dsql->ExecuteNoneQuery($inquery1);
	$dsql->ExecuteNoneQuery($inquery2);
	ShowMsg("成功发送一条信息!","pm.php?dopost=outbox");
	exit();
}

/*-----------------------
function __del(){  }
----------------------*/
else if($dopost=='del')
{
	$ids = ereg_replace("[^0-9,]","",$ids);
	if($folder=='inbox')
	{
		$boxsql="Select * From `#@__member_pms` where id in($ids) And folder like 'inbox' And toid='{$cfg_ml->M_ID}'";
		$dsql->SetQuery($boxsql);
		$dsql->Execute();
		$query='';
		while($row = $dsql->GetArray())
		{
			if($row && $row['isadmin']==1)
			{
				$query = "Update `#@__member_pms` set writetime='0' where id='{$row['id']}' And folder='inbox' And toid='{$cfg_ml->M_ID}' And isadmin='1';";
				$dsql->ExecuteNoneQuery($query);
			}
			else
			{
				$query = "Delete From `#@__member_pms` where id in($ids) And toid='{$cfg_ml->M_ID}' And folder like 'inbox'";
			}
		}
	}
	else if($folder=='outbox')
	{
		$query = "Delete From `#@__member_pms` where id in($ids) And fromid='{$cfg_ml->M_ID}' And folder like 'outbox' ";
	}
	else
	{
		$query = "Delete From `#@__member_pms` where id in($ids) And fromid='{$cfg_ml->M_ID}' Or toid='{$cfg_ml->M_ID}' And folder like 'outbox' Or (folder like 'inbox' And hasview='0')";
	}
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("成功删除指定的消息!","pm.php?folder=".$folder);
	exit();
}

/*-----------------------
function __man(){  }
----------------------*/
else
{
	if(!isset($folder))
	{
		$folder = 'inbox';
	}
	require_once(DEDEINC."/datalistcp.class.php");
	$wsql = '';
	if($folder=='outbox')
	{
		$wsql = " `fromid`='{$cfg_ml->M_ID}' And folder like 'outbox' ";
		$tname = "发件箱";
	}
	elseif($folder=='inbox')
	{
		$query = "Select * From `#@__member_pms` where folder like 'outbox' And isadmin='1'";
		$dsql->SetQuery($query);
		$dsql->Execute();
		while($row = $dsql->GetArray())
		{
			$row2 = $dsql->GetOne("Select * From `#@__member_pms` where fromid = '$row[id]' And toid='{$cfg_ml->M_ID}'");
			if(!is_array($row2))
			{
				$row3= "INSERT INTO
				`#@__member_pms` (`floginid`,`fromid`,`toid`,`tologinid`,`folder`,`subject`,`sendtime`,`writetime`,`hasview`,`isadmin`,`message`)
				VALUES ('admin','{$row['id']}','{$cfg_ml->M_ID}','{$cfg_ml->M_LoginID}','inbox','{$row['subject']}','{$row['sendtime']}','{$row['writetime']}','{$row['hasview']}','{$row['isadmin']}','{$row['message']}')";
				$dsql->ExecuteNoneQuery($row3);
			}
		}
		$wsql = " toid='{$cfg_ml->M_ID}' And folder='inbox' And writetime!=''";
		$tname = "收件箱";
	}
	else
	{

		$wsql = " `fromid` ='{$cfg_ml->M_ID}' And folder like 'outbox'";
		$tname = "已发信息";
	}
	$query = "Select * From `#@__member_pms` where $wsql order by sendtime desc";
	$dlist = new DataListCP();
	$dlist->pageSize = 20;
	$dlist->SetParameter("dopost",$dopost);
	$dlist->SetTemplate(DEDEMEMBER.'/templets/pm-main.htm');
	$dlist->SetSource($query);
	$dlist->Display();
}
?>