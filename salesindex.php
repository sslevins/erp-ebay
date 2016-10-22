<?php
include "include/config.php";
include "include/function.php";


include "top.php";
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 <?php
 
 
if ($_GET['act']=='add')
{
$sku=$_GET['sku'];
$price3=$_GET['price'];
$shipfree3=$_GET['shipfree'];

$price=$_GET['price'];
$shipfree=$_GET['shipfree'];
$sku1=$_GET['sku1'];
$sku2=$_GET['sku2'];
$qty1=$_GET['qty1'];
$qty2=$_GET['qty2'];
if ($_GET['price1']!='')
{$price=$_GET['price1'];
$shipfree=$_GET['shipfree1'];
$price1=$_GET['price1'];
$shipfree1=$_GET['shipfree1'];
$dlfree=$_GET['dlfree'];
}
$sqlRMB="select * from ebay_currency where currency ='RMB'";
$sqlEUR="select * from ebay_currency where currency ='EUR'";
$sqlAUD="select * from ebay_currency where currency ='AUD'";
$sqlGBP="select * from ebay_currency where currency ='GBP'";
	$sqlRMB = $dbcon->execute($sqlRMB);//  中国
		$rsRMB = $dbcon->getResultArray($sqlRMB);
$rsEUR = $dbcon->execute($sqlEUR);// 欧元 德国
		$rsEUR = $dbcon->getResultArray($rsEUR);

$rsAUD = $dbcon->execute($sqlAUD);//澳元 澳大利亚
		$rsAUD = $dbcon->getResultArray($rsAUD);
 
$rsGBP = $dbcon->execute($sqlGBP);//英  /英国
		$rsGBP = $dbcon->getResultArray($rsGBP);
 $RMB=1/$rsRMB[0]['rates'];
$EUR=1/$rsEUR[0]['rates'];
$AUD=1/$rsAUD[0]['rates'];
$GBP=1/$rsGBP[0]['rates'];
 /*
$rsbf= mysql_query("select * from erp_code where code ='".$sku."'");

$rsbsd=mysql_query("select count(*) as countnum from  erp_code where code ='".$sku."' ");
	 
while ($rsdd=mysql_fetch_array($rsbsd))
		{
	$countnumd=	$rsdd[countnum];
		}
 
	if ($countnumd>0){
	 
		while ($rsf=mysql_fetch_array($rsbf))
		{
		$rsbfg= mysql_query("select * from erp_code_number where code_id ='".$rsf[id]."'");
		while ($rsfgf=mysql_fetch_array($rsbfg))
			{
$sql="select * from erp_products_data where products_sku ='".$rsfgf[sku]."'";
$rs=db_execute($sql);
$a=$a+ $rs['products_value']*$rsfgf[number];
$ship= get_shipping_fee_use_weight($rs['products_weight']*$rsfgf[number]);
$products_weight=($rs['products_weight']*$rsfgf[number]);
//echo $a."成本";
			}

                }

		}else*/
				if (1==1)
{
		if ($sku!='')
{
$sql="select * from ebay_goods where goods_sn ='".$sku."'";
 	$rs = $dbcon->execute($sql);
	$rs = $dbcon->getResultArray($rs);
 
$a= $rs[0]['goods_cost'];
 //$astatus= $rs['products_remark_2'];

$ship= get_shipping_fee_use_weight($rs[0]['goods_weight']*1000);
$products_weight=$rs[0]['goods_weight'];
}
if ($_GET['price1']!='')
{
$sql="select * from ebay_goods where goods_sn ='".$sku1."'";
 	$rs = $dbcon->execute($sql);
	$rs = $dbcon->getResultArray($rs);
 
$a= $rs[0]['goods_cost']*$qty1;
//$astatus1= $rs['products_remark_2'];
  
$ship= get_shipping_fee_use_weight($rs[0]['goods_weight']*$qty1*1000);
  
$products_weight=$rs[0]['goods_weight']*$qty1;
}
if ($_GET['qty2']!='')
{
$sql="select * from ebay_goods where goods_sn ='".$sku2."'";
//$rs=db_execute($sql);
	$rs = $dbcon->execute($sql);
		$rs = $dbcon->getResultArray($rs);

$a=$a+ $rs[0]['goods_cost']*$qty2;
//$astatus2= $rs['products_remark_2'];

$products_weight=$products_weight+$rs[0]['goods_weight']*$qty2;
$ship=get_shipping_fee_use_weight($products_weight*1000);

}

}

  
$products_weight=$products_weight*1000;

 if ($products_weight<=50)
{$ship=$products_weight*0.071; }

if ($products_weight<=50)
{$shipd=4.62; }
if ($products_weight>50)
{$shipd= $products_weight*0.0924;}

 if ($products_weight<2000){
$shipc=  get_shipping_fee_use_weight($products_weight) +8;

}else{$shipc=$ship;}
/*
if ($_GET['price1']=='' & $rs['xiaobaofee']!=0)
{
$ship=$rs['xiaobaofee'];
$shipd =$rs['eubfee'];
$shipc=$rs['guahaofee'];
			 
}*/
$ship=round($ship, 2); 
 $m1;
$m2;
$m3;
$m4;
//get_shipping_fee_use_weight($rs['products_weight'])
//$rs['products_value'];
$acount=($price+$shipfree);

	if ($_GET['paypal']==1) $paypal=0.029;
	if ($_GET['paypal']==2)$paypal=0.032;
	if ($_GET['paypal']==3)	$paypal=0.034;
	if ($_GET['paypal']==4) $paypal=0.039;
	if ($_GET['paypal']==5)$paypal=0.06;
	
	
	if ($acount<50)
	{
	$m1d=$dlfree;
	
	 
	if ($_GET['catetry']==1) $m1c=$acount*0.11;
		if ($_GET['catetry']==2)$m1c=$acount*0.07;
	if ($_GET['catetry']==3)	$m1c=$acount*0.10;
	$m1c=round($m1c, 2); 
	$m1p=$acount*$paypal+0.3;
	if ($_GET['paypal']==5)$m1p=$acount*$paypal+0.05;
	$m1p=round($m1p, 2); 
$MS1.=  "M=".$m1d."+". $m1c."+". $m1p."<br>";
	$m1=$m1d+$m1c+$m1p;
	$m1g=$m1c+$m1p;
	
	}
	else
	{
	  $m1d=$dlfree;
	if ($_GET['catetry']==1)	$m1c=($acount-50)*0.06+50*0.11;
	if ($_GET['catetry']==2)    $m1c=($acount-50)*0.05+50*0.07;
	if ($_GET['catetry']==3)    $m1c=($acount-50)*0.08+50*0.10;
	$m1c=round($m1c, 2); 
	$m1p=$acount*$paypal+0.3;
		if ($_GET['paypal']==5)$m1p=$acount*$paypal+0.05;

	$m1p=round($m1p, 2); 
	$m1=$m1d+$m1c+$m1p;
	$m1g= $m1c+$m1p;
	$m11=$m1d+$m1c+$m1p;
	$MS1.=  "M=".$m1d."+". $m1c."+". $m1p."<br>";
	}

	if ($price<50)
	{
	$m2d=$dlfree;
	
	$m2c=$price*0.099;
	if ($_GET['catetry']==2)$m2c=$price*0.03;
	$m2c=round($m2c, 2); 
	$m2p=$acount*$paypal+0.2;
		if ($_GET['paypal']==5)$m2p=$acount*$paypal+0.05;

	$m2p=round($m2p, 2); 
	$m2=$m2d+$m2c+$m2p;
	$m4d=$dlfree;
	$m4c=$price*0.099;
	$m4p=$acount*$paypal+0.35;
		if ($_GET['paypal']==5)$m4p=$acount*$paypal+0.05;

	$m4c=round($m4c, 2); 
	$m4p=round($m4p, 2); 
	$m4=$m4d+$m4c+$m4p;
	 $MS2.=  "M=".$m2d."+". $m2c."+". $m2p."<br>";
	 $MS4.=  "M=".$m4d."+". $m4c."+". $m4p."<br>";

	
	}
	else
	{
	 $m1d=$dlfree;
	$m2c=($price-50)*0.0495+50*0.099;
	//	if ($_GET['catetry']==2)$m2c=($price-50)*0.0495+50*0.03;
	if ($_GET['catetry']==2)$m2c=$price*0.03;
	$m2c=round($m2c, 2); 
	$m2p=$acount*$paypal+0.2;
		if ($_GET['paypal']==5)$m2p=$acount*$paypal+0.05;

	$m2p=round($m2p, 2); 
	$m2=$m2d+$m2c+$m2p;
	
	$m4d=$dlfree;
	$m4c=50*0.099+($price-50)*0.06;
	$m4p=$acount*$paypal+0.35;
		if ($_GET['paypal']==5)$m4p=$acount*$paypal+0.05;

	$m4c=round($m4c, 2); 
	$m4p=round($m4p, 2); 
	$m4=$m4d+$m4c+$m4p;
	$MS4.=  "M=".$m4d."+". $m4c."+". $m4p."<br>";
	$MS2.=  "M=".$m2d."+". $m2c."+". $m2p."<br>";
	}

	if ($price<75)
	{
	 $m3d=$dlfree;
	$m3c=$price*0.079;
	$m3p=$acount*$paypal+0.3;
		if ($_GET['paypal']==5)$m3p=$acount*$paypal+0.05;

	$m3=$m3d+$m3c+$m3p;
	$m3p=round($m3p, 2); 
	$m3c=round($m3c, 2); 
	 $m32d=$dlfree;
	$m32c=$price*0.074;
	$m32p=$acount*$paypal+0.3;
		if ($_GET['paypal']==5)$m32p=$acount*$paypal+0.05;

	$m32p=round($m32p, 2); 
	$m32c=round($m32c, 2); 
	 $m32=$m32d+$m32c+$m32p;
	$MS3.=  "M=".$m3d."+". $m3c."+". $m3p."<br>";
	$MS32.=  "M=".$m32d."+". $m32c."+". $m32p."<br>";


	}
	else
	{
 	 $m3d=$dlfree;
	$m3c=($price-75)*0.04+5.55;
	$m3p=$acount*$paypal+0.35;
		if ($_GET['paypal']==5)$m3p=$acount*$paypal+0.05;

	$m3=$m3d+$m3c+$m3p;
	
	 $m32d=$dlfree;
	$m32c=($price-75)*0.04+5.55;
	$m32p=$acount*$paypal+0.35;
		if ($_GET['paypal']==5)$m32p=$acount*$paypal+0.05;

	$m32p=round($m32p, 2); 
	$m32c=round($m32c, 2); 
	$m32=$m32d+$m32c+$m32p;
	$MS3.=  "M=".$m3d."+". $m3c."+". $m3p."<br>";
	$MS32.=  "M=".$m32d."+". $m32c."+". $m32p."<br>";
	}
$x1=(($RMB*$acount-$RMB*$m1g)*0.96-$a-$RMB* $m1d-$ship)/($RMB*$acount);

$x1g=((round($RMB*$acount, 2)-round($RMB*$m1g,2))*0.96-$RMB* $m1d-$a-$shipc)/(round($RMB*$acount, 2));
$x11=((round($RMB*$acount, 2)-round($RMB*$m1,2))*0.96-$a-$shipd)/(round($RMB*$acount, 2));
//echo "X1=".$RMB ."*" .$acount."-".round($RMB*$m1,2)."-".$a."-".$ship."/".$RMB."*".$acount;
$xx1="X1=(".$RMB ."*" .$acount."-".round($RMB*$m1,2).")*0.96-".$a."-".$ship."/".$RMB."*".$acount;
$xx1g="X1=(".$RMB ."*" .$acount."-".round($RMB*$m1,2).")*0.96-".$a."-".$shipc."/".$RMB."*".$acount;

 $margin1=round($RMB*$x1, 2)*$acount;
  $margin1=(($RMB*$acount-$RMB*$m1g)*0.96-$a-$RMB* $m1d-$ship);
//$margin1=$x1=(($RMB*$acount-$RMB*$m1)*0.96-$a-$ship);
 $margin1g=round($RMB*$x1g, 2)*$acount;
  $margin11=round($RMB*$x11, 2)*$acount;
   $margin1= number_format( $margin1, 2, '.', '');
 $x1=number_format($x1*100, 2, '.', '') ."%";
 $x1g=number_format($x1g*100, 2, '.', '') ."%";

 $x11=number_format($x11*100, 2, '.', '') ."%";
$x2=(($RMB*(round($acount/$GBP, 2))-$RMB*round($m2/$GBP, 2))*0.96-$a-$ship)/($RMB*(round($acount/$GBP,2)));
$x2g=(($RMB*(round($acount/$GBP, 2))-$RMB*round($m2/$GBP, 2))*0.96-$a-$shipc)/($RMB*(round($acount/$GBP,2)));

//echo "<br>";
$xx2= "X2=(".$RMB ."*" .round($acount/$GBP,2)."-".round($RMB*round($m2/$GBP, 2),2).")*0.96-".$a."-".$ship."/".$RMB."*".round($acount/$GBP,2);
//echo "X2=".$RMB ."*" .round($acount/$GBP,2)."-".round($RMB*round($m2/$GBP, 2),2)."-".$a."-".$ship."/".$RMB."*".round($acount/$GBP,2);
 $margin2=$RMB*(round($x2/$GBP,2))*$acount;
 $margin2g=$RMB*(round($x2g/$GBP,2))*$acount;

   $margin2= number_format( $margin2, 2, '.', '');

 $x2=number_format($x2*100, 2, '.', '') ."%";
  $x2g=number_format($x2g*100, 2, '.', '') ."%";
$x3=(($RMB*(round($acount/$AUD,2))-$RMB*round($m3/$AUD, 2))*0.96-$a-$ship)/($RMB*(round($acount/$AUD,2)));
$x3g=(($RMB*(round($acount/$AUD,2))-$RMB*round($m3/$AUD, 2))*0.96-$a-$shipc)/($RMB*(round($acount/$AUD,2)));

//echo "<br>";
//echo "X3=".$RMB ."*" .round($acount/$AUD,2)."-".round($RMB*round($m3/$AUD, 2),2)."-".$a."-".$ship."/".$RMB."*".round($acount/$AUD,2);
$xx3= "X3=(".$RMB ."*" .round($acount/$AUD,2)."-".round($RMB*round($m3/$AUD, 2),2).")*0.96-".$a."-".$ship."/".$RMB."*".round($acount/$AUD,2);


$x32=(($RMB*(round($acount/$AUD,2))-$RMB*round($m32/$AUD, 2))*0.96-$a-$ship)/($RMB*(round($acount/$AUD,2)));
$x32g=(($RMB*(round($acount/$AUD,2))-$RMB*round($m32/$AUD, 2))*0.96-$a-$shipc)/($RMB*(round($acount/$AUD,2)));

  $margin32=$RMB*(round($x32/$AUD,2))*$acount;
   $margin32g=$RMB*(round($x32g/$AUD,2))*$acount;
	  $margin32= number_format($margin32, 2, '.', '');
 $x32=number_format($x32*100, 2, '.', '') ."%";
 $x32g=number_format($x32g*100, 2, '.', '') ."%";
  $margin3=$RMB*(round($x3/$AUD,2))*$acount;
  $margin3g=$RMB*(round($x3g/$AUD,2))*$acount;
  
  $margin3= number_format( $margin3, 2, '.', '');

 $x3=number_format($x3*100, 2, '.', '') ."%";
 $x3g=number_format($x3g*100, 2, '.', '') ."%";

$x4=(($RMB*(round($acount/$EUR,2))-$RMB*round($m4/$EUR, 2))*0.93-$a-$ship)/($RMB*(round($acount/$EUR,2)));
$x4g=(($RMB*(round($acount/$EUR,2))-$RMB*round($m4/$EUR, 2))*0.93-$a-$shipc)/($RMB*(round($acount/$EUR,2)));

//echo "<br>";
//echo "X4=".$RMB ."*" .round($acount/$EUR,2)."-".round($RMB*round($m4/$EUR, 2),2)."-".$a."-".$ship."/".$RMB."*".round($acount/$EUR,2);
$xx4= "X4=(".$RMB ."*" .round($acount/$EUR,2)."-".round($RMB*round($m4/$EUR, 2),2).")*0.93-".$a."-".$ship."/".$RMB."*".round($acount/$EUR,2);

 $margin4=$RMB*(round($x4/$EUR,2))*$acount;
 $margin4g=$RMB*(round($x4g/$EUR,2))*$acount;
  $margin4= number_format( $margin4, 2, '.', '');
 $x4=number_format($x4*100, 2, '.', '') ."%";
 $x4g=number_format($x4g*100, 2, '.', '') ."%";

 //	echo "<br>";  echo $ship;
 


}$ss=" 	x= [ (汇率*（售价+运费）-汇率*M)*坏货率 -成本 -实际运费]
               /
    汇率*（售价+运费）
