(function (global) {
  'use strict';

  const DEFAULT_RECOVERY_ITEMS = [
    { field: 'moeten01', text: 'Eet vandaag drie gewone eetmomenten.' },
    { field: 'moeten02', text: 'Plan of bevestig vandaag een hulp- of herstelcontact.' },
    { field: 'gunnen01', text: 'Neem een warme douche, rustmoment of ander kalmerend herstelmoment.' },
    { field: 'gunnen02', text: 'Kies een kleine, veilige beloning na je eerste herstelstap.' },
    { field: 'nietdoen01', text: 'Ga vandaag niet terug naar triggers, risicoplekken of risicocontact.' }
  ];

  function splitLines(value) {
    return String(value || '')
      .split(/\n|,|;/)
      .map((part) => part.trim())
      .filter(Boolean);
  }

  function uniqueList(values) {
    const seen = new Set();
    return values.filter((value) => {
      const key = String(value || '').trim().toLowerCase();
      if (!key || seen.has(key)) return false;
      seen.add(key);
      return true;
    });
  }

  function getSupportNames(iamData) {
    if (global.iamSupportNetwork && typeof global.iamSupportNetwork.getSupportSuggestions === 'function') {
      return global.iamSupportNetwork.getSupportSuggestions(iamData).map((item) => item.name);
    }
    return [];
  }

  function buildSupportScripts(options) {
    const config = options || {};
    const supportNames = uniqueList([].concat(config.supportNames || []));
    const supportName = supportNames[0] || 'iemand uit mijn steunnetwerk';
    const crisisLabel = config.crisisLabel || 'ik zit niet stevig';
    const ask = config.ask || 'wil je 15 minuten bij me blijven of met me meedenken over mijn volgende veilige stap?';
    const action = config.action || 'ik wil nu niet alleen blijven en geen ruimte geven aan verder gebruik';

    return [
      `Ik heb nu ${crisisLabel}. Wil je me helpen door even bereikbaar te blijven?`,
      `${supportName}, ik stuur dit voordat ik verder wegglij. ${ask}`,
      `Ik heb nu hulp nodig. ${action}. Kun je me nu bellen of appen?`
    ];
  }

  function appendUniqueLine(value, text) {
    const clean = String(text || '').trim();
    if (!clean) return String(value || '').trim();
    const existing = splitLines(value);
    if (existing.some((item) => item.toLowerCase() === clean.toLowerCase())) {
      return String(value || '').trim();
    }
    return String(value || '').trim()
      ? `${String(value || '').trim()}\n${clean}`
      : clean;
  }

  function todayParts() {
    const now = new Date();
    return {
      dd: String(now.getDate()).padStart(2, '0'),
      mm: String(now.getMonth() + 1).padStart(2, '0'),
      yyyy: String(now.getFullYear())
    };
  }

  function buildRecoveryAgendaPatch(options) {
    const config = options || {};
    const formData = config.formData || {};
    const supportNames = uniqueList(getSupportNames(config.iamData).concat(splitLines(config.supportNamesText || '')));
    const firstSupport = supportNames[0] || 'een steunpersoon';
    const date = todayParts();
    const patch = {
      dd: date.dd,
      mm: date.mm,
      yyyy: date.yyyy
    };

    const customItems = [];
    if (formData.minimaleStappen) {
      customItems.push({ field: 'moeten01', text: splitLines(formData.minimaleStappen)[0] || formData.minimaleStappen });
    }
    if (formData.weeropstaan || formData.recoverySteps || formData.herstelstap) {
      customItems.push({ field: 'moeten02', text: splitLines(formData.weeropstaan || formData.recoverySteps || formData.herstelstap)[0] || 'Plan vandaag een concrete herstelstap.' });
    }
    if (formData.welGaanDoen || formData.distractionStrategy) {
      customItems.push({ field: 'gunnen01', text: splitLines(formData.welGaanDoen || formData.distractionStrategy)[0] || 'Kies vandaag een veilige regulatie-activiteit.' });
    }
    if (formData.schaamte || formData.preventFall) {
      customItems.push({ field: 'gunnen02', text: splitLines(formData.schaamte || formData.preventFall)[0] || 'Maak het jezelf makkelijker om opnieuw contact te zoeken.' });
    }
    if (formData.nietGaanDoen || formData.schrappen) {
      customItems.push({ field: 'nietdoen01', text: splitLines(formData.nietGaanDoen || formData.schrappen)[0] || 'Vermijd vandaag teruggaan naar je risicopatroon.' });
    }

    const selectedItems = DEFAULT_RECOVERY_ITEMS.map((fallback) => {
      const custom = customItems.find((item) => item.field === fallback.field);
      return custom || fallback;
    });

    selectedItems.forEach((item) => {
      patch[item.field] = item.text;
    });

    patch.willen01 = `Bel of app ${firstSupport} voor een korte check-in.`;
    patch.willen02 = 'Maak een rustige wandeling of andere korte reset zonder triggers.';
    patch.beloning = 'Iets kleins en veiligs nadat ik mijn herstelstap heb gedaan.';
    patch.reden = 'Omdat ik na crisis weer richting kies in plaats van door te glijden.';
    patch.trekverwacht = '6';

    return patch;
  }

  function applyRecoveryAgenda(iamData, options) {
    if (!iamData || typeof iamData.getFormData !== 'function' || typeof iamData.updateFormData !== 'function') {
      return { ok: false, reason: 'iamData unavailable' };
    }
    const current = iamData.getFormData('agenda') || {};
    const patch = buildRecoveryAgendaPatch({
      iamData: iamData,
      formData: options && options.formData,
      supportNamesText: options && options.supportNamesText
    });

    const merged = { ...current };
    Object.keys(patch).forEach((key) => {
      if (!current[key] || ['dd', 'mm', 'yyyy', 'trekverwacht'].includes(key)) {
        merged[key] = patch[key];
      }
    });

    const saved = iamData.updateFormData('agenda', merged);
    return { ok: true, saved: saved, patch: patch };
  }

  global.iamCrisisActions = {
    buildSupportScripts: buildSupportScripts,
    buildRecoveryAgendaPatch: buildRecoveryAgendaPatch,
    applyRecoveryAgenda: applyRecoveryAgenda
  };
})(window);
