let contenidoPrincipal = document.getElementById('contenidoPrincipal');
let modalComando = 1;
//$('.dropdown-toggle').dropdown()

function mostrarMasContenido(){
    $('.view-more').click(function(){   
        $('.hide-content').attr('hidden', false);
        let btn = "<i class='ri-arrow-up-circle-line view-less text-danger fs-2'></i>";
        $('#change-button').html(btn);
    });
}

function mostrarMenosContenido(){
    $('.view-less').click(function(){   
        $('.hide-content').attr('hidden', true);
        let btn = "<button type='button' class='btn btn-primary btn-sm view-more'>View More</button>";
        $('#change-button').html(btn);
    });
}
/*
function mostrarContenido(){
    let btnVMore = $('.view-more');
    let classP = btnVMore[0];

    let comparar = classP.className;

    if(comparar.includes('btn btn-primary view-more')){
        $('.hide-content').attr('hidden', false);

        btnVMore.removeClass('btn btn-primary view-more');
        btnVMore.addClass('btn btn-primary view-less');

    }else{
        btnVMore.removeClass('btn btn-primary view-less');
        btnVMore.addClass('btn btn-primary view-more');
        $('.hide-content').attr('hidden', true);
    }
}*/

document.addEventListener("DOMContentLoaded", async function(){
    
    try{
        const response = await fetch(base_url + "AdminPage/ListaDispositivoEmpresa",{method: 'GET'});
        const data = await response.json();
        console.log('ERRO');
        console.log(data);
        contenidoPrincipal.innerHTML  =data.text;
        graficoPastel();
        graficoBarra();
        dataTableGenset();
        MapaLeaflet();
        alarmaModal();
        mensajeModal();
        horasModal();
        //mostrarMenosContenido();
        mostrarMasContenido();
        
    
    }catch(err){alert(err);}
    
    //cada 10 segundos ejecutar 
    //setInterval( async function(){ okey =  await obtenerCambio();}, 30000);
    //setInterval( async function(){ tst =  await mostrarMenosContenido();}, 1000);
    //setInterval( async function(){ tst2 =  await mostrarMasContenido();}, 1000);

})
/*
$(document).ready(function(){
    graficoPastel();
    graficoBarra();
    dataTableGenset();
    MapaLeaflet();
});*/



function graficoPastel(){
    const http = new XMLHttpRequest();
    const url = base_url + 'AdminPage/GraficaEncendidoApagado';
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            console.log('DATO')
            console.log(res);
            let ctx = document.getElementById('gBarra').getContext('2d');
            let myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ON', 'OFF'],
                    datasets: [{
                        label: 'Estado',
                        data: [res.on, res.off],
                        backgroundColor: [
                            'rgba(0, 255, 0, 0.2)',
                            'rgba(255, 0, 0, 0.2)',
                        ],
                        borderColor: [
                            'rgba(0, 255, 0, 1)',
                            'rgba(255, 0, 0, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            display: false
                        }
                    },
                    responsive: false
                }
            });
            myChart.update();
        }
    }
}

function graficoBarra(){
    const http = new XMLHttpRequest();
    const url = base_url + 'AdminPage/GraficaUltimos3Dias';
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            //dos arrays fechas y datos
            let ctx = document.getElementById('gPastel').getContext('2d');
            let myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.fechas,
                    datasets: [{
                        label: 'Datos de los últimos 3 días',
                        data: res.datos,
                        backgroundColor: [
                            'rgba(0, 255, 0, 0.2)',
                            'rgba(255, 0, 0, 0.2)',
                            'rgba(0, 0, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(0, 255, 0, 1)',
                            'rgba(255, 0, 0, 1)',
                            'rgba(0, 0, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            display: false
                        },
                        x:{
                            display: true
                        }
                    },
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins:{
                        legend:{
                            display:true,
                        },
                        datalabels:{
                            color: 'black',
                            anchor: 'end',
                            align: 'start',
                            offset: 4,
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            });
            myChart.update();
        }
    }
}

