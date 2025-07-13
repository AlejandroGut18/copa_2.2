<?php
session_start();

if (isset($_SESSION['nombre'])) {
    // Renueva el tiempo de última actividad
    $_SESSION['ULTIMA_ACTIVIDAD'] = time();
    echo json_encode(['status' => 'ok']);
} else {
    // La sesión ha caducado
    echo json_encode(['status' => 'expired']);
}
?>
