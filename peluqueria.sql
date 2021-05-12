-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-05-2021 a las 22:56:45
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peluqueria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `motivos` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `tiempo` time NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `motivos`, `fecha`, `tiempo`, `id_usuario`) VALUES
(34, '123.', '2021-05-12 08:00:00', '00:45:00', 20),
(35, '123.', '2021-05-13 08:00:00', '00:45:00', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `dia` varchar(10) NOT NULL,
  `aperturaMañana` time DEFAULT NULL,
  `cierreMañana` time DEFAULT NULL,
  `aperturaTarde` time DEFAULT NULL,
  `cierreTarde` time DEFAULT NULL,
  `cerrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`dia`, `aperturaMañana`, `cierreMañana`, `aperturaTarde`, `cierreTarde`, `cerrado`) VALUES
('Domingo', '10:00:00', '13:30:00', '16:00:00', '21:00:00', 1),
('Jueves', '08:00:00', '08:00:00', '08:00:00', '08:00:00', 0),
('Lunes', '08:00:00', '08:00:00', '08:00:00', '08:00:00', 1),
('Martes', '08:00:00', '08:00:00', '08:00:00', '08:00:00', 0),
('Miércoles', '08:00:00', '08:00:00', '08:00:00', '08:00:00', 0),
('Sábado', '08:00:00', '08:00:00', '08:00:00', '08:00:00', 0),
('Viernes', '10:00:00', '13:00:00', '16:00:00', '20:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tiempo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `tiempo`) VALUES
(75, '123', '00:45:00'),
(76, '234', '00:15:00'),
(77, 'manuek', '00:15:00'),
(78, 'ert', '01:30:00'),
(79, 'tyr', '03:30:00'),
(80, '567', '02:30:00'),
(81, '5674', '02:30:00'),
(82, '2344', '02:00:00'),
(83, '234234234', '02:30:00'),
(84, '2342', '02:15:00'),
(85, '2432342', '03:00:00'),
(86, '2342523', '02:45:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `nick`, `contraseña`, `email`, `telefono`, `nombre`, `apellidos`, `edad`) VALUES
(20, 'Administrador', '123', 'lqCW', 'antoniojose.serna@gmail.com', '622920876', 'Antonio José', 'Serna Cantó', 123),
(41, 'Cliente', '456', 'maOZ', 'antonio.jose.serna@gmail.com', '622920876', 'Antonio José', 'Serna Can', 456);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`dia`),
  ADD UNIQUE KEY `dia` (`dia`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
