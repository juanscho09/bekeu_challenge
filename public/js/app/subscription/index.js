$(function() {
    init();
    events();
});

function init(){
    window.$lst_states = $('#lst_states');
    window.$tb_subscriptions = $('#subscriptions');
    window.$bt_send_subscription = $('#send_subscription');
}

function events(){
    $bt_send_subscription.on('click', subscribe);
    $lst_states.select2({
        theme: 'bootstrap4',
    });
    tableSubscriptions();
}

function tableSubscriptions(){
    $tb_subscriptions.DataTable({
        //"responsive": true,
        "order": [[ 1, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_path + "/subscriptions_ajax",
        },
        "columns": [
            { "data": "id",
                className: "text-center"},
            { "data": "email",
                className: "text-center"},
            { "data": "state.name",
                className: "text-center" },
            { "data": "created_at",
                className: "text-center" },
            { "data": "updated_at",
                className: "text-center" }
        ],
        language: {
            url: base_path + '/libs/datatables/js/es-ES.json'
        },
        oLanguage: {
            sZeroRecords: "<center>No se encontraron resultados</center>"
        },
        /*columnDefs: [
            { orderable: false, targets: -1 },
            { orderable: false, targets: -2 }
        ]*/
    });
}

function subscribe(){
    var data = {
        email: $('#tx_email').val(),
        state_id: $('#lst_states').val()
    };
    var request = $.ajax({
        url: base_path + "/subscriptions",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        method: "POST",
        beforeSend: function () {
            Swal.fire({
                title: 'La petición se está procesando...'
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
            $tb_subscriptions.DataTable().ajax.reload();
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