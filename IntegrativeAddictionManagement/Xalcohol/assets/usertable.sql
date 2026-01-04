-- MySQL dump 8.22
--
-- Host: localhost    Database: registration
---------------------------------------------------------
-- Server version	3.23.53a

--
-- Table structure for table 'user'
--

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  user_id int(11) NOT NULL auto_increment,
  user_name tinytext,
  first_name tinytext,
  last_name tinytext,
  password tinytext,
  email tinytext,
  remote_addr tinytext,
  confirm_hash tinytext,
  is_confirmed tinyint(4) default NULL,
  date_created date default NULL,
  PRIMARY KEY  (user_id)
) TYPE=MyISAM;

/*!40000 ALTER TABLE user DISABLE KEYS */;

--
-- Dumping data for table 'user'
--


LOCK TABLES user WRITE;

/*!40000 ALTER TABLE user ENABLE KEYS */;
UNLOCK TABLES;

