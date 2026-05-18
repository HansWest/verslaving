/**
 * Central Data Store for IAM (Integrative Addiction Management)
 * Handles all localStorage/IndexedDB operations
 * 
 * Privacy-first: All data stays on user's device
 * Multiple pages share this central data pool
 */

class IamDataStore {
  constructor() {
    this.storageKey = 'iam_data';
    this.version = '1.0';
    this.autoSaveInterval = 30000; // 30 seconds
    this.autoSaveTimer = null;
    this.fieldOverlapMap = this.buildFieldOverlapMap();
    this.init();
  }

  /**
   * Maintainer note: semantic overlap map for cross-form fields.
   *
   * Naming convention:
   * - Keep form-local fields specific (e.g. support1Name, personName).
   * - Use integration summary buckets as canonical cross-form meaning.
   * - Treat entries below as "semantic equivalents", not strict schema aliases.
   */
  buildFieldOverlapMap() {
    return {
      supportPerson: {
        description: 'People that can provide support, from quick contact to concrete support plan.',
        fields: [
          'plan-van-aanpak.supportPeople',
          'sociaal-netwerk.reachableSupport',
          'sociaal-netwerk.firstReachOut',
          'steunnetwerk.support1Name',
          'steunnetwerk.support2Name',
          'steunnetwerk.support3Name',
          'motiverende-mensen.personName'
        ],
        integrationBuckets: ['supportNetwork']
      },
      motivationAnchor: {
        description: 'Motivational direction and why-change anchors.',
        fields: [
          'plan-van-aanpak.mainGoal',
          'voor-nadelen-balansen.decisionNote',
          'motiverende-mensen.motivationType',
          'motiverende-mensen.messageToPerson',
          'waarom-wel-gebruiken.functionSummary'
        ],
        integrationBuckets: ['motivationAnchors']
      },
      triggerPressure: {
        description: 'Pressure and trigger-like content including what use dampens/avoids.',
        fields: [
          'sociaal-netwerk.cravingPeople',
          'risico-mensen.riskySituationWithPerson',
          'waarom-wel-gebruiken.notFeeling',
          'waarom-wel-gebruiken.notThinking',
          'waarom-wel-gebruiken.spaceGiven'
        ],
        integrationBuckets: ['topTriggers']
      },
      needSignalABCD: {
        description: 'Need signal (ABCDaaah B) that should map to alternatives and change advantages.',
        fields: [
          'trek-opvangen.behoefte',
          'trek-opvangen.alternatief',
          'voor-nadelen-balansen.changeAdvantagesText'
        ],
        integrationBuckets: []
      },
      dateStartSemantics: {
        description: 'Start date appears in multiple forms with form-specific meaning.',
        fields: [
          'plan-van-aanpak.startDate',
          'steunnetwerk.startDate'
        ],
        integrationBuckets: []
      }
    };
  }

  getFieldOverlapMap() {
    return this.fieldOverlapMap;
  }

  /**
   * Initialize data store on first load
   */
  init() {
    if (!this.getData()) {
      this.createNewData();
    }
    this.startAutoSave();
  }

