/**
*
*	Archivo JS en la vista del formulario para el control de los alumnos
*	@author Ing. Eduardo López Méndez
*	16/08/2019
*
*/
$(document).ready(function() {

	//Ejecutar busqueda en la tabla de los alumnos al escribir en el input del buscador
	 $("#buscar").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tAlumnos tbody tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
	
	//Ejecutar ajax con los datos del formulario para insertar un alumno
	$("form").submit(function(e) {
		e.preventDefault();
		$.ajax({
	            type: "POST",
	            url: "php/insertAlumno.php",
	            data:$(this).serialize(),
	            beforeSend: function(){
	                
	            },
	            complete:function(data){
	                
	            },
	            success: function(data){
	               
	            	//Si se inserto correctamente actualizar la lista de alumnos
	               if(data == 0){

	               		$("tbody").empty();
	               		cargar_alumnos();
						$("form")[0].reset();
						d = new Date();
						fecha = d.getFullYear() + "-" + (d.getMonth() + 1).toString().padStart(2,'0') + "-" + d.getDate().toString().padStart(2,'0');
						$("#fecha").val(fecha)
	               }else{
	               		//Si los datos no cumplen con las condiciones requeridas mostrar una notificación
	               		if(data == 1){
	               			$.notify({
			                    message: "Datos incorrectos"
			                },{
			                    type: 'danger',
			                    placement: {
			                                    from: "bottom",
			                                    align: "right"
			                                }
			                });
	               		}else{
	               			//Si el alumno ya esta registrado mostrar una notificación
	               			$.notify({
			                    message: "La matricula ya esta registrada"
			                },{
			                    type: 'danger',
			                    placement: {
			                                    from: "bottom",
			                                    align: "right"
			                                }
			                });
	               		}
	               }           	
	                
	            },
	            error: function(data){
	                /*
	                * Se ejecuta si la peticón ha sido erronea
	                * */
	                console.log("Error");
	            }
	        });
	});

	//Cargar los alumnos en la lista y la fecha al cargar la pagina
	fecha();
	cargar_alumnos();


});

/**
*
*	Funcion fecha
*	carga la fecha de registro
*
*/
function fecha() {
	d = new Date();
	fecha = d.getFullYear() + "-" + (d.getMonth() + 1).toString().padStart(2,'0') + "-" + d.getDate().toString().padStart(2,'0');
	$("#fecha").val(fecha)
}

/**
*
*	Funcion Cargar alumnos
*	carga los alumnos en la lista
*
*/
function cargar_alumnos() {
	$.post("php/formAlumnos.php",{opt:1},function(respuesta) {
		respuesta = JSON.parse(respuesta);

		$.each(respuesta,function(i,j) {
			tr=$('<tr>');
			tr.append('<td>'+j.matricula+'</td>');
			tr.append('<td>'+j.nombre+'</td>');
			tr.append('<td>'+j.fecha_registro+'</td>');
			tr.append('<td><button id="'+j.matricula+'" class="btnImg btn btn-danger"><img src="img/eliminar.png"></button>' )
			tr.appendTo($('tbody'));

			$("#"+j.matricula).click(function(e) {
				$.post("php/formAlumnos.php",{opt:2,matricula:j.matricula},function(respuesta) {
					$("#"+j.matricula).parent().parent().remove();
				});
			});
		});
	});
}