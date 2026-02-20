let reporteData = [];
let dispositivoNombre = '';

document.addEventListener('DOMContentLoaded', function () {
    // Fechas por defecto: últimos 7 días
    let fin   = new Date();
    let ini   = new Date();
    ini.setDate(ini.getDate() - 7);
    ini.setMinutes(ini.getMinutes() - ini.getTimezoneOffset());
    fin.setMinutes(fin.getMinutes() - fin.getTimezoneOffset());
    document.getElementById('f_inicio').value = ini.toISOString().slice(0, 16);
    document.getElementById('f_fin').value    = fin.toISOString().slice(0, 16);

    cargarDispositivos();
});

function cargarDispositivos() {
    const http = new XMLHttpRequest();
    http.open('GET', base_url + 'Reportes/obtenerDispositivos', true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const datos = JSON.parse(this.responseText);
            let html = '<option value="">Seleccione un dispositivo</option>';
            datos.forEach(d => {
                html += `<option value="${d.imei}">${d.dispositivo}</option>`;
            });
            document.getElementById('sel_imei').innerHTML = html;
        }
    };
}

function generarReporte() {
    const imei       = document.getElementById('sel_imei').value;
    const agrupacion = document.getElementById('sel_agrupacion').value;
    const f_inicio   = document.getElementById('f_inicio').value;
    const f_fin      = document.getElementById('f_fin').value;

    if (!imei) { alertas('Seleccione un dispositivo', 'warning'); return; }
    if (!f_inicio || !f_fin) { alertas('Ingrese el rango de fechas', 'warning'); return; }

    // Nombre del dispositivo seleccionado
    const sel = document.getElementById('sel_imei');
    dispositivoNombre = sel.options[sel.selectedIndex].text;

    Swal.fire({ title: 'Generando reporte...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    const formData = new FormData();
    formData.append('imei',       imei);
    formData.append('agrupacion', agrupacion);
    formData.append('f_inicio',   f_inicio);
    formData.append('f_fin',      f_fin);

    const http = new XMLHttpRequest();
    http.open('POST', base_url + 'Reportes/generarReporte', true);
    http.send(formData);
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            Swal.close();
            const res = JSON.parse(this.responseText);
            if (res.icono !== 'success') { alertas(res.msg, res.icono); return; }
            reporteData = res.resumen;
            renderTabla(reporteData, res.agrupacion);
        }
    };
}

function renderTabla(data, agrupacion) {
    const labels = { dia: 'día', semana: 'semana', mes: 'mes' };
    document.getElementById('tituloTabla').textContent =
        `Resumen por ${labels[agrupacion]} — ${dispositivoNombre}`;

    let tbody = '';
    let totOp = 0, totFull = 0, totEco = 0, totConsumo = 0;

    data.forEach(row => {
        const desde = formatFecha(row.fecha_inicio);
        const hasta = formatFecha(row.fecha_fin);
        totOp      += row.horas_operacion;
        totFull    += row.horas_full;
        totEco     += row.horas_eco;
        totConsumo += row.consumo_combustible;

        tbody += `<tr>
            <td class="fw-bold">${row.periodo}</td>
            <td>${desde}</td>
            <td>${hasta}</td>
            <td>${row.total_registros}</td>
            <td>${row.horas_operacion} h</td>
            <td><span class="badge bg-danger">${row.horas_full} h</span></td>
            <td><span class="badge bg-success">${row.horas_eco} h</span></td>
            <td><span class="badge bg-warning text-dark">${row.consumo_combustible} L</span></td>
        </tr>`;
    });

    document.getElementById('tbodyReporte').innerHTML = tbody;

    // Footer totales
    document.getElementById('footHorasOp').textContent    = round2(totOp) + ' h';
    document.getElementById('footHorasFull').textContent  = round2(totFull) + ' h';
    document.getElementById('footHorasEco').textContent   = round2(totEco) + ' h';
    document.getElementById('footConsumo').textContent    = round2(totConsumo) + ' L';

    // Cards resumen
    document.getElementById('totalHorasOp').textContent   = round2(totOp) + ' h';
    document.getElementById('totalHorasFull').textContent = round2(totFull) + ' h';
    document.getElementById('totalHorasEco').textContent  = round2(totEco) + ' h';
    document.getElementById('totalConsumo').textContent   = round2(totConsumo) + ' L';

    document.getElementById('cardsResumen').style.cssText = '';
    document.getElementById('cardTabla').style.display    = 'block';
}

