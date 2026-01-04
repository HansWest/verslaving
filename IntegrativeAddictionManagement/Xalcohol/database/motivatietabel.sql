-- --------------------------------------------------------
-- Tabel structuur voor tabel motivatietabel
-- --------------------------------------------------------
DROP TABLE IF EXISTS motivatietabel;
CREATE TABLE motivatietabel (
motivatie_id smallint(11) NOT NULL auto_increment,
persoon_id smallint(11) NOT NULL default '0',
ontwen_fase varchar(10) default NULL,
-- allemaal vooronderzoek, afkick, start abstinentie, start controle, duurzame abstinentie, duurzame controle, heroverweging
motivatie_niveau varchar(10) default NULL,
-- zeker twijfel redenatie smoes
motivatie_categorie varchar(30) default NULL,
motivatie_tekst varchar(80) default NULL,
motivat_ontwen_jn smallint(4) default NULL,
-- 1 = motivatie voor ontwennen 0 = motivatie voor gebruik
motivat_posneg smallint(4) default NULL,
-- 1 = positive naartoe-motivatie 0 = negatieve weg van-motivatie
motivat_ik_ander smallint(4) default NULL,
-- 1 is interne motivatie 0 = externe
onderlig_doel_id varchar(11) default NULL,
-- relatie met doelen???
onderlig_reden_id varchar(11) default NULL,
-- relatie met redenaties???
motiv_gewicht_berek smallint(4) default NULL,
-- berekend gewicht van voor-nadeel
motiv_gewicht_zelf smallint(4) default NULL,
-- toegekend gewicht van voor-nadeel
motiv_gewicht_termijn smallint(4) default NULL,
-- toegekend termijn van voor-nadeel
huiswerk_id varchar(11) default NULL,
-- relatie met doelen???
PRIMARY KEY (motivatie_id),
KEY persoon_id (persoon_id),
KEY ontwen_fase (ontwen_fase)
) TYPE=MyISAM AUTO_INCREMENT=1000 ;

-- Gegevens worden uitgevoerd voor tabel motivatietabel
INSERT INTO motivatietabel ( motivatie_id , persoon_id , ontwen_fase , motivatie_niveau , motivatie_categorie , motivatie_tekst , motivat_ontwen_jn , motivat_posneg , motivat_ik_ander , onderlig_doel_id , onderlig_reden_id , motiv_gewicht_berek , motiv_gewicht_zelf , motiv_gewicht_termijn, huiswerk_id ) 
VALUES ('1', '1', 'allemaal', 'zeker', 'medisch', 'erectieproblemen als gevolg van vaatzwakte', '1', '0', '1', NULL , NULL , NULL , NULL , NULL , NULL 
);
-- motivat_ontwen_jn = ja
INSERT INTO `motivatietabel` VALUES (2, 1, '', 'redenatie', 'medisch', 'ik voel dat mijn antidepressieve medicatie niet meer werkt', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (3, 1, '', 'redenatie', 'medisch', 'ik heb steeds meer maagklachten', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (4, 1, '', 'redenatie', 'medisch', 'ik ben steeds vaker ziek', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (5, 1, '', 'redenatie', 'medisch', 'ik krijg meer last van een hoge bloeddruk', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- 
INSERT INTO `motivatietabel` VALUES (20, 1, '', 'redenatie', 'relationeel', 'mijn dronkenschap ondermijnt iedere keer de mogelijkheid om een relatie te beginnen', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (21, 1, '', 'redenatie', 'relationeel', 'er zijn steeds vaker ruzies met mijn partner', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (22, 1, '', 'redenatie', 'relationeel', 'ik schaam mij tegenover mijn partner over mijn drinkgedrag', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (30, 1, '', 'redenatie', 'relationeel', 'de kinderen vertrouwen mij niet meer', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (31, 1, '', 'redenatie', 'relationeel', 'mijn partner vertrouwt mij niet meer met de kinderen', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- 
INSERT INTO `motivatietabel` VALUES (40, 1, '', 'redenatie', 'arbeid', 'ik moest mij te vaak ziek melden in de afgelopen periode', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (41, 1, '', 'redenatie', 'arbeid', 'mijn manager vertrouwt mijn ziekmeldingen niet meer', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (42, 1, '', 'redenatie', 'arbeid', 'ik moest voor mijn gevoel te veel overwerken om goed te maken wat er misging', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (43, 1, '', 'redenatie', 'arbeid', 'ik maak meer -bijna-foutjes op mijn werk', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- 
INSERT INTO `motivatietabel` VALUES (60, 1, '', 'redenatie', 'emotioneel', 'ik merk dat mijn angsten steeds meer groeien', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (61, 1, '', 'redenatie', 'emotioneel', 'ik merk dat ik steeds makkelijker geïrriteerd raak', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (62, 1, '', 'redenatie', 'emotioneel', 'ik voel mij vaker en dieper depressief', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- 
INSERT INTO `motivatietabel` VALUES (80, 1, '', 'redenatie', 'sociaal', 'ik kom alleen nog maar in de kroeg', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (81, 1, '', 'redenatie', 'sociaal', 'ik raak steeds meer oude vrienden kwijt', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (82, 1, '', 'redenatie', 'sociaal', 'ik ga nooit meer ergens naartoe', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- motivat_ontwen_jn =nee
INSERT INTO `motivatietabel` VALUES (101, 1, '', 'smoes', 'medisch', 'dan voel ik minder pijn', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (102, 1, '', 'smoes', 'medisch', 'dan voel ik mijn depressie even niet', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (113, 1, '', 'smoes', 'rust', 'dan kan ik tenminste in slaap vallen', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (120, 1, '', 'smoes', 'relationeel', 'dan durf ik met mijn partner over gevoel te praten', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (121, 1, '', 'smoes', 'relationeel', 'dan voel ik de pijn minder door mijn partner', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (122, 1, '', 'smoes', 'relationeel', 'dan hoef ik niet onder ogen te zien wat voor relatie ik heb', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (135, 1, '', 'smoes', 'relationeel', 'dan heb ik minder last van het gejengel van de kinderen', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (140, 1, '', 'smoes', 'arbeid', 'dan kan ik afstand nemen van mijn werk', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (180, 1, '', 'smoes', 'sociaal', 'dan durf ik mensen aan te spreken', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `motivatietabel` VALUES (181, 1, '', 'smoes', 'seksueel', 'dan durf ik tenminste iemand te versieren', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        