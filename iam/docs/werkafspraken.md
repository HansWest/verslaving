# Werkafspraken

Deze notitie bevat praktische afspraken over hoe we IAM ontwikkelen en hoe nieuwe inzichten worden vastgelegd.

## Documentatie eerst

- Lees bij werk aan IAM altijd eerst de documentatie in deze map.
- Behandel de documentatiemap als primaire bron voor theorie, taalkeuzes en conceptuele richting.
- Gebruik interne geheugensteun alleen aanvullend, niet als hoofdbron.

## Nieuwe inzichten expliciet vastleggen

- Nieuwe theoretische inzichten worden opgenomen in de documentatiemap.
- Nieuwe werkafspraken worden opgenomen in de documentatiemap.
- Houd kennis expliciet, zichtbaar en overdraagbaar in de repo zelf.

## Numeriek waar mogelijk (slider-check)

- Bij elk formulier- of UI-ontwerp doen we een vaste check: kan dit invoerveld zinnig numeriek met een slider (`0-100` of andere duidelijke schaal)?
- Als een slider pedagogisch helpt (sneller kiezen, beter vergelijken, trend zichtbaar), krijgt die voorkeur boven vrije tekst of losse labels.
- Elke nieuwe slider krijgt altijd: schaaluitleg (`wat betekent laag/hoog`), opslag in data, weergave in historie en opname in export.
- Als een veld niet geschikt is voor een slider, leggen we kort vast waarom (bijvoorbeeld te contextueel of narratief).
- Gebruik voor snelle pagina-QA de checklist in `iam/docs/pagina-review-checklist.md`.

## Instellingen herkenbaar maken

- Instellingenblokken krijgen in de kop bij voorkeur een duidelijk ⚙-icoon, zodat gebruikers ze snel scannen als configuratie in plaats van inhoud.
- Als een instellingenblok een titel heeft in een `details`-summary of settingsheader, combineer die titel met het icoon in dezelfde kopregel.

## One Truth Aanpak

- We werken met een single source of truth: per onderwerp is er steeds 1 leidende plek.
- Documentatie in gebruik staat in de map `iam/docs` en niet verspreid in meerdere varianten.
- Per functionaliteit is duidelijk wat de actieve versie is en in welke map die staat.

## Kruisbestuiving: 1 leidende bron

- Kruisbestuiving van formulierinformatie wordt centraal opgebouwd in `iam/js/dataStore.js`.
- Pagina's lezen kruisbestuiving via centrale helpercontexten (zoals `getCrossPollinationPack`) en bouwen die logica niet opnieuw lokaal op.
- Suggestieregels, prioritering en deduplicatie voor kruisbestuiving worden op 1 plek onderhouden.
- UI-bestanden mogen alleen presentatie en toepassing doen (tonen, knopacties, invullen), niet de bronselectie herschrijven.
- Nieuwe kruisbestuivingsbehoeften worden eerst als nieuwe context in de centrale helper toegevoegd, daarna pas in pagina-UI aangesloten.

## Opruimen van oude varianten

- Als een nieuwe versie actief in gebruik is, verwijderen we oude of dubbele varianten die niet meer nodig zijn.
- We laten geen parallelle "bijna dezelfde" versies staan zonder expliciete reden.
- Bij twijfel: eerst in documentatie aangeven welke versie leidend is, daarna pas opruimen.

## Risico-inventaris: vier dimensies, los ingevoerd, samen bruikbaar

De risico-inventaris bestaat uit vier gescheiden dimensies die pedagogisch apart behandeld worden, maar in Plan van Aanpak samen refereerbaar zijn:

- **Situaties**: Contexten/omstandigheden (feestdagen, bepaalde plekken, na bepaalde activiteiten, tijdsmomenten). Passief, triggerend.
- **Activiteiten**: Dingen die jij doet (feesten, bepaalde gesprekken, seks, dansen). Actief, keuze.
- **Mensen**: Contacten met specifieke risicotypes (enablers, overbelasting, mede-gebruikers, emotioneel getriggerd). Per persoon met plan A/B.
- **Gevoelens & Gedachten**: Interne risicofactoren (lastige gevoelens, risicogedachten). Mentaal/emotioneel.

Gebruiker vult alle dimensies apart in (pedagogische helderheid), maar in **Plan van Aanpak/Noodplan** kunnen situaties, activiteiten, mensen en gevoelens samen geselecteerd worden als triggers om actie in te stellen. Bijvoorbeeld: "Als ik in **situatie** X zit met **persoon** Y en **gedachte** Z opkomt, dan doe ik **activiteit** A om koers te houden."

