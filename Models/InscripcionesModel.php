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
                FROM inscripciones i
                INNER JOIN torneos t ON i.torneo_id = t.id
                INNER JOIN equipos e ON i.equipo_id = e.id
                LEFT JOIN grupos g ON i.grupo_id = g.id
                ORDER BY i.id DESC";

        return $this->selectAll($sql);
    }

    public function insertarInscripcion($torneo_id, $grupo_id, $equipo_id, $genero, $status_id)
    {
        $verificar = "SELECT * FROM inscripciones WHERE torneo_id = ? AND equipo_id = ? LIMIT 1";
        $existe = $this->selectAllMejorado($verificar, [$torneo_id, $equipo_id]);

        if (empty($existe)) {
            $query = "INSERT INTO inscripciones(torneo_id, grupo_id, equipo_id, genero, status_id, fecha_inscripcion) 
                    VALUES (?, ?, ?, ?, ?, CURDATE())";
            $datos = [$torneo_id, $grupo_id, $equipo_id, $genero, $status_id];
            $data = $this->save($query, $datos);

            return ($data == 1) ? "ok" : "error";
        } else {
            return "existe"; // Ya inscrito en ese torneo
        }
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
        INNER JOIN inscripciones i ON ij.inscripcion_id = i.id
        WHERE i.id = $id AND ij.jugador_id = $jugador_id";
        return $this->select($sql);
    }
    public function getInscripcion($id)
    {
        $sql = "SELECT id, torneo_id, grupo_id, equipo_id, genero, status_id 
        FROM inscripciones 
        WHERE id = $id";
        return $this->select($sql);
    }
    public function actualizarInscripcion($torneo_id, $grupo_id, $equipo_id, $genero, $status_id, $id)
    {
        $query = "UPDATE inscripciones SET torneo_id = ?, grupo_id = ?, equipo_id = ?, genero = ?, status_id = ? WHERE id = ?";
        $datos = array($torneo_id, $grupo_id, $equipo_id, $genero, $status_id, $id);
        $data = $this->save($query, $datos);

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
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
    public function estadoInscJugador($status_id, $inscripcion_id, $jugador_id)
{
    $sql = "UPDATE inscripcion_jugadores SET status_id = ? WHERE inscripcion_id = ? AND jugador_id = ?";
        $datos = array($status_id, $inscripcion_id, $jugador_id);
        $data = $this->save($sql, $datos);
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

    public function getInscripcionByEquipo($torneo, $genero, $equipo)
    {
        $sql = "SELECT id FROM inscripciones 
            WHERE torneo_id = ? AND genero = ? AND equipo_id = ? LIMIT 1";
        $params = [$torneo, $genero, $equipo];
        return $this->selectAllMejorado($sql, $params);
    }

    public function insertarInscJugador($inscripcion_id, $jugador_id, $status_id)
    {
        $sqlTorneo = "SELECT torneo_id FROM inscripciones WHERE id = ?";
        $inscripcion = $this->selectAllMejorado($sqlTorneo, [$inscripcion_id]);

        if (empty($inscripcion)) {
            return "error"; // No existe la inscripción
        }
        $torneo_id = $inscripcion[0]['torneo_id'];

        // 2. Verificar si el jugador ya está inscrito en el mismo torneo (en cualquier equipo)
        $verificarTorneo = "SELECT ij.* 
        FROM inscripcion_jugadores ij
        INNER JOIN inscripciones i ON ij.inscripcion_id = i.id
        WHERE i.torneo_id = ? AND ij.jugador_id = ? LIMIT 1";
        $repetido = $this->selectAllMejorado($verificarTorneo, [$torneo_id, $jugador_id]);

        if (!empty($repetido)) {
            return "repetido"; // Ya está inscrito en ese torneo
        }
        $verificar = "SELECT * FROM inscripcion_jugadores 
              WHERE inscripcion_id = ? AND jugador_id = ? LIMIT 1";
        $existe = $this->selectAllMejorado($verificar, [$inscripcion_id, $jugador_id]);

        // 3. Validar que no haya más de 10 jugadores en esta inscripción (equipo en torneo)
        $consultaMaximo = "SELECT COUNT(*) AS total FROM inscripcion_jugadores WHERE inscripcion_id = ? and status_id = 1";
        $jugadores = $this->selectAllMejorado($consultaMaximo, [$inscripcion_id]);

        if (!empty($jugadores) && $jugadores[0]['total'] >= 4) {
            return "limite"; // Ya alcanzó el máximo de jugadores para esta inscripción
        }        

        if (empty($existe)) {
            // 4. Insertar al jugador en esa inscripción con status_id
            $query = "INSERT INTO inscripcion_jugadores(inscripcion_id, jugador_id, status_id) VALUES (?, ?, ?)";
            $datos = [$inscripcion_id, $jugador_id, $status_id];
            $data = $this->save($query, $datos);

            return ($data == 1) ? "ok" : "error";
        } else {
            return "existe"; // Ya está en ese equipo (esto podría ser redundante si ya se revisó arriba)
        }
    }



}
?>