  /**
   * Create new empty data structure
   */
  createNewData() {
    const newData = {
      version: this.version,
      userId: this.generateUUID(),
      created: new Date().toISOString(),
      lastModified: new Date().toISOString(),
      appMeta: {
        weeklyReview: {
          lastCompletedAt: null,
          reflection: '',
          learning: '',
          nextStep: '',
          history: []
        },
        sleepTracking: {
          enabled: false,
          lastModified: null
        },
        trackingSettings: {
          sleep: false,
          food: false,
          training: false,
          meditation: false,
          social: false,
          emotion: false,
          frustration: false
        },
        crossPollination: {
          profile: 'gebalanceerd',
          phase: 'stabilisatie',
          lastModified: null
        }
      },
      forms: {
        'craving-gevoel': {
          layer1: {
            name: '',
            bodyLocation: ''
          },
          layer2: {
            name: '',
            bodyLocation: ''
          },
          layer3: {
            name: '',
            bodyLocation: ''
          },
          differenceMain: '',
          differenceMiddle: '',
          notes: '',
          lastUpdated: null
        },
        'lastige-gevoelens': {
          avoidTriggers: '',
          distractionIdeas: '',
          healthyIntensity: '',
          resolveApproach: '',
          enduranceSupport: '',
          acceptancePractice: '',
          talkPeople: '',
          reframing: '',
          examplesFromOthers: '',
          feelingSurfing: '',
          nextTimeAvoid: '',
          learningPeriod: '',
          lastUpdated: null
        },
        'voor-nadelen-balansen': {
          usage: {
            advantages: [],
            disadvantages: []
          },
          change: {
            advantages: [],
            disadvantages: []
          },
          usageAdvantagesText: '',
          usageDisadvantagesText: '',
          changeAdvantagesText: '',
          changeDisadvantagesText: '',
          decisionNote: '',
          lastUpdated: null
        },
        'stimulus-respons': {
          stimulus: '',
          passiveAvoidance: '',
          activeAvoidance: '',
          functionalAlternative: '',
          distraction: '',
          cognitive: '',
          attention: '',
          socialSupport: '',
          contingencyReward: '',
          longTerm: '',
          practicePlan: '',
          lastUpdated: null
        },
        'risico-situaties': {
          situationDraft: '',
          riskySituations: '',
          externalRisks: '',
          internalRisks: '',
          afterRisks: '',
          nextRiskDate: '',
          nextRiskLabel: '',
          responsePlan: '',
          lastUpdated: null
        },
        'risico-mensen': {
          personName: '',
          closenessScore: '',
          riskType: '',
          riskySituationWithPerson: '',
          hopeFromPerson: '',
          instructionReceived: 'nee',
          noInstructionReason: '',
          wiseWords: '',
          planA: '',
          planB: '',
          boundarySummary: '',
          lastUpdated: null
        },
        'risico-activiteiten': {
          activityDraft: '',
          riskyActivities: '',
          externalRisks: '',
          internalRisks: '',
          preparationPlan: '',
          exitStrategy: '',
          afterRisks: '',
          rationalizationRisks: '',
          matchingSkills: '',
          lastUpdated: null
        },
        'soorten-trek': {
          cravingType1Name: '',
          cravingType1BodySignals: '',
          cravingType1Context: '',
          cravingType1Duration: '',
          cravingType1HelpfulResponse: '',
          cravingType2Name: '',
          cravingType2BodySignals: '',
          cravingType2Context: '',
          cravingType2Duration: '',
          cravingType2HelpfulResponse: '',
          cravingType3Name: '',
          cravingType3BodySignals: '',
          cravingType3Context: '',
          cravingType3Duration: '',
          cravingType3HelpfulResponse: '',
          earlyWarningPattern: '',
          noGoSignals: '',
          reflection: '',
          lastUpdated: null
        },
        'plan-van-aanpak': {
          startPoint: '',
          mainGoal: '',
          goalDate: '',
          usageGoal: '',
          sustainabilityTerm: '',
          planA: '',
          planB: '',
          fallbackGoal: '',
          startDate: '',
          supportPeople: '',
          rewards: '',
          goals: [],
          steps: [],
          lastUpdated: null
        },
        'sociaal-netwerk': {
          closeRing: '',
          middleRing: '',
          farRing: '',
          desiredConnections: '',
          networkReflection: '',
          motivatingPerson: '',
          motivatingWhy: '',
          reachableSupport: '',
          supportType: '',
          carefulPeople: '',
          uncarefulPeople: '',
          cravingPeople: '',
          safePeople: '',
          safetyCareOverlap: '',
          supportNetworkPeople: '',
          talkCravingPeople: '',
          cravingUserPeople: '',
          cravingNonUserPeople: '',
          coUserPeople: '',
          unawarePeople: '',
          firstReachOut: '',
          nextContactDate: '',
          trustLevel: '',
          contactRoute: '',
          anchor1Name: '',
          anchor1Quality: '',
          anchor2Name: '',
          anchor2Quality: '',
          anchor3Name: '',
          anchor3Quality: '',
          lastUpdated: null
        },
        'steunnetwerk': {
          support1Name: '',
          support1Reachability: '',
          support1Speed: '',
          support1Route: '',
          support1SupportType: '',
          support1Reliability: '',
          support1Guide: '',
          support2Name: '',
          support2Reachability: '',
          support2Speed: '',
          support2Route: '',
          support2SupportType: '',
          support2Reliability: '',
          support2Guide: '',
          support3Name: '',
          support3Reachability: '',
          support3Speed: '',
          support3Route: '',
          support3SupportType: '',
          support3Reliability: '',
          support3Guide: '',
          startDate: '',
          networkSummary: '',
          lastUpdated: null
        }
      },
      integrationSummary: null
    };
    newData.integrationSummary = this.buildIntegrationSummary(newData.forms);
    this.saveData(newData);
    return newData;
  }

  /**
   * Get all data
   */
  getData() {
    try {
      const data = localStorage.getItem(this.storageKey);
      return data ? JSON.parse(data) : null;
    } catch (e) {
      console.error('Error reading data:', e);
      return null;
    }
  }

  /**
   * Save all data
   */
  saveData(data) {
    try {
      data.lastModified = new Date().toISOString();
      localStorage.setItem(this.storageKey, JSON.stringify(data));
      return true;
    } catch (e) {
      console.error('Error saving data:', e);
      return false;
    }
  }

  /**
   * Get specific form data
   */
  getFormData(formType) {
    const data = this.getData();
    return data?.forms?.[formType] || null;
  }

  getAppMeta(key) {
    const data = this.getData();
    return key ? data?.appMeta?.[key] || null : data?.appMeta || null;
  }

