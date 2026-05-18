(function () {
    const STORAGE_KEY = 'iam.theme.preference';
    const VALID_PREFERENCES = new Set(['auto', 'light', 'dark']);
    const darkQuery = window.matchMedia('(prefers-color-scheme: dark)');

    function getSystemTheme() {
        return darkQuery.matches ? 'dark' : 'light';
    }

    function normalizePreference(value) {
        if (typeof value !== 'string') return 'auto';
        const normalized = value.trim().toLowerCase();
        return VALID_PREFERENCES.has(normalized) ? normalized : 'auto';
    }

    function getStoredPreference() {
        try {
            return normalizePreference(localStorage.getItem(STORAGE_KEY));
        } catch (error) {
            return 'auto';
        }
    }

    function resolveTheme(preference) {
        const pref = normalizePreference(preference);
        return pref === 'auto' ? getSystemTheme() : pref;
    }

    function applyTheme(preference) {
        const pref = normalizePreference(preference);
        const theme = resolveTheme(pref);
        const root = document.documentElement;

        root.setAttribute('data-theme-preference', pref);
        root.setAttribute('data-theme', theme);
        root.style.colorScheme = theme;

        return { preference: pref, theme };
    }

    function setPreference(preference) {
        const pref = normalizePreference(preference);
        try {
            localStorage.setItem(STORAGE_KEY, pref);
        } catch (error) {
            // Ignore storage failures and still apply for this session.
        }
        return applyTheme(pref);
    }

    function handleSystemThemeChange() {
        const pref = getStoredPreference();
        if (pref === 'auto') {
            applyTheme(pref);
        }
    }

    function ensureThemeShortcut() {
        const path = (window.location.pathname || '').toLowerCase();
        if (path.endsWith('/to_self_manage_game.htm') || path.endsWith('to_self_manage_game.htm')) {
            return;
        }

        if (document.getElementById('themeSettingsCard')) return;
        if (document.querySelector('.theme-settings-shortcut')) return;

        const wrap = document.createElement('div');
        wrap.className = 'theme-settings-shortcut-wrap';

        const shortcut = document.createElement('a');
        shortcut.className = 'theme-settings-shortcut';
        shortcut.href = 'index.htm#themeSettingsCard';
        shortcut.textContent = 'Thema';
        shortcut.setAttribute('aria-label', 'Ga naar thema-instellingen');
        wrap.appendChild(shortcut);

        const contentRoot = document.querySelector('.container, main, .page-wrap, .page-shell, body');
        if (!contentRoot) return;

        contentRoot.insertBefore(wrap, contentRoot.firstChild);
    }

    if (typeof darkQuery.addEventListener === 'function') {
        darkQuery.addEventListener('change', handleSystemThemeChange);
    } else if (typeof darkQuery.addListener === 'function') {
        darkQuery.addListener(handleSystemThemeChange);
    }

    const initialPreference = getStoredPreference();
    applyTheme(initialPreference);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ensureThemeShortcut);
    } else {
        ensureThemeShortcut();
    }

    window.IAMTheme = {
        STORAGE_KEY,
        getPreference: getStoredPreference,
        getSystemTheme,
        resolveTheme,
        applyTheme,
        setPreference
    };
})();
