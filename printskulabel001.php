<?php
	include "include/config.php";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style media="print"> 

.noprint { display: none } 




</style> 

<style type="text/css">
<!--
body {
	margin-top: 0px;
}
.STYLE1 {
	font-size: 29px;
	font-weight: bold;
}
-->
</style>




</div>





<?php
	
	
	$sku  = $_REQUEST['sku'];
	
	$ss		= "select * from ebay_goods where goods_sn='$sku' and ebay_user ='$user' ";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	
	
	$goods_name		= $ss[0]['goods_name'];
	
	
 

 

  ?>



 


    <table width="200" height="100" border="0" cellpadding="0" cellspacing="0" style="border:1px dashed #999999; height:40mm; width:80mm">



      <tr>

        <td width="244" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td><div align="center"><?php echo $goods_name;?></div></td>
</tr>
<tr>
              <td><div align="center"><img src="barcode128.class.php?data=<?php echo $sku; ?>" alt="" width="214" height="70"/></div></td>
          </tr>

        <tr>
              <td><div align="center" class="STYLE1"><?php echo $sku; ?></div></td>
          </tr>
            <tr>
              <td></td>
            </tr>
        </table></td>
      </tr>
    </table>


  

  



  

  
  <div style="page-break-after:always;">&nbsp;</div>
