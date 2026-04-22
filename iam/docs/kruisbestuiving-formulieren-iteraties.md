# Kruisbestuiving Tussen Formulieren (IAM)

Doel: informatie die op de ene pagina wordt ingevuld, slim en behulpzaam laten terugkomen op andere pagina's.

## 1. Principes

- Gebruik data als spiegel, niet als oordeel.
- Geef korte, concrete "duwtjes" met taal van de gebruiker zelf.
- Toon alleen wat nu relevant is voor dit formulier.
- Werk in lagen: live-duwtjes, dagreflectie, weekreflectie, plan-escalatie.
- Alles lokaal op toestel (privacy-first).

## 2. Mogelijkheden Voor Kruisbestuiving

### 2.1 Live veld-naar-veld duwtjes

Voorbeelden:
- "Je noemde bij Behoefte: <tekst>. Komt dat terug in je Alternatief, en/of in je plan van Aanpak?"
- "Je schreef eerder dat <interventie> helpt. Is dat nu je eerste stap?"
- "Je noemt nu een trigger die vorige week ook terugkwam. Wil je je noodstap aanscherpen?"

Waar toepassen:
- trek-opvangen -> trek-opvangen-2
- trek-opvangen -> noodplan-forse-trek
- risico-* -> noodplan-forse-trek
- plan-van-aanpak -> alle uitvoerformulieren

### 2.2 Samenvatting-naar-formulier prompts

Gebruik de integratie-samenvatting voor contextprompts:
- topTriggers
- bestInterventions
- supportNetwork
- earlyWarnings

Voorbeeldprompt:
- "Je top trigger is vaak <x>. Zie je die nu terug in deze situatie?"

### 2.3 Formulier-naar-formulier "replay"

Toon eerder ingevulde kernzinnen compact bovenaan een nieuw formulier:
- "Eerder zei je: <zin 1>"
- "Eerder werkte: <zin 2>"
- "Eerder miste: <zin 3>"

### 2.4 Contradictie-check (zacht)

Signaleer zachte spanning tussen intentie en plan:
- "Je doel is <lange termijn>, maar je actie hier is nog niet concreet. Wil je 1 mini-stap kiezen?"
- "Je kiest voor uitstellen, maar er staat nog geen als-dan zin. Nu toevoegen?"

### 2.5 Herhaling als motor

Voeg reminders toe op basis van ingevulde herhaalplannen:
- "Je herhaalplan was om 3x te oefenen. Zit je op schema?"
- "Herhalen helpt oude automatische reacties herschrijven. Welke kleine oefening doe je vandaag?"

## 3. Iteratie-Ideeën (Jouw Voorbeelden Ingebouwd)

### 3.1 Week-herkijk prompt

- "Vorige week zei je dit: <xxx>. Als je er nu nogmaals naar kijkt, heb je aanvullingen of nieuwe inzichten?"

Varianten:
- "Wat klopt nog precies?"
- "Wat zou je nu anders formuleren?"

### 3.2 Lastige-momenten prompt

- "Je bent in de afgelopen week mogelijk lastige momenten tegengekomen. Wat zeggen die over je pogingen?"

Varianten:
- "Welke stap werkte nog niet sterk genoeg?"
- "Welke stap werkte juist beter dan verwacht?"

### 3.3 Plan A / Plan B structuur

- "Je hebt een A-plan. Wat is je B-backup-plan?"
- "Hoe vaak mag plan A mislopen voor je plan B activeert?"
- "Nu je bijna op die grens zit, wil je plan B bijstellen?"

### 3.4 Escalatiebeslissing met teller

Ja, een teller is goed mogelijk.

Opties:
- Mislukte-pogingen teller (A-plan fail count)
- Lastige-momenten teller (zonder oordeel)
- Herhaal-oefeningen teller (positieve focus)

Drempels:
- handmatig instelbaar per gebruiker (bijv. 3, 5 of 7)
- zachte waarschuwing bij 80% van grens
- actief voorstel Plan B bij 100%

## 4. Concreet Datamodel (Lokaal)

Voorgestelde extra velden per form:

- iterationMeta:
  - lastWeeklyReviewAt
  - weeklyReflectionCount
  - promptHistory[]

- planMeta:
  - planA
  - planB
  - planAFailCount
  - planAFailThreshold
  - planBActivatedAt
  - planBRevisionCount

