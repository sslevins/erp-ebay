<?php
include "include/config.php";


include "top.php";

$isuse = $_REQUEST['isuse'];

if ($type == "delsystem") {

    $ordersn = explode(",", $_REQUEST['ordersn']);
    $status = "";
    for ($g = 0; $g < count($ordersn); $g++) {


        $sn = $ordersn[$g];

        if ($sn != "") {

            $sql = "delete  from  ebay_goods where goods_id='$sn'";



            if ($dbcon->execute($sql)) {


                $status = " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
            } else {


                $status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
            }
        }
    }
}



/* 已经占用库存 */

function stocssskused($goods_sn) {

    global $dbcon;
    $gsql = "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and (a.ebay_status ='1' or a.ebay_status ='512' or a.ebay_status ='509')  and ebay_combine!='1'";
    $gsql = $dbcon->execute($gsql);
    $gsql = $dbcon->getResultArray($gsql);
    $usedqty = $gsql[0]['qty'] ? $gsql[0]['qty'] : 0;
    return $usedqty;
}
?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
                        <h2><?php echo $_REQUEST['action'] . $status; ?> </h2>
                        备注：在此模块中，当仓库库存数量小于库存上限或上限时，都会显示在下面的列表中。 库存上限和下限是可以在货品资料管理中添加的。
                    </div>

                    <div class='listViewBody'>


                        <div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">


                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>



                                    <td nowrap="nowrap" scope="row" >&nbsp;&nbsp;&nbsp;

                                        关键字：
                                        <input name="keys" type="text" id="keys" onkeydown="enterkeys()"/>
										仓库：
										<select name="warehouse" id="warehouse">
										<option value="0">Please select</option>
										<?php 
										
										$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
										$sql = $dbcon->execute($sql);
										$sql = $dbcon->getResultArray($sql);
							
										for($i=0;$i<count($sql);$i++){
									
											$id					= $sql[$i]['id'];
											$store_name			= $sql[$i]['store_name'];	
									
										
										?>
										<option value="<?php echo $id;?>" <?php if($_REQUEST['warehouse'] ==$id) echo "selected=selected";?>><?php echo $store_name; ?></option>
										<?php
										}
										
										
										?>

									  </select>
										产品状态：
										<select name="isuse" id="isuse">
                                          <option value="">产品状态</option>
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
								    <input type="button" value="查找" onclick="searchorder()" />
										<input class='button' type="button" name='search_form_submit2' value='采购单导出' id='search_form_submit3' onclick="caigou()"/>
                                        <input class='button' type="button" name='button' value='全选' id='search_form_submit' onclick="check_all('ordersn','ordersn')" /></td>
                                </tr>
                            </table>
                        </div>
                        <div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
                        <div id='Accountssaved_viewsSearchForm' style='display: none';></div>
                        </form>

                        <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
                            <tr class='pagination'>
                                <td colspan='15'>
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
                                        <tr>
                                            <td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
                                            <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
                                        </tr>
                                    </table>		</td>
                            </tr><tr height='20'>
                                <th scope='col' nowrap="nowrap">
                            <div style='white-space: nowrap;'width='100%' align='left'>操作</div></th>
                                <th scope='col' nowrap="nowrap">状态</th>
                                <th scope='col' nowrap="nowrap">仓库</th>

                            <th scope='col' nowrap="nowrap">
                            <div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>

                            <th scope='col' nowrap="nowrap">
                            <div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>

                            <th scope='col' nowrap="nowrap">供应商名称</th>
                            <th scope='col' nowrap="nowrap"><span class="left_bt2">产品售价</span></th>
                            <th scope='col' nowrap="nowrap">单位&nbsp;</th>
                            <th scope='col' nowrap="nowrap">产品货位&nbsp;</th>
                            <th scope='col' nowrap="nowrap">实际库存</th>
                            <th scope='col' nowrap="nowrap">最近一周销量</th>
                            <th scope='col' nowrap="nowrap">购买的网址</th>
                            <th scope='col' nowrap="nowrap">进货价</th>
                            <th scope='col' nowrap="nowrap">当前状态&nbsp;</th>
                            <th scope='col' nowrap="nowrap">操作</th>
                            </tr>



<?php
$sql = "SELECT a.goods_id as bb,a.goods_sn as asn,a.goods_name as aname,a.goods_price,a.goods_cost,a.goods_unit,a.isuse,a.factory,b.* FROM ebay_goods AS a
JOIN ebay_onhandle AS b ON a.goods_id = b.goods_id where b.goods_count not BETWEEN goods_xx AND goods_sx and a.ebay_user='$user' and b.store_id != '' ";
$keys = $_REQUEST['keys'];
$warehouse = $_REQUEST['warehouse'];
if ($keys != "") {

    $sql .= " and(a.goods_name like '%$keys%' or a.goods_sn like '%$keys%' or a.goods_unit like '%$keys%')";
}
if($warehouse){
	$sql .= " and b.store_id = '$warehouse' ";
}

$isuse = $_REQUEST['isuse'];
if($isuse){
	$sql .= " and a.isuse = '$isuse' ";
}

$query = $dbcon->query($sql);
$total = $dbcon->num_rows($query);

$pageindex = ( isset($_GET['pageindex']) ) ? $_GET['pageindex'] : 1;
$limit = " limit " . ($pageindex - 1) * $pagesize . ",$pagesize";


$page = new page(array('total' => $total, 'perpage' => $pagesize));
$sql = $sql . $limit;




$sql = $dbcon->execute($sql);
$sql = $dbcon->getResultArray($sql);