<br>
M= 登陆费+成交费+paypal费用
";
?>
<script src='js/ajaxa.js'></script>
 <div id="main_frame_main">
  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" align="left" valign="top">
	<?php //include_once("includes/addup_button_group.php");?>
    <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td bgcolor="#D1FFCE"> </td>
      </tr>
	  
	  <tr>  
	  <td bgcolor="#D1FFCE" align="center"> 
	  
	      <form action="" method="get" name="form_files" id="form_files">
paypal类型<select name="paypal">
     <option value="1">paypal2.9% </option>
     <option value="2">paypal3.2%</option>
     <option value="3">paypal3.4% </option>
	 <option value="4">paypal3.9% </option>
     <option value="5">小paypal6%+0.05 </option>
   </select>
	  类别<select name="catetry">
     <option value="1">other </option>
     <option value="2">electronic*</option>
     <option value="3">colse </option>
   </select>登陆费<input name="dlfree" type="text" id="dlfree" size="15"  value="<? echo $dl;?>" /></td> 
   </tr> 
   <tr><td>
   <table width="50%" border="0" cellspacing="0" cellpadding="3" align="left">
    
	<!--   <tr bgcolor="#D1FFCE">
	  <td align="right">paypal类型</td>
   <td><select name="paypal">
     <option value="1">paypal2.9% </option>
     <option value="2">paypal3.2%</option>
     <option value="3">paypal3.4% </option>
	 <option value="4">paypal3.9% </option>
     <option value="5">小paypal6%+0.05 </option>
   </select></td>
   </tr>
   --->
	<!---  <tr bgcolor="#D1FFCE">
	  <td align="right">类别</td>
   <td><select name="catetry">
     <option value="1">other </option>
     <option value="2">electronic*</option>
     <option value="3">colse </option>
   </select></td>
   </tr>