  normalizeTrekDossierState(state = {}) {
    const entries = Array.isArray(state.entries)
      ? state.entries.map((entry) => this.normalizeTrekDossierEntry(entry))
      : [];

    entries.sort((left, right) => {
      const dateOrder = String(right.date || '').localeCompare(String(left.date || ''));
      if (dateOrder !== 0) return dateOrder;
      return String(right.updatedAt || '').localeCompare(String(left.updatedAt || ''));
    });

    const activeId = typeof state.activeId === 'string' ? state.activeId : '';
    const resolvedActiveId = entries.some((entry) => entry.id === activeId)
      ? activeId
      : (entries[0] ? entries[0].id : '');

    return {
      activeId: resolvedActiveId,
      entries: entries
    };
  }

  normalizeTrekDossierEntry(entry = {}) {
    const now = new Date().toISOString();
    const pages = entry.pages && typeof entry.pages === 'object' ? entry.pages : {};

    return {
      id: typeof entry.id === 'string' && entry.id ? entry.id : this.generateUUID(),
      date: typeof entry.date === 'string' && entry.date ? entry.date : now.slice(0, 10),
      keyword: typeof entry.keyword === 'string' ? entry.keyword : '',
      createdAt: typeof entry.createdAt === 'string' && entry.createdAt ? entry.createdAt : now,
      updatedAt: typeof entry.updatedAt === 'string' && entry.updatedAt ? entry.updatedAt : now,
      pages: pages
    };
  }

  getTrekDossierState() {
    return this.normalizeTrekDossierState(this.getAppMeta('trekDossiers') || {});
  }

  saveTrekDossierState(state) {
    const normalized = this.normalizeTrekDossierState(state || {});
    this.updateAppMeta('trekDossiers', normalized);
    return normalized;
  }

  getTrekDossierEntries() {
    return this.getTrekDossierState().entries || [];
  }

  getActiveTrekDossier() {
    const state = this.getTrekDossierState();
    return state.entries.find((entry) => entry.id === state.activeId) || null;
  }

  setActiveTrekDossier(entryId) {
    const state = this.getTrekDossierState();
    if (state.entries.some((entry) => entry.id === entryId)) {
      state.activeId = entryId;
    }
    return this.saveTrekDossierState(state);
  }

  createTrekDossier(payload = {}) {
    const now = new Date().toISOString();
    const entry = this.normalizeTrekDossierEntry({
      id: this.generateUUID(),
      date: payload.date,
      keyword: payload.keyword,
      createdAt: now,
      updatedAt: now,
      pages: payload.pages || {}
    });
    const state = this.getTrekDossierState();
    state.entries.unshift(entry);
    state.activeId = entry.id;
    this.saveTrekDossierState(state);
    return entry;
  }

  updateTrekDossierMeta(entryId, patch = {}) {
    if (!entryId) return null;
    const state = this.getTrekDossierState();
    const entry = state.entries.find((item) => item.id === entryId);
    if (!entry) return null;

    const nextDate = typeof patch.date === 'string' && patch.date ? patch.date : entry.date;
    const nextKeyword = typeof patch.keyword === 'string' ? patch.keyword : entry.keyword;

    entry.date = nextDate;
    entry.keyword = nextKeyword;
    entry.updatedAt = new Date().toISOString();
    this.saveTrekDossierState(state);
    return entry;
  }

  updateTrekDossierPage(entryId, formKey, formData) {
    if (!entryId || !formKey) return null;
    const state = this.getTrekDossierState();
    const entry = state.entries.find((item) => item.id === entryId);
    if (!entry) return null;

    if (!entry.pages || typeof entry.pages !== 'object') {
      entry.pages = {};
    }

    entry.pages[formKey] = {
      ...formData,
      lastUpdated: new Date().toISOString()
    };
    entry.updatedAt = new Date().toISOString();
    this.saveTrekDossierState(state);
    return entry.pages[formKey];
  }

  getTrekDossierPage(entryId, formKey) {
    const state = this.getTrekDossierState();
    const entry = state.entries.find((item) => item.id === entryId);
    return entry?.pages?.[formKey] || null;
  }

  updateAppMeta(key, value) {
    const data = this.getData();
    if (!data.appMeta) {
      data.appMeta = {};
    }

    const currentValue = data.appMeta[key] || {};
    data.appMeta[key] = {
      ...currentValue,
      ...value
    };

    this.saveData(data);
    return data.appMeta[key];
  }

  /**
   * Get canonical integration summary derived from multiple forms
   */
  getIntegrationSummary(forceRebuild = false) {
    const data = this.getData();
    if (!data) return null;

    if (forceRebuild || !data.integrationSummary) {
      data.integrationSummary = this.buildIntegrationSummary(data.forms || {});
      this.saveData(data);
    }

    return data.integrationSummary;
  }

  topInsightItems(items, max = 2) {
    if (!Array.isArray(items)) return [];
    return this.uniqueLimited(items.filter(Boolean), max);
  }