### Multi-person management (Risico-Mensen)

- Risico-mensen pagina ondersteunt meerdere personen per profiel.
- Per persoon kun je: toevoegen, bewerken, verwijderen, opslaan.
- Risicotypes worden uit JSON geladen en zijn herbruikbaar.
- Plan A/B per persoon kunnen later in Plan van Aanpak/Noodplan gecombineerd worden met situaties en activiteiten.

### Legacy-inzichten die expliciet zijn overgenomen

De volgende inhoudelijke inzichten uit legacy-formulieren zijn bewust behouden in de moderne IAM-variant:

- **Risico-gevoelens**:
	- Tweedeling blijft leidend: (1) gevoelens die lastig uit te houden zijn zonder gebruik, (2) gevoelens/behoeften die lastig te uiten zijn zonder gebruik.
	- Ellis/CGT-reframing is expliciet toegevoegd: "Klopt dit echt?" en "Helpt deze gedachte mij vooruit?" plus reflectie op uitzonderingen en herkomst van gedachten.
	- Interne risico's zijn expliciet gemaakt als eigen veld: risico's die voortkomen uit wat iemand denkt/voelt, los van externe context.
	- Rol in flow: primair inventariseren en benoemen van risico-triggers (wat triggert gebruik).

- **Lastige-gevoelens**:
	- Rol in flow: primair coping en oefenen (wat doe je concreet als gevoelens oplopen).
	- Focus ligt op meerdere nuchtere antwoordroutes: voorkomen, afleiding, regulatie, verwerking, acceptatie, steun en reframing.
	- Aanbevolen volgorde: eerst risico-gevoelens invullen, daarna lastige-gevoelens als praktische oefenvertaling.

- **Risico-activiteiten**:
	- Sequentie is expliciet: voorbereiding -> risico tijdens activiteit -> exitstrategie -> risico's na afloop -> goedpraat-risico's.
	- Vaardigheden zijn concreet uitgewerkt in vijf categorieen:
		- afleidingen,
		- praten/steun inschakelen,
		- anders denken (cognitieve bijsturing),
		- treksurfen (tijdelijk uit situatie stappen),
		- zelfbeloning.

- **Noodplan forse trek**:
	- Piekmomenten gebruiken een "wel-doen eerst"-aanpak: directe acties zijn leidend, niet alleen verbodsformuleringen.
	- Steun is operationeel gemaakt: niet alleen wie je belt, maar ook wat anderen concreet voor je kunnen doen.
	- Cognitieve houvast bevat expliciet smoezen-herkenning naast rationele zinnen en piekeren-uitstellen.
	- Scheiding blijft expliciet: noodplan bij forse trek, plan bij uitglijden en noodplan bij wegglijden overlappen, maar zijn functioneel verschillend.

- **Plan bij uitglijden / Noodplan wegglijden**:
	- Het verschil tussen uitglijder en wegglijden wordt niet alleen benoemd, maar ook persoonlijk gedefinieerd door de gebruiker.
	- Reflectie op verschil gebeurt op twee momenten: achteraf herkennen (evaluatie) en vooraf herkennen (vroegsignalering).
	- Een eigen werkdefinitie van "terugval" helpt om sneller en minder discussiabel op te schalen naar intensiever herstelplan.
	- **Kernmechanisme van wegglijden:** Verslaving kapt het brein in zodat gebruik "belangrijk" voelt, geen keuze meer. Dit maakt traditionele "gewoon niet doen" onrealistisch.
	- **Ongewone maatregelen zijn soms noodzakelijk:** Geld afgeven, plekken/mensen vermijden, strikte steun. Dit zijn hulpmiddelen, geen mislukking.
	- **Normalisering:** Het kan altijd gebeuren dat je "verder uitglijdt dan je van plan was" — dit is geen teken van falend karakter, maar schoolvoorwerp van het brein onder druk.
	- **Prioriteit bij initiële response:** Indien uitglijding optreedt, focus eerst op schade-controle en opstaan (niet op "waarom"). Reflectie op oorzaken kan nuchter gebeuren, maar hoort niet thuis in noodmodus.
	- **Stimulus-respons controle (technieken-kompas)**:
	- Controle = iets wel doen zodat je iets niet doet (eigenlijk).
	- Technieken kunnen gericht zijn op **stimulus-vermijding** (passief/actief) of **respons-voorkoming** (alternatieven, afleiding, cognitief, aandachtsgerichte, sociale steun) of **consequentie-sturing** (beloning, lange-termijn-perspectief).
	- **Subtiliteit:** Combinaties van stimuli kunnen samen "te veel voor willskracht" zijn (bijv. vermoeidheid + tegenvaller + trigger = cumulatief effect). Dit wordt concreet in de vorm aangegeven.
	- **Oefenen belangrijk:** Zowel in realiteit als imaginair oefenen helpt automatisering op te bouwen buiten piekmomenten.

