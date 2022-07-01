$(document).on("change", "#type", function (e) {
    type = document.getElementById("type").value;
    id = document.getElementById('select-tools').value
    if (type == 'abono') {
        if (document.getElementById('name')) {
            $(".modal-body #amount #value").remove();
            $(".modal-body #amount #name").remove();
        }
        if (document.getElementById('pays')) {
            $(".modal-body #amount #_pay").remove();
            $(".modal-body #amount #pays").remove();
        }
        $.ajax({
            method: 'GET',
            data: {'id':id},
            url: '/api/validate/payment'
        }).done(function (params) {
            if (params.type == 'abono') {
                val = params.fee - params.amount
                $(`<label id="name" for="amount"><strong>Monto</strong></label>
                <input id="value" class="form-control" type="number" name="amount" value="${val}"placeholder="20000" required/>`).appendTo('#amount');
            } else {
                $(`<label id="name" for="amount"><strong>Monto</strong></label>
                <input id="value" class="form-control" type="number" name="amount" placeholder="20000" required/>`).appendTo('#amount');
            }
        })
    } else if (type == 'pago') {
        $(".modal-body #amount #pays").remove();
        $(".modal-body #amount #_pay").remove();
        $(".modal-body #amount #value").remove();
        $(".modal-body #amount #name").remove();
    } else if (type == 'pagos') {
        if (document.getElementById('name')) {
            $(".modal-body #amount #value").remove();
            $(".modal-body #amount #name").remove();
        }
        $(`<label id="_pay" for="pays"><strong>Pagos a realizar</strong></label>
                <input id="pays" class="form-control" type="number" name="pays" value="1" required/>`).appendTo('#amount');
    } else {
        $(".modal-body #amount #name").remove();
        $(".modal-body #amount #pays").remove();
        $(".modal-body #amount #_pay").remove();
        $(".modal-body #amount #value").remove();
        $(".modal-body #amount #name").remove();
    }
});

$.ajax({
    method: 'GET',
    url: '/api/salesvehicles'
}).done(function (params) {
    $('#select-tools').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'placa',
        searchField: 'placa',
        options: params,
        create: false,
        maxItems: 1
    });

})

$(document).on("change", "#select-tools", function(e) {
    document.getElementsByName("type")[0].disabled = false;
});

