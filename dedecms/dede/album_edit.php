<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_Edit,a_AccEdit,a_MyEdit');
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEADMIN."/inc/inc_archives_functions.php");

if(empty($dopost))
{
	$dopost = '';
}
if($dopost!='save')
{
	require_once(DEDEADMIN."/inc/inc_catalog_options.php");
	require_once(DEDEINC."/dedetag.class.php");
	ClearMyAddon();
	$aid = intval($aid);

	//读取归档信息
	$arcQuery = "Select ch.typename as channelname,ar.membername as rankname,arc.*
    From `#@__archives` arc
    left join `#@__channeltype` ch on ch.id=arc.channel
    left join `#@__arcrank` ar on ar.rank=arc.arcrank where arc.id='$aid' ";
	$arcRow = $dsql->GetOne($arcQuery);
	if(!is_array($arcRow))
	{
		ShowMsg("读取档案基本信息出错!","-1");
		exit();
	}
	$query = "Select * From `#@__channeltype` where id='".$arcRow['channel']."'";
	$cInfos = $dsql->GetOne($query);
	if(!is_array($cInfos))
	{
		ShowMsg("读取频道配置信息出错!","javascript:;");
		exit();
	}
	$addtable = $cInfos['addtable'];
	$addRow = $dsql->GetOne("Select * From `$addtable` where aid='$aid'");
	$channelid = $arcRow['channel'];
	$imgurls = $addRow["imgurls"];
	$maxwidth = $addRow["maxwidth"];
	$pagestyle = $addRow["pagestyle"];
	$irow = $addRow["row"];
	$icol = $addRow["col"];
	$isrm = $addRow["isrm"];
	$ddmaxwidth = $addRow["ddmaxwidth"];
	$pagepicnum = $addRow["pagepicnum"];
	$tags = GetTags($aid);
	include DedeInclude("templets/album_edit.htm");
	exit();
}