--->      <tr bgcolor="#D1FFCE">
        <td align="right">SKU号:</td>
        <td align="left"><input name="sku" type="text" id="sku" value="<? echo $sku;?>" size="15" /><font color="#FF0000"><? echo  $astatus;?></font></td>
      </tr>

      <tr bgcolor="#D1FFCE">
        <td align="right">售价:</td>
        <td align="left"><input name="price" type="text" id="price" size="15" value="<? echo $price3;?>" >
        (C)</td>
      </tr>
    <tr bgcolor="#D1FFCE">
        <td align="right">运费:</td>
        <td align="left"><input name="shipfree" type="text" id="shipfree" size="15"  value="<? echo $shipfree3;?>" />
          (D)</td>
      </tr>
	    <tr bgcolor="#D1FFCE">
        <td align="right">&nbsp; </td>
        <td align="left">
           </td>
      </tr>
    
      <tr bgcolor="#D1FFCE">
        <td align="left">&nbsp;</td>
        <td align="left"><input type="Submit" name="Submit" onclick="edit_order_log_ajax();" value="计算" />
		<input type="hidden" name="act" value="add" />		  
        <input type="button" name="Submit2" onclick="edit_order_log_ajax1();"  value="清空" /> 
        <?php   if  (1==1 ){?>    <input type="button" name="Submit5" value="改" onclick=" chk_this_orders_status('cyf'); "/>
			<? }?></td>
      </tr>
    </table>
	
	<table width="50%" border="0" cellspacing="0" cellpadding="3" align="right">
      
	<!---  <tr bgcolor="#D1FFCE" >
	  <td align="right">登陆费</td>
   <td><input name="dlfree" type="text" id="dlfree" size="15"  value="<? echo $dl;?>" /><!--<select name="catetry1" id="catetry1">
     <option value="1">other </option>
     <option value="2">electronic*</option>
     <option value="3">colse </option>
   </select></td> </tr>
