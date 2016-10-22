<?php

include "include/config.php";





include "top.php";





$ostatus		= $_REQUEST['ostatus']?$_REQUEST['ostatus']:"0";

$keys			= $_REQUEST['keys']?trim($_REQUEST['keys']):"";

$sku			= $_REQUEST['sku']?trim($_REQUEST['sku']):"";

$account		= $_REQUEST['account'];

$type			= $_REQUEST['type'];

$sort			= $_REQUEST['sort']?$_REQUEST['sort']:'';

$sortstatus		= $_REQUEST['sortstatus']?$_REQUEST['sortstatus']:0;

$sortdefault	= 0;



if($sort == 'recordnumber'){

	

	

	if($sortstatus  == '0'){

	

		$sortstr	= " order by a.recordnumber desc";

		$sortstatus = 1;

		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

		

	}else{

	

		$sortstr	= " order by a.recordnumber asc";

		$sortstatus	= 0;

		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

	}



}



if($sort == 'ebay_userid'){

	

	

	if($sortstatus  == '0'){

	

		$sortstr	= " order by a.ebay_userid desc";

		$sortstatus = 1;

		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

		

	}else{

	

		$sortstr	= " order by a.ebay_userid asc";

		$sortstatus	= 0;

		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

	}



}




if($sort == 'ebay_shipfee'){

	

	

	if($sortstatus  == '0'){

	

		$sortstr	= " order by a.ebay_shipfee desc";

		$sortstatus = 1;

		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

		

	}else{

	

		$sortstr	= " order by a.ebay_shipfee asc";

		$sortstatus	= 0;

		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

	}



}



if($sort == 'ebay_total'){

	

	

	if($sortstatus  == '0'){

	

		$sortstr	= " order by a.ebay_total desc";

		$sortstatus = 1;

		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

		

	}else{

	

		$sortstr	= " order by a.ebay_total asc";

		$sortstatus	= 0;

		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

	}



}



if($sort == 'ebay_createdtime'){

	

	

	if($sortstatus  == '0'){

	

		$sortstr	= " order by a.ebay_createdtime desc";

		$sortstatus = 1;

		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

		

	}else{

	

		$sortstr	= " order by a.ebay_createdtime asc";

		$sortstatus	= 0;

		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

	}



}



if($sort == 'ebay_paidtime'){

	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_paidtime desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_paidtime asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'onumber'){

	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_id desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_id asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'ShippedTime'){

	

	

	if($sortstatus  == '0'){

	

		$sortstr	= " order by a.ShippedTime desc";

		$sortstatus = 1;

		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

		

	}else{

	

		$sortstr	= " order by a.ShippedTime asc";

		$sortstatus	= 0;

		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";

		

	}



}





