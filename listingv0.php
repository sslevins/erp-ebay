<?php
include "include/config.php";


include "top.php";

$type	= $_REQUEST['type'];

$ostatus = $_REQUEST['status'];
$ListingType = $_REQUEST['ListingType'];
$searchtype = $_REQUEST['searchtype'];

$keys = $_REQUEST['keys'];	
$account = $_REQUEST['account'];
$sort= $_REQUEST['sort']?$_REQUEST['sort']:'QuantitySold';
$sortstatus	= $_REQUEST['sortstatus']?$_REQUEST['sortstatus']:0;
$sortdefault		= 0;

if ($sort=="price")
  {
if($sortstatus  == '0'){
		$sortstr	= " order by a.StartPrice desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.StartPrice asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}	
if ($sort=="type")
{
if($sortstatus  == '0'){
		$sortstr	= " order by a.ListingType desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.ListingType asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if ($sort=="number")
{
if($sortstatus  == '0'){
		$sortstr	= " order by a.QuantityAvailable desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.QuantityAvailable asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}	
if ($sort=="sku")
{
if($sortstatus  == '0'){
		$sortstr	= " order by a.sku desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.sku asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}	

if ($sort=="QuantitySold")
{
if($sortstatus  == '0'){
		$sortstr	= " order by a.QuantitySold desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.QuantitySold asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}	

if($sort == 'title'  ){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.Title desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.Title asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
if($sort == ''  ){
	if($sortstatus  == '0'){
		$sortstr	= " order by a.sku desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}else{
		$sortstr	= " order by a.sku asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;操作：
	
      
<input type="button" value="批量提交修改" onclick="Modifysku()" />
<!--

<input type="button" value="自动更新数量" onclick="Modifysku02()" /> -->
<input type="button" value="同步库存数量到eBay" onclick="Modifysku03()" />

<br />
查找：
<input name="keys" type="text" id='keys' value='<?php echo $keys;?>' />
<select name='searchtype' id='searchtype'>
  <option value="">请选择</option>
  <option value="1" <?php if($searchtype=='1') echo "selected='selected'";?>>按eBay 帐号查找</option>
  <option value="2" <?php if($searchtype=='2') echo "selected='selected'";?>>按sku 查找</option>
  <option value="5" <?php if($searchtype=='5') echo "selected='selected'";?>>按多属性子sku 查找</option>
  <option value="3" <?php if($searchtype=='3') echo "selected='selected'";?>>按Item Title   查找</option>
  <option value="4" <?php if($searchtype=='4') echo "selected='selected'";?>>按Item Number  查找</option>
</select>
刊登类型：
<select name='ListingType' id='ListingType'>
  <option value="">请选择</option>
  <?php
  	$vv		= "select distinct ListingType from ebay_list where ebay_user ='$user' ";
	$vv		= $dbcon->execute($vv);
	$vv		= $dbcon->getResultArray($vv);
	
	for($i=0;$i<count($vv);$i++){
	
		$ListingType1		= $vv[$i]['ListingType'];
		
	
  
   ?>
  <option value="<?php echo $ListingType1;?>" <?php if($ListingType1==$ListingType) echo "selected='selected'";?>><?php echo $ListingType1;?></option>
  
  
  <?php  }  ?>
</select>
选择eBay帐号：
<select name="account" id="account">
<option value="">所有帐号</option>

  <?php 
					
					$sql	 = "select * from ebay_account as a  where ebay_user='$user' and ($ebayacc)";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$accounts	= $sql[$i]['ebay_account'];
					 ?>
  <option value="<?php echo $accounts;?>"  <?php if($account == $accounts) echo 'selected="selected"';?>><?php echo $accounts;?></option>
  <?php } ?>
</select>
<input name="导入eBay在线" type="button" id="导入eBay在线" value="查找" onclick='search();' />
<input type="button" value="全选" onclick="check_all('ordersn2','ordersn2')" />
<br />
<br /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</div>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='13'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th nowrap="nowrap" scope='col'>
				<div style='white-space: nowrap;'width='100%' align='left'>eBay ID</div></th>
			
		            <th nowrap="nowrap" scope='col'>Item ID</th>
                    <th nowrap="nowrap" scope='col'><a href="listing.php?module=list&action=<?php echo $_REQUEST['action'];?>&sort=sku&status=<?php echo $_REQUEST['status'];?>&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $_REQUEST['keys'];?>&searchtype=<?php echo $_REQUEST['searchtype'];?>&ListingType=<?php echo $_REQUEST['ListingType'];?>&account=<?php echo $account;?>">SKU</a><?php if($sort == 'sku') echo $sortsimg; ?></th>
        <th nowrap="nowrap" scope='col'>
		  <a href="listing.php?module=list&action=<?php echo $_REQUEST['action'];?>&sort=title&status=<?php echo $_REQUEST['status'];?>&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $_REQUEST['keys'];?>&searchtype=<?php echo $_REQUEST['searchtype'];?>&ListingType=<?php echo $_REQUEST['ListingType'];?>&account=<?php echo $account;?>">Title</a><?php if($sort == 'title') echo $sortsimg; ?>		</th>
			
					<th nowrap="nowrap" scope='col'><a href="listing.php?module=list&action=<?php echo $_REQUEST['action'];?>&sort=type&status=<?php echo $_REQUEST['status'];?>&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $_REQUEST['keys'];?>&searchtype=<?php echo $_REQUEST['searchtype'];?>&ListingType=<?php echo $_REQUEST['ListingType'];?>&account=<?php echo $account;?>">Type</a><?php if($sort == 'type') echo $sortsimg; ?></th>
		<th nowrap="nowrap" scope='col'>Site</th>
                    <th nowrap="nowrap" scope='col'>库存</th>
                    <th nowrap="nowrap" scope='col'>币种</th>
                    <th nowrap="nowrap" scope='col'>
                    <a href="listing.php?module=list&action=<?php echo $_REQUEST['action'];?>&sort=QuantitySold&status=<?php echo $_REQUEST['status'];?>&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $_REQUEST['keys'];?>&searchtype=<?php echo $_REQUEST['searchtype'];?>&ListingType=<?php echo $_REQUEST['ListingType'];?>&account=<?php echo $account;?>">
                    
                    售出数</a><?php if($sort == 'QuantitySold') echo $sortsimg; ?></th>
                    <th nowrap="nowrap" scope='col'><a href="listing.php?module=list&action=<?php echo $_REQUEST['action'];?>&sort=price&status=<?php echo $_REQUEST['status'];?>&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $_REQUEST['keys'];?>&searchtype=<?php echo $_REQUEST['searchtype'];?>&ListingType=<?php echo $_REQUEST['ListingType'];?>&account=<?php echo $account;?>">价格</a><?php if($sort == 'price') echo $sortsimg; ?></th>
	                 <th nowrap="nowrap" scope='col'><a href="listing.php?module=list&action=<?php echo $_REQUEST['action'];?>&sort=number&status=<?php echo $_REQUEST['status'];?>&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $_REQUEST['keys'];?>&searchtype=<?php echo $_REQUEST['searchtype'];?>&ListingType=<?php echo $_REQUEST['ListingType'];?>&account=<?php echo $account;?>" >数量</a><?php if($sort == 'number') echo $sortsimg; ?></th>
	                 <th nowrap="nowrap" scope='col'>自动调整价格/数量</th>
	                 <th nowrap="nowrap" scope='col'>操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql= "select * from ebay_list as a where status='".$_REQUEST['status']."' and ebay_user='$user' and ($ebayacc) ";
				
				if($searchtype == '5'){
				$sql= "select * from ebay_list as a join ebay_listvariations as b on a.ItemID = b.itemid where a.status='".$_REQUEST['status']."' and a.ebay_user='$user' and ($ebayacc) and b.SKU like '%$keys%'";
				}
				
				if($keys!="" &&  $searchtype =='3'){
				$sql .= " and a.Title like '%$keys%' ";
				}
				if($keys!="" &&  $searchtype =='2'){
				$sql .= " and a.SKU like '%$keys%' ";
				}
				
				if($keys!="" &&  $searchtype =='4'){
				$sql .= " and a.ItemID like '$keys' ";
				}
				if($ListingType != '' ) $sql .= " and ListingType='$ListingType' ";
				if($account != '' ) 	$sql .="  and a.ebay_account ='$account' ";
				
				if($searchtype == '5'){
					
					$sql .= " group by a.id ";
					
				}

				$sql=$sql.$sortstr;
	
				

				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
		
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)* 100 .",100";
				$page=new page(array('total'=>$total,'perpage'=>100));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$id							= $sql[$i]['id'];
					$PictureURL01				= $sql[$i]['PictureURL01'];
					$ebay_account				= $sql[$i]['ebay_account'];
					$Title						= $sql[$i]['Title'];
					$SKU						= $sql[$i]['SKU'];
					$ListingType				= $sql[$i]['ListingType'];
					$StartPricecurrencyID		= $sql[$i]['StartPricecurrencyID'];
					$ViewItemURL				= $sql[$i]['ViewItemURL'];
					$StartPrice					= $sql[$i]['StartPrice'];
					$ItemID						= $sql[$i]['ItemID'];
					$Quantity					= $sql[$i]['Quantity'];
					$Site						= $sql[$i]['Site'];
					$QuantityAvailable			= $sql[$i]['QuantityAvailable'];
					$QuantitySold				= $sql[$i]['QuantitySold']?$sql[$i]['QuantitySold']:0;
					$track_price				= $sql[$i]['track_price']?'N':'Y';
					$track_stock				= $sql[$i]['track_stock']?'N':'Y';
			  ?>
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $ebay_account; ?></td>
				
			      <td scope='row' align='left' valign="top" ><a href="<?php echo $ViewItemURL;?>" target="_blank"><?php echo $sql[$i]['ItemID'];?></a></td>
						    <td scope='row' align='left' valign="top" >
					          <input name="SKU<?php echo $id;?>" type="text" id="SKU<?php echo $id;?>" value="<?php echo $SKU;?>" /></td>
			      <td scope='row' align='left' valign="top" ><?php echo $Title;?></td>
				
			      <td scope='row' align='left' valign="top" ><?php
				 echo $ListingType;
				 
					
				   
				   
				   ?>&nbsp;</td>
			      <td scope='row' align='left' valign="top" ><?php echo $Site;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php
							$vv = "select store_name,id from ebay_store where ebay_user='$user' ";
							$vv		= $dbcon->execute($vv);
							$vv		= $dbcon->getResultArray($vv);
							foreach($vv as $k=>$v){
								$vvv = "select goods_count from ebay_onhandle where goods_sn='$SKU' and store_id='".$v['id']."'";
								$vvv		= $dbcon->execute($vvv);
								$vvv		= $dbcon->getResultArray($vvv);
								$handlecount = $vvv[0]['goods_count']?$vvv[0]['goods_count']:0;
								echo $v['store_name'].' : '.$handlecount.'<br>';
							}
						?>&nbsp;</td>
                        
                        
                        	<td scope='row' align='left' valign="top" ><?php echo  $StartPricecurrencyID;?>&nbsp;</td>
                        	<td scope='row' align='left' valign="top" ><?php echo  $QuantitySold;?>&nbsp;</td>
                        	<td scope='row' align='left' valign="top" >
                       	      <textarea name="StartPrice<?php echo $id;?>" id="StartPrice<?php echo $id;?>" cols="10" rows="1"><?php echo $StartPrice;?></textarea></td>
                        	<td scope='row' align='left' valign="top" >
                       	    <textarea name="Quantity<?php echo $id;?>" id="Quantity<?php echo $id;?>" cols="6" rows="1"><?php echo $QuantityAvailable;?></textarea>
                       	    <input name="ordersn2" type="checkbox" id="ordersn2" value="<?php echo $id;?>" /></td>
                        	<td scope='row' align='left' valign="top" ><?php echo $track_price.' / '.$track_stock;?>&nbsp;</td>
                        	<td scope='row' align='left' valign="top" ><a href="#" onclick="track_list('<?php  echo $id; ?>')">设置跟踪</a>
                            
                            <a href="#" onclick="enditem('<?php  echo $id; ?>')">End Item</a>
                            
                            </td>
                        	<?php
							$ss		= "select * from ebay_listvariations where ebay_account='$ebay_account' and itemid ='$ItemID'";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($s=0;$s<count($ss);$s++){
								
								$SKU = $ss[$s]['SKU'];
								
                            ?>
      </tr>
         		<tr height='20' class='oddListRowS1'>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >
       		      <input name="KSKU<?php echo $ss[$s]['id']; ?>" type="text" id="KSKU<?php echo $ss[$s]['id']; ?>" value="<?php echo $ss[$s]['SKU'];  ?>" /></td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td scope='row' align='left' valign="top" >&nbsp;</td>
         		  <td align='left' valign="top" scope='row' ><?php echo $ss[$s]['VariationSpecifics']; ?>&nbsp;</td>
         		  <td colspan="3" align='left' valign="top" scope='row' ><?php
							$vv = "select store_name,id from ebay_store where ebay_user='$user' ";
							$vv		= $dbcon->execute($vv);
							$vv		= $dbcon->getResultArray($vv);
							foreach($vv as $k=>$v){
								$vvv = "select goods_count from ebay_onhandle where goods_sn='$SKU' and store_id='".$v['id']."'";
								$vvv		= $dbcon->execute($vvv);
								$vvv		= $dbcon->getResultArray($vvv);
								$handlecount = $vvv[0]['goods_count']?$vvv[0]['goods_count']:0;
								echo $v['store_name'].' : '.$handlecount.'<br>';
							}
						?></td>
         		  <td scope='row' align='left' valign="top" >
   		          <textarea name="KStartPrice<?php echo $ss[$s]['id']; ?>"  id="KStartPrice<?php echo $ss[$s]['id']; ?>" cols="10" rows="1"><?php echo $ss[$s]['StartPrice']; ?></textarea></td>
       		      <td scope='row' align='left' valign="top" >
   		          <textarea name="KQuantity<?php echo $ss[$s]['id']; ?>" id="KQuantity<?php echo $ss[$s]['id']; ?>" cols="6" rows="1"><?php  echo $ss[$s]['QuantityAvailable']; ?></textarea>
   		          <input name="ordersn3" type="checkbox" id="ordersn3" value="<?php echo $ss[$s]['id']; ?>" /></td>
       		      <td scope='row' align='left' valign="top" >&nbsp;</td>
       		      <td scope='row' align='left' valign="top" >&nbsp;</td>
       		  </tr>
              
              
              <?php } ?>


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='13'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


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
	
	cName = 'ordersn3';
	
	var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			
			checkboxs[i].checked = true;
		}else{
			
			checkboxs[i].checked = false;
		}	
		
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







	

	
	function ReviseItem(){
		
		var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择产品");
		return false;	
	}
	
		
		var url	= "ReviseItem.php?itemid="+bill;
		
		openwindow(url,"Smart",500,500);
	
	}
	
	function editproducts(){
	
		
		var url	= "addrelist.php";
		window.open(url,'_blank');
	
	
	}
	
	function enditem(bill){

		if(confirm("确认删除吗")){

		var url	= "enditem.php?id="+bill;
		openwindow(url,"Smart",300,200);


		}

	}
	
	

	function liststatus(){
		
		
		var account		 	= document.getElementById("account").value;
		if(account == '' ){
			alert('Please select account');
			return false;
		}
		var url	= "liststatus.php?account="+account;
		window.open(url,"_blank");
		
		
		
	}


	function readditem(){
		
		var bill	= "";
			var checkboxs = document.getElementsByName("ordersn2");
   			 for(var i=0;i<checkboxs.length;i++){
				if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		alert("请选择产品");
		return false;	
	}
		var url	= "readditem.php?id="+bill;
		
		openwindow(url,"Smart",300,200);
		
		
	}
function AddItem(){
		
		var bill	= "";
			var checkboxs = document.getElementsByName("ordersn");
   			 for(var i=0;i<checkboxs.length;i++){
				if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择产品");
		return false;	
	}
	
		
		var url	= "AddItem.php?id="+bill;
		
		openwindow(url,"Smart",300,200);
		
		
	}
	
	
	
	function verify(){
		
		var bill	= "";
			var checkboxs = document.getElementsByName("ordersn");
   			 for(var i=0;i<checkboxs.length;i++){
				if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择产品");
		return false;	
	}
	
		
		var url	= "verify.php?id="+bill;
		
		openwindow(url,"Smart",600,400);
		
		
	}
	
		function listhours(){
		
			var bill	= "";
			var checkboxs = document.getElementsByName("ordersn");
   			 for(var i=0;i<checkboxs.length;i++){
				if(checkboxs[i].checked == true){			
			bill =  checkboxs[i].value;		
		}		
		}
		
		if(i>1){
		
		alert('一次只能设置一个定时规则');
		return false;
			
			
			
		}
		
		var url	= "listhours.php?id="+bill;
		
		openwindow(url,"Smart",700,600);
		
		
	}
	
	
	function Modifysku(){
	
		
		
		/* 检查非组合sku的产品列表 */
		var bill	= "";
		
		var billstr	= "";
		
			var checkboxs = document.getElementsByName("ordersn2");
   			 for(var i=0;i<checkboxs.length;i++){
				if(checkboxs[i].checked == true){			
				bill +=  checkboxs[i].value;
				var StartPrice		= document.getElementById('StartPrice'+checkboxs[i].value).value;
				var Quantity		= document.getElementById('Quantity'+checkboxs[i].value).value;
				
				
				var SKU		= document.getElementById('SKU'+checkboxs[i].value).value;
				billstr				+= checkboxs[i].value+"*"+StartPrice+"*"+Quantity+"*"+SKU+"@@";
				
				
			}		
		}
		
		
		/* 检查非组合sku的产品列表 */
		var bill2	= "";
		var billstr2	= "";
		
			var checkboxs = document.getElementsByName("ordersn3");
   			 for(var i=0;i<checkboxs.length;i++){
				if(checkboxs[i].checked == true){			
				bill +=  checkboxs[i].value;
				var StartPrice		= document.getElementById('KStartPrice'+checkboxs[i].value).value;
				var Quantity		= document.getElementById('KQuantity'+checkboxs[i].value).value;
				var KSKU		= document.getElementById('KSKU'+checkboxs[i].value).value;
			
				billstr2				+= checkboxs[i].value+"*"+StartPrice+"*"+Quantity+"*"+KSKU+"@@";
				
				
			}		
		}
		
		
		
		
		var url	= "listing_batchupdate.php?billstr="+encodeURIComponent(billstr)+"&billstr2="+encodeURIComponent(billstr2);
		openwindow(url,"Smart",700,600);
	
	}
	function search(){
	
	
		var keys 			= document.getElementById("keys").value;
		var type		 	= document.getElementById("searchtype").value;
		var ListingType 	= document.getElementById("ListingType").value;
		var account		 	= document.getElementById("account").value;
		window.location.href = 'listing.php?module=list&action=<?php echo $_REQUEST['action']; ?>&status=<?php echo $ostatus;?>&keys='+encodeURIComponent(keys)+'&searchtype='+type+"&ListingType="+ListingType+"&account="+account;
	}
	
	
	function track_list(id){
		var url	= "track_list.php?id="+id;
		openwindow(url,"Smart",700,600);
	}
	
	
	function Modifysku02(){
	
		
		
		
		//var url	= "liststatus.php";
	//	window.open(url,"_blank");
		
	}
	
	
	function Modifysku03(){
	
		
		
		alert('如果库存的中的sku 数量为0 ,则系统不会更新到ebay');
		
		var url	= "liststatus02.php";
		window.open(url,"_blank");
		
	}
	
	
	document.onkeydown=function(event){
  e = event ? event :(window.event ? window.event : null);
  if(e.keyCode==13){
 search();
  }
 }
	
</script>