--->      <tr bgcolor="#D1FFCE">
        <td align="right">SKU号:</td>
        <td align="left"><input name="sku1" type="text" id="sku1" value="<? echo $sku1;?>" size="15" /><font color="#FF0000"><? echo  $astatus1;?></font>
        数量<input name="qty1" type="text"  value="<? echo $qty1;?>" size="10" /></td>
		
      </tr>
	     <tr bgcolor="#D1FFCE">
        <td align="right">SKU号:</td>
        <td align="left"><input name="sku2" type="text" id="sku2" value="<? echo $sku2;?>" size="15" /><font color="#FF0000"><? echo  $astatus2;?></font>
        数量<input name="qty2" type="text"  value="<? echo $qty2;?>" size="10" /></td>
		
      </tr>
      <tr bgcolor="#D1FFCE">
        <td align="right">售价:</td>
        <td align="left"><input name="price1" type="text" id="price1" size="15" value="<? echo $price1;?>" >
        (C)</td>
      </tr>
      <tr bgcolor="#D1FFCE">
        <td align="right">运费:</td>
        <td align="left"><input name="shipfree1" type="text" id="shipfree1" size="15"  value="<? echo $shipfree1;?>" />
        (D)</td>
      </tr>
      
      
      <tr bgcolor="#D1FFCE">
        <td align="left">&nbsp;</td>
        <td align="left"><input type="Submit" name="Submit" value="计算" onclick="edit_order_log_ajax1();" />
		<input type="hidden" name="act" value="add" />		  
         <input type="button" name="Submit2" onclick="edit_order_log_ajax();"  value="清空" /> <?php   if  (1==1 ){?>    <input type="button" name="Submit5" value="改" onclick=" chk_this_orders_status('cyf'); "/>
			<? }?></td>
      </tr>
    </table>
		</form>

	  </td>
	  </tr>