- **Oefenen voor de toekomst (drie-dimensie herstelmodel)**:
	- Recovery werkt als het leven nuchter/gecontroleerd áánvaardbaar wordt: minstens zo interessant, warm, mooi, spannend als op middel.
	- Oefenen gebeurt in **drie dimensies** (niet sequentieel, maar parallel):
		- **Biologisch:** Conditie, kracht, slaap, voeding, energie, vermogen tot genot. Focus op zelf-activatie (niet afleiding of medicatie alleen).
		- **Psychologisch:** (1) Lastige gevoelens/herinneringen een betere, nuchtere plaats geven (acceptatie/verwerking). (2) Gezonde emoties beter uitleven/expressen in nuchter leven (gezonde uiting zonder middel).
		- **Sociaal:** Supportieve vriendschappen bouwen; grenzen stellen aan schadelijke contacten.
	- Dit kader is complementair aan koping (lastige-gevoelens), risico-inventarisatie, en noodplannen: oefenen is de "proactieve aufbau" variant.

- **Biologische herstelaspect:** Vergiftiging (medicatie), honger (voeding), energie (beweging), vermogen tot genot (activatie), dokterscheck. Dit wordt concreet uitgewerkt, niet alleen als "voelen beter".

- **Persoonlijke waarden**:
	- Waarden worden geformuleerd als actief gedrag (liefst werkwoorden), niet als abstract etiket.
	- Focus op drie centrale waarden voorkomt vaagheid en helpt prioriteren.
	- Per waarde wordt vertaald naar dagelijks zichtbaar gedrag ("hoe zie je dit terug in je dag?").
	- Koppeling met motiverende mensen blijft expliciet: waarden worden sterker als sociale omgeving ze mee ondersteunt.

- **Motiverende mensen**:
	- Motivatie mag zowel uit huidige relaties als uit toekomstgerichte rollen/doelen komen (nog niet bestaande persoon/rol).
	- Kernvragen blijven: wie/rol, bestaand of toekomst, zichtbare lange-termijnsignalering, en persoonlijke boodschap.
	- Deze pagina is aanvullend op steunnetwerk: niet alleen wie praktisch helpt, maar ook voor wie/waarvoor je het doet.

### Besluit bij overlap: steunnetwerk versus motiverende mensen

- Voorkeursterm in gebruikerscommunicatie: **steun** (laagdrempelig en concreet).
- Niet volledig in elkaar schuiven: dat verhoogt cognitieve belasting en maakt praktische acties minder scherp.
- Wel strak koppelen:
	- **Steunnetwerk** = operationeel (bereikbaarheid, snelheid, betrouwbaarheid, handleiding).
	- **Steun en motivatie** = richting en betekenis (voor wie/waarvoor, bestaand of toekomst).
- Overlap blijft functioneel: dezelfde persoon kan in beide pagina's terugkomen, maar met ander doel.

- **Voor- / nadelen balansen**:
	- Beslislogica blijft een 2x2 balans: voordelen/nadelen van gebruik versus voordelen/nadelen van verandering.
	- Korte- en lange-termijnweging blijven expliciet, omdat motivatie vaak schuift per tijdshorizon.
	- Visualisatie ondersteunt besluitvorming: compacte balansweergave met puntschatting en besliskompas.
	- Balans blijft herhaalbaar in de tijd (datum + bijstellen), geen eenmalige test.

- **Soorten trek**:
	- Trek wordt niet als 1 uniforme toestand behandeld: gebruiker onderscheidt meerdere trekprofielen.
	- Per profiel worden lichaamssignalen, context, duur en helpende respons apart ingevuld.
	- Kernprincipe: verschillende soorten trek vragen vaak een verschillende aanpak.

- **To-Do lijst (dagelijkse herstelsturing)**:
	- Korte dagelijkse check blijft leidend (circa 5-10 minuten) om herstelacties niet te laten ophopen.
	- Beslisfilter blijft expliciet: onderscheid tussen belang en haast per taak.
	- Taken worden geformuleerd als werkwoorden (concreet gedrag), inclusief afvinkbaar gereed-moment.

