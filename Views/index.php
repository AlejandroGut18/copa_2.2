<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
    <!-- Logo -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url; ?>Assets/icons/logo1.ico">

    <!-- Title -->
    <title>Iniciar | Sesión</title>
</head>

<body>
<!--     <section class="material-half-bg">
        <div class="cover"></div>
    </section> -->
    <section class="fondo-section">
        <img class="fondo-img" src="<?php echo base_url; ?>Assets/img/login/login-fondo.png" alt="image-fondo">
    </section>
    <section class="login-content">
        
<!--         <div class="logo">
            <h1>Bienvenido</h1>
        </div> -->
        <div class="login-box">
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 7px; margin-top: 7px;">
                <img class="logo-img" src="<?php echo base_url; ?>Assets/icons/logo1.ico" alt="image-fondo" style="width: 80px; height: 80px; object-fit: contain;">
            </div>
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
                <span style="font-size:1.6rem; font-weight:700; background: linear-gradient(to right, rgb(35,156,19), #ffd823); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; text-align: center;">ASOBOCOPA</span>
            </div>
            <form class="login-form" id="frmLogin" onsubmit="frmLogin(event);">
                <h3 class="login-head"><!-- <i class="fa fa-lg fa-fw fa-user"></i> --></h3>
                <h3 style="display: flex; justify-content: center; align-items: center; text-align: center; margin-bottom: 10px;">Iniciar Sesión</h3>
                <div class="form-group">
                    <label class="control-label"><i class="fa fa-lg fa-fw fa-user"></i>USUARIO</label>
                    <input class="form-control" type="text" placeholder="Usuario o Email" id="usuario" name="usuario" autofocus required>
                </div>
                <div class="form-group">
                    <label class="control-label"><i class="fa fa-lg fa-fw fa-lock"></i>CONTRASEÑA</label>
                    <div style="position: relative;">
                        <input class="form-control" type="password" placeholder="Contraseña" id="clave" name="clave" required>
                        <span onclick="togglePassword()" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
                            <!-- Heroicons Eye SVG -->
                            <svg id="toggleClaveIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22">
                                <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94A10.06 10.06 0 0112 19.5c-7 0-10.5-7.5-10.5-7.5a20.6 20.6 0 014.21-5.94m3.29-2.13A10.06 10.06 0 0112 4.5c7 0 10.5 7.5 10.5 7.5a20.6 20.6 0 01-4.21 5.94M3 3l18 18" />
                                <circle id="eyePupil" cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <script>
                function togglePassword() {
                    const input = document.getElementById('clave');
                    const icon = document.getElementById('toggleClaveIcon');
                    const eyeOpen = icon.querySelector('#eyeOpen');
                    const eyePupil = icon.querySelector('#eyePupil');

                    if (input.type === 'password') {
                        input.type = 'text';
                        eyeOpen.setAttribute('d', 'M1.5 12s3.5-7 10.5-7 10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12z');
                        eyePupil.setAttribute('fill', 'currentColor');
                    } else {
                        input.type = 'password';
                        eyeOpen.setAttribute('d', 'M17.94 17.94A10.06 10.06 0 0112 19.5c-7 0-10.5-7.5-10.5-7.5a20.6 20.6 0 014.21-5.94m3.29-2.13A10.06 10.06 0 0112 4.5c7 0 10.5 7.5 10.5 7.5a20.6 20.6 0 01-4.21 5.94M3 3l18 18');
                        eyePupil.setAttribute('fill', 'none');
                    }
                }
                </script>
                <div class="alert alert-danger d-none" role="alert" id="alerta"></div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>Login</button>
                </div>
                <!-- <div class="login-footer pass">
                    <p>¿Olvidó su contraseña?</p>
                    <a href="<?php echo base_url; ?>Views/forgot_password.php">Recuperar contraseña</a>
                </div> -->
                <div class="login-footer" style="margin-left:10px">
                    <p>¿Eres miembro y no tienes un usuario?</p>
                    <a href="<?php echo base_url; ?>Views/sign-in.php">Regístrese aquí</a>
                </div>
            </form>
        </div>
    </section>
    <!-- Essential javascripts for application to work-->

    <script src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/main.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url; ?>Assets/js/pace.min.js"></script>
    <script>
        const base_url = '<?php echo base_url; ?>';
    </script>
    <script src="<?php echo base_url; ?>Assets/js/login.js"></script>
    <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function() {
            $('.login-box').toggleClass('flipped');
            return false;
        });
    </script>
</body>


</html>