<?php
class CalendarioModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }
    public function selectConfiguracion()
    {
        $sql = "SELECT * FROM configuracion";
        return $this->select($sql);
    }

    public function filtrarEstadoTorneos($estado)
    {
        $sql = "SELECT t.*, s.nombre AS estado 
                FROM torneos t 
                INNER JOIN status s ON t.status_id = s.id 
                WHERE 1=1";

        if ($estado == "1") {
            $sql .= " AND t.status_id = 1";
        } elseif ($estado == "2") {
            $sql .= " AND t.status_id = 2";
        }

        return $this->selectAll($sql);
    }
    public function getTorneos()
    {
        $sql = "SELECT * FROM torneos";
        return $this->selectAll($sql);
    }
}



?>