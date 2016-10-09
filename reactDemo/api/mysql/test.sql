# Host: localhost  (Version: 5.5.40)
# Date: 2015-09-20 13:25:57
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "t_class"
#

DROP TABLE IF EXISTS `t_class`;
CREATE TABLE `t_class` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) DEFAULT NULL,
  `t_num` int(11) DEFAULT NULL,
  `t_manager` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

#
# Data for table "t_class"
#

/*!40000 ALTER TABLE `t_class` DISABLE KEYS */;
INSERT INTO `t_class` VALUES (50,'英语一班111',123,'我老师'),(54,'计算机网络一班',45,'纪老师'),(55,'计算机应用三班',76,'马天林');
/*!40000 ALTER TABLE `t_class` ENABLE KEYS */;

#
# Structure for table "t_report"
#

DROP TABLE IF EXISTS `t_report`;
CREATE TABLE `t_report` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `t_chinese` decimal(10,1) DEFAULT NULL COMMENT '语文',
  `t_math` decimal(10,1) DEFAULT NULL COMMENT '数学',
  `t_english` decimal(10,1) DEFAULT NULL COMMENT '英语',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "t_report"
#

/*!40000 ALTER TABLE `t_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_report` ENABLE KEYS */;

#
# Structure for table "t_student"
#

DROP TABLE IF EXISTS `t_student`;
CREATE TABLE `t_student` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) DEFAULT NULL,
  `t_sex` varchar(10) DEFAULT NULL,
  `t_birth` date DEFAULT NULL,
  `t_height` smallint(6) DEFAULT NULL,
  `t_tel` varchar(50) DEFAULT NULL,
  `t_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "t_student"
#

/*!40000 ALTER TABLE `t_student` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_student` ENABLE KEYS */;
