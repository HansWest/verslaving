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
    this.init();
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
    const balans = getForm('voor-nadelen-balansen');
    const plan = getForm('plan-van-aanpak');

    const topTriggersBucket = this.buildInsightBucket([
      risicoSituaties.riskySituations,
      risicoActiviteiten.riskyActivities,
      stimulus.stimulus,
      soortenTrek.cravingType1Context,
      soortenTrek.cravingType2Context,
      soortenTrek.cravingType3Context,
      risicoMensen.riskySituationWithPerson
    ], 8);

    const supportNetworkBucket = this.buildInsightBucket([
      stimulus.socialSupport,
      gevoelens.talkPeople,
      plan.supportPeople,
      risicoMensen.personName
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
      plan.planA
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
      risicoActiviteiten.internalRisks
    ], 8);

    const motivationAnchorsBucket = this.buildInsightBucket([
      plan.mainGoal,
      plan.usageGoal,
      balans.decisionNote,
      soortenTrek.reflection,
      gevoelens.learningPeriod
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
}

// Initialize global data store
const iamData = new IamDataStore();
