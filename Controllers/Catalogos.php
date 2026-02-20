<?php
class Catalogos extends Controller
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
        $this->views->getView($this, "index");
    }

    // ── ALARMAS ──────────────────────────────────────────
    public function listarAlarmas()
    {
        $data = $this->model->getAlarmas();
        foreach ($data as &$row) {
            $badge = $row['estado'] == 1
                ? "<span class='badge bg-success'>Activo</span>"
                : "<span class='badge bg-danger'>Inactivo</span>";

            $btnEstado = $row['estado'] == 1
                ? "<button class='btn btn-warning btn-sm' onclick='toggleAlarma({$row['id']}, 0)' title='Desactivar'><i class='bi bi-toggle-on'></i></button>"
                : "<button class='btn btn-success btn-sm'  onclick='toggleAlarma({$row['id']}, 1)' title='Activar'><i class='bi bi-toggle-off'></i></button>";

            $row['estado_badge'] = $badge;
            $row['acciones'] = "
                <div class='d-flex justify-content-center gap-1'>
                    <button class='btn btn-info btn-sm' onclick='verAlarma({$row['id']})' title='Ver detalle'>
                        <i class='bi bi-eye-fill'></i>
                    </button>
                    <button class='btn btn-primary btn-sm' onclick='editarAlarma({$row['id']})' title='Editar'>
                        <i class='bi bi-pencil-fill'></i>
                    </button>
                    {$btnEstado}
                </div>";
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getAlarma($id)
    {
        $data = $this->model->getAlarmaById($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function guardarAlarma()
    {
        $id          = strClean($_POST['id'] ?? '');
        $codigo      = strClean($_POST['codigo']);
        $nombre      = strClean($_POST['nombre']);
        $tipo_causa  = strClean($_POST['tipo_causa']);
        $diagnostico = strClean($_POST['diagnostico']);
        $id_user     = $_SESSION['id_ztrack'];

        if (empty($codigo) || empty($nombre)) {
            echo json_encode(['msg' => 'Código y Nombre son requeridos', 'icono' => 'warning']);
            die();
        }

        if (empty($id)) {
            $res = $this->model->insertarAlarma($codigo, $nombre, $tipo_causa, $diagnostico, $id_user);
        } else {
            $res = $this->model->actualizarAlarma($id, $codigo, $nombre, $tipo_causa, $diagnostico, $id_user);
        }

        $msg = $res == 1
            ? ['msg' => 'Alarma guardada correctamente', 'icono' => 'success']
            : ['msg' => 'Error al guardar', 'icono' => 'error'];

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function toggleAlarma()
    {
        $id     = strClean($_POST['id']);
        $estado = strClean($_POST['estado']);
        $res    = $this->model->toggleAlarma($id, $estado);
        $msg    = $res == 1
            ? ['msg' => 'Estado actualizado', 'icono' => 'success']
            : ['msg' => 'Error al actualizar', 'icono' => 'error'];
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // ── MENSAJES ─────────────────────────────────────────
    public function listarMensajes()
    {
        $data = $this->model->getMensajes();
        foreach ($data as &$row) {
            $badge = $row['estado'] == 1
                ? "<span class='badge bg-success'>Activo</span>"
                : "<span class='badge bg-danger'>Inactivo</span>";

            $btnEstado = $row['estado'] == 1
                ? "<button class='btn btn-warning btn-sm' onclick='toggleMensaje({$row['id']}, 0)' title='Desactivar'><i class='bi bi-toggle-on'></i></button>"
                : "<button class='btn btn-success btn-sm'  onclick='toggleMensaje({$row['id']}, 1)' title='Activar'><i class='bi bi-toggle-off'></i></button>";

            $row['estado_badge'] = $badge;
            $row['acciones'] = "
                <div class='d-flex justify-content-center gap-1'>
                    <button class='btn btn-info btn-sm' onclick='verMensaje({$row['id']})' title='Ver detalle'>
                        <i class='bi bi-eye-fill'></i>
                    </button>
                    <button class='btn btn-primary btn-sm' onclick='editarMensaje({$row['id']})' title='Editar'>
                        <i class='bi bi-pencil-fill'></i>
                    </button>
                    {$btnEstado}
                </div>";
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getMensaje($id)
    {
        $data = $this->model->getMensajeById($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function guardarMensaje()
    {
        $id          = strClean($_POST['id'] ?? '');
        $codigo      = strClean($_POST['codigo']);
        $nombre      = strClean($_POST['nombre']);
        $tipo_causa  = strClean($_POST['tipo_causa']);
        $diagnostico = strClean($_POST['diagnostico']);
        $id_user     = $_SESSION['id_ztrack'];

        if (empty($codigo) || empty($nombre)) {
            echo json_encode(['msg' => 'Código y Nombre son requeridos', 'icono' => 'warning']);
            die();
        }

        if (empty($id)) {
            $res = $this->model->insertarMensaje($codigo, $nombre, $tipo_causa, $diagnostico, $id_user);
        } else {
            $res = $this->model->actualizarMensaje($id, $codigo, $nombre, $tipo_causa, $diagnostico, $id_user);
        }

        $msg = $res == 1
            ? ['msg' => 'Mensaje guardado correctamente', 'icono' => 'success']
            : ['msg' => 'Error al guardar', 'icono' => 'error'];

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function toggleMensaje()
    {
        $id     = strClean($_POST['id']);
        $estado = strClean($_POST['estado']);
        $res    = $this->model->toggleMensaje($id, $estado);
        $msg    = $res == 1
            ? ['msg' => 'Estado actualizado', 'icono' => 'success']
            : ['msg' => 'Error al actualizar', 'icono' => 'error'];
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}