(function (global) {
  'use strict';

  const TREK_FORM_KEYS = ['trek-opvangen', 'trek-opvangen-2'];

  function normalizeText(value) {
    return String(value || '').trim().replace(/\s+/g, ' ');
  }

  function todayISODate() {
    return new Date().toISOString().slice(0, 10);
  }

  function formatDateLabel(dateValue) {
    const clean = normalizeText(dateValue);
    if (!clean) return 'zonder datum';

    const parsed = new Date(`${clean}T12:00:00`);
    if (Number.isNaN(parsed.getTime())) {
      return clean;
    }

    return parsed.toLocaleDateString('nl-NL', {
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    });
  }

  function getState(iamData) {
    if (!iamData || !iamData.getTrekDossierState) {
      return { activeId: '', entries: [] };
    }
    return iamData.getTrekDossierState() || { activeId: '', entries: [] };
  }

  function listEntries(iamData) {
    const state = getState(iamData);
    return Array.isArray(state.entries) ? state.entries.slice() : [];
  }

  function getEntryById(iamData, entryId) {
    if (!entryId) return null;
    return listEntries(iamData).find((entry) => entry.id === entryId) || null;
  }

  function getActiveEntry(iamData) {
    const state = getState(iamData);
    return getEntryById(iamData, state.activeId) || null;
  }

  function buildEntryLabel(entry) {
    if (!entry) return 'Onbekend dossier';
    const keyword = normalizeText(entry.keyword);
    return keyword ? `${formatDateLabel(entry.date)} · ${keyword}` : formatDateLabel(entry.date);
  }

  function countFilledValues(value) {
    if (!value || typeof value !== 'object') return 0;
    return Object.entries(value).reduce((count, [key, item]) => {
      if (key === 'lastUpdated' || key === 'createdAt' || key === 'updatedAt') {
        return count;
      }
      if (typeof item === 'string' && normalizeText(item)) {
        return count + 1;
      }
      if (Array.isArray(item) && item.some((part) => normalizeText(part))) {
        return count + 1;
      }
      return count;
    }, 0);
  }

  function buildEntrySummary(entry) {
    const pages = entry && entry.pages ? entry.pages : {};
    const counts = TREK_FORM_KEYS.map((formKey, index) => {
      const label = String(index + 1);
      const filled = countFilledValues(pages[formKey]);
      return `${label}:${filled}`;
    });
    return counts.join(' · ');
  }

  function ensureActiveEntry(iamData, draftMeta = {}) {
    const current = getActiveEntry(iamData);
    if (current) return current;

    const entries = listEntries(iamData);
    if (entries.length) {
      if (iamData.setActiveTrekDossier) {
        iamData.setActiveTrekDossier(entries[0].id);
      }
      return getActiveEntry(iamData);
    }

    if (!iamData || !iamData.createTrekDossier) return null;
    return iamData.createTrekDossier({
      date: draftMeta.date || todayISODate(),
      keyword: draftMeta.keyword || ''
    });
  }

  function createEntry(iamData, draftMeta = {}) {
    if (!iamData || !iamData.createTrekDossier) return null;
    return iamData.createTrekDossier({
      date: draftMeta.date || todayISODate(),
      keyword: draftMeta.keyword || ''
    });
  }

  function setActiveEntry(iamData, entryId) {
    if (!iamData || !iamData.setActiveTrekDossier) return null;
    return iamData.setActiveTrekDossier(entryId);
  }

  function updateActiveMeta(iamData, patch = {}) {
    const active = ensureActiveEntry(iamData, patch);
    if (!active || !iamData || !iamData.updateTrekDossierMeta) return null;
    return iamData.updateTrekDossierMeta(active.id, patch);
  }

  function savePageSnapshot(iamData, formKey, pageData, draftMeta = {}) {
    const active = ensureActiveEntry(iamData, draftMeta);
    if (!active || !iamData || !iamData.updateTrekDossierPage) return null;
    if (draftMeta && (draftMeta.date || draftMeta.keyword)) {
      iamData.updateTrekDossierMeta(active.id, {
        date: draftMeta.date || active.date,
        keyword: typeof draftMeta.keyword === 'string' ? draftMeta.keyword : active.keyword
      });
    }
    return iamData.updateTrekDossierPage(active.id, formKey, pageData);
  }

  function getPageSnapshot(iamData, formKey, entryId) {
    const entry = entryId ? getEntryById(iamData, entryId) : getActiveEntry(iamData);
    return entry?.pages?.[formKey] || null;
  }

  global.iamTrekDossiers = {
    todayISODate: todayISODate,
    formatDateLabel: formatDateLabel,
    buildEntryLabel: buildEntryLabel,
    buildEntrySummary: buildEntrySummary,
    getState: getState,
    listEntries: listEntries,
    getEntryById: getEntryById,
    getActiveEntry: getActiveEntry,
    createEntry: createEntry,
    setActiveEntry: setActiveEntry,
    updateActiveMeta: updateActiveMeta,
    savePageSnapshot: savePageSnapshot,
    getPageSnapshot: getPageSnapshot,
    ensureActiveEntry: ensureActiveEntry
  };
})(window);
