<?php
class PrestamosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPrestamos()
    {
        $sql = "SELECT t.id, t.nombre, t.fecha_inicio, t.fecha_fin, 
                       u.nombre AS ubicacion, s.nombre AS estado 
                FROM torneos t
                INNER JOIN ubicaciones u ON t.ubicacion_id = u.id
                INNER JOIN status s ON t.status_id = s.id";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function insertarTorneo($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id)
    {
        // Verificar si ya existe un torneo con el mismo nombre en las mismas fechas
        $verificar = "SELECT * FROM torneos 
                      WHERE nombre = '$nombre' 
                      AND fecha_inicio = '$fecha_inicio' 
                      AND ubicacion_id = $ubicacion_id";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            $query = "INSERT INTO torneos(nombre, fecha_inicio, fecha_fin, ubicacion_id, status_id) 
                      VALUES (?,?,?,?,?)";
            $datos = array($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id);
            $data = $this->insert($query, $datos);
            
            if ($data > 0) {
                $res = $data;
            } else {
                $res = 0;
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    
    public function actualizarTorneo($id, $nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id)
    {
        $sql = "UPDATE torneos 
                SET nombre = ?, 
                    fecha_inicio = ?, 
                    fecha_fin = ?, 
                    ubicacion_id = ?, 
                    status_id = ? 
                WHERE id = ?";
        $datos = array($nombre, $fecha_inicio, $fecha_fin, $ubicacion_id, $status_id, $id);
        $data = $this->save($sql, $datos);
        
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    
    public function eliminarTorneo($id)
    {
        // Primero verificar si hay registros relacionados
        $verificar = "SELECT * FROM partidos WHERE torneo_id = $id";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            $sql = "DELETE FROM torneos WHERE id = ?";
            $datos = array($id);
            $data = $this->save($sql, $datos);
            
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "relacionado";
        }
        return $res;
    }
    
    public function getTorneo($id)
    {
        $sql = "SELECT t.*, u.nombre AS ubicacion, s.nombre AS estado 
                FROM torneos t
                INNER JOIN ubicaciones u ON t.ubicacion_id = u.id
                INNER JOIN status s ON t.status_id = s.id
                WHERE t.id = $id";
        $res = $this->select($sql);
        return $res;
    }
    
    public function getUbicaciones()
    {
        $sql = "SELECT * FROM ubicaciones";
        $res = $this->selectAll($sql);
        return $res;
    }
    
    public function getEstados()
    {
        $sql = "SELECT * FROM status WHERE tipo = 'torneo'";
        $res = $this->selectAll($sql);
        return $res;
    }

    /////
    public function insertarPrestamo($estudiante,$libro, $cantidad, string $fecha_prestamo, string $fecha_devolucion, string $observacion)
    {
        $verificar = "SELECT * FROM prestamo WHERE id_libro = '$libro' AND id_estudiante = $estudiante AND estado = 1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO prestamo(id_estudiante, id_libro, fecha_prestamo, fecha_devolucion, cantidad, observacion) VALUES (?,?,?,?,?,?)";
            $datos = array($estudiante, $libro, $fecha_prestamo, $fecha_devolucion, $cantidad, $observacion);
            $data = $this->insert($query, $datos);
            if ($data > 0) {
                $lib = "SELECT * FROM libro WHERE id = $libro";
                $resLibro = $this->select($lib);
                $total = $resLibro['cantidad'] - $cantidad;
                $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
                $datosLibro = array($total, $libro);
                $this->save($libroUpdate, $datosLibro);
                $res = $data;
            } else {
                $res = 0;
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function actualizarPrestamo($estado, $id)
    {
        $sql = "UPDATE prestamo SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $lib = "SELECT * FROM prestamo WHERE id = $id";
            $resLibro = $this->select($lib);
            $id_libro = $resLibro['id_libro'];
            $lib = "SELECT * FROM libro WHERE id = $id_libro";
            $residLibro = $this->select($lib);
            $total = $residLibro['cantidad'] + $resLibro['cantidad'];
            $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
            $datosLibro = array($total, $id_libro);
            $this->save($libroUpdate, $datosLibro);
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function selectDatos()
    {
        $sql = "SELECT * FROM configuracion";
        $res = $this->select($sql);
        return $res;
    }
    public function getCantLibro($libro)
    {
        $sql = "SELECT * FROM libro WHERE id = $libro";
        $res = $this->select($sql);
        return $res;
    }
   
    public function getPrestamoLibro($id_prestamo)
    {
        $sql = "SELECT e.id, e.codigo, e.nombre, e.carrera, l.id, l.titulo, p.id, p.id_estudiante, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.observacion, p.estado FROM estudiante e INNER JOIN libro l INNER JOIN prestamo p ON p.id_estudiante = e.id WHERE p.id_libro = l.id AND p.id = $id_prestamo";
        $res = $this->select($sql);
        return $res;
    }

    public function selectPrestamoDebe()
    {
        $sql = "SELECT e.id, e.nombre, l.id, l.titulo, p.id, p.id_estudiante, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.observacion, p.estado FROM estudiante e INNER JOIN libro l INNER JOIN prestamo p ON p.id_estudiante = e.id WHERE p.id_libro = l.id AND p.estado = 1 ORDER BY e.nombre ASC";
        $res = $this->selectAll($sql);
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
