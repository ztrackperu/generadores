<?php
class Reportes extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo_ztrack'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, "index");
    }

    public function obtenerDispositivos()
    {
        $data = $this->model->ListaGensetEmpresa($_SESSION['empresa_genset_id']);
        $res  = json_decode($data);
        $res  = $res->data->genset;
        $novo = [];
        foreach ($res as $item) {
            $novo[] = [
                'imei'        => $item->imei,
                'dispositivo' => $item->descripcion . ' - ' . $item->imei
            ];
        }
        echo json_encode($novo, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarReporte()
    {
        $imei      = strClean($_POST['imei']);
        $f_inicio  = strClean($_POST['f_inicio']);
        $f_fin     = strClean($_POST['f_fin']);
        $agrupacion = strClean($_POST['agrupacion']); // dia | semana | mes

        if (empty($imei) || empty($f_inicio) || empty($f_fin)) {
            echo json_encode(['msg' => 'Todos los campos son requeridos', 'icono' => 'warning']);
            die();
        }
        if ($f_inicio > $f_fin) {
            echo json_encode(['msg' => 'Fecha inicio mayor a fecha fin', 'icono' => 'warning']);
            die();
        }

        $obj  = ['imei' => $imei, 'fechaI' => $f_inicio . ':00', 'fechaF' => $f_fin . ':00'];
        $data = $this->model->obtenerDatosTabla($obj);
        $res  = json_decode($data);

        if (empty($res) || empty($res->data)) {
            echo json_encode(['msg' => 'Sin datos para el período', 'icono' => 'warning']);
            die();
        }

        $registros = $res->data;
        $resumen   = $this->procesarResumen($registros, $agrupacion);

        echo json_encode([
            'icono'     => 'success',
            'resumen'   => $resumen,
            'agrupacion'=> $agrupacion
        ], JSON_UNESCAPED_UNICODE);
        die();
    }

private function procesarResumen($registros, $agrupacion)
{
    $grupos = [];

    foreach ($registros as $reg) {
        $fecha = substr($reg->fecha_r, 0, 10); // YYYY-MM-DD

        switch ($agrupacion) {
            case 'semana':
                $clave = 'Semana ' . date('W', strtotime($fecha)) . '-' . date('Y', strtotime($fecha));
                break;
            case 'mes':
                $clave = date('m/Y', strtotime($fecha));
                break;
            default:
                $clave = $fecha;
        }

        if (!isset($grupos[$clave])) {
            $grupos[$clave] = [];
        }
        $grupos[$clave][] = $reg;
    }

    $resultado = [];

    foreach ($grupos as $clave => $regs) {
        $n = count($regs);

        // ── Filtrar solo registros con on_off = 1 ──────────────────
        $encendidos = array_values(array_filter($regs, function($r) {
            return $r->on_off == 1;
        }));

        if (empty($encendidos)) {
            // El dispositivo estuvo apagado todo el período
            $resultado[] = [
                'periodo'             => $clave,
                'fecha_inicio'        => substr($regs[0]->fecha_r, 0, 19),
                'fecha_fin'           => substr($regs[$n-1]->fecha_r, 0, 19),
                'total_registros'     => $n,
                'horas_operacion'     => 0,
                'horas_full'          => 0,
                'horas_eco'           => 0,
                'consumo_combustible' => 0,
            ];
            continue;
        }

        $nE = count($encendidos);

        // ── Horas operación: primer ON hasta último ON ──────────────
        $t_inicio = strtotime($encendidos[0]->fecha_r);
        $t_fin    = strtotime($encendidos[$nE - 1]->fecha_r);
        $horas_operacion = round(abs($t_fin - $t_inicio) / 3600, 2);

        // ── Consumo: Dv_Fuel primero - Dv_Fuel último ──────────────
        $fuel_inicio = $encendidos[0]->Dv_Fuel;
        $fuel_fin    = $encendidos[$nE - 1]->Dv_Fuel;
        $consumo     = round(max($fuel_inicio - $fuel_fin, 0), 2);

        // ── Horas Full/Eco por diferencia entre registros ON ────────
        $horas_full_min = 0;
        $horas_eco_min  = 0;

        for ($i = 1; $i < $nE; $i++) {
            $t1   = strtotime($encendidos[$i - 1]->fecha_r);
            $t2   = strtotime($encendidos[$i]->fecha_r);
            $mins = abs($t2 - $t1) / 60;

            // Solo contar si el intervalo es razonable (< 60 min)
            // para no contar gaps de apagado como tiempo encendido
            if ($mins <= 60) {
                if ($encendidos[$i]->Dv_Frequency >= 55) {
                    $horas_full_min += $mins;
                } else {
                    $horas_eco_min  += $mins;
                }
            }
        }

        $resultado[] = [
            'periodo'             => $clave,
            'fecha_inicio'        => substr($encendidos[0]->fecha_r, 0, 19),
            'fecha_fin'           => substr($encendidos[$nE - 1]->fecha_r, 0, 19),
            'total_registros'     => $n,
            'registros_on'        => $nE,
            'horas_operacion'     => $horas_operacion,
            'horas_full'          => round($horas_full_min / 60, 2),
            'horas_eco'           => round($horas_eco_min  / 60, 2),
            'consumo_combustible' => $consumo,
        ];
    }

    return $resultado;
}

}