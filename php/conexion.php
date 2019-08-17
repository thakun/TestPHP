<?php
	/**
	*
	*	Clase Conexion para manejar el acceso a la base de datos
	*	@author Ing. Eduardo López Méndez
	*	16/08/2019
	*
	*/
	class Conexion{

		/***
		*
		*	Funcion conectar que realiza la conexion con la base de datos
		*
		*/

		public static function conectar(){
			$mysqli = new mysqli('localhost','root','','test');

			if($mysqli->connect_error){
				die("Error de conección(".$mysqli-connect_errno.")".$mysqli->connect_error);
			}		

			return $mysqli;
		}

	}
	
?>