function alarmaModal(){
    let alarma = document.querySelector('#alarmaModal');
    alarma.addEventListener('click', function(){
        //$('#modalAlarma').modal('show');
        const http = new XMLHttpRequest();
        const url = base_url + "AdminPage/listaAlarmas";
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                $('#modalAlarma').modal('show');
                dataTableAlarma(res);
            }
        }
    });
}

function dataTableAlarma(data){
    //reinicializar
    if ($.fn.DataTable.isDataTable('#tblAlarma')) {
        $('#tblAlarma').DataTable().destroy();
    }
    tblAlarma = $('#tblAlarma').DataTable({
        data: data,
        columns: [
            {data: "id"},
            {data: "fecha"},
            {data: "codigo"},
            {data: "alarma"},
            {data: "equipo"},
            {data: "acciones"}
        ],
        responsive: true
    });
}

function eliminarAlarma(){
    $('#tblAlarma tbody').on('click', 'button.eliminar', function(){
        tblAlarma.row($(this).parents('tr')).remove().draw();
    });
}

function mensajeModal(){
    let mensaje = document.querySelector('#mensajeModal');
    mensaje.addEventListener('click', function(){
        //$('#modalMensaje').modal('show');
        const http = new XMLHttpRequest();
        const url = base_url + "AdminPage/listaMensajes";
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                $('#modalMensaje').modal('show');
                dataTableMensaje(res);
            }
        }
    });
}

function dataTableMensaje(data){
    //reinicializar
    if ($.fn.DataTable.isDataTable('#tblMensaje')) {
        $('#tblMensaje').DataTable().destroy();
    }
    tblMensaje = $('#tblMensaje').DataTable({
        data: data,
        columns: [
            {data: "id"},
            {data: "fecha"},
            {data: "codigo"},
            {data: "mensaje"},
            {data: "equipo"},
            {data: "acciones"}
        ],
        responsive: true
    });
}
function eliminarMensaje(){
    $('#tblMensaje tbody').on('click', 'button.eliminar', function(){
        tblMensaje.row($(this).parents('tr')).remove().draw();
    });
}

function horasModal(){
    let horas = document.querySelector('#horasModal');
    horas.addEventListener('click', function(){
        //$('#modalHoras').modal('show');
        const http = new XMLHttpRequest();
        const url = base_url + "AdminPage/listaHoras";
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                $('#modalHoras').modal('show');
                dataTableHoras(res);
            }
        }
    });
}

function dataTableHoras(data){
    //reinicializar
    if ($.fn.DataTable.isDataTable('#tblHoras')) {
        $('#tblHoras').DataTable().destroy();
    }
    tblHoras = $('#tblHoras').DataTable({
        data: data,
        columns: [
            {data: "id"},
            {data: "desde"},
            {data: "h_actual"},
            {data: "duracion"},
            {data: "acciones"},
        ],
        responsive: true
    });
}

function eliminarHoras(){
    $('#tblHoras tbody').on('click', 'button.eliminar', function(){
        tblHoras.row($(this).parents('tr')).remove().draw();
    });
}