  getCrossPollinationPack(context) {
    const tuning = this.getCrossPollinationTuning();
    const summary = this.getIntegrationSummary();
    if (!summary) {
      return { context, available: false };
    }

    if (context === 'sova-grenzen') {
      return {
        context,
        available: true,
        triggers: this.topInsightItems(summary.topTriggers, tuning.mainCap),
        supports: this.topInsightItems(summary.supportNetwork, tuning.secondaryCap),
        interventions: this.topInsightItems(summary.bestInterventions, tuning.mainCap)
      };
    }

    if (context === 'sova-mixed-signals') {
      return {
        context,
        available: true,
        triggers: this.topInsightItems(summary.topTriggers, tuning.mainCap),
        supports: this.topInsightItems(summary.supportNetwork, tuning.secondaryCap),
        fallbacks: this.topInsightItems(summary.fallbackMoves, tuning.mainCap)
      };
    }

    if (context === 'smoezenboekverhaal') {
      return {
        context,
        available: true,
        triggers: this.topInsightItems(summary.topTriggers, tuning.triggerCap),
        motivations: this.topInsightItems(summary.motivationAnchors, tuning.secondaryCap),
        interventions: this.topInsightItems(summary.bestInterventions, tuning.mainCap)
      };
    }

    if (context === 'to-do-lijst') {
      const suggestions = [];
      this.topInsightItems(summary.earlyWarnings, tuning.mainCap).forEach((item) => {
        suggestions.push({ title: `Vroege waarschuwing monitoren: ${item}`, importance: 'hoog', urgency: 'nu' });
      });
      this.topInsightItems(summary.bestInterventions, tuning.mainCap).forEach((item) => {
        suggestions.push({ title: `Interventie inplannen: ${item}`, importance: 'hoog', urgency: 'deze-week' });
      });
      this.topInsightItems(summary.supportNetwork, tuning.secondaryCap).forEach((item) => {
        suggestions.push({ title: `Steuncontact plannen met: ${item}`, importance: 'middel', urgency: 'deze-week' });
      });

      const seen = new Set();
      const uniqueSuggestions = [];
      suggestions.forEach((item) => {
        const key = String(item.title || '').trim().toLowerCase();
        if (!key || seen.has(key)) return;
        seen.add(key);
        uniqueSuggestions.push(item);
      });

      return {
        context,
        available: true,
        suggestions: uniqueSuggestions.slice(0, tuning.todoCap)
      };
    }

    if (context === 'plan-van-aanpak-core') {
      const balans = this.getFormData('voor-nadelen-balansen') || {};
      const trek = this.getFormData('soorten-trek') || {};
      const risicoSituaties = this.getFormData('risico-situaties') || {};
      const risicoMensen = this.getFormData('risico-mensen') || {};
      const sociaalNetwerk = this.getFormData('sociaal-netwerk') || {};
      const risicoActiviteiten = this.getFormData('risico-activiteiten') || {};
      const stimulus = this.getFormData('stimulus-respons') || {};
      const gevoelens = this.getFormData('lastige-gevoelens') || {};
      const smoezen = this.getFormData('smoezenboekverhaal') || {};
      const sovaGrenzen = this.getFormData('sova-grenzen') || {};
      const sovaMixed = this.getFormData('sova-mixed-signals') || {};

      const pool = [
        { text: summary?.topTriggers?.[0] || risicoSituaties.riskySituations, source: 'risico-situaties', target: 'startPoint' },
        { text: summary?.motivationAnchors?.[0] || balans.decisionNote, source: 'voor-nadelen-balansen', target: 'mainGoal' },
        { text: risicoSituaties.responsePlan || stimulus.functionalAlternative, source: 'risico-situaties / stimulus-respons', target: 'planA' },
        { text: risicoActiviteiten.exitStrategy || risicoActiviteiten.afterRisks, source: 'risico-activiteiten', target: 'planB' },
        { text: summary?.supportNetwork?.[0] || risicoMensen.personName || sociaalNetwerk.reachableSupport || sociaalNetwerk.firstReachOut || stimulus.socialSupport, source: 'supportNetwork', target: 'supportPeople' },
        { text: stimulus.contingencyReward || gevoelens.enduranceSupport, source: 'stimulus-respons / lastige-gevoelens', target: 'rewards' },
        { text: summary?.fallbackMoves?.[0] || trek.noGoSignals || risicoMensen.boundarySummary, source: 'nood/terugvalsignalen', target: 'fallbackGoal' },
        { text: smoezen.ontkrachting01 || smoezen.ontkrachting02, source: 'smoezenboek', target: 'planB' },
        { text: sovaGrenzen.wensgedrag || sovaMixed.wensgedrag, source: 'sova', target: 'planA' },
        { text: (this.getFormData('wat-is-mijn-ik') || {}).workStrengthen, source: 'wat-is-mijn-ik', target: 'mainGoal' },
        { text: (this.getFormData('wat-is-mijn-ik') || {}).valuesStrengthen, source: 'wat-is-mijn-ik', target: 'mainGoal' },
        { text: (this.getFormData('wat-is-mijn-ik') || {}).socialStrengthen, source: 'wat-is-mijn-ik', target: 'supportPeople' },
        { text: (this.getFormData('wat-is-mijn-ik') || {}).bodyStrengthen, source: 'wat-is-mijn-ik', target: 'planA' }
      ];

      const unique = [];
      pool.forEach((item) => {
        const clean = String(item.text || '').trim();
        if (!clean) return;
        if (unique.some((entry) => entry.text.toLowerCase() === clean.toLowerCase())) return;
        unique.push({ ...item, text: clean });
      });

      return {
        context,
        available: unique.length > 0,
        suggestions: unique.slice(0, tuning.planCap)
      };
    }

    if (context === 'plan-van-aanpak-boost') {
      const smoezen = this.getFormData('smoezenboekverhaal') || {};
      const sovaGrenzen = this.getFormData('sova-grenzen') || {};
      const sovaMixed = this.getFormData('sova-mixed-signals') || {};

      const pool = [
        { text: smoezen.smoes01, source: 'smoes01', target: 'fallbackGoal', prefix: 'Herken-smoes' },
        { text: smoezen.ontkrachting01, source: 'ontkrachting01', target: 'planB', prefix: 'Ontkrachting' },
        { text: smoezen.ontkrachting02, source: 'ontkrachting02', target: 'planB', prefix: 'Ontkrachting' },
        { text: sovaGrenzen.wensgedrag, source: 'sova-grenzen', target: 'planA', prefix: 'Grensactie' },
        { text: sovaMixed.wensgedrag, source: 'sova-mixed-signals', target: 'planA', prefix: 'Communicatie-actie' },
        { text: sovaMixed.wensgedrag02, source: 'sova-mixed-signals', target: 'planA', prefix: 'Reserve-afspraak' }
      ];

      const unique = [];
      pool.forEach((item) => {
        const clean = String(item.text || '').trim();
        if (!clean) return;
        const key = clean.toLowerCase();
        if (unique.some((entry) => entry.key === key)) return;
        unique.push({ ...item, text: clean, key: key });
      });

      return {
        context,
        available: unique.length > 0,
        suggestions: unique.slice(0, tuning.boostCap)
      };
    }

    if (context === 'wat-is-mijn-ik') {
      const forms = (this.getData() || {}).forms || {};
      const getF = (key) => forms[key] || {};
      const soortenTrek = getF('soorten-trek');
      const chemsexPatroon = getF('chemsex-patroon');
      const chemsexWatWilIk = getF('chemsex-wat-wil-ik');
      const waarden = getF('persoonlijke-waarden');
      const motiverendeMensen = getF('motiverende-mensen');
      const steunnetwerk = getF('steunnetwerk');
      const risicoSituaties = getF('risico-situaties');

      return {
        context,
        available: true,
        body: this.topInsightItems([
          soortenTrek.earlyWarningPattern,
          soortenTrek.noGoSignals,
          risicoSituaties.internalRisks,
          chemsexPatroon.comedownBody,
          chemsexPatroon.earlySignals
        ], tuning.secondaryCap),
        sexual: this.topInsightItems([
          chemsexPatroon.sessionPositives,
          chemsexPatroon.nextChange,
          chemsexWatWilIk.coreNeed,
          chemsexWatWilIk.avoidFeeling
        ], tuning.secondaryCap),
        social: this.topInsightItems([
          ...(summary.supportNetwork || []),
          motiverendeMensen.personName,
          steunnetwerk.networkSummary
        ], tuning.secondaryCap),
        work: this.topInsightItems([
          ...(summary.motivationAnchors || []).slice(0, 2),
          waarden.waarde01,
          waarden.waardenterugzien
        ], tuning.secondaryCap),
        values: this.topInsightItems([
          waarden.waarde01,
          waarden.waarde02,
          waarden.waarde03,
          chemsexWatWilIk.importantValues,
          chemsexWatWilIk.futureVision,
          ...(summary.motivationAnchors || []).slice(0, 2)
        ], tuning.secondaryCap)
      };
    }

    return { context, available: false };
  }

