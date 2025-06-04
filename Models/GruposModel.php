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
    public function insertarGrupo($nombre, $status_id, $torneo_id, $genero)
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

    public function getGrupo($id)
    {
        $sql = "SELECT * FROM grupo WHERE id = $id";
        return $this->select($sql);
    }
    public function actualizarGrupo($nombre, $status_id, $torneo_id, $genero, $id)
    {
        $query = "UPDATE grupos SET nombre = ?, status_id = ?, torneo_id = ?, genero = ? WHERE id = ?";
        $datos = array($nombre, $status_id, $torneo_id, $genero, $id);
        $data = $this->save($query, $datos);

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
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