function dataTableGenset(){
    tblGenset = $('#tblGenset').DataTable({
        //pageLength: 8,
        ajax: {
            url: base_url + "AdminPage/ListaDeGraficos",
            dataSrc: ''
        },
        columns: [
            { 'data': 'id'},
            { 'data': null},
            { 'data': 'descripcion'},
            { 'data' : 'fecha_r'},
            { 'data': 'Tr_Timer2'},
            { 'data': 'Dv_Alarm'},
            { 'data': 'Dv_Fuel'}
        ],
        columnDefs: [
            {
                targets: 1,
                render: function(data, type, row){
                    //return `<div class='d-flex justify-content-center align-items-center'><span>${data}</span><button type='button' class='btn btn-primary-outline btn-sm' onclick='detallesContenedor(${data})'><i class='bi bi-eye-fill text-secondary'></i></button></div>`;
                    return `<div class='d-flex justify-content-center align-items-center gap-1'>
                                <p>${row.imei}</p>
                                <button type='button' class='btn btn-primary-outline btn-sm' onclick='detallesContenedor(${row.config})'><i class='bi bi-eye-fill text-secondary'></i></button>
                            </div>`;
                }
            },
            /*

            {
                targets: 3,
                //render doughnut
                render: function(data, type, row){
                    //return `<div class='d-flex justify-content-center' style='display:block;margin:0 auto;'><canvas style='margin:0;' id='gDoughnut${data.id}' width='100' height='100'></canvas></div>`;
                    let badgeClass= '';
                    if (data == 1) {
                        badgeClass = 'bg-success';
                        return `<div class='text-center'><span class='badge rounded-pill ${badgeClass}'>ON</span></div>`;
                    }else{
                        badgeClass = 'bg-danger';
                        return `<div class='text-center'><span class='badge rounded-pill ${badgeClass}'>OFF</span></div>`;
                    }
                }
            },

            */
           
{
  targets: 3,
  render: function(data, type, row) {

    // Formatear fecha legible (opcional)

    if (!data) return '';
    const fechaLimpia = data.split('.')[0].replace('T', ' ');

    // Convertir la cadena ISO a objeto Date
    const fechaDato = new Date(data);
    const ahora = new Date();

    // Calcular diferencia en milisegundos → minutos
    const diffMs = ahora - fechaDato;
    const diffMin = diffMs / (1000 * 60);

    // Determinar color según el rango
    let badgeClass = '';
    let texto = '';

    if (diffMin <= 20) {
      badgeClass = 'bg-success';
      texto = fechaLimpia;
    } else if (diffMin <= 360) { // 6 horas = 360 minutos
      badgeClass = 'bg-warning text-dark';
      texto = 'Inactivo (menos de 6h)';
    } else {
      badgeClass = 'bg-danger';
      texto = fechaLimpia
    }
    const fechaFormateada = fechaDato.toLocaleString('es-PE', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });


    // Retornar badge + tooltip con fecha
    return `
      <div class='text-center'>
        <span class='badge rounded-pill ${badgeClass}' title='Última actualización: ${fechaFormateada}'>
          ${texto}
        </span>
      </div>`;
  }
},





            {
                targets: 4,
                render: function(data, type, row){
                    //return `<div class='d-flex align-items-center fs-4'><i class='bi bi-arrow-up-short me-2 align-items-center mb-1 text-success value-icon fs-2'></i>${data}</div>`;
                    return `<div class='d-flex justify-content-center'>${data}</div>`
                }

            },
            {
                targets: 5,
                render: function(data, type, row){
                    let badgeClass = '';
                    if (data <= 0) {
                        iconClass = 'text-secondary';
                        badgeClass = 'bg-secondary';
                    } else if (data > 1 && data <= 3) {
                        iconClass = 'text-success';
                        badgeClass = 'bg-success';
                    } else if(data > 3 && data <= 6){
                        iconClass = 'text-warning';
                        badgeClass = 'bg-warning';
                    }else{
                        iconClass = 'text-danger';
                        badgeClass = 'bg-danger';
                    }
                    return `<div class='text-center'><i class='bi bi-bell-fill fs-4 ${iconClass}'></i><span class='badge rounded-pill ${badgeClass}'>${data}</span></div>`;
                }
            },
            {
                targets: 6,
                render: function(data, type, row){
                    //return `<div class='d-flex justify-content-center' style='display:block;margin:0 auto;'><canvas style='margin:0;' id='gfPastel${data.id}' width='100' height='100'></canvas></div>`;
                    return `<div class='d-flex justify-content-center'>${data}</div>`;
                }
            }
        ],
        responsive: true,
        drawCallback: function(settings) {
            var api = this.api();
            api.rows().every(function() {
                var data = this.data();
                console.log(data);
                // DOM cargado antes de llamar a graficoPastelPrueba
                if (document.getElementById(`gfPastel${data.id}`)) {
                    graficoPastelPrueba(data);
                }
                if (document.getElementById(`gDoughnut${data.id}`)) {
                    graficoDoughnut(data);
                }
            });
        }
        
    });
}
function graficoPastelPrueba(data){
    let ctx = document.getElementById(`gfPastel${data.dato.id}`).getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['ON', 'OFF'],
            datasets: [{
                label: 'Estado',
                data: [data.dato.ON, data.dato.OFF],
                backgroundColor: [
                    'rgba(0, 255, 0, 0.2)',
                    'rgba(255, 0, 0, 0.2)',
                ],
                borderColor: [
                    'rgba(0, 255, 0, 1)',
                    'rgba(255, 0, 0, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    display: false
                }
            },
            plugins:{
                legend:{
                    display:false,
                },
            }
        }
    });
    myChart.update();
}

