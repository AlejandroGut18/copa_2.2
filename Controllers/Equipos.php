<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class Equipos extends Controller
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
        $perm = $this->model->verificarPermisos($id_user, "Equipos");
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
        $data = $this->model->getEquipos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-edit" type="button" onclick="btnEditarEquipo(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-delete" type="button" onclick="btnEliminarEquipo(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
            </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarEquipo(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
            </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $nombre = strClean($_POST['nombre']);
        $delegado = strClean($_POST['delegado'] ?? '');
        $genero = strClean($_POST['genero']);
        $id = strClean($_POST['id']);
        $tipo = strClean($_POST['tipo_equipo']);

        // Estatus por defecto
        $status_id = strClean($_POST['status_id'] ?? 1);

        if (empty($nombre) || empty($genero)) {
            $msg = array('msg' => 'Nombre y género son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->insertarEquipo($nombre, $delegado, $status_id, $genero, $tipo);
                if ($data == "ok") {
                    $msg = array('msg' => 'Equipo registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El equipo ya existe', 'icono' => 'warning');
                } else if ($data == "jugador_no_existe") {
                    $msg = array('msg' => 'El delegado no existe', 'icono' => 'warning');

                } else if ($data === "delegado_genero") {
                    $msg = array('msg' => "Ese jugador ya es delegado en un equipo del mismo género", 'icono' => "warning");
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                // Validar si ya existe un equipo con ese nombre (distinto al actual)
                $verificarNombre = "SELECT * FROM equipos WHERE nombre = '$nombre' AND id != $id";
                $existeNombre = $this->model->select($verificarNombre);
            
                // Validar si el delegado ya está en otro equipo del mismo género (distinto al actual)
                $verificarDelegado = "SELECT * FROM equipos 
                    WHERE delegado_equipo = '$delegado' 
                    AND genero = '$genero' 
                    AND id != $id";
                $existeDelegado = $this->model->select($verificarDelegado);
            
                if (!empty($existeNombre)) {
                    $msg = array('msg' => 'Ya existe otro equipo con ese nombre', 'icono' => 'warning');
                } else if (!empty($existeDelegado)) {
                    $msg = array('msg' => 'Ese jugador ya es delegado de otro equipo del mismo género', 'icono' => 'warning');
                } else {
                    $data = $this->model->actualizarEquipo($nombre, $delegado, $status_id, $genero, $id, $tipo);
                    if ($data == "modificado") {
                        $msg = array('msg' => 'Equipo modificado', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                    }
                }
            }
            
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->getEquipo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->estadoEquipo(2, $id); // Cambia status a inactivo
        if ($data == 1) {
            $msg = array('msg' => 'Equipo dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $data = $this->model->estadoEquipo(1, $id); // Cambia status a activo
        if ($data == 1) {
            $msg = array('msg' => 'Equipo restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarActivos()
    {
        $torneo = isset($_GET['torneo_id']) ? $_GET['torneo_id'] : null;

        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $data = $this->model->getEquiposActivos($genero, $torneo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarInscritos()
    {
        $torneo = isset($_GET['torneo_id']) ? $_GET['torneo_id'] : null;
        $grupo = isset($_GET['grupo_id']) ? $_GET['grupo_id'] : null;
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $data = $this->model->getEquiposInscritos($genero, $torneo, $grupo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarNoInscritos()
    {
        $torneo = isset($_GET['torneo_id']) ? $_GET['torneo_id'] : null;

        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $data = $this->model->getEquiposNoInscritos($genero, $torneo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }




}
