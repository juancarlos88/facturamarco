-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-03-2012 a las 21:35:38
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `razon_social`, `rfc_cliente`, `calle`, `num_ext`, `num_int`, `colonia`, `codigo_postal`, `delegacion`, `estado`, `pais`, `fecha_alta`) VALUES
(1, 'Prueba S.A. de C.V.', 'SACP12345', 'Av. Siempre viva', '12', '13', 'Avante', '09800', 'Coyoacán', 'DF', 'México ', '2012-03-12');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`id_concepto`, `id_factura`, `cantidad`, `descripcion`, `precio_unitario`) VALUES
(1, 1, '20', '<p>Plumas round stic mexicano.<br />Barril verde con tapa verde.<br />Barril naranga con tapa naranja.<br />Impresi&oacute;n 1 tinta en color blanco.</p>', 1.91),
(2, 1, '2000', '<p><span style="font-family: ''Times New Roman''; text-align: left; font-size: medium;">Plumas round stic mexicano.</span><br style="font-family: ''Times New Roman''; text-align: left; font-size: medium;" /><span style="font-family: ''Times New Roman''; text-align: left; font-size: medium;">Barril verde con tapa verde.</span><br style="font-family: ''Times New Roman''; text-align: left; font-size: medium;" /><span style="font-family: ''Times New Roman''; text-align: left; font-size: medium;">Barril naranga con tapa naranja.</span><br style="font-family: ''Times New Roman''; text-align: left; font-size: medium;" /><span style="font-family: ''Times New Roman''; text-align: left; font-size: medium;">Impresi&oacute;n 1 tinta en color blanco.</span></p>', 1.91);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_cliente`, `num_factura`, `code_factura`, `fecha_altaf`) VALUES
(1, 1, '10001', 'a87e91356decf7372f6a845765c200', '2012-03-06');
