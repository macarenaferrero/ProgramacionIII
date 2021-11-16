-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generaciÃ³n: 08-11-2021 a las 17:24:05
-- VersiÃ³n del servidor: 10.4.20-MariaDB
-- VersiÃ³n de PHP: 8.0.9

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
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `idMesa` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT 0,
  `nombre_cliente` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `estado` enum('vacia','con cliente esperando pedido','con cliente comiendo','con cliente pagando','cerrada') COLLATE utf8_unicode_ci NOT NULL,
  `valoracionMesa` int(2) NOT NULL DEFAULT 0,
  `valoracionRestaurant` int(2) NOT NULL DEFAULT 0,
  `valoracionMozo` int(2) NOT NULL DEFAULT 0,
  `valoracionCocinero` int(2) NOT NULL DEFAULT 0,
  `valoracionDescripcion` varchar(66) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `facturacionAcumulada` float DEFAULT 0,
  `horaIngreso` timestamp NULL DEFAULT NULL,
  `horaEgreso` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`idMesa`, `idUsuario`, `nombre_cliente`, `estado`, `valoracionMesa`, `valoracionRestaurant`, `valoracionMozo`, `valoracionCocinero`, `valoracionDescripcion`, `facturacionAcumulada`, `horaIngreso`, `horaEgreso`) VALUES
(4, 0, '0', 'vacia', 0, 0, 0, 0, '0', 0, NULL, NULL),
(5, 0, '0', 'vacia', 0, 0, 0, 0, '0', 0, NULL, NULL),
(6, 0, '0', 'vacia', 0, 0, 0, 0, '0', 0, NULL, NULL),
(7, 4, '0', 'vacia', 0, 0, 0, 0, '0', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `fechaIngreso` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','en preparacion','listo para servir','servido') COLLATE utf8_unicode_ci NOT NULL,
  `nombre_cliente` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `productosBebida` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `productosComida` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `precio` float NOT NULL,
  `fotoMesa` longblob DEFAULT NULL,
  `demoraPedido` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `idSector` enum('barraTragos','barraChopera','cocina','candyBar') COLLATE utf8_unicode_ci NOT NULL,
  `precio` float NOT NULL,
  `demoraProducto` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `descripcion`, `idSector`, `precio`, `demoraProducto`) VALUES
(1, 'Coca-Cola', 'barraTragos', 280, '00:05:00'),
(2, 'Sprite', 'barraTragos', 260, '00:05:00'),
(3, 'Fanta', 'barraTragos', 260, '00:05:00'),
(4, 'Agua', 'barraTragos', 100, '00:05:00'),
(5, 'GinTonic', 'barraTragos', 200, '00:15:00'),
(6, 'Cerveza', 'barraChopera', 450, '00:10:00'),
(7, 'Fernet', 'barraTragos', 230, '00:15:00'),
(8, 'Vodka', 'barraTragos', 280, '00:15:00'),
(9, 'Vino', 'barraTragos', 680, '00:08:00'),
(10, 'Sorrentinos', 'cocina', 580, '00:30:00'),
(11, 'Ravioles', 'cocina', 450, '00:25:00'),
(12, 'Noquis', 'cocina', 370, '00:20:00'),
(13, 'Spaguetti', 'cocina', 350, '00:27:00'),
(14, 'Panzerotti', 'cocina', 380, '00:32:00'),
(15, 'Flan', 'candyBar', 180, '00:15:00'),
(16, 'Helado', 'candyBar', 256, '00:08:00'),
(17, 'CheeseCake', 'candyBar', 245, '00:18:00'),
(18, 'Chocotorta', 'candyBar', 150, '00:04:00'),
(20, 'Hamburguesa con papas', 'cocina', 550, '00:45:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `fechaIngreso` timestamp NOT NULL DEFAULT current_timestamp(),
  `fechaBaja` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `clave`, `fechaIngreso`, `fechaBaja`) VALUES
(1, 'SOCIO1', 'todoLoVeo', '2021-11-07 19:04:18', NULL),
(2, 'MOZO1', 'todoLoSirvo', '2021-11-07 19:04:18', NULL),
(3, 'COCINERO1', 'todoLoCocino', '2021-11-07 19:04:18', NULL),
(4, 'CERVECERO1', 'sirvoTuBirra', '2021-11-07 19:04:18', NULL),
(5, 'BARTENDER1', 'sirvoTuTrago', '2021-11-07 19:04:18', NULL),
(6, 'SOCIO2', 'todoLoVeo', '2021-11-07 19:04:18', NULL),
(7, 'MOZO2', 'todoLoSirvo', '2021-11-07 19:04:18', NULL),
(8, 'COCINERO2', 'todoLoCocino', '2021-11-07 19:04:18', NULL),
(9, 'CERVECERO2', 'sirvoTuBirra', '2021-11-07 19:04:18', NULL),
(10, 'BARTENDER2', 'sirvoTuTrago', '2021-11-07 19:04:18', NULL),
(11, 'SOCIO3', 'todoLoVeo', '2021-11-07 19:04:18', NULL),
(12, 'MOZO3', 'todoLoSirvo', '2021-11-07 19:04:18', NULL),
(13, 'COCINERO3', 'todoLoCocino', '2021-11-07 19:04:18', NULL),
(17, 'BARTENDER3', 'sirvoTuVaso', '2021-11-08 00:29:07', NULL),
(19, 'CERVECERO3', 'sirvoTuBirra', '2021-11-08 02:40:16', NULL);

--
-- Ãndices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
