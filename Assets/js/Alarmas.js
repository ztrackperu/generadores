function alertas(msg, icono) {
    Swal.fire({
        position: 'center',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    })
}

$(document).ready(function(){
    //datatable
    tblAlarmas = $('#tblAlarmas').DataTable({
        ajax: {
            url: base_url + "Alarmas/getAlarmas",
            dataSrc: ''
        },
        columns: [
            { "data": "id" },
            { "data": "CODIGO" },
            { "data": "NOMBRE" },
            { "data": "TIPO_CAUSA" },
            { "data": "DIAGNOSTICO" },
            { "data": "acciones"}
        ],
        responsive: true
    });
});

function frmAlarma(){
    document.getElementById("title").textContent = "Nueva Alarma";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmAlarma").reset();
    document.getElementById("id").value = "";
    $("#modalAgregarYeditarAlarma").modal("show");
}

function registrarAlarma(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const form = document.getElementById("frmAlarma");
    const data = new FormData(form);
    const url = base_url + "Alarmas/registrarAlarma";
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            $("#modalAgregarYeditarAlarma").modal("hide");
            form.reset();
            tblAlarmas.ajax.reload();
            alertas(res.msg, res.icono);
        }
    }
}

function editarAlarmaModal(id) {
    document.getElementById("title").textContent = "Actualizar Receta";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Alarmas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("codigo").value = res.CODIGO;
            document.getElementById("nombre").value = res.NOMBRE;
            document.getElementById("tipo_causa").value = res.TIPO_CAUSA;   
            document.getElementById("diagnostico").value = res.DIAGNOSTICO;             

            $("#modalAgregarYeditarAlarma").modal("show");
        }
    }
}

function eliminarAlarmaModal(id){
    const http = new XMLHttpRequest();
    const url = base_url + "Alarmas/eliminarAlarmaModal/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalEliminarAlarma").modal("show");
            $("#deleteAlarma").html(datos.text);
        }
    }
}
function verAlarmaModal(id){
    const http = new XMLHttpRequest();
    const url = base_url + "Alarmas/getAlarma/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalVerAlarma").modal("show");
            $("#viewAlarma").html(datos.text);
        }
    }
}

function eliminarAlarma(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Alarmas/eliminarAlarma/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalEliminarAlarma").modal("hide");
            alertas(datos.msg, datos.icono);
            //recargar la tabla
            tblAlarmas.ajax.reload();
        }
    }
}

function reingresarAlarma(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Alarmas/reingresarAlarma/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            alertas(datos.msg, datos.icono);
            //recargar la tabla
            tblAlarmas.ajax.reload();
        }
    }
}