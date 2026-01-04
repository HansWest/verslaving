-- --------------------------------------------------------
-- Tabel structuur voor tabel maatschaplktabel
-- --------------------------------------------------------
-- beschrijving van de maatschappelijke leefsituatie
DROP TABLE IF EXISTS maatschaplktabel;
CREATE TABLE maatschaplktabel (
persoon_id smallint(11) NOT NULL,
partner_id smallint(11) default NULL,
-- de id van de partner
kids smallint(4) default '0',
-- aantal kinderen
kidsinwonend smallint(4) default '0',
-- aantal inwonende kinderen
woon_sit smallint(4) default NULL,
-- 1 inwonend bij ouders/opvoeders  2 inwonend in hulpverl.instelling  3 alleen-wonend  4 alleen-wonend met inwonende kinderen  5 samen wonend met partner  6 samenwonend communeverband
opleidingniv smallint(4) default NULL,
--  1 Lagere school 2 Lager Voorbereidend Onderwijs  3 Middelbaar Voorbereidend Onderwijs  4 Hoger Voorbereidend Onderwijs  5 Lager Beroeps Onderwijs (niet afgemaakt)  6 Lager Beroeps Onderwijs (afgemaakt)  7 Middelbaar Beroeps Onderwijs (niet afgemaakt)  8 Middelbaar Beroeps Onderwijs (afgemaakt)  9 Hoger Beroeps Onderwijs (niet afgemaakt)  10 Hoger Beroeps Onderwijs (afgemaakt)  11 Universitair Onderwijs (niet afgemaakt)  12 Universitair Onderwijs (afgemaakt)
werk_situatie smallint(4) default NULL,
-- 1 werkeloos afgekeurd  2 werkeloos gepensioneerd  3 werkzoekend  4 huisvrouw huisman  5 lerend studerend   6 onbetaald werk   7 betaald werk
arbeidsproblem smallint(4) default '0',
--  0=helemaal niet 1=minimaal 2=enigszins 3=matig 4=vrij ernstig 5=ernstig
werkstudie smallint(4) default '0',
-- aantal uur per week besteed aan
huishouden smallint(4) default '0',
-- aantal uur per week besteed aan
opvoedingzorg smallint(4) default '0',
-- aantal uur per week besteed aan
PRIMARY KEY (persoon_id),
KEY partner_id (partner_id)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
-- Gegevens worden uitgevoerd voor tabel maatschaplktabel
INSERT INTO maatschaplktabel VALUES (1,2,0,0,5,11,7,0,0,0,0);