  getCrossPollinationSettings() {
    const stored = this.getAppMeta('crossPollination') || {};
    const profile = ['voorzichtig', 'gebalanceerd', 'directief'].includes(stored.profile)
      ? stored.profile
      : 'gebalanceerd';
    const phase = ['crisis', 'stabilisatie', 'groei'].includes(stored.phase)
      ? stored.phase
      : 'stabilisatie';

    return {
      profile,
      phase,
      lastModified: stored.lastModified || null
    };
  }

  setCrossPollinationSettings(next = {}) {
    const current = this.getCrossPollinationSettings();
    const profile = ['voorzichtig', 'gebalanceerd', 'directief'].includes(next.profile)
      ? next.profile
      : current.profile;
    const phase = ['crisis', 'stabilisatie', 'groei'].includes(next.phase)
      ? next.phase
      : current.phase;

    return this.updateAppMeta('crossPollination', {
      profile,
      phase,
      lastModified: new Date().toISOString()
    });
  }

  getCrossPollinationTuning() {
    const settings = this.getCrossPollinationSettings();
    const profileMap = {
      voorzichtig: {
        mainCap: 1,
        secondaryCap: 1,
        triggerCap: 2,
        todoCap: 3,
        planCap: 3,
        boostCap: 3
      },
      gebalanceerd: {
        mainCap: 2,
        secondaryCap: 2,
        triggerCap: 3,
        todoCap: 6,
        planCap: 5,
        boostCap: 6
      },
      directief: {
        mainCap: 3,
        secondaryCap: 2,
        triggerCap: 4,
        todoCap: 8,
        planCap: 7,
        boostCap: 8
      }
    };

    const phaseAdjustments = {
      crisis: { mainCap: 1, secondaryCap: 1, triggerCap: 2 },
      stabilisatie: { },
      groei: { mainCap: 1, triggerCap: 1 }
    };

    const base = profileMap[settings.profile] || profileMap.gebalanceerd;
    const adjusted = { ...base };
    const phaseShift = phaseAdjustments[settings.phase] || phaseAdjustments.stabilisatie;

    Object.keys(phaseShift).forEach((key) => {
      adjusted[key] = Math.max(1, (adjusted[key] || 1) + phaseShift[key]);
    });

    return adjusted;
  }

