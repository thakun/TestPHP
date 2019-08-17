<?php

	include "alumno.php";
	include "conexion.php";

	//Insertar alumnos
	$a = new Alumno($_REQUEST['inpMatricula'],$_REQUEST['inpNombre'],$_REQUEST['inpFecha']);
	echo json_encode($a->insertar());

?>