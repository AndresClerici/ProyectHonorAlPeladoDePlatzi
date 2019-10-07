<?php

//insert.php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$cod_empresa = '';
$cod_sucursal = '';
$tipo_comprobante = '';
$ser_comprobante = '';
$nro_comprobante = '';

if($form_data->action == 'fetch_single_data')
{
	$sql = "SELECT cod_empresa,
				   cod_sucursal, tipo_comprobante, ser_comprobante, nro_comprobante 
			  FROM aux2 WHERE nro_comprobante ='".$form_data->id."'";
	//$statement = $connect->prepare($query);
	//$statement->execute();
	$query = oci_parse($conexion, $sql);
	$exe = oci_execute($query, OCI_DEFAULT);

	if (!$exe) {
	  $e = oci_error($query);
	  oci_rollback($conexion); // revertir los cambios en ambas tablas
	  trigger_error(htmlentities($e["<h3>Recargue la página tocando el boton</h3></br><a href=insert.php#new-ubication> Retornar</a>"]), E_USER_ERROR);
	}

	//$result = $statement->fetchAll();

	/*oci_fetch_all($query, $result);

	foreach($result as $row)
	{
		$output['cod_empresa'] = $row['COD_EMPRESA'];
		$output['cod_sucursal'] = $row['COD_SUCURSAL'];
		$output['tipo_comprobante'] = $row['TIPO_COMPROBANTE'];
		$output['ser_comprobante'] = $row['SER_COMPROBANTE'];
		$output['nro_comprobante'] = $row['NRO_COMPROBANTE'];		
	}*/

	while (($row = oci_fetch_array($query, OCI_ASSOC)) != false){
		$output['cod_empresa'] 		= $row['COD_EMPRESA'];
		$output['cod_sucursal'] 	= $row['COD_SUCURSAL'];
		$output['tipo_comprobante'] = $row['TIPO_COMPROBANTE'];
		$output['ser_comprobante']  = $row['SER_COMPROBANTE'];
		$output['nro_comprobante']  = $row['NRO_COMPROBANTE'];
	}
}
elseif($form_data->action == "Delete")
{
	$sql = "
	DELETE FROM aux2 WHERE nro_comprobante='".$form_data->id."'
	";	

	$query = oci_parse($conexion, $sql);
	$exe = oci_execute($query, OCI_DEFAULT);

	if (!$exe) {
	  $e = oci_error($query);
	  oci_rollback($conexion); // revertir los cambios en ambas tablas
	  trigger_error(htmlentities($e["<h3>Recargue la página tocando el boton</h3></br>
	  	<a href=insert.php#new-ubication> Retornar</a>"]), E_USER_ERROR);
	} else {
		oci_commit($conexion);
		oci_free_statement($query);
		$output['message'] = 'Data Deleted';
	}

	/*$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Data Deleted';
	}*/
}
else
{
	if(empty($form_data->cod_empresa))
	{
		$error[] = 'Se necesita Cod. Empresa';
	}
	else
	{
		$cod_empresa = $form_data->cod_empresa;
	}

	if(empty($form_data->cod_sucursal))
	{
		$error[] = 'Se necesita Cod. Sucursal';
	}
	else
	{
		$cod_sucursal = $form_data->cod_sucursal;
	}

	if(empty($form_data->tipo_comprobante))
	{
		$error[] = 'Se necesita Tipo Comprobante';
	}
	else
	{
		$tipo_comprobante = $form_data->tipo_comprobante;
	}

	if(empty($form_data->ser_comprobante))
	{
		$error[] = 'Se necesita Serie Comprobante';
	}
	else
	{
		$ser_comprobante = $form_data->ser_comprobante;
	}

	if(empty($form_data->nro_comprobante))
	{
		$error[] = 'Se necesita N°. Comprobante';
	}
	else
	{
		$nro_comprobante = $form_data->nro_comprobante;
	}

	if(empty($error))
	{
		if($form_data->action == 'Insert')
		{
			/*$data = array(
				':cod_empresa'		=>	$cod_empresa,
				':cod_sucursal'		=>	$cod_sucursal,
				':tipo_comprobante' =>	$tipo_comprobante,
				':ser_comprobante'  =>	$ser_comprobante,
				':nro_comprobante'  =>	$nro_comprobante);

			$sql = "INSERT INTO aux2
				(cod_empresa, cod_sucursal, tipo_comprobante, ser_comprobante, nro_comprobante) VALUES
				(:cod_empresa, :cod_sucursal, :tipo_comprobante, :ser_comprobante, :nro_comprobante)";*/

			$sql = "INSERT INTO aux2 (cod_empresa, cod_sucursal, tipo_comprobante, ser_comprobante, nro_comprobante) VALUES ('".$cod_empresa."', '".$cod_sucursal."', '".$tipo_comprobante."', '".$ser_comprobante."', ".$nro_comprobante.")";
			$query = oci_parse($conexion, $sql);
			$exe = oci_execute($query, OCI_DEFAULT);

			if (!$exe) {
			  $e = oci_error($query);
			  oci_rollback($conexion); // revertir los cambios en ambas tablas
			  trigger_error(htmlentities($e["<h3>Recargue la página tocando el boton</h3></br>
			  	<a href=insert.php#new-ubication> Retornar</a>"]), E_USER_ERROR);			  
			} else {
				oci_commit($conexion);
				oci_free_statement($query);
				$message = 'Data Inserted';
			}

			/*$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Inserted';
			}*/
		}
		if($form_data->action == 'Edit')
		{
			/*$data = array(
				':cod_empresa'	=>	$cod_empresa,
				':cod_sucursal'	=>	$cod_sucursal,
				':tipo_comprobante'	=>	$tipo_comprobante,
				':ser_comprobante'	=>	$ser_comprobante,
				':nro_comprobante'	=>	$nro_comprobante,
				':id'				=>	$form_data->id
			);*/

			$sql = "
			UPDATE aux2
			SET cod_empresa = '".$cod_empresa."', 
				cod_sucursal = '".$cod_sucursal."',
				tipo_comprobante = '".$tipo_comprobante."',
				ser_comprobante = '".$ser_comprobante."',
				nro_comprobante = '".$nro_comprobante."'
			WHERE nro_comprobante = ".$form_data->id." "; //$nro_comprobante

			$query = oci_parse($conexion, $sql);
			$exe = oci_execute($query, OCI_DEFAULT);

			if (!$exe) {
			  $e = oci_error($query);
			  oci_rollback($conexion); // revertir los cambios en ambas tablas
			  trigger_error(htmlentities($e["<h3>Recargue la página tocando el boton</h3></br>
			  	<a href=insert.php#new-ubication> Retornar</a>"]), E_USER_ERROR);
			} else {
				oci_commit($conexion);
				oci_free_statement($query);
				$message = 'Data Edited';
			}
		}
	}
	else
	{
		$validation_error = implode(", ", $error);		
	}

	$output = array(
		'error'		=>	$validation_error,
		'message'	=>	$message
	);
}

echo json_encode($output);
?>