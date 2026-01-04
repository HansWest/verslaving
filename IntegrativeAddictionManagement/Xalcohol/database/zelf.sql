-- --------------------------------------------------------
-- Tabel structuur voor tabel zelfond
-- --------------------------------------------------------
DROP TABLE IF EXISTS zelfond;
CREATE TABLE IF NOT EXISTS zelfond (
persoon_id tinyint(10) NOT NULL default '0',
SteunNietZelf smallint(4) default '',
GevoelToelatenNietBeheersen smallint(4) default '',
BetrokkenNietAfstand smallint(4) default '',
AanpassenNietAfgrenzen smallint(4) default '',
PositiefNietKritisch smallint(4) default '',
IntuitieNietPlan smallint(4) default '',
AanvaardenNietHopen1 smallint(4) default '',
AfleidingNietBezig smallint(4) default '',
AfwachtenNietActie smallint(4) default '',
emoheftig smallint(4) default '',
emohelder smallint(4) default '',
PRIMARY KEY (persoon_id)
) TYPE=MyISAM;

-- Gegevens worden uitgevoerd voor tabel zelfond
