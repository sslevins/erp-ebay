<?php

include "include/config.php";





include "top.php";




$note			= $_REQUEST['note'];
$ostatus		= $_REQUEST['ostatus']?$_REQUEST['ostatus']:"0";

$keys			= $_REQUEST['keys']?trim($_REQUEST['keys']):"";

$sku			= $_REQUEST['sku']?trim($_REQUEST['sku']):"";

$account		= $_REQUEST['account'];

$type			= $_REQUEST['type'];

$sort			= $_REQUEST['sort']?$_REQUEST['sort']:'';

$sortstatus		= $_REQUEST['sortstatus']?$_REQUEST['sortstatus']:0;

$sortdefault	= 0;

function getresultcount($status){



	global $dbcon,$user;

	

	$sql	= "select count(*) as cc from ebay_order where ebay_status='".$status."' and ebay_user='$user' and ebay_combine!='1'";

	

	

	$sql	= $dbcon->execute($sql);

	$sql	= $dbcon->getResultArray($sql);

	return  $sql[0]['cc'];

	$dbcon->close();

	





}













if($type 	== "ordermarket"){

	$ordersn = explode(",",$_REQUEST['ordersn']);
	$cstatus = $_REQUEST['id'];
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){		

		$sn 	=  $ordersn[$g];
		if($sn != ""){			

			$sql		= "update ebay_order set ebay_status='$cstatus' where ebay_ordersn='$sn'";
			
			
			if($cstatus == '995'){
			
				$sql		= "update ebay_order set ebay_status='$cstatus',refundtime='$mctime' where ebay_ordersn='$sn'";
				
			}
			if($cstatus == '992'){
				$sql		= "update ebay_order set ebay_status='$cstatus',resendtime='$mctime' where ebay_ordersn='$sn'";
			}
			
			if($cstatus == '998'){
				$sql		= "update ebay_order set ebay_status='$cstatus',canceltime='$mctime' where ebay_ordersn='$sn'";
			}
			

		
			if($dbcon->execute($sql)){
						$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";
			}else{
						$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";
			}			

		}

	}


}





if($type 	== "delsystem"){

	

	$ordersn = explode(",",$_REQUEST['ordersn']);

	$status  = "";

	for($g=0;$g<count($ordersn);$g++){

		

		

		$sn 	=  $ordersn[$g];



		if($sn != ""){

			

			$sql		= "delete  from  ebay_order where ebay_ordersn='$sn'";

		

			

		if($dbcon->execute($sql)){

	

	

					$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";



	}else{

	



					$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";



	}



			

		}

	}

	

}



	

	

 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<style type="text/css">

<!--

.STYLE1 {font-size: xx-small}

-->

</style>



<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

		

	<td nowrap="nowrap" scope="row" ><!--

               <input type="button" value="打印地址A4" onClick="detail2()">

               <input type="button" value="Label标签打印" onclick="detail3()" />-->搜索类型：<select name="type" id="type">
	  <option value="0">买家</option>
      <option value="1">买家邮件</option>
      <option value="2">收款邮件</option>
      <option value="3">物品号</option>
      <option value="4">地址</option>
      <option value="5">交易号</option>
      
	</select>
	  
	   <input name="keys" type="text" id="keys" />
	   付款日期从:
	   <input name="start" type="text" onclick="WdatePicker()" id="start" >
       付款日期到:
	   <input name="end" type="text" onclick="WdatePicker()" id="end" >
	   <input type="button" value="Search" onclick="searchorder()" />
	  
	  <input type="button" value="同步Paypal订单" onclick="location.href='paypalimport.php?module=orders&action=同步Paypal'" /></td>
</tr>
</table>

</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td colspan='3'><div id="rows"></div> 		</td>
	</tr><tr height='20'>

					<th scope='col' nowrap="nowrap">付款</th>

  <th scope='col' nowrap="nowrap">

				<div style='white-space: nowrap;'width='100%' align='left'>买家</div></th>

			

					<th scope='col' nowrap="nowrap">
