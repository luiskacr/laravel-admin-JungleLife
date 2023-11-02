
/**
 * Set Default #table config from DataTable
 *
 * @returns void
 */
$(document).ready(function (){
    $('#table').dataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "bSort": false,
        responsive: true,

    })
});

/**
 * Set Global DataTables values
 *
 * @returns void
 */
(function ($, DataTable) {
    $.extend(true, DataTable.defaults, {
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },

        responsive: true,

    });
})(jQuery, jQuery.fn.dataTable);

/**
 * Set Default #date config from flatpickr
 *
 * @returns void
 */
$("#date").flatpickr({
    "dateFormat": "d-m-Y",
    "minDate": "today",
    "locale": "es"
});

/**
 * Create a Success Toast Notification
 *
 * @param message
 * @return void
 */
function successToast( message ){
    Toastify({
        text: message,
        avatar: 'https://api.iconify.design/gridicons/checkmark.svg?color=white',
        duration: 3000,
        className: "bg-success",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "none",
        },
        onClick: function(){} // Callback after click
    }).showToast();

}

/**
 * Create a Danger Toast Notification
 *
 * @param message
 * @return void
 */
function dangerToast( message ){
    Toastify({
        text: message,
        avatar: 'https://api.iconify.design/ic/baseline-warning.svg?color=white',
        duration: 3000,
        className: "bg-danger",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "none",
        },
        onClick: function(){} // Callback after click
    }).showToast();
}

/**
 * Create an Info Toast Notification
 *
 * @param message
 * @return void
 */
function infoToast( message ){
    Toastify({
        text: message,
        avatar: 'https://api.iconify.design/bi/info-circle.svg?color=white',
        duration: 3000,
        className: "bg-info",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "none",
        },
        onClick: function(){} // Callback after click
    }).showToast();
}

/**
 * Delays the execution of code for the specified time.
 *
 * @param {number} time - The time in milliseconds to sleep.
 * @returns {Promise} A promise that resolves after the specified time has elapsed.
 */
function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}
