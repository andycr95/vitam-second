$(document).on("change", "#type_report_c_i", function (e) {
    type = e.target.value;
    $('#form-control-i-c').remove();
    $('#name_type_report').remove();
    $('#type_report_t').remove();
    $('#form-control-t').remove();
    if (type == '2') {
        $(`<div class="form-group" id="form-control-i-c"></div>`).appendTo('#form-control-i-t');
        $(`<div class="form-group" id="form-control-t"></div>`).appendTo('#form-control-i-t');
        $(`<div class="form-row"> <div class="col"> <label id="name" for="amount"><strong>Mes</strong></label> <input id="datepicker" autocomplete="off" name="month" class="form-control" placeholder="Seleccione una fecha..." /></div></div>`).appendTo('#form-control-t');
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekHeader: 'Sm',
            dateFormat: 'mm',
            firstDay: 1,
            isRTL: false,
            maxDate: "0",
            minDate: new Date(2020, 2, 10),
            showMonthAfterYear: false,
            yearSuffix: ''
            };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $("#datepicker").datepicker();
        $.ajax({
            method: 'GET',
            url: '/api/investors'
        }).done(function (params) {
            $(`<label id="name" for="amount"><strong>Inversionista</strong></label>
            <select id="investor_id" name="investor_id" placeholder="Seleccione una opción..."></select>`).appendTo('#form-control-i-c');
            $('#investor_id').selectize({
                maxItems: null,
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                options: params,
                create: false,
                maxItems: 1
            });
        })
    } else {
        $(`<label id="name_type_report">Tipo de reporte - Tiempo</label>
        <select class="form-control" name="type_report_t" id="type_report_t">
            <option value="#">Seleccione una opcion</option>
            <option value="1">Diario</option>
            <option value="2">Semanal</option>
            <option value="3">Mensual</option>
        </select>`).appendTo('#form_type_report_c_i');
    }
});

$(document).on("change", "#type_report_t", function (e) {
    type = e.target.value;
    $('#form-control-t').remove();
    $(`<div class="form-group" id="form-control-t"></div>`).appendTo('#form-control-i-t');
    if (type == 2) {
        $(`
        <div class="form-row">
        <div class="col">
                <label id="name" for="amount"><strong>Fecha inicio</strong></label>
                <input id="datepicker" autocomplete="off" name="dateinit" class="form-control" placeholder="Seleccione una fecha..." />
            </div>
            <div class="col">
                <label id="name" for="amount"><strong>Fecha fin</strong></label>
                <input id="datepicker2" autocomplete="off" name="dateend" class="form-control" placeholder="Seleccione una fecha..." />
            </div>
        </div>`
        ).appendTo('#form-control-t');
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            maxDate: "0",
            minDate: new Date(2020, 2, 10),
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
        $("#datepicker").datepicker();
        $("#datepicker2").datepicker();
    } else if(type == 3) {
        $(`
        <div class="form-row">
            <div class="col">
                <label id="name" for="amount"><strong>Mes</strong></label>
                <input id="datepicker" autocomplete="off" name="month" class="form-control" placeholder="Seleccione un mes..." />
            </div>
        </div>`
        ).appendTo('#form-control-t');
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekHeader: 'Sm',
            dateFormat: 'mm-yy',
            firstDay: 1,
            isRTL: false,
            maxDate: "0",
            minDate: new Date(2020, 2, 10),
            showMonthAfterYear: false,
            yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
        $("#datepicker").datepicker();
    } else {
        $(`
        <div class="form-row">
            <div class="col">
                <label id="name" for="amount"><strong>Dia</strong></label>
                <input id="datepicker" autocomplete="off" name="day" class="form-control" placeholder="Seleccione un dia..." />
            </div>
        </div>`
        ).appendTo('#form-control-t');
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            maxDate: "0",
            minDate: new Date(2020, 2, 10),
            showMonthAfterYear: false,
            yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
        $("#datepicker").datepicker();
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
