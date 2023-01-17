-- Adminer 4.8.1 MySQL 10.9.2-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `items` (`id`, `brand`, `model`, `category`, `price`, `amount`, `description`, `created_at`, `image_path`) VALUES
(1,	'Jackson',	'JS22 DKA Dinky AH Snow White',	'Elektrická gitara',	245,	6,	'',	'2022-01-04 17:28:24',	'guitars/electric guitars/Jackson JS22 DKA Dinky AH Snow White.png'),
(2,	'Fender',	'Squier Affinity Series Precision Bass PJ MN BPG Čierna',	'Basgitara',	255,	6,	'',	'2023-01-04 17:28:24',	'guitars/bass guitars/Fender Squier Affinity Series Precision Bass PJ MN BPG Čierna.png'),
(5,	'ESP',	'LTD BB-600 Baritone Ben Burnley Black Sunburst',	'Elektrická gitara',	1889,	10,	'',	'2023-01-04 17:28:24',	'guitars/electric guitars/ESP LTD BB-600 Baritone Ben Burnley Black Sunburst.png'),
(6,	'Fender',	'Squier FSR Classic Vibe \'50s Telecaster MN Vintage Blonde',	'Elektrická gitara',	439,	30,	'',	'2023-01-04 17:28:24',	'guitars/electric guitars/Fender Squier FSR Classic Vibe \'50s Telecaster MN Vintage Blonde.png'),
(7,	'Fender',	'Player Series P Bass MN Čierna',	'Basgitara',	799,	0,	'',	'2023-01-04 17:28:24',	'guitars/bass guitars/Fender Player Series P Bass MN Čierna.png'),
(8,	'Epiphone',	'DR-100 Natural',	'Akustická gitara',	141,	15,	'',	'2023-01-04 17:28:24',	'guitars/acoustic guitars/Epiphone DR-100 Natural.png'),
(9,	'Cort',	'AD810E Open Pore',	'Elektroakustická gitara',	179,	0,	'',	'2023-01-04 17:28:24',	'guitars/electric acoustic guitars/Cort AD810E Open Pore.png'),
(18,	'Ibanez ',	'GRG170DX-BKN Black Night',	'Elektrická gitara',	279,	2,	'Elektrická gitara zo série GRG, telo vyrobené z lipového dreva, skrutkovaný javorový krk GRG1, palisandrový hmatník s 24 Jumbo pražcami, snímače Humbucker PSND2, Single PSNDS, Humbucker PSND1, chrómový hardware, tremolo kobylka Fat 10, ladiace mechaniky Ibanez, ovládanie Volume, Tone a 5-polohový prepínač s možnosťou rozopínania HB v medzipolohách, prevedenie Black Night.\n\nIbanez GRG170DX je prvá gitara vydaná v sérii Ibanez \'GRG\'. Telo z lipy, javorový krk so žraločou intarziou a chrómový hardware zaisťuje čístý a elegantný vzhľad. Vďaka jednoduchému ovládaniu sa rýchlo stane favoritom gitaristov na všetkých úrovniach. Lipa je pomerne ľahké drevo, ktoré je veľmi pohodlné pre dlhšie hranie. S dobrou rovnováhu pre vzostupy a pády. Vraví sa že v lipe je pravda, charakterom zvuku je niečím medzi mahagonom a jelšou.\nČi už ste začiatočník hľadajúci svoj prvý elektro-aparát alebo profesionál, ktorý má záujem o výborný záložný nástroj, Ibanez GRG alebo GRX sú ideálne modely pre Vás. Ponúkajú kvalitu a záruku ako tie najdrahšie modely.  Ibanez GRG 170DX je veľmi verzatilný nástroj z ohľadu toho aký žáner chcete hrať pretože rozsah jej tónov je veľmi bohatý. Dostupnosť doplnkov je dobrá, čo je ďalší dôvod prečo sa o tomto produkte dá tvrdiť, že ponúka veľkú hodnotu v pomere k cene.',	'2023-01-10 14:17:45',	'guitars/electric guitars/Ibanez GRG170DX-BKN Black Night.png');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `orders_items_id_fk` (`item_id`),
  KEY `orders_users_id_fk` (`user_id`),
  CONSTRAINT `orders_items_id_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `orders_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `orders` (`id`, `user_id`, `item_id`, `created_at`, `updated_at`, `amount`) VALUES
