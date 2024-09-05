-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 05 sep. 2024 à 07:31
-- Version du serveur : 8.0.37
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pizzeria`
--

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cart_status` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `cart_status`, `date_creation`) VALUES
(1, 1, 'en cours', '2024-09-03 11:52:55'),
(2, 1, 'en cours', '2024-09-04 06:49:26');

-- --------------------------------------------------------

--
-- Structure de la table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `dish_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `dish_id`, `quantity`) VALUES
(1, 1, 76, 1),
(2, 2, 148, 1),
(3, 2, 161, 2);

-- --------------------------------------------------------

--
-- Structure de la table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `is_discounted` float(3,2) NOT NULL,
  `sells_count` int NOT NULL DEFAULT '0',
  `pate_id` int DEFAULT NULL,
  `base_id` int DEFAULT NULL,
  `size_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `name`, `description`, `image_url`, `price`, `type`, `is_new`, `is_discounted`, `sells_count`, `pate_id`, `base_id`, `size_id`) VALUES
(76, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 8.00, 'pizza', 1, 0.04, 0, 1, 1, 1),
(77, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 9.00, 'pizza', 1, 0.04, 0, 2, 1, 1),
(78, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 10.50, 'pizza', 1, 0.04, 0, 3, 1, 1),
(79, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 10.00, 'pizza', 1, 0.04, 0, 1, 1, 2),
(80, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 11.00, 'pizza', 1, 0.04, 0, 2, 1, 2),
(81, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 12.50, 'pizza', 1, 0.04, 0, 3, 1, 2),
(82, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 11.00, 'pizza', 1, 0.04, 0, 1, 1, 3),
(83, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 12.00, 'pizza', 1, 0.04, 0, 2, 1, 3),
(84, 'Regina', 'la pizza reine', 'img/products/Pizza Regina.png', 13.50, 'pizza', 1, 0.04, 0, 3, 1, 3),
(148, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 7.00, 'pizza', 1, 0.00, 0, 1, 1, 1),
(149, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 8.00, 'pizza', 1, 0.00, 0, 2, 1, 1),
(150, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 9.50, 'pizza', 1, 0.00, 0, 3, 1, 1),
(151, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 9.00, 'pizza', 1, 0.00, 0, 1, 1, 2),
(152, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 10.00, 'pizza', 1, 0.00, 0, 2, 1, 2),
(153, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 11.50, 'pizza', 1, 0.00, 0, 3, 1, 2),
(154, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 10.00, 'pizza', 1, 0.00, 0, 1, 1, 3),
(155, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 11.00, 'pizza', 1, 0.00, 0, 2, 1, 3),
(156, 'Margarita', 'blablabla', 'img/products/Pizza Margarita.png', 12.50, 'pizza', 1, 0.00, 0, 3, 1, 3),
(157, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 9.20, 'pizza', 1, 0.00, 0, 1, 3, 1),
(158, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 10.20, 'pizza', 1, 0.00, 0, 2, 3, 1),
(159, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 11.70, 'pizza', 1, 0.00, 0, 3, 3, 1),
(160, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 11.20, 'pizza', 1, 0.00, 0, 1, 3, 2),
(161, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 12.20, 'pizza', 1, 0.00, 0, 2, 3, 2),
(162, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 13.70, 'pizza', 1, 0.00, 0, 3, 3, 2),
(163, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 12.20, 'pizza', 1, 0.00, 0, 1, 3, 3),
(164, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 13.20, 'pizza', 1, 0.00, 0, 2, 3, 3),
(165, 'Salmon', 'ciboulette cacahuette citron', 'img/products/Pizza Salmon.jpg', 14.70, 'pizza', 1, 0.00, 0, 3, 3, 3),
(184, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 8.00, 'pizza', 0, 0.00, 0, 1, 1, 1),
(185, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 9.00, 'pizza', 0, 0.00, 0, 2, 1, 1),
(186, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 10.50, 'pizza', 0, 0.00, 0, 3, 1, 1),
(187, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 10.00, 'pizza', 0, 0.00, 0, 1, 1, 2),
(188, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 11.00, 'pizza', 0, 0.00, 0, 2, 1, 2),
(189, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 12.50, 'pizza', 0, 0.00, 0, 3, 1, 2),
(190, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 11.00, 'pizza', 0, 0.00, 0, 1, 1, 3),
(191, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 12.00, 'pizza', 0, 0.00, 0, 2, 1, 3),
(192, 'Quatre fromages', 'Pizza aux quatres délicieux fromtons', 'img/products/Pizza Quatre fromages.jpg', 13.50, 'pizza', 0, 0.00, 0, 3, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `dish_ingredients`
--

CREATE TABLE `dish_ingredients` (
  `dish_ingredient_id` int NOT NULL,
  `dish_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ingredient_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `dish_ingredients`
--

INSERT INTO `dish_ingredients` (`dish_ingredient_id`, `dish_name`, `ingredient_id`) VALUES
(154, 'Regina', 5),
(155, 'Regina', 6),
(156, 'Regina', 9),
(157, 'Regina', 12),
(186, 'Margarita', 6),
(187, 'Margarita', 8),
(188, 'Salmon', 8),
(189, 'Salmon', 11),
(190, 'Salmon', 19),
(199, 'Quatre fromages', 5),
(200, 'Quatre fromages', 15),
(201, 'Quatre fromages', 16),
(202, 'Quatre fromages', 25);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `extra_price` decimal(5,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL,
  `is_bio` tinyint(1) NOT NULL,
  `is_allergen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `name`, `description`, `image_url`, `extra_price`, `is_available`, `is_bio`, `is_allergen`) VALUES
(5, 'Tomate', 'Tomates fraîches tranchées', 'img/products/ingredients/tomate.jpg', 0.50, 1, 1, 0),
(6, 'Mozzarella', 'Mozzarella fondante', 'img/products/ingredients/mozzarella.jpg', 1.00, 1, 1, 0),
(7, 'Pepperoni', 'Tranches de pepperoni épicé', 'url_image_pepperoni.jpg', 1.50, 1, 0, 1),
(8, 'Basilic', 'Feuilles de basilic frais', 'url_image_basilic.jpg', 0.25, 1, 1, 0),
(9, 'Champignons', 'Champignons de Paris', 'url_image_champignons.jpg', 0.75, 1, 1, 0),
(10, 'Oignons', 'Oignons rouges émincés', 'url_image_oignons.jpg', 0.50, 1, 1, 0),
(11, 'Olives', 'Olives noires dénoyautées', 'url_image_olives.jpg', 0.60, 1, 0, 0),
(12, 'Jambon', 'Jambon cuit en tranches', 'url_image_jambon.jpg', 1.00, 1, 0, 1),
(13, 'Poivrons', 'Poivrons tricolores', 'url_image_poivrons.jpg', 0.70, 1, 1, 0),
(14, 'Anchois', 'Filets d\'anchois', 'url_image_anchois.jpg', 1.20, 1, 0, 1),
(15, 'Parmesan', 'Copeaux de parmesan', 'url_image_parmesan.jpg', 1.50, 1, 1, 1),
(16, 'Fromage de chèvre', 'Rondelles de fromage de chèvre', 'url_image_chevre.jpg', 1.75, 1, 1, 1),
(17, 'Bacon', 'Morceaux de bacon grillés', 'url_image_bacon.jpg', 1.50, 1, 0, 1),
(18, 'Artichaut', 'Cœurs d\'artichaut', 'url_image_artichaut.jpg', 1.00, 1, 1, 0),
(19, 'Saumon fumé', 'Tranches de saumon fumé', 'url_image_saumon.jpg', 2.00, 1, 0, 1),
(20, 'Thon', 'Morceaux de thon', 'url_image_thon.jpg', 1.20, 1, 0, 1),
(21, 'Rucola', 'Feuilles de roquette', 'url_image_rucola.jpg', 0.80, 1, 1, 0),
(22, 'Chorizo', 'Rondelles de chorizo épicé', 'url_image_chorizo.jpg', 1.50, 1, 0, 1),
(23, 'Poulet', 'Morceaux de poulet grillé', 'url_image_poulet.jpg', 1.75, 1, 0, 1),
(24, 'Pesto', 'Sauce pesto verte', 'url_image_pesto.jpg', 0.90, 1, 1, 0),
(25, 'Gorgonzola', 'Gorgonzola fait dans les traditions italiennes', 'img/products/ingredients/gorgonzola.jpg', 1.50, 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `date_order` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(8,2) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `cart_id`, `date_order`, `total`, `order_status`) VALUES
(1, 1, 1, '2024-09-03 11:54:03', 8.00, 'traitée'),
(2, 1, 2, '2024-09-04 06:52:34', 31.40, 'en cours');

-- --------------------------------------------------------

--
-- Structure de la table `pizzas_bases`
--

CREATE TABLE `pizzas_bases` (
  `pizza_base_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extra_price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pizzas_bases`
--

INSERT INTO `pizzas_bases` (`pizza_base_id`, `name`, `description`, `extra_price`) VALUES
(1, 'Base tomate', 'Base traditionnelle de sauce tomate', 0.00),
(2, 'Base tomate épicée', 'Une base tomate revisitée par notre chef', 0.50),
(3, 'Base crème fraiche', 'Une base 100% crème fraiche', 1.50),
(4, 'Base crème aux herbes', 'Une base crème fraiche avec de bonnes herbes fraîches', 2.00);

-- --------------------------------------------------------

--
-- Structure de la table `pizzas_pates`
--

CREATE TABLE `pizzas_pates` (
  `pizza_pate_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extra_price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pizzas_pates`
--

INSERT INTO `pizzas_pates` (`pizza_pate_id`, `name`, `description`, `extra_price`) VALUES
(1, 'Pâte Fine', 'Pâte fine et croustillante', 0.00),
(2, 'Pâte Epaisse', 'Pâte épaisse et moelleuse', 1.00),
(3, 'Pâte Epaisse au fromage', 'Pâte épaisse et moelleuse au fromage', 2.50);

-- --------------------------------------------------------

--
-- Structure de la table `pizzas_sizes`
--

CREATE TABLE `pizzas_sizes` (
  `pizza_size_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extra_price` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pizzas_sizes`
--

INSERT INTO `pizzas_sizes` (`pizza_size_id`, `name`, `description`, `extra_price`) VALUES
(1, 'S', 'Petite : 26cm', 0.00),
(2, 'M', 'Moyenne : 30cm', 2.00),
(3, 'L', 'Grande : 36cm', 3.00);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `dish_id` int DEFAULT NULL,
  `score` int NOT NULL,
  `commentary` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `object` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ticket_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `user_id`, `last_name`, `first_name`, `email`, `phone`, `order_id`, `object`, `message`, `attachment`, `date_creation`, `ticket_status`) VALUES
(1, 1, 'rereefefe', 'Roberto', 'roberto@admin.com', '054444444', 0, 'gfdgfd', 'nhhh,hfnh fn hfnhfhgn', '', '2024-09-03 14:20:13', 'open'),
(2, 1, '', '', '', '', 1, 'momiomioiommoi', 'omiomiomiomihgjkhgjkhgj cfghjghj ghj ghgvh ', 'tickets/attachments/Attachement_1725373256.png', '2024-09-03 14:20:56', 'open');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_signup` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fidelity_points` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `address`, `phone`, `date_signup`, `fidelity_points`) VALUES
(1, 'jean', 'luc', 'malibu1106@gmail.com', 'fefefefe', NULL, '0645454', '2024-09-03 07:46:38', 0),
(2, 'Françoise', 'Chirac', 'fchiriac@gmail.com', '$2y$10$7zhfoNB.nyyFm/idZCs02eluQ4qNZulcL9sdR2Fy2iJOf/Hf6eCLi', NULL, NULL, '2024-09-03 08:18:57', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Index pour la table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`);

--
-- Index pour la table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);

--
-- Index pour la table `dish_ingredients`
--
ALTER TABLE `dish_ingredients`
  ADD PRIMARY KEY (`dish_ingredient_id`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Index pour la table `pizzas_bases`
--
ALTER TABLE `pizzas_bases`
  ADD PRIMARY KEY (`pizza_base_id`);

--
-- Index pour la table `pizzas_pates`
--
ALTER TABLE `pizzas_pates`
  ADD PRIMARY KEY (`pizza_pate_id`);

--
-- Index pour la table `pizzas_sizes`
--
ALTER TABLE `pizzas_sizes`
  ADD PRIMARY KEY (`pizza_size_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT pour la table `dish_ingredients`
--
ALTER TABLE `dish_ingredients`
  MODIFY `dish_ingredient_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pizzas_bases`
--
ALTER TABLE `pizzas_bases`
  MODIFY `pizza_base_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `pizzas_pates`
--
ALTER TABLE `pizzas_pates`
  MODIFY `pizza_pate_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `pizzas_sizes`
--
ALTER TABLE `pizzas_sizes`
  MODIFY `pizza_size_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
