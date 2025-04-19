-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-04-2025 a las 07:09:28
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
-- Base de datos: `tycoon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_jugador`
--

CREATE TABLE `datos_jugador` (
  `Id` int(11) NOT NULL,
  `Id_Usuario` int(11) DEFAULT NULL,
  `Id_Modulo` int(11) DEFAULT NULL,
  `ventas` int(11) DEFAULT NULL,
  `ganancia_venta` double DEFAULT NULL,
  `CiclosVenta` int(11) DEFAULT NULL,
  `GananciaTotal` double DEFAULT NULL,
  `NivelDesbloqueo` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `cantidad_ventas` int(11) DEFAULT NULL,
  `Precio` int(11) DEFAULT NULL,
  `Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `datos_jugador`
--

INSERT INTO `datos_jugador` (`Id`, `Id_Usuario`, `Id_Modulo`, `ventas`, `ganancia_venta`, `CiclosVenta`, `GananciaTotal`, `NivelDesbloqueo`, `estado`, `cantidad_ventas`, `Precio`, `Nivel`) VALUES
(46, 7, 1, 101, 10, 60, 0, 1, 1, 1, 200, 1),
(47, 7, 2, 48, 24, 120, 0, 1, 1, 1, 300, 1),
(48, 7, 3, 10, 40, 180, 0, 1, 1, 1, 500, 1),
(49, 7, 4, 0, 70, 240, 0, 3, 0, 0, 1500, 0),
(50, 7, 5, 0, 124, 300, 0, 4, 0, 0, 3000, 0),
(51, 7, 6, 0, 185, 360, 0, 5, 0, 0, 5000, 0),
(52, 7, 7, 0, 248, 420, 0, 6, 0, 0, 8000, 0),
(53, 7, 8, 0, 325, 480, 0, 7, 0, 0, 10500, 0),
(54, 7, 9, 0, 400, 540, 0, 8, 0, 0, 15000, 0),
(55, 7, 10, 0, 550, 600, 0, 9, 0, 0, 20000, 0),
(56, 7, 11, 0, 700, 660, 0, 10, 0, 0, 35000, 0),
(57, 7, 12, 0, 1000, 720, 0, 10, 0, 0, 50000, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mejoras`
--

CREATE TABLE `mejoras` (
  `Id_Mejora` int(11) NOT NULL,
  `Id_Modulo` int(11) NOT NULL,
  `Nombre` varchar(90) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Tipo` enum('velocidad','cantidad','ganancia') NOT NULL,
  `reduccion_tiempo` int(11) DEFAULT NULL,
  `cantidad_ventas` int(11) DEFAULT NULL,
  `precio_venta` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mejoras`
--

INSERT INTO `mejoras` (`Id_Mejora`, `Id_Modulo`, `Nombre`, `Descripcion`, `Precio`, `Tipo`, `reduccion_tiempo`, `cantidad_ventas`, `precio_venta`, `estado`) VALUES
(1, 1, 'Fábrica Automatizada', 'Reduce tiempo de venta en 15 segundos', 500.00, 'velocidad', 30, 0, 0, 0),
(2, 1, 'Equipo de Ventas', 'Aumenta ventas por lote en 5', 800.00, 'cantidad', 0, 5, 0, 0),
(3, 1, 'Material Premium', 'Aumenta la ganancia por venta en 20', 1200.00, 'ganancia', 0, 0, 20, 0),
(4, 1, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 10 segundos', 650.00, 'velocidad', 20, 0, 0, 0),
(5, 2, 'Fábrica Automatizada', 'Reduce tiempo de venta en 20 segundos', 1000.00, 'velocidad', 40, 0, 0, 0),
(6, 2, 'Equipo de Ventas', 'Aumenta ventas por lote en 6', 1300.00, 'cantidad', 0, 6, 0, 0),
(7, 2, 'Material Premium', 'Aumenta la ganancia por venta en 30', 1800.00, 'ganancia', 0, 0, 30, 0),
(8, 2, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 15 segundos', 1100.00, 'velocidad', 30, 0, 0, 0),
(9, 3, 'Fábrica Automatizada', 'Reduce tiempo de venta en 25 segundos', 1500.00, 'velocidad', 50, 0, 0, 0),
(10, 3, 'Equipo de Ventas', 'Aumenta ventas por lote en 7', 1800.00, 'cantidad', 0, 7, 0, 0),
(11, 3, 'Material Premium', 'Aumenta la ganancia por venta en 40', 2200.00, 'ganancia', 0, 0, 40, 0),
(12, 3, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 20 segundos', 1300.00, 'velocidad', 40, 0, 0, 0),
(13, 4, 'Fábrica Automatizada', 'Reduce tiempo de venta en 30 segundos', 2000.00, 'velocidad', 60, 0, 0, 0),
(14, 4, 'Equipo de Ventas', 'Aumenta ventas por lote en 8', 2500.00, 'cantidad', 0, 8, 0, 0),
(15, 4, 'Material Premium', 'Aumenta la ganancia por venta en 60', 3000.00, 'ganancia', 0, 0, 60, 0),
(16, 4, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 25 segundos', 1800.00, 'velocidad', 50, 0, 0, 0),
(17, 5, 'Fábrica Automatizada', 'Reduce tiempo de venta en 35 segundos', 2800.00, 'velocidad', 70, 0, 0, 0),
(18, 5, 'Equipo de Ventas', 'Aumenta ventas por lote en 9', 3200.00, 'cantidad', 0, 9, 0, 0),
(19, 5, 'Material Premium', 'Aumenta la ganancia por venta en 85', 3800.00, 'ganancia', 0, 0, 85, 0),
(20, 5, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 30 segundos', 2500.00, 'velocidad', 60, 0, 0, 0),
(21, 6, 'Fábrica Automatizada', 'Reduce tiempo de venta en 40 segundos', 3500.00, 'velocidad', 80, 0, 0, 0),
(22, 6, 'Equipo de Ventas', 'Aumenta ventas por lote en 10', 4000.00, 'cantidad', 0, 10, 0, 0),
(23, 6, 'Material Premium', 'Aumenta la ganancia por venta en 100', 4800.00, 'ganancia', 0, 0, 100, 0),
(24, 6, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 35 segundos', 3100.00, 'velocidad', 70, 0, 0, 0),
(25, 7, 'Fábrica Automatizada', 'Reduce tiempo de venta en 45 segundos', 4200.00, 'velocidad', 90, 0, 0, 0),
(26, 7, 'Equipo de Ventas', 'Aumenta ventas por lote en 11', 4800.00, 'cantidad', 0, 11, 0, 0),
(27, 7, 'Material Premium', 'Aumenta la ganancia por venta en 120', 5500.00, 'ganancia', 0, 0, 120, 0),
(28, 7, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 40 segundos', 3700.00, 'velocidad', 80, 0, 0, 0),
(29, 8, 'Fábrica Automatizada', 'Reduce tiempo de venta en 50 segundos', 5000.00, 'velocidad', 100, 0, 0, 0),
(30, 8, 'Equipo de Ventas', 'Aumenta ventas por lote en 12', 5800.00, 'cantidad', 0, 12, 0, 0),
(31, 8, 'Material Premium', 'Aumenta la ganancia por venta en 150', 6500.00, 'ganancia', 0, 0, 150, 0),
(32, 8, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 45 segundos', 4500.00, 'velocidad', 90, 0, 0, 0),
(33, 9, 'Fábrica Automatizada', 'Reduce tiempo de venta en 55 segundos', 5800.00, 'velocidad', 110, 0, 0, 0),
(34, 9, 'Equipo de Ventas', 'Aumenta ventas por lote en 13', 6600.00, 'cantidad', 0, 13, 0, 0),
(35, 9, 'Material Premium', 'Aumenta la ganancia por venta en 180', 7500.00, 'ganancia', 0, 0, 180, 0),
(36, 9, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 50 segundos', 5200.00, 'velocidad', 100, 0, 0, 0),
(37, 10, 'Fábrica Automatizada', 'Reduce tiempo de venta en 60 segundos', 6700.00, 'velocidad', 120, 0, 0, 0),
(38, 10, 'Equipo de Ventas', 'Aumenta ventas por lote en 14', 7500.00, 'cantidad', 0, 14, 0, 0),
(39, 10, 'Material Premium', 'Aumenta la ganancia por venta en 220', 8500.00, 'ganancia', 0, 0, 220, 0),
(40, 10, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 55 segundos', 6000.00, 'velocidad', 110, 0, 0, 0),
(41, 11, 'Fábrica Automatizada', 'Reduce tiempo de venta en 65 segundos', 7600.00, 'velocidad', 130, 0, 0, 0),
(42, 11, 'Equipo de Ventas', 'Aumenta ventas por lote en 15', 8500.00, 'cantidad', 0, 15, 0, 0),
(43, 11, 'Material Premium', 'Aumenta la ganancia por venta en 280', 9500.00, 'ganancia', 0, 0, 280, 0),
(44, 11, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 60 segundos', 6900.00, 'velocidad', 120, 0, 0, 0),
(45, 12, 'Fábrica Automatizada', 'Reduce tiempo de venta en 70 segundos', 8500.00, 'velocidad', 140, 0, 0, 0),
(46, 12, 'Equipo de Ventas', 'Aumenta ventas por lote en 16', 9500.00, 'cantidad', 0, 16, 0, 0),
(47, 12, 'Material Premium', 'Aumenta la ganancia por venta en 350', 11000.00, 'ganancia', 0, 0, 350, 0),
(48, 12, 'Maquinaria Mejorada', 'Reduce tiempo de venta en 65 segundos', 7800.00, 'velocidad', 130, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mejoras_usuarios`
--

CREATE TABLE `mejoras_usuarios` (
  `Id_MejoraUsuario` int(11) NOT NULL,
  `Id_Mejora` int(11) DEFAULT NULL,
  `estado` tinyint(11) DEFAULT NULL,
  `Id_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `Id_Modulo` int(11) NOT NULL,
  `Ventas` int(11) DEFAULT NULL,
  `Ganancia_Venta` double DEFAULT NULL,
  `CiclosVenta` int(11) DEFAULT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `GananciaTotal` double DEFAULT NULL,
  `NivelDesbloqueo` int(11) DEFAULT NULL,
  `Precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`Id_Modulo`, `Ventas`, `Ganancia_Venta`, `CiclosVenta`, `Nombre`, `GananciaTotal`, `NivelDesbloqueo`, `Precio`) VALUES
(1, 0, 10, 60, 'Modulo 1', 0, 1, 200),
(2, 0, 24, 120, 'Modulo 2', 0, 1, 300),
(3, 0, 40, 180, 'Modulo 3', 0, 1, 500),
(4, 0, 70, 240, 'Modulo 4', 0, 3, 1500),
(5, 0, 124, 300, 'Modulo 5', 0, 4, 3000),
(6, 0, 185, 360, 'Modulo 6', 0, 5, 5000),
(7, 0, 248, 420, 'Modulo 7', 0, 6, 8000),
(8, 0, 325, 480, 'Modulo 8', 0, 7, 10500),
(9, 0, 400, 540, 'Modulo 9', 0, 8, 15000),
(10, 0, 550, 600, 'Modulo 10', 0, 9, 20000),
(11, 0, 700, 660, 'Modulo 11', 0, 10, 35000),
(12, 0, 1000, 720, 'Modulo 12', 0, 10, 50000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL,
  `xp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id_nivel`, `xp`) VALUES
(1, 249),
(2, 499),
(3, 999),
(4, 1999),
(5, 2999),
(6, 3999),
(7, 4999),
(8, 5999),
(9, 6999),
(10, 7999);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos`
--

CREATE TABLE `objetivos` (
  `Id_objetivos` int(11) NOT NULL,
  `Id_Modulo` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `dinero` double DEFAULT NULL,
  `xp` int(11) DEFAULT NULL,
  `ventas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `objetivos`
--

INSERT INTO `objetivos` (`Id_objetivos`, `Id_Modulo`, `nombre`, `estado`, `descripcion`, `dinero`, `xp`, `ventas`) VALUES
(1, 1, 'Ventas Iniciales', 0, 'Realiza 5 ventas con el Módulo 1', 50, 50, 5),
(2, 1, 'Primer Empuje', 0, 'Realiza 10 ventas con el Módulo 1', 100, 75, 10),
(3, 1, 'Crecimiento', 0, 'Realiza 20 ventas con el Módulo 1', 150, 100, 20),
(4, 1, 'Expansión', 0, 'Realiza 30 ventas con el Módulo 1', 200, 125, 30),
(5, 1, 'Dominio', 0, 'Realiza 50 ventas con el Módulo 1', 300, 150, 50),
(6, 2, 'Ventas Iniciales', 0, 'Realiza 5 ventas con el Módulo 2', 75, 60, 5),
(7, 2, 'Primer Empuje', 0, 'Realiza 10 ventas con el Módulo 2', 150, 80, 10),
(8, 2, 'Crecimiento', 0, 'Realiza 25 ventas con el Módulo 2', 225, 105, 25),
(9, 2, 'Expansión', 0, 'Realiza 40 ventas con el Módulo 2', 300, 125, 40),
(10, 2, 'Dominio', 0, 'Realiza 60 ventas con el Módulo 2', 400, 150, 60),
(11, 3, 'Ventas Iniciales', 0, 'Realiza 10 ventas con el Módulo 3', 100, 60, 10),
(12, 3, 'Primer Empuje', 0, 'Realiza 20 ventas con el Módulo 3', 200, 85, 20),
(13, 3, 'Crecimiento', 0, 'Realiza 35 ventas con el Módulo 3', 300, 110, 35),
(14, 3, 'Expansión', 0, 'Realiza 50 ventas con el Módulo 3', 400, 130, 50),
(15, 3, 'Dominio', 0, 'Realiza 75 ventas con el Módulo 3', 500, 155, 75),
(16, 4, 'Ventas Iniciales', 0, 'Realiza 10 ventas con el Módulo 4', 125, 65, 10),
(17, 4, 'Primer Empuje', 0, 'Realiza 25 ventas con el Módulo 4', 250, 90, 25),
(18, 4, 'Crecimiento', 0, 'Realiza 40 ventas con el Módulo 4', 375, 115, 40),
(19, 4, 'Expansión', 0, 'Realiza 60 ventas con el Módulo 4', 500, 135, 60),
(20, 4, 'Dominio', 0, 'Realiza 90 ventas con el Módulo 4', 600, 160, 90),
(21, 5, 'Ventas Iniciales', 0, 'Realiza 15 ventas con el Módulo 5', 150, 70, 15),
(22, 5, 'Primer Empuje', 0, 'Realiza 30 ventas con el Módulo 5', 300, 95, 30),
(23, 5, 'Crecimiento', 0, 'Realiza 50 ventas con el Módulo 5', 450, 120, 50),
(24, 5, 'Expansión', 0, 'Realiza 75 ventas con el Módulo 5', 600, 140, 75),
(25, 5, 'Dominio', 0, 'Realiza 100 ventas con el Módulo 5', 750, 165, 100),
(26, 6, 'Ventas Iniciales', 0, 'Realiza 20 ventas con el Módulo 6', 180, 70, 20),
(27, 6, 'Primer Empuje', 0, 'Realiza 40 ventas con el Módulo 6', 360, 95, 40),
(28, 6, 'Crecimiento', 0, 'Realiza 65 ventas con el Módulo 6', 540, 120, 65),
(29, 6, 'Expansión', 0, 'Realiza 90 ventas con el Módulo 6', 720, 140, 90),
(30, 6, 'Dominio', 0, 'Realiza 120 ventas con el Módulo 6', 900, 165, 120),
(31, 7, 'Ventas Iniciales', 0, 'Realiza 25 ventas con el Módulo 7', 200, 70, 25),
(32, 7, 'Primer Empuje', 0, 'Realiza 50 ventas con el Módulo 7', 400, 95, 50),
(33, 7, 'Crecimiento', 0, 'Realiza 75 ventas con el Módulo 7', 600, 120, 75),
(34, 7, 'Expansión', 0, 'Realiza 100 ventas con el Módulo 7', 800, 140, 100),
(35, 7, 'Dominio', 0, 'Realiza 130 ventas con el Módulo 7', 1000, 165, 130),
(36, 8, 'Ventas Iniciales', 0, 'Realiza 30 ventas con el Módulo 8', 250, 75, 30),
(37, 8, 'Primer Empuje', 0, 'Realiza 60 ventas con el Módulo 8', 500, 100, 60),
(38, 8, 'Crecimiento', 0, 'Realiza 90 ventas con el Módulo 8', 750, 125, 90),
(39, 8, 'Expansión', 0, 'Realiza 120 ventas con el Módulo 8', 1000, 150, 120),
(40, 8, 'Dominio', 0, 'Realiza 150 ventas con el Módulo 8', 1200, 175, 150),
(41, 9, 'Ventas Iniciales', 0, 'Realiza 35 ventas con el Módulo 9', 300, 75, 35),
(42, 9, 'Primer Empuje', 0, 'Realiza 70 ventas con el Módulo 9', 600, 100, 70),
(43, 9, 'Crecimiento', 0, 'Realiza 105 ventas con el Módulo 9', 900, 125, 105),
(44, 9, 'Expansión', 0, 'Realiza 140 ventas con el Módulo 9', 1200, 150, 140),
(45, 9, 'Dominio', 0, 'Realiza 180 ventas con el Módulo 9', 1500, 175, 180),
(46, 10, 'Ventas Iniciales', 0, 'Realiza 40 ventas con el Módulo 10', 350, 80, 40),
(47, 10, 'Primer Empuje', 0, 'Realiza 80 ventas con el Módulo 10', 700, 105, 80),
(48, 10, 'Crecimiento', 0, 'Realiza 120 ventas con el Módulo 10', 1050, 130, 120),
(49, 10, 'Expansión', 0, 'Realiza 160 ventas con el Módulo 10', 1400, 150, 160),
(50, 10, 'Dominio', 0, 'Realiza 200 ventas con el Módulo 10', 1700, 170, 200),
(51, 11, 'Ventas Iniciales', 0, 'Realiza 45 ventas con el Módulo 11', 400, 80, 45),
(52, 11, 'Primer Empuje', 0, 'Realiza 90 ventas con el Módulo 11', 800, 105, 90),
(53, 11, 'Crecimiento', 0, 'Realiza 135 ventas con el Módulo 11', 1200, 130, 135),
(54, 11, 'Expansión', 0, 'Realiza 180 ventas con el Módulo 11', 1600, 150, 180),
(55, 11, 'Dominio', 0, 'Realiza 225 ventas con el Módulo 11', 2000, 170, 225),
(56, 12, 'Ventas Iniciales', 0, 'Realiza 50 ventas con el Módulo 12', 500, 85, 50),
(57, 12, 'Primer Empuje', 0, 'Realiza 100 ventas con el Módulo 12', 1000, 110, 100),
(58, 12, 'Crecimiento', 0, 'Realiza 150 ventas con el Módulo 12', 1500, 135, 150),
(59, 12, 'Expansión', 0, 'Realiza 200 ventas con el Módulo 12', 2000, 155, 200),
(60, 12, 'Dominio', 0, 'Realiza 250 ventas con el Módulo 12', 2500, 175, 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos_usuarios`
--

CREATE TABLE `objetivos_usuarios` (
  `Id_objetivos_usuarios` int(11) NOT NULL,
  `Id_Usuario` int(11) DEFAULT NULL,
  `Id_objetivos` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id_Usuario` int(11) NOT NULL,
  `Username` varchar(15) DEFAULT NULL,
  `Pass` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `Dinero` double DEFAULT 0,
  `xp` int(11) DEFAULT 0,
  `Id_Nivel` int(11) DEFAULT 1,
  `ciclos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_Usuario`, `Username`, `Pass`, `correo`, `Dinero`, `xp`, `Id_Nivel`, `ciclos`) VALUES
(7, 'MagikSystem22', '1234', 'magiksystem22@gmail.com', 1262, 0, 1, 6062);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datos_jugador`
--
ALTER TABLE `datos_jugador`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Usuario` (`Id_Usuario`),
  ADD KEY `Id_Modulo` (`Id_Modulo`);

--
-- Indices de la tabla `mejoras`
--
ALTER TABLE `mejoras`
  ADD PRIMARY KEY (`Id_Mejora`),
  ADD KEY `Id_Modulo` (`Id_Modulo`);

--
-- Indices de la tabla `mejoras_usuarios`
--
ALTER TABLE `mejoras_usuarios`
  ADD PRIMARY KEY (`Id_MejoraUsuario`),
  ADD KEY `Id_Mejora` (`Id_Mejora`),
  ADD KEY `Id_Usuario` (`Id_Usuario`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`Id_Modulo`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `objetivos`
--
ALTER TABLE `objetivos`
  ADD PRIMARY KEY (`Id_objetivos`),
  ADD KEY `Id_Modulo` (`Id_Modulo`);

--
-- Indices de la tabla `objetivos_usuarios`
--
ALTER TABLE `objetivos_usuarios`
  ADD PRIMARY KEY (`Id_objetivos_usuarios`),
  ADD KEY `Id_Usuario` (`Id_Usuario`),
  ADD KEY `Id_objetivos` (`Id_objetivos`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD KEY `Id_Nivel` (`Id_Nivel`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_jugador`
--
ALTER TABLE `datos_jugador`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `mejoras`
--
ALTER TABLE `mejoras`
  MODIFY `Id_Mejora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `mejoras_usuarios`
--
ALTER TABLE `mejoras_usuarios`
  MODIFY `Id_MejoraUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `Id_Modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `objetivos`
--
ALTER TABLE `objetivos`
  MODIFY `Id_objetivos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `objetivos_usuarios`
--
ALTER TABLE `objetivos_usuarios`
  MODIFY `Id_objetivos_usuarios` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos_jugador`
--
ALTER TABLE `datos_jugador`
  ADD CONSTRAINT `datos_jugador_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `datos_jugador_ibfk_2` FOREIGN KEY (`Id_Modulo`) REFERENCES `modulos` (`Id_Modulo`);

--
-- Filtros para la tabla `mejoras`
--
ALTER TABLE `mejoras`
  ADD CONSTRAINT `mejoras_ibfk_1` FOREIGN KEY (`Id_Modulo`) REFERENCES `modulos` (`Id_Modulo`);

--
-- Filtros para la tabla `mejoras_usuarios`
--
ALTER TABLE `mejoras_usuarios`
  ADD CONSTRAINT `mejoras_usuarios_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `modulos` (`Id_Modulo`),
  ADD CONSTRAINT `mejoras_usuarios_ibfk_2` FOREIGN KEY (`Id_Mejora`) REFERENCES `mejoras` (`Id_Mejora`),
  ADD CONSTRAINT `mejoras_usuarios_ibfk_3` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`);

--
-- Filtros para la tabla `objetivos`
--
ALTER TABLE `objetivos`
  ADD CONSTRAINT `objetivos_ibfk_1` FOREIGN KEY (`Id_Modulo`) REFERENCES `modulos` (`Id_Modulo`);

--
-- Filtros para la tabla `objetivos_usuarios`
--
ALTER TABLE `objetivos_usuarios`
  ADD CONSTRAINT `objetivos_usuarios_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `objetivos_usuarios_ibfk_2` FOREIGN KEY (`Id_objetivos`) REFERENCES `objetivos` (`Id_objetivos`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Id_Nivel`) REFERENCES `niveles` (`id_nivel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
