
-- Database: OOGJE
-- --------------------------------------------------------
-- Tabel structuur voor tabel oogjepersonen
-- --------------------------------------------------------

DROP TABLE IF EXISTS oogjepersonen;
CREATE TABLE oogjepersonen (
  persoon_id smallint(11) NOT NULL auto_increment,
  user_name varchar(20) NOT NULL default '',
  emailadres varchar(35) NOT NULL default '',
  voornaam varchar(20) NOT NULL default '',
  achternaam varchar(30) NOT NULL default '',
  paswoord varchar(50) NOT NULL default '',
  remote_addr varchar(20) NOT NULL default '',
  confirm_hash varchar(50) NOT NULL default '',
  is_confirmed smallint(4) default NULL,
  date_created date default NULL,
  smsfoon varchar(15) NOT NULL default '',
-- smsfoon  foon waarop smsjes ontvangen kunnen worden
  titel varchar(5) NOT NULL default '',
  krediet decimal(6,0) NOT NULL default '0',
  gebdat date NOT NULL default '0000-00-00',
  gender smallint(4) default NULL,
  functie varchar(20) NOT NULL default '',
clearance smallint(2) default '0',
-- clearance  2=betaald 1, 4= betaald 3, 6=betaald 5
werkdag smallint(3) default '8',
-- werkdag in uur
werkweek smallint(3) default '36',
-- werkweek in uur
  PRIMARY KEY  (persoon_id),
  KEY krediet (krediet)
) TYPE=MyISAM AUTO_INCREMENT=102 ;

-- 
-- Gegevens worden uitgevoerd voor tabel oogjepersonen
-- 

INSERT INTO oogjepersonen VALUES (101, 'meizekePapapapa', 'karin@fuzzybrush.nl', 'Karin', 'Berwald', 'b7626fe60f276ad29fbeefca8cb99336', '212.83.243.18', 'e8636440ac633c05b23a6e9306d54b4a', 1, '2006-09-05', '', '', 1000000, '0000-00-00', NULL, 'bossinnetje', 0, 8, 36);
INSERT INTO oogjepersonen VALUES (1, 'fuzzyboss', 'info@helpdisk.nl', 'Hans', 'West', '7c825fa585a01b4bfb978c92cf1981b1', '212.83.243.18', 'efbc0ac03d6f5a6bd12de3802fd793fb', 1, '2006-09-05', '06 55861554', 'dhr', 1000000, '0000-00-00', NULL, 'boss', 0, 8, 36);
INSERT INTO oogjepersonen VALUES (100, 'delta03', 'jonnydelta@pt.lu', 'Johnny', 'Delta', '37fc88e8479af829479b45dfddc55225', '212.83.243.18', '08b41fa545f01728ff5029a2ffc83227', 1, '2006-09-05', '', 'dhr', 1000000, '0000-00-00', NULL, 'BigBoss', 0, 8, 36);
        
-- 

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel oogjetaken
-- 

