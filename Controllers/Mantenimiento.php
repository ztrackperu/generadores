<?php

class Mantenimiento extends Controller
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

    public function listar(){
        $data = $this->model->obtenerMantenimientos();
        for($i=0;$i<count($data);$i++){
            if($data[$i]['estado'] == 1){
                //$data[$i]['ultimo_mantenimiento'] = $data[$i]['horometro_actual'] + 500;
                $data[$i]['acciones'] = "<div class='d-flex justify-content-center gap-1'>
                <button class='btn btn-warning btn-sm' onclick='editarMantenimiento(".$data[$i]['id'].")'><i class='ri-pencil-line fs-6'></i></button>
                <button class='btn btn-danger btn-sm' onclick='eliminarMantenimiento(".$data[$i]['id'].")'><i class='ri-delete-bin-line fs-6'></i></button></div>
                <button class='btn btn-info btn-sm' onclick='verMantenimiento(\"".$data[$i]['dispositivo']."\")'><i class='ri-eye-line fs-6'></i></button></div>
                ";
            }else{
                //reingresar
                $data[$i]['acciones'] = "<div class='d-flex justify-content-center'>
                <button class='btn btn-success btn-sm' onclick='reingresarMantenimiento(".$data[$i]['id'].")'><i class='ri-reply-all-line fs-6'></i></button></div>";
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

    }

    public function obtenerDispositivos(){
        $obj =[];
        $data = $this->model->ListaGensetEmpresa($_SESSION['empresa_genset_id']);
        $dispositivos = json_decode($data);
        $dispositivos = $dispositivos->data->genset;
        foreach ($dispositivos as $dispositivo) {
            $por = ['id' => $dispositivo->config, 'imei' => $dispositivo->imei, 'dispositivo' => $dispositivo->descripcion.'_'.$dispositivo->imei];
            array_push($obj,$por);
        }
        echo json_encode($obj, JSON_UNESCAPED_UNICODE);
    }

    public function verMantenimiento($dispositivo){
        $data = $this->model->historialMantenimiento($dispositivo);
        echo json_encode($data);
        die();
    }

    function registrar(){
        $id = $_POST['id'];
        $dispositivo = $_POST['dispositivo'];
        $horometro = $_POST['horometro'];
        $tipo = $_POST['tipo'];
        $ultimo_mantenimiento = $_POST['fecha_prx_mantenimiento'];
        $user = $_SESSION['id_ztrack'];
        //america/lima 
        date_default_timezone_set('America/Lima');
        $fecha_actual = date("Y-m-d H:i:s");
        if (empty($dispositivo) && empty($horometro) && empty($tipo) && empty($ultimo_mantenimiento)) {
            $res = array('msg' => 'Campos vacios', 'icono'=> 'warning');
        } else {
            if ($id == "") {
                $ultimoR = $this->model->obtenerUltimoMantenimiento($dispositivo);
                if ($ultimoR == null) {
                    $data = $this->model->insertarMantenimiento($dispositivo, $horometro, $tipo, $ultimo_mantenimiento, $user);
                    if ($data == 1) {
                        $res = array('msg' => 'Mantenimiento registrado correctamente', 'icono'=> 'success');
                    } else {
                        $res = array('msg' => 'Error al registrar mantenimiento', 'icono'=> 'error');
                    }
                } else {
                    if (strtotime($ultimoR['fecha_ultimo_mantenimiento']) > strtotime($ultimo_mantenimiento)) {
                        $res = array('msg' => 'Ingrese una fecha mayor al último mantenimiento', 'icono'=> 'warning');
                    } elseif ($ultimoR['horometro_actual'] > $horometro) {
                        $res = array('msg' => 'Ingrese un horómetro mayor al último mantenimiento', 'icono'=> 'warning');
                    } else {
                        $data = $this->model->insertarMantenimiento($dispositivo, $horometro, $tipo, $ultimo_mantenimiento, $user);
                        if ($data == 1) {
                            $res = array('msg' => 'Mantenimiento registrado correctamente', 'icono'=> 'success');
                        } else {
                            $res = array('msg' => 'Error al registrar mantenimiento', 'icono'=> 'error');
                        }
                    }
                }
            } else {
                $ultimoR = $this->model->obtenerUltimoMantenimiento($dispositivo);
                if (strtotime($ultimoR['fecha_ultimo_mantenimiento']) > strtotime($ultimo_mantenimiento)) {
                    $res = array('msg' => 'Ingrese una fecha mayor al último mantenimiento', 'icono'=> 'warning');
                } elseif ($ultimoR['horometro_actual'] > $horometro) {
                    $res = array('msg' => 'Ingrese un horómetro mayor al último mantenimiento', 'icono'=> 'warning');
                } else {
                    $data = $this->model->editarMantenimiento($dispositivo, $horometro, $tipo, $ultimo_mantenimiento, $user, $fecha_actual, $id);
                    if ($data == 1) {
                        $res = array('msg' => 'Mantenimiento editado correctamente', 'icono'=> 'success');
                    } else {
                        $res = array('msg' => 'Error al editar mantenimiento', 'icono'=> 'error');
                    }
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    function editar($id){
        $data = $this->model->editar($id);
        echo json_encode($data);
        die();
    }

    public function eliminar($id){
        $data = $this->model->eliminarMantenimiento(0, $id);
        if($data == 1){
            $res = array('msg' => 'Mantenimiento eliminado correctamente', 'icono'=> 'success');
        }else{
            $res = array('msg' => 'Error al eliminar mantenimiento', 'icono'=> 'error');
        }
        echo json_encode($res);

    }

    public function reingresar($id){
        $data = $this->model->eliminarMantenimiento(1, $id);
        if($data == 1){
            $res = array('msg' => 'Mantenimiento reingresado correctamente', 'icono'=> 'success');
        }else{
            $res = array('msg' => 'Error al reingresar mantenimiento', 'icono'=> 'error');
        }
        echo json_encode($res);
    }
    public function dispositivos(){
        $obj =[];
        $data = $this->model->ListaGensetEmpresa($_SESSION['empresa_genset_id']);
        $dispositivos = json_decode($data);
        $dispositivos = $dispositivos->data->genset;
        foreach ($dispositivos as $dispositivo) {
            $por = ['dispositivos' => $dispositivo->descripcion.'_'.$dispositivo->imei];
            array_push($obj,$por);
        }
        return json_encode($obj, JSON_UNESCAPED_UNICODE);
    }
    public function dispositivosParaInsertar() {
        $listaDispositivos = [];
        $dispositivosInsertados = [];
        // Obtener todos los dispositivos desde la API
        $dispositivos = $this->dispositivos();
        $dispositivos = json_decode($dispositivos, true);
        // Obtener los dispositivos ya insertados desde la base de datos local
        $data = $this->model->obtenerMantenimientos();
        $data = json_decode(json_encode($data), true);
        $enlaceVistaPrincipal = base_url . 'AdminPage';
    
        for($i=0;$i<count($data);$i++){
            array_push($dispositivosInsertados, $data[$i]['dispositivo']);
        }

        //comparativa
        foreach ($dispositivos as $dispositivo) {
            if (!in_array($dispositivo['dispositivos'], $dispositivosInsertados)) {
                array_push($listaDispositivos, $dispositivo);
            }
        }
        $html = '';
        if (empty($listaDispositivos)) {
            $html .= "";
        }else{
            $html.="<div class='form-group'>
                        <a class='btn btn-secondary' href='{$enlaceVistaPrincipal}'><i class='ri-home-4-line'></i></a>
                    </div>";
            foreach ($listaDispositivos as $index => $dispositivo) {
                $html .= "
                    <div class='form-group row mt-2'>
                        <div class='col-md-3'>
                            <input type='text' id='dp_{$index}' name='dp_{$index}' class='form-control' value='{$dispositivo['dispositivos']}' readonly>
                        </div>
                        <div class='col-md-3'>
                            <select id='condicion_{$index}' class='form-select' name='condicion_{$index}' required>
                                <option value=''>Seleccione</option>
                                <option value='Nuevo' selected>Nuevo</option>
                                <option value='Usado'>Usado</option>
                            </select>
                            <!--<input type='text' id='condicion_{$index}' name='condicion_{$index}' class='form-control' value='Nuevo' readonly>-->
                        </div>
                        <div class='col-md-3'>
                            <input type='number' id='horometro_{$index}' class='form-control' name='horometro_{$index}' value='0'>
                        </div>
                        <div class='col-md-3'>
                            <select id='tipo_{$index}' name='tipo_{$index}' class='form-select' required>
                                <option value=''>Seleccione</option>
                                <option value='M0' selected>M0</option>
                                <option value='M1'>M1</option>
                                <option value='M2'>M2</option>
                                <option value='M3'>M3</option>
                                <option value='M4'>M4</option>
                            </select>
                            <!--<input type='text' id='tipo_{$index}' name='tipo_{$index}' class='form-control' value='M0' readonly>-->
                        </div>
                    </div>
                    ";
                $total_dispositivos = $index+1;
            }
            $html .= " <div class='form-group mt-2'>
                        <button type='submit' class='btn btn-secondary w-100'>Grabar</button>
                    </div>";
            $html .= "<input type='hidden' id='total_dispositivos' name='total_dispositivos' value='{$total_dispositivos}'>";
        }
        $res = array('html' => $html);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function grabarDispositivos(){
        $total = $_POST['total_dispositivos'];
        for($i=0; $i<$total; $i++){
            $dispositivo = $_POST['dp_'.$i];
            //$condicion = $_POST['condicion_'.$i];
            $horometro = $_POST['horometro_'.$i];
            $tipo = $_POST['tipo_'.$i];
            $user = $_SESSION['id_ztrack'];
            date_default_timezone_set('America/Lima');
            $fecha = date("Y-m-d H:i:s");
            $this->model->insertarMantenimiento($dispositivo, $horometro, $tipo, $fecha, $user);
        }
        $res = array('msg' => 'Dispositivos registrados correctamente', 'icono'=> 'success');
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}