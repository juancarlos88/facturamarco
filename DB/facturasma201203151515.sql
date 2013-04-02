-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-03-2012 a las 22:15:31
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `facturasma`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `rfc_cliente` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `calle` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `num_ext` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `num_int` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `colonia` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codigo_postal` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `delegacion` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `estado` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `pais` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `razon_social`, `rfc_cliente`, `calle`, `num_ext`, `num_int`, `colonia`, `codigo_postal`, `delegacion`, `estado`, `pais`, `fecha_alta`) VALUES
(2, 'ALVA ENVASES S.A. DE C.V. ', 'AEN070524HL9', 'Niños Héroes', '1 B', NULL, 'Alfonso Espejel', '90208', 'Tlaxcala', 'Tlaxcala', 'México', '2012-03-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE IF NOT EXISTS `concepto` (
  `id_concepto` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` int(11) DEFAULT NULL,
  `cantidad` varchar(11) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` text COLLATE utf8_bin,
  `precio_unitario` double DEFAULT NULL,
  PRIMARY KEY (`id_concepto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`id_concepto`, `id_factura`, `cantidad`, `descripcion`, `precio_unitario`) VALUES
(3, 3, '500', 0x3c703e526f756e642053746963204d65786963616e6f3c6272202f3e42617272696c20426c616e636f3c6272202f3e417a756c2048533c6272202f3e54696e7461206e6567726f3c2f703e3c62722f3e3c703e266e6273703b3c2f703e, 1.91),
(4, 3, '1', 0x3c703e476173746f20646520656e76266961637574653b6f3c2f703e3c62722f3e3c703e266e6273703b3c2f703e, 150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `num_factura` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `code_factura` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `fecha_altaf` date DEFAULT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_cliente`, `num_factura`, `code_factura`, `fecha_altaf`) VALUES
(3, 2, '1001', '62c8c5235042a38444bea650dddf5478', '2012-03-07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
