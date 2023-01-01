
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
    })
});


function successToast( messaje ){
    Toastify({
        text: messaje,
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

function dangerToast( messaje ){
    Toastify({
        text: messaje,
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

function infoToast( messaje ){
    Toastify({
        text: messaje,
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
