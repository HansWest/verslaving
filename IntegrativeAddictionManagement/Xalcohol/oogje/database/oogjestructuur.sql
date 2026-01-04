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
projectid smallint(11) NOT NULL default '0',
krediet decimal(6,0) NOT NULL default '0',
gebdat date NOT NULL default '0000-00-00',
-- jjjj mm dd
gender smallint(4) default NULL,
-- 1=man 0=vrouw
functie varchar(20) NOT NULL default '',
clearance smallint(2) default '0',
-- clearance  2=betaald 1, 4= betaald 3, 6=betaald 5
werkdag smallint(3) default '8',
-- werkdag in uur
werkweek smallint(3) default '36',
-- werkweek in uur
PRIMARY KEY  (persoon_id),
KEY projectid (projectid),
KEY krediet (krediet)
) TYPE=MyISAM AUTO_INCREMENT=101 ;


-- 
-- Gegevens worden uitgevoerd voor tabel oogjepersonen
-- 

INSERT INTO `oogjepersonen` VALUES (0, 'meizekePapapapa', 'karin@fuzzybrush.nl', 'Karin', 'Berwald', 'b7626fe60f276ad29fbeefca8cb99336', '212.83.243.18', 'e8636440ac633c05b23a6e9306d54b4a', 1, '2006-09-05', '', '', 100, 1000000, '0000-00-00', NULL, 'bossinnetje', 0, 8, 36);
-- papapapa
INSERT INTO `oogjepersonen` VALUES (1, 'fuzzyboss', 'info@helpdisk.nl', 'Hans', 'West', '7c825fa585a01b4bfb978c92cf1981b1', '212.83.243.18', 'efbc0ac03d6f5a6bd12de3802fd793fb', 1, '2006-09-05', '06 55861554', 'dhr', 100, 1000000, '0000-00-00', NULL, 'boss', 0, 8, 36);
-- ronaldjacob
INSERT INTO `oogjepersonen` VALUES (100, 'delta03', 'jonnydelta@pt.lu', 'Johnny', 'Delta', '37fc88e8479af829479b45dfddc55225', '212.83.243.18', '08b41fa545f01728ff5029a2ffc83227', 1, '2006-09-05', '', 'dhr', 100, 1000000, '0000-00-00', NULL, 'BigBoss', 0, 8, 36);
-- delta03       

INSERT INTO oogjepersonen ( persoon_id , user_name , emailadres , voornaam , achternaam , paswoord , remote_addr , confirm_hash , is_confirmed , date_created , smsfoon , titel , projectid , krediet , gebdat , gender , functie , clearance , werkdag , werkweek ) 
VALUES (3, 'usernaam', 'email@helpdisk.nl', 'voornaam', 'achternaam', 'pass', '01:0:10', 'hash', 0, '2006-01-01', '06 55861554', 'dhr', 100, 1000000, '1959-01-27', 1, 'boss', 6, 8, 36);

-- 
-- --------------------------------------------------------
-- 
-- Tabel structuur voor tabel oogjetaken
-- 
DROP TABLE IF EXISTS oogjetaken;
CREATE TABLE IF NOT EXISTS oogjetaken (
taakid smallint(11) NOT NULL auto_increment,
persoon_id tinyint(10) NOT NULL default '0',
-- voor wie is dit idee of todo of agenda
vanwie_id tinyint(10) NOT NULL default '0',
-- van wie kome idee ofopdracht
terugrap tinyint(4) NOT NULL default '0',
-- verschillende niveaus van terurapportage
projectid smallint(11) NOT NULL default '0',
percentvoltooid tinyint(4) NOT NULL default '0',
-- 100 (%) == klaar
idtdagniveau tinyint(3) NOT NULL default '0',
-- 1== ideeniveau 2 == to do niveau 3 == agenda niveau 4== klaarmaarbewaard 8==verworpen idee 9== nietklaar maar bewaard
wanneerstartdatumtijd date NOT NULL default '0000-00-00',
wanneerduedatumtijd datetime NOT NULL default '0000-00-00 00:00:00',
-- WANNEER duedate voor todo, is ook agenda-einddatum
alarmdatumtijd datetime NOT NULL default '0000-00-00 00:00:00',
urgentie tinyint(2) NOT NULL default '0',
imptortantie tinyint(2) NOT NULL default '0',
verwachteduur tinyint(2) NOT NULL default '8',
-- in uren ( 8 = 1 werkdag)
herhaling tinyint(3) NOT NULL default '0',
-- in dagen als niet nul dan als to do kopieren 
kosten decimal(10,0) NOT NULL default '0',
-- voor toekomst
evaldatum date NOT NULL default '0000-00-00',
-- ook te gebruiken voor terurapportage
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

-- 
-- Gegevens worden uitgevoerd voor tabel oogjetaken
-- 
INSERT INTO oogjetaken ( taakid , persoon_id , vanwie_id , terugrap , projectid , percentvoltooid , idtdagniveau , wanneerstartdatumtijd , wanneerduedatumtijd , alarmdatumtijd , urgentie , imptortantie , verwachteduur , herhaling , kosten , evaldatum , evaluatiedoor , idstartvoorwaarde , wattaakomsch , history ) 
VALUES (
'100', '0', '1', '0', '100', '0', '0', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '8', '0', '0', '0000-00-00', NULL , NULL , 'de dinges brief voor seaborn maken', NULL
);


-- --------------------------------------------------------
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
INSERT INTO oogjeteams ( team_id , team_naam , startdatum ) 
VALUES (
'100', 'Fuzzy Bosses', '2006-08-20'
);


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
duedatum date NOT NULL default '0000-00-00',
maildatum date NOT NULL default '0000-00-00',
dagntotvlgnd tinyint(3) NOT NULL default '7',
-- volgende week nieuwe rapportage
KEY projectid (projectid)
) TYPE=MyISAM;
-- --------------------------------------------------------
INSERT INTO oogjeprojecten ( projectid , projectnaam , startdatum , maildatum , dagntotvlgnd ) 
VALUES (
'100', 'Fuzzy Brush BNL', '2006-07-01', '0000-00-00', '7'
)