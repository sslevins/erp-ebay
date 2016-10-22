<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="商乐APP,ebay工具" />
<meta name="description" content="商乐APP,ebay工具" />
<meta name="copyright" content="商乐APP" />
<title>我的ebay</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="jquery.js"></script>

<!--[if IE 6]>

<script type="text/javascript" src="DD_belatedPNG.js"></script>

	<script>

		DD_belatedPNG.fix('img, .tuangou, .tab_con1, .tab_con2, .tab_con3');

	</script>

<![endif]-->

<style>

body { font-family:"微软雅黑", Arial, Helvetica, sans-serif; font-size:12px; color:#222; margin:0px; padding:0px; background:url(); }

</style>
</head>
<body>
		
        
        <?php
			
			
			include "../include/dbconnect.php";
			$dbcon	= new DBClass();
			$show		= $_REQUEST['show'];   // 要显示的广告模板
			$id			= $_REQUEST['id'];	   // 对应模板下面的ID
			
			
			
			$sql		= "select * from ebay_advancenamedetail where pid = '$id' and salemodule = '0' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			
			
			
			
			
			/* 顶部广告模板 */
			
			
			if($show  == 'isfes_app_lattice'){
			
			
			echo '<div class="product_left">';
			
			
			$sql		= "select * from ebay_advancenamedetail where pid = '$id' and salemodule = '0' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){
					
					
					$itemid		= $sql[$i]['itemid'];

					$ebay_user		= $sql[$i]['ebay_user'];
					if($ebay_user == 'vipskf') die('the products is expired.');


					$type		= $sql[$i]['type'];
					$url	= "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=".$itemid;
					
					if($type  == '1'){
					$url	= $sql[$i]['url'];
					}
					$picurl		= $sql[$i]['picurl'];
			
			
		?>

<ul>
  <li><a href="<?php echo $url;?>" target="_blank"><img src="http://42.121.19.218/v3-all/images/<?php echo $picurl;?>" width="190" height="150" alt="A001" title="A001" onmouseover="brightMe(this)" onmouseout="brightAll()" /></a></li>
</ul>

       <?php
	   
	   
	   
	    }
		
		echo '</div>';
		
		 ?>
        



<script language="javascript" type="text/javascript">
$(document).ready(function(){

	

});

function brightMe(ctrl)

{

	$('img').each(function(){

		$(this).addClass('product_left_alpha');

	});

	$(ctrl).removeClass('product_left_alpha');

}

function brightAll()

{

	$('img').each(function(){

		$(this).removeClass('product_left_alpha');

	});

}

</script>

</body>

</html>
 <?php
			}
			
			
			if($show  == 'isfes_app_shop'){
			// btn_1_off
			
			/* 右侧  在线说明广告 */
			
			$sql		= "select * from ebay_advancename where id = '$id'  ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			
			$ebay_user		= $sql[0]['ebay_user'];
					if($ebay_user == 'vipskf') die('the products is expired.');
					
					
			
			$notice				= $sql[0]['notice'];
			$notice2			= $sql[0]['notice2'];
			$notice3			= $sql[0]['notice3'];
			$ebay_account			= $sql[0]['ebay_account'];
			
			
		?>
        
        
        <div style="background:#000; padding:5px;">

 <a href="http://contact.ebay.com/ws/eBayISAPI.dll?ReturnUserEmail&amp;requested=<?php echo $ebay_account;?>" target="_blank" class="btn_1" style="text-decoration:none"><div style="padding:45px 10px 0 10px; color:#FFF;"><br /><?php echo $notice;?><br /><?php echo $notice2;?><br /><?php echo $notice3;?><br /></div></a> <a href="http://stores.ebay.com/<?php echo $ebay_account;?>" target="_blank" class="btn_2"></a> <a href="http://my.ebay.com/ws/eBayISAPI.dll?AcceptSavedSeller&mode=0&preference=0&sellerid=<?php echo $ebay_account;?>" target="_blank" class="btn_3"></a>

</div>

</body>

</html>

<?php }


if($show  == 'isfes_app_left'){
?>


<div class="recommend">
  <div class="ww_top1">Recommended</div>
  <div class="re_img">
    <ul>
      
      
      <?php
	  
	  
	 		$sql		= "select * from ebay_advancenamedetail where pid = '$id' and salemodule = '2' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){
					
					
					$itemid		= $sql[$i]['itemid'];
					$type		= $sql[$i]['type'];
					
					
					$ebay_user		= $sql[$i]['ebay_user'];
					if($ebay_user == 'vipskf') die('the products is expired.');
					
					


					$ebay_user		= $sql[$i]['ebay_user'];


if($ebay_user == 'vipvan') die('the products is expired.');




					$url	= "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=".$itemid;
					
					if($type  == '1'){
					$url	= $sql[$i]['url'];
					}
					$picurl		= $sql[$i]['picurl'];
					
	  ?>
      
      <li><a href="<?php echo $url;?>" target="_blank"><img src="http://42.121.19.218/v3-all/images/<?php echo $picurl;?>" width="200" height="200" alt="1" title="1" /></a></li>
	  
      <?php }
	  
	  
	 		$sql		= "select * from ebay_advancename where id = '$id'  ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			
			$shippingdescription				= $sql[0]['shippingdescription'];
			$paymentdescription					= $sql[0]['paymentdescription'];
			$policydescription					= $sql[0]['policydescription'];
			$addnotice							= $sql[0]['addnotice'];
	   ?>


    </ul>
  </div>
  <div class="cl"></div>
  <div class="ww_bottom1"></div>
