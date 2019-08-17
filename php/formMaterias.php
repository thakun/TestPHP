<?php

	include "materia.php";
	include "conexion.php";

	$opt = $_POST['opt'];

	//Cargar materias
	if($opt == '1'){
		echo json_encode(Materia::cargar_materias());
	}else{
		//Eliminar materia
		echo json_encode(Materia::eliminar_materia($_POST['clave']));
	}

?>