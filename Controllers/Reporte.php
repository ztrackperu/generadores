<?php

class Reporte extends Controller
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
        /*
        $perm = $this->model->verificarPermisos($id_user, "Live");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
        */
        /*
        //pedimos la info 
        $data = $this->model->ListaContenedores($id_user);
        #echo $data ;
        $resultadoContenedores = json_decode($data);
        $resultadoContenedores = $resultadoContenedores->data;
        $this->views->getView($this, "index",json_encode($resultadoContenedores));
        */
        $this->views->getView($this, "index");

    }

    public function reportePorDia(){
        //'fechaI' => $fechaI."T00:00:00", 'fechaF' => $fechaF."T23:59:59"
        $fecha = $_POST['f_busqueda'];
        $empresa = $_SESSION['empresa_genset_id'];
        if($fecha == "" ){
            $res = array('msg' => 'No se ha seleccionado una fecha', "icono" => "warning");
        }else{
            $data = $this->model->reportePorDia($empresa);
            $data = json_decode($data);
            $data = $data->data->genset;
            $res = array('msg' => 'success', "icono" => "success", 'data' => $data);
            //$data = $data->data;
            /*
            if($data == ""){
                $res = array('msg' => 'No hay datos para la fecha seleccionada', "icono" => "warning");
            }else{
                $res = array('msg' => 'success', "icono" => "success", 'data' => $data);
            }*/
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}