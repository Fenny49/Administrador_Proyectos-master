-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2025 a las 07:01:13
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
-- Base de datos: `pruebas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `prioridad` enum('Normal','Media','Alta') NOT NULL DEFAULT 'Normal',
  `status` enum('Activo','Pendiente','Atrasado') NOT NULL DEFAULT 'Pendiente',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `id_usuario_asignado` int(11) DEFAULT NULL,
  `anio` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `nombre`, `descripcion`, `prioridad`, `status`, `fecha_inicio`, `fecha_fin`, `id_usuario_asignado`, `anio`) VALUES
(10236, 'Creación módulo ventas', 'Implementación de módulo ventas en sistema', 'Normal', 'Activo', '2025-06-08', '2025-06-14', 2, '2025'),
(10237, 'Actualización Usuarios', 'Importación de usuarios nuevos', 'Normal', 'Pendiente', '2025-06-15', '2025-07-10', 1, '2025'),
(10238, 'Actualización de base de datos', 'Importación de base de datos central', 'Media', 'Pendiente', '2025-06-25', '2025-07-10', 1, '2025'),
(10239, 'Actualización ERP junio 2025', 'Actualización Módulo Ventas', 'Alta', 'Atrasado', '2025-06-01', '2025-07-15', 2, '2025'),
(10240, 'Testeo de funcionalidad', 'Testeo de funcionalidad de prototipo más reciente Version 1.0', 'Media', 'Pendiente', '2025-06-25', '2025-07-17', 2, '2025');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_usuario` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido_Paterno` varchar(100) NOT NULL,
  `Apellido_Materno` varchar(100) NOT NULL,
  `Codigo_User` int(6) NOT NULL,
  `Correo` varchar(120) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Rol` enum('capturista','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_usuario`, `Nombre`, `Apellido_Paterno`, `Apellido_Materno`, `Codigo_User`, `Correo`, `Password`, `Rol`) VALUES
(1, 'Ricardo', 'Chab', 'Pool', 1, 'admin@mail.com', '123456', 'administrador'),
(2, 'Lucas Gonzalez', 'Pech', 'Cob', 123456, 'lucas@mail.com', '12345678', 'capturista'),
(3, 'Juan Enrique', 'Perez', 'Vazquez', 453730, 'juan@mail.com', '12345678', 'capturista'),
(4, 'Alberto Luis', 'Pech', 'Chan', 785165, 'alberto@mail.com', '12345678', 'capturista'),
(5, 'Casemiro', 'Salazar', 'Hernandez', 144098, 'casemiro@mail.com', '12345678', 'capturista');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `id_usuario_asignado` (`id_usuario_asignado`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10241;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_usuario_asignado`) REFERENCES `usuario` (`Id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
