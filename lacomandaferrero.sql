-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2021 a las 19:59:19
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lacomandaferrero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `idEncuesta` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `valoracionMesa` int(2) NOT NULL,
  `valoracionRestaurant` int(2) NOT NULL,
  `valoracionMozo` int(2) NOT NULL,
  `valoracionCocinero` int(2) NOT NULL,
  `comentarios` text NOT NULL,
  `promedioValoracion` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`idEncuesta`, `idPedido`, `valoracionMesa`, `valoracionRestaurant`, `valoracionMozo`, `valoracionCocinero`, `comentarios`, `promedioValoracion`) VALUES
(2, 8, 7, 6, 5, 7, 'llego la comida fria', 6.25),
(3, 12, 8, 8, 8, 8, 'Muy limpio todo', 8),
(4, 16, 9, 8, 9, 7, 'Lindo lugar familiar', 8.25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `idMesa` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT 0,
  `estado` enum('vacia','con cliente esperando pedido','con cliente comiendo','con cliente pagando','cerrada') COLLATE utf8_unicode_ci NOT NULL,
  `horaEgreso` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`idMesa`, `idUsuario`, `estado`, `horaEgreso`) VALUES
(4, 2, 'con cliente esperando pedido', '2021-11-15 06:55:44'),
(5, 2, 'cerrada', NULL),
(6, 3, 'cerrada', NULL),
(7, 3, 'cerrada', NULL),
(8, 2, 'cerrada', '2021-11-29 21:08:58'),
(9, 47, 'cerrada', '2021-11-29 21:08:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `fechaIngreso` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','en preparacion','listo para servir','servido','pagado') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pendiente',
  `nombre_cliente` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `precio` float NOT NULL,
  `fotoMesa` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `demoraPedido` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `fechaIngreso`, `estado`, `nombre_cliente`, `idMesa`, `idUsuario`, `precio`, `fotoMesa`, `demoraPedido`) VALUES
