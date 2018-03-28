# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.38)
# Database: filsdeculte
# Generation Time: 2018-03-28 13:29:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tweets
# ------------------------------------------------------------

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;

INSERT INTO `tweets` (`id`, `id_tweet`, `user_tweet`, `target_tweet`, `movie_title`, `created_at`, `updated_at`, `created_tweet_time`, `tweet_user_id`, `target_user_id`, `spoil`, `isSpoiled`, `isFailed`)
VALUES
	(54,'975384249900720128','HMoncenis','HMoncenis','jeuxdenfants','2018-03-18 16:53:44','2018-03-18 16:53:45','14:51:41','2210477268','964112547589820416','A la fin ils finissent coulés dans un bloc de béton.',1,0),
	(85,'975848177055293440','HMoncenis','HMoncenis','djangounchained','2018-03-19 22:05:09','2018-03-19 22:05:10','21:35:10','2210477268','964112547589820416','A la fin le docteur King Schultz se fait tuer et Django récupère sa femme.',1,0),
	(87,'976549814174396416','HMoncenis','HMoncenis','hairspray','2018-03-21 20:06:00','2018-03-21 20:06:01','20:03:13','2210477268','964112547589820416','A la fin c\'est Inez qui gagne le concours Hairspray.',1,0),
	(90,'976572301448761345','TestFilsDeCulte','TestFilsDeCulte','330themovie','2018-03-21 21:32:50','2018-03-21 21:32:51','21:32:35','976571313866330112','964112547589820416','',0,1),
	(91,'976572168879443973','TestFilsDeCulte','TestFilsDeCulte','jeuxdenfants','2018-03-21 21:33:07','2018-03-21 21:33:08','21:32:03','976571313866330112','976571313866330112','A la fin ils finissent coulés dans un bloc de béton.',1,0),
	(92,'976573583567843328','TestFilsDeCulte','TestFilsDeCulte','test','2018-03-21 21:38:27','2018-03-21 21:38:28','21:37:40','976571313866330112','976571313866330112','A la fin il se perce un trou dans la tête pour oublier les mathématiques.',1,0),
	(94,'976574067628302337','TestFilsDeCulte','TestFilsDeCulte','127heures','2018-03-21 21:40:22','2018-03-21 21:40:22','21:39:36','976571313866330112','976571313866330112','A la fin il se coupe le bras.',1,0),
	(97,'976576549502713856','TestFilsDeCulte','TestFilsDeCulte','verybadtrip','2018-03-21 21:51:22','2018-03-21 21:51:23','21:49:27','976571313866330112','976571313866330112','',0,1),
	(98,'976766588492840961','TestFilsDeCulte','TestFilsDeCulte','hello','2018-03-22 10:25:27','2018-03-22 10:25:28','10:24:36','976571313866330112','976571313866330112','',0,1),
	(99,'976937459090182144','TestFilsDeCulte','TestFilsDeCulte','127heures','2018-03-22 21:44:14','2018-03-22 21:44:14','21:43:35','976571313866330112','976571313866330112','A la fin il se coupe le bras.',1,0);

/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
