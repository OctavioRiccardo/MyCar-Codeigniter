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
  `estado` enum('reserva','alquiler','devuelto') NOT NULL DEFAULT 'reserva' 
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
  ADD CONSTRAINT `fk_alquiler_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alquiler_vehiculo` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;