if($sort == ''  ){

	

	
	if($sortstatus  == '0'){
		$sortstr	= " order by a.ebay_id desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='../images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ebay_id desc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='../images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}

}






function getresultcount($status){



	global $dbcon,$user;

	

	$sql	= "select count(*) as cc from ebay_order where ebay_status='".$status."' and ebay_user='$user' and ebay_combine!='1'";

	

	

	$sql	= $dbcon->execute($sql);

	$sql	= $dbcon->getResultArray($sql);

	return  $sql[0]['cc'];

	$dbcon->close();

	





}













if($type 	== "del"){

	

	$ordersn = explode(",",$_REQUEST['ordersn']);

	$cstatus = $_REQUEST['cstatus'];

	

	$status  = "";

	for($g=0;$g<count($ordersn);$g++){

		

		

		$sn 	=  $ordersn[$g];



		if($sn != ""){

			

			$sql		= "update ebay_order set ebay_status='$cstatus' where ebay_ordersn='$sn'";

		

			

			

		if($dbcon->execute($sql)){

	

	

					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";



	}else{

	



					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";



	}



			

		}

	}

	

}





if($type 	== "delsystem"){

	

	$ordersn 		= explode(",",$_REQUEST['ordersn']);
	$changestatus 	= $_REQUEST['changestatus'];
	

	$status  = "";

	for($g=0;$g<count($ordersn);$g++){

		

		

		$sn 	=  $ordersn[$g];



		if($sn != ""){

			
			

				
				$sql		= "update ebay_order set isprint='1' where ebay_id ='$sn'";
			
			
	


		if($dbcon->execute($sql)){

	

	

					$status	= " -[<font color='#33CC33'>操作记录: 操作成功</font>]";



	}else{

	



					$status = " -[<font color='#FF0000'>操作记录: 操作失败</font>]";



	}



			

		}

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





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

		

	<td nowrap="nowrap" scope="row" ><!--

               <input type="button" value="打印地址A4" onClick="detail2()">

               <input type="button" value="Label标签打印" onclick="detail3()" />--><!--
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
          -->
          
            ID/Name/Country/Email：

<input name="keys" type="text" size="10" id="keys" value="<?php echo $keys ?>">

                    Custom Label/Item Number：

                    <input name="sku" type="text" id="sku"> 

                    <br />

    <select name="acc" id="acc" onchange="changeaccount()">

                      <option value="">帐号</option>

                      <?php 

					

					$sql	 = "select * from ebay_account where ebay_user='$user'";

					$sql	 = $dbcon->execute($sql);

					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$acc	= $sql[$i]['ebay_account'];

					 ?>

                      <option value="<?php echo $acc;?>" <?php if($account == $acc) echo "selected=selected" ?>><?php echo $acc;?></option>

                      <?php } ?>
                      
                      
                       <option value="淘宝"  	<?php if($account == '淘宝') echo "selected=selected" ?>>淘宝</option>
                    <option value="速卖通" 	<?php if($account == '速卖通') echo "selected=selected" ?>>速卖通</option>
                    <option value="阿里巴巴" <?php if($account == '阿里巴巴') echo "selected=selected" ?>>阿里巴巴</option>
                    <option value="亚马逊"  <?php if($account == '亚马逊') echo "selected=selected" ?>>亚马逊</option>
                    <option value="网站" 	<?php if($account == '网站') echo "selected=selected" ?>>网站</option>
                    <option value="美国订单" 	<?php if($account == '美国订单') echo "selected=selected" ?>>美国订单</option>
            </select>


            <select name="country" id="country" onchange="changeaccount()">
              <option value=""> 选择国家</option>
              <?php 

					

					$sql	 = "select distinct ebay_countryname from ebay_order where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$ebay_countryname	= $sql[$i]['ebay_countryname'];
					 ?>
              <option value="<?php echo $ebay_countryname;?>" ><?php echo $ebay_countryname;?></option>
              <?php } ?>
            </select>
            <select name="Shipping" id="Shipping" >
              <option value="">运送方式</option>
              <?php 

					

					$sql	 = "select * from ebay_carrier where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$name	= $sql[$i]['name'];
					 ?>
              <option value="<?php echo $name;?>" ><?php echo $name;?></option>
              <?php } ?>
            </select>
            
            发出开始:
            <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start0;?>" /> 
            发出结束:
            <input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $start1;?>" />
            <select name="ebay_ordertype" id="ebay_ordertype">
              <option value="-1" >订单类型</option>
              <?php

							$tql	= "select * from ebay_ordertype where ebay_user = '$user'";
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
            <input type="button" value="查找" onClick="searchorder()">

                    

                    

                    

                    

    

    

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" value="一键确认" onclick="confirmorderprofit()" /></td></tr>
</table>

