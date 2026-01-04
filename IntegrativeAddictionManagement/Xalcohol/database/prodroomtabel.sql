-- --------------------------------------------------------
-- Tabel structuur voor tabel prodroomtabel
-- --------------------------------------------------------
DROP TABLE IF EXISTS prodroomtabel;
CREATE TABLE prodroomtabel (
 prodroom_id smallint(11) NOT NULL auto_increment,
 persoon_id smallint(11) NOT NULL default '0',
 prodroom_categorie varchar(30) default NULL,
 prodroom_text varchar(160) default NULL,
 prodroom_gewicht smallint(4) default NULL,
PRIMARY KEY (prodroom_id),
 KEY persoon_id (persoon_id)
) TYPE=MyISAM AUTO_INCREMENT=500 ;
-- Gegevens worden uitgevoerd voor tabel prodroomtabel
INSERT INTO prodroomtabel VALUES (1,1,'denkgedrag','meer perfectionisme','');
INSERT INTO prodroomtabel VALUES (2,1,'denkgedrag','denken aan tegenslagen','');
INSERT INTO prodroomtabel VALUES (3,1,'denkgedrag','vastbijten op spanningsbron buiten jou','');
INSERT INTO prodroomtabel VALUES (4,1,'denkgedrag','concentratieverlies','');
INSERT INTO prodroomtabel VALUES (5,1,'denkgedrag','emotiedenken','');
INSERT INTO prodroomtabel VALUES (6,1,'denkgedrag','veel overspannen fantasie&euml;n','');
INSERT INTO prodroomtabel VALUES (20,1,'emotioneel','sneller angstig','');
INSERT INTO prodroomtabel VALUES (21,1,'emotioneel','schrikachtiger','');
INSERT INTO prodroomtabel VALUES (22,1,'emotioneel','sneller geïrriteerd of kribbig','');
INSERT INTO prodroomtabel VALUES (23,1,'emotioneel','snel boos','');
INSERT INTO prodroomtabel VALUES (24,1,'emotioneel','boos op mijzelf','');
INSERT INTO prodroomtabel VALUES (25,1,'emotioneel','sneller opgewonden','');
INSERT INTO prodroomtabel VALUES (26,1,'emotioneel','sneller schaamte','');
INSERT INTO prodroomtabel VALUES (27,1,'emotioneel','vlakkere emoties','');
INSERT INTO prodroomtabel VALUES (28,1,'emotioneel','ontremde doorbraak emoties','');
INSERT INTO prodroomtabel VALUES (30,1,'emotioneel','muziek niet bruikbaar om emotie te reguleren','');
INSERT INTO prodroomtabel VALUES (40,1,'energie','vermoeid gevoel','');
INSERT INTO prodroomtabel VALUES (41,1,'energie','trainen valt zwaarder','');
INSERT INTO prodroomtabel VALUES (42,1,'energie','leeg gevoel in de borst','');
INSERT INTO prodroomtabel VALUES (43,1,'energie','(op)gejaagd gevoel','');
INSERT INTO prodroomtabel VALUES (44,1,'energie','geen puf meer voor seks','');
INSERT INTO prodroomtabel VALUES (50,1,'pijn','pijn in de nek','');
INSERT INTO prodroomtabel VALUES (51,1,'pijn','pijn in schouders','');
INSERT INTO prodroomtabel VALUES (52,1,'pijn','pijn in maag','');
INSERT INTO prodroomtabel VALUES (53,1,'pijn','pijn in onderrug','');
INSERT INTO prodroomtabel VALUES (54,1,'pijn','pijn in onderbuik','');
INSERT INTO prodroomtabel VALUES (55,1,'pijn','hoofdpijn (opkomend)','');
INSERT INTO prodroomtabel VALUES (56,1,'pijn','hoofdpijn (verergerend)','');
INSERT INTO prodroomtabel VALUES (60,1,'gedrag','verslapen','');
INSERT INTO prodroomtabel VALUES (61,1,'gedrag','geen pauzes meer nemen','');
INSERT INTO prodroomtabel VALUES (62,1,'gedrag','chaos in huis','');
INSERT INTO prodroomtabel VALUES (63,1,'gedrag','dat ik telkens ruzie krijg','');
INSERT INTO prodroomtabel VALUES (64,1,'gedrag','veel bijna-ongelukjes','');
INSERT INTO prodroomtabel VALUES (65,1,'gedrag','er gebeuren ongelukjes','');
INSERT INTO prodroomtabel VALUES (80,1,'spieren','gespannen kuiten','');
INSERT INTO prodroomtabel VALUES (81,1,'spieren','gespannen schouders','');
INSERT INTO prodroomtabel VALUES (82,1,'spieren','gespannen vuisten','');
INSERT INTO prodroomtabel VALUES (83,1,'spieren','gespannen voorhoofd','');
INSERT INTO prodroomtabel VALUES (84,1,'spieren','gespannen kaken','');
INSERT INTO prodroomtabel VALUES (85,1,'spieren','tanden knarsen','');
INSERT INTO prodroomtabel VALUES (86,1,'spieren','moeite met slikken','');
INSERT INTO prodroomtabel VALUES (87,1,'spieren','brok in de keel','');
INSERT INTO prodroomtabel VALUES (88,1,'spieren','lichaamsco&ouml;rdinatie is lastiger','');
INSERT INTO prodroomtabel VALUES (90,1,'lichamelijk','versneld hartritme','');
INSERT INTO prodroomtabel VALUES (91,1,'lichamelijk','je hart klopt harder/meer voelbaar','');
INSERT INTO prodroomtabel VALUES (92,1,'lichamelijk','onrustig in borst','');
INSERT INTO prodroomtabel VALUES (93,1,'lichamelijk','onrustig bewegend gevoel in buik','');
INSERT INTO prodroomtabel VALUES (94,1,'lichamelijk','knoop in buik','');
INSERT INTO prodroomtabel VALUES (95,1,'lichamelijk','versnelde ademhaling','');
INSERT INTO prodroomtabel VALUES (96,1,'lichamelijk','oppervlakkige ademhaling','');
INSERT INTO prodroomtabel VALUES (97,1,'lichamelijk','droge mond','');
INSERT INTO prodroomtabel VALUES (98,1,'lichamelijk','licht in het hoofd','');
INSERT INTO prodroomtabel VALUES (99,1,'lichamelijk','druk op het hoofd hoofd','');
INSERT INTO prodroomtabel VALUES (100,1,'lichamelijk','warmte in oren en/of het gezicht','');
INSERT INTO prodroomtabel VALUES (101,1,'lichamelijk','tintelingen in de huid','');
INSERT INTO prodroomtabel VALUES (102,1,'lichamelijk','rood worden van de huid','');
INSERT INTO prodroomtabel VALUES (103,1,'lichamelijk','huiduitslag','');
INSERT INTO prodroomtabel VALUES (104,1,'lichamelijk','meer last van acne','');
INSERT INTO prodroomtabel VALUES (105,1,'lichamelijk','bad hair days','');
INSERT INTO prodroomtabel VALUES (106,1,'lichamelijk','droog of juist vet haar','');
INSERT INTO prodroomtabel VALUES (107,1,'lichamelijk','seks lukt niet meer','');
INSERT INTO prodroomtabel VALUES (120,1,'nachtrust','dromen over gebruik','');
INSERT INTO prodroomtabel VALUES (121,1,'nachtrust','nachtmerries','');
INSERT INTO prodroomtabel VALUES (122,1,'nachtrust','onrustige dromen','');
INSERT INTO prodroomtabel VALUES (123,1,'nachtrust','onrustige dromen','');
INSERT INTO prodroomtabel VALUES (124,1,'nachtrust','nachtelijk zweten','');
INSERT INTO prodroomtabel VALUES (125,1,'nachtrust','vaker in een zwart gat vallen','');
INSERT INTO prodroomtabel VALUES (126,1,'nachtrust','niet wakker kunnen worden','');
INSERT INTO prodroomtabel VALUES (127,1,'nachtrust','koffie is noodzakelijk om wakker te worden','');
INSERT INTO prodroomtabel VALUES (128,1,'nachtrust','vroeger en kapot in slaap donderen','');
INSERT INTO prodroomtabel VALUES (129,1,'nachtrust','langer wakker liggen voor je inslaapt','');
INSERT INTO prodroomtabel VALUES (140,1,'dagelijks leven','moeite met kranten of de nieuwsberichten','');
INSERT INTO prodroomtabel VALUES (141,1,'dagelijks leven','behoefte aan afzondering','');
INSERT INTO prodroomtabel VALUES (142,1,'dagelijks leven','meer last van kleine kinderen','');
INSERT INTO prodroomtabel VALUES (143,1,'dagelijks leven','minder weerwoord tegen lastige mensen','');
INSERT INTO prodroomtabel VALUES (144,1,'dagelijks leven','ongezonder eten','');
INSERT INTO prodroomtabel VALUES (145,1,'dagelijks leven','de dagen zijn niet leuk meer','');
INSERT INTO prodroomtabel VALUES (150,1,'neurologisch','vaker een deja-vu','');
INSERT INTO prodroomtabel VALUES (151,1,'neurologisch','behoefte aan stilte','');
