<?php include "Views/Templates/header.php"; ?>

<style>
@media (max-width: 600px) {
    .welcome-card {
        flex-direction: column !important;
        padding: 24px 8px !important;
        gap: 22px !important;
        text-align: center;
        align-items: center !important;
        justify-content: center !important;
    }
    .welcome-card h1 {
        font-size: 2rem !important;
        line-height: 1.2 !important;
        text-align: center !important;
    }
    .welcome-card h2 {
        font-size: 1.3rem !important;
        text-align: center !important;
    }
    .welcome-card img {
        width: 260px !important;
        display: block;
        margin: 0 auto !important;
    }
    .welcome-card > div {
        min-width: unset !important;
        flex: 1 1 100% !important;
        display: flex;
        flex-direction: column;
        align-items: center !important;
    }
}
</style>
<div class="welcome-card" style="display: flex; flex-wrap: wrap; align-items: center; background:rgb(255, 255, 255); border-radius: 14px; padding: 28px 32px; margin-bottom: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); gap: 32px;">
    <div style="flex: 1 1 340px; min-width: 240px;">
        <h1 style="margin: 0 0 12px 0; font-size: 2.2rem; font-weight: 900; color: #b59b2a; letter-spacing: -1.5px; line-height: 1.15;">
            ¡Bienvenido al Sistema ASOBOCOPA!
        </h1>
        <h2 style="margin: 0 0 18px 0; font-size: 1.22rem; font-weight: 700; color: #a68c1d;">
            Hola, <span style="color: #f43f5e;"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
        </h2>
        <div style="color: #166534; font-size: 1.09rem; line-height: 1.7;">
            <a href="<?php echo base_url; ?>Perfil" style="display: inline-block; background: #166534; color: #fff; text-decoration: none; font-weight: 700; border-radius: 8px; padding: 10px 28px; margin-top: 8px; box-shadow: 0 2px 10px rgba(181,155,42,0.13); transition: background 0.2s;">
                <i class="fa fa-user" style="margin-right: 7px;"></i>Ver mi perfil
            </a>
        </div>
    </div>
    <div style="flex: 0 0 260px; display: flex; justify-content: center; align-items: center;">
        <div style="border-radius: 16px;">
            <img src="<?php echo base_url; ?>/Assets/img/bolas.png" alt="Bolas criollas" style="width: 360px; max-width: 100%; height: auto; display: block;">
        </div>
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
