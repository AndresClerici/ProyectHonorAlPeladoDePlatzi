<?php

//database_connection.php

//$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

	$host="199.141.145.246";
	$port="1521"; // Por defecto 1521
	$user_name="asa";
	$password="clerici4456";
	$service_name="hhb";

	/*define("ORCL_HOST",$HOST);
	define("ORCL_USER_NAME",$USER_NAME);
	define("ORCL_PASSWORD",$PASSWORD);
	define("ORCL_SERVICE_NAME",$SERVICE_NAME);*/
    
	//$host="".ORCL_HOST."";
	$sid="(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=".$host.")(PORT=".$port.")))(CONNECT_DATA=(SERVICE_NAME=".$service_name.")))";

	$conexion = oci_connect($user_name,$password,$sid);

	if (!$conexion) {
		echo "No se establecio la conexion";
	    $e = oci_error();
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

?>


