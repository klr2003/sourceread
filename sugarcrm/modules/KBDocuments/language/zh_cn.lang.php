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
/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
	//module
	'LBL_MODULE_NAME' => '知识文档库',
	'LBL_MODULE_TITLE' => '基本知识',
	'LNK_NEW_ARTICLE' => '新建文章',
	'LNK_KBDOCUMENT_LIST'=> '文档列表',
	'LBL_DOC_REV_HEADER' => '文档版本',
	'LBL_SEARCH_FORM_TITLE'=> '文档查找',
	'LBL_KBDOC_TAGS' => '文章标签:',
	'LBL_KBDOC_BODY' => '文章主体:',
	'LBL_KBDOC_APPROVED_BY' =>'审核人:',
	'LBL_KBDOC_ATTACHMENT' =>'文档附件',
	'LBL_KBDOC_ATTS_TITLE' =>'下载附件:',	
	'LBL_SEND_EMAIL'  => '发送邮件',
	'LBL_SELECT_TAG_BUTTON_TITLE' => '选择',
	'LBL_ATTACHMENTS' => '附件:',
	'LBL_EMBEDED_IMAGES' => '嵌入图象:',
	'LBL_SHOW_ARTICLE_DETAILS' => '显示细节',
	'LBL_HIDE_ARTICLE_DETAILS' => '隐藏细节',
	'LBL_TAGS' => '标签:',
	'LBL_NOT_AN_ADMIN_USER' => '非管理员用户',
	'LBL_NOT_A_VALID_FILE' => '无效文件',
	
	//Tag tree related labels    
    'LBL_SELECT_A_NODE_FROM_TREE' => '在树中选择一个节点',
    'LBL_SELECT_A_NODE_FROM_TREE' => '创建标签',
    'LBL_SEARCH'  =>'查找',
    'LBL_NEW_TAG_NAME' => '标签名称:',
	
	//vardef labels	
	'LBL_KBDOCUMENT_ID' => '文档编号',
	'LBL_ARTICLE_TITLE' => '标题:',
	'LBL_ARTICLE_AUTHOR' => '作者:',
	'LBL_ARTICLE_APPROVED_BY' =>'审核人:',
	'LBL_ARTICLE_BODY' => '文章主体:',
	'LBL_NAME' => '文档名称:',
	'LBL_DESCRIPTION' => '描述',
	'LBL_CATEGORY' => '类别',
	'LBL_SUBCATEGORY' => '子类别',
	'LBL_STATUS' => '状态',
	'LBL_CREATED_BY'=> '创建人',
	'LBL_DATE_ENTERED'=> '输入数据',
    'LBL_DATEENTERED'=> '输入数据:',
	'LBL_DATE_MODIFIED'=> '修改日期',
	'LBL_DELETED' => '删除',
	'LBL_MODIFIED'=> '按编号修改',
	'LBL_MODIFIED_USER' => '修改人',
	'LBL_CREATED'=> '创建人',
	'LBL_RELATED_DOCUMENT_ID'=>'相关文档编号',
	'LBL_RELATED_DOCUMENT_REVISION_ID'=>'相关文档版本编号',
	'LBL_IS_TEMPLATE'=>'是否模版',
	'LBL_TEMPLATE_TYPE'=>'文档类型',

    'LBL_PARENT_TYPE'=>'父结点类型',
	'LBL_NUMBER'    =>  'LBL_NUMBER',
    'LBL_TEXT_BODY' =>  '文本内容',
    'LBL_CREATED_BY_NAME' => 'LBL_CREATED_BY_NAME',
    'LBL_TAG_ID' => 'LBL_TAG_ID',
    'LBL_KBDOCUMENTS_KBTAGS_ID' => 'LBL_KBDOCUMENTS_KBTAGS_ID',
	'LBL_LATEST_REVISION_NAME' => '最新版本名称',
    'LBL_SELECTED_REVISION_NAME' => '所选版本名称',
	'LBL_REVISION_NAME' => '版本编号',
	'LBL_KBDOCUMENT_REVISION_NUMBER' => '文档版本编号',
	'LBL_MIME' => 'Mime Type',
	'LBL_REVISION' => '修订版本',
	'LBL_DOCUMENT' => '相关文档',
	'LBL_LATEST_REVISION' => '最新版本编号',
    'LBL_LATEST_REVISION_NAME' => '最新版本',
    'LBL_SELECTED_REVISION_NAME' => '选中版本',
	'LBL_CHANGE_LOG'=> '变化日志',
	'LBL_ACTIVE_DATE'=> '发版日期',
	'LBL_EXPIRATION_DATE' => '终止日期',
	'LBL_FILE_EXTENSION'  => '延伸文件',

    'LBL_KBDOC_TAGS' => '文档标签:',
	'LBL_KBDOC_BODY' => '文档内容:',
	'LBL_KBDOC_APPROVED_BY' =>'审核人:',
	'LBL_KBDOC_ATTACHMENT' =>'知识库文档附件:',
	'LBL_KBDOC_ATTS_TITLE' =>'下载附件:',

    'LBL_KNOWLEDGE_BASE_SEARCH' => '知识库检索',
	'LBL_KNOWLEDGE_BASE_ADMIN' => '知识库管理',
    'LBL_KNOWLEDGE_BASE_ADMIN_MENU' => '知识库管理',
     
	'LBL_CAT_OR_SUBCAT_UNSPEC'=>'未指定',
	//document edit and detail view
	'LBL_KBDOC_TAGS' => '标签:',
	'LBL_KBDOC_BODY' => '内容:',
	'LBL_KBDOC_APPROVED_BY' =>'审核人:',
	'LBL_KBDOC_ATTACHMENT' =>'知识库文档附件',
	'LBL_KBDOC_ATTS_TITLE' =>'下载附件:',
	'LBL_DOC_NAME' => '文档名称:',
	'LBL_FILENAME' => '文件名称:',
	'LBL_DOC_VERSION' => '修订版本:',
	'LBL_CATEGORY_VALUE' => '分类:',
	'LBL_SUBCATEGORY_VALUE'=> '子项分类:',
	'LBL_DOC_STATUS'=> '状态:',
	'LBL_LAST_REV_CREATOR' => '修订版本创建人:',
	'LBL_LAST_REV_DATE' => '修订日期:',
	'LBL_DOWNNLOAD_FILE'=> '附件:',
	'LBL_DET_RELATED_DOCUMENT'=>'相关文档:',
	'LBL_DET_RELATED_DOCUMENT_VERSION'=>"相关文档版本:",
	'LBL_DET_IS_TEMPLATE'=>'模版:',
	'LBL_DET_TEMPLATE_TYPE'=>'文档类型:',
	'LBL_IS_EXTERNAL_ARTICLE' => '外部文章:',
	'LBL_SHOW_TAGS' => '显示更多标签',
    'LBL_HIDE_TAGS' => '隐藏标签',




	'LBL_DOC_DESCRIPTION'=>'描述:',
	'LBL_KBDOC_SUBJECT' =>'主题:',
	'LBL_DOC_ACTIVE_DATE'=> '发版日期:',
	'LBL_DOC_EXP_DATE'=> '有效期:',

	//document list view.
	'LBL_LIST_ARTICLES' => '文章',
	'LBL_LIST_FORM_TITLE' => '文档列表',
	'LBL_LIST_DOCUMENT' => '文档',
	'LBL_LIST_CATEGORY' => '分类',
	'LBL_LIST_SUBCATEGORY' => '子项分类',
	'LBL_LIST_REVISION' => '修订版本',
	'LBL_LIST_LAST_REV_CREATOR' => '最新改版人',
	'LBL_LIST_LAST_REV_DATE' => '改版日期',
	'LBL_LIST_VIEW_DOCUMENT'=>'查看',
    'LBL_LIST_DOWNLOAD'=> '下载',
	'LBL_LIST_ACTIVE_DATE' => '发版日期',
	'LBL_LIST_EXP_DATE' => '有效期',
	'LBL_LIST_STATUS'=>'状态',
    'LBL_ARTICLE_AUTHOR_LIST' => '作者',

	//document search form.
	'LBL_SF_DOCUMENT' => '文档名称:',
	'LBL_SF_CATEGORY' => '分类:',
	'LBL_SF_SUBCATEGORY'=> '子项分类:',
	'LBL_SF_ACTIVE_DATE' => '发版日期:',
	'LBL_SF_EXP_DATE'=> '有效期:',

	'DEF_CREATE_LOG' => '已创建文档',
    
    //kbdocument full text search form.
    'LBL_TAB_SEARCH' => '搜索',
    'LBL_TAB_BROWSE' => '浏览',
    'LBL_TAB_ADVANCED' => '高级',
    'LBL_MENU_FTS' => '全文本检索',
    'LBL_FTS_EMPTY_STRING' =>  '在空字符串中不可使用全文本检索',
    'LBL_SEARCH_WITHIN' => '查找界于:',      
    'LBL_CONTAINING_THESE_WORDS' => '包含这些词语:',     
    'LBL_EXCLUDING_THESE_WORDS' => '不包含这些词语:',  
    'LBL_UNDER_THIS_TAG' => '使用这个标签:',
    'LBL_PUBLISHED' => '发版:',
    'LBL_EXPIRES' => '有效期:',
    'LBL_TIMES_VIEWED' => '查看次数:',    
    'LBL_ATTACHMENTS' => '附件:',
    'LBL_SAVE_SEARCH_AS' => '保存查找为:',
    'LBL_SAVE_SEARCH_AS_HELP' => '这样保存了您的指定输入作为保存知识库查找过滤.',
    'LBL_PREVIOUS_SAVED_SEARCH' => '以前保存的查找:',
    'LBL_PREVIOUS_SAVED_SEARCH_HELP' => '编辑或者删除一个存在的保存的查找.',
    'LBL_UPDATE' => '更新',
    'LBL_DELETE' => '删除',
    'LBL_SHOW_OPTIONS' => '显示更多选项',
    'LBL_AND' => '和',
    'LBL_SEARCH' => '查找',
    'LBL_CLEAR' => '清除',
    'LBL_LIST_KBDOC_APPROVER_NAME' => '审核人姓名',
    'LBL_LIST_VIEWING_FREQUENCY' => '周期',  
    'LBL_ARTICLE_PREVEW_UNAVAILABLE_NO_DOCUMENT' => '不可预览，没有找到文档记录.',
    'LBL_ARTICLE_PREVEW_UNAVAILABLE_NO_CONTENT' => 'P不可预览，虽然文档存在，但是文档还没有内容.',
    'LBL_UNTAGGED_ARTICLES_NODE' => '未标签的文章',
    'LBL_TOP_TEN_LIST_TITLE' => '前十篇被看的最多的文章',
    'LBL_SHOW_SYNTAX_HELP' => '搜索[语法]提示',
    'LBL_MISMATCH_QUOTES_ERR' => '您的查询将不被检索. 必须有一个最近的双引号对于每个双引号，使其成为一对，如果您希望用双引号查找一个字符串，用反斜杠来表示它 (\")', 
    'LBL_SYNTAX_CHEAT_SHEET' => 
        '<B>搜索[语法]提示:</b><P>
        <ol>