  /**
   * Update specific form data
   */
  updateFormData(formType, formData) {
    const data = this.getData();
    if (!data.forms[formType]) {
      data.forms[formType] = {};
    }
    data.forms[formType] = {
      ...data.forms[formType],
      ...formData,
      lastUpdated: new Date().toISOString()
    };
    data.integrationSummary = this.buildIntegrationSummary(data.forms || {});
    this.saveData(data);
    return data.forms[formType];
  }

  /**
   * Alias for updateFormData for backward compatibility
   */
  setFormData(formType, formData) {
    return this.updateFormData(formType, formData);
  }

  /**
   * Build reusable cross-form insights from modern and bridged pages
   */
  buildIntegrationSummary(forms) {
    const getForm = (key) => forms?.[key] || {};

    const stimulus = getForm('stimulus-respons');
    const risicoSituaties = getForm('risico-situaties');
    const risicoMensen = getForm('risico-mensen');
    const risicoActiviteiten = getForm('risico-activiteiten');
    const soortenTrek = getForm('soorten-trek');
    const gevoelens = getForm('lastige-gevoelens');
    const waaromWel = getForm('waarom-wel-gebruiken');
    const balans = getForm('voor-nadelen-balansen');
    const waarden = getForm('persoonlijke-waarden');
    const plan = getForm('plan-van-aanpak');
    const sociaalNetwerk = getForm('sociaal-netwerk');
    const steunnetwerk = getForm('steunnetwerk');
    const motiverendeMensen = getForm('motiverende-mensen');
    const watIsMijnIk = getForm('wat-is-mijn-ik');
    const sovaGrenzen = getForm('sova-grenzen');
    const sovaMixed = getForm('sova-mixed-signals');
    const smoezen = getForm('smoezenboekverhaal');
    const levensdoelen = getForm('levensdoelen-stellen');
    const genietBeloon = getForm('genieten-belonen');
    const waardigheid = getForm('waardigheid');
    const chemsexPatroon = getForm('chemsex-patroon');
    const chemsexWatWilIk = getForm('chemsex-wat-wil-ik');
    const combineParts = (...parts) => parts
      .filter((part) => typeof part === 'string' && part.trim())
      .join(' - ');

    const topTriggersBucket = this.buildInsightBucket([
      risicoSituaties.riskySituations,
      risicoActiviteiten.riskyActivities,
      stimulus.stimulus,
      soortenTrek.cravingType1Context,
      soortenTrek.cravingType2Context,
      soortenTrek.cravingType3Context,
      risicoMensen.riskySituationWithPerson,
      sociaalNetwerk.cravingPeople,
      sociaalNetwerk.cravingUserPeople,
      sociaalNetwerk.cravingNonUserPeople,
      sociaalNetwerk.coUserPeople,
      sociaalNetwerk.uncarefulPeople,
      sociaalNetwerk.unawarePeople,
      waaromWel.notFeeling,
      waaromWel.notThinking,
      waaromWel.spaceGiven,
      waaromWel.functionSummary
    ], 8);

    const supportNetworkBucket = this.buildInsightBucket([
      stimulus.socialSupport,
      gevoelens.talkPeople,
      plan.supportPeople,
      risicoMensen.personName,
      sociaalNetwerk.reachableSupport,
      sociaalNetwerk.supportNetworkPeople,
      sociaalNetwerk.carefulPeople,
      sociaalNetwerk.safePeople,
      sociaalNetwerk.talkCravingPeople,
      sociaalNetwerk.firstReachOut,
      combineParts(sociaalNetwerk.anchor1Name, sociaalNetwerk.anchor1Quality),
      combineParts(sociaalNetwerk.anchor2Name, sociaalNetwerk.anchor2Quality),
      combineParts(sociaalNetwerk.anchor3Name, sociaalNetwerk.anchor3Quality),
      combineParts(steunnetwerk.support1Name, steunnetwerk.support1SupportType),
      combineParts(steunnetwerk.support2Name, steunnetwerk.support2SupportType),
      combineParts(steunnetwerk.support3Name, steunnetwerk.support3SupportType),
      steunnetwerk.networkSummary,
      motiverendeMensen.personName,
      combineParts(motiverendeMensen.personName, motiverendeMensen.personRole),
      levensdoelen.steunHerinnering
    ], 8);

    const bestInterventionsBucket = this.buildInsightBucket([
      stimulus.functionalAlternative,
      stimulus.activeAvoidance,
      stimulus.distraction,
      stimulus.attention,
      risicoSituaties.responsePlan,
      risicoActiviteiten.preparationPlan,
      risicoActiviteiten.exitStrategy,
      gevoelens.enduranceSupport,
      gevoelens.acceptancePractice,
      plan.planA,
      sovaGrenzen.wensgedrag,
      sovaGrenzen.jouwwensgedrag,
      sovaMixed.wensgedrag,
      sovaMixed.wensgedrag02,
      smoezen.ontkrachting01,
      smoezen.ontkrachting02,
      smoezen.ontkrachting03,
      genietBeloon.genietingenmomenteel,
      genietBeloon.gedragBelonen,
      genietBeloon.snelBelonen,
      levensdoelen.eersteStap
    ], 10);

    const fallbackMovesBucket = this.buildInsightBucket([
      plan.planB,
      risicoMensen.planB,
      risicoActiviteiten.afterRisks,
      risicoSituaties.afterRisks,
      gevoelens.nextTimeAvoid
    ], 8);

    const earlyWarningsBucket = this.buildInsightBucket([
      soortenTrek.earlyWarningPattern,
      soortenTrek.noGoSignals,
      risicoSituaties.internalRisks,
      risicoActiviteiten.internalRisks,
      sovaGrenzen.lastgedrag,
      sovaMixed.lastgedrag,
      smoezen.smoes01,
      smoezen.smoes02,
      smoezen.smoes03,
      levensdoelen.grensSignalen,
      chemsexPatroon.earlySignals
    ], 8);

    const motivationAnchorsBucket = this.buildInsightBucket([
      plan.mainGoal,
      plan.usageGoal,
      balans.decisionNote,
      waarden.waarde01,
      waarden.waarde02,
      waarden.waarde03,
      waarden.waardenterugzien,
      waarden.waardenterugzien02,
      waarden.waardenterugzien03,
      soortenTrek.reflection,
      gevoelens.learningPeriod,
      motiverendeMensen.motivationType,
      motiverendeMensen.visibleProgress,
      motiverendeMensen.messageToPerson,
      waaromWel.functionSummary,
      combineParts(motiverendeMensen.anchor1Name, motiverendeMensen.anchor1Why),
      combineParts(motiverendeMensen.anchor2Name, motiverendeMensen.anchor2Why),
      combineParts(motiverendeMensen.anchor3Name, motiverendeMensen.anchor3Why),
      watIsMijnIk.workStrengthen,
      watIsMijnIk.valuesStrengthen,
      watIsMijnIk.socialStrengthen,
      watIsMijnIk.bodyStrengthen,
      levensdoelen.levensDoelen,
      levensdoelen.steunHerinnering,
      waardigheid.intrinsiekWaarde,
      waardigheid.toegevoegdeWaarde,
      chemsexWatWilIk.coreNeed,
      chemsexWatWilIk.importantValues,
      chemsexWatWilIk.futureVision
    ], 8);

    const insightMeta = {
      topTriggers: topTriggersBucket.meta,
      supportNetwork: supportNetworkBucket.meta,
      bestInterventions: bestInterventionsBucket.meta,
      fallbackMoves: fallbackMovesBucket.meta,
      earlyWarnings: earlyWarningsBucket.meta,
      motivationAnchors: motivationAnchorsBucket.meta
    };

    const metaList = Object.values(insightMeta);
    const avgCoverage = metaList.length
      ? Math.round(metaList.reduce((sum, meta) => sum + meta.coveragePct, 0) / metaList.length)
      : 0;

    return {
      topTriggers: topTriggersBucket.items,
      supportNetwork: supportNetworkBucket.items,
      bestInterventions: bestInterventionsBucket.items,
      fallbackMoves: fallbackMovesBucket.items,
      earlyWarnings: earlyWarningsBucket.items,
      motivationAnchors: motivationAnchorsBucket.items,
      insightMeta,
      metrics: {
        averageCoveragePct: avgCoverage,
        confidenceLabel: this.coverageToConfidenceLabel(avgCoverage),
        populatedInsightCount: metaList.filter((meta) => meta.filledSources > 0).length,
        totalInsightCount: metaList.length
      },
      updatedAt: new Date().toISOString()
    };
  }

