-- --------------------------------------------------------
-- Tabel structuur voor tabel redenatietabel 
-- --------------------------------------------------------

-- 
DROP TABLE IF EXISTS redenatietabel;
CREATE TABLE redenatietabel (
reden_id smallint(11) NOT NULL auto_increment,
persoon_id smallint(11) NOT NULL default '0',
ontwen_fase varchar(10) default NULL,
-- allemaal vooronderzoek, afkick, star, start, duurzaamheid, heroverweging
reden_niveau varchar(10) default NULL,
-- zeker twijfel redenatie smoes
reden_categorie varchar(30) default NULL,
reden_tekst varchar(80) default NULL,
onderlig_emot varchar(80) default NULL,
-- onderliggende emotie - (uit lijst?)
reden_ontkracht varchar(80) default NULL,
-- wat is daar tegenover te zetten
reden_gewicht smallint(4) default NULL,
PRIMARY KEY (reden_id),
KEY persoon_id (persoon_id),
KEY ontwen_fase (ontwen_fase)
) TYPE=MyISAM AUTO_INCREMENT=100 ;

-- 
-- Gegevens worden uitgevoerd voor tabel redenatietabel
-- 10
INSERT INTO redenatietabel VALUES (10,1,'allemaal','smoes','zelf','hebbiktochschijtan','woede','als ik voor mijzelf niet de moeite neem kan ik niet verwachten dat een ander dat wel doet','');
INSERT INTO redenatietabel VALUES (11,1,'allemaal','twijfel','zelf','anders is het geen gezelligheid','submissie','hoe gezellig is het voor mij als de gezelligheid bestaat uit het drinken van iets dat voor mij gevaarlijk is','');
INSERT INTO redenatietabel VALUES (12,1,'duurzaamheid','twijfel','zelf','anders durf ik een deel van mijn behoeften niet (uit) te leven','sociale angst','is het wel echt een rijk leven?... als ik dit alleen maar verdoofd kan beleven','');
INSERT INTO redenatietabel VALUES (91,1,'afkick','smoes','sociaal','ik moet mijn gasten toch op een goede manier ontvangen','submissie','moet je eens kijken hoe ik mijn gasten ga ontvangen als ik uit blijf glijden','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfbeloning','dat had ik wel verdiend','zin','is het dan een beloning om jouw leven te vergiftigen?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','kicken','dat heb ik nodig om te kunnen kicken','zin','is een verslaving echt kicken dan?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','tijdsvulling','als ik niets gebruik dan verveel ik mij zo','verveling','gaat het er bij verveling niet om dat je NIEUWE digen beleeft?','');
-- kicken
-- rust krijgen
-- in slaap vallen
-- angst wegdrinken
-- moed indrinken
-- eenzaamheid wegdrinken
-- seksueel presteren
-- perfectionisme verdoven
-- paniek voorkomen
-- verleden vergeten
-- minder moeten van mijzelf
-- mijzelf belonen
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfbeloning','ik had het geld dus ik kon het me veroorloven','zin','als je een ons muizengif kan kopen.. wil je dat dan aanschaffen voor jezelf?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfhandicapping','Als ik trek krijg dan moet ik absoluut iets gebruiken','zin','dat moet je ECHT want??? omdat???','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfhandicapping','Iedereen weet dat je als je trek krijgt dat je het dan niet meer kan controleren','zin','wie is die IEDEREEN waar je achter gaat staan?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','ontkenning','Het leven is veel gemakkelijker als ik gebruik.','hopeloosheid','hm.. ik zie vaak nogal wat problemen ontstaan juist door een verslaving','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','ontkenning','ik moet in staat zijn het te beperken tot de weekenden, dat kan toch Iedereen.','submissie','Mensen met een goed ontwikkelde verslaving kunnen dat niet...','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfhandicapping','Het is zinloos: eens een verslaafde - altijd een verslaafde.','verdriet','zelfs als je altijd verslaafd bent betekent dat niet dat je altijd gebruikt','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfhandicapping','ik kan niet stoppen, dat lukt me niet, dat weet toch Iedereen.','zin','ik ken erg veel mensen die het tegendeel bewijzen...','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfmedicatie','als ik gebruik gaat de pijn weg.','pijn','dat kan zo voelen op korte termijn maar wat zijn de bijwerkingen van dit medicijn?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','zelfmedicatie','ik heb iets nodig om me beter te voelen.','pijn','dat kan zo voelen op korte termijn maar wat zijn de bijwerkingen van dit medicijn?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','ontkenning','ik ben mans genoeg om het te hanteren, ik ben de baas.','macht','blijkt dat zo te zijn of zou je dat wensen?','');
INSERT INTO redenatietabel VALUES ('',1,'allemaal','smoes','sociaal','ik praat makkelijker als ik wat op heb.','angst','als je nuchter leert praten blijk je vaak betere gesprekken te hebben.','');
INSERT INTO redenatietabel VALUES ('',1,'allemaal','smoes','sociaal','Alle leuke en gezellige mensen gebruiken.','angst','er zijn ook heel saaie mensen die te veel drinken. net als zou als er ook leuke mensen zijn die niet drinken...','');
INSERT INTO redenatietabel VALUES ('',1,'allemaal','smoes','prestatie','ik presteer beter als Ik gebruikt heb.','submissie','voelt dat zo of is dat ook echt zo?..','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','ontkenning','ik voel me sterker als ik gebruik.','zin','dat kan zo voelen op korte termijn maar IS dat ook zo?','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','ontkenning','ik sta mezelf toe alleen deze te nemen, daarna stop ik dan weer helemaal','zin','helemaal stoppen door tussendoor te gebruiken???','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','terugval','ik had toch in staat moeten zijn om droog te blijven ... nu is alles verloren','zin','waarom zou je jezelf meer vergiftigen als je al gif binnen hebt.','');
INSERT INTO redenatietabel VALUES ('',1,'start','smoes','vlucht','ik kan er niet meer tegen en moet dus wel gebruiken','rechtvaardiging','is deze vlucht wel echt een vlucht van problemen weg, of maakt het nieuwe?','');

Controle  ik ben nu een maand gestopt, ik kan mijn gebruik nu controleren.
Rechtvaardiging ik heb het recht om me soms te vertroetelen met mijn favoriete drankje
ik hou er nou eenmaal van om te drinken.
Rechtvaardiging ik voel me rot en ik heb al genoeg ellende achter de rug.




