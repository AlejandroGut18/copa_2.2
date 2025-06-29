<?php
class GruposModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    // public function getUsuario($usuario, $clave)
    // {
    //     $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave' AND estado = 1";
    //     $data = $this->select($sql);
    //     return $data;
    // }
    public function getGrupos()
    {
        // En el modelo (getGrupos)
        $sql = "SELECT g.id, g.nombre, g.genero, g.status_id, e.nombre AS estatus, t.nombre AS torneo 
            FROM grupos g 
            INNER JOIN status e ON g.status_id = e.id 
            INNER JOIN torneos t ON g.torneo_id = t.id 
            ORDER BY t.nombre, g.genero, g.nombre";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function insertarGrupo($nombre, $torneo_id, $genero, $status_id)
    {
        // Validar que no exista el mismo grupo con el mismo torneo y género
        $verificar = "SELECT * FROM grupos WHERE nombre = '$nombre' AND torneo_id = $torneo_id AND genero = '$genero'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $query = "INSERT INTO grupos(nombre, status_id, torneo_id, genero) VALUES (?, ?, ?, ?)";
            $datos = array($nombre, $status_id, $torneo_id, $genero);
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

    public function estadoGrupo($status_id, $id)
    {
        $query = "UPDATE grupos SET status_id = ? WHERE id = ?";
        $datos = array($status_id, $id);
        $data = $this->save($query, $datos);
        return $data;
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

    public function getGruposActivos($genero = null, $torneo = null)
    {
        $sql = "SELECT id, nombre FROM grupos WHERE status_id = 1";
        $params = [];
    
        if (!empty($genero)) {
            $sql .= " AND genero = ?";
            $params[] = $genero;
        }
    
        if (!empty($torneo)) {
            $sql .= " AND torneo_id = ?";
            $params[] = $torneo;
        }
    
        if (!empty($params)) {
            return $this->selectAllMejorado($sql, $params);
        }
    
        return $this->selectAll($sql);
    }
}
?>