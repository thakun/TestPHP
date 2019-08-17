/**
*
*	Archivo JS en la vista del formulario para el control de los asignaciones, la relación entre alumno y materia
*	@author Ing. Eduardo López Méndez
*	16/08/2019
*
*/
$(document).ready(function() {

	//Ejecutar busqueda en la tabla de los asignaciones al escribir en el input del buscador
	 $("#buscar").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tAsignaciones tbody tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
	
	//Ejecutar ajax con los datos del formulario para insertar un asignacion
	$("form").submit(function(e) {
		e.preventDefault();
		if($("#cmbAlumnos").val() != "0" && $("#cmbMaterias").val() != "0"){
			$.ajax({
	            type: "POST",
	            url: "../php/insertAsignaciones.php",
	            data:$(this).serialize(),
	            beforeSend: function(){
	                
	            },
	            complete:function(data){
	                
	            },
	            success: function(data){
	               //Si se inserto correctamente actualizar la lista de asignaciones
	               if(data == 0){

	               		$("tbody").empty();
	               		cargar_asignaciones();
						$("form")[0].reset();
	               }else{
	               		if(data == 1){
	               			//Si los datos no cumplen con las condiciones requeridas mostrar una notificación
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
	               			//Si el alumno ya esta relacionado con la materia mostrar una notificación
	               			$.notify({
			                    message: "El alumno ya esta inscrito en la materia"
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
		}else{
			$.notify({
                message: "Selecciona un alumno y una materia"
                },{
                    type: 'danger',
                    placement: {
                                    from: "bottom",
                                    align: "right"
                                }
                });
		}
		
	});

	//Cargar los asignaciones en la lista y la informacion de los dropdowns de alumnos y materias al cargar la pagina
	cargar_dropdowns();
	cargar_asignaciones();


});

/**
*
*	Funcion Cargar dropdowns
*	carga los alumnos y las materias en sus respectivos dropdowns en la lista
*
*/
function cargar_dropdowns(){
	$.post("../php/formAsignaciones.php",{opt:2},function(respuesta) {
		
		respuesta = JSON.parse(respuesta);

		$.each(respuesta[0],function(i,j) {
			opt = $('<option value="'+j.matricula+'">'+j.nombre+'</option>');
			opt.appendTo($('#cmbAlumnos'));
		});
		$.each(respuesta[1],function(i,j) {
			opt = $('<option value="'+j.clave_materia+'">'+j.nombre+'</option>');
			opt.appendTo($('#cmbMaterias'));
		});
	});
}

/**
*
*	Funcion Cargar asignaciones
*	carga las materias en la lista
*
*/
function cargar_asignaciones() {
	$.post("../php/formAsignaciones.php",{opt:1},function(respuesta) {
		respuesta = JSON.parse(respuesta);
		
		$.each(respuesta,function(i,j) {
			tr=$('<tr>');
			tr.append('<td>'+j.matricula+'</td>');
			tr.append('<td>'+j.nombre+'</td>');
			tr.append('<td>'+j.materia+'</td>');
			tr.append('<td>'+j.clave_materia+'</td>');
			tr.append('<td><button id="'+j.id_asignacion+'" class="btnImg btn btn-danger"><img src="../img/eliminar.png"></button>' )
			tr.appendTo($('tbody'));

			$("#"+j.id_asignacion).click(function(e) {
				$.post("../php/formAsignaciones.php",{opt:3,matricula:j.matricula,clave:j.clave_materia},function(respuesta) {
					console.log(respuesta)
					$("#"+j.id_asignacion).parent().parent().remove();
				});
			});
		});
	});
}