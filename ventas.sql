-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-05-2020 a las 16:51:10
-- Versión del servidor: 5.7.23
-- Versión de PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `observaciones` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `descripcion`, `observaciones`) VALUES
(1, 'Sandwiches Especiales', ''),
(2, 'Ensaladas', ''),
(3, 'Potes', ''),
(4, 'Bandejas', ''),
(5, 'Triples', ''),
(6, 'Postres', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reposicion`
--

CREATE TABLE `reposicion` (
  `idRepo` int(11) NOT NULL,
  `fecha_repo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `detalle` json NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `local` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reposicion`
--

INSERT INTO `reposicion` (`idRepo`, `fecha_repo`, `detalle`, `id_usuario`, `local`) VALUES
(1, '2020-04-03 10:04:05', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(3, '2020-04-03 10:04:35', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"4\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"5\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"6\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(4, '2020-04-03 11:04:16', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(5, '2020-04-03 11:04:51', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(6, '2020-04-03 11:04:19', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(7, '2020-04-03 11:04:36', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(8, '2020-04-03 11:04:52', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(9, '2020-04-03 11:04:56', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(10, '2020-04-03 11:04:10', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(11, '2020-04-03 11:04:57', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(12, '2020-04-03 11:04:02', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(13, '2020-04-03 11:04:24', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(14, '2020-04-03 11:04:19', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(15, '2020-04-03 11:04:41', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(16, '2020-04-03 11:04:49', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(17, '2020-04-03 11:04:51', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(18, '2020-04-03 11:04:12', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(19, '2020-04-03 11:04:08', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(20, '2020-04-03 11:04:52', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(21, '2020-04-03 11:04:20', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(22, '2020-04-03 11:04:24', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(23, '2020-04-03 11:04:54', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(24, '2020-04-03 11:04:26', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(25, '2020-04-03 11:04:33', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(26, '2020-04-03 11:04:57', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(27, '2020-04-03 11:04:09', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(28, '2020-04-03 11:04:26', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(29, '2020-04-03 11:04:48', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(30, '2020-04-03 11:04:51', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas'),
(31, '2020-04-03 11:04:05', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(32, '2020-04-04 10:04:28', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(33, '2020-04-04 10:04:09', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"4\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"5\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"6\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(34, '2020-04-04 10:04:23', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(35, '2020-04-04 10:04:50', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(36, '2020-04-04 11:04:31', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(37, '2020-04-04 11:04:24', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(38, '2020-04-04 11:04:00', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(39, '2020-04-04 11:04:31', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(40, '2020-04-04 11:04:32', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(41, '2020-04-04 11:04:52', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(42, '2020-04-04 11:04:27', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(43, '2020-04-04 11:04:39', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(44, '2020-04-04 11:04:37', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(45, '2020-04-04 12:04:37', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"5\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"5\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(46, '2020-04-04 12:04:16', '[{\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(47, '2020-04-05 09:04:56', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(48, '2020-04-05 09:04:06', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"5\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"6\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"7\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"8\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"9\"}]', 1, 'Lomas'),
(49, '2020-04-05 09:04:48', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(50, '2020-04-05 09:04:15', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(51, '2020-04-05 10:04:40', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(52, '2020-04-05 10:04:48', '[{\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(53, '2020-04-05 11:04:35', '[{\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(54, '2020-04-05 11:04:53', '[{\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(55, '2020-04-05 11:04:31', '[{\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(56, '2020-04-05 11:04:45', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(57, '2020-04-07 09:04:33', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"3\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"2\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"4\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"5\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"6\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(58, '2020-04-07 12:04:22', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 4, 'Lomas'),
(59, '2020-04-07 13:04:33', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(60, '2020-04-07 13:04:21', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"2\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(61, '2020-04-07 13:04:44', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 6, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 7, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 8, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(62, '2020-05-10 13:05:25', '[{\"codigo\": 3, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 9, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 10, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(64, '2020-05-17 13:05:56', '[{\"codigo\": 4, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(68, '2020-05-17 13:05:14', '[{\"codigo\": 12, \"sector\": \"2\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(69, '2020-05-17 13:05:25', '[{\"codigo\": 10, \"sector\": \"2\", \"cantidad\": \"1\"}, {\"codigo\": 12, \"sector\": \"2\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(70, '2020-05-17 13:05:46', '[{\"codigo\": 5, \"sector\": \"1\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(80, '2020-05-17 14:05:27', '[{\"codigo\": 13, \"sector\": \"2\", \"cantidad\": \"1\"}]', 1, 'Lomas'),
(81, '2020-05-17 14:05:13', '[{\"codigo\": 15, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 16, \"sector\": \"1\", \"cantidad\": \"1\"}, {\"codigo\": 17, \"sector\": \"1\", \"cantidad\": \"2\"}]', 1, 'Lomas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `idSector` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `impresora` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sector`
--

INSERT INTO `sector` (`idSector`, `descripcion`, `impresora`) VALUES
(1, 'Subsuelo', 'SUBSUELO'),
(2, 'Fiambreria', 'FIAMBRERIA');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `reposicion`
--
ALTER TABLE `reposicion`
  ADD PRIMARY KEY (`idRepo`);

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`idSector`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reposicion`
--
ALTER TABLE `reposicion`
  MODIFY `idRepo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `idSector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
