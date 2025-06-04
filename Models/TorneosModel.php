<?php
class TorneosModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTorneos()
    {
        $sql =  "SELECT t.*, u.nombre AS ubicacion, s.nombre AS estado 
        FROM torneos t 
        INNER JOIN ubicaciones u ON t.ubicacion_id = u.id 
        INNER JOIN status s ON t.status_id = s.id";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarTorneo($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id)
    {
        $verificar = "SELECT * FROM torneos WHERE nombre = '$nombre'";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            $query = "INSERT INTO torneos(nombre, fecha_inicio, fecha_fin, ubicacion_id, status_id) VALUES (?,?,?,?,?)";
            $datos = array($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id);
            $data = $this->save($query, $datos);
            
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function editTorneo($id)
    {
        $sql = "SELECT * FROM torneos WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarTorneo($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id, $id)
    {
        $query = "UPDATE torneos SET nombre = ?, fecha_inicio = ?, fecha_fin = ?, ubicacion_id = ?, status_id = ? WHERE id = ?";
        $datos = array($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id, $id);
        $data = $this->save($query, $datos);
        
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function estadoTorneo($status_id, $id)
    {
        $query = "UPDATE torneos SET status_id = ? WHERE id = ?";
        $datos = array($status_id, $id);
        $data = $this->save($query, $datos);
        return $data;
    }
    public function buscarTorneo($valor)
    {
        $sql = "SELECT id, nombre AS text FROM torneos 
                WHERE nombre LIKE '%" . $valor . "%' 
                AND status_id = 1  -- Asumiendo que status 1 es activo
                LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getTorneosActivos() {
        $sql = "SELECT id, nombre 
                FROM torneos 
                WHERE status_id = 1 
                ORDER BY nombre";
        return $this->selectAll($sql);
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
}