  buildInsightBucket(sourceValues, limit = 8) {
    const normalizedLists = sourceValues.map((value) => this.normalizeList(value));
    const items = this.uniqueLimited(normalizedLists.flat(), limit);
    const totalSources = sourceValues.length;
    const filledSources = normalizedLists.filter((list) => list.length > 0).length;
    const coveragePct = totalSources ? Math.round((filledSources / totalSources) * 100) : 0;

    return {
      items,
      meta: {
        totalSources,
        filledSources,
        coveragePct,
        confidenceLabel: this.coverageToConfidenceLabel(coveragePct)
      }
    };
  }

  coverageToConfidenceLabel(coveragePct) {
    if (coveragePct >= 75) return 'hoog';
    if (coveragePct >= 40) return 'middel';
    return 'laag';
  }

  normalizeList(value) {
    if (value === null || value === undefined) return [];

    if (Array.isArray(value)) {
      return value.flatMap((item) => this.normalizeList(item));
    }

    if (typeof value === 'object') {
      return Object.values(value).flatMap((item) => this.normalizeList(item));
    }

    if (typeof value === 'string') {
      return value
        .split(/\n|;|\u2022|•|,/)
        .map((item) => item.trim())
        .filter(Boolean)
        .filter((item) => item.length >= 2);
    }

    if (typeof value === 'number') {
      return [String(value)];
    }

    return [];
  }

