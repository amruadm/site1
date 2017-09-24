-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: public
-- ------------------------------------------------------
-- Server version	5.7.19-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `added_by` bigint(20) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comm_text` text,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fki_added_by_fkey` (`added_by`),
  KEY `fki_post_id_fkey` (`post_id`),
  CONSTRAINT `comm_added_by_fkey` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`),
  CONSTRAINT `post_id_fkey` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,'2017-09-13 02:43:43','И комментик заодно затестил, работает збс :)',1),(5,3,'2017-09-17 01:28:43','ВОУ! ЭТО РАБОТАЕТ!',1);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `permission` mediumtext NOT NULL,
  `world` varchar(50) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`name`,`type`),
  KEY `world` (`world`,`name`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'system',2,'schema_version','','2'),(2,'default',0,'modifyworld.*','',''),(3,'default',0,'default','','true'),(64,'Administrator',0,'inheritance','','[Moderator]'),(69,'19b3d4ea-97ad-34c3-93a7-fc05dc107896',1,'name','','Xerobrine'),(74,'3798693c-9b9b-11e7-8de1-3085a98ec2c8',1,'name','','Naman'),(75,'Player',0,'worldedit.analysis.count','',''),(76,'Player',0,'worldedit.wand.toggle','',''),(77,'Player',0,'worldedit.wand','',''),(78,'Player',0,'worldedit.selection.hpos','',''),(79,'Player',0,'worldedit.selection.pos','',''),(80,'Player',0,'worldedit.navigation.unstuck','',''),(81,'Player',0,'worldguard.region.info','',''),(82,'Player',0,'worldedit.selection.shift','',''),(83,'Player',0,'worldedit.selection.contract','',''),(84,'Player',0,'worldedit.selection.expand','',''),(85,'Player',0,'worldguard.region.flag.regions.own.<region>','',''),(86,'Player',0,'worldguard.region.flag.regions.own.*','',''),(87,'Player',0,'worldguard.region.list.own','',''),(88,'Player',0,'worldguard.region.removemember.own.*','',''),(89,'Player',0,'worldguard.region.addmember.own.*','',''),(90,'Player',0,'worldguard.region.removeowner.own.*','',''),(91,'Player',0,'worldguard.region.addowner.own.*','',''),(92,'Player',0,'worldguard.region.remove.own.*','',''),(93,'Player',0,'worldguard.region.select.own.*','',''),(94,'Player',0,'worldguard.region.claim','',''),(95,'Player',0,'worldguard.region.wand','',''),(96,'Player',0,'lwc.remove','',''),(97,'Player',0,'lwc.info','',''),(98,'Player',0,'lwc.unlock','',''),(99,'Player',0,'lwc.modify','',''),(100,'Player',0,'lwc.create.*','',''),(101,'Player',0,'lwc.protect','',''),(102,'Player',0,'chatex.chat.global','',''),(103,'Player',0,'chatex.allowchat','',''),(104,'Player',0,'worldedit*','',''),(105,'Player',0,'modifyworld.*','',''),(106,'Player',0,'default','','true'),(107,'Player',0,'suffix','','&f'),(108,'Player',0,'prefix','','&8> &7[&6И&7]&f '),(109,'VIP',0,'nicknamegui.use.<color>','',''),(110,'VIP',0,'nicknamegui.use','',''),(111,'VIP',0,'chatex.chat.italic','',''),(112,'VIP',0,'chatex.chat.underline','',''),(113,'VIP',0,'chatex.chat.strikethrough','',''),(114,'VIP',0,'chatex.chat.bold','',''),(115,'VIP',0,'chatex.chat.magic','',''),(116,'VIP',0,'chatex.chat.color','',''),(117,'VIP',0,'chatex.chat.global','',''),(118,'VIP',0,'chatex.allowchat','',''),(119,'VIP',0,'worldedit*','',''),(120,'VIP',0,'modifyworld.*','',''),(121,'VIP',0,'inheritance','','[Player]'),(122,'VIP',0,'default','','false'),(123,'VIP',0,'suffix','','&f'),(124,'VIP',0,'prefix','','&8> &7[&5VIP&7]&f '),(125,'Moderator',0,'citizens.npc.*','',''),(126,'Moderator',0,'citizens.admin.*','',''),(127,'Moderator',0,'quests.editor.*','',''),(128,'Moderator',0,'quests.admin.*','',''),(129,'Moderator',0,'worldedit.drain','',''),(130,'Moderator',0,'worldedit.green','',''),(131,'Moderator',0,'worldedit.help','',''),(132,'Moderator',0,'worldedit.remove','',''),(133,'Moderator',0,'worldedit.butcher','',''),(134,'Moderator',0,'worldedit.extinguish','',''),(135,'Moderator',0,'worldedit.fixwater','',''),(136,'Moderator',0,'worldedit.fixlava','',''),(137,'Moderator',0,'worldedit.fill.recursive','',''),(138,'Moderator',0,'worldedit.fill','',''),(139,'Moderator',0,'worldedit.thaw','',''),(140,'Moderator',0,'worldedit.snow','',''),(141,'Moderator',0,'worldedit.tool.farwand','',''),(142,'Moderator',0,'worldedit.tool.tree','',''),(143,'Moderator',0,'worldedit.brush.options.range','',''),(144,'Moderator',0,'worldedit.brush.options.mask','',''),(145,'Moderator',0,'worldedit.brush.options.size','',''),(146,'Moderator',0,'worldedit.brush.options.material','',''),(147,'Moderator',0,'worldedit.brush.ex','',''),(148,'Moderator',0,'worldedit.brush.gravity','',''),(149,'Moderator',0,'worldedit.brush.smooth','',''),(150,'Moderator',0,'worldedit.brush.cylinder','',''),(151,'Moderator',0,'worldedit.brush.sphere','',''),(152,'Moderator',0,'worldedit.tool.replacer','',''),(153,'Moderator',0,'worldedit.superpickaxe','',''),(154,'Moderator',0,'worldedit.superpickaxe.recursive','',''),(155,'Moderator',0,'worldedit.superpickaxe.area','',''),(156,'Moderator',0,'worldedit.history.redo','',''),(157,'Moderator',0,'worldedit.history.undo','',''),(158,'Moderator',0,'worldedit.clipboard.paste','',''),(159,'Moderator',0,'worldedit.clipboard.cut','',''),(160,'Moderator',0,'worldedit.clipboard.flip','',''),(161,'Moderator',0,'worldedit.clipboard.rotate','',''),(162,'Moderator',0,'worldedit.clipboard.copy','',''),(163,'Moderator',0,'worldedit.region.move','',''),(164,'Moderator',0,'worldedit.regen','',''),(165,'Moderator',0,'worldedit.region.stack','',''),(166,'Moderator',0,'worldedit.region.replace','',''),(167,'Moderator',0,'worldedit.region.walls','',''),(168,'Moderator',0,'worldedit.selection.expand','',''),(169,'Moderator',0,'worldedit.generation.pumpkins','',''),(170,'Moderator',0,'worldedit.generation.forest','',''),(171,'Moderator',0,'worldedit.generation.shape','',''),(172,'Moderator',0,'worldedit.generation.pyramid','',''),(173,'Moderator',0,'worldedit.generation.sphere','',''),(174,'Moderator',0,'worldedit.generation.cylinder','',''),(175,'Moderator',0,'worldedit.region.set','',''),(176,'Moderator',0,'worldedit.biome.set','',''),(177,'Moderator',0,'worldedit.biome.info','',''),(178,'Moderator',0,'worldedit.navigation.thru.command','',''),(179,'Moderator',0,'worldguard.slay.other','',''),(180,'Moderator',0,'worldguard.slay','',''),(181,'Moderator',0,'worldguard.heal.other','',''),(182,'Moderator',0,'worldguard.heal','',''),(183,'Moderator',0,'worldguard.ungod','',''),(184,'Moderator',0,'worldguard.god','',''),(185,'Moderator',0,'lwc.shownotices','',''),(186,'Moderator',0,'lwc.admin','',''),(187,'Moderator',0,'lwc.deny','',''),(188,'Moderator',0,'maxbans.kick','',''),(189,'Moderator',0,'maxbans.warn','',''),(190,'Moderator',0,'maxbans.mute','',''),(191,'Moderator',0,'maxbans.ban','',''),(192,'Moderator',0,'chatex.mod','',''),(193,'Moderator',0,'chatex.chat.global','',''),(194,'Moderator',0,'chatex.allowchat','',''),(195,'Moderator',0,'worldedit*','',''),(196,'Moderator',0,'modifyworld.*','',''),(197,'Moderator',0,'inheritance','','[VIP]'),(198,'Moderator',0,'default','','false'),(199,'Moderator',0,'suffix','','&f'),(200,'Moderator',0,'prefix','','&8> &7[&2М&7]&f '),(201,'Administrator',0,'*','',''),(202,'Administrator',0,'default','','false'),(203,'Administrator',0,'suffix','','&f'),(204,'Administrator',0,'prefix','','&8> &7[&4A&7]&f '),(205,'48d9074c-986c-3d4e-bb60-83df51e0679b',1,'name','','Naman'),(206,'b8773e62-9893-11e7-8de1-3085a98ec2c8',1,'name','','amruadm'),(207,'ff9407f8-3dc5-3202-81d0-e138ce14d121',1,'name','','Joey'),(208,'0363fd3c-e49f-3868-a146-005c06427d15',1,'name','','amruadm');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions_entity`
