<?php
class AuditoriaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registrarAuditoria($usuario_id, $accion, $detalle)
    {
        $sql = "INSERT INTO auditoria (usuario_id, accion, detalle) VALUES (?, ?, ?)";
        $datos = [$usuario_id, $accion, $detalle];
        return $this->save($sql, $datos);
    }

    public function getAuditoria()
    {
        $sql = "SELECT a.id, u.nombre AS usuario, a.accion, a.detalle, a.fecha
                FROM auditoria a
                INNER JOIN usuarios u ON a.usuario_id = u.id
                ORDER BY a.id DESC";
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
