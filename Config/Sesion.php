<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Config.php'; // Asegúrate de que esta ruta sea correcta

$inactividad_maxima = 600;

if (isset($_SESSION['ULTIMA_ACTIVIDAD'])) {
    $tiempo_inactivo = time() - $_SESSION['ULTIMA_ACTIVIDAD'];

    if ($tiempo_inactivo > $inactividad_maxima) {
        session_unset();
        session_destroy();
        header("Location: " . base_url . "index.php");
        exit();
    }
}

$_SESSION['ULTIMA_ACTIVIDAD'] = time();
