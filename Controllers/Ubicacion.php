<?php
class Ubicacion extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        // $id_user = $_SESSION['id_usuario'];
        // $perm = $this->model->verificarPermisos($id_user, "ubicaciones");
        // if (!$perm && $id_user != 1) {
        //     $this->views->getView($this, "permisos");
        //     exit;
        // }
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getUbicaciones();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-primary" type="button" onclick="btnEditarUbic(' . $data[$i]['id'] . ')">
                        <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button class="btn btn-danger" type="button" onclick="btnEliminarUbic(' . $data[$i]['id'] . ')">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $nombre = strClean($_POST['nombre']);
        $direccion = strClean($_POST['direccion']);
        $id = strClean($_POST['id']);

        if (empty($nombre) || empty($direccion)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } else {
            
            if ($id == "") {
                $data = $this->model->insertarUbicacion($nombre, $direccion);
                if ($data == "ok") {
                    $msg = array('msg' => 'Ubicacion registrada', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Ubicacion ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->actualizarUbicacion($nombre, $direccion, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Ubicacion modificada', 'icono' => 'success');
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
        $data = $this->model->getUbicacion($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->estadoTorneo(2, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Torneo dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
//     public function reingresar($id)
//     {
//         $data = $this->model->estadoTorneo(1, $id);
//         if ($data == 1) {
//             $msg = array('msg' => 'Torneo restaurado', 'icono' => 'success');
//         } else {
//             $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
//         }
//         echo json_encode($msg, JSON_UNESCAPED_UNICODE);
//         die();
//     }
//     public function buscarTorneo()
//     {
//         if (isset($_GET['q'])) {
//             $valor = $_GET['q'];
//             $data = $this->model->buscarTorneo($valor);
//             echo json_encode($data, JSON_UNESCAPED_UNICODE);
//             die();
//         }
//     }
}
