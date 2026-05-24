-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2026 a las 03:33:35
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
-- Base de datos: `gestionmycar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id_alquiler` int(11) NOT NULL,
  `fecha_desde` date NOT NULL,
  `cantidad_dias` int(11) NOT NULL,
  `fecha_hasta` date NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `clave_usuario` varchar(50) NOT NULL,
  `rol` enum('administrador','cliente') NOT NULL,
  `nombre_apellido` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_alta` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `tipo_vehiculo` enum('auto','moto','camioneta') NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `anio` int(11) NOT NULL,
  `numero_plazas` int(11) NOT NULL,
  `motor` varchar(15) NOT NULL,
  `kilometraje` float NOT NULL,
  `precio_alquiler_dia` float NOT NULL,
  `disponibilidad` enum('disponible','no_disponible') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `tipo_vehiculo`, `imagen`, `marca`, `modelo`, `anio`, `numero_plazas`, `motor`, `kilometraje`, `precio_alquiler_dia`, `disponibilidad`) VALUES
(1, 'auto', NULL, 'Toyota', 'Corolla', 2021, 5, '2.0', 45200, 35000, 'disponible'),
(2, 'auto', NULL, 'Volkswagen', 'Golf', 2019, 5, '1.4 TSI', 68300, 32000, 'disponible'),
(3, 'auto', NULL, 'Ford', 'Focus', 2018, 5, '2.0', 89750, 28000, 'no_disponible'),
(4, 'auto', NULL, 'Chevrolet', 'Cruze', 2022, 5, '1.4 Turbo', 23100, 40000, 'disponible'),
(5, 'moto', NULL, 'Honda', 'CB 250 Twister', 2021, 2, '250cc', 15400, 12000, 'disponible'),
(6, 'moto', NULL, 'Yamaha', 'FZ 3.0', 2020, 2, '150cc', 28700, 10000, 'disponible'),
(7, 'moto', NULL, 'Bajaj', 'Rouser NS 200', 2019, 2, '200cc', 41200, 9500, 'no_disponible'),
(8, 'moto', NULL, 'Kawasaki', 'Z400', 2023, 2, '400cc', 6200, 18000, 'disponible'),
(9, 'camioneta', NULL, 'Toyota', 'Hilux', 2022, 5, '2.8 TD', 38400, 55000, 'disponible'),
(10, 'camioneta', NULL, 'Ford', 'Ranger', 2021, 5, '3.2 TD', 51700, 52000, 'no_disponible');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`),
  ADD KEY `fk_alquiler_vehiculo` (`id_vehiculo`),
  ADD KEY `fk_alquiler_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD CONSTRAINT `fk_alquiler_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alquiler_vehiculo` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
