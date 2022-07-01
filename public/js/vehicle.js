$(document).on("click", "#deletevehicle", function (e) {
    var id = $(this).data("id");
    document.getElementById("id").value = id;
    var state = $(this).data("state");
    document.getElementById("state").value = state;
});

$('#vehicleUpdate').click(function ($event) {
    $event.preventDefault();

    if (document.getElementsByName("placa")[0].disabled == false) {
        document.getElementsByName("placa")[0].disabled = true;
        document.getElementsByName("model")[0].disabled = true;
        document.getElementsByName("color")[0].disabled = true;
        document.getElementsByName("motor")[0].disabled = true;
        document.getElementsByName("fee")[0].disabled = true;
        document.getElementsByName("branchoffice")[0].disabled = true;
        document.getElementsByName("amount")[0].disabled = true;
        document.getElementsByName("investor")[0].disabled = true;
        document.getElementsByName("chasis")[0].disabled = true;
        $("#vehicleSave").attr({ disabled: true });
        $("#vehicleUpdate span").remove();
        $("#vehicleUpdate").attr({
            class: 'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("placa")[0].disabled = false;
        document.getElementsByName("model")[0].disabled = false;
        document.getElementsByName("color")[0].disabled = false;
        document.getElementsByName("investor")[0].disabled = false;
        document.getElementsByName("branchoffice")[0].disabled = false;
        document.getElementsByName("motor")[0].disabled = false;
        document.getElementsByName("amount")[0].disabled = false;
        document.getElementsByName("fee")[0].disabled = false;
        document.getElementsByName("chasis")[0].disabled = false;
        $("#vehicleSave").attr({ disabled: false });
        $("#vehicleUpdate span").remove();
        $("#vehicleUpdate").attr({
            class: 'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$(document).on("click", "#editvehicle", function (e) {
    var id = $(this).data("id");
    var placa = $(this).data("placa");
    var motor = $(this).data("motor");
    var model = $(this).data("model");
    var fee = $(this).data("fee");
    var chasis = $(this).data("chasis");
    var investor = $(this).data("investor");
    var color = $(this).data("color");
    var nameinv = $(this).data("nameinv");
    var type = $(this).data("type");
    var nametype = $(this).data("nametype");
    var Br = $(this).data("branchid");
    var nameBr = $(this).data("branchname");
    var amount = $(this).data("amount");
    $('#editForm').append(`<input name="id" id="id" value="${id}" type="hidden"/>`);
    document.getElementById("placa").value = placa;
    document.getElementById("color").value = color;
    document.getElementById("model").value = model;
    document.getElementById("motor").value = motor;
    document.getElementById("fee").value = fee;
    document.getElementById("chasis").value = chasis;
    if (amount != '') {
        document.getElementById("amount").value = amount;
    } else {
        document.getElementById("amount").value = 365;
    }
    document.getElementById("optionInv").value = investor;
    $('#editForm #optionInv').append(`${nameinv}`);

    document.getElementById("optionTyp").value = type;
    $('#editForm #optionTyp').append(`${nametype}`);

    document.getElementById("optionBr").value = Br;
    $('#editForm #optionBr').append(`${nameBr}`);
});

$(document).on("change", "#type_id", function (e) {
    var type = document.getElementById("type_id").value;
    if (type > 1) {
        $("#groupAmount .nono").remove();
        $("#groupAmount .form-control").remove();
        $("#groupAmount").append(`<label class="nono" for="amount"><strong>Cantidad de dias</strong></label> <input class="form-control" type="text" id="amount" name="amount" placeholder="365" required/>`);
    } else {
        $("#groupAmount .nono").remove();
        $("#groupAmount .form-control").remove();
        $("#groupAmount").append(`<input class="form-control" type="hidden" id="amount" value="365" name="amount" placeholder="365" required/>`);
    }
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

$(document).on("blur", "#placa", function (e) {
    placa = document.getElementById("placa").value;
    url = "/api/validate/vehicle";
        $.ajax({
            method: "GET",
            url: url,
            data: { 'placa': placa },
            success: function (res) {
                if (res != true) {
                    toastr.error(res.placa)
                    $('#vehicleSave').attr({disabled: true});
                } else {
                    $('#vehicleSave').attr({disabled: false});
                }
            }
        })
});

$(document).on("blur", "#chasis", function (e) {
    chasis = document.getElementById("chasis").value;
    url = "/api/validate/vehicle";
        $.ajax({
            method: "GET",
            url: url,
            data: { 'chasis': chasis },
            success: function (res) {
                if (res != true) {
                    toastr.error(res.chasis)
                    $('#vehicleSave').attr({disabled: true});
                } else {
                    $('#vehicleSave').attr({disabled: false});
                }
            }
        })
});

$(document).on("blur", "#motor", function (e) {
    motor = document.getElementById("motor").value;
    url = "/api/validate/vehicle";
        $.ajax({
            method: "GET",
            url: url,
            data: { 'motor': motor },
            success: function (res) {
                if (res != true) {
                    toastr.error(res.motor)
                    $('#vehicleSave').attr({disabled: true});
                } else {
                    $('#vehicleSave').attr({disabled: false});
                }
            }
        })
});

$.ajax({
    method: 'GET',
    url: '/api/investors'
}).done(function (params) {
    investors = []
    for (let i = 0; i < params.length; i++) {
        const e = params[i];
        e.name = e.name + " " + e.last_name
        investors.push(e)
    }
    $('#select-investor').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        options: investors,
        create: false,
        maxItems: 1
    });
})

$(document).on("click", "#deleteButton", function (e) {
    e.preventDefault()
    id = document.getElementById('id').value
    state = document.getElementById("state").value;
    if (state == 0) {
        toastr.info('Este vehiculo se encuentra en proceso de venta')
    } else {
        $('#deleteform').submit()
    }
})
