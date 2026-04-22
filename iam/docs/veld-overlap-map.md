# Veld-overlap map (IAM)

Doel: duidelijk houden welke velden bewust inhoudelijk overlappen, zodat nieuwe pagina's consistent koppelen zonder onbedoelde duplicatie.

## Naamconventie

- Houd form-specifieke velden lokaal en expliciet (bijv. `support1Name`, `personName`).
- Gebruik integratie-buckets als semantische laag over formulieren heen.
- Zie overlap als semantische equivalentie, niet als schema-alias.
- Voeg bij nieuwe overlap altijd 1) nudge-koppeling en 2) suggestie-koppeling toe.

## Overlapdomeinen

### 1. Supportpersoon

Betekenis: personen die steun kunnen bieden, van snel contact tot concreet steunplan.

Velden:
- `plan-van-aanpak.supportPeople`
- `sociaal-netwerk.reachableSupport`
- `sociaal-netwerk.firstReachOut`
- `steunnetwerk.support1Name`
- `steunnetwerk.support2Name`
- `steunnetwerk.support3Name`
- `motiverende-mensen.personName`

Integratie-bucket:
- `supportNetwork`

### 2. Motivatie-anker

Betekenis: waarom veranderen, richting en persoonlijke ankers.

Velden:
- `plan-van-aanpak.mainGoal`
- `voor-nadelen-balansen.decisionNote`
- `motiverende-mensen.motivationType`
- `motiverende-mensen.messageToPerson`
- `waarom-wel-gebruiken.functionSummary`

Integratie-bucket:
- `motivationAnchors`

### 3. Triggerdruk

Betekenis: druk/triggercontent en wat gebruik tijdelijk dempt.

Velden:
- `sociaal-netwerk.cravingPeople`
- `risico-mensen.riskySituationWithPerson`
- `waarom-wel-gebruiken.notFeeling`
- `waarom-wel-gebruiken.notThinking`
- `waarom-wel-gebruiken.spaceGiven`

Integratie-bucket:
- `topTriggers`

### 4. Behoefte-signaal (ABCDaaah B)

Betekenis: onderliggende behoefte en vertaling naar alternatief/voordelen van veranderen.

Velden:
- `trek-opvangen.behoefte`
- `trek-opvangen.alternatief`
- `voor-nadelen-balansen.changeAdvantagesText`

### 5. Startdatum (vormspecifiek)

Betekenis: zelfde veldnaam, andere context.

Velden:
- `plan-van-aanpak.startDate`
- `steunnetwerk.startDate`

## Praktijkregel bij nieuwe pagina's

- Voeg eerst lokale velden toe in de pagina.
- Koppel daarna aan bestaande overlapdomeinen via nudges/suggesties.
- Voeg alleen nieuwe integratie-sources toe als er echt nieuwe semantiek is.
