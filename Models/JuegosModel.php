<?php
class JuegosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getJuegos()
    {
        $sql = "SELECT 
                    j.id                    AS id,
                    t.nombre                AS torneo,
                    e1.nombre               AS equipo,
                    COALESCE(dj.puntos, 0)         AS puntos_equipo,
                    e2.nombre               AS vs_equipo,
                    COALESCE(dj.puntos_vs, 0)      AS puntos_vs_equipo,
                    j.genero,
                    j.fecha                 AS fecha_juego,
                    j.hora,
                    j.status_id
                FROM 
                    juegos j
                INNER JOIN torneos t     ON j.torneo_id   = t.id
                INNER JOIN equipos e1    ON j.equipo_id    = e1.id
                INNER JOIN equipos e2    ON j.vs_equipo_id = e2.id
                LEFT JOIN detalles_juego dj 
                                    ON dj.juego_id    = j.id";
        return $this->selectAll($sql);
    }


    public function insertarJuego($torneo_id, $grupo_id, $equipo_id, $vs_equipo_id, $genero, $fecha, $hora, $status_id)
    {
        // Verifica si ya existe un juego con estos parámetros
        $existe = $this->verificarJuegoExiste($torneo_id, $grupo_id, $equipo_id, $vs_equipo_id, $genero, $fecha, $hora);

        if (!empty($existe)) {
            return "existe";
        }

        $query = "INSERT INTO juegos (torneo_id, grupo_id, equipo_id, vs_equipo_id, genero, fecha, hora, status_id)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $datos = array($torneo_id, $grupo_id, $equipo_id, $vs_equipo_id, $genero, $fecha, $hora, $status_id);
        $data = $this->save($query, $datos);

        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function verificarJuegoExiste($torneo_id, $grupo_id, $equipo_id, $vs_equipo_id, $genero, $fecha, $hora)
    {
        $sql = "SELECT id FROM juegos 
            WHERE torneo_id = ? 
              AND grupo_id = ? 
              AND equipo_id = ? 
              AND vs_equipo_id = ? 
              AND genero = ? 
              AND fecha = ? 
              AND hora = ?";

        $datos = array($torneo_id, $grupo_id, $equipo_id, $vs_equipo_id, $genero, $fecha, $hora);

        return $this->selectAllMejorado($sql, $datos);
    }


    public function getJuego($id)
    {
        $sql = "SELECT 
                j.id,
                j.fecha AS fecha_juego,
                j.hora,
                j.status_id,
                e1.nombre AS equipo1,
                e1.logo AS logo1,
                e2.nombre AS equipo2,
                e2.logo AS logo2
            FROM juegos j
            INNER JOIN equipos e1 ON j.equipo_id = e1.id
            INNER JOIN equipos e2 ON j.vs_equipo_id = e2.id
            WHERE j.id = ? 
            LIMIT 1";

        return $this->selectMejorado($sql, [$id]);
    }
    public function actualizarFechaHora($id, $fecha, $hora)
    {
        $sql = "UPDATE juegos SET fecha = ?, hora = ? WHERE id = ?";
        return $this->save($sql, [$fecha, $hora, $id]);
    }


    // public function actualizarJuego($torneo_id, $equipo_id, $vs_equipo_id, $puntos_equipo, $puntos_vs_equipo, $status_id, $detalle_calendario_id, $id)
    // {
    //     $query = "UPDATE juegos SET torneo_id = ?, equipo_id = ?, vs_equipo_id = ?, puntos_equipo = ?, puntos_vs_equipo = ?, status_id = ?, detalle_calendario_id = ? 
    //               WHERE id = ?";
    //     $datos = array($torneo_id, $equipo_id, $vs_equipo_id, $puntos_equipo, $puntos_vs_equipo, $status_id, $detalle_calendario_id, $id);
    //     $data = $this->save($query, $datos);

    //     if ($data == 1) {
    //         $res = "modificado";
    //     } else {
    //         $res = "error";
    //     }

    //     return $res;
    // }

    public function estadoJuego($status_id, $id)
    {
        $query = "UPDATE juegos SET status_id = ? WHERE id = ?";
        $datos = array($status_id, $id);
        return $this->save($query, $datos);
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
    // public function guardarDetalleJuego($juego_id, $equipo_id, $puntos, $vs_equipo_id, $puntos_vs_equipo)
    // {
    //     $query = "SELECT COUNT(*) as total FROM detalles_juegos WHERE juego_id = ? AND equipo_id = ?";
    //     $datos = array($juego_id, $equipo_id);
    //     $result = $this->selectMejorado($query, $datos);

    //     if ($result && $result['total'] > 0) {
    //         // UPDATE
    //         $query = "UPDATE detalles_juegos 
    //               SET puntos = ?, vs_equipo_id = ?, puntos_vs_equipo = ?
    //               WHERE juego_id = ? AND equipo_id = ?";
    //         $datos = array($puntos, $vs_equipo_id, $puntos_vs_equipo, $juego_id, $equipo_id);
    //         $data = $this->save($query, $datos);
    //         return ($data == 1) ? "modificado" : "error";
    //     } else {
    //         // INSERT
    //         $query = "INSERT INTO detalles_juegos 
    //               (juego_id, equipo_id, puntos, vs_equipo_id, puntos_vs_equipo)
    //               VALUES (?, ?, ?, ?, ?)";
    //         $datos = array($juego_id, $equipo_id, $puntos, $vs_equipo_id, $puntos_vs_equipo);
    //         $data = $this->save($query, $datos);
    //         return ($data == 1) ? "ok" : "error";
    //     }
    // }

    // filtros
    public function filtrarJuegos($torneo, $equipo, $genero, $estado)
    {
        $sql = "SELECT 
                j.id AS id,
                t.nombre AS torneo,
                e1.nombre AS equipo,
                (
                    SELECT dj.puntos 
                    FROM detalles_juego dj 
                    WHERE dj.juego_id = j.id AND dj.equipo_id = j.equipo_id
                    LIMIT 1
                ) AS puntos_equipo,
                e2.nombre AS vs_equipo,
                (
                    SELECT dj.puntos 
                    FROM detalles_juego dj 
                    WHERE dj.juego_id = j.id AND dj.equipo_id = j.vs_equipo_id
                    LIMIT 1
                ) AS puntos_vs_equipo,
                j.genero,
                j.fecha AS fecha_juego,
                j.hora,
                j.status_id
            FROM juegos j
            INNER JOIN torneos t ON j.torneo_id = t.id
            INNER JOIN equipos e1 ON j.equipo_id = e1.id
            INNER JOIN equipos e2 ON j.vs_equipo_id = e2.id
            WHERE 1";

        $params = [];

        if (!empty($torneo)) {
            $sql .= " AND j.torneo_id = ?";
            $params[] = $torneo;
        }

        if (!empty($genero)) {
            $sql .= " AND j.genero = ?";
            $params[] = $genero;
        }

        if (!empty($equipo)) {
            $sql .= " AND (j.equipo_id = ? OR j.vs_equipo_id = ?)";
            $params[] = $equipo;
            $params[] = $equipo;
        }

        if ($estado !== '') {
            $sql .= " AND j.status_id = ?";
            $params[] = $estado;
        }

        return $this->selectAllMejorado($sql, $params);
    }

    //funciones para generar los enfrentaminetos:
    public function getEquiposPorGrupo($torneo_id, $genero)
    {
        $sql = "SELECT ie.equipo_id, e.nombre, g.nombre AS grupo
            FROM inscripciones_equipos ie
            INNER JOIN equipos e ON ie.equipo_id = e.id
            INNER JOIN grupos g ON ie.grupo_id = g.id
            WHERE ie.torneo_id = ? AND ie.genero = ? AND ie.grupo_id IS NOT NULL AND ie.status_id = 1";
        return $this->selectAllMejorado($sql, [$torneo_id, $genero]);
    }

    public function crearEnfrentamientosPorGrupo($equipos, $torneo_id, $genero)
    {
        $grupos = [];
        foreach ($equipos as $eq) {
            $grupos[$eq['grupo']][] = $eq['equipo_id'];
        }

        foreach ($grupos as $grupo_letra => $grupo_equipos) {
            $grupo_id = $this->obtenerGrupoId($torneo_id, $genero, $grupo_letra);
            $n = count($grupo_equipos);

            for ($i = 0; $i < $n; $i++) {
                for ($j = $i + 1; $j < $n; $j++) {
                    $sql = "INSERT INTO juegos (torneo_id, grupo_id, equipo_id, vs_equipo_id, genero, status_id)
                        VALUES (?, ?, ?, ?, ?, 3)";
                    $this->save($sql, [$torneo_id, $grupo_id, $grupo_equipos[$i], $grupo_equipos[$j], $genero]);
                }
            }
        }

        return true;
    }

    private function obtenerGrupoId($torneo_id, $genero, $letra)
    {
        $sql = "SELECT id FROM grupos WHERE torneo_id = ? AND genero = ? AND nombre = ? LIMIT 1";
        $grupo = $this->selectMejorado($sql, [$torneo_id, $genero, $letra]);
        return $grupo['id'] ?? null;
    }



    // funcion para mostrar los detalles de los juegos y sus jugadores

    public function getDetallesJuego($juego_id)
    {
        // 1. Obtener datos básicos del juego y equipos
        $sql = "SELECT 
                j.id,
                j.fecha AS fecha_juego,
                j.hora,
                j.status_id,
                j.equipo_id,
                j.vs_equipo_id,
                e1.nombre AS equipo1,
                e1.logo AS logo1,
                e2.nombre AS equipo2,
                e2.logo AS logo2
            FROM juegos j
            INNER JOIN equipos e1 ON j.equipo_id = e1.id
            INNER JOIN equipos e2 ON j.vs_equipo_id = e2.id
            WHERE j.id = ?
            LIMIT 1";

        $juego = $this->selectMejorado($sql, [$juego_id]);
        if (!$juego)
            return null;

        $equipo1_id = $juego['equipo_id'];
        $equipo2_id = $juego['vs_equipo_id'];

        // 2. Obtener puntos del juego
        $sqlPuntos = "SELECT puntos, puntos_vs FROM detalles_juego WHERE juego_id = ?";
        $puntos = $this->selectMejorado($sqlPuntos, [$juego_id]);

        $juego['puntos'] = $puntos['puntos'] ?? 0;
        $juego['puntos_vs'] = $puntos['puntos_vs'] ?? 0;

        // 3. Obtener inscripcion_id para cada equipo
        $sqlIns = "SELECT id FROM inscripciones_equipos WHERE equipo_id = ? LIMIT 1";
        $inscripcion1 = $this->selectMejorado($sqlIns, [$equipo1_id]);
        $inscripcion2 = $this->selectMejorado($sqlIns, [$equipo2_id]);

        $inscripcion1_id = $inscripcion1['id'] ?? 0;
        $inscripcion2_id = $inscripcion2['id'] ?? 0;

        // 4. Obtener jugadores y rendimiento para equipo 1
        $sqlJugadores = "SELECT j.cedula, j.nombre, j.apellido,
                            COALESCE(d.arrimesL, 0) AS arrimesL,
                            COALESCE(d.arrimesB, 0) AS arrimesB,
                            COALESCE(d.bochesL, 0) AS bochesL,
                            COALESCE(d.bochesB, 0) AS bochesB,
                            COALESCE(d.rastererosL, 0) AS rastererosL,
                            COALESCE(d.rastrerosB, 0) AS rastrerosB
                     FROM inscripcion_equipo_jugadores ij
                     INNER JOIN jugadores j ON ij.jugador_id = j.cedula
                     LEFT JOIN detalles_jugador d ON d.juego_id = ? AND d.jugador_id = j.cedula AND d.inscripcion_id = ij.inscripcion_id
                     WHERE ij.inscripcion_id = ? AND ij.status_id = 1";

        $jugadores1 = $this->selectAllMejorado($sqlJugadores, [$juego_id, $inscripcion1_id]);

        // 5. Obtener jugadores y rendimiento para equipo 2
        $jugadores2 = $this->selectAllMejorado($sqlJugadores, [$juego_id, $inscripcion2_id]);

        // 6. Retornar datos
        return [
            'juego' => $juego,
            'equipo1' => [
                'nombre' => $juego['equipo1'],
                'logo' => $juego['logo1'],
                'inscripcion_id' => $inscripcion1_id,
                'jugadores' => $jugadores1
            ],
            'equipo2' => [
                'nombre' => $juego['equipo2'],
                'logo' => $juego['logo2'],
                'inscripcion_id' => $inscripcion2_id,
                'jugadores' => $jugadores2
            ]
        ];
    }
    // inserta los dato del juego 
    /**
     * Inserta o actualiza puntos en detalles_juego y rendimiento en detalles_jugador.
     *
     * @param int   $juego_id
     * @param int   $ins1_id
     * @param int   $ins2_id
     * @param int   $p1
     * @param int   $p2
     * @param array $rendimiento  Estructura: ['equipo1'=>[jugId=>[arrimesL=>...,...]], 'equipo2'=>[...] ]
     * @return bool
     */
    public function guardarDetalleJuego($juego_id, $ins1_id, $ins2_id, $p1, $p2, $rendimiento)
    {
        // 1) actualizar/insertar detalles_juego
        $sqlDJ = "INSERT INTO detalles_juego (juego_id, puntos, puntos_vs)
              VALUES (?, ?, ?)
              ON DUPLICATE KEY UPDATE puntos = ?, puntos_vs = ?";
        $this->save($sqlDJ, [$juego_id, $p1, $p2, $p1, $p2]);

        // 2) para cada equipo y jugador
        $sqlR = "INSERT INTO detalles_jugador
                (juego_id, inscripcion_id, jugador_id,
                 arrimesL, arrimesB, bochesL, bochesB, rastererosL, rastrerosB)
             VALUES (?,?,?,?,?,?,?,?,?)
             ON DUPLICATE KEY UPDATE
               arrimesL    = ?,
               arrimesB    = ?,
               bochesL     = ?,
               bochesB     = ?,
               rastererosL = ?,
               rastrerosB  = ?";

        // recorre ambos grupos
        foreach (['equipo1' => $ins1_id, 'equipo2' => $ins2_id] as $grupoKey => $ins_id) {
            if (!isset($rendimiento[$grupoKey]))
                continue;
            foreach ($rendimiento[$grupoKey] as $jugId => $vals) {
                $params = [
                    $juego_id,
                    $ins_id,
                    $jugId,
                    $vals['arrimesL'],
                    $vals['arrimesB'],
                    $vals['bochesL'],
                    $vals['bochesB'],
                    $vals['rastererosL'],
                    $vals['rastrerosB'],
                    // para UPDATE
                    $vals['arrimesL'],
                    $vals['arrimesB'],
                    $vals['bochesL'],
                    $vals['bochesB'],
                    $vals['rastererosL'],
                    $vals['rastrerosB'],
                ];
                $this->save($sqlR, $params);
            }
        }

        return true;
    }



}
