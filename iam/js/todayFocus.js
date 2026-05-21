(function (window) {
  const LOCAL_STORAGE_KEY = 'iam_daily_focus_v1';
  const APP_META_KEY = 'dailyFocus';

  function getDateKey(offsetDays) {
    const day = new Date();
    day.setHours(0, 0, 0, 0);
    day.setDate(day.getDate() + offsetDays);
    return day.toISOString().slice(0, 10);
  }

  function hasIamData() {
    return !!(
      window.iamData &&
      typeof window.iamData.getAppMeta === 'function' &&
      typeof window.iamData.updateAppMeta === 'function'
    );
  }

  function readEntries() {
    if (hasIamData()) {
      const meta = window.iamData.getAppMeta(APP_META_KEY) || {};
      if (meta.entries && typeof meta.entries === 'object') {
        return meta.entries;
      }
      return {};
    }

    try {
      const raw = window.localStorage.getItem(LOCAL_STORAGE_KEY);
      if (!raw) return {};
      const parsed = JSON.parse(raw);
      return parsed && typeof parsed === 'object' ? parsed : {};
    } catch (error) {
      console.error('todayFocus read failed', error);
      return {};
    }
  }

  function writeEntries(entries) {
    if (hasIamData()) {
      window.iamData.updateAppMeta(APP_META_KEY, {
        entries: entries,
        updatedAt: new Date().toISOString()
      });
      return;
    }

    try {
      window.localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(entries));
    } catch (error) {
      console.error('todayFocus write failed', error);
    }
  }

  function getTodayText() {
    const entries = readEntries();
    return (entries[getDateKey(0)] && entries[getDateKey(0)].text) || '';
  }

  function getYesterdayText() {
    const entries = readEntries();
    return (entries[getDateKey(-1)] && entries[getDateKey(-1)].text) || '';
  }

  function saveTodayText(text, source) {
    const cleanText = String(text || '').trim();
    const entries = readEntries();
    const todayKey = getDateKey(0);

    if (!cleanText) {
      delete entries[todayKey];
      writeEntries(entries);
      return '';
    }

    entries[todayKey] = {
      text: cleanText,
      source: source || 'onbekend',
      updatedAt: new Date().toISOString()
    };
    writeEntries(entries);
    return cleanText;
  }

  function initDailyFocusWidget(config) {
    const textarea = document.getElementById(config.textareaId);
    if (!textarea) return null;

    const yesterdayTextEl = config.yesterdayTextId
      ? document.getElementById(config.yesterdayTextId)
      : null;
    const carryButton = config.carryButtonId
      ? document.getElementById(config.carryButtonId)
      : null;
    const newButton = config.newButtonId
      ? document.getElementById(config.newButtonId)
      : null;

    const source = config.source || 'onbekend';
    const yesterdayText = getYesterdayText();

    if (yesterdayTextEl) {
      yesterdayTextEl.textContent = yesterdayText
        ? 'Gisteren: ' + yesterdayText
        : 'Gisteren: nog niet ingevuld.';
    }

    const currentToday = getTodayText();
    if (currentToday) {
      textarea.value = currentToday;
    } else {
      const seeded = String(textarea.value || '').trim();
      if (seeded) {
        saveTodayText(seeded, source);
      }
    }

    let saveTimer = null;
    const persist = () => {
      const saved = saveTodayText(textarea.value, source);
      if (typeof config.onPersist === 'function') {
        config.onPersist(saved);
      }
    };

    textarea.addEventListener('input', () => {
      if (saveTimer) {
        window.clearTimeout(saveTimer);
      }
      saveTimer = window.setTimeout(persist, 250);
    });

    if (carryButton) {
      carryButton.addEventListener('click', () => {
        if (!yesterdayText) return;

        const current = String(textarea.value || '').trim();
        if (current && current !== yesterdayText) {
          const shouldOverwrite = window.confirm('Je hebt vandaag al tekst. Gisteren overnemen en huidige tekst vervangen?');
          if (!shouldOverwrite) return;
        }

        textarea.value = yesterdayText;
        persist();
      });
    }

    if (newButton) {
      newButton.addEventListener('click', () => {
        textarea.value = '';
        persist();
        textarea.focus();
      });
    }

    return {
      getTodayText: getTodayText,
      getYesterdayText: getYesterdayText,
      save: persist
    };
  }

  window.iamTodayFocus = {
    initDailyFocusWidget: initDailyFocusWidget,
    getTodayText: getTodayText,
    getYesterdayText: getYesterdayText,
    saveTodayText: saveTodayText
  };
})(window);