</table></td>
  </tr>
  <tr>
 
  
		<td align="right" valign="top">
		<div id="orders_status_name" class="back_rz_box">
</div>
<!--	<div id="input_output_total">
	正在载入数据，请稍等，<img src="images/loading.gif" />&nbsp;&nbsp;	--->			<table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr bgcolor="#D1FFCE">
        <td align="center" colspan="8">无店铺</td>
     
      
        <td   align="center" colspan="12">有店铺</td>
        </tr>
	    <tr bgcolor="#D1FFCE">
        <td width="93" align="center">国家</td>
        <td width="69" align="center">利润</td>
        <td width="113" align="center">利润率</td>
		<td width="69" align="center">挂号利润</td>
        <td width="113" align="center">挂号利润率</td>
        
        <td width="53" align="center">登陆费</td>
        <td width="80" align="center">成交费</td>
	
		 <td width="80" align="center">paypal费</td>
		 		 

         <td width="123" align="center">国家</td>
         <td width="75" align="center">利润</td>
         <td width="86" align="center">利润率</td>
		 <td width="69" align="center">挂号利润</td>
        <td width="113" align="center">挂号利润率</td>
        <td width="54" align="center">成本</td>
		<td width="60" align="center">登陆费</td>
        <td width="80" align="center">成交费</td>
		 <td width="80" align="center">paypal费</td>
		 <td width="86" align="center">实际运费</td>
		  <td width="86" align="center">挂号运费</td>
        </tr>
		  <tr bgcolor="#D1FFCE">
        <td align="left"><span class="STYLE1">美国</span></td>
        <td width="69" align="center" id="text" onmouseover="create(this,0)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin1;?></td>
        <td width="113" align="center"><? echo $x1; ?></td>
         <td width="69" align="center" id="text" onmouseover="create(this,0)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin1g;?></td>
        <td width="113" align="center"><? echo $x1g; ?></td>
        
		<td width="53" align="center"><? echo $m1d; ?></td>
		<td width="80" align="center"><? echo $m1c; ?></td>
		<td width="80" align="center"><? echo $m1p; ?></td>
		

            <td align="left"><span class="STYLE1">美国</span></td>
            <td width="75" align="center"><? echo $margin1;?></td>
            <td width="86" align="center"><? echo $x1; ?></td>
			   <td width="75" align="center"><? echo $margin1g;?></td>
            <td width="86" align="center"><? echo $x1g; ?></td>
        <td width="54" align="center"><? echo $a; ?></td>
		<td width="60" align="center"><? echo $m1d; ?></td>
		<td width="80" align="center"><? echo $m1c; ?></td>
		<td width="80" align="center"><? echo $m1p; ?></td>
		<td width="86" align="center"><? echo number_format($ship, 2, '.', ''); ?></td>
		<td width="86" align="center"> <? echo number_format($shipc, 2, '.', ''); ?></td>
        </tr>
		
		
			  <tr bgcolor="#D1FFCE">
        <td align="left"><span class="STYLE1">美国EUB</span></td>
        <td width="69" align="center" id="text" onmouseover="create(this,0)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin11;?></td>
        <td width="113" align="center"><? echo $x11; ?></td>
          <td width="69" align="center" id="text" onmouseover="create(this,0)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin11;?></td>
        <td width="113" align="center"><? echo $x11; ?></td>
        
		<td width="53" align="center"><? echo $m1d; ?></td>
		<td width="80" align="center"><? echo $m1c; ?></td>
		<td width="80" align="center"><? echo $m1p; ?></td>
		

            <td align="left"><span class="STYLE1">美国EUB</span></td>
            <td width="75" align="center"><? echo $margin11;?></td>
            <td width="86" align="center"><? echo $x11; ?></td>
			  <td width="75" align="center"><? echo $margin11;?></td>
            <td width="86" align="center"><? echo $x11; ?></td>
        <td width="54" align="center"><? echo $a; ?></td>
		<td width="60" align="center"><? echo $m1d; ?></td>
		<td width="80" align="center"><? echo $m1c; ?></td>
		<td width="80" align="center"><? echo $m1p; ?></td>
		<td width="86" align="center"> <? echo number_format($shipd, 2, '.', ''); ?></td>
		<td width="86" align="center"> <? echo number_format($shipdd, 2, '.', ''); ?></td>
        </tr>
		
		  <tr bgcolor="#D1FFCE">
        <td align="left"><span class="STYLE1">英国</span></td>
        <td width="69" align="center" id="text" onmouseover="create(this,1)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin2;?></td>
        <td width="113" align="center"><? echo $x2; ?></td>
                <td width="69" align="center" id="text" onmouseover="create(this,1)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin2g;?></td>
        <td width="113" align="center"><? echo $x2g; ?></td>
		<td width="53" align="center"><? echo $m2d; ?></td>
		<td width="80" align="center"><? echo $m2c; ?></td>
		<td width="80" align="center"><? echo $m2p; ?></td>
		
            <td align="left"><span class="STYLE1">英国</span></td>
            <td width="75" align="center"><? echo $margin2;?></td>
            <td width="86" align="center"><? echo $x2; ?></td>
			            <td width="75" align="center"><? echo $margin2g;?></td>
            <td width="86" align="center"><? echo $x2g; ?></td>
        <td width="54" align="center"><? echo $a; ?></td>
		<td width="60" align="center"><? echo $m2d; ?></td>
		<td width="80" align="center"><? echo $m2c; ?></td>
		<td width="80" align="center"><? echo $m2p; ?></td>
		<td width="86" align="center"><? echo number_format($ship, 2, '.', ''); ?></td>
		<td width="86" align="center"><? echo number_format($shipc, 2, '.', ''); ?></td>
        </tr>
		  <tr bgcolor="#D1FFCE">
        <td align="left"><span class="STYLE1">澳大利亚</span></td>
        <td width="69" align="center" id="text" onmouseover="create(this,2)" style="cursor:pointer;" onMouseOut="del()"> <? echo $margin3;?></td>
        <td width="113" align="center"><? echo $x3; ?></td>
                <td width="69" align="center" id="text" onmouseover="create(this,2)" style="cursor:pointer;" onMouseOut="del()"> <? echo $margin3g;?></td>
        <td width="113" align="center"><? echo $x3g; ?></td>
		<td width="53" align="center"><? echo $m3d; ?></td>
		<td width="80" align="center"><? echo $m3c; ?></td>
		<td width="80" align="center"><? echo $m3p; ?></td>
		
            <td align="left"><span class="STYLE1">澳大利亚</span></td>
            <td width="75" align="center"><? echo $margin32;?></td>
            <td width="86" align="center"><? echo $x32; ?></td>
			            <td width="75" align="center"><? echo $margin32g;?></td>
            <td width="86" align="center"><? echo $x32g; ?></td>
        <td width="54" align="center"><? echo $a; ?></td>
		<td width="60" align="center"><? echo $m32d; ?></td>
		<td width="80" align="center"><? echo $m32c; ?></td>
		<td width="80" align="center"><? echo $m32p; ?></td>
		<td width="86" align="center"><? echo number_format($ship, 2, '.', ''); ?></td>
		<td width="86" align="center"><? echo number_format($shipc, 2, '.', ''); ?></td>
        </tr>
		  <tr bgcolor="#D1FFCE">
        <td align="left"><span class="STYLE1">德国</span></td>
        <td width="69" align="center" id="text" onmouseover="create(this,3)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin4;?></td>
        <td width="113" align="center"><? echo $x4; ?></td>
                <td width="69" align="center" id="text" onmouseover="create(this,3)" style="cursor:pointer;" onMouseOut="del()"><? echo $margin4g;?></td>
        <td width="113" align="center"><? echo $x4g; ?></td>
		<td width="53" align="center"><? echo $m4d; ?></td>
		<td width="80" align="center"><? echo $m4c; ?></td>
		<td width="80" align="center"><? echo $m4p; ?></td>
		
            <td align="left"><span class="STYLE1">德国</span></td>
            <td width="75" align="center"><? echo $margin4;?></td>
            <td width="86" align="center"><? echo $x4; ?></td>
			            <td width="75" align="center"><? echo $margin4g;?></td>
            <td width="86" align="center"><? echo $x4g; ?></td>
        <td width="54" align="center"><? echo $a; ?></td>
		<td width="60" align="center"><? echo $m4d; ?></td>
		<td width="80" align="center"><? echo $m4c; ?></td>
		<td width="80" align="center"><? echo $m4p; ?></td>
		<td width="86" align="center"><? echo number_format($ship, 2, '.', ''); ?></td>
		<td width="86" align="center"><? echo number_format($shipc, 2, '.', ''); ?></td>
        </tr>
		<tr><td colspan="10" align="center"> <b>EBAY业务员工作法则</b><br> <td><td colspan="10" align="center">
