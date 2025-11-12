<?php

class Perfil extends Controller
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
		$id_user = $_SESSION['id_ztrack'];
        $this->views->getView($this, "index");
    }

    public function perfil(){
        $this->views->getView($this, "perfil");
    }

    public function getPerfil(){
        $profile = base_url . 'Assets/img/user1.jpg';
        $text = '';
        $text .= "<div class='col-12 col-lg-3 mt-1'>
                <div class='card'>
                    <div class='card-body text-center'>
                        <h1>Nombre de Usuario</h1>
                        <img src='{$profile}' class='img-fluid rounded-circle mx-auto d-block' alt='Foto de usuario' style='width: 100px;'>
                        <div class='mt-3'>
                            <h5>Nombre</h5>
                            <p>Nombre</p>
                        </div>
                        <div>
                            <h5>Apellido</h5>
                            <p>Apellido</p>
                        </div>
                        <div>
                            <h5>Correo</h5>
                            <p>Correo</p>
                        </div>
                        <div>
                            <h5>RUC</h5>
                            <p>RUC</p>
                        </div>
                        <div>
                            <h5>Empresa</h5>
                            <p>Empresa</p>
                        </div>
                        <div>
                            <h5>Inicio de Suscripción</h5>
                            <p>Inicio de Suscripción</p>
                        </div>
                        <div>
                            <h5>Tiempo de Suscripción</h5>
                            <p>Tiempo de Suscripción</p>
                        </div>
                        <div>
                            <h5>Estado</h5>
                            <p>Estado</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-12 col-lg-9 mt-1'>
                <div class='card'>
                    <div class='card-body'>
                        <h1 class='fw-bold fs-5'>Editar</h1>
                        <form id='frmPerfil' onsubmit='editarPerfil(event)'>
                            <div class='row'>
                                <div class='col-12 col-lg-11'>
                                    <div class='form-group mt-1'>
                                        <label for='nombre'>Nombre</label>
                                        <div class='d-flex gap-1 flex-nowrap'>
                                            <input type='text' class='form-control' id='nombre' name='nombre' value='nombre' disabled>
                                            <button type='button' class='btn btn-light' onclick='editarCampo(\"nombre\")'>
                                                <i class='ri-pencil-fill text-secondary fs-6'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class='form-group mt-1'>
                                        <label for='apellido'>Apellido</label>
                                        <div class='d-flex gap-1 flex-nowrap'>
                                            <input type='text' class='form-control' id='apellido' name='apellido' value='apellido' disabled>
                                            <button type='button' class='btn btn-light' onclick='editarCampo(\"apellido\")'>
                                                <i class='ri-pencil-fill text-secondary fs-6'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class='form-group mt-1'>
                                        <label for='correo'>Correo</label>
                                        <div class='d-flex gap-1 flex-nowrap'>
                                            <input type='email' class='form-control' id='correo' name='correo' value='correo' disabled>
                                            <button type='button' class='btn btn-light' onclick='editarCampo(\"correo\")'>
                                                <i class='ri-pencil-fill text-secondary fs-6'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class='form-group mt-1'>
                                        <label for='ruc'>RUC</label>
                                        <div class='d-flex gap-1 flex-nowrap'>
                                            <input type='text' class='form-control' id='ruc' name='ruc' placeholder='ruc' disabled>
                                            <button type='button' class='btn btn-light' disabled>
                                                <i class='ri-pencil-fill text-secondary fs-6'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class='form-group mt-1'>
                                        <label for='empresa'>Empresa</label>
                                        <div class='d-flex gap-1 flex-nowrap'>
                                            <input type='text' class='form-control' id='empresa' name='empresa' placeholder='empresa' disabled>
                                            <button type='button' class='btn btn-light' disabled>
                                                <i class='ri-pencil-fill text-secondary fs-6'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>";
        $res = array('html' => $text);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function getPerfiles(){
        $data = $this->model->getPerfiles();
        for($i=0;$i<count($data);$i++){
            if($data[$i]['estado'] == 1){
                $data[$i]['acciones'] = "<div class='d-flex justify-content-center gap-1'>
                <button class='btn btn-warning btn-sm' onclick='editarPerfilModal(".$data[$i]['id'].")'><i class='ri-pencil-line fs-5'></i></button>
                <button class='btn btn-danger btn-sm' onclick='eliminarPerfilModal(".$data[$i]['id'].")'><i class='ri-delete-bin-line fs-5'></i></button></div>
                <button class='btn btn-info btn-sm' onclick='verPerfilModal(".$data[$i]['id'].")'><i class='ri-eye-line fs-5'></i></button></div>
                ";
            }else{
                //reingresar
                $data[$i]['acciones'] = "<div class='d-flex justify-content-center'>
                <button class='btn btn-success btn-sm' onclick='reingresarPerfil(".$data[$i]['id'].")'><i class='ri-reply-all-line fs-5'></i></button></div>";
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    public function visualizarPerfil($id){
        $data = $this->model->getPerfil($id);
        $text = '';
        //form group
        $text .="<div class='form-group'>
                    <div class='d-flex justify-content-center flex-wrap col-lg-12'>
                        <div class='col-12 col-lg-6'>
                            <label>Usuario</label>
                        </div>
                        <div class='col-12 col-lg-6'>
                            <input type='text' class='form-control' id='usuario' value='".$data['usuario']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>Nombre</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='nombre' value='".$data['nombre']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>Apellido</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='apellido' value='".$data['apellido']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>Correo</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='correo' value='".$data['correo']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>RUC</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='ruc' value='".$data['ruc']."' readonly>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <label>Empresa</label>
                        </div>
                        <div class='col-12 col-lg-6 mt-2'>
                            <input type='text' class='form-control' id='empresa' value='".$data['empresa']."' readonly>
                        </div>
                    </div>
                </div>";
        $res = array('text' => $text);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function registrarPerfil(){
        $usuario = strClean($_POST['usuario']);
        $nombre = strClean($_POST['nombre']);
        $apellido = strClean($_POST['apellido']);
        $correo = strClean($_POST['correo']);
        $ruc = strClean($_POST['ruc']);
        $empresa = strClean($_POST['empresa']);
        $id = strClean($_POST['id']);
        $user = $_SESSION['id_ztrack'];
        $fecha_actual = date("Y-m-d H:i:s");
        
        if(empty($usuario) || empty($nombre) || empty($apellido) || empty($correo) || empty($ruc) || empty($empresa)){
            $res = array('msg' => 'Llenar todos los campos', 'icono' => 'warning');
        }else{
            if($id == ""){
                $data = $this->model->insertarPerfil($usuario, $nombre, $apellido, $correo, $ruc, $empresa, $user);
                if($data == 1){
                    $res = array('msg' => 'Perfil registrado', 'icono' => 'success');
                }else{
                    $res = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            }else{
                $data = $this->model->editarPerfil($usuario, $nombre, $apellido, $correo, $ruc, $empresa, $user, $fecha_actual, $id);
                if($data == 1){
                    $res = array('msg' => 'Perfil actualizado', 'icono' => 'success');
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

    public function eliminarPerfilModal($id){
        $data = $this->model->obtenerID($id);
        $text = '';
        //estas seguro de eliminar?
        $text .= "<div class='d-flex justify-content-center'>
                    <h5>¿Estás seguro de eliminar esta Perfil {$data['usuario']}?</h5>
                </div>
                <div class='d-flex justify-content-center mt-3 gap-1'>
                    <button class='btn btn-danger' onclick='eliminarPerfil(".$id.")'>Eliminar</button>
                    <button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                </div>";
        $res = array('text' => $text);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function eliminarPerfil($id){
        $data = $this->model->eliminarPerfil(0, $id);
        if($data == 1){
            $res = array('msg' => 'Perfil eliminado', 'icono' => 'success');
        }else{
            $res = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresarPerfil($id){
        $data = $this->model->eliminarPerfil(1, $id);
        if($data == 1){
            $res = array('msg' => 'Perfil restaurado', 'icono' => 'success');
        }else{
            $res = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}