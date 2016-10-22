<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title>ISFES V3</title> 
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" />
</head><body> 
<div id="header"> 



    <div id="companyLogo"><strong> 

<img src="themes/Sugar5/images/company_logo.png" width="131" height="49" ><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=287311025&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:287311025:44" alt="ebaytools" title="ebaytools"> Isfes ERP V3 又称 selling-360</strong></div>    
  <div id="globalLinks">					


    <ul> 


        </ul> 



</div>    <div id="welcome"> 

	<a href="ISFES V3_20121228.doc" target="_blank"><span style="font-size:25px; font-weight:bold "><font color="#FF0000">
    下载向导</font></span></a>

    Welcome, <strong><?php echo $_SESSION['truename']; ?></strong> [ <a href='handle.php?action=Logout' class='utilsLink'>Log Out</a> ]
    <a href='systemuserpass.php?&action=密码修改' class='utilsLink'>修改密码</a> ]
	

</div> 



  <div class="clear"></div> 



    <div style="height:25px"> 







</div> 







<span id='sm_holder'></span> 



    <div class="clear"></div> 



        <div id="moduleList"> 



<ul> 



    <li class="noBorder">&nbsp;</li> 



    



    



    <?php







	$module		= $_REQUEST['module'];

	$user		= $_SESSION['user'];



	/* 检查用户权限*/

	$cpower	= explode(",",$_SESSION['power']);

	
 

	 ?>


<?php 	if(in_array("orders",$cpower)){	 ?> 
<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'orders') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="orderindex.php?module=orders&ostatus=1&action=待处理订单" id="moduleTab_Home">订单管理</a></span><span class="notCurrentTabRight">&nbsp;</span></li>
<?php } ?>

<?php 	if(in_array("message",$cpower)){	 ?> 
<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'message') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="messagecategory.php?module=message" id="moduleTab_Accounts">消息管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
</li> 
<?php } ?>


<?php 	if(in_array("rma_index",$cpower)){	 ?> 
<li class="notCurrentTabLeft"> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'case') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="rmaindex.php?module=case&action=RMA 管理&mstatus=0" id="moduleTab_Opportunities">RMA 管理</a></span><span class="notCurrentTabLeft">&nbsp;</span> 
</li> 
<?php } ?>

<?php 	if(in_array("faxin",$cpower)){	 ?> 
                    <li class="notCurrentTabLeft"> 


        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'mail') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="messagetemplate.php?module=mail&action=模板管理" id="moduleTab_Opportunities">自动发信</a></span><span class="notCurrentTabLeft">&nbsp;</span> 



        </li> 
<?php } ?>                 
<!--

   <li class="notCurrentTabLeft"> 
        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'pcase') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="prmaindex.php?module=pcase&action=产品CASE管理&mstatus=0" id="moduleTab_Opportunities">产品Case</a></span><span class="notCurrentTabLeft">&nbsp;</span> 
        </li> 


<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'zencart') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="zenorderindex.php?module=zencart&action=ZenCart未处理订单&ostatus=1" id="moduleTab_Accounts">Zendcart订单管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
</li> 
-->


<?php 	if(in_array("customer",$cpower)){	 ?> 

<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'customer') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="s_customer.php?module=customer&action=客户管理&ostatus=1" id="moduleTab_Accounts">客户管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
</li> 
<?php } ?>
        


<?php if($_SESSION['user'] == 'survy' || $_SESSION['user'] == 'chineon'){ ?>
<?php 	if(in_array("paypal",$cpower)){	 ?> 
<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'paypalrefund') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="paypal_refund.php?module=paypalrefund&status=0" id="moduleTab_Accounts">PayPal退款管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
</li> 
<?php 
}
} 
?>



<?php 	if(in_array("feedback",$cpower)){	 ?> 
   <li> 

        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'feedback') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="feedback.php?module=feedback&action=评价管理" id="moduleTab_Accounts">评价管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
        </li> 

<?php } ?>
<?php 	if(in_array("kandeng",$cpower)){	 ?> 

 <li> 
        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'list') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="listing.php?module=list&action=活动-未售出&status=0" id="moduleTab_Contacts">刊登管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
        </li> 
		
 <?php } ?>       

