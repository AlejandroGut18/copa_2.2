<?php include "Views/Templates/header.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Admin | ASOBOCOPA</title>
    <style>
        :root {
            --primary: #111827; /* Azul noche profundo */
            --secondary: #6B7280; /* Gris medio */
            --accent: #166534;
             --nose: #10B981; /* Verde esmeralda */
            --light: #F9FAFB; /* Gris claro */
            --white: #FFFFFF;
            --border-radius: 12px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--light);
        }

        .profile-card {
            max-width: 900px;
            margin: 2rem auto;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .profile-header {
            padding: 3rem 3rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .avatar-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            position: relative;
           
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid  #ffd823;;
            box-shadow: var(--shadow-sm);
             
        }

        .status-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 24px;
            height: 24px;
            background-color: var(--nose);
            border-radius: 50%;
            border: 3px solid var(--white);
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .profile-title {
            font-size: 1rem;
            color: var(--secondary);
            font-weight: 400;
            margin-bottom: 1rem;
        }

        .profile-role {
            display: inline-block;
            background-color: var(--light);
            color: var(--nose);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 2rem 3rem;
            gap: 2rem;
        }

        .profile-section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 0.75rem;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .info-item {
            display: flex;
            margin-bottom: 1rem;
        }

        .info-icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            color: #ffd823;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.75rem;
            color: var(--secondary);
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 500;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .stat-item {
            padding: 1.25rem;
            background: var(--light);
            border-radius: var(--border-radius);
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.7rem;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .link-item {
            padding: 0.5rem 1rem;
            background: var(--light);
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .link-item:hover {
            background: var(--accent);
            color: var(--white);
        }

        .profile-footer {
            padding: 1.5rem 3rem;
            background: var(--light);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--secondary);
            color: var(--secondary);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-p {
            background: var(--primary);
            color: var(--white);
        }

        .btn-p:hover {
            background: var(--accent);
            color: var(--white);
        }

        @media (max-width: 768px) {
            .profile-body {
                grid-template-columns: 1fr;
                padding: 1.5rem;
            }
            
            .profile-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .profile-footer {
                padding: 1.5rem;
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-container">
            <img src="<?php echo base_url; ?>Assets/img/logo.png" alt="User Image" class="profile-avatar">
            <div class="status-badge"></div>
            </div>
            <h1 class="profile-name"><?php echo $_SESSION['nombre']; ?></h1>
            <p class="profile-title"><?php echo $_SESSION['usuario']; ?></p>
            <span class="profile-role"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
        </div>

        <div class="profile-body">
            <div>
                <div class="profile-section">
                    <h3 class="section-title">Información Personal</h3>
                    <div class="info-item">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div class="info-content">
                            <div class="info-label">Nombre de usuario</div>
                            <div class="info-value"><?php echo $_SESSION['nombre']; ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div class="info-content">
                            <div class="info-label">Correo electrónico</div>
                            <div class="info-value">admin@asobocopa.com</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div class="info-content">
                            <div class="info-label">Teléfono</div>
                            <div class="info-value">+1 234 567 890</div>
                        </div>
                    </div>
                </div>

                <div class="profile-section">
                    <h3 class="section-title">Actividad</h3>
                    <div class="info-item">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="info-content">
                            <div class="info-label">Último acceso</div>
                            <div class="info-value">Hoy, 10:45 AM</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div class="info-content">
                            <div class="info-label">Miembro desde</div>
                            <div class="info-value">15 Enero 2022</div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="profile-section">
                    <h3 class="section-title">Estadísticas</h3>
                    <div class="stats-grid">
                        <!-- Estadísticas vacías por ahora -->
                    </div>
                </div>
            </div>
            <!-- Se eliminó la sección de estadísticas y accesos rápidos para mantener el diseño limpio -->
        </div>

        <div class="profile-footer" style="gap:5;">
            <button class="btn btn-outline" style="flex:1 1 0; min-width:0; height:48px;">Editar Perfil</button>
            <button class="btn btn-p" style="flex:1 1 0; min-width:0; height:48px;" href="#" id="modalPass">Cambiar Contraseña</button>
        </div>
    </div>
    <script>
        document.querySelector("#modalPass").addEventListener("click", function () {
            document.querySelector("#frmCambiarPass").reset();
            $("#cambiarClave").modal("show");
        });
    </script>
</body>
</html>
<?php include "Views/Templates/footer.php"; ?>