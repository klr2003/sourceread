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

//the left value is the key stored in the db and the right value is ie display value
//to translate, only modify the right value in each key/value pair
$app_list_strings = array (
  'language_pack_name' => '简体中文',
  'moduleList' => 
  array (
    'Home' => '首页',
    'Bugs' => '缺陷追踪',
    'Cases' => '客户反馈',
    'Notes' => '备忘录',
    'Newsletters' => '列表',
    'Teams' => '团队',
    'Users' => '用户',
    'KBDocuments' => '知识库',
    'FAQ' => '常见问题',
  ),
  'moduleListSingular' => 
  array (
    'Home' => '首页',
    'Bugs' => '缺陷追踪',
    'Cases' => '客户反馈',
    'Notes' => '备忘录',
    'Teams' => '团队',
    'Users' => '用户',
  ),
  'checkbox_dom' => 
  array (
    '' => '',
    1 => '是',
    2 => '否',
  ),
  'account_type_dom' => 
  array (
    '' => '',
    'Analyst' => '分析者',
    'Competitor' => '竞争者',
    'Customer' => '客户',
    'Integrator' => '整合者',
    'Investor' => '投资者',
    'Partner' => '合作者',
    'Press' => '出版商',
    'Prospect' => '销售前景',
    'Reseller' => '批发商',
    'Other' => '其它',
  ),
  'industry_dom' => 
  array (
    '' => '',
    'Apparel' => '服裝',
    'Banking' => '银行',
    'Biotechnology' => '生物技术',
    'Chemicals' => '化学化工',
    'Communications' => '通讯',
    'Construction' => '建筑',
    'Consulting' => '咨询',
    'Education' => '教育',
    'Electronics' => '电子',
    'Energy' => '能源',
    'Engineering' => '工程设计',
    'Entertainment' => '文化',
    'Environmental' => '环境保护',
    'Finance' => '金融',
    'Government' => '政府机构',
    'Healthcare' => '卫生保健',
    'Hospitality' => '医疗机构',
    'Insurance' => '保险',
    'Machinery' => '机械',
    'Manufacturing' => '生产企业',
    'Media' => '医院',
    'Not For Profit' => '非盈利机构',
    'Recreation' => '娱乐',
    'Retail' => '零售',
    'Shipping' => '海运',
    'Technology' => '技术',
    'Telecommunications' => '电信',
    'Transportation' => '运输',
    'Utilities' => '公用事业',
    'Other' => '其它',
  ),
  'lead_source_default_key' => 'Self Generated',
  'lead_source_dom' => 
  array (
    '' => '',
    'Cold Call' => '意外来访',
    'Existing Customer' => '现有客户',
    'Self Generated' => '自产',
    'Employee' => '员工',
    'Partner' => '合作者',
    'Public Relations' => '公共关系',
    'Direct Mail' => '直邮',
    'Conference' => '会议',
    'Trade Show' => '展览',
    'Web Site' => '网站',
    'Word of mouth' => '他人介紹',
    'Email' => '电子邮件',
    'Other' => '其它',
  ),
  'opportunity_type_dom' => 
  array (
    '' => '',
    'Existing Business' => '已有生意',
    'New Business' => '新生意',
  ),
  'opportunity_relationship_type_default_key' => '主要决策人',
  'opportunity_relationship_type_dom' => 
  array (
    '' => '',
    'Primary Decision Maker' => '主要决策人',
    'Business Decision Maker' => '商业决策者',
    'Business Evaluator' => '商业评估者',
    'Technical Decision Maker' => '技术决策者',
    'Technical Evaluator' => '技术评估人',
    'Executive Sponsor' => '主管助理',
    'Influencer' => '影响者',
    'Other' => '其它',
  ),
  'case_relationship_type_default_key' => '主要联系人',
  'case_relationship_type_dom' => 
  array (
    '' => '',
    'Primary Contact' => '主要联系人',
    'Alternate Contact' => '其他联系人',
  ),
  'payment_terms' => 
  array (
    '' => '',
    'Net 15' => '货到15天付款',
    'Net 30' => '货到30天付款',
  ),
  'sales_stage_default_key' => '销售前景',
  'sales_stage_dom' => 
  array (
    'Prospecting' => '销售前景',
    'Qualification' => '资格合格',
    'Needs Analysis' => '需要分析',
    'Value Proposition' => '价值陈述',
    'Id. Decision Makers' => '辨识决策者',
    'Perception Analysis' => '感觉分析',
    'Proposal/Price Quote' => '建议/出价',
    'Negotiation/Review' => '谈判/回顾',
    'Closed Won' => '谈成结束',
    'Closed Lost' => '丢单结束',
  ),
  'sales_probability_dom' => 
  array (
    'Prospecting' => '10',
    'Qualification' => '20',
    'Needs Analysis' => '25',
    'Value Proposition' => '30',
    'Id. Decision Makers' => '40',
    'Perception Analysis' => '50',
    'Proposal/Price Quote' => '65',
    'Negotiation/Review' => '80',
    'Closed Won' => '100',
    'Closed Lost' => '0',
  ),
  'activity_dom' => 
  array (
    'Call' => '电话',
    'Meeting' => '会议',
    'Task' => '任务',
    'Email' => '电子邮件',
    'Note' => '备忘录',
  ),
  'salutation_dom' => 
  array (
    '' => '',
    'Mr.' => '先生',
    'Ms.' => '小姐',
    'Mrs.' => '女士',
    'Dr.' => '博士',
    'Prof.' => '教授',
  ),
  'reminder_max_time' => 3600,
  'reminder_time_options' => 
  array (
    60 => '提前1分钟',
    300 => '提前5分钟',
    600 => '提前10分钟',
    900 => '提前15分钟',
    1800 => '提前30分钟',
    3600 => '提前1小时',
  ),
  'task_priority_default' => '中',
  'task_priority_dom' => 
  array (
    'High' => '高',
    'Medium' => '中',
    'Low' => '低',
  ),
  'task_status_default' => '未开始',
  'task_status_dom' => 
  array (
    'Not Started' => '未开始',
    'In Progress' => '处理中',
    'Completed' => '完成',
    'Pending Input' => '等待输入',
    'Deferred' => '延期',
  ),
  'meeting_status_default' => '已计划',
  'meeting_status_dom' => 
  array (
    'Planned' => '已计划',
    'Held' => '完成',
    'Not Held' => '未开始',
  ),
  'call_status_default' => '已计划',
  'call_status_dom' => 
  array (
    'Planned' => '已计划',
    'Held' => '完成',
    'Not Held' => '未开始',
  ),
  'call_direction_default' => '发件箱',
  'call_direction_dom' => 
  array (
    'Inbound' => '打入',
    'Outbound' => '打出',
  ),
  'lead_status_dom' => 
  array (
    '' => '',
    'New' => '新增',
    'Assigned' => '已分配',
    'In Process' => '处理中',
    'Converted' => '已转换',
    'Recycled' => '已重复',
    'Dead' => '终止',
  ),
  'lead_status_noblank_dom' => 
  array (
    'New' => 'New',
    'Assigned' => 'Assigned',
    'In Process' => 'In Process',
    'Converted' => 'Converted',
    'Recycled' => 'Recycled',
    'Dead' => 'Dead',
  ),
  'case_status_default_key' => '新增',
  'case_status_dom' => 
  array (
    'New' => '新增',
    'Assigned' => '已分配',
    'Closed' => '结束',
    'Pending Input' => '等待输入',
    'Rejected' => '拒绝',
    'Duplicate' => '重复',
  ),
  'case_priority_default_key' => 'P2',
  'case_priority_dom' => 
  array (
    'P1' => '高',
    'P2' => '中',
    'P3' => '低',
  ),
  'user_status_dom' => 
  array (
    'Active' => '启用',
    'Inactive' => '停用',
  ),
  'employee_status_dom' => 
  array (
    'Active' => '启用',
    'Terminated' => '终止',
    'Leave of Absence' => '离职',
  ),
  'messenger_type_dom' => 
  array (
    '' => '',
    'MSN' => 'MSN',
    'Yahoo!' => 'Yahoo!',
    'AOL' => 'AOL',
  ),
  'project_task_priority_options' => 
  array (
    'High' => '高',
    'Medium' => '中',
    'Low' => '低',
  ),
  'project_task_status_options' => 
  array (
    'Not Started' => '未开始',
    'In Progress' => '处理中',
    'Completed' => '完成',
    'Pending Input' => '等待输入',
    'Deferred' => '延期',
  ),
  'project_task_utilization_options' => 
  array (
    0 => '无',
    25 => '25',
    50 => '50',
    75 => '75',
    100 => '100',
  ),
  'record_type_default_key' => '客户',
  'record_type_display' => 
  array (
    'Accounts' => '客户',
    'Opportunities' => '商业机会',
    'Cases' => '客户反馈',
    'Leads' => '潜在客户',
    'Contacts' => '联系人档案',




    'Bugs' => '缺陷',
    'Project' => '项目管理',
    'ProjectTask' => '项目任务',
    'Tasks' => '任务',
  ),
  'record_type_display_notes' => 
  array (
    'Accounts' => '客户',
    'Contacts' => '联系人',
    'Opportunities' => '商业机会',
    'Cases' => '用户反馈',
    'Leads' => '潜在客户',






    'Bugs' => '缺陷追踪',
    'Emails' => '电子邮件',
    'Project' => '项目管理',
    'ProjectTask' => '项目任务',
    'Meetings' => '会议',
    'Calls' => '电话',
  ),



































  'quote_type_dom' => 
  array (
    'Quotes' => '报价',
    'Orders' => '已订购',
  ),
  'default_quote_stage_key' => '草稿',
  'quote_stage_dom' => 
  array (
    'Draft' => '草稿',
    'Negotiation' => '谈判',
    'Delivered' => '已交付',
    'On Hold' => '等待',
    'Confirmed' => '已确认',
    'Closed Accepted' => '谈成结束',
    'Closed Lost' => '丢单结束',
    'Closed Dead' => '未成结束',
  ),
  'default_order_stage_key' => '未决定',
  'order_stage_dom' => 
  array (
    'Pending' => '未决定',
    'Confirmed' => '已确认',
    'On Hold' => '等待',
    'Shipped' => '已发货',
    'Cancelled' => '已取消',
  ),
  'quote_relationship_type_default_key' => '主要决策人',
  'quote_relationship_type_dom' => 
  array (
    '' => '',
    'Primary Decision Maker' => '主要决策人',
    'Business Decision Maker' => '商业决策者',
    'Business Evaluator' => '商业评估者',
    'Technical Decision Maker' => '技术决策者',
    'Technical Evaluator' => '技术评估人',
    'Executive Sponsor' => '主管助理',
    'Influencer' => '影响者',
    'Other' => '其它',
  ),
  'layouts_dom' => 
  array (
    'Standard' => '建议',
    'Invoice' => '发票',
    'Terms' => '付款条件',
  ),
  'bug_priority_default_key' => '中',
  'bug_priority_dom' => 
  array (
    'Urgent' => '紧急',
    'High' => '高',
    'Medium' => '中',
    'Low' => '低',
  ),
  'bug_resolution_default_key' => '',
  'bug_resolution_dom' => 
  array (
    '' => '',
    'Accepted' => '已接受',
    'Duplicate' => '重复',
    'Fixed' => '固定价格',
    'Out of Date' => '过期',
    'Invalid' => '无效',
    'Later' => '以后',
  ),
  'bug_status_default_key' => '新增',
  'bug_status_dom' => 
  array (
    'New' => '新增',
    'Assigned' => '已分配',
    'Closed' => '结束',
    'Pending' => '未决定',
    'Rejected' => '拒绝',
  ),
  'bug_type_default_key' => '缺陷',
  'bug_type_dom' => 
  array (
    'Defect' => '问题',
    'Feature' => '特性',
  ),
  'source_default_key' => '自产',
  'source_dom' => 
  array (
    '' => '',
    'Internal' => '内部',
    'Forum' => '论坛',
    'Web' => '网络',
    'InboundEmail' => '电子邮件',
  ),
  'product_category_default_key' => '',
  'product_category_dom' => 
  array (
    '' => '',
    'Accounts' => '客户',
    'Activities' => '活动',
    'Bug Tracker' => '缺陷追踪',
    'Calendar' => '日程安排',
    'Calls' => '电话',
    'Campaigns' => '市场活动',
    'Cases' => '客户反馈',
    'Contacts' => '联系人档案',
    'Currencies' => '货币',
    'Dashboard' => '统计图',
    'Documents' => '文档',
    'Emails' => '电子邮件',
    'Feeds' => '记录',
    'Forecasts' => '销售预测',
    'Help' => '帮助',
    'Home' => '首页',
    'Leads' => '潜在客户',
    'Meetings' => '会议',
    'Notes' => '备忘录',
    'Opportunities' => '商业机会',
    'Outlook Plugin' => 'Outlook插件',
    'Product Catalog' => '产品目录',
    'Products' => '产品',
    'Projects' => '项目',
    'Quotes' => '报价',
    'Releases' => '版本',
    'RSS' => 'RSS',
    'Studio' => '工作室',
    'Upgrade' => '更新',
    'Users' => '用户',
  ),
  'campaign_status_dom' => 
  array (
    '' => '',
    'Planning' => '计划中',
    'Active' => '启用',
    'Inactive' => '停用',
    'Complete' => '完成',
    'In Queue' => '队列中',
    'Sending' => '发送中',
  ),
  'campaign_type_dom' => 
  array (
    '' => '',
    'Telesales' => '电话行销',
    'Mail' => '邮件',
    'Email' => '电子邮件',
    'Print' => '打印',
    'Web' => '网络',
    'Radio' => '广播',
    'Television' => '电视',
  ),
  'notifymail_sendtype' => 
  array (
    'sendmail' => 'sendmail',
    'SMTP' => 'SMTP',
  ),
  'dom_timezones' => 
  array (
    -12 => '(GMT–12)国际日期线以西',
    -11 => '(GMT-11)中途岛萨摩亚',
    -10 => '(GMT–10)夏威夷',
    -9 => '(GMT–9)阿拉斯加',
    -8 => '(GMT–8)旧金山',
    -7 => '(GMT–7)凤凰',
    -6 => '(GMT-6)萨斯喀彻温',
    -5 => '(GMT–5)纽约',
    -4 => '(GMT–4)圣地亚哥',
    -3 => '(GMT–3)布宜诺斯艾利斯',
    -2 => '(GMT-2)中大西洋',
    -1 => '(GMT-1)亚述尔群岛',
    0 => '(GMT)',
    1 => '(GMT+1) Madrid',
    2 => '(GMT+2) Athens',
    3 => '(GMT+3)莫斯科',
    4 => '(GMT+4)喀布尔',
    5 => '(GMT+5)叶卡特琳堡',
    6 => '(GMT+6)阿斯塔纳',
    7 => '(GMT+7)曼谷',
    8 => '(GMT+8)珀斯',
    9 => '(GMT+9)汉城',
    10 => '(GMT+10)布里斯班',
    11 => '(GMT+11)索罗门群岛',
    12 => '(GMT+12)奥克兰',
  ),
  'dom_cal_month_long' => 
  array (
    0 => '',
    1 => '1月',
    2 => '2月',
    3 => '3月',
    4 => '4月',
    5 => '5月',
    6 => '6月',
    7 => '7月',
    8 => '8月',
    9 => '9月',
    10 => '10月',
    11 => '11月',
    12 => '12月',
  ),
  'dom_report_types' => 
  array (
    'tabular' => '行与列',
    'summary' => '合计',
    'detailed_summary' => '细节合计',
  ),
  'dom_email_types' => 
  array (
    'out' => '已发送',
    'archived' => '已存档',
    'draft' => 'Draft',
    'inbound' => 'Inbound',
  ),
  'dom_email_status' => 
  array (
    'archived' => '已存档',
    'closed' => 'Closed',
    'draft' => '草稿',
    'read' => '已阅读',
    'replied' => '已回复',
    'sent' => '已发送',
    'send_error' => '发送错误',
    'unread' => '未阅读',
  ),
  'dom_email_server_type' => 
  array (
    '' => '--无--',
    'imap' => 'IMAP',
    'pop3' => 'POP3',
  ),
  'dom_mailbox_type' => 
  array (
    'pick' => '新增[任何]',
    'bug' => '新增缺陷',
    'support' => '新增支持',
    'contact' => '新增联系人',
    'sales' => '新增潜在客户',
    'task' => '新增任务',
    'bounce' => '处理退信',
  ),
  'dom_email_distribution' => 
  array (
    '' => '--无--',
    'direct' => '直接指派',
    'roundRobin' => '循环',
    'leastBusy' => '最少忙碌',
  ),
  'dom_email_errors' => 
  array (
    1 => '直接指派项目时只能选择一个用户。',
    2 => '直接指派项目时只能指派选择的项目。',
  ),
  'dom_email_bool' => 
  array (
    'bool_true' => '是',
    'bool_false' => '否',
  ),
  'dom_int_bool' => 
  array (
    1 => '是',
    0 => '否',
  ),
  'dom_switch_bool' => 
  array (
    'on' => '是',
    'off' => '否',
    '' => '否',
  ),
  'dom_email_link_type' => 
  array (
    '' => '系统默认邮件客户端',
    'sugar' => 'SugarCRM邮件客户端',
    'mailto' => '外部邮件客户端',
  ),
  'dom_email_editor_option' => 
  array (
    '' => '默认电子邮件格式',
    'html' => 'HTML电子邮件',
    'plain' => '纯文本电子邮件',
  ),
  'schedulers_times_dom' => 
  array (
    'not run' => '超时, 没有被执行',
    'ready' => '就绪',
    'in progress' => 'In Progress',
    'failed' => '失败',
    'completed' => 'Completed',
    'no curl' => '未运行:没有可利用的cURL',
  ),
  'forecast_schedule_status_dom' => 
  array (
    'Active' => '启用',
    'Inactive' => '停用',
  ),
  'forecast_type_dom' => 
  array (
    'Direct' => '直接',
    'Rollup' => '上滚',
  ),
  'document_category_dom' => 
  array (
    '' => '',
    'Marketing' => '市场',
    'Knowledege Base' => '基础知识',
    'Sales' => '销售',
  ),
  'document_subcategory_dom' => 
  array (
    '' => '',
    'Marketing Collateral' => '市场营销',
    'Product Brochures' => '产品手册',
    'FAQ' => '常见问题',
  ),
  'document_status_dom' => 
  array (
    'Active' => '启用',
    'Draft' => '草稿',
    'FAQ' => '常见问题',
    'Expired' => '有效期',
    'Under Review' => '审查中',
    'Pending' => '未决定',
  ),
  'document_template_type_dom' => 
  array (
    '' => '',
    'mailmerge' => '邮件合并',
    'eula' => '最终用户许可协议',
    'nda' => '保密协议',
    'license' => '许可证协议',
  ),
  'dom_meeting_accept_options' => 
  array (
    'accept' => '接受',
    'decline' => '拒绝',
    'tentative' => '搁置',
  ),
  'dom_meeting_accept_status' => 
  array (
    'accept' => 'Accepted',
    'decline' => '拒绝',
    'tentative' => '搁置',
    'none' => '无',
  ),










































































































































































































// deferred
/*// QUEUES MODULE DOMs
'queue_type_dom' => array(
	'Users' => 'Users',



	'Mailbox' => 'Mailbox',
),		   
*/
  'prospect_list_type_dom' => 
  array (
    'default' => 'Default',
    'seed' => '种子',
    'exempt_domain' => '阻止列表 – 根据域',
    'exempt_address' => '阻止列表 – 根据电子邮件地址',
    'exempt' => '阻止列表 – 根据编号',
    'test' => '测试',
  ),
  'email_marketing_status_dom' => 
  array (
    '' => '',
    'active' => 'Active',
    'inactive' => 'Inactive',
  ),
  'campainglog_activity_type_dom' => 
  array (
    '' => '',
    'targeted' => '尝试发送/发送消息',
    'send error' => '退信，其它',
    'invalid email' => '退信，无效的邮箱',
    'link' => '点击链接',
    'viewed' => '已查看的信息',
    'removed' => '可退出的邮件',
    'lead' => '现有销售潜在客户',
    'contact' => '新增联系人',
  ),
  'campainglog_target_type_dom' => 
  array (
    'Contacts' => '联系人档案',
    'Users' => '用户',
    'Prospects' => '目标',
    'Leads' => '潜在客户',
  ),































);
$app_strings = array (





  'ERR_CREATING_FIELDS' => '填写附加细节字段错误:',
  'ERR_CREATING_TABLE' => '新增表错误:',
  'ERR_DELETE_RECORD' => '必须指定记录编号才能删除客户。',
  'ERR_EXPORT_DISABLED' => '禁止导出。',
  'ERR_EXPORT_TYPE' => '错误导出',
  'ERR_INVALID_AMOUNT' => '请输入有效金额:',
  'ERR_INVALID_DATE_FORMAT' => '日期格式必须是:',
  'ERR_INVALID_DATE' => '请输入有效日期。',
  'ERR_INVALID_DAY' => '请输入有效天数。',
  'ERR_INVALID_EMAIL_ADDRESS' => '不是有效的电子邮件地址。',
  'ERR_INVALID_HOUR' => '请输入有效小时。',
  'ERR_INVALID_MONTH' => '请输入有效月份。',
  'ERR_INVALID_TIME' => '请输入有效时间。',
  'ERR_INVALID_YEAR' => '请输入有4位数。',
  'ERR_NEED_ACTIVE_SESSION' => '需要一个可用的会话来导出内容。',
  'ERR_MISSING_REQUIRED_FIELDS' => '缺少必填字段:',
  'ERR_INVALID_VALUE' => '无效值:',
  'ERR_NOTHING_SELECTED' => '继续之前请选择。',
  'ERR_OPPORTUNITY_NAME_DUPE' => '商业机会名称已存在，请输入另一个名称。',
  'ERR_OPPORTUNITY_NAME_MISSING' => '商业机会名称不能为空。请输入以下的商业机会名称。',
  'ERR_SELF_REPORTING' => '用户不可以给自己汇报。',
  'ERR_SQS_NO_MATCH_FIELD' => '没有匹配字段:',
  'ERR_SQS_NO_MATCH' => '没有匹配',
  'ERR_PORTAL_LOGIN_FAILED' => 'Unable to create portal login session.  Please contact administrator.',
  'ERR_RESOURCE_MANAGEMENT_INFO' => 'Return to <a href="index.php">Home</a>',
  'LBL_ACCOUNT' => '客户',
  'LBL_ACCOUNTS' => '客户',
  'LBL_ACCUMULATED_HISTORY_BUTTON_KEY' => 'H',
  'LBL_ACCUMULATED_HISTORY_BUTTON_LABEL' => '查看摘要',
  'LBL_ACCUMULATED_HISTORY_BUTTON_TITLE' => '查看摘要[Alt+H]',
  'LBL_ADD_BUTTON_KEY' => 'A',
  'LBL_ADD_BUTTON_TITLE' => '新增[Alt+A]',
  'LBL_ADD_BUTTON' => '增加',
  'LBL_ADD_DOCUMENT' => '增加文档',
  'LBL_ADD_TO_PROSPECT_LIST_BUTTON_KEY' => 'L',
  'LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL' => '增加到目标列表',
  'LBL_ADD_TO_PROSPECT_LIST_BUTTON_TITLE' => '增加到目标列表',
  'LBL_ADDITIONAL_DETAILS_CLOSE_TITLE' => '关闭',
  'LBL_ADDITIONAL_DETAILS_CLOSE' => '关闭',
  'LBL_ADDITIONAL_DETAILS' => '其它细节',
  'LBL_ADMIN' => '系统管理',
  'LBL_ALT_HOT_KEY' => 'Alt+',
  'LBL_ARCHIVE' => '存档',
  'LBL_ASSIGNED_TO_USER' => '负责人:',
  'LBL_ASSIGNED_TO' => '负责人:',
  'LBL_BACK' => '上一步',
  'LBL_BILL_TO_ACCOUNT' => '付款客户',
  'LBL_BILL_TO_CONTACT' => '付款联系人',
  'LBL_BROWSER_TITLE' => 'SugarCRM–商业开源客户关系管理系统',
  'LBL_BUGS' => '缺陷追踪',
  'LBL_BY' => '被',
  'LBL_CALLS' => '电话',
  'LBL_CAMPAIGNS_SEND_QUEUED' => '发送队列中的市场活动邮件',
  'LBL_CANCEL_BUTTON_KEY' => 'X',
  'LBL_CANCEL_BUTTON_LABEL' => '取消',
  'LBL_CANCEL_BUTTON_TITLE' => '取消[Alt+X]',
  'LBL_CASE' => '用户反馈',
  'LBL_CASES' => '客户反馈',
  'LBL_CHANGE_BUTTON_KEY' => 'G',
  'LBL_CHANGE_BUTTON_LABEL' => '更改',
  'LBL_CHANGE_BUTTON_TITLE' => '更改[Alt+G]',
  'LBL_CHARSET' => 'UTF-8',
  'LBL_CHECKALL' => '全选',
  'LBL_CLEAR_BUTTON_KEY' => 'C',
  'LBL_CLEAR_BUTTON_LABEL' => '清除',
  'LBL_CLEAR_BUTTON_TITLE' => '清除[Alt+C]',
  'LBL_CLEARALL' => '全部清除',
  'LBL_CLOSE_WINDOW' => '关闭窗口',
  'LBL_CLOSEALL_BUTTON_KEY' => 'Q',
  'LBL_CLOSEALL_BUTTON_LABEL' => '全部关闭',
  'LBL_CLOSEALL_BUTTON_TITLE' => '全部关闭[Alt+I]',
  'LBL_COMPOSE_EMAIL_BUTTON_KEY' => 'L',
  'LBL_COMPOSE_EMAIL_BUTTON_LABEL' => '撰写电子邮件',
  'LBL_COMPOSE_EMAIL_BUTTON_TITLE' => '撰写电子邮件[Alt+L]',
  'LBL_CONTACT_LIST' => '联系人列表',
  'LBL_CONTACT' => '联系人',
  'LBL_CONTACTS' => '联系人档案',
  'LBL_CREATE_BUTTON_LABEL' => '新增',
  'LBL_CREATED_BY_USER' => '创建人',
  'LBL_CREATED' => '创建人',
  'LBL_CURRENT_USER_FILTER' => '只显示我的记录:',
  'LBL_DATE_ENTERED' => '创建日期:',
  'LBL_DATE_MODIFIED' => '最后修改:',
  'LBL_DELETE_BUTTON_KEY' => 'D',
  'LBL_DELETE_BUTTON_LABEL' => '删除',
  'LBL_DELETE_BUTTON_TITLE' => '删除[Alt+D]',
  'LBL_DELETE_BUTTON' => '删除',
  'LBL_DELETE' => '删除',
  'LBL_DELETED' => '已删除',
  'LBL_DIRECT_REPORTS' => '直接报告人',
  'LBL_DONE_BUTTON_KEY' => 'X',
  'LBL_DONE_BUTTON_LABEL' => '完成',
  'LBL_DONE_BUTTON_TITLE' => '完成[Alt+X]',
  'LBL_DST_NEEDS_FIXIN' => '应用程序需要设置夏令时时间。请转到管理员控制台下的<a href="index.php?module=Administration&action=DstFix">修复</a>链接，设置夏令时时间。',
  'LBL_DUPLICATE_BUTTON_KEY' => 'U',
  'LBL_DUPLICATE_BUTTON_LABEL' => '复制',
  'LBL_DUPLICATE_BUTTON_TITLE' => '复制[Alt+U]',
  'LBL_DUPLICATE_BUTTON' => '复制',
  'LBL_EDIT_BUTTON_KEY' => 'E',
  'LBL_EDIT_BUTTON_LABEL' => '编辑',
  'LBL_EDIT_BUTTON_TITLE' => '编辑[Alt+E]',
  'LBL_EDIT_BUTTON' => '编辑',
  'LBL_VIEW_BUTTON_KEY' => 'V',
  'LBL_VIEW_BUTTON_LABEL' => '查看',
  'LBL_VIEW_BUTTON_TITLE' => '查看[Alt+V]',
  'LBL_VIEW_BUTTON' => '查看',
  'LBL_EMAIL_PDF_BUTTON_KEY' => 'M',
  'LBL_EMAIL_PDF_BUTTON_LABEL' => '以PDF格式发送电子邮件',
  'LBL_EMAIL_PDF_BUTTON_TITLE' => '以PDF格式发送电子邮件[Alt+M]',
  'LBL_EMAILS' => '电子邮件',
  'LBL_EMPLOYEES' => '员工',
  'LBL_ENTER_DATE' => '输入日期',
  'LBL_EXPORT_ALL' => '全部导出',
  'LBL_EXPORT' => '导出',
  'LBL_HIDE' => '隐藏',
  'LBL_ID' => '编号',
  'LBL_IMPORT_PROSPECTS' => '导入目标',
  'LBL_IMPORT' => '导入',
  'LBL_LAST_VIEWED' => '最近查看',
  'LBL_LEADS' => '潜在客户',
  'LBL_LIST_ACCOUNT_NAME' => '客户名称',
  'LBL_LIST_ASSIGNED_USER' => '用户',
  'LBL_LIST_CONTACT_NAME' => '联系人姓名',
  'LBL_LIST_CONTACT_ROLE' => '联系人角色',
  'LBL_LIST_EMAIL' => '电子邮件',
  'LBL_LIST_NAME' => '名称',
  'LBL_LIST_OF' => '的',
  'LBL_LIST_PHONE' => '电话',
  'LBL_LIST_USER_NAME' => '用户名',
  'LBL_LISTVIEW_MASS_UPDATE_CONFIRM' => '您确定您要更新整个列表?',
  'LBL_LISTVIEW_NO_SELECTED' => '请选择至少1条记录进行操作。',
  'LBL_LISTVIEW_OPTION_CURRENT' => '当前页',
  'LBL_LISTVIEW_OPTION_ENTIRE' => '整个列表',
  'LBL_LISTVIEW_OPTION_SELECTED' => '已选择的记录',
  'LBL_LISTVIEW_SELECTED_OBJECTS' => '已选择',
  'LBL_LOCALE_NAME_EXAMPLE_FIRST' => '约翰',
  'LBL_LOCALE_NAME_EXAMPLE_LAST' => '某',
  'LBL_LOCALE_NAME_EXAMPLE_SALUTATION' => '先生',
  'LBL_LOGOUT' => '注销',
  'LBL_MAILMERGE_KEY' => 'M',
  'LBL_MAILMERGE' => '邮件合并',
  'LBL_MASS_UPDATE' => '批量更新',
  'LBL_MEETINGS' => '会议',
  'LBL_MEMBERS' => '成员',
  'LBL_MODIFIED_BY_USER' => '修改人',
  'LBL_MODIFIED' => '修改人',
  'LBL_MY_ACCOUNT' => '个人信息',
  'LBL_NAME' => '名称',
  'LBL_NEW_BUTTON_KEY' => 'N',
  'LBL_NEW_BUTTON_LABEL' => '新增',
  'LBL_NEW_BUTTON_TITLE' => '新增[Alt+N]',
  'LBL_NEXT_BUTTON_LABEL' => '下一步',
  'LBL_NONE' => '--无--',
  'LBL_NOTES' => '备忘录',
  'LBL_OPENALL_BUTTON_KEY' => 'O',
  'LBL_OPENALL_BUTTON_LABEL' => '全部开放',
  'LBL_OPENALL_BUTTON_TITLE' => '全部开放[Alt+O]',
  'LBL_OPENTO_BUTTON_KEY' => 'T',
  'LBL_OPENTO_BUTTON_LABEL' => '开放到:',
  'LBL_OPENTO_BUTTON_TITLE' => '开放到:[Alt+T]',
  'LBL_OPPORTUNITIES' => 'Opportunities',
  'LBL_OPPORTUNITY_NAME' => '商业机会名称',
  'LBL_OPPORTUNITY' => '商业机会',
  'LBL_OR' => '或者',
  'LBL_PERCENTAGE_SYMBOL' => '%',
  'LBL_PRODUCT_BUNDLES' => '产品包',
  'LBL_PRODUCTS' => '产品',
  'LBL_PROJECT_TASKS' => '项目任务',
  'LBL_PROJECTS' => '项目',
  'LBL_QUOTE_TO_OPPORTUNITY_KEY' => 'O',
  'LBL_QUOTE_TO_OPPORTUNITY_LABEL' => '根据报价创建商业机会',
  'LBL_QUOTE_TO_OPPORTUNITY_TITLE' => '根据报价创建商业机会[Alt+O]',
  'LBL_QUOTES_SHIP_TO' => '运往',
  'LBL_QUOTES' => '报价',
  'LBL_RELATED_RECORDS' => '相关记录',
  'LBL_REMOVE' => '移除',
  'LBL_REQUIRED_SYMBOL' => '*',
  'LBL_SAVE_BUTTON_KEY' => 'S',
  'LBL_SAVE_BUTTON_LABEL' => '保存',
  'LBL_SAVE_BUTTON_TITLE' => '保存[Alt+S]',
  'LBL_FULL_FORM_BUTTON_KEY' => 'F',
  'LBL_FULL_FORM_BUTTON_LABEL' => '完全式',
  'LBL_FULL_FORM_BUTTON_TITLE' => '完全式',
  'LBL_SAVE_NEW_BUTTON_KEY' => 'V',
  'LBL_SAVE_NEW_BUTTON_LABEL' => '保存并且新增',
  'LBL_SAVE_NEW_BUTTON_TITLE' => '保存并且新增[Alt+V]',
  'LBL_SEARCH_BUTTON_KEY' => 'Q',
  'LBL_SEARCH_BUTTON_LABEL' => '查找',
  'LBL_SEARCH_BUTTON_TITLE' => '查找[Alt+Q]',
  'LBL_SEARCH' => '查找',
  'LBL_SELECT_BUTTON_KEY' => 'T',
  'LBL_SELECT_BUTTON_LABEL' => '选择',
  'LBL_SELECT_BUTTON_TITLE' => '选择[Alt+T]',
  'LBL_SELECT_CONTACT_BUTTON_KEY' => 'T',
  'LBL_SELECT_CONTACT_BUTTON_LABEL' => '选择联系人',
  'LBL_SELECT_CONTACT_BUTTON_TITLE' => '选择联系人[Alt+T]',
  'LBL_SELECT_REPORTS_BUTTON_LABEL' => '从报表中选择',
  'LBL_SELECT_REPORTS_BUTTON_TITLE' => '选择报表',
  'LBL_SELECT_USER_BUTTON_KEY' => 'U',
  'LBL_SELECT_USER_BUTTON_LABEL' => '选择用户',
  'LBL_SELECT_USER_BUTTON_TITLE' => '选择用户[Alt+U]',
  'LBL_SERVER_RESPONSE_RESOURCES' => '创建这个页面的资源(查询，文件)',
  'LBL_SERVER_RESPONSE_TIME_SECONDS' => '秒。',
  'LBL_SERVER_RESPONSE_TIME' => '服务器响应时间:',
  'LBL_SHIP_TO_ACCOUNT' => '收货客户',
  'LBL_SHIP_TO_CONTACT' => '收货联系人',
  'LBL_SHORTCUTS' => '快捷方式',
  'LBL_SHOW' => '显示',
  'LBL_SQS_INDICATOR' => '',
  'LBL_STATUS_UPDATED' => '对于这个事件，您的状态已更新！',
  'LBL_STATUS' => '状态:',
  'LBL_SUBJECT' => '主题',
  'LBL_SYNC' => '同步',
  'LBL_TASKS' => '任务',
  'LBL_TEAMS_LINK' => '团队',
  'LBL_THOUSANDS_SYMBOL' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => '存档电子邮件',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => '存档电子邮件[Alt+K]',
  'LBL_UNAUTH_ADMIN' => '没有管理权限',
  'LBL_UNDELETE_BUTTON_LABEL' => '不删除',
  'LBL_UNDELETE_BUTTON_TITLE' => '不删除',
  'LBL_UNDELETE_BUTTON' => '不删除',
  'LBL_UNDELETE' => '不删除',
  'LBL_UNSYNC' => '不同步',
  'LBL_UPDATE' => '更新',
  'LBL_USER_LIST' => '用户列表',
  'LBL_USERS_SYNC' => '用户同步',
  'LBL_USERS' => '用户',
  'LBL_VIEW_PDF_BUTTON_KEY' => 'P',
  'LBL_VIEW_PDF_BUTTON_LABEL' => '以PDF格式打印',
  'LBL_VIEW_PDF_BUTTON_TITLE' => '以PDF格式打印[Alt+P]',
  'LNK_ABOUT' => '关于',
  'LNK_ADVANCED_SEARCH' => '高级查找',
  'LNK_BASIC_SEARCH' => '基本查找',
  'LNK_DELETE_ALL' => '删除所有记录',
  'LNK_DELETE' => '删除',
  'LNK_EDIT' => '编辑',
  'LNK_GET_LATEST' => '获取最新的',
  'LNK_GET_LATEST_TOOLTIP' => '用最新版本替换',
  'LNK_HELP' => '帮助',
  'LNK_LIST_END' => '末页',
  'LNK_LIST_NEXT' => '下页',
  'LNK_LIST_PREVIOUS' => '上页',
  'LNK_LIST_RETURN' => '返回列表',
  'LNK_LIST_START' => '首页',
  'LNK_LOAD_SIGNED' => '签署',
  'LNK_LOAD_SIGNED_TOOLTIP' => '用签署文件代替',
  'LNK_PRINT' => '打印',
  'LNK_REMOVE' => '移除',
  'LNK_RESUME' => '重试',
  'LNK_VIEW_CHANGE_LOG' => '查看更改日志',
  'NTC_CLICK_BACK' => '请按浏览器的“返回”按钮返回，并纠正错误。',
  'NTC_DATE_FORMAT' => '(yyyy-mm-dd)',
  'NTC_DATE_TIME_FORMAT' => '(yyyy-mm-dd 24:00)',
  'NTC_DELETE_CONFIRMATION_MULTIPLE' => '确定要删除所选择的记录吗?',
  'NTC_TEMPLATE_IS_USED' => '这个模板至少被1个营销活动所使用。你确定要删除它吗？',
  'NTC_TEMPLATES_IS_USED' => "下列模板在营销活动中被使用。你确定要删除它们吗？\n",  
  'NTC_DELETE_CONFIRMATION' => '您确定要删除这条记录?',
  'NTC_LOGIN_MESSAGE' => '请输入用户名和密码。',
  'NTC_NO_ITEMS_DISPLAY' => '无',
  'NTC_REMOVE_CONFIRMATION' => '您确定要移除这个关系吗?',
  'NTC_REQUIRED' => '表示必填字段',
  'NTC_SUPPORT_SUGARCRM' => '支持SugarCRM开源项目，通过paypal捐赠它。-它是快速、免费和安全的软件！',
  'NTC_TIME_FORMAT' => '(24:00)',
  'NTC_WELCOME' => '欢迎',
  'NTC_YEAR_FORMAT' => '(yyyy)',
  'LOGIN_LOGO_ERROR' => '请更换SugarCRM标识。',
  'ERROR_FULLY_EXPIRED' => '您公司SugarCRM的许可已经超期30天以上,需要进行修订.只有管理员可以登陆.',
  'ERROR_LICENSE_EXPIRED' => '您公司SugarCRM的许可需要被更新,只有管理员可以登陆',
  'ERROR_NO_RECORD' => '检索记录出错。这条记录可能已被删除，或者您可能没有权限查看它。',
  'LBL_DUP_MERGE' => '发现重复',
  'LBL_LOADING' => '加载中...',
  'LBL_SAVING_LAYOUT' => '布局保存中...',
  'LBL_SAVED_LAYOUT' => '布局已被保存。',
  'LBL_SAVED' => '已保存',
  'LBL_SAVING' => '保存中',
  'LBL_DISPLAY_COLUMNS' => '显示列',
  'LBL_HIDE_COLUMNS' => '隐藏列',
  'LBL_SEARCH_CRITERIA' => '查找标准',
  'LBL_SAVED_VIEWS' => '已保存的视图',
  'LBL_NO_RECORDS_FOUND' => '- 0 Records Found -',
  'LBL_LOGIN_SESSION_EXCEEDED' => 'The server is too busy. Please try again later.',
  'LBL_CHANGE_PASSWORD' => 'Change Password',
  'LBL_LOGIN_TO_ACCESS' => '请登录以访问这个区域.',
)?>
