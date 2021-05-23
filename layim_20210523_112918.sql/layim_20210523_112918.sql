-- MySQL dump 10.13  Distrib 5.6.49, for Linux (x86_64)
--
-- Host: localhost    Database: layim
-- ------------------------------------------------------
-- Server version	5.6.49-log

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
-- Table structure for table `layim_friends`
--

DROP TABLE IF EXISTS `layim_friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layim_friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `friend_id` int(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`friend_id`,`group_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layim_friends`
--

LOCK TABLES `layim_friends` WRITE;
/*!40000 ALTER TABLE `layim_friends` DISABLE KEYS */;
INSERT INTO `layim_friends` VALUES (1,2,1,1),(2,3,1,1),(3,4,1,2),(4,1,2,4);
/*!40000 ALTER TABLE `layim_friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layim_group`
--

DROP TABLE IF EXISTS `layim_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layim_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layim_group`
--

LOCK TABLES `layim_group` WRITE;
/*!40000 ALTER TABLE `layim_group` DISABLE KEYS */;
INSERT INTO `layim_group` VALUES (1,'我的朋友',1),(2,'我的同学',1),(3,'我的同事',1),(4,'我的朋友',2);
/*!40000 ALTER TABLE `layim_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layim_ing`
--

DROP TABLE IF EXISTS `layim_ing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layim_ing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layim_ing`
--

LOCK TABLES `layim_ing` WRITE;
/*!40000 ALTER TABLE `layim_ing` DISABLE KEYS */;
/*!40000 ALTER TABLE `layim_ing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layim_message`
--

DROP TABLE IF EXISTS `layim_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layim_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `active_id` int(11) DEFAULT '0' COMMENT '主动id',
  `passive_id` int(11) DEFAULT '0' COMMENT '被动id',
  `status` int(11) DEFAULT '0' COMMENT '0:未处理  1：同意    2：拒绝',
  PRIMARY KEY (`id`),
  KEY `active_id` (`active_id`,`passive_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layim_message`
--

LOCK TABLES `layim_message` WRITE;
/*!40000 ALTER TABLE `layim_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `layim_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layim_qun`
--

DROP TABLE IF EXISTS `layim_qun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layim_qun` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qun_name` varchar(255) DEFAULT NULL,
  `user_ids` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layim_qun`
--

LOCK TABLES `layim_qun` WRITE;
/*!40000 ALTER TABLE `layim_qun` DISABLE KEYS */;
INSERT INTO `layim_qun` VALUES (1,'php交流群','1'),(2,'mysql交流群','1'),(3,'swoole交流群','1'),(4,'go交流群','1'),(5,'layui交流群','1'),(6,'鸿蒙os','1'),(7,'闲聊瞎砍','1');
/*!40000 ALTER TABLE `layim_qun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layim_user`
--

DROP TABLE IF EXISTS `layim_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layim_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login_time` varchar(20) DEFAULT NULL,
  `create_time` varchar(20) DEFAULT NULL,
  `qun_id` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL COMMENT '别名',
  `sign` varchar(255) DEFAULT NULL,
  `touxiang` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'hidden' COMMENT 'hidden离线 online在线',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layim_user`
--

LOCK TABLES `layim_user` WRITE;
/*!40000 ALTER TABLE `layim_user` DISABLE KEYS */;
INSERT INTO `layim_user` VALUES (1,'yaya','123456','1621387849','1621387849',NULL,'亚龙','我是张亚龙','http://q1.qlogo.cn/g?b=qq&nk=1003713200&s=100','online'),(2,'feifei','123456','1621387849','1621387849',NULL,'张飞','1','http://q1.qlogo.cn/g?b=qq&nk=1003713200&s=100','online'),(3,'beibei','123456','1621387849','1621387849',NULL,'刘备','1','http://q1.qlogo.cn/g?b=qq&nk=1003713200&s=100','hidden'),(4,'yuyu','123456','1621387849','1621387849',NULL,'关羽','','http://q1.qlogo.cn/g?b=qq&nk=1003713200&s=100','hidden');
/*!40000 ALTER TABLE `layim_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-23 11:29:19
