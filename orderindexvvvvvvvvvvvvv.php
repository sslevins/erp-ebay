<?php
/*
** 11月27日 
	1.添加包货地址打印格式
	2.修改总价格计算
** 修改人  胡耀龙
*/
include "include/config.php";
include "top.php";

if(!in_array("orders",$cpower)){
 	
	die('无权限，请在系统管理，用户管理中设置');
 }
 
 $stockstatus				= $_REQUEST['stockstatus'];
$hunhe				= $_REQUEST['hunhe'];
$start				= $_REQUEST['start'];
$end				= $_REQUEST['end'];
$ebay_ordertype		= $_REQUEST['ebay_ordertype'];
$ostatus			= $_REQUEST['ostatus']?$_REQUEST['ostatus']:"0";
$status0			= $_REQUEST['status'];
$fprice             = $_REQUEST['fprice'];
$eprice             =$_REQUEST['eprice'];
$fweight             =$_REQUEST['fweight'];
$eweight             =$_REQUEST['eweight'];

if($status0 != '') $ostatus = $status0;
$country			= $_REQUEST['country'];
$keys				= $_REQUEST['keys']?trim($_REQUEST['keys']):"";
$shipping			= $_REQUEST['Shipping'];
$sku				= $_REQUEST['sku'];
$note				= $_REQUEST['isnote'];

$account			= $_REQUEST['account'];
$searchtype			= $_REQUEST['searchtype'];

$type				= $_REQUEST['type'];
$ebay_site			= $_REQUEST['ebay_site'];
$sort				= $_REQUEST['sort']?$_REQUEST['sort']:'';
$screen             = $_REQUEST['screen'];
$sortstatus			= $_REQUEST['sortstatus']?$_REQUEST['sortstatus']:0;
$sortdefault		= 0;

$ebay_warehouse				= $_REQUEST['ebay_warehouse'];

