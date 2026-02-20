<?php
class CatalogosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // ── ALARMAS ──────────────────────────────────────────
    public function getAlarmas()
    {
        $sql = "SELECT * FROM alarmas ORDER BY CODIGO ASC";
        return $this->selectAll($sql);
    }

    public function getAlarmaById($id)
    {
        $sql = "SELECT * FROM alarmas WHERE id = $id";
        return $this->select($sql);
    }

    public function insertarAlarma($codigo, $nombre, $tipo_causa, $diagnostico, $user)
    {
        $sql = "INSERT INTO alarmas (CODIGO, NOMBRE, TIPO_CAUSA, DIAGNOSTICO, user_c) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->save($sql, [$codigo, $nombre, $tipo_causa, $diagnostico, $user]);
    }

    public function actualizarAlarma($id, $codigo, $nombre, $tipo_causa, $diagnostico, $user)
    {
        $sql = "UPDATE alarmas SET CODIGO=?, NOMBRE=?, TIPO_CAUSA=?, DIAGNOSTICO=?, 
                user_m=?, updated_at=NOW() WHERE id=?";
        return $this->save($sql, [$codigo, $nombre, $tipo_causa, $diagnostico, $user, $id]);
    }

    public function toggleAlarma($id, $estado)
    {
        $sql = "UPDATE alarmas SET estado=?, updated_at=NOW() WHERE id=?";
        return $this->save($sql, [$estado, $id]);
    }

    // ── MENSAJES ─────────────────────────────────────────
    public function getMensajes()
    {
        $sql = "SELECT * FROM mensajes ORDER BY CODIGO ASC";
        return $this->selectAll($sql);
    }

    public function getMensajeById($id)
    {
        $sql = "SELECT * FROM mensajes WHERE id = $id";
        return $this->select($sql);
    }

    public function insertarMensaje($codigo, $nombre, $tipo_causa, $diagnostico, $user)
    {
        $sql = "INSERT INTO mensajes (CODIGO, NOMBRE, TIPO_CAUSA, DIAGNOSTICO, user_c) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->save($sql, [$codigo, $nombre, $tipo_causa, $diagnostico, $user]);
    }

    public function actualizarMensaje($id, $codigo, $nombre, $tipo_causa, $diagnostico, $user)
    {
        $sql = "UPDATE mensajes SET CODIGO=?, NOMBRE=?, TIPO_CAUSA=?, DIAGNOSTICO=?, 
                user_m=?, updated_at=NOW() WHERE id=?";
        return $this->save($sql, [$codigo, $nombre, $tipo_causa, $diagnostico, $user, $id]);
    }

    public function toggleMensaje($id, $estado)
    {
        $sql = "UPDATE mensajes SET estado=?, updated_at=NOW() WHERE id=?";
        return $this->save($sql, [$estado, $id]);
    }
}