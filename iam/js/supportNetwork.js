(function (global) {
  'use strict';

  function splitNames(value) {
    return String(value || '')
      .split(/\n|,|;|\|/)
      .map((part) => part.trim())
      .filter(Boolean)
      .map((part) => part.replace(/^[-*•]+\s*/, '').trim())
      .filter((part) => part.length >= 2);
  }

  function getSourceMeta(sourceKey) {
    const map = {
      'integratiesamenvatting': { href: './index.htm', sourceLabel: 'Open homepage-overzicht' },
      'sociaal netwerk': { href: './sociaal-netwerk.htm', sourceLabel: 'Open sociaal netwerk' },
      'steunnetwerk': { href: './steunnetwerk.htm', sourceLabel: 'Open steunnetwerk' },
      'plan van aanpak': { href: './plan-van-aanpak.htm', sourceLabel: 'Open plan van aanpak' }
    };
    return map[sourceKey] || { href: '', sourceLabel: '' };
  }

  function pushUnique(target, name, source) {
    const clean = String(name || '').trim();
    if (!clean) return;
    const key = clean.toLowerCase();
    if (target.some((entry) => entry.name.toLowerCase() === key)) return;
    const meta = getSourceMeta(source || '');
    target.push({
      name: clean,
      source: source || '',
      href: meta.href,
      sourceLabel: meta.sourceLabel
    });
  }

  function getSupportSuggestions(iamData) {
    const suggestions = [];
    const summary = iamData && iamData.getIntegrationSummary ? iamData.getIntegrationSummary() : null;
    const sociaal = iamData && iamData.getFormData ? (iamData.getFormData('sociaal-netwerk') || {}) : {};
    const steun = iamData && iamData.getFormData ? (iamData.getFormData('steunnetwerk') || {}) : {};
    const plan = iamData && iamData.getFormData ? (iamData.getFormData('plan-van-aanpak') || {}) : {};

    (Array.isArray(summary && summary.supportNetwork) ? summary.supportNetwork : []).forEach((item) => {
      pushUnique(suggestions, item, 'integratiesamenvatting');
    });

    ['reachableSupport', 'firstReachOut', 'safePeople', 'carefulPeople', 'supportNetworkPeople'].forEach((key) => {
      splitNames(sociaal[key]).forEach((item) => pushUnique(suggestions, item, 'sociaal netwerk'));
    });

    ['support1Name', 'support2Name', 'support3Name'].forEach((key) => {
      splitNames(steun[key]).forEach((item) => pushUnique(suggestions, item, 'steunnetwerk'));
    });

    splitNames(plan.supportPeople).forEach((item) => pushUnique(suggestions, item, 'plan van aanpak'));

    return suggestions.slice(0, 8);
  }

  global.iamSupportNetwork = {
    getSupportSuggestions: getSupportSuggestions
  };
})(window);