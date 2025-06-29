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
                FROM 
                    juegos j
                INNER JOIN torneos t ON j.torneo_id = t.id
                INNER JOIN equipos e1 ON j.equipo_id = e1.id
                INNER JOIN equipos e2 ON j.vs_equipo_id = e2.id";
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
                j.*, 
                (
                    SELECT puntos 
                    FROM detalles_juego dj 
                    WHERE dj.juego_id = j.id AND dj.equipo_id = j.equipo_id 
                    LIMIT 1
                ) AS puntos_equipo,
                (
                    SELECT puntos 
                    FROM detalles_juego dj 
                    WHERE dj.juego_id = j.id AND dj.equipo_id = j.vs_equipo_id 
                    LIMIT 1
                ) AS puntos_vs_equipo
            FROM juegos j
            WHERE j.id = ?";
        return $this->select($sql);
    }

    public function actualizarJuego($torneo_id, $equipo_id, $vs_equipo_id, $puntos_equipo, $puntos_vs_equipo, $status_id, $detalle_calendario_id, $id)
    {
        $query = "UPDATE juegos SET torneo_id = ?, equipo_id = ?, vs_equipo_id = ?, puntos_equipo = ?, puntos_vs_equipo = ?, status_id = ?, detalle_calendario_id = ? 
                  WHERE id = ?";
        $datos = array($torneo_id, $equipo_id, $vs_equipo_id, $puntos_equipo, $puntos_vs_equipo, $status_id, $detalle_calendario_id, $id);
        $data = $this->save($query, $datos);

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }

        return $res;
    }

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
public function guardarDetalleJuego($juego_id, $equipo_id, $puntos, $vs_equipo_id, $puntos_vs_equipo)
{
    $query = "SELECT COUNT(*) as total FROM detalles_juegos WHERE juego_id = ? AND equipo_id = ?";
    $datos = array($juego_id, $equipo_id);
    $result = $this->select($query, $datos);

    if ($result && $result['total'] > 0) {
        // UPDATE
        $query = "UPDATE detalles_juegos 
                  SET puntos = ?, vs_equipo_id = ?, puntos_vs_equipo = ?
                  WHERE juego_id = ? AND equipo_id = ?";
        $datos = array($puntos, $vs_equipo_id, $puntos_vs_equipo, $juego_id, $equipo_id);
        $data = $this->save($query, $datos);
        return ($data == 1) ? "modificado" : "error";
    } else {
        // INSERT
        $query = "INSERT INTO detalles_juegos 
                  (juego_id, equipo_id, puntos, vs_equipo_id, puntos_vs_equipo)
                  VALUES (?, ?, ?, ?, ?)";
        $datos = array($juego_id, $equipo_id, $puntos, $vs_equipo_id, $puntos_vs_equipo);
        $data = $this->save($query, $datos);
        return ($data == 1) ? "ok" : "error";
    }
}


}
