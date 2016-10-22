<?php

include "include/config.php";





include "top.php";





	$tracknumber		= $_REQUEST['tracknumber'];

	$value				= trim($_REQUEST['value']);

	$shiptype			= $_REQUEST['shiptype'];

	$storeid			= $_REQUEST['storeid'];

	$sw		= '';

	if($storeid == '69') $str	= "深圳";

	if($storeid == '70') $str	= "苏州";

	

	

	if($value != ''){

	

	$ss					= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where (a.ebay_id='$value' or a.ebay_tracknumber='$value') ";

	

	$ss					= $dbcon->execute($ss);

	$ss					= $dbcon->getResultArray($ss);

	

	if(count($ss)  == '0'){

		

		$status = " -[<font color='#FF0000'>操作记录:未找到订单</font>]";	

		echo "<script>alert('".'未找到订单'."')</script>";

		$sw	= 1;

		

	}else{

		

		

		

			$ystatus		= $ss[0]['ebay_status'];

			$ebay_carrier	= $ss[0]['ebay_carrier'];

			$account		= $ss[0]['ebay_account'];

			$osn			= $ss[0]['ebay_ordersn'];	

		if($ystatus     == '123'){

			

			$status = " -[<font color='#33CC33'>操作记录订单核对成功</font>]";

			if($tracknumber != ''){

			

			$ss		= "update ebay_order set ebay_status='2',ebay_tracknumber='$tracknumber',scantime='$mctime' where ebay_id='$value' or ebay_tracknumber='$value' ";

			

			

				$type		 = 0;

				$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";

				$sql		 = $dbcon->execute($sql);

				$sql		 = $dbcon->getResultArray($sql);

				$token		 = $sql[0]['ebay_token'];

				CompleteSale02($token,$osn,$type);

			

			

			

			

			}else{

			

			$ss		= "update ebay_order set ebay_status='2',scantime='$mctime' where ebay_id='$value' or ebay_tracknumber='$value' ";

			}

			

			

				

			

		//	if($ebay_carrier != 'E邮宝' ){

				

			$sb		= "update ebay_order set ebay_markettime='$mctime',ShippedTime='$mctime' where ebay_ordersn='$osn'";

			$dbcon->execute($sb);

				addoutstock($osn);

				

				

				

		//	}

			

			$dbcon->execute($ss);

		

		}else{

		

		

			$status = " -[<font color='#33CC33'>订单不在已处理，请检查...</font>]";

			echo "<script>alert('".'订单不在已处理，通知客服人员'."')</script>";

				$sw	= 1;

		}

		

		

		

	}

	}









 ?>

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo "订单扫描".$status.' '.$str;?> </h2>

</div>



<div class='listViewBody'>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

  <?php if($sw == '1'){ ?>

 <embed   src= "r.wav"   loop=false  autostart=true   name=bgss   width="0"   height=0> 

 

 <?php } ?>





