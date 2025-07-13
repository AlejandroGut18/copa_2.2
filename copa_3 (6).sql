-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2025 a las 18:11:54
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

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `detalle`, `fecha`) VALUES
(1, 1, 'UPDATE', 'Modificó torneo ID 10: Torneo Especial', '2025-06-22 23:33:20'),
(2, 1, 'UPDATE', 'Modificó torneo ID 10: ubicacion_id: \'4\' → \'3\'', '2025-06-22 23:59:36'),
(3, 1, 'UPDATE', 'Modificó torneo ID 10: nombre: \'Torneo Especial\' → \'Torneo Especia\'', '2025-06-23 00:22:57'),
(4, 1, 'UPDATE', 'Modificó torneo ID 10: nombre: \'Torneo Especia\' → \'Torneo Especial\'', '2025-06-23 00:23:36'),
(5, 1, 'UPDATE', 'Modificó torneo ID 10: nombre: \'Torneo Especial\' → \'Torneo Especia\'', '2025-06-23 01:44:38'),
(6, 1, 'UPDATE', 'Modificó torneo ID 10: nombre: \'Torneo Especia\' → \'Torneo Especial\'', '2025-06-23 01:44:46'),
(7, 1, 'UPDATE', 'Modificó torneo ID 10: fecha_inicio: \'2025-06-04\' → \'2025-06-03\'; fecha_fin: \'2025-06-22\' → \'2025-06-23\'; ubicacion_id: \'3\' → \'2\'', '2025-06-23 01:45:50'),
(8, 1, 'DELETE', 'Desactivó torneo ID: 8', '2025-06-24 05:03:10'),
(9, 1, 'DELETE', 'Desactivó torneo ID: 9', '2025-06-24 05:03:15'),
(10, 1, 'UPDATE', 'Reingresó torneo ID: 9', '2025-06-25 15:17:03'),
(11, 1, 'DELETE', 'Desactivó torneo ID: 10', '2025-06-27 12:39:05'),
(12, 1, 'UPDATE', 'Reingresó torneo ID: 10', '2025-06-28 12:40:14'),
(13, 1, 'UPDATE', 'Modificó torneo ID 10: nombre: \'Torneo Especial\' → \'Torneo Especia\'', '2025-06-28 14:55:52'),
(14, 1, 'UPDATE', 'Modificó torneo ID 10: nombre: \'Torneo Especia\' → \'Torneo Especial\'', '2025-06-28 14:56:05'),
(15, 3, 'DELETE', 'Desactivó torneo ID: 10', '2025-06-28 15:29:06'),
(16, 1, 'UPDATE', 'Reingresó torneo ID: 10', '2025-06-28 15:29:55'),
(17, 1, 'INSERT', 'Registro torneo: b', '2025-06-28 15:40:52'),
(18, 1, 'DELETE', 'Desactivó torneo ID: 11', '2025-06-28 15:41:01'),
(19, 1, 'DELETE', 'Desactivó torneo ID: 10', '2025-06-28 21:30:08'),
(20, 1, 'DELETE', 'Desactivó torneo ID: 9', '2025-06-28 22:02:49'),
(21, 1, 'UPDATE', 'Reingresó torneo ID: 11', '2025-06-28 22:02:56'),
(22, 1, 'UPDATE', 'Modificó torneo ID 11: sin cambios detectados', '2025-06-28 22:03:05'),
(23, 1, 'UPDATE', 'Modificó torneo ID 11: nombre: \'b\' → \'Perido 2\'', '2025-06-29 08:59:05'),
(24, 1, 'UPDATE', 'Reingresó torneo ID: 10', '2025-06-29 08:59:31'),
(25, 1, 'UPDATE', 'Modificó torneo ID 11: sin cambios detectados', '2025-06-29 14:21:33'),
(26, 1, 'INSERT', 'Registro torneo: VI Naguanagua', '2025-06-30 18:35:15'),
(27, 1, 'UPDATE', 'Modificó torneo ID 12: nombre: \'VI Naguanagua\' → \'VI Torneo Naguanagua\'', '2025-06-30 18:36:04'),
(28, 1, 'DELETE', 'Desactivó torneo ID: 12', '2025-06-30 18:36:50'),
(29, 1, 'UPDATE', 'Reingresó torneo ID: 12', '2025-06-30 18:37:18'),
(30, 1, 'UPDATE', 'Reingresó torneo ID: 8', '2025-06-30 19:07:04'),
(31, 1, 'UPDATE', 'Modificó torneo ID 8: fecha_fin: \'2025-11-12\' → \'2025-06-30\'', '2025-06-30 19:07:29'),
(32, 1, 'DELETE', 'Desactivó torneo ID: 12', '2025-06-30 20:47:01'),
(33, 1, 'UPDATE', 'Reingresó torneo ID: 12', '2025-06-30 20:49:36'),
(34, 1, 'DELETE', 'Desactivó torneo ID: 10', '2025-07-03 07:32:36'),
(35, 1, 'DELETE', 'Desactivó torneo ID: 8', '2025-07-03 07:32:42'),
(36, 1, 'DELETE', 'Desactivó torneo ID: 11', '2025-07-03 07:32:47'),
(37, 1, 'UPDATE', 'Reingresó torneo ID: 11', '2025-07-03 07:33:05'),
(38, 1, 'UPDATE', 'Reingresó torneo ID: 10', '2025-07-03 07:33:10'),
(39, 1, 'DELETE', 'Desactivó torneo ID: 12', '2025-07-03 07:42:15'),
(40, 1, 'UPDATE', 'Reingresó torneo ID: 12', '2025-07-03 07:52:55'),
(41, 1, 'DELETE', 'Desactivó torneo ID: 10', '2025-07-03 07:53:01'),
(42, 1, 'UPDATE', 'Reingresó torneo ID: 10', '2025-07-03 10:51:27'),
(43, 1, 'DELETE', 'Desactivó torneo ID: 12', '2025-07-03 11:20:21'),
(44, 1, 'UPDATE', 'Reingresó torneo ID: 12', '2025-07-03 11:20:34'),
(45, 1, 'DELETE', 'Desactivó torneo ID: 12', '2025-07-03 11:21:02'),
(46, 1, 'DELETE', 'Desactivó torneo ID: 11', '2025-07-03 11:21:10'),
(47, 1, 'UPDATE', 'Reingresó torneo ID: 12', '2025-07-03 11:56:03'),
(48, 1, 'DELETE', 'Desactivó torneo ID: 10', '2025-07-03 11:56:16'),
(49, 1, 'INSERT', 'Registro torneo: VII Naguanagua', '2025-07-03 12:14:27'),
(50, 1, 'DELETE', 'Desactivó torneo ID: 13', '2025-07-03 12:14:36'),
(51, 1, 'UPDATE', 'Reingresó torneo ID: 13', '2025-07-03 12:14:41'),
(52, 1, 'DELETE', 'Desactivó torneo ID: 13', '2025-07-03 12:47:08'),
(53, 1, 'UPDATE', 'Reingresó torneo ID: 11', '2025-07-03 13:04:22'),
(54, 1, 'UPDATE', 'Reingresó torneo ID: 13', '2025-07-03 13:04:26'),
(55, 1, 'UPDATE', 'Reingresó torneo ID: 10', '2025-07-03 13:04:32'),
(56, 1, 'UPDATE', 'Reingresó torneo ID: 9', '2025-07-03 13:04:37'),
(57, 1, 'DELETE', 'Desactivó torneo ID: 9', '2025-07-07 19:31:24'),
(58, 1, 'DELETE', 'Desactivó torneo ID: 11', '2025-07-07 19:31:30'),
(59, 1, 'DELETE', 'Desactivó torneo ID: 12', '2025-07-07 19:31:35'),
(60, 1, 'DELETE', 'Desactivó torneo ID: 13', '2025-07-07 19:31:40'),
(61, 1, 'UPDATE', 'Reingresó torneo ID: 13', '2025-07-07 20:10:39'),
(62, 1, 'DELETE', 'Desactivó torneo ID: 13', '2025-07-07 20:10:51'),
(63, 1, 'UPDATE', 'Reingresó torneo ID: 13', '2025-07-07 20:11:39'),
(64, 1, 'UPDATE', 'Reingresó torneo ID: 4', '2025-07-07 20:57:55'),
(65, 1, 'DELETE', 'Desactivó torneo ID: 4', '2025-07-07 20:58:18'),
(66, 1, 'DELETE', 'Desactivó torneo ID: 13', '2025-07-08 12:59:52'),
(67, 1, 'UPDATE', 'Reingresó torneo ID: 13', '2025-07-08 13:10:28'),
(68, 1, 'UPDATE', 'Modificó torneo ID 13: sin cambios detectados', '2025-07-10 01:24:42'),
(69, 1, 'UPDATE', 'Modificó torneo ID 13: sin cambios detectados', '2025-07-10 01:24:49'),
(70, 1, 'UPDATE', 'Reingresó torneo ID: 9', '2025-07-10 01:24:57'),
(71, 1, 'DELETE', 'Desactivó torneo ID: 9', '2025-07-10 01:25:07'),
(72, 1, 'UPDATE', 'Modificó torneo ID 13: sin cambios detectados', '2025-07-10 01:38:46'),
(73, 1, 'UPDATE', 'Modificó torneo ID 13: sin cambios detectados', '2025-07-10 01:39:04');

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
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `telefono`, `direccion`, `correo`, `foto`) VALUES
(1, 'ASOBOCOPA', '1234567890', 'Carabobo - Venezuela', 'copa@gmail.com', 'logo.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_juego`
--

CREATE TABLE `detalles_juego` (
  `juego_id` int(10) UNSIGNED NOT NULL,
  `equipo_id` int(10) UNSIGNED DEFAULT NULL,
  `puntos` int(11) NOT NULL DEFAULT 0,
  `vs_equipo_id` int(10) UNSIGNED DEFAULT NULL,
  `puntos_vs` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detalles_juego`
--

INSERT INTO `detalles_juego` (`juego_id`, `equipo_id`, `puntos`, `vs_equipo_id`, `puntos_vs`) VALUES
(76, NULL, 2, NULL, 8),
(77, NULL, 7, NULL, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_jugador`
--

CREATE TABLE `detalles_jugador` (
  `juego_id` int(10) UNSIGNED DEFAULT NULL,
  `inscripcion_id` int(10) UNSIGNED NOT NULL,
  `jugador_id` varchar(15) NOT NULL,
  `arrimesL` int(11) DEFAULT 0,
  `arrimesB` int(11) DEFAULT 0,
  `bochesL` int(11) DEFAULT 0,
  `bochesB` int(11) DEFAULT 0,
  `rastererosL` int(11) DEFAULT 0,
  `rastrerosB` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detalles_jugador`
--

INSERT INTO `detalles_jugador` (`juego_id`, `inscripcion_id`, `jugador_id`, `arrimesL`, `arrimesB`, `bochesL`, `bochesB`, `rastererosL`, `rastrerosB`) VALUES
(77, 19, '13345710', 1, 1, 8, 5, 0, 0),
(77, 19, '13345718', 0, 0, 0, 0, 0, 0),
(77, 19, '13345732', 0, 0, 0, 0, 0, 0),
(77, 19, '13345740', 0, 0, 0, 0, 0, 0),
(77, 19, '13345744', 0, 0, 0, 0, 0, 0),
(77, 24, '13345708', 0, 0, 0, 0, 0, 0),
(77, 24, '13345730', 0, 0, 0, 0, 0, 0),
(76, 19, '13345710', 22, 22, 0, 0, 0, 0),
(76, 19, '13345718', 0, 0, 0, 0, 0, 0),
(76, 19, '13345732', 0, 0, 0, 0, 0, 0),
(76, 19, '13345740', 0, 0, 0, 0, 0, 0),
(76, 19, '13345744', 0, 0, 0, 0, 0, 0),
(76, 21, '13345716', 0, 0, 0, 0, 0, 0),
(76, 21, '13345724', 0, 0, 0, 0, 0, 0),
(76, 21, '13345726', 0, 0, 0, 0, 0, 0),
(76, 21, '13345774', 0, 0, 0, 0, 0, 0);

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
(260, 5, 1),
(261, 5, 2),
(262, 5, 3),
(263, 5, 6),
(264, 5, 7),
(268, 3, 2),
(269, 3, 3),
(270, 3, 6),
(271, 3, 10),
(272, 2, 1),
(273, 2, 2),
(274, 2, 3),
(275, 2, 4),
(276, 2, 6);

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
  `logo` varchar(255) DEFAULT NULL,
  `tipo_equipo` varchar(2) NOT NULL DEFAULT 'Af'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre`, `delegado_equipo`, `status_id`, `genero`, `logo`, `tipo_equipo`) VALUES
(1, 'Toros FC', '31151553', 1, 'M', NULL, 'AF'),
(24, 'Contadores', '20876345', 1, 'F', NULL, 'AF'),
(25, 'Contadores', '18943210', 1, 'M', NULL, 'AF'),
(26, 'CRPU', '17456239', 1, 'F', NULL, 'AF'),
(27, 'Casa Portuguesa', '22334455', 1, 'F', NULL, 'AF'),
(28, 'Casa Portuguesa', '14567890', 1, 'M', NULL, 'AF'),
(29, 'APUC', '20123456', 1, 'F', NULL, 'AF'),
(30, 'Licda. Educación', '19876543', 1, 'F', NULL, 'AF'),
(31, 'Lic. Educación', '13345678', 1, 'M', NULL, 'AF'),
(32, 'ADC', '19283746', 1, 'F', NULL, 'AF'),
(33, 'Empresa UC', '22334455', 1, 'F', NULL, 'AF'),
(34, 'Empresa UC', '21098765', 1, 'M', NULL, 'AF'),
(35, 'Polígono', '20567834', 1, 'F', NULL, 'AF'),
(36, 'Polígono', '16789012', 1, 'M', NULL, 'AF'),
(37, 'UPT Valencia', '16678899', 1, 'M', NULL, 'AF'),
(38, 'Hogar Hispano', '18889900', 1, 'F', NULL, 'AF'),
(39, 'Veteranos', '15678901', 1, 'F', NULL, 'AF'),
(40, 'Veteranos', '17894561', 1, 'M', NULL, 'AF'),
(41, 'Los Titanes', '14789632', 1, 'M', NULL, 'AF'),
(42, 'Las Panteras', '21998877', 1, 'F', NULL, 'AF'),
(43, 'Estrellas del Sur', '20876345', 1, 'F', NULL, 'AF'),
(44, 'Guerreros', '17456239', 1, 'M', NULL, 'AF'),
(65, 'Leones FC', '13345680', 1, 'M', NULL, 'AF'),
(66, 'Águilas FC', '13345682', 1, 'M', NULL, 'AF'),
(67, 'Halcones FC', '13345684', 1, 'M', NULL, 'AF'),
(68, 'Cóndores SC', '13345686', 1, 'M', NULL, 'AF'),
(69, 'Tiburones FC', '13345688', 1, 'M', NULL, 'AF'),
(70, 'Panteras SC', '13345690', 1, 'M', NULL, 'AF'),
(71, 'Lobos FC', '13345692', 1, 'M', NULL, 'AF'),
(72, 'Osos FC', '13345694', 1, 'M', NULL, 'AF'),
(73, 'Rayos FC', '13345696', 1, 'M', NULL, 'AF'),
(74, 'Truenos SC', '13345698', 1, 'M', NULL, 'AF'),
(75, 'Volcanes FC', '13345700', 1, 'M', NULL, 'AF'),
(76, 'Dragones SC', '13345702', 1, 'M', NULL, 'AF'),
(77, 'Titanes FC', '13345704', 1, 'M', NULL, 'AF'),
(78, 'Gladiadores FC', '13345706', 1, 'M', NULL, 'AF'),
(79, 'Ciclones SC', '13345708', 1, 'M', NULL, 'AF'),
(80, 'Huracanes FC', '13345710', 1, 'M', NULL, 'AF'),
(81, 'Relámpagos SC', '13345712', 1, 'M', NULL, 'AF'),
(82, 'Jaguares FC', '13345714', 1, 'M', NULL, 'AF'),
(83, 'Águilas Doradas', '13345716', 1, 'M', NULL, 'AF'),
(84, 'Gacelas FC', '13345679', 1, 'F', NULL, 'AF'),
(85, 'Estrellas SC', '13345681', 1, 'F', NULL, 'AF'),
(86, 'Mariposas FC', '13345683', 1, 'F', NULL, 'AF'),
(87, 'Flores SC', '13345685', 1, 'F', NULL, 'AF'),
(88, 'Amazonas FC', '13345687', 1, 'F', NULL, 'AF'),
(89, 'Valkirias SC', '13345689', 1, 'F', NULL, 'AF'),
(90, 'Sirenas FC', '13345691', 1, 'F', NULL, 'AF'),
(91, 'Fénix SC', '13345693', 1, 'F', NULL, 'AF'),
(92, 'Unicornios FC', '13345695', 1, 'F', NULL, 'AF'),
(93, 'Auroras SC', '13345697', 1, 'F', NULL, 'AF'),
(94, 'Pegasos FC', '13345699', 1, 'F', NULL, 'AF'),
(95, 'Arcoíris SC', '13345701', 1, 'F', NULL, 'AF'),
(96, 'Hadas FC', '13345703', 1, 'F', NULL, 'AF'),
(97, 'Perlas SC', '13345705', 1, 'F', NULL, 'AF'),
(98, 'Joyas FC', '13345707', 1, 'F', NULL, 'AF'),
(99, 'Diamantes SC', '13345709', 1, 'F', NULL, 'AF'),
(100, 'Rubíes FC', '13345711', 1, 'F', NULL, 'AF'),
(101, 'Zafiros SC', '13345713', 1, 'F', NULL, 'AF'),
(102, 'Esmeraldas FC', '13345715', 1, 'F', NULL, 'AF'),
(103, 'Topacios SC', '13345717', 1, 'F', NULL, 'AF'),
(104, 'City', '13345692', 1, 'F', NULL, 'IN'),
(105, 'SINPROTEC', '7542758', 1, 'F', NULL, 'AF'),
(106, 'Por ahi', '13345693', 1, 'M', NULL, 'AF');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_jugadores`
--

CREATE TABLE `equipo_jugadores` (
  `id` int(10) UNSIGNED NOT NULL,
  `jugador_id` varchar(15) NOT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `equipo_jugadores`
--

INSERT INTO `equipo_jugadores` (`id`, `jugador_id`, `equipo_id`, `status_id`) VALUES
(106, '18943210', 25, 1),
(107, '18943210', 28, 1),
(108, '18943210', 37, 1),
(109, '17456239', 26, 1),
(110, '17456239', 38, 1),
(111, '17456239', 44, 1),
(112, '14567890', 28, 1),
(113, '14567890', 31, 1),
(114, '14567890', 34, 1),
(115, '20123456', 29, 1),
(116, '20123456', 30, 1),
(117, '20123456', 32, 1),
(118, '16789012', 25, 1),
(119, '16789012', 31, 1),
(120, '16789012', 36, 1),
(124, '15678901', 25, 1),
(125, '15678901', 34, 1),
(126, '15678901', 40, 1),
(127, '22334455', 27, 1),
(128, '22334455', 33, 1),
(129, '22334455', 38, 1),
(130, '21098765', 25, 1),
(131, '21098765', 34, 1),
(132, '21098765', 36, 1),
(133, '17894561', 24, 1),
(134, '17894561', 38, 1),
(135, '17894561', 39, 1),
(136, '13345678', 25, 1),
(137, '13345678', 31, 1),
(138, '13345678', 40, 1),
(139, '19283746', 32, 1),
(140, '19283746', 35, 1),
(141, '19283746', 38, 1),
(142, '16678899', 25, 1),
(143, '16678899', 37, 1),
(144, '16678899', 41, 1),
(145, '18889900', 24, 1),
(146, '18889900', 38, 1),
(147, '18889900', 42, 1),
(148, '15432198', 25, 1),
(149, '15432198', 28, 1),
(150, '15432198', 41, 1),
(151, '20567834', 24, 1),
(152, '20567834', 35, 2),
(153, '20567834', 39, 2),
(154, '14789632', 25, 1),
(155, '14789632', 36, 1),
(156, '14789632', 41, 1),
(157, '21998877', 24, 1),
(158, '21998877', 38, 1),
(159, '21998877', 42, 1),
(160, '13345678', 69, 1),
(161, '13345762', 68, 1),
(162, '13345716', 65, 1),
(163, '13345774', 67, 1),
(164, '13345684', 70, 1),
(165, '13345764', 76, 1),
(166, '13345762', 77, 1),
(167, '13345740', 65, 1),
(168, '16678899', 82, 1),
(169, '13345688', 71, 1),
(170, '13345714', 80, 1),
(171, '15678901', 68, 1),
(172, '13345702', 72, 1),
(173, '13345746', 67, 1),
(174, '13345750', 78, 1),
(175, '13345768', 71, 1),
(176, '16789012', 72, 1),
(177, '13345776', 74, 1),
(178, '13345748', 80, 1),
(179, '13345688', 1, 1),
(180, '13345762', 76, 1),
(181, '13345692', 75, 1),
(182, '13345776', 82, 1),
(183, '13345740', 73, 1),
(184, '13345714', 66, 1),
(185, '13345754', 66, 1),
(187, '13345754', 65, 1),
(188, '13345738', 81, 1),
(189, '13345728', 78, 1),
(190, '21098765', 70, 1),
(191, '18943210', 75, 1),
(192, '13345698', 73, 1),
(193, '13345682', 70, 1),
(194, '13345742', 75, 1),
(195, '13345730', 73, 1),
(196, '13345698', 82, 1),
(197, '13345722', 72, 1),
(198, '13345756', 81, 1),
(199, '16789012', 83, 1),
(200, '13345770', 74, 1),
(201, '13345716', 68, 1),
(202, '13345736', 82, 1),
(203, '13345774', 83, 1),
(204, '13345746', 76, 1),
(205, '13345704', 72, 1),
(206, '13345696', 80, 1),
(207, '13345724', 67, 1),
(208, '15678901', 67, 1),
(209, '13345770', 79, 1),
(210, '13345708', 79, 2),
(211, '13345748', 74, 1),
(212, '13345752', 70, 2),
(213, '13345728', 79, 1),
(214, '13345730', 70, 1),
(215, '13345762', 81, 1),
(216, '13345706', 72, 1),
(217, '13345744', 81, 1),
(218, '13345770', 81, 1),
(219, '13345772', 76, 1),
(220, '13345776', 75, 1),
(221, '13345754', 72, 1),
(222, '13345736', 76, 1),
(223, '13345694', 66, 1),
(224, '13345734', 69, 1),
(225, '13345758', 82, 1),
(226, '13345746', 70, 1),
(227, '13345764', 70, 1),
(228, '13345754', 75, 1),
(229, '14789632', 80, 1),
(230, '13345724', 68, 1),
(231, '13345762', 78, 1),
(232, '13345726', 70, 1),
(233, '13345750', 77, 1),
(234, '13345714', 67, 1),
(235, '14789632', 70, 1),
(236, '21098765', 71, 1),
(237, '13345690', 78, 1),
(238, '13345678', 76, 1),
(239, '13345710', 79, 1),
(240, '13345738', 73, 1),
(241, '13345708', 78, 2),
(242, '13345712', 70, 1),
(243, '13345750', 69, 1),
(244, '13345738', 71, 1),
(245, '13345700', 66, 1),
(246, '16789012', 70, 1),
(247, '13345756', 68, 1),
(248, '13345732', 75, 1),
(249, '13345728', 66, 1),
(250, '13345734', 68, 1),
(251, '13345728', 77, 1),
(252, '13345690', 81, 1),
(253, '13345694', 78, 1),
(254, '13345694', 71, 1),
(255, '13345770', 65, 1),
(256, '13345718', 65, 1),
(257, '13345756', 66, 1),
(258, '13345742', 77, 1),
(259, '13345724', 76, 1),
(260, '13345688', 76, 1),
(261, '13345706', 83, 1),
(262, '13345746', 71, 1),
(263, '13345700', 81, 1),
(264, '13345754', 82, 1),
(265, '13345718', 80, 1),
(266, '13345680', 69, 1),
(267, '13345734', 79, 1),
(268, '13345730', 76, 1),
(269, '13345702', 79, 1),
(270, '13345728', 1, 1),
(271, '16678899', 67, 1),
(272, '15678901', 76, 1),
(273, '13345710', 68, 1),
(274, '13345700', 82, 1),
(275, '13345722', 76, 1),
(276, '13345692', 78, 1),
(277, '13345752', 69, 1),
(278, '13345696', 75, 1),
(279, '13345746', 74, 1),
(280, '15678901', 71, 1),
(281, '13345750', 1, 1),
(282, '13345748', 71, 1),
(283, '13345686', 81, 1),
(284, '13345706', 82, 1),
(285, '13345708', 66, 1),
(286, '13345714', 78, 1),
(287, '13345756', 80, 1),
(288, '13345766', 71, 1),
(289, '13345752', 77, 1),
(290, '13345726', 68, 1),
(291, '13345718', 70, 1),
(292, '13345692', 66, 1),
(293, '13345774', 68, 1),
(294, '13345694', 75, 1),
(295, '13345698', 77, 1),
(296, '13345688', 67, 1),
(297, '13345740', 79, 1),
(298, '13345694', 69, 1),
(299, '13345704', 69, 1),
(300, '13345742', 78, 1),
(301, '13345774', 76, 1),
(302, '13345768', 69, 1),
(303, '13345716', 79, 1),
(304, '16789012', 82, 1),
(305, '13345760', 67, 1),
(306, '13345734', 76, 1),
(307, '13345710', 65, 1),
(308, '13345686', 71, 1),
(309, '13345740', 71, 1),
(310, '13345752', 81, 2),
(311, '13345750', 70, 1),
(312, '13345680', 72, 1),
(313, '13345762', 73, 1),
(314, '13345744', 65, 1),
(315, '13345716', 67, 1),
(316, '13345742', 81, 1),
(317, '13345748', 69, 1),
(318, '15432198', 67, 1),
(319, '13345682', 65, 1),
(320, '13345696', 77, 1),
(321, '13345754', 80, 1),
(322, '13345772', 72, 1),
(323, '13345708', 69, 1),
(324, '13345758', 69, 1),
(325, '13345760', 70, 1),
(327, '13345708', 73, 2),
(328, '13345710', 74, 1),
(329, '13345732', 65, 1),
(330, '14567890', 79, 1),
(331, '13345686', 72, 1),
(332, '13345702', 65, 1),
(333, '13345714', 76, 1),
(334, '13345738', 78, 1),
(335, '13345702', 70, 1),
(336, '13345702', 82, 1),
(337, '13345700', 83, 1),
(338, '18943210', 83, 1),
(339, '13345736', 1, 1),
(341, '13345708', 83, 2),
(342, '14789632', 73, 1),
(343, '13345688', 77, 1),
(344, '13345710', 78, 1),
(345, '13345686', 65, 1),
(346, '13345682', 75, 1),
(347, '13345732', 67, 1),
(348, '18943210', 66, 1),
(349, '16678899', 1, 1),
(350, '13345686', 69, 1),
(351, '14789632', 65, 1),
(352, '13345698', 83, 1),
(353, '15678901', 65, 1),
(354, '13345726', 74, 1),
(355, '15678901', 1, 1),
(356, '13345704', 66, 1),
(357, '13345772', 77, 1),
(358, '13345736', 77, 1),
(359, '13345704', 71, 1),
(360, '28883654', 31, 1),
(361, '28883654', 36, 2),
(387, '19876543', 30, 1),
(388, '19876543', 32, 1),
(389, '19876543', 35, 1),
(509, '31151553', 34, 1),
(510, '31151553', 36, 2),
(511, '31151553', 66, 1),
(512, '31151553', 67, 2),
(513, '31151553', 68, 1),
(514, '31151553', 69, 2),
(515, '31151553', 76, 2),
(516, '31151553', 77, 2),
(525, '31151554', 25, 1),
(526, '31151554', 28, 1),
(527, '31151554', 31, 1),
(528, '31151554', 36, 2),
(529, '31151554', 40, 2),
(530, '31151554', 44, 2),
(531, '31151554', 66, 2),
(532, '9089886', 25, 1),
(533, '9089886', 73, 1),
(540, '10733998', 26, 1),
(541, '10733998', 32, 1),
(542, '20876345', 24, 1),
(543, '20876345', 38, 1),
(544, '20876345', 43, 1),
(551, '31170220', 27, 1),
(552, '31170220', 29, 1),
(553, '31170220', 30, 1),
(554, '31170220', 99, 1),
(555, '31151552', 40, 1),
(556, '31151552', 65, 1),
(557, '7542758', 104, 2),
(558, '7542758', 105, 1),
(559, '31170220', 105, 1),
(560, '13345739', 105, 1),
(561, '13345717', 105, 1),
(562, '13345731', 105, 1),
(563, '13345775', 105, 1),
(564, '13345745', 105, 1),
(565, '20567834', 42, 1),
(566, '13345711', 42, 1),
(567, '13345771', 42, 1),
(568, '20567834', 33, 1),
(569, '13345752', 34, 1),
(570, '13345773', 33, 1),
(571, '13345708', 34, 1),
(573, '1234567890', 1, 1),
(574, '1234567890', 44, 1),
(575, '9089886', 44, 1),
(576, '12345678', 44, 1),
(577, '87654321', 44, 1),
(578, '23456789', 44, 1),
(579, '34567890', 44, 1),
(580, '45678901', 44, 1),
(581, '123456543', 65, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `torneo_id`, `genero`, `status_id`) VALUES
(1, 'A', 8, 'M', 1),
(2, 'B', 8, 'M', 1),
(3, 'C', 8, 'M', 1),
(4, 'D', 8, 'M', 1),
(5, 'A', 8, 'F', 1),
(6, 'B', 8, 'F', 1),
(7, 'C', 8, 'F', 1),
(8, 'D', 8, 'F', 1),
(9, 'A', 7, 'M', 2),
(10, 'A', 9, 'M', 1),
(11, 'B', 9, 'M', 1),
(12, 'C', 9, 'M', 1),
(13, 'D', 9, 'M', 1),
(14, 'A', 9, 'F', 1),
(15, 'B', 9, 'F', 1),
(16, 'C', 9, 'F', 1),
(17, 'D', 9, 'F', 1),
(18, 'B', 6, 'M', 1),
(19, 'A', 10, 'M', 1),
(20, 'B', 10, 'M', 1),
(21, 'C', 10, 'M', 1),
(22, 'D', 10, 'M', 1),
(23, 'A', 10, 'F', 1),
(24, 'B', 10, 'F', 1),
(25, 'C', 10, 'F', 1),
(26, 'D', 10, 'F', 1),
(27, 'A', 11, 'M', 1),
(28, 'B', 11, 'M', 1),
(29, 'C', 11, 'M', 1),
(30, 'D', 11, 'M', 1),
(31, 'A', 11, 'F', 1),
(32, 'B', 11, 'F', 1),
(33, 'C', 11, 'F', 1),
(34, 'D', 11, 'F', 2),
(35, 'no se', 11, 'M', 2),
(36, 'aa', 11, 'M', 2),
(37, 'A', 12, 'M', 1),
(38, 'B', 12, 'M', 1),
(39, 'C', 12, 'M', 1),
(40, 'D', 12, 'M', 1),
(41, 'A', 12, 'F', 1),
(42, 'B', 12, 'F', 1),
(43, 'C', 12, 'F', 1),
(44, 'D', 12, 'F', 1),
(45, 'A', 13, 'M', 1),
(46, 'B', 13, 'M', 1),
(47, 'C', 13, 'M', 1),
(48, 'D', 13, 'M', 1),
(49, 'A', 13, 'F', 1),
(50, 'B', 13, 'F', 1),
(51, 'C', 13, 'F', 1),
(52, 'D', 13, 'F', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_equipos`
--

CREATE TABLE `inscripciones_equipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL,
  `grupo_id` int(10) UNSIGNED DEFAULT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripciones_equipos`
--

INSERT INTO `inscripciones_equipos` (`id`, `torneo_id`, `grupo_id`, `equipo_id`, `genero`, `fecha_inscripcion`, `status_id`) VALUES
(1, 10, 20, 83, 'M', '2025-06-19', 1),
(5, 9, 10, 31, 'M', '2025-06-19', 2),
(6, 10, 19, 66, 'M', '2025-06-19', 1),
(7, 10, 22, 81, 'M', '2025-06-19', 1),
(8, 10, 19, 77, 'M', '2025-06-19', 1),
(9, 9, 14, 32, 'F', '2025-06-21', 2),
(10, 10, 22, 28, 'M', '2025-06-21', 1),
(11, 10, 20, 37, 'M', '2025-06-21', 1),
(15, 10, 20, 1, 'M', '2025-06-24', 1),
(16, 10, 21, 25, 'M', '2025-06-24', 1),
(18, 10, 21, 40, 'M', '2025-06-24', 1),
(19, 10, 21, 65, 'M', '2025-06-24', 1),
(20, 10, 21, 82, 'M', '2025-06-24', 1),
(21, 10, 21, 68, 'M', '2025-06-24', 1),
(22, 10, 19, 70, 'M', '2025-06-24', 1),
(23, 10, 20, 69, 'M', '2025-06-24', 1),
(24, 10, 21, 73, 'M', '2025-06-24', 1),
(25, 10, 20, 75, 'M', '2025-06-24', 1),
(26, 10, 19, 71, 'M', '2025-06-24', 1),
(27, 10, 19, 74, 'M', '2025-06-24', 1),
(28, 10, 22, 72, 'M', '2025-06-24', 1),
(29, 10, 20, 78, 'M', '2025-06-24', 1),
(30, 10, 19, 67, 'M', '2025-06-24', 1),
(31, 10, 22, 76, 'M', '2025-06-24', 1),
(32, 10, 20, 80, 'M', '2025-06-24', 1),
(33, 10, 21, 79, 'M', '2025-06-24', 1),
(34, 10, 22, 31, 'M', '2025-06-25', 1),
(35, 10, 22, 36, 'M', '2025-06-30', 1),
(36, 10, 19, 41, 'M', '2025-06-30', 1),
(38, 8, NULL, 70, 'M', '2025-07-01', 2),
(39, 11, NULL, 71, 'M', '2025-07-01', 2),
(40, 11, 5, 72, 'M', '2025-07-01', 2),
(41, 11, NULL, 70, 'M', '2025-07-01', 2),
(42, 12, NULL, 69, 'M', '2025-07-02', 2),
(43, 12, 5, 70, 'M', '2025-07-03', 2),
(44, 13, 5, 105, 'F', '2025-07-03', 2),
(45, 10, 22, 34, 'M', '2025-07-07', 2),
(47, 10, NULL, 105, 'F', '2025-07-08', 1),
(48, 10, 22, 44, 'M', '2025-07-08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_equipo_jugadores`
--

CREATE TABLE `inscripcion_equipo_jugadores` (
  `inscripcion_id` int(10) UNSIGNED NOT NULL,
  `jugador_id` varchar(15) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion_equipo_jugadores`
--

INSERT INTO `inscripcion_equipo_jugadores` (`inscripcion_id`, `jugador_id`, `status_id`) VALUES
(1, '13345698', 1),
(1, '13345700', 1),
(1, '13345706', 1),
(1, '13345708', 1),
(1, '13345774', 1),
(1, '16789012', 1),
(1, '18943210', 1),
(6, '13345694', 1),
(6, '13345714', 1),
(6, '13345728', 1),
(6, '18943210', 1),
(7, '13345700', 1),
(7, '13345738', 1),
(7, '13345756', 1),
(7, '13345770', 1),
(8, '13345696', 1),
(8, '13345752', 1),
(8, '13345762', 1),
(10, '14567890', 1),
(15, '13345736', 1),
(15, '15678901', 1),
(15, '31151553', 1),
(19, '13345710', 1),
(19, '13345718', 1),
(19, '13345732', 1),
(19, '13345740', 1),
(19, '13345744', 1),
(20, '13345698', 1),
(20, '13345706', 1),
(20, '13345754', 1),
(20, '13345758', 1),
(21, '13345716', 1),
(21, '13345724', 1),
(21, '13345726', 1),
(21, '13345774', 1),
(22, '13345682', 1),
(22, '13345684', 1),
(22, '13345746', 1),
(22, '13345750', 1),
(23, '13345678', 1),
(23, '13345680', 1),
(23, '13345686', 1),
(23, '13345704', 1),
(23, '13345734', 1),
(24, '13345708', 1),
(24, '13345730', 1),
(25, '13345692', 1),
(25, '13345742', 1),
(26, '13345688', 1),
(26, '13345768', 1),
(26, '21098765', 1),
(27, '13345776', 1),
(35, '14789632', 1),
(35, '16789012', 1),
(35, '21098765', 1),
(35, '28883654', 1),
(35, '31151553', 1),
(35, '31151554', 1),
(47, '13345717', 1),
(47, '13345731', 1),
(47, '13345739', 1),
(47, '13345745', 1),
(47, '13345775', 1),
(47, '31170220', 1),
(47, '7542758', 1),
(48, '12345678', 1),
(48, '1234567890', 1),
(48, '23456789', 1),
(48, '31151554', 1),
(48, '34567890', 1),
(48, '87654321', 1),
(48, '9089886', 1),
(1, '14789632', 2),
(1, '15432198', 2),
(1, '16678899', 2),
(5, '13345678', 2),
(5, '14567890', 2),
(5, '16789012', 2),
(9, '19876543', 2),
(9, '20123456', 2),
(38, '13345682', 2),
(38, '13345684', 2),
(38, '13345726', 2),
(38, '13345730', 2),
(38, '13345746', 2),
(38, '13345752', 2),
(38, '13345764', 2),
(38, '21098765', 2),
(39, '13345688', 2),
(39, '13345694', 2),
(39, '13345738', 2),
(39, '13345768', 2),
(39, '21098765', 2),
(40, '13345702', 2),
(40, '13345704', 2),
(40, '13345706', 2),
(40, '13345722', 2),
(40, '16789012', 2),
(41, '13345682', 2),
(41, '13345684', 2),
(41, '13345702', 2),
(41, '13345712', 2),
(41, '13345718', 2),
(41, '13345726', 2),
(41, '13345730', 2),
(41, '13345746', 2),
(41, '13345752', 2),
(41, '13345764', 2),
(41, '14789632', 2),
(41, '16789012', 2),
(41, '21098765', 2),
(42, '13345678', 2),
(42, '13345680', 2),
(42, '13345686', 2),
(42, '13345694', 2),
(42, '13345704', 2),
(42, '13345734', 2),
(42, '13345750', 2),
(42, '13345752', 2),
(42, '13345758', 2),
(42, '13345768', 2),
(42, '31151553', 2),
(43, '13345682', 2),
(43, '13345684', 2),
(43, '13345730', 2),
(43, '13345746', 2),
(43, '13345752', 2),
(43, '21098765', 2),
(44, '13345717', 2),
(44, '13345731', 2),
(44, '13345739', 2),
(44, '31170220', 2),
(44, '7542758', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(10) UNSIGNED NOT NULL,
  `torneo_id` int(10) UNSIGNED NOT NULL,
  `genero` varchar(20) NOT NULL,
  `grupo_id` int(10) UNSIGNED NOT NULL,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `vs_equipo_id` int(10) UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `planilla` varchar(255) DEFAULT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `torneo_id`, `genero`, `grupo_id`, `equipo_id`, `vs_equipo_id`, `fecha`, `hora`, `planilla`, `status_id`) VALUES
(1, 10, 'M', 20, 83, 37, NULL, NULL, NULL, 3),
(2, 10, 'M', 20, 83, 1, NULL, NULL, NULL, 3),
(3, 10, 'M', 20, 83, 69, NULL, NULL, NULL, 3),
(4, 10, 'M', 20, 83, 75, NULL, NULL, NULL, 3),
(5, 10, 'M', 20, 83, 78, NULL, NULL, NULL, 3),
(6, 10, 'M', 20, 83, 80, NULL, NULL, NULL, 3),
(7, 10, 'M', 20, 37, 1, NULL, NULL, NULL, 3),
(8, 10, 'M', 20, 37, 69, NULL, NULL, NULL, 3),
(9, 10, 'M', 20, 37, 75, NULL, NULL, NULL, 3),
(10, 10, 'M', 20, 37, 78, NULL, NULL, NULL, 3),
(11, 10, 'M', 20, 37, 80, NULL, NULL, NULL, 3),
(12, 10, 'M', 20, 1, 69, NULL, NULL, NULL, 3),
(13, 10, 'M', 20, 1, 75, NULL, NULL, NULL, 3),
(14, 10, 'M', 20, 1, 78, NULL, NULL, NULL, 3),
(15, 10, 'M', 20, 1, 80, NULL, NULL, NULL, 3),
(16, 10, 'M', 20, 69, 75, NULL, NULL, NULL, 3),
(17, 10, 'M', 20, 69, 78, NULL, NULL, NULL, 3),
(18, 10, 'M', 20, 69, 80, NULL, NULL, NULL, 3),
(19, 10, 'M', 20, 75, 78, NULL, NULL, NULL, 3),
(20, 10, 'M', 20, 75, 80, NULL, NULL, NULL, 3),
(21, 10, 'M', 20, 78, 80, NULL, NULL, NULL, 3),
(22, 10, 'M', 19, 66, 77, NULL, NULL, NULL, 3),
(23, 10, 'M', 19, 66, 70, NULL, NULL, NULL, 3),
(24, 10, 'M', 19, 66, 71, NULL, NULL, NULL, 3),
(25, 10, 'M', 19, 66, 74, NULL, NULL, NULL, 3),
(26, 10, 'M', 19, 66, 67, NULL, NULL, NULL, 3),
(27, 10, 'M', 19, 66, 41, NULL, NULL, NULL, 3),
(28, 10, 'M', 19, 77, 70, NULL, NULL, NULL, 3),
(29, 10, 'M', 19, 77, 71, NULL, NULL, NULL, 3),
(30, 10, 'M', 19, 77, 74, NULL, NULL, NULL, 3),
(31, 10, 'M', 19, 77, 67, NULL, NULL, NULL, 3),
(32, 10, 'M', 19, 77, 41, NULL, NULL, NULL, 3),
(33, 10, 'M', 19, 70, 71, NULL, NULL, NULL, 3),
(34, 10, 'M', 19, 70, 74, NULL, NULL, NULL, 3),
(35, 10, 'M', 19, 70, 67, NULL, NULL, NULL, 3),
(36, 10, 'M', 19, 70, 41, NULL, NULL, NULL, 3),
(37, 10, 'M', 19, 71, 74, NULL, NULL, NULL, 3),
(38, 10, 'M', 19, 71, 67, NULL, NULL, NULL, 3),
(39, 10, 'M', 19, 71, 41, NULL, NULL, NULL, 3),
(40, 10, 'M', 19, 74, 67, NULL, NULL, NULL, 3),
(41, 10, 'M', 19, 74, 41, NULL, NULL, NULL, 3),
(42, 10, 'M', 19, 67, 41, NULL, NULL, NULL, 3),
(43, 10, 'M', 22, 81, 28, NULL, NULL, NULL, 3),
(44, 10, 'M', 22, 81, 72, NULL, NULL, NULL, 3),
(45, 10, 'M', 22, 81, 76, NULL, NULL, NULL, 3),
(46, 10, 'M', 22, 81, 31, NULL, NULL, NULL, 3),
(47, 10, 'M', 22, 81, 36, NULL, NULL, NULL, 3),
(48, 10, 'M', 22, 81, 44, NULL, NULL, NULL, 3),
(49, 10, 'M', 22, 28, 72, NULL, NULL, NULL, 3),
(50, 10, 'M', 22, 28, 76, NULL, NULL, NULL, 3),
(51, 10, 'M', 22, 28, 31, NULL, NULL, NULL, 3),
(52, 10, 'M', 22, 28, 36, NULL, NULL, NULL, 3),
(53, 10, 'M', 22, 28, 44, NULL, NULL, NULL, 3),
(54, 10, 'M', 22, 72, 76, NULL, NULL, NULL, 3),
(55, 10, 'M', 22, 72, 31, NULL, NULL, NULL, 3),
(56, 10, 'M', 22, 72, 36, NULL, NULL, NULL, 3),
(57, 10, 'M', 22, 72, 44, NULL, NULL, NULL, 3),
(58, 10, 'M', 22, 76, 31, NULL, NULL, NULL, 3),
(59, 10, 'M', 22, 76, 36, NULL, NULL, NULL, 3),
(60, 10, 'M', 22, 76, 44, NULL, NULL, NULL, 3),
(61, 10, 'M', 22, 31, 36, NULL, NULL, NULL, 3),
(62, 10, 'M', 22, 31, 44, NULL, NULL, NULL, 3),
(63, 10, 'M', 22, 36, 44, NULL, NULL, NULL, 3),
(64, 10, 'M', 21, 25, 40, NULL, NULL, NULL, 3),
(65, 10, 'M', 21, 25, 65, NULL, NULL, NULL, 3),
(66, 10, 'M', 21, 25, 82, NULL, NULL, NULL, 3),
(67, 10, 'M', 21, 25, 68, NULL, NULL, NULL, 3),
(68, 10, 'M', 21, 25, 73, NULL, NULL, NULL, 3),
(69, 10, 'M', 21, 25, 79, NULL, NULL, NULL, 3),
(70, 10, 'M', 21, 40, 65, NULL, NULL, NULL, 3),
(71, 10, 'M', 21, 40, 82, NULL, NULL, NULL, 3),
(72, 10, 'M', 21, 40, 68, NULL, NULL, NULL, 3),
(73, 10, 'M', 21, 40, 73, NULL, NULL, NULL, 3),
(74, 10, 'M', 21, 40, 79, NULL, NULL, NULL, 3),
(75, 10, 'M', 21, 65, 82, NULL, NULL, NULL, 3),
(76, 10, 'M', 21, 65, 68, NULL, NULL, NULL, 3),
(77, 10, 'M', 21, 65, 73, NULL, NULL, NULL, 3),
(78, 10, 'M', 21, 65, 79, NULL, NULL, NULL, 3),
(79, 10, 'M', 21, 82, 68, NULL, NULL, NULL, 3),
(80, 10, 'M', 21, 82, 73, NULL, NULL, NULL, 3),
(81, 10, 'M', 21, 82, 79, NULL, NULL, NULL, 3),
(82, 10, 'M', 21, 68, 73, NULL, NULL, NULL, 3),
(83, 10, 'M', 21, 68, 79, NULL, NULL, NULL, 3),
(84, 10, 'M', 21, 73, 79, '2025-07-09', '17:00:00', NULL, 3);

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
('10733998', 'Besliht', 'Hidalgo', '1970-05-01', 'hidalgobeslith@gamil.com', '04144204949', 1, 'F'),
('123456543', 'jjjjjjjjjjjjjjjjjjhllllllllllll', 'ajjjjjjjjjjjjjjjjjj', '1993-11-11', 'jjjjjjjjjjjjj@j.com', '+584141288999', 1, 'M'),
('12345678', 'Carlos', 'Pérez', '2000-05-15', 'carlos.perez@example.com', '04141234567', 1, 'M'),
('1234567890', 'Jose', 'More', '1977-07-22', 'jose_moreno@gmail.com', '04123445678', 1, 'M'),
('13345678', 'Miguel', 'Castro', '1995-11-30', 'miguel.castro@gmail.com', '04161110002', 1, 'M'),
('13345679', 'Sofía', 'Rojas', '1998-03-15', 'sofia.rojas@hotmail.com', '04241234567', 1, 'F'),
('13345680', 'Carlos', 'Mendoza', '1992-07-22', 'carlos.mendoza@yahoo.com', '04141234578', 1, 'M'),
('13345681', 'Valentina', 'Pérez', '2000-01-10', 'valentina.perez@gmail.com', '04161234579', 1, 'F'),
('13345682', 'Jorge', 'González', '1994-09-05', 'jorge.gonzalez@outlook.com', '04261234580', 1, 'M'),
('13345683', 'Camila', 'Silva', '1999-12-18', 'camila.silva@gmail.com', '04141234581', 1, 'F'),
('13345684', 'Andrés', 'Herrera', '1993-06-25', 'andres.herrera@yahoo.com', '04161234582', 1, 'M'),
('13345685', 'Isabella', 'Torres', '1997-04-12', 'isabella.torres@gmail.com', '04241234583', 1, 'F'),
('13345686', 'Luis', 'Díaz', '1991-08-30', 'luis.diaz@hotmail.com', '04141234584', 1, 'M'),
('13345687', 'Gabriela', 'Vargas', '1996-02-14', 'gabriela.vargas@gmail.com', '04161234585', 1, 'F'),
('13345688', 'Diego', 'Ramírez', '1990-05-19', 'diego.ramirez@yahoo.com', '04261234586', 1, 'M'),
('13345689', 'María', 'Ríos', '1995-11-03', 'maria.rios@gmail.com', '04141234587', 1, 'F'),
('13345690', 'Fernando', 'Cordero', '1992-07-28', 'fernando.cordero@outlook.com', '04161234588', 1, 'M'),
('13345691', 'Ana', 'Morales', '1998-04-07', 'ana.morales@hotmail.com', '04241234589', 1, 'F'),
('13345692', 'Ricardo', 'Navarro', '1994-10-15', 'ricardo.navarro@gmail.com', '04141234590', 1, 'M'),
('13345693', 'Lucía', 'Molina', '1999-01-22', 'lucia.molina@yahoo.com', '04161234591', 1, 'F'),
('13345694', 'José', 'Peña', '1993-08-11', 'jose.pena@gmail.com', '04261234592', 1, 'M'),
('13345695', 'Daniela', 'Guerrero', '1997-06-09', 'daniela.guerrero@hotmail.com', '04141234593', 1, 'F'),
('13345696', 'Manuel', 'Reyes', '1991-12-04', 'manuel.reyes@outlook.com', '04161234594', 1, 'M'),
('13345697', 'Paula', 'Cruz', '1996-03-27', 'paula.cruz@gmail.com', '04241234595', 1, 'F'),
('13345698', 'Juan', 'Salazar', '1990-09-14', 'juan.salazar@yahoo.com', '04141234596', 1, 'M'),
('13345699', 'Valeria', 'Fuentes', '1995-04-30', 'valeria.fuentes@gmail.com', '04161234597', 1, 'F'),
('13345700', 'Pedro', 'Acosta', '1992-11-08', 'pedro.acosta@hotmail.com', '04261234598', 1, 'M'),
('13345701', 'Antonella', 'Medina', '1998-07-17', 'antonella.medina@outlook.com', '04141234599', 1, 'F'),
('13345702', 'Alejandro', 'Cáceres', '1994-02-23', 'alejandro.caceres@gmail.com', '04161234600', 1, 'M'),
('13345703', 'Adriana', 'Paredes', '1999-05-19', 'adriana.paredes@yahoo.com', '04241234601', 1, 'F'),
('13345704', 'Rafael', 'Bravo', '1993-12-11', 'rafael.bravo@gmail.com', '04141234602', 1, 'M'),
('13345705', 'Emma', 'Miranda', '1997-08-04', 'emma.miranda@hotmail.com', '04161234603', 1, 'F'),
('13345706', 'Oscar', 'Valenzuela', '1991-04-27', 'oscar.valenzuela@outlook.com', '04261234604', 1, 'M'),
('13345707', 'Martina', 'Espinoza', '1996-01-14', 'martina.espinoza@gmail.com', '04141234605', 1, 'F'),
('13345708', 'Mario', 'Carvajal', '1990-10-09', 'mario.carvajal@yahoo.com', '04161234606', 1, 'M'),
('13345709', 'Sara', 'Lara', '1995-06-25', 'sara.lara@gmail.com', '04241234607', 1, 'F'),
('13345710', 'Hugo', 'Ochoa', '1992-03-18', 'hugo.ochoa@hotmail.com', '04141234608', 1, 'M'),
('13345711', 'Julia', 'Cabrera', '1998-12-03', 'julia.cabrera@outlook.com', '04161234609', 1, 'F'),
('13345712', 'Francisco', 'Franco', '1994-09-16', 'francisco.franco@gmail.com', '04261234610', 1, 'M'),
('13345713', 'Catalina', 'Santana', '1999-02-28', 'catalina.santana@yahoo.com', '04141234611', 1, 'F'),
('13345714', 'Pablo', 'Maldonado', '1993-07-12', 'pablo.maldonado@gmail.com', '04161234612', 1, 'M'),
('13345715', 'Renata', 'Vega', '1997-04-05', 'renata.vega@hotmail.com', '04241234613', 1, 'F'),
('13345716', 'Eduardo', 'Rangel', '1991-11-19', 'eduardo.rangel@outlook.com', '04141234614', 1, 'M'),
('13345717', 'Jimena', 'Campos', '1996-08-22', 'jimena.campos@gmail.com', '04161234615', 1, 'F'),
('13345718', 'Alberto', 'Sosa', '1990-05-07', 'alberto.sosa@yahoo.com', '04261234616', 1, 'M'),
('13345719', 'Florencia', 'Rivas', '1995-01-25', 'florencia.rivas@gmail.com', '04141234617', 1, 'F'),
('13345720', 'Gustavo', 'Aguirre', '1992-10-14', 'gustavo.aguirre@hotmail.com', '04161234618', 1, 'M'),
('13345721', 'Laura', 'Márquez', '1998-07-08', 'laura.marquez@outlook.com', '04241234619', 1, 'F'),
('13345722', 'Raúl', 'Delgado', '1994-03-31', 'raul.delgado@gmail.com', '04141234620', 1, 'M'),
('13345723', 'Carolina', 'Castaño', '1999-09-15', 'carolina.castano@yahoo.com', '04161234621', 1, 'F'),
('13345724', 'Santiago', 'Osorio', '1993-04-27', 'santiago.osorio@gmail.com', '04261234622', 1, 'M'),
('13345725', 'Ximena', 'Cortés', '1997-12-10', 'ximena.cortes@hotmail.com', '04141234623', 1, 'F'),
('13345726', 'Daniel', 'Bermúdez', '1991-08-03', 'daniel.bermudez@outlook.com', '04161234624', 1, 'M'),
('13345727', 'Victoria', 'Mejía', '1996-05-16', 'victoria.mejia@gmail.com', '04241234625', 1, 'F'),
('13345728', 'Javier', 'Pacheco', '1990-02-09', 'javier.pacheco@yahoo.com', '04141234626', 1, 'M'),
('13345729', 'Olivia', 'León', '1995-10-24', 'olivia.leon@gmail.com', '04161234627', 1, 'F'),
('13345730', 'Roberto', 'Cervantes', '1992-06-17', 'roberto.cervantes@hotmail.com', '04261234628', 1, 'M'),
('13345731', 'Emilia', 'Castañeda', '1998-03-02', 'emilia.castaneda@outlook.com', '04141234629', 1, 'F'),
('13345732', 'Felipe', 'Valdés', '1994-11-15', 'felipe.valdes@gmail.com', '04161234630', 1, 'M'),
('13345733', 'Danna', 'Gallegos', '1999-07-28', 'danna.gallegos@yahoo.com', '04241234631', 1, 'F'),
('13345734', 'Arturo', 'Velásquez', '1993-01-12', 'arturo.velasquez@gmail.com', '04141234632', 1, 'M'),
('13345735', 'Regina', 'Montes', '1997-08-05', 'regina.montes@hotmail.com', '04161234633', 1, 'F'),
('13345736', 'Sebastián', 'Zambrano', '1991-04-18', 'sebastian.zambrano@outlook.com', '04261234634', 1, 'M'),
('13345737', 'Mariana', 'Rueda', '1996-01-01', 'mariana.rueda@gmail.com', '04141234635', 1, 'F'),
('13345738', 'David', 'Giraldo', '1990-09-14', 'david.giraldo@yahoo.com', '04161234636', 1, 'M'),
('13345739', 'Antonia', 'Bernal', '1995-06-07', 'antonia.bernal@gmail.com', '04241234637', 1, 'F'),
('13345740', 'Josué', 'Quintero', '1992-03-20', 'josue.quintero@hotmail.com', '04141234638', 1, 'M'),
('13345741', 'Mía', 'Fajardo', '1998-12-03', 'mia.fajardo@outlook.com', '04161234639', 1, 'F'),
('13345742', 'Héctor', 'Cifuentes', '1994-07-16', 'hector.cifuentes@gmail.com', '04261234640', 1, 'M'),
('13345743', 'Julieta', 'Guevara', '1999-04-29', 'julieta.guevara@yahoo.com', '04141234641', 1, 'F'),
('13345744', 'Tomás', 'Escobar', '1993-10-12', 'tomas.escobar@gmail.com', '04161234642', 1, 'M'),
('13345745', 'Luna', 'Arango', '1997-05-25', 'luna.arango@hotmail.com', '04241234643', 1, 'F'),
('13345746', 'Rodrigo', 'Cadena', '1991-02-08', 'rodrigo.cadena@outlook.com', '04141234644', 1, 'M'),
('13345747', 'Abril', 'Mora', '1996-11-21', 'abril.mora@gmail.com', '04161234645', 1, 'F'),
('13345748', 'Emiliano', 'Rivera', '1990-08-04', 'emiliano.rivera@yahoo.com', '04261234646', 1, 'M'),
('13345749', 'Natalia', 'Trujillo', '1995-03-17', 'natalia.trujillo@gmail.com', '04141234647', 1, 'F'),
('13345750', 'Ángel', 'Villa', '1992-12-30', 'angel.villa@hotmail.com', '04161234648', 1, 'M'),
('13345751', 'Aitana', 'Zapata', '1998-09-13', 'aitana.zapata@outlook.com', '04241234649', 1, 'F'),
('13345752', 'Mateo', 'Gómez', '1994-05-26', 'mateo.gomez@gmail.com', '04141234650', 1, 'M'),
('13345753', 'Elena', 'Orozco', '1999-02-08', 'elena.orozco@yahoo.com', '04161234651', 1, 'F'),
('13345754', 'Nicolás', 'Roa', '1993-10-21', 'nicolas.roa@gmail.com', '04261234652', 1, 'M'),
('13345755', 'Clara', 'Parra', '1997-07-04', 'clara.parra@hotmail.com', '04141234653', 1, 'F'),
('13345756', 'Maximiliano', 'López', '1991-04-17', 'maximiliano.lopez@outlook.com', '04161234654', 1, 'M'),
('13345757', 'Alessandra', 'Guzmán', '1996-01-30', 'alessandra.guzman@gmail.com', '04241234655', 1, 'F'),
('13345758', 'Vicente', 'Hernández', '1990-11-13', 'vicente.hernandez@yahoo.com', '04141234656', 1, 'M'),
('13345759', 'Bianca', 'Dávila', '1995-08-26', 'bianca.davila@gmail.com', '04161234657', 1, 'F'),
('13345760', 'Samuel', 'Castaño', '1992-04-09', 'samuel.castano@hotmail.com', '04261234658', 1, 'M'),
('13345761', 'Valery', 'Mesa', '1998-01-22', 'valery.mesa@outlook.com', '04141234659', 1, 'F'),
('13345762', 'Juan Pablo', 'Restrepo', '1994-06-05', 'juanp.restrepo@gmail.com', '04161234660', 1, 'M'),
('13345763', 'Juliana', 'Arias', '1999-03-18', 'juliana.arias@yahoo.com', '04241234661', 1, 'F'),
('13345764', 'Diego Alejandro', 'Jiménez', '1993-12-01', 'diegoa.jimenez@gmail.com', '04141234662', 1, 'M'),
('13345765', 'Marina', 'Moreno', '1997-07-14', 'marina.moreno@hotmail.com', '04161234663', 1, 'F'),
('13345766', 'Federico', 'Suárez', '1991-02-27', 'federico.suarez@outlook.com', '04261234664', 1, 'M'),
('13345767', 'Luciana', 'Romero', '1996-11-10', 'luciana.romero@gmail.com', '04141234665', 1, 'F'),
('13345768', 'Ricardo José', 'Ortega', '1990-08-23', 'ricardoj.ortega@yahoo.com', '04161234666', 1, 'M'),
('13345769', 'Ana Sofía', 'Cárdenas', '1995-05-06', 'anas.cardenas@gmail.com', '04241234667', 1, 'F'),
('13345770', 'Joaquín', 'Vélez', '1992-01-19', 'joaquin.velez@hotmail.com', '04141234668', 1, 'M'),
('13345771', 'Catalina María', 'Franco', '1998-10-02', 'catalinam.franco@outlook.com', '04161234669', 1, 'F'),
('13345772', 'Lorenzo', 'Sánchez', '1994-04-15', 'lorenzo.sanchez@gmail.com', '04261234670', 1, 'M'),
('13345773', 'Diana Marcela', 'García', '1999-11-28', 'dianam.garcia@yahoo.com', '04141234671', 1, 'F'),
('13345774', 'Esteban', 'Lozano', '1993-07-11', 'esteban.lozano@gmail.com', '04161234672', 1, 'M'),
('13345775', 'Natalie', 'Álvarez', '1997-02-24', 'natalie.alvarez@hotmail.com', '04241234673', 1, 'F'),
('13345776', 'Juan David', 'Cano', '1991-09-07', 'juand.cano@outlook.com', '04141234674', 1, 'M'),
('13345777', 'Gabrielle', 'Santos', '1996-06-20', 'gabrielle.santos@gmail.com', '04161234675', 1, 'F'),
('14567890', 'Pedro', 'Pérez', '1995-07-30', 'pedro.perez@gmail.com', '04162345678', 1, 'M'),
('14789632', 'Samuel', 'Mora', '1996-09-07', 'samuel.mora@gmail.com', '04162223340', 1, 'M'),
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
('23456789', 'Andrés', 'Gómez', '2001-11-10', 'andres.gomez@example.com', '04241234567', 1, 'M'),
('28883654', 'Armando', 'Paredes', '2006-01-02', 'armandoAndo@gmail.com', '04244553421', 1, 'M'),
('31151552', 'Eduardo', 'Guevara', '2004-02-10', 'eduardogue@gmail.com', '04121350179', 1, 'M'),
('31151553', 'Eduar', 'Gutierrez', '2000-02-22', 'alex@gmail.com', '04121350170', 1, 'M'),
('31151554', 'Eduardo', 'Sequera', '2004-06-08', 'eduadrdoP@gmail.com', '04121350179', 1, 'M'),
('31170220', 'bbbb', 'bbbb', '2004-12-28', 'bbbb@gmail.com', '04345566670', 1, 'F'),
('34567890', 'José', 'Fernández', '1998-03-05', 'jose.fernandez@example.com', '04121234567', 1, 'M'),
('45678901', 'Miguel', 'Torres', '2002-07-30', 'miguel.torres@example.com', '04261234567', 1, 'M'),
('5567899', 'Samuel', 'Parra', '1968-06-29', 'samuel@gmail.com', '04244226789', 1, 'M'),
('7542758', 'Rossana', 'Rodriguez', '1962-04-26', 'SilvaRoss06@gmail.com', '04124508552', 1, 'F'),
('87654321', 'Luis', 'Ramírez', '1999-08-22', 'luis.ramirez@example.com', '04161234567', 1, 'M'),
('9089886', 'sss', 'sss', '2002-05-22', 'ssss@gmail.com', '04123345560', 1, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`) VALUES
(1, 'Grupos'),
(2, 'Equipos'),
(3, 'Jugadores'),
(4, 'Usuarios'),
(5, 'Configuracion'),
(6, 'Torneos'),
(7, 'Calendario'),
(8, 'Reportes'),
(9, 'Ubicaciones'),
(10, 'Inscripciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'adminstrador'),
(3, 'delegado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `nombre`) VALUES
(1, 'activo'),
(2, 'inactivo'),
(3, 'pendiente'),
(4, 'en ejecución'),
(5, 'culminado'),
(6, 'próximo'),
(7, 'suspendido');

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
(2, 'Super Copa 2025', '2025-06-01', NULL, 1, 2),
(3, 'COPA 2026', '2026-01-17', '2025-05-31', 1, 2),
(4, 'Copa Master', '2025-04-15', '2025-06-10', 1, 2),
(5, 'Campeonato Final', '2025-05-06', '2025-06-25', 1, 2),
(6, 'Campeonato 2024', '2024-03-04', '2024-10-23', 1, 2),
(7, 'Torneo 2020', '2020-02-01', '2020-11-01', 1, 2),
(8, 'Champion 2025', '2025-06-03', '2025-06-30', 1, 2),
(9, 'Copa Copa', '2025-06-09', '2025-06-22', 1, 2),
(10, 'Torneo Especial', '2025-06-03', '2025-06-23', 2, 1),
(11, 'Perido 2', '2025-06-18', '2025-07-10', 1, 2),
(12, 'VI Torneo Naguanagua', '2025-06-02', '2025-07-07', 7, 3),
(13, 'VII Naguanagua', '2025-07-04', '2025-09-10', 7, 1);

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
  `direccion` text NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `nombre`, `direccion`, `status_id`) VALUES
(1, 'Polígono de tiro', 'Redomas de Guaparo', 1),
(2, 'Casa Portuguesa', 'San Diego', 1),
(3, 'Draculandia', 'Parque Recreacional del Sur', 1),
(4, 'Forum', 'Naguanagua', 1),
(5, 'aaa', 'llllllll', 2),
(6, 'hola', 'alall', 2),
(7, 'Naguagua', 'Naguanagua', 1),
(8, 'nose', 'ala', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `rol_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user_name`, `nombre`, `apellido`, `email`, `password`, `status_id`, `rol_id`) VALUES
(1, 'admin', 'Super Admin', 'Super', 'admin@gmail.com', '792e507c9b933a1f712c452b94c4a4603af42e0293c6aa714c1f7fea541f0d50', 1, 1),
(2, 'angel', 'Vida ', 'Informatico', 'vida@gmail.com', '519ba91a5a5b4afb9dc66f8805ce8c442b6576316c19c6896af2fa9bda6aff71', 1, NULL),
(3, 'alex', 'Alejandro ', 'Gutierrez\r\n', 'ale@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1, 3),
(4, 'lou', 'Laura', 'Lara', 'lou@gmail.com', '8f00793014a5cd4994a0cbb999dbba67f9a135d5184ca326d082a65a8ad2d849', 1, 1),
(5, 'delegado', 'Delegado', 'No', 'delegado@gmail.com', '8f00793014a5cd4994a0cbb999dbba67f9a135d5184ca326d082a65a8ad2d849', 1, 3);

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
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_juego`
--
ALTER TABLE `detalles_juego`
  ADD UNIQUE KEY `uq_detalles_juego` (`juego_id`),
  ADD KEY `fk_vs_equipo` (`vs_equipo_id`),
  ADD KEY `fk_equipo` (`equipo_id`);

--
-- Indices de la tabla `detalles_jugador`
--
ALTER TABLE `detalles_jugador`
  ADD UNIQUE KEY `uq_detalles_jugador` (`juego_id`,`inscripcion_id`,`jugador_id`),
  ADD KEY `jugador_id` (`jugador_id`),
  ADD KEY `detalles_jugador_ibfk_2` (`inscripcion_id`);

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
  ADD KEY `fk_equipo_jugadores_e` (`equipo_id`),
  ADD KEY `fk_status_equipo_jugadores` (`status_id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grupo_status` (`status_id`),
  ADD KEY `fk_grupo_torneo` (`torneo_id`);

--
-- Indices de la tabla `inscripciones_equipos`
--
ALTER TABLE `inscripciones_equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torneo_id` (`torneo_id`),
  ADD KEY `grupo_id` (`grupo_id`),
  ADD KEY `equipo_id` (`equipo_id`),
  ADD KEY `fk_inscripciones_estatus` (`status_id`);

--
-- Indices de la tabla `inscripcion_equipo_jugadores`
--
ALTER TABLE `inscripcion_equipo_jugadores`
  ADD PRIMARY KEY (`inscripcion_id`,`jugador_id`),
  ADD KEY `jugador_id` (`jugador_id`),
  ADD KEY `fk_status_inscripcion_jugador` (`status_id`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_juegos_equipo` (`equipo_id`),
  ADD KEY `fk_juegos_vs_equipo` (`vs_equipo_id`),
  ADD KEY `fk_juegos_torneo` (`torneo_id`),
  ADD KEY `fk_juegos_grupo` (`grupo_id`);

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
  ADD KEY `fk_usuarios_rol` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `equipo_jugadores`
--
ALTER TABLE `equipo_jugadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=582;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `inscripciones_equipos`
--
ALTER TABLE `inscripciones_equipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `auditoria_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalles_juego`
--
ALTER TABLE `detalles_juego`
  ADD CONSTRAINT `detalles_juego_ibfk_1` FOREIGN KEY (`juego_id`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `fk_detalle_equipo` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `fk_equipo` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vs_equipo` FOREIGN KEY (`vs_equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_jugador`
--
ALTER TABLE `detalles_jugador`
  ADD CONSTRAINT `detalles_jugador_ibfk_1` FOREIGN KEY (`juego_id`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `detalles_jugador_ibfk_2` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripciones_equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_jugador_ibfk_3` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`cedula`);

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
  ADD CONSTRAINT `fk_equipo_jugadores_j` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_status_equipo_jugadores` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupo_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_torneo` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripciones_equipos`
--
ALTER TABLE `inscripciones_equipos`
  ADD CONSTRAINT `fk_inscripciones_estatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_equipos_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_equipos_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_equipos_ibfk_3` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripcion_equipo_jugadores`
--
ALTER TABLE `inscripcion_equipo_jugadores`
  ADD CONSTRAINT `fk_status_inscripcion_jugador` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `inscripcion_equipo_jugadores_ibfk_1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripciones_equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripcion_equipo_jugadores_ibfk_2` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `fk_juegos_equipo` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `fk_juegos_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `fk_juegos_torneo` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`),
  ADD CONSTRAINT `fk_juegos_vs_equipo` FOREIGN KEY (`vs_equipo_id`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `juegos_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
