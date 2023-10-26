-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2014 a las 20:47:59
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `system_validator`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `rfc` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pais` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `no_int` int(11) NOT NULL,
  `no_ext` int(11) NOT NULL,
  `municipio` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `localidad` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `colonia` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cp` int(11) NOT NULL,
  `calle` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`rfc`, `nombre`, `pais`, `no_int`, `no_ext`, `municipio`, `localidad`, `estado`, `colonia`, `cp`, `calle`) VALUES
('APA9707035N4', 'AGRICOLA PAREDES SA DE CV', 'MEXICO', 302, 520, 'CULIACAN', 'CULIACAN DE ROSALES', 'SINALOA', 'CENTRO', 80000, 'PASEO NIÑOS HEROES ORIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `records_xml`
--

CREATE TABLE IF NOT EXISTS `records_xml` (
  `rfc` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `nombre_xml` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folio_uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden_compra` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valido` tinyint(1) NOT NULL,
  `errores` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `records_xml`
--

INSERT INTO `records_xml` (`rfc`, `fecha`, `nombre_xml`, `folio_uuid`, `orden_compra`, `valido`, `errores`) VALUES
('TOM850506EL9', '2014-11-27 15:32:05', 'TOM850506EL9L6206008112014.xml', '42fca418-01e3-4863-9225-ad920ca57bdb', '', 1, ''),
('TOM850506EL9', '2014-11-27 15:32:05', 'TOM850506EL9L6206108112014.xml', 'e5e8606e-b16b-4fc6-ab09-c9c02f776913', '', 1, ''),
('TOM850506EL9', '2014-11-27 15:32:05', 'TOM850506EL9L6206208112014.xml', '4bf08734-89e0-4a14-9176-f2241b606679', '', 1, ''),
('TOM850506EL9', '2014-11-27 15:32:05', 'TOM850506EL9L6206308112014.xml', 'c81466ed-2730-466b-aa62-42d59a1ee956', '', 1, ''),
('TOM850506EL9', '2014-11-27 15:44:35', 'TOM850506EL9L6206408112014.xml', '184ccce0-c84e-451d-86b9-3a8b1d729548', '', 1, ''),
('TOM850506EL9', '2014-11-27 15:44:35', 'TOM850506EL9R1283608112014.xml', 'E400D9C6-3937-44D2-9474-7D65A6E59A9C', '', 1, ''),
('BBT680215S78', '2014-11-27 17:33:05', 'LC-141664.XML', '63B2203A-BFA4-4EDD-A2DD-FB8C98DC034F', '', 1, ''),
('PNO860502HSA', '2014-12-05 09:21:12', 'PNO860502HSA__AX__15207.xml', '8865F8D5-3DD2-4FCF-AC8B-2FE09D97F04D', '', 1, ''),
('PNO860502HSA', '2014-12-05 09:21:12', 'PNO860502HSA__PX__19685.xml', '7C5A9F09-EB37-45FF-ACDC-EC7F204FEBE1', '', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_ultsol` date NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cve_proveedor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `password`, `correo`, `fecha_ultsol`, `nombre`, `cve_proveedor`) VALUES
('GAAJ910704HX8', '025a4659f9cfdb9b6fdc20f8ca19e3ec', 'jegandarillaa@gmail.com', '2014-10-01', 'Jesus Edwin Gandarilla Aguilar', ''),
('GALE120918KD9', '025a4659f9cfdb9b6fdc20f8ca19e3ec', 'edwin_gala@hotmail.com', '2014-10-24', 'Edwin Daniel Gandarilla Lara', 'APA1421'),
('TOM850506EL9', 'fdeb29f1a8bb6edb894f1a035eb3f0a8', 'cobranza@tomaco.mx', '2014-11-26', 'TOMACO SA DE CV', '000015'),
('PNO860502HSA', '6c42b00a098c84f0c67bcb5cbe07a857', 'kosuna@pro-agro.com.mx', '2014-11-26', 'PROAGRO DEL NOROESTE,S.A.DE C.V.', '000059'),
('BBT680215S78', '308f78c51c8d4da6ae31cf9108348230', 'cartera.culiacan@babatsa.com.mx', '2014-11-26', 'BALEROS, BANDAS Y TORNILLOS, S.A. DE C.V.', '000144'),
('AGP121212D59   ', 'b90e0cdf887232b846d4e571bf10ee21', 'xxx@mail.com', '0000-00-00', 'PRUEBA', '1\r'),
('INO840605F54   ', 'de9d4040e81fed0155a96dc29cd97f47', 'xxx@mail.com', '0000-00-00', 'INDUSTRIAS NOY, S.A. DE C.V.', '7\r'),
('FCS9112164M0   ', 'b5cc320d2b72f72923496a79689a4ade', 'xxx@mail.com', '0000-00-00', 'FETASA CULIACAN, S. A. DE C. V.', '14\r'),
('KUR710801793   ', '17574cca2e700e1f496105ad600cf337', 'xxx@mail.com', '0000-00-00', 'KURODA, S.A. DE C.V.', '17\r'),
('ROG821220CG4   ', '8f2a80e70da57122c73b2b3d9490a900', 'xxx@mail.com', '0000-00-00', 'ROGAS, S.A. DE C.V.', '20\r'),
('MAC8504266YA   ', '7943688cc3f11374128719ade3c01ae7', 'xxx@mail.com', '0000-00-00', 'MUELLES Y AMORTIGUADORES DE CULIACAN, S.A. DE C.V.', '25\r'),
('SOQG630626TE8  ', '04fc8a7b06f096f59d10c5373f9d7c13', 'xxx@mail.com', '0000-00-00', 'JOSE GUADALUPE SOTO QUINTERO', '29\r'),
('MHU820315UT3   ', 'd000a9ef9c4408a6d38984335cb97ee8', 'xxx@mail.com', '0000-00-00', 'MAQUINARIA DEL HUMAYA,S.A.DE C.V.', '34\r'),
('AGR080515141   ', '280bcbc22358284c8b561e653a5f3ead', 'xxx@mail.com', '0000-00-00', 'AGRICENTER, S.A. DE C.V.', '37\r'),
('LCU580417F43   ', '3739186ba36c7779fd0501e716560330', 'xxx@mail.com', '0000-00-00', 'LLANTERA DE CULIACAN, S.A. DE C.V.', '62\r'),
('GGE9511222Z2   ', 'a20a1dad7a964d707756ef076f0f6608', 'xxx@mail.com', '0000-00-00', 'GASTELUM Y GASTELUM ELECTRICIDAD, S.A. DE C.V.', '65\r'),
('FAN870311EE6   ', 'cd1522861a59578ad6fe0d49f6716435', 'xxx@mail.com', '0000-00-00', 'FANOSA, S.A. DE C.V.', '67\r'),
('AEBJ811019V11  ', 'c009e79fcae7b3328799d3510eb32365', 'xxx@mail.com', '0000-00-00', 'JUAN ADRIAN ARECHIGA BARRON', '76\r'),
('AHO090529TY7   ', '521fe6cbc92edbdeb503c97e92f3d9e4', 'xxx@mail.com', '0000-00-00', 'AS HORTISERVICIOS,S.A. DE C.V.', '77\r'),
('NPA911023IM5   ', 'fc4244c853c601d3149b014822fbe619', 'xxx@mail.com', '0000-00-00', 'NOVATEC PAGANI,S.A. DE C.V.', '78\r'),
('IRO951228268   ', 'c824625371d15a6a59465cc9529b2751', 'xxx@mail.com', '0000-00-00', 'INDUSTRIAS ROCHIN, S.A. DE C.V.', '79\r'),
('FAG031203IU9   ', 'a37f55b049d1fd16745346d27ca40421', 'xxx@mail.com', '0000-00-00', 'FG AGROPRODUCTOS, S. DE R.L. DE C.V.', '81\r'),
('BARE630723AU1  ', '7e3c384017db20d1d597a5cabad8195d', 'xxx@mail.com', '0000-00-00', 'ERNESTO BATIZ RAMIREZ', '82\r'),
('EVA031110T77   ', 'cbd4dc852a9563a5203b56015d710cb1', 'xxx@mail.com', '0000-00-00', 'ELECTRICA VALENZUELA, S.A.DE C.V.', '90\r'),
('IHE910614QG4   ', 'a6efc921f9d69db8c63ee84c9b6274b2', 'xxx@mail.com', '0000-00-00', 'INDUSTRIAL HERGAR S.A. DE C.V.', '93\r'),
('ERC840604LF5   ', 'c36e56af84bf9c002a976a4a859d9d64', 'xxx@mail.com', '0000-00-00', 'EQUIPOS Y REFRIGERACION DE CULIACAN, S.A. DE C.V.', '94\r'),
('LOLR6205053B8  ', '1966b98cf4c61a5edb343acec758c077', 'xxx@mail.com', '0000-00-00', 'RUBEN LOPEZ LLANES', '97\r'),
('UISM901005BE4  ', 'cef4fa59925732eb06bad92e70bb2c93', 'xxx@mail.com', '0000-00-00', 'MARTIN ALBERTO URIARTE SANCHEZ', '99\r'),
('PME960701GG0   ', '212d0f732e63515b7518c2db5a30966b', 'xxx@mail.com', '0000-00-00', 'PRAXAIR MEXICO, S. DE R.L. DE C.V', '102\r'),
('NAN0307243I9   ', 'b77b620d3c6ebc66ad305326d2cb9e51', 'xxx@mail.com', '0000-00-00', 'NUEVA AGROINDUSTRIAS DEL NORTE, S.A. DE C.V.', '108\r'),
('EXTRANJERO     ', '91cafb39a78d2c48a06ee4a05d5e8171', 'xxx@mail.com', '0000-00-00', 'COMMERCIAL PACKING SERVICES OF NOGALES, L.L.C.', '112\r'),
('CUN820107GC7   ', '0a88c774dea34b66c414cb727f28928b', 'xxx@mail.com', '0000-00-00', 'COMERCIOS UNIDOS, S.A DE C.V.', '117\r'),
('EIA060304LK1   ', 'a2b5359325a306fca49007b7374aeb38', 'xxx@mail.com', '0000-00-00', 'ESPECIALIDADES INDUSTRIALES Y AGRICOLAS, S.A. DE C.V.', '118\r'),
('DIM020131HVA   ', '73e1f183feb689fd4fb8b087d7902905', 'xxx@mail.com', '0000-00-00', 'DRIP IRRIGATION DE MEXICO, S.A. DE C.V.', '121\r'),
('CDI020814TMA   ', 'd881cd5172e6962a4ac1c46fa91c2c31', 'xxx@mail.com', '0000-00-00', 'COMERCIAL DIGAX,S.A. DE C.V.', '122\r'),
('PMR920213FY6   ', 'b8000cafd5390a6c39b722e1eedd2b90', 'xxx@mail.com', '0000-00-00', 'PROVEEDOR MAYORISTA AL REFACCIONARIO, S.A. DE C.V.', '124\r'),
('INF891031LT4   ', '1bcb65d62070a88e7f8c6731909a6f96', 'xxx@mail.com', '0000-00-00', 'INFRA, S.A. DE C.V.', '127\r'),
('CPA791010QF7   ', 'c0613478d0e1675382b584ba1fe18d58', 'xxx@mail.com', '0000-00-00', 'CAMIONERA DEL PACIFICO S. A. DE C. V.', '134\r'),
('PRT950411LC8   ', '21c554ea3336d83d8591ae58252fdec0', 'xxx@mail.com', '0000-00-00', 'PLASTICOS Y RESINAS TRES RIOS, S.A. DE C.V.', '135\r'),
('EMA810918F2A   ', 'aa7f394b197bd0201a37b18ec26955d5', 'xxx@mail.com', '0000-00-00', 'EMPRESAS MATCO, S.A. DE C.V.', '138\r'),
('AEAD5108265X3  ', '9321d2a32cdb1466a4fe5002380be4c4', 'xxx@mail.com', '0000-00-00', 'ADRIAN FILIBERTO ARECHIGA ', '139\r'),
('MMA931202QJ4   ', '73e06c80d5ac1e98106a1863773527c4', 'xxx@mail.com', '0000-00-00', 'MAPCO MATERIALES, S.A. DE C.V.', '140\r'),
('PFN9105238S8   ', 'c98041f336998c2a690944851a3479f8', 'xxx@mail.com', '0000-00-00', 'PRODUCTORA DE FERTILIZANTES DEL NOROESTE,S.A. DE C.V.', '141\r'),
('SIN110831222   ', 'ba0ba09cd6f0f0eaf2818bf8bcacc820', 'xxx@mail.com', '0000-00-00', 'SYSCO INDUSTRIAL, S.A. DE C.V.', '142\r'),
('LRS830215LH1   ', '1719f913b586056d98638655be819e8b', 'xxx@mail.com', '0000-00-00', 'LLANTAS ROYAL DE SINALOA, S.A. DE C.V.', '152\r'),
('ASI9806089R1   ', '368f4e2a04f020ca11b220f1fcd7ce33', 'xxx@mail.com', '0000-00-00', 'ATESA DE SINALOA, S.A. DE C.V.', '154\r'),
('SER930302FA4   ', '4728fce9a9c6a0b16381787816457454', 'xxx@mail.com', '0000-00-00', 'SERDI S.A. DE C.V.', '157\r'),
('VALO440416HR9  ', '4ea87623ee64aeced33ded620a306e10', 'xxx@mail.com', '0000-00-00', 'ONOFRE VALENZUELA LOPEZ', '166\r'),
('ADE851227V81   ', '656774253be896916a4d0d7bdbc28679', 'xxx@mail.com', '0000-00-00', 'AGRO DESCUENTO, S.A DE C.V.', '167\r'),
('SAN990311RH7   ', '22a1470ca6e62bca3f00789567a13ace', 'xxx@mail.com', '0000-00-00', 'SERVICIOS DE ACERO DEL NOROESTE, S.A. DE C.V.', '168\r'),
('GUMM5109297D1  ', 'ce864c52beca3cf2d3d4912e1960e04f', 'xxx@mail.com', '0000-00-00', 'JOSE MIGUEL GUZMAN MERCADO', '170\r'),
('HOR1012097D2   ', 'f01d40aaf86f05f0f617f32040b5ffdd', 'xxx@mail.com', '0000-00-00', 'HUMISOL ORGANICO, S.A. DE C.V.', '171\r'),
('OCO980123SB7   ', 'e5994320162346b3ba88e7e3693776d7', 'xxx@mail.com', '0000-00-00', 'OFI-COMP,S.A. DE C.V.', '179\r'),
('AAIJ6501171Y3  ', '3f57b46e3d408c8e3a4faf6f5ca979f1', 'xxx@mail.com', '0000-00-00', 'JUAN CARLOS ARAMBURO IZABAL', '183\r'),
('GAVM480330P86  ', 'c7cfadaca13c52ab3c000ff3fcb0785e', 'xxx@mail.com', '0000-00-00', 'MIGUEL ANGEL GARCIA VALDEZ', '196\r'),
('SLP7801205A9   ', '1835e0a5a07cc4fcadc318179a79e4c6', 'xxx@mail.com', '0000-00-00', 'SUPER LLANTAS DEL PACIFICO, S.A. DE C.V.', '199\r'),
('LOCJ5108148E9  ', 'f57ce3552dd11b6404871179355baa50', 'xxx@mail.com', '0000-00-00', 'JULIA LOPEZ CALDERON', '202\r'),
('EEP850820921   ', 'e638e97883a0384ee8632223b49170c4', 'xxx@mail.com', '0000-00-00', 'ENVASES Y EMPAQUES DEL PACIFICO, S.A. DE C.V.', '207\r'),
('SAE971224AC5   ', '3b4260799a71c62e3b862e32ef2a7c2d', 'xxx@mail.com', '0000-00-00', 'SERVICIOS AGROAMBIENTALES Y ECOLOGICOS, S.A. DE C.V.', '212\r'),
('TVA990216GA7   ', 'a51cacd6ebee7bca2d2b0c03933b079f', 'xxx@mail.com', '0000-00-00', 'TRACTO DEL VALLE,S.A.DE C.V.', '213\r'),
('AVA921222SY9   ', 'ed3cbe836a671b842eeafda127227cb0', 'xxx@mail.com', '0000-00-00', 'AGRICOLA VALENZUELA,S.A. DE C.V.', '216\r'),
('GAL930104D23   ', '24055d2b0ff9a337165799b91444469c', 'xxx@mail.com', '0000-00-00', 'GRANERO EL ALHUATE,S.A.DE C.V.', '224\r'),
('AME97092056A   ', 'd52346a72e99e7f9af8a26d56fea96b3', 'xxx@mail.com', '0000-00-00', 'AGROBIOSOL DE MEXICO,S.A. DE C.V.', '227\r'),
('AFN120815HN8   ', '7ec744069bfc99f3aebae369d57fc304', 'xxx@mail.com', '0000-00-00', 'AGRODISTRIBUCIONES FITOSANITARIAS Y NUTRICIONALES, S.A. DE C.V.', '230\r'),
('SOEM6908232NA  ', '377ec2908b9515cf2e3b22fbf4bbec32', 'xxx@mail.com', '0000-00-00', 'MAURICIO JESUS SORIA ESCORZA', '239\r'),
('DERB660221MH7  ', '466d986d6b538e67f714265c9f6cb66c', 'xxx@mail.com', '0000-00-00', 'BRAULIA MARIA DELGADO RAMOS', '240\r'),
('SIN9508035F2   ', 'd8de9d8df0f7626befb626ba72b1107d', 'xxx@mail.com', '0000-00-00', 'SINALOAGUA, S.A. DE C.V.', '243\r'),
('GMM991105IS8   ', '89df7b9c0c1dc5cd6b4a6cc71bf28b27', 'xxx@mail.com', '0000-00-00', 'GRUPO MORSA DE MEXICO,S.A. DE C.V.', '245\r'),
('EPA880302G33   ', 'f38a9a20e27c87d1c9022d8ecc632787', 'xxx@mail.com', '0000-00-00', 'EXPORTADORA DE PLASTICOS AGRICOLAS S.A. DE C.V.', '248\r'),
('CMS0105101A9   ', '62086a7ed1962479e7bacaf2ea99565f', 'xxx@mail.com', '0000-00-00', 'COMERCIALIZADORES DE MATERIALES DE SINALOA,S.A. DE C.V.', '253\r'),
('MFC920123531   ', '0e08afd3ed8ea6c41715abb8001c3c8f', 'xxx@mail.com', '0000-00-00', 'MARTINEZ FRENOS Y CLUTCH, S.A. DE C.V.', '263\r'),
('APM040824HL3   ', '1edb5c856d335f76e7c06a724a613772', 'xxx@mail.com', '0000-00-00', 'ABS PROMOTORA DE MEXICO,S.A. DE C.V.', '283\r'),
('QPI860406QY5   ', '36121ff677b353c533e37c0c6272b7cd', 'xxx@mail.com', '0000-00-00', 'QUIMICA PIMA,S.A. DE C.V.', '285\r'),
('PLS8711306R7   ', '10fd44dfb3ece5be99cbe95c07ae0d07', 'xxx@mail.com', '0000-00-00', 'TEKNOVA DISTRIBUCIONES, S.A. DE C.V.', '288\r'),
('AQU800410SQ2   ', '03b190288ce8587d40a6cf65a21410e9', 'xxx@mail.com', '0000-00-00', 'AQUAFIM,S.A. DE C.V.', '291\r'),
('NMS940324RY6   ', '88c4c9eb360afa540d8fb63dc4272645', 'xxx@mail.com', '0000-00-00', 'NETAFIM MEXICO S.A. DE C.V.', '302\r'),
('HSI1207311V5   ', '44c6554485f1e5b23e197d417b9b8b39', 'xxx@mail.com', '0000-00-00', 'HORTISERVICIOS DE SINALOA, S.A. DE C.V.', '305\r'),
('CAD0910309W4   ', 'cfd182597239b03274d3d7859830c83b', 'xxx@mail.com', '0000-00-00', 'CADENAS AGRICOLAS DE CULIACAN S.A. DE C.V.', '309\r'),
('ICA8804284B1   ', 'd9cf7781a9f7d9b20cc111ec265a4ef4', 'xxx@mail.com', '0000-00-00', 'INDUSTRIAL COMERCIAL AGRICOLA DEL PACIFICO, S.A. DE C.V.              ', '311\r'),
('SOSJ4510069Q1  ', '1d677baac80a12ce2dc57d04751b9090', 'xxx@mail.com', '0000-00-00', 'JUAN DE DIOS SOLORZANO SARABIA', '319\r'),
('INZ0508097S5   ', '944e8d3356ab1400d814819d365efe42', 'xxx@mail.com', '0000-00-00', 'INZUMA, S.A. DE C.V.', '321\r'),
('VENB5809033A4  ', '54fcf89b4ad4b9fc3121e827637fb3eb', 'xxx@mail.com', '0000-00-00', 'BERTHA OLIVIA VEGA NU', '322\r'),
('MEZJ4911299J4  ', '3d5a4d9229c29570e046d66eeb1bebdc', 'xxx@mail.com', '0000-00-00', 'JAIME ANTONIO MEDINA ZAMORA', '335\r'),
('CMO980206566   ', '1dc1851f6648a57b6eca3817fbd8fd7b', 'xxx@mail.com', '0000-00-00', 'CULIACAN MOTORS, S.A. DE C.V.', '337\r'),
('JAE021010R31   ', 'd65ce7ce7ec17abe5af361d17ad3eb71', 'xxx@mail.com', '0000-00-00', 'JJ AEROPARTES S.A. DE C.V.', '351\r'),
('CAP090908E39   ', '3c644897327772882ceaa28991e6b3a1', 'xxx@mail.com', '0000-00-00', 'CERCAS Y ACCESORIOS DE PLASTICO, S.A. DE C.V.', '353\r'),
('SIA9309071A5   ', 'caa86a2f13aa59294c37717be94c2faa', 'xxx@mail.com', '0000-00-00', 'SEGURIDAD INDUSTRIAL AMIGO, S.A. DE C.V.', '358\r'),
('POR040121LI8   ', 'd7206ef1da0b2c72b4bec68eb0145ee3', 'xxx@mail.com', '0000-00-00', 'PREMIER DE ORIENTE  S. DE R.L.DE C.V.', '374\r'),
('FTZ840427B87   ', 'c24958e45ed5977066983a9f4f38a2df', 'xxx@mail.com', '0000-00-00', 'FERRETERA Y TORNILLERIA ZAPATA, S.A. DE C.V.', '375\r'),
('VDO030101596   ', '9984f3f1a1729a90600a346e2a594f77', 'xxx@mail.com', '0000-00-00', 'VITASERVICIOS DOKE, S.A. DE C.V.', '384\r'),
('AAIA6003114X6  ', 'd1f7294f70a21a0afc96820936467165', 'xxx@mail.com', '0000-00-00', 'ARTURO ARAMBURO IZABAL', '392\r'),
('ENA940701IC4   ', '3afa866621512d12c58396979b19c291', 'xxx@mail.com', '0000-00-00', 'EURO NOVEDADES AGRICOLAS, S.A. DE C.V.', '393\r'),
('IVA790625F53   ', '7eec219ce099c9fc8b3be6b529e78c0b', 'xxx@mail.com', '0000-00-00', 'INDUSTRIAS VAZQUEZ, S.A DE C.V', '399\r'),
('TVN7407019H3   ', '56f3da39f9278bff0a4ec4df99dbe52b', 'xxx@mail.com', '0000-00-00', 'TUBERIAS Y VALVULAS DEL NOROESTE, S.A. DE C.V.', '401\r'),
('FALE441106AQ5  ', '48df7eac8cad7c422e3bc6df56b19eb7', 'xxx@mail.com', '0000-00-00', 'LEONARDO FAJARDO ', '410\r'),
('ASE9501179N5   ', 'a626b3236f96c45fb7d3b59861f820b8', 'xxx@mail.com', '0000-00-00', 'AGRICOLA DE SERVICIOS, S.A. DE C.V.', '414\r'),
('EEI111227484   ', 'b8d482d2a234d99e75658c4b571dda83', 'xxx@mail.com', '0000-00-00', 'EQUIPOS E INNOVACION PARA AGRICULTURA Y CONSTRUCCION, S.A. C.V.', '415\r'),
('GFS130321ER7   ', 'c20a091ea6d47d06181cd61586a00ae9', 'xxx@mail.com', '0000-00-00', 'GRUINDAG FOOD SOLUTIONS, S.A. DE C.V.', '416\r'),
('CSO680801P93   ', '1fb9f663116e554a423efbc3b54ff324', 'xxx@mail.com', '0000-00-00', 'CASA SOMMER S.A DE C.V.', '429\r'),
('COLR620509G63  ', 'ebdd6e0258bd08abb125d53863d0e713', 'xxx@mail.com', '0000-00-00', 'RAUL CORONADO LEPRO', '440\r'),
('AEEJ640703JC6  ', 'c2f446aa73fff7d6bb16ef78977634ad', 'xxx@mail.com', '0000-00-00', 'JOSEFINA MARIA AMEZCUA ESPINO', '441\r'),
('HTR0702164I1   ', '962ba76e8af850f2b4cb8e70e2257e8c', 'xxx@mail.com', '0000-00-00', 'HEAVY TRUCKS REFACCIONES,S.A. DE C.V.', '442\r'),
('HMC870105CF9   ', 'd3403ad317210cd3aae2772822d186b7', 'xxx@mail.com', '0000-00-00', 'HERRAMIENTAS DE MANO EL CUERVO,S.A. DE C.V.', '445\r'),
('LAB000502FU2   ', '885c1b4063f7fa757e8ef6a462b42c45', 'xxx@mail.com', '0000-00-00', 'LABELPACK,S.A. DE C.V.', '448\r'),
('OSL011217B48   ', '3b5f2cd25d669d0e55b3d65e68df4816', 'xxx@mail.com', '0000-00-00', 'OLEFINAS S.L.P., S.A. DE C.V.', '451\r'),
('EMM7507127Z2   ', '246416e1058eb734058de2b5813b6346', 'xxx@mail.com', '0000-00-00', 'EMPRESA MEXICANA DE MANUFACTURAS,S.A.DE C.V.', '453\r'),
('AHP040213RX4   ', '6d847c8f3a93a0374c26b7c254983cbb', 'xxx@mail.com', '0000-00-00', 'AGROINSUMOS HORTICOLAS DEL PACIFICO,S.A.DE C.V.', '454\r'),
('IMP980515NF9   ', 'fa8a3c98f7641f43ce19c77bc0b8239e', 'xxx@mail.com', '0000-00-00', 'INVERNADEROS MEXICANOS DEL PACIFICO,S.A.DE C.V.', '455\r'),
('DUC860103HY7   ', 'bdc82c8d22cff49c5614dd7462e86c0e', 'xxx@mail.com', '0000-00-00', 'DUCORAGRO,S.A. DE C.V.', '459\r'),
('PNO020114AT1   ', '8e37e230f456c1d0deeadfaf5f17a320', 'xxx@mail.com', '0000-00-00', 'PROBIOTICOS DEL NOROESTE,S.A. DE C.V.', '461\r'),
('PCE6310158U4   ', '0df2388cbea2596d23f252b072b89e98', 'xxx@mail.com', '0000-00-00', 'PREMIER CHEVROLET,S.A. DE C.V.', '463\r'),
('TOZA621227D79  ', 'd700cef7ed0ae03f7c02d60a3359c3d4', 'xxx@mail.com', '0000-00-00', 'ALFONSO TORRES ZAZUETA', '465\r'),
('BINB550514J17  ', '08030f5157e48ac9925de5fab95f49dd', 'xxx@mail.com', '0000-00-00', 'BEATRIZ EUGENIA BRIBIESCA NORIEGA', '469\r'),
('AGR981105MI5   ', 'a926ce0f0ba765c1554d3977146adcaa', 'xxx@mail.com', '0000-00-00', 'AGRACOM S.A. DE C.V.', '471\r'),
('HID0812301T3   ', 'ab4a55934afc4638cfe8e049e33d3c90', 'xxx@mail.com', '0000-00-00', 'HIDROVANS S.A DE C.V.', '477\r'),
('SASM8704182E6  ', '491750bfff5d96b46a38b4ca0773a14e', 'xxx@mail.com', '0000-00-00', 'MIGUEL ANGEL SAHAGUN SANCHEZ', '479\r'),
('FIRN770713FP8  ', '60412bfac10db65045a44bc6133ae91d', 'xxx@mail.com', '0000-00-00', 'NAZARIO FRIAS RAMOS', '480\r'),
('MAG0710313R4   ', '30d0a0d2d30663be2dd2d998d4a7c85b', 'xxx@mail.com', '0000-00-00', 'MAF AGROBOTICA,S.A. DE C.V.', '492\r'),
('CIU040719JP7   ', '759e8c62e446db5ddbe12c036f7ec905', 'xxx@mail.com', '0000-00-00', 'CORPORACION INDUSTRIAL URUAPAN, S.A. DE C.V.', '500\r'),
('AALM610422866  ', '20ace76182d87bc5bef5816b9a349b0f', 'xxx@mail.com', '0000-00-00', 'MANUEL DE JESUS ALVAREZ LIZARRAGA', '517\r'),
('CASG821212RR8  ', '4ea0ad71f48cf63e410b693e3392bf8a', 'xxx@mail.com', '0000-00-00', 'GUADALUPE CARRASCO SANCHEZ', '582\r'),
('ASP600721PX5   ', '615edd573753bcd0fd17bce909e5fcf0', 'xxx@mail.com', '0000-00-00', 'ACERO SUECO PALME, S.A.P.I DE C.V.', '593\r'),
('SUM010525IF9   ', '4ecf46b891c23c3bcf058aceb5c89297', 'xxx@mail.com', '0000-00-00', 'SUMILAB S.A. DE C.V.', '751\r'),
('MEDC4811011Q0  ', '98a43398d991f1a65f69f804e830524b', 'xxx@mail.com', '0000-00-00', 'CASTULO MENDEZ DELGADO', '762\r'),
('SAG1208013Z8   ', 'e96f5869e4a0962d5d3d7097b61a2743', 'xxx@mail.com', '0000-00-00', 'SUKARNE AGROINDUSTRIAL, S.A. DE C.V.', '802\r'),
('OAL1206155C6   ', 'ee3f39db1e13d6ee3714d20fc169c5bc', 'xxx@mail.com', '0000-00-00', 'OG ALLEY, S.A. DE C.V.', '803\r'),
('AEGE6507158W4  ', 'b12f1e9c4383b6383e09d2f67e05f761', 'xxx@mail.com', '0000-00-00', 'ENRIQUE ARMENTA GALVEZ', '806\r'),
('HME080808SB0   ', '0e360a1fd2e12cbcbdc4ae68dcad2188', 'xxx@mail.com', '0000-00-00', 'HYDROFLOW DE MEXICO, S. DE R.L. DE C.V.', '808\r'),
('ROBG450618VC7  ', 'a07a0889602c6dc85c1e85770bb9a1d3', 'xxx@mail.com', '0000-00-00', 'GILBERTO ROJO BURGOS', '810\r'),
('DOCJ830612PH8  ', '7180302ecd1fb34d51e5fd63b2b88ca7', 'xxx@mail.com', '0000-00-00', 'JESSICA DOREYDA DORAME COLORES', '812\r'),
('ACA0111059H0   ', 'c394047b04c9b3b969eae5068c22cf9e', 'xxx@mail.com', '0000-00-00', 'ACEROS CABOS, S.A. DE C.V.', '813\r'),
('INV140508KLA   ', 'd3a7d80842a2f0d460626b3249a52d40', 'xxx@mail.com', '0000-00-00', 'INVERGROW, S.A. DE C.V.', '814\r'),
('GAGP890709II2  ', '2bf7de348c1ca47f5e292c3765ea6c8e', 'xxx@mail.com', '0000-00-00', 'PAMELA GARCIA GAMEZ', '827\r'),
('MRE880929US4   ', 'a08892ca2d1ed919d5d3fbd669b74516', 'xxx@mail.com', '0000-00-00', 'MOTO RED S.A. DE C.V.', '828\r'),
('MAG0710313R4   ', '30d0a0d2d30663be2dd2d998d4a7c85b', 'xxx@mail.com', '0000-00-00', 'MAF AGROBOTICA, S.A. DE C.V.', '924\r'),
('NAT120119CW1   ', '73a625158a6861827c6591efca72b23e', 'xxx@mail.com', '0000-00-00', 'NATURALGROW S.A.P.I. DE C.V.', '926\r'),
('HYD120201I11   ', '8ac43d90f090907be4c8f880f531d384', 'xxx@mail.com', '0000-00-00', 'HYDROPRO, S.A. DE C.V.', '934\r'),
('GAAJ640323MP8  ', '33f25a700a7273eab380e8ecb05307bb', 'xxx@mail.com', '0000-00-00', 'JUAN PABLO GAMEZ ACOSTA', '991\r'),
('SME090609HK6   ', '60aad178519a2067626aa9c252341b7d', 'xxx@mail.com', '0000-00-00', 'SUPERA DE MEXICO, S. DE R.L. DE C.V.', '1006\r'),
('AOC900115QH9   ', 'edd1b36ff69d69c9925c10aa042c7b41', 'xxx@mail.com', '0000-00-00', 'ALTATEC DE OCCIDENTE S.A. DE C.V.', '1032\r'),
('GAAF611125R8A  ', '5212aeac18bcffcfbab69925eba0dfaa', 'xxx@mail.com', '0000-00-00', 'FEDERICO GAMBOA AGUIRRE', '1101\r'),
('TOM111206UK0   ', '5c6ed5d9440f5b52f56d2eb472e0d7c5', 'xxx@mail.com', '0000-00-00', 'TOMPAK, S.A. DE C.V.', '1129\r'),
('MSO8511154B9   ', 'aa5d6ee7870ee06fb069a37e56eadd79', 'xxx@mail.com', '0000-00-00', 'MANTENIMIENTO Y SERVICIO PARA OFICINAS, S.A. DE C.V.', '1131\r'),
('SSL090331VC8   ', '0194b6658b07234f6c22ecf99b52de24', 'xxx@mail.com', '0000-00-00', 'SOLUCIONES DE SANIDAD Y LIMPIEZA S.A. DE C.V.', '1152\r'),
('SAVV500201JU4  ', '8ed749a242dd058887069ef12e452d08', 'xxx@mail.com', '0000-00-00', 'VICTORIA GUADALUPE SANTILLAN VILLEGAS', '1157\r'),
('UUCJ8902029K3  ', '8a2406bab4e3b271bddd5c31fc462523', 'xxx@mail.com', '0000-00-00', 'JORGE RAUL URTUSUASTEGUI CASTILLA', '1243\r'),
('RILL810825AW1  ', 'd21421e6d3bd30ac58adcf0517335191', 'xxx@mail.com', '0000-00-00', 'LUIS MACARIO RIVERA LUGO', '1246\r'),
('RORM8103037U1  ', 'f2d8759300cb25dfa5d376bea99ce6f1', 'xxx@mail.com', '0000-00-00', 'JOSE MANUEL RODRIGUEZ REYES', '1247\r'),
('AULR770705AY4  ', '487788246e3980c192bc33c120e2d45e', 'xxx@mail.com', '0000-00-00', 'RAFAEL AGUIRRE LUGO', '1434\r'),
('CPA010503C54   ', '976609f040db1e1d3370f45c02afbc5f', 'xxx@mail.com', '0000-00-00', 'CONTRAPESOS Y PARCHES S.A. DE .C.V.', '1487\r'),
('PIA9606262D9   ', '6b1206ea2aa078efa19adf3832c4057f', 'xxx@mail.com', '0000-00-00', 'PROVEEDORA DE INSUMOS AGROPECUARIOS Y SERVICIOS, S.A. DE C.V.', '1506\r'),
('EPA100115KI6   ', 'b66a7c71c403592d16a408a90f7e6de0', 'xxx@mail.com', '0000-00-00', 'EQUIPOS Y PARTES DE ASPERSION,S.A. DE C.V.', '1547\r'),
('ISC101217290   ', 'cb63b9d2d5675dbcc66fcbbda3722799', 'xxx@mail.com', '0000-00-00', 'IMPREGNADORA Y SECADORA CARVAJAL S.A. DE C.V.', '1583\r'),
('NMU930618PF0   ', '5e24039b0153707eca98920d58be37a7', 'xxx@mail.com', '0000-00-00', 'NEUMATICOS MUEVETIERRA, S.A. DE C.V.', '1687\r'),
('EIRJ580510EJ2  ', '0f1ad46167e64d277a3e2e912903addb', 'xxx@mail.com', '0000-00-00', 'JUAN JOSE ESPINOZA RODRIGUEZ', '1697\r'),
('PEML530825CYA  ', 'eacd89c57d4a33af22dbecdd7e629313', 'xxx@mail.com', '0000-00-00', 'JOSE LUIS PEREZ MACIAS', '1719\r'),
('ATR1009013F3   ', '326becbf174f7c83984e35e614e7273e', 'xxx@mail.com', '0000-00-00', 'ASPERSORAS Y TRACTORES, S.A. DE C.V.', '1755\r'),
('PRO120323348   ', '0200bd4850c187ad3e132af1333dc83a', 'xxx@mail.com', '0000-00-00', 'PROSIPSA, S.A. DE C.V.', '1772\r'),
('ACA831202EQ4   ', '23d7b64386feecb831dae85f6b9833c1', 'xxx@mail.com', '0000-00-00', 'ALMACENES CAMARENA S.A.DE C.V.', '1813\r'),
('ECO910208EQ5   ', 'b9d9e509e7851184baa21e7ded0ca7ee', 'xxx@mail.com', '0000-00-00', 'ECO COMERCIAL, S.A DE C.V.', '1885\r'),
('AGS630109U15   ', 'c0466f64a4667e8e0b4015c9121db913', 'xxx@mail.com', '0000-00-00', 'ARTES GRAFICAS SINALOENSES, S.A. DE C.V.', '1978\r'),
('POO1002168N3   ', 'c70c7a7016f3d6020f867486cfbd40f0', 'xxx@mail.com', '0000-00-00', 'PAPEL ORO OPB, S.A. DE C.V.', '1987\r'),
('SEAM630530RN5  ', '0e505daafbc00b07892942cd012187eb', 'xxx@mail.com', '0000-00-00', 'MARCO ANTONIO SERNA ALMENDAREZ', '2000\r'),
('TOSJ560816LX7  ', '9b06cea08ff1a829cea1c7210dd69f11', 'xxx@mail.com', '0000-00-00', 'JOSE DE JESUS TOPETE SOTOMAYOR', '2004\r'),
('SEAJ691003ID8  ', '04cc49fd3299a456935089f7334b0418', 'xxx@mail.com', '0000-00-00', 'JUAN JOSE SERNA ALMENDAREZ', '2005\r'),
('DESS551031EU5  ', '95afdff343dadb03e5571400eaf23825', 'xxx@mail.com', '0000-00-00', 'SALVADOR DELGADILLO SOTO', '2006\r'),
('CURC830905PW6  ', '398d365b17d3855931f2b7c04864d962', 'xxx@mail.com', '0000-00-00', 'CARITINA CRUZ ROCHA', '2010\r'),
('GOMH810413A82  ', 'bd0bb0a77176e138e1896f8527dc2958', 'xxx@mail.com', '0000-00-00', 'HERMES OMAR GOMEZ MONSIVAIS', '2014\r'),
('KIM860826ND5   ', 'eadc33929173689495e145e3db4804b3', 'xxx@mail.com', '0000-00-00', 'KIMPEN, S.A. DE C.V.', '2017\r'),
('OHI0610041G0   ', 'aa7dc14a64a69827c533d7ac6109dc59', 'xxx@mail.com', '0000-00-00', 'OPERADORA DE HIGIENE, S.A. DE C.V.', '2018\r'),
('EOTJ911216MC3  ', 'e4445757921d995286c18faa4419cd40', 'xxx@mail.com', '0000-00-00', 'JORGE ARMANDO ESCOBEDO TORRES', '2023\r'),
('VAGT8712291Q3  ', '14438f1d382424a9ceb95b8e65248818', 'xxx@mail.com', '0000-00-00', 'TOMAS VAZQUEZ GOMEZ', '2024\r'),
('MORC9010095V4  ', '2cedbf36a64af2e5f498ddf79a55fc29', 'xxx@mail.com', '0000-00-00', 'CARLOS EDUARDO MORENO RODRIGUEZ', '2027\r'),
('CACC610101PW4  ', 'e8712433e13731d32e447461090c1046', 'xxx@mail.com', '0000-00-00', 'MA. CARMEN CASTILLO CASTILLO', '2032\r'),
('MEVL740730A28  ', 'b00506c505f864d1bb341ad15de856bc', 'xxx@mail.com', '0000-00-00', 'LETICIA MEDRANO VAZQUEZ', '2033\r'),
('IAL970412QI1   ', '7af09dab9e4e382c049853495c0a5911', 'xxx@mail.com', '0000-00-00', 'IMPULSORA DE ALTURA, S.A. DE C.V.', '2036\r'),
('IPR100625NR0   ', '86ca8ed4e99b8a3b16e08945a9ea0b45', 'xxx@mail.com', '0000-00-00', 'IRRIGACION PRODUCTIVA,S.A. DE C.V. ', '2044\r'),
('VASS571123928  ', '272cf96e7e5df24626aeae020c527d6b', 'xxx@mail.com', '0000-00-00', 'SERGIO VALENZUELA SALAZAR', '2054\r'),
('AALO590421TN1  ', '845013d43e776ad8d56fc55889fa71fa', 'xxx@mail.com', '0000-00-00', 'OCTAVIO ALVAREZ LOPEZ', '2064\r'),
('REH090427I7A   ', 'ec8e8c9d2d7854e44624fdf71045fdcc', 'xxx@mail.com', '0000-00-00', 'RIEGOS E HIDRAULICA DE MEXICO S.A DE C.V', '2147\r'),
('TNO880601NJ1   ', 'fd35b31c1d20c46e96a09d480207f38c', 'xxx@mail.com', '0000-00-00', 'TELECOMUNICACIONES DEL NOROESTE S.A. DE C.V.', '2237\r'),
('ADR990125954   ', 'ba2d4872569f5526bb8c17af04d888d8', 'xxx@mail.com', '0000-00-00', 'AGRO-DREN S.A. DE C.V.', '2238\r'),
('MPA040507U22   ', '07f63a03dc43a1c12bbf71f0c3c91fc6', 'xxx@mail.com', '0000-00-00', 'MG PARTS, S.A DE C.V.', '2260\r'),
('NEN1201303M3   ', 'abc80a01ade7682ce97c093331ce9407', 'xxx@mail.com', '0000-00-00', 'NATURAL ENVISION, S.A. DE C.V.', '2389\r'),
('PCN920813AD2   ', '546594a258fc69e1505257f5ef3c85f1', 'xxx@mail.com', '0000-00-00', 'PINTURAS CALZADA DEL NOROESTE S.A. DE C.V.', '2480\r'),
('THU8606106V3   ', 'c77be67e9af122b52807d78ab43bd552', 'xxx@mail.com', '0000-00-00', 'TAPICES DEL HUMAYA, S.A. DE C.V.', '2720\r'),
('KMO040517P6A   ', '254d6a2c3fc91dff4f43af6cb0b969fa', 'xxx@mail.com', '0000-00-00', 'KARGO MONTACARGAS, S. DE R.L. DE C.V.', '2746\r'),
('TTA920401JD6   ', 'ea0b222c75f621608214a1aecb05c0e3', 'xxx@mail.com', '0000-00-00', 'TODO PARA LA TAPICERIA S.A. DE C.V.', '2821\r'),
('TSR101202GY1   ', '6981ccf3ccfa2b4c9c8eca39c4bdbbd9', 'xxx@mail.com', '0000-00-00', 'THERMO SERVICIOS REFRIGERACION DE SINALOA S.A. DE C.V', '2900\r'),
('AAL921006988   ', '308e4e487a6d5d7d57945922c2a0c881', 'xxx@mail.com', '0000-00-00', 'AGROALDIME, S. A. DE C. V.', '3000\r'),
('CACL7202207U1  ', 'a715dea7d4c307662cd610fa90d62ded', 'xxx@mail.com', '0000-00-00', 'LUIS CARMONA CLAVERAN', '3180\r'),
('CSG0208218E9   ', '91c07bf1a2482d77d0639a3b8638a7c1', 'xxx@mail.com', '0000-00-00', 'CASTIL SERVICIOS Y GARANTIAS S.A. DE C.V.', '3588\r'),
('CAN850110NR8   ', '6fb60f97954f4e35e21f061d2dc106a9', 'xxx@mail.com', '0000-00-00', 'COMERCIAL AUTOMOTRIZ DEL NOROESTE,S.A. DE C.V.', '3615\r'),
('GAMC670926UK2  ', '2850e9966972037d08909cb87c09a1d4', 'xxx@mail.com', '0000-00-00', 'CIPRIANO GALVEZ MADRID', '3701\r'),
('CES020718D58   ', 'a0331f52e6df58c1de9e8e236f05eebf', 'xxx@mail.com', '0000-00-00', 'COMPONENTES ELECTRONICOS DE SINALOA S.A. DE C.V', '3702\r'),
('ABE100413EG4   ', 'b24ef6d8cfc8ab4316060ca652690054', 'xxx@mail.com', '0000-00-00', 'AERONAUTICA BENITEZ S.A. DE C.V.', '3755\r'),
('KBO101221N58   ', '188b7572daf0c6862d2f057c8b305214', 'xxx@mail.com', '0000-00-00', 'KURODA BOMBAS S.A.P.I. DE C.V.', '3794\r'),
('LOFE440501AK6  ', '78a06e953d5c87f0a41f39e8d96139a0', 'xxx@mail.com', '0000-00-00', 'FELIPA LOPEZ ', '3821\r'),
('SAN990621LL8   ', 'cf2c42d7b0de3e901e420ca8b8ad01d9', 'xxx@mail.com', '0000-00-00', 'SANITEK S.A. DE C.V.', '3868\r'),
('ROMF581116QA1  ', '05ca158a2979508b26a29802f3a1bbd8', 'xxx@mail.com', '0000-00-00', 'FIDENCIO ROSALES MERCADO', '3873\r'),
('CAAM820914F86  ', '5260c1de2820730e2cc9e12e8d93287b', 'xxx@mail.com', '0000-00-00', 'MARCO ANTONIO CARDENAS ARMENTA', '3876\r'),
('DIM1207131N0   ', '0432a32707662dca0a5fa0f905571713', 'xxx@mail.com', '0000-00-00', 'DELTATRAK INTERNACIONAL M', '3909\r');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
