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
	'LBL_FW'					=> 'FW:',
	'LBL_RE'					=> 'RE:',

	'LBL_BUTTON_CREATE'					=> '创建',
	'LBL_BUTTON_EDIT'					=> '编辑',
	'LBL_QS_DISABLED'                   => '(此模板对快速查找无效. 请使用选择按钮.)',  
	'LBL_SIGNATURE_PREPEND'				=> '在回复上签名吗?',
    'LBL_EMAIL_DEFAULT_DESCRIPTION' 	=> '这是这是您请求的引用 (您可以改变这个文本)',
    'LBL_EMAIL_QUOTE_FOR' => 'Quote for: ',
    'LBL_QUOTE_LAYOUT_DOES_NOT_EXIST_ERROR' => '引用布局文件不存在: $layout',
    'LBL_QUOTE_LAYOUT_REGISTERED_ERROR' => '引用布局不在modules/Quotes/Layouts.php中注册',

	'LBL_CONFIRM_DELETE' => '您确实要删除这个文件夹吗?',

	'LBL_QUOTES_SUBPANEL_TITLE' => '报价',
	'LBL_EMAILS_QUOTES_REL' => '电子邮件:报价',
    'LBL_ERROR_SELECT_REPORT'   => '请选择一个报表',
    'LBL_ERROR_SELECT_MODULE_SELECT'   => '请点击相关字段旁的选择按钮来选择',
    'LBL_ERROR_SELECT_MODULE'   => '请为相关字段选择一个模块',
	'ERR_ARCHIVE_EMAIL' => '错误:选择要存档的电子邮件',
	'ERR_DATE_START' => '开始日期',
	'ERR_DELETE_RECORD' => '错误:记录数必须指定删除的帐户。',
	'ERR_NOT_ADDRESSED' => '错误:电子邮件必须要有收件人，抄送，或者密送地址。',
	'ERR_TIME_START' => '开始时间',
	'LBL_ACCOUNTS_SUBPANEL_TITLE' => '客户',
	'LBL_ADD_ANOTHER_FILE' => '增加另外一个文件',
	'LBL_ADD_DASHLETS' => '增加新增栏',
	'LBL_ADD_DOCUMENT' => '从sugarCRM文档中增加文档',
	'LBL_ADD_ENTRIES'           => '添加记录',
	'LBL_ADD_FILE' => '从文件系统中增加文档',
	'LBL_ARCHIVED_EMAIL' => '已存档的电子邮件',
	'LBL_ARCHIVED_MODULE_NAME' => '新增存档电子邮件',
	'LBL_ATTACHMENTS' => '附件:',
	'LBL_BCC' => '密送:',
	'LBL_BODY' => '正文:',
	'LBL_BUGS_SUBPANEL_TITLE' => '缺陷',
	'LBL_CC' => '抄送:',
	'LBL_COLON'					=> ':',
	'LBL_COMPOSE_MODULE_NAME' => '撰写电子邮件',
	'LBL_CONTACT_FIRST_NAME' => '联系人的名:',
	'LBL_CONTACT_LAST_NAME' => '联系人的姓:',
	'LBL_CONTACT_NAME' => '联系人:',
	'LBL_CONTACTS_SUBPANEL_TITLE' => '联系人',
	'LBL_CREATED_BY' => '创建人',
	'LBL_DATE_AND_TIME' => '发送日期:',
	'LBL_DATE_SENT' => '发送日期:',
	'LBL_DATE' => '发送日期:',
    'LBL_DELETE_FROM_SERVER'    => '从服务器上删除消息',
	'LBL_DESCRIPTION' => '说明',
	'LBL_EDIT_ALT_TEXT' => '编辑纯文本:',
	'LBL_EDIT_MY_SETTINGS' => '编辑我的设置',
	'LBL_EMAIL_ATTACHMENT' => '电子邮件附件',
	'LBL_EMAIL_EDITOR_OPTION' => '发送HTML电子邮件',
	'LBL_EMAIL_SELECTOR' => '选择',
	'LBL_EMAIL' => '电子邮件:',
	'LBL_EMAILS_ACCOUNTS_REL' => '电子邮件:帐户',
	'LBL_EMAILS_BUGS_REL' => '电子邮件:缺陷',
	'LBL_EMAILS_CASES_REL' => '电子邮件:用户反馈',
	'LBL_EMAILS_CONTACTS_REL' => '电子邮件:联系人',
	'LBL_EMAILS_LEADS_REL' => '电子邮件:潜在用户',
	'LBL_EMAILS_OPPORTUNITIES_REL' => '电子邮件:商业机会',
	'LBL_EMAILS_NOTES_REL' => '电子邮件:备忘录',
	'LBL_EMAILS_PROJECT_REL' => '电子邮件:项目',
	'LBL_EMAILS_PROJECT_TASK_REL' => '电子邮件:项目任务',
	'LBL_EMAILS_PROSPECT_REL' => '电子邮件:销售前景',
	'LBL_EMAILS_TASKS_REL' => '电子邮件:任务',
	'LBL_EMAILS_USERS_REL' => '电子邮件:用户',
	'LBL_ERROR_SENDING_EMAIL' => '发送电子邮件错误',
	'LBL_FORWARD_HEADER' => '开始转发消息:',
	'LBL_FROM_NAME' => '发件人姓名',
	'LBL_FROM' => '发件人:',
	'LBL_HTML_BODY' => 'HTML正文',
	'LBL_INVITEE' => '收件人',
	'LBL_LEADS_SUBPANEL_TITLE' => '潜在客户',
	'LBL_MESSAGE_SENT' => '发送消息',
	'LBL_MODIFIED_BY' => '修改人',
	'LBL_MODULE_NAME_NEW' => '存档电子邮件',
	'LBL_MODULE_NAME' => '电子邮件箱',
	'LBL_MODULE_TITLE' => '电子邮件:',
	'LBL_NEW_FORM_TITLE' => '存档电子邮件',
	'LBL_NONE'                  => '无',
	'LBL_NOT_SENT' => '发送错误',
	'LBL_NOTE_SEMICOLON' => '注意:使用分号，或者单引号来分隔多个电子邮件地址。',
	'LBL_NOTES_SUBPANEL_TITLE' => '附件',
	'LBL_OPPORTUNITY_SUBPANEL_TITLE' => '商业机会',
	'LBL_PROJECT_SUBPANEL_TITLE' => '项目',
	'LBL_PROJECT_TASK_SUBPANEL_TITLE' => '项目任务',
	'LBL_RAW' => '原始电子邮件',
	'LBL_SAVE_AS_DRAFT_BUTTON_KEY'=> 'R',
	'LBL_SAVE_AS_DRAFT_BUTTON_LABEL' => '保存草稿',
	'LBL_SAVE_AS_DRAFT_BUTTON_TITLE' => '保存草稿[Alt+R]',
	'LBL_SEARCH_FORM_DRAFTS_TITLE' => '查找草稿',
	'LBL_SEARCH_FORM_SENT_TITLE' => '查找已发送电子邮件',
	'LBL_SEARCH_FORM_TITLE' => '查找电子邮件',
	'LBL_SEND_ANYWAYS' => '电子邮件没有主题，一定要发送/保存吗?',
	'LBL_SEND_BUTTON_KEY'		=> 'S',
	'LBL_SEND_BUTTON_LABEL' => '发送',
	'LBL_SEND_BUTTON_TITLE' => '发送[Alt+S]',
	'LBL_SEND' => '发送',
	'LBL_SENT_MODULE_NAME' => '发件箱',
	'LBL_SHOW_ALT_TEXT' => '显示纯文本',
	'LBL_SIGNATURE' => '签名',
	'LBL_SUBJECT' => '主题:',
	'LBL_TEXT_BODY' => '文本正文',
	'LBL_TIME' => '发送时间:',
	'LBL_TO_ADDRS' => '收件人',
	'LBL_USE_TEMPLATE' => '使用模板:',
	'LBL_USERS_SUBPANEL_TITLE' => '用户',
	'LBL_USERS' => '用户',

	'LNK_ALL_EMAIL_LIST' => '电子邮件箱',
	'LNK_ARCHIVED_EMAIL_LIST' => '已存档的电子邮件',
	'LNK_CALL_LIST' => '电话',
	'LNK_DRAFTS_EMAIL_LIST' => '草稿箱',
	'LNK_EMAIL_LIST' => '电子邮件',
	'LBL_EMAIL_RELATE'          => '相关',
	'LNK_EMAIL_TEMPLATE_LIST' => '电子邮件模版',
	'LNK_MEETING_LIST' => '会议',
	'LNK_NEW_ARCHIVE_EMAIL' => '新增存档电子邮件',
	'LNK_NEW_CALL' => '安排电话',
	'LNK_NEW_EMAIL_TEMPLATE' => '创建电子邮件模版',
	'LNK_NEW_EMAIL' => '存档电子邮件',
	'LNK_NEW_MEETING' => '安排会议',
	'LNK_NEW_NOTE' => '新增备忘录',
	'LNK_NEW_SEND_EMAIL' => '撰写电子邮件',
	'LNK_NEW_TASK' => '新增任务',
	'LNK_NOTE_LIST' => '备忘录',
	'LNK_SENT_EMAIL_LIST' => '发件箱',
	'LNK_TASK_LIST' => '任务',
	'LNK_VIEW_CALENDAR' => '今天',

	'LBL_LIST_ASSIGNED' => '负责人',
	'LBL_LIST_CONTACT_NAME' => '联系人姓名',
	'LBL_LIST_CREATED' => '创建人',
	'LBL_LIST_DATE_SENT' => '发送日期',
	'LBL_LIST_DATE' => '发送日期',
	'LBL_LIST_FORM_DRAFTS_TITLE' => '草稿',
	'LBL_LIST_FORM_SENT_TITLE' => '发件箱',
	'LBL_LIST_FORM_TITLE' => '电子邮件列表',
	'LBL_LIST_FROM_ADDR' => '发件人',
	'LBL_LIST_RELATED_TO' => '相关',
	'LBL_LIST_SUBJECT' => '主题',
	'LBL_LIST_TIME' => '发送时间',
	'LBL_LIST_TO_ADDR' => '收件人',
	'LBL_LIST_TYPE' => '类型',

	'NTC_REMOVE_INVITEE' => '您确定要从这封电子邮件中移除收件人吗?',
	'WARNING_SETTINGS_NOT_CONF' => '警告:电子邮件设置没有配置，不能发送电子邮件。',
	'WARNING_NO_UPLOAD_DIR' => '附件可能丢失:检测到变量“upload_tmp_dir”没有值。请在php.ini文件中重新配置这个变量。',
	'WARNING_UPLOAD_DIR_NOT_WRITABLE' => '附件可能丢失:检测到变量“upload_tmp_dir”的值是错误的或者是不可以使用的。请在php.ini文件中重新配置这个变量。',

    // for All emails
	'LBL_BUTTON_RAW_TITLE' => '显示原始电子邮件[Alt+E]',
    'LBL_BUTTON_RAW_KEY'     => 'e',
	'LBL_BUTTON_RAW_LABEL' => '显示原始电子邮件',
	'LBL_BUTTON_RAW_LABEL_HIDE' => '隐藏原始电子邮件',

	// for InboundEmail
	'LBL_BUTTON_CHECK' => '接收邮件',
	'LBL_BUTTON_CHECK_TITLE' => '接收新的电子邮件[Alt+C]',
	'LBL_BUTTON_CHECK_KEY'		=> 'c',
	'LBL_BUTTON_FORWARD' => '转发',
	'LBL_BUTTON_FORWARD_TITLE' => '转发这封电子邮件[Alt+F]',
	'LBL_BUTTON_FORWARD_KEY'	=> 'f',
	'LBL_BUTTON_REPLY_KEY'		=> 'r',
	'LBL_BUTTON_REPLY_TITLE' => '回复[Alt+R]',
	'LBL_BUTTON_REPLY' => '回复',
	'LBL_CASES_SUBPANEL_TITLE' => '客户反馈',
	'LBL_INBOUND_TITLE' => '收件箱',
	'LBL_INTENT' => '目的',
	'LBL_MESSAGE_ID' => '消息编号',
	'LBL_REPLY_HEADER_1' => '于',
	'LBL_REPLY_HEADER_2' => '写:',
	'LBL_REPLY_TO_ADDRESS' => '回复人地址',
	'LBL_REPLY_TO_NAME' => '回复人姓名',

	'LBL_LIST_BUG' => '缺陷',
	'LBL_LIST_CASE' => '客户反馈',
	'LBL_LIST_CONTACT' => '联系人',
	'LBL_LIST_LEAD' => '潜在客户',
	'LBL_LIST_TASK' => '任务',
	'LBL_LIST_ASSIGNED_TO_NAME' => '负责人',

	// for Inbox
	'LBL_ALL' => '所有',
	'LBL_ASSIGN_WARN' => '确保所有的3个选项都被选中。',
	'LBL_BACK_TO_GROUP' => '返回组收件箱',
	'LBL_BUTTON_DISTRIBUTE_KEY'	=> 'a',
	'LBL_BUTTON_DISTRIBUTE_TITLE' => '指派[Alt+A]',
	'LBL_BUTTON_DISTRIBUTE' => '指派',
	'LBL_BUTTON_GRAB_KEY'		=> 't',
	'LBL_BUTTON_GRAB_TITLE' => '从组邮件箱中接收[Alt+T]',
	'LBL_BUTTON_GRAB' => '从组邮件箱中接收',
	'LBL_CREATE_BUG' => '新增缺陷',
	'LBL_CREATE_CASE' => '新增客户反馈',
	'LBL_CREATE_CONTACT' => '新增联系人',
	'LBL_CREATE_LEAD' => '新增潜在客户',
	'LBL_CREATE_TASK' => '新增任务',
	'LBL_DIST_TITLE' => '任务',
	'LBL_LOCK_FAIL_DESC' => '被选中的记录现在不可以被使用。',
	'LBL_LOCK_FAIL_USER' => '采取所有权。',
	'LBL_MASS_DELETE_ERROR' => '选中的记录未被删除。',
	'LBL_NEW' => '新邮件',
	'LBL_NEXT_EMAIL' => '下一封电子邮件',
	'LBL_NO_GRAB_DESC' => '没有记录可以被使用。稍后再试。',
	'LBL_QUICK_REPLY' => '回复',
	'LBL_REPLIED' => '已回复',
	'LBL_SELECT_TEAM' => '选择团队',
	'LBL_TAKE_ONE_TITLE' => '名',
	'LBL_TITLE_SEARCH_RESULTS' => '查找结果',
	'LBL_TO' => '收件人:',
	'LBL_TOGGLE_ALL' => '全选',
	'LBL_UNKNOWN' => '未知',
	'LBL_UNREAD_HOME' => '未读电子邮件',
	'LBL_UNREAD' => '未阅读',
	'LBL_USE_ALL' => '所有查找结果',
	'LBL_USE_CHECKED' => '只有选中的',
	'LBL_USE_MAILBOX_INFO' => '使用邮箱:地址',
	'LBL_USE' => '指派:',
	'LBL_ASSIGN_SELECTED_RESULTS_TO' => '分配选择结果给: ',
	'LBL_USER_SELECT' => '选择用户',
	'LBL_USING_RULES' => '使用规则:',
	'LBL_WARN_NO_DIST' => '未选择分发方式。',
	'LBL_WARN_NO_USERS' => '未选择用户',

	'LBL_LIST_STATUS' => '状态',
	'LBL_LIST_TITLE_GROUP_INBOX' => '组收件箱',
	'LBL_LIST_TITLE_MY_DRAFTS' => '我的草稿箱',
	'LBL_LIST_TITLE_MY_INBOX' => '我的收件箱',
	'LBL_LIST_TITLE_MY_SENT' => '我的发件箱',
	'LBL_LIST_TITLE_MY_ARCHIVES' => '我的存档电子邮件',

	'LNK_CHECK_MY_INBOX' => '接收我的邮件',
	'LNK_DATE_SENT' => '发送日期',
	'LNK_GROUP_INBOX' => '组收件箱',
	'LNK_MY_DRAFTS' => '我的草稿箱',
	'LNK_MY_INBOX' => '我的收件箱',
	'LNK_QUICK_REPLY' => '回复',
	'LNK_MY_ARCHIVED_LIST' => '我的存档邮件箱',

	// advanced search
	'LBL_ASSIGNED_TO' => '负责人:',
	'LBL_MEMBER_OF' => '父类',
	'LBL_QUICK_CREATE' => '快速新增',
	'LBL_STATUS' => '电子邮件状态:',
	'LBL_TYPE' => '类型:',
	
	//#20680 EmialTemplate Ext.Message.show;
	'LBL_EMAILTEMPLATE_MESSAGE_SHOW_TITLE' => '请检查！',
	'LBL_EMAILTEMPLATE_MESSAGE_SHOW_MSG' => '您确定要替换这个模板? 这将导致您已经填写的数据丢失！',
	'LBL_REPLY_TO' => '回复:',
	'LBL_EMAIL_FLAGGED' => '已标记:',
	'LBL_EMAIL_REPLY_TO_STATUS' => '回复状态:',
	'LBL_CHECK_ATTACHMENTS'=>'请检查附件!',
	'LBL_HAS_ATTACHMENTS' => '这封邮件有附件。你要保留它（们）吗？',	
);
