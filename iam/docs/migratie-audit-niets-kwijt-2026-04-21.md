# Migratie Audit - Niets Kwijt (2026-04-21)

Doel:
- Verifiëren dat gemigreerde formulieren inhoudelijk en functioneel niet "uitgekleed" zijn.
- Verifiëren dat verwijderde legacybestanden terug te vinden zijn in archief.

Werkwijze:
1. Per formulier: legacybron (Integrative/archief) vergeleken met `iam/htm` variant.
2. JavaScript-signalen gecontroleerd: oude cookie-acties vs huidige IAM datastore.
3. Archiefdekking gecontroleerd voor verwijderde legacybestanden.

## Samenvatting

- Alle gecontroleerde formulieren hebben een moderne IAM-variant met actieve opslag via `iamData`.
- Legacy JS was meestal beperkt tot hulppopups + `saveSelections/loadSelections` cookie-acties.
- Voor verwijderde legacybestanden in deze migraties is archiefdekking aanwezig.
- Inhoudelijk zijn meerdere legacykaders expliciet teruggezet als "Legacy-aanvulling" of equivalent.

## Per formulier

| Formulier | Legacybron (audit) | IAM-variant | JS status | Archiefstatus |
|---|---|---|---|---|
| `stimulus-respons.htm` | `legacy-archive/2026-04-21-cleanup-round1/IntegrativeAddictionManagement/htm/stimulus-respons.htm` | `iam/htm/stimulus-respons.htm` | Van popup/cookie naar actieve IAM-opslag en suggestielogica | Integrative + htm-version gedekt |
| `soorten-trek.htm` | `legacy-archive/2026-04-21-cleanup-round1/IntegrativeAddictionManagement/htm/soorten-trek.htm` | `iam/htm/soorten-trek.htm` | Van popup/cookie naar actieve IAM-opslag en weekprompt-koppeling | Integrative + htm-version gedekt |
| `plan-van-aanpak.htm` | `legacy-archive/2026-04-21-cleanup-round1/IntegrativeAddictionManagement/htm/plan-van-aanpak.htm` | `iam/htm/plan-van-aanpak.htm` | Oude datum/agendafuncties vervangen door IAM-dataflow + suggesties | Integrative + htm-version gedekt |
| `noodplan-forse-trek.htm` | `legacy-archive/2026-04-21-cleanup-round1/IntegrativeAddictionManagement/htm/noodplan-forse-trek.htm` | `iam/htm/noodplan-forse-trek.htm` | Van popup/cookie naar IAM-opslag, voortgang, nudges | Integrative + htm-version gedekt |
| `trek-opvangen.htm` | `legacy-archive/2026-04-21-cleanup-round1/IntegrativeAddictionManagement/htm/trek-opvangen.htm` | `iam/htm/trek-opvangen.htm` | Van cookiegedrag naar IAM-opslag + nudges + weekprompt | Integrative gedekt; geen htm-version variant in archive |
| `craving-gevoel.htm` | `legacy-archive/2026-04-21-cleanup-round2/IntegrativeAddictionManagement/htm/craving-gevoel.htm` | `iam/htm/craving-gevoel.htm` | Van popup/cookie naar IAM-opslag met laagindeling | Integrative + htm-version gedekt |
| `craving-1-10.htm` | `legacy-archive/2026-04-21-cleanup-round2/IntegrativeAddictionManagement/htm/craving-1-10.htm` | `iam/htm/craving-1-10.htm` | Legacy had geen echte formulierlogica; nu slider + actieadvies + IAM-opslag | Integrative + htm-version gedekt |
| `voor-nadelen-balansen.htm` | `IntegrativeAddictionManagement/htm/voor-nadelen-balansen.htm` | `iam/htm/voor-nadelen-balansen.htm` | Van minimale hulpfunctie naar IAM-opslag en normalisatie | Integrative aanwezig; htm-version bron ontbreekt |
| `noodplan-tekst.htm` | `legacy-archive/2026-04-21-cleanup-round2/IntegrativeAddictionManagement/htm/noodplan-tekst.htm` | `iam/htm/noodplan-tekst.htm` | Legacy had popup/cookiegedrag; nu planroute-keuze + beslisregel met IAM-opslag | Integrative + htm-version gedekt |

## Inhoudelijke borging (delta)

Teruggezet of expliciet geborgd in IAM:
1. `trek-opvangen.htm`: herhalen/timing-kader uit legacy expliciet teruggezet.
2. `plan-van-aanpak.htm`: strategie-check (doel vs strategie) toegevoegd.
3. `noodplan-forse-trek.htm`: piek-kader en onderscheid met uitglijden/wegglijden toegevoegd.
4. `soorten-trek.htm`: vergelijkhulp (sluipend/plots, opstuwer/wegtrekker, context) toegevoegd.
5. `stimulus-respons.htm`: technieken-kompas en relevante doorklikken toegevoegd.
6. `craving-gevoel.htm`: niveauverschil-kader toegevoegd.
7. `voor-nadelen-balansen.htm`: verdiepende vragen, voorbeeldrichting en datumveld toegevoegd.

## Conclusie

- Geen aanwijzing dat zinnige JavaScript is weggegooid zonder vervanging.
- Verwijderde legacybestanden in de uitgevoerde rondes zijn terug te vinden in archief.
- De moderne formulieren bevatten in meerdere gevallen meer functionele logica dan de legacyvarianten.

## Aanbevolen vervolgstap

1. Zelfde auditformat herhalen na elke volgende opschoonbatch.
2. Per batch een nieuwe auditfile toevoegen met datumstempel.