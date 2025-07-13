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
        // Obtener datos básicos del jugador
        $sqlJugador = "SELECT * FROM jugadores WHERE cedula = ?";
        $jugador = $this->selectMejorado($sqlJugador, [$cedula]);

        if (!empty($jugador)) {
            // Obtener SOLO los equipos activos
            $sqlEquipos = "SELECT equipo_id FROM equipo_jugadores WHERE jugador_id = ? AND status_id = 1";
            $equipos = $this->selectAllMejorado($sqlEquipos, [$cedula]);
            $jugador['equipos'] = array_column($equipos, 'equipo_id');
        }

        return $jugador;
    }

    public function asociarJugadorEquipo($jugador_id, $equipo_id)
    {
        $sql = "INSERT INTO equipo_jugadores (jugador_id, equipo_id) VALUES (?, ?)";
        $data = array($jugador_id, $equipo_id);
        return $this->save($sql, $data);
    }

    // Traer equipos actuales del jugador
    public function obtenerEquiposJugador($cedula)
    {
        $sql = "SELECT equipo_id FROM equipo_jugadores WHERE jugador_id = ?";
        return $this->selectAllMejorado($sql, [$cedula]);
    }

    // Cambiar estado activo/inactivo
    public function cambiarEstadoEquipoJugador($cedula, $equipo_id, $estado)
    {
        $sql = "UPDATE equipo_jugadores SET status_id = ? WHERE jugador_id = ? AND equipo_id = ?";
        return $this->save($sql, [$estado, $cedula, $equipo_id]);
    }


    public function actualizarJugador($cedula, $nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero)
    {
        $sql = "UPDATE jugadores SET 
                nombre = ?, 
                apellido = ?, 
                fecha_nacimiento = ?, 
                email = ?, 
                telefono = ?, 
                status_id = ?, 
                genero = ?
                WHERE cedula = ?";
        $datos = array($nombre, $apellido, $fecha_nacimiento, $email, $telefono, $status_id, $genero, $cedula);
        $res = $this->save($sql, $datos);
        return $res == 1 ? "ok" : "error";
    }

    // public function eliminarEquiposJugador($jugador_id)
    // {
    //     $sql = "DELETE FROM equipo_jugadores WHERE jugador_id = ?";
    //     return $this->save($sql, [$jugador_id]);
    // }

    public function estadoJugador($status_id, $cedula)
    {
        // Actualizar estado jugador
        $queryJugador = "UPDATE jugadores SET status_id = ? WHERE cedula = ?";
        $datosJugador = [$status_id, $cedula];
        $dataJugador = $this->save($queryJugador, $datosJugador);

        // Actualizar estado de equipos asociados al jugador
        $queryEquipos = "UPDATE equipo_jugadores SET status_id = ? WHERE jugador_id = ?";
        $datosEquipos = [$status_id, $cedula];
        $dataEquipos = $this->save($queryEquipos, $datosEquipos);

        // Opcional: podrías validar si ambas consultas se ejecutaron bien
        if ($dataJugador && $dataEquipos) {
            return 1;
        } else {
            return 0;
        }
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
                    FROM inscripcion_equipo_jugadores  ij
                    INNER JOIN inscripciones_equipos i ON ij.inscripcion_id = i.id
                    WHERE i.torneo_id = ?
                )";
            $params[] = $torneo_id;
        }

        if (!empty($params)) {
            return $this->selectAllMejorado($sql, $params);
        }

        return $this->selectAll($sql);
    }

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
                FROM inscripciones_equipos i
                INNER JOIN torneos t ON i.torneo_id = t.id
                INNER JOIN equipos e ON i.equipo_id = e.id
                INNER JOIN inscripcion_equipo_jugadores  ij ON i.id = ij.inscripcion_id
                INNER JOIN jugadores j ON ij.jugador_id = j.cedula
                WHERE i.status_id = 1";

        return $this->selectAll($sql);
    }

    public function getJugadorConEquipos($cedula)
    {
        $sqlJugador = "SELECT * FROM jugadores WHERE cedula = ?";
        $jugador = $this->selectMejorado($sqlJugador, [$cedula]);

        if ($jugador) {
            $sqlEquipos = "SELECT ej.status_id, e.nombre FROM equipo_jugadores ej
                       INNER JOIN equipos e ON ej.equipo_id = e.id
                       WHERE ej.jugador_id = ?";
            $equipos = $this->selectAllMejorado($sqlEquipos, [$cedula]);
            $jugador['equipos'] = $equipos;
        }

        return $jugador;
    }
    public function buscarDelegado($valor)
    {
        $sql = "SELECT cedula AS id, 
                   CONCAT(nombre, ' ', apellido, ' - ', cedula) AS text 
            FROM jugadores 
            WHERE (cedula LIKE ? OR nombre LIKE ? OR apellido LIKE ?) 
              AND estatus_id = 1 
            LIMIT 10";

        $param = "%$valor%";
        return $this->selectAllMejorado($sql, [$param, $param, $param]);
    }




}
?>