for ($i = 0; $i < count($sql); $i++) {

    $factory = $sql[$i]['factory'];
    $ss = "select *  from ebay_partner where id = $factory";
    $ss = $dbcon->execute($ss);
    $ss = $dbcon->getResultArray($ss);
    $company_name = $ss[0]['company_name'];

 $isuse = $sql[$i]['isuse'];
    $goods_id = $sql[$i]['bb'];
    $goods_sn = $sql[$i]['asn'];
    $goods_name = $sql[$i]['aname'];
    $goods_price = $sql[$i]['goods_price'] ? $sql[$i]['goods_price'] : 0;
    $goods_cost = $sql[$i]['goods_cost'] ? $sql[$i]['goods_cost'] : 0;
    $goods_count = $sql[$i]['goods_count'] ? $sql[$i]['goods_count'] : 0;
    $goods_unit = $sql[$i]['goods_unit'];
    $goods_location = $sql[$i]['goods_location'];
    $warehousesx = $sql[$i]['goods_sx'];
    $warehousexx = $sql[$i]['goods_xx'];
    $goodsurl = $sql[$i]['goodsurl'];
	  $store_id = $sql[$i]['store_id'];
	  
	  
										  $ss = "select id,store_name from  ebay_store where ebay_user='$user' and id ='$store_id'";									
										$ss = $dbcon->execute($ss);
										$ss = $dbcon->getResultArray($ss);
	
				$store_name = $ss[0]['store_name'];
				
	
	
    $dstr = "";


 
	
    if ($goods_count > $warehousesx)
        $dstr = "<strong><font color=#CCCC33>库存数量过多</font></strong>" . $goods_count . " sx:" . $warehousesx . " xx:" . $warehousexx;
    if ($goods_count < $warehousexx)
        $dstr = "<strong><font color=red>需要紧急备货</font></strong>" . $goods_count . " sx:" . $warehousesx . " xx:" . $warehousexx;
    ?>



                                <tr height='20' class='oddListRowS1'>
                                    <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_id; ?>" ><?php echo $goods_id; ?></td>
                                    <td scope='row' align='left' valign="top" ><?php echo $isuse;?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $store_name;?>&nbsp;</td>

                                    <td scope='row' align='left' valign="top" >
                                <?php echo $goods_sn; ?>                            </td>

                                    <td scope='row' align='left' valign="top" ><?php echo $goods_name; ?></td>

                                    <td scope='row' align='left' valign="top" ><?php echo $company_name; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $goods_price; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $goods_unit; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $goods_location; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $goods_count; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" >
    <?php
    $start1 = date('Y-m-d H:i:s');
    $start0 = strtotime(date('Y-m-d H:i:s', strtotime("$start1 -7 days")));
    $start1 = strtotime($start1);


    $ss = "select sum(ebay_amount) as cc from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn  where b.sku='$goods_sn' and a.ebay_status != '0' and (a.ebay_createdtime>=$start0 and a.ebay_createdtime<=$start1) ";




    $ss = $dbcon->execute($ss);
    $ss = $dbcon->getResultArray($ss);
    echo $ss[0]['cc'];
    ?>

                                        &nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><a href="<?php echo $goodsurl; ?>" target="_blank"><?php echo $goodsurl; ?></a>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $goods_cost; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><?php echo $dstr; ?>&nbsp;</td>
                                    <td scope='row' align='left' valign="top" ><a href="productadd.php?pid=<?php echo $goods_id; ?>&&module=warehouse&action=货品资料添加" target="_blank">修改</a>&nbsp;					        </td>
                                </tr>




                                    <?php } ?>
                            <tr class='pagination'>
                                <td colspan='15'>
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
                                        <tr>
                                            <td nowrap="nowrap" class='paginationActionButtons'><div align="center"><? echo '<br><center>' . $page->show(2) . "</center>"; //输出分页 ?> 
                                                </div></td>
                                        </tr>
                                    </table>		</td>
                            </tr></table>


                        <div class="clear"></div>
<?php
include "bottom.php";
?>
                        <script language="javascript">

 document.getElementById('keys').focus();
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


                            function deleteallsystem(){

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
	
                                    location.href='productalert.php?module=warehouse&action=货品资料管理&type=delsystem&ordersn='+bill;
		
		
                                }

                            }


                            function searchorder(){
			 var warehouse 	= document.getElementById('warehouse').value;	
		 var isuse 	= document.getElementById('isuse').value;	
                                var content 	= document.getElementById('keys').value;	
                                location.href= 'productalert1.php?keys='+content+"&module=warehouse&isuse="+isuse+"&warehouse="+warehouse+"&action=货品资料管理";
                            }
                            function enterkeys(){
	
                                var keyCode = event.keyCode;

                                if (keyCode == 13) {
			
                                    searchorder();			
		
                                }
                            }
	
	
                            function instock(pid){
	
		
                                var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=in";
                                window.open(url,"_blank");
		
	
	
                            }
	
	
                            function outstock(pid){
	
		
                                var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=out";
                                window.open(url,"_blank");
		
	
	
                            }
	
                            function caigou(){
	
								var storeid = document.getElementById("warehouse").value;
								 var bill	= "";
                                var checkboxs = document.getElementsByName("ordersn");
                                for(var i=0;i<checkboxs.length;i++){
                                    if(checkboxs[i].checked == true){			
                                        bill = bill + ","+checkboxs[i].value;		
                                    }		
                                }
                             
								if(storeid == 0){
		
                                    alert("请选择仓库");
                                    return false;	
                                }
                                var url	= "productcaigou.php?bill="+bill+"&store_id="+storeid;
                                window.open(url,"_blank");
                            }
							 function drcaigou(){
								var url	= "productdrcaigou.php?module=warehouse&action=采购单入库";
                                window.open(url,"_blank");
							 }
                        </script>