$(function() {
    init();
    events();
});

function init(){
    window.$lst_states = $('#lst_states');
    window.$tx_email = $('#tx_email');
    window.$tb_subscriptions = $('#subscriptions');
    window.$hd_subscriptionid = $('#hd_subscriptionid');
    window.$bt_send_subscription = $('#send_subscription');
    window.$bt_clean_subscription = $('#clean_subscription');
    window.$frm_subscription = $("#frm_subscription");
}

function events(){
    $bt_send_subscription.on('click', subscribe);
    $bt_clean_subscription.on('click', resetForm);
    $lst_states.select2({
        theme: 'bootstrap4',
    });
    tableSubscriptions();
    rulesForValidation();
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
                className: "text-center" },
            { "data": null,
                render: function(data, type) {
                    var btn_edit = '<button class="btn" type="button" onclick="edit(\''+data.email+'\','+data.state_id+','+data.id+')">'+
                        '<i class="fa fa-edit"></i></button>';
                    var btn_delete = '<button class="btn" type="button" onclick="confirmRemove('+data.id+')"><i class="fa fa-trash"></i></button>';
                         
                    return btn_edit + btn_delete;
                }
            },
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

function rulesForValidation(){
    $frm_subscription.validate({
        rules: {
            tx_email: {
                required: true,
                email: true
            }
        },
        messages : {
            tx_email: {
                required: "Es necesario escribir el mail",
                email: "El formato debería ser: abc@domain.tld"
            }
        }
    });
}

function subscribe(){
    if( !$frm_subscription.valid() ){
        return false;
    }
    var hd_subscriptionid = $hd_subscriptionid.val();
    var data = {
        email: $tx_email.val(),
        state_id: $lst_states.val(),
        id: $hd_subscriptionid.val()
    };
    var method = "POST";
    var route = "/subscriptions";
    if( hd_subscriptionid != ""  ){
        method = "PUT";
        route = "/subscriptions/" + hd_subscriptionid;
    }
    var request = $.ajax({
        url: base_path + route,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        method: method,
        beforeSend: function () {
            Swal.fire({
                title: 'La petición se está procesando...'
            });
            Swal.showLoading()
        }
    });
    
    responseAjax(request);
}

function edit(mail, state_id, id){
    $tx_email.val(mail);
    $lst_states.val(state_id).change();
    $hd_subscriptionid.val(id);
}

function confirmRemove(subscription_id){
    Swal.fire({
        title: "¿Seguro de eliminar esta suscripción?",
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {
            if (result.isConfirmed) {
                remove(subscription_id);
            }
      })
}

function remove(sub_id){
    var request = $.ajax({
        url: base_path + "/subscriptions/remove/" + sub_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        beforeSend: function () {
            Swal.fire({
                title: 'La petición se está procesando...'
            });
            Swal.showLoading()
        }
    });
    
    responseAjax(request);
}

function responseAjax(request){
    request.done(function( response ) {
        let mensaje = response.mensaje;
        if( !response.error ){
            toast.fire({
                icon: 'success',
                title: mensaje
            });
            resetForm();
            $tb_subscriptions.DataTable().ajax.reload();
        } else {
            toast.fire({
                icon: 'error',
                title: mensaje
            });
        }
    });
    
    request.fail(function( jqXHR, textStatus ) {
        //alert( "Request failed: " + textStatus );
        var msj_error = "Ocurrió un error en la operación.";
        if( jqXHR.status == "422" ){
            var error = jqXHR.responseJSON.errors;
            msj_error = "";
            if( typeof error.email != "undefined" && error.email.length > 0 ){
                msj_error += error.email[0] + "</br>";
            }
            if( typeof error.state_id != "undefined" && error.state_id.length > 0 ){
                msj_error += error.state_id[0] + "</br>";
            }
        }
        toast.fire({
            icon: 'error',
            title: msj_error
        });
    });
}

function resetForm(){
    $tx_email.val("");
    $lst_states.val("").change();
    $hd_subscriptionid.val("");
    $frm_subscription.validate().resetForm();
}