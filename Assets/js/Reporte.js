function alertas(msg, icono) {
    Swal.fire({
        position: 'center',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    })
}

function convertirImgBase64(rutaImagen) {
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var reader = new FileReader();
            reader.onloadend = function() {
                resolve(reader.result);
            }
            reader.onerror = function(error) {
                reject(error);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.onerror = function() {
            reject(new Error('Error al cargar la imagen.'));
        };
        xhr.open('GET', rutaImagen);
        xhr.responseType = 'blob';
        xhr.send();
    });
}


async function reporteGeneral(e){
    e.preventDefault();
    const frm = document.getElementById('frmReporte');
    const data = new FormData(frm);
    const http = new XMLHttpRequest();
    const url = base_url + 'Reporte/reportePorDia';
    http.open('POST', url, true);
    http.send(data);
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const res = JSON.parse(this.responseText);
            console.log(res);
            if(res.icono == 'success'){
                alertas(res.msg, res.icono);
                setTimeout(() => {
                    reportePorDia(res.data);
                }, 3000);
            }else{
                alertas(res.msg, res.icono);
            }
        }
    }
}
function evaluarNull(value){
    if(value == null){
        return '';
    }else{
        return value;
    }
}

async function reportePorDia(data){

    const cabecera = await convertirImgBase64(base_url + 'Assets/img/cabecera.png');
    const pie_de_pagina = await convertirImgBase64(base_url + 'Assets/img/pie_de_pagina.png');
    let tablaDispositivos = [
        [
            {text: 'Dispositivos', bold:true},
            {text: 'Última posición', bold:true},
            {text: 'Horómetro', bold:true},
            {text: 'Alertas', bold:true},
            {text: 'Mensajes', bold:true},
            {text: 'Horas ON/OFF', bold:true},
            {text: 'Próximo mantenimiento', bold:true},   
        ]
    ]

    data.forEach(e => {
        tablaDispositivos.push([
            evaluarNull(e.descripcion)+'_'+e.imei,
            { text: 'Ver', link: 'https://'+e.link_mapa, color: 'blue', decoration: 'underline', alignment:'center'},
            e.Tr_Timer2,
            e.config= null,
            e.config= null,
            e.config= null,
            e.config= null
        ])
    });

    let docDefinition = {
        pageMargins: [40, 60, 40, 60],
        header: {
            image: cabecera,
            width: 585,
            height: 55,
            alignment: 'center',
            margin: [0, 5, 0, 0]
        },
        footer: {
            image: pie_de_pagina,
            width: 585,
            height: 55,
            alignment: 'center',
            margin: [0, -10, 0, 0]
        },
        content: [
            {
                columns:[
                    {text: 'Reporte por día', style: 'header'}
                ]
            },
            {
                columns:[
                    {
                        width: '100%',
                        table: {
                            widths: ['*','auto','*','auto','auto','auto', 'auto'],
                            body: tablaDispositivos
                        },
                        fontSize:7
                    }
                ]
            }
        ]
    }
    pdfMake.createPdf(docDefinition).open();
}