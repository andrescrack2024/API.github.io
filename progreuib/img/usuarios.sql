-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 02:12:26
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `progreuib`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `Area` varchar(100) DEFAULT NULL,
  `Rol` enum('Trabajador','Empresa','Administrador','Vendedor') DEFAULT NULL,
  `Especialidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Correo`, `Contraseña`, `Fecha_Registro`, `Area`, `Rol`, `Especialidad`) VALUES
(22, 'Sharly', 'sharly151@gmail.com', '$2y$10$bus.29kddSaqJddIYCJ/eOfs.O84ikvz2duOdSTZPsbQfi1jtd7w.', '2025-05-10 07:10:20', NULL, 'Administrador', NULL),
(23, 'Admiron', 'admiron123@hotmail.com', '$2y$10$MlgKaoReUc7UlNaiP2kVjO1z9mSaP10aPiV5PSMfZpHGV7Q8k5/GC', '2025-05-10 07:17:23', 'Salud', 'Empresa', 'Médico'),
(24, 'Tecnoloclik', 'sinergia@gmail.com', '$2y$10$U7PJmY2ppk6ROzijUTbdGOe7lmJKuVTgI4J8uS4NeRWem.Kd5klXO', '2025-05-13 23:30:05', 'Salud', 'Empresa', 'Desarrollo Web'),
(25, 'Andres', 'andres@gmail.com', '$2y$10$GsTpNhqgBqevlLwzIobFYOKSVAPJftQPLX0rMZGaOfPtUQiynH9Ie', '2025-05-15 00:07:31', 'Educación', 'Trabajador', 'Docente');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `reestablecer_id` AFTER DELETE ON `usuarios` FOR EACH ROW BEGIN
    DECLARE nuevo_id INT;

    -- Buscar el ID más bajo disponible en la tabla de control
    SELECT MIN(id) INTO nuevo_id FROM control_ids WHERE id NOT IN (SELECT id FROM usuarios);
    
    -- Si encontramos un ID disponible, lo insertamos en la tabla de control
    IF nuevo_id IS NOT NULL THEN
        INSERT INTO control_ids (id) VALUES (nuevo_id);
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