if($sort == 'recordnumber'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.recordnumber desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.recordnumber asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
if($sort == 'ebay_tracknumber'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_tracknumber desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_tracknumber asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
if($sort == 'ebay_userid'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_userid desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_userid asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'sku'){
	if($sortstatus  == '0'){
		$sortstr	= " order by b.sku desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by b.sku asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'ebay_shipfee'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_shipfee desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_shipfee asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'ebay_total'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_total desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_total asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
if($sort == 'ebay_createdtime'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_createdtime desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_createdtime asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}



if($sort == 'ebay_paidtime'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_paidtime desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_paidtime asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'onumber'){

	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_id desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_id asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'ShippedTime'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ShippedTime desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ShippedTime asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'ebay_account'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_account desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_account asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
if($sort == 'ebay_countryname'){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_countryname desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_countryname asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
if($sort == ''  ){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_paidtime desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_paidtime desc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
	$sort = 'ebay_paidtime';
}
$screen=$_REQUEST['screen'];
if($screen=='screen')
 {
	$sql1="select  *from ebay_onhandle ";
	$sql1=$dbcon->execute($sql1);
	$sql1=$dbcon->getResultArray($sql1);
	
	
 for($a=0;a<count($sql1);$a++)
  {
	$goods_count=$sql1[$a]['goods_count'];
	$goods_sn   =$sql1[$a]['goods_sn'];
	
	$sql2="select *from ebay_orderdetail where sku=".$goods_sn."";
	$i=0;
	
  while(i<count($sql1))
  {
	$sql2="select *from ebay_orderdetail where sku=".$sql1[$i]['goods_sn']."";
	$sql2=$dbcon->execute($sql1);
	$sql2=$dbcon->getResultArray($sql1);
	
	if($sql2[$i]['goods_count']>0)
	{
	 $sql4="update"; 
	}
	else if($sql2[$i]['goods_count']<=0)
	{
	 $sql4="update";	
	}
	  $i++;
  }
  }
}


/*
function getresultcount($status){
	global $dbcon,$user;
	$sql	= "select count(1) as cc from ebay_order where ebay_status='".$status."' and ebay_user='$user' and ebay_combine!='1'";
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	return  $sql[0]['cc'];
	$dbcon->close();
}*/

if($_REQUEST["type"] == "d") {
	$id = substr($_REQUEST["id"],1);

	$sqlDel = "delete ebay_order, ebay_orderdetail from ebay_order, ebay_orderdetail where ebay_order.ebay_ordersn =  ebay_orderdetail.ebay_ordersn and ebay_order.ebay_id in ($id)";
	if($dbcon->execute($sqlDel)) {
		$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
	} else {
		$status	= " -[<font color='#33CC33'>操作记录: 记录删除失败</font>]";
	}
}


 ?>

<style type="text/css">

<!--

.STYLE1 {font-size: xx-small}

-->

</style>

 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>


<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status;?>&nbsp;&nbsp;&nbsp;&nbsp;</h2>






                    

</div>



<div class='listViewBody'>






 

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

		

	<td >操作：
	  <input name="input" type="button" value="全选" onclick="check_all0('ordersn','ordersn')" />




            <!--
            
            <input name="button2" type="button" onclick="comorder()" value="自动合并" />
            <input name="input3" type="button" value="手动合并" onClick="combine()">
<input type="button" value="取消打印"		 	onclick="ordermarkprint('del')" />
               <input type="button" value="打印地址A4" onClick="detail2()">

               <input type="button" value="Label标签打印" onclick="detail3()" />-->

          
		 
          <!--
          
          
                    <input name="button" type="button" onclick="pimod()" value="批量修改" />


          <input type="button" value="添加" onclick="location.href='ordermodifive.php?module=orders&type=addorder&action=Add new Order'" />
            <input type="button" value="发货清单导出" onclick="exportdelivery()" />
		  <input type="button" value="日销售报表" onclick="salereport()" />
		  <input type="button" value="跟踪批量导入" onclick="location.href='trackimport.php?module=orders&amp;type=addorder&amp;action=跟踪号导入'" />
		  <input type="button" value="预读中邮挂号" onclick="location.href='orderdregister.php?module=orders&amp;type=addorder&amp;action=中国邮政小包挂号条码批量上传'">
		  <input type="button" value="申请挂号条码" onclick="applycode()">
 
 
            EUB：
            <input type="button" value="申请单号" onclick="eubtracknumberv3()" />
            <input type="button" value="交运" onclick="eubv3jy()" />
            <input type="button" value="热敏" onclick="eubtracknumberv3rm(1)" />
            <input type="button" value="A4" onclick="eubtracknumberv3rm(0)" />
            <input type="button" value="取消跟踪号" onclick="canceleubtracknumber()" />
            <input type="button" value="EUB重新发货" onclick="eubre()" />
 <input type="button" value="SMT导入" onclick="location.href='ordersumaitongupload.php?module=orders&amp;type=addorder&amp;action=速买通导入模板'" />
           <input type="button" value="删除" onclick="deleteById()" />
          <input type="button" value="标记三态"		 	onclick="doo(2)" />
          <input type="button" value="标记泰嘉" 			onclick="doo(3)" />
          <input type="button" value="标记出口易" 		onclick="doo(4)" />
          <input type="button" value="标记其他发货" 		onclick="doo(5)" />
          <input type="button" value="标记缺货订单" 		onclick="doo(6)" />
          <input type="button" value="标记已删除订单" 		onclick="doo(9)" />
          <br />
          <input type="button" value="标记问题订单" 		onclick="doo(7)" />
          <input type="button" value="专线导出" onclick="labelto01()" />
          <input type="button" value="三态导出" onclick="labelto02()" />
          <input type="button" value="Send Mail" onclick="ebaymarket02()" />
          <input type="button" value="EUB热敏打印API" onclick="eubrm()" />
             <input type="button" value="EUBA4打印API" onclick="euba4()" />
           <input type="button" value="登记黑名单" onclick="bookhackorer()" />
		  <input type="button" value="发送到燕文" onclick="posttoyanwen()" />
          -->
          <input name="button4" type="button" onclick="ebaymarket02()" value="发信" />
          <input type="button" value="eBay标发出" onclick="ebaymarket(0)" />
          <input type="button" value="Amazon传跟踪号" onclick="ammarket(0)" />
         
          <input type="button" value="速买通标发出" onclick="ebaymarketsmt(0)" />
          <input type="button" value="开始配货" onclick="distribute03()" />
          <input type="button" value="生成出库单" onclick="addoutorder()" />
          
          <?php if($user == 'vipwx' or $user == 'vipsui' or $user == 'viphcx' or $user == 'viphewei'){ ?>
          <input type="button" value="发货列表导出" onclick="labelto003()" />
          <input type="button" value="采购列表导出" onclick="labeltocg()" />
          <?php } ?>
          
          <select name="filesid" id="filesid" onchange="exportstofiles()" >
         <option value="" id="filesidselect">导出到XLS</option>
               <option value="12">热敏EUB-xls</option>
                   <option value="1">发货清单-1-xls</option>
                   <option value="10">发货清单-2-xls</option>
				   <option value="100">发货清单-3-xls</option>
                   <option value="105">发货清单-4-xls</option>
				   <option value="1051">发货清单-5-xls</option>
				   <option value="01251">发货清单-6-xls</option>
				    <option value="102">发货信息-4PX-xls</option>
				   <option value="101">一页24个地址pdf导出</option>
                   <option value="11">发货地址-xls</option>
                   <option value="5">拣货单_01-xls</option>
                    <option value="104">拣货单_02-xls</option>
                     <option value="107">拣货单_03_无库存-xls</option>
					  <option value="01252">拣货单_04-xls</option>
                   <option value="2">递四方-xls</option>
                   <option value="103">出口易_01-xls</option>
				   <option value="92101">出口易_UK-xls</option>
				   <option value="92102">出口易_M2C版-xls</option>
				   <option value="92103">出口易_专线-xls</option>
                   <option value="3">三态导出-xls</option>
                   <option value="4">eBay-csv</option>
				   <option value="0131">eBay-csv(修)</option>
				    <option value="44">eBay-csv（THG）</option>
				   <option value="116">速达xls</option>
                   <option value="6">常规列表导出xls</option>
                   <option value="7">本地发货记录导出xls</option>
                   <option value="8">美国发货记录导出xls</option>
                   <option value="9">欧洲发货记录导出xls</option>
				   <option value="15">地址+拣货清单</option>
                   <option value="106">地址+图片+拣货清单</option>
                   <option value="113">地址+图片+拣货清单2</option>
				   <option value="1131">地址+图片+拣货清单3</option>
                   <option value="11311">图片+拣货清单4</option>
                   
				   <option value="108">客户预留单格式</option>
				   <option value="110">导出需要格式</option>
				   <option value="111">fedex导出</option>
				   
                   <option value="112">导出无库存商品</option>
				   <option value="c1">仓库1</option>
				   <option value="c2">仓库2</option>
				   <option value="c3">仓库3</option>
                   <option value="c4">发货清单_UK</option>
                    <!--<option value="999">SalesHistory_01</option>-->
                    <option value="20">SalesHistory_02</option>
                    <option value="2020">SalesHistory_002</option>
                    
					 <option value="112601">数据导出格式</option>
					 <option value="112701">包货地址打印格式</option>
					 <option value="0108">小狼导出格式</option>
                     
                     <option value="0109">A_订单导出格式</option>
                     <option value="0110">B_订单导出格式</option>
                     <option value="0111">速卖通格式</option>
					 <option value="0117">亚马逊格式导出</option>
					 <option value="0122">西班牙邮政</option>
					 <option value="130226">西班牙邮政挂号小包</option>
					 <option value="1302261">西班牙邮政2(送货上门)</option>
					 <option value="1302263">西班牙邮政1(邮政取货)</option>
					 <option value="1302264">西班牙24H货代CSV</option>
					 <option value="1302265">西班牙48-72H货代CSV</option>
					 <option value="1302262">香港MAX600</option>
                     <option value="1302263">HK_PaypalDetails</option>
                     <option value="1302266">夏普_发货单导出</option>
					 <option value="1329">EU Letter_2 - doc</option>
                     <option value="130407">order UK-xls</option>
					 <option value="1304071">order HK-xls</option>
                     <option value="1304072">KU_system-xls</option>
					 <option value="130413">C02 Manifest-xls</option>
                     <option value="130415">燕文EbayExpress-xls</option>
                     <option value="130416">Endica_csv</option>
                     <option value="130417">vipchi_bma.xls</option>
                     <option value="130418">SCM-订单格式导出</option>
					 <option value="130419">订单格式导出-自定义01</option>
	                 <option value="130426">订单格式导出_自定义02</option>

                     <option value="130420">易网邮-自定义02</option>
                     
					 <option value="130421">AMAZON-批量上传导出格式</option>
                     <option value="130422">发货列表-FJ</option>
	              

 <option value="1304218">夏普格式导出</option>
   <option value="130423">发货列表-flyta_v7_1</option>
	                 <option value="130424">发货列表-HK挂号模板</option>
	                 <option value="130425">发货列表-美国</option>
	                 <option value="156">1128-XLS</option>
                     <option value="157">线下EUB格式-XLS</option>


          </select>
          <select name="printid" id="printid" onchange="printtofiles()" style=" width:150px"  >
                   <option value="" id="printidselect">打印订单</option>
                    <option value="16" >Packing Slip打印</option>
                    <option value="248" >Invoice-打印</option>
                    <option value="18" >夏普格式01</option>
					<option value="181" >夏普格式02</option>
					<option value="1812" >夏普格式02(修)</option>
                    <option value="1813" >夏普格式03</option>
                     <option value="18144" >夏普格式04</option>
                   <option value="15" >A4包货单01</option>
                   <option value="14" >A4包货单02</option>
				   <option value="151" >A4包货单03</option>
                   <option value="141" >A4包货单04</option>
                   <option value="13" >标签打印40*60</option>
                   <option value="1" >标签打印50*100</option>
                   <option value="183" >标签打印50*100西班牙</option>
                   <option value="12" >A4快递打印</option>
                   <option value="5" >标签打印-100*100</option>
                                      <option value="55" >标签打印-100*100_02</option>


                   <option value="2" >国际EUB-A4打印</option>
                   <option value="3" >国际EUB-热敏打印</option>
                    <option value="17" >国际EUB-AU热敏打印</option>
                    
                   <option value="6" >国际EUB发货清单-A4打印</option>
                   <option value="305" >地址+物品+图片每页1个-A4打印</option>
                   <option value="4" >地址+条码+物品每页5个-A4打印</option>
				   <option value="241">地址+物品+图片5个-A4打印</option>
				   <option value="40">地址+条码+物品5个-A4打印(修)</option>
                   <option value="41">地址+条码+物品5个-A4打印(修2)</option>
                   <option value="182">地址+条码+物品5个-A4打印(修3)</option>
                    <option value="441">地址+条码+物品5个-A4打印(修4)</option>
                   <option value="7" >地址10-A4打印</option>
                   <option value="11" >地址10+条码+sku-A4打印</option>
                   <option value="42" >地址10+条码+sku-A4打印(修改)</option>
                   <option value="9" >地址8+条码+sku-A4打印</option>
				   
                   
                   <option value="10" >拣货清单+条码-A4打印</option>
                   <option value="245" >拣货清单+条码-A4打印2</option>
				   <option value="20">a4/8</option>
				   <option value="19">label 100X100</option>
				   <option value="21">label 80X60</option>
				   <option value="22">小包 80X60</option>
				   <option value="222">小包 100X100</option>
				   <option value="23">挂号 80X60</option>
                   <option value="244">小包 70X60</option>
				    <option value="24">燕文a4</option>
				   <option value="25">燕文a5</option>
				   <option value="26">燕文a6</option>
				   <option value="27">本地a6打印</option>
                   <option value="246" >THGlable102mm*70mm打印</option>
                   <option value="247">地址打印</option>
				    <option value="121001">三态A4地址打印</option>
					<option value="0116">亚马逊_A4打印</option>
					<option value="0314">label 100*100(2)</option>
                    <option value="0315">label 100*100(3)</option>
					<option value="03141">label 80</option>
					<option value="13331">TNT</option>
					<option value="13332">EMS</option>
					<option value="130413">系统sample</option>
                    <option value="130414">TNT-Invoice</option>
                     <option value="130415">A4-一页6个</option>
                     <option value="130416">A4+报关单一页三个</option>
                     
                     <option value="130417">100*100-带跟踪号</option>
                     
                      
                    
          </select>
          <select name="stockstatus" id="stockstatus"   style="width:90px" >
            <option value="" id="printidselect2">出入库查询</option>
            <option value="0"  <?php if($stockstatus == '0') echo 'selected="selected"' ?> >未出库</option>
            <option value="1"  <?php if($stockstatus == '1') echo 'selected="selected"' ?>>已出库</option>
            <option value="2"  <?php if($stockstatus == '2') echo 'selected="selected"' ?>>已打印</option>
            <option value="3"  <?php if($stockstatus == '3') echo 'selected="selected"' ?>>未打印</option>
          </select>
          <select name="orderoperation" id="orderoperation"    onchange="orderoperation()" >
            <option value="" id="orderoperationselect">订单操作</option>
            <option value="0">标记打印</option>
            <option value="1">取消打印标记</option>
            <option value="2">手动合并</option>
            <option value="3">自动合并</option>
            <option value="4">添加新订单</option>
            <option value="5">速卖通订单上传</option>
            <option value="6">Amazon订单上传</option>
            <option value="7">Excel跟踪号批量导入</option>
            <option value="43">CSV跟踪号批量导入</option>
            <option value="44">SCM-订单状态更新</option>

            <option value="8">eBay CSV导入</option>
			<option value="36">自定义模板 CSV导入</option>
			<option value="37">测试1 CSV导入</option>
            <option value="9">批量修改</option>
            <option value="">------------</option>
            <option value="10">EUB-申请跟踪号</option>
            <option value="11">EUB-交运订单</option>
            <option value="12">EUB-热敏打印</option>
            <option value="13">EUB-A4打印</option>
            <option value="14">EUB-取消跟踪号</option>
            <option value="15">EUB-重新发货</option>
            <option value="">------------</option>
            <option value="16">线下EUB-申请跟踪号</option>
            <option value="17">线下EUB-取消跟踪号</option>
            <option value="18">线下EUB-标签打印</option>
            <option value="">------------</option>
            <option value="19">HK-ecship-申请跟踪号</option>
            <option value="20">HK-ecship-Common label</option>
            <option value="21">HK-ecship-4-inch</option>
            <option value="22">HK-ecship-A4*3</option>
            <option value="23">HK-ecship-A4*2</option>
            
            <option value="">------4PX API------</option>
            <option value="24">4PX-本地上传和确认</option>
            <option value="35">4PX-本地上传和确认V2.0</option>
            <option value="">------4PX 海外仓API------</option>
            <option value="25">4PX订单宝-上传并确认</option>
            <option value="26">4PX订单宝-同步订单状态</option>
            <option value="27">4PX订单宝-查看处理费</option>
            <option value="225">4PX订单宝-上传并确认V2.0</option>
            <option value="226">4PX订单宝-同步订单状态V2.0</option>
            
            
            <option value="">------出口易API------</option>
            <option value="28">上传并确认</option>
            <option value="29">获取跟踪号</option>
            
            <option value="">------出口易M2C------</option>
            
            <option value="30">上传并确认</option>
            <option value="31">获取跟踪号</option>
			
			<option value="">------出口易专线------</option>
            
            <option value="32">上传并确认</option>
            <option value="33">获取跟踪号</option>
            
            <option value="">------三态------</option>
            <option value="34">上传并确认</option>

			<option value="">------Endicia USPS------</option>
            <option value="38">上传跟踪号</option>
			<option value="39">A4-4*6一页4个pdf</option>

            <option value="">------万邑通------</option>
            <option value="40">提交订单并确认</option>
            <option value="41">作废订单</option>
            <option value="42">同步跟踪号</option>
            
            <option value="">------比利时邮政------</option>
            <option value="45">申请跟踪号</option>
            <option value="46">打印标签</option>
            <option value="47">打印发票</option>
            <option value="48">发货清单导出</option>
            
            
            <option value="">------燕文API------</option>
              <option value="49">申请跟踪号</option>
              <option value="50">A4</option>
              <option value="51">CnMiniParcel10x10</option>
			  <option value="52">LI10x10</option>
              <option value="53">同步跟踪号</option>     
              
              
			<option value="">------预设跟踪号------</option>
            
             <option value="54">跟踪号导入</option>     
              <option value="55">跟踪号申请</option>     

          </select>
       
          <!--<input type="button" value="Dhgate导入" onclick="location.href='orderdhgateupload.php?module=orders&amp;type=addorder&amp;action=Dhgate订单导入'" />
          
          线下EUB:
                   <input type="button" value="申请跟踪号" onclick="creatordereubxx()" />
          <input type="button" value="取消跟踪号" onclick="deleubxx()" />
                   <input type="button" value="打印标签" onclick="printeubxx()" />
                   
                                      
HK EUB:
<input type="button" value="申请单号" onclick="hkeub()" />

<input type="button" value="Common label" onclick="eubtracknumberv3rmHK(0)" />
<input type="button" value="4-inch " onclick="eubtracknumberv3rmHK(1)" />
<input type="button" value="A4 X3" onclick="eubtracknumberv3rmHK(2)" />
<input type="button" value="A4 X2" onclick="eubtracknumberv3rmHK(3)" />


 4px :
<input type="button" value="4px上传及确认" onclick="pxsubmit()" />

4PX订单宝: 
<input type="button" value="上传并确认" onclick="submit4px()" />
<input type="button" value="同步订单状态" onclick="submit4pxstatus()" />
<input type="button" value="查看订单费用" onclick="check4pxfee()" />

出口易：
<input type="button" value="上传并确认" onclick="submitcky()" />
<input type="button" value="获取跟踪号" onclick="tracknumbercky()" />
出口易M2C：
<input type="button" value="上传并确认" onclick="submitm2c()" />
<input type="button" value="获取跟踪号" onclick="tracknumberm2c()" />


                   
          
          --><?php if($user =='test' || $user =='survy'){ ?>
                   <input type="button" value="库存检测" onclick="distribute02()" />
                                      <input type="button" value="线下eub提交" onclick="xxeub()" />

                   <input type="button" value="Invoice" onclick="invoicexby()" />
<?php } ?>

          <div style="border-bottom:#CCCCCC solid 1px">&nbsp;</div>
          搜索：
          <input name="keys" type="text" id="keys" value="<?php echo $keys ?>" />
          <select name="searchtype" id="searchtype" style="width:90px">
            <option value="1" <?php if($searchtype == '1') echo 'selected="selected"' ?>>客户ID</option>
            <option value="3" <?php if($searchtype == '3') echo 'selected="selected"' ?>>客户邮箱</option>
            <option value="8" <?php if($searchtype == '8') echo 'selected="selected"' ?>>SKU</option>
            <option value="6" <?php if($searchtype == '6') echo 'selected="selected"' ?>>Item Number</option>
            <option value="7" <?php if($searchtype == '7') echo 'selected="selected"' ?>>物品标题</option>
            <option value="9" <?php if($searchtype == '9') echo 'selected="selected"' ?>>订单编号</option>
            <option value="11" <?php if($searchtype == '11') echo 'selected="selected"' ?>>Amazon订单ID</option>
            
            <option value="0" <?php if($searchtype == '0') echo 'selected="selected"' ?>>Record No.</option>
            <option value="2" <?php if($searchtype == '2') echo 'selected="selected"' ?>>客户姓名</option>
            <option value="4" <?php if($searchtype == '4') echo 'selected="selected"' ?>>Paypal交易ID</option>
            <option value="5" <?php if($searchtype == '5') echo 'selected="selected"' ?>>跟踪号</option>
            <option value="10" <?php if($searchtype == '10') echo 'selected="selected"' ?>>运送地址</option>
          </select>
        
          <select name="acc" id="acc" onchange="changeaccount()" style="width:90px">
            <option value="">eBay帐号</option>
            <?php 

					

					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$acc	= $sql[$i]['ebay_account'];
					 ?>
            <option value="<?php echo $acc;?>" <?php if($account == $acc) echo "selected=selected" ?>><?php echo $acc;?></option>
            <?php } ?>
          </select>
          <select name="isnote" id="isnote" style="width:90px">
            <option value="">留言</option>
            <option value="1" <?php if($note == '1') echo 'selected="selected"'; ?> >有note</option>
            <option value="0" <?php if($note == '0') echo 'selected="selected"'; ?>>无note</option>
          </select>
          <select name="ebay_site" id="ebay_site" style="width:90px" >
            <option value="">站点</option>
            <option value="US" <?php if($ebay_site == 'US' ) echo 'selected="selected"';?> >US</option>
            <option value="UK" <?php if($ebay_site == 'UK' ) echo 'selected="selected"';?> >UK</option>
            <option value="Germany" <?php if($ebay_site == 'Germany' ) echo 'selected="selected"';?> >Germany</option>
            <option value="France" <?php if($ebay_site == 'France' ) echo 'selected="selected"';?> >France</option>
            <option value="eBayMotors" <?php if($ebay_site == 'eBayMotors' ) echo 'selected="selected"';?> >eBayMotors</option>
            <option value="Canada" <?php if($ebay_site == 'Canada' ) echo 'selected="selected"';?> >Canada</option>
            <option value="Australia" <?php if($ebay_site == 'Australia' ) echo 'selected="selected"';?> >Australia</option>
          </select>
          <select name="Shipping" id="Shipping" style="width:90px" >
            <option value="">运送方式</option>
            <option value="88" <?php if($shipping == '88') echo 'selected="selected"';?>>未设置
             
              <?php
		   
		   
		   if($ostatus == 100){
		   
		   $gg	= "select count(ebay_id) as cc from ebay_order as a where a.ebay_user='$user'  and a.ebay_combine!='1' and ($ebayacc) and  (ebay_carrier ='' or ebay_carrier is null)";
		   }else{
		   $gg	= "select count(ebay_id) as cc from ebay_order as a where a.ebay_user='$user'  and a.ebay_combine!='1' and ($ebayacc) and a.ebay_status='$ostatus' and (ebay_carrier ='' or ebay_carrier is null) ";
		   }		   
		  // $gg	= $dbcon->execute($gg);
		 //  $gg	= $dbcon->getResultArray($gg);
		 //  echo $gg[0]['cc'];
		   ?>
            </option>
            <?php 

					

					$sql	 = "select distinct name  from ebay_carrier where ebay_user='$user'  ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$name	= $sql[$i]['name'];
					 ?>
            <option value="<?php echo $name;?>"  <?php if($shipping == $name) echo 'selected="selected"';?> ><?php echo $name;?>
              <?php
		   
		   /*
		   if($ostatus == 100){
		   
		   $gg	= "select count(ebay_id) as cc from ebay_order as a where a.ebay_user='$user'  and a.ebay_combine!='1'   and ($ebayacc) and  ebay_carrier ='$name'";
		   
		   }else{
		   $gg	= "select count(ebay_id) as cc from ebay_order as a where a.ebay_user='$user'  and a.ebay_combine!='1'   and ($ebayacc) and a.ebay_status='$ostatus' and ebay_carrier ='$name'";
		   }
		   $gga	= $dbcon->execute($gg);
		   $gg	= $dbcon->getResultArray($gga);
			$dbcon->free_result($gga);
		  echo $gg[0]['cc'];
		  */
		  
		   
		   
		   ?>
            </option>
            <?php } ?>
          </select>
          <select name="ebay_ordertype" id="ebay_ordertype" style="width:90px" >
            <option value="-1" >订单类型</option>
            <?php

							$tql	= "select typename from ebay_ordertype where ebay_user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){

							$typename1		= $tql[$i]['typename'];

						   

						   ?>
            <option value="<?php echo $typename1;?>"  <?php if($ebay_ordertype == $typename1) echo "selected=selected" ?>><?php echo $typename1;?></option>
            <?php

						   }

						   

						   

						   ?>
          </select>
          <select name="status" id="status" style="width:90px" >
            <option value="" <?php if($status0 == "") echo "selected=selected" ?>>订单状态</option>
            <option value="100" <?php  if($status0 == "100")  echo "selected=selected" ?>>所有订单</option>
            <option value="0" <?php  if($status0 == "0")  echo "selected=selected" ?>>未付款订单</option>
            <option value="1" <?php  if($status0 == "1")  echo "selected=selected" ?>>待处理订单</option>
            <?php



							$ss		= "select id,name from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
            <option value="<?php echo $ssid; ?>" <?php  if($status0 == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
            <?php } ?>
            <option value="2" <?php  if($status0 == '2')  echo "selected=selected" ?>>已经发货</option>
          </select>
          <select name="hunhe" id="hunhe" >
            <option value="">Please select</option>
            
            <!--
            <option value="0" <?php if($hunhe == '0') echo 'selected="selected"';?>>两件或两件以上的订单</option>
            <option value="1" <?php if($hunhe == '1') echo 'selected="selected"';?>>一件物品的订单</option>
            <option value="2" <?php if($hunhe == '2') echo 'selected="selected"';?>>一件物品的多数量订单</option>
            <option value="3" <?php if($hunhe == '3') echo 'selected="selected"';?>>四件或四件以下</option>
            <option value="4" <?php if($hunhe == '4') echo 'selected="selected"';?>>五件到8件之间</option>
            <option value="5" <?php if($hunhe == '5') echo 'selected="selected"';?>>9件到9件以上</option>-->
            
          </select>
          国家:
    <input name="country" id="country" value="<?php echo $country;?>" type="text" />
    仓库:
    <select name="ebay_warehouse" id="ebay_warehouse">
      <option value="">未设置</option>
      <?php 


							$sql = "select * from  ebay_store where ebay_user='$user'";									

							$sql = $dbcon->execute($sql);

							$sql = $dbcon->getResultArray($sql);

				

							for($i=0;$i<count($sql);$i++){

						

								$iid					= $sql[$i]['id'];

								$store_name			= $sql[$i]['store_name'];

								$goods_sku			= $sql[$i]['goods_sku'];	

								$goods_sx			= $sql[$i]['goods_sx'];	

								$goods_xx			= $sql[$i]['goods_xx'];	

						

							

							?>
      <option value="<?php echo $iid;?>" <?php if($iid ==$ebay_warehouse) echo "selected=selected";?>><?php echo $store_name; ?></option>
      <?php

							}

							

							

							?>
    </select>
    <br />
价格：
<input name="fprice" id="fprice" type="text"  value="<?php echo $fprice;?>" />
~
<input name="eprice" id="eprice" type="text"  value="<?php echo $eprice;?>" />

重量
&nbsp;&nbsp;&nbsp;
<input name="fweight" id="fweight" type="text"  value="<?php echo $fweight;?>" />
to
<input name="eweight" id="eweight" type="text"  value="<?php echo $eweight;?>" />
付款时间:
<input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start;?>" />
~
<input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $end;?>" />
<input type="button" value="搜索" onclick="searchorder()" /></td>
</tr>
</table>


 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td colspan='17'><div id="rows"></div> <div id="rows2"></div>		  </td>
	</tr><tr height='20'>

					<th nowrap="nowrap" scope='col'>

				<div style='white-space: nowrap;'width='100%' align='left'>

				  <input name="ordersn2" type="checkbox" id="ordersn2" value="<?php echo $ordersn;?>" onClick="check_all('ordersn','ordersn')" />
		</div></th>
					<th nowrap="nowrap" scope='col'><a href="orderindex.php?module=orders&amp;ostatus=<?php echo $ostatus;?>&amp;action=<?php echo $_REQUEST['action'];?>&amp;sort=onumber&amp;sortstatus=<?php echo $sortstatus;?>&amp;account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">编号</font></a></th>
		<th nowrap="nowrap" scope='col'>操作</th>
					<th nowrap="nowrap" scope='col'><span style="white-space: nowrap;"><a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=recordnumber&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">Record No.</font></a></span>

                    <?php if($sort == 'recordnumber') echo $sortsimg; ?>                    </th>

					<th width="5%" nowrap="nowrap" scope='col'>

                
                <a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_account&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">帐号</font></a><span style="white-space: nowrap;">

					  <?php if($sort == 'ebay_account') echo $sortsimg; ?>

					</span></span></th>

			

					<th width="10%" nowrap="nowrap" scope='col'>

				<div style='white-space: nowrap;'width='100%' align='left'><a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_userid&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">Buyer Email/ID</font></a>

				  <?php if($sort == 'ebay_userid') echo $sortsimg; ?>
				</div>			</th>

			

					<th width="5%" nowrap="nowrap" scope='col'><span class="left_bt2"><a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=sku&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">SKU</font></a><span style="white-space: nowrap;">

					  <?php if($sort == 'sku') echo $sortsimg; ?>

					</span></span></th>

                    <th scope='col' nowrap="nowrap">Qty</th>
                    <th scope='col' nowrap="nowrap">出库/打印</th>
        <th scope='col' nowrap="nowrap">
        
        <a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_countryname&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">
                
                
                国家</font></a><span style="white-space: nowrap;">

					  <?php if($sort == 'ebay_countryname') echo $sortsimg; ?>

					</span></span>        </th>
<th scope='col' nowrap="nowrap">


<a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_tracknumber&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">跟踪号</font></a><?php if($sort == 'ebay_total') echo $sortsimg; ?>



</th>
        <th scope='col' nowrap="nowrap">运输</th>
        <th scope='col' nowrap="nowrap">运费</th>
        <th scope='col' nowrap="nowrap"><a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_total&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">总价</font></a><?php if($sort == 'ebay_total') echo $sortsimg; ?>&nbsp;</th>

					<th scope='col' nowrap="nowrap">
					
					<a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_createdtime&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">Sale Date</font></a><?php if($sort == 'ebay_createdtime') echo $sortsimg; ?>					</th>
					<th scope='col' nowrap="nowrap">

				<div style='white-space: nowrap;'width='100%' align='left'><a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_paidtime&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">Paid	Date</font></a><?php if($sort == 'ebay_paidtime') echo $sortsimg; ?></div>			</th>

			

		            <th scope='col' nowrap="nowrap"><a href="orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ShippedTime&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>&country=<?php echo $country;?>&Shipping=<?php echo $shipping; ?>&start=<?php echo $start;?>&end=<?php echo $end;?>&status=<?php echo $status;?>&isnote=<?php echo $note;?>&ebay_ordertype=<?php echo $ebay_ordertype;?>&keys=<?php echo $keys;?>&searchtype=<?php echo $searchtype;?>"><font color="#0033FF">Shipped Date</font></a><?php if($sort == 'ShippedTime') echo $sortsimg; ?></th>

        </tr>

		





			  <?php

			  	

				
				$allprice = 0;
			  	

				if($ostatus ==0){

					$sql		= "select * from ebay_order as a where ebay_user='$user' and ebay_status='0'  and ebay_combine!='1'";
				}else{
					$sql		= "select * from ebay_order as a where ebay_user='$user' and ebay_status=$ostatus and ebay_combine!='1'";
				}
				if($ostatus == 100){
					$sql		= "select * from ebay_order as a where ebay_user='$user'  and ebay_combine!='1'";
				}
				
				/*
				if($hunhe == '3'){
				$sql = "SELECT a. * , b.ebay_id AS ddd, b.ebay_itemid, b.ebay_itemtitle, b.sku, COUNT( * ) AS cc
FROM ebay_order AS a
JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn
WHERE a.ebay_user='$user'  and a.ebay_combine!='1' and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) <= 4 
  ";  			if($ostatus != 100) $sql .=  " and a.ebay_status=$ostatus ";
				}
				
				
				if($hunhe == '4'){
				$sql = "SELECT a. * , b.ebay_id AS ddd, b.ebay_itemid, b.ebay_itemtitle, b.sku, COUNT( * ) AS cc
FROM ebay_order AS a
JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn
WHERE a.ebay_user='$user'  and a.ebay_combine!='1' and ((select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=5 and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) <= 8 )
  ";  			if($ostatus != 100) $sql .=  " and a.ebay_status=$ostatus ";
				}
				
				if($hunhe == '5'){
				$sql = "SELECT a. * , b.ebay_id AS ddd, b.ebay_itemid, b.ebay_itemtitle, b.sku, COUNT( * ) AS cc
FROM ebay_order AS a
JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn
WHERE a.ebay_user='$user'  and a.ebay_combine!='1' and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=9 
  ";  			if($ostatus != 100) $sql .=  " and a.ebay_status=$ostatus ";
				}
				
				
				if($hunhe == '0'){
				$sql = "SELECT a. * , b.ebay_id AS ddd, b.ebay_itemid, b.ebay_itemtitle, b.sku, COUNT( * ) AS cc
FROM ebay_order AS a
JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn
WHERE a.ebay_user='$user'  and a.ebay_combine!='1' and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=2
  ";  			if($ostatus != 100) $sql .=  " and a.ebay_status=$ostatus ";
				}
			
			
			if($hunhe == '1'){
				$sql = "SELECT a. * , b.ebay_id AS ddd, b.ebay_itemid, b.ebay_itemtitle, b.sku, COUNT( * ) AS cc
FROM ebay_order AS a
JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn
WHERE a.ebay_user='$user' and a.ebay_combine!='1' and (select  sum(ebay_amount) AS cc  from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) = 1 ";


				if($ostatus != 100) $sql .=  " and a.ebay_status=$ostatus ";
			}
			
			
			if($hunhe == '2'){
				$sql = "SELECT a. * , b.ebay_id AS ddd, b.ebay_itemid, b.ebay_itemtitle, b.sku, COUNT( * ) AS cc
FROM ebay_order AS a
JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn
WHERE a.ebay_user='$user' and a.ebay_combine!='1' and (select  sum(ebay_amount) AS cc  from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn)   > 1  and (select count(*) AS cc from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn) = 1";


				if($ostatus != 100) $sql .=  " and a.ebay_status=$ostatus ";
			}
			
			*/
			
			
			
				if($sort == 'sku' || $searchtype== 8 || $searchtype== 6 || $searchtype== 7 || $ebay_site != '' || $stockstatus == '0' || $stockstatus == 1){

					if($ostatus == 100){
					$sql	= "select a.*,b.ebay_id as ddd from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_user='$user'  and ebay_combine!='1'  ";
				}else{
					$sql	= "select a.*,b.ebay_id as ddd from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='$ostatus'  and ebay_combine!='1'  ";
				}
				}
				
				
				
				
				if($searchtype == '0' && $keys != ''){$sql	.= " and a.recordnumber			 = '$keys'";}
				if($searchtype == '1' && $keys != ''){$sql	.= " and a.ebay_userid		 = '$keys'";}
				if($searchtype == '2' && $keys != ''){$sql	.= " and a.ebay_username	 = '$keys'";}
				if($searchtype == '3' && $keys != ''){$sql	.= " and a.ebay_usermail	 = '$keys'";}
				if($searchtype == '4' && $keys != ''){$sql	.= " and a.ebay_ptid		 = '$keys'";}
				if($searchtype == '5' && $keys != ''){$sql	.= " and a.ebay_tracknumber	 like  '%$keys%'";}
				if($searchtype == '6' && $keys != ''){$sql	.= " and b.ebay_itemid		 = '$keys'";}
				//if($searchtype == '7' && $keys != ''){$sql	.= " and b.ebay_itemtitle	 like '%$keys%'";}
				if($searchtype == '8' && $keys != ''){$sql	.= " and b.sku			 	 like '%$keys%'";}
				if($searchtype == '9' && $keys != ''){$sql	.= " and a.ebay_id		 	 = '$keys'";}
				if($searchtype == '11' && $keys != ''){$sql	.= " and a.ebay_ordersn	 	 = '$keys'";}
				
				if($stockstatus != '' && $stockstatus == '0' ) {$sql	.= " and b.istrue		 = '0' ";}
				if($stockstatus != '' && $stockstatus == '1' ) {$sql	.= " and b.istrue		 = '1' ";}
				
				if($stockstatus != '' && $stockstatus == '2' ) {$sql	.= " and a.isprint		 = '1' ";}
				if($stockstatus != '' && $stockstatus == '3' ) {$sql	.= " and a.isprint		 = '0' ";}
				
				
				
				if($searchtype == '10' && $keys != ''){$sql	.= " and (a.ebay_username like '%$keys%' or a.ebay_street like '%$keys%' or a.ebay_street1 like '%$keys%' or a.ebay_city like '%$keys%' or a.ebay_state like '%$keys%' or a.ebay_countryname like '%$keys%' or a.ebay_postcode like '%$keys%' or a.ebay_phone like '%$keys%') ";}

//stockstatus











				if($ebay_ordertype !='' && $ebay_ordertype !='-1'  ) $sql.=" and a.ebay_ordertype='$ebay_ordertype'";
		
				if($country !=''){
					
					if($country == 'United States'){		
				 	$sql.=" and (a.ebay_countryname='United States' or a.ebay_countryname='US' or a.ebay_countryname='USA' or a.ebay_countryname='APO/FPO' OR a.ebay_countryname='Puerto Rico' )";
				 	}else{
					$sql.=" and a.ebay_countryname='$country'";
					}
				 }
				 
	if( $ebay_warehouse> 0 ) 	$sql.=" and a.ebay_warehouse	= '$ebay_warehouse' ";
				if( $note == '1') 	$sql.=" and a.ebay_note	!=''";
				if( $note == '0') 	$sql.=" and a.ebay_note	=''";
				if( $ebay_site != '') 	$sql.=" and b.ebay_site	='$ebay_site'";
				if($shipping !='') {
				
				if($shipping == '88'){
				$sql.=" and (a.ebay_carrier='' or a.ebay_carrier is null )";
				}else{
				$sql.=" and a.ebay_carrier='$shipping'";
				
				}
				}
				$sql	.= " and ($ebayacc)";
				
				
				if($account !="") $sql.= " and a.ebay_account='$account'";
				
				
				
				if($start !='' && $end != ''){
					
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql	.= " and (a.ebay_paidtime>=$st00 and a.ebay_paidtime<=$st11)";
				}
				
				if($fprice!='')
				{
					$sql.=" and a.ebay_total>=$fprice";
				}
				if($eprice!=''){
					$sql.=" and a.ebay_total<=$eprice";
				}
				if($fweight!='')
				{
					$sql.=" and a.orderweight>=$fweight";
				}
				if($eweight!=''){
					$sql.=" and a.orderweight<=$eweight";
				}
				
				if($sku	!= "" ){
					$sql .= " group by a.ebay_id order by ebay_id desc ";
					
				}else{
					//$sql .= ' group by a.ebay_id '.$sortstr;
					
					$sql .= ' group by a.ebay_id '.$sortstr;
					
				}

				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				
				
				
				/* 释放mysql 系统资源 */
				$dbcon->free_result($query);
					
					
				$totalpages = $total;
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				
				
				
				
				$sql = $sql.$limit;
				
				
				
 				$sqla		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sqla);
				
				/* 释放mysql 系统资源 */
				$dbcon->free_result($sqla);
				
				
				$dpage		= 0;
				for($i=0;$i<count($sql);$i++){
					$totalprofit				= $sql[$i]['totalprofit'];
					$noteb				= $sql[$i]['ebay_noteb']?$sql[$i]['ebay_noteb']:"";
					$ebayid				= $sql[$i]['ebay_id'];
					$ordersn			= $sql[$i]['ebay_ordersn'];
					$ordershipfee		= $sql[$i]['ordershipfee'];
					$orderweight		= $sql[$i]['orderweight'];
					$packingtype		= $sql[$i]['packingtype'];
					$orderweight2		= $sql[$i]['orderweight2'];
					$userid				= $sql[$i]['ebay_userid'];
					$username			= $sql[$i]['ebay_username'];
					$scantime			= $sql[$i]['scantime'];
					$email				= $sql[$i]['ebay_usermail'];
					$total				= $sql[$i]['ebay_total'];
					$ebay_shipfee				= $sql[$i]['ebay_shipfee'];
					$currency			= $sql[$i]['ebay_currency'];
					
					
					/*
					
					$sss = "select rates from ebay_currency where currency='$currency' and user='$user'";
					$sss = $dbcon->execute($sss);
					$sss	= $dbcon->getResultArray($sss);
					$rates  = $sss[0]['rates']?$sss[0]['rates']:1;
					*/
					
					
					$truetotal = $total*1;
					$allprice			+= $truetotal;
					
					
					
					$paidtime			= $sql[$i]['ebay_paidtime'];
					$RefundAmount		= $sql[$i]['RefundAmount'];
					$ebay_ordersn		= $sql[$i]['ebay_ordersn'];
					$dpage++;
					$ebay_createdtime	= $sql[$i]['ebay_createdtime'];
					$country			= $sql[$i]['ebay_countryname'];
					$isprint			= $sql[$i]['isprint'];
					$status				= Getstatus($sql[$i]['ebay_status']);
					$account			= $sql[$i]['ebay_account'];
					$ebay_warehouse			= $sql[$i]['ebay_warehouse'];
					$pxorderid			= $sql[$i]['pxorderid'];
					
					$cky_orderid 			= $sql[$i]['cky_orderid'];
					$cky_item 			= $sql[$i]['cky_item'];
					
					/*
					$ebay_feedback		= $sql[$i]['ebay_feedback'];
					
					
					$imgsrc				= '';
					if($ebay_feedback == 'Positive') $imgsrc = '<img src="images/iconPos_16x16.gif" width="16" height="16" />';
					if($ebay_feedback == 'Negative') $imgsrc = '<img src="images/iconNeg_16x16.gif" width="16" height="16" />';
					if($ebay_feedback == 'Neutral')  $imgsrc = '<img src="images/iconNeu_16x16.gif" width="16" height="16" />';
					*/
					
					
				
					$shipfee				= $sql[$i]['ebay_shipfee'];
					$ebaynote				= $sql[$i]['ebay_note'];
					$ebay_carrier			= $sql[$i]['ebay_carrier'];
					$recordnumber 			= $sql[$i]['recordnumber'];
					$ebay_tracknumber		= $sql[$i]['ebay_tracknumber'];
					$ShippedTime			= $sql[$i]['ebay_markettime'];
					$ebay_status			= $sql[$i]['ebay_status'];
					$moneyback= $sql[$i]['moneyback'];
					$moneyback_total= $sql[$i]['moneyback_total'];
					$ebay_createdtime		= $sql[$i]['ebay_createdtime'];
					$formatshipprice	= $currency.$shipfee;
					$formattotalprice	= $currency.$total;
					
					/*  对应物品明细表  2012-05-13号 */					
					$st	= "select ebay_id,ebay_itemid,ebay_itemtitle,ebay_itemurl,sku,ebay_itemprice,ebay_amount,istrue,notes,recordnumber,attribute,ebay_shiptype from ebay_orderdetail where ebay_ordersn='$ordersn'";
					$sta = $dbcon->execute($st);
					$st	= $dbcon->getResultArray($sta);
					
					/* 释放mysql 系统资源 */
					$dbcon->free_result($sta);
				
				
					$itemid		= $st[0]['ebay_itemid'];		
					$ebay_ptid		=  $sql[$i]['ebay_ptid'];
					$PayPalEmailAddress=  $sql[$i]['PayPalEmailAddress'];
					//$messagesql	= "select id from ebay_message where  sendid ='$userid' and itemid ='$itemid'";
					//$messagesql = $dbcon->execute($messagesql);
					//$messagesql	= $dbcon->getResultArray($messagesql);
					

			  ?>

              

              

                  

         		<tr height='20' class='oddListRowS1'>

						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ebayid;?>" onchange="displayselect()" >

					     <?php
						if($ebaynote != "") echo "<img src='notes.gif' title='".$ebaynote."'  width=\"20\" height=\"20\"/>";
						?>                        </td>
						<td scope='row' align='left' valign="top" ><?php echo $ebayid;?></td>
						<td scope='row' align='left' valign="top" ><a href="ordermodifive.php?ordersn=<?php echo $ordersn;?>&module=orders&ostatus=1&action=ModifiveOrder"  target="_blank">编辑</a>&nbsp;
                                                      &nbsp;<a href="#" onclick="copyorders('<?php echo $ordersn;?>')" >复制</a>
                                                       &nbsp;<a href="expressprint.php?id=<?php echo $ebayid;?>" target="_blank">快递</a>                                                      </td>
		          <td scope='row' align='left' valign="top" ><?php echo $recordnumber;?></td>

						    <td scope='row' align='left' valign="top" >

							<?php echo $account; ?>                            </td>

				

						    <td scope='row' align='left' valign="top" ><?php echo $userid;?>(<?php echo $email;?>)
                            <?php 
							echo $username.'<br>';
							echo $ordersn;
							
							
							?>                             </td>

				

						    <td scope='row' align='left' valign="top" >&nbsp;</td>

						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
			      <td scope='row' align='left' valign="top" ><?php echo $country;?></td>
<td scope='row' align='left' valign="top" ><?php 
							if($ebay_tracknumber != '') echo '<br><font color=red>'.$ebay_tracknumber.'</font>'; 							
							?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_carrier;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_shipfee;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $formattotalprice;?>&nbsp;</td>

						    <td scope='row' align='left' valign="top" >
                            <?php 
							
							if($ebay_createdtime != '0' && $ebay_createdtime != ''){
							echo date('Y-m-d',$ebay_createdtime);
							
							}
							 ?>
							
                            
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php 
							if($paidtime != 0){
							echo date('M-d',$paidtime); }

							?></td>

		                    <td scope='row' align='left' valign="top" ><?php 
							if($ShippedTime != 0){
							echo date('M-d',$ShippedTime);
							}
							?>&nbsp;扫描时间:<?php
							
							if($scantime > 0) echo  date('M-d H:i',$scantime);
							
							 ?></td>
              </tr>

              

             <?php

			  

							

							$total	= 0;
							$productcost		= 0;
							$productweight		= 0;

							for($t=0;$t<count($st);$t++){

							

							
								$pid			= $st[$t]['ebay_id'];	
								$qname			= $st[$t]['ebay_itemtitle'];								
								$qitemid		= $st[$t]['ebay_itemid'];
								$sku			= $st[$t]['sku'];
								$imagepic		= $st[$t]['ebay_itemurl'];
								
								if($imagepic == '' ){
								
										
										
										$ddsql		= "select goods_pic from ebay_goods where ebay_user ='$user' and goods_sn ='$sku' ";
										$ddsql 		= $dbcon->execute($ddsql);
										$ddsql		= $dbcon->getResultArray($ddsql);
										
										$imagepic	= 'images/'.$ddsql[0]['goods_pic'];
								
								}
								
								
								$ebay_amount	= $st[$t]['ebay_amount'];
								$qname			= $st[$t]['ebay_itemtitle'];
								$recordnumber	= $st[$t]['recordnumber'];
								$ebay_itemprice	= $st[$t]['ebay_itemprice'];
								$istrue			= $st[$t]['istrue'];
								$notes			= $st[$t]['notes'];
								$attribute		= $st[$t]['attribute'];
								$ebay_shiptype	= $st[$t]['ebay_shiptype'];
								
								
								
							
			  ?>

         		<tr height='20' class='oddListRowS1'>

         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td align='left' valign="top" scope='row' ><?php
			// echo"	  交昜号：".$ebay_ptid ."  Paypal:".$PayPalEmailAddress;
			
				  if($t == 0){
				  if($ebay_status == '0'){
					echo '未付款订单';
				  }else if($ebay_status == '1'){
					echo '待处理订单';
				  }else if($ebay_status == '2'){
					echo '已经发货';
				  }else{
				  	 
					
					 $rr		= "select name from ebay_topmenu where id='$ebay_status' ";
					 $rra		= $dbcon->execute($rr);
					 $rr		= $dbcon->getResultArray($rra);
					 echo $rr[0]['name'];
					 
				  }
				  
				  if($pxorderid != '') echo '<br>4px ID:<font color=red>'.$pxorderid.'<br>';
				  
				  }
				  
				  
				  if($cky_orderid  != '') echo '<br>CKY ID:<font color=red>'.$cky_orderid .'</font><br>';
				  if($cky_item  != '') echo '<br>CKY Item ID:<font color=red>'.$cky_item .'</font><br>';
				  
				  
				  ?></td>
         		  <td scope='row' align='left' valign="top" ><?php if(count($st) >1) echo  $recordnumber; ?></td>

         		  <td scope='row' align='left' valign="top" ><a href="http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?php echo $qitemid; ?>" target="_blank">

				 <img src="<?php echo $imagepic; ?>" border="0" width="50" height="50" />
                  
               
         		  <td scope='row' align='left' valign="top" >
                  
                  <?php
				  		
						if(strlen($qitemid) >  10 ){ 
							$url	= "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=$qitemid";
						}else{
							$url	= "http://www.amazon.com/gp/product/$qitemid";
						}                        
				  
				  ?>
                  
                  <span class="STYLE1"><a href="<?php echo $url;?>" target="_blank"><?php echo "(".$qitemid.")<br><font color=#0066FF>".$qname."</font></a>";
				  
				  
				  
				  if($notes != '') echo '<br><font color=red>'.$notes.'</font>';?></td>

         		  <td scope='row' align='left' valign="top" ><span class="STYLE1">
         		    <input name="sku<?php echo $pid;?>" type="text" id="sku<?php echo $pid;?>" value="<?php echo $sku;?>" />
       		      <a href="#" onclick="savesku('<?php echo $pid;?>')">Save</a><span id="mstatus<?php echo $pid;?>" name="mstatus<?php echo $pid;?>"></span>&nbsp;</td>

         		  <td scope='row' align='left' valign="top" ><strong><?php echo $ebay_amount;?></strong></td>
         		  <td scope='row' align='left' valign="top" ><?php 
							
							if($istrue == '1'){
								
								echo "√";
							}else{								
								echo "×";
							}
							echo '/';
							echo $isprint?'√':'×';
						?></td>
         		  <td align='left' valign="top" scope='row' >属性:<?php echo $attribute.' '; ?>&nbsp;</td>

         		  <td colspan="4" align='left' valign="top" scope='row' >
                  <a href="#" onclick="rta('<?php echo $ebayid;?>','<?php echo $pid;?>')">RMA 管理<?php echo $ebay_shiptype;?></a> </td>
                  
					<td colspan="4" align='left' valign="top" scope='row' ><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="1" >
                      <?php 
					
					$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					$rra			= $dbcon->execute($rr);
					$rr 	 	= $dbcon->getResultArray($rra);
					
					/* 释放mysql 系统资源 */
					$dbcon->free_result($rra);
					
					
					if(count($rr) > 0){

			

					$goods_sncombine	= $rr[0]['goods_sncombine'];

					$goods_sncombine    = explode(',',$goods_sncombine);

					

					for($e=0;$e<count($goods_sncombine);$e++){

						

						

						$pline			= explode('*',$goods_sncombine[$e]);

						$goods_sn		= $pline[0];

						$goddscount     = $pline[1] * $ebay_amount;

						

						$gg			= "SELECT goods_sn,goods_name,isuse FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
						$gga			= $dbcon->execute($gg);
						$gg 	 		= $dbcon->getResultArray($gga);
						
						/* 释放mysql 系统资源 */
						$dbcon->free_result($gga);
						if($gg=='')
						{
							$goods_sn="无该商品";
						}
                       else{
						$goods_sn		= $gg[0]['goods_sn'];

						$goods_name		= $gg[0]['goods_name'];

						$isuse		= $gg[0]['isuse'];
						
                        }
						?>
                      <tr>
                        <td  ><?php echo $goods_sn;?>&nbsp;</td>
                        <td  ><?php echo $goods_name;?>&nbsp;</td>
                        <td  ><?php echo $goddscount;?>&nbsp;/
                          <?php 

					  	

						$dd				= "select sum(b.goods_count) as cc,isuse from ebay_goods as a join  ebay_onhandle as b on a.goods_id = b.goods_id  where a.goods_sn ='$goods_sn' and a.ebay_user ='$user' ";
						
						if($ebay_warehouse > 0) $dd .= " and b.store_id='$ebay_warehouse' ";

					
						
						$dda				= $dbcon->execute($dd);
						$dd				= $dbcon->getResultArray($dda);
						/* 释放mysql 系统资源 */
						$dbcon->free_result($dda);
						
						if(count($dd)=='')
						{
						echo "无库存";
						}
						else 
						{
						echo '<font color=red>'.$dd[0]['cc'].'</font>';
						}
						
						
					  

					  ?>                        </td>
                        <td  ><?php
					  
					  
					if($isuse == '0') $isuse	= '在线';
					if($isuse == '1') $isuse	= '下线';
					if($isuse == '2') $isuse	= '零库存';
					if($isuse == '3') $isuse	= '清仓';
					
					echo $isuse;
					
					  
					  ?>
                          &nbsp;</td>
                      </tr>
                      <?php

					}

					}else{

					

						$gg				= "SELECT goods_sn,goods_name,isuse FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
						$gga			= $dbcon->execute($gg);
						$gg 	 		= $dbcon->getResultArray($gga);
						
						$dbcon->free_result($gga);

					if($gg=='')
						{
							$goods_sn="无该商品";
						}
                       else{
						$goods_sn		= $gg[0]['goods_sn'];
						$goods_name		= $gg[0]['goods_name'];
						$isuse		= $gg[0]['isuse'];
						
                        }
					

					

					

					

					 ?>
                      <tr>
                        <td><?php echo $goods_sn;?>&nbsp;</td>
                        <td><?php echo $goods_name;?>&nbsp;</td>
                        <td><?php echo $ebay_amount;?>&nbsp;/
                          <?php 

					  	

						$dd					= "select sum(b.goods_count) as cc from ebay_goods as a join  ebay_onhandle as b on a.goods_id = b.goods_id  where a.goods_sn ='$goods_sn'  and a.ebay_user ='$user' ";
						
						if($ebay_warehouse > 0) $dd .= " and b.store_id='$ebay_warehouse' ";
						
						
						$dda				= $dbcon->execute($dd);
						$dd					= $dbcon->getResultArray($dda);
						$dbcon->free_result($dda);
						
						
						if(count($dd)<= 0)
						{
							echo "无库存";
						}
						else 						
						{
						echo '<font color=red>'.$dd[0]['cc'].'</font>';
						}
						

					  

					  ?>                        </td>
                        <td><?php
					  
				
					echo $isuse;
					
					  
					  
					  ?>
                          &nbsp;</td>
                      </tr>
                      <?php

					 

					 }

					 

					 

					  ?>
                    </table></td>
					   
              <?php 
			  $ebaynote					= str_replace('<![CDATA[','',$ebaynote);
			  $ebaynote					= str_replace(']]>','',$ebaynote);
			  ?>
         		<tr height='20' class='oddListRowS1'>

         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>

         		  <td scope='row' align='left' valign="top" >&nbsp;</td>

         		  <td colspan="11" align='left' valign="top" scope='row' >
                  <?php if($ebaynote != '') echo 'eBay notes:'.$ebaynote.'<br>'; ?>
                  <?php if($noteb != '') echo 'My note:'.$noteb.'<br>'; ?>                  </td>

         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
   		      </tr>
               <?php  } } ?>

		<tr class='pagination'>

		<td colspan='17'>

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>
                    本页订单条数为：<?php echo $dpage;?> 总金额是：<?php echo $allprice;?>
                    <div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>
    <div class="clear"></div>
<?php
include "bottom.php";
?>

<script language="javascript">

	

	 document.getElementById('rows').innerHTML="Your search results is <?php echo $totalpages;?>";

	 

	 

function check_all0(obj,cName)

{

    var checkboxs = document.getElementsByName(cName);

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == false){

			

			checkboxs[i].checked = true;

		}else{

			

			checkboxs[i].checked = true;

		}	

		

	}

}