<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%">

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

				  <td nowrap="nowrap" class='paginationActionButtons'>

				    <table width="100%" border="0" align="center">

				      <tr>

				        <td width="53%"><DIV style="font-size:36px">1.订单号/跟踪号:

				          <input name="order" type="text" id="order" onkeydown="check01()" style="width:180px; height:50px; font-size:24px" />

				        </DIV>		                </td>

				        <td width="47%" colspan="3" rowspan="3" valign="top">包装人员：

				          <select name="packagingstaff" id="packagingstaff">

                            <?php

							

							$ss		= "select * from ebay_user where username ='$truename'  ";

							$ss		= $dbcon->execute($ss);

							$ss		= $dbcon->getResultArray($ss);

							

							for($i=0;$i<count($ss); $i++){

							

								

											$usernames	= $ss[$i]['username'];

								

							?>

                            <option value="<?php echo $usernames;?>" <?php if($cguser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>

                            <?php

							

							}

							

							 ?>

                          </select>

				          <br />

				        <div id="mstatus2"> </div>

				        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                          <tr>

                            <td>&nbsp;</td>

                          </tr>

                          <tr>

                            <td>同步重量

                              <input name="currentweight" type="text" id="currentweight" style="width:120px; height:50px; font-size:46px"  onkeydown="getnewweight()"  />

                              <input type="button" value="手动确认重量" onclick="updateweight2()"  /></td>

                          </tr>

                          <tr>

                            <td><span style="font-size:36px">产品计算重量：</span>   <div id="mstatus3" style="font-size:36px">    </div>   </td>

                          </tr>

                        </table>

				        <br /></td>

				      </tr>

				      

				      <tr>

				        <td>

                        <div id="mstatus" style="font-size:36px">                        </div>            

                        

                        <DIV style="font-size:36px">2.同步重量</DIV>                                              </td>

		              </tr>

				      <tr>

				        <td>

                        

                         

        <Applet id="app" code="a.class" height=387 width=400>

<PARAM NAME = ARCHIVE VALUE = "comm.jar" >





<param name=myName value="kaka"> 





<param name=mySex value="mail">



<param name=myNum value=200630170> 





<param name=myAge value=22>

</Applet>

                        

                        &nbsp;</td>

			          </tr>

				      <tr>

				        <td colspan="4"><select name="account3" size="10" multiple="multiple" id="account3">

                          <?php 

					

					$sql	 = "select * from ebay_account as a  where a.ebay_user='$user'   ";

					$sql	 = $dbcon->execute($sql);

					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$account	= $sql[$i]['ebay_account'];

					 ?>

                          <option value="<?php echo $account;?>"><?php echo $account;?></option>

                          <?php } ?>

                        </select>

				          扫描开始时间:

                        

                        

                        <?php

						

						$start1						= date('Y-m-d ').' 00:00:00';

						$start2						= date('Y-m-d ').' 23:59:59';

							

	

						

						

						?>

				          <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start1;?>" />

			            扫描结束时间:

			            <input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $start2;?>" />

			            <input type="button" value="导出到xls" onclick="xlsbaobiao()" /></td>

			          </tr>

				      <tr>

				        <td colspan="4">速卖通批量发货格式化导出:<br />

				          eBay帐号：

				            <select name="account" id="account">

                              <?php 

					

				$sql	 = "select * from ebay_account as a where a.ebay_user='$user' and ($ebayacc) order by a.ebay_account desc ";

						$sql	 = $dbcon->execute($sql);

					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$account	= $sql[$i]['ebay_account'];

					 ?>

                              <option value="<?php echo $account;?>"><?php echo $account;?></option>

                              <?php } ?>

                            </select>

			              扫描开始时间:

                        

                        

                        <?php

						

						$start1						= date('Y-m-d ').' 00:00:00';

						$start2						= date('Y-m-d ').' 23:59:59';

							

	

						

						

						?>

                          <input name="start1" id="start1" type="text" onclick="WdatePicker()" value="<?php echo $start1;?>" />

扫描结束时间:

<input name="end1" id="end1" type="text" onclick="WdatePicker()" value="<?php echo $start2;?>" />

<input type="button" value="导出到xls" onclick="xlsbaobiao2()" />

<br />

<br />

B2B销售报表数据导出：<br />

eBay帐号：

<select name="account2" id="account2">

  <?php 

					

					$sql	 = "select * from ebay_account as a where a.ebay_user='$user' and ($ebayacc) order by a.ebay_account desc ";

					$sql	 = $dbcon->execute($sql);

					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$account	= $sql[$i]['ebay_account'];

					 ?>

  <option value="<?php echo $account;?>"><?php echo $account;?></option>

  <?php } ?>

</select>

扫描开始时间:

<?php

						

						$start1						= date('Y-m-d ').' 00:00:00';

						$start2						= date('Y-m-d ').' 23:59:59';

							

	

						

						

						?>

<input name="start2" id="start2" type="text" onclick="WdatePicker()" value="<?php echo $start1;?>" />

扫描结束时间:

<input name="end2" id="end2" type="text" onclick="WdatePicker()" value="<?php echo $start2;?>" />

<input type="button" value="导出到xls" onclick="xlsbaobiao3()" /><br /></td>

			          </tr>

				      <tr>

				        <td colspan="4">&nbsp;</td>

			          </tr>

			        </table>

				

				  </td>

			    </tr>

			</table>		</td>

	</tr>

		



              

		<tr class='pagination'>

		<td>

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'></td>

					</tr>

			</table>		</td>

	</tr></table>





    <div class="clear"></div>

<?php



include "bottom.php";





?>