- **Trek-opvangen (ABCDaaah)**:
	- Kernstructuur blijft leidend: Stop/ademen -> A (Actualiteit) -> B (Behoefte) -> C (Cognitieve afweging + keuze) -> D (Doen).
	- Doen wordt concreet uitgesplitst in: actief afscheid, actief accepteren, alternatief gedrag op behoefte B, en herhalen.
	- Afleiding blijft een legitieme tussenstap binnen regulatie (geen mislukking), met doel om weer te kunnen kiezen.
	- Oefenprincipe blijft expliciet: vroeg erbij zijn + herhalen buiten piekmomenten om automatisering op te bouwen.

- **Trek-opvangen 2 (tijdsperspectief omdraaien)**:
	- Aanvullende A-B-B2-C-D techniek blijft behouden:
		- A: directe winst van gebruiken,
		- B: lange-termijndoel,
		- B2: verwachte gevoelstoestand bij behalen van dat doel,
		- C: directe behoeftebevrediging bewust uitstellen,
		- D: direct handelen richting B/B2.
	- Functie: korte-termijn-impuls afzwakken door toekomstgevoel concreet en emotioneel beschikbaar te maken.
	- Deze module blijft aanvullend op ABCDaaah (niet vervangend).

- **Plan van Aanpak & Backup-strategie**:
	- **Doel moet concreet zijn:** Halfslachtige doelaanpak leidt tot verlies van grip. Concreet = aantallen, grenzen, startdatum, duur.
	- **Gefaseerd risico:** Halverwege kan het doelslippage worden (aandacht verslapt, crisis voorbij voelt, plan vergeten). Dit is reden genoeg voor Plan B vooraf.
	- **Plan A → Plan B logica:** Als strategie 1 niet werkt, past men eerst de strategie aan (Plan B), voordat men het doel herziet.
	- **Houdbaarheid:** Bewust kiezen hoelang je het doel volhoudt (evt. halfjaar, jaar), dan her-evalueren. Dit voorkomt doelafdrift.
	- **Doelslippage-preventie:** Regelmatige check: "Ben ik nog op koers met wat ik wilde bereiken?" Schriftelijke plans helpen hier.

- **Stoppen versus gestopt blijven (kernboodschap in gebruikersflow)**:
	- Stoppen voelt vooraf vaak enger/moeilijker dan het achteraf blijkt.
	- Gestopt blijven blijkt in de praktijk vaak moeilijker dan vooraf gedacht.
	- Bij duidelijke keuze zonder voortdurende twijfel kan de biologische onrust afnemen.
	- Daarna wordt vaak zichtbaarder wat onder gebruik lag: emotionele/psychologische afhankelijkheid in dagelijks leven.
	- UI/flow-afspraak: combineer crisisroute (drukregulatie) altijd met langetermijnroute (gevoelens, relaties, waarden, ritme), zodat "gestopt blijven" expliciet begeleid wordt.

- **Sociale Vaardigheden (SOVA): Grenzen stellen**:
	- **Videocamera-principe:** Beschrijf observeerbaar gedrag (wat je ziet/hoort), niet je interpretatie ervan. Helpt communicatie scherp.
	- Context: Regelmatig gebruik maakt mensen kwetsbaar voor lastige sociale situaties; niet reageren put wilskracht uit.
	- **Tik-in-de-plaat-principe:** Grenzen stellen is herhaling, niet nieuwe argumenten. Consistent en rustig herhalen.
	- Formule: Observeerbaar gedrag → jouw gevoel → jouw reactie → jouw wens (alternatief gedrag) → voordelen + waardering van ander.

	- Mensen geven regelmatig tegenstrijdige signalen die verwarring oproepen.
	- **Gevoelens niet wegpoetsen:** Ze hoeven niet weg, wel op moment/plaats begrepen en uitgesproken.
	- **Videocamera-principe dubbel:** Twee observeerbare gedragingen, beide legitiem voelen, maar samen verwarrend.
	- Formule: Gedrag 1 → gevoel 1, Gedrag 2 → gevoel 2 → verwarring → jouw reactie → wens voor communicatie + waardering.