function check_all(obj,cName)

{

    var checkboxs = document.getElementsByName(cName);

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == false){

			

			checkboxs[i].checked = true;

		}else{

			

			checkboxs[i].checked = false;

		}	

		

	}
displayselect();

}



function combine(){

	

	var bill	= "";

	var g		= 0;

	var checkboxs = document.getElementsByName("ordersn");

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == true){

			

			bill = bill + ","+checkboxs[i].value;

			g++;

		}	

		

	}

	if(bill == ""){

		

		alert("请选择订单号");

		return false;

	

	}

	

	if(g<=1){

	

		 alert("合并订单最少需要选择两个或两个以上的订单！！！");

		 return false;

	}

	

	

	if(confirm("确认合并吗，客户订单信息，将以第一个订单信息为准，确认？")){

	

		window.open("ordercombine.php?ordersn="+bill,"_blank");



	}

	

}









	

	

	

		function ebaymarket(type){

		

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}

		if(bill == ""){

			

		//	alert("请选择订单号");

		//	return false;

		

		}
		
		var alerstr		= '您确认将选中订单在ebay上标记发出吗?';
		
		if(type == 1){
			alerstr		= '你确认出库吗';
		}
		if(confirm(alerstr)){
				window.open("ordermarket.php?ordersn="+bill+"&type="+type,"_blank");
		}
	}
	
	
	
	function ebaymarketsmt(type){


		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}
		}
		if(bill == ""){			
		alert("请选择订单号");
		return false;
		}
		
		var alerstr		= '您确认将选中订单在ebay上标记发出吗?';
		
		if(type == 1){
			alerstr		= '你确认出库吗';
		}
		if(confirm(alerstr)){
				window.open("ordermarketsmt.php?ordersn="+bill+"&type="+type,"_blank");
		}
	}
	
	
	
	
	
	function ammarket(type){

		

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}

		if(bill == ""){

			

		}
		
		var alerstr		= '您确认将选中订单在amaozn上标记发出吗?';
		
		if(type == 1){
			alerstr		= '你确认出库吗';
		}
		if(confirm(alerstr)){
				window.open("AMordermarket.php?ordersn="+bill+"&type="+type,"_blank");
		}
	}

		function searchorder(){
		var ebay_ordertype	 		= document.getElementById('ebay_ordertype').value;
		var fprice	 		        = document.getElementById('fprice').value;
		var eprice	 		        = document.getElementById('eprice').value;
		var fweight	 		        = document.getElementById('fweight').value;
		var eweight 		        = document.getElementById('eweight').value;
		var isnote	 				= document.getElementById('isnote').value;
		var ebay_site	 			= document.getElementById('ebay_site').value;
		var searchtype 				= document.getElementById('searchtype').value;
		var keys	 				= document.getElementById('keys').value;
		var country	 				= document.getElementById('country').value;
		var acc	 					= document.getElementById('acc').value;
		var Shipping	 			= document.getElementById('Shipping').value;
		var isprint			= '';
		var stockstatus	 			= document.getElementById('stockstatus').value;
		var start			= document.getElementById('start').value;
		var end				= document.getElementById('end').value;
		var status			= document.getElementById('status').value;
		
		var hunhe			= document.getElementById('hunhe').value;
		var istrue				= '';
		
		var isshipfee	 		= '';

				var ebay_warehouse			= document.getElementById('ebay_warehouse').value;

		location.href= 'orderindex.php?module=orders&action=<?php echo $_REQUEST['action'];?>&ostatus=<?php echo $ostatus;?>&searchtype='+searchtype+'&keys='+encodeURIComponent(keys)+'&country='+country+'&Shipping='+Shipping+'&account='+acc+'&isprint='+isprint+"&start="+start+"&end="+end+"&istrue="+istrue+'&isnote='+isnote+'&isshipfee='+isshipfee+"&hunhe="+hunhe+"&pagesize=<?php echo $pagesize;?>&status="+status+"&ebay_ordertype="+ebay_ordertype+"&fprice="+fprice+"&eprice="+eprice+"&fweight="+fweight+"&eweight="+eweight+"&ebay_site="+ebay_site+"&stockstatus="+stockstatus+"&ebay_warehouse="+ebay_warehouse;
		
		
		

		

	}


 

	function sdformat(){

	

	

	//window.open("ordertoexcelst.php","_blank");

	var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}



		

		var country 	= document.getElementById('country').value;



	//	window.open("ordertoexcelst.php?bill="+bill,"_blank");

