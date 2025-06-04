<?php
class Grupos extends Controller
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
        $data = $this->model->getGrupos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarGrupo(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarGrupo(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
            </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarGrupo(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
            </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $nombre = strClean($_POST['nombre']);
        $genero = strClean($_POST['genero']);
        $torneo = strClean($_POST['torneo']);
        $id = strClean($_POST['id']);

        // Estatus por defecto (puedes cambiar esto si lo tomas dinámicamente desde la BD)
        $status_id = 1;

        if (empty($nombre) || empty($genero) || empty($torneo)) {
            $msg = array('msg' => 'Todos los campos obligatorios son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->insertarGrupo($nombre, $status_id, $torneo, $genero);
                if ($data == "ok") {
                    $msg = array('msg' => 'Grupo registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El grupo ya existe en este torneo y género', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->actualizarGrupo($nombre, $status_id, $torneo, $genero, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Grupo modificado', 'icono' => 'success');
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
        $data = $this->model->getGrupo($id); // Asume que tienes una función getGrupo($id) en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->estadoGrupo(2, $id); // Cambia el status_id a 2 (inactivo)
        if ($data == 1) {
            $msg = array('msg' => 'Grupo dado de baja', 'icono' => 'success');
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