DROP TABLE IF EXISTS oogjetaken;
CREATE TABLE IF NOT EXISTS oogjetaken (
taakid smallint(11) NOT NULL auto_increment,
persoon_id smallint(11) NOT NULL default '0',
vanwie_id smallint(11) NOT NULL default '0',
terugrap smallint(11) NOT NULL default '0',
projectid smallint(11) NOT NULL default '0',
percentvoltooid tinyint(3) NOT NULL default '0',
-- 100 (%) == klaar
idtdagniveau tinyint(3) NOT NULL default '0',
wanneerstartdatumtijd date NOT NULL default '0000-00-00',
wanneerduedatumtijd datetime NOT NULL default '0000-00-00 00:00:00',
-- WANNEER duedate voor todo, is ook agenda-einddatum
alarmdatumtijd datetime NOT NULL default '0000-00-00 00:00:00',
-- voor toekomst
urgentie tinyint(2) NOT NULL default '0',
imptortantie tinyint(2) NOT NULL default '0',
verwachteduur tinyint(2) NOT NULL default '8',
-- in uren ( 8 = 1 werkdag)
herhaling tinyint(3) NOT NULL default '0',
-- in dagen als niet nul dan als to do kopieren 
kosten decimal(10,0) NOT NULL default '0',
evaldatum date NOT NULL default '0000-00-00',
evaluatiedoor smallint(11) default NULL,
idstartvoorwaarde smallint(11) default NULL,
-- als in 1 dag
wattaakomsch varchar(160) default NULL,
--  WAT in werkwoorden
waar varchar(50) default 'nvt',
-- welke lokatie
wie varchar(50) default 'nvt',
-- betrokkenen
created datetime NOT NULL default '0000-00-00 00:00:00',
history varchar(160) default NULL,
-- alle veranderingen
PRIMARY KEY (taakid),
KEY persoon_id (persoon_id),
KEY projectid (projectid)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Gegevens worden uitgevoerd voor tabel oogjetaken
-- 


-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel oogjeideen
-- 

DROP TABLE IF EXISTS oogjeideen;
CREATE TABLE IF NOT EXISTS oogjeideen (
ideeid smallint(11) NOT NULL auto_increment,
subidee_nav_id tinyint(11) NOT NULL default '0',
vanwieid tinyint(11) NOT NULL default '0',
persoon_id tinyint(11) NOT NULL default '0',
projectid smallint(11) NOT NULL default '0',
datumtijd datetime NOT NULL default '0000-00-00 00:00:00',
soort varchar(6) default 'oogje',
ideenote varchar(160) default NULL,
uitgewerkt tinyint(11) NOT NULL default '0',
terugrapaanid tinyint(11) NOT NULL default '0',
-- kan persoon zelf zijn 0 = niet aan zichzelf maar meestal rapport
PRIMARY KEY (ideeid),
KEY persoon_id (persoon_id),
KEY vanwieid (vanwieid)
) TYPE=MyISAM;

-- 
-- Gegevens worden uitgevoerd voor tabel berichtjes
-- 

-- 
-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel oogjemail
-- 

DROP TABLE IF EXISTS oogjemail;
CREATE TABLE IF NOT EXISTS oogjemail (
berichtid smallint(11) NOT NULL auto_increment,
persoon_id tinyint(11) NOT NULL default '0',
aanwieid tinyint(11) NOT NULL default '0',
-- kan persoon zelf zijn aan zichzelf maar meestal rapport
projectid smallint(11) NOT NULL default '0',
datumtijd datetime NOT NULL default '0000-00-00 00:00:00',
soort varchar(6) default 'oogje',
bericht varchar(160) default NULL,
PRIMARY KEY (berichtid),
KEY persoon_id (persoon_id),
KEY vanwieid (aanwieid)
) TYPE=MyISAM;

-- 
-- Gegevens worden uitgevoerd voor tabel oogjemail
-- 

-- --------------------------------------------------------
-- 
-- Tabel structuur voor tabel oogjeteams
-- 
-- --------------------------------------------------------

DROP TABLE IF EXISTS oogjeteams;
CREATE TABLE IF NOT EXISTS oogjeteams (
team_id smallint(11) NOT NULL auto_increment,
team_naam varchar(25) default NULL,
startdatum date NOT NULL default '0000-00-00',
-- codes voor de get referenties om onduidelijker te maken? ik denk aan een 'opdracht'=getal met een replace en een explode ("0 0") oid tot opdrachten wordt verzameld
KEY team_id (team_id)
) TYPE=MyISAM;
-- --------------------------------------------------------

-- --------------------------------------------------------
-- 
-- Tabel structuur voor tabel oogjeprojecten
-- 
-- --------------------------------------------------------

DROP TABLE IF EXISTS oogjeprojecten;
CREATE TABLE IF NOT EXISTS oogjeprojecten (
projectid smallint(11) NOT NULL auto_increment,
projectnaam varchar(25) default NULL,
startdatum date NOT NULL default '0000-00-00',
maildatum date NOT NULL default '0000-00-00',
dagntotvlgnd tinyint(3) NOT NULL default '7',
-- volgende week nieuwe rapportage
KEY projectid (projectid)
) TYPE=MyISAM;
-- --------------------------------------------------------

