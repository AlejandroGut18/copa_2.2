<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';
require_once __DIR__ . '/../Config/Config.php';

class Inscripciones extends Controller
{
    private $rol_id; // ✅ Variable de rol

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
        $this->rol_id = $_SESSION['rol_id'] ?? 0; // ✅ Guardamos el rol en la clase

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
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex align-items-center">
                    <button class="btn btn-cleann btn-sm mr-2" type="button" onclick="verInscripcion(' . $data[$i]['id'] . ')" title="Ver Inscripción">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgb(255, 255, 255)" stroke-width="2">
                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>';

                if ($this->rol_id == ROL_ADMINISTRADOR || $this->rol_id == ROL_ADMIN) {
                    $data[$i]['acciones'] .= '
                    <button class="btn btn-edit btn-sm mr-2" type="button" onclick="btnEditarInscripcion(' . $data[$i]['id'] . ')" title="Editar Inscripción">
                      <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button class="btn btn-delete btn-sm" type="button" onclick="btnEliminarInscripcion(' . $data[$i]['id'] . ')" title="Dar de baja Inscripción">
                      <i class="fa fa-trash-o"></i>
                    </button>';
                }

                $data[$i]['acciones'] .= '</div>';

            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class="d-flex align-items-center">
                    <button class="btn btn-cleann btn-sm mr-2" type="button" onclick="verInscripcion(' . $data[$i]['id'] . ')" title="Ver Inscripción">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgb(255, 255, 255)" stroke-width="2">
                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>';

                if ($this->rol_id == ROL_ADMINISTRADOR || $this->rol_id == ROL_ADMIN) {
                    $data[$i]['acciones'] .= '
                        <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarInscripcion(' . $data[$i]['id'] . ', \'' . $data[$i]['genero'] . '\')" title="Reactivar Inscripción">
                        <i class="fa fa-reply-all"></i>
                        </button>
                        ';
                }


                $data[$i]['acciones'] .= '</div>';
            }