<?php 	if(in_array("purchase",$cpower)){	 ?> 
<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'purchase') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="purchase_outstockorder.php?module=purchase&action=缺货订单" id="moduleTab_Contacts">采购管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
</li> 
<?php } ?>


<?php 	if(in_array("warehouse",$cpower)){	 ?> 
<li> 
<span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'warehouse') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="productindex.php?module=warehouse&action=货品资料管理" id="moduleTab_Contacts">库存管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
</li> 
<?php } ?>




<?php 	if(in_array("sales",$cpower)){	 ?> 
         <li class="notCurrentTabLeft"> 
        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'finance') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="paypaltindex.php?module=finance&action=Paypal销售额统计" id="moduleTab_Opportunities">销售分析</a></span><span class="notCurrentTabLeft">&nbsp;</span> 
        </li>
<?php } ?>

<?php 	if(in_array("report",$cpower)){	 ?> 
         <li class="notCurrentTabLeft"> 
        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'report') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="reportsales.php?module=report&action=" id="moduleTab_Opportunities">统计报表</a></span><span class="notCurrentTabLeft">&nbsp;</span> 
        </li>
<?php } ?>




<?php 	if(in_array("system",$cpower)){	 ?> 
            <li> 
        <span class="notCurrentTabLeft">&nbsp;</span><span class="<?php if($module == 'system') echo 'currentTab'; else echo 'notCurrentTab'; ?>"><a href="systemebay.php?module=system&action=系统管理" id="moduleTab_Leads">系统管理</a></span><span class="notCurrentTabRight">&nbsp;</span> 
        </li> 
<?php } ?>


    </ul> 



</div>    







<div class="clear"></div>



<div class="line"></div> 



<div id="shortcuts" class="headerList"> 

<span> 

<!-- 业务管理-->

<?php if($module == 'sale'){ ?>
<span style="white-space:nowrap;"><a href="salesindex.php?module=sale&action=利润计算">&nbsp;<span>利润计算</span></a>
<span style="white-space:nowrap;"><a href="add_products_add.php?module=sale&action=产品开发">&nbsp;<span>产品开发</span></a>
<span style="white-space:nowrap;"><a href="add_products_price.php?module=sale&action=产品优化">&nbsp;<span>产品优化</span></a>
<span style="white-space:nowrap;"><a href="qs_list.php?module=sale&action=FAQ(知识库)">&nbsp;<span>FAQ(知识库)</span></a>

<?php } ?>


<!-- warehouse管理-->

<?php if($module == 'feedback'){ ?>
<span style="white-space:nowrap;"><a href="feedbacktj.php?module=feedback&action=评价加载">&nbsp;<span>评价报表</span></a>
<span style="white-space:nowrap;"><a href="feedbacksys.php?module=feedback&action=评价加载">&nbsp;<span>评价加载</span></a>
<span style="white-space:nowrap;"><a href="feedback.php?module=feedback&action=评价管理">&nbsp;<span>评价管理</span></a>
<?php } ?>
<!-- 订单管理 -->
<?php if($module == 'case'){ ?>
<span style="white-space:nowrap;"><a href="rmaindex.php?module=case&action=RMA 管理">&nbsp;<span>RMA管理</span></a>



<span style="white-space:nowrap;"><a href="rmastatus.php?module=case&action=case类型自定义&type=1">&nbsp;<span>RMA 类型自定义</span></a>
<span style="white-space:nowrap;"><a href="rmastatus.php?module=case&action=case原因自定义&type=2">&nbsp;<span>RMA 原因自定义</span></a>
<?php } ?>


