<?php
class PerfilModel extends Query{
    protected $id, $nombre, $telefono, $direccion, $correo, $img;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectConfiguracion()
    {
        $sql = "SELECT * FROM configuracion";
        $res = $this->select($sql);
        return $res;
    }

    public function verificarPermisos($id_user, $permiso)
    {

        $tiene = false;
        $sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
        //alterar estructura para trabajar con apis       
    }

    public function getPerfiles(){
        $sql = "SELECT * FROM usuarios";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function getPerfil($id){
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarPerfil($usuario, $nombre, $apellido, $correo, $ruc, $empresa, $user){
        $sql = "INSERT INTO usuarios (usuario, nombre, apellido, correo, ruc, empresa, user_c) VALUES (?,?,?,?,?,?,?)";
        $datos = array($usuario, $nombre, $apellido, $correo, $ruc, $empresa, $user);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function editarPerfil($usuario, $nombre, $apellido, $correo, $ruc, $empresa, $user, $fecha_actual, $id){
        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, apellido = ?, correo = ?, ruc = ?, empresa = ?, user_m = ?, updated_at = ? WHERE id = ?";
        $datos = array($usuario, $nombre, $apellido, $correo, $ruc, $empresa, $user, $fecha_actual, $id);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function editar($id){
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $res = $this->select($sql);
        return $res;

    }

    public function obtenerID($id){
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function eliminarPerfil($estado, $id){
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $res = $this->save($sql, $datos);
        return $res;

    }
}