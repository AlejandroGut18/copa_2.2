<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';
require_once __DIR__ . '/../Models/TorneosModel.php';

class Calendario extends Controller
{
    public $torneosModel;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $this->torneosModel = new TorneosModel();


    }

    public function index()
    {
		$id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Calendario");

        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
        
        $data = $this->model->selectConfiguracion();
        $this->views->getView($this, "index", $data);
    }

/* NUNCA QUITAR XD */
    public function Enfrentamiento()
    {
        $this->views->getView($this, "enfrentamiento");
    }

    public function listarTorneos()
    {
        $data = $this->torneosModel->getTorneos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status_id'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getEventosCalendar()
    {
        $data = $this->torneosModel->getTorneos(); // Usa tu modelo ya existente
        $eventos = [];

        foreach ($data as $torneo) {
            $eventos[] = [
                'title' => $torneo['nombre'],
                'start' => $torneo['fecha_inicio'],
                'end'   => $torneo['fecha_fin'] ? date('Y-m-d', strtotime($torneo['fecha_fin'])) : $torneo['fecha_inicio'],
                'color' => ($torneo['status_id'] == 1) ? '#28a745' : '#dc3545',
                'sede'  => isset($torneo['ubicacion']) ? $torneo['ubicacion'] : '',
                'estado' => isset($torneo['estado']) ? $torneo['estado'] : ''
            ];
        }

        echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
        die();
    }

    

}
?>