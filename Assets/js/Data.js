/*$(document).ready(function(){
    dataTable();
});*/

$(document).ready(function(){
    //obtenemos la fecha actual
    let f_inicio = new Date();
    let f_fin = new Date();

    //calculo de la fecha de inicio - 6 horas de la fecha actual
    f_inicio.setHours(f_inicio.getHours() - 6);
    f_inicio.setMinutes(f_inicio.getMinutes() - f_inicio.getTimezoneOffset());
    $('#f_inicio').val(f_inicio.toISOString().slice(0, 16));
    //calculo de la fecha de fin
    f_fin.setMinutes(f_fin.getMinutes() - f_fin.getTimezoneOffset());
    $('#f_fin').val(f_fin.toISOString().slice(0, 16));
});

async function obtenerDispositivos(){
    html = '';
    const http = new XMLHttpRequest();
    const url = base_url + 'Data/obtenerDispositivos';
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const datos = JSON.parse(this.responseText);
            console.log('select');
            console.log(datos);
            html += `<option value="">Seleccione un dispositivo</option>`;
            datos.forEach(element => {
                html += `<option value="${element.imei}">${element.dispositivo}</option>`;
            });
            $('#dispositivos').html(html);
        }
    }
}
function alertas(msg, icono) {
    Swal.fire({
        position: 'center',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    })
}
document.addEventListener("DOMContentLoaded", async function(){
    try {
        obtenerDispositivos();
    } catch (err) {
        alert(err);
    }
});

async function seleccionarGenset(value){
    //alert(value);

    const response = await fetch(base_url + 'Data/obtenerDatosTabla/' + value);
    const data = await response.json();
    dataTable(data);
    dataTable2(data);
}   

function dataTable(data){
    //destruir dataTable anterior para poder cargar uno nuevo
    if($.fn.DataTable.isDataTable('#tblDatos')){
        $('#tblDatos').DataTable().destroy();
        //borrar el tbody de la tabla
        $('#tblDatos tbody').remove();
    }
    const buttons = [
        {
            extend: 'excel',
            text: '<i class="ri-file-excel-2-line"></i>',
            className: 'btn btn-success',
            titleAttr: 'Exportar a Excel'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="ri-file-pdf-2-fill"></i>',
            className: 'btn btn-danger',
            titleAttr: 'Exportar a PDF',
            customize: function (doc) {
                //doc.defaultStyle.fontSize = 8;
                doc.pageOrientation = 'landscape';
                doc.pageMargins = [10,10,10,10];
                //bajar tamaño solo de la thead y no del tbody
                doc.styles.tableHeader.fontSize = 8;
            }
        },
        {
            extend: 'print',
            text: '<i class="ri-printer-line"></i>',
            className: 'btn btn-info',
            titleAttr: 'Imprimir',
            // HACER QUE LA HOJA ESTE EN ORIENTACION LANDSCAPE
            customize: function (win) {
                $(win.document.body).find('table').addClass('display').css('font-size', '9.5px');
                $(win.document.body).find('h1').css('text-align', 'center');
            }
        }
    ];
    tblDatos = $('#tblDatos').DataTable({
        pageLength: 25,
        responsive: true,
        data: data,
        columns:[
            { 'data': 'fecha_r' },
            { 'data': 'Dv_Voltage'},
            { 'data': 'Dv_Water'},
            { 'data': 'Dv_Frequency'},
            { 'data': 'Dv_Fuel'},
            { 'data': 'Rt_Voltaje2'},
            { 'data': 'Rt_Rotor'},
            { 'data': 'Rt_Field'},
            { 'data': 'velocidad'},
            { 'data': null},
            { 'data': 'Dv_rpm'},
            { 'data': 'Tr_Timer2'},
            { 'data': null},
            { 'data': 'latitud'},
            { 'data': 'longitud'},
            { 'data': 'Dv_Alarm'},
            { 'data': 'link_mapa'}
        ],
        columnDefs:[
            {
                targets: 0,
                render: function(data, type, row){
                    // data = 2024-11-25T04:05:20.459000
                    //split para separar los milisegundos
                    const fecha = data.split('T');
                    //split para separar la fecha de la hora
                    const fecha2 = fecha[0].split('-');
                    //split para separar la hora
                    const hora = fecha[1].split(':');
                    //split para separar los segundos
                    const segundos = hora[2].split('.');
                    return `${fecha2[2]}/${fecha2[1]}/${fecha2[0]} ${hora[0]}:${hora[1]}:${segundos[0]}`;
                }  
            },
            {
                targets: 9,
                render: function(data, type, row){
                    return `ON`;
                }
            },
            {
                targets: 12,
                render: function(data, type, row){
                    return ` `;
                }
            },
            {
                targets: 16,
                render: function(data, type, row){
                    return ` `;
                }
            }
        ],
        order:[
            [0, 'desc']
        ],
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons
    });
}

