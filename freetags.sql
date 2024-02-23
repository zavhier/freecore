-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-02-2024 a las 18:05:31
-- Versión del servidor: 10.5.24-MariaDB
-- Versión de PHP: 8.2.14

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
(18, 'XXX Nuevo Producto Notebook', 'XXXX Computadora personal', '2024-01-02 17:07:42', 'c://', NULL, NULL, 1, 1, 3, 1, NULL, '/asset/img/', 1),
(36, 'Guitarra gri', 'Guitarra criolla', '2024-02-16 18:07:46', '', NULL, NULL, 1, 77, 1, 1, NULL, NULL, 1),
(37, 'Guitarra Gps', 'Guitarra pedro', '2024-02-16 19:25:29', '', NULL, 'ABA-a1111', 2, 78, 2, 2, NULL, NULL, 1),
(39, 'Productos QR', 'Producto QR Freetags', '2024-02-17 01:05:27', 'd66eed33', 'www.freetags.com.ar/buscar/d66eed33', NULL, 1, 19, 1, 1, NULL, '/asset/img/', 1),
(40, 'Productos QR 2', 'Producto QR Freetags 2', '2024-02-17 01:12:16', 'b55370d4', 'www.freetags.com.ar/buscar/d66eed33', NULL, 1, 19, 1, 1, NULL, '/asset/img/', 3),
(41, 'Productos QR 3', 'Producto QR Freetags 3', '2024-02-17 01:13:08', 'b0529d0a', 'www.freetags.com.ar/buscar/b0529d0a', NULL, 1, NULL, 1, 1, NULL, '/asset/img/', 3),
(42, 'Guitarra de lolo', 'Guitarra de lolo', '2024-02-17 19:29:20', '', NULL, 'ADASAS', 2, 78, 2, 2, NULL, NULL, 1),
(43, 'Qr 1', 'Qr 1', '2024-02-20 23:32:20', 'aaaaaaa', 'www.freetags.com.ar/buscar/aaaaaaa', NULL, 17, NULL, 3, 1, NULL, NULL, 1),
(44, 'Qr 2', 'Qr 2', '2024-02-20 23:32:20', 'aaaaaab', 'www.freetags.com.ar/buscar/aaaaaab', NULL, 17, NULL, 3, 1, NULL, NULL, 1),
(45, 'Qr 3', 'Qr 7', '2024-02-20 23:32:20', 'aaaaaac', 'www.freetags.com.ar/buscar/aaaaaac', NULL, 17, NULL, 3, 1, NULL, NULL, 1),
(46, 'Qr 3', 'Qr 6', '2024-02-20 23:32:20', 'aaaaaad', 'www.freetags.com.ar/buscar/aaaaaad', NULL, 17, NULL, 3, 1, NULL, NULL, 1),
(47, 'Qr 3', 'Qr 5', '2024-02-20 23:32:20', 'aaaaaae', 'www.freetags.com.ar/buscar/aaaaaae', NULL, 17, NULL, 3, 1, NULL, NULL, 1),
(48, 'Qr 4', 'Qr 4', '2024-02-20 23:32:20', 'aaaaaaf', 'www.freetags.com.ar/buscar/aaaaaaf', NULL, 17, 88, 3, 1, NULL, NULL, 1),
(53, 'ProductoQR', 'Carga_App_Externa', '2024-02-22 22:09:50', '9rIH4W1h', 'https://freetags.mysite.com.ar/buscar/9rIH4W1h', '9rIH4W1h', 12, NULL, 1, 1, NULL, 'codes/22-02-2024-07-09-48/', 1),
(54, 'ProductoQR', 'Carga_App_Externa', '2024-02-22 23:58:40', 'okGeuzmE', 'https://freetags.mysite.com.ar/buscar/okGeuzmE', 'okGeuzmE', 2, NULL, 1, 1, NULL, 'codes/22-02-2024-08-57-34/', 1),
(55, 'ProductoQR', 'Carga_App_Externa', '2024-02-23 20:03:42', 'QmScyLwH', 'https://freetags.com.ar/buscar/QmScyLwH', 'QmScyLwH', 12, NULL, 1, 1, NULL, 'codes/23-02-2024-05-03-22/', 1);

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
(12, 'El palmar S.A', 'San Luis', '555-98765', 'user', '2023-12-15 15:23:41', NULL),
(14, 'Pepga pig', 'San Luis', '555-98765', 'user', '2024-02-20 15:23:29', NULL),
(17, 'Mapfre', 'Bogota 335', '4587-5785', 'mapfre@gmail.com', '2024-02-22 22:24:19', NULL);

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
(1, 'Producto de FreeTags'),
(2, 'Producto de SafeBags');

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
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_alta`, `estado`, `genero`, `telcel`, `telref`, `urlimg`, `idempresa`) VALUES
(1, 'adminó', 'admin', '$2a$12$IYNu9hUzAMzBr/aq0gzyKOOCYawyNGQPYr9zaFdkKsRoX1M8cLBM.', 'manager', '2024-02-20 13:38:15', 1, NULL, '', '', '', 0),
(6, 'demo1', 'demo1@gmail.com', '$2y$12$Nizv66PxLbVsVbeY.bBzh.qVB2uQZsgz2FA4WbkcYf6BqrgcqvWPK', 'user', '2024-01-08 18:36:39', 1, 'F', '555-123451', '123-965874', '', 1),
(19, 'Leandro', 'alvarez.leandro.a@gmail.com', '$2y$12$.4liJ9ycYcPJgIzlR.S5DO10IQkkrgOY1l741q.i9a.r0lDgHwSg6', 'user', '2024-02-15 02:42:15', 1, 'M', '555-123456', '123-965874', '', 1),
(45, 'Javier', 'bicho@gmail.com', '$2y$12$mrt1wEYFa2FWb9QeY1h4LeGoU2vsGTAM/mKOeZnFZ0DNDYjT/qX/q', 'user', '2024-02-12 21:47:42', 1, 'M', '1234555555', '01137718645', '-', 1),
(63, 'Leandro', 'leoal2006@gmail.com', '$2y$12$CC62yB5zXh0yXBQZMYckg.i1EcRiAbArc9pLvXEdpXmJxmXLfseVa', 'user', '2024-02-15 18:09:33', 1, 'M', '1554109999', '1554109999', '-', 1),
(65, 'zavhier', 'zahier_@gmail.com', '$2y$12$zlD6fim4kQEW5sMYpbOyhugv6KC6Erp3habFFPefiaHAveZO0S6na', 'user', '2024-02-15 18:41:53', 1, 'M', '121212', '12121212', '-', 2),
(66, 'zavhier', 'za@gmail.com', '$2y$12$Sv6yeddlxTsVTZriXcfiDepURj8fPRMAvMXglEmbg9Wd0M.cE.CWG', 'user', '2024-02-15 18:44:03', 1, 'M', '121212', '12312', '-', 2),
(67, 'akvier', 'wewe@gmail.com', '$2y$12$r6zvRSYHzgxTs0WfozJPF.qkfC9d7albObnwFQEDqwWayRCVkEzL.', 'user', '2024-02-15 18:44:57', 1, 'M', '12121212', '121212', '-', 2),
(69, 'asasasa', 'aa@gmail.com', '$2y$12$y0Bg67L2Ce9z36bKf31/yeUfttcvdhEX7eDHJ9HsC2CpGu21YRMnm', 'user', '2024-02-15 18:46:42', 1, 'M', '12342323', '1234', '-', 2),
(71, 'javier', 'dss@gmail.com', '$2y$12$3HnyoekVcX1OsbxSOGZYC.3lQHfswGu8Z7HTx1p40lEHC7Ca5K8c.', 'user', '2024-02-15 18:57:24', 1, 'M', '12121212', '112121212', '-', 2),
(77, 'Javier', 'zavhier@gmail.com', '$2y$12$QnK7rWfPNE6IoZC3ygrLUeW7aM1lQZU3cZC0WVZfC/g8HazmZMFpe', 'user', '2024-02-16 18:06:12', 1, 'M', '1137718645', '1137718645', '-', 1),
(78, 'Perdo Raúl', 'pedro@gmail.com', '$2y$12$EBhujIKviDikuGuedB4TjetHMTK.3vOtL6RuYXHHg4krFSpcGO.dO', 'user', '2024-02-16 19:24:50', 1, 'M', '121222111', '123211212', '-', 2),
(83, 'Mapfre', 'mapfre@gmail.com', '$2y$12$dwc2bUgvD9Al/sAoQGKUvOSKzkFdbDIpoUhu9xqAhV9nHUnfLWzDa', 'rz', '2024-02-20 17:43:18', 1, 'M', '1137718645', '1137718645', '-', 1),
(88, 'elchombo', 'chomb@gmail.com', '$2y$12$9sbgcCoTTzOBby59mu20sO/zrgzH7fDqTXMTDHN2.y6oNI1T3dQCy', 'user', '2024-02-22 18:45:00', 1, 'M', '1337718645', '1337718645', '-', 1);

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
(10, 1, 4),
(13, 1, 14),
(16, 83, 17);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `razon_social`
--
ALTER TABLE `razon_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `usuarios_razon_social`
--
ALTER TABLE `usuarios_razon_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
