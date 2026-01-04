
-- ------------------------------------------------------
-- Tabel structuur voor tabel eventstabel
-- --------------------------------------------------------
DROP TABLE IF EXISTS eventstabel;
CREATE TABLE eventstabel (
event_id smallint(11) NOT NULL auto_increment,
persoon_id smallint(11) NOT NULL default '0',
event_tekst varchar(80) default NULL,
event_afgeleerd varchar(80) default 'nog in te vullen',
event_aangeleerd varchar(80) default 'nog in te vullen',
event_les varchar(80) default 'nog in te vullen',
event_leeftijd smallint(4) NOT NULL default '0',
event_gewicht smallint(4) NOT NULL default '0',
PRIMARY KEY (event_id),
KEY persoon_id (persoon_id)
) TYPE=MyISAM AUTO_INCREMENT=100 ;

-- Gegevens worden uitgevoerd voor tabel eventstabel
INSERT INTO eventstabel VALUES (1,0,'suicide dreiging van ma','grenzen te stellen naar mensen met verdriet','verantwoordelijk te voelen voor dingen van ANDEREN','ZELF verantwoordelijk zijn','12','9');
