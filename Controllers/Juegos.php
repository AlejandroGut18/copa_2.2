<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';
require_once __DIR__ . '/../Models/TorneosModel.php';

class juegos extends Controller
{
    private $rol_id;
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
        $this->rol_id = $_SESSION['rol_id']; // ← esta línea es clave

        $perm = $this->model->verificarPermisos($id_user, "Grupos");
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
        $data = $this->model->getJuegos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 3) {
                $data[$i]['estado'] = '<span class="badge badge-success">Pendiente</span>';

                // Botones solo para ADMIN o ADMINISTRADOR
                if ($this->rol_id == ROL_ADMIN || $this->rol_id == ROL_ADMINISTRADOR) {
                    $data[$i]['acciones'] = '<div>
                        <button class="btn btn-editcalendar" type="button" title="Asignar fecha y hora" onclick="btnEditarJuego(' . $data[$i]['id'] . ');">
                        <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn btn-success" type="button" onclick="btnActualizarPuntos(' . $data[$i]['id'] . ');"><i class="bi bi-cloud-arrow-up fs-4"></i></button>
                    </div>';
                } else {
                    $data[$i]['acciones'] = '-'; // O dejarlo vacío si prefieres
                }
            } else if ($data[$i]['status_id'] == 5) {
                $data[$i]['estado'] = '<span class="badge badge-secondary">Culminado</span>';
                $data[$i]['acciones'] = '-'; // Opcional: podrías mostrar solo el botón de ver
            } else {
                $data[$i]['estado'] = '<span class="badge badge-dark">Desconocido</span>';
                $data[$i]['acciones'] = '-';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $id = isset($_POST['id']) ? strClean($_POST['id']) : "";

        // Si solo vienen puntos (Agregar Resultados)
        if (isset($_POST['puntos_equipo']) && isset($_POST['puntos_vs_equipo']) && !empty($id)) {
            $puntos_equipo = strClean($_POST['puntos_equipo']);
            $puntos_vs_equipo = strClean($_POST['puntos_vs_equipo']);

            // Obtener equipos del juego
            $juego = $this->model->getJuego($id);

            if ($juego) {
                $this->model->actualizarPuntos($id, $juego['equipo_id'], $puntos_equipo);
                $this->model->actualizarPuntos($id, $juego['vs_equipo_id'], $puntos_vs_equipo);

                $msg = array('msg' => 'Puntos actualizados correctamente', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Juego no encontrado', 'icono' => 'error');
            }

            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        // Registro/edición completa
        $torneo_id = strClean($_POST['torneo_id'] ?? '');
        $grupo_id = strClean($_POST['grupo_id'] ?? '');
        $equipo_id = strClean($_POST['equipo_id'] ?? '');
        $vs_equipo_id = strClean($_POST['vs_equipo_id'] ?? '');
        $genero = strClean($_POST['genero'] ?? '');
        $fecha = strClean($_POST['fecha'] ?? '');
        $hora = strClean($_POST['hora'] ?? '');
        $status_id = 3;

        if (
            empty($torneo_id) || empty($grupo_id) || empty($equipo_id) ||
            empty($vs_equipo_id) || empty($genero) || empty($fecha) || empty($hora)
        ) {
            $msg = array('msg' => 'Todos los campos son requeridos', 'icono' => 'warning');
        } else {
            if ($equipo_id == $vs_equipo_id) {
                $msg = array('msg' => 'Los equipos no pueden ser iguales', 'icono' => 'error');
            } else {
                if (empty($id)) {
                    $data = $this->model->insertarJuego(
                        $torneo_id,
                        $grupo_id,
                        $equipo_id,
                        $vs_equipo_id,
                        $genero,
                        $fecha,
                        $hora,
                        $status_id
                    );

                    if ($data == "ok") {
                        $msg = array('msg' => 'Juego registrado', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El juego ya existe en esa fecha', 'icono' => 'warning');
                    } else {
                        $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                    }
                } else {
                    $existe = $this->model->verificarJuegoExiste(
                        $torneo_id,
                        $grupo_id,
                        $equipo_id,
                        $vs_equipo_id,
                        $genero,
                        $fecha,
                        $hora,
                        $id
                    );

                    if ($existe) {
                        $msg = array('msg' => 'Ya existe otro juego con esos equipos en esa fecha', 'icono' => 'warning');
                    } else {
                        $data = $this->model->actualizarJuego(
                            $torneo_id,
                            $grupo_id,
                            $equipo_id,
                            $vs_equipo_id,
                            $genero,
                            $fecha,
                            $hora,
                            $status_id,
                            $id
                        );

                        if ($data == "modificado") {
                            $msg = array('msg' => 'Juego modificado', 'icono' => 'success');
                        } else {
                            $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                        }
                    }
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function editar($id)
    {
        $data = $this->model->getJuego($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editarDetallesJuego($id)
    {
        $data = $this->model->getDetallesJuego($id);
        if (is_null($data)) {
            $msg = array('msg' => 'Error al Cargar datos', 'icono' => 'error');
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function actualizarFechaHora()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['juego_id'] ?? null;
            $fecha = $_POST['fecha'] ?? null;
            $hora = $_POST['hora'] ?? null;

            if (!$id || !$fecha || !$hora) {
                echo json_encode(['msg' => 'Datos incompletos', 'icono' => 'warning']);
                exit;
            }

            $resultado = $this->model->actualizarFechaHora($id, $fecha, $hora);

            if ($resultado) {
                echo json_encode(['msg' => 'Fecha y hora actualizadas correctamente', 'icono' => 'success']);
            } else {
                echo json_encode(['msg' => 'Error al actualizar fecha y hora', 'icono' => 'error']);
            }
            exit;
        }
    }



    public function eliminar($id)
    {
        $data = $this->model->estadoJuego(2, $id); // Cambia el status_id a 2 (inactivo)
        if ($data == 1) {
            $msg = array('msg' => 'Juego dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $data = $this->model->estadoJuego(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Juego restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    // public function registrarPuntos()
    // {
    //     $datos = json_decode(file_get_contents("php://input"), true);

    //     require_once 'Models/JuegosModel.php';
    //     $model = new JuegosModel();

    //     $todoBien = true;

    //     foreach ($datos as $detalle) {
    //         $res = $model->guardarDetalleJuego(
    //             $detalle['juego_id'],
    //             $detalle['equipo_id'],
    //             $detalle['puntos'],
    //             $detalle['vs_equipo_id'],
    //             $detalle['puntos_vs_equipo']
    //         );

    //         if ($res !== "ok" && $res !== "modificado") {
    //             $todoBien = false;
    //             break;
    //         }
    //     }

    //     echo json_encode([
    //         "ok" => $todoBien,
    //         "msg" => $todoBien ? null : "Error al registrar uno o más puntos"
    //     ]);
    // }
    // filtros

    public function filtrar()
    {
        $torneo = $_POST['torneo'] ?? '';
        $equipo = $_POST['equipo'] ?? '';
        $genero = $_POST['genero'] ?? '';
        $estado = $_POST['estado'] ?? '';

        $data = $this->model->filtrarJuegos($torneo, $equipo, $genero, $estado);

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 3) {
                $data[$i]['estado'] = '<span class="badge badge-success">Pendiente</span>';

                // Botones solo para ADMIN o ADMINISTRADOR
                if ($this->rol_id == ROL_ADMIN || $this->rol_id == ROL_ADMINISTRADOR) {
                    $data[$i]['acciones'] = '<div>
                        <button class="btn btn-editcalendar" type="button" title="Asignar fecha y hora" onclick="btnEditarJuego(' . $data[$i]['id'] . ');">
                        <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn btn-success" type="button" onclick="btnActualizarPuntos(' . $data[$i]['id'] . ');"><i class="bi bi-cloud-arrow-up fs-4"></i></button>
                    </div>';
                } else {
                    $data[$i]['acciones'] = '-'; // O dejarlo vacío si prefieres
                }
            } else if ($data[$i]['status_id'] == 5) {
                $data[$i]['estado'] = '<span class="badge badge-secondary">Culminado</span>';
                $data[$i]['acciones'] = '-'; // Opcional: podrías mostrar solo el botón de ver
            } else {
                $data[$i]['estado'] = '<span class="badge badge-dark">Desconocido</span>';
                $data[$i]['acciones'] = '-';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    // recibe los datos para generar los enfretaminetos
    public function generarRoundRobin()
    {
        $torneo_id = $_POST['torneo_id'] ?? '';
        $genero = $_POST['genero'] ?? '';

        if (empty($torneo_id) || empty($genero)) {
            echo json_encode(['msg' => 'Todos los campos son obligatorios', 'icono' => 'warning']);
            return;
        }

        $equipos = $this->model->getEquiposPorGrupo($torneo_id, $genero);
        if (count($equipos) !== 28) {
            echo json_encode(['msg' => 'Deben haber 28 equipos inscritos', 'icono' => 'warning']);
            return;
        }

        $result = $this->model->crearEnfrentamientosPorGrupo($equipos, $torneo_id, $genero);

        if ($result) {
            echo json_encode(['msg' => 'Enfrentamientos generados correctamente', 'icono' => 'success']);
        } else {
            echo json_encode(['msg' => 'Error al generar enfrentamientos', 'icono' => 'error']);
        }
    }

    // public function guardarDetalleJuego()
    // {
    //     $juego_id = strClean($_POST['juego_id']);
    //     $ins1_id = strClean($_POST['inscripcion_equipo1_id']);
    //     $ins2_id = strClean($_POST['inscripcion_equipo2_id']);
    //     $p1 = intval($_POST['puntos_equipo1']);
    //     $p2 = intval($_POST['puntos_equipo2']);
    //     $rend = $_POST['rendimiento'] ?? [];

    //     // 1) Actualizar o insertar tabla detalles_juego
    //     $sqlUp = "INSERT INTO detalles_juego (juego_id,puntos,puntos_vs)
    //           VALUES (?,?,?)
    //           ON DUPLICATE KEY UPDATE puntos = ?, puntos_vs = ?";
    //     $this->model->save($sqlUp, [$juego_id, $p1, $p2, $p1, $p2]);

    //     // 2) Para cada grupo y jugador, insertar/actualizar detalles_jugador
    //     foreach (['equipo1', 'equipo2'] as $grupoKey) {
    //         $ins_id = ${$grupoKey . '_id'}; // ins1_id o ins2_id
    //         if (isset($rend[$grupoKey])) {
    //             foreach ($rend[$grupoKey] as $jugId => $vals) {
    //                 $sqlDJ = "INSERT INTO detalles_jugador 
    //                 (juego_id, inscripcion_id, jugador_id, arrimesL, arrimesB, bochesL, bochesB, rastererosL, rastrerosB)
    //               VALUES (?,?,?,?,?,?,?,?,?)
    //               ON DUPLICATE KEY UPDATE
    //                 arrimesL = ?, arrimesB = ?, bochesL = ?, bochesB = ?, rastererosL = ?, rastrerosB = ?";
    //                 $params = [
    //                     $juego_id,
    //                     $ins_id,
    //                     $jugId,
    //                     $vals['arrimesL'],
    //                     $vals['arrimesB'],
    //                     $vals['bochesL'],
    //                     $vals['bochesB'],
    //                     $vals['rastererosL'],
    //                     $vals['rastrerosB'],
    //                     // para UPDATE
    //                     $vals['arrimesL'],
    //                     $vals['arrimesB'],
    //                     $vals['bochesL'],
    //                     $vals['bochesB'],
    //                     $vals['rastererosL'],
    //                     $vals['rastrerosB'],
    //                 ];
    //                 $this->model->save($sqlDJ, $params);
    //             }
    //         }
    //     }

    //     echo json_encode([
    //         'msg' => 'Detalle guardado exitosamente',
    //         'icono' => 'success'
    //     ], JSON_UNESCAPED_UNICODE);
    //     die();
    // }


    // ingresar los datos del juego 
    public function guardarDetalleJuego()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['msg' => 'Método no permitido', 'icono' => 'error']);
            exit;
        }

        $juego_id = strClean($_POST['juego_id'] ?? '');
        $ins1_id = strClean($_POST['inscripcion_equipo1_id'] ?? '');
        $ins2_id = strClean($_POST['inscripcion_equipo2_id'] ?? '');
        $p1 = intval($_POST['puntos_equipo1'] ?? 0);
        $p2 = intval($_POST['puntos_equipo2'] ?? 0);
        $rend = $_POST['rendimiento'] ?? [];

        if (!$juego_id || !$ins1_id || !$ins2_id) {
            echo json_encode(['msg' => 'Datos incompletos', 'icono' => 'warning']);
            exit;
        }

        $ok = $this->model->guardarDetalleJuego(
            $juego_id,
            $ins1_id,
            $ins2_id,
            $p1,
            $p2,
            $rend
        );

        if ($ok) {
            echo json_encode(['msg' => 'Detalle guardado exitosamente', 'icono' => 'success']);
        } else {
            echo json_encode(['msg' => 'Error al guardar detalle', 'icono' => 'error']);
        }
        exit;
    }



}