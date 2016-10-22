<?php

include "include/config.php";





include "top.php";





$cidtype	= $_REQUEST['cidtype'];

$os						= $_REQUEST['ostatus'];
$searchs				= $_REQUEST['searchs'];
$keys					= trim($_REQUEST['keys']);
$ebay_account			= $_REQUEST['ebay_account'];
$start					= $_REQUEST['start'];
$end					= $_REQUEST['end'];
$replystatus			= $_REQUEST['replystatus'];
$color					= $_REQUEST['color'];



	if($_REQUEST['type'] == "mk"){

		

		$ms  		= $_REQUEST['gstatus']; 

		$messageid	= explode(",",$_REQUEST['bill']);

		$status		= "";

		

		for($g=0;$g<count($messageid);$g++){

			

			$mid	= $messageid[$g];

			if($mid	!= ""){

				

				$sql			= "UPDATE `ebay_message` SET `status` = '".$ms."' WHERE `message_id` ='$mid'";
			
			
				
				if($dbcon->execute($sql)){

			

			$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";

			

		}else{

		

			$status = " -[<font color='#FF0000'>操作记录: 记录操作败</font>]";

		}

		

			

			}

			

		}

	

	

	}

	

	

	

		if($_REQUEST['type'] == "class"){

		

		$ms  		= $_REQUEST['status']; 

		$messageid	= explode(",",$_REQUEST['bill']);

		$classid		= $_REQUEST['classid'];

		$status		= "";

		

		for($g=0;$g<count($messageid);$g++){

			

			$mid	= $messageid[$g];

			if($mid	!= ""){

				

				

				$sql			= "UPDATE `ebay_message` SET `classid` = '".$classid."' WHERE `message_id` ='$mid'";

				if($dbcon->execute($sql)){

			

			$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";

			

		}else{

		

			$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";

		}

		

			

			}

			

		}

	

	

	}

	

	



	$sort		= $_REQUEST['sort']?$_REQUEST['sort']:'Received';
	$sortstatus		= $_REQUEST['sortstatus']?$_REQUEST['sortstatus']:0;
	

	

	