<script language="javascript">





	function xlsbaobiao(){

	

		

		var start		= document.getElementById('start').value;

		var end			= document.getElementById('end').value;

		var account		= '';

		

		

		

		

		var len			= document.getElementById('account3').options.length;

		 for(var i = 0; i < len; i++){

		   if( document.getElementById('account3').options[i].selected){

			var e =  document.getElementById('account3').options[i];

			

			account	+= e.value+'#';

		

		   }

		  }

		

	

		

		var url			= 'xlsbaobiao.php?start='+start+"&end="+end+"&account="+encodeURIComponent(account);

		window.open(url,"_blank");

		

	

	}

	function xlsbaobiao2(){

	

		

		var start		= document.getElementById('start1').value;

		var end			= document.getElementById('end1').value;

		var account			= document.getElementById('account').value;

		var url			= 'xlsbaobiao2.php?start='+start+"&end="+end+"&account="+account;

		window.open(url,"_blank");

		

	

	}

	

	

	function xlsbaobiao3(){

	

		

		var start		= document.getElementById('start2').value;

		var end			= document.getElementById('end2').value;

		var account			= document.getElementById('account').value;

		var url			= 'xlsbaobiao3.php?start='+start+"&end="+end+"&account="+account;

		window.open(url,"_blank");

		

	

	}

	

	

	

	var ebayid	= '';

	

	

	var xmlHttpRequest;  



    function createXMLHttpRequest(){  



        try  



        {  



       // Firefox, Opera 8.0+, Safari  



        xmlHttpRequest=new XMLHttpRequest();  



        }  



     catch (e)  



        {  



  



      // Internet Explorer  



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

	

	

	var i	= 0;

	var g   = 2;

	var yy	= 0;

	var ss	= 0;



	var currentweight = 0;

	



	function datasend(){

	i++

	currentweight			=  window.document.app.currentweight;

	

	if(currentweight >= 0){

	

	document.getElementById('currentweight').value = currentweight;

	}

	

	

	

//	document.getElementById('mstatus').innerHTML =  currentweight;

	if(currentweight>0){

	

		if(yy<=0){			

			yy	= setInterval("yyyuu();",1000); 

		}

	

	}else{

	

		clearInterval(yy);

		yy = 0;		

		g  = 2;

				

	}



	

}





function yyyu(){





ss = setInterval("datasend();",100); 





}



function yyyuu(){



	

	document.getElementById('mstatus').innerHTML =  'Please wait '+g+' seconds,this weight will be update';	

	g	= g-1;

	if(g == 0){

		clearInterval(ss);

		clearInterval(yy);

		 i	= 0;

		 g   = 2;

yy	= 0;

 ss	= 0;

updateweight2();



		

		

	}

		

}









function updateweight2(){



			var url		= "getajax2.php";

			currentweight		= document.getElementById('currentweight').value;

			var packagingstaff	= document.getElementById('packagingstaff').value;	

			

			

			

			if(ebayid == ''){

		

		alert('请先扫描订单号');

				return false;

		}

			

			var param	= "type=tracknumber2&ebayid="+ebayid+"&packagingstaff="+packagingstaff+"&currentweight="+currentweight;			sendRequestPost2(url,param);



			



}





	

	function check01(){

		

		var order	= document.getElementById('order').value;	

		var keyCode = event.keyCode;

		
order 		= order.replace('TB','');
		

		if (keyCode == 13) {

			

			ebayid	= order;

			document.getElementById('mstatus').innerHTML="<img src=cx.gif />";

			

			var url		= "getajax2.php";

			var param	= "type=checkorder&ebayid="+ebayid;

			sendRequestPost(url,param);

		}

		

		

	}

	

	

	

	function check02(){

		var packagingstaff	= document.getElementById('packagingstaff').value;	

		var tracknumber		= document.getElementById('tracknumber').value;	

		var keyCode 		= event.keyCode;



		if (keyCode == 13) {





			document.getElementById('mstatus').innerHTML="<img src=cx.gif />";

			var url		= "getajax2.php";

			var param	= "type=tracknumber&ebayid="+ebayid+"&tracknumber="+tracknumber+"&packagingstaff="+packagingstaff;

			

			sendRequestPost4(url,param);

		}

		

	}

	

	

	

	 function sendRequestPost4(url,param){

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true); 

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 

        xmlHttpRequest.onreadystatechange = processResponse4; 

        xmlHttpRequest.send(param); 

    }  

    //处理返回信息函数 

    function processResponse4(){

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  







				if(res == '1'){

				

					document.getElementById('mstatus').innerHTML="<font color='#33CC33' size='50px'>核对成功，出库成功</font>";

					document.getElementById('order').focus();

					document.getElementById('order').value	= '';

					document.getElementById('tracknumber').value	= '';

					document.getElementById('currentweight').value	= '';

									

				//	yyyu();

					

				}else{

					if(res == '2'){
					document.getElementById('mstatus').innerHTML="<font color='#FF0000'>核对成功，出库失败</font>";
					}else{
					document.getElementById('mstatus').innerHTML="<font color='#FF0000'>核对失败</font>";
					}

				

				}

				

				document.getElementById('mstatus2').innerHTML="";

				

								

            }

			

        }  



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

	



				if(res == '1'){

				

					document.getElementById('mstatus').innerHTML="<font color='#33CC33'>核对成功</font>";

					

					

					

					

					var url		= "getajax2.php";

					var param	= "type=getpweight&ebayid="+ebayid;

					sendRequestPost55(url,param);

					document.getElementById('currentweight').focus();

				//	yyyu();

					

				}else{

					document.getElementById('mstatus').innerHTML="<font color='#FF0000'>核对失败</font>";

				

				}

				

				document.getElementById('mstatus2').innerHTML="";

				

								

            }

			

        }  



    }  

	

	

	

	 function sendRequestPost2(url,param){

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true); 

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 

        xmlHttpRequest.onreadystatechange = processResponse2; 

        xmlHttpRequest.send(param); 

    }  

    //处理返回信息函数 

    function processResponse2(){

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  

	

				

				if(res == '1'){

					

					document.getElementById('mstatus').innerHTML="<font color='#33CC33' size='50px'>核对成功,重量同步成功</font>";

					document.getElementById('order').focus();

					document.getElementById('order').value	= '';

					document.getElementById('currentweight').value	= '';

					

				}else{

					document.getElementById('mstatus').innerHTML="<font color='#FF0000'>重量同步失败</font>";

				

				}

								

            }

			

        }  



    }

	

	

	

	function listshipfee(){

	

			var url		= "getajax2.php";

			currentweight		= document.getElementById('currentweight').value;

			var param	= "type=listshipfee&ebayid="+ebayid+"&currentweight="+currentweight;

			

			sendRequestPost3(url,param);

	

	

	

	

	}

	 function sendRequestPost3(url,param){

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true); 

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 

        xmlHttpRequest.onreadystatechange = processResponse3; 

        xmlHttpRequest.send(param); 

    }  

    //处理返回信息函数 

    function processResponse3(){

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  



					document.getElementById('mstatus2').innerHTML= res+' 使用鼠标单击可以可修改运送方式';

					document.getElementById('tracknumber').select();	

					

								

            }

			

        }  



    }

	

	

	function changeship(){

	

			var url		= "getajax2.php";

			var packingby		= document.getElementById('packingby').value;

			var param	= "type=changemethod&ebayid="+ebayid+"&packingby="+packingby;

			

			sendRequestPost5(url,param);

	

	

	}

	

	

	

	

	 function sendRequestPost5(url,param){

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true); 

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 

        xmlHttpRequest.onreadystatechange = processResponse5; 

        xmlHttpRequest.send(param); 

    }  

    //处理返回信息函数 

    function processResponse5(){

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  





				if(res == '1'){

				

					document.getElementById('mstatus').innerHTML="<font color='#33CC33'>运送方式修改成功</font>";

					

				}else{

					document.getElementById('mstatus').innerHTML="<font color='#FF0000'>运送方式修改失败</font>";

				

				}

								

            }

			

        }  



    }

	 document.getElementById('order').select();	

		function exportsebay(type){

		

		

		var url		= '';

		var start		= document.getElementById('start').value;	

		var end		= document.getElementById('end').value;	



			

		url		= "xlstoshrebay.php?start="+start+"&end="+end;

				

window.open(url);

		

		

		

		

		

	}

	

	

	

	

	 function sendRequestPost55(url,param){

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true); 

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 

        xmlHttpRequest.onreadystatechange = processResponse55; 

        xmlHttpRequest.send(param); 

    }  

    //处理返回信息函数 

    function processResponse55(){

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  

				document.getElementById('mstatus3').innerHTML="<font color='#FF0000'>"+res+"</font>";

				

								

            }

			

        }  



    }

	



function getnewweight(){

	

		var keyCode 		= event.keyCode;

		if (keyCode == 13) {

		

		currentweight			=  window.document.app.currentweight;

		//if(currentweight >= 0){

			 document.getElementById('currentweight').value = currentweight;

			 updateweight2();

		 

		 

		}

	//	}

		

	}



</script>