/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
	require_once(DEDEINC.'/image.func.php');
	require_once(DEDEINC.'/oxwindow.class.php');

	$flag = isset($flags) ? join(',',$flags) : '';
	$notpost = isset($notpost) && $notpost == 1 ? 1: 0;
  if(empty($typeid2)) $typeid2 = 0;
	if(!isset($autokey)) $autokey = 0;
	if(!isset($remote)) $remote = 0;
	if(!isset($dellink)) $dellink = 0;
	if(!isset($autolitpic)) $autolitpic = 0;
	if(!isset($formhtml)) $formhtml = 0;
	if(!isset($formzip)) $formzip = 0;
	if(!isset($ddisfirst)) $ddisfirst = 0;
	if(!isset($delzip)) $delzip = 0;

	if($typeid==0)
	{
		ShowMsg("请指定文档的栏目！","-1");
		exit();
	}
	if(empty($channelid))
	{
		ShowMsg("文档为非指定的类型，请检查你发布内容的表单是否合法！","-1");
		exit();
	}
	if(!CheckChannel($typeid,$channelid))
	{
		ShowMsg("你所选择的栏目与当前模型不相符，请选择白色的选项！","-1");
		exit();
	}
	if(!TestPurview('a_Edit'))
	{
		if(TestPurview('a_AccEdit'))
		{
			CheckCatalog($typeid,"对不起，你没有操作栏目 {$typeid} 的文档权限！");
		}
		else
		{
			CheckArcAdmin($id,$cuserLogin->getUserID());
		}
	}

	//对保存的内容进行处理
	$pubdate = GetMkTime($pubdate);
	$sortrank = AddDay($pubdate,$sortup);
	$ismake = $ishtml==0 ? -1 : 0;
	$title = cn_substrR($title,$cfg_title_maxlen);
	$shorttitle = cn_substrR($shorttitle,36);
	$color =  cn_substrR($color,7);
	$writer =  cn_substrR($writer,20);
	$source = cn_substrR($source,30);
	$description = cn_substrR($description,$cfg_auot_description);
	$keywords = trim(cn_substrR($keywords,60));
	$filename = trim(cn_substrR($filename,40));
	if(!TestPurview('a_Check,a_AccCheck,a_MyCheck'))
	{
		$arcrank = -1;
	}
	$adminid = $cuserLogin->getUserID();

	//处理上传的缩略图
	if(empty($ddisremote))
	{
		$ddisremote = 0;
	}
	$litpic = GetDDImage('none',$picname,$ddisremote);

	//处理图片文档的自定义属性
	if($litpic!='' && !ereg('p',$flag))
	{
		$flag = ($flag=='' ? 'p' : $flag.',p');
	}
	if($redirecturl!='' && !ereg('j',$flag))
	{
		$flag = ($flag=='' ? 'j' : $flag.',j');
	}

	//跳转网址的文档强制为动态
	if(ereg('j', $flag)) $ismake = -1;
	//更新数据库的SQL语句
	$query = "
    update `#@__archives` set
    typeid='$typeid',
    typeid2='$typeid2',
    sortrank='$sortrank',
    flag='$flag',
    click='$click',
    ismake='$ismake',
    arcrank='$arcrank',
    money='$money',
    title='$title',
    color='$color',
    source='$source',
    writer='$writer',
    litpic='$litpic',
    pubdate='$pubdate',
    notpost='$notpost',
    description='$description',
    keywords='$keywords',
    shorttitle='$shorttitle',
    filename='$filename',
    dutyadmin='$adminid'
    where id='$id'; ";

	if(!$dsql->ExecuteNoneQuery($query))
	{
		ShowMsg("更新数据库archives表时出错，请检查！".$dsql->GetError(),"javascript:;");
		exit();
	}

	$imgurls = "{dede:pagestyle maxwidth='$maxwidth' pagepicnum='$pagepicnum' ddmaxwidth='$ddmaxwidth' row='$row' col='$col' value='$pagestyle'/}\r\n";
	$hasone = false;

	//----------------------------------------
	//检查旧的图片是否有更新，并保存
	//-----------------------------------------
	for($i=1;$i<=120;$i++)
	{
		if( !isset(${'imgurl'.$i}) ) continue;
		$info = '';
		$iinfo = str_replace("'", "`", stripslashes(${'imgmsg'.$i}));
		$iurl = stripslashes(${'imgurl'.$i});
		$ddurl = stripslashes(${'imgddurl'.$i});
		if(preg_match("/swfupload/i", $ddurl)) $ddurl = '';
		$imgfile = $cfg_basedir.$iurl;
		$litimgfile = $cfg_basedir.$ddurl;
		//有上传文件的情况
		if( isset(${'imgfile'.$i}) && is_uploaded_file(${'imgfile'.$i}) )
		{
			$tmpFile = ${'imgfile'.$i};
			//检测上传的图片， 如果类型不对，保留原来图片
			$imginfos = @GetImageSize($tmpFile, $info);
			if(!is_array($imginfos))
			{
				$imginfos = @GetImageSize($imgfile, $info);
				$imgurls .= "{dede:img ddimg='$ddurl' text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
				continue;
			}
			move_uploaded_file($tmpFile, $imgfile);
			$imginfos = @GetImageSize($imgfile, $info);
			if($ddurl==$iurl)
			{
				$litpicname = $pagestyle > 2 ? GetImageMapDD($iurl, $cfg_ddimg_width) : '';
				$litimgfile = $cfg_basedir.$litpicname;
			}
			else
			{
				if($cfg_ddimg_full=='Y') ImageResizeNew($imgfile, $cfg_ddimg_width, $cfg_ddimg_height, $litimgfile);
				else ImageResize($imgfile, $cfg_ddimg_width, $cfg_ddimg_height, $litimgfile);
				$litpicname = $ddurl;
			}
			$imgurls .= "{dede:img ddimg='$litpicname' text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
		}
		//没上传图片(只修改msg信息)
		else
		{
			$iinfo = str_replace("'", "`", stripslashes(${'imgmsg'.$i}));
			$iurl = stripslashes(${'imgurl'.$i});
			$ddurl = stripslashes(${'imgddurl'.$i});
			if(preg_match("/swfupload/i", $ddurl))
			{
				$ddurl = $pagestyle > 2 ? GetImageMapDD($iurl, $cfg_ddimg_width) : '';
			}
			$imginfos = @GetImageSize($imgfile, $info);
			$imgurls .= "{dede:img ddimg='$ddurl' text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
		}
	}

	//----------------------------
	//从HTML中获取新图片
	//----------------------------
	if($formhtml==1 && !empty($imagebody))
	{
		$imagebody = stripslashes($imagebody);
		$imgurls .= GetCurContentAlbum($imagebody,$copysource,$litpicname);
		if($ddisfirst==1 && $litpic=="" && !empty($litpicname))
		{
			$litpic = $litpicname;
			$hasone = true;
		}
	}
	/*---------------------
	function _getformzip()
	从ZIP文件中获取新图片
	---------------------*/
	if($formzip==1)
	{
		include_once(DEDEINC."/zip.class.php");
		include_once(DEDEADMIN."/file_class.php");
		$zipfile = $cfg_basedir.str_replace($cfg_mainsite,'',$zipfile);
		$tmpzipdir = DEDEDATA.'/ziptmp/'.cn_substr(md5(ExecTime()),16);
		$ntime = time();
		if(file_exists($zipfile))
		{

			@mkdir($tmpzipdir,$GLOBALS['cfg_dir_purview']);
			@chmod($tmpzipdir,$GLOBALS['cfg_dir_purview']);
			$z = new zip();
			$z->ExtractAll($zipfile,$tmpzipdir);
			$fm = new FileManagement();
			$imgs = array();
			$fm->GetMatchFiles($tmpzipdir,"jpg|png|gif",$imgs);
			$i = 0;
			foreach($imgs as $imgold)
			{
				$i++;
				$savepath = $cfg_image_dir."/".MyDate("Y-m",$ntime);
				CreateDir($savepath);
				$iurl = $savepath."/".MyDate("d",$ntime).dd2char(MyDate("His",$ntime).'-'.$adminid."-{$i}".mt_rand(1000,9999));
				$iurl = $iurl.substr($imgold,-4,4);
				$imgfile = $cfg_basedir.$iurl;
				copy($imgold,$imgfile);
				unlink($imgold);
				if(is_file($imgfile))
				{
					$litpicname = $pagestyle > 2 ? GetImageMapDD($iurl,$cfg_ddimg_width) : '';
					$info = '';
					$imginfos = GetImageSize($imgfile,$info);
					$imgurls .= "{dede:img ddimg='$litpicname' text='' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";

					//把图片信息保存到媒体文档管理档案中
					$inquery = "
                   INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,mid)
                    VALUES ('{$title}','{$iurl}','1','".$imginfos[0]."','".$imginfos[1]."','0','".filesize($imgfile)."','".$ntime."','$adminid');
                 ";
					$dsql->ExecuteNoneQuery($inquery);
					if(!$hasone && $ddisfirst==1
					&& $litpic=="" && !empty($litpicname))
					{
						if( file_exists($cfg_basedir.$litpicname) )
						{
							$litpic = $litpicname;
							$hasone = true;
						}
					}
				}
			}
			if($delzip==1)
			{
				unlink($zipfile);
			}
			$fm->RmDirFiles($tmpzipdir);
		}
	}
	/*---------------------
	function _swfupload()
	通过swfupload上传的新图片
	---------------------*/
	if(is_array($_SESSION['bigfile_info']))
	{
		foreach($_SESSION['bigfile_info'] as $k=>$v)
		{
			$truefile = $cfg_basedir.$v;
			if(strlen($v)<2 || !file_exists($truefile)) continue;
			$info = '';
			$imginfos = GetImageSize($truefile, $info);
			$litpicname = $pagestyle > 2 ? GetImageMapDD($v, $cfg_ddimg_width) : '';
			$imginfo =  !empty(${'picinfook'.$k}) ? ${'picinfook'.$k} : '';
			$imgurls .= "{dede:img ddimg='$litpicname' text='$imginfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $v {/dede:img}\r\n";
		}
	}
	
	$imgurls = addslashes($imgurls);

	//分析处理附加表数据
	$inadd_f = '';
	$inadd_v = '';
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
				if($vs[1]=='htmltext'||$vs[1]=='textdata') //HTML文本特殊处理
				{
					${$vs[0]} = AnalyseHtmlBody(${$vs[0]},$description,$litpic,$keywords,$vs[1]);
				}else{
					if(!isset(${$vs[0]}))
					{
						${$vs[0]} = '';
					}
					${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$id);
				}
				$inadd_f .= ",`{$vs[0]}` = '".${$vs[0]}."'";
			}
		}
	}

	//更新附加表
	$cts = $dsql->GetOne("Select addtable From `#@__channeltype` where id='$channelid' ");
	$addtable = trim($cts['addtable']);
	if($addtable!='')
	{
		$useip = GetIP();
		$query = "Update `$addtable`
      	set typeid='$typeid',
      	pagestyle='$pagestyle',
      	maxwidth = '$maxwidth',
      	ddmaxwidth = '$ddmaxwidth',
      	pagepicnum = '$pagepicnum',
      	imgurls='$imgurls',
      	row='$row',
      	col='$col',
      	isrm='$isrm'{$inadd_f},
      	redirecturl='$redirecturl',
      	userip = '$useip'
		where aid='$id'; ";
		if(!$dsql->ExecuteNoneQuery($query))
		{
			ShowMsg("更新附加表 `$addtable` 时出错，请检查原因！".$dsql->GetError(),"javascript:;");
			exit();
		}
	}

	//生成HTML
	UpIndexKey($id,$arcrank,$typeid,$sortrank,$tags);
	$arcUrl = MakeArt($id,true,true);
	if($arcUrl=='')
	{
		$arcUrl = $cfg_phpurl."/view.php?aid=$id";
	}
	ClearMyAddon($id, $title);
	//返回成功信息
	$msg =
	" 　　请选择你的后续操作：
    <a href='album_add.php?cid=$typeid'><u>继续发布图片</u></a>
    &nbsp;&nbsp;
    <a href='archives_do.php?aid=".$id."&dopost=editArchives'><u>查看更改</u></a>
    &nbsp;&nbsp;
    <a href='$arcUrl' target='_blank'><u>预览文档</u></a>
    &nbsp;&nbsp;
    <a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>管理已发布图片</u></a>
    &nbsp;&nbsp;
    $backurl
    ";

	$wintitle = "成功更改图集！";
	$wecome_info = "文章管理::更改图集";
	$win = new OxWindow();
	$win->AddTitle("成功更改一个图集：");
	$win->AddMsgItem($msg);
	$winform = $win->GetWindow("hand","&nbsp;",false);
	$win->Display();
}

?>