<?php
include "include/config.php";
//include "include/xmlhandle.php";
$type=$_REQUEST['type'];
$ebay_id = $_REQUEST['bill'];
$ebay_id = substr($ebay_id,1);
$id = explode(',',$ebay_id);
if($type=='creat'){
?>
<form id="form" name="form" method="post" action="eubxx.php?type=creat&bill=<?php echo $_REQUEST['bill']; ?>">
                  <table width="70%" border="0" cellpadding="0" cellspacing="0">
			      
			      <tr>
			        <td width="50%" align="right" bgcolor="#f2f2f2" class="right_txt">打印方式</td>
			        <td width="50%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="printstatus" id="printstatus">
                            <option value="00" <?php if($oost == "00") echo "selected=selected" ?>>a4打印</option>
							<option value="01" <?php  if($oost == "01")  echo "selected=selected" ?>>4*4标签打印</option>
                            <option value="03" <?php  if($oost == "03")  echo "selected=selected" ?>>4*6标签打印</option>
                      </select>
			        </div></td>
			        </tr>
                  <tr>				 
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="确认提交" >
                    </div></td>
                    </tr>
                </table>
                 </form> 
<?php



if($user == 'vipzz'){
	
	 echo '试用结束，请联系管理员开通.';
	
	die();
	

}




	if($_POST['submit']){
		$print = $_POST['printstatus'];
		foreach($id as $k=>$v){
			$data = submiteub($v,$print);
			$datas = $data['order'];
			if($datas){
				$number = $datas['mailnum'];
				$vv = "update ebay_order set ebay_tracknumber='$number' where ebay_id=".$v;
				//echo $vv;
				if($dbcon->execute($vv)){
					echo '<font color="green">'.$v.'提交成功 跟踪号：'.$number.'</font><br>';
				}else{			
					echo '<font color="red">'.$v.'提交失败</font><br>';
				}
			}else{
				echo '<font color="red">'.$v.'提交失败:'.$data['response']['description'].'</font><br>';
			}
		}
	}
}
if($type=='print'){
	$id = implode("','",$id);
	$data = printeub($id);
	if($data['status']=='success'){
		echo "<script>location.href='".$data['description']."'</script>";
	}else{
		echo "打印失败";
	}
}
if($type=='del'){
	deleub($ebay_id);
	$vv = "update ebay_order set ebay_tracknumber='' where ebay_id=".$ebay_id;
	$dbcon->execute($vv);
}
	function submiteub($ebay_id,$print){
		global $dbcon,$user;
		$data = array();
		$time = date('c');
		$etime = time()+3600*24;
		$etime = date('c',$etime);
		$value = '<orders xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
			<order>
				<orderid>{orderid}</orderid>
				<customercode>{customercode}</customercode>
				<vipcode></vipcode>
				<clcttype>{clcttype}</clcttype>
				<pod>false</pod>
				<untread>Returned</untread>
				<volweight>{volweight}</volweight>
				<startdate>'.$time.'</startdate>
				<enddate>'.$etime.'</enddate>
				<printcode>'.$print.'</printcode>
				<sender>
					<name>{sname}</name>
					<postcode>{spostcode}</postcode>
					<phone>{sphone}</phone>
					<country>{scountry}</country>
					<province>{sprovince}</province>
					<city>{scity}</city>
					<county>{scounty}</county>
					<company>{scompany}</company>
					<street>{sstreet}</street>
					<email>{semail}</email>
				</sender>
				<receiver>
					<name>{rname}</name>
					<postcode>{rpostcode}</postcode>
					<phone>{rphone}</phone>
					<country>UNITED STATES OF AMERICA</country>
					<province>{rprovince}</province>
					<city>{rcity}</city>
					<county>{rcounty}</county>
					<street>{rstreet}</street>
				</receiver>
				<collect>
					<name>{cname}</name>
					<postcode>{cpostcode}</postcode>
					<phone>{cphone}</phone>
					<country>{ccountry}</country>
					<province>{cprovince}</province>
					<city>{ccity}</city>
					<county>{ccounty}</county>
					<company>{ccompany}</company>
					<street>{cstreet}</street>
					<email>{cemail}</email>
				</collect>
			<items></items>
			<remark></remark>
			</order>
		</orders>';
		$sql = "select * from ebay_order where ebay_id = $ebay_id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$header[] = "version:international_eub_us_1.1";
		$url =   "http://www.ems.com.cn:8091/partner/api/public/p/order/";
		foreach($sql as $k=>$v){
			$orderid = $v['ebay_id'];
			$ebay_account = $v['ebay_account'];
			$rr				= "select id from ebay_account where ebay_account='$ebay_account'";
			$rr				= $dbcon->execute($rr);
			$rr				= $dbcon->getResultArray($rr);
			$id				= $rr[0]['id'];
			$rr				= "select * from eub_account1 where pid='$id'";
			$rr					= $dbcon->execute($rr);
			$rr					= $dbcon->getResultArray($rr);
			$dname					= $rr[0]['dname'];
			$dstreet				= $rr[0]['dstreet'];
			$dcity					= $rr[0]['dcity'];
			$dprovince				= $rr[0]['dprovince'];
			$dzip					= $rr[0]['dzip'];
			$dtel					= $rr[0]['dtel'];
			$ddis					= $rr[0]['ddis'];
			$dcompany					= $rr[0]['dcompany'];
			$demail					= $rr[0]['demail'];
			$cname					= $rr[0]['rname'];
			$cstreet					= $rr[0]['rstreet'];
			$ccompany					= $rr[0]['rcompany'];
			$shiptype					= $rr[0]['shiptype'];
			$authToken					= $rr[0]['token'];
			$account						= $rr[0]['ebay_account'];
			$header[] = "authenticate:$authToken";
			$value = str_replace('{orderid}','isss'.$orderid,$value);
			$value = str_replace('{sname}',$dname,$value);
			$value = str_replace('{spostcode}',$dzip,$value);
			$value = str_replace('{sphone}',$dtel,$value);
			$value = str_replace('{scountry}','CN',$value);
			$value = str_replace('{sprovince}',$dprovince,$value);
			$value = str_replace('{scity}',$dcity,$value);
			$value = str_replace('{scounty}',$ddis,$value);
			$value = str_replace('{scompany}',$dcompany,$value);
			$value = str_replace('{sstreet}',$dstreet,$value);
			$value = str_replace('{semail}',$demail,$value);
			$value = str_replace('{cname}',$cname,$value);
			$value = str_replace('{cpostcode}',$dzip,$value);
			$value = str_replace('{cphone}',$dtel,$value);
			$value = str_replace('{ccountry}','CN',$value);
			$value = str_replace('{cprovince}',$dprovince,$value);
			$value = str_replace('{ccity}',$dcity,$value);
			$value = str_replace('{ccounty}',$ddis,$value);
			$value = str_replace('{ccompany}',$ccompany,$value);
			$value = str_replace('{cstreet}',$cstreet,$value);
			$value = str_replace('{rname}',$v['ebay_username'],$value);
			$value = str_replace('{rpostcode}',$v['ebay_postcode'],$value);
			$value = str_replace('{rphone}',$v['ebay_phone'],$value);
			$value = str_replace('{rprovince}',$v['ebay_state'],$value);
			$value = str_replace('{rcity}',$v['ebay_city'],$value);
			$value = str_replace('{rcounty}',$v['ebay_state'],$value);
			$value = str_replace('{rstreet}',$v['ebay_street'].$v['ebay_street1'],$value);
			$value = str_replace('{cemail}',$demail,$value);
			$value = str_replace('{clcttype}',$shiptype,$value);
			$value = str_replace('{customercode}',$account,$value);
			$vv = "select ebay_amount,sku,ebay_itemid from ebay_orderdetail where ebay_ordersn='".$v['ebay_ordersn']."'";
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			$text = "<items>";
			foreach($vv as $kk=>$vvv){
				$value1 = '
				<item>
					<cnname>{cnname}</cnname>
					<enname>{enname}</enname>
					<count>{count}</count>
					<unit>{unit}</unit>
					<weight>{weight}</weight>
					<delcarevalue>{delcarevalue}</delcarevalue>
					<origin>CN</origin>
					<description>{sku}</description>
				</item>
				';
				
				$ss = "select goods_ywsbmc,goods_zysbmc,goods_sbjz,goods_weight,goods_unit,goods_width,goods_length,goods_height from ebay_goods where goods_sn='".$vvv['sku']."' and ebay_user = '$user'";
				
				
				
				$ss = $dbcon->execute($ss);
				$ss = $dbcon->getResultArray($ss);
				
				
				
				$skustr		= '';
				
				
				if(count($ss) == 0){
						
						
						
						$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='".$vvv['sku']."'";
						$rr			= $dbcon->execute($rr);
						$rr 	 	= $dbcon->getResultArray($rr);
						
						
						if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($v=0;$v<count($goods_sncombine);$v++){
											$pline			= explode('*',$goods_sncombine[$v]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $vvv['ebay_amount'];
											$totalqty		= $totalqty + $goddscount;
											$uu			= "SELECT goods_ywsbmc,goods_zysbmc,goods_sbjz,goods_weight,goods_unit,goods_width,goods_length,goods_height FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
								  			$uu			= $dbcon->execute($uu);
											$uu 	 	= $dbcon->getResultArray($uu);
											
											
											$weight			= number_format($uu[0]['goods_weight'],2);
											if($uu){
											
												  $value1 = str_replace('{sku}',$goods_sn,$value1);
											     $value1 = str_replace('{count}',$goddscount,$value1);
												 
												 
												 $value1 = str_replace('{cnname}',$uu[0]['goods_zysbmc'].' '.$goods_sn,$value1);
												 $value1 = str_replace('{enname}',$uu[0]['goods_ywsbmc'],$value1);
												 $value1 = str_replace('{unit}',$uu[0]['goods_unit'],$value1);
												 $value1 = str_replace('{weight}',$weight,$value1);
												 $value1 = str_replace('{delcarevalue}',$uu[0]['goods_sbjz'],$value1);
												 $volweight = $uu[0]['goods_length']*$uu[0]['goods_width']*$uu[0]['goods_height']/6000;
												 
												 
												 
												 $skustr	.= $goods_sn.' * '.$goddscount.' '.$$uu[0]['goods_name'].' '.$vvv['notes'];
												 
											 }
											$text .= $value1;
											$value1 = '
				<item>
					<cnname>{cnname}</cnname>
					<enname>{enname}</enname>
					<count>{count}</count>
					<unit>{unit}</unit>
					<weight>{weight}</weight>
					<delcarevalue>{delcarevalue}</delcarevalue>
					<origin>CN</origin>
					<description>{sku}</description>
				</item>
				';
											
											
									}
						}
						
					
					
						
				
				
				
				}else{
				
				
				$weight			= number_format($ss[0]['goods_weight'],2);

				if($ss){
				
					  $value1 = str_replace('{sku}',$vvv['sku'],$value1);
					 $value1 = str_replace('{count}',$vvv['ebay_amount'],$value1);
				
				
				
					 $value1 = str_replace('{cnname}',$ss[0]['goods_zysbmc'].' '.$vvv['sku'],$value1);
					 $value1 = str_replace('{enname}',$ss[0]['goods_ywsbmc'],$value1);
					 $value1 = str_replace('{unit}',$ss[0]['goods_unit'],$value1);
					 $value1 = str_replace('{weight}',$weight,$value1);
					 $value1 = str_replace('{delcarevalue}',$ss[0]['goods_sbjz'],$value1);
					 $volweight = $ss[0]['goods_length']*$ss[0]['goods_width']*$ss[0]['goods_height']/6000;
				 }
				$text .= $value1;
				
				
				
				$skustr	.= $goods_sn.' * '.$goddscount.' '.$$ss[0]['goods_name'].' '.$vvv['notes'];
				
				
				
				}
				
				
				
				
				
				
				
				
			}
			$text .= '</items>';
			$value = str_replace('<items></items>',$text,$value);
			$value = str_replace('{volweight}',1,$value);





			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $value);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); 
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //不直接显示回传结果
			$rs = curl_exec($curl);
			if(curl_errno($curl))
			{
				print_r(curl_error($curl));
			}
			print_r(curl_error($curl));
			curl_close($curl);
			$t = XML_unserialize($rs);
			$data = $t;
		}
		
		
	
		
		return $data;
	}
	function printeub($id){
		global $dbcon;
		$sql = "select ebay_account,ebay_tracknumber from ebay_order where ebay_id in ('$id')";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$url =   'http://www.ems.com.cn:8091/partner/api/public/p/print/batch';
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$header[] = "version:international_eub_us_1.1";

		$ebay_account = $sql[0]['ebay_account'];
		$rr				= "select id from ebay_account where ebay_account='$ebay_account'";
		$rr				= $dbcon->execute($rr);
		$rr				= $dbcon->getResultArray($rr);
		$ids				= $rr[0]['id'];
		$rr				= "select token from eub_account1 where pid='$ids'";
		$rr					= $dbcon->execute($rr);
		$rr					= $dbcon->getResultArray($rr);
		$authToken			= $rr[0]['token'];
		
		$header[] = "authenticate:$authToken";
		$value = '<orders xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
		foreach($sql as $k=>$v){
				$value .='<order>
						<mailnum>'.$v['ebay_tracknumber'].'</mailnum>
					</order>';
		}
		$value .='</orders>';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $value);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); 
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //不直接显示回传结果
			$rs = curl_exec($curl); 
			if(curl_errno($curl))
			{
				print_r(curl_error($curl));
			}
			curl_close($curl);
			//print_r($rs);
			$data = XML_unserialize($rs);
		
			
			return $data['response'];
	}
	function deleub($id){
		global $dbcon;
		$sql = "select ebay_account,ebay_tracknumber from ebay_order where ebay_id ='$id'";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$ebay_account = $sql[0]['ebay_account'];
		$ebay_tracknumber = $sql[0]['ebay_tracknumber'];
	    $url =   "http://www.ems.com.cn:8091/partner/api/public/p/order/".$ebay_tracknumber;
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$header[] = "version:international_eub_us_1.1";
		$rr				= "select id from ebay_account where ebay_account='$ebay_account'";
		$rr				= $dbcon->execute($rr);
		$rr				= $dbcon->getResultArray($rr);
		$ids				= $rr[0]['id'];
		$rr				= "select token from eub_account1 where pid='$ids'";
		$rr					= $dbcon->execute($rr);
		$rr					= $dbcon->getResultArray($rr);
		$authToken			= $rr[0]['token'];
		
		$header[] = "authenticate:$authToken";
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_exec($curl);
			if(curl_errno($curl))
			{
				print_r(curl_error($curl));
			}
			curl_close($curl);
	}
