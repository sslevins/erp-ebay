<?php

require_once ('reportmodule/jpgraph.php');
require_once ('reportmodule/jpgraph_line.php');


@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
	class DBClass{
	public $link=null;
	/**********************
	使用构造函数连接数据库
	**********************/
		function __construct($host="127.0.0.1",$root="root",$password="123456",$dbname="v3-all"){
	
	
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



$type			= $_REQUEST['type'];
@$startdate		= $_REQUEST['startdate'];
@$enddate		= $_REQUEST['enddate'];
@$account		= $_REQUEST['account'];

$dataarray		= array();


if($type == 'orders'){

			
			
			if($startdate != '' && $enddate != '' ){
		
				$sdate		= strtotime($startdate.' 00:00:00');
				$edate		= strtotime($enddate.' 23:59:59');
				$countjs	= 1;
				for($i=0;$i<= 10000000; $i++){
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
			//	echo date('Y-m-d H:i:s',$searchstartdate).'vs'.date('Y-m-d H:i:s',$searchenddate).'<br>';
				
				$ss		= "SELECT  count(ebay_id) as total  FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user'  ";
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				
				

		
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				
	
				
				$totalorders		= $ss[0]['total'];

				$dataarray[]		= $totalorders;
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					if($sdate >= $edate ) break;
					$countjs ++ ;
		}
		}
}




if($type == 'amount'){

			
			
			if($startdate != '' && $enddate != '' ){
		
				$sdate		= strtotime($startdate.' 00:00:00');
				$edate		= strtotime($enddate.' 23:59:59');
				$countjs	= 1;
				
				for($i=0;$i<= 10000000; $i++){
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
				
				
				
				
				$ss		= "SELECT  sum(ebay_total) as total  FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user'  ";
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				
				

		
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				
	
				
				$totalorders		= $ss[0]['total'];

				$dataarray[]		= $totalorders;
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					if($sdate >= $edate ) break;
					$countjs ++ ;
		}
		}
}





// Create the graph. These two calls are always required
$graph = new Graph(600,400);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot=new LinePlot($dataarray);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();


?>