--

DROP TABLE IF EXISTS `permissions_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`type`),
  KEY `default` (`default`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions_entity`
--

LOCK TABLES `permissions_entity` WRITE;
/*!40000 ALTER TABLE `permissions_entity` DISABLE KEYS */;
INSERT INTO `permissions_entity` VALUES (1,'default',0,0),(2,'19b3d4ea-97ad-34c3-93a7-fc05dc107896',1,0),(3,'Player',0,0),(4,'VIP',0,0),(5,'Moderator',0,0),(6,'Administrator',0,0),(7,'48d9074c-986c-3d4e-bb60-83df51e0679b',1,0),(8,'3798693c-9b9b-11e7-8de1-3085a98ec2c8',1,0),(9,'b8773e62-9893-11e7-8de1-3085a98ec2c8',1,0),(10,'ff9407f8-3dc5-3202-81d0-e138ce14d121',1,0),(11,'0363fd3c-e49f-3868-a146-005c06427d15',1,0);
/*!40000 ALTER TABLE `permissions_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions_inheritance`
--

DROP TABLE IF EXISTS `permissions_inheritance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions_inheritance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child` varchar(50) NOT NULL,
  `parent` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `world` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `child` (`child`,`parent`,`type`,`world`),
  KEY `child_2` (`child`,`type`),
  KEY `parent` (`parent`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions_inheritance`
--

LOCK TABLES `permissions_inheritance` WRITE;
/*!40000 ALTER TABLE `permissions_inheritance` DISABLE KEYS */;
INSERT INTO `permissions_inheritance` VALUES (15,'0363fd3c-e49f-3868-a146-005c06427d15','Administrator',1,NULL),(9,'19b3d4ea-97ad-34c3-93a7-fc05dc107896','Administrator',1,NULL),(10,'3798693c-9b9b-11e7-8de1-3085a98ec2c8','Administrator',1,NULL),(11,'48d9074c-986c-3d4e-bb60-83df51e0679b','Administrator',1,NULL),(12,'b8773e62-9893-11e7-8de1-3085a98ec2c8','Administrator',1,NULL),(13,'ff9407f8-3dc5-3202-81d0-e138ce14d121','Administrator',1,NULL);
/*!40000 ALTER TABLE `permissions_inheritance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT 'Empty',
  `added_by` bigint(20) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `body` text,
  `image` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fki_a` (`added_by`),
  CONSTRAINT `post_added_by_fkey` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'Теперь мы на мускуле!',1,'2017-09-13 02:30:04','Променял старый добрый postgres на mysql. Ну и ладно, дохуя от базы не требую,  так что идите нахуй я дартаньян','picture20170914.png'),(2,'Что ещё нового?!',2,'2017-09-13 07:45:12','Изменили авторизацию! Теперь лаунч сервер может авторизовать пользователей!\r\nЕсть пермишены!','picture20170914.png'),(4,'Новая фича!',1,'2017-09-23 15:13:52','Подгружаются файлы! С защитой от дурака и другой нечисти! \r\nБеееач!','picture20170924011352.jpeg');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(16) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uuid` char(36) DEFAULT NULL,
  `accessToken` char(32) DEFAULT NULL,
  `serverID` varchar(41) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_key` (`login`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'amruadm','b1b3773a05c0ed0176787a4f1574ff0075f7521e','2017-09-13 02:28:26','b8773e62-9893-11e7-8de1-3085a98ec2c8','1d0c9482b97173796fadd0114eb6eacb',NULL),(2,'lalka','b1b3773a05c0ed0176787a4f1574ff0075f7521e','2017-09-13 06:23:43','eac96c97-989f-11e7-8de1-3085a98ec2c8',NULL,NULL),(3,'Naman','89d9a4b444b7ec2f4697e889a765f007a0100da1','2017-09-17 01:27:46','3798693c-9b9b-11e7-8de1-3085a98ec2c8','860ee7914071d569254e7b2b6a48f29f','-746c2979ce021e8e1f776d5903ac74f3b5259812'),(4,'Joey','c9509125a9b664b82e101c871fb0c4f361f6bcfb','2017-09-18 00:45:13','7540d025-9c5e-11e7-a083-3085a98ec2c8','7f68adcd1ef6c7fa81fde2016b6aa6de',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER setUUID BEFORE INSERT ON user
FOR EACH ROW BEGIN
IF NEW.uuid IS NULL THEN
SET NEW.uuid = UUID();
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'public'
--

--
-- Dumping routines for database 'public'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-24 23:35:31