- repetitionMeta:
  - practiceTargetPerWeek
  - practiceDoneCount
  - lastPracticeAt

- eventLog[] (optioneel):
  - timestamp
  - type (urge_peak, slip_risk, planA_fail, planB_use, practice)
  - shortNote

## 5. Triggerregels Voor Duwtjes

Voorbeeldregels:

- IF behoefte exists AND alternatief empty -> toon behoefte->alternatief duwtje.
- IF planA exists AND planB empty -> toon planB prompt.
- IF planAFailCount >= threshold * 0.8 -> toon "bijna grens" prompt.
- IF planAFailCount >= threshold -> toon "activeer/bijstuur plan B" prompt.
- IF weekly review due (>= 7 dagen) -> toon vorige-week-herkijk prompt.

## 6. UX Patronen

- Compact blok boven of onder formulier: "Cognitieve duwtjes".
- Max 3-6 duwtjes tegelijk.
- Knoppen per duwtje:
  - "Neem over"
  - "Nu niet"
  - "Herinner mij later"
- Toon bron subtiel: "uit trek-opvangen", "uit plan-van-aanpak".

## 7. Prioriteiten Voor Implementatie

### Fase 1 (snel)

- Week-herkijk prompt
- Plan A/B velden
- Oefen- en pogingteller (primair positief) + drempel
- "bijna grens" en "grens bereikt" duwtjes

### Fase 2 (middel)

- EventLog met korte labels
- Duwtje-acties (Neem over / Later)
- Herhaal-oefening teller

### Fase 3 (uitbouw)

- Persoonlijke duwtje-stijl (mild/direct)
- Adaptieve drempels per gebruiker
- Trendweergave per week

## 8. Voorbeeldteksten Klaar Voor Gebruik

- "Vorige week zei je: <xxx>. Kijk je er nu anders naar?"
- "Je noemde eerder <trigger>. Zie je die nu opnieuw?"
- "Je plan A liep <n> keer mis. Wil je plan B nu activeren of bijstellen?"
- "Je zit op <n>/<drempel> richting plan B. Wil je nu al verfijnen?"
- "Je herhaalde deze oefening <n> keer deze week. Wat hielp het meest?"

## 8.1 Taalrichting Voor Motivatie

- Spreek primair over oefenen en pogingen, niet over mislukking.
- Vervang "mislukt" door: "poging" + "wat wil je hiervan leren?"
- Benadruk: proberen is beter dan niet proberen.
- Gebruik bij feedback waarderende taal: "goed dat je hebt geoefend", "je bent aan het bouwen".

## 9. Waarom Dit Werkt

- Herhaling maakt nieuwe keuzes sneller beschikbaar onder stress.
- "Eigen woorden terugzien" verhoogt herkenning en eigenaarschap.
- Drempelgedrag (bijna grens / grens) helpt tijdig bijsturen.
- Plan B normaliseert terugvalpreventie als onderdeel van leren.

## 10. Gemaakte Productkeuzes

- Tellerfocus: primair op oefeningen en pogingen.
- Reflectieframing: "mislukkingen" worden behandeld als leermomenten (pogingen + leeropbrengst).
- Drempels: per gebruiker instelbaar als standaard.
- Feedback op onrealistische instellingen: speelse reality check toegestaan.

Voorbeeld:
- "Je wil dagelijks oefenen en evalueren na 9999 keer. Mooie ambitie. Wat is een haalbare evaluatiegrens voor de komende 2 weken?"

- Duwtjes: niet alleen tijdelijk tonen, maar ook bewaren in een historielijst.
- Historielijstdoel: terugzien wat werkte en wat niet werkte.
- Feedbackkanaal: optie ontwerpen om geanonimiseerde feedback te delen (na expliciete toestemming).
- Weekprompts: minimaal op de homepage en verder op alle kernformulieren waar dit motivatie ondersteunt.

## 11. Implementatienotities Bij Deze Keuzes

- Voeg een `attemptMeta` blok toe naast `repetitionMeta`, met positieve defaults.
- Houd zowel tellerstanden als "wat heb ik geleerd" notities bij.
- Toon in de UI standaard eerst oefenvoortgang, daarna eventueel escalatie-info.
- Maak "historie" filterbaar op: nuttig, niet nuttig, later opnieuw proberen.
- Voeg in [iam/htm/index.htm](iam/htm/index.htm) een wekelijkse check-in prompt toe met snelle doorklik naar relevante formulieren.
