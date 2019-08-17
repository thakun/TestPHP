<?php

	/**
	*
	*	Clase para el manejo de los alumnos
	*	@author Ing. Eduardo López Méndez
	*	16/08/2019
	*
	*/
	class Alumno
	{

		//Cada atributo corresponde a un campo de la tabla alumno
		private $matricula;
		private $nombre;
		private $fecha_registro;
		
		/**
		*
		*	Constructor de la clase alumno con los datos requeridos
		*	@param matricula -> Matricula del alumno
		*	@param nombre -> Nombre del alumno
		*	@param fecha_registro -> Fecha en que se registro al alumno
		*
		*/
		function __construct($matricula, $nombre, $fecha_registro)
		{
			$this->matricula = $matricula;
			$this->nombre = $nombre;
			$this->fecha_registro = $fecha_registro;

		}

		/**
		*
		*	Método insertar para agregar alumnos a la base de datos
		*
		*/
		public function insertar()
		{
			$existe = Alumno::existe_matricula($this->matricula);
			if(!$existe){
				$mysqli = Conexion::conectar();
				$query = "INSERT INTO alumno(matricula,nombre,fecha_registro) VALUES ('$this->matricula','$this->nombre','$this->fecha_registro')";
				if($mysqli->query($query) == FALSE){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 2;
			}
			
		}

		/**
		*
		*	Método cargar_alumnos para obtener los alumnos registrados en la tabla alumnos
		*
		*/
		public static function cargar_alumnos(){
			$alumnos = [];
			$mysqli = Conexion::conectar();
			$query = "SELECT * FROM alumno ORDER BY fecha_registro DESC";
			if($result = $mysqli->query($query)){
				while($row = $result->fetch_object()){
					$alumnos[] = $row;
				}
			}

			return $alumnos;
		}

		/**
		*
		*	Método para eliminar un alumno de la base de datos 
		*	@param matricula -> Matricula del alumno
		*
		*/
		public static function eliminar_alumno($matricula){
			//Se genero un trigger que elimina la asignacion donde el alumno eliminado se encontraba
			$mysqli = Conexion::conectar();
			$query = "DELETE FROM alumno WHERE matricula = '$matricula'";
			if($mysqli->query($query) == FALSE){
				return 1;
			}else{
				return 0;
			}
		}

		/**
		*
		*	Método para verificar si alguna matricula existe en la base de datos para evitar repetir
		*	@param matricula -> Matricula del alumno
		*
		*/
		public static function existe_matricula($matricula){
			$mysqli = Conexion::conectar();
			$query = "SELECT matricula FROM alumno WHERE matricula = '$matricula'";
			if($result = $mysqli->query($query)){
				return $result->num_rows;
			}
		}
	}

?>