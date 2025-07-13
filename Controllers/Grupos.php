<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';

class Grupos extends Controller
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
        $torneo_id = isset($_GET['torneo']) ? intval($_GET['torneo']) : 0;
        $genero = isset($_GET['genero']) ? $_GET['genero'] : '';
        $grupo = isset($_GET['grupo']) ? $_GET['grupo'] : '';

        // Validación básica
        if ($torneo_id <= 0) {
            echo json_encode([]); // No devolver nada si no hay torneo
            return;
        }

        $data = $this->model->getGruposFiltrados($torneo_id, $genero, $grupo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function listarActivos()
    {
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
        $torneo = isset($_GET['torneo_id']) ? $_GET['torneo_id'] : null;
        $data = $this->model->getGruposActivos($genero, $torneo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

}
