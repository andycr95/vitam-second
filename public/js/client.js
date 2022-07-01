$(document).on("change", "#photo", function(e) {
    var id = $(this).data("id");
    document.getElementById("form").submit();
});

$(document).on("change", "#photo1", function(e) {
    var id = $(this).data("id");
    document.getElementById("form1").submit();
});

$(document).on("change", "#photo2", function(e) {
    var id = $(this).data("id");
    document.getElementById("form2").submit();
});

$.ajax({
    method: 'GET',
    url: '/api/branchoffices'
}).done(function (params) {
    $('#select-branch').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        options: params,
        create: false,
        maxItems: 1
    });
})

$('#clientUpdate').click(function ($event) {
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled== false) {
        document.getElementsByName("first_name")[0].disabled = true;
        document.getElementsByName("last_name")[0].disabled = true;
        document.getElementsByName("documento")[0].disabled = true;
        document.getElementsByName("address")[0].disabled = true;
        document.getElementsByName("celphone")[0].disabled = true;
        document.getElementsByName("phone")[0].disabled = true;
        document.getElementsByName("email")[0].disabled = true;
        $("#clientSave").attr({disabled: true});
        $("#clientUpdate span").remove();
        $("#clientUpdate").attr({
            class:'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;
        document.getElementsByName("last_name")[0].disabled = false;
        document.getElementsByName("documento")[0].disabled = false;
        document.getElementsByName("address")[0].disabled = false;
        document.getElementsByName("phone")[0].disabled = false;
        document.getElementsByName("celphone")[0].disabled = false;
        document.getElementsByName("email")[0].disabled = false;
        $("#clientSave").attr({disabled: false});
        $("#clientUpdate span").remove();
        $("#clientUpdate").attr({
            class:'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$(document).on("blur", "#email", function (e) {
    email = document.getElementById("email").value;
    url = "/api/validate/client/email";
    if (email.indexOf(".com") > 0) {
        $.ajax({
            method: "POST",
            url: url,
            data: { 'email': email },
            success: function (res) {
                if (res != true) {
                    $(`<div class="alert alert-danger">${res}</div> <input id="vali" value="true" type="hidden"/>`).appendTo('#form-group-email');
                    $('#clientSave').attr({disabled: true});
                    var i = 0;
                    setInterval(function () {
                        i++
                        if (i > 2) {
                            $("#form-group-email .alert ").remove();
                        }
                    }, 1000)

                } else {
                    $(`<input id="vali" value="false" type="hidden"/>`).appendTo('#form-group-email');
                    document.getElementById('vali').value = false
                    $('#clientSave').attr({disabled: false});
                }
            }
        })
    }
});

$(document).on("keyup", "#password", function (e) {
    password = document.getElementById("password").value;
    $("#form-group-password .alert ").remove();
    if (password.length < 6) {
        $(`<div class="alert alert-danger">La contraseña debe ser mayor a 6 digitos</div>`).appendTo('#form-group-password');
        var i = 0;
        setInterval(function () {
            i++
            if (i > 2) {
                $("#form-group-password .alert ").remove();
                clearInterval()
            }
        }, 1000)
    } else if (password.length == 0) {
        $("#form-group-password .alert ").remove();
    } else {
        $("#form-group-password .alert ").remove();
    }
});

$(document).on("click", "#deleteclient", function(e) {
    var id = $(this).data("id");
    document.getElementById("iddelete").value = id;
});

$(document).on("click", "#deleteButton", function (e) {
    e.preventDefault()
    id = document.getElementById("iddelete").value
    $.ajax({
        method: 'GET',
        data: {'id':id},
        url: '/api/validate/client/sales'
    }).done(function(params) {
        var id_sale
        var id_vehicle
        for (let i = 0; i < params.length; i++) {
            const e = params[i];
            id_sale = e.sale
            id_vehicle = e.vehicle
        }

        if (params.length >= 1) {
            $.confirm({
                title: 'Eliminando cliente',
                content: 'Este cliente tiene ventas en curso, desea cancelarlas?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Si: {
                        text: 'Si',
                        btnClass: 'btn-green',
                        action: function(){
                            $(`<input type="hidden" name="sale" value="${id_sale}"/>
                            <input type="hidden" name="vehicle" value="${id_vehicle}"/>`).appendTo('#deleteform');
                            $("#deleteform ").submit();
                        }
                    },
                    No: {
                        text: 'No',
                        btnClass: 'btn-red',
                        action: function(){
                            toastr.info('Cliente no eliminado')
                        }
                    },
                    close: function () {
                    }
                }
            });
        } else {
            $("#deleteform ").submit();
        }

    })
})
