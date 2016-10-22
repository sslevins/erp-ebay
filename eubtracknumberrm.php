<?PHP
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
	class DBClass{
	public $link=null;
	/**********************
	使用构造函数连接数据库
	**********************/
		function __construct($host="127.0.0.1",$root="root",$password="mysql2013",$dbname="v3-all"){
	
	
		if(!$this->link=@mysql_connect($host,$root,$password)){			
				echo "database connected failure";
				exit;
			}else{
			
			
			
			}
		mysql_query("SET NAMES utf8");
			if(!@mysql_select_db($dbname)){
			
				echo "数据库连接失败";
				die();
				
			
			}
			
	}
	
	/*************************
	执行查询语句
	*************************/
	function  query($sql){
			return @mysql_query($sql);
	}

	/*****************************************
	执行查询语句之外的操作 例如:添加，修改，删除
	*****************************************/

	function execute($sql){
		if(@function_exists("mysql_unbuffered_query")){
			$result=@mysql_unbuffered_query($sql);
		}
		else{
			$result=@mysql_query($sql);
		}
		return $result;
	} 

	/*************************
	执行更新语句
	************************/
	function update($sql){
	 	if(@function_exists("mysql_unbuffered_query"))
		{
			$result=@mysql_unbuffered_query($sql);
		}
		else{
			$result=@mysql_query($sql);
		}	
		$rows	= mysql_affected_rows($this->link);
		
		return $rows;
	}
	
	
	/**************************
	获得表的记录的行数
	*************************/
	function num_rows($result){
		if($result){
			return @mysql_num_rows($result);
		}
		else{
			return 0;
			
		}			
	}
	
	/***********************
	返回对象数据
	************************/
	function fetch_object($result){		 
			return @mysql_fetch_object($result);
	}
	
	/*************************
	返回关联数据
	*************************/
	function fetch_assoc($result){
		return @mysql_fetch_assoc($result);
	}

	/**************************
	返回关联数据
	**************************/
	function fetch_array($result,$type='MYSQL_BOTH'){
		return @mysql_fetch_array($result,$type);
	
	}
	
	/*************************
	关闭相关与数据库的信息链接
	**************************/
	
	function free_result($result){
		return @mysql_free_result($result);
	}
	
	function close(){
		return @mysql_close();
	}
	
	/*********************************
	其他操作例如结果集放入数组中
	*********************************/	
	public function getResultArray($result){
		$array=array();
		$i=0;
		while($row=@mysql_fetch_assoc($result)){
			$array[$i]=$row;
			$i++;
		}
		return $array;
	}		
}
$dbcon	= new DBClass();
$epagesize	= $_REQUEST['pagesize'];

	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	$tkary		= array();
	$tjstr		= '';
	$i = 0;
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
						$tjstr				.= " a.ebay_id='$sn' or ";
		}
	}
	
	$tjstr		= substr($tjstr,0,strlen($tjstr)-3);
//	$ss					= "select ebay_tracknumber,ebay_account,ebay_countryname from ebay_order as a join ebay_order as b on a.ebay_ordersn = b.ebay_ordersn where ($tjstr) and ebay_user ='$user' order by ebay_account,ebay_countryname,b.sku";


$ss					= "select ebay_tracknumber,a.ebay_account,ebay_countryname from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($tjstr) and a.ebay_user ='$user'  group by a.ebay_id order by a.ebay_account,ebay_countryname,b.sku  ";



	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	


	$countjs			= 0;
	$countjs2			= 0;
	$countjs3			= 0;
	$countjsarray		=  array();
	
	$lastebayaccount	='';
	$lastcountryname	= '';
	
	
	for($i=0;$i<count($ss);$i++){
	
			$ebay_tracknumber	= $ss[$i]['ebay_tracknumber'];
			$ebay_countryname	= $ss[$i]['ebay_countryname'];
			$ebay_account		= $ss[$i]['ebay_account'];
			
			if($ebay_tracknumber == '' ) die('您有选择非EUB订单打印，或 EUB跟踪号是空的');
			
			if($lastebayaccount != '' && $lastcountryname != '' ){
			
				if($lastebayaccount == $ebay_account && $ebay_countryname == $lastcountryname){
				
				$tkary[$countjs3][$countjs2]			= $ebay_tracknumber;
				
				}else{
				
				$countjs3 ++;

				$countjs2					= 0;
				$tkary[$countjs3][$countjs2]			= $ebay_tracknumber;
				
				}
			
			}else{
			
			$tkary[$countjs3][$countjs2]			= $ebay_tracknumber;
			
			}
			
			
			$countjs2 ++;
			if($countjs2 >=15 ){
				  $countjs3++;
				  $countjs2= 0;
			}
			
			
			
			
			
			$lastebayaccount	= $ebay_account;
			$lastcountryname	= $ebay_countryname;
	}
	


	$filenames		= array();






	for($i=0;$i<count($tkary)+10;$i++){
				$tar			= $tkary[$i];
				
				if($tar != ''){
				$label		= getshiplabel($sn,$tar);
				$file= date('Y').date('m').date('d').date('H').date('i').date('s').$user.rand(100,9999).'eub.pdf';
			    file_put_contents("images/".$file,$label);
				$filenames[$i] = "images/".$file;
				}
				
	}





	include_once("pdfConcat.php");
	$pdf =& new concat_pdf();
	$pdf->setFiles($filenames);
	$pdf->concat();
	$pdf->Output("newpdf".rand(100,9999999).".pdf", "I");
			
			
	
	function getshiplabel($ordersn,$tkary){
		
		global $dbcon,$user,$epagesize;
        
        $ebay_tracknumber	= $tkary[0];
        
		$ss					= "select * from ebay_order where ebay_tracknumber = '$ebay_tracknumber'  and ebay_user ='$user'";
		


		
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$ebay_tracknumber	= $ss[0]['ebay_tracknumber'];
		$ebay_account	= $ss[0]['ebay_account'];
		$ss				= "select * from ebay_account where ebay_account='$ebay_account'";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$id				= $ss[0]['id'];
		
		$ss				= "select * from eub_account where pid='$id'";
		
		
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$APIDevUserID		= $ss[0]['ebay_account'];
		$APISellerUserID	= $ss[0]['dev_id'];
		$APIPassword		= $ss[0]['dev_sig'];
		
		
		$soapclient = new soapclient("orderservice.asmx");
		$params		= array(
    	'Version' => "3.0.0",
    	'APIDevUserID' => $APIDevUserID,
    	'APIPassword' => $APIPassword,
    	'APISellerUserID' => $APISellerUserID,
    	'MessageID' => "135625622432",
		'TrackCodeList' =>$tkary,
		'PageSize' => $epagesize
		);
		
	
	

		
	
	
		$functions = $soapclient->GetAPACShippingLabels(array("GetAPACShippingLabelRequest"=>$params));
		


		foreach($functions as $aa){
			
			$bb   = (array)$aa;
			
			$ack		= $bb['Ack'];
			
			if($ack     != 'Failure'){
				
				
				$Label	= $bb['Label'];
				return $Label;
			}else{
				$Message	= $bb['Message'];
				echo "<br>".$ebay_usermail." EUB订单标签取得失败，失败原因是：<font color='#FF0000'>".$Message."</font>";
				
			}
				
			
		}
		
		
	}
	
	
	
?>
