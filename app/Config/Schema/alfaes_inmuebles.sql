-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2013 a las 12:44:50
-- Versión del servidor: 5.6.11
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `alfaes_inmuebles`
--
CREATE DATABASE IF NOT EXISTS `alfaes_inmuebles` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `alfaes_inmuebles`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencias`
--

CREATE TABLE IF NOT EXISTS `agencias` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `oficina` varchar(30) NOT NULL,
  `cif` varchar(100) NOT NULL,
  `nombre_calle` varchar(255) NOT NULL,
  `poblacion_id` varchar(36) NOT NULL,
  `provincia_id` varchar(36) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email_contacto` varchar(100) DEFAULT NULL,
  `nombre_contacto` varchar(100) DEFAULT NULL,
  `numero_calle` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poblacion` (`poblacion_id`),
  KEY `provincia` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `agencias`
--

INSERT INTO `agencias` (`id`, `oficina`, `cif`, `nombre_calle`, `poblacion_id`, `provincia_id`, `codigo_postal`, `telefono`, `fax`, `email_contacto`, `nombre_contacto`, `numero_calle`) VALUES
(1, 'Alfa Central', 'A- 81565400', 'C/ Palos de la Frontera, 4 - 1', '25000', '28', '28012', '915191319', '', 'info@iaalfa.es', 'David Monje', 0),
(2, 'Demo0002', '000000', '', '25000', '28', '00000', NULL, NULL, NULL, NULL, 0),
(3, 'Demo0003', '000000', '', '25000', '28', '00000', NULL, NULL, NULL, NULL, 0),
(4, 'Demo0004', '000000', '', '25000', '28', '00000', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chalets`
--

CREATE TABLE IF NOT EXISTS `chalets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inmueble_id` int(10) NOT NULL,
  `tipo_chalet_id` char(2) DEFAULT NULL,
  `urbanizacion` varchar(50) DEFAULT NULL,
  `numero_habitaciones` decimal(2,0) DEFAULT NULL,
  `numero_banos` decimal(2,0) DEFAULT NULL,
  `area_total` decimal(5,0) DEFAULT NULL,
  `area_salon` decimal(5,0) DEFAULT NULL,
  `gastos_comunidad` decimal(5,0) DEFAULT NULL,
  `numero_armarios` decimal(2,0) DEFAULT NULL,
  `area_terraza` decimal(3,0) DEFAULT NULL,
  `area_parcela` decimal(6,0) DEFAULT NULL,
  `plazas_parking` decimal(2,0) DEFAULT NULL,
  `estado_conservacion_id` char(2) DEFAULT NULL,
  `tipo_calefaccion_id` char(2) DEFAULT NULL,
  `tipo_agua_caliente_id` char(2) DEFAULT NULL,
  `antiguedad_edificio` char(2) DEFAULT NULL,
  `opcion_compra` char(1) DEFAULT NULL,
  `tipo_aa_id` char(2) DEFAULT NULL,
  `interior_exterior_id` char(2) DEFAULT NULL,
  `tipo_orientacion_id` char(2) DEFAULT NULL,
  `tipo_equipamiento_id` char(2) DEFAULT NULL,
  `tipo_suelo_id` char(2) DEFAULT NULL,
  `con_tendedero` char(2) DEFAULT NULL,
  `con_ascensor` char(1) DEFAULT NULL,
  `con_piscina` char(1) DEFAULT NULL,
  `con_areas_verdes` char(1) DEFAULT NULL,
  `con_conserje` char(1) DEFAULT NULL,
  `con_trastero` char(1) DEFAULT NULL,
  `con_puerta_seguridad` char(1) DEFAULT NULL,
  `con_alarma` char(1) DEFAULT NULL,
  `con_tenis` char(1) DEFAULT NULL,
  `con_squash` char(1) DEFAULT NULL,
  `con_futbol` char(1) DEFAULT NULL,
  `con_baloncesto` char(1) DEFAULT NULL,
  `con_gimnasio` char(1) DEFAULT NULL,
  `con_padel` char(1) DEFAULT NULL,
  `con_golf` char(1) DEFAULT NULL,
  `calificacion_energetica_id` char(2) DEFAULT NULL,
  `indice_energetico` decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `garajes`
--

CREATE TABLE IF NOT EXISTS `garajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inmueble_id` int(10) NOT NULL,
  `tipo_garaje_id` char(2) DEFAULT NULL,
  `estado_conservacion_id` char(2) DEFAULT NULL,
  `numero_plaza` decimal(2,0) DEFAULT NULL,
  `area_total` decimal(5,0) DEFAULT NULL,
  `gastos_comunidad` decimal(5,0) DEFAULT NULL,
  `opcion_compra` char(1) DEFAULT NULL,
  `plaza_cubierta` char(1) DEFAULT NULL,
  `plaza_doble` char(1) DEFAULT NULL,
  `con_ascensor` char(1) DEFAULT NULL,
  `con_puerta_automatica` char(1) DEFAULT NULL,
  `con_camaras_seguridad` char(1) DEFAULT NULL,
  `con_personal_seguridad` char(1) DEFAULT NULL,
  `con_alarma` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_inmueble_id` int(10) NOT NULL,
  `url_imagen` varchar(120) NOT NULL,
  `tipo_imagen_id` char(2) NOT NULL,
  `descripcion_imagen` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmuebles`
--

CREATE TABLE IF NOT EXISTS `inmuebles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `propiedad_id` char(10) NOT NULL,
  `tipo_inmueble_id` char(1) NOT NULL,
  `tipo_operacion_id` char(1) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `agencia_id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `pais_id` int(11) NOT NULL,
  `coord_x` float(12,9) DEFAULT NULL,
  `coord_y` varchar(12) DEFAULT NULL,
  `nombre_calle` varchar(150) DEFAULT NULL,
  `numero_calle` smallint(6) NOT NULL,
  `codigo_postal` varchar(5) DEFAULT NULL,
  `localidad` varchar(75) DEFAULT NULL,
  `nombre_contacto` varchar(50) DEFAULT NULL,
  `email_contacto` varchar(100) DEFAULT NULL,
  `telefono1_contacto` varchar(12) DEFAULT NULL,
  `telefono2_contacto` varchar(12) DEFAULT NULL,
  `horario_contacto` char(2) DEFAULT NULL,
  `tipo_contrato` char(2) DEFAULT NULL,
  `medio_captacion` char(2) DEFAULT NULL,
  `fecha_captacion` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL,
  `motivo_baja` char(2) DEFAULT NULL,
  `llaves` char(1) DEFAULT NULL,
  `ref_catastral` char(20) DEFAULT NULL,
  `registro_de` varchar(32) DEFAULT NULL,
  `registro_numero` decimal(4,0) DEFAULT NULL,
  `registro_tomo` decimal(4,0) DEFAULT NULL,
  `registro_finca` decimal(6,0) DEFAULT NULL,
  `registro_folio` decimal(4,0) DEFAULT NULL,
  `honorarios` decimal(7,2) DEFAULT NULL,
  `comision` decimal(7,2) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`propiedad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inmueble_id` int(10) NOT NULL,
  `tipo_local_id` char(2) DEFAULT NULL,
  `bloque` varchar(15) DEFAULT NULL,
  `urbanizacion` varchar(50) NOT NULL,
  `estado_conservacion_id` char(2) DEFAULT NULL,
  `numero_aseos` decimal(2,0) DEFAULT NULL,
  `area_total` decimal(5,0) DEFAULT NULL,
  `area_salon` decimal(5,0) DEFAULT NULL,
  `ultima_actividad` varchar(50) DEFAULT NULL,
  `plantas_edificio` decimal(2,0) DEFAULT NULL,
  `gastos_comunidad` decimal(5,0) DEFAULT NULL,
  `numero_habitaciones` char(3) DEFAULT NULL,
  `antiguedad_edificio` char(2) DEFAULT NULL,
  `longitud_fachada` char(2) DEFAULT NULL,
  `opcion_compra` char(1) DEFAULT NULL,
  `tipo_calefaccion_id` char(2) DEFAULT NULL,
  `tipo_agua_caliente_id` char(2) DEFAULT NULL,
  `tipo_aa_id` char(2) DEFAULT NULL,
  `localizacion_local_id` char(2) DEFAULT NULL,
  `tipo_suelo_id` char(2) DEFAULT NULL,
  `con_salida_humos` char(1) DEFAULT NULL,
  `con_almacen` char(1) DEFAULT NULL,
  `con_cocina_equipada` char(1) DEFAULT NULL,
  `con_puerta_seguridad` char(1) DEFAULT NULL,
  `con_camaras_seguridad` char(1) DEFAULT NULL,
  `con_alarma` char(1) DEFAULT NULL,
  `calificacion_energetica_id` char(2) DEFAULT NULL,
  `indice_energetico` decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficinas`
--

CREATE TABLE IF NOT EXISTS `oficinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inmueble_id` char(10) NOT NULL,
  `tipo_oficina_id` char(2) NOT NULL,
  `bloque` varchar(15) DEFAULT NULL,
  `escalera` varchar(4) DEFAULT NULL,
  `piso` char(3) DEFAULT NULL,
  `puerta` varchar(4) DEFAULT NULL,
  `urbanizacion` varchar(50) DEFAULT NULL,
  `numero_banos` decimal(2,0) DEFAULT NULL,
  `area_total` decimal(5,0) DEFAULT NULL,
  `area_salon` decimal(5,0) DEFAULT NULL,
  `gastos_comunudad` decimal(5,0) DEFAULT NULL,
  `numero_ascensores` decimal(2,0) DEFAULT NULL,
  `altura_edificio` decimal(2,0) DEFAULT NULL,
  `plazas_parking` decimal(2,0) DEFAULT NULL,
  `numero_habitaciones` char(2) DEFAULT NULL,
  `estado_conservacion_id` char(2) DEFAULT NULL,
  `tipo_calefaccion_id` char(2) DEFAULT NULL,
  `tipo_agua_caliente_id` char(2) DEFAULT NULL,
  `antiguedad_edificio` char(2) DEFAULT NULL,
  `tipo_aa_id` char(2) DEFAULT NULL,
  `interior_exterior_id` char(2) DEFAULT NULL,
  `tipo_orientacion_id` char(2) DEFAULT NULL,
  `tipo_suelo_id` char(2) DEFAULT NULL,
  `tipo_cableado_id` char(2) DEFAULT NULL,
  `opcion_compra` char(1) DEFAULT NULL,
  `con_almacen` char(1) DEFAULT NULL,
  `con_zona_carga_descarga` char(1) DEFAULT NULL,
  `con_puerta_seguridad` char(1) DEFAULT NULL,
  `con_camaras_seguridad` char(1) DEFAULT NULL,
  `con_alarma` char(1) DEFAULT NULL,
  `con_instalaciones_deportivas` char(1) DEFAULT NULL,
  `calificacion_energetica_id` char(2) DEFAULT NULL,
  `indice_energetico` decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(10) NOT NULL,
  `pais` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `pais`) VALUES
(34, 'España');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pisos`
--

