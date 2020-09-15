-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-09-2020 a las 12:54:39
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `morosos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anunciantes`
--

CREATE TABLE `anunciantes` (
  `login` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `bloqueado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `anunciantes`
--

INSERT INTO `anunciantes` (`login`, `password`, `email`, `bloqueado`) VALUES
('dwes', '$2y$04$3ghELHuqRjFmLdx.LJWFw.hDJTPMI7.uRSjjbUnaZLOcoeg5Ztneq', 'dwes@dwes.com', 0),
('usu1', '$2y$10$3aHQA/tKluA.F2m.F5gaPOf.XrmWgzlJ13gAaF4s0L02reWDWm77O', 'usu1@usu1.com', 0),
('usu2', '$2y$10$unGNFSzpS6hy96K65g5q.eExREhyufoDlDotoMEjEA7IYdefoz4M6', 'usu1@usu1.com', 0),
('usu3', '$2y$10$dHfPcexvOlxHcKhkRysil./HBt/k52LltULCpiYOakUmWAijuSzQO', 'usu1@usu1.com', 1),
('usu4', '$2y$04$5sNWjv24GwHKbK0kHZxsWedM7Wb0aZVCoT.RfHs.HHUWyG.N.JAkK', 'usu2@usu2.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `id_anuncio` int(11) NOT NULL,
  `autor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `moroso` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `localidad` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`id_anuncio`, `autor`, `moroso`, `localidad`, `descripcion`, `fecha`) VALUES
(117, 'usu2', 'Carlos', 'Av Carlos Haya, 29010 Málaga, Málaga, Spain', 'casa okupa 34', '2020-05-28'),
(119, 'usu1', 'el paco', 'Av carlos de haya 29010 Málaga, Málaga, España', 'Casa okupada 34', '2020-04-07'),
(258, 'usu2', 'pepe', 'malaga', 'banco', '2020-08-12'),
(275, 'usu1', 'pepe1', 'jazmines 12, Málaga', 'pepe3', '2020-08-19'),
(277, 'usu1', 'hola', 'hola', 'hola', '2020-08-19'),
(278, 'Invitado', '', '', '', '2020-08-19'),
(284, 'usu1', '  el primer', 'rosa 20', 'banco caixa', '2020-09-01'),
(288, 'pepe2', ' pepe2 pepe2', 'rosa 12', 'bqanckl', '2020-09-30'),
(289, 'usu1', 'babriela', 'Jazmines, 12, Málaga', 'caixa bancka', '2020-09-05'),
(290, 'usu1', '888', 'kkklk', 'kklklk', '2020-09-05'),
(291, 'usu1', ' 999999', 'kkkkkk', 'kkkkkkk', '2020-09-05'),
(294, 'usu1', 'el mrooso', 'kjkjk', 'kjkjk', '2020-09-05'),
(299, 'usu1', ' lkkl', 'klklklk', 'klklklk', '2020-09-05'),
(300, 'usu1', ' pepep', 'pwpepw', 'pepepe', '2020-09-05'),
(318, 'usu1', ' moroso 11', 'jazmines 12, Málaga', 'banco', '2020-09-06'),
(326, 'usu1', ' ppop', 'ppop', 'pppop', '2020-09-06'),
(327, 'usu1', 'kjkj', 'kjkjk', 'kjkj', '2020-09-06'),
(328, 'usu1', ' jkjkj', 'jkjkjk', 'kjkjk', '2020-09-06'),
(334, 'usu1', ' mroso34', 'hjjhjhhjh', 'hjhjhjh', '2020-09-06'),
(337, 'usu1', 'pepe23', 'rosa 23', 'banco 23', '2020-09-06'),
(365, 'usu1', 'nuevo', 'rosa12 ', 'banco 12', '2020-09-06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anunciantes`
--
ALTER TABLE `anunciantes`
  ADD PRIMARY KEY (`login`);

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id_anuncio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