// Redibujar gráficos cuando la ventana cambia de tamaño
$(window).resize(function() {
    tblGenset.columns.adjust().draw();
});

function graficoDoughnut(data){
    let ctx = document.getElementById(`gDoughnut${data.c0.id}`).getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['ON', 'OFF'],
            datasets: [{
                label: 'Estado',
                data: [data.c0.ON, data.c0.OFF],
                backgroundColor: [
                    'rgba(0, 255, 0, 0.2)',
                    'rgba(255, 0, 0, 0.2)',
                ],
                borderColor: [
                    'rgba(0, 255, 0, 1)',
                    'rgba(255, 0, 0, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    display: false
                }
            },
            plugins:{
                legend:{
                    display:false,
                }
            }
        }
    });
    myChart.update();
}

function MapaLeaflet(){
    const http = new XMLHttpRequest();
    const url = base_url + 'AdminPage/MapaLeaflet';
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);

            let mymap = L.map('map').setView([-12.0463731, -77.042754], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mymap);

            // Definir el icono del marcador
            let greenIcon = L.icon({
                iconUrl: base_url + 'Assets/img/marcador.png',
                iconSize: [30, 30],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            // Agregar puntos en el mapa
            res.forEach(function(punto) {
                // Extraer las coordenadas de la URL
                const coordsMatch = punto.link_mapa.match(/q=(-?\d+\.\d+),(-?\d+\.\d+)/);
                // Verificar si las coordenadas son válidas
                if (coordsMatch) {
                    const coords = coordsMatch.slice(1, 3);
                    const lat = parseFloat(coords[0]);
                    const lng = parseFloat(coords[1]);

                    // Verificar si las coordenadas no son None
                    if (!isNaN(lat) && !isNaN(lng)) {
                        // Agregar el marcador al mapa
                        let marker = L.marker([lat, lng], {icon: greenIcon}).addTo(mymap);
                        //marker.bindPopup("<b>" + punto.imei + "</b>");
                        let content = `
                            <div class='d-flex justify-content-center gap-1'>
                                <button class="btn btn-primary" type="button" id="btn-location">
                                    Location
                                </button>
                                <button class="btn" type="button" id="btn-detalles">
                                    Detalles
                                </button>
                            </div>
                            <div class="collapse show mt-2" id="location">
                                <div class="card card-body">
                                    <div class="form-group d-flex gap-2">
                                        <label class="fw-bold text-uppercase">Genset ID:</label>
                                        <span> -NA- </span>
                                    </div>
                                    <div class="form-group d-flex gap-2">
                                        <label class="fw-bold text-uppercase">Latitud:</label>
                                        <span>${punto.latitud}</span>
                                    </div>
                                    <div class="form-group d-flex gap-2">
                                        <label class="fw-bold text-uppercase">Longitud:</label>
                                        <span>${punto.longitud}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse mt-2" id="detalles">
                                <div class="card card-body">
                                    <div class="form-group d-flex gap-1">
                                        <label class="fw-bold text-uppercase">Imei</label>
                                        <span>${punto.imei}</span>
                                    </div>
                                </div>
                            </div>`;

                        marker.bindPopup(content);

                        $(document).on('click', '#btn-location', function() {
                            $('#detalles').collapse('hide');
                            $('#location').collapse('toggle');
                        });
                        $(document).on('click', '#btn-detalles', function() {
                            $('#location').collapse('hide');
                            $('#detalles').collapse('toggle');
                        });
                    }
                }
            });
        }
    }
}
async function obtenerCambio() {
    //$(".loader").show();
    const response = await fetch(base_url + "AdminPage/LiveData", {method: "GET", });
    const result = await response.json();
    if(result.length!=0){
        result.forEach(function(res){
            tarjeta(res);
            //$('#fechita_'+res.telemetria_id).text(res.ultima_fecha);
            console.log(res.telemetria_id);
        })
    }
    console.log(result);
    //setInterval(  function(){ $(".loader").fadeOut("fast"); }, 1000);

    return result;
}

