-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Set-2019 às 21:23
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nfv`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comprador`
--

CREATE TABLE `comprador` (
  `id_com` int(11) NOT NULL,
  `nome_com` varchar(50) DEFAULT NULL,
  `snome_com` varchar(50) DEFAULT NULL,
  `lat_com` varchar(15) NOT NULL,
  `lon_com` varchar(15) NOT NULL,
  `cep_com` char(8) DEFAULT NULL,
  `end_com` varchar(100) DEFAULT NULL,
  `email_com` varchar(100) DEFAULT NULL,
  `senha_com` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `comprador`
--

INSERT INTO `comprador` (`id_com`, `nome_com`, `snome_com`, `lat_com`, `lon_com`, `cep_com`, `end_com`, `email_com`, `senha_com`) VALUES
(1, 'Christopher', 'Brendo', '-23.4604695', '-46.7216065', '02938000', 'Avenida Raimundo Pereira de Magalhães', 'chris@gmail.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(2, 'Amanda', 'Ketellyn', '-23.4604695', '-46.7216065', '02938000', 'Av. Raimundo Pereira de Magalhães, São Paulo - SP, 02675-031, Brazil', 'amanda@gmail.com', '123456789'),
(4, 'Emilly', 'Gonçalves', '-23.4708073', '-46.7350608', '02939000', 'Av. Dr. Felipe Pinel, São Paulo - SP, 02675-031, Brazil', 'emi.gon@hotmail.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(13, 'Christopher', 'Brendo', '-23.4822028', '-46.7233205', '02938000', 'Av. Raimundo Pereira de Magalhães, São Paulo - SP, 02938-000, Brasil', 'christopher.goncalves2002@hotmail.com.br', ''),
(14, 'Christopher', 'Brendo', '-23.4822028', '-46.7233205', '02938000', 'Av. Raimundo Pereira de Magalhães, São Paulo - SP, 02938-000, Brasil', 'christopher.goncalves2002@gmail.com', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `id_fav` int(11) NOT NULL,
  `id_pec` int(11) NOT NULL,
  `id_com` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_for` int(11) NOT NULL,
  `rs_for` varchar(255) DEFAULT NULL,
  `des_for` varchar(250) NOT NULL,
  `cnpj_for` char(14) DEFAULT NULL,
  `lat_for` varchar(13) NOT NULL,
  `lon_for` varchar(15) NOT NULL,
  `cep_for` char(8) DEFAULT NULL,
  `end_for` varchar(100) DEFAULT NULL,
  `email_for` varchar(100) DEFAULT NULL,
  `senha_for` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id_for`, `rs_for`, `des_for`, `cnpj_for`, `lat_for`, `lon_for`, `cep_for`, `end_for`, `email_for`, `senha_for`) VALUES
(1, 'Condominio Cantareira Norte Shopping', 'aaaaaaaaa', '26406107000128', '-23.4447474', '-46.7229906', '02984035', 'Av. Raimundo Pereira de Magalhães, 11001 - Parada De Taipas, São Paulo - SP, 02984-035, Brazil', 'msallum@lumine.adm.br', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(4, 'Condominio Shopping Center Pirituba', 'Apenas um teste', '07686480000135', '-23.4876489', '-46.7200572', '02936900', 'Av. Benedito Andrade, 81 - Vila Pereira Barreto, São Paulo - SP, 02675-031, Brazil', 'evandro@ivozarzur.com.br', '123456789'),
(5, 'A.p.m. Da E.e. Prof. Mariano De Oliveira', '', '49297369000105', '-23.4911765', '-46.7156355', '02919100', 'Rua Almirante Isaias de Noronha, 13 - Vila Pereira Barreto, São Paulo - SP, 02675-031, Brazil', 'mariano@gmail.com', 'aaaaaaaaaaaaa'),
(6, 'Pirituba Empreendimentos Imobiliarios Ltda', '', '60676780000116', '-23.569776', '-46.6646874', '01427001', 'R. Estados Unidos, 970 - Jardim America, São Paulo - SP, 01427-001, Brazil', 'piritubaemp@gmail.com', '123456789'),
(7, 'Borrachas Pirituba Eireli', '', '30010793000190', '-23.4873688', '-46.7104576', '02968000', 'Av. Fuad Lutfalla, 290 - Jardim Sao Jose, São Paulo - SP, 02968-000, Brazil', 'mccont@uol.com.br', '123456789'),
(9, 'Smiles Fidelidade S.a.', '', '05730375000120', '-23.5005605', '-46.8494309', '06454000', 'Alameda Rio Negro, 585 - Alphaville Industrial, Barueri - SP, 06454-000, Brazil', 'mb@bambanassessoria.com.br', '123456789'),
(10, 'Azul Linhas Aereas Brasileiras S.a.', '', '09296295000160', '-23.5049994', '-46.8374722', '06460040', 'Av. Marcos Penteado de Ulhoa Rodrigues, 939 - Tamboré, Barueri - SP, 06460-040, Brazil', 'tributario@voeazul.com.br', '123456789'),
(11, 'Condominio Edificio Parque Villa Lobos', '', '71588750000174', '-23.5308175', '-46.7292295', '05302000', 'R. Schilling, 494 - Vila Leopoldina, São Paulo - SP, 05302-001, Brazil', 'villa@gmail.com', '123456789'),
(12, 'Hannover Consultoria E Negocios Ltda.', '', '04822826000197', '-23.5465', '-46.7161613', '05461010', 'Av. Prof. Fonseca Rodrigues, 960 - Alto de Pinheiros, São Paulo - SP, Brazil', 'antonio@alpinacontabilidade.com.br', '123456789'),
(13, 'Icarros Ltda.', '', '03991201000196', '-23.6356005', '-46.6414713', '04344902', 'Pç. Alfredo Egydio de Souza Aranha - R. Volkswagen, 3 - Jabaquara, São Paulo - SP, Brazil', 'cpires@icarros.com.br', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `id_ima` int(11) NOT NULL,
  `nome_ima` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `imagem`
--

INSERT INTO `imagem` (`id_ima`, `nome_ima`) VALUES
(1, 'albertinho-wallpaper.jpg'),
(2, 'albertinho-wallpaper.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

CREATE TABLE `marca` (
  `id_mar` int(11) NOT NULL,
  `nome_mar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`id_mar`, `nome_mar`) VALUES
(1, 'Audi'),
(2, 'BMW'),
(3, 'Chery'),
(4, 'Chevrolet'),
(5, 'Citroen'),
(6, 'Fiat'),
(7, 'Ford'),
(8, 'Honda'),
(9, 'Hyundai'),
(10, 'Jac Motors'),
(11, 'Kia'),
(12, 'Mercedes-Benz'),
(13, 'Mitsubishi'),
(14, 'Nissan'),
(15, 'Peugeot'),
(16, 'Renault'),
(17, 'Subaru'),
(18, 'Suzuki'),
(19, 'Toyota'),
(20, 'Volkswagen'),
(21, 'Volvo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo`
--

CREATE TABLE `modelo` (
  `id_mod` int(11) NOT NULL,
  `id_mar` int(11) NOT NULL,
  `nome_mod` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `modelo`
--

INSERT INTO `modelo` (`id_mod`, `id_mar`, `nome_mod`) VALUES
(1, 1, 'A1'),
(2, 1, 'A3 Sedan'),
(3, 1, 'A3'),
(4, 1, 'A4 Avant'),
(5, 1, 'A4 Sedan'),
(6, 1, 'A5'),
(7, 1, 'A7'),
(8, 1, 'A8'),
(9, 1, 'Q3'),
(10, 1, 'Q5'),
(11, 1, 'Q7'),
(12, 1, 'R8'),
(13, 1, 'R8 GT'),
(14, 1, 'RS 3 Sportback'),
(15, 1, 'RS5'),
(16, 1, 'RS6 Avant'),
(17, 1, 'TT Coupe'),
(18, 1, 'TT Roadster'),
(19, 2, 'Série 1'),
(20, 2, 'Série 1 Cabrio'),
(21, 2, 'Série 1 Coupé'),
(22, 2, 'Série 1 M'),
(23, 2, 'Série 3 Cabrio'),
(24, 2, 'Série 3 M3 Coupé'),
(25, 2, 'Série 3 M3 Sedã'),
(26, 2, 'Série 3 Sedã'),
(27, 2, 'Série 5 Gran Turismo'),
(28, 2, 'Série 5 Sedã'),
(29, 2, 'Série 7 Sedã'),
(30, 2, 'X1'),
(31, 2, 'X3'),
(32, 2, 'X'),
(33, 2, 'X6'),
(34, 2, 'Z4 Roadster'),
(35, 2, 'I3'),
(36, 3, 'Celer Hatch'),
(37, 3, 'Celer Sedan'),
(38, 3, 'Cielo Hatch'),
(39, 3, 'Cielo Sedan'),
(40, 3, 'Face'),
(41, 3, 'QQ'),
(42, 3, 'S18'),
(43, 3, 'Tiggo'),
(44, 4, 'Agile'),
(45, 4, 'Astra Hatch'),
(46, 4, 'Astra Sedan'),
(47, 4, 'Blazer'),
(48, 4, 'Camaro'),
(49, 4, 'Captiva'),
(50, 4, 'Celta'),
(51, 4, 'Classic'),
(52, 4, 'Cobalt'),
(53, 4, 'Corsa Hatch'),
(54, 4, 'Corsa Sedan'),
(55, 4, 'Cruze'),
(56, 4, 'Cruze Sport6'),
(57, 4, 'Malibu'),
(58, 4, 'Montana'),
(59, 4, 'Omega'),
(60, 4, 'Onix'),
(61, 4, 'Prisma'),
(62, 4, 'S10'),
(63, 4, 'Sonic'),
(64, 4, 'Spin'),
(65, 4, 'Tracker'),
(66, 4, 'Trailblazer'),
(67, 4, 'Vectra'),
(68, 4, 'Vectra GT'),
(69, 4, 'Zafira'),
(70, 5, 'Aircross'),
(71, 5, 'C3'),
(72, 5, 'C3 Picasso'),
(73, 5, 'C4'),
(74, 5, 'C4 Lounge'),
(75, 5, 'C4 Pallas'),
(76, 5, 'C4 Picasso'),
(77, 5, 'C5'),
(78, 5, 'C5 Tourer'),
(79, 5, 'DS3'),
(80, 5, 'DS5'),
(81, 5, 'Jumper'),
(82, 5, 'Xsara Picasso'),
(83, 6, '500'),
(84, 6, '500 Abarth'),
(85, 6, 'Bravo'),
(86, 6, 'Doblò'),
(87, 6, 'Doblò Cargo'),
(88, 6, 'Ducato'),
(89, 6, 'Fiorino'),
(90, 6, 'Freemont'),
(91, 6, 'Grand Siena'),
(92, 6, 'Idea'),
(93, 6, 'Linea'),
(94, 6, 'Mille'),
(95, 6, 'Palio'),
(96, 6, 'Palio Adventure'),
(97, 6, 'Palio Weekend'),
(98, 6, 'Punto'),
(99, 6, 'Siena EL'),
(100, 6, 'Strada'),
(101, 6, 'Uno'),
(102, 7, 'Courier'),
(103, 7, 'EcoSport'),
(104, 7, 'Edge'),
(105, 7, 'F-250'),
(106, 7, 'Fiesta Rocam Hatch'),
(107, 7, 'Fiesta Rocam Sedan'),
(108, 7, 'Focus Hatch'),
(109, 7, 'Focus'),
(110, 7, 'Sedan'),
(111, 7, 'Fusion'),
(112, 7, 'Ka'),
(113, 7, 'Ka+'),
(114, 7, 'New Fiesta'),
(115, 7, 'New Fiesta Hatch'),
(116, 7, 'Ranger'),
(117, 8, 'Accord'),
(118, 8, 'CR-V'),
(119, 8, 'City'),
(120, 8, 'Civic'),
(121, 8, 'Civic Si'),
(122, 8, 'Fit'),
(123, 8, 'HR-V'),
(124, 9, 'Azera'),
(125, 9, 'Equus'),
(126, 9, 'HB20'),
(127, 9, 'HB20S'),
(128, 9, 'HR'),
(129, 9, 'Santa Fe'),
(130, 9, 'Sonata'),
(131, 9, 'Tucson'),
(132, 9, 'Veloster'),
(133, 9, 'Veracruz'),
(134, 9, 'I30'),
(135, 9, 'I30 CW'),
(136, 9, 'IX35'),
(137, 10, 'J2'),
(138, 10, 'J3'),
(139, 10, 'J3 Turin'),
(140, 10, 'J5'),
(141, 10, 'J6'),
(142, 10, 'T6'),
(143, 11, 'Cadenza'),
(144, 11, 'Carens'),
(145, 11, 'Carnival'),
(146, 11, 'Cerato'),
(147, 11, 'Mohave'),
(148, 11, 'Optima'),
(149, 11, 'Picanto'),
(150, 11, 'Sorento'),
(151, 11, 'Soul'),
(152, 11, 'Sportage'),
(153, 12, 'CLA'),
(154, 12, 'Classe A'),
(155, 12, 'Classe B'),
(156, 12, 'Classe C'),
(157, 12, 'Classe C 250 Turbo Sport'),
(158, 12, 'Classe C 63 AMG Touring'),
(159, 12, 'Classe CL'),
(160, 12, 'Classe CLS 63 AMG'),
(161, 12, 'Classe E'),
(162, 12, 'Classe G'),
(163, 12, 'Classe GL'),
(164, 12, 'Classe GLK'),
(165, 12, 'Classe M'),
(166, 12, 'Classe S'),
(167, 12, 'Classe S 400 Hybird'),
(168, 12, 'Classe SLK'),
(169, 12, 'Classe SLS AMG'),
(170, 12, 'GLA'),
(171, 13, 'ASX'),
(172, 13, 'L200 Outdoor'),
(173, 13, 'L200 Savana'),
(174, 13, 'L200 Triton'),
(175, 13, 'Lancer Evolution X'),
(176, 13, 'Outlander'),
(177, 13, 'Pajero Dakar'),
(178, 13, 'Pajero Full'),
(179, 13, 'Pajero Sport'),
(180, 13, 'Pajero TR4'),
(181, 14, 'Frontier'),
(182, 14, 'Grand Livina'),
(183, 14, 'Livina'),
(184, 14, 'March'),
(185, 14, 'Sentra'),
(186, 14, 'Tiida Hatch'),
(187, 14, 'Tiida Sedan'),
(188, 14, 'Versa'),
(189, 15, '2008'),
(190, 15, '207'),
(191, 15, '207 SW'),
(192, 15, '207 Sedan'),
(193, 15, '208'),
(194, 15, '3008'),
(195, 15, '307'),
(196, 15, '308'),
(197, 15, '308 CC'),
(198, 15, '408'),
(199, 15, '508'),
(200, 15, 'Boxer'),
(201, 15, 'Hoggar'),
(202, 15, 'Partner'),
(203, 15, 'RCZ'),
(204, 16, 'Clio'),
(205, 16, 'Duster'),
(206, 16, 'Fluence'),
(207, 16, 'Grand Tour'),
(208, 16, 'Kangoo Express'),
(209, 16, 'Logan'),
(210, 16, 'Master'),
(211, 16, 'Sandero'),
(212, 16, 'Sandero Stepway'),
(213, 16, 'Symbol'),
(214, 17, 'Forester'),
(215, 17, 'Impreza Hatch'),
(216, 17, 'Impreza Sedan'),
(217, 17, 'Legacy'),
(218, 17, 'Outback'),
(219, 17, 'Tribeca'),
(220, 18, 'Grand Vitara'),
(221, 18, 'Jimny'),
(222, 18, 'SX4'),
(223, 19, 'Camry'),
(224, 19, 'Corolla'),
(225, 19, 'Etios Hatch'),
(226, 19, 'Etios Sedan'),
(227, 19, 'Hilux'),
(228, 19, 'Prius'),
(229, 19, 'RAV4'),
(230, 19, 'SW4'),
(231, 20, 'Amarok'),
(232, 20, 'CrossFox'),
(233, 20, 'Fox'),
(234, 20, 'Fusca'),
(235, 20, 'Gol'),
(236, 20, 'Gol G4'),
(237, 20, 'Golf'),
(238, 20, 'Jetta'),
(239, 20, 'Jetta Variant'),
(240, 20, 'Kombi'),
(241, 20, 'Parati'),
(242, 20, 'Passat'),
(243, 20, 'Passat Variant'),
(244, 20, 'Polo'),
(245, 20, 'Polo Sedan'),
(246, 20, 'Saveiro'),
(247, 20, 'Space Cross'),
(248, 20, 'Space Fox'),
(249, 20, 'Tiguan'),
(250, 20, 'Touareg'),
(251, 20, 'Up!'),
(252, 20, 'Voyage'),
(253, 21, 'C30'),
(254, 21, 'S60'),
(255, 21, 'V40'),
(256, 21, 'XC60'),
(257, 21, 'XC90');

-- --------------------------------------------------------

--
-- Estrutura da tabela `peca`
--

CREATE TABLE `peca` (
  `id_pec` int(11) NOT NULL,
  `id_for` int(11) NOT NULL,
  `id_mar` int(11) NOT NULL,
  `id_mod` int(11) NOT NULL,
  `ano_pec` char(4) DEFAULT NULL,
  `nome_pec` varchar(50) DEFAULT NULL,
  `des_pec` varchar(255) DEFAULT NULL,
  `val_pec` int(11) DEFAULT NULL,
  `id_ima` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `peca`
--

INSERT INTO `peca` (`id_pec`, `id_for`, `id_mar`, `id_mod`, `ano_pec`, `nome_pec`, `des_pec`, `val_pec`, `id_ima`) VALUES
(1, 1, 1, 1, '2002', 'Mateus', 'Teste', 12000, 1),
(2, 1, 2, 19, '2001', 'eduardo correia', 'teaead', 1354, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comprador`
--
ALTER TABLE `comprador`
  ADD PRIMARY KEY (`id_com`);

--
-- Indexes for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `id_com` (`id_com`),
  ADD KEY `id_pec` (`id_pec`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_for`);

--
-- Indexes for table `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`id_ima`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_mar`);

--
-- Indexes for table `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id_mod`),
  ADD KEY `id_mar` (`id_mar`);

--
-- Indexes for table `peca`
--
ALTER TABLE `peca`
  ADD PRIMARY KEY (`id_pec`),
  ADD KEY `id_for` (`id_for`),
  ADD KEY `id_mar` (`id_mar`),
  ADD KEY `id_mod` (`id_mod`),
  ADD KEY `id_ima` (`id_ima`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comprador`
--
ALTER TABLE `comprador`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_for` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `imagem`
--
ALTER TABLE `imagem`
  MODIFY `id_ima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id_mar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id_mod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `peca`
--
ALTER TABLE `peca`
  MODIFY `id_pec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_com`) REFERENCES `comprador` (`id_com`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_pec`) REFERENCES `peca` (`id_pec`);

--
-- Limitadores para a tabela `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`id_mar`) REFERENCES `marca` (`id_mar`);

--
-- Limitadores para a tabela `peca`
--
ALTER TABLE `peca`
  ADD CONSTRAINT `peca_ibfk_1` FOREIGN KEY (`id_for`) REFERENCES `fornecedor` (`id_for`),
  ADD CONSTRAINT `peca_ibfk_2` FOREIGN KEY (`id_mar`) REFERENCES `marca` (`id_mar`),
  ADD CONSTRAINT `peca_ibfk_3` FOREIGN KEY (`id_mod`) REFERENCES `modelo` (`id_mod`),
  ADD CONSTRAINT `peca_ibfk_4` FOREIGN KEY (`id_ima`) REFERENCES `imagem` (`id_ima`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
