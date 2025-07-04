/*global document: false */

function borra_cat(a) {
  event.preventDefault();
  var mensaje = "Está seguro de borrar la categoria " + a + "??";
  var id = a;
  Swal.fire({
  title: mensaje,
  text: "Borrar Categoria....",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, Borrar'

}).then((result) => {
  if (result.value) {
    const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    type: 'success',
    title: 'Categoria Borrada'
  })
    navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
  	navigator.vibrate(1000);
    var request = $.ajax({
            url:'/categorias/borrar',
            type:'POST',
            dataType: 'text',
            cache: false,
            data: {'id': id}
             });
             request.done(function( msg ) {
              window.location.href = '/categorias';

             });
             request.fail(function( jqXHR, textStatus ) {
             alert( "Error : " + textStatus );
            });


          } else {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'warning',
            title: 'Error al borrar!!'
            })

          }

  })


}
function edita_cat(a) {
  event.preventDefault();
  var id = a;
  var request = $.ajax({
            url:'/categorias/editar',
            type:'POST',
            dataType: 'json',
            cache: false,
            data: {'id': id}
             });
             request.done(function(respuesta) {
              $('#modalModificarCategoria').modal('show');
              $('#CategoriaNombre').val(respuesta['descripcion']);
              $('#idCategoria').val(respuesta['idCategoria']);
            });
             request.fail(function( jqXHR, textStatus ) {
             alert( "Error !!!: " + textStatus );
            });
}

$(document).ready(function() {
     $('#categorias').DataTable( {

        "order": [[ 0, "asc" ]],
        "pagingType": "full_numbers",
        "paging":         true,
        "language":  {
    "decimal":        "",
    "scrollX": true,
    "emptyTable":     "sin datos en la tabla",
    "info":           "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
    "infoEmpty":      "Showing 0 to 0 of 0 entries",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Mostrar _MENU_ registros",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search":         "Buscar: ",
    "zeroRecords":    "Sin coincidencias",
    "paginate": {
        "first":      "Primera",
        "last":       "Ultima",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}
    } );
} );
