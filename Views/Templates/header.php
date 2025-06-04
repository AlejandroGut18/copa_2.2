<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
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
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Panel Administrativo</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link href="<?php echo base_url; ?>Assets/css/main.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/datatables.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?php echo base_url; ?>Configuracion/admin">Copa de Campeones</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!--Notification Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">Libros no entregados.</li>
                    <div class="app-notification__content">
                        <li id="nombre_estudiante">
                            
                        </li>
                    </div>
                    <li class="app-notification__footer"><a href="<?php echo base_url; ?>Configuracion/libros" target="_blank">Generar Reporte.</a></li>
                </ul>
            </li>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="#" id="modalPass"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/salir"><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/img/logo.png" alt="User Image" width="50">
            <div>
                <p class="app-sidebar__user-name"><?php echo $_SESSION['nombre'] ?></p>
                <p class="app-sidebar__user-designation"><?php echo $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <ul class="app-menu">
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Materia"><i class="app-menu__icon fa fa-calendar" style="color: #ffffff;"></i><span class="app-menu__label">Calendario</span></a></li>
            
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <span style="display: inline-block; vertical-align: middle; margin-right: 5px;">
                        <svg height="18px" width="18px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" style="vertical-align: middle;">
                            <g>
                                <path class="st0" d="M102.49,0c0,27.414,0,104.166,0,137.062c0,112.391,99.33,156.25,153.51,156.25 c54.18,0,153.51-43.859,153.51-156.25c0-32.896,0-109.648,0-137.062H102.49z M256.289,50.551l-68.164,29.768v98.474l-0.049,19.53 c-0.526-0.112-47.274-10.112-47.274-78.391c0-28.17,0-69.6,0-69.6h60.385L256.289,50.551z"></path>
                                <polygon class="st0" points="315.473,400.717 291.681,367.482 279.791,318.506 256,322.004 232.209,318.506 220.314,367.482 205.347,388.394 196.527,400.476 196.699,400.476 196.527,400.717 "></polygon>
                                <polygon class="st0" points="366.93,432.24 366.93,432 145.07,432 145.07,511.598 145.07,511.76 145.07,511.76 145.07,512 366.93,512 366.93,432.402 366.93,432.24 "></polygon>
                                <path class="st0" d="M511.638,96.668c-0.033-1.268-0.068-2.336-0.068-3.174V45.1h-73.889v38.736h35.152v9.658 c0,1.127,0.037,2.557,0.086,4.258c0.389,13.976,1.303,46.707-21.545,70.203c-5.121,5.266-11.221,9.787-18.219,13.613 c-3.883,17.635-10.109,33.564-18.104,47.814c26.561-6.406,48.026-17.898,64.096-34.422 C513.402,159.734,512.121,113.918,511.638,96.668z"></path>
                                <path class="st0" d="M60.625,167.955c-22.848-23.496-21.934-56.227-21.541-70.203c0.047-1.701,0.082-3.131,0.082-4.258v-9.658 h34.842h0.07l0,0h0.24V45.1H0.43v48.394c0,0.838-0.032,1.906-0.068,3.174c-0.482,17.25-1.76,63.066,32.494,98.293 c16.068,16.524,37.531,28.014,64.092,34.422c-7.996-14.25-14.22-30.182-18.103-47.816C71.846,177.74,65.746,173.221,60.625,167.955 z"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="app-menu__label">Torneo</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Torneos">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" style="vertical-align: middle; margin-right: 5px;">
                                <path d="M4 9L20 9M8 9V20M6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V7.2C21 6.0799 21 5.51984 20.782 5.09202C20.5903 4.71569 20.2843 4.40973 19.908 4.21799C19.4802 4 18.9201 4 17.8 4H6.2C5.0799 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.07989 3 7.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Tabla
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="<?php echo base_url; ?>Ubicacion">
                            <span style="display: inline-block; vertical-align: middle; margin-right: 5px;">
                                <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.917 45.917" xml:space="preserve" stroke="#ffffff" width="18" height="18" style="vertical-align: middle;">
                                    <g>
                                        <g>
                                            <path d="M33.523,28.334c-0.717,1.155-1.498,2.358-2.344,3.608c7.121,1.065,10.766,3.347,10.766,4.481 c0,1.511-6.459,5.054-18.986,5.054c-12.528,0-18.988-3.543-18.988-5.054c0-1.135,3.645-3.416,10.768-4.481 c-0.847-1.25-1.628-2.453-2.345-3.608C5.365,29.661,0,32.385,0,36.424c0,5.925,11.551,9.024,22.959,9.024s22.958-3.1,22.958-9.024 C45.917,32.385,40.553,29.661,33.523,28.334z"></path>
                                            <path d="M22.96,36.047c1.032,0,2.003-0.491,2.613-1.325c3.905-5.33,10.813-15.508,10.813-20.827 c0-7.416-6.012-13.427-13.427-13.427c-7.417,0-13.427,6.011-13.427,13.427c0,5.318,6.906,15.497,10.812,20.827 C20.957,35.556,21.928,36.047,22.96,36.047z M17.374,13.63c0-3.084,2.5-5.584,5.585-5.584c3.084,0,5.584,2.5,5.584,5.584 s-2.5,5.584-5.584,5.584C19.874,19.215,17.374,16.715,17.374,13.63z"></path>
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
                    <span style="display: inline-block; vertical-align: middle; margin-right: 5px;">
                        <svg fill="#ffffff" height="18px" width="18px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 494.938 494.938" xml:space="preserve" stroke="#ffffff" style="vertical-align: middle;">
                            <g>
                                <path d="M19.215,154.585l112.695,46.467c2.078,0.852,4.221,1.259,6.337,1.259c5.718,0,11.247-2.957,14.333-8.142l50.739-85.448 l92.707-45.619l2.856,42.134c0.1,1.243,0.943,2.308,2.132,2.665c1.188,0.365,2.486-0.057,3.252-1.049L381.922,5.623 c0.776-1.016,0.922-2.38,0.339-3.526c-0.553-1.153-1.721-1.877-2.992-1.877L251.672,0c-1.25-0.008-2.356,0.764-2.815,1.935 c-0.437,1.161-0.109,2.486,0.813,3.315l31.648,27.986l-97.127,47.799c-2.908,1.43-5.316,3.664-6.974,6.436l-45.929,77.33 l-99.367-40.98c-8.533-3.527-18.238,0.545-21.746,9.036C6.664,141.356,10.729,151.082,19.215,154.585z"></path>
                                <path d="M469.375,445.01H25.567c-13.801,0-24.966,11.173-24.966,24.965c0,13.789,11.165,24.963,24.966,24.963h443.808 c13.78,0,24.961-11.174,24.961-24.963C494.336,456.183,483.155,445.01,469.375,445.01z"></path>
                                <path d="M50.221,241.837c-5.557,0-10.074,4.519-10.074,10.085V401.64c0,5.566,4.518,10.086,10.074,10.086h58.886 c5.571,0,10.091-4.52,10.091-10.086V251.922c0-5.566-4.52-10.085-10.091-10.085H50.221z"></path>
                                <path d="M375.761,82.027V401.64c0,5.566,4.52,10.086,10.075,10.086h58.901c5.556,0,10.075-4.52,10.075-10.086V82.027 c0-5.566-4.52-10.086-10.075-10.086h-58.901C380.28,71.941,375.761,76.461,375.761,82.027z"></path>
                                <path d="M273.969,161.045c-5.57,0-10.09,4.52-10.09,10.086V401.64c0,5.566,4.519,10.086,10.09,10.086h58.886 c5.557,0,10.075-4.52,10.075-10.086V171.131c0-5.566-4.519-10.086-10.075-10.086H273.969z"></path>
                                <path d="M162.103,286.386c-5.571,0-10.091,4.517-10.091,10.084v105.17c0,5.566,4.52,10.086,10.091,10.086h58.87 c5.572,0,10.092-4.52,10.092-10.086V296.47c0-5.567-4.52-10.084-10.092-10.084H162.103z"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="app-menu__label">Grupos</span>
                </a>
            </li>            
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Libros</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Autor"><i class="icon fa fa-address-book-o"></i> Autor</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Editorial"><i class="icon fa fa-tags"></i> Editorial</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Libros"><i class="icon fa fa-book"></i> Libros</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-wrench"></i><span class="app-menu__label">Administración</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Usuarios"><i class="icon fa fa-user-o"></i> Usuarios</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url; ?>Configuracion"><i class="icon fa fa-cogs"></i> Configuración</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" target="_blank" href="<?php echo base_url; ?>Prestamos/pdf"><i class="icon fa fa-file-pdf-o"></i> Libros Prestados</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <main class="app-content">