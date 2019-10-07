<?php

//fetch_data.php

include('database_connection.php');

$sql = "SELECT cod_empresa, cod_compra FROM aux2 
        WHERE ROWNUM <= 100 ORDER BY cod_empresa, cod_compra";
//$statement = $connect->prepare($query);

$query = oci_parse($conexion, $sql);
$exe = oci_execute($query, OCI_DEFAULT);

if (!$exe) {
  $e = oci_error($query);
  oci_rollback($conexion); // revertir los cambios en ambas tablas
  trigger_error(htmlentities($e["<h3>Recargue la página tocando el boton</h3></br>
  	<a href=insert.php#new-ubication> Retornar</a>"]), E_USER_ERROR);
}

/*if($statement->execute())
{
	while($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		$data[] = $row;
	}

	echo json_encode($data);
}*/

/*while (($row = oci_fetch_array($query, OCI_ASSOC)) != false){
	$nav[] = $row;
	$data["prueba"] = $nav;	
}*/

while (($row = oci_fetch_array($query, OCI_ASSOC)) != false){	
	$data[] = $row;	
}

echo json_encode($data);
?>