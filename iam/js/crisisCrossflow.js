(function (global) {
  'use strict';

  function splitLines(value) {
    return String(value || '')
      .split(/\n|,|;/)
      .map((part) => part.trim())
      .filter(Boolean);
  }

  function uniqueList(items) {
    const seen = new Set();
    return items.filter((item) => {
      const key = String(item || '').trim().toLowerCase();
      if (!key || seen.has(key)) {
        return false;
      }
      seen.add(key);
      return true;
    });
  }

  function pushItems(list, items, source, href, maxPerField) {
    splitLines(items)
      .slice(0, maxPerField)
      .forEach((text) => {
        list.push({
          text: text,
          source: source,
          href: href
        });
      });
  }

  function buildCrossflowSuggestions(iamData, currentFormKey, maxItems) {
    if (!iamData || typeof iamData.getFormData !== 'function') {
      return [];
    }

    const out = [];
    const limit = typeof maxItems === 'number' ? maxItems : 6;
    const eachFieldMax = 1;

    const forse = iamData.getFormData('noodplan-forse-trek') || {};
    const uitglijden = iamData.getFormData('plan-bij-uitglijden') || {};
    const wegglijden = iamData.getFormData('noodplan-wegglijden') || {};

    if (currentFormKey !== 'noodplan-forse-trek') {
      pushItems(out, uitglijden.immediateStop, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
      pushItems(out, uitglijden.slippageSupport, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
      pushItems(out, uitglijden.recoverySteps, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
      pushItems(out, wegglijden.welGaanDoen, 'Noodplan wegglijden', './noodplan-wegglijden.htm', eachFieldMax);
      pushItems(out, wegglijden.minimaleStappen, 'Noodplan wegglijden', './noodplan-wegglijden.htm', eachFieldMax);
      pushItems(out, wegglijden.privepersonen, 'Noodplan wegglijden', './noodplan-wegglijden.htm', eachFieldMax);
    }

    if (currentFormKey !== 'plan-bij-uitglijden') {
      pushItems(out, forse.doen, 'Noodplan forse trek', './noodplan-forse-trek.htm', eachFieldMax);
      pushItems(out, forse.steunnetwerk, 'Noodplan forse trek', './noodplan-forse-trek.htm', eachFieldMax);
      pushItems(out, forse.sosSignaal, 'Noodplan forse trek', './noodplan-forse-trek.htm', eachFieldMax);
      pushItems(out, wegglijden.herkennenVooraf, 'Noodplan wegglijden', './noodplan-wegglijden.htm', eachFieldMax);
      pushItems(out, wegglijden.nietGaanDoen, 'Noodplan wegglijden', './noodplan-wegglijden.htm', eachFieldMax);
      pushItems(out, wegglijden.weeropstaan, 'Noodplan wegglijden', './noodplan-wegglijden.htm', eachFieldMax);
    }

    if (currentFormKey !== 'noodplan-wegglijden') {
      pushItems(out, forse.ratio, 'Noodplan forse trek', './noodplan-forse-trek.htm', eachFieldMax);
      pushItems(out, forse.herstelstap, 'Noodplan forse trek', './noodplan-forse-trek.htm', eachFieldMax);
      pushItems(out, uitglijden.slippageSignals, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
      pushItems(out, uitglijden.immediateStop, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
      pushItems(out, uitglijden.preventFall, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
      pushItems(out, uitglijden.slippageSupport, 'Plan bij uitglijden', './plan-bij-uitglijden.htm', eachFieldMax);
    }

    return uniqueList(out.map((entry) => `${entry.source}::${entry.text}`))
      .map((key) => {
        const parts = key.split('::');
        const source = parts[0];
        const text = parts.slice(1).join('::');
        const match = out.find((item) => item.source === source && item.text === text);
        return {
          source: source,
          text: text,
          href: match ? match.href : ''
        };
      })
      .slice(0, limit);
  }

  function setupCollapsible(options) {
    const config = options || {};
    const box = document.getElementById(config.boxId);
    const toggle = document.getElementById(config.toggleId);
    const storageKey = config.storageKey;

    if (!box || !toggle || !storageKey) {
      return;
    }

    const isCollapsed = localStorage.getItem(storageKey) === 'true';
    if (isCollapsed) {
      box.classList.add('support-script-box--collapsed');
    }

    toggle.addEventListener('click', () => {
      box.classList.toggle('support-script-box--collapsed');
      const newState = box.classList.contains('support-script-box--collapsed');
      localStorage.setItem(storageKey, String(newState));
    });
  }

  global.iamCrisisCrossflow = {
    buildCrossflowSuggestions: buildCrossflowSuggestions,
    setupCollapsible: setupCollapsible
  };
})(window);