<?php if($module == 'paypalrefund'){ ?>
<span style="white-space:nowrap;"><a href="paypal_refund.php?module=paypalrefund&status=">&nbsp;<span>Paypal 所有退款申请
(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_paypalrefund where ebay_user='$user' ";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)
</span></a>


<span style="white-space:nowrap;"><a href="paypal_refund.php?module=paypalrefund&status=0">&nbsp;<span>Paypal 退款待审核
(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_paypalrefund where ebay_user='$user' and status = 0";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)
</span></a>

<span style="white-space:nowrap;"><a href="paypal_refund.php?module=paypalrefund&status=1">&nbsp;<span>Paypal 退款已审核(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_paypalrefund where ebay_user='$user' and status = 1";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)
</span></a>

<span style="white-space:nowrap;"><a href="paypal_refund.php?module=paypalrefund&status=2">&nbsp;<span>Paypal 退款已完成(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_paypalrefund where ebay_user='$user' and status = 2";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)
</span></a>
<?php } ?>






<!-- 发信管理 -->

<?php if($module == 'mail'){ ?>
<span style="white-space:nowrap;"><a href="feedbacksys.php?module=mail&action=数据同步">&nbsp;<span>好评加载</span></a> 
<span style="white-space:nowrap;"><a href="feedback.php?module=mail&action=好评管理">&nbsp;<span>好评管理</span></a> 
<span style="white-space:nowrap;"><a href="messagetemplate.php?module=mail&action=模板管理">&nbsp;<span>信件模板管理</span></a>
<span style="white-space:nowrap;"><a href="fahuo.php?module=mail&action=发货流程">&nbsp;<span>发货流程</span></a>
<span style="white-space:nowrap;"><a href="mailorderindex.php?module=mail&action=待发信订单&mstatus=0">&nbsp;<span>待发信订单(<font color="#FF0000">

<?php
$sql		= "select ebay_id from ebay_order as a where ebay_user='$user' and ebay_status='2'  and ebay_combine!='1' and (mailstatus='0' or mailstatus ='') and ($ebayacc) ";
$query		= $dbcon->query($sql);
$total		= $dbcon->num_rows($query);

/* 释放mysql 系统资源 */
$dbcon->free_result($query);



echo $total;
?></font>
)
</span></a> 



<span style="white-space:nowrap;"><a href="mailorderindex.php?module=mail&action=正在发信订单&mstatus=1">&nbsp;<span>正在发信订单
(<font color="#FF0000">
<?php
$sql		= "select ebay_id from ebay_order as a where ebay_user='$user' and ebay_status='2'  and ebay_combine!='1' and mailstatus='1' and ($ebayacc) ";
$query		= $dbcon->query($sql);
$total		= $dbcon->num_rows($query);
echo $total;

/* 释放mysql 系统资源 */
$dbcon->free_result($query);

?></font>
)



</span></a> 

<span style="white-space:nowrap;"><a href="mailorderindex.php?module=mail&action=已结束发信订单&mstatus=2">&nbsp;<span>已结束发信订单
(<font color="#FF0000">
<?php
$sql		= "select * from ebay_order as a where ebay_user='$user' and ebay_status='2'  and ebay_combine!='1' and mailstatus='2' and ($ebayacc) ";
$query		= $dbcon->query($sql);
$total		= $dbcon->num_rows($query);
echo $total;


/* 释放mysql 系统资源 */
$dbcon->free_result($query);


?></font>
)
</span></a> 







<span style="white-space:nowrap;"><a href="mailrun.php?module=mail&action=信件检查">&nbsp;<span>信件检查</span></a> 



<?php } ?>
<!-- Message管理-->
<?php if($module == 'message'){ ?>
<span style="white-space:nowrap;"><a href="messagecategory.php?module=message&action=Message规则">&nbsp;<span>Message分类</span></a> 
<span style="white-space:nowrap;"><a href="messagetemplate.php?module=message&action=Message模板设置">&nbsp;<span>Message模板设置</span></a> 
<span style="white-space:nowrap;"><a href="messageindex.php?module=message&action=所有Message&ostatus=all">&nbsp;<span>All Message(<font color="#FF0000">
<?php
$sql	= "select count(1) as cc from ebay_message where  ebay_user='$user'   and status = 0  ";
$sqla	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sqla);

/* 释放mysql 系统资源 */
$dbcon->free_result($sqla);


echo $sql[0]['cc'];
?>
</font>)</span></a> 
<span style="white-space:nowrap;"><a href="messageindex.php?module=message&action=From Message&ostatus=0">&nbsp;<span>From members(<font color="#FF0000">
<?php
$sql	= "select count(1) as cc from ebay_message where  ebay_user='$user'   and forms ='0' and status = 0 ";
$sqla	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sqla);
echo $sql[0]['cc'];

/* 释放mysql 系统资源 */
$dbcon->free_result($sqla);

?>
</font>)</span></a> 


<span style="white-space:nowrap;"><a href="messageindex.php?module=message&action=From eBay&ostatus=2">&nbsp;<span>From eBay(<font color="#FF0000">
<?php
$sql	= "select count(1) as cc from ebay_message where  ebay_user='$user'  and forms ='2' and status = 0 ";
$sqla	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sqla);

/* 释放mysql 系统资源 */
$dbcon->free_result($sqla);


echo $sql[0]['cc'];
?>
</font>)</span></a> 


<span style="white-space:nowrap;"><a href="messageindex.php?module=message&action=Hight priority&ostatus=3">&nbsp;<span>High priority(<font color="#FF0000">
<?php
$sql	= "select count(1) as cc from ebay_message where  ebay_user='$user'    and forms ='3' and status = 0 ";
$sqla	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sqla);
echo $sql[0]['cc'];


/* 释放mysql 系统资源 */
$dbcon->free_result($sqla);

?>
</font>)</span></a> 
<span style="white-space:nowrap;"><a href="messagebaobiao.php?module=message&action=Message报表">&nbsp;<span>Message报表</span></a>
<span style="white-space:nowrap;"><a href="messageload.php?module=message&action=Message同步">&nbsp;<span>Message同步</span></a>
<?php 
} ?>

