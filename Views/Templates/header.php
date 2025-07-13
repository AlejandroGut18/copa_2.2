<?php
require_once __DIR__ . '/../../Config/Config.php';
require_once __DIR__ . '/../../Config/Sesion.php';

$rol_id = $_SESSION['rol_id'] ?? null;
$nombre_usuario = $_SESSION['nombre'] ?? 'Invitado';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description"
        content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description"
        content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Panel Administrativo</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link href="<?php echo base_url; ?>Assets/css/main.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/datatables.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/tippy.css">
    
    <!-- Logo -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url; ?>Assets/icons/logo1.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header" style="font-family: 'Segoe UI', 'Roboto', 'Arial', sans-serif; font-weight: bold;">
       <!--  <a class="app-header__logo" href="<?php echo base_url; ?>Configuracion/admin"
            style="font-family: 'Segoe UI', 'Roboto', 'Arial', sans-serif; font-weight: bold; font-size: 1.3rem; color: #ffffff;">
            Copa de Campeones
        </a> #222e3c -->
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <div class="logo">
            <img src="<?php echo base_url; ?>Assets/icons/logo1.ico" alt="Logo" style="width:50px;height:50px;">
            <div style="display:flex; flex-direction:column; line-height:1; margin-left:0.5rem;">
            <span style="font-size:1.6rem; font-weight:700; background: linear-gradient(to right,rgb(35, 156, 19), #ffd823); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">ASOBOCOPA</span>
            </div>
        </div>
        <!-- Sidebar toggle button-->
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!--Notification Menu-->
            <!--<li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                    aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">Libros no entregados.</li>
                    <div class="app-notification__content">
                        <li id="nombre_estudiante">

                        </li>
                    </div>
                    <li class="app-notification__footer"><a href="<?php echo base_url; ?>Configuracion/libros"
                            target="_blank">Generar Reporte.</a></li>
                </ul>
            </li>-->
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url; ?>Perfil"><i class="fa fa-user fa-lg"></i> Perfil</a>
                    </li>
                   <!-- <li style="display:none;">
                        <a class="dropdown-item" href="#" id="modalPass">
                            <i class="fa fa-cog fa-lg"></i> Configuración
                        </a>
                    </li>-->
                    <li>
                        <a class="dropdown-item salir" href="#" id="btnSalir">
                            <i class="fa fa-sign-out fa-lg"></i> Salir
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
                src="<?php echo base_url; ?>Assets/img/logo.png" alt="User Image" width="50">
            <div>
                <p class="app-sidebar__user-name"><?php echo $_SESSION['nombre'] ?></p>
                <p class="app-sidebar__user-designation"><?php echo $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <ul class="app-menu">
            <li>
                <a class="app-menu__item" href="<?php echo base_url; ?>Configuracion/admin">
                    <i class="app-menu__icon fa fa-home" style="color: #ffffff; font-size: 1.2em;"></i>
                    <span class="app-menu__label">Inicio</span>
                </a>
            </li>

            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-calendar" style="color: #ffffff;"></i>
                    <span class="app-menu__label">Calendario</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Calendario">
                            <i class="fa fa-trophy" style="margin-right: 5px;"></i>
                            Calendario Copa
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Calendario/Enfrentamiento">
                            <i class="fa fa-users" style="margin-right: 5px;"></i>
                            Calendario Juegos
                        </a>
                    </li>
                </ul>
            </li>
            
        </li>

            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <span style="display: inline-block; vertical-align: middle; margin-right: 5px;">
                        <svg height="18px" width="18px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                            fill="#ffffff" style="vertical-align: middle;">
                            <g>
                                <path class="st0"
                                    d="M102.49,0c0,27.414,0,104.166,0,137.062c0,112.391,99.33,156.25,153.51,156.25 c54.18,0,153.51-43.859,153.51-156.25c0-32.896,0-109.648,0-137.062H102.49z M256.289,50.551l-68.164,29.768v98.474l-0.049,19.53 c-0.526-0.112-47.274-10.112-47.274-78.391c0-28.17,0-69.6,0-69.6h60.385L256.289,50.551z">
                                </path>
                                <polygon class="st0"
                                    points="315.473,400.717 291.681,367.482 279.791,318.506 256,322.004 232.209,318.506 220.314,367.482 205.347,388.394 196.527,400.476 196.699,400.476 196.527,400.717 ">
                                </polygon>
                                <polygon class="st0"
                                    points="366.93,432.24 366.93,432 145.07,432 145.07,511.598 145.07,511.76 145.07,511.76 145.07,512 366.93,512 366.93,432.402 366.93,432.24 ">
                                </polygon>
                                <path class="st0"
                                    d="M511.638,96.668c-0.033-1.268-0.068-2.336-0.068-3.174V45.1h-73.889v38.736h35.152v9.658 c0,1.127,0.037,2.557,0.086,4.258c0.389,13.976,1.303,46.707-21.545,70.203c-5.121,5.266-11.221,9.787-18.219,13.613 c-3.883,17.635-10.109,33.564-18.104,47.814c26.561-6.406,48.026-17.898,64.096-34.422 C513.402,159.734,512.121,113.918,511.638,96.668z">
                                </path>
                                <path class="st0"
                                    d="M60.625,167.955c-22.848-23.496-21.934-56.227-21.541-70.203c0.047-1.701,0.082-3.131,0.082-4.258v-9.658 h34.842h0.07l0,0h0.24V45.1H0.43v48.394c0,0.838-0.032,1.906-0.068,3.174c-0.482,17.25-1.76,63.066,32.494,98.293 c16.068,16.524,37.531,28.014,64.092,34.422c-7.996-14.25-14.22-30.182-18.103-47.816C71.846,177.74,65.746,173.221,60.625,167.955 z">
                                </path>
                            </g>
                        </svg>
                    </span>
                    <span class="app-menu__label">Torneos</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Torneos">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="18"
                                height="18" style="vertical-align: middle; margin-right: 5px;">
                                <path
                                    d="M4 9L20 9M8 9V20M6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V7.2C21 6.0799 21 5.51984 20.782 5.09202C20.5903 4.71569 20.2843 4.40973 19.908 4.21799C19.4802 4 18.9201 4 17.8 4H6.2C5.0799 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.07989 3 7.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20Z"
                                    stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Tabla Torneos
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Ubicacion">
                            <span style="display: inline-block; vertical-align: middle; margin-right: 5px;">
                                <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.917 45.917"
                                    xml:space="preserve" stroke="#ffffff" width="18" height="18"
                                    style="vertical-align: middle;">
                                    <g>
                                        <g>
                                            <path
                                                d="M33.523,28.334c-0.717,1.155-1.498,2.358-2.344,3.608c7.121,1.065,10.766,3.347,10.766,4.481 c0,1.511-6.459,5.054-18.986,5.054c-12.528,0-18.988-3.543-18.988-5.054c0-1.135,3.645-3.416,10.768-4.481 c-0.847-1.25-1.628-2.453-2.345-3.608C5.365,29.661,0,32.385,0,36.424c0,5.925,11.551,9.024,22.959,9.024s22.958-3.1,22.958-9.024 C45.917,32.385,40.553,29.661,33.523,28.334z">
                                            </path>
                                            <path
                                                d="M22.96,36.047c1.032,0,2.003-0.491,2.613-1.325c3.905-5.33,10.813-15.508,10.813-20.827 c0-7.416-6.012-13.427-13.427-13.427c-7.417,0-13.427,6.011-13.427,13.427c0,5.318,6.906,15.497,10.812,20.827 C20.957,35.556,21.928,36.047,22.96,36.047z M17.374,13.63c0-3.084,2.5-5.584,5.585-5.584c3.084,0,5.584,2.5,5.584,5.584 s-2.5,5.584-5.584,5.584C19.874,19.215,17.374,16.715,17.374,13.63z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            Ubicaciones
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a class="app-menu__item" href="<?php echo base_url; ?>Grupos">
                    <span style="display: inline-block; vertical-align: middle; margin-right: 5px; margin-left: -2px;">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            style="vertical-align: middle;">
                            <path
                                d="M15.5 7.5C15.5 9.433 13.933 11 12 11C10.067 11 8.5 9.433 8.5 7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5Z"
                                fill="#ffffff"></path>
                            <path
                                d="M18 16.5C18 18.433 15.3137 20 12 20C8.68629 20 6 18.433 6 16.5C6 14.567 8.68629 13 12 13C15.3137 13 18 14.567 18 16.5Z"
                                fill="#ffffff"></path>
                            <path
                                d="M7.12205 5C7.29951 5 7.47276 5.01741 7.64005 5.05056C7.23249 5.77446 7 6.61008 7 7.5C7 8.36825 7.22131 9.18482 7.61059 9.89636C7.45245 9.92583 7.28912 9.94126 7.12205 9.94126C5.70763 9.94126 4.56102 8.83512 4.56102 7.47063C4.56102 6.10614 5.70763 5 7.12205 5Z"
                                fill="#ffffff"></path>
                            <path
                                d="M5.44734 18.986C4.87942 18.3071 4.5 17.474 4.5 16.5C4.5 15.5558 4.85657 14.744 5.39578 14.0767C3.4911 14.2245 2 15.2662 2 16.5294C2 17.8044 3.5173 18.8538 5.44734 18.986Z"
                                fill="#ffffff"></path>
                            <path
                                d="M16.9999 7.5C16.9999 8.36825 16.7786 9.18482 16.3893 9.89636C16.5475 9.92583 16.7108 9.94126 16.8779 9.94126C18.2923 9.94126 19.4389 8.83512 19.4389 7.47063C19.4389 6.10614 18.2923 5 16.8779 5C16.7004 5 16.5272 5.01741 16.3599 5.05056C16.7674 5.77446 16.9999 6.61008 16.9999 7.5Z"
                                fill="#ffffff"></path>
                            <path
                                d="M18.5526 18.986C20.4826 18.8538 21.9999 17.8044 21.9999 16.5294C21.9999 15.2662 20.5088 14.2245 18.6041 14.0767C19.1433 14.744 19.4999 15.5558 19.4999 16.5C19.4999 17.474 19.1205 18.3071 18.5526 18.986Z"
                                fill="#ffffff"></path>
                        </svg>
                    </span>
                    <span class="app-menu__label">Grupos</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="<?php echo base_url; ?>Juegos">
                    <svg fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        stroke="#ffffff"
                        style="display: inline-block; vertical-align: middle; margin-right: 5px; margin-left: -2px;">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M18.667,8.667A6.667,6.667,0,1,0,12,15.333,6.667,6.667,0,0,0,18.667,8.667Zm-6.667,2a2,2,0,1,1,2-2A2,2,0,0,1,12,10.667Z">
                            </path>
                            <path d="M19.089,13.636a8.667,8.667,0,0,1-5.682,3.573L17,22l.556-4.444L22,17Z"></path>
                            <path d="M4.911,13.636,2,17l4.444.556L7,22l3.593-4.791A8.667,8.667,0,0,1,4.911,13.636Z">
                            </path>
                        </g>
                    </svg>
                    <span class="app-menu__label">Juegos</span>
                </a>
            </li>
            <?php if ($_SESSION['rol_id'] == ROL_ADMIN): ?>

            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"
                        style="vertical-align: middle; margin-right: 5px;">
                        <path
                            d="M17 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM7 11c1.66 0 3-1.34 3-3S8.66 5 7 5 4 6.34 4 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-1.1.9-2 2-2s2 .9 2 2V19h7v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                    </svg>
                    <span class="app-menu__label">Equipos / Jugadores</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Equipos">
                            <i class="icon fa fa-table"
                                style="font-size: 16px; vertical-align: middle; margin-right: 5px;"></i>
                            <span style="font-size: 14px;">Tabla Equipos</span>
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Jugadores">
                            <svg fill="#ffffff" height="30px" width="30px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 511.999 50" xml:space="preserve" stroke="#ffffff"
                                style="vertical-align: middle; margin-top: -15px; margin-left: -7; ">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path
                                                d="M413.391,121.726c0-22.369-18.133-40.501-40.501-40.501c-22.368,0-40.501,18.133-40.501,40.501 c0,14.55,7.677,27.303,19.196,34.444c-0.243,0.121-0.49,0.223-0.729,0.355l-46.662,25.689v-36.622 c-0.13-26.401-21.716-47.878-48.118-47.878c-13.512,0-95.34,0-108.932,0c-26.629,0-48.401,21.478-48.534,47.979v150.71 c0,11.23,9.104,20.333,20.333,20.333s20.333-9.103,20.333-20.333V145.795c0.011-2.279,1.864-4.117,4.142-4.112 s4.121,1.854,4.121,4.132c0.001,49.61,0.009,331.013,0.009,341.785c0,13.476,10.924,24.399,24.4,24.399 c13.476,0,24.4-10.924,24.4-24.399V292.571h10.535V487.6c0,13.476,10.924,24.399,24.4,24.399 c13.476,0,24.179-10.924,24.179-24.399c0-91.194,0-247.353,0-341.887c0-2.223,1.799-4.027,4.023-4.033 c2.224-0.006,4.033,1.789,4.044,4.013v70.926c0,15.566,16.712,25.202,30.139,17.813l76.802-42.281 c10.672-5.875,14.034-20.007,6.354-30.115C397.343,160.056,413.391,142.768,413.391,121.726z">
                                            </path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <circle cx="201.604" cy="42.141" r="42.141"></circle>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span style="font-size: 14px;">Jugadores</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"
                style="vertical-align: middle; margin-right: 5px;">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM21.41 6.34a1.25 1.25 0 000-1.77l-2-2a1.25 1.25 0 00-1.77 0l-1.83 1.83 3.75 3.75 1.85-1.81z"/>
                </svg>

                <span class="app-menu__label">Inscripciones</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="<?php echo base_url; ?>Inscripciones">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff"
                            viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 5px;">
                            <path
                                d="M17 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM7 11c1.66 0 3-1.34 3-3S8.66 5 7 5 4 6.34 4 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-1.1.9-2 2-2s2 .9 2 2V19h7v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        <span style="font-size: 14px;"> Inscribir Equipos</span>
                    </a>
                </li>
               
            </ul>
            <?php endif; ?>

            <?php if ($_SESSION['rol_id'] == ROL_ADMIN): ?>

            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="icon fa fa-cogs" style="margin-right: 5px;" ></i><span class="app-menu__label">Configuración</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Usuarios"><i
                                class="icon fa fa-user-o" style="margin-right: 11px;"></i> Usuarios</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Configuracion"><i
                                class="app-menu__icon fa fa-wrench"></i> Empresa</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Auditoria"><i
                                class="app-menu__icon fa fa-wrench"></i> Registros Auditoria</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Reportes</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" target="_blank" href="<?php echo base_url; ?>Prestamos/pdf"><i
                                class="icon fa fa-file-pdf-o"></i> Reportes Generados</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <main class="app-content">