(21,	19,	8,	'2023-01-17 16:06:19',	'2023-01-17 16:06:19',	1);

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `ratings_users_id_fk` (`user_id`),
  KEY `ratings_items_id_fk` (`item_id`),
  CONSTRAINT `ratings_items_id_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `ratings_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `ratings` (`id`, `user_id`, `value`, `review`, `item_id`, `created_at`, `updated_at`) VALUES
(13,	19,	4,	'Donec augue purus, vestibulum non viverra id, sagittis quis leo. Pellentesque sit amet tellus luctus, malesuada mauris in, malesuada purus. Proin sed finibus nisi, tempus vehicula massa. Nulla facilisi. Nulla id sapien nibh. Cras enim risus, accumsan at erat eu, ullamcorper aliquam nulla. Vivamus finibus erat at eros suscipit porttitor non sit amet nisl. Cras congue est eros, in molestie enim mollis ut. Suspendisse auctor sem eros, quis efficitur massa commodo hendrerit. Vivamus faucibus nibh ligula.',	8,	'2023-01-17 16:05:37',	'2023-01-17 16:05:37'),
(14,	19,	3,	'Quisque non vestibulum lacus. Suspendisse nec ornare ipsum. Pellentesque porta mauris quis varius blandit. Etiam suscipit ultrices risus et imperdiet.',	9,	'2023-01-17 17:36:30',	'2023-01-17 17:39:23'),
(15,	21,	5,	'Pellentesque eget varius nisl, non lacinia mi. Suspendisse quis accumsan enim.',	8,	'2023-01-17 18:33:31',	'2023-01-17 19:11:45'),
(16,	21,	5,	'Quisque non vestibulum lacus. Suspendisse nec ornare ipsum. Pellentesque porta mauris quis varius blandit. Etiam suscipit ultrices risus et imperdiet. Cras eu sem consequat, consequat libero quis, rutrum sapien. Fusce malesuada orci in velit elementum, at aliquet orci faucibus. Sed id justo mauris. Praesent vitae est tincidunt, aliquet erat quis, gravida nunc. Vestibulum egestas tellus vel ante cursus sagittis. Suspendisse non lobortis dui. Cras efficitur sollicitudin porttitor. Nunc dignissim facilisis justo at rhoncus. Pellentesque ullamcorper, ligula ut condimentum scelerisque, sem nibh malesuada mi, tincidunt tempus eros velit sit amet lacus. Curabitur dictum vel nisi eget hendrerit. Maecenas laoreet, lorem id gravida blandit, nulla lorem luctus diam, vitae pulvinar felis diam non justo.',	18,	'2023-01-17 18:34:54',	'2023-01-17 18:34:54');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `updated_at`, `created_at`, `remember_token`) VALUES
(19,	'Ruslan',	'Hlazkov',	'rus.glaz1@gmail.com',	'$2y$10$dLR47k.EsqwR70H6u2bcRuWR5p1etAOvUHxOwN2Rn0L5R6gWd3bdO',	'2023-01-17 16:03:20',	'2023-01-17 16:03:20',	NULL),
(20,	'Lorem',	'Ipsum',	'loremipsum@gmail.com',	'$2y$10$VMxL7yCOLFr73rTsoy2Hw.VMhT2W/FzcQRccepqTB4aphOBX42j6S',	'2023-01-17 16:04:29',	'2023-01-17 16:04:29',	NULL),
(21,	'Taras',	'Shevchenko',	'tarasshevchenko@gmail.com',	'$2y$10$4O4S8/FzkAQ1o6VRDGxTkOOyHgfv5TIYELTW4pww1RdKpTYqcRmm6',	'2023-01-17 18:32:26',	'2023-01-17 18:32:26',	NULL);

DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `wishlists_items_id_fk` (`item_id`),
  KEY `wishlists_users_id_fk` (`user_id`),
  CONSTRAINT `wishlists_items_id_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `wishlists_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2023-01-17 20:36:37
