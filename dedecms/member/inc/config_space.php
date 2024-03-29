<?php
if(!defined('DEDEMEMBER')) exit('dedecms');

//检查是否开放会员功能
if($cfg_mb_open=='N')
{
	ShowMsg("系统关闭了会员功能，因此你无法访问此页面！","javascript:;");
	exit();
}

$_vars = GetUserSpaceInfos();
$_vars['bloglinks'] = $_vars['curtitle'] = '';

//---------------------------
//用户权限检查
//被禁言用户
if($_vars['spacesta'] == -2)
{
	ShowMsg("用户：{$_vars['userid']} 被禁言，因此个人空间禁止访问！", "-1");
	exit();
}
//未审核用户
if($_vars['spacesta'] < 0)
{
	ShowMsg("用户：{$_vars['userid']} 的资料尚未通过审核，因此空间禁止访问！", "-1");
	exit();
}
//是否禁止了管理员空间的访问
if( !isset($_vars['matt']) ) $_vars['matt'] = 0;
if($_vars['matt'] == 10 && $cfg_mb_adminlock=='Y' 
&& !( isset($cfg_ml->fields) && $cfg_ml->fields['matt']==10 ))
{
	ShowMsg('系统设置了禁止访问管理员的个人空间！', '-1');
	exit();
}

//---------------------------
//默认风格
if($_vars['spacestyle']=='')
{
	if($_vars['mtype']=='个人') {
		$_vars['spacestyle'] = 'person';
	}
	else if($_vars['mtype']=='企业') {
		$_vars['spacestyle'] = 'company';
	}
	else {
		$_vars['spacestyle'] = 'person';
	}
}
//找不到指定样式文件夹的时候使用person为默认
if(!is_dir(DEDEMEMBER.'/space/'.$_vars['spacestyle']))
{
	$_vars['spacestyle'] = 'person';
}

//获取分类数据
$mtypearr = array();
$dsql->Execute('mty', "select * from `#@__mtypes` where mid='".$_vars['mid']."'");
while($row = $dsql->GetArray('mty'))
{
	$mtypearr[] = $row;
}

//获取栏目导航数据
$_vars['bloglinks'] = array();
$query = "select tp.channeltype,ch.typename from `#@__arctype` tp 
      left join `#@__channeltype` ch on ch.id=tp.channeltype 
      where (ch.usertype='' OR ch.usertype like '{$_vars['mtype']}') And tp.channeltype<>1 And tp.issend=1 And tp.ishidden=0 group by tp.channeltype order by ABS(tp.channeltype) asc";
$dsql->Execute('ctc', $query);
while( $row = $dsql->GetArray('ctc') )
{
	$_vars['bloglinks'][$row['channeltype']] = $row['typename'];
}


//获取企业用户私有数据
if($_vars['mtype']=='企业')
{
	require_once(DEDEINC.'/enums.func.php');
	$query = "select * from `#@__member_company` where mid='".$_vars['mid']."'";
	$company = $db->GetOne($query);
	$company['vocation'] = GetEnumsValue('vocation', $company['vocation']);
	$company['cosize'] = GetEnumsValue('cosize', $company['cosize']);
	$tmpplace = GetEnumsTypes($company['place']);
	$provinceid = $tmpplace['top'];
	$provincename = (isset($em_nativeplaces[$provinceid]) ?  $em_nativeplaces[$provinceid] : '');
	$cityname = (isset($em_nativeplaces[$tmpplace['son']]) ? $em_nativeplaces[$tmpplace['son']] : '');
	$company['place'] = $provincename.' - '.$cityname;
	$_vars = array_merge($company, $_vars);
	if($action == 'infos') $action = 'introduce';
	$_vars['comface'] = empty($_vars['comface']) ? 'images/comface.png' : $_vars['comface'];
}

/**
 * 获取空间基本信息
 *
 * @return unknown
 */
function GetUserSpaceInfos()
{
	global $dsql,$uid,$cfg_memberurl;
	$_vars = array();
	$userid = ereg_replace("[\r\n\t \*%]",'',$uid);
	$query = "Select m.mid,m.mtype,m.userid,m.uname,m.sex,m.rank,m.email,m.scores,
							m.spacesta,m.face,m.logintime,
							s.*,t.*,r.membername,m.matt
		          From `#@__member` m
		          left join `#@__member_space` s on s.mid=m.mid
		          left join `#@__member_tj` t on t.mid=m.mid
		          left join `#@__arcrank` r on r.rank=m.rank
		          where m.userid like '$uid' ";
	$_vars = $dsql->GetOne($query);
	if(!is_array($_vars))
	{
		ShowMsg("你访问的用户可能已经被删除！","javascript:;");
		exit();
	}
	if($_vars['face']=='')
	{
		if($_vars['sex']=='女')
		{
			$_vars['face'] = 'images/dfboy.gif';
		}
		else
		{
			$_vars['face'] = 'images/dfgril.gif';
		}
	}
	$_vars['userid_e'] = urlencode($_vars['userid']);
	$_vars['userurl'] = $cfg_memberurl."/index.php?uid=".$_vars['userid_e'];
	if($_vars['membername']=='开放浏览')
	{
		$_vars['membername'] = '限制会员';
	}
	return $_vars;
}

?>