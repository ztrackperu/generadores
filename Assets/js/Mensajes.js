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
    tblMensajes = $('#tblMensajes').DataTable({
        ajax: {
            url: base_url + "Mensajes/getMensajes",
            dataSrc: ""
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

function frmMensaje(){
    document.getElementById("title").textContent = "Nuevo Mensaje";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmMensaje").reset();
    document.getElementById("id").value = "";
    $("#modalAgregarYeditarMensaje").modal("show");
}

function registrarMensaje(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const form = document.getElementById("frmMensaje");
    const data = new FormData(form);
    const url = base_url + "Mensajes/registrarMensaje";
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            $("#modalAgregarYeditarMensaje").modal("hide");
            form.reset();
            tblMensajes.ajax.reload();
            alertas(res.msg, res.icono);
        }
    }
}

function editarMensajeModal(id) {
    document.getElementById("title").textContent = "Actualizar Receta";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Mensajes/editar/" + id;
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

            $("#modalAgregarYeditarMensaje").modal("show");
        }
    }
}

function eliminarMensajeModal(id){
    const http = new XMLHttpRequest();
    const url = base_url + "Mensajes/eliminarMensajeModal/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalEliminarMensaje").modal("show");
            $("#deleteMensaje").html(datos.text);
        }
    }
}
function verMensajeModal(id){
    const http = new XMLHttpRequest();
    const url = base_url + "Mensajes/getMensaje/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalVerMensaje").modal("show");
            $("#viewMensaje").html(datos.text);
        }
    }
}

function eliminarMensaje(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Mensajes/eliminarMensaje/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalEliminarMensaje").modal("hide");
            alertas(datos.msg, datos.icono);
            //recargar la tabla
            tblMensajes.ajax.reload();
        }
    }
}

function reingresarMensaje(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Mensajes/reingresarMensaje/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            alertas(datos.msg, datos.icono);
            //recargar la tabla
            tblMensajes.ajax.reload();
        }
    }
}