<?php

class Gps extends Controller
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
        $gps =  $_SESSION['gps'];
        if($gps == 1){
            $this->views->getView($this, "permisos");
        }else{
            $this->views->getView($this, "index");
        }
    }

    public function buscarGps(){
        $dispositivo = $_POST['dispositivos'];
        $f_inicio = $_POST['f_inicio'];
        $f_fin = $_POST['f_fin'];

       if($dispositivo == "" || $f_inicio == "" || $f_fin == ""){
            $res = array('msg' => 'Campos vacios', 'icon' => 'warning');
        }else{
            if($f_inicio > $f_fin){
                $res = array('msg' => 'La fecha de inicio no puede ser mayor a la fecha final', 'icon' => 'warning');
            }else{
                $data = array(
                    'fechaF' => $f_fin.':00',
                    'fechaI' => $f_inicio.':00',
                    'imei' => $dispositivo
                );
                $dataMadurador = $this->model->obtenerDatosGps($data);
                $res = json_decode($dataMadurador);
             
                if(empty($res->data->latitud) || empty($res->data->longitud))
                {
                    $res = array('msg' => 'No se encontraron datos', 'icon' => 'warning');
                }else{
                    $res = array('msg' => 'Datos encontrados', 'icon' => 'success', 'data' => $res->data);
                }
             
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function obtenerDispositivos(){
        $novo =[];
        $data = $this->model->ListaGensetEmpresa($_SESSION['empresa_genset_id']);
        $resultadoMadurador = json_decode($data);
        $resultadoMadurador = $resultadoMadurador->data->genset;
        foreach ($resultadoMadurador as $producto) {
            $por =  ['id' => $producto->config, 'imei' => $producto->imei, 'dispositivo' => $producto->descripcion . " - " . $producto->imei];
            array_push($novo,$por);
        }
        //echo json_encode($resultadoMadurador, JSON_UNESCAPED_UNICODE);
        echo json_encode($novo, JSON_UNESCAPED_UNICODE); 

    }

    public function obtenerDatosGps($param){
        if($param !=""){
            $pros = explode(",",$param);
            $imei = $pros[0];
            $fechaI = (isset($pros[1])) ? $pros[2] : "0";
            $fechaF = (isset($pros[2])) ? $pros[3] : "0";

            if($fechaI == "0" && $fechaF == "0"){
                $cadena = array(
                    'imei' => $imei
                );
            }else{
                if(fechaGrafica($fechaI, $fechaF)=="ok"){
                    $cadena = array(
                        'fechaI' => validateDate($fechaI),
                        'fechaF' => validateDate($fechaF),
                        'imei' => $imei
                    );
                }else{
                    $cadena = array();
                }
            }
            if(count($cadena)!=0){
                $dataMadurador = $this->model->obtenerDatosGps($cadena);
                $dataMadurador = json_decode($dataMadurador);
                $nav = $dataMadurador->data->latitud;
                if($nav == ""){
                    $resultadoMadurador = array('msg' => 'No se encontraron datos', 'icon' => 'warning');
                }else{
                    //$resultadoMadurador = json_decode($dataMadurador);
                    $resultadoMadurador = $dataMadurador->data;
                    $resultadoMadurador = array('msg' => 'Datos encontrados', 'icon' => 'success', 'data' => $resultadoMadurador);
                }
            }else{
                $resultadoMadurador = fechaGrafica($fechaI, $fechaF);
            }
        }else{
            $resultadoMadurador = "";
            $resultadoMadurador = array('msg' => 'No se encontraron datos', 'icon' => 'warning');
        }
        echo json_encode($resultadoMadurador, JSON_UNESCAPED_UNICODE);
    }
}