window.open("allpacklist.php?ordersn="+bill+"&country="+country,"_blank");

	

	}

	

	

	function sdformat1(){

	

		var content 	= document.getElementById('keys').value;

		var account 	= document.getElementById('acc').value;

		var sku 	= document.getElementById('sku').value;

		var country 	= document.getElementById('country').value;

		

		location.href= 'orderindex.php?keys='+content+"&account="+account+"&sku="+sku+"&module=orders&action=<?php echo $_REQUEST['action'];?>&ostatus=<?php echo $ostatus;?>&country="+country;

	

	

	}

	

	function ukformat(){

	

	

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}

		if(bill == ""){

			

			alert("请选择订单号");

			return false;

		

		}

		



		//window.open("packlist.php?ordersn="+bill,"_blank");

window.open("allpacklist.php?ordersn="+bill,"_blank");

		

		

	

	

	}

	

		function allformat(){

	

	

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}

		if(bill == ""){

			

			alert("请选择订单号");

			return false;

		

		}

		



		window.open("allpacklist.php?ordersn="+bill,"_blank");



		

		

	

	

	}

	

	

	

	

	

	

	

	







		function detail2(){

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}

		if(bill == ""){

			

			alert("请选择订单号");

			return false;

		

		}

	

		var url	= "exceltodetail2.php?type=delivery&bill="+bill;

		window.open(url,"_blank");

		

	

	}

		function detail3(){

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){

				

				bill = bill + ","+checkboxs[i].value;

			

			}	

			

		}

		if(bill == ""){

			

			alert("请选择订单号");

			return false;

		

		}

	

		var url	= "labeladdress.php?type=delivery&bill="+bill;

		window.open(url,"_blank");

		

	

	}

	

	

	function bulkedit(){

		

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){				

				bill = bill + ","+checkboxs[i].value;			

			}	

			

		}

		

		if(bill == ""){

			

			alert("Please select Orders");

			return false;

		

		}

		window.open("orderbulkeditorderstatus.php?module=orders&ordersn="+bill,"_blank");

	

	}

	

	function shippingtolist(){

		

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){				

				bill = bill + ","+checkboxs[i].value;			

			}	

			

		}

		

		if(bill == ""){

			

		//	alert("Please select Orders");

		//	return false;

		

		}

		window.open("allpacklist.php?module=orders&ordersn="+bill,"_blank");

	

	}
	
	function ordermarkprint(type){
	
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == true){			

			bill = bill + ","+checkboxs[i].value;		

		}		

	}

	if(bill == ""){

		alert("请选择订单号");
		return false;	

	}

	
	
	
	

		
		
		

	if(confirm('确认操作吗')){

	

		openwindow("orderprint.php?ordersn="+bill+"&type="+type,'',550,385);
		

	}



}

	
	function ebaymarket02(){
		
		
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}

		
		
		if(confirm('您确认将选中订单进行发信吗?')){
		
		
		
		openwindow("ordermarket02.php?ordersn="+bill,'',550,385);
		}
		
		
		
			
	
		
		
	
	}
	
	function deleteById() {
		
		var bill = "";
		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++) {
			if(checkboxs[i].checked == true) {
				bill = bill + "," + checkboxs[i].value;
			}
		}

		if(bill == "") {
			alert("请选择你要删除的订单！");
		} else if(confirm("您确定要删除选中的订单吗？")) {
			location.href = 'orderindex.php?type=d&id='+bill;
		}
	}
	
	
	
