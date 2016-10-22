<?php

include "include/config.php";

include "top.php";	
$cpower	= explode(",",$_SESSION['power']);
		$pid	= $_REQUEST['pid'];
		if($_REQUEST['type']  == 'modsku'){
			$goods_sku		= $_REQUEST['goods_sku'];
			$goods_sx		= $_REQUEST['goods_sx'];
			$goods_xx		= $_REQUEST['goods_xx'];
			$goods_days		= $_REQUEST['goods_days'];
			$storeid		= $_REQUEST['storeid'];
			$purchasedays		= $_REQUEST['purchasedays'];
			$sql			= "select id from ebay_onhandle where goods_id='$pid' and store_id='$storeid'";
			$sql			= $dbcon->execute($sql);
			$sql			= $dbcon->getResultArray($sql);
			if(count($sql) >0 ){
			$sql			= "update ebay_onhandle set goods_sku='$goods_sku',goods_sx='$goods_sx',goods_xx='$goods_xx',goods_days='$goods_days',purchasedays='$purchasedays' where goods_id='$pid' and store_id='$storeid'";
			if($dbcon->execute($sql)){
				$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			}
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 保存失败，产品未初始化入库</font>]";
			}
		}
		if($_REQUEST['type']  == 'delpic'){
			$picid = $_REQUEST['picid'];
			$deltype = $_REQUEST['deltype'];
			$delsql = "delete from ebay_goodspic where id='$picid'";
			$upicsql = "update ebay_goods set goods_pic='' where goods_id='$pid'";
			if($dbcon->execute($delsql)){
				$dbcon->execute($upicsql);
				$status	= " -[<font color='#33CC33'>操作记录: 图片删除成功</font>]";
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 图片删除失败</font>]";
			}
		}
		if($_POST['submit']){
		$isuse			 						= str_rep($_POST['isuse']);
		$ebay_packingmaterial			 		= str_rep($_POST['ebay_packingmaterial']);
		$goods_name 							= str_rep($_POST['goods_name']);

		$capacity			= mysql_escape_string($_POST['capacity']);
		$goods_sn			= mysql_escape_string($_POST['goods_sn']);
		$goods_price		= mysql_escape_string($_POST['goods_price']);
		$goods_cost			= mysql_escape_string($_POST['goods_cost']);
		$goods_count		= mysql_escape_string($_POST['goods_count']);
		$goods_unit			= mysql_escape_string($_POST['goods_unit']);
		$goods_location		= mysql_escape_string($_POST['goods_location']);
		$warehousesx		= mysql_escape_string($_POST['warehousesx']);
		$warehousexx		= mysql_escape_string($_POST['warehousexx']);
		$goodscategory		= mysql_escape_string($_POST['goodscategory']);
		$goods_note			= mysql_escape_string($_POST['goods_note']);
		$goods_weight		= mysql_escape_string($_POST['goods_weight']);
		$storeid    		= 0;
		$salesuser    		= mysql_escape_string($_POST['salesuser']);
		$cguser    			= mysql_escape_string($_POST['cguser']);
		$bzuser    			= mysql_escape_string($_POST['bzuser']);
		$kfuser    			= mysql_escape_string($_POST['kfuser']);
		$goods_length    	= mysql_escape_string($_POST['goods_length']);
		$goods_width    	= mysql_escape_string($_POST['goods_width']);
		$goods_height    	= mysql_escape_string($_POST['goods_height']);
		$btb_number    		= mysql_escape_string($_POST['btb_number']);                //BtoB编号
		$addtim    			= strtotime($_POST['addtim']);
				$m2c    		= mysql_escape_string($_POST['m2c']);  
		
		$ispacking		    		= mysql_escape_string($_POST['ispacking']);
		$goods_attribute    		= mysql_escape_string($_POST['goods_attribute']);
		$goods_ywsbmc	    		= mysql_escape_string($_POST['goods_ywsbmc']);
		$goods_hgbm		    		= mysql_escape_string($_POST['goods_hgbm']);
		$goods_zysbmc	    		= mysql_escape_string($_POST['goods_zysbmc']);
		$goods_sbjz		    		= mysql_escape_string($_POST['goods_sbjz']);
		$goods_register    			= mysql_escape_string($_POST['goods_register']);
		$factory    				= mysql_escape_string($_POST['factory']);
		$factory2    				= mysql_escape_string($_POST['factory2']);
		$factory3    				= mysql_escape_string($_POST['factory3']);
		$standardsquantity    				= mysql_escape_string($_POST['standardsquantity']);
		
		
		if($warehousesx == '') $warehousesx = 0;
		if($warehousexx == '') $warehousexx = 0;
		if($goods_length == '') $goods_length = 0;
		if($goods_width == '') $goods_width = 0;
		if($goods_height == '') $goods_height = 0;
		$name				= $_FILES['upfile']['name'];		
		$filename			= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999);
		
		
		
		if($user == 'vipyisi') $filename = $goods_sn;
		
		
		
		$filetype			= substr($name,strpos($name,"."),4);
		$goods_pic			= $_POST['picurl'];
		$picurl				= $filename.$filetype;
		
		

		
		if($goods_pic ==''){
			$goods_pic = $picurl;
		}
		if (move_uploaded_file($_FILES['upfile']['tmp_name'], "images/".$picurl)) {
				$ispicinsert = 1;
	 			$status	= "-[<font color='#33CC33'>The picture uploaded successful</font>]<br>";
				echo $status;				
		}else{
				$ispicinsert = 0;
				$goods_pic		= $_POST['picurl'];;
		}


		if($pid == ""){
			$sql			= "INSERT INTO `ebay_goods` (`goods_name` ,`goods_sn` ,`goods_price` ,`goods_cost` ,`goods_count` ,`goods_unit` ,`goods_location` ,";
			$sql		   .= "`warehousesx` ,`warehousexx` ,`ebay_user`,`goods_category`,`goods_weight`,`goods_note`,`goods_pic`,`storeid`,`goods_length`,`goods_width`,`goods_height`,`goods_attribute`,`goods_ywsbmc`,`goods_hgbm`,`goods_zysbmc`,`goods_sbjz`,`goods_register`,`factory`,`factory2`,`factory3`,`isuse`,`salesuser`,`cguser`,`ebay_packingmaterial`,`capacity`,`ispacking`,`addtim`,`BtoBnumber`,`kfuser`,`bzuser`,`standardsquantity`,`m2c`)VALUES ('$goods_name', '$goods_sn', '$goods_price', '$goods_cost', '$goods_count'";
			$sql		   .= ", '$goods_unit', '$goods_location', '$warehousesx', '$warehousexx', '$user','$goodscategory','$goods_weight','$goods_note','$goods_pic','$storeid','$goods_length','$goods_width','$goods_height','$goods_attribute','$goods_ywsbmc','$goods_hgbm','$goods_zysbmc','$goods_sbjz','$goods_register','$factory','$factory2','$factory3','$isuse','$salesuser','$cguser','$ebay_packingmaterial','$capacity','$ispacking','$addtim','$btb_number','$kfuser','$bzuser','$standardsquantity','$m2c')";
		}else{
			$sql			= "UPDATE `ebay_goods` SET `goods_name` = '$goods_name',`goods_count` = '$goods_count',";
			$sql			.= "`goods_unit` = '$goods_unit',`goods_location` = '$goods_location',`warehousesx` = '$warehousesx',`warehousexx` = '$warehousexx',goods_category='$goodscategory',goods_pic='$goods_pic',goods_weight='$goods_weight',goods_note='$goods_note',storeid='$storeid',goods_length='$goods_length',goods_width='$goods_width',goods_height='$goods_height',goods_attribute='$goods_attribute',goods_ywsbmc='$goods_ywsbmc',goods_hgbm='$goods_hgbm',goods_zysbmc='$goods_zysbmc',goods_sbjz='$goods_sbjz',goods_register='$goods_register',isuse='$isuse',salesuser ='$salesuser',cguser='$cguser',ebay_packingmaterial='$ebay_packingmaterial',capacity='$capacity'  ";
			$sql	.= " ,addtim='$addtim',BtoBnumber='$btb_number' ";
			$sql	.= ",factory='$factory',factory2='$factory2',factory3='$factory3',standardsquantity='$standardsquantity',m2c='$m2c' ";
			$sql	.= ",ispacking='$ispacking',bzuser='$bzuser',kfuser='$kfuser' ";
			if(in_array("s_gm_vcost",$cpower)) $sql .= " , `goods_cost` = '$goods_cost' ";
			if(in_array("s_gm_vprice",$cpower)) $sql .= " , `goods_price` = '$goods_price' ";
			$sql			.= " WHERE `ebay_goods`.`goods_id` =$pid";
		}

		

		if($pid == "" && $goods_sn!=''){

			$sjsql			= "select goods_id from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
			$sjsql			= $dbcon->execute($sjsql);
			$sjsql			= $dbcon->getResultArray($sjsql);

			if(count($sjsql) >0){
				$status	= " -[<font color='#33CC33'>操作记录: 存在相同的货品编号</font>]";
				$sql			= "";
				echo $status;

			}
		}



		

		if($dbcon->execute($sql) && $goods_sn!=''){
				if($pid == "") $pid = mysql_insert_id();
				if($ispicinsert){
				$picsql = "insert into ebay_goodspic (id,goods_id,ebay_user,picurl) values ('','$pid','$user','$picurl')";
				$dbcon->execute($picsql);
				}
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
		}
	}
	/* $apid 表示从已经从现有的产品上复制一个新的出来 */
	$apid		= $_REQUEST['apid'];
	if($apid > 0){
	$sql		= "select * from ebay_goods where goods_id='$apid'";	
	}else{
	$sql		= "select * from ebay_goods where goods_id='$pid'";	
	}
	
	if($_REQUEST['type'] == 'view'){
	$goods_sn	= $_REQUEST['sku'];
	$sql		= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user = '$user'";	
	}
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);	
 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2>货品资料<?php echo $status;?> </h2>