地址</th>

			
		</tr>
			  <?php				

			
					$sql		= "select * from ebay_paypalorder as a where ebay_user='$user'";
				
		

				
				$type			= $_REQUEST['type'];
				$keys			= $_REQUEST['keys'];
				
				
				if($ostatus =='1'){
					
					$sql	.= " and ebay_status='1'";
					
				
				}
				
				if($type =='0'){
					
					$sql	.= " and BUYERID='$keys'";
					
				
				}
				
				if($type =='1'){
					
					$sql	.= " and EMAIL='$keys'";
					
				
				}
				
			
				if($type =='2'){
					
					$sql	.= " and RECEIVEREMAIL='$keys'";
					
				
				}
				
			
				if($type =='4'){
					
					$sql	.= " and (SHIPTONAME like '%$keys%' or SHIPTOSTREET like '%$keys%' or SHIPTOSTREET2 like '%$keys%' or SHIPTOCITY like '%$keys%' or SHIPTOSTATE like '%$keys%' or SHIPTOZIP like '%$keys%' or SHIPTOCOUNTRYNAME like '%$keys%')";
					
				
				}
				
				if($type =='5'){
					
					$sql	.= " and TRANSACTIONID='$keys'";
					
				
				}
				
				
				
				
			
				$start			= $_REQUEST['start'];
				$end			= $_REQUEST['end'];
				if($start != '' && $end != ''){
				
					$start		= strtotime($start." 00:00:00");
					$end		= strtotime($end." 23:59:59");
					$sql.= " and (a.ORDERTIME>=$start and a.ORDERTIME<=$end)";
				
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

					
						$TRANSACTIONID		= $sql[$i]['TRANSACTIONID'];
						$ORDERTIME			= date('Y-m-d H:i:s',$sql[$i]['ORDERTIME']);
						$CURRENCYCODE		= $sql[$i]['CURRENCYCODE'];
						$dollar				= '$';
						
						if($CURRENCYCODE == 'USD'){
							
							$dollar				= '$';
						}elseif($CURRENCYCODE == 'EUR'){
							
							$dollar				= '€';
						}elseif($CURRENCYCODE == 'AUD'){
							
							$dollar				= '$';
						}elseif($CURRENCYCODE == 'GBP'){
							
							$dollar				= '￡';
						}
						$NETFEE		= $dollar.($sql[$i]['AMT'] - $sql[$i]['FEEAMT']);
						

								
						$ss					= "select * from  ebay_paypalorderdetail where TRANSACTIONID ='$TRANSACTIONID'";
						$ss					= $dbcon->execute($ss);
						$ss					= $dbcon->getResultArray($ss);
						
						$EMAIL		= $sql[$i]['EMAIL'];
						$BUYERID		= $sql[$i]['BUYERID'];
						$PAYMENTSTATUS		= $sql[$i]['PAYMENTSTATUS'];
						$PAYERSTATUS		= $sql[$i]['PAYERSTATUS'];
						
						
						$SHIPTONAME			= $sql[$i]['SHIPTONAME'];
						$SHIPTOSTREET		= $sql[$i]['SHIPTOSTREET'];
						$SHIPTOSTREET2		= $sql[$i]['SHIPTOSTREET2'];
						$SHIPTOCITY			= $sql[$i]['SHIPTOCITY'];						
						$SHIPTOSTATE		= $sql[$i]['SHIPTOSTATE'];						
						$SHIPTOZIP			= $sql[$i]['SHIPTOZIP'];
						$SHIPTOCOUNTRYNAME	= $sql[$i]['SHIPTOCOUNTRYNAME'];
						
						$addressline		= $SHIPTONAME."<br>".$SHIPTOSTREET."<br>".$SHIPTOSTREET2."<br>".$SHIPTOCITY." ".$SHIPTOSTATE."<br>".$SHIPTOZIP."<br>".$SHIPTOCOUNTRYNAME;
						
			  ?>

              

              

                  

         		<tr height='20' class='oddListRowS1'>

						<td scope='row' align='left' valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>交易号</td>
                            <td><a href="#" onclick="details('<?php echo $TRANSACTIONID;?>')"><?php echo $TRANSACTIONID;?></a>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>日期</td>
                            <td><?php echo $ORDERTIME;?>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>净额</td>
                            <td><?php echo $NETFEE;?>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>数量</td>
                            <td><?php echo count($ss);?>&nbsp;</td>
                          </tr>
                        </table></td>

						    <td scope='row' align='left' valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="25%">付款邮件</td>
                                <td width="75%"><?php echo $EMAIL;?>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>买家</td>
                                <td><?php echo $BUYERID;?>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>付款状态</td>
                                <td><?php echo $PAYMENTSTATUS;?>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Paypal邮件地址</td>
                                <td><?php echo $PAYERSTATUS;?>&nbsp;</td>
                              </tr>
                            </table></td>

				

						    <td scope='row' align='left' valign="top" ><?php echo $addressline;?>&nbsp;</td>
		      </tr>
         		<tr height='20' class='oddListRowS1'>
         		  <td colspan="3" align='left' valign="top" scope='row' ><div style="width:auto; border:1px solid #3399CC"></div> </td>
       		  </tr>

              

             <?php

			  

							$st	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";

							$st = $dbcon->execute($st);

							$st	= $dbcon->getResultArray($st);

							$total	= 0;

							

							

							for($t=0;$t<count($st);$t++){

							

							

								$qname			= $st[$t]['ebay_itemtitle'];								

								$qitemid		= $st[$t]['ebay_itemid'];

								$sku			= $st[$t]['sku'];

								$imagepic		= $st[$t]['ebay_itemurl'];

								$ebay_amount	= $st[$t]['ebay_amount'];

								$qname			= $st[$t]['ebay_itemtitle'];

								$recordnumber	= $st[$t]['recordnumber'];

								$ebay_itemprice	= $st[$t]['ebay_itemprice'];

								$ListingType	= $st[$t]['ListingType'];

						

			  ?>



              

              
              <?php 

			  

			  if($ebaynote != ""){

			  

			  

			  $ebaynote					= str_replace('<![CDATA[','',$ebaynote);

			  $ebaynote					= str_replace(']]>','',$ebaynote);

			  ?>

              



              
               <?php } } } ?>

		<tr class='pagination'>

		<td colspan='3'>

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









	

	

	

		function ebaymarket(){

		

		

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

		

		if(confirm('您确认将选中订单在ebay上标记发出吗?')){

		

		

		

		window.open("ordermarket.php?ordersn="+bill,"_blank");

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

	

		location.href='orderindex.php?type=del&ordersn='+bill+"&ostatus="+<?php echo $ostatus;?>+"&module=orders&action=<?php echo $_REQUEST['action'];?>&cstatus="+sn;

		

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

	

		location.href='orderindex.php?type=delsystem&ordersn='+bill+"&ostatus="+<?php echo $ostatus;?>+"&module=orders&action=<?php echo $_REQUEST['action'];?>";

		

	}



}









		function searchorder(){

			var type 	= document.getElementById('type').value;
			var keys 	= document.getElementById('keys').value;
	
			var start 		= document.getElementById('start').value;
			var end 		= document.getElementById('end').value;

			location.href= 's_paypalindex.php?keys='+keys+"&type="+type+"&module=orders&action=<?php echo $_REQUEST['action'];?>&ostatus=<?php echo $ostatus;?>&start="+start+"&end="+end;


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



	function addresstoword(){

		

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){				

				bill = bill + ","+checkboxs[i].value;			

			}	

			

		}

		

		if(confirm("需要将相同地址进行合并吗？ 选择OK,表示是")){

		

		

			 var url = "ordertoword.php?module=orders&ordersn="+bill+"&iscombine=1";

			 

		}else{

			

			

			 var url = "ordertoword.php?module=orders&ordersn="+bill+"&iscombine=0";

		}

	   

		

		

		window.open(url,"_blank");

		

	

	}
	
	
	function ordermarket(id){
	
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


		var url		= 'orderindex.php?module=orders&ostatus=<?php echo $ostatus;?>&action=<?php echo $_REQUEST['action'];?>&type=ordermarket&ordersn='+bill+"&id="+id;
		location.href	= url;
		
	
	
	}
	
	
	function searchmessage(userid){
	
	
		
		var url		= "messageindex.php?module=message&type=class&ostatus=all&keys="+userid+"&account=&ostatus=0&action=所有Message&sort=0";
		
		openwindow(url,'00',1050,1050);
	
	
	
	
	}
	
	
	function details(tid){
	
	var url		= "paypaldetailsview.php?tid="+tid;
		
		openwindow(url,'00',800,900);
	
	
	
	
	
	
	
	
	}
	
	
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
	





</script>