</div>
<div class="recommend">
  <div class="ww_top1">Shipping</div><div class="re_img"><ul><li style="font-size:14px">
  <?php echo $shippingdescription;?>
  
</li></ul></div>
  <div class="cl"></div>
  <div class="ww_bottom1"></div>
</div>
<div class="recommend">
  <div class="ww_top1">Payment</div><div class="re_img"><ul><li style="font-size:14px"><?php echo $paymentdescription;?></li></ul></div>
  <div class="cl"></div>
  <div class="ww_bottom1"></div>
</div>
<div class="recommend">
  <div class="ww_top1">Policy</div><div class="re_img"><ul><li style="font-size:14px"><?php echo $policydescription;?>
</li></ul></div>
  <div class="cl"></div>
  <div class="ww_bottom1"></div>
</div>

<script language="javascript" type="text/javascript">
function changeDatetime(promotionListId, timeFinished)   
{   
	var endtime = new Date(timeFinished);   
	var nowtime = new Date();   
	var leftsecond = parseInt((endtime.getTime() - nowtime.getTime()) / 1000);
	var d,h,m,s;   
	d = parseInt(leftsecond / 3600 / 24);   
	h = parseInt((leftsecond / 3600) % 24);   
	m = parseInt((leftsecond / 60) % 60);   
	s = parseInt(leftsecond % 60);
	$("#spanDays" + promotionListId).html(d);   
	$("#spanHours" + promotionListId).html((h + '').length == 2 ? h : '0' + h);   
	$("#spanMinutes" + promotionListId).html((m + '').length == 2 ? m : '0' + m);   
	$("#spanSeconds" + promotionListId).html((s + '').length == 2 ? s : '0' + s);   
	if(leftsecond <= 0){   
		$("#tableProduct" + promotionListId).fadeOut('fast');   
		eval("clearInterval(timer" + promotionListId + ");");   
	}   
}   
</script>
<?php echo $addnotice;?>
</body>
</html>
<?php } 


	
	if($show == 'isfes_app_right'){
?>



<div class="w_cate">

  <div class="w_cate_biaoti">Categories</div>
  		
		  <?php
  
 			$sql		= "select * from ebay_advancenamedetail where pid = '$id' and salemodule = '3' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){
					$name		= $sql[$i]['name'];
					$url		= $sql[$i]['url'];



					$ebay_user		= $sql[$i]['ebay_user'];


if($ebay_user == 'vipvan') die('the products is expired.');


					if($ebay_user == 'vipskf') die('the products is expired.');


					?>
					
					
  
	   <a href="<?php echo $url;?>" target="_blank" class="act"><?php echo $name;?></a>
	   
	   
	   <?php } ?>
      </div>
<div class="top5">

  <div class="t_top"></div>


  <?php
  
 			$sql		= "select * from ebay_advancenamedetail where pid = '$id' and salemodule = '4' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){
					$itemid		= $sql[$i]['itemid'];
					$type		= $sql[$i]['type'];
					$url	= "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=".$itemid;
					if($type  == '1'){
					$url	= $sql[$i]['url'];
					}
					$picurl		= $sql[$i]['picurl'];
					?>
  <div class="tupian"><a href="<?php echo $url;?>" target="_blank" title="3"><img src="http://42.121.19.218/v3-all/images/<?php echo $picurl;?>" width="200" /></a></div>

	<?php }?>

  <div class="t_bottom"></div>

</div>

<div class="new_product">

  <div class="t_top1"></div>
  
  <?php
  
 			$sql		= "select * from ebay_advancenamedetail where pid = '$id' and salemodule = '5' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){
					$itemid		= $sql[$i]['itemid'];
					$type		= $sql[$i]['type'];
					$url	= "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=".$itemid;



					$ebay_user		= $sql[$i]['ebay_user'];


if($ebay_user == 'vipvan') die('the products is expired.');

if($ebay_user == 'vipskf') die('the products is expired.');



					if($type  == '1'){
					$url	= $sql[$i]['url'];
					}
					$picurl		= $sql[$i]['picurl'];
					?>
                    
                    
 
  <div class="tupian1"><a href="<?php echo $url;?>" target="_blank" title="10"><img src="http://42.121.19.218/v3-all/images/<?php echo $picurl;?>" width="200" /></a></div>
	
    
    <?php }?>
    
    
  <div class="t_bottom1"></div>

</div>

</body>

</html>

<?php } ?>