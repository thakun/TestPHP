<?php

	/**
	*
	*	Clase para el manejo de las asignaciones
	*	@author Ing. Eduardo López Méndez
	*	16/08/2019
	*
	*/
	class Asignacion
	{

		private $matricula;
		private $clave_materia;
		
		/**
		*
		*	Constructor de la clase Asignacion con los datos requeridos
		*	@param matricula -> Matricula del alumno
		*	@param clave_materia -> clave de la materia
		*
		*/
		function __construct($matricula, $clave_materia)
		{
			$this->matricula = $matricula;
			$this->clave_materia = $clave_materia;
		}

		/**
		*
		*	Método insertar para agregar asignaciones a la base de datos
		*
		*/
		public function insertar()
		{
			$existe = Asignacion::existe_asignacion($this->matricula, $this->clave_materia);

			if(!$existe){
				$mysqli = Conexion::conectar();
				$query = "INSERT INTO asignacion(matricula,clave_materia) VALUES ('$this->matricula',$this->clave_materia)";
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
		*	Método cargar_asignaciones para obtener las asignaciones registradas en la tabla asignación
		*
		*/
		public static function cargar_asignaciones(){
			$asignaciones = [];
			$mysqli = Conexion::conectar();
			$query = "SELECT asignacion.id_asignacion,alumno.matricula, alumno.nombre, materia.clave_materia, materia.nombre As materia FROM alumno INNER JOIN asignacion ON alumno.matricula = asignacion.matricula INNER JOIN materia ON asignacion.clave_materia = materia.clave_materia";
			if($result = $mysqli->query($query)){
				while($row = $result->fetch_object()){
					$asignaciones[] = $row;
				}
			}

			return $asignaciones;
		}

		/**
		*
		*	Método para eliminar una asignacion de la base de datos 
		*	@param matricula -> MAtricula del alumno
		*	@param clave_materia -> Clave de la materia
		*
		*/
		public static function eliminar_asignacion($matricula,$clave_materia){
			$mysqli = Conexion::conectar();
			$query = "DELETE FROM asignacion WHERE matricula = '$matricula' AND clave_materia = $clave_materia";
			if($mysqli->query($query) == FALSE){
				echo "Error";
			}
		}

		/**
		*
		*	Método para verificar si alguna asignacion ya esta registrada para evitar repetir
		*	@param matricula -> Matricula del alumno
		*	@param clave_materia -> Clave de la materia a verificar
		*
		*/
		public static function existe_asignacion($matricula,$clave_materia){
			$mysqli = Conexion::conectar();
			$query = "SELECT matricula FROM asignacion WHERE matricula = '$matricula' AND clave_materia = $clave_materia";
			if($result = $mysqli->query($query)){
				return $result->num_rows;
			}
		}
	}

?>