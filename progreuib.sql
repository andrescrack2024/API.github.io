-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2025 a las 06:52:34
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
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `status` enum('unread','read','replied','spam') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_ids`
--

CREATE TABLE `control_ids` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Correo` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `Logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`ID`, `Nombre`, `Descripcion`, `Correo`, `Password`, `Fecha_Registro`, `Logo`) VALUES
(24, 'Tecnoloclik', NULL, 'sinergia@gmail.com', '$2y$10$U7PJmY2ppk6ROzijUTbdGOe7lmJKuVTgI4J8uS4NeRWem.Kd5klXO', '2025-05-13 23:30:06', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `ID` int(11) NOT NULL,
  `Titulo` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  `Requisitos` text DEFAULT NULL,
  `Area` varchar(100) NOT NULL,
  `Empresa_id` int(11) NOT NULL,
  `Ubicacion` varchar(100) DEFAULT NULL,
  `Tipo_Contrato` varchar(50) DEFAULT NULL,
  `Salario` varchar(50) DEFAULT NULL,
  `Modalidad` enum('Presencial','Remoto','Híbrido') DEFAULT 'Presencial',
  `Experiencia` varchar(50) DEFAULT NULL,
  `Fecha_Publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Fecha_Expiracion` timestamp NULL DEFAULT NULL,
  `Estado` enum('Activa','Inactiva','Cerrada') DEFAULT 'Activa',
  `Vacantes` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`ID`, `Titulo`, `Descripcion`, `Requisitos`, `Area`, `Empresa_id`, `Ubicacion`, `Tipo_Contrato`, `Salario`, `Modalidad`, `Experiencia`, `Fecha_Publicacion`, `Fecha_Expiracion`, `Estado`, `Vacantes`) VALUES
(0, 'Diseñador Grafico', 'Se requiere un diseñador web con 20 años de experiencia', '20 años de expriencia.\r\nTitulo de Ing Software', 'Tecnología', 24, 'Quibdo,Choco', 'Tiempo Completo', '$4.600.000', 'Presencial', '', '2025-05-14 21:22:01', '2025-06-13 21:22:01', 'Activa', 1),
(0, 'Diseñador Grafico', 'Se requiere un diseñador web con 20 años de experiencia', '20 años de expriencia.\r\nTitulo de Ing Software', 'Tecnología', 24, 'Quibdo,Choco', 'Tiempo Completo', '$4.600.000', 'Presencial', NULL, '2025-05-14 22:42:43', NULL, 'Activa', 1),
(0, 'Diseñador Grafico', 'Se requiere un diseñador web con 20 años de experiencia', '20 años de expriencia.\r\nTitulo de Ing Software', 'Tecnología', 24, 'Quibdo,Choco', 'Tiempo Completo', '$4.600.000', 'Presencial', NULL, '2025-05-15 01:30:33', NULL, 'Activa', 1);

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
(25, 'Andres', 'andres@gmail.com', '$2y$10$GsTpNhqgBqevlLwzIobFYOKSVAPJftQPLX0rMZGaOfPtUQiynH9Ie', '2025-05-15 00:07:31', 'Educación', 'Trabajador', 'Docente'),
(26, 'Daniel', 'daniel@hotmail.com', '$2y$10$KDmpJsCq1er/vLcSPabs3e0rEddOZA/rxHR2izJKihEZ/u1nv42fO', '2025-05-17 10:18:12', NULL, 'Administrador', NULL),
(27, 'Julián Palacios', 'juanpalacios@gmail.com', '$2y$10$Q5KjCjOoffLHrQ16i35SeOl30xIfg7b3QMMitdR/9Fc/czT3/pXru', '2025-05-17 14:23:09', 'Educación', 'Trabajador', 'Docente'),
(28, 'Duvan', 'Duvan@gmail.com', '$2y$10$TrhMlojmrst5C3OO7jfjc.NSSVKOVLxXcJTGfqmCiQUeGxYb5Uto6', '2025-05-17 14:35:21', 'Tecnología', 'Trabajador', 'Programador'),
(29, 'Nicolas', 'nicolas@gmail.com', '$2y$10$Wi2uNeZHWfLKPZ7ALLHgROb89Cxgp0/xc1tVo5RGQ5DzPhgXMRuSm', '2025-05-17 14:36:16', NULL, 'Administrador', 'Administrador'),
(30, 'ferney', 'ferney@hotmail.com', '$2y$10$NalLA6nhAbFpD9EhCoD7lunSlHCH0Sak7QqgHNz0MIHuZicQLmht.', '2025-05-19 22:32:35', NULL, 'Administrador', 'Administrador');

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
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `status` (`status`);

--
-- Indices de la tabla `control_ids`
--
ALTER TABLE `control_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`ID`);

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
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