            if (empty($data[$i]['grupo'])) {
                $data[$i]['grupo'] = 'Sin grupo';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $torneo_id = strClean($_POST['torneo_id'] ?? '');
        $genero = strClean($_POST['genero'] ?? '');
        $equipo_id = strClean($_POST['equipo_id'] ?? '');
        $status_id = strClean($_POST['status_id'] ?? 1);
        $jugadores = $_POST['jugadores'] ?? [];

        if (empty($torneo_id) || empty($genero) || empty($equipo_id)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } elseif (empty($jugadores)) {
            $msg = array('msg' => 'Debe seleccionar al menos 5 jugadores', 'icono' => 'warning');
        } else {
            // Registrar la inscripción en la tabla inscripciones_equipos
            $data = $this->model->insertarInscripcion($torneo_id, $genero, $equipo_id, $status_id);

            if (is_numeric($data)) {
                $inscripcion_id = $data;

                // Asociar jugadores a la inscripción
                foreach ($jugadores as $jugador_id) {
                    $res = $this->model->insertarInscJugador($inscripcion_id, $jugador_id, $status_id);

                    if (is_array($res) && $res['estado'] === 'repetido') {
                        // Devuelve el mensaje personalizado y detiene la ejecución
                        $msg = array('msg' => "El jugador con cédula {$res['jugador_id']} ya está inscrito en otro equipo del torneo", 'icono' => 'warning');
                        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                        die();
                    }

                    if ($res !== "ok") {
                        $msg = array('msg' => "Error al registrar al jugador {$jugador_id}: {$res}", 'icono' => 'error');
                        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                }
                $msg = array('msg' => 'Inscripción registrada exitosamente', 'icono' => 'success');


            } elseif ($data === "existe") {
                $msg = array('msg' => 'El equipo ya está inscrito en este torneo', 'icono' => 'warning');

            } elseif ($data === "limite") {
                $msg = array('msg' => 'El Torneo ya esta llenó cuenta con 28 equipos', 'icono' => 'warning');

            } elseif ($data === "error") {
                $msg = array('msg' => 'Error al registrar la inscripción', 'icono' => 'error');

            } else {
                // 🛡️ Prevención por si acaso el método devuelve algo inesperado
                $msg = array('msg' => 'Respuesta inesperada del modelo', 'icono' => 'error');
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        // 1. Obtener datos básicos de la inscripción
        $ins = $this->model->getInscripcion($id);
        //   // Ej: ['id'=>41,'torneo_id'=>11,…]

        // 2. Obtener los jugadores asociados (array de ['jugador_id'=> cedula])
        $jug = $this->model->getJugadoresByInscripcion($id);
        //   // Ej: [ ['jugador_id'=>'13345684'], … ]

        // 3. Extraer solo las cédulas en un array plano
        $cedulas = array_column($jug, 'jugador_id');

        // 4. Incluirlas en la respuesta
        $ins['jugadores'] = $cedulas;

        echo json_encode($ins, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actualizar()
    {
        $id = $_POST['id'];
        $torneo = $_POST['torneo_id'];
        $genero = $_POST['genero'];
        $equipo = $_POST['equipo_id'];
        $jugadores = $_POST['jugadores'] ?? [];

        if (empty($torneo) || empty($genero) || empty($equipo)) {
            $msg = ['msg' => 'Todos los campos son obligatorios', 'icono' => 'warning'];
        } elseif (count($jugadores) < 5 || count($jugadores) > 10) {
            $msg = ['msg' => 'Debe seleccionar entre 5 y 10 jugadores', 'icono' => 'warning'];
        } else {
            // Actualizar datos generales de inscripción
            $actualizado = $this->model->actualizarInscripcion($id, $torneo, $genero, $equipo);

            if ($actualizado == 1) {
                $jugadores_actuales = $this->model->obtenerJugadoresEquipo($id);
                $jugadores_actuales_ids = array_column($jugadores_actuales, 'jugador_id');

                foreach ($jugadores_actuales_ids as $jugador_actual) {
                    if (!in_array($jugador_actual, $jugadores)) {
                        $this->model->cambiarEstadoIncripcionJugador($id, $jugador_actual, 2); // 2 = inactivo
                    }
                }

                foreach ($jugadores as $jugador_id) {
                    if (in_array($jugador_id, $jugadores_actuales_ids)) {
                        // Ya existe → asegurar que esté activo
                        $this->model->cambiarEstadoIncripcionJugador($id, $jugador_id, 1);
                    } else {
                        // No existe → insertar
                        $this->model->agregarJugadorAInscripcion($id, $jugador_id);
                    }
                }

                $msg = ['msg' => 'Inscripción actualizada correctamente', 'icono' => 'success'];
            } else {
                $msg = array('msg' => 'Error al actualizar inscripción', 'icono' => 'error');
            }

        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->estadoInscripcion(2, $id);
        $msg = $data == 1
            ? ['msg' => 'Inscripción dada de baja', 'icono' => 'success']
            : ['msg' => 'Error al eliminar', 'icono' => 'error'];
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar()
    {
        $id = $_POST['id'] ?? null;
        $genero = $_POST['genero'] ?? null;

        if (!$id || !$genero) {
            echo json_encode(['msg' => 'Datos incompletos', 'icono' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        if (!$this->model->torneoActivoPorInscripcion($id)) {
            $msg = ['msg' => 'No se puede reactivar esta inscripción porque su torneo está inactivo', 'icono' => 'warning'];
        } elseif ($this->model->totalEquiposActivosEnTorneo($id, $genero) >= 28) {
            $msg = ['msg' => 'Ya hay 28 equipos activos de este género en el torneo', 'icono' => 'warning'];
        } else {
            $data = $this->model->estadoInscripcion(1, $id);
            $msg = $data == 1
                ? ['msg' => 'Inscripción restaurada', 'icono' => 'success']
                : ['msg' => 'Error al restaurar', 'icono' => 'error'];
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }




    // public function InscripcionJugadores()
    // {
    //     // $data['usuarios'] = $this->model->selectDatos('usuarios');
    //     // $this->views->getView($this, "home", $data);
    //     $this->views->getView($this, "InscripcionesJugador");
    // }
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

    public function ver($id)
    {
        if (empty($id)) {
            echo json_encode(['error' => 'No se indicó inscripcion'], JSON_UNESCAPED_UNICODE);
            die();
        }
        // Traer datos básicos de la inscripción
        $ins = $this->model->getInscripcionCompleta($id);
        if (!$ins) {
            echo json_encode(['error' => 'Inscripción no encontrada'], JSON_UNESCAPED_UNICODE);
            die();
        }
        // Traer jugadores con nombre y status
        $jug = $this->model->getJugadoresByInscripcionDetalle($id);
        // Preparar respuesta
        $ins['jugadores'] = $jug;
        echo json_encode($ins, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarEquiposInscritos()
    {
        $torneo_id = $_GET['torneo_id'] ?? null;
        $genero = $_GET['genero'] ?? null;

        if (!$torneo_id || !$genero) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        $equipos = $this->model->obtenerEquiposInscritos($torneo_id, $genero);
        echo json_encode($equipos);
    }

    public function asignarGruposAleatorio()
    {
        $torneo_id = strClean($_POST['torneo_id'] ?? '');
        $genero = strClean($_POST['genero'] ?? '');
        $equipos = $_POST['equipos'] ?? [];

        if (empty($torneo_id) || empty($genero) || empty($equipos)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
            echo json_encode($msg);
            return;
        }

        if (count($equipos) !== 28) {
            $msg = array('msg' => 'Deben ser 28 equipos obligatoriamente', 'icono' => 'warning');
            echo json_encode($msg);
            return;
        }

        $gruposAsignados = $this->model->asignarEquiposAGrupos($torneo_id, $genero, $equipos);

        if (!empty($gruposAsignados)) {
            $msg = array(
                'msg' => 'Equipos asignados correctamente a los grupos',
                'icono' => 'success',
                'grupos' => $gruposAsignados // Incluir datos estructurados
            );
        } else {
            $msg = array('msg' => 'No se pudieron asignar los equipos', 'icono' => 'error');
        }

        echo json_encode($msg);
    }

    // filtros
    public function filtrar()
    {
        $torneo = $_POST['torneo'] ?? '';
        $genero = $_POST['genero'] ?? '';
        $grupo = $_POST['grupo'] ?? '';
        $estado = $_POST['estado'] ?? '';

        $data = $this->model->filtrarInscripciones($torneo, $genero, $grupo, $estado);


        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex align-items-center">
                    <button class="btn btn-cleann btn-sm mr-2" type="button" onclick="verInscripcion(' . $data[$i]['id'] . ')" title="Ver Inscripción">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgb(255, 255, 255)" stroke-width="2">
                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>';

                if ($this->rol_id == ROL_ADMINISTRADOR || $this->rol_id == ROL_ADMIN) {
                    $data[$i]['acciones'] .= '
                    <button class="btn btn-edit btn-sm mr-2" type="button" onclick="btnEditarInscripcion(' . $data[$i]['id'] . ')" title="Editar Inscripción">
                      <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button class="btn btn-delete btn-sm" type="button" onclick="btnEliminarInscripcion(' . $data[$i]['id'] . ')" title="Dar de baja Inscripción">
                      <i class="fa fa-trash-o"></i>
                    </button>';
                }

                $data[$i]['acciones'] .= '</div>';

            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class="d-flex align-items-center">
                    <button class="btn btn-cleann btn-sm mr-2" type="button" onclick="verInscripcion(' . $data[$i]['id'] . ')" title="Ver Inscripción">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgb(255, 255, 255)" stroke-width="2">
                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>';

                if ($this->rol_id == ROL_ADMINISTRADOR || $this->rol_id == ROL_ADMIN) {
                    $data[$i]['acciones'] .= '
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarInscripcion(' . $data[$i]['id'] . ')" title="Reactivar Inscripción">
                      <i class="fa fa-reply-all"></i>
                    </button>';
                }

                $data[$i]['acciones'] .= '</div>';
            }

            if (empty($data[$i]['grupo'])) {
                $data[$i]['grupo'] = 'Sin grupo';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function equiposPorGrupo()
    {
        $torneo = isset($_GET['torneo']) ? intval($_GET['torneo']) : 0;
        $genero = isset($_GET['genero']) ? $_GET['genero'] : '';

        if ($torneo <= 0 || empty($genero)) {
            echo json_encode([]);
            return;
        }

        $equipos = $this->model->getEquiposConGrupo($torneo, $genero);
        echo json_encode($equipos, JSON_UNESCAPED_UNICODE);
    }






    // public function registrarJugador()
    // {
    //     $inscripcion_id = strClean($_POST['inscripcion_id']);
    //     $cedula_jugador = strClean($_POST['jugador']);
    //     $status_id = strClean(cadena: $_POST['status_id'] ?? 1);
    //     $id = strClean($_POST['id'] ?? "");


    //     if (empty($inscripcion_id) || empty($cedula_jugador)) {
    //         $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
    //     } else {
    //         $data = $this->model->insertarInscJugador($inscripcion_id, $cedula_jugador, $status_id);
    //         if ($data == "ok") {
    //             $msg = array('msg' => 'Jugador inscrito correctamente', 'icono' => 'success');
    //         } else if ($data == "existe") {
    //             $msg = array('msg' => 'El jugador ya está inscrito en este equipo', 'icono' => 'warning');
    //         } else if ($data == "repetido") {
    //             $msg = array('msg' => 'El jugador ya está inscrito en un equipo en este torneo', 'icono' => 'warning');
    //         } else if ($data == "limite") {
    //             $msg = array('msg' => 'Este equipo ya tiene 4 jugadores inscritos en este torneo', 'icono' => 'warning');
    //         } else {
    //             $msg = array('msg' => 'Error al inscribir jugador', 'icono' => 'error');
    //         }

    //     }
    //     echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    //     die();
    // }

}