- **Toekomstoptie: emotie-dynamiek bij craving (pilot, nog niet actief in kernflow)**:
	- Doel: gebruikers helpen om craving/emotie-schommelingen beter te begrijpen en te reguleren.
	- Kernidee: emotie beweegt door 2 krachten:
		- **Decay naar baseline** (herstelrichting),
		- **Impact van user-input** (reactie op gebeurtenis/antwoord).
	- Basisvorm:
		- `new = old + decay + change`
		- `decay = (baseline - old) * decayQuotient` (typisch startpunt 0.1)
		- `change = (delta * impact) / (1 + afstandTotBaseline * impact)`
	- Praktische waarde: normaliseert emotionele schommelingen en maakt zichtbaar dat pieken meestal niet permanent zijn.
	- Veiligheidsafspraak: niet gebruiken voor diagnose of sturing van medische beslissingen; alleen als psycho-educatieve ondersteuning.
	- Implementatievoorbereiding staat in `iam/js/emotionDynamics.js` en is bewust nog niet gekoppeld aan actieve formulieren.

Doel van deze overname: pedagogische scherpte uit legacy behouden zonder terug te vallen op oude techniek of oude UI.

## Pagina's met bijzondere status

### to_self_manage_game.htm — standalone spel, geen IAM-kernpagina

- `to_self_manage_game.htm` is een zelfstandig spel en valt **buiten de IAM-kernflow**.
- Het krijgt **geen algemene IAM-aanpassingen**: 
  - Geen koppeling aan `mobile.css`/`forms.css`
  - Geen dataStore-integratie met andere formulieren
  - Geen One Truth-check of automatische sync met IAM-kernpagina's
  - Geen refactoring of modernisering die aan kernpagina's wordt toegepast
- Aanpassingen aan dit spel zijn altijd game-specifiek en worden expliciet als zodanig behandeld
- De pagina wordt in `index.htm` aangeboden als optioneel extra (Zinnen verzetten & afleiding), niet als onderdeel van een IAM-fase
- Dit is bewust anders: het spel is bedoeld als pauze/afleiding, niet als onderdeel van de therapeutische interventies

### gebruik-bijhouden.htm — verwijderd (redundante redirect)

- `gebruik-bijhouden.htm` was een pure redirect naar `dagelijks-gevolg.htm` zonder eigen inhoud of intelligentie.
- Omdat `dagelijks-gevolg.htm` zelf al in de navigatie staat, was de redirect dubbel en zonder meerwaarde.
- Het bestand en alle verwijzingen ernaar zijn verwijderd (mei 2026).

### verwijten-en-empathie.htm — relationele gevoelsverwerking, steunpagina

- `verwijten-en-empathie.htm` is een pagina voor verwerking van verwijten zonder in verdediging te schieten.
- Doel: van defensie naar empathie, van schuld naar verantwoordelijkheid.
- **Structuur** (5 stappen):
  1. **Inventaris**: Wat zei/zegt de ander precies (zonder evaluatie)?
  2. **Adem & voelen**: Grounding-moment; voelen hoe getriggerd je bent
  3. **Eigen verhaal**: Jouw rationalisaties en verdedigingsmechanismes opschrijven
  4. **Empathie**: Wat voelt de ander, wat heeft de ander nodig?
  5. **Verantwoordelijkheid**: Wat neem jij op je (zonder jezelf klein te maken)?
- **Koppeling**: Werkt samen met `ingeslikte-emoties.htm` (wat je zelf inslikt) en kan triggers onderzoeken vanuit `risico-gevoelens.htm`
- **Fase-plaatsing**: Fase 2 (lastige gevoelens onderzoeken), ook bruikbaar in Fase 4 (conflict-opvangst na uitglijder)
- **Data-opslag**: Lokale dataStore per datum/persoon-combinatie, exporteerbaar

### de-spiraal.htm — mechanismevisualisatie: isolatie vs. verbinding

- `de-spiraal.htm` helpt gebruikers zien hóé hun gevoelens, gedachten en gedrag **zichzelf versterken** (gesloten spiraal) óf **zich helen** (open spiraal).
- Doel: van abstracte risico-verkenning naar concreet patroonzicht en hoe je het doorbreekt.
- **Kernstructuur**:
  1. **Gesloten Spiraal** (⬇️): Moeilijke gevoelens → Verdedigende gedachten → Terugtrekking → Ander voelt zich afgewezen → JIJ voelt je meer alleen
  2. **Open Spiraal** (⬆️): Moeilijke gevoelens erkend → Kwetsbare gedachten → Open gedrag → Ander voelt zich vertrouwd → JIJ voelt je verbonden
  3. **Vergelijking & Reflectie**: Gebruiker bepaalt welke spiraal actief is en wat de volgende stap kan zijn
