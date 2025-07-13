<?php
class GruposModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGruposFiltrados($torneo_id, $genero = '', $grupo = '')
    {
        $sql = "SELECT 
                t.nombre AS torneo, 
                g.nombre AS grupo, 
                e.nombre AS equipo, 
                i.genero, 
                s.nombre AS estado
            FROM inscripciones_equipos i
            INNER JOIN torneos t ON i.torneo_id = t.id
            INNER JOIN equipos e ON i.equipo_id = e.id
            INNER JOIN grupos g ON i.grupo_id = g.id
            INNER JOIN status s ON i.status_id = s.id
            WHERE i.torneo_id = ?";

        $params = [$torneo_id];

        if (!empty($genero)) {
            $sql .= " AND i.genero = ?";
            $params[] = $genero;
        }

        if (!empty($grupo)) {
            $sql .= " AND g.nombre = ?";
            $params[] = $grupo;
        }

        return $this->selectAllMejorado($sql, $params);
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