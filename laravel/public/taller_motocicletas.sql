-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 14-04-2020 a las 13:06:43
-- Versión del servidor: 5.6.35
-- Versión de PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taller_motocicletas`
--
CREATE DATABASE IF NOT EXISTS `taller_motocicletas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `taller_motocicletas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `Id_Cliente` int(11) NOT NULL,
  `DNI` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Apellido1` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Apellido2` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `CP` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Poblacion` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Provincia` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Fotografia` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Detalle_Factura`
--

CREATE TABLE `Detalle_Factura` (
  `Id_Det_Factura` int(11) NOT NULL,
  `Numero_Factura` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` int(11) NOT NULL,
  `Unidades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Facturas`
--

CREATE TABLE `Facturas` (
  `Numero_Factura` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Matricula` varchar(7) COLLATE utf8_spanish_ci NOT NULL,
  `Mano_Obra` int(11) NOT NULL,
  `Precio_Hora` float NOT NULL,
  `Fecha_Emision` date NOT NULL,
  `Fecha_Pago` date NOT NULL,
  `Base_Imponible` float NOT NULL,
  `IVA` float NOT NULL,
  `Total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Motocicletas`
--

CREATE TABLE `Motocicletas` (
  `Matricula` varchar(7) COLLATE utf8_spanish_ci NOT NULL,
  `Marca` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Modelo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Anyo` int(11) NOT NULL,
  `Color` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Id_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Repuestos`
--

CREATE TABLE `Repuestos` (
  `Referencia` int(11) NOT NULL,
  `Descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Importe` float NOT NULL,
  `Ganancia` int(11) NOT NULL,
  `Fotografia` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`Id_Cliente`);

--
-- Indices de la tabla `Detalle_Factura`
--
ALTER TABLE `Detalle_Factura`
  ADD PRIMARY KEY (`Id_Det_Factura`);

--
-- Indices de la tabla `Facturas`
--
ALTER TABLE `Facturas`
  ADD PRIMARY KEY (`Numero_Factura`);

--
-- Indices de la tabla `Motocicletas`
--
ALTER TABLE `Motocicletas`
  ADD PRIMARY KEY (`Matricula`);

--
-- Indices de la tabla `Repuestos`
--
ALTER TABLE `Repuestos`
  ADD PRIMARY KEY (`Referencia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `Id_Cliente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Detalle_Factura`
--
ALTER TABLE `Detalle_Factura`
  MODIFY `Id_Det_Factura` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Repuestos`
--
ALTER TABLE `Repuestos`
  MODIFY `Referencia` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
