/*
 * Legacy form sync bridge for IAM
 * Connects old single-form pages to central iamData storage.
 */
(function () {
  function getFormKeyFromPath() {
    const path = window.location.pathname || '';
    const base = path.split('/').pop() || '';
    return base.replace(/\.html?$/i, '').trim().toLowerCase();
  }

  function getFieldId(field, index) {
    return field.name || field.id || `field_${index}`;
  }

  function collectFormData(form) {
    const data = {};
    const seenRadio = new Set();

    const fields = form.querySelectorAll('input, textarea, select');
    fields.forEach((field, index) => {
      const key = getFieldId(field, index);
      if (!key || field.disabled) return;

      if (field.type === 'radio') {
        if (seenRadio.has(key)) return;
        seenRadio.add(key);
        const selected = form.querySelector(`input[type="radio"][name="${CSS.escape(field.name)}"]:checked`);
        data[key] = selected ? selected.value : '';
        return;
      }

      if (field.type === 'checkbox') {
        const group = field.name
          ? form.querySelectorAll(`input[type="checkbox"][name="${CSS.escape(field.name)}"]`)
          : null;

        if (group && group.length > 1) {
          if (data[key] !== undefined) return;
          data[key] = Array.from(group)
            .filter((item) => item.checked)
            .map((item) => item.value);
          return;
        }

        data[key] = field.checked;
        return;
      }

      data[key] = field.value || '';
    });

    return data;
  }

  function applyFormData(form, savedData) {
    if (!savedData || typeof savedData !== 'object') return;

    const fields = form.querySelectorAll('input, textarea, select');
    fields.forEach((field, index) => {
      const key = getFieldId(field, index);
      if (!key || !(key in savedData)) return;

      const value = savedData[key];

      if (field.type === 'radio') {
        if (field.value === value) field.checked = true;
        return;
      }

      if (field.type === 'checkbox') {
        if (Array.isArray(value)) {
          field.checked = value.includes(field.value);
        } else {
          field.checked = Boolean(value);
        }
        return;
      }

      field.value = value;
    });
  }

  function initLegacySync() {
    if (!window.iamData || typeof window.iamData.getFormData !== 'function') return;

    const form = document.querySelector('form');
    if (!form) return;

    const formKey = getFormKeyFromPath();
    if (!formKey) return;

    const saved = window.iamData.getFormData(formKey);
    applyFormData(form, saved);

    let saveTimer = null;
    const persist = function () {
      const payload = collectFormData(form);
      window.iamData.updateFormData(formKey, payload);
    };

    const scheduleSave = function () {
      window.clearTimeout(saveTimer);
      saveTimer = window.setTimeout(persist, 200);
    };

    form.addEventListener('input', scheduleSave);
    form.addEventListener('change', scheduleSave);
  }

  document.addEventListener('DOMContentLoaded', initLegacySync);
})();
