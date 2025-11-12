<?php

class Mensajes extends Controller
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

    public function getMensajes(){
        $data = $this->model->getMensajes();
        for($i=0;$i<count($data);$i++){
            if($data[$i]['estado'] == 1){
                $data[$i]['acciones'] = "<div class='d-flex justify-content-center'>
                <button class='btn btn-warning btn-sm' onclick='editarMensajeModal(".$data[$i]['id'].")'><i class='ri-pencil-line fs-5'></i></button>
                <button class='btn btn-danger btn-sm' onclick='eliminarMensajeModal(".$data[$i]['id'].")'><i class='ri-delete-bin-line fs-5'></i></button></div>
                <button class='btn btn-info btn-sm' onclick='verMensajeModal(".$data[$i]['id'].")'><i class='ri-eye-line fs-5'></i></button></div>
                ";
            }else{
                //reingresar
                $data[$i]['acciones'] = "<div class='d-flex justify-content-center'>
                <button class='btn btn-success btn-sm' onclick='reingresarMensaje(".$data[$i]['id'].")'><i class='ri-reply-all-line fs-5'></i></button></div>";
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getMensaje($id){
        $data = $this->model->getMensaje($id);
        $text = '';
        //form group
        $text .="<div class='form-group'>
                    <div class='d-flex justify-content-center flex-wrap col-lg-12'>
                        <div class='col-12 col-lg-6'>
                            <label>CÓDIGO</label>
                        </div>
                        <div class='col-12 col-lg-6'>
                            <input type='text' class='form-control' id='codigo' value='".$data['CODIGO']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>NOMBRE</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='nombre' value='".$data['NOMBRE']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>CAUSA</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='causa' value='".$data['TIPO_CAUSA']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>DIAGNÓSTICO</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='diagnostico' value='".$data['DIAGNOSTICO']."' readonly>
                        </div>
                    </div>
                </div>";
        $res = array('text' => $text);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function registrarMensaje(){
        $codigo = strClean($_POST['codigo']);
        $nombre = strClean($_POST['nombre']);
        $causa = strClean($_POST['tipo_causa']);
        $diagnostico = strClean($_POST['diagnostico']);
        $id = strClean($_POST['id']);
        $user = $_SESSION['id_ztrack'];
        $fecha_actual = date("Y-m-d H:i:s");
        
        if(empty($codigo) || empty($nombre) || empty($causa) || empty($diagnostico)){
            $res = array('msg' => 'Llenar todos los campos', 'icono' => 'warning');
        }else{
            if($id == ""){
                $data = $this->model->insertarMensaje($codigo, $nombre, $causa, $diagnostico, $user);
                if($data == 1){
                    $res = array('msg' => 'Mensaje registrada', 'icono' => 'success');
                }else{
                    $res = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            }else{
                $data = $this->model->editarMensaje($codigo, $nombre, $causa, $diagnostico, $user, $fecha_actual, $id);
                if($data == 1){
                    $res = array('msg' => 'Mensaje actualizada', 'icono' => 'success');
                }else{
                    $res = array('msg' => 'Error al actualizar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function editar($id){
        $data = $this->model->editar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminarMensajeModal($id){
        $data = $this->model->obtenerID($id);
        $text = '';
        //estas seguro de eliminar?
        $text .= "<div class='d-flex justify-content-center'>
                    <h5>¿Estás seguro de eliminar esta Mensaje {$data['CODIGO']}?</h5>
                </div>
                <div class='d-flex justify-content-center mt-3 gap-1'>
                    <button class='btn btn-danger' onclick='eliminarMensaje(".$id.")'>Eliminar</button>
                    <button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                </div>";
        $res = array('text' => $text);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function eliminarMensaje($id){
        $data = $this->model->eliminarMensaje(0, $id);
        if($data == 1){
            $res = array('msg' => 'Mensaje eliminada', 'icono' => 'success');
        }else{
            $res = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresarMensaje($id){
        $data = $this->model->eliminarMensaje(1, $id);
        if($data == 1){
            $res = array('msg' => 'Mensaje restaurada', 'icono' => 'success');
        }else{
            $res = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}