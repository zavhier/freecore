-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-01-2024 a las 11:34:49
-- Versión del servidor: 10.5.23-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `freetags`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `descripcion`) VALUES
(1, 'FreeTags'),
(2, 'SafeTags');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `url_qr` varchar(255) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `razon_social_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo_estado_id` int(11) DEFAULT NULL,
  `tipo_producto_id` int(11) DEFAULT NULL,
  `fecha_baja` timestamp NULL DEFAULT NULL,
  `urlimg` varchar(255) DEFAULT NULL,
  `condicion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `codigo_qr`, `url_qr`, `serial`, `razon_social_id`, `usuario_id`, `tipo_estado_id`, `tipo_producto_id`, `fecha_baja`, `urlimg`, `condicion`) VALUES
(1, 'ASUS A51', 'Celular', '2023-12-11 03:00:00', '', NULL, NULL, 1, 1, 1, 1, NULL, NULL, 1),
(2, 'Galaxy S22', 'Celular', '2023-12-13 03:00:00', 'A123456', NULL, NULL, 2, 1, 1, 1, NULL, NULL, 1),
(11, 'Galaxy S22 Demo', 'Tablet', '2023-12-15 03:00:00', 'B123456', NULL, NULL, 1, 1, 1, 1, NULL, NULL, 1),
(13, 'NUEVO NOTEBOOK I9', 'Computadora personal', '2023-12-15 03:00:00', 'c://', NULL, '11212121', 1, 17, 2, 2, NULL, '/asset/img/', 1),
(17, 'Guitarra', 'Computadora personal', '2024-01-02 17:01:26', '', NULL, NULL, NULL, 17, 1, 2, NULL, '/asset/img/', 1),
(18, 'XXX Nuevo Producto Notebook', 'XXXX Computadora personal', '2024-01-02 17:07:42', 'c://', NULL, NULL, 1, 1, 1, 1, NULL, '/asset/img/', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razon_social`
--

CREATE TABLE `razon_social` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `urlimg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `razon_social`
--

INSERT INTO `razon_social` (`id`, `nombre`, `direccion`, `telefono`, `correo`, `fecha_creacion`, `urlimg`) VALUES
(1, 'Servicios Centrales, S.L', 'Av. de Mayo 266 - Capital Federal', '555-123456', 'centrales@gmail.com', '2023-12-11 03:00:00', NULL),
(2, 'Telefónica Móviles España, S.A.U.', 'Av. 9 de Julio', '0800-23654', 'telefonica@gmail.com', '2023-12-13 03:00:00', NULL),
(4, 'Las cabañas del Nono XXX', 'Las Rejas Tigre', '555-98765', 'cabanias@gmail.com', '2023-12-12 02:42:15', NULL),
(12, 'El palmar S.A', 'San Luis', '555-98765', 'user', '2023-12-15 15:23:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estado`
--

CREATE TABLE `tipo_estado` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipo_estado`
--

INSERT INTO `tipo_estado` (`id`, `descripcion`) VALUES
(1, 'Extraviado'),
(2, 'Activo'),
(3, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id`, `descripcion`) VALUES
(1, 'FreeTags'),
(2, 'SafeBags');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(255) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) DEFAULT NULL,
  `genero` varchar(15) DEFAULT NULL,
  `telcel` varchar(30) NOT NULL,
  `telref` varchar(30) NOT NULL,
  `urlimg` varchar(150) NOT NULL,
  `idempresa` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_alta`, `estado`, `genero`, `telcel`, `telref`, `urlimg`, `idempresa`) VALUES
(1, 'adminó', 'admin', '$2a$12$IYNu9hUzAMzBr/aq0gzyKOOCYawyNGQPYr9zaFdkKsRoX1M8cLBM.', 'manager', '2023-12-12 02:42:15', 1, NULL, '', '', '', 0),
(6, 'demo1', 'demo1@gmail.com', '$2y$12$Nizv66PxLbVsVbeY.bBzh.qVB2uQZsgz2FA4WbkcYf6BqrgcqvWPK', 'user', '2024-01-02 16:05:13', 1, 'F', '555-123456', '123-965874', '', 1),
(17, 'zavhier', 'zavhier@gmail.com', '$2y$12$itBNHHmOfo662ccJiIF1XubcoID.DZvckqPOq3sBm2w4gIDB9MAwS', 'user', '2024-01-02 16:04:55', 1, 'M', '555-123456', '123-965874', '', 1),
(18, 'catalina', 'catalina@gmail.com', '$2y$12$vT9zLKJFN4eUtNvEyJ6zo.nEdY5Ucy8VyYceREgu45l7QwLzfb8h2', 'user', '2024-01-02 16:05:02', 1, 'M', '555-123456', '123-965874', '', 2),
(19, 'leo', 'leo@gmail.com', '$2y$12$w9wYP8dpsOB9DytaG6G1VOigpxKZr7cGm94CQUIfjpA5dBZUM5t5W', 'user', '2024-01-02 16:20:44', 1, 'M', '555-123456', '123-965874', '', 1),
(26, 'usuario de prueba', 'prueba@gmail.com', '$2y$12$JOVOapM6P54lixbC.rY0weyJ7GdBwzzV/Q.9AQexyyWV9aL1I7ooK', 'user', '2024-01-04 16:52:15', 1, 'F', '555-123456', '123-965874', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_razon_social`
--

CREATE TABLE `usuarios_razon_social` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `razon_social_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios_razon_social`
--

INSERT INTO `usuarios_razon_social` (`id`, `usuario_id`, `razon_social_id`) VALUES
(8, 1, 1),
(9, 1, 2),
(10, 1, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_razon_social` (`razon_social_id`),
  ADD KEY `fk_usuario_id` (`usuario_id`),
  ADD KEY `fk_tipo_estado_id` (`tipo_estado_id`),
  ADD KEY `fk_tipo_producto_id` (`tipo_producto_id`);

--
-- Indices de la tabla `razon_social`
--
ALTER TABLE `razon_social`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_estado`
--
ALTER TABLE `tipo_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_razon_social`
--
ALTER TABLE `usuarios_razon_social`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `razon_social_id` (`razon_social_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `razon_social`
--
ALTER TABLE `razon_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo_estado`
--
ALTER TABLE `tipo_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuarios_razon_social`
--
ALTER TABLE `usuarios_razon_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_razon_social` FOREIGN KEY (`razon_social_id`) REFERENCES `razon_social` (`id`),
  ADD CONSTRAINT `fk_tipo_estado_id` FOREIGN KEY (`tipo_estado_id`) REFERENCES `tipo_estado` (`id`),
  ADD CONSTRAINT `fk_tipo_producto_id` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tipo_producto` (`id`),
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios_razon_social`
--
ALTER TABLE `usuarios_razon_social`
  ADD CONSTRAINT `usuarios_razon_social_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuarios_razon_social_ibfk_2` FOREIGN KEY (`razon_social_id`) REFERENCES `razon_social` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
