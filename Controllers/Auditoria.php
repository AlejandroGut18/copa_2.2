<?php
require_once __DIR__ . '/../Config/Config.php';

class Auditoria extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("Location: " . base_url);
            exit;
        }
        parent::__construct();

        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Grupos");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }

    public function index()
    {
        $this->views->getView($this, "index"); // Vista index.php en Views/Auditoria/
    }

    public function listar()
    {
        $data = $this->model->getAuditoria();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
