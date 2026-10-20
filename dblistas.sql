-- Creación de la tabla 'elementos'
CREATE TABLE `elementos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lista` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `medida` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_lista` (`id_lista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creación de la tabla 'listas'
CREATE TABLE `listas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `idu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creación de la tabla 'usuarios'
CREATE TABLE `usuarios` (
  `idu` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`idu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creación de las llaves foráneas después de crear todas las tablas
ALTER TABLE `elementos`
  ADD CONSTRAINT `elementos_ibfk_1` FOREIGN KEY (`id_lista`) REFERENCES `listas` (`id`) ON DELETE CASCADE;

ALTER TABLE `listas`
  ADD CONSTRAINT `listas_ibfk_1` FOREIGN KEY (`idu`) REFERENCES `usuarios` (`idu`) ON DELETE CASCADE;