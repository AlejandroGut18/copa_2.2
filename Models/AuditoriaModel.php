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
}