function descargarPDF() {
    if (!reporteData.length) { alertas('Sin datos para exportar', 'warning'); return; }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

    // ── Encabezado ──
    doc.setFillColor(33, 37, 41);
    doc.rect(0, 0, 297, 20, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('REPORTE OPERACIONAL DE GENERADOR', 148, 13, { align: 'center' });

    doc.setFontSize(9);
    doc.setFont('helvetica', 'normal');
    doc.text(`Dispositivo: ${dispositivoNombre}`, 10, 27);
    doc.text(`Generado: ${new Date().toLocaleString('es-PE')}`, 287, 27, { align: 'right' });

    // ── Cards resumen ──
    const cards = [
        { label: 'Horas Operación', value: document.getElementById('totalHorasOp').textContent,   color: [13, 110, 253] },
        { label: 'Horas Full ≥55Hz', value: document.getElementById('totalHorasFull').textContent, color: [220, 53, 69]  },
        { label: 'Horas Eco <55Hz',  value: document.getElementById('totalHorasEco').textContent,  color: [25, 135, 84]  },
        { label: 'Consumo Total',    value: document.getElementById('totalConsumo').textContent,   color: [255, 193, 7]  },
    ];

    let cx = 10;
    cards.forEach(card => {
        doc.setFillColor(...card.color);
        doc.roundedRect(cx, 32, 65, 18, 2, 2, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(8);
        doc.text(card.label, cx + 32.5, 39, { align: 'center' });
        doc.setFontSize(13);
        doc.setFont('helvetica', 'bold');
        doc.text(card.value, cx + 32.5, 46, { align: 'center' });
        doc.setFont('helvetica', 'normal');
        cx += 70;
    });

    // ── Tabla detalle ──
    const agrupacion = document.getElementById('sel_agrupacion').value;
    const labels = { dia: 'día', semana: 'semana', mes: 'mes' };
    doc.setTextColor(0, 0, 0);
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.text(`Detalle por ${labels[agrupacion]}`, 10, 58);

    const head = [['Período', 'Desde', 'Hasta', 'Registros', 'Hrs Operación', 'Hrs Full (≥55Hz)', 'Hrs Eco (<55Hz)', 'Consumo (L)']];
    const body = reporteData.map(row => [
        row.periodo,
        formatFecha(row.fecha_inicio),
        formatFecha(row.fecha_fin),
        row.total_registros,
        row.horas_operacion + ' h',
        row.horas_full + ' h',
        row.horas_eco + ' h',
        row.consumo_combustible + ' L'
    ]);

    // Fila totales
    body.push([
        'TOTAL', '', '', '',
        round2(reporteData.reduce((a, r) => a + r.horas_operacion, 0)) + ' h',
        round2(reporteData.reduce((a, r) => a + r.horas_full, 0)) + ' h',
        round2(reporteData.reduce((a, r) => a + r.horas_eco, 0)) + ' h',
        round2(reporteData.reduce((a, r) => a + r.consumo_combustible, 0)) + ' L',
    ]);

    doc.autoTable({
        head,
        body,
        startY: 62,
        styles:         { fontSize: 8, cellPadding: 2, halign: 'center' },
        headStyles:     { fillColor: [33, 37, 41], textColor: 255, fontStyle: 'bold' },
        alternateRowStyles: { fillColor: [245, 245, 245] },
        // Fila total en negrita
        didParseCell: function (data) {
            if (data.row.index === body.length - 1) {
                data.cell.styles.fontStyle  = 'bold';
                data.cell.styles.fillColor  = [220, 220, 220];
            }
            // Colores por columna
            if (data.section === 'body' && data.row.index < body.length - 1) {
                if (data.column.index === 5) data.cell.styles.textColor = [220, 53, 69];
                if (data.column.index === 6) data.cell.styles.textColor = [25, 135, 84];
                if (data.column.index === 7) data.cell.styles.textColor = [180, 130, 0];
            }
        },
        foot: [],
    });

    // ── Pie de página ──
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(7);
        doc.setTextColor(150);
        doc.text(`ZTRACK - Reporte generado automáticamente`, 10, 205);
        doc.text(`Página ${i} de ${pageCount}`, 287, 205, { align: 'right' });
    }

    doc.save(`Reporte_${dispositivoNombre.replace(/ /g,'_')}_${new Date().toISOString().slice(0,10)}.pdf`);
}

// ── Utilidades ──
function formatFecha(str) {
    if (!str) return '';
    const [fecha, hora] = str.split('T');
    const [y, m, d]     = fecha.split('-');
    return `${d}/${m}/${y} ${hora ? hora.slice(0,5) : ''}`;
}

function round2(val) {
    return Math.round(val * 100) / 100;
}

function alertas(msg, icono) {
    Swal.fire({ position: 'center', icon: icono, title: msg, showConfirmButton: false, timer: 3000 });
}