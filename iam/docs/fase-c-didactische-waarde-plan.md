# Fase C: Didactische Waarde & Zinvolheid

**Planning Date:** 12 mei 2026  
**Target Pages:** 6 abstract/reflectie pagina's  
**Objective:** Transform abstract pages → actionable pages (didactische waarde)

---

## Problem Statement

**Current State:**
- Pages like "wat-is-mijn-ik", "levensdoelen-stellen", "waardigheid" are rich but *abstract*
- Users fill them out, but don't get clear *next step* or *application context*
- High cognitive load: "Wat nu? Waar past dit in mijn plan?"
- Drop-off likely on reflection pages (no immediate action payload)

**Solution:**
Add three elements to each abstract page:
1. **Context cards** — "Wanneer wel/niet gebruiken" (explicit scenarios)
2. **Doorverwijzingen** — Direct links to concrete action pages
3. **"Nu doen" routing** — One-click integration into plan/crisis context

---

## Target Pages (Fase C)

| Page | Type | Current Gap | C-Solution |
|------|------|-------------|-----------|
| what-is-mijn-ik | Identity | Abstract identity → no link to actions | Add "persoonlijke-waarden" routing + scenario context |
| levensdoelen-stellen | Goal-setting | Goals written → not in plan | Add "plan-van-aanpak" integration button |
| waardigheid | Value-anchoring | Abstract anchor → unused in crisis | Add crisis-relevance context + noodplan-wegglijden link |
| motiverende-mensen | Motivation | Motivators listed → not accessible in crisis | Add quick-access overlay + link to steunnetwerk page |
| sociaal-netwerk | Social mapping | Network mapped → underused in risico-planning | Add "risico-mensen" integration |
| genieten-belonen | Reward planning | Rewards defined → not in daily agenda | Add "agenda" + "voor-nadelen-balansen" bridging |

---

## Implementation Pattern (per page)

### 1. Context Card: "Wanneer wel/niet gebruiken"

**HTML Structure:**
```html
<div class="context-card">
  <h3>Wanneer is dit bruikbaar?</h3>
  <div class="scenario-list">
    <div class="scenario">
      <strong>✓ Wel bruikbaar:</strong> Wanneer je jezelf kwijt raakt in routines... <a href="#risico-denken">zie risico-denken</a>
    </div>
    <div class="scenario">
      <strong>✗ Niet bruikbaar:</strong> Wanneer je in acute nood bent... <a href="#noodplan-wegglijden">ga direct naar noodplan</a>
    </div>
  </div>
</div>
```

