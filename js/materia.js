/**
*
*	Archivo JS en la vista del formulario para el control de las materias
*	@author Ing. Eduardo López Méndez
*	16/08/2019
*
*/
$(document).ready(function() {

	//Ejecutar busqueda en la tabla de las materias al escribir en el input del buscador
	 $("#buscar").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tMaterias tbody tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
	
	//Ejecutar ajax con los datos del formulario para insertar una materia
	$("form").submit(function(e) {
		e.preventDefault();
		$.ajax({
	            type: "POST",
	            url: "../php/insertMateria.php",
	            data:$(this).serialize(),
	            beforeSend: function(){
	                
	            },
	            complete:function(data){
	                
	            },
	            success: function(data){
	               
	               //Si se inserto correctamente actualizar la lista de materias
	               if(data == 0){

	               		$("tbody").empty();
	               		cargar_materias();
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
	               			//Si la materia ya esta registrada mostrar una notificación
	               			$.notify({
			                    message: "La materia ya esta registrada"
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

	//Cargar las materias en la lista
	cargar_materias();


});

/**
*
*	Funcion Cargar alumnos
*	carga los alumnos en la lista
*
*/
function cargar_materias() {
	$.post("../php/formMaterias.php",{opt:1},function(respuesta) {
		console.log(respuesta);
		respuesta = JSON.parse(respuesta);
		
		$.each(respuesta,function(i,j) {
			tr=$('<tr>');
			tr.append('<td>'+j.clave_materia+'</td>');
			tr.append('<td>'+j.nombre+'</td>');
			tr.append('<td><button id="'+j.clave_materia+'" class="btnImg btn btn-danger"><img src="../img/eliminar.png"></button>' )
			tr.appendTo($('tbody'));

			$("#"+j.clave_materia).click(function(e) {
				$.post("../php/formMaterias.php",{opt:2,clave:j.clave_materia},function(respuesta) {
					$("#"+j.clave_materia).parent().parent().remove();
				});
			});
		});
	});
}