if($sort == 'subject'){

	if($sortstatus  == '0'){

		$sortstr	= " order by subject desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

	}else{

		$sortstr	= " order by subject asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}


if($sort == 'Received'){

	if($sortstatus  == '0'){

		$sortstr	= " order by createtime1 desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

	}else{

		$sortstr	= " order by createtime1 asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}

if($sort == 'recipientid'){

	if($sortstatus  == '0'){

		$sortstr	= " order by recipientid desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

	}else{

		$sortstr	= " order by recipientid asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}


if($sort == 'from'){

	if($sortstatus  == '0'){

		$sortstr	= " order by sendid desc";
		$sortstatus = 1;
		$sortsimg	= "<img src='images/descend_10x5.gif'   width=\"10\" height=\"5\"/>";

	}else{

		$sortstr	= " order by sendid asc";
		$sortstatus	= 0;
		$sortsimg	= "<img src='images/ascend_10x5.gif'   width=\"10\" height=\"5\"/>";
	}
}


 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status;?> </h2>

</div>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

		

	<td nowrap="nowrap" scope="row" >查找： 
	  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>" />

      

      <select name="searchs" id="searchs" >
        <option value="0" <?php if($searchs == '0') echo 'selected="selected"';?>>keyword</option>
        <option value="1" <?php if($searchs == '1') echo 'selected="selected"';?>>UserID</option>
        <option value="2" <?php if($searchs == '2') echo 'selected="selected"';?>>ItemID</option>
        <option value="3" <?php if($searchs == '3') echo 'selected="selected"';?>>Item Title</option>
      </select>
      eBay 帐号
	  <select name="ebay_account" id="ebay_account" onchange="changeaccount()">

      <option value="">Please select</option>

      <?php 

					

					$sql	 = "select ebay_account from ebay_account where ebay_user='$user' and ($ebaymes) order by ebay_account desc ";

					$sqla	 = $dbcon->execute($sql);

					$sql	 = $dbcon->getResultArray($sqla);
					
					$dbcon->free_result($sqla);
					

					for($i=0;$i<count($sql);$i++){					

					 

					 	$acc	= $sql[$i]['ebay_account'];

					 ?>

      <option value="<?php echo $acc;?>" <?php if($ebay_account == $acc) echo "selected=selected" ?>><?php echo $acc;?></option>

      <?php } ?>
    </select>
	  状态:
	  <select name="replystatus" id="replystatus" >
        <option value="">Please select</option>

        <option value="0" <?php if($replystatus == '0') echo "selected=selected" ?>>已回复</option>
        <option value="1" <?php if($replystatus == '1') echo "selected=selected" ?>>未回复</option>
      </select>
	  <input name="selectall" type="button" value="查找" onclick="searchs()" />
	  <br />
	  操作：
	  <select name="mm2" id="mm2" onchange="classid('<?php echo $userid;?>')">
        <option value="0">Move to</option>
        <?php	

		$so	= "select category_name,id from ebay_messagecategory where ebay_user='$user'";	

		$soa	= $dbcon->execute($so);

		$so = $dbcon->getResultArray($soa);		
		
		$dbcon->free_result($soa);

		for($ii=0;$ii<count($so);$ii++){			

			$cname		= $so[$ii]['category_name'];

			$cid		= $so[$ii]['id'];		

	   ?>
        <option <?php if($type == $cid) echo "selected" ?> value="<?php echo $cid;?>"><?php echo $cname; ?></option>
        <?php }  ?>
      </select>
	  <select name="messagestatus" id="messagestatus" onchange="changemessagestatus()">
        <option value="">Market as </option>
        
        <option value="Read"> Read</option>
        <option value="UnRead"> UnRead</option>
        <option value="Flagged"> Flagged</option>
        <option value="Unflagged"> Unflagged</option>
      </select>
	  <select name="changestatus" id="mm" onchange="changestatus('<?php echo $userid;?>')">
        <option value="0" <?php if($replystatus == '0') echo "selected=selected" ?>>已回复</option>
        <option value="1" <?php if($replystatus == '1') echo "selected=selected" ?>>未回复</option>
      </select>
	  <select name="color" id="color" >
        <option value="" <?php if($replystatus == '') echo "selected=selected" ?>>所有</option>
        <option value="0" <?php if($color == '0') echo "selected=selected" ?>>灰</option>
        <option value="1" <?php if($color == '1') echo "selected=selected" ?>>黄</option>
        <option value="2" <?php if($color == '2') echo "selected=selected" ?>>绿</option>
        <option value="3" <?php if($color == '3') echo "selected=selected" ?>>红</option>
      </select>
	  <input name="selectall3" type="button" value="标记已回复" onclick="messagemarket(1)" />
	  <input name="selectall4" type="button" value="标记未回复" onclick="messagemarket(0)" />
	  <input name="selectall5" type="button" value="回复Message" onclick="replyone()" />
	  <input name="selectall2" type="button" value="全选" onclick="check_all('ordersn','ordersn')" />
	  <br /></td>
	</tr>
</table>

</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>
	  <td colspan='4'><div id="rows"></div><div id="rows2"></div> </td>
	  </tr>
	<tr>

		<td width="13%" colspan='4'><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"  >

          

          <tr>

            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

              <tr>

                <td><?php echo $status; ?></td>
              </tr>

            </table></td>
          </tr>

          

          <tr>

            <td>

            

		 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC"  >



  <tr>

    <th bgcolor="#eeeeee" class="left_txt"><input name="ordersn2" type="checkbox" id="ordersn2" onclick="check_all('ordersn','ordersn')" value="<?php echo $mid;?>"></th>
    <th bgcolor="#eeeeee" class="left_txt">&nbsp;</th>
    <th bgcolor="#eeeeee" class="left_txt">&nbsp;</th>

    <th bgcolor="#eeeeee" class="left_txt">
    
        <a href="messageindex.php?module=message&ostatus=<?php echo $os;?>&action=<?php echo $_REQUEST['action'];?>&sort=recipientid&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $keys;?>&searchs=<?php echo $searchs;?>&ebay_account=<?php echo $ebay_account;?>&replystatus=<?php echo $replystatus;?>&cidtype=<?php echo $cidtype;?>">eBay Account</a></span>
    <?php if($sort == 'recipientid') echo $sortsimg; ?>
    
    
    &nbsp;</th>

    <th height="30" bgcolor="#eeeeee" class="left_txt">
    
      <a href="messageindex.php?module=message&ostatus=<?php echo $os;?>&action=<?php echo $_REQUEST['action'];?>&sort=from&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $keys;?>&searchs=<?php echo $searchs;?>&ebay_account=<?php echo $ebay_account;?>&replystatus=<?php echo $replystatus;?>&cidtype=<?php echo $cidtype;?>">
    From
     <?php if($sort == 'from') echo $sortsimg; ?>
    </a>
    </th>

    <th bgcolor="#eeeeee" class="left_txt">
    
    <a href="messageindex.php?module=message&ostatus=<?php echo $os;?>&action=<?php echo $_REQUEST['action'];?>&sort=subject&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $keys;?>&searchs=<?php echo $searchs;?>&ebay_account=<?php echo $ebay_account;?>&replystatus=<?php echo $replystatus;?>&cidtype=<?php echo $cidtype;?>">Subject</a></span>
    <?php if($sort == 'subject') echo $sortsimg; ?>
    
    </th>

    <th bgcolor="#eeeeee" class="left_txt">
    
    <a href="messageindex.php?module=message&ostatus=<?php echo $os;?>&action=<?php echo $_REQUEST['action'];?>&sort=Received&sortstatus=<?php echo $sortstatus;?>&keys=<?php echo $keys;?>&searchs=<?php echo $searchs;?>&ebay_account=<?php echo $ebay_account;?>&replystatus=<?php echo $replystatus;?>&cidtype=<?php echo $cidtype;?>">Received</a></span>
    <?php if($sort == 'Received') echo $sortsimg; ?>
    
    
    </th>

    <th bgcolor="#eeeeee" class="left_txt">Class</th>

    <th bgcolor="#eeeeee" class="left_txt">Reply User</th>

    <th bgcolor="#eeeeee" class="left_txt">Reply Time</th>
    </tr>

			<?php

			

			

			
			
			$tj			= 0;
			
			

			  if($cidtype !=""){

					//				


					$sql = "select createtime1,replytime,sendid,subject,createtime,status,recipientid,itemid,title,message_id,classid,title,classid,replyuser,mmarket,id
	 from ebay_message where classid='$cidtype' and ebay_user='$user' and status ='$os'";

				}else{

					//$sql = "select * from ebay_message where forms='$os' and ebay_user='$user' and (classid = '0' or classid = '')";
					$sql = "select createtime1,replytime,sendid,subject,createtime,status,recipientid,itemid,title,message_id,classid,title,classid,replyuser,mmarket,id from ebay_message where forms='$os' and ebay_user='$user' ";

				}
				
				if($os == 'all'){
				
					$sql = "select createtime1,replytime,sendid,subject,createtime,status,recipientid,itemid,title,message_id,classid,title,classid,replyuser,mmarket,id from ebay_message where ebay_user='$user' ";
					
					
				}

				if($replystatus == '0'){ $sql	.= " and status='1'";}
				if($replystatus == '1'){ $sql	.= " and status='0'";}
				
				
				if($cidtype == '' && $replystatus == '' ) $sql .= " and status ='0' ";
				
				
				
				
				
				if($color != ''){ $sql	.= " and mmarket='$color'";}
				
				
				if($ebay_account != ''){ 
				
				$sql	.= " and ebay_account='$ebay_account'";
				}else{
				
				$sql	.= " and ($ebaymes)";
				
				}
				if($searchs == '0'){ $sql .= " and (sendid like '%$keys%'  or subject like '%$keys%' or body like '%$keys%' or itemid like '%$keys%' or title like '%$keys%' ) "; }
				
				if($searchs == '1'){ $sql .= " and  sendid = '$keys' "; }
				if($searchs == '2'){ $sql .= " and  itemid like '%$keys%' "; }
				if($searchs == '3'){ $sql .= " and  title like '%$keys%' "; }

				
				
				$sql .= $sortstr;
	



				$tsql 	= $dbcon->query($sql);

				$total 	= $dbcon->num_rows($tsql);
				
				
				$dbcon->free_result($tsql);
				$totalpages = $total;
				

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
 

				

				$sqla = $dbcon->execute($sql);

				$sql = $dbcon->getResultArray($sqla);
				
				$dbcon->free_result($sqla);

				for($i=0;$i<count($sql);$i++){

					
					$replytime			= $sql[$i]['replytime'];
					
					
					if($replytime != ''){
					
						$replytime		= date('Y-m-d H:i:s',$replytime);
						
					
					}
					$userid			= $sql[$i]['sendid'];

					$subject		= $sql[$i]['subject'];

					$rtime			= $sql[$i]['createtime'];

					$mstatuss		= $sql[$i]['status'];

				//						

					$recipientid 	= $sql[$i]['recipientid'];


					$itemid			= $sql[$i]['itemid'];

					$title			= $sql[$i]['title'];

					$mid			= $sql[$i]['message_id'];
					$classid		= $sql[$i]['classid'];
					$replyuser		= $sql[$i]['replyuser'];
					$mmarket		= $sql[$i]['mmarket'];
					$id				= $sql[$i]['id'];
					$Read			= $sql[$i]['Read'];
			?>

              

    <tr align="center" class="0" >

      <td align="left" bgcolor="#FFFFFF" class="left_txt"><input name="ordersn" type="checkbox" id="ordersn"  onchange="displayselect()" value="<?php echo $mid;?>" >&nbsp;</td>
      <td align="left" bgcolor="#FFFFFF" class="left_txt">
      
      <?php if($mstatuss == '1'){ ?>
      <img src="images/replied.jpg" />
      <?php } ?>
      
      </td>
      <td align="left" bgcolor="#FFFFFF" class="left_txt"><div id="img<?php echo $id;?>" onclick="changeimage('<?php echo $id;?>')"> <img border="0" src="images/<?php echo $mmarket;?>.gif" width="16px" height="16px" /></div></td>

      <td align="left" bgcolor="#FFFFFF" class="left_txt">
	  
	  	<a href="ebaymessagereplyone.php?messageid=<?php echo $mid; ?>" target="_blank" style="font-weight:100">
	  <?php echo $recipientid;?></a>&nbsp;</td>

      <td align="left" bgcolor="#FFFFFF" class="left_txt" title="


    

    

    

    "><?php echo $userid;?>&nbsp;</td>

    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="left">
<a href="ebaymessagereplyone.php?messageid=<?php echo $mid; ?>" target="_blank" style="font-weight:100; color:#000000; text-decoration:none">
	<?php if($Read == 0){ ?>
    
    <strong><?php echo substr($subject,0,80).'...';?></strong>
    <?php }else{ ?>
    <?php echo substr($subject,0,80).'...';?>
    
    
    <?php } ?>
    
     </a>
    
    </div></td>

    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="center"><?php echo date('Y-m-d H:i:s',strtotime($rtime));?>&nbsp;</div></td>

    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="center">

    <?php

    	$so	= "select * from ebay_messagecategory where id='$classid'";

		$so	= $dbcon->execute($so);

		$so = $dbcon->getResultArray($so);

		echo $so[0]['category_name'];

		

     

	 ?>

        

    

    </div></td>

    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $replyuser;?>&nbsp;</td>

    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $replytime;?></td>
    </tr>

    

    

    <?php } ?>

    

    <tr align="center" class="0">

      <td colspan="10" align="left" bgcolor="#FFFFFF" class="left_txt"><div align="left"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></div></td>
    </tr>

    



    

    <tr align="center" class="0">

      <td colspan="14" align="left" bgcolor="#FFFFFF">      </td>
    </tr>
  </table>            </td>
          </tr>

        

        </table> </td>
	</tr>

		



              

		<tr class='pagination'>

		<td colspan='4'>

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

	

	function marketyh(){

		

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

		var keys			= document.getElementById("keywords").value;
		var account			= document.getElementById("acc").value;
		var messagestatus	= document.getElementById("messagestatus").value;
		var sorts	= document.getElementById("sort").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		


		if(confirm("确认将此条信息标为已回复吗?")){

			
			location.href= "messageindex.php?module=message&type=mk&ostatus=<?php echo $os ?>&keys="+keys+"&account="+account+"&ostatus="+messagestatus+"&action=<?php echo $_REQUEST['action'];?>&sort="+sorts+"&start="+start+"&end="+end+"&gstatus=1"+"&cidtype=<?php echo $cidtype ?>&bill="+bill;

		}	

		

	}

	

	function marketwh(){

		

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

	

		var keys			= document.getElementById("keywords").value;
		var account			= document.getElementById("acc").value;
		var messagestatus	= document.getElementById("messagestatus").value;
		var sorts	= document.getElementById("sort").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		


		if(confirm("确认将此条信息标为未回复吗?")){

			
			location.href= "messageindex.php?module=message&type=mk&ostatus=<?php echo $os ?>&keys="+keys+"&account="+account+"&ostatus="+messagestatus+"&action=<?php echo $_REQUEST['action'];?>&sort="+sorts+"&start="+start+"&end="+end+"&gstatus=0"+"&cidtype=<?php echo $cidtype ?>&bill="+bill;

		}	

		

	}

	function marketewh(){

		

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

	
var keys			= document.getElementById("keywords").value;
		var account			= document.getElementById("acc").value;
		var messagestatus	= document.getElementById("messagestatus").value;
		var sorts	= document.getElementById("sort").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		


		if(confirm("确认将此条信息标为不需要回复message吗?")){

			
			location.href= "messageindex.php?module=message&type=mk&ostatus=<?php echo $os ?>&keys="+keys+"&account="+account+"&ostatus="+messagestatus+"&action=<?php echo $_REQUEST['action'];?>&sort="+sorts+"&start="+start+"&end="+end+"&gstatus=3"+"&cidtype=<?php echo $cidtype ?>&bill="+bill;

		}	

		

		

	}

function marketbwh(){

		

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

	var keys			= document.getElementById("keywords").value;
		var account			= document.getElementById("acc").value;
		var messagestatus	= document.getElementById("messagestatus").value;
		var sorts	= document.getElementById("sort").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		


		if(confirm("确认将此条记录标为ebay message吗?")){

			

			location.href= "messageindex.php?module=message&type=mk&ostatus=<?php echo $os ?>&keys="+keys+"&account="+account+"&ostatus="+messagestatus+"&action=<?php echo $_REQUEST['action'];?>&sort="+sorts+"&start="+start+"&end="+end+"&gstatus=2"+"&cidtype=<?php echo $cidtype ?>&bill="+bill;

		}

		

		

	}

	
	
	function replyone(){

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){			

				bill = bill + ","+checkboxs[i].value;		

			}		

		}

		if(bill == ""){

			

			alert("请选择要回复的message");

			return false;	

		}

	

		var url	=  "ebaymessagereplyone.php?messageid="+bill;

		window.open(url,"_blank");

		

	}

	

		

	function viewproblem(bill){

		

	



		if(bill == ""){

			

			alert("请选择订单号");

			return false;	

		}

	

		var url	=  "ebaymessagereplyone.php?messageid="+bill;

		window.open(url,"_blank");

		

	}

	

	

	function classid(name){

		

		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){			

				bill = bill + ","+checkboxs[i].value;		

			}		

		}

		if(bill == ""){

			

			alert("请选择Message");

			return false;	

		}

		

		var id 	= document.getElementById("mm2").value;

		

		if(confirm("您确认将此分类，移动到所先分类中?")){

			

			location.href= "messageindex.php?module=message&type=class&cidtype=<?php echo $cidtype ?>&bill="+bill+"&classid="+id;

			

		

		}

	}

	

	

	function searchs(){

		
		var replystatus					= document.getElementById("replystatus").value;
		var keys					= document.getElementById("keys").value;
		var searchs					= document.getElementById("searchs").value;
		var ebay_account			= document.getElementById("ebay_account").value;
		var color					= document.getElementById("color").value;
		
		location.href= "messageindex.php?module=message&type=class&ostatus=<?php echo $os ?>&keys="+keys+"&searchs="+searchs+"&ebay_account="+ebay_account+"&action=<?php echo $_REQUEST['action'];?>&replystatus="+replystatus+"&cidtype=<?php echo $_REQUEST['cidtype'];?>&color="+color;
		

	}

	

	
	var sordersn	= '';
	
	function changeimage(ordersn){
	
	
	//	document.getElementById('img'+ordersn).innerHTML= ordersn;
		sordersn	= ordersn;
		
		var url		= "getajax.php";
		var param	= "type=market&ordersn="+ordersn;
		sendRequestPost(url,param);
		
	
	
	}
	
	
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
    //发送请求函数  
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
		

				
				document.getElementById('img'+sordersn).innerHTML= '<img border="0" src="images/'+res+'.gif" width="16px" height="16px" />';
				
            }else{  
                window.alert("请求页面异常");  
            }  
			
			
        }  
    }
	



	 document.getElementById('rows').innerHTML="Your search results is <?php echo $totalpages;?>";

	 

	function changemessagestatus(){
	
	
			
			
			var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");
		var value		= document.getElementById('messagestatus').value;
		
		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){			

				bill = bill + ","+checkboxs[i].value;		

			}		

		}

		if(bill == ""){

			

			alert("请选择Message");

			return false;	

		}
		
		var url		= "marketmessage.php?bill="+bill+"&type="+value;
		
		openwindow(url,'',500,300);
	
	
	
	}
	
	function displayselect(){
		
		var b	= 0;
		
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				b++;
				
			
			}	
			
		}
		
		document.getElementById('rows2').innerHTML="您已经选择 <font color=red>"+b+"</font> 条记录 ^_^";
		
		document.getElementById("filesidselect").selected=true;
		document.getElementById("printidselect").selected=true;
		
	
	
	}
	
	function messagemarket(type){
	
		
		var bill	= "";

		var checkboxs = document.getElementsByName("ordersn");
		var value		= document.getElementById('messagestatus').value;
		
		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){			

				bill = bill + ","+checkboxs[i].value;		

			}		

		}

		if(bill == ""){

			

			alert("请选择Message");

			return false;	

		}
		
		var url		= "marketmessagestatus.php?bill="+bill+"&type="+type;
		openwindow(url,'',500,300);
		
		
	}
	
	
	//设定打开窗口并居中