<b>
      EBAY业务员开店铺法则</b></td></tr>
		
			<tr><td colspan="10" align="left" > 

1.	禁止恶意竞争。恶意竞争包括：1).故意比公司帐号低0.01或更多。2).故意抄袭公司图片，混淆物品排名。
<br>2.	不同店铺间不允许价格战，不同店铺间不存在可比性。
<br><font color="#FF0000">3.	各站点利润红线以ERP为准，所有站点ERP利润不得低于7%,业务员可以相互监督。</font>
<br>4.	业务员应在1个小时内完成公司产品的调价下架描述更正等信息。
<br>5.	如果编码错误，则按业务员造成损失的30%进行赔偿。
<br>6.	低于10%利润的热卖产品，业务员须提交到ERP产品优化模块。
<td><td colspan="10" align="left">
 一、原则上不允许在没有开设店铺站点上传产品，原有帐户慢慢调整，新帐户则不允许，<br>如果有特别原因须到业务组负责人申请登记才能上传，最多不得超过以后规定的数目。
<br>
1.没有在（澳、德）开店铺，不得上传澳德站产品。
<br>2.（澳、德）店铺可上传美英站点产品，但上传一口价数量不能超过200.
<br>3.英国店铺可上传美国站产品，一口价数量不能超过500。
<br>4.美国店铺可上传英国站产品，一口价数量不能超过300。