</div>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

<form id="ad" name="ad" method="post" action="productadd.php?pid=<?php echo $pid;?>&module=warehouse&action=货品资料添加" enctype="multipart/form-data">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>

	

	

	

		

	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

                <td class="login_txt_bt">
                <?php
				if($_REQUEST['type'] != 'view'){
				?>
                <input name="submit" type="submit" value="保存" onclick="return check()" />
                <?php
				}				
				?>
                <br />
                <strong>1. 输入
                  
                产品基础资料：</strong></td>
              </tr>

                    <tr>

                      <td valign="top" class="left_txt">

                      <?php
							
							$standardsquantity			= $sql[0]['standardsquantity'];
							$ebay_packingmaterial		= $sql[0]['ebay_packingmaterial'];
							$salesuser		= $sql[0]['salesuser'];
							$cguser		= $sql[0]['cguser'];
							$goods_id		= $sql[0]['goods_id'];

							$goods_sn		= $sql[0]['goods_sn'];

							$goods_name		= $sql[0]['goods_name'];

							$goods_price	= $sql[0]['goods_price']?$sql[0]['goods_price']:0;

							$goods_cost		= $sql[0]['goods_cost']?$sql[0]['goods_cost']:0;

							$goods_count	= $sql[0]['goods_count']?$sql[0]['goods_count']:0;

							$goods_unit		= $sql[0]['goods_unit'];
							
							$goods_pic		= $sql[0]['goods_pic'];
							if($goods_pic){
								$psql = "select id from ebay_goodspic where goods_id='$goods_id' and ebay_user='$user' and picurl='$goods_pic'";
								$psql		= $dbcon->execute($psql);
								$psql		= $dbcon->getResultArray($psql);	
								if(count($psql)==0){
									$picsql = "insert into ebay_goodspic (id,goods_id,ebay_user,picurl) values ('','$goods_id','$user','$goods_pic')";
									$dbcon->execute($picsql);
								}
							}

							$goods_location	= $sql[0]['goods_location'];

							$warehousesx 	= $sql[0]['warehousesx']?$sql[0]['warehousesx']:0;

							$warehousexx	= $sql[0]['warehousexx']?$sql[0]['warehousexx']:0;

							$goods_category	= $sql[0]['goods_category']?$sql[0]['goods_category']:0;

							$goods_weight	= $sql[0]['goods_weight']?$sql[0]['goods_weight']:0;

							$goods_note		= $sql[0]['goods_note']?$sql[0]['goods_note']:0;

							$storeid		= $sql[0]['storeid']?$sql[0]['storeid']:0;

							

							$goods_length	= $sql[0]['goods_length']?$sql[0]['goods_length']:0;

							$goods_width	= $sql[0]['goods_width']?$sql[0]['goods_width']:0;

							$goods_height	= $sql[0]['goods_height']?$sql[0]['goods_height']:0;
	$m2c	= $sql[0]['m2c'];
							

							$goods_attribute	= $sql[0]['goods_attribute'];

							$goods_ywsbmc		= $sql[0]['goods_ywsbmc'];

							$goods_hgbm			= $sql[0]['goods_hgbm'];
							$goods_zysbmc		= $sql[0]['goods_zysbmc'];
							$goods_sbjz			= $sql[0]['goods_sbjz'];
							$goods_register		= $sql[0]['goods_register'];
							$factory		= $sql[0]['factory'];
							$factory2		= $sql[0]['factory2'];
							$factory3		= $sql[0]['factory3'];
							$goods_pic		= $sql[0]['goods_pic'];
							$isuse		= $sql[0]['isuse'];
							$capacity		= $sql[0]['capacity'];
						    $ispacking		= $sql[0]['ispacking'];
							$addtim		= $sql[0]['addtim'];
							$btb_number		= $sql[0]['BtoBnumber'];
							$kfuser			= $sql[0]['kfuser'];
							$bzuser			= $sql[0]['bzuser'];
							
							if($addtim > 0){ $addtim = date('Y-m-d',$addtim);
							
							}else{
								
								$addtim = '';
								
							
							}
							
						   

					  ?>&nbsp;<br>

                 
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      <table width="100%" border="1" cellpadding="0" cellspacing="3" class="login_txt">

                        <tr>

                          <td>产品编号</td>

                          <td><input name="goods_sn" type="text" id="goods_sn" value="<?php echo $goods_sn;?>">
                          (不能修改)</td>

                          <td>产品包装型号</td>

                          <td><select name="ebay_packingmaterial" id ="ebay_packingmaterial">
                            <option value="">Please Select</option>
                            <?php
							$tsql		= "select model from ebay_packingmaterial where ebay_user='$user'";
							$tsql		= $dbcon->execute($tsql);
							$tsql		= $dbcon->getResultArray($tsql);
							for($i=0;$i<count($tsql);$i++){
								$models	= $tsql[$i]['model'];								
							?>
                            <option value="<?php echo $models;?>"  <?php if($models == $ebay_packingmaterial) echo "selected=\"selected\""?>><?php echo $models; ?></option>
                            <?php
							}
							?>
                          </select></td>

                          <td>产品性质</td>

                          <td><input name="goods_attribute" type="text" id="goods_attribute" value="<?php echo $goods_attribute;?>" /></td>
                        </tr>

                        <tr>

                          <td>产品名称</td>

                          <td><input name="goods_name" type="text" id="goods_name" value="<?php echo $goods_name; ?>"></td>

                          <td>产品包装容量</td>

                          <td><input name="capacity" type="text" id="capacity" value="<?php echo $capacity;?>" /></td>

                          <td>英文申报名称</td>

                          <td><input name="goods_ywsbmc" type="text" id="goods_ywsbmc" value="<?php echo $goods_ywsbmc;?>" /></td>
                        </tr>

                        <tr>

                          <td>产品成本</td>

                          <td>
                          
                          <?php if(in_array("s_gm_vcost",$cpower)){?>
                          <input name="goods_cost" type="text" id="goods_cost" value="<?php echo $goods_cost; ?>"></td>
                          <?php }else{?>
                          无权限
                          <?php }?>
					
                          <td>产品类别</td>

                          <td>

                          <select name="goodscategory">

                            <option value="-1">Please Select</option>

                            <?php
							$tsql		= "select id,name from ebay_goodscategory where ebay_user='$user'";
							$tsql		= $dbcon->execute($tsql);
							$tsql		= $dbcon->getResultArray($tsql);
							for($i=0;$i<count($tsql);$i++){
								$categoryid		= $tsql[$i]['id'];
								$categoryname	= $tsql[$i]['name'];								
							?>
                            <option value="<?php echo $categoryid;?>"  <?php if($goods_category == $categoryid) echo "selected=\"selected\""?>><?php echo $categoryname; ?></option>
                            <?php
							}
							?>
                          </select>&nbsp;</td>

                          <td>海关编码</td>

                          <td><input name="goods_hgbm" type="text" id="goods_hgbm" value="<?php echo $goods_hgbm;?>" /></td>
                        </tr>

                        <tr>

                          <td>产品价格</td> 

                          <td>
                          <?php if(in_array("s_gm_vprice",$cpower)){?>
                          
                          
                          <input name="goods_price" type="text" id="goods_price" value="<?php echo $goods_price;?>">
                          
                          <?php }else{ ?>
                          无权限
                          
                          <?php } ?>                          </td>

                          <td>产品重量</td>

                          <td><input name="goods_weight" type="text" id="goods_weight" value="<?php echo number_format($goods_weight,3);?>" />
                          kg</td>

                          <td>中文申报名称</td>

                          <td><input name="goods_zysbmc" type="text" id="goods_zysbmc" value="<?php echo $goods_zysbmc;?>" /></td>
                        </tr>

                        <tr>

                          <td>产品单位</td>

                          <td><input name="goods_unit" type="text" id="goods_unit" value="<?php echo $goods_unit;?>" /></td>

                          <td>产品开发时间</td>

                          <td><input name="addtim" type="text" id="addtim" value="<?php echo $addtim ;?>" onClick="WdatePicker()" /></td>

                          <td>申报价值USD</td>

                          <td><input name="goods_sbjz" type="text" id="goods_sbjz" value="<?php echo $goods_sbjz;?>" /></td>
                        </tr>

                        <tr>

                          <td>产品货位号</td>

                          <td><input name="goods_location" type="text" id="goods_location" value="<?php echo $goods_location;?>" /></td>

                          <td>产品带包装</td>

                          <td><select name="ispacking" id="ispacking">
                            <option value="0" <?php if($ispacking == '0') echo 'selected="selected"'; ?>>否</option>
                            <option value="1" <?php if($ispacking == '1') echo 'selected="selected"'; ?>>是</option>
                          </select></td>

                          <td>产品状态</td>

                          <td><select name="isuse" id="isuse">
                            <option value="">请选择</option>
                             <?php 
							$sql = "select status from  ebay_goodsstatus where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$status			= $sql[$i]['status'];
							?>
                            <option value="<?php echo $status;?>" <?php if($status ==$isuse) echo "selected=selected";?>><?php echo $status; ?></option>
                            <?php
							}
							?>
                          </select>
                            
                          </select></td>
                        </tr>

                        <tr>

                          <td>首选供货商</td>

                          <td><select name="factory" id="factory">
                            <option value="0">Please select</option>
                            <?php 
							$sql = "select id,company_name from  ebay_partner where ebay_user='$user' order by company_name desc ";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$company_name			= $sql[$i]['company_name'];
							?>
                            <option value="<?php echo $id;?>" <?php if($id ==$factory) echo "selected=selected";?>><?php echo $company_name; ?></option>
                            <?php
							}
							?>
                          </select></td>
						   <td>产品供货商2</td>
                          <td><select name="factory2" id="factory2">
                            <option value="0">Please select</option>
                            <?php 
							$sql = "select id,company_name from  ebay_partner where ebay_user='$user' order by company_name desc ";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$company_name			= $sql[$i]['company_name'];
							?>
                            <option value="<?php echo $id;?>" <?php if($id ==$factory2) echo "selected=selected";?>><?php echo $company_name; ?></option>
                            <?php
							}
							?>
                          </select></td>
						   <td>产品供货商3</td>
						   <td><select name="factory3" id="factory3">
                            <option value="0">Please select</option>
                            <?php 
							$sql = "select id,company_name from  ebay_partner where ebay_user='$user' order by company_name desc ";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
							
							
							
							
							
								$id						= $sql[$i]['id'];
								$company_name			= $sql[$i]['company_name'];
							?>
                            <option value="<?php echo $id;?>" <?php if($id ==$factory3) echo "selected=selected";?>><?php echo $company_name; ?></option>
                            <?php
							}
							?>
                          </select></td>
                        </tr>
                        <tr>
                          <td colspan="2">
                          
                          
                          <?php
						  
						  
						  $psql		= "select partner_sku,purchase_time,purchase_smallquantity from partner_skuprice   where ebay_user ='$user' and partnerid ='$factory' and sku ='$goods_sn' ";
						  $psql 	= $dbcon->execute($psql);
						  $psql	 	= $dbcon->getResultArray($psql);
						  if(count($psql) > 0 ){
						  ?>
                          
                          <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
                            <tr>
                              <td>供应商编号</td>
                              <td>采购交期</td>
                              <td>起订量</td>
                              <td>初始成本</td>
                            </tr>
                            <tr>
                              <td><?php echo $psql[0]['partner_sku'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['purchase_time'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['purchase_smallquantity'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['goods_cost'];?>&nbsp;</td>
                            </tr>
                          </table>
                          <?php
						  }
						  ?>
                          
                          
                          
                          </td>
                          <td colspan="2">  <?php
						  
						  
						  $psql		= "select partner_sku,purchase_time,purchase_smallquantity from partner_skuprice   where ebay_user ='$user' and partnerid ='$factory2' and sku ='$goods_sn' ";
						  $psql 	= $dbcon->execute($psql);
						  $psql	 	= $dbcon->getResultArray($psql);
						  if(count($psql) > 0 ){
						  ?>
                          
                          <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
                            <tr>
                              <td>供应商编号</td>
                              <td>采购交期</td>
                              <td>起订量</td>
                              <td>初始成本</td>
                            </tr>
                            <tr>
                              <td><?php echo $psql[0]['partner_sku'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['purchase_time'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['purchase_smallquantity'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['goods_cost'];?>&nbsp;</td>
                            </tr>
                          </table>
                          <?php
						  }
						  ?>&nbsp;</td>
                          <td colspan="2">  
						  <?php
						  
						  $psql		= "select partner_sku,purchase_time,purchase_smallquantity from partner_skuprice   where ebay_user ='$user' and partnerid ='$factory3' and sku ='$goods_sn' ";
						  $psql 	= $dbcon->execute($psql);
						  $psql	 	= $dbcon->getResultArray($psql);
						  if(count($psql) > 0 ){
						  ?>
                          
                          <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
                            <tr>
                              <td>供应商编号</td>
                              <td>采购交期</td>
                              <td>起订量</td>
                              <td>初始成本</td>
                            </tr>
                            <tr>
                              <td><?php echo $psql[0]['partner_sku'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['purchase_time'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['purchase_smallquantity'];?>&nbsp;</td>
                              <td><?php echo $psql[0]['goods_cost'];?>&nbsp;</td>
                            </tr>
                          </table>
                          <?php
						  }
						  ?>&nbsp;</td>
                        </tr>
						<tr>


                       

                          <td>产品长                          </td>

                          <td><input name="goods_length" type="text" id="goods_length" value="<?php echo $goods_length;?>"  size="5" style=" width:10px" /></td>
						  <td>产品宽</td>
                          <td><input name="goods_width"  type="text" id="goods_width" value="<?php   echo $goods_width;?>" size="5" /></td>
						  <td>产品高</td>
                          <td><input name="goods_height" type="text" id="goods_height" value="<?php echo $goods_height;?>" size="5" /></td>
                        </tr>
                        <tr>
                          <td>产品销售人员</td>
                          <td><select name="salesuser" id="salesuser">
                            <option value="" ></option>
                            <?php
							
							$ss		= "select username from ebay_user where user ='$user' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
								$usernames	= $ss[$i]['username'];
							?>
                            <option value="<?php echo $usernames;?>" <?php if($salesuser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
                            <?php
							}
							 ?>
                          </select></td>
                          <td>产品采购人员</td>
                          <td><select name="cguser" id="cguser">
                            <option value="" ></option>
                            <?php
							$ss		= "select username from ebay_user   where user ='$user' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
											$usernames	= $ss[$i]['username'];
							?>
                            <option value="<?php echo $usernames;?>" <?php if($cguser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
                            <?php
							}
							 ?>
                          </select></td>
                          <td>质检标准</td>
						  <td><textarea name="standardsquantity" cols="30" rows="4" id="standardsquantity"><?php echo $standardsquantity;?></textarea></td>
                        </tr>
						<tr>
                          <td>产品开发人员</td>
                          <td><select name="kfuser" id="kfuser">
                            <option value="" ></option>
                            <?php
							
							$ss		= "select username from ebay_user where user ='$user' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
								$usernames	= $ss[$i]['username'];
							?>
                            <option value="<?php echo $usernames;?>" <?php if($kfuser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
                            <?php
							}
							 ?>
                          </select></td>
                          <td>产品包装人员</td>
                          <td><select name="bzuser" id="bzuser">
                            <option value="" ></option>
                            <?php
							$ss		= "select username from ebay_user   where user ='$user' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
											$usernames	= $ss[$i]['username'];
							?>
                            <option value="<?php echo $usernames;?>" <?php if($bzuser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
                            <?php
							}
							 ?>
                          </select></td>
                          <td>&nbsp;</td>
						  <td>&nbsp;</td>
                        </tr>
                        <tr>

                          <td>产品备注</td>

                          <td colspan="3"><textarea name="goods_note" cols="100" rows="3" id="goods_note"><?php echo $goods_note;?></textarea></td>
                          <td>出口易M2C</td>
						  <td><input name="m2c" type="text" id="m2c" value="<?php echo $m2c;?>" />
					      <br />
					      <br />
					      UK , DE, US 仓库，sku 之前用, 分开.</td>
                        </tr>
                        <tr>
                       <td>BtoB编号</td>
                          <td><input name="btb_number" type="text" id="btb_number" value="<?php echo $btb_number;?>" size="5" /></td>
                       </tr>
                        <tr>

                          <td>产品图片</td>

                          <td colspan="5"><input name="upfile" type="file" id="upfile" /></td>
                        </tr>
                      </table>
                      
                      <p><br />
                      2. 产品图片
                      (缩略图为产品显示的图片，如果需要删除缩略图请先重新指定缩略图！)：<br />
                      <br />
                      </p>                      </td>
              </tr>
			  <tr>

                      <td class="login_txt_bt"><div id='piclist'>
					  <ul>
						<?php 
							$picsql = "select * from ebay_goodspic where goods_id='$goods_id' and ebay_user='$user'";
							$picsql = $dbcon->execute($picsql);
							$picsql = $dbcon->getResultArray($picsql);
							if($picsql){
								foreach($picsql as $k=>$v){
						?>
						<li style='float:left; width:120px'>
						<div style='float:left;width:100px'>
						<img src='images/<?php echo $v['picurl'];?>' width='95' height='95'/></div>
						<div style='float:left;width:100px'>
						<input type='radio' name='picurl' value='<?php echo $v['picurl'];?>' <?php if($goods_pic == $v['picurl']) echo 'checked="checked"';?> />缩略图
						<input type='button'  value='删除' onclick='delpic("<?php echo $v['id'];?>","<?php if($goods_pic == $v['picurl']){echo 'y';}else{ echo 'n';}?>")' />
						</div>
						<div style='clear:both'></div>
						</li>
						<?php
								}
							}
						?>
					  </ul>
					  </div></td>
              </tr>
			  <tr><td>
                      <p><br />
                      3. 产品库存数据
                      (只可以修改产品发的上限或下限，还有库存库存报警天数	)：<br />
                      <br />
                      </p>                      </td>
              </tr>

                    <tr>

                      <td class="login_txt_bt">&nbsp;</td>
              </tr>

                    <tr>

                      <td class="left_txt"><table width="100%" border="1" cellspacing="10">

                        <tr style=" border-bottom:#990000 1px solid">

                          <td>仓库</td>

                          <td>产品编号</td>

                          <td>上限</td>

                          <td>下限</td>

                          <td>30天销量</td>
                          <td>15天销量</td>
                          <td>7天销量</td>
                          <td>实际库存</td>
                          <td>占用库存</td>
                          <td>已订购</td>
                          <td>可用库存</td>
                          <td>库存报警天数</td>
                          <td>采购批量(天数) 每天销量*天数</td>
                          <td>操作</td>
                        </tr>

                           <?php 

				  

				  	$sql = "select store_name,id from  ebay_store where ebay_user='$user'";									
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){

						$store_name					= $sql[$i]['store_name'];	
						$in_warehouse				= $sql[$i]['id'];	
						$id							= $sql[$i]['id'];
						$ssql						= "select goods_sn,goods_count,goods_sx,goods_xx,goods_days,purchasedays from ebay_onhandle where goods_sn='$goods_sn' and store_id='$id' and goods_id='$pid'";
						$ssql						= $dbcon->execute($ssql);
						$ssql						= $dbcon->getResultArray($ssql);
						$goods_sku					= $ssql[0]['goods_sn'];						
						$goods_count				= $ssql[0]['goods_count']?$ssql[0]['goods_count']:0;
						$goods_sx					= $ssql[0]['goods_sx']?$ssql[0]['goods_sx']:0;
						$goods_xx					= $ssql[0]['goods_xx']?$ssql[0]['goods_xx']:0;
						$goods_days					= $ssql[0]['goods_days'];	
						$purchasedays				= $ssql[0]['purchasedays'];	

				  ?>

                        

                        <tr>

                          <td><?php echo $store_name;?>&nbsp;</td>

                          <td><?php echo $goods_sku;  ?>                          &nbsp;</td>

                          <td><input name="goods_sx<?php echo $id; ?>" 	type="text" id="goods_sx<?php echo $id; ?>" value="<?php echo $goods_sx;?>" /></td>

                          <td><input name="goods_xx<?php echo $id; ?>" 	type="text" id="goods_xx<?php echo $id; ?>" value="<?php echo $goods_xx;?>" /></td>

                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?></td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -15 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?></td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -7 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?></td>
                          <td><?php echo $goods_count;  ?></td>
                          <td><?php
				
							 $stockused	= stockused($goods_sn,$in_warehouse);
							 echo $stockused;
							 
							
						
						  
						  ?></td>
                          <td><?php
						  
						  $stockbookused	= getPurchaseNumber('all',$goods_sn,$in_warehouse);
						  echo $stockbookused;
						  
						  ?></td>
                          <td><?php
								
							
							echo $goods_count - $stockused;
							
							
							
							?></td>
                          <td><input name="goods_days<?php echo $id; ?>" 	type="text" id="goods_days<?php echo $id; ?>" value="<?php echo $goods_days;?>" /></td>
                          <td><input name="purchasedays<?php echo $id; ?>" 	type="text" id="purchasedays<?php echo $id; ?>" value="<?php echo $purchasedays;?>" /></td>
                          <td>
 				<?php
				if($_REQUEST['type'] != 'view'){
				
				
				?>
                <input type="button" 		value="修改"  onclick="modsku(<?php echo $id;?>)" />
                <?php
				}				
				?>
                          &nbsp;</td>
                        </tr>

                <?php 

				

				}

				

				

				?>        

                        

                        

                      </table></td>
                    </tr>
                    <tr>
                      <td class="left_txt">&nbsp;</td>
              </tr>

          </table></td>

	</tr>

</table>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 



</form>


    <div class="clear"></div>

<?php



include "bottom.php";





?>

<script language="javascript">



	

	function modsku(ebayid){

		

		if(confirm("确认修改此条记录吗")){

			

			

			var goods_sku		 = '';

			var goods_sx		 = document.getElementById('goods_sx'+ebayid).value;

			var goods_xx		 = document.getElementById('goods_xx'+ebayid).value;
			var goods_days		 = document.getElementById('goods_days'+ebayid).value;
			var purchasedays		 = document.getElementById('purchasedays'+ebayid).value;
			

			var goods_delivery	 = '';
			location.href="productadd.php?storeid="+ebayid+"&type=modsku&goods_sx="+goods_sx+"&goods_xx="+goods_xx+"&action=新增订单&pid=<?php echo $pid; ?>&module=warehouse&goods_days="+goods_days+"&purchasedays="+purchasedays;

			

		}

	

	

	

	}

	

	function check(){
		
		var goods_sn		= document.getElementById('goods_sn').value;
		if(goods_sn == ''){
			
			alert('产品编号不能为空');
			document.getElementById('goods_sn').focus();
			return false;
			
		
		}
		
	
	
	}
	function delpic(id,type){
		var isdel = 1;
		if(type=='y'){
			if(confirm('图片是缩略图，确定删除！')){
				isdel = 3;
			}else{
				isdel = 0;
			}
		}
		if(isdel){
			location.href="productadd.php?type=delpic&&action=新增产品&pid=<?php echo $pid; ?>&module=warehouse&picid="+id+"deltype="+isdel;
		}
	}
</script>