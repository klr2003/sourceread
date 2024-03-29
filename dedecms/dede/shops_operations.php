<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('shops_Operations');
require_once(DEDEINC.'/datalistcp.class.php');
if(isset($dopost))
{
	CheckPurview('shops_Operations_cpanel');
	if($dopost == 'up')
	{
		$nids = explode('`',$nid);
		$wh = '';
		foreach($nids as $n)
		{
			if($wh=='')
			{
				$wh = " WHERE oid='$n' ";
			}
			else
			{
				$wh .= " OR oid='$n' ";
			}
		}
		$dsql->SetQuery("UPDATE #@__shops_orders SET `state`='1' $wh ");
		$dsql->ExecuteNoneQuery();
	}
	elseif($dopost == 'push')
	{
		$nids = explode('`',$nid);
		$wh = '';
		foreach($nids as $n)
		{
			if($wh=='')
			{
				$wh = " WHERE oid='$n' ";
			}
			else
			{
				$wh .= " OR oid='$n' ";
			}
		}
		$dsql->SetQuery("UPDATE #@__shops_orders SET `state`='2' $wh ");
		$dsql->ExecuteNoneQuery();
	}
	elseif($dopost == 'ok')
	{
		$nids = explode('`',$nid);
		$wh = '';
		foreach($nids as $n)
		{
			if($wh=='')
			{
				$wh = " WHERE oid='$n' ";
			}
			else
			{
				$wh .= " OR oid='$n' ";
			}
		}
		$dsql->SetQuery("UPDATE #@__shops_orders SET `state`='4' $wh ");
		$dsql->ExecuteNoneQuery();
	}
	else
	{
		ShowMsg("不充许的操作范围！",$ENV_GOBACK_URL);
		exit();
	}
	ShowMsg("成功更改指定的订单记录！",$ENV_GOBACK_URL);
	exit();
}
$addsql = '';
if(empty($oid))
{
	$oid = 0;
}
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
if(isset($buyid))
{
	$buyid 	= ereg_replace("[^-0-9A-Z]","",$buyid);
	$addsql = "WHERE s.oid='".$buyid."'";
}
if(isset($sta))
{
	$addsql = "WHERE s.`state`='$sta'";
}
$sql = "SELECT s.`oid`,s.`cartcount`,s.`price`,s.`state`,s.`stime`,s.priceCount,s.dprice,s.paytype,u.`consignee`,u.`tel`,s.`userid` FROM #@__shops_orders AS s LEFT JOIN #@__shops_userinfo AS u ON s.oid=u.oid $addsql ORDER BY `stime` DESC";
$dlist = new DataListCP();
$dlist->SetParameter("oid",$oid);
if(isset($sta))
{
	$dlist->SetParameter("sta",$sta);
}
$tplfile = DEDEADMIN."/templets/shops_operations.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQLexit('dd');
$dlist->Display();

function GetSta($sta)
{
	if($sta==0)
	{
		return '未付款';
	}
	else if($sta==1)
	{
		return '已付款';
	}
	else if($sta==2)
	{
		return '已发货';
	}
	else if($sta==3)
	{
		return '已确认';
	}
	else
	{
		return '已完成';
	}
}

function GetsType($pid)
{
	global $dsql;
	$pid = intval($pid);
	$row = $dsql->GetOne("SELECT paytype FROM #@__shops_paytype WHERE pid='$pid'");
	if(is_array($row))
	{
		return $row['paytype'];
	}
	else
	{
		return '-';
	}
}

function GetMemberID($mid)
{
	global $dsql;
	if($mid==0)
	{
		return '0';
	}
	$row = $dsql->GetOne("Select userid From #@__member where mid='$mid' ");
	if(is_array($row))
	{
		return "<a href='member_view.php?id={$mid}'>".$row['userid']."</a>";
	}
	else
	{
		return '0';
	}
}

?>