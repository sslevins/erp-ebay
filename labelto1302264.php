<?php
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
include "include/dbconnect.php";
$dbcon	= new DBClass();
	$ertj		= "";

	$orders		= explode(",",$_REQUEST['ordersn']);

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);

	if($ertj == ""){

	

	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' order by ebay_id desc ";	

	}	
		
		

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	$a = 1;

	$values = array();	
	$values[0][] = 'id_agencia;cantidad_contrareembolso;cantidad_seguro;nom_ape_salida;direccion_salida;cod_pos_salida;poblacion_salida;provincia_salida;pais_salida;tlf_salida;observaciones_salida;contacto_salida;mail_salida;nom_ape_llegada;direccion_llegada;cod_pos_llegada;poblacion_llegada;provincia_llegada;pais_llegada;tlf_llegada;observaciones_llegada;contacto_llegada;mail_llegada;num_bultos;peso;largo;alto;ancho;hora_desde;hora_hasta;fin';
	for($i=0;$i<count($sql);$i++){
		$strline = '';

		$ordersn		= $sql[$i]['ebay_ordersn'];
		$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	  	= str_replace("&acute;","'",$name);
		$name  		= str_replace("&quot;","\"",$name);
		
		
	    $street1		= @$sql[$i]['ebay_street'];
	    $street2 		= @$sql[$i]['ebay_street1'];

	    $city 				= $sql[$i]['ebay_city'];
		
	    $state				= $sql[$i]['ebay_state'];
		$PaymentMethodUsed 		= $sql[$i]['PaymentMethodUsed'];
	    $countryname 		= $sql[$i]['ebay_countryname'];

	    $zip				= $sql[$i]['ebay_postcode'];

	    $tel				= $sql[$i]['ebay_phone'];

		$ebay_shipfee		= $sql[$i]['ebay_shipfee'];

		$ebay_note			= $sql[$i]['ebay_note'];

		$ebay_total	 		= @$sql[$i]['ebay_total'];
		$recordnumber		= $sql[$i]['recordnumber'];
		$ebay_account		= $sql[$i]['ebay_account'];
		$ebay_ptid			= $sql[$i]['ebay_ptid'];
		$ebay_tid			= $sql[$i]['ebay_tid'];

		
		
		
		$ebay_phone					= $sql[$i]['ebay_phone'];
		$ebay_carrier					= $sql[$i]['ebay_carrier'];
		$ss = "select * from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
		$ss	= $dbcon->execute($ss);
		$ss	= $dbcon->getResultArray($ss);
		$strline = ';'.$name.';'.$street1.$street2.';'.$zip.';'.$city.';'.$state.';'.$countryname.';'.$tel.';;'.$name.';'.$ebay_usermail.';1;1;25;17;8;10:30;18:30;';
		$values[$a][0] = '19;;;yoyoBey Almacen;C/alcala 414 C.C.alcala norte bajo 59 ;28027;Madrid;Madrid;España;911693209;;yoyobey;info@yoybey.com';
		$values[$a][1] = $strline;
		$a++;
}
$fp = fopen('images/xibanya24.csv', 'w');
 foreach($values as $k=>$v){
	 fputcsv($fp,$v);
 }
 fclose($fp);
 Header("Location:images/xibanya24.csv"); 
exit;





