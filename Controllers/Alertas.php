<?php

class Alertas extends Controller
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
        // aqui debe llegar todo los datos si es user 1 sino de acuedo a loq ue esta permitido 
		$id_user = $_SESSION['id_ztrack'];
        $this->views->getView($this, "index");
    }

    public function getAlertas(){
        $data = [];
        //default america/lima
        date_default_timezone_set('America/Lima');
        $fecha = date('Y-m-d');
        /*
        for($i = 0; $i <=0; $i++) {
            $data[$i]['generador'] = 'Ejemplo' .$i+1;
            $data[$i]['fecha'] = $fecha;
            $data[$i]['codigo'] = $i + 101;
            $data[$i]['detalle'] = 'detalle ' . $i+1;
            $data[$i]['tipo'] = 'tipo ' . $i;
        }
            */
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function mostrarDefCodigo($id){
        $data = $this->model->obtenerCodigo($id);
        $text = '';
        $text .= '
                <div class="row">
                    <h5 class="card-title text-uppercase">CÓDIGO '.$id.'</h5>
                    <div class="col-12 col-lg-12">
                        <div class="form-group mt-2">
                            <label class="fw-bold text-uppercase">Nombre</label>
                            <textarea class="form-control mt-2" id="descripcion" rows="1" readonly>'.$data['NOMBRE'].'</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label class="fw-bold text-uppercase">Tipo o Causa</label>
                            <textarea class="form-control mt-2" id="descripcion" rows="4" readonly>'.$data['TIPO_CAUSA'].'</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label class="fw-bold text-uppercase">Diagnóstico</label>
                            <textarea class="form-control mt-2" id="descripcion" rows="4" readonly>'.$data['DIAGNOSTICO'].'</textarea>
                        </div>
                    </div>
                </div>';
        $res = array('text' => $text);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);

    }

    public function buscarAlerta(){
        $f_inicio = formatearFecha($_POST['f_inicio']);
        $f_fin = formatearFecha($_POST['f_fin']);
        $res = array('f_inicio' => $f_inicio, 'f_fin' => $f_fin);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}