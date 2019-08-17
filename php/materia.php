<?php

	/**
	*
	*	Clase para el manejo de las materias
	*	@author Ing. Eduardo López Méndez
	*	16/08/2019
	*
	*/
	class Materia
	{
		//Cada atributo corresponde a un campo de la tabla materia
		private $clave_materia;
		private $nombre;
		
		/**
		*
		*	Constructor de la clase Materia con los datos requeridos
		*	@param clave_materia -> clave de la materia
		*	@param nombre -> Nombre de la materia
		*
		*/
		function __construct($clave_materia, $nombre)
		{
			$this->clave_materia = $clave_materia;
			$this->nombre = $nombre;
		}

		/**
		*
		*	Método insertar para agregar materias a la base de datos
		*
		*/
		public function insertar()
		{
			$existe = Materia::existe_materia($this->nombre, $this->clave_materia);

			if(!$existe){
				$mysqli = Conexion::conectar();
				$query = "INSERT INTO materia(clave_materia,nombre) VALUES ($this->clave_materia,'$this->nombre')";
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
		*	Método cargar_alumnos para obtener las materias registradas en la tabla materia
		*
		*/
		public static function cargar_materias(){
			$materias = [];
			$mysqli = Conexion::conectar();
			$query = "SELECT * FROM materia";
			if($result = $mysqli->query($query)){
				while($row = $result->fetch_object()){
					$materias[] = $row;
				}
			}

			return $materias;
		}

		/**
		*
		*	Método para eliminar una materia de la base de datos 
		*	@param clave_materia -> Clave de la materia
		*
		*/
		public static function eliminar_materia($clave_materia){
			//Se genero un trigger que elimina la asignacion donde la materia eliminada se encontraba			
			$mysqli = Conexion::conectar();
			$query = "DELETE FROM materia WHERE clave_materia = $clave_materia";
			if($mysqli->query($query) == FALSE){
				echo "Error";
			}
		}

		/**
		*
		*	Método para verificar si alguna clave o nombre de materia existe en la base de datos para evitar repetir
		*	@param nombre -> Nombre de la materia a verificar
		*	@param clave_materia -> Clave de la materia a verificar
		*
		*/
		public static function existe_materia($nombre,$clave_materia){
			$mysqli = Conexion::conectar();
			$query = "SELECT nombre FROM materia WHERE nombre = '$nombre' OR clave_materia = $clave_materia";
			if($result = $mysqli->query($query)){
				return $result->num_rows;
			}
		}
	}

?>