(function (global) {
  'use strict';

  const WEEKLY_REVIEW_KEY = 'weeklyReview';

  function get(iamData) {
    return iamData && iamData.getAppMeta ? (iamData.getAppMeta(WEEKLY_REVIEW_KEY) || {}) : {};
  }

  function isDue(lastCompletedAt) {
    if (!lastCompletedAt) return true;
    const last = new Date(lastCompletedAt);
    if (Number.isNaN(last.getTime())) return true;
    return (Date.now() - last.getTime()) >= 7 * 24 * 60 * 60 * 1000;
  }

  function previewText(value, maxLength) {
    const limit = Number(maxLength) || 120;
    const text = String(value || '').trim().replace(/\s+/g, ' ');
    if (!text) return '';
    return text.length > limit ? `${text.slice(0, limit - 1)}...` : text;
  }

  function toItem(text, href, sourceLabel) {
    return {
      text: String(text || ''),
      href: href || '',
      sourceLabel: sourceLabel || ''
    };
  }

  function buildBaseItems(weekly, emptyText, sourceHref, sourceLabel) {
    const items = [];
    if (weekly.reflection) items.push(toItem(`Terugblik: ${previewText(weekly.reflection)}`, sourceHref, sourceLabel));
    if (weekly.learning) items.push(toItem(`Leerpunt: ${previewText(weekly.learning)}`, sourceHref, sourceLabel));
    if (weekly.nextStep) items.push(toItem(`Volgende stap: ${previewText(weekly.nextStep)}`, sourceHref, sourceLabel));
    if (!items.length) items.push(toItem(emptyText || 'Nog geen weekreflectie opgeslagen op de homepage.', sourceHref, sourceLabel));
    return items;
  }

  function renderPrompt(options) {
    const config = options || {};
    const weekly = get(config.iamData);
    const status = document.getElementById(config.statusId || 'weeklyReviewStatus');
    const list = document.getElementById(config.listId || 'weeklyReviewList');
    const applyButton = document.getElementById(config.applyButtonId || 'weeklyReviewApply');

    if (!status || !list || !applyButton) {
      return { weekly: weekly, due: true, lines: [] };
    }

    const due = isDue(weekly.lastCompletedAt);
    status.textContent = weekly.lastCompletedAt
      ? (due ? 'Tijd voor nieuwe terugblik' : 'Deze week bijgewerkt')
      : 'Nog geen terugblik';
    status.classList.toggle('due', due);

    const items = buildBaseItems(weekly, config.emptyText, config.sourceHref, config.sourceLabel);
    const extraLines = typeof config.extraLines === 'function'
      ? config.extraLines(weekly)
      : (config.extraLines || []);

    [].concat(extraLines || []).filter(Boolean).forEach((line) => {
      items.push(typeof line === 'string' ? toItem(line) : toItem(line.text, line.href, line.sourceLabel));
    });

    list.innerHTML = '';
    items.slice(0, config.maxLines || 4).forEach((itemData) => {
      const item = document.createElement('li');
      if (itemData.href) {
        const link = document.createElement('a');
        link.href = itemData.href;
        link.textContent = itemData.text;
        if (itemData.sourceLabel) {
          link.title = itemData.sourceLabel;
        }
        item.appendChild(link);
      } else {
        item.textContent = itemData.text;
      }
      list.appendChild(item);
    });

    applyButton.disabled = !weekly.nextStep;
    return { weekly: weekly, due: due, lines: items.map((item) => item.text), items: items };
  }

  global.iamWeeklyReview = {
    get: get,
    isDue: isDue,
    previewText: previewText,
    renderPrompt: renderPrompt
  };
})(window);