
-- 
-- Tabel structuur voor tabel `pogingentabel`
-- 

DROP TABLE IF EXISTS `pogingentabel`;
CREATE TABLE `pogingentabel` (
  `poging_id` int(12) NOT NULL default '0',
  `persoon_id` smallint(11) NOT NULL default '0',
  `pogingnummer` tinyint(4) NOT NULL default '0',
  `pogingnaam` varchar(30) NOT NULL default 'ik doe het liever zelf alleen',
  `startdatum` date NOT NULL default '0000-00-00',
  `evaldatum` date NOT NULL default '0000-00-00',
  `strategie` smallint(4) default '0',
  `personalmax` smallint(4) default '0',
  `aanpakzelf` smallint(4) default '0',
  `aanpaksamen` smallint(4) default '0',
  `aanpakmedic` smallint(4) default '0',
  `aanpakprofes` smallint(4) default '0',
  `leservan` smallint(50) default '0',
  PRIMARY KEY  (`poging_id`),
  KEY `persoon_id ` (`persoon_id`),
  KEY `pogingnaam` (`pogingnaam`),
  KEY `pogingnummer` (`pogingnummer`)
) TYPE=MyISAM;

-- 
-- Gegevens worden uitgevoerd voor tabel `pogingentabel`
-- 

INSERT INTO `pogingentabel` VALUES (0, 5, 0, '', '2006-09-24', '0000-00-00', 2006, 3, 1, 0, 0, 0, 0);