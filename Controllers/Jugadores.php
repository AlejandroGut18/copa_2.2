<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class Jugadores extends Controller
{
    /**
     * @var JugadoresModel
     */
    protected $model;
    private $auditoria;
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $this->model = new JugadoresModel(); // Si no lo tienes, inclúyelo

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
                $data[$i]['acciones'] = '<div class="d-flex align-items-center">
                    <button class="btn btn-cleann btn-sm mr-2" type="button" onclick="verJugador(\'' . $data[$i]['cedula'] . '\')" title="Datos Jugador">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgb(255, 255, 255)" stroke-width="2">
                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                    <button class="btn btn-edit btn-sm mr-2" type="button" onclick="btnEditarJugador(\'' . $data[$i]['cedula'] . '\')" title="Editar Jugador">
                        <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button class="btn btn-delete btn-sm" type="button" onclick="btnEliminarJugador(\'' . $data[$i]['cedula'] . '\')" title="Desactivar Jugador">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class="d-flex align-items-center">
                    <button class="btn btn-cleann btn-sm mr-2" type="button" onclick="verJugador(\'' . $data[$i]['cedula'] . '\')" title="Ver Jugador">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgb(255, 255, 255)" stroke-width="2">
                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarJugador(\'' . $data[$i]['cedula'] . '\')" title="Reactivar Jugador">
                        <i class="fa fa-reply-all"></i>
                    </button>
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
        $equipos = $_POST['equipos'] ?? [];

        if (
            empty($cedula) || empty($nombre) || empty($apellido) ||
            empty($fecha_nacimiento) || empty($email) || empty($genero)
        ) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } elseif (empty($equipos)) {
            $msg = array('msg' => 'Debe seleccionar al menos un equipo', 'icono' => 'warning');
        } else {
            // Validar que haya al menos un equipo seleccionado
            if (empty($equipos)) {
                $msg = array('msg' => 'Debe seleccionar al menos un equipo', 'icono' => 'warning');
            } else {
                $data = $this->model->insertarJugador($cedula, $nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero);
                if ($data == "ok") {
                    $jugador_id = $cedula; // ✅ Se mantiene cédula como ID
                    // Insertar relaciones en equipo_jugadores
                    foreach ($equipos as $equipo_id) {
                        $this->model->asociarJugadorEquipo($jugador_id, $equipo_id);
                    }
                    $msg = array('msg' => 'Jugador registrado exitosamente', 'icono' => 'success');

                } elseif ($data == "existe") {
                    $msg = array('msg' => 'Este Jugador ya fué regsitrado', 'icono' => 'warning');
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
        $data = $this->model->getJugador($id);
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
        $equipos = $_POST['equipos'] ?? [];

        if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || empty($email)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } elseif (empty($equipos)) {
            $msg = array('msg' => 'Debe seleccionar al menos un equipo', 'icono' => 'warning');
        } else {
            $actualizado = $this->model->actualizarJugador($cedula, $nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero);

            if ($actualizado == "ok") {
                $equipos_actuales = $this->model->obtenerEquiposJugador($cedula); // array de equipo_id actuales
                $equipos_actuales_ids = array_column($equipos_actuales, 'equipo_id');

                // Desactivar los equipos que ya no están seleccionados
                foreach ($equipos_actuales_ids as $equipo_actual) {
                    if (!in_array($equipo_actual, $equipos)) {
                        $this->model->cambiarEstadoEquipoJugador($cedula, $equipo_actual, 2); // 2 = inactivo
                    }
                }

                // Insertar o reactivar los equipos nuevos
                foreach ($equipos as $equipo_id) {
                    if (in_array($equipo_id, $equipos_actuales_ids)) {
                        // Ya existe → asegurar que esté activo
                        $this->model->cambiarEstadoEquipoJugador($cedula, $equipo_id, 1);
                    } else {
                        // No existe → insertar
                        $this->model->asociarJugadorEquipo($cedula, $equipo_id);
                    }
                }

                $msg = array('msg' => 'Jugador actualizado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al actualizar jugador', 'icono' => 'error');
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

    // public function listarInscritos()
    // {
    //     $data = $this->model->getInscritos();
    //     for ($i = 0; $i < count($data); $i++) {
    //         $cedula = htmlspecialchars($data[$i]['cedula'], ENT_QUOTES, 'UTF-8');
    //         if ($data[$i]['status_id'] == 1) {
    //             $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
    //             $data[$i]['acciones'] = '<div>
    //                 <button class="btn btn-edit" type="button" onclick="btnEditarInscJugador(' . $data[$i]['id'] . ', \'' . $cedula . '\');"><i class="fa fa-pencil-square-o"></i></button>

    //                 <button class="btn btn-delete" type="button" onclick="btnEliminarInscJugador(' . $data[$i]['id'] . ', \'' . $cedula . '\');"><i class="fa fa-trash-o"></i></button>
    //             </div>';
    //         } else {
    //             $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
    //             $data[$i]['acciones'] = '<div>
    //                 <button class="btn btn-success" type="button" onclick="btnReingresarInscJugador(' . $data[$i]['id'] . ', \'' . $data[$i]['cedula'] . '\');"><i class="fa fa-reply-all"></i></button>
    //             </div>';
    //         }

    //     }
    //     echo json_encode($data, JSON_UNESCAPED_UNICODE);
    //     die();
    // }

    //Devuelve los jugadores que son parte del equipo selecionado
    public function ListarJugEquipo()
    {
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $equipo = isset($_GET['equipo_id']) ? $_GET['equipo_id'] : null;
        $data = $this->model->getJugEquipo($genero, $equipo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ListarNoInscritos()
    {
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $equipo = isset($_GET['equipo_id']) ? $_GET['equipo_id'] : null;
        $torneo = isset($_GET['torneo_id']) ? $_GET['torneo_id'] : null;
        $data = $this->model->getJugadorNoInsc($genero, $equipo, $torneo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ver($cedula)
    {
        // Validar que venga cedula
        if (empty($cedula)) {
            echo json_encode(['error' => 'No se indicó jugador']);
            die();
        }

        // Llamar al modelo para obtener datos
        $jugador = $this->model->getJugadorConEquipos($cedula);

        if ($jugador) {
            echo json_encode($jugador, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Jugador no encontrado']);
        }

        die();
    }

    public function buscarDelegado()
    {
        if (isset($_GET['est'])) {
            $valor = $_GET['est'];
            $data = $this->model->buscarDelegado($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }






}
