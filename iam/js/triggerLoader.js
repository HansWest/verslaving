(function (global) {
  /**
   * Cross-dimensional trigger loader
   * Loads and aggregates triggers from:
   * - risico-situaties (situations)
   * - risico-activiteiten (activities)
   * - risico-mensen (people)
   */

  function getTriggers(iamData) {
    if (!iamData) return { situations: [], activities: [], people: [] };

    const result = {
      situations: [],
      activities: [],
      people: []
    };

    // Load situations from risico-situaties
    try {
      const situatiesData = iamData.getFormData ? iamData.getFormData('risico-situaties') : null;
      if (situatiesData && situatiesData.riskySituations) {
        const lines = String(situatiesData.riskySituations)
          .split('\n')
          .map((line) => line.trim())
          .filter(Boolean);
        result.situations = lines;
      }
    } catch (e) {
      console.warn('Could not load situations', e);
    }

    // Load activities from risico-activiteiten
    try {
      const activitiesData = iamData.getFormData ? iamData.getFormData('risico-activiteiten') : null;
      if (activitiesData && activitiesData.riskyActivities) {
        const lines = String(activitiesData.riskyActivities)
          .split('\n')
          .map((line) => line.trim())
          .filter(Boolean);
        result.activities = lines;
      }
    } catch (e) {
      console.warn('Could not load activities', e);
    }

    // Load people from risico-mensen
    try {
      const menData = iamData.getFormData ? iamData.getFormData('risico-mensen') : null;
      if (menData && menData.people && Array.isArray(menData.people)) {
        result.people = menData.people.map((person) => person.name || '(naamloos)');
      }
    } catch (e) {
      console.warn('Could not load people', e);
    }

    return result;
  }

  function renderMultiSelect(containerId, items, name) {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = '';
    if (!items || items.length === 0) {
      container.innerHTML = '<p style="font-size:0.9rem; color:#999;">Geen items beschikbaar. Vul eerst de risico-pagina in.</p>';
      return;
    }

    items.forEach((item) => {
      const label = document.createElement('label');
      const input = document.createElement('input');
      input.type = 'checkbox';
      input.value = item;
      input.name = name;
      input.className = 'trigger-checkbox';
      label.appendChild(input);
      label.appendChild(document.createTextNode(item));
      label.style.display = 'flex';
      label.style.gap = '0.5rem';
      label.style.alignItems = 'center';
      label.style.marginBottom = '0.5rem';
      container.appendChild(label);
    });
  }

  function getSelectedTriggers(containerIds) {
    const result = {};
    Object.keys(containerIds).forEach((key) => {
      const containerId = containerIds[key];
      const selected = [];
      const checkboxes = document.querySelectorAll(`#${containerId} input[type="checkbox"]:checked`);
      checkboxes.forEach((cb) => {
        if (cb.value.trim()) selected.push(cb.value);
      });
      result[key] = selected;
    });
    return result;
  }

  global.iamTriggerLoader = {
    getTriggers: getTriggers,
    renderMultiSelect: renderMultiSelect,
    getSelectedTriggers: getSelectedTriggers
  };
})(window);
