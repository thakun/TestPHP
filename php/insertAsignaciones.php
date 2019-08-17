<?php

	include "asignacion.php";
	include "conexion.php";

	//Insertar asignaciones
	$c = new Asignacion($_REQUEST['selectAlumno'],$_REQUEST['selectMateria']);
	echo json_encode($c->insertar());

?>