(8, '2021-11-28 00:13:25', 'en preparacion', 'Juan', 5, 2, 840, 'FotosPedidos/Juan-5-2.jpg', '00:30:00'),
(12, '2021-11-28 02:02:33', 'pagado', 'Cristian', 8, 2, 1170, 'FotosPedidos/Cristian-8-2.jpg', '00:25:00'),
(13, '2021-11-29 15:12:04', 'pendiente', 'Marce', 8, 15, 0, 'FotosPedidos/Marce-8-15.', '00:00:00'),
(14, '2021-11-29 15:12:21', 'pendiente', 'Marce', 8, 15, 0, 'FotosPedidos/Marce-8-15.jpg', '00:00:00'),
(15, '2021-11-29 16:59:13', 'pendiente', 'Jose', 8, 21, 0, 'FotosPedidos/Jose-8-21.', '00:00:00'),
(16, '2021-11-29 16:59:47', 'pagado', 'Jose', 8, 21, 1170, 'FotosPedidos/Jose-8-21.jpg', '00:25:00'),
(17, '2021-11-29 18:42:55', 'pendiente', 'Julian', 9, 25, 0, 'FotosPedidos/Julian-mesa9-idUsuario25.jpg', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `idSector` enum('barraTragos','barraChopera','cocina','candyBar') COLLATE utf8_unicode_ci NOT NULL,
  `precio` float NOT NULL,
  `demoraProducto` time NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` enum('en preparacion','lista para servir','servido','pagado','pendiente') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `descripcion`, `idSector`, `precio`, `demoraProducto`, `orden`, `estado`) VALUES
(1, 'Coca-Cola', 'barraTragos', 280, '00:05:00', 4, 'pendiente'),
(2, 'Sprite', 'barraTragos', 260, '00:05:00', 8, 'en preparacion'),
(3, 'Fanta', 'barraTragos', 260, '00:05:00', 0, 'en preparacion'),
(4, 'Agua', 'barraTragos', 100, '00:05:00', 0, 'en preparacion'),
(5, 'GinTonic', 'barraTragos', 200, '00:15:00', 0, 'en preparacion'),
(6, 'Cerveza', 'barraChopera', 450, '00:10:00', 0, 'pendiente'),
(7, 'Fernet', 'barraTragos', 230, '00:15:00', 0, 'pendiente'),
(8, 'Vodka', 'barraTragos', 280, '00:15:00', 0, 'en preparacion'),
(9, 'Vino', 'barraTragos', 680, '00:08:00', 0, 'en preparacion'),
(10, 'Sorrentinos', 'cocina', 580, '00:30:00', 8, 'en preparacion'),
(11, 'Ravioles', 'cocina', 450, '00:25:00', 0, 'en preparacion'),
(12, 'Noquis', 'cocina', 370, '00:20:00', 4, 'en preparacion'),
(13, 'Spaguetti', 'cocina', 350, '00:27:00', 0, 'en preparacion'),
(14, 'Panzerotti', 'cocina', 380, '00:32:00', 0, 'pendiente'),
(15, 'Flan', 'candyBar', 180, '00:15:00', 0, 'pendiente'),
(16, 'Helado', 'candyBar', 256, '00:08:00', 0, 'en preparacion'),
(17, 'CheeseCake', 'candyBar', 245, '00:18:00', 0, 'en preparacion'),
(18, 'Chocotorta', 'candyBar', 150, '00:04:00', 0, 'en preparacion'),
(20, 'Hamburguesa con papas', 'cocina', 550, '00:45:00', 0, 'en preparacion'),
(26, 'Daikiry', 'barraTragos', 250, '00:10:00', 12, 'pagado'),
(27, 'Corona', 'barraChopera', 300, '00:05:00', 12, 'pagado'),
(28, 'hamburguesa de garbanzo', 'cocina', 140, '00:15:00', 12, 'pagado'),
(29, 'Una milanesa a caballo', 'cocina', 340, '00:25:00', 12, 'pagado'),
(30, 'hamburguesa de garbanzo', 'cocina', 140, '00:15:00', 12, 'pagado'),
(31, 'Una milanesa a caballo', 'cocina', 340, '00:25:00', 16, 'pagado'),
(32, 'hamburguesa de garbanzo', 'cocina', 140, '00:15:00', 12, 'en preparacion'),
(33, 'hamburguesa de garbanzo', 'cocina', 140, '00:15:00', 12, 'lista para servir'),
(34, 'hamburguesa de garbanzo', 'cocina', 140, '00:15:00', 16, 'pagado'),
(35, 'hamburguesa de garbanzo', 'cocina', 140, '00:15:00', 16, 'pagado'),
(36, 'Corona', 'barraChopera', 300, '00:05:00', 16, 'pagado'),
(37, 'Daikiry', 'barraTragos', 250, '00:10:00', 16, 'pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` text COLLATE utf8_unicode_ci NOT NULL,
  `tipoUsuario` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `fechaIngreso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fechaBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `tipoUsuario`, `clave`, `fechaIngreso`, `fechaBaja`) VALUES
(20, 'mferrero', 'MOZO', '$2y$10$TF2ChbMpDm9TGTGUXnNdq.JsbAohrLYOz080j/o7Ac4DE5uvoK66G', '2021-11-29 15:58:31', NULL),
(21, 'lpose', 'MOZO', '$2y$10$5h9RdAsXFwJSKT8sVyUBZeXZSOJcqf9CUmNZ3aYoB0OBur7StPncS', '2021-11-29 15:58:43', NULL),
(22, 'aposse', 'BARTENDER', '$2y$10$f.sqh3Ka3PqKILEkEhJI3OaOmKscAY.nvlHRf6QK4rqlakIqD04B6', '2021-11-29 16:56:53', '2021-11-29'),
(23, 'lferrero', 'CERVECERO', '$2y$10$SOngkrw7eR5nwtwLDM0dEunhR2RpUYK2Nrtwg1m.eQayLtw67V2Du', '2021-11-29 15:58:59', NULL),
(41, 'rferrero', 'SOCIO', '$2y$10$K35LtDfCId/tUK5NSTqFL.U3T.9GiF8oQzTij1jBCFUM3oMZd.VlK', '2021-11-29 16:31:35', NULL),
(42, 'sdutra', 'MOZO', '$2y$10$cXo0ExGCcE4Uck0bdj7l.efTosxUsitGiA71BqfoNaCExQ1hIHXB6', '2021-11-29 15:59:47', NULL),
(43, 'mborda', 'COCINERO', '$2y$10$MzxSr.vvbZXmp9y6K/wPYOCQhzYEB7LgAfdQkeE2XJBYh2lQBFh0S', '2021-11-29 15:59:56', NULL),
(44, 'cchavez', 'CERVECERO', '$2y$10$56oZLo8LCQ9XpUd2MM032OdfSL4V/PcHfWrNpnKf9ZyKlRyGqFGwC', '2021-11-29 16:00:04', NULL),
(47, 'dmoreno', 'MOZO', '$2y$10$Ium1Ar0R/KqAL.CV0BN/FeocPKpoRN8WXQcEPF5Ly9KHS1sLzh7ca', '2021-11-29 16:00:20', NULL),
(48, 'eluquez', 'COCINERO', '$2y$10$Ch8D.oKmn9Qn/CTjjoGhFOz1f5u.1T8Ax/TzoQWj0NhMq/QC8hY3K', '2021-11-29 16:00:28', NULL),
(49, 'ssbaglia', 'CERVECERO', '$2y$10$j2JEFkrR0tLVk.4NvBRPb.KlBnYCgnXqgJlXZi4YJ0PhZ6pFC7ySy', '2021-11-29 16:00:37', NULL),
(50, 'econte', 'BARTENDER', '$2y$10$s9/tq/pzf81F8uWvdbGkNONWRTt.Z2rjdPurzgYtl/pJ6YS8bJ63m', '2021-11-29 16:01:26', NULL),
(51, 'cmartinez', 'COCINERO', '$2y$10$wDP/1iQIt/q4SduLds3wrOHUOIQ7gVWWd43cxscTjxxTkGQDTuoPa', '2021-11-29 16:01:47', NULL),
(52, 'jperez', 'BARTENDER', '$2y$10$3lsuDTh.83W.iywi2tVmUeghN3F19FOoxrwh5czqXcWvMmAL7/L8q', '2021-11-29 16:01:56', NULL),
(53, 'lpaz', 'CERVECERO', '$2y$10$C86OHMtEbYxfEZKv1O1W7O78uCE/8Mf1oUEo/TH/EFQjoyiT90Lxi', '2021-11-29 16:02:06', NULL),
(54, 'lrodriguez', 'MOZO', '$2y$10$py2pznzDuEsFmSvsV6rQsOsvIXIwR309P/ssN2CLAYy2jz9CYuUAC', '2021-11-29 16:02:15', NULL),
(55, 'ffalcon', 'MOZO', '$2y$10$5R9oKm.c40SlsTyPb390k.vuoqTnRLXEMeSsclI0g43e2X5UcsEZO', '2021-11-29 16:02:37', NULL),
(56, 'rsuarez', 'BARTENDER', '$2y$10$FciXcZ/1.9iQbpKLrbkNxOjIjLPJgy/TtE26h9R.TXA4VSCNAXi22', '2021-11-29 16:02:47', NULL),
(57, 'ydominguez', 'CERVECERO', '$2y$10$MAEcgEJG.2aXFmsCu9Ku8.2XmhAW4zlj.k5Nh5SGbRpE7LHnxbjUe', '2021-11-29 16:02:59', NULL),
(58, 'rpeña', 'SOCIO', '$2y$10$xdxWrQ0AWroqWPdWtYw0Fu/.2jL66XUllg7xJWCrpqckRtVXt68uy', '2021-11-29 20:54:22', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`idEncuesta`),
  ADD UNIQUE KEY `idPedido` (`idPedido`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `idEncuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `fk_Encuestas_Pedidos` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
