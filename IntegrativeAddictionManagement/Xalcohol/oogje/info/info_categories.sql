-- --------------------------------------------------------
-- Tabel structuur voor tabel info_categories
-- --------------------------------------------------------
DROP TABLE IF EXISTS info_categories;
CREATE TABLE IF NOT EXISTS info_categories (
infoid smallint(11) NOT NULL auto_increment,
persoon_id tinyint(10) NOT NULL default '0',
percentvoltooid tinyint(3) NOT NULL default '0',
-- 100 (%) == klaar
wanneerstartdatumtijd date NOT NULL default '0000-00-00',
wanneerduedatumtijd datetime NOT NULL default '0000-00-00 00:00:00',
-- WANNEER duedate voor todo, is ook agenda-einddatum
urgentie tinyint(2) NOT NULL default '0',
imptortantie tinyint(2) NOT NULL default '0',
verwachteduur tinyint(2) NOT NULL default '8',
-- in uren ( 8 = 1 werkdag)
herhaling tinyint(3) NOT NULL default '0',
-- in dagen als niet nul dan als to do kopieren 
kosten decimal(10,0) NOT NULL default '0',
alarmdatumtijd datetime NOT NULL default '0000-00-00 00:00:00',
-- voor toekomst
evaldatum date NOT NULL default '0000-00-00',
evaluatiedoor smallint(11) default NULL,
idstartvoorwaarde smallint(11) default NULL,
-- als in 1 dag
wattaakomsch varchar(160) default NULL,
--  WAT in werkwoorden
history varchar(160) default NULL,
-- alle veranderingen
PRIMARY KEY (taakid),
KEY persoon_id (persoon_id),
KEY projectid (projectid)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- Gegevens worden uitgevoerd voor tabel info_categories