$(document).on("click", "#saveButton", function(e) {
    id = document.getElementById('select-tools').value
    type_if = document.getElementById('type').value
    if (document.getElementById('type').value == '#') {
        toastr.error('Debe seleccionar un tipo de pago')
    } else {
        if (type_if == 'abono') {
            if (document.getElementById('value').value == '') {
                toastr.error('Debe ingresar un monto')
            } else {
                $.ajax({
                method: 'GET',
                data: {'id':id},
                url: '/api/validate/payment'
            }).done(function (params) {
                val = params.fee - params.amount
                if (document.getElementById('type').value == 'pago') {
                    if (params.type == "abono") {
                        toastr.error(`Tiene un pago de ${val} pendiente por saldar`)
                    } else {
                        $.confirm({
                            title: `Registrando pago a ${params.placa}`,
                            content: 'Está seguro de realizar este pago',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                Si: {
                                    text: 'Si',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        $('#paymentForm').submit()
                                    }
                                },
                                No: {
                                    text: 'No',
                                    btnClass: 'btn-red',
                                    action: function(){
                                        toastr.info('pago cancelado')
                                    }
                                },
                                close: function () {
                                }
                            }
                        });
                    }
                } else if (document.getElementById('type').value == 'abono') {
                    value = document.getElementById('value').value
                    if (params.type == "abono") {
                        if (value > val) {
                            toastr.error(`Tiene un pago de ${val} primero saldelo`)
                        } else {
                            $.confirm({
                                title: `Registrando abono a ${params.placa}`,
                                content: 'Está seguro de realizar este abono',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    Si: {
                                        text: 'Si',
                                        btnClass: 'btn-green',
                                        action: function(){
                                            $('#paymentForm').submit()
                                        }
                                    },
                                    No: {
                                        text: 'No',
                                        btnClass: 'btn-red',
                                        action: function(){
                                            toastr.info('pago cancelado')
                                        }
                                    },
                                    close: function () {
                                    }
                                }
                            });
                        }
                    } else {
                        $.confirm({
                            title: `Registrando abono a ${params.placa}`,
                            content: 'Está seguro de realizar este abono',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                Si: {
                                    text: 'Si',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        $('#paymentForm').submit()
                                    }
                                },
                                No: {
                                    text: 'No',
                                    btnClass: 'btn-red',
                                    action: function(){
                                        toastr.info('pago cancelado')
                                    }
                                },
                                close: function () {
                                }
                            }
                        });
                    }
                }
            })
            }
        } else {
            $.ajax({
                method: 'GET',
                data: {'id':id},
                url: '/api/validate/payment'
            }).done(function (params) {
                val = params.fee - params.amount
                if (document.getElementById('type').value == 'pago') {
                    if (params.type == "abono") {
                        toastr.error(`Tiene un pago de ${val} pendiente por saldar`)
                    } else {
                        $.confirm({
                            title: `Registrando pago a ${params.placa}`,
                            content: 'Está seguro de realizar este pago',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                Si: {
                                    text: 'Si',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        $('#paymentForm').submit()
                                    }
                                },
                                No: {
                                    text: 'No',
                                    btnClass: 'btn-red',
                                    action: function(){
                                        toastr.info('pago cancelado')
                                    }
                                },
                                close: function () {
                                }
                            }
                        });
                    }
                } else if (document.getElementById('type').value == 'abono') {
                    value = document.getElementById('value').value
                    if (params.type == "abono") {
                        if (value > val) {
                            toastr.error(`Tiene un pago de ${val} primero saldelo`)
                        } else {
                            $.confirm({
                                title: `Registrando abono a ${params.placa}`,
                                content: 'Está seguro de realizar este abono',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    Si: {
                                        text: 'Si',
                                        btnClass: 'btn-green',
                                        action: function(){
                                            $('#paymentForm').submit()
                                        }
                                    },
                                    No: {
                                        text: 'No',
                                        btnClass: 'btn-red',
                                        action: function(){
                                            toastr.info('pago cancelado')
                                        }
                                    },
                                    close: function () {
                                    }
                                }
                            });
                        }
                    } else {
                        $.confirm({
                            title: `Registrando abono a ${params.placa}`,
                            content: 'Está seguro de realizar este abono',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                Si: {
                                    text: 'Si',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        $('#paymentForm').submit()
                                    }
                                },
                                No: {
                                    text: 'No',
                                    btnClass: 'btn-red',
                                    action: function(){
                                        toastr.info('pago cancelado')
                                    }
                                },
                                close: function () {
                                }
                            }
                        });
                    }
                }
            })
        }
    }
});

$(document).on("click", "#deletepayment", function(e) {
    var id = $(this).data("id");
    var placa = $(this).data("placa");
    document.getElementById('iddelete').value = id;
    $.confirm({
        title: `Eliminando pago de ${placa}`,
        content: 'Está seguro de eliminar este pago',
        type: 'red',
        typeAnimated: true,
        buttons: {
            Si: {
                text: 'Si',
                btnClass: 'btn-green',
                action: function(){
                    $('#deletepaymentForm').submit()
                }
            },
            No: {
                text: 'No',
                btnClass: 'btn-red',
                action: function(){
                    toastr.info('Cancelado')
                }
            },
            close: function () {
            }
        }
    });
});


$(document).on("click", "#testpayment", function(e) {
    var id = $(this).data("id");
    var placa = $(this).data("placa");
    document.getElementById('idtest').value = id;
    $.confirm({
        title: `Eliminando pago de ${placa}`,
        content: 'Está seguro de eliminar este pago',
        type: 'red',
        typeAnimated: true,
        buttons: {
            Si: {
                text: 'Si',
                btnClass: 'btn-green',
                action: function(){
                    $('#testpaymentForm').submit()
                }
            },
            No: {
                text: 'No',
                btnClass: 'btn-red',
                action: function(){
                    toastr.info('Cancelado')
                }
            },
            close: function () {
            }
        }
    });
});

$(document).on("click", "#ticketpayment", function(e) {
    var id = $(this).data("id");
    document.getElementById('idticket').value = id;
     $('#ticketpaymentForm').submit()
});

const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

for (let i = 0; i < document.getElementsByClassName('precio').length; i++) {
    const e = document.getElementsByClassName('precio')[i];
    e.innerHTML = formatterPeso.format(e.innerHTML)
}