<!-- warehouse管理-->
<?php if($module == 'customer'){ ?>
<span style="white-space:nowrap;"><a href="s_customer.php?module=customer&action=客户管理&ostatus=1">&nbsp;<span>客户信息</span></a>
<span style="white-space:nowrap;"><a href="s_customer2.php?module=customer&action=客户管理&ostatus=1">&nbsp;<span>黑名单</span></a>
<?php } ?>

<!-- warehouse管理-->
<?php if($module == 'warehouse'){ ?>
<?php if(in_array("w_stockmanage",$cpower)){?>
<span style="white-space:nowrap;"><a href="productwarehouse.php?module=warehouse&action=仓库管理">&nbsp;<span>仓库管理</span></a>
<?php }?>
<?php if(in_array("w_iostore",$cpower)){?>
<span style="white-space:nowrap;"><a href="productwarehousetype.php?module=warehouse&action=出入库类型">&nbsp;<span>出入库类型</span></a>
<?php }?>

<!--
<span style="white-space:nowrap;"><a href="instorefrompurchase.php?module=warehouse&action=入库单&stype=0&dstatus=0">&nbsp;<span>采购转入库单</span></a>
-->



<?php if(in_array("w_instore",$cpower)){?>
<span style="white-space:nowrap;"><a href="instore.php?module=warehouse&action=入库单&stype=0&dstatus=0">&nbsp;<span>入库单</span></a>
<?php }?>
<?php if(in_array("w_outstore",$cpower)){?>
<span style="white-space:nowrap;"><a href="outstore.php?module=warehouse&action=出库单&stype=1&dstatus=0">&nbsp;<span>出库单</span></a>
<?php }?>
<?php if(in_array("w_allocate",$cpower)){?>
<span style="white-space:nowrap;"><a href="wtowarehouse.php?module=warehouse&action=调拨单&stype=3&dstatus=0">&nbsp;<span>调拨单</span></a>
<?php }?>
<?php if(in_array("w_goodstype",$cpower)){?>
<span style="white-space:nowrap;"><a href="productcategory.php?module=warehouse&action=货品类别管理">&nbsp;<span>货品类别管理</span></a> 
<?php }?>
<?php if(in_array("w_goodsmanage",$cpower)){?>
<span style="white-space:nowrap;"><a href="productindex.php?module=warehouse&action=货品资料管理">&nbsp;<span>货品资料管理</span></a> 
<?php }?>
<?php if(in_array("w_goodscombine",$cpower)){?>
<span style="white-space:nowrap;"><a href="productcombine.php?module=warehouse&action=组合产品管理">&nbsp;<span>组合产品管理</span></a> 
<?php }?>
<?php if(in_array("w_material",$cpower)){?>
<span style="white-space:nowrap;"><a href="packingmaterial.php?module=warehouse&action=包装材料管理">&nbsp;<span>包装材料管理</span></a>
<?php }?>

<span style="white-space:nowrap;"><a href="productalert1.php?module=warehouse&action=库存预警">&nbsp;<span>库存预警</span></a>

<?php if(in_array("w_mbaobiao01",$cpower)){?>
<span style="white-space:nowrap;"><a href="productreport01.php?module=warehouse&action=进销存汇总表">&nbsp;<span>进销存汇总表</span></a>
<?php }?>
<span style="white-space:nowrap;"><a href="pandianadd.php?module=warehouse&action=库存盘点&ostatus=0">&nbsp;<span>库存盘点</span></a>
<span style="white-space:nowrap;"><a href="pandianindex.php?module=warehouse&action=盘点审核&ostatus=0">&nbsp;<span>盘点审核</span></a>
<?php } ?>

