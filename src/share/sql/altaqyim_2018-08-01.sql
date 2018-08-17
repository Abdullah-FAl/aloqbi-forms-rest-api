# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.35)
# Database: altaqyim
# Generation Time: 2018-08-01 12:02:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table employee
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(255) NOT NULL,
  `employee_number` int(11) NOT NULL,
  `jobـname` varchar(255) NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table evaluation_results
# ------------------------------------------------------------

DROP TABLE IF EXISTS `evaluation_results`;

CREATE TABLE `evaluation_results` (
  `e_results_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `tasks_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL,
  `e_results` int(11) NOT NULL,
  `e_deta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`e_results_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table standard
# ------------------------------------------------------------

DROP TABLE IF EXISTS `standard`;

CREATE TABLE `standard` (
  `standard_id` int(11) NOT NULL AUTO_INCREMENT,
  `standard_title` longtext NOT NULL,
  `standard_description` longtext NOT NULL,
  PRIMARY KEY (`standard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `tasks_id` int(11) NOT NULL AUTO_INCREMENT,
  `tasks_title` longtext NOT NULL,
  `tasks_description` longtext NOT NULL,
  PRIMARY KEY (`tasks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tasks_standard
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks_standard`;

CREATE TABLE `tasks_standard` (
  `tasks_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_fullname` longtext NOT NULL,
  `user_level` longtext NOT NULL,
  `user_levelname` longtext NOT NULL,
  `user_jobname` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_fullname`, `user_level`, `user_levelname`, `user_jobname`)
VALUES
	(1,'admin','$2y$10$ktWB9d35UNGPUuATCWqrHuEvL6mjHLksq715BDBhEBLoMeAaevfki','عبد الله محمد فال','master','مدير النظام','التقني الأول'),
	(2,'c','$2y$10$ggxCMAyf8J6aAULZTx2uNO2AppCQPwb.tUDyztCj2sFSlk/q5kqDa','c','1','إضافة المحاور و الأسئلة','c'),
	(3,'d','$2y$10$xxko2HsHA2Lkz./IxXt8N./hFSS.4wQ5ELFz85fwJ0OYbVGhlps4i','d','2',' الشيخ','d');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
