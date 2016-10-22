<?php
include "include/config.php";


include "top.php";




	
	$id		= $_REQUEST['id'];
	
	if($_POST['submit']){
		
		$pass		 = $_POST['pass1'];
		
		$ss			 = "select * from eub_account where pid='$id'";
		$ss			 = $dbcon->execute($ss);
		$ss			 = $dbcon->getResultArray($ss);
		
		
	
		$ebay_account		 = trim($_POST['ebay_account']);
		$dev_id				 = trim($_POST['dev_id']);
		$dev_sig			 = trim($_POST['dev_sig']);
		
		
		$pname					 = trim($_POST['pname']);
		$pcompany				 = trim($_POST['pcompany']);
		$pcountry				 = trim($_POST['pcountry']);
		$pprovince				 = trim($_POST['pprovince']);
		$pcity					 = trim($_POST['pcity']);
		$pdis					 = trim($_POST['pdis']);
		$pstreet				 = trim($_POST['pstreet']);
		$pzip					 = trim($_POST['pzip']);
		$ptel					 = trim($_POST['ptel']);
		$pte1					 = trim($_POST['pte1']);
		$pemail					 = trim($_POST['pemail']);
		$dname					 = trim($_POST['dname']);
		$dcompany				 = trim($_POST['dcompany']);
		$dcountry				 = trim($_POST['dcountry']);
		$dprovince				 = trim($_POST['dprovince']);
		$dcity					 = trim($_POST['dcity']);
		$ddis					 = trim($_POST['ddis']);
		$dstreet				 = trim($_POST['dstreet']);
		$dzip					 = trim($_POST['dzip']);
		$dtel					 = trim($_POST['dtel']);
		$demail					 = trim($_POST['demail']);
		$shiptype				 = trim($_POST['shiptype']);
		
		/* return addess*/
		$rname					 = trim($_POST['rname']);
		$rcompany				 = trim($_POST['rcompany']);
		$rcountry				 = trim($_POST['rcountry']);
		$rprovince				 = trim($_POST['rprovince']);
		$rcity					 = trim($_POST['rcity']);
		$rdis					 = trim($_POST['rdis']);
		$rstreet				 = trim($_POST['rstreet']);
		

		
		if(count($ss) > 0){
	
		
			$sql		 = "update eub_account set ebay_account='$ebay_account',dev_id='$dev_id',dev_sig='$dev_sig',pname='$pname',pcompany='$pcompany',pcountry='$pcountry',pprovince='$pprovince',pcity='$pcity',pdis='$pdis',pstreet='$pstreet',pzip='$pzip',ptel='$ptel',pte1='$pte1',pemail='$pemail',dname='$dname',dcompany='$dcompany',dcountry='$dcountry',dprovince='$dprovince',dcity='$dcity',ddis='$ddis',dstreet='$dstreet',dzip='$dzip',dtel='$dtel',demail='$demail',shiptype='$shiptype',rname='$rname', rcompany='$rcompany',rcountry='$rcountry',rprovince='$rprovince',rcity='$rcity',rdis='$rdis',rstreet='$rstreet' where pid='$id'";
		
		}else{
			
			$sql		 = "insert into eub_account(ebay_account,dev_id,dev_sig,pid,pname,pcompany,pcountry,pprovince,pcity,pdis,pstreet,pzip,ptel,pte1,pemail,dname,dcompany,dcountry,dprovince,dcity,ddis,dstreet,dzip,dtel,demail,shiptype,rname,rcompany,rcountry,rprovince,rcity,rdis,rstreet) values('$ebay_account','$dev_id','$dev_sig','$id','$pname','$pcompany','$pcountry','$pprovince','$pcity','$pdis','$pstreet','$pzip','$ptel','$pte1','$pemail','$dname','$dcompany','$dcountry','$dprovince','$dcity','$ddis','$dstreet','$dzip','$dtel','$demail','$shiptype','$rname','$rcompany','$rcountry','$rprovince','$rcity','$rdis','$rstreet')";
			
			
		
		}
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 修改成功</font>]";
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 修改失败</font>]";
		}
		
		
		
		
		
	}
	
	
	$ss			 = "select * from eub_account where pid='$id'";
	$ss			 = $dbcon->execute($ss);
	$ss			 = $dbcon->getResultArray($ss);
	
	 $ebay_account					  = $ss[0]['ebay_account'];
	  $dev_id					  = $ss[0]['dev_id'];
	  $dev_sig					  = $ss[0]['dev_sig'];
	 
	$pname				  = $ss[0]['pname'];
	$pcompany				  = $ss[0]['pcompany'];
	$pcountry				  = $ss[0]['pcountry'];
	$pprovince				  = $ss[0]['pprovince'];
	$pcity					  = $ss[0]['pcity'];
	$pdis					  = $ss[0]['pdis'];
	$pstreet		 		  = $ss[0]['pstreet'];	
	$pzip			 		  = $ss[0]['pzip'];	
	$ptel					  = $ss[0]['ptel'];	
	$pte1				  	  = $ss[0]['pte1'];	
	$pemail				  	  = $ss[0]['pemail'];	
	$dname				  	  = $ss[0]['dname'];	
	$dcompany				  = $ss[0]['dcompany'];	
	$dcountry				  = $ss[0]['dcountry'];	
	$dprovince			  	  = $ss[0]['dprovince'];	
	$dcity			  		  = $ss[0]['dcity'];	
	$ddis			          = $ss[0]['ddis'];	
	$dstreet			      = $ss[0]['dstreet'];	
	$dzip			  		  = $ss[0]['dzip'];	
	$dtel				      = $ss[0]['dtel'];	
	$demail			 	      = $ss[0]['demail'];	
	$shiptype			 	  = $ss[0]['shiptype'];	
	
	$rname			 		  = $ss[0]['rname'];	
	$rcompany			 	  = $ss[0]['rcompany'];	
	$rcountry			 	  = $ss[0]['rcountry'];	
	$rprovince			 	  = $ss[0]['rprovince'];	
	$rdis			 	  	  = $ss[0]['rdis'];	
	$rstreet			 	  = $ss[0]['rstreet'];	
	$rcity			 	  = $ss[0]['rcity'];	
	


 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td>'
            <div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="systemeubsetup.php?module=system&action=邮件帐号设置&id=<?php echo $id;?>">
                  <table width="63%" border="0" align="center" cellspacing="0" class="left_txt">
                    <tr>
                      <td width="22%">eBay帐号：</td>
                      <td width="78%"><input name="ebay_account" type="text" id="ebay_account" value="<?php echo $ebay_account;?>">
