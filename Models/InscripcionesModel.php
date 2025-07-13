<?php
class InscripcionesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getInscritos()
    {
        $sql = "SELECT i.id, 
                    t.nombre AS torneo, 
                    e.nombre AS equipo, 
                    g.nombre AS grupo, 
                    i.genero, 
                    i.fecha_inscripcion,
                    i.status_id
                FROM inscripciones_equipos i
                INNER JOIN torneos t ON i.torneo_id = t.id
                INNER JOIN equipos e ON i.equipo_id = e.id
                LEFT JOIN grupos g ON i.grupo_id = g.id 
                ORDER BY i.id DESC ";

        return $this->selectAll($sql);
    }

    public function insertarInscripcion($torneo_id, $genero, $equipo_id, $status_id, $grupo_id = null)
    {
        // 1. Verificar si ya está inscrito
        $verificar = "SELECT * FROM inscripciones_equipos WHERE torneo_id = ? AND equipo_id = ? LIMIT 1";
        $existe = $this->selectMejorado($verificar, [$torneo_id, $equipo_id]);

        if (!empty($existe)) {
            return "existe"; // Ya inscrito
        }

        // 2. Verificar si ya hay 28 equipos inscritos activos
        $conteoQuery = "SELECT COUNT(*) as total FROM inscripciones_equipos 
                    WHERE torneo_id = ? AND genero = ? AND status_id = 1";
        $conteo = $this->selectAllMejorado($conteoQuery, [$torneo_id, $genero]);

        if ($conteo && $conteo[0]['total'] >= 28) {
            return "limite";
        }

        // 3. Asignar grupo automáticamente si ya hay equipos con grupo
        if (is_null($grupo_id)) {
            $checkGrupos = "SELECT COUNT(*) AS con_grupo FROM inscripciones_equipos 
                        WHERE torneo_id = ? AND genero = ? AND grupo_id IS NOT NULL AND status_id = 1";
            $gruposExistentes = $this->selectAllMejorado($checkGrupos, [$torneo_id, $genero]);

            if (!empty($gruposExistentes) && $gruposExistentes[0]['con_grupo'] > 0) {
                // Buscar grupo con menos equipos activos
                $sqlGrupos = "SELECT g.id, g.nombre, 
                            (SELECT COUNT(*) FROM inscripciones_equipos ie 
                             WHERE ie.grupo_id = g.id AND ie.status_id = 1 AND ie.genero = ? AND ie.torneo_id = ?) AS total
                         FROM grupos g 
                         WHERE g.torneo_id = ? AND g.genero = ?
                         ORDER BY total ASC
                         LIMIT 1";
                $grupo = $this->selectAllMejorado($sqlGrupos, [$genero, $torneo_id, $torneo_id, $genero]);

                if (!empty($grupo)) {
                    $grupo_id = $grupo[0]['id'];
                }
            }
        }

        // 4. Insertar inscripción
        $query = "INSERT INTO inscripciones_equipos(torneo_id, grupo_id, equipo_id, genero, status_id, fecha_inscripcion) 
              VALUES (?, ?, ?, ?, ?, CURDATE())";
        $datos = [$torneo_id, $grupo_id, $equipo_id, $genero, $status_id];
        $inscripcion_id = $this->save($query, $datos, true);

        // 5. Verificar si hay equipo retirado en ese grupo para sustituir
        if (is_numeric($inscripcion_id) && $grupo_id) {
            // Buscar el equipo retirado en ese grupo (status ≠ 1)
            $sqlRetirado = "SELECT equipo_id FROM inscripciones_equipos 
                        WHERE torneo_id = ? AND grupo_id = ? AND genero = ? AND status_id != 1
                        LIMIT 1";
            $equipoRetirado = $this->selectMejorado($sqlRetirado, [$torneo_id, $grupo_id, $genero]);

            if (!empty($equipoRetirado)) {
                $equipoAntiguo = $equipoRetirado['equipo_id'];

                // Actualizar todos los juegos donde ese equipo esté como equipo_id o vs_equipo_id
                $sqlUpdateJuegos1 = "UPDATE juegos 
                                 SET equipo_id = ? 
                                 WHERE torneo_id = ? AND grupo_id = ? AND genero = ? AND equipo_id = ?";
                $this->save($sqlUpdateJuegos1, [$equipo_id, $torneo_id, $grupo_id, $genero, $equipoAntiguo]);

                $sqlUpdateJuegos2 = "UPDATE juegos 
                                 SET vs_equipo_id = ? 
                                 WHERE torneo_id = ? AND grupo_id = ? AND genero = ? AND vs_equipo_id = ?";
                $this->save($sqlUpdateJuegos2, [$equipo_id, $torneo_id, $grupo_id, $genero, $equipoAntiguo]);
            }
        }

        return is_numeric($inscripcion_id) ? $inscripcion_id : "error";
    }



    public function getInscripcionJug($id, $jugador_id)
    {
        $sql = "SELECT 
            i.id,~
            ij.jugador_id,
            i.torneo_id,
            i.genero,
            i.equipo_id
        FROM inscripcion_jugadores ij
        INNER JOIN inscripciones_equipos i ON ij.inscripcion_id = i.id
        WHERE i.id = $id AND ij.jugador_id = $jugador_id";
        return $this->select($sql);
    }
    public function getInscripcion($id)
    {
        $sql = "SELECT id, torneo_id, grupo_id, equipo_id, genero, status_id 
        FROM inscripciones_equipos 
        WHERE id = $id";
        return $this->select($sql);
    }
    public function getJugadoresByInscripcion($inscripcion_id)
    {
        $sql = "SELECT jugador_id FROM inscripcion_equipo_jugadores WHERE inscripcion_id = ? AND status_id = 1";
        return $this->selectAllMejorado($sql, [$inscripcion_id]);
    }

    public function actualizarInscripcion($id, $torneo, $genero, $equipo)
    {
        $sql = "UPDATE inscripciones_equipos SET torneo_id = ?, genero = ?, equipo_id = ? WHERE id = ?";
        return $this->save($sql, [$torneo, $genero, $equipo, $id]);
    }

    // Retorna los jugadores asociados a una inscripción (activos e inactivos)
    public function obtenerJugadoresEquipo($inscripcion_id)
    {
        $sql = "SELECT jugador_id 
                    FROM inscripcion_equipo_jugadores WHERE
                    inscripcion_id = ? ";
        return $this->selectAllMejorado($sql, [$inscripcion_id]);
    }

    // Cambia el estado de un jugador en una inscripción
    public function cambiarEstadoIncripcionJugador($inscripcion_id, $jugador_id, $status_id)
    {
        $sql = "UPDATE inscripcion_equipo_jugadores SET status_id = ? WHERE inscripcion_id = ? AND jugador_id = ?";
        return $this->save($sql, [$status_id, $inscripcion_id, $jugador_id]);
    }

    // Agrega un nuevo jugador a la inscripción
    public function agregarJugadorAInscripcion($inscripcion_id, $jugador_id)
    {
        $sql = "INSERT INTO inscripcion_equipo_jugadores (inscripcion_id, jugador_id, status_id) VALUES (?, ?, 1)";
        return $this->save($sql, [$inscripcion_id, $jugador_id]);
    }

    public function estadoInscripcion($status_id, $inscripcion_id)
    {
        // 1) Actualizar la inscripción
        $sqlIns = "UPDATE inscripciones_equipos 
                   SET status_id = ? 
                   WHERE id = ?";
        $resIns = $this->save($sqlIns, [$status_id, $inscripcion_id]);

        // 2) Actualizar todos los jugadores vinculados a esa inscripción
        $sqlJug = "UPDATE inscripcion_equipo_jugadores 
                   SET status_id = ? 
                   WHERE inscripcion_id = ?";
        $resJug = $this->save($sqlJug, [$status_id, $inscripcion_id]);

        // 3) Si estamos reactivando (status_id == 1) y ambas actualizaciones fueron exitosas
        if ($status_id == 1 && $resIns && $resJug) {
            // Obtener datos de la inscripción
            $sqlDatos = "SELECT torneo_id, genero, equipo_id, grupo_id 
                     FROM inscripciones_equipos 
                     WHERE id = ?";
            $datos = $this->selectMejorado($sqlDatos, [$inscripcion_id]);
            if ($datos) {
                $torneo_id = $datos['torneo_id'];
                $genero = $datos['genero'];
                $equipo_id = $datos['equipo_id'];
                $grupo_id = $datos['grupo_id'];

                // A) Si no tenía grupo asignado pero ya hay grupos formados, asignar uno con menor carga
                if (is_null($grupo_id)) {
                    $sqlGrupos = "SELECT g.id,
                                     (SELECT COUNT(*) FROM inscripciones_equipos ie
                                      WHERE ie.grupo_id = g.id
                                        AND ie.status_id = 1
                                        AND ie.genero = ?
                                        AND ie.torneo_id = ?) AS total
                              FROM grupos g
                              WHERE g.torneo_id = ? AND g.genero = ?
                              ORDER BY total ASC
                              LIMIT 1";
                    $grupo = $this->selectAllMejorado($sqlGrupos, [$genero, $torneo_id, $torneo_id, $genero]);
                    if (!empty($grupo)) {
                        $grupo_id = $grupo[0]['id'];
                        // Actualizar grupo en la inscripción reactivada
                        $this->save(
                            "UPDATE inscripciones_equipos SET grupo_id = ? WHERE id = ?",
                            [$grupo_id, $inscripcion_id]
                        );
                    }
                } else {
                    // B) Tenía grupo: verificar si aún hay cupo en ese mismo grupo
                    // (por ejemplo, máximo 7 equipos por grupo; ajústalo si tu torneo es distinto)
                    $maxPorGrupo = 7;
                    $sqlCuenta = "SELECT COUNT(*) AS total
                              FROM inscripciones_equipos
                              WHERE torneo_id = ?
                                AND genero = ?
                                AND grupo_id = ?
                                AND status_id = 1";
                    $count = $this->selectMejorado($sqlCuenta, [$torneo_id, $genero, $grupo_id]);
                    if ($count && $count['total'] >= $maxPorGrupo) {
                        // Buscar otro grupo con espacio
                        $sqlOtro = "SELECT g.id,
                                        (SELECT COUNT(*) FROM inscripciones_equipos ie
                                         WHERE ie.grupo_id = g.id
                                           AND ie.status_id = 1
                                           AND ie.genero = ?
                                           AND ie.torneo_id = ?) AS total
                                FROM grupos g
                                WHERE g.torneo_id = ? AND g.genero = ?
                                HAVING total < ?
                                ORDER BY total ASC
                                LIMIT 1";
                        $otro = $this->selectAllMejorado($sqlOtro, [$genero, $torneo_id, $torneo_id, $genero, $maxPorGrupo]);
                        if (!empty($otro)) {
                            $nuevoGrupo = $otro[0]['id'];
                            $this->save(
                                "UPDATE inscripciones_equipos SET grupo_id = ? WHERE id = ?",
                                [$nuevoGrupo, $inscripcion_id]
                            );
                            $grupo_id = $nuevoGrupo;
                        }
                    }
                }

                // C) Si ya existen partidos generados para ese grupo, reemplazar al equipo retirado
                if ($grupo_id) {
                    // Identificar al equipo antiguo (el primero que aparezca con status != 1)
                    $sqlRet = "SELECT equipo_id
                           FROM inscripciones_equipos
                           WHERE torneo_id = ?
                             AND grupo_id = ?
                             AND genero = ?
                             AND status_id != 1
                           LIMIT 1";
                    $retirado = $this->selectMejorado($sqlRet, [$torneo_id, $grupo_id, $genero]);
                    if (!empty($retirado)) {
                        $equipoAntiguo = $retirado['equipo_id'];
                        // Reemplazar en los juegos donde aparezca
                        $this->save(
                            "UPDATE juegos
                         SET equipo_id = ?
                         WHERE torneo_id = ?
                           AND grupo_id = ?
                           AND genero = ?
                           AND equipo_id = ?",
                            [$equipo_id, $torneo_id, $grupo_id, $genero, $equipoAntiguo]
                        );
                        $this->save(
                            "UPDATE juegos
                         SET vs_equipo_id = ?
                         WHERE torneo_id = ?
                           AND grupo_id = ?
                           AND genero = ?
                           AND vs_equipo_id = ?",
                            [$equipo_id, $torneo_id, $grupo_id, $genero, $equipoAntiguo]
                        );
                    }
                }
            }
        }
        // 3) Devolver 1 si ambas consultas resultaron en éxito
        if ($resIns && $resJug) {
            return 1;
        }
        return 0;
    }
    // cuenta la cantidad de equipos activos en un torneo
    public function totalEquiposActivosEnTorneo($inscripcion_id, $genero)
    {
        $sql = "SELECT COUNT(*) AS total
            FROM inscripciones_equipos ie
            WHERE ie.torneo_id = (
                SELECT torneo_id FROM inscripciones_equipos WHERE id = ?
            )
            AND ie.genero = ?
            AND ie.status_id = 1";

        $res = $this->selectMejorado($sql, [$inscripcion_id, $genero]);
        return $res['total'] ?? 0;
    }

    public function torneoActivoPorInscripcion($inscripcion_id)
    {
        $sql = "SELECT t.status_id 
            FROM inscripciones_equipos ie
            INNER JOIN torneos t ON ie.torneo_id = t.id
            WHERE ie.id = ?";
        $res = $this->selectMejorado($sql, [$inscripcion_id]);
        return $res && $res['status_id'] == 1;
    }

    // public function estadoInscJugador($status_id, $inscripcion_id, $jugador_id)
    // {
    //     $sql = "UPDATE inscripcion_equipo_jugadores SET status_id = ? WHERE inscripcion_id = ? AND jugador_id = ?";
    //     $datos = array($status_id, $inscripcion_id, $jugador_id);
    //     $data = $this->save($sql, $datos);
    //     return $data;
    // }

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

    public function getInscripcionByEquipo($torneo, $genero, $equipo)
    {
        $sql = "SELECT id FROM inscripciones_equipos 
            WHERE torneo_id = ? AND genero = ? AND equipo_id = ? LIMIT 1";
        $params = [$torneo, $genero, $equipo];
        return $this->selectAllMejorado($sql, $params);
    }
    public function insertarInscJugador($inscripcion_id, $jugador_id, $status_id)
    {
        // 1. Obtener el torneo de la inscripción
        $sqlTorneo = "SELECT torneo_id FROM inscripciones_equipos WHERE id = ?";
        $inscripcion = $this->selectMejorado($sqlTorneo, [$inscripcion_id]);

        if (empty($inscripcion)) {
            return "error"; // No existe la inscripción
        }

        $torneo_id = $inscripcion['torneo_id'];

        // 2. Verificar si el jugador ya está inscrito en otro equipo en el mismo torneo
        $verificarTorneo = "SELECT ij.* 
            FROM inscripcion_equipo_jugadores ij
            INNER JOIN inscripciones_equipos i ON ij.inscripcion_id = i.id
            WHERE i.torneo_id = ? AND ij.jugador_id = ? LIMIT 1";
        $repetido = $this->selectMejorado($verificarTorneo, [$torneo_id, $jugador_id]);

        if (!empty($repetido)) {
            return array('estado' => 'repetido', 'jugador_id' => $jugador_id);
        }

        // 3. Verificar si ya está en esta inscripción
        $verificar = "SELECT * FROM inscripcion_equipo_jugadores 
            WHERE inscripcion_id = ? AND jugador_id = ? LIMIT 1";
        $existe = $this->selectMejorado($verificar, [$inscripcion_id, $jugador_id]);

        // 4. Verificar máximo de 10 jugadores activos
        $consultaMaximo = "SELECT COUNT(*) AS total FROM inscripcion_equipo_jugadores WHERE inscripcion_id = ? AND status_id = 1";
        $jugadores = $this->selectMejorado($consultaMaximo, [$inscripcion_id]);

        if (!empty($jugadores) && $jugadores['total'] >= 10) {
            return "limite"; // Límite alcanzado
        }

        if (empty($existe)) {
            // 5. Insertar al jugador
            $query = "INSERT INTO inscripcion_equipo_jugadores(inscripcion_id, jugador_id, status_id) VALUES (?, ?, ?)";
            $datos = [$inscripcion_id, $jugador_id, $status_id];
            $data = $this->save($query, $datos);

            return ($data == 1) ? "ok" : "error";
        } else {
            return "existe"; // Ya está en el mismo equipo
        }
    }

    // 4.1) Obtener datos de la inscripción (incluye nombres de torneo y equipo)
    public function getInscripcionCompleta($id)
    {
        $sql = "SELECT ie.id,
                   t.nombre AS torneo,
                   ie.genero,
                   e.nombre AS equipo,
                   ie.status_id
            FROM inscripciones_equipos ie
            INNER JOIN torneos t ON ie.torneo_id = t.id
            INNER JOIN equipos  e ON ie.equipo_id  = e.id
            WHERE ie.id = ?";
        return $this->selectMejorado($sql, [$id]);
    }

    // 4.2) Obtener lista de jugadores con nombre completo y status
    public function getJugadoresByInscripcionDetalle($inscripcion_id)
    {
        $sql = "SELECT j.cedula      AS jugador_id,
                   CONCAT(j.nombre,' ',j.apellido) AS nombre,
                   ij.status_id
            FROM inscripcion_equipo_jugadores ij
            INNER JOIN jugadores j ON ij.jugador_id = j.cedula
            WHERE ij.inscripcion_id = ? AND ij.status_id = 1";
        return $this->selectAllMejorado($sql, [$inscripcion_id]);
    }

    public function obtenerEquiposInscritos($torneo_id, $genero)
    {
        $sql = "SELECT e.id, e.nombre
            FROM inscripciones_equipos ie
            INNER JOIN equipos e ON ie.equipo_id = e.id
            WHERE ie.torneo_id = ? AND ie.genero = ? AND ie.status_id = 1";

        return $this->selectAllMejorado($sql, [$torneo_id, $genero]);

    }

    public function asignarEquiposAGrupos($torneo_id, $genero, $equipos)
    {
        shuffle($equipos);
        $grupos = ['A', 'B', 'C', 'D'];
        $asignaciones = [];
        $equiposPorGrupo = 7; // 28 equipos / 4 grupos

        foreach ($grupos as $letra) {
            // Obtener ID del grupo
            $sqlGrupo = "SELECT id FROM grupos WHERE torneo_id = ? AND genero = ? AND nombre = ?";
            $grupo = $this->selectAllMejorado($sqlGrupo, [$torneo_id, $genero, $letra]);

            if (empty($grupo))
                continue;
            $grupo_id = $grupo[0]['id'];

            // Asignar 7 equipos a este grupo
            for ($i = 0; $i < $equiposPorGrupo; $i++) {
                if (empty($equipos))
                    break;

                $equipo_id = array_shift($equipos);

                $sqlUpdate = "UPDATE inscripciones_equipos 
                      SET grupo_id = ? 
                      WHERE torneo_id = ? AND equipo_id = ? AND genero = ?";
                $this->save($sqlUpdate, [$grupo_id, $torneo_id, $equipo_id, $genero]);

                $asignaciones[] = [
                    "equipo_id" => $equipo_id,
                    "grupo" => $letra
                ];
            }
        }

        return $asignaciones;
    }


    public function filtrarInscripciones($torneo, $genero, $grupo, $estado)
    {
        $sql = "SELECT 
                    i.id, 
                    t.nombre AS torneo, 
                    e.nombre AS equipo, 
                    g.nombre AS grupo, 
                    i.genero, 
                    i.fecha_inscripcion, 
                    i.status_id
                FROM inscripciones_equipos i
                INNER JOIN torneos t ON i.torneo_id = t.id
                INNER JOIN equipos e ON i.equipo_id = e.id
                LEFT JOIN grupos g ON i.grupo_id = g.id
                WHERE 1=1";

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
            $sql .= " AND g.nombre = ?";
            $params[] = $grupo;
        }
        if (!empty($estado)) {
            $sql .= " AND i.status_id = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY i.id DESC";

        return $this->selectAllMejorado($sql, $params);
    }

    //devuelve los equipos segun el torneo y genero


    public function getEquiposConGrupo($torneo_id, $genero)
    {
        $sql = "SELECT ie.equipo_id, e.nombre, g.nombre AS grupo
            FROM inscripciones_equipos ie
            INNER JOIN equipos e ON ie.equipo_id = e.id
            INNER JOIN grupos g ON ie.grupo_id = g.id
            WHERE ie.torneo_id = ? AND ie.genero = ? AND ie.status_id = 1 AND ie.grupo_id IS NOT NULL
            ORDER BY g.nombre, e.nombre";

        return $this->selectAllMejorado($sql, [$torneo_id, $genero]);
    }




}
?>