**Styling:**
- Light blue background (#f4f8fb)
- Contextual icons (✓/✗)
- Inline links to other pages
- Max 3-4 scenarios per page

### 2. Doorverwijzing Cards: "Volgende Stap"

**HTML Structure:**
```html
<div class="integration-card">
  <h3>Klaar om dit toe te passen?</h3>
  <div class="action-grid">
    <a href="./plan-van-aanpak.htm" class="action-button primary">
      Voeg toe aan je plan
    </a>
    <a href="./steunnetwerk.htm" class="action-button secondary">
      Betrek je steun
    </a>
  </div>
</div>
```

**Button Tiers:**
- **Primary:** Most common next step (bold color)
- **Secondary:** Alternative paths (muted)
- **Tertiary:** Rarely used but available

### 3. Nu-Doen Routing: Crisis/Plan Context

**Logic:**
```javascript
function getApplicableContext() {
  // Check if crisis data exists
  if (iamData.getFormData('noodplan-wegglijden')?.mensenopdehoogte) {
    return { context: 'CRISIS', route: 'steunnetwerk' };
  }
  // Check if in active planning mode
  if (iamData.getFormData('plan-van-aanpak')?.weeklyReviewStatus) {
    return { context: 'PLANNING', route: 'plan-van-aanpak' };
  }
  // Default: reflection mode
  return { context: 'REFLECTION', route: 'index' };
}
```

**Display Logic:**
- If CRISIS: Show "Voeg toe aan je noodplan" button in red
- If PLANNING: Show "Voeg toe aan deze week" button in green
- If REFLECTION: Show "Bewaar voor later" button in blue

---

## Phased Implementation

### Phase C1 (Week 1): Design & Data Architecture
- [ ] Create context-card template (reusable across 6 pages)
- [ ] Map "when to use" scenarios for each page
- [ ] Define doorverwijzing button sets per page
- [ ] Test nu-doen routing logic on 1 page (pilot on wat-is-mijn-ik)

### Phase C2 (Week 2): Implementation on 3 Pages
- [ ] what-is-mijn-ik — Add context + routing + persoonlijke-waarden link
- [ ] levensdoelen-stellen — Add context + plan-van-aanpak integration
- [ ] waardigheid — Add context + crisis relevance + noodplan-wegglijden link

### Phase C3 (Week 3): Rollout to Remaining 3 Pages
- [ ] motiverende-mensen, sociaal-netwerk, genieten-belonen
- [ ] Final A/B testing (with vs. without context cards)
- [ ] User feedback collection

### Phase C4 (Week 4): Optimization & Metrics
- [ ] Track "context card click-through rate"
- [ ] Measure "doorverwijzing button usage"
- [ ] Monitor "page abandon rate" (should decrease)
- [ ] Collect user feedback on "didactische waarde"

---

## Success Metrics (C-specific)

| Metric | Baseline | Target | Timeline |
|--------|----------|--------|----------|
| Page dwell time | 2-3 min | 3-5 min | Week 2 |
| Doorverwijzing click-through | 0% | >40% | Week 3 |
| Page-to-action completion | Low | >70% | Week 4 |
| User satisfaction (survey) | N/A | >4/5 | Week 4 |
| Abandoned sessions after abstract page | High | <20% | Week 4 |

---

## Design Pattern: Reusable Components

### Context Card (template)
```css
.context-card {
  background: #f4f8fb;
  border-left: 4px solid #5b744a;
  border-radius: 8px;
  padding: 1.25rem;
  margin: 1.5rem 0;
}

.scenario {
  margin-bottom: 0.75rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #d0d8e0;
}

.scenario:last-child {
  border-bottom: none;
  margin-bottom: 0;
}
```

### Integration Button Set (template)
```css
.integration-card {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
  margin-top: 1.5rem;
}

@media (max-width: 600px) {
  .integration-card {
    grid-template-columns: 1fr;
  }
}
```

---

## Questions to Resolve (Before Implementation)

1. **Deep vs. Shallow Context?** Should context cards explain the *why* (deep) or just list scenarios (shallow)?
   - Recommendation: Shallow (2-3 sentences max) — users already know why on abstract pages

2. **How Many Doorverwijzingen per Page?** 2-3 primary actions or full menu?
   - Recommendation: 2-3 primary, max 1 secondary per page to avoid choice paralysis

3. **Should Nu-Doen Update Existing Data?** Or just soft-link to target page?
   - Recommendation: Soft-link only (avoid data collision; user chooses when to integrate)

4. **Mobile Behavior?** Context cards collapse or always visible?
   - Recommendation: Always visible (short enough to not clutter)

---

## Rollout Plan

**Timing:** After Fase B stabilizes (1-2 weeks post-deployment)

**Sequence:**
1. Build context card template + integration button set
2. Test on 1 page (wat-is-mijn-ik) in dev environment
3. Gather internal feedback (QA + stakeholders)
4. Rollout to 3 pages (week 1) if green
5. Rollout to remaining 3 pages (week 2) if metrics look good
6. Measure end-to-end impact (week 4)

**Acceptance Criteria:**
- [ ] All context cards load without delay (<50ms)
- [ ] Doorverwijzing buttons integrate data correctly
- [ ] Nu-doen routing works in crisis/planning/reflection modes
- [ ] Mobile layout doesn't break on 375px
- [ ] User feedback indicates improved "zinvolheid"

---

## Related Work Dependencies

- **Fase B complete:** ✅ (required for routing infrastructure)
- **Crisis module stable:** ✅ (required for crisis context detection)
- **User testing framework:** TBD (optional but recommended)

---

## Next Steps

1. ✅ Approve Fase C scope & design
2. ✅ Finalize "when to use" scenarios per page (collaborative workshop)
3. ✅ Build context card + integration button components
4. ✅ Test on wat-is-mijn-ik pilot
5. ✅ Launch Fase C1 (Week 1)

---

**Prepared by:** GitHub Copilot — Claude Haiku 4.5  
**Date:** 12 mei 2026 14:30 UTC  
**Status:** READY FOR APPROVAL  
**Est. Effort:** 2-3 weeks full implementation
