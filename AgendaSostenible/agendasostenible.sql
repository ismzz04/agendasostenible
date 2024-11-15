-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2024 a las 15:48:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agendasostenible`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncis`
--

CREATE TABLE `anuncis` (
  `id` int(11) NOT NULL,
  `usuari_id` int(11) DEFAULT NULL,
  `titol` varchar(255) DEFAULT NULL,
  `descripcio` text DEFAULT NULL,
  `imatges` text DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `estat` enum('esborrany','public','caducat','esborrat') DEFAULT 'esborrany'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anuncis`
--

INSERT INTO `anuncis` (`id`, `usuari_id`, `titol`, `descripcio`, `imatges`, `categoria_id`, `estat`) VALUES
(1, NULL, 'Intercanvi de Llibres', 'Estic buscant algú interessat en intercanviar llibres sobre sostenibilitat, ecologia i jardineria. Tinc diversos títols sobre hort urbà, reciclatge i energies renovables.', 'llibres_ecologia.jpg', 1, 'public'),
(2, NULL, 'Venda de Bicicleta Elèctrica Usada', 'Bicicleta elèctrica en bones condicions, amb autonomia de fins a 50 km. Ideal per moure’s per la ciutat de forma sostenible. Preu negociable.', 'bicicleta_electrica.jpg', 2, 'public'),
(3, NULL, 'Curs de Compostatge Domèstic', 'Oferim un curs intensiu de compostatge per a aquells que vulguin aprendre a fer compost a casa. El curs inclou pràctiques i assessorament personalitzat.', 'curs_compostatge.jpg', 3, 'caducat'),
(4, NULL, 'Donació de Mobles Usats', 'Donem mobles en bon estat (taules, cadires, prestatgeries) per a persones que els puguin reutilitzar. Recollida a càrrec de l\'interessat.', 'mobles.jpg', 4, 'public'),
(5, NULL, 'Voluntaris per Netejar Platges', ' Busquem voluntaris per a una jornada de neteja de platges. Són benvinguts tots aquells que vulguin contribuir a mantenir el litoral net.', 'platja_neteja.jpg', 5, 'public'),
(6, NULL, 'Lloguer d’Equip de Càmping', ' Llogo equip de càmping (tenda, fogonet, aïllants, etc.) per a qui vulgui gaudir de la natura de manera sostenible sense comprar materials nous.', 'camping.jpg', 6, 'public'),
(7, NULL, 'Xerrada sobre Permacultura', 'Conferència sobre permacultura aplicada a l’hort urbà. Aprèn tècniques per cultivar de manera ecològica i sostenible. Entrada gratuïta.', 'permacultura.jpg', 7, 'public');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom_categoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `nom_categoria`) VALUES
(1, 'Intercanvi'),
(2, 'Venda'),
(3, 'Formació'),
(4, 'Donació'),
(5, 'Voluntariat'),
(6, 'Lloguer'),
(7, 'Informació');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentaris`
--

CREATE TABLE `comentaris` (
  `id` int(11) NOT NULL,
  `usuari_id` int(11) DEFAULT NULL,
  `esdeveniment_id` int(11) DEFAULT NULL,
  `comentari` text DEFAULT NULL,
  `estat` enum('pendent','publicat') DEFAULT 'pendent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentaris`
--

INSERT INTO `comentaris` (`id`, `usuari_id`, `esdeveniment_id`, `comentari`, `estat`) VALUES
(2, 2, 5, 'Molt bona feina', 'publicat'),
(3, 2, 5, 'Top!', 'publicat'),
(4, 2, 4, 'M\'agrada!', 'publicat'),
(5, 2, 3, 'Aniré si o si', 'publicat'),
(6, 2, 2, 'Guay', 'publicat'),
(7, 2, 1, 'M\'encanta', 'publicat'),
(8, 3, 5, 'Molt bé!', 'publicat');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consells_sostenibilitat`
--

CREATE TABLE `consells_sostenibilitat` (
  `id` int(11) NOT NULL,
  `titol` varchar(255) DEFAULT NULL,
  `descripcio_breu` varchar(255) DEFAULT NULL,
  `text_explicatiu` text DEFAULT NULL,
  `etiquetes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consells_sostenibilitat`
--

INSERT INTO `consells_sostenibilitat` (`id`, `titol`, `descripcio_breu`, `text_explicatiu`, `etiquetes`) VALUES
(2, 'Redueix, Reutilitza i Recicla', 'L’essència de la sostenibilitat és reduir el consum, reutilitzar el que tenim i reciclar el que no podem reutilitzar.', 'Comença a aplicar la regla de les 3R a la teva vida diària. Redueix el consum d’envasos, compra productes en granel o reutilitzables, i separa els residus per facilitar-ne el reciclatge.', '#3R #Reciclatge #Reutilització'),
(3, 'Estalvi d’Energia a Casa', 'Reduir el consum d’energia a casa és clau per disminuir la petjada de carboni.', 'Apaga els llums quan no els necessitis, utilitza bombetes LED i desconnecta els dispositius electrònics que no estàs utilitzant. Considera instal·lar panells solars per generar energia neta.', '#Energia #EstalviEnergètic #PanellsSolars'),
(4, 'Evita el Plàstic d’un Sol Ús', 'Els plàstics d’un sol ús són una de les principals causes de contaminació global.', 'Porta sempre amb tu una ampolla reutilitzable, una bossa de tela i utensilis sostenibles. Això reduirà el nombre d\'envasos de plàstic que utilitzes i, per tant, la contaminació que generes.', '#SensePlàstic #Reutilitzable #Sostenibilitat'),
(5, 'Utilitza Transport Sostenible', 'El transport sostenible ajuda a reduir les emissions de CO₂.', 'Opta per caminar, anar en bicicleta o utilitzar transport públic en lloc del cotxe. Si necessites un vehicle, considera compartir cotxe o utilitzar-ne un elèctric.', '#TransportSostenible #Bicicleta #MobilitatVerda'),
(6, 'Conserva l’Aigua', 'L’aigua és un recurs essencial que hem de conservar.', 'Redueix el consum d\'aigua amb petites accions com dutxes més curtes, utilitzar aixetes amb limitadors de cabal i recollir aigua de pluja per regar plantes.', '#EstalviDAigua #RecursosNaturals #Conservació');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esdeveniments`
--

CREATE TABLE `esdeveniments` (
  `id` int(11) NOT NULL,
  `titol` varchar(255) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `descripcio` text DEFAULT NULL,
  `tipus` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valoracio` decimal(2,1) DEFAULT NULL,
  `imatge` varchar(255) DEFAULT NULL,
  `visualitzacions` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `esdeveniments`
--

INSERT INTO `esdeveniments` (`id`, `titol`, `latitud`, `longitud`, `descripcio`, `tipus`, `data`, `hora`, `valoracio`, `imatge`, `visualitzacions`) VALUES
(1, 'Caminada Ecològica', 42.36462150, 3.15813730, 'Una caminata anual para limpiar áreas naturales, promover el reciclaje y aprender sobre la biodiversidad local.\r\n', 'Aire lliure', '2025-04-14', '09:00:00', 5.0, 'pexels-qjpioneer-917510.jpg', 0),
(2, 'Mercat de Productes Locals i Sostenibles', 42.11353500, 3.13874220, 'Feria de productores locales donde los visitantes pueden comprar productos ecológicos y sostenibles.', 'Aire lliure', '2025-05-20', '10:00:00', 4.0, 'pexels-sarah-chai-7262777.jpg', 0),
(3, 'Xerrada sobre Energies Renovables', 42.26560000, 2.96170000, ' Conferencia educativa sobre el uso de energías renovables y cómo implementarlas en el hogar.', 'Xerrada', '2025-06-08', '18:15:00', 5.0, 'pexels-kindelmedia-9875441.jpg', 0),
(4, 'Taller de Compostatge Domèstic', 42.26320180, 3.17553280, 'Taller práctico sobre cómo hacer compost en casa, dirigido a aquellos interesados en el reciclaje de desechos orgánicos.', 'Aire lliure', '2025-06-12', '16:00:00', 4.0, 'pexels-mali-802221.jpg', 0),
(5, 'Jornada de Plantació d’Arbres', 42.30780000, 3.14758000, 'Evento para plantar árboles en áreas afectadas por la deforestación y aprender sobre el impacto del cambio climático.\r\n', 'Aire lliure', '2025-09-01', '10:30:00', 5.0, 'pexels-laker-5732806.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorits`
--

CREATE TABLE `favorits` (
  `usuari_id` int(11) NOT NULL,
  `esdeveniment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favorits`
--

INSERT INTO `favorits` (`usuari_id`, `esdeveniment_id`) VALUES
(2, 1),
(2, 3),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

CREATE TABLE `usuaris` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `cognoms` varchar(255) DEFAULT NULL,
  `nom_usuari` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contrasenya` varchar(255) DEFAULT NULL,
  `imatge_perfil` varchar(255) DEFAULT NULL,
  `rol` enum('usuari','admin') DEFAULT 'usuari'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `nom`, `cognoms`, `nom_usuari`, `email`, `contrasenya`, `imatge_perfil`, `rol`) VALUES
(2, 'Ismael', 'Zabibi', 'ismaadmin', 'ismael@gmail.com', 'Isma1234.', 'img_avatar.png', 'admin'),
(3, 'Yahya', 'Sadouni', 'yahyaadmin', 'yahya@gmail.com', 'Yahya1234.', '54b19ada-d53e-4ee9-8882-9dfed1bf1396.jpg', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracions`
--

CREATE TABLE `valoracions` (
  `id` int(11) NOT NULL,
  `usuari_id` int(11) DEFAULT NULL,
  `esdeveniment_id` int(11) DEFAULT NULL,
  `valoracio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracions`
--

INSERT INTO `valoracions` (`id`, `usuari_id`, `esdeveniment_id`, `valoracio`) VALUES
(2, 2, 4, 4),
(3, 2, 5, 5),
(4, 2, 3, 5),
(5, 2, 2, 4),
(6, 2, 1, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncis`
--
ALTER TABLE `anuncis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuari_id` (`usuari_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentaris`
--
ALTER TABLE `comentaris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuari_id` (`usuari_id`),
  ADD KEY `esdeveniment_id` (`esdeveniment_id`);

--
-- Indices de la tabla `consells_sostenibilitat`
--
ALTER TABLE `consells_sostenibilitat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `esdeveniments`
--
ALTER TABLE `esdeveniments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipus` (`tipus`),
  ADD KEY `data` (`data`);

--
-- Indices de la tabla `favorits`
--
ALTER TABLE `favorits`
  ADD PRIMARY KEY (`usuari_id`,`esdeveniment_id`),
  ADD KEY `esdeveniment_id` (`esdeveniment_id`);

--
-- Indices de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_usuari` (`nom_usuari`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `valoracions`
--
ALTER TABLE `valoracions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuari_id` (`usuari_id`),
  ADD KEY `esdeveniment_id` (`esdeveniment_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncis`
--
ALTER TABLE `anuncis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comentaris`
--
ALTER TABLE `comentaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `consells_sostenibilitat`
--
ALTER TABLE `consells_sostenibilitat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `esdeveniments`
--
ALTER TABLE `esdeveniments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `valoracions`
--
ALTER TABLE `valoracions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncis`
--
ALTER TABLE `anuncis`
  ADD CONSTRAINT `anuncis_ibfk_1` FOREIGN KEY (`usuari_id`) REFERENCES `usuaris` (`id`),
  ADD CONSTRAINT `anuncis_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `comentaris`
--
ALTER TABLE `comentaris`
  ADD CONSTRAINT `comentaris_ibfk_1` FOREIGN KEY (`usuari_id`) REFERENCES `usuaris` (`id`),
  ADD CONSTRAINT `comentaris_ibfk_2` FOREIGN KEY (`esdeveniment_id`) REFERENCES `esdeveniments` (`id`);

--
-- Filtros para la tabla `favorits`
--
ALTER TABLE `favorits`
  ADD CONSTRAINT `favorits_ibfk_1` FOREIGN KEY (`usuari_id`) REFERENCES `usuaris` (`id`),
  ADD CONSTRAINT `favorits_ibfk_2` FOREIGN KEY (`esdeveniment_id`) REFERENCES `esdeveniments` (`id`);

--
-- Filtros para la tabla `valoracions`
--
ALTER TABLE `valoracions`
  ADD CONSTRAINT `valoracions_ibfk_1` FOREIGN KEY (`usuari_id`) REFERENCES `usuaris` (`id`),
  ADD CONSTRAINT `valoracions_ibfk_2` FOREIGN KEY (`esdeveniment_id`) REFERENCES `esdeveniments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