CREATE TABLE IF NOT EXISTS `pisos` (
  `id` int(11) NOT NULL,
  `inmueble_id` int(10) NOT NULL,
  `es_duplex` char(1) NOT NULL,
  `es_atico` char(1) NOT NULL,
  `es_estudio` char(1) NOT NULL,
  `es_ultimo_piso` char(1) DEFAULT NULL,
  `bloque` varchar(15) DEFAULT NULL,
  `escalera` varchar(4) DEFAULT NULL,
  `piso` char(3) DEFAULT NULL,
  `puerta` varchar(4) DEFAULT NULL,
  `urbanizacion` varchar(50) DEFAULT NULL,
  `estado_conservacion_id` char(2) DEFAULT NULL,
  `numero_habitaciones` decimal(2,0) DEFAULT NULL,
  `numero_banos` decimal(2,0) DEFAULT NULL,
  `area_total` decimal(5,0) DEFAULT NULL,
  `area_salon` decimal(5,0) DEFAULT NULL,
  `gastos_comunidad` decimal(5,0) DEFAULT NULL,
  `numero_armarios` decimal(2,0) DEFAULT NULL,
  `area_terraza` decimal(3,0) DEFAULT NULL,
  `plazas_parking` decimal(2,0) DEFAULT NULL,
  `tipo_calefaccion_id` char(2) DEFAULT NULL,
  `tipo_agua_caliente_id` char(2) DEFAULT NULL,
  `antiguedad_edificio` char(2) DEFAULT NULL,
  `tipo_aa_id` char(2) DEFAULT NULL,
  `interior_exterior_id` char(2) DEFAULT NULL,
  `tipo_orientacion_id` char(2) DEFAULT NULL,
  `tipo_equipamiento_id` char(2) DEFAULT NULL,
  `tipo_suelo_id` char(2) DEFAULT NULL,
  `tipo_tendedero_id` char(2) DEFAULT NULL,
  `opcion_compra` char(1) DEFAULT NULL,
  `con_ascensor` char(1) DEFAULT NULL,
  `con_piscina` char(1) DEFAULT NULL,
  `con_areas_verdes` char(1) DEFAULT NULL,
  `con_coserje` char(1) DEFAULT NULL,
  `con_trastero` char(1) DEFAULT NULL,
  `con_puerta_seguridad` char(1) DEFAULT NULL,
  `con_alarma` char(1) DEFAULT NULL,
  `con_tenis` char(1) DEFAULT NULL,
  `con_squash` char(1) DEFAULT NULL,
  `con_futbol` char(1) DEFAULT NULL,
  `con_baloncesto` char(1) DEFAULT NULL,
  `con_gimnasio` char(1) DEFAULT NULL,
  `con_padel` char(1) DEFAULT NULL,
  `con_golf` char(1) DEFAULT NULL,
  `calificacion_energetica_id` char(2) DEFAULT NULL,
  `indice_energetico` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poblaciones`
--

CREATE TABLE IF NOT EXISTS `poblaciones` (
  `id` int(10) NOT NULL,
  `poblacion` varchar(50) NOT NULL DEFAULT '',
  `provincia_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `provincia_id` (`provincia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `poblaciones`
--

INSERT INTO `poblaciones` (`id`, `poblacion`, `provincia_id`) VALUES
(7, 'Asparrena', 1),
(10, 'Barrundia', 1),
(54, 'Albacete', 2),
(63, 'Balazote', 2),
(72, 'Casas de Juan Núñez', 2),
(80, 'Chinchilla de Monte-Aragón', 2),
(96, 'Madrigueras', 2),
(103, 'Motilleja', 2),
(118, 'Riópar', 2),
(119, 'Robledo', 2),
(152, 'Alicante/Alacant', 3),
(156, 'Altea', 3),
(169, 'Benidorm', 3),
(185, 'Calpe/Calp', 3),
(188, 'Campello (el)', 3),
(201, 'Dénia', 3),
(203, 'Elche/Elx', 3),
(207, 'Finestrat', 3),
(216, 'Hondón de los Frailes', 3),
(217, 'Ibi', 3),
(220, 'Jávea/Xàbia', 3),
(226, 'Monóvar/Monòver', 3),
(227, 'Mutxamel', 3),
(236, 'Orihuela', 3),
(255, 'Sant Joan d''Alacant', 3),
(258, 'San Vicente del Raspeig/Sant Vicent del Raspeig', 3),
(264, 'Tibi', 3),
(268, 'Torrevieja', 3),
(274, 'Villajoyosa/Vila Joiosa (la)', 3),
(277, 'Pilar de la Horadada', 3),
(285, 'Albox', 4),
(292, 'Almería', 4),
(295, 'Antas', 4),
(310, 'Carboneras', 4),
(313, 'Cuevas del Almanzora', 4),
(324, 'Garrucha', 4),
(328, 'Huércal-Overa', 4),
(337, 'Macael', 4),
(339, 'Mojácar', 4),
(350, 'Pulpí', 4),
(354, 'Roquetas de Mar', 4),
(361, 'Sorbas', 4),
(368, 'Turre', 4),
(374, 'Vélez-Rubio', 4),
(375, 'Vera', 4),
(377, 'Vícar', 4),
(378, 'Zurgena', 4),
(383, 'Adrada (La)', 5),
(397, 'Barraco (El)', 5),
(425, 'Casavieja', 5),
(458, 'Guisando', 5),
(463, 'Higuera de las Dueñas', 5),
(477, 'Lanzahíta', 5),
(480, 'Madrigal de las Altas Torres', 5),
(481, 'Maello', 5),
(493, 'Mijares', 5),
(519, 'Navahondilla', 5),
(550, 'Piedralaves', 5),
(586, 'Santa María de los Caballeros', 5),
(587, 'Santa María del Tiétar', 5),
(600, 'Sotillo de la Adrada', 5),
(601, 'Tiemblo (El)', 5),
(629, 'Villanueva de Ávila', 5),
(637, 'Alconera', 6),
(642, 'Atalaya', 6),
(644, 'Badajoz', 6),
(678, 'Feria', 6),
(681, 'Fuente de Cantos', 6),
(683, 'Fuente del Maestre', 6),
(684, 'Fuentes de León', 6),
(703, 'Llerena', 6),
(710, 'Medina de las Torres', 6),
(728, 'Parra (La)', 6),
(737, 'Puebla de Sancho Pérez', 6),
(751, 'Santos de Maimona (Los)', 6),
(765, 'Usagre', 6),
(770, 'Valencia del Ventoso', 6),
(778, 'Villafranca de los Barros', 6),
(787, 'Zafra', 6),
(796, 'Alcúdia', 7),
(800, 'Banyalbufar', 7),
(801, 'Binissalem', 7),
(805, 'Campanet', 7),
(806, 'Campos', 7),
(810, 'Costitx', 7),
(820, 'Inca', 7),
(822, 'Lloseta', 7),
(825, 'Mahón', 7),
(830, 'Mercadal (Es)', 7),
(832, 'Muro', 7),
(833, 'Palma de Mallorca', 7),
(835, 'Pollença', 7),
(845, 'Sant Lluís', 7),
(848, 'Santa Margalida', 7),
(851, 'Selva', 7),
(865, 'Ametlla del Vallès (L'')', 8),
(870, 'Artés', 8),
(871, 'Avià', 8),
(875, 'Badalona', 8),
(878, 'Balsareny', 8),
(879, 'Barcelona', 8),
(880, 'Begues', 8),
(882, 'Berga', 8),
(884, 'Borredà', 8),
(892, 'Caldes d''Estrac', 8),
(893, 'Caldes de Montbui', 8),
(898, 'Callús', 8),
(901, 'Canovelles', 8),
(906, 'Cardedeu', 8),
(909, 'Casserres', 8),
(914, 'Castellbisbal', 8),
(918, 'Castellet i la Gornal', 8),
(928, 'Cervelló', 8),
(935, 'Dosrius', 8),
(937, 'Esplugues de Llobregat', 8),
(942, 'Fogars de la Selva', 8),
(944, 'Fonollosa', 8),
(946, 'Franqueses del Vallès (Les)', 8),
(952, 'Gironella', 8),
(954, 'Granada (La)', 8),
(956, 'Granollers', 8),
(957, 'Gualba', 8),
(959, 'Guardiola de Berguedà', 8),
(961, 'Hospitalet de Llobregat (L'')', 8),
(965, 'Llagosta (La)', 8),
(966, 'Llinars del Vallès', 8),
(967, 'Lliçà d''Amunt', 8),
(968, 'Lliçà de Vall', 8),
(978, 'Masnou (El)', 8),
(983, 'Molins de Rei', 8),
(984, 'Mollet del Vallès', 8),
(985, 'Montcada i Reixac', 8),
(986, 'Montgat', 8),
(1001, 'Navàs', 8),
(1002, 'Nou de Berguedà (La)', 8),
(1004, 'Olvan', 8),
(1005, 'Olèrdola', 8),
(1016, 'Palau-solità i Plegamans', 8),
(1017, 'Pallejà', 8),
(1026, 'Pobla de Lillet (La)', 8),
(1034, 'Puig-reig', 8),
(1039, 'Ripollet', 8),
(1040, 'Roca del Vallès (La)', 8),
(1045, 'Sabadell', 8),
(1049, 'Sallent', 8),
(1052, 'Sant Adrià de Besòs', 8),
(1056, 'Sant Antoni de Vilamajor', 8),
(1060, 'Sant Celoni', 8),
(1063, 'Sant Cugat del Vallès', 8),
(1065, 'Sant Esteve de Palautordera', 8),
(1067, 'Sant Fost de Campsentelles', 8),
(1069, 'Sant Feliu de Llobregat', 8),
(1075, 'Sant Joan Despí', 8),
(1079, 'Sant Just Desvern', 8),
(1085, 'Sant Martí Sarroca', 8),
(1089, 'Sant Pere de Ribes', 8),
(1092, 'Sant Pere de Vilamajor', 8),
(1094, 'Sant Quintí de Mediona', 8),
(1095, 'Sant Quirze de Besora', 8),
(1102, 'Santa Coloma de Cervelló', 8),
(1103, 'Santa Coloma de Gramenet', 8),
(1109, 'Santa Margarida i els Monjos', 8),
(1117, 'Santa Maria de Palautordera', 8),
(1121, 'Sant Vicenç dels Horts', 8),
(1128, 'Sitges', 8),
(1139, 'Teià', 8),
(1140, 'Tiana', 8),
(1146, 'Torrelles de Foix', 8),
(1147, 'Torrelles de Llobregat', 8),
(1152, 'Vallgorguina', 8),
(1153, 'Vallirana', 8),
(1154, 'Vallromanes', 8),
(1156, 'Vic', 8),
(1159, 'Viladecans', 8),
(1162, 'Vilobí del Penedès', 8),
(1163, 'Vilafranca del Penedès', 8),
(1164, 'Vilalba Sasserra', 8),
(1165, 'Vilanova i la Geltrú', 8),
(1168, 'Vilanova del Vallès', 8),
(1184, 'Aranda de Duero', 9),
(1199, 'Baños de Valdearados', 9),
(1242, 'Castrillo de la Vega', 9),
(1261, 'Covarrubias', 9),
(1275, 'Fresnillo de las Dueñas', 9),
(1280, 'Fuentecén', 9),
(1285, 'Fuentespina', 9),
(1290, 'Gumiel de Izán', 9),
(1306, 'Huerta de Rey', 9),
(1321, 'Lerma', 9),
(1332, 'Medina de Pomar', 9),
(1373, 'Peñaranda de Duero', 9),
(1472, 'Vadocondes', 9),
(1537, 'Villarcayo de Merindad de Castilla la Vieja', 9),
(1543, 'Abadía', 10),
(1550, 'Alcántara', 10),
(1556, 'Aldeanueva de la Vera', 10),
(1579, 'Cáceres', 10),
(1589, 'Carcaboso', 10),
(1591, 'Casar de Cáceres', 10),
(1596, 'Casas del Castañar', 10),
(1617, 'Galisteo', 10),
(1619, 'Garganta (La)', 10),
(1620, 'Garganta la Olla', 10),
(1623, 'Garrovillas', 10),
(1627, 'Granja (La)', 10),
(1631, 'Guijo de Granadilla', 10),
(1637, 'Hervás', 10),
(1640, 'Holguera', 10),
(1645, 'Jaraíz de la Vera', 10),
(1648, 'Jerte', 10),
(1655, 'Majadas', 10),
(1656, 'Malpartida de Cáceres', 10),
(1657, 'Malpartida de Plasencia', 10),
(1664, 'Mirabel', 10),
(1665, 'Mohedas de Granadilla', 10),
(1671, 'Navaconcejo', 10),
(1677, 'Oliva de Plasencia', 10),
(1679, 'Pasarón de la Vera', 10),
(1689, 'Plasencia', 10),
(1695, 'Rebollar', 10),
(1718, 'Sierra de Fuentes', 10),
(1724, 'Tornavacas', 10),
(1732, 'Torremenga', 10),
(1736, 'Trujillo', 10),
(1739, 'Valdefuentes', 10),
(1743, 'Valdeobispo', 10),
(1757, 'Zarza de Granadilla', 10),
(1792, 'San Fernando', 11),
(1794, 'San Roque', 11),
(1803, 'Zahara', 11),
(1809, 'Alcalà de Xivert', 12),
(1810, 'Alcora (l'')', 12),
(1812, 'Alfondeguilla', 12),
(1814, 'Almazora/Almassora', 12),
(1816, 'Almenara', 12),
(1831, 'Benicasim/Benicàssim', 12),
(1833, 'Borriol', 12),
(1835, 'Cabanes', 12),
(1841, 'Castellón de la Plana/Castelló de la Plana', 12),
(1853, 'Chilches', 12),
(1871, 'Llosa (la)', 12),
(1874, 'Moncofa', 12),
(1879, 'Nules', 12),
(1881, 'Onda', 12),
(1882, 'Oropesa del Mar/Orpesa', 12),
(1885, 'Peñíscola', 12),
(1890, 'Pobla Tornesa (la)', 12),
(1891, 'Ribesalbes', 12),
(1894, 'Salzadella (la)', 12),
(1900, 'Segorbe', 12),
(1902, 'Soneja', 12),
(1913, 'Torreblanca', 12),
(1918, 'Useras/Useres (les)', 12),
(1920, 'Vall d''Alba', 12),
(1922, 'Vall d''Uixó (la)', 12),
(1924, 'Vilafamés', 12),
(1931, 'Villarreal/Vila-real', 12),
(1934, 'Vinaròs', 12),
(1940, 'Sant Joan de Moró', 12),
(1990, 'Labores (Las)', 13),
(1998, 'Moral de Calatrava', 13),
(2004, 'Poblete', 13),
(2175, 'Oleiros', 15),
(2195, 'Santiago de Compostela', 15),
(2221, 'Alcázar del Rey', 16),
(2233, 'Chillarón de Cuenca', 16),
(2249, 'Buendía', 16),
(2258, 'Cañaveras', 16),
(2280, 'Cuenca', 16),
(2290, 'Fuentes', 16),
(2368, 'Reíllo', 16),
(2392, 'Torrubia del Campo', 16),
(2401, 'Valdemoro-Sierra', 16),
(2425, 'Villar de Olalla', 16),
(2444, 'Fuentenava de Jábaga', 16),
(2445, 'Arcas del Villar', 16),
(2458, 'Arbúcies', 17),
(2475, 'Breda', 17),
(2481, 'Caldes de Malavella', 17),
(2487, 'Camprodon', 17),
(2507, 'Escala (L'')', 17),
(2511, 'Figueres', 17),
(2523, 'Girona', 17),
(2527, 'Hostalric', 17),
(2539, 'Lloret de Mar', 17),
(2545, 'Massanes', 17),
(2555, 'Olot', 17),
(2584, 'Riells i Viabrea', 17),
(2586, 'Riudarenes', 17),
(2596, 'Sant Feliu de Buixalleu', 17),
(2602, 'Sant Jaume de Llierca', 17),
(2603, 'Sant Jordi Desvalls', 17),
(2629, 'Sils', 17),
(2638, 'Tossa de Mar', 17),
(2660, 'Vilamacolum', 17),
(2673, 'Albolote', 18),
(2676, 'Albuñol', 18),
(2677, 'Albuñuelas', 18),
(2679, 'Alfacar', 18),
(2685, 'Almuñécar', 18),
(2688, 'Armilla', 18),
(2689, 'Atarfe', 18),
(2701, 'Cájar', 18),
(2711, 'Cenes de la Vega', 18),
(2712, 'Cijuela', 18),
(2719, 'Cúllar Vega', 18),
(2720, 'Chauchina', 18),
(2722, 'Churriana de la Vega', 18),
(2726, 'Diezma', 18),
(2738, 'Gójar', 18),
(2741, 'Granada', 18),
(2745, 'Güejar Sierra', 18),
(2750, 'Huétor de Santillán', 18),
(2752, 'Huétor Vega', 18),
(2753, 'Illora', 18),
(2755, 'Iznalloz', 18),
(2760, 'Juviles', 18),
(2762, 'Láchar', 18),
(2768, 'Loja', 18),
(2772, 'Maracena', 18),
(2776, 'Monachil', 18),
(2785, 'Ogíjares', 18),
(2787, 'Órgiva', 18),
(2789, 'Otura', 18),
(2790, 'Padul', 18),
(2793, 'Peligros', 18),
(2797, 'Píñar', 18),
(2800, 'Pórtugos', 18),
(2802, 'Pulianas', 18),
(2807, 'Salobreña', 18),
(2809, 'Santa Fe', 18),
(2824, 'Zubia (La)', 18),
(2830, 'Gabias (Las)', 18),
(2836, 'Vegas del Genil', 18),
(2844, 'Albalate de Zorita', 19),
(2845, 'Albares', 19),
(2859, 'Alocén', 19),
(2860, 'Alovera', 19),
(2876, 'Azuqueca de Henares', 19),
(2896, 'Casar (El)', 19),
(2912, 'Cogolludo', 19),
(2918, 'Cubillo de Uceda (El)', 19),
(2942, 'Galápagos', 19),
(2945, 'Guadalajara', 19),
(2951, 'Hita', 19),
(2953, 'Hontoba', 19),
(2980, 'Matarrubia', 19),
(3023, 'Pioz', 19),
(3028, 'Pozo de Guadalajara', 19),
(3030, 'Prados Redondos', 19),
(3078, 'Torrejón del Rey', 19),
(3088, 'Trijueque', 19),
(3089, 'Trillo', 19),
(3090, 'Uceda', 19),
(3094, 'Valdearenas', 19),
(3096, 'Valdeaveruelo', 19),
(3100, 'Valdenuño Fernández', 19),
(3111, 'Villanueva de la Torre', 19),
(3117, 'Yebes', 19),
(3195, 'Donostia-San Sebastián', 20),
(3233, 'Campofrío', 21),
(3256, 'Isla Cristina', 21),
(3265, 'Nava (La)', 21),
(3579, 'Úbeda', 23),
(3673, 'León', 24),
(3692, 'Palacios de la Valduerna', 24),
(3697, 'Pola de Gordón (La)', 24),
(3720, 'San Andrés del Rabanedo', 24),
(3740, 'Sariegos', 24),
(3765, 'Valverde de la Virgen', 24),
(3792, 'Villaquilambre', 24),
(3813, 'Alcarràs', 25),
(3869, 'Cervià de les Garrigues', 25),
(3969, 'Sant Llorenç de Morunys', 25),
(3975, 'Senterada', 25),
(4080, 'Cervera del Río Alhama', 26),
(4121, 'Logroño', 26),
(4226, 'Foz', 27),
(4276, 'Ajalvir', 28),
(4278, 'Álamo (El)', 28),
(4279, 'Alcalá de Henares', 28),
(4281, 'Alcorcón', 28),
(4283, 'Algete', 28),
(4284, 'Alpedrete', 28),
(4285, 'Ambite', 28),
(4287, 'Aranjuez', 28),
(4288, 'Arganda del Rey', 28),
(4289, 'Arroyomolinos', 28),
(4291, 'Batres', 28),
(4292, 'Becerril de la Sierra', 28),
(4293, 'Belmonte de Tajo', 28),
(4295, 'Berrueco (El)', 28),
(4296, 'Boadilla del Monte', 28),
(4297, 'Boalo (El)', 28),
(4300, 'Brunete', 28),
(4301, 'Buitrago del Lozoya', 28),
(4302, 'Bustarviejo', 28),
(4303, 'Cabanillas de la Sierra', 28),
(4305, 'Cadalso de los Vidrios', 28),
(4307, 'Campo Real', 28),
(4309, 'Carabaña', 28),
(4314, 'Ciempozuelos', 28),
(4315, 'Cobeña', 28),
(4316, 'Colmenar del Arroyo', 28),
(4317, 'Colmenar de Oreja', 28),
(4318, 'Colmenarejo', 28),
(4319, 'Colmenar Viejo', 28),
(4320, 'Collado Mediano', 28),
(4321, 'Collado Villalba', 28),
(4323, 'Coslada', 28),
(4324, 'Cubas de la Sagra', 28),
(4325, 'Chapinería', 28),
(4326, 'Chinchón', 28),
(4328, 'Escorial (El)', 28),
(4330, 'Fresnedillas de la Oliva', 28),
(4331, 'Fresno de Torote', 28),
(4332, 'Fuenlabrada', 28),
(4333, 'Fuente el Saz de Jarama', 28),
(4334, 'Fuentidueña de Tajo', 28),
(4335, 'Galapagar', 28),
(4339, 'Getafe', 28),
(4340, 'Griñón', 28),
(4341, 'Guadalix de la Sierra', 28),
(4342, 'Guadarrama', 28),
(4346, 'Hoyo de Manzanares', 28),
(4347, 'Humanes de Madrid', 28),
(4348, 'Leganés', 28),
(4349, 'Loeches', 28),
(4352, 'Madrid', 28),
(4353, 'Majadahonda', 28),
(4354, 'Manzanares el Real', 28),
(4356, 'Mejorada del Campo', 28),
(4357, 'Miraflores de la Sierra', 28),
(4361, 'Moraleja de Enmedio', 28),
(4362, 'Moralzarzal', 28),
(4363, 'Morata de Tajuña', 28),
(4364, 'Móstoles', 28),
(4366, 'Navalafuente', 28),
(4367, 'Navalagamella', 28),
(4368, 'Navalcarnero', 28),
(4370, 'Navas del Rey', 28),
(4371, 'Nuevo Baztán', 28),
(4372, 'Olmeda de las Fuentes', 28),
(4373, 'Orusco de Tajuña', 28),
(4374, 'Paracuellos de Jarama', 28),
(4375, 'Parla', 28),
(4378, 'Pelayos de la Presa', 28),
(4379, 'Perales de Tajuña', 28),
(4380, 'Pezuela de las Torres', 28),
(4382, 'Pinto', 28),
(4384, 'Pozuelo de Alarcón', 28),
(4385, 'Pozuelo del Rey', 28),
(4388, 'Quijorna', 28),
(4389, 'Rascafría', 28),
(4391, 'Ribatejada', 28),
(4392, 'Rivas-Vaciamadrid', 28),
(4394, 'Robledo de Chavela', 28),
(4396, 'Rozas de Madrid (Las)', 28),
(4398, 'San Agustín de Guadalix', 28),
(4399, 'San Fernando de Henares', 28),
(4400, 'San Lorenzo de El Escorial', 28),
(4401, 'San Martín de la Vega', 28),
(4402, 'San Martín de Valdeiglesias', 28),
(4403, 'San Sebastián de los Reyes', 28),
(4408, 'Serranillos del Valle', 28),
(4411, 'Soto del Real', 28),
(4412, 'Talamanca de Jarama', 28),
(4413, 'Tielmes', 28),
(4415, 'Torrejón de Ardoz', 28),
(4416, 'Torrejón de la Calzada', 28),
(4417, 'Torrejón de Velasco', 28),
(4418, 'Torrelaguna', 28),
(4419, 'Torrelodones', 28),
(4421, 'Torres de la Alameda', 28),
(4424, 'Valdelaguna', 28),
(4427, 'Valdemorillo', 28),
(4428, 'Valdemoro', 28),
(4429, 'Valdeolmos-Alalpardo', 28),
(4430, 'Valdepiélagos', 28),
(4431, 'Valdetorres de Jarama', 28),
(4432, 'Valdilecha', 28),
(4434, 'Velilla de San Antonio', 28),
(4435, 'Vellón (El)', 28),
(4437, 'Villaconejos', 28),
(4438, 'Villa del Prado', 28),
(4443, 'Villanueva de la Cañada', 28),
(4444, 'Villanueva del Pardillo', 28),
(4446, 'Villar del Olmo', 28),
(4447, 'Villarejo de Salvanés', 28),
(4448, 'Villaviciosa de Odón', 28),
(4451, 'Lozoyuela-Navas-Sieteiglesias', 28),
(4453, 'Tres Cantos', 28),
(4478, 'Benalmádena', 29),
(4507, 'Fuengirola', 29),
(4520, 'Málaga', 29),
(4522, 'Marbella', 29),
(4523, 'Mijas', 29),
(4553, 'Torremolinos', 29),
(4554, 'Abanilla', 30),
(4555, 'Abarán', 30),
(4556, 'Águilas', 30),
(4558, 'Alcantarilla', 30),
(4559, 'Aledo', 30),
(4560, 'Alguazas', 30),
(4561, 'Alhama de Murcia', 30),
(4562, 'Archena', 30),
(4564, 'Blanca', 30),
(4568, 'Caravaca de la Cruz', 30),
(4569, 'Cartagena', 30),
(4571, 'Ceutí', 30),
(4572, 'Cieza', 30),
(4573, 'Fortuna', 30),
(4576, 'Librilla', 30),
(4578, 'Lorquí', 30),
(4579, 'Mazarrón', 30),
(4580, 'Molina de Segura', 30),
(4581, 'Moratalla', 30),
(4583, 'Murcia', 30),
(4584, 'Ojós', 30),
(4587, 'Ricote', 30),
(4588, 'San Javier', 30),
(4589, 'San Pedro del Pinatar', 30),
(4590, 'Torre-Pacheco', 30),
(4593, 'Ulea', 30),
(4594, 'Unión (La)', 30),
(4608, 'Altsasu/Alsasua', 31),
(4625, 'Arbizu', 31),
(4651, 'Berbinzana', 31),
(4671, 'Ziordia', 31),
(4682, 'Etxarri-Aranatz', 31),
(4689, 'Ergoiena', 31),
(4721, 'Uharte-Arakil', 31),
(4728, 'Iturmendi', 31),
(4736, 'Lakuntza', 31),
(4787, 'Olazti/Olazagutía', 31),
(4837, 'Urdiain', 31),
(4871, 'Allariz', 32),
(4883, 'Boborás', 32),
(4889, 'Carballiño (O)', 32),
(4924, 'Ourense', 32),
(4966, 'Avilés', 33),
(4971, 'Cabranes', 33),
(4976, 'Carreño', 33),
(4978, 'Castrillón', 33),
(4982, 'Corvera de Asturias', 33),
(4986, 'Gijón', 33),
(4993, 'Langreo', 33),
(4997, 'Llanera', 33),
(4998, 'Llanes', 33),
(5002, 'Nava', 33),
(5004, 'Noreña', 33),
(5006, 'Oviedo', 33),
(5011, 'Piloña', 33),
(5017, 'Ribadedeva', 33),
(5027, 'Sariego', 33),
(5028, 'Siero', 33),
(5034, 'Teverga', 33),
(5056, 'Venta de Baños', 34),
(5106, 'Herrera de Pisuerga', 34),
(5133, 'Palencia', 34),
(5237, 'Arucas', 35),
(5247, 'Palmas de Gran Canaria (Las)', 35),
(5266, 'Arbo', 36),
(5267, 'Barro', 36),
(5268, 'Baiona', 36),
(5273, 'Cangas', 36),
(5274, 'Cañiza (A)', 36),
(5278, 'Covelo', 36),
(5286, 'Gondomar', 36),
(5288, 'Guarda (A)', 36),
(5289, 'Lalín', 36),
(5291, 'Marín', 36),
(5294, 'Moaña', 36),
(5295, 'Mondariz', 36),
(5296, 'Mondariz-Balneario', 36),
(5298, 'Mos', 36),
(5299, 'Neves (As)', 36),
(5300, 'Nigrán', 36),
(5301, 'Oia', 36),
(5302, 'Pazos de Borbén', 36),
(5303, 'Pontevedra', 36),
(5304, 'Porriño (O)', 36),
(5307, 'Ponteareas', 36),
(5308, 'Ponte Caldelas', 36),
(5310, 'Redondela', 36),
(5313, 'Rosal (O)', 36),
(5314, 'Salceda de Caselas', 36),
(5315, 'Salvaterra de Miño', 36),
(5316, 'Sanxenxo', 36),
(5318, 'Soutomaior', 36),
(5319, 'Tomiño', 36),
(5320, 'Tui', 36),
(5322, 'Vigo', 36),
(5323, 'Vilaboa', 36),
(5324, 'Vila de Cruces', 36),
(5327, 'Illa de Arousa (A)', 36),
(5708, 'Guía de Isora', 38),
(5729, 'Santiago del Teide', 38),
(5743, 'Alfoz de Lloredo', 39),
(5746, 'Arenas de Iguña', 39),
(5748, 'Arnuero', 39),
(5750, 'Astillero (El)', 39),
(5753, 'Bareyo', 39),
(5754, 'Cabezón de la Sal', 39),
(5756, 'Cabuérniga', 39),
(5758, 'Camargo', 39),
(5760, 'Cartes', 39),
(5761, 'Castañeda', 39),
(5762, 'Castro-Urdiales', 39),
(5766, 'Comillas', 39),
(5767, 'Corrales de Buelna (Los)', 39),
(5768, 'Corvera de Toranzo', 39),
(5769, 'Campoo de Enmedio', 39),
(5770, 'Entrambasaguas', 39),
(5773, 'Hazas de Cesto', 39),
(5775, 'Herrerías', 39),
(5779, 'Liérganes', 39),
(5780, 'Limpias', 39),
(5782, 'Marina de Cudeyo', 39),
(5784, 'Medio Cudeyo', 39),
(5785, 'Meruelo', 39),
(5786, 'Miengo', 39),
(5788, 'Molledo', 39),
(5789, 'Noja', 39),
(5790, 'Penagos', 39),
(5794, 'Piélagos', 39),
(5796, 'Polanco', 39),
(5797, 'Potes', 39),
(5798, 'Puente Viesgo', 39),
(5799, 'Ramales de la Victoria', 39),
(5802, 'Reocín', 39),
(5803, 'Ribamontán al Mar', 39),
(5804, 'Ribamontán al Monte', 39),
(5806, 'Riotuerto', 39),
(5808, 'Ruente', 39),
(5810, 'Ruiloba', 39),
(5811, 'San Felices de Buelna', 39),
(5814, 'San Roque de Riomiera', 39),
(5815, 'Santa Cruz de Bezana', 39),
(5816, 'Santa María de Cayón', 39),
(5817, 'Santander', 39),
(5818, 'Santillana del Mar', 39),
(5819, 'Santiurde de Reinosa', 39),
(5820, 'Santiurde de Toranzo', 39),
(5822, 'San Vicente de la Barquera', 39),
(5827, 'Suances', 39),
(5829, 'Torrelavega', 39),
(5832, 'Udías', 39),
(5833, 'Valdáliga', 39),
(5837, 'Val de San Vicente', 39),
(5840, 'Villacarriedo', 39),
(5841, 'Villaescusa', 39),
(5843, 'Villaverde de Trucíos', 39),
(5845, 'Abades', 40),
(5866, 'Ayllón', 40),
(5872, 'Bernuy de Porreros', 40),
(5876, 'Cabañas de Polendos', 40),
(5881, 'Cantimpalos', 40),
(5882, 'Carbonero el Mayor', 40),
(5891, 'Cerezo de Abajo', 40),
(5903, 'Domingo García', 40),
(5911, 'Espinar (El)', 40),
(5912, 'Espirdo', 40),
(5932, 'Hontanares de Eresma', 40),
(5934, 'Ituero y Lama', 40),
(5942, 'Lastrilla (La)', 40),
(5943, 'Losa (La)', 40),
(5949, 'Marugán', 40),
(5963, 'Nava de la Asunción', 40),
(5971, 'Navas de San Antonio', 40),
(5976, 'Otero de Herreros', 40),
(5978, 'Palazuelos de Eresma', 40),
(6001, 'San Ildefonso', 40),
(6011, 'Sauquillo de Cabezas', 40),
(6013, 'Segovia', 40),
(6016, 'Sotillo', 40),
(6021, 'Torrecaballeros', 40),
(6025, 'Trescasas', 40),
(6026, 'Turégano', 40),
(6027, 'Urueñas', 40),
(6033, 'Valverde del Majano', 40),
(6046, 'Zarzuela del Monte', 40),
(6048, 'Ortigosa del Monte', 40),
(6053, 'San Cristóbal de Segovia', 40),
(6057, 'Alcalá de Guadaira', 41),
(6063, 'Almensilla', 41),
(6065, 'Aznalcázar', 41),
(6070, 'Bormujos', 41),
(6074, 'Camas', 41),
(6087, 'Coria del Río', 41),
(6093, 'Espartinas', 41),
(6097, 'Gelves', 41),
(6112, 'Mairena del Aljarafe', 41),
(6123, 'Palomares del Río', 41),
(6139, 'San Juan de Aznalfarache', 41),
(6140, 'Sanlúcar la Mayor', 41),
(6144, 'Sevilla', 41),
(6146, 'Tomares', 41),
(6162, 'Alconaba', 42),
(6173, 'Almajano', 42),
(6175, 'Almarza', 42),
(6176, 'Almazán', 42),
(6178, 'Almenar de Soria', 42),
(6181, 'Arcos de Jalón', 42),
(6191, 'Berlanga de Duero', 42),
(6197, 'Buitrago', 42),
(6198, 'Burgo de Osma-Ciudad de Osma', 42),
(6200, 'Cabrejas del Pinar', 42),
(6201, 'Calatañazor', 42),
(6208, 'Carrascosa de la Sierra', 42),
(6211, 'Castilruiz', 42),
(6215, 'Cidones', 42),
(6221, 'Covaleda', 42),
(6223, 'Cubo de la Solana', 42),
(6224, 'Cueva de Ágreda', 42),
(6242, 'Garray', 42),
(6243, 'Golmayo', 42),
(6244, 'Gómara', 42),
(6263, 'Morón de Almazán', 42),
(6268, 'Navaleno', 42),
(6278, 'Quintana Redonda', 42),
(6281, 'Rábanos (Los)', 42),
(6285, 'Renieblas', 42),
(6291, 'Royo (El)', 42),
(6293, 'San Esteban de Gormaz', 42),
(6294, 'San Felices', 42),
(6295, 'San Leonardo de Yagüe', 42),
(6299, 'Santa María de las Hoyas', 42),
(6302, 'Soria', 42),
(6303, 'Sotillo del Rincón', 42),
(6307, 'Talveila', 42),
(6308, 'Tardelcuende', 42),
(6310, 'Tejado', 42),
(6314, 'Trévago', 42),
(6317, 'Valdeavellano de Tera', 42),
(6326, 'Velilla de la Sierra', 42),
(6329, 'Villaciervos', 42),
(6337, 'Vinuesa', 42),
(6341, 'Yelo', 42),
(6343, 'Albinyana', 43),
(6357, 'Arboç (L'')', 43),
(6361, 'Banyeres del Penedès', 43),
(6369, 'Bisbal del Penedès (La)', 43),
(6371, 'Bonastre', 43),
(6378, 'Calafell', 43),
(6391, 'Creixell', 43),
(6392, 'Cunit', 43),
(6415, 'Llorenç del Penedès', 43),
(6420, 'Masllorenç', 43),
(6430, 'Montmell (El)', 43),
(6460, 'Querol', 43),
(6471, 'Roda de Barà', 43),
(6472, 'Rodonyà', 43),
(6477, 'Sant Jaume dels Domenys', 43),
(6480, 'Santa Oliva', 43),
(6488, 'Tarragona', 43),
(6502, 'Vandellòs i l''Hospitalet de l''Infant', 43),
(6503, 'Vendrell (El)', 43),
(6511, 'Vila-seca', 43),
(6773, 'Almorox', 45),
(6781, 'Borox', 45),
(6786, 'Cabañas de Yepes', 45),
(6787, 'Cabezamesada', 45),
(6791, 'Camarena', 45),
(6792, 'Camarenilla', 45),
(6798, 'Carranque', 45),
(6801, 'Casarrubios del Monte', 45),
(6806, 'Cedillo del Condado', 45),
(6809, 'Ciruelos', 45),
(6813, 'Corral de Almaguer', 45),
(6815, 'Chozas de Canales', 45),
(6818, 'Dosbarrios', 45),
(6820, 'Escalona', 45),
(6823, 'Esquivias', 45),
(6825, 'Fuensalida', 45),
(6830, 'Guardia (La)', 45),
(6835, 'Hormigos', 45),
(6837, 'Huerta de Valdecarábanos', 45),
(6838, 'Iglesuela (La)', 45),
(6840, 'Illescas', 45),
(6843, 'Lillo', 45),
(6845, 'Lucillos', 45),
(6847, 'Magán', 45),
(6854, 'Mata (La)', 45),
(6858, 'Méntrida', 45),
(6860, 'Miguel Esteban', 45),
(6866, 'Nambroca', 45),
(6874, 'Noblejas', 45),
(6877, 'Novés', 45),
(6880, 'Ocaña', 45),
(6882, 'Ontígola', 45),
(6883, 'Orgaz', 45),
(6887, 'Pantoja', 45),
(6901, 'Quintanar de la Orden', 45),
(6908, 'Romeral (El)', 45),
(6916, 'Santa Cruz del Retamar', 45),
(6917, 'Santa Olalla', 45),
(6920, 'Seseña', 45),
(6924, 'Talavera de la Reina', 45),
(6927, 'Toledo', 45),
(6935, 'Ugena', 45),
(6938, 'Valmojado', 45),
(6941, 'Ventas de Retamosa (Las)', 45),
(6946, 'Villaluenga de la Sagra', 45),
(6947, 'Villamiel de Toledo', 45),
(6953, 'Villarrubia de Santiago', 45),
(6955, 'Villasequilla', 45),
(6956, 'Villatobas', 45),
(6957, 'Viso de San Juan (El)', 45),
(6959, 'Yeles', 45),
(6960, 'Yepes', 45),
(6961, 'Yuncler', 45),
(6963, 'Yuncos', 45),
(6968, 'Agullent', 46),
(6974, 'Albalat dels Tarongers', 46),
(6977, 'Alboraya', 46),
(6979, 'Alcàsser', 46),
(6992, 'Algar de Palancia', 46),
(6993, 'Algemesí', 46),
(7022, 'Benifairó de les Valls', 46),
(7034, 'Bétera', 46),
(7038, 'Bonrepòs i Mirambell', 46),
(7042, 'Burjassot', 46),
(7049, 'Carlet', 46),
(7066, 'Quart de Poblet', 46),
(7069, 'Cullera', 46),
(7074, 'Xirivella', 46),
(7075, 'Chiva', 46),
(7080, 'Eliana (l'')', 46),
(7098, 'Gilet', 46),
(7099, 'Godella', 46),
(7111, 'Llíria', 46),
(7123, 'Manises', 46),
(7126, 'Masalavés', 46),
(7127, 'Massalfassar', 46),
(7128, 'Massamagrell', 46),
(7133, 'Mislata', 46),
(7136, 'Monserrat', 46),
(7141, 'Museros', 46),
(7142, 'Náquera', 46),
(7154, 'Paterna', 46),
(7157, 'Picanya', 46),
(7163, 'Pobla de Farnals (la)', 46),
(7166, 'Pobla de Vallbona (la)', 46),
(7168, 'Puig', 46),
(7169, 'Puçol', 46),
(7171, 'Rafelbuñol/Rafelbunyol', 46),
(7180, 'Rocafort', 46),
(7184, 'Sagunto/Sagunt', 46),
(7192, 'Serra', 46),
(7194, 'Silla', 46),
(7199, 'Sueca', 46),
(7208, 'Torrent', 46),
(7212, 'Turís', 46),
(7214, 'Valencia', 46),
(7229, 'San Antonio de Benagéber', 46),
(7236, 'Aldeamayor de San Martín', 47),
(7239, 'Arroyo de la Encomienda', 47),
(7252, 'Boecillo', 47),
(7256, 'Cabezón de Pisuerga', 47),
(7279, 'Cigales', 47),
(7284, 'Corcos', 47),
(7304, 'Laguna de Duero', 47),
(7318, 'Mojados', 47),
(7358, 'Renedo de Esgueva', 47),
(7370, 'San Miguel del Pino', 47),
(7379, 'Santovenia de Pisuerga', 47),
(7385, 'Simancas', 47),
(7389, 'Tordesillas', 47),
(7397, 'Traspinedo', 47),
(7399, 'Tudela de Duero', 47),
(7406, 'Valdestillas', 47),
(7410, 'Valladolid', 47),
(7417, 'Viana de Cega', 47),
(7453, 'Zaratán', 47),
(7456, 'Abanto y Ciérvana-Abanto Zierbena', 48),
(7464, 'Arrieta', 48),
(7466, 'Bakio', 48),
(7467, 'Barakaldo', 48),
(7468, 'Barrika', 48),
(7471, 'Bermeo', 48),
(7474, 'Bilbao', 48),
(7479, 'Zeberio', 48),
(7489, 'Fruiz', 48),
(7490, 'Galdakao', 48),
(7492, 'Gamiz-Fika', 48),
(7494, 'Gatika', 48),
(7496, 'Gordexola', 48),
(7498, 'Getxo', 48),
(7507, 'Laukiz', 48),
(7508, 'Leioa', 48),
(7509, 'Lemoa', 48),
(7510, 'Lemoiz', 48),
(7515, 'Maruri-Jatabe', 48),
(7518, 'Meñaka', 48),
(7523, 'Mungia', 48),
(7525, 'Muskiz', 48),
(7531, 'Plentzia', 48),
(7532, 'Portugalete', 48),
(7533, 'Errigoiti', 48),
(7534, 'Valle de Trápaga-Trapagaran', 48),
(7535, 'Lezama', 48),
(7536, 'Santurtzi', 48),
(7537, 'Ortuella', 48),
(7538, 'Sestao', 48),
(7539, 'Sopelana', 48),
(7540, 'Sopuerta', 48),
(7552, 'Derio', 48),
(7553, 'Erandio', 48),
(7554, 'Loiu', 48),
(7555, 'Sondika', 48),
(7556, 'Zamudio', 48),
(7564, 'Zierbena', 48),
(7838, 'Almunia de Doña Godina (La)', 50),
(8064, 'Torrehermosa', 50),
(8102, 'Zaragoza', 50),
(8126, 'Benimamet', 46),
(8128, 'Segur de Calafell', 43),
(8153, 'Ajo', 39),
(8172, 'La Manga del Mar Menor', 30),
(8226, 'Empuriabrava', 17),
(8229, 'Coma-Ruga', 43),
(8233, 'Grau de Castelló, El/Grao, El', 12),
(8235, 'Pagan (Lo)', 30),
(8244, 'Isla de Canela', 21),
(8245, 'Islantilla', 21),
(8249, 'Villaobispo de las Regueras', 24),
(8250, 'Navatejera', 24),
(8258, 'Palomares', 4),
(8259, 'Lugones', 33),
(8270, 'Santa Ponça', 7),
(8294, 'Cobreces', 39),
(8296, 'Loredo', 39),
(8298, 'Oreña', 39),
(8301, 'Toñanes', 39),
(8357, 'Boo', 39),
(8358, 'Guarnizo', 39),
(8432, 'Cacicedo', 39),
(8436, 'Maliaño', 39),
(8437, 'Muriedas', 39),
(8469, 'Bedico', 39),
(8476, 'Santiago (Cartes)', 39),
(8479, 'Pomaluengo', 39),
(8481, 'Villabañez', 39),
(8483, 'Baltezana', 39),
(8491, 'Samano', 39),
(8541, 'Hoznayo', 39),
(8574, 'Beranga', 39),
(8673, 'Gajano', 39),
(8675, 'Pedreña', 39),
(8676, 'Pontejos', 39),
(8677, 'Rubayo', 39),
(8685, 'Villanueva de la Peña', 39),
(8700, 'Cuchia', 39),
(8703, 'Mogro', 39),
(8744, 'Arce', 39),
(8746, 'Boo (Piélagos)', 39),
(8748, 'Liencres', 39),
(8749, 'Mortera', 39),
(8750, 'Oruña', 39),
(8752, 'Quijano', 39),
(8770, 'Requejada', 39),
(8801, 'Puente San Miguel', 39),
(8804, 'Valles', 39),
(8805, 'Villapresente', 39),
(8808, 'Galizano', 39),
(8810, 'Somo', 39),
(8811, 'Suesa', 39),
(8819, 'Villaverde de Pontones', 39),
(8899, 'Sancibrián', 39),
(8900, 'Soto de la Marina', 39),
(8905, 'Penilla (La)', 39),
(8908, 'Sarón', 39),
(8912, 'Peñacastillo', 39),
(8913, 'San Román (Santander)', 39),
(8979, 'Hinojedo', 39),
(8989, 'Viernoles', 39),
(9014, 'Unquera', 39),
(100003, 'Armenia', 100014),
(100010, 'La Tebaida', 100014);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(10) NOT NULL,
  `provincia` varchar(30) NOT NULL DEFAULT '',
  `pais_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pais_id` (`pais_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `provincia`, `pais_id`) VALUES
(1, 'Álava', 34),
(2, 'Albacete', 34),
(3, 'Alicante', 34),
(4, 'Almería', 34),
(5, 'Ávila', 34),
(6, 'Badajoz', 34),
(7, 'Baleares', 34),
(8, 'Barcelona', 34),
(9, 'Burgos', 34),
(10, 'Cáceres', 34),
(11, 'Cádiz', 34),
(12, 'Castellón', 34),
(13, 'Ciudad Real', 34),
(14, 'Córdoba', 34),
(15, 'A Coruña', 34),
(16, 'Cuenca', 34),
(17, 'Girona', 34),
(18, 'Granada', 34),
(19, 'Guadalajara', 34),
(20, 'Guipúzcoa', 34),
(21, 'Huelva', 34),
(22, 'Huesca', 34),
(23, 'Jaén', 34),
(24, 'León', 34),
(25, 'Lleida', 34),
(26, 'La rioja', 34),
(27, 'Lugo', 34),
(28, 'Madrid', 34),
(29, 'Málaga', 34),
(30, 'Murcia', 34),
(31, 'Navarra', 34),
(32, 'Orense', 34),
(33, 'Asturias', 34),
(34, 'Palencia', 34),
(35, 'Las Palmas', 34),
(36, 'Pontevedra', 34),
(37, 'Salamanca', 34),
(38, 'Tenerife', 34),
(39, 'Cantabria', 34),
(40, 'Segovia', 34),
(41, 'Sevilla', 34),
(42, 'Soria', 34),
(43, 'Tarragona', 34),
(44, 'Teruel', 34),
(45, 'Toledo', 34),
(46, 'Valencia', 34),
(47, 'Valladolid', 34),
(48, 'Vizcaya', 34),
(49, 'Zamora', 34),
(50, 'Zaragoza', 34),
(51, 'Ceuta', 34),
(52, 'Melilla', 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_antiguedades`
--

CREATE TABLE IF NOT EXISTS `taux_antiguedades` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_antiguedades`
--

INSERT INTO `taux_antiguedades` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'menos de 5 años'),
('02', 'entre 5 y 10 años'),
('03', 'entre 10 y 20 años'),
('04', 'entre 20 y 30 años'),
('05', 'más de 30 años');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_areas_fachada`
--

CREATE TABLE IF NOT EXISTS `taux_areas_fachada` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_areas_fachada`
--

INSERT INTO `taux_areas_fachada` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'sin fachada'),
('02', 'de 1 a 4 metros'),
('03', 'de 5 a 8 metros'),
('04', 'de 9 a 12 metros'),
('05', 'más de 12 metros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_calificaciones_energeticas`
--

CREATE TABLE IF NOT EXISTS `taux_calificaciones_energeticas` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_calificaciones_energeticas`
--

INSERT INTO `taux_calificaciones_energeticas` (`id`, `description`) VALUES
('01', 'A+'),
('02', 'A'),
('03', 'B'),
('04', 'B-'),
('05', 'C'),
('06', 'D'),
('07', 'E'),
('08', 'F'),
('09', 'G');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_distribuciones`
--

CREATE TABLE IF NOT EXISTS `taux_distribuciones` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_distribuciones`
--

INSERT INTO `taux_distribuciones` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'diáfana'),
('02', 'de 1 a 2 estancias'),
('03', 'de 3 a 5 estancias'),
('04', 'de 5 a 10 estancias'),
('05', 'más de 10 estancias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_estados_conservacion`
--

CREATE TABLE IF NOT EXISTS `taux_estados_conservacion` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_estados_conservacion`
--

INSERT INTO `taux_estados_conservacion` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'a reformar'),
('02', 'buen estado'),
('03', 'promoción de obra nueva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_horarios_contacto`
--

CREATE TABLE IF NOT EXISTS `taux_horarios_contacto` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_horarios_contacto`
--

INSERT INTO `taux_horarios_contacto` (`id`, `description`) VALUES
('00', 'indiferente'),
('01', 'mañanas'),
('02', 'mediodía'),
('03', 'tardes'),
('04', 'noches'),
('05', 'fines de semana'),
('06', 'horario comercial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_interior_exterior`
--

CREATE TABLE IF NOT EXISTS `taux_interior_exterior` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_interior_exterior`
--

INSERT INTO `taux_interior_exterior` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'exterior'),
('02', 'interior');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_lenguajes`
--

CREATE TABLE IF NOT EXISTS `taux_lenguajes` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_lenguajes`
--

INSERT INTO `taux_lenguajes` (`id`, `description`) VALUES
('01', 'español'),
('02', 'italiano'),
('03', 'portugués'),
('04', 'inglés'),
('05', 'francés'),
('06', 'alemán'),
('07', 'catalán');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_localizaciones_local`
--

CREATE TABLE IF NOT EXISTS `taux_localizaciones_local` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_localizaciones_local`
--

INSERT INTO `taux_localizaciones_local` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'en centro comercial'),
('02', 'a pie de calle');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_medios_captacion`
--

CREATE TABLE IF NOT EXISTS `taux_medios_captacion` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_medios_captacion`
--

INSERT INTO `taux_medios_captacion` (`id`, `description`) VALUES
('BO', 'boletín'),
('CC', 'cartel calle'),
('ES', 'escaparate'),
('IN', 'internet'),
('ML', 'mailing'),
('OT', 'otras'),
('PR', 'prensa'),
('RE', 'referenciado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_motivos_baja`
--

CREATE TABLE IF NOT EXISTS `taux_motivos_baja` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_motivos_baja`
--

INSERT INTO `taux_motivos_baja` (`id`, `description`) VALUES
('BT', 'baja temporal'),
('FE', 'fin de encargo'),
('OB', 'obsolescencia'),
('RP', 'retirado propietario'),
('VA', 'v/a Alfa Inmobiliaria'),
('VC', 'v/a competencia'),
('VP', 'v/a propietario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_plantas_piso`
--

CREATE TABLE IF NOT EXISTS `taux_plantas_piso` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  `order_by` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_plantas_piso`
--

INSERT INTO `taux_plantas_piso` (`id`, `description`, `order_by`) VALUES
('00', 'bajo', 3),
('01', 'planta 1', 4),
('02', 'planta 2', 5),
('03', 'planta 3', 6),
('04', 'planta 4', 7),
('05', 'planta 5', 8),
('06', 'planta 6', 9),
('07', 'planta 7', 10),
('08', 'planta 8', 11),
('09', 'planta 9', 12),
('10', 'planta 10', 13),
('11', 'planta 11', 14),
('12', 'planta 12', 15),
('13', 'planta 13', 16),
('14', 'planta 14', 17),
('15', 'planta 15', 18),
('16', 'planta 16', 19),
('17', 'planta 17', 20),
('18', 'planta 18', 21),
('19', 'planta 19', 22),
('20', 'planta 20', 23),
('21', 'planta 21', 24),
('22', 'planta 22', 25),
('23', 'planta 23', 26),
('24', 'planta 24', 27),
('25', 'planta 25', 28),
('26', 'planta 26', 29),
('27', 'planta 27', 30),
('28', 'planta 28', 31),
('29', 'planta 29', 32),
('30', 'planta 30', 33),
('31', 'planta 31', 34),
('32', 'planta 32', 35),
('33', 'planta 33', 36),
('34', 'planta 34', 37),
('35', 'planta 35', 38),
('36', 'planta 36', 39),
('37', 'planta 37', 40),
('38', 'planta 38', 41),
('39', 'planta 39', 42),
('40', 'planta 40', 43),
('41', 'planta 41', 44),
('42', 'planta 42', 45),
('43', 'planta 43', 46),
('44', 'planta 44', 47),
('45', 'planta 45', 48),
('46', 'planta 46', 49),
('47', 'planta 47', 50),
('48', 'planta 48', 51),
('49', 'planta 49', 52),
('50', 'planta 50', 53),
('51', 'planta 51', 54),
('52', 'planta 52', 55),
('53', 'planta 53', 56),
('54', 'planta 54', 57),
('55', 'planta 55', 58),
('56', 'planta 56', 59),
('57', 'planta 57', 60),
('X0', 'entreplanta', 3),
('X1', 'semisótano', 2),
('X2', 'sótano', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_puertas_piso`
--

CREATE TABLE IF NOT EXISTS `taux_puertas_piso` (
  `id` char(4) NOT NULL,
  `description` varchar(32) NOT NULL,
  `order_by` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_puertas_piso`
--

INSERT INTO `taux_puertas_piso` (`id`, `description`, `order_by`) VALUES
('99', 'número (1, 2, 3…)', 2),
('cd', 'centro derecha', 14),
('ci', 'centro izquierda', 13),
('cr', 'centro', 12),
('dr', 'derecha', 5),
('ed', 'exterior derecha', 8),
('ei', 'exterior izquierda', 7),
('ex', 'exterior', 6),
('id', 'interior derecha', 11),
('ii', 'interior izquierda', 10),
('in', 'interior', 9),
('iz', 'izquierda', 4),
('pu', 'puerta única', 3),
('zz', 'letra (a,b,c...)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_aa`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_aa` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_aa`
--

INSERT INTO `taux_tipos_aa` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'frío'),
('02', 'frío/calor'),
('03', 'no disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_agua_caliente`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_agua_caliente` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_agua_caliente`
--

INSERT INTO `taux_tipos_agua_caliente` (`id`, `description`) VALUES
('01', 'Tipo 1'),
('02', 'Tipo 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_cableado`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_cableado` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_cableado`
--

INSERT INTO `taux_tipos_cableado` (`id`, `description`) VALUES
('00', 'indiferente'),
('01', 'cableado por falso techo'),
('02', 'cableado por suelo técnico'),
('03', 'cableado por paredes'),
('04', 'cableado tipo red eckermann'),
('05', 'cableado no disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_calefaccion`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_calefaccion` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_calefaccion`
--

INSERT INTO `taux_tipos_calefaccion` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'central'),
('02', 'individual'),
('03', 'no disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_chalet`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_chalet` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_chalet`
--

INSERT INTO `taux_tipos_chalet` (`id`, `description`) VALUES
('01', 'chalet'),
('02', 'chalet adosado'),
('03', 'chalet independiente'),
('04', 'chalet pareado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_contrato`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_contrato` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_contrato`
--

INSERT INTO `taux_tipos_contrato` (`id`, `description`) VALUES
('AB', 'Alfa Básico'),
('AD', 'Alfa Digital'),
('AI', 'Alfa Integral'),
('EV', 'Encargo Verbal'),
('PV', 'Particular Vende');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_equipamiento`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_equipamiento` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_equipamiento`
--

INSERT INTO `taux_tipos_equipamiento` (`id`, `description`) VALUES
('01', 'sin amueblar'),
('02', 'cocina amueblada'),
('03', 'amueblado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_garaje`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_garaje` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_garaje`
--

INSERT INTO `taux_tipos_garaje` (`id`, `description`) VALUES
('01', 'moto'),
('02', 'coche');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_imagen`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_imagen` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_imagen`
--

INSERT INTO `taux_tipos_imagen` (`id`, `description`) VALUES
('00', 'desconocido'),
('01', 'baño'),
('02', 'cocina'),
('03', 'detalles'),
('04', 'dormitorio'),
('05', 'fachada'),
('06', 'garaje'),
('07', 'jardín'),
('08', 'plano'),
('09', 'salón'),
('10', 'terraza'),
('11', 'vistas'),
('12', 'piscina'),
('13', 'compañeros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_inmueble`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_inmueble` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_inmueble`
--

INSERT INTO `taux_tipos_inmueble` (`id`, `description`) VALUES
('01', 'piso'),
('02', 'chalet'),
('03', 'local'),
('04', 'oficina'),
('05', 'garaje'),
('06', 'terreno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_local`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_local` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_local`
--

INSERT INTO `taux_tipos_local` (`id`, `description`) VALUES
('01', 'local'),
('02', 'nave');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_oficina`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_oficina` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_oficina`
--

INSERT INTO `taux_tipos_oficina` (`id`, `description`) VALUES
('01', 'exclusivo oficinas'),
('02', 'viviendas y oficinas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_operacion`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_operacion` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_operacion`
--

INSERT INTO `taux_tipos_operacion` (`id`, `description`) VALUES
('01', 'venta'),
('02', 'alquiler');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_orientacion`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_orientacion` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_orientacion`
--

INSERT INTO `taux_tipos_orientacion` (`id`, `description`) VALUES
('01', 'norte'),
('02', 'nordeste'),
('03', 'este'),
('04', 'sudeste'),
('05', 'sur'),
('06', 'suroeste'),
('07', 'oeste'),
('08', 'noroeste');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_suelo`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_suelo` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_suelo`
--

INSERT INTO `taux_tipos_suelo` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'parquet'),
('02', 'tarima flotante'),
('03', 'tarima normal'),
('04', 'madera'),
('05', 'moqueta'),
('06', 'mármol'),
('07', 'cerámica'),
('08', 'gres'),
('09', 'terrazo'),
('10', 'otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_tipos_tendedero`
--

CREATE TABLE IF NOT EXISTS `taux_tipos_tendedero` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_tipos_tendedero`
--

INSERT INTO `taux_tipos_tendedero` (`id`, `description`) VALUES
('00', 'no lo sé'),
('01', 'cubierto'),
('02', 'descubierto'),
('03', 'no disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taux_visibilidades_direccion`
--

CREATE TABLE IF NOT EXISTS `taux_visibilidades_direccion` (
  `id` char(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `taux_visibilidades_direccion`
--

INSERT INTO `taux_visibilidades_direccion` (`id`, `description`) VALUES
('01', 'visible'),
('02', 'sólo calle'),
('03', 'ocultar dirección');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terrenos`
--

CREATE TABLE IF NOT EXISTS `terrenos` (
  `id` int(11) NOT NULL,
  `inmueble_id` int(10) NOT NULL,
  `kilometro` int(10) DEFAULT NULL,
  `numero_parcela` int(10) DEFAULT NULL,
  `sector` varchar(30) DEFAULT NULL,
  `area_terreno` decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_propertyId` (`inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `_audit_creation_user` varchar(36) NOT NULL DEFAULT '',
  `_audit_creation_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `_audit_update_user` varchar(36) NOT NULL DEFAULT '',
  `_audit_update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `_level_admin_required` int(11) NOT NULL DEFAULT '999999999',
  `_visibility` int(11) NOT NULL DEFAULT '0',
  `_owner_id` varchar(36) NOT NULL,
  `_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) DEFAULT NULL,
  `inactive_until` datetime DEFAULT NULL,
  `office_id` varchar(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_user_login` (`office_id`,`username`),
  KEY `IX_user_office` (`office_id`),
  KEY `_audit_creation_user` (`_audit_creation_user`),
  KEY `_audit_update_user` (`_audit_update_user`),
  KEY `_level_admin_required` (`_level_admin_required`),
  KEY `_visibility` (`_visibility`),
  KEY `_owner_id` (`_owner_id`),
  KEY `_record_status` (`_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `_audit_creation_user`, `_audit_creation_time`, `_audit_update_user`, `_audit_update_time`, `_level_admin_required`, `_visibility`, `_owner_id`, `_deleted`, `username`, `password`, `inactive_until`, `office_id`) VALUES
('331a4c71-6380-1f1d-3648-dbd0fafa9b5b', 'e5c55e31-1edf-ea40-4839-af6a6c13aa69', '2007-02-22 11:55:09', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2011-10-31 16:11:41', 5000, 0, '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', 0, 'soporte', '6f8c7620d3856a267366740a302e0a24', NULL, '0001'),
('9c5f7ac6-4b33-0187-4df6-5ea73adab360', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:58:30', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:58:30', 5000, 0, '9c5f7ac6-4b33-0187-4df6-5ea73adab360', 0, 'dmonje', '87608c84e38a0ed859f8a081cf7d9aa4', NULL, '0001'),
('D0002', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:16:15', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:16:15', 5000, 0, 'D0002', 0, 'demo0002', '4b76e4bd29f23bf1d1b51d0335ff3252', NULL, '0002'),
('D0003', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:37:35', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:37:35', 5000, 0, 'D0003', 0, 'demo0003', '38ecfbd9216c50c3545453788f551b3d', NULL, '0003'),
('D0004', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:38:03', '331a4c71-6380-1f1d-3648-dbd0fafa9b5b', '2013-01-14 18:38:03', 5000, 0, 'D0004', 0, 'demo0004', '76c7f2a2ff543bb8999f0e115ac1cf6f', NULL, '0004');
