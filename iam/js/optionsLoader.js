(function (global) {
  function resolvePath(data, path) {
    if (!path) return data;
    return path.split('.').reduce(function (acc, key) {
      if (acc && typeof acc === 'object') return acc[key];
      return undefined;
    }, data);
  }

  function normalizeSource(source) {
    if (Array.isArray(source)) {
      return { groups: [{ label: 'Overig', items: source }] };
    }

    if (source && Array.isArray(source.groups)) {
      return source;
    }

    if (source && Array.isArray(source.items)) {
      return { groups: [{ label: source.label || 'Overig', items: source.items }] };
    }

    return { groups: [] };
  }

  function toOptionData(item) {
    if (typeof item === 'string') {
      var clean = item.trim();
      return clean ? { value: clean, label: clean } : null;
    }

    if (!item || typeof item !== 'object') return null;

    var value = (item.value || item.label || '').toString().trim();
    var label = (item.label || value).toString().trim();
    if (!value || !label) return null;

    return {
      value: value,
      label: label,
      reaction: item.reaction ? String(item.reaction) : '',
      reactionKey: item.reactionKey ? String(item.reactionKey) : ''
    };
  }

  function renderSelectOptions(select, source, placeholder) {
    if (!select) return;

    select.innerHTML = '';

    var firstOption = document.createElement('option');
    firstOption.value = '';
    firstOption.textContent = placeholder || 'Kies een optie';
    select.appendChild(firstOption);

    var normalized = normalizeSource(source);

    normalized.groups.forEach(function (group) {
      var items = Array.isArray(group && group.items) ? group.items : [];
      if (!items.length) return;

      var optgroup = document.createElement('optgroup');
      optgroup.label = (group && group.label) || 'Overig';

      items.forEach(function (item) {
        var optionData = toOptionData(item);
        if (!optionData) return;

        var option = document.createElement('option');
        option.value = optionData.value;
        option.textContent = optionData.label;
        if (optionData.reaction) option.dataset.reaction = optionData.reaction;
        if (optionData.reactionKey) option.dataset.reactionKey = optionData.reactionKey;
        optgroup.appendChild(option);
      });

      if (optgroup.children.length) {
        select.appendChild(optgroup);
      }
    });
  }

  async function loadSelectOptions(config) {
    var select = document.getElementById(config.selectId);
    if (!select) {
      throw new Error('Select element niet gevonden: ' + config.selectId);
    }

    var placeholder = config.placeholder || 'Kies een optie';
    var fallback = config.fallback || { groups: [] };

    try {
      var response = await fetch(config.url, { cache: 'no-cache' });
      if (!response.ok) {
        throw new Error('HTTP ' + response.status);
      }

      var json = await response.json();
      var selectedData = resolvePath(json, config.dataPath);
      renderSelectOptions(select, selectedData, placeholder);
      return { usedFallback: false, data: selectedData };
    } catch (error) {
      console.warn('Kon opties niet laden, fallback wordt gebruikt.', error);
      renderSelectOptions(select, fallback, placeholder);
      return { usedFallback: true, data: fallback };
    }
  }

  function getSelectedOptionMeta(select) {
    if (!select || !select.options || select.selectedIndex < 0) {
      return { value: '', label: '', reaction: '', reactionKey: '' };
    }

    var selected = select.options[select.selectedIndex];
    if (!selected) {
      return { value: '', label: '', reaction: '', reactionKey: '' };
    }

    return {
      value: selected.value || '',
      label: selected.textContent || '',
      reaction: (selected.dataset && selected.dataset.reaction) || '',
      reactionKey: (selected.dataset && selected.dataset.reactionKey) || ''
    };
  }

  global.iamOptionsLoader = {
    loadSelectOptions: loadSelectOptions,
    renderSelectOptions: renderSelectOptions,
    getSelectedOptionMeta: getSelectedOptionMeta
  };
})(window);