</td></tr>

       </table>
 	</td>
  </tr>
</table>
 <? echo $ss;?>
     <div class="clear"></div>
<?php

include "bottom.php";


?>
<script>
var oo = true
var vv=["<?  echo"<br>".$xx1; ?>","<? echo "<br>".$xx2; ?>","<? echo "<br>".$xx3; ?>","<? echo "<br>".$xx4; ?>"]
function create(obj,num){
if(oo==true){
oo=false
var div =document.createElement("div")
div.className="f"
div.id="div"
div.innerHTML=vv[num]
document.body.appendChild(div)
var left=obj.offsetLeft
var top=obj.offsetTop
var width=obj.offsetWidth
while (obj=obj.offsetParent) {
left += obj.offsetLeft;
top += obj.offsetTop;
};
document.getElementById("div").style.left=left+width
document.getElementById("div").style.top=top
div.onmouseout=del
}}

function del(e){
e=e||event;
var obj=e.relatedTarget||e.toElement;
var div =document.getElementById("div")
if(div.contains(obj))return;
document.body.removeChild(div)
oo=true
}
function chk_this_orders_status(str)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}
   if (str=='cyfw')
   {
    var re_price=replace_code(document.getElementById('re_price').value);
	var ss=replace_code(document.getElementById('ss').value);
	var yus=document.getElementsByName('yus');
	var yusy=document.getElementsByName('yusy');

	var an_country=document.getElementsByName('an_country');
	 var en_country=document.getElementsByName('en_country');
 	var on_country=document.getElementsByName('on_country');
 	var dn_country=document.getElementsByName('dn_country');

	var sy=replace_code(document.getElementById('sy').value);
    var re_login=replace_code(document.getElementById('re_login').value);
    var re_paypal=replace_code(document.getElementById('re_paypal').value);
 	 var yus;
	 var yu;
	 var an;
	 var en;
	 var on;
	 var dn;
 if( yus[0].checked){		yus=replace_code(yus[0].value);}else{yus=0;}
 if( yusy[0].checked){		yu=replace_code(yusy[0].value);}else{yu=0;}
if( an_country[0].checked){	an=replace_code(an_country[0].value);}else{an=0;}
if( en_country[0].checked){		en=replace_code(en_country[0].value);}else{en=0;}
if( on_country[0].checked){		on=replace_code(on_country[0].value);}else{on=0;}
if( dn_country[0].checked){		dn=replace_code(dn_country[0].value);}else{dn=0;}
	var url="input_output_products.php?action=cyf&ss="+ss+"&yus="+yus+"&yu="+yu+"&an="+an+"&en="+en+"&on="+on+"&dn="+dn+"&sy="+sy+"&re_login="+re_login+"&re_paypal="+re_paypal+"&re_price="+re_price;
 	alert(url);
    url=encodeURI(url);
    xmlHttp.onreadystatechange=function (){chk_this_orders_status_result();};
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null); 
   }
   
    if (str=='cyf')
   {
      document.getElementById('orders_status_name').innerHTML='<div class="bak_rz"><table border="0" cellspacing="4" cellpadding="0" width="100%"><tr><td colspan="2">	有店铺<input name="yusy" type="checkbox" value="1">无店铺<input name="yus" type="checkbox" value="2"><br>条件<input name="ss" type="text"><br>(如：C+D>50)<br>美国<input name="an_country" type="checkbox" id="an_country" value="1">英国<input name="en_country"  id="en_country" type="checkbox" value="2"><br>澳大利亚<input name="on_country" id="on_country" type="checkbox" value="3">德国<input name="dn_country" id="dn_country" type="checkbox" value="4"><br>登陆费<textarea name="re_login" id="back_reason" style="width:180px; height:60px;"></textarea><br>成交费<textarea name="re_price" id="re_price" style="width:180px; height:60px;"></textarea><br>paypal费<textarea name="re_paypal" id="re_paypal" style="width:180px; height:60px;"></textarea><br>坏货率<input name="sy" type="text"></td></tr>  <tr><td align="left"></td>    <td><input type="button" name="Submit" value="确定" onclick="chk_this_orders_status(\'cyfw\');"><input type="button" name="Submit2" value="放弃" onclick="chk_this_orders_status(\'back_reason_close\');"></td></tr></table></div>';
   }
   if (str=='back_reason_close'){document.getElementById('orders_status_name').innerHTML='<font color="#ff9900"></font>';}

    
}


function chk_this_orders_status_result()
{
	if(xmlHttp.readyState==4)
	{
		if(xmlHttp.status==200){
		                 document.getElementById('orders_status_name').innerHTML=xmlHttp.responseText;
		                       }
	}	
}
function cl_order_log_ajax ()
{

  
 document.getElementById('sku').value='';
   document.getElementById('price').value='';
  document.getElementById('shipfree').value='';
}

function edit_order_log_ajax ()
{
 document.getElementById('sku1').value='';
  document.getElementById('qty1').value='';
   document.getElementById('sku2').value='';
  document.getElementById('qty2').value='';
   document.getElementById('price1').value='';
  document.getElementById('shipfree1').value='';
}
function edit_order_log_ajax1 ()
{
 document.getElementById('sku').value='';
    document.getElementById('price').value='';
  document.getElementById('shipfree').value='';
}
</script>