- **Koppeling**: Brug tussen risico-inzicht (Fase 3) en praktische relatie-werk (`verwijten-en-empathie.htm`, `sociaal-netwerk.htm`, `steunnetwerk.htm`)
- **Fase-plaatsing**: Fase 3 (Risico-architectuur), als sluitstuk dat toont *waarom* risico's kunnen escaleren en *hoe* verbinding breekt
- **Data-opslag**: Lokale dataStore per datum, focust op herkenning van patronen

### verbinding-en-bijdrage.htm — verbinding, bijdrage en planstap

- `verbinding-en-bijdrage.htm` is de moderne, accuratere opvolger van het oude creatiespiraal-concept.
- Doel: van positieve wens naar betekenisvolle verbinding, sociale bijdrage en eerste haalbare stap.
- Belangrijk subthema: niet alles alleen dragen; delen van emoties en zorgen helpt eenzaamheid en zelfafsluiting verminderen.
- Extra laag: als emoties die expressie vragen worden afgeleerd, kan gebruik die emotionele lading chemisch proberen te dragen of op te roepen; dan krijgt het middel te veel emotioneel gewicht.
- **Kernstructuur**:
	1. Positief formuleren van de wens
	2. Eindresultaat concreet maken
	3. Niet alles alleen dragen: wat kun je delen?
	4. Zien wie hier beter van wordt
	5. Koppelen aan mensen die kunnen helpen
	6. Omzetten in een kleine planstap
- **Koppeling**: sluit aan op `levensdoelen-stellen.htm`, `motiverende-mensen.htm`, `sociaal-netwerk.htm`, `steunnetwerk.htm`, `ingeslikte-emoties.htm`, `lastige-gevoelens.htm`, `verwijten-en-empathie.htm`, `de-spiraal.htm`, `plan-van-aanpak.htm` en `genieten-belonen.htm`
- **Fase-plaatsing**: Fase 5 (Borging en ritme), omdat de pagina wens, bijdrage, planning en volhouden samenbrengt
- **Data-opslag**: Lokale dataStore per datum, zodat wens en plan later terug te vinden zijn

### Index weekreview -> plan/escalatie (kruisbestuiving)

- De weekreview op `index.htm` gebruikt niet alleen integratiesamenvatting, maar ook `attemptMeta` uit historielijst.
- Bij meerdere pogingen verschijnt een directe doorklik naar `plan-van-aanpak.htm`.
- Bij labels `niet-nuttig` verschijnt extra route naar `plan-backupplan.htm`.
- Bij herhaald `niet-nuttig` verschijnt escalatieroute naar `noodplan-wegglijden.htm`.
- Doel: tijdig bijsturen op Plan A -> Plan B -> escalatie, zonder extra zoekwerk voor gebruiker.

## Leidende Set (Kernflow)

De onderstaande pagina's vormen de actieve kernflow van IAM in `iam/htm`.

- `index.htm`
- `start-nu.htm`
- `waarom-wel-gebruiken.htm`
- `wat-is-mijn-ik.htm`
- `persoonlijke-waarden.htm`
- `lastige-gevoelens.htm`
- `craving-1-10.htm`
- `craving-gevoel.htm`
- `voor-nadelen-balansen.htm`
- `verwijten-en-empathie.htm`
- `stimulus-respons.htm`
- `risico-situaties.htm`
- `risico-gevoelens.htm`
- `risico-denken.htm`
- `risico-mensen.htm`
- `risico-activiteiten.htm`
- `soorten-trek.htm`
- `de-spiraal.htm`
- `noodplan-forse-trek.htm`
- `trek-opvangen.htm`
- `trek-opvangen-2.htm`
- `plan-van-aanpak.htm`
- `motiverende-mensen.htm`
- `genieten-belonen.htm`
- `verbinding-en-bijdrage.htm`
- `agenda.htm`

Alles buiten deze set is voorlopig niet leidend in de kernflow, tenzij expliciet toegevoegd in dit document.

## Scheiding van soorten kennis

- Theorie en inhoudelijke visie horen in bestanden zoals `achterliggende-theorie.md`.
- Werkwijze, proces en ontwikkelafspraken horen in `werkafspraken.md`.
- Gebruikersteksten blijven eenvoudiger dan interne theorie.

## Taal en benadering

- Vroege schermen nodigen uit tot zelfonderzoek en vermijden te snelle etiketten.
- Formuleringen als `wat is er aantrekkelijk aan?`, `wat levert het op?` en `wat kost het je?` passen beter dan direct pathologiserende taal.