&nbsp;</td>
                    </tr>
                    <tr>
                      <td> API开发者ID ：</td>
                      <td><input name="dev_id" type="text" id="dev_id" value=<?php echo $dev_id;?>>
&nbsp;</td>
                    </tr>
                    <tr>
                      <td> API 签名 ：</td>
                      <td><input name="dev_sig" type="text" id="dev_sig" value="<?php echo $dev_sig;?>" />
                        <br />
                      在EUB主页，选择系统设置-》ebay帐号管理-》查看API凭证，将您看到的三个参数添加到系统中来。</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>默认交运&nbsp;</td>
                      <td><select name="shiptype" id="shiptype">
                        <option value="0"  <?php if($shiptype == '0') echo "selected=\"selected\"" ?>>上门揽收</option>
                         <option value="1" <?php if($shiptype == '1') echo "selected=\"selected\"" ?>>卖家自送</option>
                      </select>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2"><h2>默认揽收信息&nbsp;</h2></td>
                    </tr>
                    <tr>
                      <td> 联系人 ： </td>
                      <td><input name="pname" type="text" id="pname" value="<?php echo $pname;?>" /></td>
                    </tr>
                      <tr>
                      <td> 公司名称 ： </td>
                      <td><input name="pcompany" type="text" id="pcompany" value="<?php echo $pcompany;?>" /></td>
                    </tr>
                      <tr>
                      <td valign="top"> 联系地址 ： </td>
                      <td valign="top">省市区，请填写对应代码，参考如下:<br />
                          <a href="http://www.ebay.cn/uploadfile/2011/0304/eBay_ePacket_API_V2_Readme.pdf">http://www.ebay.cn/uploadfile/2011/0304/eBay_ePacket_API_V2_Readme.pdf</a> <br />
                          4.5 节揽收地址代码<br />
                        <br />
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5%">国家 </td>
                            <td width="95%"><input name="pcountry" type="text" id="pcountry" value="<?php echo $pcountry;?>"/></td>
                          </tr>
                          <tr>
                            <td>省 </td>
                            <td><input name="pprovince" type="text" id="pprovince" value="<?php echo $pprovince;?>"/></td>
                          </tr>
                          <tr>
                            <td>市 </td>
                            <td><input name="pcity" type="text" id="pcity" value="<?php echo $pcity;?>"/></td>
                          </tr>
                          <tr>
                            <td>区</td>
                            <td><input name="pdis" type="text" id="pdis" value="<?php echo $pdis;?>"/></td>
                          </tr>
                        </table>
                        <br /></td>
                    </tr>
                      <tr>
                      <td> 街道地址： </td>
                      <td><input name="pstreet" type="text" id="pstreet" value="<?php echo $pstreet;?>"/></td>
                    </tr>
                      <tr>
                      <td> 邮政编码 ： </td>
                      <td><input name="pzip" type="text" id="pzip" value="<?php echo $pzip;?>"/></td>
                    </tr>
                      <tr>
                        <td>手机号码 ：                        </td>
                        <td><input name="ptel" type="text" id="ptel" value="<?php echo $ptel;?>"/></td>
                      </tr>
                      <tr>
                        <td> 固定电话 ： </td>
                        <td><input name="pte1" type="text" id="pte1" value="<?php echo $pte1;?>"/></td>
                      </tr>
                      <tr>
                        <td> 电子邮件 ： </td>
                        <td><input name="pemail" type="text" id="pemail" value="<?php echo $pemail;?>"/></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><h2>默认英文退货地址</h2>                          </td>
                      </tr>
                      <tr>
                        <td>Name:</td>
                        <td><input name="dname" type="text" id="dname" value="<?php echo $dname;?>"/></td>
                      </tr>
                      <tr>
                        <td>Company:</td>
                        <td><input name="dcompany" type="text" id="dcompany" value="<?php echo $dcompany;?>"/></td>
                      </tr>
                      <tr>
                        <td>Address:</td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5%">国家 </td>
                            <td width="95%"><input name="dcountry" type="text" id="dcountry" value="<?php echo $dcountry;?>"/></td>
                          </tr>
                          <tr>
                            <td>省 </td>
                            <td><input name="dprovince" type="text" id="dprovince" value="<?php echo $dprovince;?>"/></td>
                          </tr>
                          <tr>
                            <td>市 </td>
                            <td><input name="dcity" type="text" id="dcity" value="<?php echo $dcity;?>"/></td>
                          </tr>
                          <tr>
                            <td>区</td>
                            <td><input name="ddis" type="text" id="ddis" value="<?php echo $ddis;?>"/></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td>Street:</td>
                        <td><input name="dstreet" type="text" id="dstreet" value="<?php echo $dstreet;?>"/></td>
                      </tr>
                      <tr>
                        <td>Zip Code:</td>
                        <td><input name="dzip" type="text" id="dzip" value="<?php echo $dzip;?>"/></td>
                      </tr>
                      <tr>
                        <td>Mobile:</td>
                        <td><input name="dtel" type="text" id="dtel" value="<?php echo $dtel;?>"/></td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td><input name="demail" type="text" id="demail" value="<?php echo $demail;?>"/>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><h2>默认中文退货地址</h2></td>
                      </tr>
                      <tr>
                        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="14%"> 联系人 ： </td>
                            <td width="86%"><input name="rname" type="text" id="rname" value="<?php echo $rname;?>"/></td>
                          </tr>
                          <tr>
                            <td> 公司名称 ： </td>
                            <td><input name="rcompany" type="text" id="rcompany" value="<?php echo $rcompany;?>"/></td>
                          </tr>
                          <tr>
                            <td> 联系地址 ： </td>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="7%">国家 </td>
                                <td width="93%"><input name="rcountry" type="text" id="rcountry" value="<?php echo $rcountry;?>"/></td>
                              </tr>
                              <tr>
                                <td>省 </td>
                                <td><input name="rprovince" type="text" id="rprovince" value="<?php echo $rprovince;?>"/></td>
                              </tr>
                              <tr>
                                <td>市 </td>
                                <td><input name="rcity" type="text" id="rcity" value="<?php echo $rcity;?>"/></td>
                              </tr>
                              <tr>
                                <td>区</td>
                                <td><input name="rdis" type="text" id="rdis" value="<?php echo $rdis;?>"/></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td> 街道地址 ： </td>
                            <td><input name="rstreet" type="text" id="rstreet" value="<?php echo $rstreet;?>"/></td>
                          </tr>
                        </table></td>
                      </tr>
                    
                    <tr>
                      <td colspan="2"><input name="submit" type="submit" value="提交" onClick="return check()">
                        &nbsp;</td>
                      </tr>
                  </table>
                  </form>
					  <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p></td>
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

<script language="javascript">
	
	function check(){
	
		var pas1	= document.getElementById('pass1').value;
		var pas2	= document.getElementById('pass2').value;
		
		if(pas1 == "" || pas2 == ""){
		
			alert('请输入密码');
			return false;
		}
		
		if(pas1 != pas2){
			
			alert('两次输入法的密码不一至');
			return false;
		
		}
	
	}



</script>