  uniqueLimited(list, limit = 8) {
    const seen = new Set();
    const result = [];

    list.forEach((item) => {
      const normalized = String(item || '').trim();
      if (!normalized) return;

      const key = normalized.toLowerCase();
      if (seen.has(key)) return;

      seen.add(key);
      result.push(normalized);
    });

    return result.slice(0, limit);
  }

  /**
   * Start auto-save (30 seconds)
   */
  startAutoSave() {
    this.autoSaveTimer = setInterval(() => {
      const data = this.getData();
      if (data) {
        this.saveData(data);
      }
    }, this.autoSaveInterval);
  }

  /**
   * Stop auto-save
   */
  stopAutoSave() {
    if (this.autoSaveTimer) {
      clearInterval(this.autoSaveTimer);
    }
  }

  /**
   * Export data as JSON
   */
  exportJSON() {
    const data = this.getData();
    const jsonString = JSON.stringify(data, null, 2);
    const blob = new Blob([jsonString], { type: 'application/json' });
    return {
      filename: `iam-backup-${new Date().toISOString().split('T')[0]}.json`,
      blob: blob
    };
  }

  /**
   * Export data as CSV (simplified, form-specific)
   */
  exportFormCSV(formType) {
    const formData = this.getFormData(formType);
    if (!formData) return null;

    let csv = 'IAM Data Export\n';
    csv += `Form Type,${formType}\n`;
    csv += `Export Date,${new Date().toISOString()}\n\n`;

    // Generic CSV for array of objects
    if (Array.isArray(formData)) {
      const keys = formData[0] ? Object.keys(formData[0]) : [];
      csv += keys.join(',') + '\n';
      formData.forEach(item => {
        csv += keys.map(key => {
          const val = item[key];
          return typeof val === 'string' && val.includes(',') ? `"${val}"` : val;
        }).join(',') + '\n';
      });
    } else {
      // Key-value pairs
      Object.entries(formData).forEach(([key, value]) => {
        if (typeof value !== 'object') {
          csv += `${key},"${value}"\n`;
        }
      });
    }

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    return {
      filename: `iam-${formType}-${new Date().toISOString().split('T')[0]}.csv`,
      blob: blob
    };
  }

  /**
   * Import JSON data
   */
  importJSON(jsonString) {
    try {
      const data = JSON.parse(jsonString);
      if (data.version && data.forms) {
        this.saveData(data);
        return { success: true, message: 'Data imported successfully' };
      }
      return { success: false, message: 'Invalid data format' };
    } catch (e) {
      return { success: false, message: 'Error parsing JSON: ' + e.message };
    }
  }

  /**
   * Clear all data (with confirmation)
   */
  clearAllData(confirm = false) {
    if (confirm) {
      localStorage.removeItem(this.storageKey);
      this.createNewData();
      return true;
    }
    return false;
  }

  /**
   * Generate UUID
   */
  generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
      const r = Math.random() * 16 | 0;
      const v = c === 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }

  /**
   * Tracking settings management
   */
  getTrackingSettings() {
    const data = this.getData();
    return data?.appMeta?.trackingSettings || {
      sleep: false,
      food: false,
      training: false,
      meditation: false,
      social: false,
      emotion: false
    };
  }

  setSleepTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.sleep = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  setFoodTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.food = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  setTrainingTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.training = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  setMeditationTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.meditation = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  setSocialTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.social = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  setEmotionTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.emotion = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  getSleepTrackingEnabled() {
    return this.getTrackingSettings().sleep;
  }

  getFoodTrackingEnabled() {
    return this.getTrackingSettings().food;
  }

  getTrainingTrackingEnabled() {
    return this.getTrackingSettings().training;
  }

  getMeditationTrackingEnabled() {
    return this.getTrackingSettings().meditation;
  }

  getSocialTrackingEnabled() {
    return this.getTrackingSettings().social;
  }

  getEmotionTrackingEnabled() {
    return this.getTrackingSettings().emotion;
  }

  setFrustrationTrackingEnabled(enabled) {
    const settings = this.getTrackingSettings();
    settings.frustration = enabled;
    this.updateAppMeta('trackingSettings', settings);
  }

  getFrustrationTrackingEnabled() {
    return this.getTrackingSettings().frustration;
  }
}

// Initialize global data store
const iamData = new IamDataStore();