//设定打开窗口并居中
function openwindow(url,name,iWidth,iHeight)
{
var url; //转向网页的地址;
var name; //网页名称，可为空;
var iWidth; //弹出窗口的宽度;
var iHeight; //弹出窗口的高度;
var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
}
	
	function labelto01(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;
			
			}				
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}	
		window.open("labelto01.php?ordersn="+bill,"_blank");	
	}
	
	
	function labelto02(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;
			
			}				
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}	
		window.open("labelto02.php?ordersn="+bill,"_blank");	
	}
	
	function labelto03(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;
			
			}				
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}	
		alert("提示：\n\r选定BCD列，在点击鼠标右键，选择设置单元格格式-》选择对齐=》选择自动换行=》选择确定，就可看到您想要的格式。")
		window.open("labelto02.php?ordersn="+bill,"_blank");	
	}
	
	
	function labelto04(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;
			
			}				
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}	
		//alert("提示：\n\r选定BCD列，在点击鼠标右键，选择设置单元格格式-》选择对齐=》选择自动换行=》选择确定，就可看到您想要的格式。")
		window.open("label04.php?ordersn="+bill,"_blank");	
	}
	
	
	function pimod(){
		
		var bill		= "";
		var checkboxs 	= document.getElementsByName("ordersn");
		var Shipping 	= document.getElementById('Shipping').value;
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("如果您不选择订单，将会打印当前分类下，所选择条件的所有订单");
		
		}
	
		var url	= "mod.php?bill="+bill+"&module=orders&ostatus=<?php echo $ostatus;?>&Shipping="+Shipping;
		window.open(url,"_blank");
		
	
	}
	
	function distribute(){
		
		var url		= "screenorder.php?module=orders";
		openwindow(url,'',550,385);
		}
		
		
		function distribute02(){
		
		var url		= "screenorder02.php?module=orders";
		openwindow(url,'',550,385);
		}
		
		
		function distribute03(){
		
		if(confirm('如果选择指定订单，将会对所选择的订单，进行配货, 如果是，请选择确认，如果不是请选择取消')){
		
		
			var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		var url		= "screenorder03.php?module=orders&bill="+bill;
		openwindow(url,'',550,385);
		
		}else{
		
		
		var url		= "screenorder03.php?module=orders";
		openwindow(url,'',550,385);
		}
		
		
		}
		
