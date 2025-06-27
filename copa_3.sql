-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2025 a las 21:45:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `copa_3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `detalle` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendarios`
--

CREATE TABLE `calendarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `detalle_id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` text NOT NULL,
  `correo` varchar(100) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `telefono`, `direccion`, `correo`, `foto`) VALUES
(1, 'Copa de Campeones', '1234567890', 'Carabobo - Venezuela', 'copa@gmail.com', 'logo.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_calendarios`
--

CREATE TABLE `detalles_calendarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `grupo_id` int(10) UNSIGNED NOT NULL,
  `ubicacion_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_permisos`
--

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_permisos`
--

INSERT INTO `detalle_permisos` (`id`, `id_usuario`, `id_permiso`) VALUES
(88, 1, 10),
(189, 2, 1),
(190, 2, 2),
(191, 2, 3),
(192, 2, 4),
(193, 2, 6),
(218, 3, 4),
(219, 3, 5),
(220, 3, 6),
(221, 3, 7),
(222, 3, 8),
(223, 3, 9),
(224, 3, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `delegado_equipo` varchar(15) DEFAULT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre`, `delegado_equipo`, `status_id`, `genero`, `logo`) VALUES
(1, 'Toros FC', '31151553', 1, 'M', NULL),
(24, 'Contadores', '20876345', 1, 'F', NULL),
(25, 'Contadores', '18943210', 1, 'M', NULL),
(26, 'CRPU', '17456239', 1, 'F', NULL),
(27, 'Casa Portuguesa', '22334455', 1, 'F', NULL),
(28, 'Casa Portuguesa', '14567890', 1, 'M', NULL),
(29, 'APUC', '20123456', 1, 'F', NULL),
(30, 'Lic. Educación', '19876543', 1, 'F', NULL),
(31, 'Lic. Educación', '13345678', 1, 'M', NULL),
(32, 'ADC', '19283746', 1, 'F', NULL),
(33, 'Empresa UC', '22334455', 1, 'F', NULL),
(34, 'Empresa UC', '21098765', 1, 'M', NULL),
(35, 'Polígono', '20567834', 1, 'F', NULL),
(36, 'Polígono', '16789012', 1, 'M', NULL),
(37, 'UPT Valencia', '16678899', 1, 'M', NULL),
(38, 'Hogar Hispano', '18889900', 1, 'F', NULL),
(39, 'Veteranos', '15678901', 1, 'F', NULL),
(40, 'Veteranos', '17894561', 1, 'M', NULL),
(41, 'Los Titanes', '14789632', 1, 'M', NULL),
(42, 'Las Panteras', '21998877', 1, 'F', NULL),
(43, 'Estrellas del Sur', '20876345', 1, 'F', NULL),
(44, 'Guerreros', '17456239', 1, 'M', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_jugadores`
--

CREATE TABLE `equipo_jugadores` (
  `id` int(10) UNSIGNED NOT NULL,
  `jugador_id` varchar(15) NOT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `equipo_jugadores`
--

INSERT INTO `equipo_jugadores` (`id`, `jugador_id`, `equipo_id`) VALUES
(103, '20876345', 24),
(104, '20876345', 33),
(105, '20876345', 43),
(106, '18943210', 25),
(107, '18943210', 28),
(108, '18943210', 37),
(109, '17456239', 26),
(110, '17456239', 38),
(111, '17456239', 44),
(112, '14567890', 28),
(113, '14567890', 31),
(114, '14567890', 34),
(115, '20123456', 29),
(116, '20123456', 30),
(117, '20123456', 32),
(118, '16789012', 25),
(119, '16789012', 31),
(120, '16789012', 36),
(121, '19876543', 30),
(122, '19876543', 32),
(123, '19876543', 35),
(124, '15678901', 25),
(125, '15678901', 34),
(126, '15678901', 40),
(127, '22334455', 27),
(128, '22334455', 33),
(129, '22334455', 38),
(130, '21098765', 25),
(131, '21098765', 34),
(132, '21098765', 36),
(133, '17894561', 24),
(134, '17894561', 38),
(135, '17894561', 39),
(136, '13345678', 25),
(137, '13345678', 31),
(138, '13345678', 40),
(139, '19283746', 32),
(140, '19283746', 35),
(141, '19283746', 38),
(142, '16678899', 25),
(143, '16678899', 37),
(144, '16678899', 41),
(145, '18889900', 24),
(146, '18889900', 38),
(147, '18889900', 42),
(148, '15432198', 25),
(149, '15432198', 28),
(150, '15432198', 41),
(151, '20567834', 24),
(152, '20567834', 35),
(153, '20567834', 39),
(154, '14789632', 25),
(155, '14789632', 36),
(156, '14789632', 41),
(157, '21998877', 24),
(158, '21998877', 38),
(159, '21998877', 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `status_id`, `torneo_id`, `genero`) VALUES
(1, 'A', 1, 8, 'M'),
(2, 'B', 1, 8, 'M'),
(3, 'C', 1, 8, 'M'),
(4, 'D', 1, 8, 'M'),
(5, 'A', 1, 8, 'F'),
(6, 'B', 1, 8, 'F'),
(7, 'C', 1, 8, 'F'),
(8, 'D', 1, 8, 'F'),
(9, 'A', 1, 7, 'M'),
(10, 'A', 1, 9, 'M'),
(11, 'B', 1, 9, 'M'),
(12, 'C', 1, 9, 'M'),
(13, 'D', 1, 9, 'M'),
(14, 'A', 1, 9, 'F'),
(15, 'B', 1, 9, 'F'),
(16, 'C', 1, 9, 'F'),
(17, 'D', 1, 9, 'F'),
(18, 'B', 1, 6, 'M'),
(19, 'A', 1, 10, 'M'),
(20, 'B', 1, 10, 'M'),
(21, 'C', 1, 10, 'M'),
(22, 'D', 1, 10, 'M'),
(23, 'A', 1, 10, 'F'),
(24, 'B', 1, 10, 'F'),
(25, 'C', 1, 10, 'F'),
(26, 'D', 1, 10, 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_equipos`
--

CREATE TABLE `grupo_equipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `grupo_id` int(10) UNSIGNED NOT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL,
  `grupo_id` int(10) UNSIGNED DEFAULT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL,
  `fecha_inscripcion` datetime DEFAULT current_timestamp(),
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `torneo_id`, `grupo_id`, `equipo_id`, `genero`, `fecha_inscripcion`, `status_id`) VALUES
(1, 10, 19, 41, 'M', '2025-06-19 01:48:00', 1),
(5, 10, 19, 37, 'M', '2025-06-19 01:55:07', 1),
(6, 10, NULL, 34, 'M', '2025-06-19 02:43:33', 1),
(7, 10, NULL, 44, 'M', '2025-06-19 02:49:18', 1),
(8, 10, 19, 36, 'M', '2025-06-19 12:10:23', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_jugadores`
--

CREATE TABLE `inscripcion_jugadores` (
  `inscripcion_id` int(10) UNSIGNED NOT NULL,
  `jugador_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(10) UNSIGNED NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `vs_equipo_id` int(10) UNSIGNED NOT NULL,
  `puntos_equipo` int(11) NOT NULL DEFAULT 0,
  `puntos_vs_equipo` int(11) NOT NULL DEFAULT 0,
  `status_id` int(10) UNSIGNED NOT NULL,
  `detalle_calendario_id` int(10) UNSIGNED NOT NULL,
  `planilla` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `email` varchar(254) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`cedula`, `nombre`, `apellido`, `fecha_nacimiento`, `email`, `telefono`, `status_id`, `genero`) VALUES
('13345678', 'Miguel', 'Castro', '1995-11-30', 'miguel.castro@gmail.com', '04161110002', 1, 'M'),
('14567890', 'Pedro', 'Pérez', '1995-07-30', 'pedro.perez@gmail.com', '04162345678', 1, 'M'),
('14789632', 'Samuel', 'Mora', '1996-09-07', 'samuel.mora@gmail.com', '04162223344', 1, 'M'),
('15432198', 'Jonathan', 'Peña', '1999-12-12', 'jonathan.p@gmail.com', '04165554433', 1, 'M'),
('15678901', 'José', 'Moreno', '1994-08-18', 'jose.m@gmail.com', '04163332211', 1, 'M'),
('16678899', 'Fernando', 'Delgado', '1993-03-03', 'fernando.d@gmail.com', '04162221100', 1, 'M'),
('16789012', 'Carlos', 'Ramírez', '1996-04-11', 'carlos.ramirez@gmail.com', '04145556677', 1, 'M'),
('17456239', 'María', 'López', '2000-01-09', 'maria.lopez@gmail.com', '04161230001', 1, 'F'),
('17894561', 'Laura', 'Mendoza', '1996-06-06', 'laura.men@gmail.com', '04160009988', 1, 'F'),
('18889900', 'Camila', 'Reyes', '2000-08-25', 'camila.r@gmail.com', '04161119988', 1, 'F'),
('18943210', 'Luis', 'Martínez', '1998-12-21', 'luis.m@gmail.com', '04161234567', 1, 'M'),
('19283746', 'Daniela', 'Silva', '1997-07-20', 'dani.silva@gmail.com', '04167775544', 1, 'F'),
('19876543', 'Sofía', 'Navarro', '1997-09-15', 'sofia.nav@gmail.com', '04168889900', 1, 'F'),
('20123456', 'Ana', 'Torres', '2002-02-22', 'ana.t@gmail.com', '04141113344', 1, 'F'),
('20567834', 'Lucía', 'Salas', '2001-01-30', 'lucia.salas@gmail.com', '04164443322', 1, 'F'),
('20876345', 'Carla', 'González', '1999-03-14', 'carla.g@gmail.com', '04141112233', 1, 'F'),
('21098765', 'Andrés', 'Gutiérrez', '1998-10-12', 'andres.gut@gmail.com', '04164445566', 1, 'M'),
('21998877', 'Isabel', 'Pineda', '2002-04-14', 'isa.pineda@gmail.com', '04169998877', 1, 'F'),
('22334455', 'Valentina', 'Fernández', '2001-05-05', 'valen.f@gmail.com', '04167778899', 1, 'F'),
('31151553', 'Eduar', 'Gutierrez', '2000-02-22', 'alex@gmail.com', '04121350170', 1, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `tipo`) VALUES
(1, 'Grupos', 1),
(2, 'Equipos', 2),
(3, 'Jugadores', 3),
(4, 'Usuarios', 4),
(5, 'Configuracion', 5),
(6, 'Torneos', 6),
(7, 'Calendario', 7),
(8, 'Reportes', 8),
(9, 'Ubicaciones', 9),
(10, 'no se', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `nombre`, `descripcion`) VALUES
(1, 'activo', 'activo'),
(2, 'inactivo', 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `ubicacion_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `ubicacion_id`, `status_id`) VALUES
(1, 'COPA 2025', '2023-07-01', '2023-07-20', 1, 2),
(2, 'Super Copa 2025', '2025-06-01', NULL, 1, 1),
(3, 'COPA 2026', '2026-01-17', '2025-05-31', 1, 1),
(4, 'Copa Master', '2025-04-15', '2025-06-10', 1, 1),
(5, 'Campeonato Final', '2025-05-06', '2025-06-25', 1, 1),
(6, 'Campeonato 2024', '2024-03-04', '2024-10-23', 1, 2),
(7, 'Torneo 2020', '2020-02-01', '2020-11-01', 1, 2),
(8, 'Champion 2025', '2025-06-03', '2025-11-12', 1, 1),
(9, 'Copa Copa', '2025-06-10', '2025-08-13', 1, 2),
(10, 'Torneo Especial', '2025-06-04', NULL, 1, 1);

--
-- Disparadores `torneos`
--
DELIMITER $$
CREATE TRIGGER `grupos_por_defecto_torneo` AFTER INSERT ON `torneos` FOR EACH ROW BEGIN
  -- Grupos masculinos
  INSERT INTO grupos (nombre, status_id, torneo_id, genero) VALUES
  ('A', 1, NEW.id, 'M'),
  ('B', 1, NEW.id, 'M'),
  ('C', 1, NEW.id, 'M'),
  ('D', 1, NEW.id, 'M');

  -- Grupos femeninos
  INSERT INTO grupos (nombre, status_id, torneo_id, genero) VALUES
  ('A', 1, NEW.id, 'F'),
  ('B', 1, NEW.id, 'F'),
  ('C', 1, NEW.id, 'F'),
  ('D', 1, NEW.id, 'F');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(260) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `nombre`, `direccion`, `status_id`) VALUES
(1, 'El Poligono', 'Redomas de Guaparo', 1),
(2, 'Casa Portuguesa', 'San Diego', 1),
(3, 'Draculandia', 'Parque Recreacional del Sur', 1),
(4, 'Forum', 'Naguanagua', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `rol_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `clave`, `status_id`, `rol_id`) VALUES
(1, 'admin', 'Super Admin', '792e507c9b933a1f712c452b94c4a4603af42e0293c6aa714c1f7fea541f0d50', 1, NULL),
(2, 'angel', 'Vida Informatico', '519ba91a5a5b4afb9dc66f8805ce8c442b6576316c19c6896af2fa9bda6aff71', 1, NULL),
(3, 'alex', 'Alejandro Gutierrez', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1, NULL),
(4, 'lou', 'Laura', '8f00793014a5cd4994a0cbb999dbba67f9a135d5184ca326d082a65a8ad2d849', 1, NULL),
(5, 'delegado', 'Delegado', '8f00793014a5cd4994a0cbb999dbba67f9a135d5184ca326d082a65a8ad2d849', 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `calendarios`
--
ALTER TABLE `calendarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calendarios_detalle` (`detalle_id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_calendarios`
--
ALTER TABLE `detalles_calendarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalles_grupo` (`ubicacion_id`);

--
-- Indices de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`,`genero`),
  ADD KEY `fk_equipo_delegado` (`delegado_equipo`),
  ADD KEY `fk_equipo_status` (`status_id`);

--
-- Indices de la tabla `equipo_jugadores`
--
ALTER TABLE `equipo_jugadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipo_jugadores_j` (`jugador_id`),
  ADD KEY `fk_equipo_jugadores_e` (`equipo_id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grupo_status` (`status_id`),
  ADD KEY `fk_grupo_torneo` (`torneo_id`);

--
-- Indices de la tabla `grupo_equipos`
--
ALTER TABLE `grupo_equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_equipo_torneo` (`equipo_id`,`torneo_id`),
  ADD KEY `grupo_id` (`grupo_id`),
  ADD KEY `torneo_id` (`torneo_id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torneo_id` (`torneo_id`),
  ADD KEY `grupo_id` (`grupo_id`),
  ADD KEY `equipo_id` (`equipo_id`),
  ADD KEY `fk_inscripciones_estatus` (`status_id`);

--
-- Indices de la tabla `inscripcion_jugadores`
--
ALTER TABLE `inscripcion_jugadores`
  ADD PRIMARY KEY (`inscripcion_id`,`jugador_id`),
  ADD KEY `jugador_id` (`jugador_id`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torneo_id` (`torneo_id`),
  ADD KEY `equipo_id` (`equipo_id`),
  ADD KEY `vs_equipo_id` (`vs_equipo_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `detalle_calendario_id` (`detalle_calendario_id`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `correo` (`email`),
  ADD KEY `fk_jugador_status` (`status_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_torneo_status` (`status_id`),
  ADD KEY `fk_torneo_ubicacion` (`ubicacion_id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ubicaciones_status` (`status_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_status` (`status_id`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendarios`
--
ALTER TABLE `calendarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalles_calendarios`
--
ALTER TABLE `detalles_calendarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `equipo_jugadores`
--
ALTER TABLE `equipo_jugadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `grupo_equipos`
--
ALTER TABLE `grupo_equipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `auditoria_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `calendarios`
--
ALTER TABLE `calendarios`
  ADD CONSTRAINT `fk_calendarios_detalle` FOREIGN KEY (`detalle_id`) REFERENCES `detalles_calendarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_calendarios`
--
ALTER TABLE `detalles_calendarios`
  ADD CONSTRAINT `fk_detalles_grupo` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD CONSTRAINT `detalle_permisos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `detalle_permisos_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `fk_equipo_delegado` FOREIGN KEY (`delegado_equipo`) REFERENCES `jugadores` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipo_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `equipo_jugadores`
--
ALTER TABLE `equipo_jugadores`
  ADD CONSTRAINT `fk_equipo_jugadores_e` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipo_jugadores_j` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupo_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_torneo` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupo_equipos`
--
ALTER TABLE `grupo_equipos`
  ADD CONSTRAINT `grupo_equipos_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `grupo_equipos_ibfk_2` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `grupo_equipos_ibfk_3` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`);

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `fk_inscripciones_estatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_3` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripcion_jugadores`
--
ALTER TABLE `inscripcion_jugadores`
  ADD CONSTRAINT `inscripcion_jugadores_ibfk_1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripcion_jugadores_ibfk_2` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `juegos_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `juegos_ibfk_2` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `juegos_ibfk_3` FOREIGN KEY (`vs_equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `juegos_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `juegos_ibfk_5` FOREIGN KEY (`detalle_calendario_id`) REFERENCES `detalles_calendarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `fk_jugador_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD CONSTRAINT `fk_torneo_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_torneo_ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD CONSTRAINT `fk_ubicaciones_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
