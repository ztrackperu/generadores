<?php
class MantenimientoModel extends Query{
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

    public function ListaGensetEmpresa($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, urlapiMongo2."/Maersk/datos/empresa/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }

    public function obtenerMantenimientos(){ 
        $sql = "SELECT m.*
                FROM mantenimientos m
                INNER JOIN (
                    SELECT dispositivo, MAX(id) as id
                    FROM mantenimientos
                    GROUP BY dispositivo
                ) sub
                ON m.id = sub.id
                ORDER BY m.fecha_ultimo_mantenimiento DESC";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function obtenerDispositivos(){
        $sql = "SELECT dispositivo FROM mantenimientos GROUP BY dispositivo";
        $res = $this->selectAll($sql);
        return $res;

    }
    public function historialMantenimiento($dispositivo){
        $sql = "SELECT * FROM mantenimientos WHERE dispositivo = '$dispositivo' AND estado = 1";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function eliminarMantenimiento($estado,$id){
        $sql = "UPDATE mantenimientos SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function editar($id){
        $sql = "SELECT * FROM mantenimientos WHERE id = '$id'";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarMantenimiento($dispositivo,$horometro, $tipo, $ultimo_mantenimiento, $user){
        $sql = "INSERT INTO mantenimientos (dispositivo,horometro_actual, tipo_mantenimiento, fecha_ultimo_mantenimiento, user_c) VALUES (?,?,?,?,?)";
        $datos = array($dispositivo,$horometro, $tipo, $ultimo_mantenimiento, $user);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function editarMantenimiento($dispositivo, $horometro, $tipo, $fecha_ultimo_mantenimiento, $user, $fecha_actual, $id){
        $sql = "UPDATE mantenimientos SET dispositivo = ?, horometro_actual = ?, tipo_mantenimiento = ?, fecha_ultimo_mantenimiento = ?, user_m = ?, updated_at = ? WHERE id = ?";
        $datos = array($dispositivo, $horometro, $tipo, $fecha_ultimo_mantenimiento, $user, $fecha_actual, $id);
        $res = $this->save($sql, $datos);
        return $res;
    }

    public function obtenerUltimoMantenimiento($dispositivo){
        $sql = "SELECT * FROM mantenimientos WHERE dispositivo = '$dispositivo' ORDER BY created_at DESC LIMIT 1";
        $res = $this->select($sql);
        return $res;
    }
}