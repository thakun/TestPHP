<?php

	include "materia.php";
	include "conexion.php";

	//Insertar materias
	$m = new Materia($_REQUEST['inpClave'],$_REQUEST['inpNombre']);
	echo json_encode($m->insertar());

?>