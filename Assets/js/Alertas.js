

$(document).ready(function(){
    tblAlertas = $('#tblAlertas').DataTable({
        ajax: {
            url: base_url + 'Alertas/getAlertas',
            dataSrc: ""
        },
        columns: [
            { "data": "generador" },
            { "data": "fecha" },
            { "data": "codigo" },
            { "data": "detalle" },
            { "data": "tipo" },
            { "data": "codigo" }
        ],
        columnDefs: [
            {
                targets: 5,
                render: function(data, type, row){
                    return '<button type="button" class="btn btn-primary" onclick="mostrarAlerta(' + data + ')"><i class="ri-eye-fill"></i></button>';
                }
            }
        ],
        responsive: true
    });
});

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


function mostrarAlerta(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Alertas/mostrarDefCodigo/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const datos = JSON.parse(this.responseText);
            $('#contentDefCodigo').html(datos.text);
            $('#modalDefCodigo').modal('show');
        }
    }
}

function buscarAlerta(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const url = base_url + 'Alertas/buscarAlerta';
    const form = document.getElementById('frmAlertas');
    const data = new FormData(form);
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            console.log(res);
        }
    }
}