<?php
class UbicacionModel extends Query
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
    public function getUbicaciones()
    {
        $sql = "SELECT u.*, s.nombre AS estado 
        FROM ubicaciones u 
        INNER JOIN status s ON u.status_id = s.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function insertarUbicacion($nombre, $direccion, $status_id)
    {
        $verificar = "SELECT * FROM ubicaciones WHERE nombre = '$nombre'";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            $query = "INSERT INTO ubicaciones(nombre, direccion, status_id ) VALUES (?,?,?)";
            $datos = array($nombre, $direccion, $status_id);
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

    public function getUbicacion($id)
    {
        $sql = "SELECT * FROM ubicaciones WHERE id = $id";
        return $this->select($sql);
    }
    public function actualizarUbicacion($nombre, $direccion, $status_id, $id)
    {
        $query = "UPDATE ubicaciones SET nombre = ?, direccion = ? WHERE id = ?";
        $datos = array($nombre, $direccion, $status_id, $id);
        $data = $this->save($query, $datos);
        
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getUbicacionesActivas() {
        $sql = "SELECT id, nombre 
                FROM ubicaciones 
                WHERE status_id = 1 
                ORDER BY nombre";
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
}
?>