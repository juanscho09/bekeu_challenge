$(function() {
    init();
    events();
});

function init(){
    window.$btn_import = $('#import_states');
}

function events(){
    $btn_import.on('click', importStates);
}

function importStates(){
    var request = $.ajax({
        url: base_path + "/states/store",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        beforeSend: function () {
            Swal.fire({
                title: 'La petición se está procesando...',
                allowOutsideClick: false
            });
            Swal.showLoading()
        }
    });
    
    request.done(function( response ) {
        let mensaje = response.mensaje;
        if( !response.error ){
            toast.fire({
                icon: 'success',
                title: mensaje
            });
        } else {
            toast.fire({
                icon: 'error',
                title: mensaje
            });
        }
    });
    
    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
        toast.fire({
            icon: 'error',
            title: 'Ocurrió un error en la importación.'
        });
    });
}
