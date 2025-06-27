<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1> Panel de Administración</h1>
    </div>
</div>
<div class="dashboard-container">
    <div class="dashboard-widgets">
        <a class="widget" href="<?php echo base_url; ?>Materia">
            <span class="widget-icon"><i class="fa fa-calendar"></i></span>
            <span class="widget-title">Calendario</span>
            <span class="widget-desc">Ver eventos y partidos</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Torneos">
            <span class="widget-icon"><i class="fa fa-trophy"></i></span>
            <span class="widget-title">Torneos</span>
            <span class="widget-desc">Gestión de torneos</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Equipos">
            <span class="widget-icon"><i class="fa fa-users"></i></span>
            <span class="widget-title">Equipos</span>
            <span class="widget-desc">Listado de equipos</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Grupos">
            <span class="widget-icon"><i class="fa fa-object-group"></i></span>
            <span class="widget-title">Grupos</span>
            <span class="widget-desc">Ver y organizar grupos</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Juegos">
            <span class="widget-icon"><i class="fa fa-futbol-o"></i></span>
            <span class="widget-title">Juegos</span>
            <span class="widget-desc">Partidos y resultados</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Jugadores">
            <span class="widget-icon"><i class="fa fa-user"></i></span>
            <span class="widget-title">Jugadores</span>
            <span class="widget-desc">Gestión de jugadores</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Usuarios">
            <span class="widget-icon"><i class="fa fa-user-circle"></i></span>
            <span class="widget-title">Usuarios</span>
            <span class="widget-desc">Administrar usuarios</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Configuracion">
            <span class="widget-icon"><i class="fa fa-cogs"></i></span>
            <span class="widget-title">Configuración</span>
            <span class="widget-desc">Preferencias del sistema</span>
        </a>
        <a class="widget" href="<?php echo base_url; ?>Reportes">
            <span class="widget-icon"><i class="fa fa-file-pdf-o"></i></span>
            <span class="widget-title">Reportes</span>
            <span class="widget-desc">Reportes generados</span>
        </a>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
