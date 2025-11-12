<?php
class MensajesModel extends Query{
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

    public function getMensajes(){
        $sql = "SELECT * FROM mensajes";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function getMensaje($id){
        $sql = "SELECT * FROM mensajes WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function obtenerID($id){
        $sql = "SELECT * FROM mensajes WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    //cambiar de estado a 0
    public function eliminarMensaje($estado, $id){
        $sql = "UPDATE mensajes SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function reingresarMensaje($estado, $id){
        $sql = "UPDATE mensajes SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function insertarMensaje($codigo, $nombre, $causa, $diagnostico, $user){
        $sql = "INSERT INTO mensajes(CODIGO, NOMBRE, TIPO_CAUSA, DIAGNOSTICO, user_c) VALUES (?, ?, ?, ?, ?)";
        $datos = array($codigo, $nombre, $causa, $diagnostico, $user);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function editarMensaje($codigo, $nombre, $causa, $diagnostico, $user, $fecha_actual, $id){
        $sql = "UPDATE mensajes SET CODIGO = ?, NOMBRE = ?, TIPO_CAUSA = ?, DIAGNOSTICO = ?, user_m = ?, updated_at = ? WHERE id = ?";
        $datos = array($codigo, $nombre, $causa, $diagnostico, $user, $fecha_actual, $id);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function editar($id){
        $sql = "SELECT * FROM mensajes WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function existeCodigo($codigo){
        $sql = "SELECT * FROM mensajes WHERE CODIGO = '$codigo'";
        $res = $this->select($sql);
        return $res;
    }
}