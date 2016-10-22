<?
//header("Content-type:application/vnd.ms-doc;");
//header("Content-Disposition:filename=test.doc");
?>
<?php

	include "include/config.php";
	
	
	
			$hunhe		= $_REQUEST['hunhe'];
			
			
			$ertj		= "";
			$orders		= explode(",",$_REQUEST['ordersn']);
			for($g=0;$g<count($orders);$g++){
		
		
				$sn 	=  $orders[$g];
				if($sn != ""){
				
					$ertj	.= " a.ebay_id ='$sn' or";
				}
			
			}
			$ertj			 = substr($ertj,0,strlen($ertj)-3);
			
			$status			 = '';
			
			
	
			$sql	= "select a.*,b.ebay_id as ddd,b.ebay_itemid,b.ebay_itemtitle,b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn  where ($ertj) GROUP BY a.ebay_id ";



			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			
			
		
			
				
		
			
		
?>
<style type="text/css">
<!--
table{font-family:Arial, Helvetica, sans-serif;}
.table {border: 0px dotted #CCCCCC; }
.STYLE4 {font-size: 12px; font-family:Arial, Helvetica, sans-serif;}
.styleth{font-size: 14px; font-family:"宋体";}
.style14b{font-size: 14px;font-family:Arial, Helvetica, sans-serif;}
.styletracknb{font-size:14px;}
-->
</style>
<style media="print"> 
.noprint { display: none } 
</style> 

<script > 

self.moveTo(0,0);
self.resizeTo(screen.availWidth,screen.availHeight);
self.focus();
function doPrintSetup(){ 
//打印设置 
WB.ExecWB(8,1) 
} 
function doPrintPreview(){ 
//打印预览 
WB.ExecWB(7,1) 
} 
function doprint(){ 
//直接打印 
WB.ExecWB(6,6) 
} 

/*

function window.onload() { 

//idPrint1.disabled = false; 
//idPrint3.disabled = false; 

} 
*/
</script>

<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<div class="noprint" align="right">
<input type="button" id="preview" value="打印预览" onclick="previewPage()"/>
<input type="button" id="printpage" value="打印" onclick="printPage()"/>
<input type="button" id="printpagedirect" value="使用默认打印机直接打印" onclick="printPageDirect()"/>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:8px;">
	<tr>
		<td width="55%" align="right">
			<span style="font-size:18px;font-weight:bold;">包装清单  (<?php echo $status;?>)</span>
		</td>
		<td align="right">
			<?php echo date('Y-m-d H:i:s'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>



<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr height="24">
    <td align="center"><span class="styleth"> 包装编号</span></td>
    <td align="center"><span class="styleth">店名</span></td>
    <td align="center"><span class="styleth">收件人地址</span></td>
    <td align="center"><span class="styleth">货位号</span></td>
    <td align="center"><span class="styleth">产品编号</span></td>
    <td align="center"><span class="styleth">数量</span></td>
    <td align="center"><span class="styleth">邮寄方式<br />
    </span></td>
    <td align="center"><span class="styleth">重量</span></td>
    <td align="center"><span class="styleth"> 备注</span></td>
  </tr>
  
  <?php
  
  $d		= 0;
  
  for($i=0;$i<count($sql);$i++){
  
  
  		
		$ebay_tracknumber		= $sql[$i]['ebay_tracknumber'];
	  	$ebay_username	    	= $sql[$i]['ebay_username'];
	    $ebay_account	    	= $sql[$i]['ebay_account'];
		$ebay_ordersn   		= $sql[$i]['ebay_ordersn'];
		$ebay_id		   		= $sql[$i]['ebay_id'];
		
		$name				= $sql[$i]['ebay_username'];
		$name	  			= str_replace("&acute;","'",$name);
		$name  				= str_replace("&quot;","\"",$name);
	    $street1			= @$sql[$i]['ebay_street'];
	    $street2 			= @$sql[$i]['ebay_street1'];
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
	    $countryname 		= $sql[$i]['ebay_countryname'];
	    $zip				= $sql[$i]['ebay_postcode'];
	    $tel				= $sql[$i]['ebay_phone'];
		$recordnumber1		= $sql[$i]['recordnumber'];
		$ebay_carrier		= $sql[$i]['ebay_carrier'];
		
		//$addressline		= $name.$street1.' '.$street2.'<br>'.$city.' '.$state.' '.$zip.' '.$countryname;
		
		
		$addr_line_one = $name.$street1.' '.$street2;
		$addr_line_two = $city.' '.$state.' '.$zip.' '.$countryname;
		$addressline   = (strlen($addr_line_one)>35)?substr($addr_line_one,0,32).'...<br>':$addr_line_one.'<br>';
		$addressline   .= (strlen($addr_line_two)>35)?substr($addr_line_two,0,32).'...':$addr_line_two;
		
		/*
		if(strlen($name.$street1.$street2) < 35)
		{
		   $addressline		= $name.$street1.' '.$street2.'<br>'.$city.' '.$state.' '.$zip.' '.$countryname;
		}
		else
		{
		   $addressline = substr($name.$street1.' '.$street2,0,35).'...<br>'.$city.' '.$state.' '.$zip.' '.$countryname;
		}
		*/
		
		
		
	   
	   $ss		= "select * from ebay_account where ebay_account ='$ebay_account' ";
	   $ss		= $dbcon->execute($ss);
	   $ss		= $dbcon->getResultArray($ss);
	   $id		= $ss[0]['id'];
	 
	   $appname		= $ss[0]['appname'];
	   
	   $ss		= "select * from eub_account where pid ='$id' ";
	   $ss		= $dbcon->execute($ss);
	   $ss		= $dbcon->getResultArray($ss);
	   
	   $dname	= $ss[0]['dname'];
	   
	   
	   $ss		= "select * from ebay_orderdetail where ebay_ordersn ='$ebay_ordersn' ";
	   $ss		= $dbcon->execute($ss);
	   $ss		= $dbcon->getResultArray($ss);
	   $qty		= 0;
	   $goods_sbjz	= 0;
	   $goods_weight	= 0;
	   $goods_weight	= 0;
	   $goods_ywsbmc	= '';
	   
	   for($g=0;$g<count($ss);$g++)
	   {
	   	
			$qty			 = $ss[$g]['ebay_amount'];
			$sku			 = $ss[$g]['sku'];
			$notes			 = $ss[$g]['notes'];
			
			
			$d++;
			
			
	   		
			$gg		= "select * from ebay_goods where goods_sn ='$sku' and ebay_user ='$user'";
			$gg		= $dbcon->execute($gg);
	   		$gg		= $dbcon->getResultArray($gg);
			
			$goods_location		 = $gg[0]['goods_location'];
			$goods_weight	 = $gg[0]['goods_weight'];
			$goods_ywsbmc	 = $gg[0]['goods_ywsbmc'].' ';
			
	   		if($g >0){
				
				$addressline	= '';
				$appname		= '';
				
			
			}
	   

	   
	   
  ?>
  <tr>
    <td>
      <div align="center"><span class="STYLE4"><strong>
        
        <?php if($g == 0){ ?>
        <?php echo $ebay_ordersn;?></strong></span><br />
        
        <img src="barcode128.class.php?data=<?php echo $ebay_ordersn ?>" alt=""/>
        <?php } ?>
    &nbsp;</div></td>
    <td align="center"><span class="STYLE4"><?php echo $appname;?>&nbsp;</span></td>
    <td style="padding-left:2px;"><span class="STYLE4"><?php echo $addressline?>&nbsp;</span></td>
    <td align="center"><span class="style14b"><?php echo $goods_location;?>&nbsp;</span></td>
    <td><div align="center"><span class="STYLE4"><strong><?php echo $sku;?></strong></span><br />
    <img src="barcode128.class.php?data=<?php echo $sku ?>" alt=""/>&nbsp;</div></td>
    <td align="center"><span class="STYLE4"><?php 
	
	if($qty >=2){
	
	echo '<strong>'.$qty.'</strong>';
	}else{
	echo $qty;
	
	}
	
	
	
	
	?>&nbsp;</span></td>
    <td align="center"><span class="STYLE4"><?php echo ($g == 0)?$ebay_carrier:'';?>&nbsp;</span></td>
    <td align="center"><span class="STYLE4"><?php echo $goods_weight;?>&nbsp;</span></td>
    <td align="center" class="styletracknb"><?php echo ($g == 0)?$ebay_tracknumber:'';//echo $notes;?>&nbsp;</td>
  </tr>
  
  <?php
	if($hunhe == '0')//多件
	{
	    if($g+1<count($ss) || ($i+1)<count($sql))
		{
			$suffix_condition = true;
		}
	}
	else
	{
		$suffix_condition = $i+1<count($sql)?true:false;
	}
	
    if((($d+1) % 13) == 0 && $suffix_condition){ ?>
</table>
<br />

    <div  style="page-break-after:always;"><div align="center">拣 货人_________________ 二次分检_________________扫描_________________包货人_________________</div></div>
     
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:8px;">
	<tr>
		<td width="55%" align="right">
			<span style="font-size:18px;font-weight:bold;">包装清单  (<?php echo $status;?>)</span>
		</td>
		<td align="right">
			<?php echo date('Y-m-d H:i:s'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>



   <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">

    <tr height="24">
    <td align="center"><span class="styleth"> 包装编号</span></td>
    <td align="center"><span class="styleth">店名</span></td>
    <td align="center"><span class="styleth">收件人地址</span></td>
    <td align="center"><span class="styleth">货位号</span></td>
    <td align="center"><span class="styleth">产品编号</span></td>
    <td align="center"><span class="styleth">数量</span></td>
    <td align="center"><span class="styleth">邮寄方式<br />
    </span></td>
    <td align="center"><span class="styleth">重量</span></td>
    <td align="center"><span class="styleth"> 备注</span></td>
  </tr>
  <?php } ?>
  

  
	  <?php 
	   }
	  ?>
  
  
   
  
  
  <?php  
  }
  ?>
</table><br />

 <div style="page-break-after:always;"><div align="center">拣 货人_________________  二次分检_________________  扫描_________________  包货人_________________</div></div>
 <script type="text/javascript">
AC_AX_RunContent( 'id','factory','viewastext','viewastext','style','display:none','classid','clsid:1663ed61-23eb-11d2-b92f-008048fdd814','codebase','smsx.cab#Version=6,6,440,26' ); //end AC code
</script><noscript><object id="factory" viewastext style="display:none" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="smsx.cab#Version=6,6,440,26"></object></noscript>
 <!--<object id="factory" viewastext style="display:none" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="smsx.cab#Version=6,6,440,26"></object>-->
 <!--<object id="factory" classid="clsid:1663ED61-23EB-11D2-B92F-008048FDD814" codebase="http://codestore.meadroid.com:80/products/ScriptX/binary.ashx?version=6,6,440,26&amp;filename=smsx.cab&amp;hashKey=6ffafc6e-1cea-4860-a298-bb532d2095ec&amp;usage=http://www.meadroid.com#Version=6,6,440,26" viewastext ></boject>-->
 <!--<object id="factory" style="display:none" viewastext classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="http://www.meadroid.com/scriptx/ScriptX.cab#Version=5,60,0,360"></object>-->
 <script type="text/javascript">
AC_AX_RunContent( 'classid','CLSID:8856F961-340A-11D0-A96B-00C04FD705A2','id','wb','name','wb','height','0','width','0' ); //end AC code
</script><noscript><OBJECT classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2" id=wb name=wb height=0 width=0></OBJECT></noscript>
 <script type="text/javascript" defer="defer">
	function setPage()
	{
		//HP LaserJet M1005
		//factory.printing.printer = "EPSON ME 600F Series";
		//factory.printing.printer = "HP LaserJet M1005";
    
    
    if(!factory.object)
    {
    		document.getElementById('preview').disabled = true;
    		document.getElementById('printpage').disabled = true;
    		document.getElementById('printpagedirect').disabled = true;
    		return;
    }
    
    
		factory.printing.header = "&b&b page: &p of &P";
		factory.printing.footer = "";
		//factory.printing.footer = "&b&b page: &p of &P";
		factory.printing.portrait = false;
		factory.printing.leftMargin = 5;
		factory.printing.topMargin = 15;
		factory.printing.rightMargin = 3;
		factory.printing.bottomMargin = 3;
		
		//factory.printing.Print(false);
		//factory.printing.Preview();

	}
	
	function previewPage()
	{
		//setPage();
		factory.printing.Preview();
	}
	
	function printPage()
	{
		//setPage();
		factory.printing.Print(true);
	}
	
	function printPageDirect()
	{
	    //setPage();
	    //factory.printing.Print(true);
	    wb.ExecWB(6,6);
		/*
	    try
		{
			setPage();
			factory.printing.Print(false);
		}
		catch(e)
		{
			alert('Failure');
		]
		*/
	}
	window.onload = setPage;

</script>