<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class Inscripciones extends Controller
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
        $perm = $this->model->verificarPermisos($id_user, "Inscripciones");
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
        $data = $this->model->getInscritos(); // Este método debe hacer el JOIN para traer nombres

        for ($i = 0; $i < count($data); $i++) {
            // Estado visual
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarInscripcion(' . $data[$i]['id'] . ')"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarInscripcion(' . $data[$i]['id'] . ')"><i class="fa fa-trash-o"></i></button>
            </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarInscripcion(' . $data[$i]['id'] . ')"><i class="fa fa-reply-all"></i></button>
            </div>';
            }

            // Validación para mostrar "Sin grupo"
            if (empty($data[$i]['grupo'])) {
                $data[$i]['grupo'] = 'Sin grupo';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $torneo_id = strClean($_POST['torneo_id']);
        $grupo_id = empty($_POST['grupo_id']) ? null : strClean($_POST['grupo_id']);
        $equipo_id = strClean($_POST['equipo_id']);
        $genero = strClean($_POST['genero']);
        $status_id = strClean(cadena: $_POST['status_id'] ?? 1);
        $id = strClean($_POST['id']);

        if (empty($torneo_id) || empty($equipo_id) || empty($genero)) {
            $msg = array('msg' => 'Torneo, género y equipo son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->insertarInscripcion($torneo_id, $grupo_id, $equipo_id, $genero, $status_id);
                if ($data == "ok") {
                    $msg = array('msg' => 'Inscripción registrada', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El equipo ya está inscrito en este torneo', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar inscripción', 'icono' => 'error');
                }
            } else {
                $data = $this->model->actualizarInscripcion($torneo_id, $grupo_id, $equipo_id, $genero, $status_id, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Inscripción actualizada', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar inscripción', 'icono' => 'error');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->getInscripcion($id); // Asume que tienes una función getGrupo($id) en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editarInscJugador($id)
    {
        $data = $this->model->getInscripcionJug($id); // Asume que tienes una función getGrupo($id) en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->estadoGrupo(2, $id); // Cambia el status_id a 2 (inactivo)
        if ($data == 1) {
            $msg = array('msg' => 'Equipo dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminarInscJugador()
    {
        $inscripcion_id = isset($_GET['id']) ? $_GET['id'] : null;
        $jugador_id = isset($_GET['cedula']) ? $_GET['cedula'] : null;
        $data = $this->model->estadoInscJugador(2, $inscripcion_id, $jugador_id); // Cambia el status_id a 2 (inactivo)
        if ($data == 1) {
            $msg = array('msg' => 'Jugador dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $data = $this->model->estadoGrupo(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Equipo restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresarInscJugador()
    {
        $inscripcion_id = isset($_GET['id']) ? $_GET['id'] : null;
        $jugador_id = isset($_GET['cedula']) ? $_GET['cedula'] : null;
        $data = $this->model->estadoInscJugador(1, $inscripcion_id, $jugador_id);
        if ($data == 1) {
            $msg = array('msg' => 'Jugador restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function InscripcionJugadores()
    {
        // $data['usuarios'] = $this->model->selectDatos('usuarios');
        // $this->views->getView($this, "home", $data);
        $this->views->getView($this, "InscripcionesJugador");
    }
    public function buscarInscripcion()
    {
        $torneo = $_GET['torneo_id'] ?? null;
        $genero = $_GET['genero'] ?? null;
        $equipo = $_GET['equipo_id'] ?? null;

        if (!$torneo || !$genero || !$equipo) {
            echo json_encode(["error" => "Faltan parámetros"], JSON_UNESCAPED_UNICODE);
            die();
        }

        $data = $this->model->getInscripcionByEquipo($torneo, $genero, $equipo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarJugador()
    {
        $inscripcion_id = strClean($_POST['inscripcion_id']);
        $cedula_jugador = strClean($_POST['jugador']);
        $status_id = strClean(cadena: $_POST['status_id'] ?? 1);
        $id = strClean($_POST['id'] ?? "");


        if (empty($inscripcion_id) || empty($cedula_jugador)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
        } else {
            $data = $this->model->insertarInscJugador($inscripcion_id, $cedula_jugador, $status_id);
            if ($data == "ok") {
                $msg = array('msg' => 'Jugador inscrito correctamente', 'icono' => 'success');
            } else if ($data == "existe") {
                $msg = array('msg' => 'El jugador ya está inscrito en este equipo', 'icono' => 'warning');
            } else if ($data == "repetido") {
                $msg = array('msg' => 'El jugador ya está inscrito en un equipo en este torneo', 'icono' => 'warning');
            } else if ($data == "limite") {
                $msg = array('msg' => 'Este equipo ya tiene 4 jugadores inscritos en este torneo', 'icono' => 'warning');
            } else {
                $msg = array('msg' => 'Error al inscribir jugador', 'icono' => 'error');
            }

        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}
