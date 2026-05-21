# IAM compliance-audit - 2026-05-18

Doel: alle bestaande pagina's in `iam/htm` technisch toetsen op kern-afspraken uit `werkafspraken.md` en `pagina-review-checklist.md`.

## Scope en methode

- Totaal gescand: 63 pagina's (`iam/htm/*.htm`).
- Gecontroleerd op harde criteria:
  - viewport meta,
  - koppeling `../css/mobile.css`,
  - koppeling `../css/forms.css`,
  - aanwezigheid invoervelden,
  - aanwezigheid sliders,
  - bij sliders: signalen van opslag/persistentie,
  - bij sliders: signalen van schaaluitleg.

## Samenvatting

- Viewport in orde op 62/63 pagina's.
- `mobile.css` gekoppeld op 60/63 pagina's.
- `forms.css` gekoppeld op 60/63 pagina's.
- Sliders gevonden op 4 pagina's; alle 4 tonen signalen van persistentie en schaaluitleg.

## Bevindingen (prioriteit)

### Kritiek

1. `iam/htm/toevoegingen.htm`
- Geen volwaardige IAM-pagina (snippetbron), mist viewport, CSS-koppelingen en document-structuur.
- Botst met werkafspraken als deze pagina direct toegankelijk/actief is.

### Hoog

1. `iam/htm/to_self_manage_game.htm`
- Heeft interactieve invoer en sliders, maar gebruikt niet de centrale IAM-CSS (`mobile.css`, `forms.css`).
- Risico op visuele/UX-inconsistentie met mobile-first IAM-afspraken.

### Middel

1. `iam/htm/gebruik-bijhouden.htm`
- Is een redirectpagina naar `dagelijks-gevolg.htm`.
- Mist IAM-CSS en dataStore-koppeling, maar functioneel is dit acceptabel zolang het echt alleen redirect is.

## Kernflow-check

- Alle pagina's uit de Leidende Set (Kernflow) zijn aanwezig op schijf.
- Er bestaan extra pagina's buiten de Leidende Set; dat hoeft niet fout te zijn, maar vraagt duidelijke status (actief, experiment, archief, redirect of snippet) conform One Truth.

## Beslissingen vastgelegd na audit

### to_self_manage_game.htm — blijft bewust standalone

- **Besluit:** `to_self_manage_game.htm` wordt niet gekoppeld aan IAM-CSS en geen kernpagina.
- Het is een zelfstandig spel, fundamenteel anders van aard dan de formulierpagina's in de kernflow.
- Algemene IAM-aanpassingen (CSS, dataStore, One Truth) zijn hier niet van toepassing.
- Zie `werkafspraken.md` § "Pagina's met bijzondere status" voor de volledige afspraak.

### gebruik-bijhouden.htm — verwijderd

- **Besluit:** Verwijderd. Was een pure redirect naar `dagelijks-gevolg.htm` zonder eigen inhoud.
- Verwijzingen in `index.htm` (PHASE_FORMS en MODERN_STRUCTURED_FORMS) zijn ook verwijderd.
- `dagelijks-gevolg.htm` was al aanwezig in dezelfde Fase 1-navigatie; de redirect was dubbel.



1. `toevoegingen.htm` verplaatsen naar een niet-routeerbare snippets/archieflocatie, of omzetten naar valide pagina met expliciete status-banner.
2. Voor `to_self_manage_game.htm`: beslissen of dit een IAM-kernpagina wordt (dan koppelen aan IAM-CSS) of expliciet als los experiment labelen.
3. Voor alle niet-kernflow pagina's: statuslabel toevoegen in documentatie (actief/experimenteel/archief/redirect).
