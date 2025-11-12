$(document).ready(function(){
    maparPredeterminado();
});

function alertas(msg, icono) {
    Swal.fire({
        position: 'center',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    })
}
async function obtenerDispositivos(){
    html = '';
    const http = new XMLHttpRequest();
    const url = base_url + 'Gps/obtenerDispositivos';
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

async function seleccionarGenset(value){
    //alert(value);

    const response = await fetch(base_url + 'Gps/obtenerDatosGps/' + value);
    const data = await response.json();
    console.log(data);
    
    if(data.icon == 'success'){
        alertas(data.msg, data.icon);
        setTimeout(() => {
            const mapa = data.data;
            marcarMapa(mapa.latitud, mapa.longitud, mapa.i_f);
        }, 2000);
    }else{
        alertas(data.msg, data.icon);
    }
   //const mapa = data.data;
   //marcarMapa(data.latitud, data.longitud);
} 


document.addEventListener("DOMContentLoaded", async function(){
    try {
        obtenerDispositivos();
    } catch (err) {
        alert(err);
    }
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

function buscarGps(e){
    e.preventDefault();
    const http = new XMLHttpRequest();
    const form = document.getElementById("frmGps");
    const data = new FormData(form);
    const url = base_url + "Gps/buscarGps";
    http.open("POST", url);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            if(res.icon == 'success'){
                alertas(res.msg, res.icon);
                setTimeout(() => {
                    const mapa = res.data;
                    //console.log(mapa);
                    marcarMapa(mapa.latitud, mapa.longitud, mapa.i_f);
                }, 2000);
            }else{
                alertas(res.msg, res.icon);
            }
        }
    }
}

function maparPredeterminado(){
    let mymap = L.map('mapa').setView([-11.9802829,-77.1225813], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(mymap);
    var greenIcon = L.icon({
        iconUrl: base_url + 'Assets/img/marcador.png',
        iconSize: [30, 30],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    L.marker([-11.9802829,-77.1225813], {icon: greenIcon}).addTo(mymap)
}



function marcarMapa(latitudes, longitudes, inicio_fin) {
    if (window.mymap) {
        window.mymap.remove();
        window.mymap = null;
    }

    // Limpiar contenedor
    $('#mapa').remove();
    $('#mapa-container').append('<div id="mapa" style="height: 800px;"></div>');

    // Mapa
    window.mymap = L.map('mapa').setView([latitudes[0], longitudes[0]], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(window.mymap);

    // Puntos
    let puntos = [];
    for (let i = 0; i < latitudes.length; i++) {
        // Si latitud o longitud tiene un dato null no considerar el dato
        if (latitudes[i] != null && longitudes[i] != null) {
            puntos.push([latitudes[i], longitudes[i]]);
        }
    }

    // Línea
    window.routeLayer = L.polyline(puntos, { color: 'blue' }).addTo(window.mymap);
    window.mymap.fitBounds(window.routeLayer.getBounds());

    //macador_inicio
    let marcadorI = L.icon({
        iconUrl: base_url + 'Assets/img/marcador_inicio.png',
        iconSize: [55, 40],
        iconAnchor : [15, 30]
    })
    //marcador_fin
    let marcadorF = L.icon({
        iconUrl: base_url + 'Assets/img/marcador_fin.png',
        iconSize: [55, 40],
        iconAnchor : [15, 30]
    })

    // Marcadores de inicio y fin
    if (inicio_fin.length >= 2) {
        let inicio = inicio_fin[0];
        let fin = inicio_fin[1];
        
        let market = L.marker([inicio.latitud, inicio.longitud], {icon: marcadorI}).addTo(window.mymap);
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
                                        <span>${inicio.latitud}</span>
                                    </div>
                                    <div class="form-group d-flex gap-2">
                                        <label class="fw-bold text-uppercase">Longitud:</label>
                                        <span>${inicio.longitud}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse mt-2" id="detalles">
                                <div class="card card-body" style="font-size:12px;">
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Voltaje de la batería</label>
                                            <span>${inicio.Dv_Voltage}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Temp. motor</label>
                                            <span>${inicio.Dv_Water}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Frecuencia de arranque</label>
                                            <span>${inicio.Dv_Frequency}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Nivel de combustible</label>
                                            <span>${inicio.Dv_Fuel}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Voltaje entregado</label>
                                            <span>${inicio.Rt_Voltaje2}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Corriente del rotor</label>
                                            <span>${inicio.Rt_Field}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Velocidad</label>
                                            <span>${inicio.velocidad}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">RPM</label>
                                            <span>${inicio.Dv_rpm}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Horómetro</label>
                                            <span>${inicio.Tr_Timer2}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Alarma</label>
                                            <span>${inicio.Dv_Alarm}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
        market.bindPopup(content);
        let market2 = L.marker([fin.latitud, fin.longitud], {icon: marcadorF}).addTo(window.mymap);
        let content2 = `
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
                                        <span>${fin.latitud}</span>
                                    </div>
                                    <div class="form-group d-flex gap-2">
                                        <label class="fw-bold text-uppercase">Longitud:</label>
                                        <span>${fin.longitud}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse mt-2" id="detalles">
                                <div class="card card-body" style="font-size:12px;">
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Voltaje de la batería</label>
                                            <span>${fin.Dv_Voltage}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Temp. motor</label>
                                            <span>${fin.Dv_Water}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Frecuencia de arranque</label>
                                            <span>${fin.Dv_Frequency}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Nivel de combustible</label>
                                            <span>${fin.Dv_Fuel}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Voltaje entregado</label>
                                            <span>${fin.Rt_Voltaje2}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Corriente del rotor</label>
                                            <span>${fin.Rt_Field}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Velocidad</label>
                                            <span>${fin.velocidad}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">RPM</label>
                                            <span>${fin.Dv_rpm}</span>
                                        </div>
                                    </div>
                                    <div class='row col-12 col-lg-12'>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Horómetro</label>
                                            <span>${fin.Tr_Timer2}</span>
                                        </div>
                                        <div class="form-group d-flex gap-1 col-lg-6">
                                            <label class="fw-bold text-uppercase">Alarma</label>
                                            <span>${fin.Dv_Alarm}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
        market2.bindPopup(content2);

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