function dataTable2(data){
    //destruir dataTable anterior para poder cargar uno nuevo
    if($.fn.DataTable.isDataTable('#tblDatos2')){
        $('#tblDatos2').DataTable().destroy();
        //borrar el tbody de la tabla
        $('#tblDatos2 tbody').remove();
    }
    const buttons = [
        {
            extend: 'excel',
            text: '<i class="ri-file-excel-2-line"></i>',
            className: 'btn btn-success',
            titleAttr: 'Exportar a Excel'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="ri-file-pdf-2-fill"></i>',
            className: 'btn btn-danger',
            titleAttr: 'Exportar a PDF',
            customize: function (doc) {
                //doc.defaultStyle.fontSize = 8;
                doc.pageOrientation = 'landscape';
                doc.pageMargins = [10,10,10,10];
                //bajar tamaño solo de la thead y no del tbody
                doc.styles.tableHeader.fontSize = 8;
            }
        },
        {
            extend: 'print',
            text: '<i class="ri-printer-line"></i>',
            className: 'btn btn-info',
            titleAttr: 'Imprimir',
            // HACER QUE LA HOJA ESTE EN ORIENTACION LANDSCAPE
            customize: function (win) {
                $(win.document.body).find('table').addClass('display').css('font-size', '9.5px');
                $(win.document.body).find('h1').css('text-align', 'center');
            }
        }
    ];
    tblDatos2 = $('#tblDatos2').DataTable({
        pageLength: 25,
        responsive: true,
        data: data,
        columns:[
            { 'data': 'fecha_r' },
            { 'data': 'Dv_Voltage'},
            { 'data': 'Dv_Water'},
            { 'data': 'Dv_Frequency'},
            { 'data': 'Dv_Fuel'},
            { 'data': 'Rt_Voltaje2'},
            { 'data': 'Rt_Rotor'},
            { 'data': 'Rt_Field'},
            { 'data': null},
            { 'data': 'Dv_rpm'},
            { 'data': 'Tr_Timer2'},
            { 'data': null},
            { 'data': 'Dv_Alarm'},
            { 'data': null}
        ],
        columnDefs:[
            {
                targets: 0,
                render: function(data, type, row){
                    // data = 2024-11-25T04:05:20.459000
                    //split para separar los milisegundos
                    const fecha = data.split('T');
                    //split para separar la fecha de la hora
                    const fecha2 = fecha[0].split('-');
                    //split para separar la hora
                    const hora = fecha[1].split(':');
                    //split para separar los segundos
                    const segundos = hora[2].split('.');
                    return `${fecha2[2]}/${fecha2[1]}/${fecha2[0]} ${hora[0]}:${hora[1]}:${segundos[0]}`;
                }  
            },
            {
                targets: 8,
                render: function(data, type, row){
                    return `ON`;
                }
            },
            {
                targets: 11,
                render: function(data, type, row){
                    return ` `;
                }
            },
            {
                targets: 13,
                render: function(data, type, row){
                    return ` `;
                }
            }
        ],
        order:[
            [0, 'desc']
        ],
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons
    });
}

function buscarData(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const url = base_url + 'Data/DatosDispositivoPorFecha';
    const frm = document.getElementById('frmData');
    const formData = new FormData(frm);
    http.open("POST", url);
    http.send(formData);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const datos = JSON.parse(this.responseText);
            console.log(datos);
            if(datos.icon == 'success'){
                alertas(datos.msg, datos.icon);
                setTimeout(() => {
                    dataTable(datos.data);
                }, 2000);
            }else{
                alertas(datos.msg, datos.icon);
            }
        }
    }

}