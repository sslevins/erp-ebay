<?php 
include "../include/config.php";


	$id		= $_REQUEST['id'];
	
	

	
	if($_POST['submit']){
	
		
		$time			= strtotime($_POST['time']);
		$ntime			= strtotime($_POST['ntime']);
		$import			= $_POST['import'];
		$ebay_xmsn		= $_POST['ebay_xmsn'];
		$ebay_account	= $_POST['ebay_account'];
		$ebay_userid	= $_POST['ebay_userid'];
		$sku			= $_POST['sku'];
		$method			= $_POST['method'];
		$note			= $_POST['note'];
		$status			= $_POST['status'];
		$title			= $_POST['title'];

		
		
		if($id == ''){
			
			$sql		= "insert into ebay_complain(import,time,ebay_xmsn,ebay_account,ebay_userid,reason,title,sku,method,ntime,note,status,user) values('$import','$time','$ebay_xmsn','$ebay_account','$ebay_userid','$reason','$title','$sku','$method','$ntime','$note','$status','$user')";
			
		
		
		}else{
		
			
			$sql		= "update ebay_complain set import='$import',time='$time',ebay_xmsn='$ebay_xmsn',ebay_account='$ebay_account',ebay_userid='$ebay_userid',reason='$reason',title='$title',sku='$sku',method='$method',ntime='$ntime',note='$note',status='$status',user='$user' where id='$id' ";
			 
		
		
		}
		

		

		if($dbcon->execute($sql)){

			

			$sstatus = "$sn 操作成功";

		}else{

			$sstatus = "$sn 操作失败";

		}

		
	
	
	}
	
	
	$ss		= "select * from ebay_complain where id='$id'";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	
	
	$import				= $ss[0]['import'];
	$time				= $ss[0]['time']?$ss[0]['time']:strtotime(date('Y-m-d'));
	$time				= date('Y-m-d',$time);
	
	$ebay_xmsn			= $ss[0]['ebay_xmsn']?$ss[0]['ebay_xmsn']:date('Ymd').rand(100,999);
	$ebay_account		= $ss[0]['ebay_account'];
	$ebay_userid		= $ss[0]['ebay_userid'];
	$reason				= $ss[0]['reason'];
	$title				= $ss[0]['title'];
	$sku				= $ss[0]['sku'];
	$method				= $ss[0]['method'];

	$ntime				= $ss[0]['ntime']?$ss[0]['ntime']:strtotime(date('Y-m-d'));
	$ntime				= date('Y-m-d',$ntime);
	$note				= $ss[0]['note'];
	$status				= $ss[0]['status'];
	
	
	
	
	
	
	
	
 ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
}
-->
</style>

<link href="../images/skin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../My97DatePicker/WdatePicker.js"></script>
<body>
<input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td width="1138" height="29" valign="top" background="../images/content-bg.gif"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
      <tr>
        <td height="31"><div class="titlebt"></div></td>
      </tr>
    </table></td>
    <td width="21" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="71" valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%" height="138" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="13" valign="top"><?php echo $sstatus;?>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="left_txt">当前位置：Dispute加载</td>
          </tr>
          <tr>
            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			    <td width="100%"><table width="100%" height="420" border="0" cellpadding="0" cellspacing="0">
                
			    <form method="post" action="s_customeradd.php?id=<?php echo $id;?>">   
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">优先级</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><select name="import" id="import">
			          <option value="一般" <?php if($import == '一般') echo  "selected" ?>>一般</option>
			          <option value="重要  <?php if($import == '重要') echo  "selected" ?>">重要</option>
			          <option value="非常重要" <?php if($import == '非常重要') echo  "selected" ?>>非常重要</option>
			        </select></div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">日期</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="time" type="text" id="time" onClick="WdatePicker()" value="<?php echo $time;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">档案编号</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="ebay_xmsn" type="text" id="ebay_xmsn" value="<?php echo $ebay_xmsn; ?>">
			          </div></td>
			        </tr>
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">eBay帐号:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <select name="ebay_account" id="ebay_account">
                        <option value="all">All account</option>
                        <?php 
					
					$sql	 = "select * from ebay_account where ebay_user='$user'";
				
					
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                        <option value="<?php echo $account;?>" <?php if($ebay_account == $account ) echo  "selected" ?> ><?php echo $account;?></option>
                        
                        <?php } ?>
                        
                        <option value="速卖通" <?php if($ebay_account == '速卖通' ) echo  "selected" ?> >速卖通</option>
                        
                        
                      </select>
                    </div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">买家ID</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="ebay_userid" type="text" id="ebay_userid" value="<?php echo $ebay_userid;?>">
			          </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">抱怨原因</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="reason" id="reason">
                        <option value="物品未收到" <?php if($reason == '物品未收到' ) echo  "selected" ?>>物品未收到</option> 
                        <option value="物品破损" <?php if($reason == '物品破损' ) echo  "selected" ?>>物品破损</option> 
                        <option value="收到错误的物品" <?php if($reason == '收到错误的物品' ) echo  "selected" ?>>收到错误的物品</option> 
                        <option value="物品不合适" <?php if($reason == '物品不合适' ) echo  "selected" ?>>物品不合适</option>            
                         <option value="物品质量问题" <?php if($reason == '物品质量问题' ) echo  "selected" ?>>物品质量问题</option>                   
                          <option value="物品缺失" <?php if($reason == '物品缺失' ) echo  "selected" ?>>物品缺失</option>                          
                      </select>
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">物品信息</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="title" type="text" id="title" value="<?php echo $title;?>">
			          </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">SKU</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="sku" type="text" id="sku" value="<?php echo $sku;?>">
			          </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">处理方式</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="method" type="text" id="method" value="<?php echo $method;?>">
                    </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">下个跟进的时间</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="ntime" type="text" id="ntime" value="<?php echo $ntime;?>" onClick="WdatePicker()">
			          </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">备注</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="note" type="text" id="note" value="<?php echo $note;?>">
			          </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">档案状态</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="status" id="status">
                        <option value="开启" <?php if($status == '开启' ) echo  "selected" ?> >开启</option>
                        <option value="关闭" <?php if($status == '关闭' ) echo  "selected" ?>>关闭</option>
                        <option value="等待回复" <?php if($status == '等待回复' ) echo  "selected" ?>>等待回复</option>
                        <option value="等待跟进" <?php if($status == '等待跟进' ) echo  "selected" ?>>等待跟进</option>
                      </select>
			        </div></td>
			        </tr>
                
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" onClick="check()" value="Add">
                    </div></td>
                    </tr>
                        </form> 
                      
                </table>			      
			  <tr>
                <td width="80%" height="17" colspan="4" align="right" ><div align="left">
             </td>
              </tr>
            
            </table></td>
          </tr>
        </table>
          </td>
      </tr>
    </table></td>
    <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="../images/mail_leftbg.gif"><img src="../images/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="../images/buttom_bgs.gif"><img src="../images/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>
</body>
<script language="javascript">

	
	function check(){
		
		var account	= document.getElementById('account').value;

		location.href='f_disputeadd.php?account='+account;
		
	}



</script>