function openwindow(url,name,iWidth,iHeight)
{
var url; //转向网页的地址;
var name; //网页名称，可为空;
var iWidth; //弹出窗口的宽度;
var iHeight; //弹出窗口的高度;
var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
}

</script>

<script > 
var   ctrl=false; 
var   shift=false; 
document.onkeydown=function   (){ 
if(event.keyCode==17){ 
ctrl=true; 
}else   if(event.keyCode==16){ 
shift=true; 
} 
}; 
document.onkeyup=function   (){ 
ctrl=false; 
shift=false; 
} 
function   choose(obj){ 
var   rowI=event.srcElement.parentNode.rowIndex; 
if(ctrl&&shift)   return; 
if(!ctrl&&!shift){ 
for(var   i=0;i <table1.rows.length;i++){ 
table1.rows(i).cells(0).firstChild.checked=false; 
table1.rows(i).bgColor=""; 
} 
table1.rows(rowI).cells(0).firstChild.checked=true; 
table1.rows(rowI).bgColor="red"; 
table1.currentRow=rowI; 
} 
if(ctrl){ 
table1.rows(rowI).cells(0).firstChild.checked=true; 
table1.rows(rowI).bgColor="red"; 
} 
if(shift){ 
for(var   i=0;i <table1.rows.length;i++){ 
table1.rows(i).cells(0).firstChild.checked=false; 
table1.rows(i).bgColor=""; 
} 
if(rowI <table1.currentRow){ 
for(var   i=rowI;i <=table1.currentRow;i++){ 
table1.rows(parseInt(i)).cells(0).firstChild.checked=true; 
table1.rows(parseInt(i)).bgColor="red"; 
} 
}else{ 
for(var   i=table1.currentRow;i <=rowI;i++){ 
table1.rows(parseInt(i)).cells(0).firstChild.checked=true; 
table1.rows(parseInt(i)).bgColor="red"; 
} 
} 
} 
} 

	document.onkeydown=function(event){
  e = event ? event :(window.event ? window.event : null);
  if(e.keyCode==13){
 searchs();
  }
 }
</script > 