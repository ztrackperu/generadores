let tblAlarmas, tblMensajes;

document.addEventListener('DOMContentLoaded', function () {
    cargarTablaAlarmas();
    cargarTablaMensajes();
});

// ── ALARMAS ──────────────────────────────────────────────

function cargarTablaAlarmas() {
    if ($.fn.DataTable.isDataTable('#tblAlarmas')) {
        $('#tblAlarmas').DataTable().destroy();
    }
    tblAlarmas = $('#tblAlarmas').DataTable({
        ajax: { url: base_url + 'Catalogos/listarAlarmas', dataSrc: '' },
        columns: [
            { data: 'CODIGO' },
            { data: 'NOMBRE' },
            { data: 'estado_badge' },
            { data: 'acciones' }
        ],
        order: [[0, 'asc']],
        responsive: true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
    });
}

function nuevaAlarma() {
    limpiarModal('alarma', 'Nueva Alarma');
    $('#modalCatalogo').modal('show');
}

function verAlarma(id) {
    fetchCatalogo('Catalogos/getAlarma/' + id, 'alarma', 'Detalle de Alarma', true);
}

function editarAlarma(id) {
    fetchCatalogo('Catalogos/getAlarma/' + id, 'alarma', 'Editar Alarma', false);
}

function toggleAlarma(id, estado) {
    toggleCatalogo('Catalogos/toggleAlarma', id, estado, tblAlarmas);
}

// ── MENSAJES ─────────────────────────────────────────────

function cargarTablaMensajes() {
    if ($.fn.DataTable.isDataTable('#tblMensajes')) {
        $('#tblMensajes').DataTable().destroy();
    }
    tblMensajes = $('#tblMensajes').DataTable({
        ajax: { url: base_url + 'Catalogos/listarMensajes', dataSrc: '' },
        columns: [
            { data: 'CODIGO' },
            { data: 'NOMBRE' },
            { data: 'estado_badge' },
            { data: 'acciones' }
        ],
        order: [[0, 'asc']],
        responsive: true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
    });
}

function nuevoMensaje() {
    limpiarModal('mensaje', 'Nuevo Mensaje');
    $('#modalCatalogo').modal('show');
}

function verMensaje(id) {
    fetchCatalogo('Catalogos/getMensaje/' + id, 'mensaje', 'Detalle de Mensaje', true);
}

function editarMensaje(id) {
    fetchCatalogo('Catalogos/getMensaje/' + id, 'mensaje', 'Editar Mensaje', false);
}

function toggleMensaje(id, estado) {
    toggleCatalogo('Catalogos/toggleMensaje', id, estado, tblMensajes);
}

// ── COMPARTIDO ───────────────────────────────────────────

function fetchCatalogo(url, tipo, titulo, soloLectura) {
    const http = new XMLHttpRequest();
    http.open('GET', base_url + url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById('cat_id').value          = res.id;
            document.getElementById('cat_tipo').value        = tipo;
            document.getElementById('cat_codigo').value      = res.CODIGO;
            document.getElementById('cat_nombre').value      = res.NOMBRE;
            document.getElementById('cat_tipo_causa').value  = res.TIPO_CAUSA;
            document.getElementById('cat_diagnostico').value = res.DIAGNOSTICO;
            document.getElementById('modalCatalogoTitulo').textContent = titulo;

            // Solo lectura en modo ver
            const campos = ['cat_codigo','cat_nombre','cat_tipo_causa','cat_diagnostico'];
            campos.forEach(id => {
                document.getElementById(id).readOnly = soloLectura;
            });
            document.getElementById('btnGuardarCatalogo').style.display = soloLectura ? 'none' : 'inline-block';

            $('#modalCatalogo').modal('show');
        }
    };
}

function limpiarModal(tipo, titulo) {
    document.getElementById('frmCatalogo').reset();
    document.getElementById('cat_id').value   = '';
    document.getElementById('cat_tipo').value = tipo;
    document.getElementById('modalCatalogoTitulo').textContent = titulo;
    ['cat_codigo','cat_nombre','cat_tipo_causa','cat_diagnostico'].forEach(id => {
        document.getElementById(id).readOnly = false;
    });
    document.getElementById('btnGuardarCatalogo').style.display = 'inline-block';
}

function guardarCatalogo() {
    const tipo = document.getElementById('cat_tipo').value;
    const url  = tipo === 'alarma' ? 'Catalogos/guardarAlarma' : 'Catalogos/guardarMensaje';
    const frm  = document.getElementById('frmCatalogo');
    const http = new XMLHttpRequest();
    http.open('POST', base_url + url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertas(res.msg, res.icono);
            if (res.icono === 'success') {
                $('#modalCatalogo').modal('hide');
                tipo === 'alarma' ? tblAlarmas.ajax.reload() : tblMensajes.ajax.reload();
            }
        }
    };
}

function toggleCatalogo(url, id, estado, tabla) {
    const accion = estado == 1 ? 'activar' : 'desactivar';
    Swal.fire({
        title: `¿${accion.charAt(0).toUpperCase() + accion.slice(1)} este registro?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then(result => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('estado', estado);
            const http = new XMLHttpRequest();
            http.open('POST', base_url + url, true);
            http.send(formData);
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    if (res.icono === 'success') tabla.ajax.reload();
                }
            };
        }
    });
}