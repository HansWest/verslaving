-- --------------------------------------------------------
-- Tabel structuur voor tabel zelfbrieven
-- --------------------------------------------------------
DROP TABLE IF EXISTS zelfbrieven;
CREATE TABLE IF NOT EXISTS zelfbrieven (
persoon_id tinyint(10) NOT NULL default '0',
zelfbrief1 smallint(255) default '',
zelfbrief2 smallint(255) default '',
terugvalbrief smallint(255) default '',
verslaafde blob NOT NULL,
PRIMARY KEY (persoon_id)
) TYPE=MyISAM;

-- Gegevens worden uitgevoerd voor tabel zelfbrieven
