<?php
class JugadoresModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getJugadores()
    {
        $sql = "SELECT 
                j.`cedula`,
                j.`nombre`,
                j.`apellido`,
                j.`fecha_nacimiento`,
                TIMESTAMPDIFF(YEAR, j.`fecha_nacimiento`, CURDATE()) AS `edad`,
                j.`email`,
                j.`telefono`,
                j.`genero`,
                j.`status_id`
            FROM 
                `jugadores` j
            LEFT JOIN 
                `status` s ON j.`status_id` = s.`id`
            ORDER BY 
                j.`apellido`, j.`nombre`;";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function insertarJugador($cedula, $nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero)
    {
        // Verificar si ya existe un jugador con esa cédula o mismos datos personales
        $verificar = "SELECT * FROM jugadores 
                  WHERE cedula = '$cedula' 
                  OR (nombre = '$nombre' AND apellido = '$apellido' AND fecha_nacimiento = '$fecha_nacimiento')";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $query = "INSERT INTO jugadores(
                    cedula, 
                    nombre, 
                    apellido, 
                    fecha_nacimiento, 
                    email, 
                    telefono, 
                    status_id, 
                    genero
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $datos = array(
                $cedula,
                $nombre,
                $apellido,
                $fecha_nacimiento,
                $email,
                $telefono,
                $status_id,
                $genero
            );

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

    public function getJugador($cedula)
    {
        $sql = "SELECT * FROM jugadores WHERE cedula = '$cedula'";
        return $this->select($sql);
    }

    public function actualizarJugador($nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero, $cedula)
    {
        $query = "UPDATE jugadores SET 
              nombre = ?, 
              apellido = ?, 
              fecha_nacimiento = ?, 
              email = ?, 
              telefono = ?, 
              status_id = ?, 
              genero = ? 
              WHERE cedula = ?";

        $datos = array($nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero, $cedula);
        $data = $this->save($query, $datos);

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function estadoJugador($status_id, $cedula)
    {
        $query = "UPDATE jugadores SET status_id = ? WHERE cedula = ?";
        $datos = array($status_id, $cedula);
        $data = $this->save($query, $datos);
        return $data;
    }
    public function getDelegados()
    {
        $sql = "SELECT cedula, nombre, apellido 
            FROM jugadores 
            WHERE status_id = 1";
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
    //Devuelve jugadores activos y filtra por genero
    public function getActivos($genero = null)
    {
        $sql = "SELECT cedula, nombre, apellido FROM jugadores WHERE status_id = 1";
        if (!empty($genero)) {
            $sql .= " AND genero = ?";
            return $this->selectAllMejorado($sql, [$genero]);
        }
        return $this->selectAll($sql);
    }
    public function getJugEquipo($genero = null, $equipo = null)
    {
        $sql = "SELECT 
                    j.cedula,
                    j.nombre,
                    j.apellido
                FROM 
                    equipo_jugadores ej
                INNER JOIN 
                    jugadores j ON ej.jugador_id = j.cedula
                WHERE 
                    j.status_id = 1";

        $params = [];

        if (!empty($equipo)) {
            $sql .= " AND ej.equipo_id = ?";
            $params[] = $equipo;
        }

        if (!empty($genero)) {
            $sql .= " AND j.genero = ?";
            $params[] = $genero;
        }

        if (!empty($params)) {
            return $this->selectAllMejorado($sql, $params);
        }

        return $this->selectAll($sql);
    }
    public function getJugadorNoInsc($genero = null, $equipo = null, $torneo_id = null)
    {
        $sql = "SELECT 
                j.cedula,
                j.nombre,
                j.apellido
            FROM 
                equipo_jugadores ej
            INNER JOIN 
                jugadores j ON ej.jugador_id = j.cedula
            WHERE 
                j.status_id = 1";

        $params = [];

        if (!empty($equipo)) {
            $sql .= " AND ej.equipo_id = ?";
            $params[] = $equipo;
        }

        if (!empty($genero)) {
            $sql .= " AND j.genero = ?";
            $params[] = $genero;
        }

        if (!empty($torneo_id)) {
            $sql .= " AND j.cedula NOT IN (
                    SELECT ij.jugador_id
                    FROM inscripcion_jugadores ij
                    INNER JOIN inscripciones i ON ij.inscripcion_id = i.id
                    WHERE i.torneo_id = ?
                )";
            $params[] = $torneo_id;
        }

        if (!empty($params)) {
            return $this->selectAllMejorado($sql, $params);
        }

        return $this->selectAll($sql);    }

    //devuelve jugadores inscritos en un torneo
    public function getInscritos()
    {
        $sql = "SELECT 
                    i.id,
                    t.nombre AS torneo,
                    e.nombre AS equipo,
                    j.cedula,
                    j.nombre,
                    j.apellido,
                    i.genero,
                    ij.status_id
                FROM inscripciones i
                INNER JOIN torneos t ON i.torneo_id = t.id
                INNER JOIN equipos e ON i.equipo_id = e.id
                INNER JOIN inscripcion_jugadores ij ON i.id = ij.inscripcion_id
                INNER JOIN jugadores j ON ij.jugador_id = j.cedula
                WHERE i.status_id = 1";

        return $this->selectAll($sql);
    }

}
?>