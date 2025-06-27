<?php
class EquiposModel extends Query
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
    public function getEquipos()
    {
        // En el modelo (getGrupos)
        $sql = "SELECT 
                    e.*, 
                    CONCAT(j.nombre, ' ', j.apellido) AS delegado, 
                    s.nombre AS estado 
                FROM 
                    equipos e
                INNER JOIN jugadores j ON e.delegado_equipo = j.cedula
                INNER JOIN status s ON e.status_id = s.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function insertarEquipo($nombre, $delegado, $status_id, $genero)
    {
        // Verificar que no exista un equipo con el mismo nombre
        $verificar = "SELECT * FROM equipos WHERE nombre = '$nombre'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $query = "INSERT INTO equipos(nombre, delegado_equipo, status_id, genero) VALUES (?, ?, ?, ?)";
            $datos = array($nombre, $delegado, $status_id, $genero);
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

    public function getEquipo($id)
    {
        $sql = "SELECT * FROM equipos WHERE id = $id";
        return $this->select($sql);
    }

    public function actualizarEquipo($nombre, $delegado, $status_id, $genero, $id)
    {
        $query = "UPDATE equipos SET nombre = ?, delegado_equipo = ?, status_id = ?, genero = ? WHERE id = ?";
        $datos = array($nombre, $delegado, $status_id, $genero, $id);
        $data = $this->save($query, $datos);

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function estadoEquipo($status_id, $id)
    {
        $query = "UPDATE equipos SET status_id = ? WHERE id = ?";
        $datos = array($status_id, $id);
        $data = $this->save($query, $datos);
        return $data;
    }

    public function getEquiposActivos($genero = null, $torneo = null)
    {
        $sql = "SELECT id, nombre FROM equipos WHERE status_id = 1";
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
    public function getEquiposInscritos($genero = null, $torneo = null, $grupo = null)
    {
        $sql = "SELECT 
                i.id AS inscripcion_id,
                e.id,
                e.nombre 
            FROM 
                inscripciones i
            INNER JOIN 
                equipos e ON i.equipo_id = e.id
            WHERE 
                e.status_id = 1";

        $params = [];

        if (!empty($torneo)) {
            $sql .= " AND i.torneo_id = ?";
            $params[] = $torneo;
        }

        if (!empty($genero)) {
            $sql .= " AND i.genero = ?";
            $params[] = $genero;
        }
        if (!empty($grupo)) {
            $sql .= " AND i.grupo_id = ?";
            $params[] = $grupo;
        }

        if (!empty($params)) {
            return $this->selectAllMejorado($sql, $params);
        }
        return $this->selectAll($sql);
    }
    public function getEquiposNoInscritos($genero, $torneo_id)
    {
        $sql = "SELECT e.id, e.nombre
            FROM equipos e
            LEFT JOIN inscripciones i 
                ON e.id = i.equipo_id 
                AND i.torneo_id = ? 
                AND i.genero = e.genero
            WHERE e.status_id = 1
              AND e.genero = ?
              AND i.equipo_id IS NULL";

        $datos = [$torneo_id, $genero];
        return $this->selectAllMejorado($sql, $datos);
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
?>