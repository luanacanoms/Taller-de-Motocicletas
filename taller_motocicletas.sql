-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/05/2026 às 13:45
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `taller_motocicletas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `Id_Cliente` int(11) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Apellido1` varchar(15) NOT NULL,
  `Apellido2` varchar(15) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `Poblacion` varchar(15) NOT NULL,
  `Provincia` varchar(15) NOT NULL,
  `Telefono` varchar(9) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Fotografia` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`Id_Cliente`, `DNI`, `Nombre`, `Apellido1`, `Apellido2`, `Direccion`, `CP`, `Poblacion`, `Provincia`, `Telefono`, `Email`, `Fotografia`) VALUES
(1, '12345678A', 'Carlos', 'García', 'López', 'Calle Mayor 1', '03201', 'Elche', 'Alicante', '600111222', 'carlos.garcia@email.com', ''),
(2, '87654321B', 'María', 'Sánchez', 'Ruiz', 'Avenida Libertad 45', '03202', 'Elche', 'Alicante', '600333444', 'maria.sanchez@email.com', ''),
(3, '11223344C', 'David', 'Martínez', 'Gómez', 'Plaza Central 3', '03001', 'Alicante', 'Alicante', '600555666', 'david.martinez@email.com', ''),
(4, '23456789D', 'Laura', 'Fernández', 'Torres', 'Calle Luna 12', '03203', 'Elche', 'Alicante', '600777888', 'laura.f@email.com', ''),
(5, '34567890E', 'Javier', 'Ruiz', 'Navarro', 'Av. Blasco Ibáñez 5', '03002', 'Alicante', 'Alicante', '600999000', 'javi.ruiz@email.com', ''),
(6, '45678901F', 'Carmen', 'Domínguez', 'Gil', 'Plaza Mayor 8', '03130', 'Santa Pola', 'Alicante', '611222333', 'carmen.d@email.com', ''),
(7, '56789012G', 'Antonio', 'Morales', 'Castro', 'Calle Sol 45', '03204', 'Elche', 'Alicante', '622333444', 'antonio.m@email.com', ''),
(8, '67890123H', 'Sofía', 'Ortiz', 'Rubio', 'Vía Parque 10', '03003', 'Alicante', 'Alicante', '633444555', 'sofia.ortiz@email.com', ''),
(9, '78901234J', 'Diego', 'Molina', 'Sanz', 'Calle del Mar 22', '03140', 'Guardamar', 'Alicante', '644555666', 'diego.m@email.com', ''),
(10, '89012345K', 'Lucía', 'Delgado', 'Romero', 'Av. Novelda 100', '03205', 'Elche', 'Alicante', '655666777', 'lucia.delgado@email.com', ''),
(11, '90123456L', 'Miguel', 'Castro', 'Suárez', 'Gran Vía 15', '03004', 'Alicante', 'Alicante', '666777888', 'miguel.c@email.com', ''),
(12, '01234567M', 'Elena', 'Vargas', 'Marín', 'Calle Reina 33', '03201', 'Elche', 'Alicante', '677888999', 'elena.vargas@email.com', ''),
(13, '12345098N', 'Pablo', 'Iglesias', 'Vidal', 'Paseo Marítimo 1', '03130', 'Santa Pola', 'Alicante', '688999000', 'pablo.iglesias@email.com', ''),
(14, '11112222A', 'Roberto', 'Gallego', 'Soto', 'Calle Elfo 12', '03202', 'Elche', 'Alicante', '611000111', 'roberto.g@email.com', ''),
(15, '22223333B', 'Alba', 'Reyes', 'Méndez', 'Av. Santa Pola 4', '03130', 'Santa Pola', 'Alicante', '611000222', 'alba.reyes@email.com', ''),
(16, '33334444C', 'Jorge', 'Cano', 'Vila', 'Plaza Crevillente 1', '03205', 'Elche', 'Alicante', '611000333', 'jorge.cv@email.com', ''),
(17, '44445555D', 'Sara', 'Pascual', 'Vega', 'Calle Pinos 34', '03005', 'Alicante', 'Alicante', '611000444', 'sara.pascual@email.com', ''),
(18, '55556666E', 'Mario', 'Herrero', 'Cruz', 'Gran Vía 88', '03001', 'Alicante', 'Alicante', '611000555', 'mario.herrero@email.com', ''),
(19, '66667777F', 'Paula', 'Diez', 'Garrido', 'Calle Ancha 9', '03204', 'Elche', 'Alicante', '611000666', 'paula.diez@email.com', ''),
(20, '77778888G', 'Hugo', 'Cabrera', 'Lara', 'Paseo Marítimo 15', '03140', 'Guardamar', 'Alicante', '611000777', 'hugo.cabrera@email.com', ''),
(21, '88889999H', 'Nerea', 'Fuentes', 'Mora', 'Av. Libertad 120', '03201', 'Elche', 'Alicante', '611000888', 'nerea.fuentes@email.com', ''),
(22, '99990000J', 'Víctor', 'Rojas', 'Luna', 'Calle Poeta 22', '03004', 'Alicante', 'Alicante', '611000999', 'victor.rojas@email.com', ''),
(23, '00001111K', 'Irene', 'Iglesias', 'Parra', 'Plaza Flores 3', '03203', 'Elche', 'Alicante', '611000100', 'irene.iglesias@email.com', ''),
(24, '12121212L', 'Andrés', 'Silva', 'Ramos', 'Calle Sol 7', '03130', 'Santa Pola', 'Alicante', '611000101', 'andres.silva@email.com', ''),
(25, '13131313M', 'Clara', 'Navarro', 'Blanco', 'Av. Dama de Elche 50', '03202', 'Elche', 'Alicante', '611000102', 'clara.n@email.com', ''),
(26, '14141414N', 'Marcos', 'Giménez', 'Soler', 'Calle Mayor 80', '03002', 'Alicante', 'Alicante', '611000103', 'marcos.gimenez@email.com', ''),
(27, '15151515P', 'Teresa', 'Romero', 'Herrera', 'Vía Parque 44', '03205', 'Elche', 'Alicante', '611000104', 'teresa.romero@email.com', ''),
(28, '16161616Q', 'Iván', 'López', 'Serrano', 'Calle del Huerto 2', '03201', 'Elche', 'Alicante', '611000105', 'ivan.lopez@email.com', ''),
(29, '17171717R', 'Beatriz', 'Gómez', 'Peña', 'Av. Alfonso X 11', '03005', 'Alicante', 'Alicante', '611000106', 'beatriz.gomez@email.com', ''),
(30, '18181818S', 'Rubén', 'Martín', 'Arias', 'Calle Palmeral 5', '03203', 'Elche', 'Alicante', '611000107', 'ruben.m@email.com', ''),
(31, '19191919T', 'Silvia', 'Sánchez', 'Paredes', 'Ronda Norte 33', '03204', 'Elche', 'Alicante', '611000108', 'silvia.sanchez@email.com', ''),
(32, '20202020V', 'Adrián', 'Pérez', 'Gálvez', 'Calle del Puerto 14', '03140', 'Guardamar', 'Alicante', '611000109', 'adrian.perez@email.com', ''),
(33, '21212121W', 'Carmen', 'García', 'Ibáñez', 'Av. Estación 9', '03003', 'Alicante', 'Alicante', '611000110', 'carmen.gi@email.com', ''),
(34, '22221111X', 'Raúl', 'Fernández', 'Cortes', 'Plaza Madrid 2', '03201', 'Elche', 'Alicante', '611000112', 'raul.f@email.com', ''),
(35, '23232323Y', 'Marta', 'Ruiz', 'Carmona', 'Calle Reyes 45', '03130', 'Santa Pola', 'Alicante', '611000113', 'marta.ruiz@email.com', ''),
(36, '24242424Z', 'Alberto', 'Díaz', 'Marín', 'Av. Costa Blanca 100', '03001', 'Alicante', 'Alicante', '611000114', 'alberto.diaz@email.com', ''),
(37, '25252525A', 'Rosa', 'Vázquez', 'Ortega', 'Calle Luna 8', '03202', 'Elche', 'Alicante', '611000115', 'rosa.vazquez@email.com', ''),
(38, '26262626B', 'Héctor', 'Molina', 'Iglesias', 'Paseo Vistabella 21', '03205', 'Elche', 'Alicante', '611000116', 'hector.m@email.com', ''),
(39, '27272727C', 'Cristina', 'Suárez', 'Reyes', 'Calle Sol 99', '03004', 'Alicante', 'Alicante', '611000117', 'cristina.suarez@email.com', ''),
(40, '28282828D', 'Tomás', 'Castillo', 'Campos', 'Av. Universidad 15', '03203', 'Elche', 'Alicante', '611000118', 'tomas.castillo@email.com', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `Id_Det_Factura` int(11) NOT NULL,
  `Numero_Factura` varchar(15) NOT NULL,
  `Referencia` int(11) NOT NULL,
  `Unidades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Despejando dados para a tabela `detalle_factura`