let ethyValues = {};
let co2Values = {};
let supplyValues = {};
let returnValues = {};
let humidityValues = {};
let iHoursValues = {};
let avlValues = {};
let compressorValues = {};
let evaporatorValues = {};
let ambientValues = {};
let pwdValues = {};
let procesoValues = {};
let cmodeValues = {};
let usda1Values = {};
let usda2Values = {};
function tarjeta(res){
    let iconSuccess = "<i class='bi bi-arrow-up-short me-2 align-items-center mb-1 text-success value-icon'></i>";
    let iconDown = "<i class='bi bi-arrow-down-short me-2 align-items-center mb-1 text-danger value-icon'></i>";

    if(ethyValues[res.telemetria_id] === undefined){
        ethyValues[res.telemetria_id] = res.ethylene;
    }
    let evaluacionEti;
    if(res.ethylene > ethyValues[res.telemetria_id]){
        evaluacionEti = iconSuccess;
    }else if(res.ethylene < ethyValues[res.telemetria_id]){
        evaluacionEti = iconDown;
    }

    $('#eti_icon_'+res.telemetria_id).html(evaluacionEti);

    if(co2Values[res.telemetria_id] === undefined){
        co2Values[res.telemetria_id] = res.co2_reading;
    }
    let evaluacionCO2;
    if(res.co2_reading > co2Values[res.telemetria_id]){
        evaluacionCO2 = iconSuccess;
    }else if(res.co2_reading < co2Values[res.telemetria_id]){
        evaluacionCO2 = iconDown;
    }

    $('#co2_icon_'+res.telemetria_id).html(evaluacionCO2);

    if(supplyValues[res.telemetria_id] === undefined){
        supplyValues[res.telemetria_id] = res.temp_supply
    }

    let evaluacionSupply;

    if(res.temp_supply > supplyValues[res.telemetria_id]){
        evaluacionSupply = iconSuccess;
    }else if(res.temp_supply < supplyValues[res.telemetria_id]){
        evaluacionSupply = iconDown;
    }
    $('#supply_icon_'+res.telemetria_id).html(evaluacionSupply);

    if(returnValues[res.telemetria_id] === undefined){
        returnValues[res.telemetria_id] = res.return_air
    }

    let evaluacionReturn;
    if(res.return_air > returnValues[res.telemetria_id]){
        evaluacionReturn = iconSuccess;
    }else if(res.return_air < returnValues[res.telemetria_id]){
        evaluacionReturn = iconDown;
    }
    $('#return_icon_'+res.telemetria_id).html(evaluacionReturn);

    if(humidityValues[res.telemetria_id] === undefined){
        humidityValues[res.telemetria_id] = res.relative_humidity
    }
    let evaluacionHumidity;
    if(res.relative_humidity > humidityValues[res.telemetria]){
        evaluacionHumidity = iconSuccess;
    }else if(res.relative_humidity < humidityValues[res.telemetria_id]){
        evaluacionHumidity = iconDown;
    }
    $('#humidity_icon_'+res.telemetria_id).html(evaluacionHumidity);

    if(iHoursValues[res.telemetria_id] === undefined){
        iHoursValues[res.telemetria_id] = res.ripener_prueba
    }
    let evaluacionIHours;
    if(res.ripener_prueba > iHoursValues[res.telemetria_id]){
        evaluacionIHours = iconSuccess;
    }else if(res.ripener_prueba < iHoursValues[res.telemetria_id]){
        evaluacionIHours = iconDown;
    }
    $('#i_hours_icon_'+res.telemetria_id).html(evaluacionIHours);

    if(avlValues[res.telemetria_id] === undefined){
        avlValues[res.telemetria_id] = res.avl
    }
    let evaluacionAvl;
    if(res.avl > avlValues[res.telemetria_id]){
        evaluacionAvl = iconSuccess;
    }else if(res.avl < avlValues[res.telemetria_id]){
        evaluacionAvl = iconDown;
    }
    $('#avl_icon_'+res.telemetria_id).html(evaluacionAvl);

    if(compressorValues[res.telemetria_id] === undefined){
        compressorValues[res.telemetria_id] = res.compress_coil_1
    }
    let evaluacionCompressor;
    if(res.compress_coil_1 > compressorValues[res.telemetria_id]){
        evaluacionCompressor = iconSuccess;
    }else if(res.compress_coil_1 < compressorValues[res.telemetria_id]){
        evaluacionCompressor = iconDown;
    }
    $('#compressor_icon_'+res.telemetria_id).html(evaluacionCompressor);

    if(evaporatorValues[res.telemetria_id] === undefined){
        evaporatorValues[res.telemetria_id] = res.evaporation_coil
    }
    let evaluacionEvaporator;
    if(res.evaporation_coil > evaporatorValues[res.telemetria_id]){
        evaluacionEvaporator = iconSuccess;
    }else if(res.evaporation_coil < evaporatorValues[res.telemetria_id]){
        evaluacionEvaporator = iconDown;
    }
    $('#evaporator_icon_'+res.telemetria_id).html(evaluacionEvaporator);

    if(ambientValues[res.telemetria_id] === undefined){
        ambientValues[res.telemetria_id] = res.ambient_air
    }
    let evaluacionAmbient;
    if(res.ambient_air > ambientValues[res.telemetria_id]){
        evaluacionAmbient = iconSuccess;
    }else if(res.ambient_air < ambientValues[res.telemetria_id]){
        evaluacionAmbient = iconDown;
    }
    $('#ambient_air_icon_'+res.telemetria_id).html(evaluacionAmbient);

    if(pwdValues[res.telemetria_id] === undefined){
        pwdValues[res.telemetria_id] = res.defrost_prueba
    }
    let evaluacionPwd;
    if(res.defrost_prueba > pwdValues[res.telemetria_id]){
        evaluacionPwd = iconSuccess;
    }else if(res.defrost_prueba < pwdValues[res.telemetria_id]){
        evaluacionPwd = iconDown;
    }
    $('#pwd_icon_'+res.telemetria_id).html(evaluacionPwd);

    if(procesoValues[res.telemetria_id] === undefined){
        procesoValues[res.telemetria_id] = res.stateProcess
    }
    let evaluacionProceso;
    if(res.stateProcess > procesoValues[res.telemetria_id]){
        evaluacionProceso = iconSuccess;
    }else if(res.stateProcess < procesoValues[res.telemetria_id]){
        evaluacionProceso = iconDown;
    }
    $('#proceso_icon_'+res.telemetria_id).html(evaluacionProceso);

    if(cmodeValues[res.telemetria_id] === undefined){
        cmodeValues[res.telemetria_id] = res.controlling_mode
    }
    let evaluacionCmode;    
    if(res.controlling_mode > cmodeValues[res.telemetria_id]){
        evaluacionCmode = iconSuccess;
    }else if(res.controlling_mode < cmodeValues[res.telemetria_id]){
        evaluacionCmode = iconDown;
    }
    $('#c_mode_icon_'+res.telemetria_id).html(evaluacionCmode);

    if(usda1Values[res.telemetria_id] === undefined){
        usda1Values[res.telemetria_id] = res.cargo_1_temp
    }
    let evaluacionUsda1;
    if(res.cargo_1_temp > usda1Values[res.telemetria_id]){
        evaluacionUsda1 = iconSuccess;
    }else if(res.cargo_1_temp < usda1Values[res.telemetria_id]){
        evaluacionUsda1 = iconDown;
    }
    $('#usda_1_icon_'+res.telemetria_id).html(evaluacionUsda1);
    
    if(usda2Values[res.telemetria_id] === undefined){
        usda2Values[res.telemetria_id] = res.cargo_2_temp
    }
    let evaluacionUsda2;
    if(res.cargo_2_temp > usda2Values[res.telemetria_id]){
        evaluacionUsda2 = iconSuccess;
    }else if(res.cargo_2_temp < usda2Values[res.telemetria_id]){
        evaluacionUsda2 = iconDown;
    }
    $('#usda_2_icon_'+res.telemetria_id).html(evaluacionUsda2);
    

    $('#fechita_'+res.telemetria_id).text(res.ultima_fecha);
    $('#ethyleno_'+res.telemetria_id).text(res.ethylene +"ppm");
    let co2V = res.co2_reading;
    if(co2V>=0  && co2V<=30){
        $('#co2_'+res.telemetria_id).text(co2V + "%");
    }else{
        $('#co2_'+res.telemetria_id).text('NA %');
    }
    $('#supply_'+res.telemetria_id).text(res.temp_supply_1+"F°");
    $('#return_'+res.telemetria_id).text(res.return_air+"F°");
    $('#humidity_'+res.telemetria_id).text(res.relative_humidity+"%");
    $('#i_hours_'+res.telemetria_id).text(res.ripener_prueba);
    $('#avl_'+res.telemetria_id).text(res.avl+"CFM");
    $('#compressor_'+res.telemetria_id).text(res.compress_coil_1+"F°");
    $('#evaporator_'+res.telemetria_id).text(res.evaporation_coil+"F°");
    $('#ambient_air_'+res.telemetria_id).text(res.ambient_air+"F°");
    $('#pwd_'+res.telemetria_id).text(res.defrost_prueba);
    $('#proceso_'+res.telemetria_id).text(res.stateProcess);
    $('#c_mode_'+res.telemetria_id).text(res.controlling_mode);
    $('#usda_1_'+res.telemetria_id).text(res.cargo_1_temp+"F°");
    $('#usda_2_'+res.telemetria_id).text(res.cargo_2_temp+"F°");
    
    /*
    $('#temp1_'+res.telemetria_id).text(res.temp_supply_1);
    $('#return_'+res.telemetria_id).text(res.return_air);
    $('#s_temp_'+res.telemetria_id).val(res.set_point);
    $('#humd_'+res.telemetria_id).text(res.relative_humidity);
    $('#evap_'+res.telemetria_id).text(res.evaporation_coil);
    $('#s_humd_'+res.telemetria_id).val(res.humidity_set_point);
    $('#cargo1_'+res.telemetria_id).text(res.cargo_1_temp);
    $('#cargo2_'+res.telemetria_id).text(res.cargo_2_temp);
    $('#cargo3_'+res.telemetria_id).text(res.cargo_3_temp);
    $('#cargo4_'+res.telemetria_id).text(res.cargo_4_temp);
    $('#etileno_'+res.telemetria_id).text(res.ethylene);
    $('#sp_etileno_'+res.telemetria_id).val(res.sp_ethyleno);
    $('#co2_'+res.telemetria_id).text(res.co2_reading);
    $('#sp_co2_'+res.telemetria_id).val(res.set_point_co2);
    $('#h_inyeccion_'+res.telemetria_id).text(res.ripener_prueba);
    $('#n_apertura_'+res.telemetria_id).text(res.avl);
    $('#compresor_'+res.telemetria_id).text(res.compress_coil_1);
    $('#defrost_prueba_'+res.telemetria_id).text(res.defrost_prueba);*/
}

function registrarRespuesta(e) {
    e.preventDefault();
    const url = base_url + "AdminPage/registrar";
    const frm = document.getElementById("frmRegistrar");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                frm.reset();
                tblFormulario.ajax.reload();
                alertas(res.msg, res.icono);
        }
    }
}

function detallesContenedor(id){
    const http = new XMLHttpRequest();
    const url = base_url + 'AdminPage/detallesContenedor/' + id;
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            console.log(res);

            // Ocultar y limpiar el contenido del modal
            $('#modalContenedor').modal('hide');
            $('#modalContenido').html('');

            // Mostrar el modal con el nuevo contenido
            $('#modalContenedor').modal('show');
            $('#modalContenido').html(res.html);
        }
    }
}

/* 
@media (min-width: 768px) {
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: auto;
        right: 0;
    }
}

@media (max-width: 767.98px) {
    .dropdown-menu {
        position: static;
        float: none;
    }
}
*/