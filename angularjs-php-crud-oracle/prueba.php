<?php 

include('database_connection.php');

$sql = "SELECT cod_empresa, 
			   cod_sucursal, tipo_comprobante, ser_comprobante, nro_comprobante 
		  FROM aux2 WHERE nro_comprobante = 76";
//$statement = $connect->prepare($query);
//$statement->execute();
$query = oci_parse($conexion, $sql);
$exe = oci_execute($query, OCI_DEFAULT);

if (!$exe) {
  $e = oci_error($query);
  oci_rollback($conexion); // revertir los cambios en ambas tablas
  trigger_error(htmlentities($e["<h3>Recargue la página tocando el boton</h3></br>
  	<a href=insert.php#new-ubication> Retornar</a>"]), E_USER_ERROR);
}

//$result = $statement->fetchAll();

while (($row = oci_fetch_array($query, OCI_ASSOC)) != false){	
	$output['cod_empresa'] 		= $row['COD_EMPRESA'];
	$output['cod_sucursal'] 	= $row['COD_SUCURSAL'];
	$output['tipo_comprobante'] = $row['TIPO_COMPROBANTE'];
	$output['ser_comprobante']  = $row['SER_COMPROBANTE'];
	$output['nro_comprobante']  = $row['NRO_COMPROBANTE'];
}

/*$nrows = oci_fetch_all($query, $result);

foreach($result as $col){
	foreach ($col as $item) {
		echo $item[];
     	/*$output['cod_empresa'] 		= $col['COD_EMPRESA'];
		$output['cod_sucursal'] 	= $col['COD_SUCURSAL'];
		$output['tipo_comprobante'] = $col['TIPO_COMPROBANTE'];
		$output['ser_comprobante']  = $col['SER_COMPROBANTE'];
		$output['nro_comprobante']  = $col['NRO_COMPROBANTE'];
//		echo $item['COD_EMPRESA'];   
    }
}	*/

echo json_encode($output);
?>