<?php
/*
	订单扫描
*/
include "include/config.php";
$action = $_REQUEST['action'];
global $dbcon,$user;
/*获取订单内容 @order 订单号*/




if($action=='order'){
	$order = trim($_REQUEST['order']);
	$count = 0;
	$goodsall = 0;
	$lenght = strlen($order);
	if($order && $lenght<=20){
		$sql = "select scanning_id from ebay_scanning where order_number = $order and ebay_user='$user'";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		if($sql[0]){ 											//判断是否检测过  是 更新扫描表 否 插入新数据
		
			$insert = 'no';
			$upsql = "update ebay_scanning set now_order='0',check_num = '0',state = '0' where order_number = ".$order." and ebay_user='$user' ;";
			$dbcon->execute($upsql);
			
		}else{
		
			$insert = 'yes';
		}
		$sql		= "select ebay_ordersn from ebay_order where (ebay_id='$order' or ebay_tracknumber='$order') and ebay_combine 	!= 1 and ebay_user='$user' ";
		

		
		$sql			= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);
		if($sql[0]){										//判断是否有效订单 
			$ordersn    = $sql[0]['ebay_ordersn'];
			$sql		= "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$ordersn' ";
			$sql			= $dbcon->execute($sql);
			$data			= $dbcon->getResultArray($sql);
			$count = 0;
			$text = '';
			foreach($data as $key=>$val){					// 插入扫描表 并生成表格内容
				
				
				
				$sku		= $val[sku];
				$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku' and ebay_user='$user' ";
				$rr			= $dbcon->execute($rr);
				$rr 	 	= $dbcon->getResultArray($rr);
					
				if(count($rr) > 0){
		
					$goods_sncombine	= $rr[0]['goods_sncombine'];
					$goods_sncombine    = explode(',',$goods_sncombine);	
					
					
					for($e=0;$e<count($goods_sncombine);$e++){
						$pline			= explode('*',$goods_sncombine[$e]);
						$goods_sn		= $pline[0];
						$goddscount     = $pline[1] * $val[ebay_amount];
						$count ++;
						if($insert=='yes'){
							$insertsql = "insert into ebay_scanning (scanning_id, order_number , now_order,goods_name,order_num,check_num,state,ebay_user )values('','$order','0','$goods_sn',$goddscount,'0','0','$user');";
							$dbcon->execute($insertsql);
						}
						$localtion = getgoodslocation($goods_sn);
						$text.= creatTr($goods_sn,$goddscount,$localtion);
						$goodsall = $goodsall +$goddscount;
					}
				}else{
					if($insert=='yes'){
						$insertsql = "insert into ebay_scanning (scanning_id, order_number , now_order,goods_name,order_num,check_num,state,ebay_user )values('','$order','0','$val[sku]',$val[ebay_amount],'0','0','$user');";
						$dbcon->execute($insertsql);
					}
					$localtion = getgoodslocation($val['sku']);
					$text.= creatTr($val['sku'],$val['ebay_amount'],$localtion);
					$goodsall = $goodsall +$val['ebay_amount'];
					$count++;
				}
			}
			$array = array('text'=>$text,'count'=>$count,'goodsall'=>$goodsall);
			$jsonencode = json_encode($array);  
			echo $jsonencode; 								//返回 $text 表格内容  $count  物品类别数  $goodsall  物品总数量
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
	exit();
}
/*检测物品 @randorder 零时订单号 @sku 物品编号  @check_num 物品数量 @order 订单号 */
if($action=='check'){							
	$randorder = $_REQUEST['randorder'];
	$sku = $_REQUEST['ordername'];
	$check_num = $_REQUEST['ordernum'];
	$order = trim($_REQUEST['orders']);
	
	if(!$randorder){
		$randorder = rand(1,1000).time();
	} 
	$sql = "select * from ebay_scanning where goods_name = '$sku' and order_number = '$order' and state<>'y' and ebay_user='$user' ";
	$sql = $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	if($sql[0]){	//判断订单号 物品编号  是否正确
		$check_num += $sql[0]['check_num'];
		if($check_num == $sql[0]['order_num']){
			$state = 'y';
		}else{
			$state = $sql[0]['order_num'] - $check_num;
		}
		$upsql = "update ebay_scanning set now_order='$randorder',check_num = '$check_num',state = '$state' where   scanning_id='".$sql[0]['scanning_id']."';";
		$dbcon->execute($upsql);
	}
	$sql = "select * from ebay_scanning where order_number = '$order' and state = 'y' and ebay_user='$user'";
	$sql = $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$succednum = count($sql);
	$array = array('randorder'=>$randorder,'succednum'=>$succednum);
	$jsonencode = json_encode($array);  
	echo $jsonencode;     //返回 @randorder 零时订单号  @succednum 完成了的物品数量
	exit();
}
/*订单结束*/
if($action =='end'){
	$randorder = $_REQUEST['randorder'];
	$order = trim($_REQUEST['order']);
	$time =  time();
	if($order && $scaningorderstatus){
	$upsql = "update ebay_order set ebay_status='$scaningorderstatus',scantime2='$time' where (ebay_id='$order' or ebay_tracknumber='$order') and ebay_user='$user';";
	$dbcon->execute($upsql);//更新状态
	echo 1; 	
	}else{
	echo 0;
	}		
	exit();
}
/* 
	** 生成tr
	** @sku 物品编号
	** @number  物品数量
	** @return  varchar 
*/
function creatTr($sku,$number,$localtion){
	$text = '';
	$text.= "<tr class='val' id='".$sku."'>";
	$text.= "<td class='sku' style='width:70px'>".$sku."</td>";
	$text.= "<td style='width:50px'>".$localtion."</td>";
	$text.= "<td id='".$sku."num'>".$number."</td>";
	$text.= "<td id='".$sku."snum'>0</td>";
	$text.= "<td id='".$sku."state'>&nbsp;</td>";
	$text.= "</tr>";
	return $text;
}

function getgoodslocation($sku){
		global $dbcon;
			$txt = '';
			if($sku){
				$vv			= "select goods_location from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
				$vv			= $dbcon->execute($vv);
				$vv 	 	= $dbcon->getResultArray($vv);
				if($vv[0]['goods_location']){
					$txt = $vv[0]['goods_location'];
				}
			}
			return $txt;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<link rel="stylesheet" type="text/css" href="themes/default/css/scanning.css" /> 
<script src='js/jquery.js'></script>
</head>
<body>
	<div class='main'>
		<div class='orderbox'>
		订单号<input name='order' type='text' id='order' value=""/>
		</div>
		<div class='wupin'>
		物品编号：<input name='name' id='name' type='text' value=""/><br>
		物品数量：<input name='num' id='num' type='text' value="1"/>
		<input id = "randorder" type="hidden" value='0'/>
		</div>
		<div class='content'>
			请输入需要检测的订单号
		</div>
		<div id='news'>
			物品总数：<b class='count'>0</b>类 共<b class='goodsall'>0</b>件<br>
			<b id='err'></b><br>
		</div>
		<div id='msg'>
			<b id='showmsg'></b><br>
			<span id='timeout'>1</span>秒后结束<br>
		</div>
		<table>
		</table>
		<div id="music"></div>
	</div>
<script>
	$(function(){
		$('#order').focus(); //订单文本框获取光标
		$("html").die().live("keydown",function(event){     //获取键盘事件
			if(event.keyCode==13 && $("#msg").is(":hidden")){     //判断是否回车  并且不是结束时
				if($(".orderbox").is(":hidden")) {				//判断是否正在检测物品
					if($("#name").val() && $("#num").val()){			//判断物品编号 和物品数量 是否为空  
						var numID = $("#name").val()+'num';				//获取物品数量td 的id
						var stateID = $("#name").val()+'state';			//获取状态td 的id
						var snumID = $("#name").val()+'snum';			//获取扫描数量td  的id
						if($("#"+snumID).length>0){					//判断物品是否正确
							var s = parseInt($("#num").val())+parseInt($("#"+snumID).html());		// 检测数量
							$("#"+snumID).html(s);
							
							if(parseInt($("#"+snumID).html()) <= parseInt($("#"+numID).html())){			//判断检测数量是否超过 订单数量
								if($("#"+snumID).html() == $("#"+numID).html()){		//判断是否检测完成
									$("#"+stateID).html("<b style='color:green'>√</b>");		//更改状态显示
									var trhtml = $("#"+$('#name').val()).html();
									$("#"+$('#name').val()).remove();
									$('table tr:last').after("<tr class='val' id='"+$('#name').val()+"'>"+trhtml+"</tr>");		//完成行 移到末尾
								}else{			//未检测完成
									$("#"+stateID).html("<b style='color:red'>×</b>");
								}
								$('#err').ajaxStart(function(){			//等待显示
									$('#err').css('color','#000000');
									$('#err').html('物品检测中请稍后...');
								});
								//物品后台检测
								$.getJSON("?action=check&ordername="+$('#name').val()+"&ordernum="+$('#num').val()+"&randorder="+$('#randorder').val()+"&orders="+$('#order').val(),function(msg){
									//$("#music").html('<embed src="music/622.mp3" autostart="true" volume=100 loop="0" hidden="true">');
									$('#randorder').val(msg.randorder);
									$('#succed').html(msg.succednum);
									$('#err').css('color','green');
									$('#err').html('正确的物品');
									if(msg.succednum == $(".count").html()){	//判断是否全部检测完成
										$('#showmsg').css('color','green');
										$('#showmsg').html('正确的订单');
										var i =1;
										$.getJSON("?action=end&order="+$('#order').val()+"&randorder="+$('#randorder').val(),function(msg){		//后台完成
											$("#msg").show();		//完成显示框 显示
											$("table").hide();		//表格 隐藏
											$('#news').hide();		//检测信息 隐藏
											$('.wupin').hide();		// 物品编号 数量文本框 隐藏
											$('.val').remove();			//删除完成订单 表格数据
											setTimeout(showtime,1000);
										});
										function showtime(){
											i = i-1;
											if(i==0){			//时间到
												$("#msg").hide();	//完成显示框隐藏
												$("#order").val('');	//清空订单号
												$(".orderbox").show();	//显示订单号输入框
												$('.content').html('请输入需要检测的订单号');
												$('.content').show();	//提示信息框显示
												$("#order").focus();	//订单号文本框获取光标
												return;
											}
											$("#timeout").html(i);
											setTimeout(showtime,1000);
										}
									}
								});
								
							}else{		//检测数量超过订单数量
								//$("#music").html('<embed src="music/478.mp3" autostart="true" volume=100 loop="0" hidden="true">'); 
								var ss =  parseInt($("#"+snumID).html()) - parseInt($("#num").val());  //取消本次检测数量
								$("#"+snumID).html(ss);
								$("#err").css('color','red');
								$("#err").html('错误的数量');	
								setTimeout(music,500);	//显示错误
							}
						}else{  //不存在的物品编号
							//$("#music").html('<embed src="music/478.mp3" autostart="true" volume=100 loop="0" hidden="true">');
							$("#err").css('color','red');
							$("#err").html('错误的物品');	//显示错误
						}
						$("#name").val('');		//清空物品编号
					}else{	// 没有完成订单结束
						//$("#music").html('<embed src="music/478.mp3" autostart="true" volume=100 loop="0" hidden="true">');
						$("#err").css('color','red');
						$("#err").html('错误的物品1');
					}
				}else{ //订单号检测
					$('.content').ajaxStart(function(){
						$('.content').html('正在加载中请稍后...');
					});
					$.getJSON("?action=order&order="+$("#order").val(),function(msg){	//后台获取订单内容
						if(msg.text){
							//$("#music").html('<embed src="music/895.mp3" autostart="true" volume=100 loop="0" hidden="true">');
							$('.wupin').show();			//物品编号文本框显示
							$('.orderbox').hide();		//订单号文本框隐藏
							$('table').html(msg.text);	//添加表格内容
							$('.content').hide();		//提示框隐藏
							$('.count').html(msg.count);	//物品类别数
							$('.goodsall').html(msg.goodsall);		//总物品件数
							$('#err').html('请输入物品编号');
							$('#news').show();			//检测信息框显示
							$('table').show();			//表格显示
							$('#name').focus();			//物品编号获取光标
						}else{		//错误订单号 
							//$("#music").html('<embed src="music/486.wav" autostart="true" volume=100 loop="0" hidden="true">');
							$(".content").html('错误的订单号！'); 
							$("#order").val('');//显示错误
						}
					});
				}
			 }     
		});
		// function music(){
			// $("#music").html('<embed src="music/478.mp3" autostart="true" volume=100 loop="0" hidden="true">');
		// }         
	});
</script>
</body>
</html>