<li>加号 (+)  表明结果“一定含有”这个选项.</li>
<li>减号 (-) 表明结果“不应该含有”这一条.  减号 (-) 不是必要的如果您填入的文本字段或单词被排除.</li>
<li>在一对双引号中有多个单词，标记 ("例子1 例子2") 被视为单一查找项. 必须有一组打开和关闭的双引号标记否则搜索将不会执行.<br>当搜索引号标记本身时, 使用反斜杠-引号 (\") 代替.</li>
<li>一个单引号标记 (\') 将被作为一个查找，而不是作为一组.</li></ol>

        </p>

        <p><b>例如: </b><br><br>
        查询含有单词“Sugar”或“CRM”的文章必须有单词"Knowledge Base" 和"cool, "但是不应该有单词 "demo" or "过去式," 输入下列字符串:<br>&nbsp;&nbsp;&nbsp;&nbsp;Sugar CRM +"Knowledge Base" +cool -demo -"Past Tense"</p><br>

        <p><b>注意: </b><br>
<ol><li>客户反馈信息没关系.</li>
<li>空格和逗号是都可接受的分割符.</li>
<li>不要在加号(+) 或者 减号 (-) 和单词间输入空格.</li></ol>
</p>',
        
    //for hovering over tree
    'LBL_CHILD_TAG_IN_TREE_HOVER' => '子标签',
    'LBL_CHILD_TAGS_IN_TREE_HOVER' => '子标签',
    'LBL_ARTICLE_IN_TREE_HOVER' => '文章',
    'LBL_ARTICLES_IN_TREE_HOVER' => '文章',
    'LBL_THIS_TAG_CONTAINS_TREE_HOVER' => '本标签含有',
    
	//error messages
	'ERR_DOC_NAME'=>'文档名称',
	'ERR_DOC_ACTIVE_DATE'=>'公布日期',
	'ERR_DOC_EXP_DATE'=> '有效期',
	'ERR_FILENAME'=> '文件名称',
	'ERR_DOC_VERSION'=> '文档版本',
	'ERR_DELETE_CONFIRM'=> '您确定要删除这个文档版本?',
	'ERR_DELETE_LATEST_VERSION'=> '您沒有权限删除这个文档的最新版本.',
	'LNK_NEW_MAIL_MERGE' => '邮件合并',
	'LBL_MAIL_MERGE_DOCUMENT' => '邮件合并模版:',

	'LBL_TREE_TITLE' => '文档',
	//sub-panel vardefs.
	'LBL_LIST_DOCUMENT_NAME'=>'文档名称',
	'LBL_CONTRACT_NAME'=>'合同名称:',
	'LBL_LIST_IS_TEMPLATE'=>'模板?',
	'LBL_LIST_TEMPLATE_TYPE'=>'文档类型',
	'LBL_LIST_SELECTED_REVISION'=>'选择的版本',
	'LBL_LIST_LATEST_REVISION'=>'最新版本',
	'LBL_CASES_SUBPANEL_TITLE'=>'相关客户反馈',
	'LBL_EMAILS_SUBPANEL_TITLE' => '相关电子邮件',
    'LBL_CONTRACTS_SUBPANEL_TITLE'=>'相关合同',
	'LBL_LAST_REV_CREATE_DATE'=>'最新版本修改日期',
    //'LNK_DOCUMENT_CAT'=>'文档类型',
    'LBL_KEYWORDS' => '关键字:',
    'LBL_CASES' =>'客户反馈信息',
    'LBL_EMAILS' =>'电子邮件',
    
   //Admin screen messages
    'LBL_DEFAULT_ADMIN_MESSAGE' =>'从下拉菜单列表选择一个动作',
    'LBL_SELECT_PARENT_TAG_MESSAGE' =>'从树中选择一个父标签',
    'LBL_SELECT_TAG_TO_BE_DELETED_FROM_TREE' => '选择的标签在树中被删除',
    'LBL_SELECT_TAG_TO_BE_RENAMED_FROM_TREE' =>'选择的标签在树种被更名',
       
     //Tag creation messages
    'LBL_TAG_ALREADY_EXISTS' => '标签已经存在',
    'LBL_TYPE_THE_NEW_TAG_NAME' => '键入新标签名称',
    'LBL_SAVING_THE_TAG' => '保存标签...',
    'LBL_CREATING_NEW_TAG' => '创建新标签...',
    'LBL_TAGS_ROOT_LABEL' => '标签',            
    'LBL_FAQ_TAG_NOT_RENAME_MESSAGE' => 'FAQs 标签不能被重命名',
    'LBL_SELECT_ARTICLES_TO_BE_MOVED_TO_OTHER_TAG' => '首先选择文章 ',
    'LBL_SELECT_ARTICLES_TO_APPLY_TAGS' => '选择文章来应用标签',
    'LBL_SELECT_ARTICLES_TO_DELETE'  => '首先选择文章 ',
    'LBL_SELECT_TAGS_TO_DELETE'  => '选择标签来删除',
    'LBL_SELECT_A_TAG_FROM_TREE' => '从树中选择A标签',
    'LBL_SELECT_TAGS_FROM_TREE'  => '从树中选择标签',
    'LBL_MOVING_ARTICLES_TO_TAG' =>'移动文章到标签...',
    'LBL_APPLYING_TAGS_TO_ARTICLES' =>'在文章上应用标签 ...',
    'LBL_ROOT_TAG_MESSAGE' => '根标签不能够被选择/连接到文章',
    'LBL_ROOT_TAG_CAN_NOT_BE_RENAMED' => '根标签不能被重命名',
    'LBL_SOURCE_AND_TARGET_TAGS_ARE_SAME' => '资源和目标标签是相同的',
    'LBL_TYPE_NEW_NODE_NAME'=>'请输入标签名',    
    //Tag button labels
    'LBL_DELETE_TAG'  => '删除标签',
    'LBL_SELECT_TAG'  => '选择标签',
    'LBL_APPLY_TAG'  =>  '应用标签',
    'LBL_MOVE'  =>   '移动',
    'LBL_LAUNCHING_TAG_BROWSING' => '展开标签浏览...',
    'LBL_THERE_WAS_AN_ERROR_HANDLING_TAGS' => '这是一个错误的标签处理请求.',
    'LBL_ERROR_NOT_A_FILE_INPUT_ELEMENT' =>'错误：不是一个文件输入元素',
    'LBL_CREATE_NEW_TAG'  => '创建新标签',
    'LBL_SEARCH_TAG'  => '搜索',
    'LBL_TAG_NAME'  =>'标签名称:',
    
    'LBL_SELECT_TAGS_TO_DELETE' => '选择要删除的标签',
    'LBL_TYPE_TAG_NAME_TO_SEARCH' => '键入标签名称以便搜索',
    'LBL_KB_NOTIFICATION' => '文档已被发布',
    'LBL_KB_PUBLISHED_REQUEST' => '已分配一个文档给你用语审核和发布.',
    'LBL_KB_STATUS_BACK_TO_DRAFT' => '文档状态已经变化为起草状态',

    'LBL_CONTRACTS' => '合同',

    'LBL_LIST_MOST_VIEWED' => '最热文章',
    'LBL_LIST_MOST_RECENT' => '最新文章',
	
	'LBL_SELECT_PARENT_TREE_NOTICE' => '从树形中选择父标签 ',
	'LBL_CLICK_APPLY_TAG' => '点击 应用标签',
	'LBL_HEAD_TAGS' => '标签',
);
?>

