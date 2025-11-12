$(document).ready(function() {  
    const http = new XMLHttpRequest();
    const url = base_url + 'Perfil/getPerfil';
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            console.log(res);
            $('#contenidoPerfil').html(res.html);
        }
    }
});
function editarCampo(campoId) {
   const input = document.getElementById(campoId);
   //obtiene el boton que se encuentra al lado del campo
   const button  = input.nextElementSibling

   if (input.disabled) {
        //habilita el campo
       input.disabled = false;
        //añade el icono de check
       button.innerHTML = '<i class="ri-check-fill text-secondary fs-6"></i>';
       //si se hace click en el boton se guarda el campo
       button.onclick = function() { guardarCampo(campoId); };
   }
}

function guardarCampo(campoId) {
    const input = document.getElementById(campoId);
    const button = input.nextElementSibling;
    const valor = input.value;
    console.log(valor);
    /*
    const http = new XMLHttpRequest();
    const url = base_url + 'Perfil/updateCampo';
    http.open("POST", url, true);

    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Deshabilitar el campo y cambiar el icono del botón a editar
            input.disabled = true;
            button.innerHTML = '<i class="ri-pencil-fill text-secondary fs-6"></i>';
            button.onclick = function() { editarCampo(campoId); };
        }
    }*/
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

$(document).ready(function(){
    //datatable
    tblPerfiles = $('#tblPerfiles').DataTable({
        ajax: {
            url: base_url + "Perfil/getPerfiles",
            dataSrc: ''
        },
        columns: [
            { "data": "id" },
            { "data": "usuario" },
            { "data": "nombre" },
            { "data": "apellido" },
            { "data": "correo" },
            { "data": "ruc"},
            { "data": "empresa"},
            { "data": "acciones"}
        ],
        responsive: true
    });
});

function frmPerfil(){
    document.getElementById("title").textContent = "Nuevo Perfil";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmPerfil").reset();
    document.getElementById("id").value = "";
    $("#modalAgregarYeditarPerfil").modal("show");
}

function registrarPerfil(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const form = document.getElementById("frmPerfil");
    const data = new FormData(form);
    const url = base_url + "Perfil/registrarPerfil";
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            $("#modalAgregarYeditarPerfil").modal("hide");
            form.reset();
            tblPerfiles.ajax.reload();
            alertas(res.msg, res.icono);
        }
    }
}

function editarPerfilModal(id) {
    document.getElementById("title").textContent = "Actualizar Perfil";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Perfil/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("usuario").value = res.usuario;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("apellido").value = res.apellido;   
            document.getElementById("correo").value = res.correo;      
            document.getElementById("ruc").value = res.ruc;             
            document.getElementById("empresa").value = res.empresa;             
            $("#modalAgregarYeditarPerfil").modal("show");
        }
    }
}

function eliminarPerfilModal(id){
    const http = new XMLHttpRequest();
    const url = base_url + "Perfil/eliminarPerfilModal/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalEliminarPerfil").modal("show");
            $("#deletePerfil").html(datos.text);
        }
    }
}
function verPerfilModal(id){
    const http = new XMLHttpRequest();
    const url = base_url + "Perfil/visualizarPerfil/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalVerPerfil").modal("show");
            $("#viewPerfil").html(datos.text);
        }
    }
}

function eliminarPerfil(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Perfil/eliminarPerfil/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            $("#modalEliminarPerfil").modal("hide");
            alertas(datos.msg, datos.icono);
            //recargar la tabla
            tblPerfiles.ajax.reload();
        }
    }
}

function reingresarPerfil(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'Perfil/reingresarPerfil/' + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let datos = JSON.parse(this.responseText);
            alertas(datos.msg, datos.icono);
            //recargar la tabla
            tblPerfiles.ajax.reload();
        }
    }
}