## Werkcontext voor Copilot

Deze sectie bevat alles wat nodig is om consistent en goed aan IAM te werken.

### Doel en richting

- IAM is mobile-first: de app moet goed werken op telefoonscherm.
- Privacy-first: data blijft lokaal op het apparaat van de gebruiker.
- Offline-first: geen serverafhankelijkheid voor kernfunctionaliteit.
- Onderzoekende benadering: eerst begrijpen wat gebruik oplevert/kost, pas later verdieping.

### Bronnen en structuur

- Leidende documentatie staat in `iam/docs`.
- Leidende app-bestanden staan in `iam/htm`, `iam/css`, `iam/js`.
- De kernflow in deze notitie is de primaire bron voor actieve pagina's.
- Legacy mappen (`htm-version`, `IntegrativeAddictionManagement/htm`) zijn referentiebron, niet leidend voor nieuwe wijzigingen.

### Single Source of Truth

- Per onderwerp is er 1 leidende plek.
- Nieuwe inzichten direct vastleggen in `iam/docs`.
- Als nieuwe versie actief is: oude/dubbele versies verwijderen (na expliciete markering van leidende versie).

### Inhoudelijke ankers

- Theorie: zie `achterliggende-theorie.md`.
- Werkwijze: zie `werkafspraken.md`.
- Gebruikerstekst blijft eenvoudiger en minder labelend dan interne theorie.

### Standaard werkwijze bij wijzigingen

- Lees eerst `iam/docs/werkafspraken.md` en `iam/docs/achterliggende-theorie.md`.
- Wijzig eerst de leidende variant in `iam/*`.
- Controleer of verwijzingen en paden kloppen binnen `iam`.
- Werk documentatie bij als er nieuwe keuzes of inzichten zijn.
- Ruim achterblijvende dubbele varianten op wanneer ze niet meer nodig zijn.
- Vertaal theorie bij voorkeur direct naar praktische keuzepaden: korte uitleg -> duidelijke opties -> route naar concrete actiepagina.
- Nieuwe theorie in formulieren krijgt, waar passend, een "nu doen"-router met 1 klik naar de volgende beste stap.

### Technische basisafspraken

- HTML met viewport voor mobiel gebruik.
- CSS via `../css/mobile.css` en `../css/forms.css`.
- Centrale lokale data-opslag via `iam/js/dataStore.js`.
- Exportmogelijkheden (JSON/CSV) behouden of uitbreiden waar relevant.

### Keuzelijsten als JSON (herbruikbaar)

- Vaste keuzelijsten staan bij voorkeur in `iam/assets/options` als JSON, niet hardcoded in losse HTML-pagina's.
- Gebruik herleidbare bestandsnamen in het format `<domein>-<onderwerp>.json`.
- Een JSON-bestand mag meerdere lijsten bevatten (bijv. `gevoelens` en `gedachten`) zodat meerdere pagina's dezelfde bron kunnen hergebruiken.
- Lijst-items mogen een string zijn of een object met extra velden zoals `reaction` of `reactionKey` voor bijbehorende reacties.
- Pagina's laden deze lijsten via `iam/js/optionsLoader.js` en hebben een lokale fallback in script voor robuustheid.
- Als een item `reaction` bevat, mag die reactie bij selectie automatisch als voorstel in een passend tekstveld worden toegevoegd (zonder dubbele regels).

### UX-beslissing: inklapbare secties via ronde +/− knop

- Secties en hoofdstukken die inklapbaar zijn, krijgen altijd een ronde iconknop rechtsboven in hun container.
- De knop toont **−** als de sectie open is, **+** als de sectie dicht is.
- De knop heeft `aria-expanded` voor toegankelijkheid; de `::before` pseudo-selector toont het icoon — geen zichtbare tekst in het element zelf.
- De container van de sectie krijgt de klasse `chapter-host` (met `position: relative`) zodat de knop absoluut gepositioneerd kan worden.
- Verborgen content krijgt de klasse `chapter-collapsed` (`display: none !important`).
- De CSS-regels voor dit patroon staan centraal in `iam/css/mobile.css` (sectie "Inklapbare secties"), niet inline per pagina.
- Inklapstate wordt opgeslagen in `localStorage` per pagina met een eigen sleutel.
- Standaard zijn secties die direct actief zijn voor de gebruiker open; ondersteunende of aanvullende secties starten ingeklapt.

### UX-interactieafspraak: tegelklik opent doelgebied