function eubtracknumber(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		var url		= "eubtracknumber.php?bill="+bill;
		openwindow(url,'',550,385);
	
	
	
	
	}
	
	function eubreapia4(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		alert("一次最多只能选择10个订单进行批量打印");
		
		var url		= "eubtracknumbera4.php?bill="+bill;
		openwindow(url,'',550,385);
	
	
	
	
	}
	
	function euba4pl(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		
		var url		= "eubtracknumbera420.php?bill="+bill;
		window.open(url,'_blank');
		
	
	
	
	
	}
	function euba42(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
	//	alert("一次最多只能选择10个订单进行批量打印");
		
		var url		= "eubtracknumbera42.php?bill="+bill;
		window.open(url);
	
	
	
	
	}
	
	
	
	function eubtracknumberv3rm(pagesize){
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
	//	alert("一次最多只能选择10个订单进行批量打印");
		var url		= "eubtracknumberrm.php?bill="+bill+"&pagesize="+pagesize;
		openwindow(url,'',550,385);
	}
	
function eubjy(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		var url		= "eubtracknumberjy.php?bill="+bill;
		openwindow(url,'',550,385);
	
	
	
	
	}


function eubreapi(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		var url		= "eubtracknumberrm.php?bill="+bill;
		openwindow(url,'',550,385);
	
	
	
	
	}

function eubre(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		var url		= "eubtracknumberre.php?bill="+bill;
		openwindow(url,'',550,385);
	
	
	
	
	}

		function disifan00(){
		
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;			
			}	
			
		}
		
	
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
	
		window.open("labeltodsf11.php?module=orders&ordersn="+bill,"_blank");
	
	}
