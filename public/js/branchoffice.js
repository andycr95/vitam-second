$('#branchUpdate').click(function ($event) {
    $event.preventDefault();

    if (document.getElementsByName("first_name")[0].disabled == false) {
        document.getElementsByName("first_name")[0].disabled = true;
        document.getElementsByName("encargado")[0].disabled = true;
        document.getElementsByName("address")[0].disabled = true;
        document.getElementsByName("city")[0].disabled = true;
        $("#branchSave").attr({ disabled: true });
        $("#branchUpdate span").remove();
        $("#branchUpdate").attr({
            class: 'btn btn-info btn-sm'
        }).append('<span>Actualizar</span>');
    } else {
        document.getElementsByName("first_name")[0].disabled = false;
        document.getElementsByName("encargado")[0].disabled = false;
        document.getElementsByName("address")[0].disabled = false;
        document.getElementsByName("city")[0].disabled = false;
        $("#branchSave").attr({ disabled: false });
        $("#branchUpdate span").remove();
        $("#branchUpdate").attr({
            class: 'btn btn-danger btn-sm'
        }).append('<span>Cancelar</span>');
    }
})

$('#branchSave').click(function ($event) {
    $event.preventDefault();
    var e = document.getElementsByName("encargado")[0].value;
    var id = $(this).data("id");
    if (e != id) {
        $.confirm({
            title: 'Actualizando sucursal',
            content: 'Desea que el usuario encargado ya no pertenezca a esta sucursal?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                Si: {
                    text: 'Si',
                    btnClass: 'btn-green',
                    action: function(){
                        $(`<input type="hidden" name="change" value="1"/>`).appendTo('#updateBranchofficeForm');
                        $('#updateBranchofficeForm').submit()
                    }
                },
                No: {
                    text: 'No',
                    btnClass: 'btn-red',
                    action: function(){
                        $('#updateBranchofficeForm').submit()
                    }
                },
                close: function () {
                }
            }
        });
    } else {
        $('#updateBranchofficeForm').submit()
    }

})


$(document).on("click", "#deletebranch", function (e) {
    var id = $(this).data("id");
    document.getElementById("iddelete").value = id;
});

$(document).on("click", "#deleteButton", function (e) {
    e.preventDefault()
    id = document.getElementById('iddelete').value
    $.ajax({
        method: 'GET',
        data: {'id':id},
        url: '/api/validate/branchoffice'
    }).done(function(params) {
        for (let i = 0; i < params.length; i++) {
            const e = params[i];
            if (e.employees.length > 1 & e.vehicles.length > 0) {
                toastr.error('Esta sucursal tiene empleados y vehiculos asociados')
            } else if (e.employees.length > 1) {
                toastr.error('Esta sucursal tiene empleados asociados')
            } else if (e.vehicles.length > 0) {
                toastr.error('Esta sucursal tiene vehiculos asociados')
            } else if (e.employees.length <= 1) {
                $('#deleteform').submit()
            } else {
                $('#deleteForm').submit()
            }
        }
    })
})

function validate() {
    const employees = document.getElementById('employees').value
    if (employees < 1) {
        $("#save").attr("disabled", true);
    }
}

validate()

$("#save").click(function (event) {
    const employee_id = document.getElementById('employee_id').value
    const city_id = document.getElementById('city_id').value
    event.preventDefault()
    if (city_id == "#") {
        toastr.error('Debe seleccionar una ciudad')
    } else if(employee_id == '#'){
        toastr.error('Debe seleccionar un empleado')
    } else {
        $("#createBranch").submit()
    }
})
