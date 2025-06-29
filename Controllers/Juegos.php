<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class juegos extends Controller
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
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary" type="button" onclick="btnEditarJuego(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-success" type="button" onclick="btnActualizarPuntos(' . $data[$i]['id'] . ');">
                    <i class="fa fa-plus-circle"></i> Resultado
                    </button>
                    <button class="btn btn-danger" type="button" onclick="btnEliminarJuego(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success" type="button" onclick="btnReingresarJuego(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                </div>';
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
        $status_id = strClean($_POST['status_id'] ?? 3);

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
    public function registrarPuntos()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        require_once 'Models/JuegosModel.php';
        $model = new JuegosModel();

        $todoBien = true;

        foreach ($datos as $detalle) {
            $res = $model->guardarDetalleJuego(
                $detalle['juego_id'],
                $detalle['equipo_id'],
                $detalle['puntos'],
                $detalle['vs_equipo_id'],
                $detalle['puntos_vs_equipo']
            );

            if ($res !== "ok" && $res !== "modificado") {
                $todoBien = false;
                break;
            }
        }

        echo json_encode([
            "ok" => $todoBien,
            "msg" => $todoBien ? null : "Error al registrar uno o más puntos"
        ]);
    }


}