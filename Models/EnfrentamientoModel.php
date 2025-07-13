<?php
class EnfrentamientoModel extends Query{
    public function __construct()
    {
        parent::__construct();
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
    
    public function selectConfiguracion()
    {
        $sql = "SELECT * FROM configuracion";
        return $this->select($sql);
    }
    
    public function getJuegos()
    {
        $sql = "SELECT * FROM juegos";
        return $this->selectAll($sql);
    }
    public function getEquipos()
    {
        $sql = "SELECT * FROM equipos";
        return $this->selectAll($sql);
    }
}
?>