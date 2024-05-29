-- Adminer 4.8.1 MySQL 10.11.3-MariaDB-1:10.11.3+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `absence`;
CREATE TABLE `absence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_765AE0C9DD62C21B` (`child_id`),
  CONSTRAINT `FK_765AE0C9DD62C21B` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `absence` (`id`, `child_id`, `start_date`, `end_date`, `comment`) VALUES
(1,	4,	'2024-02-16 00:00:00',	'2024-02-16 00:00:00',	'dhrgherz'),
(2,	14,	'2024-02-28 00:00:00',	'2024-02-29 00:00:00',	'mal au ventre dû au stress de la présentation'),
(3,	11,	'2024-02-28 00:00:00',	'2024-02-29 00:00:00',	'mal à la tête à force de voir papa coder'),
(4,	12,	'2024-02-28 00:00:00',	'2024-02-29 00:00:00',	'Otite (à force d\'entendre papa parler de code)'),
(5,	13,	'2024-02-28 00:00:00',	'2024-02-29 00:00:00',	'vertiges a causes des regex de papa');

DROP TABLE IF EXISTS `child`;
CREATE TABLE `child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birthday` datetime NOT NULL,
  `gender` varchar(50) NOT NULL,
  `diet` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_22B35429A76ED395` (`user_id`),
  CONSTRAINT `FK_22B35429A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `child` (`id`, `user_id`, `firstname`, `lastname`, `birthday`, `gender`, `diet`) VALUES
(2,	NULL,	'Paul',	'Durand',	'2023-01-22 23:15:47',	'fille',	'sans lactose'),
(3,	NULL,	'Jean',	'Durand',	'2022-02-16 18:38:21',	'fille',	'sans gluten'),
(4,	NULL,	'Marie',	'Martin',	'2023-04-07 09:56:35',	'fille',	'végétalien'),
(7,	NULL,	'Paul',	'Lefebvre',	'2022-06-12 18:34:57',	'fille',	'végétalien'),
(10,	2,	'Ismail',	'Sari',	'2024-02-23 00:00:00',	'garçon',	'végétarien'),
(11,	7,	'kaïs',	'Diallo',	'2017-02-18 00:00:00',	'garçon',	NULL),
(12,	7,	'elaïjah',	'Diallo',	'2021-10-23 00:00:00',	'garçon',	NULL),
(13,	7,	'Ayannah',	'Diallo',	'2022-12-24 00:00:00',	'Fille',	NULL),
(14,	8,	'Ilyes',	'Le goff',	'2021-08-18 00:00:00',	'garçon',	NULL),
(15,	2,	'Ismaïl',	'Sari',	'2022-10-22 00:00:00',	'garçon',	NULL),
(16,	11,	'Elliot',	'Sarloutte',	'2024-02-24 00:00:00',	'garçon',	NULL);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240216093059',	'2024-02-16 09:30:59',	383),
('DoctrineMigrations\\Version20240220134920',	'2024-02-21 12:12:37',	203),
('DoctrineMigrations\\Version20240227085613',	'2024-02-27 08:56:56',	27);

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `future_event` varchar(600) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `events` (`id`, `future_event`) VALUES
(4,	'Votre crèche O\'BAMBINO sera exceptionnellement fermée le mercredi 28 février, jour férié des falafels.');

DROP TABLE IF EXISTS `event_calendar`;
CREATE TABLE `event_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `event_calendar` (`id`, `start`, `title`, `end`) VALUES
(1,	'2024-02-19 20:10:28',	'Halloween',	'2024-02-17 18:10:36'),
(2,	'2024-02-17 18:28:49',	'Halloween',	'2024-02-23 07:07:01'),
(3,	'2024-02-19 20:25:05',	'rendez-vous',	'2024-02-20 12:31:53'),
(4,	'2024-02-19 12:57:40',	'anniversaire',	'2024-02-18 07:59:30'),
(5,	'2024-02-16 13:16:22',	'anniversaire',	'2024-02-20 20:51:57');

DROP TABLE IF EXISTS `meal`;
CREATE TABLE `meal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_meal_id` int(11) DEFAULT NULL,
  `starter` varchar(255) NOT NULL,
  `main_meal` varchar(255) NOT NULL,
  `dessert` varchar(255) NOT NULL,
  `snack` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `week_day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9EF68E9C30F1BD6` (`report_meal_id`),
  CONSTRAINT `FK_9EF68E9C30F1BD6` FOREIGN KEY (`report_meal_id`) REFERENCES `report` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `meal` (`id`, `report_meal_id`, `starter`, `main_meal`, `dessert`, `snack`, `date`, `week_day`) VALUES
(1,	NULL,	'homard grillé au four sur son lit de persil',	'carpaccio de boeuf/saumon accompagné de pommes dauphines',	'tarte tatin',	'fromage blanc coulis de fraise',	'2024-02-20 21:25:00',	'Lundi'),
(2,	NULL,	'Caviar',	'Souris d\'agneau/sole accompagné de son embeurrée de pomme de terre',	'Tarte feuilletée aux figues',	'Ferrero rochers',	'2024-02-18 14:09:00',	'Mardi'),
(3,	NULL,	'Escargot marinés',	'Cuisses de grenouilles accompagné de sa julienne de légumes',	'Charlotte aux fraises',	'kouign amann',	'2024-02-20 23:30:00',	'Mercredi'),
(4,	NULL,	'nems poulet/crevettes avec sa salade de choux rouge',	'Nouilles sautés aux légumes variés',	'boule coco et nougats',	'Riz au lait de coco et à la mangue',	'2024-02-17 04:23:00',	'Jeudi'),
(5,	NULL,	'Guacamole d\'avocats accompagné de ses tortillas maison',	'Chili con carne boeuf/ végétarien',	'Gateau dulce de leche',	'compote d\'ananas et gateau à la noix de coco',	'2024-02-19 18:14:00',	'Vendredi');

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` longtext DEFAULT NULL,
  `authors` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_report_id` int(11) DEFAULT NULL,
  `reminder` varchar(255) DEFAULT NULL,
  `date_report` datetime NOT NULL,
  `meal_report` varchar(255) NOT NULL,
  `toilet_report` varchar(255) NOT NULL,
  `sleep_report` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C42F77849AE3C44C` (`child_report_id`),
  CONSTRAINT `FK_C42F77849AE3C44C` FOREIGN KEY (`child_report_id`) REFERENCES `child` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `report` (`id`, `child_report_id`, `reminder`, `date_report`, `meal_report`, `toilet_report`, `sleep_report`) VALUES