--

INSERT INTO `detalle_factura` (`Id_Det_Factura`, `Numero_Factura`, `Referencia`, `Unidades`) VALUES
(1, 'FAC-26-001', 1, 1),
(2, 'FAC-26-001', 2, 1),
(3, 'FAC-26-002', 4, 1),
(4, 'FAC-26-003', 3, 1),
(5, 'FAC-26-004', 6, 1),
(6, 'FAC-26-005', 5, 2),
(7, 'FAC-26-006', 7, 1),
(8, 'FAC-26-007', 8, 1),
(9, 'FAC-26-008', 4, 1),
(10, 'FAC-26-009', 1, 1),
(11, 'FAC-26-010', 3, 1),
(12, 'FAC-26-010', 6, 1),
(13, 'FAC-26-011', 7, 1),
(14, 'FAC-26-011', 8, 1),
(15, 'FAC-26-012', 5, 2),
(16, 'FAC-26-012', 1, 1),
(17, 'FAC-26-013', 4, 1),
(18, 'FAC-26-013', 3, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `facturas`
--

CREATE TABLE `facturas` (
  `Numero_Factura` varchar(15) NOT NULL,
  `Matricula` varchar(7) NOT NULL,
  `Mano_Obra` int(11) NOT NULL,
  `Precio_Hora` float NOT NULL,
  `Fecha_Emision` date NOT NULL,
  `Fecha_Pago` date NOT NULL,
  `Base_Imponible` float NOT NULL,
  `IVA` float NOT NULL,
  `Total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Despejando dados para a tabela `facturas`
--

INSERT INTO `facturas` (`Numero_Factura`, `Matricula`, `Mano_Obra`, `Precio_Hora`, `Fecha_Emision`, `Fecha_Pago`, `Base_Imponible`, `IVA`, `Total`) VALUES
('FAC-26-001', '1234-BB', 2, 40, '2026-04-20', '2026-04-20', 117.5, 24.67, 142.17),
('FAC-26-002', '5678-CC', 1, 40, '2026-04-21', '2026-04-21', 160, 33.6, 193.6),
('FAC-26-003', '9012-DD', 3, 40, '2026-04-22', '0000-00-00', 120, 25.2, 145.2),
('FAC-26-004', '1111-AA', 2, 40, '2026-04-23', '2026-04-23', 125, 26.25, 151.25),
('FAC-26-005', '2222-BB', 1, 40, '2026-04-24', '2026-04-24', 57, 11.97, 68.97),
('FAC-26-006', '3333-CC', 3, 40, '2026-04-24', '2026-04-25', 215, 45.15, 260.15),
('FAC-26-007', '4444-DD', 1, 40, '2026-04-25', '2026-04-25', 58, 12.18, 70.18),
('FAC-26-008', '5555-EE', 2, 40, '2026-04-25', '0000-00-00', 200, 42, 242),
('FAC-26-009', '6666-FF', 1, 40, '2026-04-26', '2026-04-26', 65.5, 13.75, 79.25),
('FAC-26-010', '7777-GG', 4, 40, '2026-04-26', '0000-00-00', 250, 52.5, 302.5),
('FAC-26-011', '8888-HH', 2, 40, '2026-04-27', '2026-04-27', 193, 40.53, 233.53),
('FAC-26-012', '9999-JJ', 1, 40, '2026-04-27', '2026-04-28', 82.5, 17.32, 99.82),
('FAC-26-013', '0000-KK', 2, 40, '2026-04-28', '2026-04-28', 245, 51.45, 296.45);

-- --------------------------------------------------------

--
-- Estrutura para tabela `motocicletas`
--

CREATE TABLE `motocicletas` (
  `Matricula` varchar(7) NOT NULL,
  `Marca` varchar(30) NOT NULL,
  `Modelo` varchar(30) NOT NULL,
  `Anyo` int(11) NOT NULL,
  `Color` varchar(15) NOT NULL,
  `Id_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Despejando dados para a tabela `motocicletas`
--

INSERT INTO `motocicletas` (`Matricula`, `Marca`, `Modelo`, `Anyo`, `Color`, `Id_Cliente`) VALUES
('0000-KK', 'Vespa', 'Primavera', 2022, 'Azul', 13),
('0101-BC', 'Yamaha', 'XSR700', 2021, 'Verde', 23),
('0202-EF', 'Kawasaki', 'Vulcan S', 2018, 'Negra', 24),
('0303-HI', 'Suzuki', 'SV650', 2020, 'Azul', 25),
('0404-KL', 'Harley-Davidson', 'Sportster S', 2022, 'Marrón', 26),
('0505-NO', 'BMW', 'R nineT', 2021, 'Gris', 27),
('0606-QR', 'KTM', '1290 Super Duke', 2023, 'Naranja', 28),
('0707-TU', 'Ducati', 'Panigale V2', 2022, 'Roja', 29),
('0808-WX', 'Honda', 'Rebel 500', 2021, 'Negra', 30),
('0909-ZA', 'Yamaha', 'MT-09', 2023, 'Cian', 31),
('1010-AB', 'Honda', 'CB500F', 2021, 'Negra', 14),
('1111-AA', 'Suzuki', 'GSX-R600', 2018, 'Blanca', 4),
('1122-CD', 'Kawasaki', 'Z650', 2020, 'Blanca', 32),
('1212-MT', 'Honda', 'CRF300L', 2022, 'Roja', 1),
('1234-BB', 'Honda', 'CBR600RR', 2020, 'Rojo', 1),
('1313-MT', 'Yamaha', 'YZF-R3', 2021, 'Azul', 5),
('1414-MT', 'Kawasaki', 'Ninja 650', 2023, 'Verde', 10),
('1515-MT', 'Suzuki', 'Burgman 400', 2020, 'Gris', 15),
('1616-MT', 'Triumph', 'Trident 660', 2022, 'Plata', 20),
('2020-DE', 'Yamaha', 'Tracer 700', 2022, 'Gris', 15),
('2222-BB', 'KTM', 'Duke 390', 2021, 'Naranja', 5),
('2233-FG', 'Triumph', 'Tiger 900', 2022, 'Verde', 33),
('3030-GH', 'Kawasaki', 'Versys 650', 2020, 'Verde', 16),
('3333-CC', 'Triumph', 'Bonneville', 2019, 'Negra', 6),
('3344-IJ', 'Suzuki', 'GSX-S750', 2021, 'Azul', 34),
('3456-FF', 'BMW', 'R 1250 GS', 2023, 'Blanco', 1),
('4040-JK', 'Suzuki', 'V-Strom 650', 2019, 'Amarilla', 17),
('4444-DD', 'Yamaha', 'TMAX', 2023, 'Gris', 7),
('4455-LM', 'Honda', 'Forza 350', 2022, 'Gris', 35),
('5050-MN', 'BMW', 'G 310 R', 2023, 'Blanca', 18),
('5555-EE', 'Ducati', 'Monster', 2022, 'Roja', 8),
('5566-OP', 'Yamaha', 'NMAX 125', 2023, 'Blanca', 36),
('5678-CC', 'Yamaha', 'MT-07', 2022, 'Azul', 2),
('6060-PQ', 'KTM', '790 Duke', 2021, 'Naranja', 19),
('6666-FF', 'Honda', 'PCX 125', 2020, 'Blanca', 9),
('6677-RS', 'BMW', 'C 400 X', 2021, 'Negra', 37),
('7070-ST', 'Ducati', 'Scrambler', 2020, 'Amarilla', 20),
('7777-GG', 'Kawasaki', 'Z900', 2021, 'Verde', 10),
('7788-UV', 'KTM', 'RC 390', 2022, 'Naranja', 38),
('8080-VW', 'Triumph', 'Street Triple', 2022, 'Negra', 21),
('8888-HH', 'BMW', 'F 850 GS', 2019, 'Amarilla', 11),
('8899-XY', 'Ducati', 'Multistrada V4', 2023, 'Roja', 39),
('9012-DD', 'Kawasaki', 'Ninja 400', 2021, 'Verde', 3),
('9090-YZ', 'Honda', 'Africa Twin', 2023, 'Roja', 22),
('9900-AB', 'Vespa', 'GTS 300', 2021, 'Amarilla', 40),
('9999-JJ', 'Harley-Davidson', 'Iron 883', 2017, 'Negra', 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `repuestos`
--

CREATE TABLE `repuestos` (
  `Referencia` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL,
  `Importe` float NOT NULL,
  `Ganancia` int(11) NOT NULL,
  `Fotografia` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Despejando dados para a tabela `repuestos`
--

INSERT INTO `repuestos` (`Referencia`, `Descripcion`, `Importe`, `Ganancia`, `Fotografia`) VALUES
(1, 'Aceite Motor 10W40 4L', 25.5, 30, ''),
(2, 'Filtro de Aceite', 12, 40, ''),
(3, 'Juego Pastillas Freno', 45, 25, ''),
(4, 'Neumático Trasero', 120, 20, ''),
(5, 'Bujía NGK Iridium', 8.5, 50, ''),
(6, 'Batería 12V 10Ah', 45, 30, ''),
(7, 'Kit de Arrastre (Cadena)', 95, 25, ''),
(8, 'Filtro de Aire Alto Flujo', 18, 40, '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Id_Cliente`);

--
-- Índices de tabela `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`Id_Det_Factura`);

--
-- Índices de tabela `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`Numero_Factura`);

--
-- Índices de tabela `motocicletas`
--
ALTER TABLE `motocicletas`
  ADD PRIMARY KEY (`Matricula`);

--
-- Índices de tabela `repuestos`
--
ALTER TABLE `repuestos`
  ADD PRIMARY KEY (`Referencia`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `Id_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `Id_Det_Factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `repuestos`
--
ALTER TABLE `repuestos`
  MODIFY `Referencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
