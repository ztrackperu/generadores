$(document).ready(function(){
    tblMantenimiento = $('#tblMantenimiento').DataTable({
        ajax:{
            url: base_url + 'Mantenimiento/listar',
            dataSrc: ''
        },
        columns:[
            {data: 'id'},
            {data: 'dispositivo'},
            {data: 'horometro_actual'},
            {data: 'fecha_ultimo_mantenimiento'},
            {data: 'horometro_actual'},
            {data: 'tipo_mantenimiento'},
            {data: 'acciones'}
        ],
        columnDefs:[
            {
                targets: 4,
                render: function(data, type, row){
                    //data sumarle 500
                    const horometro = parseInt(data);
                    const diferencia = 500 + horometro;

                    if(diferencia >= 500){
                        return `<span class="badge bg-success">${diferencia}</span>`;
                    }else if(diferencia >= 300 && diferencia <= 499){
                        return `<span class="badge bg-warning">${diferencia}</span>`;
                    }else{
                        return `<span class="badge bg-danger">${diferencia}</span>`;
                    }
                }
            }
        ],
        responsive:true
    });
});

$(document).ready(function(){
    //$('#modalInsercionMasiva').modal('show');
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/dispositivosParaInsertar';
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const data = JSON.parse(this.responseText);
            /*
            console.log(data);
            $('#modalInsercionMasiva').modal('show');
            $('#contenido').html(data.html);*/
            if(data.html != ''){
                $('#modalInsercionMasiva').modal('show');
                $('#contenido').html(data.html);
            }
        }
    }
});

function grabarDispositivos(e){
    e.preventDefault();
    //$('#modalInsercionMasiva').modal('hide');
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/grabarDispositivos';
    const frm = document.getElementById('frmDispositivos');
    const data = new FormData(frm);
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            console.log(res);
            alertas(res.msg, res.icono);
            //reload tabla
            tblMantenimiento.ajax.reload();
            $('#modalInsercionMasiva').modal('hide');
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

function verMantenimiento(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/verMantenimiento/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const data = JSON.parse(this.responseText);
            $('#modalHistorico').modal('show');
            dataTableHistorico(data);
        }
    }
}

function dataTableHistorico(data){
    //reinicializar
    if ($.fn.DataTable.isDataTable('#tblHistorico')) {
        $('#tblHistorico').DataTable().destroy();
    }
    tblHistorico = $('#tblHistorico').DataTable({
        data: data,
        columns:[
            {data: 'id'},
            {data: 'dispositivo'},
            {data: 'horometro_actual'},
            {data: 'tipo_mantenimiento'},
            {data: 'fecha_ultimo_mantenimiento'}
        ],
        responsive:true,
        pageLength: 5,
        order: [[0, 'desc']],
    });
}
function frmMantenimiento(){
    selectDispositivos();
    document.getElementById("title").textContent = "Nuevo Mantenimiento";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmMantenimiento").reset();
    document.getElementById("id").value = "";
    document.getElementById("tipo").innerHTML = `<option value="">Seleccione</option><option value="M1">M1</option><option value="M2">M2</option><option value="M3">M3</option><option value="M4">M4</option>`;
    const fecha = new Date();
    fecha.setMinutes(fecha.getMinutes() - fecha.getTimezoneOffset());
    $('#fecha_prx_mantenimiento').val(fecha.toISOString().slice(0, 16));
    $("#modalAgregarYEditarMantenimiento").modal("show");
}

function selectDispositivos(){
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/obtenerDispositivos';
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const data = JSON.parse(this.responseText);
            let html = '<option value="">Seleccione un dispositivo</option>';
            data.forEach(row => {
                html += `<option value="${row.dispositivo}">${row.dispositivo}</option>`;
            });
            document.getElementById("dispositivo").innerHTML = html;
        }
    }
}

function registrarMantenimiento(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/registrar';
    const frm = document.getElementById('frmMantenimiento');
    const data = new FormData(frm);
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            $("#modalAgregarYEditarMantenimiento").modal("hide");
            tblMantenimiento.ajax.reload();
            alertas(res.msg, res.icono);
            frm.reset();
            console.log(res);
        }
    }
}

function editarMantenimiento(id){
    document.getElementById("title").textContent = "Actualizar Mantenimiento";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + 'Mantenimiento/editar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            console.log(res);
            $("#modalAgregarYEditarMantenimiento").modal("show");
            document.getElementById("id").value = res.id;
            document.getElementById("dispositivo").innerHTML = `<option value="${res.dispositivo}">${res.dispositivo}</option>`;
            document.getElementById("horometro").value = res.horometro_actual;
            document.getElementById("tipo").innerHTML = `<option value="${res.tipo_mantenimiento}">${res.tipo_mantenimiento}</option>`;
            //document.getElementById("fecha_prx_mantenimiento").value = res.fecha_ultimo_mantenimiento;
            const fecha = new Date(res.fecha_ultimo_mantenimiento);
            fecha.setMinutes(fecha.getMinutes() - fecha.getTimezoneOffset());
            $('#fecha_prx_mantenimiento').val(fecha.toISOString().slice(0, 16));

            
        }
    }
}

function eliminarMantenimiento(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/eliminar/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            tblMantenimiento.ajax.reload();
            alertas(res.msg, res.icono);
        }
    }
}

function reingresarMantenimiento(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Mantenimiento/reingresar/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            tblMantenimiento.ajax.reload();
            alertas(res.msg, res.icono);
        }
    }
}
