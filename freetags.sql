-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-02-2024 a las 00:03:52
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
(78, 'ProductoQR', 'Carga_App_Externa', '2024-02-23 21:45:15', 'oSvygiVt', 'https://freetags.mysite.com.ar/buscar/oSvygiVt', 'oSvygiVt', 17, 90, 1, 1, NULL, 'codes/23-02-2024-06-44-57/', 1),
(79, 'ProductoQR', 'Carga_App_Externa', '2024-02-24 00:17:52', 'OY1hyNFb', 'https://freetags.com.ar/buscar/OY1hyNFb', 'OY1hyNFb', 17, NULL, 1, 1, NULL, 'codes/Mapfre_23-02-2024-09-17-42/', 1),
(80, 'ProductoQR', 'Carga_App_Externa', '2024-02-24 01:46:24', 'WwZhWczP', 'https://freetags.com.ar/buscar/WwZhWczP', 'WwZhWczP', 17, NULL, 1, 1, NULL, 'codes/Mapfre_23-02-2024-10-46-16/', 1),
(81, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:22:24', 'g7wzuMjp', 'https://freetags.com.ar/buscar/g7wzuMjp', 'g7wzuMjp', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-22-22/', 1),
(82, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:22:24', 'CBFv8zho', 'https://freetags.com.ar/buscar/g7wzuMjp/CBFv8zho', 'CBFv8zho', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-22-22/', 1),
(83, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:22:24', 'O1RmDZ0r', 'https://freetags.com.ar/buscar/g7wzuMjp/CBFv8zho/O1RmDZ0r', 'O1RmDZ0r', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-22-22/', 1),
(84, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:22:24', 'ajXffFSx', 'https://freetags.com.ar/buscar/g7wzuMjp/CBFv8zho/O1RmDZ0r/ajXffFSx', 'ajXffFSx', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-22-22/', 1),
(85, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:34:47', 'lPxQpzE9', 'https://freetags.com.ar/buscar/lPxQpzE9', 'lPxQpzE9', 18, NULL, 1, 1, NULL, 'codes/Telecom_25-02-2024-08-34-45/', 1),
(86, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:34:53', 'gXtkIC7f', 'https://freetags.com.ar/buscar/gXtkIC7f', 'gXtkIC7f', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-34-52/', 1),
(112, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'wd3ThAXA', 'https://freetags.com.ar/buscar/wd3ThAXA', 'wd3ThAXA', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(113, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'dcrWCV0m', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m', 'dcrWCV0m', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(114, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', '2208KWqQ', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ', '2208KWqQ', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(115, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'mzoyKTaT', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT', 'mzoyKTaT', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(116, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'nRT8eqsM', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM', 'nRT8eqsM', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(117, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'ZFlbeqHO', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO', 'ZFlbeqHO', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(118, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'mfiDBCIG', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG', 'mfiDBCIG', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(119, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'Nml0TTxH', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH', 'Nml0TTxH', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(120, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', '2k9RGVq9', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9', '2k9RGVq9', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(121, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'NYjUOnjc', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9/NYjUOnjc', 'NYjUOnjc', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(122, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'LBLOi3SC', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9/NYjUOnjc/LBLOi3SC', 'LBLOi3SC', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(123, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'WLmIcVxm', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9/NYjUOnjc/LBLOi3SC/WLmIcVxm', 'WLmIcVxm', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(124, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'YhxIObP6', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9/NYjUOnjc/LBLOi3SC/WLmIcVxm/YhxIObP6', 'YhxIObP6', 17, NULL, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(125, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'dB315gct', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9/NYjUOnjc/LBLOi3SC/WLmIcVxm/YhxIObP6/dB315gct', 'dB315gct', 17, 91, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1),
(126, 'ProductoQR', 'Carga_App_Externa', '2024-02-25 23:36:14', 'BR5soNPb', 'https://freetags.com.ar/buscar/wd3ThAXA/dcrWCV0m/2208KWqQ/mzoyKTaT/nRT8eqsM/ZFlbeqHO/mfiDBCIG/Nml0TTxH/2k9RGVq9/NYjUOnjc/LBLOi3SC/WLmIcVxm/YhxIObP6/dB315gct/BR5soNPb', 'BR5soNPb', 17, 91, 1, 1, NULL, 'codes/Mapfre_25-02-2024-08-36-07/', 1);

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
  `urlimg` varchar(255) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `razon_social`
--

INSERT INTO `razon_social` (`id`, `nombre`, `direccion`, `telefono`, `correo`, `fecha_creacion`, `urlimg`, `color`) VALUES
(17, 'Mapfre', 'Bogota 335', '4587-5785', 'mapfre@gmail.com', '2024-02-22 22:24:19', NULL, ''),
(18, 'Telecom', 'Av. Rivadavia 2000', '011-1234578', 'teco@gmail.com.ar', '2024-02-23 21:23:54', NULL, ''),
(23, 'Code Hause S.A', 'Córdoba', '555-98765', 'user', '2023-12-12 02:42:15', NULL, 'null');

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
(1, 'Inactivo'),
(2, 'Activo'),
(3, 'Extraviado');

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
(83, 'Mapfre', 'zavhier@gmail.com', '$2y$12$dwc2bUgvD9Al/sAoQGKUvOSKzkFdbDIpoUhu9xqAhV9nHUnfLWzDa', 'rz', '2024-02-28 18:53:16', 1, 'M', '1137718645', '1137718645', '-', 1),
(89, 'Telecom', 'teco@gmail.com.ar', '$2y$12$OX8hBiXNbuNZ.Fnx95rrWurrux1SS72WCzXYj5Fq7gI8POLcLcb8e', 'user', '2024-02-23 21:23:53', 1, 'M', '011-1234578', '011-1234578', '-', 1),
(90, 'Leandro', 'leoal2006@gmail.com', '$2y$12$6JUhDQca5tuMlvkvJLQDf.3oLo.hFgkxwY2VG9y/To4R/wdlfZUqK', 'user', '2024-02-28 00:32:54', 1, 'M', '15547896', '1115548907', '-', 1),
(91, 'Javier', 'zavhier_@gmail.com', '$2y$12$0K4HR3IvbwiYAZazZELwB.ECoP1fxHWeK2lzAXcjFKDIXklQQaS7e', 'user', '2024-02-28 18:53:09', 1, 'M', '1137718645', '1137718645', '-', 1),
(103, 'Hector', 'hec@gmail.com', '$2y$12$Ns/b5Zzdv7OfLsVIwx5eF.Y2v50EAHWhpyNCc10BjbtbNKDYVdGxK', 'user', '2024-02-28 23:44:48', 1, 'M', '133718645', '133718645', '-', 2);

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
(16, 83, 17),
(17, 89, 18),
(22, 103, 23);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de la tabla `razon_social`
--
ALTER TABLE `razon_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `usuarios_razon_social`
--
ALTER TABLE `usuarios_razon_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
