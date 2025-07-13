<?php
require_once __DIR__ . '/../Models/AuditoriaModel.php';
require_once __DIR__ . '/../Models/JuegosModel.php';

class Enfrentamiento extends Controller
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
        $perm = $this->model->verificarPermisos($id_user, "Enfrentamiento");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    
    public function getEventosCalendarEnfrentamiento()
    {
        $data = $this->model->getJuegos(); 
        $eventos = [];

        // Obtener todos los equipos para mapear id => nombre
        $equipos = $this->model->getEquipos();
        $mapEquipos = [];
        foreach ($equipos as $equipo) {
            $mapEquipos[$equipo['id']] = $equipo['nombre'];
        }

        foreach ($data as $juego) {
            $nombreEquipo1 = isset($mapEquipos[$juego['equipo_id']]) ? $mapEquipos[$juego['equipo_id']] : $juego['equipo_id'];
            $nombreEquipo2 = isset($mapEquipos[$juego['vs_equipo_id']]) ? $mapEquipos[$juego['vs_equipo_id']] : $juego['vs_equipo_id'];
            $eventos[] = [
                'title' => $nombreEquipo1 . ' vs ' . $nombreEquipo2,
                'start' => $juego['fecha'] . 'T' . $juego['hora'],
                'end'   => date('Y-m-d\TH:i:s', strtotime($juego['fecha'] . ' ' . $juego['hora'])),
                'color' => ($juego['status_id'] == 3) ? '#ffc107' : '#17a2b8'
            ];
        }

        echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>