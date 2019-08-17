<?php

	include "asignacion.php";
	include "alumno.php";
	include "materia.php";
	include "conexion.php";

	$opt = $_POST['opt'];

	//Cargar asignaciones
	if($opt == '1'){
		echo json_encode(Asignacion::cargar_asignaciones());
	//Cargar información de las listas con alumnos y materias
	}elseif ($opt == '2') {
		$alumnos = Alumno::cargar_alumnos();
		$materias = Materia::cargar_materias();
		echo json_encode(Array($alumnos,$materias));
	}else{
		//Eliminar asignación
		echo json_encode(Asignacion::eliminar_asignacion($_POST['matricula'],$_POST['clave']));
	}

?>