function copyorders(bill){
		
	
		
		window.open("copyorders.php?ordersn="+bill);
	}
	

	
	function comorder(){
	
	
	if(confirm('您确认将当前订单分类下面的所有相同地址，相同地址的订单进行合并吗')){
	var url		= "comorder.php?ostatus=<?php echo $ostatus;?>";
	window.open(url,"_blank");	
	}
	
	
	
	
	
}

	function rta(ebayid,pid){
		
		
		
		var url		= 'rma.php?ebayid='+ebayid+"&pid="+pid;
	
		openwindow(url,'',800,685);
	
	
	
	}
	
		function euba4batch(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		
		var url		= "a4eubconfirm.php?bill="+bill;
		window.open(url);
		
	
	
	
	
	}
			function labeltoa4(){
	
	
	
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		
		var url		= "a4confirm.php?bill="+bill;
		window.open(url);
		
	
	
	
	
	}
	
	
	function displayselect(){
		
		var b	= 0;
		
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				b++;
				
			
			}	
			
		}
		
		document.getElementById('rows2').innerHTML="您已经选择 <font color=red>"+b+"</font> 条记录 ^_^";
		
		document.getElementById("filesidselect").selected=true;
		document.getElementById("orderoperationselect").selected=true;
		document.getElementById("printidselect").selected=true;
		
	
	
	}
	
	
	function exportstofiles(){
		
		var typevalue 	= document.getElementById('filesid').value;
		
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		
		if(typevalue == '') return false;
		
		if(bill == ""){
			alert("如果您不选择任何订单，则导出当前分类下的所有订单");
		}
		
		if(typevalue	== '0111'){
			var url		= "toxls/labelto0111.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '0117'){
			var url		= "labelto0117.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '0122'){
			var url		= "labelto0122.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '130226'){
			var url		= "labelto130226.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '1302261'){
			var url		= "labelto1302261.php?module=orders&type=1&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '1302263'){
			var url		= "labelto1302261.php?module=orders&type=3&ordersn="+bill;  // 发货清单
		}
		
		if(typevalue	== '1302266'){
			var url		= "labelto1302266.php?module=orders&type=3&ordersn="+bill;  // 发货清单
		}
		
		if(typevalue	== '130407'){
			var url		= "labelto130407.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '1302264'){
			var url		= "labelto1302264.php?module=orders&type=3&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '1302265'){
			var url		= "labelto1302265.php?module=orders&type=3&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '1304071'){
			var url		= "labelto1304071.php?module=orders&ordersn="+bill;  // 发货清单
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
		}
		
		if(typevalue	== '1304072'){
			var url		= "labelto1304072.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		
		if(typevalue	== '1302262'){
			var url		= "labelto1302262.php?module=orders&ordersn="+bill;  // 发货清单
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
		}
		if(typevalue	== '1302263'){
			var url		= "labelto1302263.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		
		if(typevalue	== '105'){
			var url		= "labelto1105.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '1051'){
			var url		= "labelto11051.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		
		
		if(typevalue	== '130426'){
			var url		= "labelto110511.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		
		
		if(typevalue	== '0131'){
			var url		= "labelto0131.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '01251'){
			var url		= "labelto01251.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '01252'){
			var url		= "labelto01252.php?module=orders&ordersn="+bill;  // 发货清单
		}
		if(typevalue	== '103'){
			var url		= "labelto1013.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		if(typevalue	== '1'){
			var url		= "labelto1001.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		if(typevalue	== '2'){
			var url		= "labelto1002.php?module=orders&ordersn="+bill;  // 发货清单
		}
		
		if(typevalue	== '3'){
			var url		= "labelto1003.php?module=orders&ordersn="+bill;  // 三态导出格式
		}
		
		if(typevalue	== '4'){
			var url		= "labelto1004.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== 'c1'){
			var url		= "labelto10c1.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== 'c2'){
			var url		= "labelto10c2.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== 'c3'){
			var url		= "labelto10c3.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== 'c4'){
			var url		= "labelto10c4.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '44'){
			var url		= "labelto10044.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '20'){
			var url		= "labelto1020.php?module=orders&ordersn="+bill;  // SalesHistory csv 导出
		}
		
		
		if(typevalue	== '2020'){
			var url		= "labelto102020.php?module=orders&ordersn="+bill;  // SalesHistory csv 导出
		}
		
		
		
		if(typevalue	== '5'){
			var url		= "labelto1005.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // ebay csv 导出
			
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			
		}
		if(typevalue	== '0108'){
			var url		= "labelto0108.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // ebay csv 导出
			
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			
		}
		
		
		if(typevalue	== '0109'){
			var url		= "toxls/labelto0108.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // ebay csv 导出
			
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			
		}
		if(typevalue	== '0110'){
			var url		= "toxls/labelto0110.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // ebay csv 导出
			
		}
		
		if(typevalue	== '104'){
			var url		= "labelto1104.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // ebay csv 导出
			
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			
		}
		
		if(typevalue	== '6'){
			var url		= "labelto1006.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";
			
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			
		}
		
		if(typevalue	== '7'){
			var url		= "labelto1007.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '8'){
			var url		= "labelto1008.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '100'){
			var url		= "labelto1011.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '101'){
			var url		= "print/labelto1101.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '102'){
			var url		= "labelto1102.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '9'){
			var url		= "labelto1009.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '10'){
			var url		= "labelto1010.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '11'){
			var url		= "labelto1011.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '12'){
			var url		= "print/labelto1013y.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '108'){
			var url		= "labelto10107.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '111'){
			var url		= "labelto1019.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '112'){
			var url		= "toxls/labelto10112.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '130417'){
			var url		= "toxls/labelto130417.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '15'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto1015.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '15'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto1015.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '156'){
			var url		= "labelto10156.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '157'){
			var url		= "labelto1001xx.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		
		
		if(typevalue	== '106'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto1017.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '11311'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto11311.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '130413'){
			var url		= "toxls/labelto130413.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '130418'){
			var url		= "toxls/labelto130418.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '130419'){
			var url		= "toxls/labelto130419.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '130420'){
			var url		= "toxls/labelto130420.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '130422'){
			var url		= "toxls/labelto130422.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
		if(typevalue	== '130423'){
			var url		= "toxls/labelto130423.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '130424'){
			var url		= "toxls/labelto130424.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		
			if(typevalue	== '130425'){
			var url		= "toxls/labelto130425.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		

		if(typevalue	== '130421'){
			var url		= "toxls/labelto130421.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}

	if(typevalue	== '1304218'){
			var url		= "labelto13040728.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}

		
		if(typevalue	== '113'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto1113.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '1131'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto11131.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '112601'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto112601.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '112701'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行\n条形码显示需要下载C39HrP24DhTt字体到控制面板中');
			var url		= "labelto112701.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '110'){
			alert('文件导出后，您需要全先，右键 - 设置单格格式 - 对齐 - 选择自动换行');
			var url		= "labelto1018.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '116'){
			var url		= "labelto1106.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '92101'){
			var url		= "labelto92101.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '92102'){
			var url		= "labelto92102.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
				if(typevalue	== '92103'){
			var url		= "labelto92103.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '107'){
			var url		= "labelto1016.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // ebay csv 导出
		}
		
		if(typevalue	== '1329'){
			var url		= "printlabel1329.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		if(typevalue	== '999'){
			var url		= "toxls/labelto1020csv.php?module=orders&ordersn="+bill;  // SalesHistory csv 导出
		}
		
		
		
		
		if(typevalue	== '130415'){
			var url		= "toxls/labelto130415.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
	
		if(typevalue	== '130416'){
			var url		= "toxls/labelto130416.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		window.open(url,'_blank');
		
	
	
	}
	
	function printtofiles(){
		
		var typevalue 	= document.getElementById('printid').value;
		var Shipping 	= document.getElementById('Shipping').value;
		if(typevalue == '') return false;
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			//alert("如果您不选择订单，将会打印当前分类下，所选择条件的所有订单");
		
		}
		
		if(typevalue	== '247'){
			var url		= "printlabel247.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		if(typevalue	== '248'){
			var url		= "printlabel248.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		if(typevalue	== '249'){
			var url		= "printlabel249.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		if(typevalue	== '18'){
			var url		= "printlabel1018.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		if(typevalue	== '181'){
			var url		= "printlabel10181.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		if(typevalue	== '1812'){
			var url		= "printlabel101812.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		
			if(typevalue	== '18144'){
			var url		= "printlabel101812144.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		
		
		
		if(typevalue	== '1813'){
			var url		= "printlabel101813.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		
		if(typevalue	== '244'){
			var url		= "printlabel1018244.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		if(typevalue	== '1'){
			var url		= "printlabel1001.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		if(typevalue	== '121001'){
			var url		= "printlabel121001.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		if(typevalue	== '2'){
			var url		= "printlabel1002.php?module=orders&ordersn="+bill;  // 国际EUB A4打印
		}
		
		if(typevalue	== '3'){
			var url		= "printlabel1003.php?module=orders&ordersn="+bill;  // 国际EUB热敏打印
		}
		
		if(typevalue	== '4'){
			var url		= "printlabel1004.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		if(typevalue	== '241'){
			var url		= "printlabel10024.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		if(typevalue	== '305'){
			var url		= "printlabel10305.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		if(typevalue	== '40'){
			var url		= "printlabel1040.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		if(typevalue	== '41'){
			var url		= "printlabel1041.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		if(typevalue	== '441'){
			var url		= "printlabel10441.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		
		
		if(typevalue	== '42'){
			var url		= "printlabel1042.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		if(typevalue	== '182'){
			var url		= "printlabel1182.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
		}
		
		if(typevalue	== '5'){
			var url		= "printlabel1005.php?module=orders&ordersn="+bill;  // 国际eub发货清单
		}
		if(typevalue	== '55'){
			var url		= "printlabel1055.php?module=orders&ordersn="+bill;  // 国际eub发货清单
		}
		
		
		if(typevalue	== '6'){
			var url		= "printlabel1006.php?module=orders&ordersn="+bill;  // 国际eub发货清单
		}
		
		if(typevalue	== '7'){
			var url		= "printlabel1007.php?module=orders&ordersn="+bill;  // 地址打印每页10个
		}
		
		if(typevalue	== '8'){
			var url		= "printlabel1008.php?module=orders&ordersn="+bill;  // 一页8个，带sku和条码
		}
		
		if(typevalue	== '9'){
			var url		= "printlabel1009.php?module=orders&ordersn="+bill;  // 一页8个，带sku和条码
		}
		
		if(typevalue	== '10'){
			var url		= "printlabel1010.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		
		if(typevalue	== '245'){
			var url		= "printlabel10245.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '246'){
			var url		= "labelto3002.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '11'){
			var url		= "printlabel1011.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		if(typevalue	== '12'){
			var url		= "printlabel1012.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		
		if(typevalue	== '13'){
			var url		= "printlabel1013.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		
		if(typevalue	== '14'){
			var url		= "printlabel1014.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '15'){
			var url		= "printlabel1015.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		if(typevalue	== '141'){
			var url		= "printlabel10141.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '151'){
			var url		= "printlabel10151.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '16'){
			var url		= "packslipnew.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '13331'){
			var url		= "printlabel1333.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '13332'){
			var url		= "printlabel13331.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		if(typevalue	== '130413'){
			var url		= "toxls/printlabel130413.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		if(typevalue	== '17'){
			var url		= "printlabel1017.php?module=orders&ordersn="+bill;  // 拣货清单+条码
		}
		
		if(typevalue	== '20'){
			alert('请设置打印格式  左右边距8 上下5');
			var url		= "printlabel1020.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
		if(typevalue	== '19'){
			var url		= "printlabel1019.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
		if(typevalue	== '0314'){
			var url		= "printlabel130314.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
		if(typevalue	== '03141'){
			var url		= "printlabel1303141.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
		
		
		
		if(typevalue	== '0315'){
			var url		= "printlabel10195.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
		
		
		
		
		if(typevalue	== '0116'){
			var url		= "printlable0116.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
				if(typevalue	== '21'){
			var url		= "printlabel1030.php?module=orders&ordersn="+bill+"&ostatus=<?php echo $ostatus;?>";  // 拣货清单+条码
		}
	  if(typevalue	== '22'){
	        var url		= "printlabel1022.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
   }
   if(typevalue	== '222'){
	        var url		= "printlabel10222.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
   }
	  if(typevalue	== '23'){
	        var url		= "printlabel1023.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
 }
	if(typevalue	== '24'){
	        var url		= "curltest.php?ebay_id="+bill+"type=print_a4";  // 燕文a4
	}
	if(typevalue	== '25'){
	        var url		= "curltest.php?ebay_id="+bill+"type=print_a5";  // 燕文a5
	}
	if(typevalue	== '26'){
	        var url		= "curltest.php?ebay_id="+bill+"type=print_a6";  // 燕文a6
	}
		if(typevalue	== '27'){
	        var url		= "printlabel1033.php?ebay_id="+bill;  // 燕文a6
	}
	
	
			if(typevalue	== '183'){
			var url		= "printlabel1183.php?module=orders&ordersn="+bill+"&Shipping="+Shipping+"&ostatus=<?php echo $ostatus;?>";  // 发货清单
			
			
	}
	
	
	
		if(typevalue	== '130414'){
			var url		= "toxls/labelto130414.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '130415'){
			var url		= "toxls/print130415.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
		if(typevalue	== '130416'){
			var url		= "toxls/print130416.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
		
	if(typevalue	== '130417'){
			var url		= "toxls/print130417.php?module=orders&ordersn="+bill;  // ebay csv 导出
		}
	
		window.open(url,'_blank');
		
	
	
	
	}	
	
	function bookhackorer(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		var count	= 0;
		
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = checkboxs[i].value;
				count++;
				
			}	
		}
		
		if(count>=2){
			alert("一次只能操作一个订单");
			return false;
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		
		openwindow("bookbackorer.php?ordersn="+bill,'',550,385);
	}
	
	
	function addoutorder(){
	
		
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			alert("请选择订单");
		}
		var url	= "battchtoaddoutorder.php?bill="+bill;
		if(confirm("您确认将这些订单标记出库吗")){
			window.open(url,"_blank");
		}
	
	
	}
	function	applycode(){

		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		 if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		 }
		
		var url="addcode.php?module=orders&bill="+bill;
			openwindow(url,'',550,385);
	}	
	function posttoyanwen(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
		
		
		var url		= "curltest.php?ebay_id="+bill+"&type=create";
		openwindow(url,'',300,200);
	}
	
	function eubtracknumberv3(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "eubtracknumberv3.php?bill="+bill;
		openwindow(url,'',550,385);
	}
	
	function hkeub(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "hkeub.php?bill="+bill;
		openwindow(url,'',550,385);
	}
	
	
	function pxsubmit(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "orderonline_test.php?type=creat&bill="+bill;
		openwindow(url,'',550,385);
	}
	function exportdelivery(){
	
	var start		= document.getElementById('start').value;
	var end			= document.getElementById('end').value;
	
	var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			
			alert("如果不选择订单则，则导出当前分类下的所有订单");
			//return false;
		}
		var url		= "exporttodelivery.php?bill="+bill+"&ostatus=<?php echo $ostatus;?>&start="+start+"&end="+end;
		openwindow(url,'',550,385);
}
function salereport(){
	var start = document.getElementById("start").value;
	var end = document.getElementById("end").value;
	var acc = document.getElementById("acc").value;
	var url  = "salesreporttoxls.php?ostatus=<?php echo $ostatus;?>&start="+start+"&end="+end+"&acc="+acc;
	window.open(url,"_blank");
}
	
	function eubv3jy(){
	
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "eubtracknumberjyv3.php?bill="+bill;
		openwindow(url,'',550,385);
	}
	
	function canceleubtracknumber(){
	
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "canceleubtracknumber.php?bill="+bill;
		openwindow(url,'',550,385);
	
	
	
	}
		var mstatusid = '';
	function savesku(id){
		var skuvalue		= document.getElementById('sku'+id).value;
		var url				= "getajax2.php";
		var param			= "type=changesku&id="+id+"&sku="+skuvalue;
		mstatusid			=  id;
		sendRequestPost(url,param);
		
		
	}
	
	
	
	
    function sendRequestPost(url,param){
        createXMLHttpRequest();  
        xmlHttpRequest.open("POST",url,true); 
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        xmlHttpRequest.onreadystatechange = processResponse; 
        xmlHttpRequest.send(param); 
    }  
    //处理返回信息函数 
    function processResponse(){
        if(xmlHttpRequest.readyState == 4){  
            if(xmlHttpRequest.status == 200){  
                var res = xmlHttpRequest.responseText;
				if(res == '0'){
				document.getElementById('mstatus'+mstatusid).innerHTML="<font color=Green>Success</font>";
				document.getElementById('sku'+mstatusid).focus();
				}else{
				document.getElementById('mstatus'+mstatusid).innerHTML="<font color=red>Failure</font>";
				}
				
			//	document.getElementById('content'+msid).value = res;
            }
		//	
        }  

    }
	
	
	var xmlHttpRequest;  
    function createXMLHttpRequest(){  
    try  
        {  
        xmlHttpRequest=new XMLHttpRequest();  
        }  
     catch (e)  
        {  
       try  
          {  
           xmlHttpRequest=new ActiveXObject("Msxml2.XMLHTTP");  
          }  
       catch (e)  
          {  
          try  
             {  
              xmlHttpRequest=new ActiveXObject("Microsoft.XMLHTTP");  
             }  
          catch (e)  
             {  
             alert("您的浏览器不支持AJAX！");  
             return false;  
             }  

          }  

        }  
    } 
	
	
	document.onkeydown=function(event){
  e = event ? event :(window.event ? window.event : null);
  if(e.keyCode==13){
 searchorder();
  }
 }
 	function creatordereubxx(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "eubxx.php?bill="+bill+"&type=creat";
		openwindow(url,'',550,385);
	}
	
	 	function xxeub(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "eubxxtest.php?bill="+bill+"&type=creat";
		openwindow(url,'',550,385);
	}
	
	
	
	function deleubxx(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "eubxx.php?bill=,"+bill+"&type=del";
		openwindow(url,'',550,385);
	}
	function printeubxx(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "eubxx.php?bill="+bill+"&type=print";
		window.open(url,'_blank');
	}
	
	function eubtracknumberv3rmHK(pagesize){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
			
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;
		
		}
	//	alert("一次最多只能选择10个订单进行批量打印");
		var url		= "eubtracknumberrmHK.php?bill="+bill+"&pagesize="+pagesize;
		openwindow(url,'',550,385);
	}
	function submit4px(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		if(confirm('确定上传并确认吗')){
		
			window.open("test4px.php?ebay_id="+bill,"_blank");

		}
	}
	
	
	function submit4pxV2(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		if(confirm('确定上传并确认吗')){
		
			window.open("test4pxV2.php?ebay_id="+bill,"_blank");

		}
	}
	
	
	function submit4pxstatus(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		window.open("status4px.php?type=status&ebay_id="+bill,"_blank");
	}
	
	
	
	function submit4pxstatusV2(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		window.open("status4pxV2.php?type=status&ebay_id="+bill,"_blank");
	}
	
	
	
	function check4pxfee(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = checkboxs[i].value;
			
			}	
			
		}
		window.open("status4px.php?type=orderfee&id="+bill,"_blank");
	}
	
	function submitcky(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		if(confirm('确定上传并确认吗')){
		
			window.open("OutStoreAddOrder.php?ebay_id="+bill,"_blank");

		}
	}
	function tracknumbercky(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		
		window.open("OutStoreAddOrder1.php?ebay_id="+bill,"_blank");

	}
	function submitm2c(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		if(confirm('确定上传并确认吗')){
		
			window.open("M2cAddorder.php?ebay_id="+bill,"_blank");

		}
	}
	function tracknumberm2c(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		
		window.open("M2cAddordr2.php?ebay_id="+bill,"_blank");

	}
	
	function submitzx(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		if(confirm('确定上传并确认吗')){
		
			window.open("ExpressAddorderNew.php?ebay_id="+bill,"_blank");

		}
	}
	function tracknumberzx(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill==''){
		alert('请选择订单');
		return false;
		}
		
		window.open("ExpressGetPackage.php?ebay_id="+bill,"_blank");

	}
	function invoicexby(){
		var bill	= "";
	
		window.open("invoicexby.php?ebay_id="+bill,"_blank");

	}
	
	
	function orderoperation(type){
	
		var typevalue 	= document.getElementById('orderoperation').value;
		
		if(typevalue == '0') ordermarkprint('add');
		if(typevalue == '1') ordermarkprint('del');
		if(typevalue == '2') combine();
		if(typevalue == '3') comorder();
		if(typevalue == '4') location.href='ordermodifive.php?module=orders&type=addorder&action=Add new Order';
		if(typevalue == '5') location.href='ordersumaitongupload.php?module=orders&amp;type=addorder&amp;action=速买通导入模板';
		if(typevalue == '6') location.href='orderukupload.php?module=orders&amp;type=addorder&amp;action=Amazon';
		if(typevalue == '7') location.href='orderuploadloader.php?module=orders&amp;type=addorder&amp;action=Amazon';
		if(typevalue == '43') location.href='orderuploadloaderCSV.php?module=orders&amp;type=addorder&amp;action=Amazon';
				if(typevalue == '44') location.href='orderuploadloader22.php?module=orders&amp;type=addorder&amp;action=Amazon';

		if(typevalue == '8') location.href='salehistoryupload.php?module=orders&amp;type=addorder&amp;action=ebay csv导入';
		if(typevalue == '36') location.href='orderupload2.php?module=orders&amp;type=addorder&amp;action=自定义模板 csv导入';
		if(typevalue == '37') location.href='orderupload3.php?module=orders&amp;type=addorder&amp;action=测试1 csv导入';
		if(typevalue == '9') pimod();
		if(typevalue == '10') eubtracknumberv3();
		if(typevalue == '11') eubv3jy();
		if(typevalue == '12') eubtracknumberv3rm(1);
		if(typevalue == '13') eubtracknumberv3rm(0);
		if(typevalue == '14') canceleubtracknumber();
		if(typevalue == '15') eubre();
		if(typevalue == '16') creatordereubxx();
		if(typevalue == '17') deleubxx();
		if(typevalue == '18') printeubxx();
		if(typevalue == '19') hkeub();
		if(typevalue == '20') eubtracknumberv3rmHK(0);
		if(typevalue == '21') eubtracknumberv3rmHK(1);
		if(typevalue == '22') eubtracknumberv3rmHK(2);
		if(typevalue == '23') eubtracknumberv3rmHK(3);
		if(typevalue == '24') pxsubmit();
		
		
		
		if(typevalue == '25') submit4px();
		if(typevalue == '26') submit4pxstatus();
		if(typevalue == '27') check4pxfee();
		
		
		if(typevalue == '225') submit4pxV2();
		if(typevalue == '226') submit4pxstatusV2();
		if(typevalue == '227') check4pxfeeV2();
		
		
		
		
		if(typevalue == '28') submitcky();
		if(typevalue == '29') tracknumbercky();
		if(typevalue == '30') submitm2c();
		if(typevalue == '31') tracknumberm2c();
		if(typevalue == '32') submitzx();
		if(typevalue == '33') tracknumberzx();
		if(typevalue == '34') stsubmit();
		if(typevalue == '35') pxsubmitv2();

		if(typevalue == '38') uspsapplytracknumber();
		if(typevalue == '39') uspsapplyprint();
		
		if(typevalue == '40') wytapi('create');
		if(typevalue == '41') wytapi('delete');
		if(typevalue == '42') wytapi('track');
		
		
		if(typevalue == '45') blsapi('track');
		if(typevalue == '46') blsapi('label');
		if(typevalue == '47') blsapi('invoice');
		if(typevalue == '48') blsapi('toxls');
		
		
		
		if(typevalue == '49') ywapi('track');
		
		if(typevalue == '50') ywapi('A4');
		if(typevalue == '51') ywapi('CnMiniParcel10x10');
		if(typevalue == '52') ywapi('LI10x10');
		if(typevalue == '53') ywapi('tracknumber');
		


		if(typevalue == '54') ydapi('export');
		if(typevalue == '55') ydapi('tracknumber');
		

		

	}

function ydapi(type){

		
		
		if(type == 'export'){
			
			var url		= "orderdregister.php?type=creat&type="+type;
		
		}else{
			
			
					var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
			
			var url		= "addcode.php?type=creat&bill="+bill+"&type="+type;
		}
				

		
		openwindow(url,'',550,385);
	}

	
	function ywapi(type){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		
		
		if(type == 'track'){
			
			var url		= "yw_applyorder.php?type=creat&bill="+bill+"&type="+type;
		
		}else{
			
			var url		= "yw_applyorder.php?type=creat&bill="+bill+"&type="+type;
		}
		
		
		
		
		if(type == 'tracknumber') var url		= "yw_applyorder.php?type=tracknumber&bill="+bill+"&type="+type;
		

		
		openwindow(url,'',550,385);
	}
	
	
	function uspsapplytracknumber(type){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "usps_applytracknumber.php?type=creat&bill="+bill+"&type="+type;
		openwindow(url,'',550,385);
	}
	
	
	
	
	function wytapi(type){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "wytapi_applyorder.php?type=creat&bill="+bill+"&type="+type;
		openwindow(url,'',550,385);
	}
	
	function blsapi(type){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		
		
		
		if(type == 'track'){
			
			var url		= "blsapi_applyorder.php?type=creat&bill="+bill+"&type="+type;
		}
		
		if(type == 'label'){
			
			var url		= "printlabel123112.php?type=creat&bill="+bill+"&type="+type;
		}
		
		
		if(type == 'invoice'){
			
			var url		= "printlabel12312.php?type=creat&bill="+bill+"&type="+type;
		}
		
		if(type == 'toxls'){
			
			var url		= "labelto130222.php?type=creat&ordersn="+bill+"&type="+type;
		}
		openwindow(url,'',550,385);
	}

	function uspsapplyprint(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "print/usps_print01.php?type=creat&bill="+bill;
		openwindow(url,'',550,385);
	}

	function pxsubmitv2(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "orderonline_testv2.php?type=creat&bill="+bill;
		openwindow(url,'',550,385);
	}
	
	function stsubmit(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择订单号");
			return false;
		}
		var url		= "Sfcaddorder.php?bill="+bill+"&type=creat";
		window.open(url,"_blank");
	}
	
	
	
	function labelto003(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;
			
			}				
		}

		alert("提示：如果不选择任何订单，将会导出当前分类下的所有订单");
		
		alert("提示：\n\r全选，在点击鼠标右键，选择设置单元格格式-》选择对齐=》选择自动换行=》选择确定，就可看到您想要的格式。")
		window.open("labelto003.php?ordersn="+bill+"&ostatus=<?php echo $ostatus;?>","_blank");	
	}	
		
		function labeltocg(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){				
				bill = bill + ","+checkboxs[i].value;
			
			}				
		}
		
		alert("提示：如果不选择任何订单，将会导出当前分类下的所有订单");
		
		window.open("labeltocg.php?ordersn="+bill+"&ostatus=<?php echo $ostatus;?>","_blank");	
	}
	
	
	
	
</script>