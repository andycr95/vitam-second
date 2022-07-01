$('#employeeUpdate').click(function ($event) {
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled == false) {
        document.getElementsByName("first_name")[0].disabled = true;
        document.getElementsByName("last_name")[0].disabled = true;
        document.getElementsByName("password")[0].disabled = true;
        document.getElementsByName("address")[0].disabled = true;
        if (document.getElementsByName("branch")[0]) {
            document.getElementsByName("branch")[0].disabled = true;
        }
        $('#pass').attr('type', 'password')
        document.getElementsByName("email")[0].disabled = true;
        $("#employeesave").attr({ disabled: true });
        $("#employeeUpdate span").remove();
        $("#employeeUpdate").attr({
            class: 'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;
        document.getElementsByName("last_name")[0].disabled = false;
        document.getElementsByName("password")[0].disabled = false;
        document.getElementsByName("address")[0].disabled = false;
        if (document.getElementsByName("branch")[0]) {
            document.getElementsByName("branch")[0].disabled = false;
        }
        $("#employeesave").attr({ disabled: false });
        $('#pass').attr('type', 'text')
        document.getElementsByName("email")[0].disabled = false;
        $("#employeeUpdate span").remove();
        $("#employeeUpdate").attr({
            class: 'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$(document).on("click", "#deleteemployee", function (e) {
    var id = $(this).data("id");
    document.getElementById("iddelete").value = id;
});

$(document).on("click", "#asignBranch", function (e) {
    var id = $(this).data("id");
    document.getElementById("idasign").value = id;
});

$(document).on("blur", "#doc", function (e) {
    let doc = document.getElementById("doc").value;
    url = "/api/validate/document";
    if (doc.length > 6) {
        $.ajax({
            method: "POST",
            url: url,
            data: { 'documento': doc },
            success: function (res) {
                if (res != true) {
                    $(`<div class="alert alert-danger">${res}</div>`).appendTo('#form-group-document');
                    var i = 0;
                    setInterval(function () {
                        i++
                        if (i > 2) {
                            $("#form-group-document .alert ").remove();
                        }
                    }, 1000)
                }
            }
        })
    }
});

$(document).on("blur", "#email", function (e) {
    email = document.getElementById("email").value;
    url = "/api/validate/email";
    if (email.indexOf(".com") > 0) {
        $.ajax({
            method: "POST",
            url: url,
            data: { 'email': email },
            success: function (res) {
                if (res != true) {
                    $(`<div class="alert alert-danger">${res}</div>`).appendTo('#form-group-email');
                    var i = 0;
                    setInterval(function () {
                        i++
                        if (i > 2) {
                            $("#form-group-email .alert ").remove();
                        }
                    }, 4000)
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

$(document).on("click", "#deleteButton", function (e) {
    e.preventDefault()
    id = document.getElementById('iddelete').value
    $.ajax({
        method: 'GET',
        data: {'id':id},
        url: '/api/validate/employee/branchs'
    }).done(function(params) {
        for (let i = 0; i < params.length; i++) {
            const e = params[i];
            if (e.branch != null) {
                toastr.error('Este empleado administrada una sucursal')
            } else {
                $('#deleteForm').submit()
            }
        }

    })
})

$.ajax({
    method: 'GET',
    url: '/api/branchoffices'
}).done(function (params) {
    $('#select-bran').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        options: params,
        create: false,
        maxItems: 1
    });
    $('#select-branch2').selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        options: params,
        create: false,
        maxItems: 1
    });
})
