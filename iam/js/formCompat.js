(function () {
    'use strict';

    function getFormKey(form) {
        if (form && form.name) {
            return form.name;
        }

        var path = (window.location.pathname || '').split('/').pop() || 'form';
        return path.replace(/\.[^.]+$/, '');
    }

    function serializeForm(form) {
        var data = {};
        if (!form || !form.elements) {
            return data;
        }

        for (var i = 0; i < form.elements.length; i += 1) {
            var el = form.elements[i];
            if (!el || !el.name || el.disabled) {
                continue;
            }

            if (el.type === 'checkbox') {
                data[el.name] = Boolean(el.checked);
                continue;
            }

            if (el.type === 'radio') {
                if (el.checked) {
                    data[el.name] = el.value;
                }
                continue;
            }

            data[el.name] = el.value;
        }

        return data;
    }

    function applyToForm(form, data) {
        if (!form || !form.elements || !data) {
            return;
        }

        for (var i = 0; i < form.elements.length; i += 1) {
            var el = form.elements[i];
            if (!el || !el.name || !Object.prototype.hasOwnProperty.call(data, el.name)) {
                continue;
            }

            if (el.type === 'checkbox') {
                el.checked = Boolean(data[el.name]);
                continue;
            }

            if (el.type === 'radio') {
                el.checked = String(data[el.name]) === String(el.value);
                continue;
            }

            el.value = data[el.name];
        }
    }

    window.saveSelections = function (form) {
        if (typeof iamData === 'undefined') {
            return;
        }
        var key = getFormKey(form);
        iamData.updateFormData(key, serializeForm(form));
    };

    window.loadSelections = function (form) {
        if (typeof iamData === 'undefined') {
            return;
        }
        var key = getFormKey(form);
        var data = iamData.getFormData(key);
        applyToForm(form, data);
    };
})();
