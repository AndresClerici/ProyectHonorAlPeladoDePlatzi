<?php 
	
	$cod_empresa = 1;
	$cod_sucursal = "01";
	$tipo_comprobante = "FCR";
	$ser_comprobante = "001-001";
	$nro_comprobante = "9999";

	$data = array(
			':cod_empresa'		=>	$cod_empresa,
			':cod_sucursal'		=>	$cod_sucursal,
			':tipo_comprobante' =>	$tipo_comprobante,
			':ser_comprobante'  =>	$ser_comprobante,
			':nro_comprobante'  =>	$nro_comprobante);

	echo $data[":cod_empresa"];
?>