SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
  `disponibilidad` enum('disponible','no_disponible') NOT NULL DEFAULT 'disponible',
  `deleted_at` datetime DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL, 
  `rol` enum('administrador','cliente') NOT NULL,
  `apellido_usuario` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_alta` date NOT NULL DEFAULT (CURRENT_DATE),
  `deleted_at` datetime DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `alquileres` (
  `id_alquiler` int(11) NOT NULL,
  `fecha_desde` date NOT NULL,
  `cantidad_dias` int(11) NOT NULL,
  `fecha_hasta` date NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('reserva','alquiler','devuelto') NOT NULL DEFAULT 'reserva',
  `metodopago` varchar(50) NOT NULL DEFAULT 'efectivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`),
  ADD KEY `fk_alquiler_vehiculo` (`id_vehiculo`),
  ADD KEY `fk_alquiler_usuario` (`id_usuario`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`);

ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `alquileres`
  ADD CONSTRAINT `fk_alquiler_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alquiler_vehiculo` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `tipo_vehiculo`, `imagen`, `marca`, `modelo`, `anio`, `numero_plazas`, `motor`, `kilometraje`, `precio_alquiler_dia`, `disponibilidad`, `deleted_at`) VALUES
(1, 'auto', 'assets/img/toyotatrueno.png', 'Toyota', 'Sprinter Trueno AE86', 1986, 5, '1.6L 4A-GE', 15000, 45000, 'disponible', NULL),
(2, 'moto', 'assets/img/moto_honda.png', 'Honda', 'CB500X', 2021, 2, '500cc', 8500, 25000, 'disponible', NULL),
(3, 'camioneta', 'assets/img/camioneta_hilux.png', 'Toyota', 'Hilux', 2023, 5, '2.8L Diesel', 12000, 60000, 'disponible', NULL),
(4, 'auto', 'assets/img/ford_mustang.png', 'Ford', 'Mustang Fastback', 1969, 4, '4.9L V8', 85000, 75000, 'disponible', NULL),
(5, 'auto', 'assets/img/tesla_models.png', 'Tesla', 'Model S Plaid', 2023, 5, 'Eléctrico', 5000, 95000, 'disponible', NULL),
(6, 'moto', 'assets/img/harley_fatboy.png', 'Harley-Davidson', 'Fat Boy 114', 2022, 2, '1868cc', 3000, 35000, 'disponible', NULL),
(7, 'camioneta', 'assets/img/ford_raptor.png', 'Ford', 'F-150 Raptor', 2022, 5, '3.5L V6', 18000, 80000, 'disponible', NULL),
(8, 'moto', 'assets/img/ducati_panigale.png', 'Ducati', 'Panigale V4', 2023, 1, '1103cc', 1200, 50000, 'disponible', NULL);

COMMIT;