(1,	2,	'reyeryhrey',	'2024-02-16 00:00:00',	'ergre',	'ergge',	'egegg'),
(2,	15,	'Essaye de faire roulé une voiture sur le plafond de la crèche. De très bonne humeur.',	'2024-02-28 00:00:00',	'à bien manger',	'RAS',	'à domir 30 minutes'),
(3,	11,	'A beaucoup dormi.',	'2024-02-28 00:00:00',	'à bien manger',	'RAS',	'à dormi 5h'),
(4,	12,	'Dessine sur le mobilier de la crèche, fais des roues arrière avec son trotteur, très en forme.',	'2024-02-28 00:00:00',	'à bien manger',	'RAS',	'n\'a pas dormi'),
(5,	13,	'sourie à tout le monde, très sage, enfant modèle.',	'2024-02-28 00:00:00',	'à bien manger',	'RAS',	'à dormi 2h45'),
(6,	14,	'à lu tous les livres de la bibliothèque, à beaucoup pousser ses camarades.',	'2024-02-28 00:00:00',	'à très bien manger',	'2 changes',	'à dormi 45 minutes');

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_user_id` int(11) DEFAULT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D649C5DA9B8E` (`child_user_id`),
  CONSTRAINT `FK_8D93D649C5DA9B8E` FOREIGN KEY (`child_user_id`) REFERENCES `child` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `child_user_id`, `email`, `roles`, `password`, `lastname`, `firstname`) VALUES
(2,	NULL,	'mennel@sari.fr',	'[]',	'$2y$13$lXkuV4WJElm6epY1sC91kuOfOUqP/f7Mw48KWrjwueSx/AAhwVaaC',	'Sari',	'Mennel'),
(4,	NULL,	'admin@admin.oclock',	'[\"ROLE_ADMIN\",\"ROLE_USER\"]',	'$2y$13$BEnG9IeAYXwK6B7rKEZ1ver41OjigXBX1YkrdRtvKjGCnmFV3XEZ.',	'admin',	'admin'),
(5,	NULL,	'gassim@diallo-admin.fr',	'[\"ROLE_ADMIN\"]',	'$2y$13$8sNhQmc4CKOVqj.XTEVJPuhd6vZoMqwNEKChgo6Z56h5U92eK7OKS',	'Diallo',	'Gassim'),
(7,	NULL,	'diallo.gassim@oclock.com',	'[]',	'$2y$13$aLnvrDcvCiEXWFH8ChRDDO3cVTOSyl2UVHYh6jctQ56Kjw8ZDoz12',	'Gassim',	'Diallo'),
(8,	NULL,	'legoff.maxime@oclock.com',	'[]',	'$2y$13$FAGCVX8pFRk7CFIPX4Rnje81LXeRVHc9XqNHn5jTLT9AXduV/cZvO',	'Le goff',	'Maxime'),
(9,	NULL,	'sarloutte.jeremie@oclock.com',	'[]',	'$2y$13$iSPRmtbAlp0ne6oa9QDk1u4XW4X4wUphNj//D8h2fIKwM800DOOu2',	'Sarloutte',	'Jeremie'),
(10,	NULL,	'maxime@admin.fr',	'[\"ROLE_ADMIN\"]',	'$2y$13$hz1OiS8j3VEH4pfmhj8NVOWtLE4zhFP6qKFNf3DwWqGkRsU.zhRdK',	'Le goff',	'Maxime'),
(11,	NULL,	'jeremie@sarloutte.fr',	'[\"ROLE_ADMIN\"]',	'$2y$13$2lBzuyapakHj3A1A.pINe.hDurUQ5oIFp.3737kBH2IbptqXBRaM6',	'Sarloutte',	'Jeremie'),
(12,	NULL,	'sari@mennel.fr',	'[]',	'$2y$13$vgit2/ZOilwWj2pkTicaw.n6tJWQbXMiEI4cOT97kkq0J1DfZleY.',	'Mennel',	'Sari'),
(14,	NULL,	'hezfbhjfe@sdgds.fr',	'[]',	'$2y$13$hJvy8yBxvkH46rPyZSiyK.eTaBIaRNQANSRA7doULCbViDANtbkcW',	'azfaz',	'azfafz');

-- 2024-02-27 09:29:13