</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td colspan='23'><div id="rows"></div> 		  </td>
	</tr><tr height='20'>

					<th nowrap="nowrap" scope='col'>

				<div style='white-space: nowrap;'width='100%' align='left'>

				  <input name="ordersn2" type="checkbox" id="ordersn2" value="<?php echo $ordersn;?>" onClick="check_all('ordersn','ordersn')" />
		</div></th>

			
					<th nowrap="nowrap" scope='col'>订单号</th>
					<th nowrap="nowrap" scope='col'><span style="white-space: nowrap;"><a href="orderindexly.php?module=finance&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=recordnumber&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>"><font color="#0033FF">Record No</font></a></span>

                    <?php if($sort == 'recordnumber') echo $sortsimg; ?>                    </th>

					<th width="5%" nowrap="nowrap" scope='col'>

				<div style='white-space: nowrap;'width='100%' align='left'>eBay Account</div></th>

			

					<th width="10%" nowrap="nowrap" scope='col'>

				<div style='white-space: nowrap;'width='100%' align='left'><a href="orderindexly.php?module=finance&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_userid&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>"><font color="#0033FF">Buyer ID</font></a>

				  <?php if($sort == 'ebay_userid') echo $sortsimg; ?>
				</div>			</th>
        <th scope='col' nowrap="nowrap">Country</th>

        <th scope='col' nowrap="nowrap">挂号</th>
        <th scope='col' nowrap="nowrap">Shipping</th>
        <th scope='col' nowrap="nowrap">SKU</th>
        <th scope='col' nowrap="nowrap"><a href="orderindexly.php?module=finance&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_total&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>"><font color="#0033FF">总价</font></a><?php if($sort == 'ebay_total') echo $sortsimg; ?>&nbsp;</th>

					<th scope='col' nowrap="nowrap">

				<div style='white-space: nowrap;'width='100%' align='left'><a href="orderindexly.php?module=finance&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ebay_paidtime&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>"><font color="#0033FF">Paid	Date</font></a><?php if($sort == 'ebay_paidtime') echo $sortsimg; ?></div>			</th>

			

		            <th scope='col' nowrap="nowrap"><a href="orderindexly.php?module=finance&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&sort=ShippedTime&sortstatus=<?php echo $sortstatus;?>&account=<?php echo $account;?>"><font color="#0033FF">Shipped Date</font></a><?php if($sort == 'ShippedTime') echo $sortsimg; ?></th>

        <th scope='col' nowrap="nowrap"><strong>电子称重量</strong></th>
        <th scope='col' nowrap="nowrap"><strong>采购价</strong></th>
        <th scope='col' nowrap="nowrap"><strong>运费列</strong></th>
        <th scope='col' nowrap="nowrap">毛利/毛利率</th>
	    <th scope='col' nowrap="nowrap">操作</th>
	</tr>

		





			  <?php

			  	

				

			  	


					

					$sql		= "select * from ebay_order as a where ebay_user='$user' and ebay_status='2' and ebay_combine!='1'";


		

				$tj = "";

				

				if($keys != ""){

					

					$tj	= " and (ebay_userid like '%$keys%' or ebay_ordersn like '%$keys%' or ebay_username like '%$keys%' or ebay_countryname like '%$keys%' or ebay_usermail like '%$keys%' or recordnumber like '%$keys%' or ebay_id like '%$keys%' or ebay_id like '%$keys%')";	

					$sql .= $tj;

					

				}

			

				

				if($account !="") $sql.= " and a.ebay_account='$account'";
				
				$start	= $_REQUEST['start'];
				$end	= $_REQUEST['end'];
				
				if($start !='' && $end != ''){
					
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql	.= " and (a.ebay_markettime>=$st00 and a.ebay_markettime<=$st11)";
					
				
				
				}
				
				
				$refundtimeend				= $_REQUEST['refundtimeend'];
				$refundtimestart			= $_REQUEST['refundtimestart'];
				if($refundtimeend !='' && $refundtimestart != ''){
					$st00	= strtotime($refundtimestart." 00:00:00");
					$st11	= strtotime($refundtimeend." 23:59:59");
					$sql	.= " and (a.refundtime>=$st00 and a.refundtime<=$st11)";
				}
				
				
				$resendtimestart				= $_REQUEST['resendtimestart'];
				$resendtimesend					= $_REQUEST['resendtimesend'];
				if($resendtimestart !='' && $resendtimesend != ''){
					$st00	= strtotime($resendtimestart." 00:00:00");
					$st11	= strtotime($resendtimesend." 23:59:59");
					$sql	.= " and (a.resendtime>=$st00 and a.resendtime<=$st11)";
				}
				
		

				$ebay_ordertype		= $_REQUEST['ebay_ordertype'];
				if($ebay_ordertype !='' && $ebay_ordertype !='-1') $sql.=" and a.ebay_ordertype='$ebay_ordertype'";

				$country		= $_REQUEST['country'];

				$note			= $_REQUEST['note'];

				if($country !='') $sql.=" and a.ebay_countryname='$country'";

				if($note !='' && $note == '1') 	$sql.=" and a.ebay_note	!=''";
				$shipping		= $_REQUEST['shipping'];
				if($shipping !='') $sql.=" and a.ebay_carrier='$shipping'";

	

			
				$profitstatus=		$_REQUEST['profitstatus'];
				
			
		




				

				

				if($sku	!= ""){

				

				if($ostatus == 100){

				

					$sql	= "select a.*,b.ebay_id as ddd from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where (b.sku like '%$sku%' or b.ebay_itemid like '%$sku%' or b.ebay_itemtitle like '%$sku%')  and a.ebay_user='$user' and a.ebay_combine!='1'";

				}else{

					

					$sql	= "select a.*,b.ebay_id as ddd from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where (b.sku like '%$sku%' or b.ebay_itemid like '%$sku%' or b.ebay_itemtitle like '%$sku%') and a.ebay_status=$ostatus and a.ebay_user='$user' and a.ebay_combine!='1'";

					

				

				}

				

					

					

				

				}

				

				

				

				if($sort == 'sku'){

				

					

					if($ostatus == 100){

				

					$sql	= "select a.*,b.ebay_id as ddd from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_user='$user' ";

				}else{

					

					$sql	= "select a.*,b.ebay_id as ddd from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='$ostatus'";

					

				

				

				

				}

				}
			
			$sql	.= " and  a.ordertype is null ";
			$sql	.= " and  a.profitstatus ='$profitstatus'  ";
			
			if($sku	!= ""){
				
				$sql .= " group by ebay_id order by ebay_id desc ";
				
			}else{
				
				$sql .= $sortstr;
				
			}
			
			
			 

			


				

				

				$query		= $dbcon->query($sql);

				$total		= $dbcon->num_rows($query);

				$totalpages = $total;

				

				

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

		

				

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;

				$sql		= $dbcon->execute($sql);

				$sql		= $dbcon->getResultArray($sql);

				$dpage		= 0;


				for($i=0;$i<count($sql);$i++){
					
	
					
					

					$noteb		= $sql[$i]['ebay_noteb']?$sql[$i]['ebay_noteb']:"";

					$is_reg		= $sql[$i]['is_reg']?$sql[$i]['is_reg']:"0";

					

					$ebayid		= $sql[$i]['ebay_id'];
					$ebay_ordertype		= $sql[$i]['ebay_ordertype'];
					

					$ebay_ptid	= $sql[$i]['ebay_ptid'];
					$ordersn	= $sql[$i]['ebay_ordersn'];

					$userid		= $sql[$i]['ebay_userid'];

					$username	= $sql[$i]['ebay_username'];

					$email		= $sql[$i]['ebay_usermail'];

					$total		= $sql[$i]['ebay_total'];

					$currency	= $sql[$i]['ebay_currency'];

					$paidtime	= $sql[$i]['ebay_paidtime'];

					$ebay_combine	= $sql[$i]['ebay_combine'];
					
$orderweight2	= $sql[$i]['orderweight2'];
					
					$orderweight		= 		 $sql[$i]['orderweight'];
					$ordershipfee		= 		 $sql[$i]['ordershipfee'];
					$ordercopst			= 		 $sql[$i]['ordercopst'];
					
					

					

					

					$RefundAmount	= $sql[$i]['RefundAmount'];

					

					$dpage++;

					

					

					//if($ostatus == 0) $paidtime	= $sql[$i]['ebay_createdtime'];

					
		$ebay_countryname		= $sql[$i]['ebay_countryname'];
					$country		= $sql[$i]['ebay_countryname'];
					$isprint		= $sql[$i]['isprint'];

					$status			= Getstatus($sql[$i]['ebay_status']);

					$account		= $sql[$i]['ebay_account'];

					$shipfee		= $sql[$i]['ebay_shipfee'];

					$ebay_paystatus	= trim($sql[$i]['ebay_paystatus']);

					$eBayPaymentStatus	= 		 $sql[$i]['eBayPaymentStatus'];

					

					

					$ebaynote	= $sql[$i]['ebay_note'];

					

					$ebay_carrier				= $sql[$i]['ebay_carrier'];

					$recordnumber				= $sql[$i]['recordnumber'];

					$ebay_tracknumber			= $sql[$i]['ebay_tracknumber'];

					

					$ShippedTime			= $sql[$i]['ebay_markettime'];

					

				

					$ebay_createdtime		= $sql[$i]['ebay_createdtime'];
					$location		= $sql[$i]['location'];

					if($currency == 'USD'){


						$formatshipprice	= "$".$shipfee;
						$formattotalprice	= "$".$total;

									

									

					}else{

								

						$formatshipprice	= $currency.$shipfee;

						$formattotalprice	= $currency.$total;

					}

					

								

							   
							    $st	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";

								$st = $dbcon->execute($st);
								$st	= $dbcon->getResultArray($st);

								$productcost		= 0;
								$productweight		= 0;
							

							$labelstr = '';

							for($t=0;$t<count($st);$t++){

								$sku			= $st[$t]['sku'];
								
								
								$labelstr		.= $sku.' ';
								

								$ebay_amount	= $st[$t]['ebay_amount'];
								
								$ssr				= "select * from ebay_goods where goods_sn= '$sku' and ebay_user='$user'";
								$ssr 				= $dbcon->execute($ssr);
								$ssr				= $dbcon->getResultArray($ssr);
								if(count($ssr)>0){
									$sweight			= $ssr[0]['goods_weight'] * $ebay_amount;
									$scost				= $ssr[0]['goods_cost'] * $ebay_amount;
									$productcost		= $productcost + $scost;
									$productweight		= $productweight + $sweight;
								}else{
									$ssr	= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
									$ssr 	= $dbcon->execute($ssr);
									$ssr	= $dbcon->getResultArray($ssr);
									$goods_sncombine	= $ssr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
										$pline			= explode('*',$goods_sncombine[$e]);
										$goods_sn		= $pline[0];
										$goddscount     = $pline[1] * $ebay_amount;
										$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
										$ee			= $dbcon->execute($ee);
										$ee 	 	= $dbcon->getResultArray($ee);
										$scost = $ee[0]['goods_cost']*$goddscount;
										$sweight = $ee[0]['goods_weight']*$goddscount;
										$productcost		= $productcost + $scost;
										$productweight		= $productweight + $sweight;
									}
								}
							}
							
							
					
							/*订单总销售额*/
							$ebaytotal		= $total;
							
							$ss			= "select * from ebay_currency where currency='$currency' and user='$user'";
							$ss			=  $dbcon->execute($ss);
							$ss			=  $dbcon->getResultArray($ss);
							$ssrates	=  $ss[0]['rates']?$ss[0]['rates']:1;
							
							$ebaytotal	= $ebaytotal * $ssrates;
							
							
							/* ebay fees */
							$ss			= "select sum(FinalValueFee) as a from ebay_orderdetail where ebay_ordersn = '$ordersn'";
							$ss			=  $dbcon->execute($ss);
							$ss			=  $dbcon->getResultArray($ss);
							$sfee		=  number_format($ss[0]['a']  * 1,2);
							$sfee		= number_format($sfee * $ssrates,2);
							
							
							/*paypal fees*/
							$ss			= "select sum(FeeOrCreditAmount) as a from ebay_orderdetail where ebay_ordersn = '$ordersn'";
							$ss			=  $dbcon->execute($ss);
							$ss			=  $dbcon->getResultArray($ss);
							$pfee		=  abs($ss[0]['a']);
							$pfee		= number_format($pfee * $ssrates,2);
				
							
							
							$ebay_combine	= explode('##',$ebay_combine);
							for($d=0;$d<count($ebay_combine);$d++){
							
								$cebayid		= $ebay_combine[$d];
								$ss			= "select * from ebay_order where ebay_id = '$cebayid'";
								$ss			=  $dbcon->execute($ss);
								$ss			=  $dbcon->getResultArray($ss);
								$ebay_ptid	= $ss[0]['ebay_ptid'];
								$ss			= "select * from  ebay_paypaldetail where tid ='$ebay_ptid'";
								$ss			=  $dbcon->execute($ss);
								$ss			=  $dbcon->getResultArray($ss);
								$pfees		=  abs($ss[0]['fee']);
								$pfee		+= $pfees * $ssrates;
						
							
							}

							if($orderweight >0 )  $productweight			= $orderweight;
							if($orderweight2 >0 )  $productweight			= $orderweight2/1000;
							
							
							
							
							/* 物品成本  productcost */
							$ss			= "select * from ebay_currency where currency='RMB' and user='$user'";
							$ss			=  $dbcon->execute($ss);
							$ss			=  $dbcon->getResultArray($ss);
							
							
							
							$ssrates	=  $ss[0]['rates']?$ss[0]['rates']:1;
							$productcost1 = $productcost * $ssrates;

							if($ordercopst >0 ){
							   $productcost				= $ordercopst;
							   $productcost1			= $productcost;
							}else{
							
								$productcost				= $productcost1;
							    $productcost1			= $productcost;
							}
							
							/* 物品运费 */
							$ss			= "select * from ebay_carrier  where name = '$ebay_carrier' and ebay_user='$user'";
							$ss			=  $dbcon->execute($ss);
							$ss			=  $dbcon->getResultArray($ss);
							
							
					
							$ebay_carrier	= $ss[0]['name'];
							$id				= $ss[0]['id'];
							
							$value			= shipfeecalc($id,$productweight,$ebay_countryname);
								
				
							$weightfee  = $value;
							$weightfee1 = $value * $ssrates;
							
							
		
							$ml			= number_format(($ebaytotal - $sfee - $pfee - $productcost1 - $weightfee1),2);
							
							/*
							
							*/
					//		echo "ebaytotaol=".$ebaytotal.' Sfee='.$sfee.' pfee '.$pfee.' productcost1  '.$productcost1.' weightfee1:'.$weightfee1;
							
							
							
							
						//	if($ordershipfee >0 ) $weightfee				= $ordershipfee;
							
							
							

			  ?>

              

              

                  

         		<tr height='20' class='oddListRowS1'>

						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ebayid;?>" >

					     <?php

						

						if($ebaynote != "") echo "<img src='notes.gif' title='".$ebaynote."'  width=\"20\" height=\"20\"/>";

						

						

						

						

						?>                        </td>
						
				  <td scope='row' align='left' valign="top" ><?php echo $ebayid;?></td>
						
				

						    <td scope='row' align='left' valign="top" ><?php echo $recordnumber;?></td>

						    <td scope='row' align='left' valign="top" >

							<?php echo $account; ?>                            </td>

				

						    <td scope='row' align='left' valign="top" ><?php echo $userid;?>
                           </td>
						    <td scope='row' align='left' valign="top" ><?php echo $country;?></td>

						    <td scope='row' align='left' valign="top" ><?php echo $ebay_tracknumber;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_carrier;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $labelstr;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $formattotalprice;?>&nbsp;</td>

						    <td scope='row' align='left' valign="top" >

							<?php 

						

							

							if($paidtime != 0){

							echo date('M-d',$paidtime); }

							

							?></td>

		                    <td scope='row' align='left' valign="top" ><?php 

							if($ShippedTime != 0){

							

							echo date('M-d',$ShippedTime);

							

							}

							

							?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><textarea name="orderweight<?php echo $ebayid;?>" cols="7" rows="1" id="orderweight<?php echo $ebayid;?>"><?php echo number_format($productweight,3);?></textarea>                  </td>
                            <td scope='row' align='left' valign="top" ><textarea name="ordercopst<?php echo $ebayid;?>" cols="10" rows="1" id="ordercopst<?php echo $ebayid;?>"><?php echo number_format($productcost,3);?></textarea></td>
                            <td scope='row' align='left' valign="top" ><textarea name="ordershipfee<?php echo $ebayid;?>" cols="7" rows="1" id="ordershipfee<?php echo $ebayid;?>"><?php echo number_format($weightfee1,3);?></textarea></td>
                            <td scope='row' align='left' valign="top" >
                            
                               <?php
							   
					
							
							echo "ebay销售额： ".$ebaytotal.'<br>';
							echo "ebay费用： ".$sfee.'<br>';
							echo "payapl费用： ".$pfee.'<br>';
							echo "物品成本： ".$productcost1.'<br>';
							echo "运费： ".$weightfee1.'<br>';
							$mll		= number_format(($ml/$ebaytotal),2);
							echo '利润:'.$ml.' / '.($mll*100).'% <br>';

							
							?>
                            
                            
                            
                            
                            
                            
                            &nbsp;</td>
       		                <td scope='row' align='left' valign="top" ><input type="button" value="确认" onclick="confirms(<?php echo $ebayid;?>)"/>
                  &nbsp;</td>
       		  </tr>

              

             <?php

			  } ?>

		<tr class='pagination'>

		<td colspan='23'>

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'>

                    本页订单条数为：<?php echo $dpage;?>

                   

                    Your search results is <?php echo $totalpages;?>

          

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

	

	

	

	function deleteall(sn){



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

	

	if(confirm('确认需要处理此条记录？')){

	

		location.href='orderindexly.php?type=del&ordersn='+bill+"&ostatus="+<?php echo $ostatus;?>+"&module=finance&action=<?php echo $_REQUEST['action'];?>&cstatus="+sn;

		

	}



}





	function deleteallsystem(sn){



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

	

	if(confirm('确认删除此条记录')){

	

		location.href='orderindexly.php?type=delsystem&ordersn='+bill+"&ostatus="+<?php echo $ostatus;?>+"&module=finance&action=<?php echo $_REQUEST['action'];?>";

		

	}



}









		function searchorder(){

	

		

		var ebay_ordertype 	= document.getElementById('ebay_ordertype').value;

		var content 	= document.getElementById('keys').value;

		var account 	= document.getElementById('acc').value;

		var sku 		= document.getElementById('sku').value;

		var note 		= '';
		
		var country 		= document.getElementById('country').value;
		var start 		= document.getElementById('start').value;
		var end 		= document.getElementById('end').value;
		var Shipping 		= document.getElementById('Shipping').value;
		
		var refundtimeend 			= '';
		var refundtimestart 		= '';
		var resendtimestart 		= '';
		var resendtimesend	 		= '';

		location.href= 'orderindexly.php?keys='+content+"&account="+account+"&sku="+sku+"&module=finance&action=<?php echo $_REQUEST['action'];?>&ostatus=<?php echo $ostatus;?>&note="+note+"&country="+country+"&start="+start+"&end="+end+"&shipping="+Shipping+"&ebay_ordertype="+ebay_ordertype+"&profitstatus=<?php echo $profitstatus;?>&refundtimeend="+refundtimeend+"&refundtimestart="+refundtimestart+"&resendtimestart="+resendtimestart+"&resendtimesend="+resendtimesend;

		

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

		

		location.href= 'orderindexly.php?keys='+content+"&account="+account+"&sku="+sku+"&module=finance&action=<?php echo $_REQUEST['action'];?>&ostatus=<?php echo $ostatus;?>&country="+country;

	

	

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

		window.open("orderbulkeditorderstatus.php?module=finance&ordersn="+bill,"_blank");

	

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

		window.open("allpacklist.php?module=finance&ordersn="+bill,"_blank");

	

	}
	
	function doo(sn){
	
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

	

		location.href='orderindexly.php?type=delsystem&ordersn='+bill+"&ostatus="+<?php echo $ostatus;?>+"&module=finance&action=<?php echo $_REQUEST['action'];?>&changestatus="+sn;

		

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

	
	function confirms(id){
		
		var orderweight		= document.getElementById('orderweight'+id).value;
		var ordershipfee 	= document.getElementById('ordershipfee'+id).value;
		var ordercopst 		= document.getElementById('ordercopst'+id).value;
		var url				= "orderconfirm.php?orderweight="+orderweight+"&ordershipfee="+ordershipfee+"&ordercopst="+ordercopst+"&ebay_id="+id;
		
		openwindow(url,'',300,300);
		
		
	
	}
	
	
	
		function confirmorderprofit(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){			

				bill = bill + ","+checkboxs[i].value;		

			}
		}
		if(bill==''){
			if(confirm('为选择订单将对所有的订单进行确认 是否继续？')){
				var url		= 'orderconfirmprofit.php?bill='+bill;
				openwindow(url,'',300,300);
			}
		}else{
			var url		= 'orderconfirmprofit.php?bill='+bill;
			openwindow(url,'',300,300);
		}
	
	}
	


</script>