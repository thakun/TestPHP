<?php

	include "alumno.php";
	include "conexion.php";

	$opt = $_POST['opt'];

	//Cargar alumnos
	if($opt == '1'){
		echo json_encode(Alumno::cargar_alumnos());
	}else{
		//Eliminar un alumno
		echo json_encode(Alumno::eliminar_alumno($_POST['matricula']));
	}

?>