- Als een tegel/link in dezelfde pagina verwijst naar een tekstgebied of sectie, dan opent het doelgebied automatisch.
- Concreet: bij links naar een `details`-sectie (of een element binnen zo'n sectie) wordt die sectie eerst geopend en daarna gescrold.
- De gebruiker kan de sectie daarna handmatig weer dichtklikken.
- Dit gedrag is een vaste designafspraak voor IAM-pagina's met tegelnavigatie.

### Veilig en beheersbaar werken

- Geen onnodige destructieve acties op bestaande user-content.
- Bij onverwachte grote afwijkingen: eerst expliciet vastleggen wat leidend is, daarna opschonen.
- Bij twijfel over inhoudelijke richting: documentatie en kernflow zijn beslissend.
- Niet gokken: liever eerst nakijken in code, documentatie of gitgeschiedenis. Als iets daarna nog onduidelijk is, gericht navragen.

## Gedeelde UI-Regels (Tool-overstijgend)

Deze regels zijn overgenomen als bruikbare standaard voor IAM-tools met vergelijkbare interactiepatronen.

### Shared controls

- Gebruik waar mogelijk gedeelde CSS-patronen voor herbruikbare controls (helpknop, modalcontrols, disclosureknop).
- Beperk module-specifieke overrides tot gevallen waar een gedeeld patroon aantoonbaar niet past.
- Hergebruik het bestaande footerpatroon met Value for Value + privacyregel wanneer de lay-out dat toelaat.

### Paginaheader patroon

- Gebruik op formulierpagina's bij voorkeur een **header als kaart** in plaats van een harde full-width balk.
- Basispatroon:
	- afgeronde hoeken (`border-radius`),
	- compacte padding (niet te hoog),
	- zachte schaduw,
	- subtiele gradient die past bij de pagina-kleur.
- Uitlijning: headertekst standaard links, tenzij de pagina-inhoud expliciet een gecentreerde hero vraagt.
- Breedte: header volgt dezelfde contentbreedte als de pagina (`max-width` + centrering) voor rust in de lay-out.
- Typografie: titel compact (`clamp`), subtitel kort en leesbaar (regelhoogte rond 1.4-1.6).
- Vermijd "grove" blokken: geen overmatige verticale ruimte, geen harde randen zonder afronding.
- Als een pagina bewust afwijkt van dit patroon, leg de reden kort vast in de pagina-annotatie of documentatie.

### Disclosure en collapse

- Grote secties zijn standaard inklapbaar, behalve bij veiligheidskritische acties of vaste lineaire kernflow.
- Disclosure gebruikt een echte knop met consistente visuele vorm: ronde outline, duidelijk centrumicoon, focus-state zichtbaar.
- Icoonbetekenis is vast: + = dicht, - = open.
- Toegankelijkheid is verplicht: button + aria-expanded + aria-controls naar het doelgebied.
- Inklapstatus wordt lokaal bewaard als de tool al lokale voorkeuren/profieldata opslaat.
- Icoonknoppen blijven semantisch consistent: help = ?, disclosure = + / -.

### Help-modal patroon

- Help gebruikt rechtsboven een sluitknop X in de modalheader.
- Helptekst staat in de modalbody, niet in de header.
- Onderin staat bij voorkeur een gecentreerde bevestigingsknop met label Got it!.
- In tools met het dark modal-systeem: .modal-header voor titel + X, .modal-body voor uitleg, .close-modal-btn voor de onderknop.

### App settings modal patroon

- Tools met gebruikersvoorkeuren tonen in de header-actierij een App Settings ⚙️ knop.
- Settingsmodal gebruikt gedeelde .modal backdrop en .glass-panel met modifier .settings-panel.
- Settingspanel is altijd scrollbaar: max-height: 90vh; overflow-y: auto; zodat Save bereikbaar blijft op kleine schermen.
- Instellingen worden gegroepeerd in sectietitels (settings-section-title), minimaal: Field Names, Data, Cross-tool Behaviour.
- Onderaan in het scrollgebied staat altijd een duidelijk Save-actie.
- Lokale opslag gebruikt een toolspecifieke sleutel, voorbeeld: kac_<toolname>_settings_v1.
- Bij openen: hydrateSettingsForm(); bij opslaan: applySettings() en direct live doorvoeren in labels/knoppen.

### Consistentieprincipe

- Versterk bij voorkeur gedeelde regels in plaats van losse per-tool fixes.
- Als een tool bewust afwijkt om structurele redenen, documenteer die reden expliciet bij die tool.
