# Legacy -> IAM Migratie Checklist

Bijgewerkt: 2026-04-21

Doel:
- Waarde uit legacybestanden overnemen in moderne IAM-formulieren.
- Daarna legacybestanden verwijderen, met inhoud bewaard in archief.

Archiefbron:
- `legacy-archive/2026-04-21-cleanup-round1`

Reeks A - al gemigreerd en opgeschoond:
1. `stimulus-respons.htm`
Status: legacybestand verwijderd uit oude paden, inhoudelijke techniek-kapstok toegevoegd aan `iam/htm/stimulus-respons.htm`.
2. `soorten-trek.htm`
Status: legacybestand verwijderd uit oude paden, vergelijkhulp toegevoegd aan `iam/htm/soorten-trek.htm`.
3. `plan-van-aanpak.htm`
Status: legacybestand verwijderd uit oude paden, strategie-check toegevoegd aan `iam/htm/plan-van-aanpak.htm`.
4. `noodplan-forse-trek.htm`
Status: legacybestand verwijderd uit oude paden, noodkader toegevoegd aan `iam/htm/noodplan-forse-trek.htm`.
5. `trek-opvangen.htm`
Status: legacybestand verwijderd uit oude Integrative-pad, herhaal- en timingkader toegevoegd aan `iam/htm/trek-opvangen.htm`.
6. `craving-gevoel.htm`
Status: legacybestanden verwijderd uit oude paden, niveauverschil-kader toegevoegd aan `iam/htm/craving-gevoel.htm`.

Opschoning ronde 1 (uitgevoerd):
1. Verwijderd uit `IntegrativeAddictionManagement/htm`:
`index.htm`, `trek-opvangen.htm`, `noodplan-forse-trek.htm`, `plan-van-aanpak.htm`, `stimulus-respons.htm`, `soorten-trek.htm`.
2. Verwijderd uit `htm-version`:
`noodplan-forse-trek.htm`, `plan-van-aanpak.htm`, `stimulus-respons.htm`, `soorten-trek.htm`.

Opschoning ronde 2 (uitgevoerd):
1. Verwijderd uit `IntegrativeAddictionManagement/htm`:
`craving-gevoel.htm`.
2. Verwijderd uit `htm-version`:
`craving-gevoel.htm`.

Nog te doen (volgende rondes):
1. Zelfde migratiepatroon toepassen op overige 1-op-1 overlapbestanden.
2. Per formulier kort vastleggen welke legacy-inzichten zijn overgenomen.
3. Per opschoonronde verwijderde inhoud toevoegen aan een gedateerde map onder `legacy-archive`.