<!-- warehouse管理-->

<?php if($module == 'finance'){ ?>
 
 
<span style="white-space:nowrap;"><a href="ordertongji2.php?module=finance&action=eBay销售额统计">&nbsp;<span>eBay销售额统计</span></a>
<span style="white-space:nowrap;"><a href="paypaltindex.php?module=finance&action=Paypal销售额统计">&nbsp;<span>Paypal销售额统计</span></a> 
<span style="white-space:nowrap;"><a href="paypaldetail.php?module=finance&action=Paypal明细查看">&nbsp;<span>Paypal明细查看</span></a> 
<span style="white-space:nowrap;"><a href="ebaydetail.php?module=finance&action=eBay费用明细查看">&nbsp;<span>eBay明细查看</span></a> 
<span style="white-space:nowrap;"><a href="productprofit.php?module=finance&action= 产品销售分析">&nbsp;<span>产品销售分析</span></a>
<span style="white-space:nowrap;"><a href="paypalimport.php?module=finance&action=同步Paypal销售额">&nbsp;<span>同步Paypal销售额</span></a>
<span style="white-space:nowrap;"><a href="ebayimport.php?module=finance&action=同步ebay费用">&nbsp;<span>同步ebay费用</span></a>
<span style="white-space:nowrap;"><a href="ordertongji.php?module=finance&action=销售/利润汇总表">&nbsp;<span>销售/利润汇总表</span></a>
<span style="white-space:nowrap;"><a href="orderindexly.php?module=finance&action=订单利润未确认&ostatus=100&profitstatus=0">&nbsp;<span>订单利润未确认
(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1'  and ebay_status='2' and profitstatus=0 ";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)
</span></a>
<span style="white-space:nowrap;"><a href="orderindexly.php?module=finance&action=订单利润已确认&ostatus=100&profitstatus=1">&nbsp;<span>订单利润已确认
(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1'  and ebay_status='2' and profitstatus=1 ";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)
</span></a>








<?php } ?>














<?php if($module == 'zencart'){ ?>


<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart所有订单&ostatus=100">&nbsp;<span>ZenCart所有订单

(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and (ebay_status='1' or ebay_status='2' or ebay_status='3' or ebay_status='4' or ebay_status='5' or ebay_status='6' or ebay_status='7' or ebay_status='8')";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>


<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart未处理订单&ostatus=1">&nbsp;<span>ZenCart未处理订单

(<font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='1'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span></span></a> 
<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart已处理订单&ostatus=2">&nbsp;<span>ZenCart已处理订单

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='2'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>

<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart待打印订单&ostatus=7">&nbsp;<span>ZenCart待打印订单

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='7'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>

<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart已打印订单&ostatus=8">&nbsp;<span>ZenCart已打印订单

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='8'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>

<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZEN-CART待MARK SHIP&ostatus=3">&nbsp;<span>ZEN-CART待MARK SHIP

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='3'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>

<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart退款订单&ostatus=4">&nbsp;<span>ZenCart退款订单

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='4'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>

<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart取消订单&ostatus=5">&nbsp;<span>ZenCart取消订单

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='5'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span>

<span style="white-space:nowrap;"><a href="zenorderindex.php?module=zencart&action=ZenCart缺货订单&ostatus=6">&nbsp;<span>ZenCart缺货订单

(<font color="#FF0000"><?php
$sql	= "select count(*) as cc from ebay_order where ebay_user='$user' and ebay_combine!='1' and ordertype ='1'  and ebay_status='6'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?></font>)</span></span></a> 
<span style="white-space:nowrap;"><a href="zenorderload.php?module=zencart&action=ZenCart订单同步">&nbsp;<span>ZenCart订单同步</span></a> 



<?php } ?>


<!-- 系统配置 -->
<?php if($module == 'purchase'){ ?>

<!--
<b style="white-space:nowrap;">供应商管理:&nbsp;&nbsp;</b>
<span style="white-space:nowrap;"><a href="purchaseorderpay.php?module=purchase&action=供应商应付款">&nbsp;<span>供应商应付款</span></a>
<br>
<br>
-->


<b style="white-space:nowrap;">采购管理&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</b>

<?php if(in_array("purchase_outstockorder",$cpower)){?>
<span style="white-space:nowrap;"><a href="purchase_outstockorder.php?module=purchase&action=缺货订单">&nbsp;<span>缺货订单</span></a>
<?php } ?>

<?php if(in_array("purchase_newplan",$cpower)){?>
<img src="images/20100916225534661.png" alt="" width="25" height="25"><a href="purchase_newplan.php?module=purchase&action=运行采购计划">&nbsp;<span>新建采购计划</span></a>
<?php } ?>


<?php if(in_array("purchase_newplanorders",$cpower)){?>
<img src="images/20100916225534661.png" alt="" width="25" height="25"><span style="white-space:nowrap;"><a href="purchase_newplanorders.php?module=purchase&action=采购计划单">&nbsp;<span>采购计划单</span></a> 
<?php } ?>

<!--<span style="white-space:nowrap;"><a href="purchasemrprun.php?module=purchase&action=运行采购计划">&nbsp;<span>运行采购计划</span></a>-->
<?php if(in_array("purchase_productstockalarm",$cpower)){?>
<img src="images/20100916225534661.png" alt="" width="25" height="25"><a href="productstockalarm.php?module=purchase&action=智能预警">&nbsp;<span>智能预警</span></a> 
<?php } ?>
<!--<span style="white-space:nowrap;"><a href="purchaseorder.php?module=purchase&action=采购订单">&nbsp;<span>采购订单</span></a> -->
<br>
<br>

<b style="white-space:nowrap;">采购转入库:&nbsp;&nbsp;</b>
<?php if(in_array("purchase_instocking",$cpower)){?>
<span style="white-space:nowrap;"><a href="purchase_instocking.php?module=purchase&action=采购中订单">&nbsp;<span>预定中订单</span></a>
<?php } ?>

<?php if(in_array("purchase_instock",$cpower)){?>
<img src="images/20100916225534661.png" alt="" width="25" height="25"><span style="white-space:nowrap;">
<a href="purchase_instock.php?module=purchase&action=入库单列表">&nbsp;<span>入库单列表</span></a>
<?php } ?>


<?php if(in_array("purchase_FinanceCheck",$cpower)){?>
<img src="images/20100916225534661.png" width="25" height="25"><a href="purchase_FinanceCheck.php?module=purchase&财务审核">&nbsp;<span>财务审核</span></a>
<?php } ?>

<?php if(in_array("purchase_qcorders",$cpower)){?>
<img src="images/20100916225534661.png" alt="" width="25" height="25"><a href="purchase_qcorders.php?module=purchase&action=质检审核">&nbsp;<span>质检审核</span></a>
<?php } ?>

<?php if(in_array("purchase_qcordersyc",$cpower)){?>
<img src="images/20100916225534661.png" width="25" height="25"><a href="purchase_qcordersyc.php?module=purchase&action=异常入库单">&nbsp;<span>异常入库单</span></a>
<?php } ?>

<?php if(in_array("purchase_completeorders",$cpower)){?>
<img src="images/20100916225534661.png" width="25" height="25"><a href="purchase_completeorders.php?module=purchase&action=已完成">&nbsp;<span>正常已完成</span></a>

<?php } ?>
<?php if(in_array("purchase_completeorders",$cpower)){?>
  <a href="purchase_qcoverorders.php?module=purchase&action=有异常完成">&nbsp;<span>有异常完成</span></a>

<?php } ?>
<br>


<?php } ?>


<?php if($module == 'list'){ ?>
<span style="white-space:nowrap;"><a href="listing.php?module=list&action=在线物品&status=0">&nbsp;<span>在线物品
(<font color="#FF0000">
<?php
$sql	= "select count(*) as cc from ebay_list where status='0' and ebay_user='$user' ";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?>
</font>)</span></a> 



<span style="white-space:nowrap;"><a href="listing.php?module=list&action=结束物品&status=1">&nbsp;<span>结束物品
(<font color="#FF0000">
<?php
$sql	= "select count(*) as cc from ebay_list where status='1' and ebay_user='$user' ";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?>
</font>)</span></a> 
</span>


<span style="white-space:nowrap;"><a href="listingimportproducts.php?module=list&action=导入在线物品&status=1">&nbsp;<span>导入在线物品</span></a></span>



<?php } ?>


<!-- 系统配置 -->
<?php if($module == 'system'){ ?>

<span style="white-space:nowrap;"><a href="systemebay.php?module=system&action=eBay帐号管理">&nbsp;<span>eBay帐号管理</span></a>
<span style="white-space:nowrap;"><a href="systeamazonaccount.php?module=system&action=Amazon帐号管理">&nbsp;<span>Amazon帐号管理</span></a> 
<span style="white-space:nowrap;"><a href="systemzencart.php?module=system&action=ZenCart帐号管理">&nbsp;<span>ZenCart帐号管理</span></a> 
<span style="white-space:nowrap;"><a href="paypalindex.php?module=system&action=paypal帐号管理">&nbsp;<span>Paypal帐号管理</span></a>
<span style="white-space:nowrap;"><a href="systemuserpass.php?module=system&action=密码修改">&nbsp;<span>密码修改</span></a>
<span style="white-space:nowrap;"><a href="systemuordertype.php?module=system&action=订单类型管理">&nbsp;<span>订单类型管理</span></a>
<span style="white-space:nowrap;"><a href="systemrates.php?module=system&action=汇率设置">&nbsp;<span>汇率设置</span></a> 
<span style="white-space:nowrap;"><a href="systemusers.php?module=system&action=用户管理">&nbsp;<span>用户管理</span></a> 
<span style="white-space:nowrap;"><a href="systemcarrier.php?module=system&action=发货方式">&nbsp;<span>发货方式</span></a>
<span style="white-space:nowrap;"><a href="systemcountrys.php?module=system&action=地区列表">&nbsp;<span>地区列表</span></a>
<br><br>
<span style="white-space:nowrap;"><a href="systemcustommenu.php?module=system&action=订单分类">&nbsp;<span>订单分类</span></a>
<!--<span style="white-space:nowrap;"><a href="systemordershide.php?module=system&action=订单清理">&nbsp;<span>订单清理</span></a> -->
<span style="white-space:nowrap;"><a href="systemconfig.php?module=system&action=系统配置">&nbsp;<span>系统配置</span></a> 
<span style="white-space:nowrap;"><a href="systemgoodsstatus.php?module=system&action=物品状态">&nbsp;<span>物品状态</span></a> 
<span style="white-space:nowrap;"><a href="partner.php?module=system&action=供应商">&nbsp;<span>供应商</span></a>
<?php } ?>


<?php if($module == 'report'){ ?>

<span style="white-space:nowrap;"><a href="reportsales.php?module=report&action=销售收入统计表">&nbsp;<span>销售收入统计表</span></a>
<span style="white-space:nowrap;"><a href="reportsales01.php?module=report&action=订单数量/销售额走势">&nbsp;<span>订单数量/销售额走势表 </span></a>
<span style="white-space:nowrap;"><a href="reportsales02.php?module=report&action=销售纯利报表">&nbsp;<span>销售纯利报表</span></a>
<span style="white-space:nowrap;"><a href="reportsales03.php?module=report&action=销售纯利明细表">&nbsp;<span>销售纯利明细表</span></a>



<?php } ?>
</span></span></div> 



</div> 
