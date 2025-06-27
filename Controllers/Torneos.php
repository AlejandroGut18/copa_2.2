<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class Torneos extends Controller
{
    private $auditoria;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $this->auditoria = new AuditoriaModel(); // ← aquí
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Torneos");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getTorneos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarTorneo(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarTorneo(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarTorneo(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $nombre = strClean($_POST['nombre']);
        $fecha_inicio = strClean($_POST['fecha_inicio']);
        $fecha_fin = strClean($_POST['fecha_fin']);
        $ubicacion_id = strClean($_POST['ubicacion_id']);
        $status_id = strClean($_POST['status_id']);
        $id = strClean($_POST['id']);

        if (empty($nombre) || empty($fecha_inicio) || empty($ubicacion_id) || empty($status_id)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } else {
            // Si no se proporciona fecha_fin, se pondrá como null
            if (empty($fecha_fin)) {
                $fecha_fin = null;
            }

            if ($id == "") {
                $data = $this->model->insertarTorneo($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id);
                if ($data == "ok") {
                    $usuario_id = $_SESSION['id_usuario'];
                    $this->auditoria->registrarAuditoria($usuario_id, 'INSERT', "Registro torneo: $nombre");
                    $msg = array('msg' => 'Torneo registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El torneo ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $torneoAntes = $this->model->editTorneo($id);
                // Comparar campos
                $cambios = [];
                if ($torneoAntes['nombre'] != $nombre) {
                    $cambios[] = "nombre: '{$torneoAntes['nombre']}' → '$nombre'";
                }
                if ($torneoAntes['fecha_inicio'] != $fecha_inicio) {
                    $cambios[] = "fecha_inicio: '{$torneoAntes['fecha_inicio']}' → '$fecha_inicio'";
                }
                if ($torneoAntes['fecha_fin'] != $fecha_fin) {
                    $cambios[] = "fecha_fin: '{$torneoAntes['fecha_fin']}' → '$fecha_fin'";
                }
                if ($torneoAntes['ubicacion_id'] != $ubicacion_id) {
                    $cambios[] = "ubicacion_id: '{$torneoAntes['ubicacion_id']}' → '$ubicacion_id'";
                }
                if ($torneoAntes['status_id'] != $status_id) {
                    $cambios[] = "status_id: '{$torneoAntes['status_id']}' → '$status_id'";
                }

                $detalle = "Modificó torneo ID $id: ";
                $detalle .= count($cambios) > 0 ? implode("; ", $cambios) : "sin cambios detectados";

                $data = $this->model->actualizarTorneo($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id, $id);
                if ($data == "modificado") {
                    $usuario_id = $_SESSION['id_usuario'];
                    $this->auditoria->registrarAuditoria($usuario_id, 'UPDATE', $detalle);
                    $msg = array('msg' => 'Torneo modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->editTorneo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->estadoTorneo(2, $id);
        if ($data == 1) {
            $usuario_id = $_SESSION['id_usuario'];
            $this->auditoria->registrarAuditoria($usuario_id, 'DELETE', "Desactivó torneo ID: $id");

            $msg = array('msg' => 'Torneo dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar($id)
    {
        $data = $this->model->estadoTorneo(1, $id);
        if ($data == 1) {
            $usuario_id = $_SESSION['id_usuario'];
            $this->auditoria->registrarAuditoria($usuario_id, 'UPDATE', "Reingresó torneo ID: $id");

            $msg = array('msg' => 'Torneo restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarActivos()
    {
        $data = $this->model->getTorneosActivos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
