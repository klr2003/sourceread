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
    //DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_sales_stage' => 'LBL_LIST_SALES_STAGE',
    'db_name' => 'LBL_NAME',
    'db_amount' => 'LBL_LIST_AMOUNT',
    'db_date_closed' => 'LBL_LIST_DATE_CLOSED',
    //END DON'T CONVERT

	'LBL_CONTRACTS' => '合同',
	'LBL_CONTRACTS_SUBPANEL_TITLE' => '合同',

	'ERR_DELETE_RECORD' => '必须指定记录编号才能删除报价。',
	'LBL_ACCOUNT_ID' => '客户编号',
	'LBL_ACCOUNT_NAME' => '客户名称:',
	'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
	'LBL_ADD_COMMENT' => '增加注释',
	'LBL_ADD_GROUP' => '增加组',
	'LBL_ADD_ROW' => '增加行',
	'LBL_ADDRESS_INFORMATION' => '联系人信息',
	'LBL_AMOUNT' => '金额:',
	'LBL_ANY_ADDRESS' => '任何地址:',
	'LBL_BILL_TO' => '付款商',
	'LBL_BILLING_ACCOUNT_NAME' => '付款客户名称:',
	'LBL_BILLING_ACCOUNT' => '客户:',
	'LBL_BILLING_ADDRESS_CITY' => '[付款商]城市',
	'LBL_BILLING_ADDRESS_COUNTRY' => '[付款商]国家',
	'LBL_BILLING_ADDRESS_POSTAL_CODE' => '[付款商]邮编',
	'LBL_BILLING_ADDRESS_STATE' => '[付款商]省份',
	'LBL_BILLING_ADDRESS_STREET' => '付款地址',
	'LBL_BILLING_ADDRESS' => '地址:',
    'LBL_BILLING_CONTACT_ID' => '[付款商]联系人:',
	'LBL_BILLING_CONTACT_NAME' => '[付款商]联系人姓名:',
	'LBL_BILLING_CONTACT' => '联系人:',
	'LBL_BUNDLE_NAME' => '组名:',
	'LBL_BUNDLE_STAGE' => '分组阶段:',
	'LBL_CALC_GRAND' => '显示总计',
    'LBL_CHECK_DATA'=>"无效的数据输入: 请检查您的数据并确认您有有效的数字 (0-9 或 '.')",
	'LBL_CITY' => '城市:',
	'LBL_CONTACT_NAME' => '联系人姓名:',
	'LBL_CONTACT_QUOTE_FORM_TITLE' => '联系人-报价:',
	'LBL_CONTACT_ROLE' => '联系人角色:',
	'LBL_COUNTRY' => '国家:',
	'LBL_CREATED_BY' => '创建人:',
	'LBL_CURRENCY' => '货币:',
	'LBL_DATE_QUOTE_CLOSED' => '实际关闭日期:',
	'LBL_DATE_QUOTE_EXPECTED_CLOSED' => '有效期至:',
	'LBL_DEFAULT_SUBPANEL_TITLE' => '报价',
	'LBL_DELETE_GROUP' => '删除组',
	'LBL_DESCRIPTION_INFORMATION' => '说明信息',
	'LBL_DESCRIPTION' => '说明:',
	'LBL_DUPLICATE' => '可能有重复的报价',
	'LBL_EMAIL_QUOTE_FOR' => '报价给:',
	'LBL_EMAIL_DEFAULT_DESCRIPTION' => '这是您要求的报价(您可以修改它)',
	'LBL_EMAIL_ATTACHMENT' => '电子邮件附件:',
	'LBL_HISOTRY_SUBPANEL_TITLE' => '历史记录',
	'LBL_INVITEE' => '联系人',
	'LBL_INVOICE' => '发票',
	'LBL_LEAD_SOURCE' => '潜在客户来源:',
	'LBL_LINE_ITEM_INFORMATION' => '行记录:',
	'LBL_LIST_ACCOUNT_NAME' => '客户名称',
	'LBL_LIST_AMOUNT' => '金额',
	'LBL_LIST_ASSIGNED_TO_NAME' => '负责人',
	'LBL_LIST_COST_PRICE' => '成本',
	'LBL_LIST_DATE_QUOTE_CLOSED' => '实际关闭',
	'LBL_LIST_DATE_QUOTE_EXPECTED_CLOSED' => '有效期至',
	'LBL_LIST_DISCOUNT_PRICE' => '单价',
	'LBL_LIST_FORM_TITLE' => '报价列表',
	'LBL_LIST_GRAND_TOTAL' => '总计',
	'LBL_LIST_LIST_PRICE' => '定价',
	'LBL_LIST_MANUFACTURER_PART_NUM' => '制造商编号',
	'LBL_LIST_PRICING_FACTOR' => '因素',
	'LBL_LIST_PRICING_FORMULA' => '定价公式',
	'LBL_LIST_PRODUCT_NAME' => '产品',
	'LBL_LIST_QUANTITY' => '数量',
	'LBL_LIST_QUOTE_NAME' => '主题',
	'LBL_LIST_QUOTE_NUM' => '编号',
	'LBL_LIST_QUOTE_STAGE' => '阶段',
	'LBL_LIST_TAXCLASS' => '赋税类别',
	'LBL_MODIFIED_BY' => '修改人',
	'LBL_MODULE_NAME' => '报价',
	'LBL_MODULE_TITLE' => '报价:首页',
	'LBL_NAME' => '报价名称',
	'LBL_NEW_FORM_TITLE' => '新增报价',
	'LBL_NEXT_STEP' => '下个步驟:',
	'LBL_OPPORTUNITY_NAME' => '商业机会名称:',
	'LBL_ORDER_STAGE' => '定单阶段',
	'LBL_ORIGINAL_PO_DATE' => '原始签订日期:',
	'LBL_PAYMENT_TERMS' => '付款条件:',
	'LBL_PDF_BILLING_ADDRESS' => '付款商',
	'LBL_PDF_CURRENCY' => '货币:',
	'LBL_PDF_GRAND_TOTAL' => '总计',
	'LBL_PDF_INVOICE_NUMBER' => '发票编号',
	'LBL_PDF_INVOICE_TITLE' => '发票',
	'LBL_PDF_ITEM_EXT_PRICE' => '额外费用',
	'LBL_PDF_ITEM_LIST_PRICE' => '单价',
	'LBL_PDF_ITEM_PRODUCT' => '产品',
	'LBL_PDF_ITEM_QUANTITY' => '数量',
	'LBL_PDF_ITEM_UNIT_PRICE' => '单价',
	'LBL_PDF_PART_NUMBER' => '参与人数',
	'LBL_PDF_QUOTE_CLOSE' => '有效期至:',
	'LBL_PDF_QUOTE_DATE' => '日期:',
	'LBL_PDF_QUOTE_NUMBER' => '报价编号:',
	'LBL_PDF_QUOTE_TITLE' => '建议',
	'LBL_PDF_SALES_PERSON' => '销售人员:',
	'LBL_PDF_SHIPPING_ADDRESS' => '到达地',
	'LBL_PDF_SHIPPING_COMPANY' => '运输供应商:',
	'LBL_PDF_SHIPPING' => '运费:',
	'LBL_PDF_SUBTOTAL' => '小计:',
	'LBL_PDF_TAX_RATE' => '税率:',
	'LBL_PDF_TAX' => '税收:',
	'LBL_PDF_TOTAL' => '总计:',
	'LBL_POSTAL_CODE' => '邮编:',
	'LBL_PROJECTS_SUBPANEL_TITLE' => '项目',
	'LBL_PROPOSAL' => '建议',
	'LBL_PURCHASE_ORDER_NUM' => '订购单编号:',
	'LBL_QUOTE_NAME' => '报价主题:',
	'LBL_QUOTE_NUM' => '报价编号:',
	'LBL_QUOTE_STAGE' => '报价阶段:',
	'LBL_QUOTE_TYPE' => '报价类型',
    'LBL_TAXABLE' => '有税的',
    'LBL_NON_TAXABLE' => '无税的',
	'LBL_QUOTE' => '报价',
	'LBL_QUOTE_LAYOUT_DOES_NOT_EXIST_ERROR' => '报价布局文件不存在:$layout',
	'LBL_QUOTE_LAYOUT_REGISTERED_ERROR' => '报价布局未在文件modules/Quotes/Layouts.php中注册',
	'LBL_REMOVE_COMMENT' => '移除注释',
	'LBL_REMOVE_ROW' => '移除行',
	'LBL_RENAME_ERROR' => '错误:不能move_pdf到$destination。您应该确定文件目录在服务器上是可写的。',
	'LBL_SALES_STAGE' => '报价阶段:',
	'LBL_SEARCH_FORM_TITLE' => '查找报价',
	'LBL_SHIP_TO' => '到达地',
	'LBL_SHIPPING_ACCOUNT_NAME' => '[收货地址]客户名称:',
	'LBL_SHIPPING_ACCOUNT' => '客户:',
	'LBL_SHIPPING_ADDRESS_CITY' => '[收货地址]城市',
	'LBL_SHIPPING_ADDRESS_COUNTRY' => '[收货地址]国家',
	'LBL_SHIPPING_ADDRESS_POSTAL_CODE' => '[收货地址]邮编',
	'LBL_SHIPPING_ADDRESS_STATE' => '[收货地址]省份',
	'LBL_SHIPPING_ADDRESS_STREET' => '收货地址',
	'LBL_SHIPPING_ADDRESS' => '地址:',
    'LBL_SHIPPING_CONTACT_ID' => '[收货地址]联系人:',
	'LBL_SHIPPING_CONTACT_NAME' => '[收货地址]联系人姓名:',
	'LBL_SHIPPING_CONTACT' => '联系人:',
	'LBL_SHIPPING_PROVIDER' => '运输供应商:',
	'LBL_SHIPPING_USDOLLAR' => '运费(美元)',
	'LBL_SHIPPING' => '运费:',
	'LBL_SHOW_LINE_NUMS' => '显示行数:',
	'LBL_STATE' => '省份:',
	'LBL_SUBTOTAL_USDOLLAR' => '小计(美元)',
	'LBL_SUBTOTAL' => '小计:',
	'LBL_SYSTEM_ID' => '系统编号',
	'LBL_TAX_USDOLLAR' => '税收(美元)',
	'LBL_TAX' => '税收:',
	'LBL_TAXRATE' => '税率:',
	'LBL_TOTAL_USDOLLAR' => '总计(美元)',
	'LBL_TOTAL' => '总计:',
	'LBL_TYPE' => '类型:',
	'LNK_NEW_QUOTE' => '新增报价',
	'LNK_QUOTE_LIST' => '报价',
	'MSG_DUPLICATE' => '新增的报价可能是重复记录。您或者从下面的列表中选择一个报价，或者点击“保存”按钮，用先前的数据继续创建这条记录。',
	'NTC_COPY_BILLING_ADDRESS' => '将付款地址复制到发货地址',
	'NTC_COPY_SHIPPING_ADDRESS' => '将收货地址复制到付款地址',
    'NTC_COPY_BILLING_ADDRESS2' => 'Copy to shipping',
    'NTC_COPY_SHIPPING_ADDRESS2' => 'Copy to billing',  
	'NTC_REMOVE_COMMENT_CONFIRMATION' => '您确定要从这个报价中移除注释吗?',
	'NTC_REMOVE_PRODUCT_CONFIRMATION' => '您确定要从这个报价中移除行数吗?',
	'NTC_REMOVE_QUOTE_CONFIRMATION' => '您确定要从这个报价中移除联系人吗?',
	'QUOTE_REMOVE_PROJECT_CONFIRM' => '您确定要从这个项目中移除报价吗?',

	'LNK_QUOTE_REPORTS' => '报价报表',

	'LBL_ASSIGNED_TO_NAME'=>'负责人:',
	'PDF_FORMAT'=>'PDF格式:',
	'LBL_ASSIGNED_TO_ID'=>'负责人标号',
);
?>
