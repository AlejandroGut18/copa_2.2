<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class Jugadores extends Controller
{
    private $auditoria;
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Jugadores");
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
        $data = $this->model->getJugadores();
        for ($i = 0; $i < count($data); $i++) {
            // Construir nombre completo
            $data[$i]['nombre_completo'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];

            // Formatear fecha de nacimiento
            $fecha = date_create($data[$i]['fecha_nacimiento']);
            $data[$i]['fecha_formateada'] = date_format($fecha, 'd/m/Y');

            // Estado
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-edit" type="button" onclick="btnEditarJugador(\'' . $data[$i]['cedula'] . '\');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-delete" type="button" onclick="btnEliminarJugador(\'' . $data[$i]['cedula'] . '\');"><i class="fa fa-trash-o"></i></button>
            </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarJugador(\'' . $data[$i]['cedula'] . '\');"><i class="fa fa-reply-all"></i></button>
            </div>';
            }
        }

        // Devuelve JSON válido para DataTables
        echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $cedula = strClean($_POST['cedula']);
        $nombre = strClean($_POST['nombre']);
        $apellido = strClean($_POST['apellido']);
        $fecha_nacimiento = strClean($_POST['fecha_nacimiento']);
        $email = strClean($_POST['email']);
        $telefono = strClean($_POST['telefono']);
        $genero = strClean($_POST['genero']);
        $status_id = strClean($_POST['status_id'] ?? 1);

        if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || empty($email)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } else {
            $existe = $this->model->getJugador($cedula);
            if (!empty($existe)) {
                $msg = array('msg' => 'El jugador ya está registrado', 'icono' => 'warning');
            } else {
                $data = $this->model->insertarJugador($cedula, $nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero);
                if ($data == "ok") {
                    $msg = array('msg' => 'Jugador registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'Jugador duplicado (nombre/apellido/fecha)', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar jugador', 'icono' => 'error');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarDelegados()
    {
        $data = $this->model->getDelegados();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function editar($id)
    {
        $data = $this->model->getJugador($id); // Asume que tienes una función getGrupo($id) en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actualizar()
    {
        $cedula = strClean($_POST['cedula']);
        $nombre = strClean($_POST['nombre']);
        $apellido = strClean($_POST['apellido']);
        $fecha_nacimiento = strClean($_POST['fecha_nacimiento']);
        $email = strClean($_POST['email']);
        $telefono = strClean($_POST['telefono']);
        $genero = strClean($_POST['genero']);
        $status_id = strClean($_POST['status_id'] ?? 1);

        if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || empty($email)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } else {
            $existe = $this->model->getJugador($cedula);
            if (empty($existe)) {
                $msg = array('msg' => 'No se encontró el jugador para actualizar', 'icono' => 'warning');
            } else {
                $data = $this->model->actualizarJugador($nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero, $cedula);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Jugador actualizado correctamente', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al actualizar jugador', 'icono' => 'error');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->estadoJugador(2, $id); // Cambia el status_id a 2 (inactivo)
        if ($data == 1) {
            $msg = array('msg' => 'jugador dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $data = $this->model->estadoJugador(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'jugador restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarActivos()
    {
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $data = $this->model->getActivos($genero);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarInscritos(){
        $data = $this->model->getInscritos();
        for ($i = 0; $i < count($data); $i++) {
            $cedula = htmlspecialchars($data[$i]['cedula'], ENT_QUOTES, 'UTF-8');
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-edit" type="button" onclick="btnEditarInscJugador(' . $data[$i]['id'] . ', \'' . $cedula . '\');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-delete" type="button" onclick="btnEliminarInscJugador(' . $data[$i]['id'] . ', \'' . $cedula . '\');"><i class="fa fa-trash-o"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success" type="button" onclick="btnReingresarInscJugador(' . $data[$i]['id'] . ', \'' . $data[$i]['cedula'] . '\');"><i class="fa fa-reply-all"></i></button>
                </div>';
            }
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    //Devuelve los jugadores que son parte del equipo selecionado
    public function ListarJugEquipo(){
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $equipo = isset($_GET['equipo_id']) ? $_GET['equipo_id'] : null;
        $data = $this->model->getJugEquipo($genero, $equipo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ListarNoInscritos(){
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $equipo = isset($_GET['equipo_id']) ? $_GET['equipo_id'] : null;
        $torneo = isset($_GET['torneo_id']) ? $_GET['torneo_id'] : null;
        $data = $this->model->getJugadorNoInsc($genero, $equipo, $torneo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    




}
