/**
 * praatmethans.js - Form handling en opslag functies
 * 
 * Deze library biedt functionaliteit voor het opslaan en herstellen van formulier data
 * Compatibel met de bestaande htm-formulieren
 */

// COOKIE FUNCTIONS (behouden voor backwards compatibility)

function setCookie(name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

// LOCALSTORAGE FUNCTIONS (nieuwe implementatie)

/**
 * Sla alle velden van een formulier op in localStorage
 */
function saveSelections(form) {
    if (!form) {
        alert("Geen formulier gevonden om op te slaan");
        return false;
    }
    
    var formName = form.name || 'default_form';
    var formData = {};
    
    // Loop door alle form elementen
    for (var i = 0; i < form.elements.length; i++) {
        var element = form.elements[i];
        var elementName = element.name;
        
        if (!elementName) continue;
        
        // Bepaal het type element en sla de waarde op
        if (element.type === 'checkbox') {
            formData[elementName] = element.checked;
        } else if (element.type === 'radio') {
            if (element.checked) {
                formData[elementName] = element.value;
            }
        } else if (element.type === 'select-multiple') {
            var selectedValues = [];
            for (var j = 0; j < element.options.length; j++) {
                if (element.options[j].selected) {
                    selectedValues.push(element.options[j].value);
                }
            }
            formData[elementName] = selectedValues;
        } else if (element.type !== 'button' && element.type !== 'submit' && element.type !== 'reset') {
            formData[elementName] = element.value;
        }
    }
    
    try {
        // Sla op in localStorage
        localStorage.setItem('form_' + formName, JSON.stringify(formData));
        
        // Als gebruiker is ingelogd, sla ook op in database
        if (typeof Auth !== 'undefined' && Auth.isLoggedIn()) {
            UserData.set('form_' + formName, formData);
        }
        
        alert("Formulier '" + formName + "' is opgeslagen");
        return true;
    } catch(e) {
        alert("Fout bij opslaan: " + e.message);
        return false;
    }
}

/**
 * Herstel alle velden van een formulier uit localStorage
 */
function loadSelections(form) {
    if (!form) {
        alert("Geen formulier gevonden om te herstellen");
        return false;
    }
    
    var formName = form.name || 'default_form';
    var formData = null;
    
    try {
        // Probeer eerst uit database te laden (als ingelogd)
        if (typeof Auth !== 'undefined' && Auth.isLoggedIn()) {
            formData = UserData.get('form_' + formName);
        }
        
        // Anders uit localStorage
        if (!formData) {
            var storedData = localStorage.getItem('form_' + formName);
            if (storedData) {
                formData = JSON.parse(storedData);
            }
        }
        
        if (!formData) {
            alert("Geen opgeslagen data gevonden voor formulier '" + formName + "'");
            return false;
        }
        
        // Herstel alle velden
        for (var elementName in formData) {
            if (formData.hasOwnProperty(elementName)) {
                var elements = form.elements[elementName];
                
                if (!elements) continue;
                
                // Als het een NodeList is (meerdere elementen met dezelfde naam)
                if (elements.length !== undefined) {
                    for (var i = 0; i < elements.length; i++) {
                        var element = elements[i];
                        
                        if (element.type === 'checkbox') {
                            element.checked = formData[elementName];
                        } else if (element.type === 'radio') {
                            if (element.value === formData[elementName]) {
                                element.checked = true;
                            }
                        } else {
                            element.value = formData[elementName];
                        }
                    }
                } else {
                    // Enkel element
                    var element = elements;
                    
                    if (element.type === 'checkbox') {
                        element.checked = formData[elementName];
                    } else if (element.type === 'select-multiple') {
                        if (Array.isArray(formData[elementName])) {
                            for (var j = 0; j < element.options.length; j++) {
                                element.options[j].selected = formData[elementName].indexOf(element.options[j].value) !== -1;
                            }
                        }
                    } else if (element.type !== 'button' && element.type !== 'submit' && element.type !== 'reset') {
                        element.value = formData[elementName];
                    }
                }
            }
        }
        
        alert("Formulier '" + formName + "' is hersteld");
        return true;
    } catch(e) {
        alert("Fout bij herstellen: " + e.message);
        return false;
    }
}

/**
 * Auto-save functionaliteit - sla formulier automatisch op bij wijzigingen
 */
function enableAutoSave(form, interval) {
    if (!form) return false;
    
    interval = interval || 30000; // Standaard elke 30 seconden
    
    // Sla op bij elke wijziging (met debounce)
    var timeout = null;
    var autoSave = function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            saveSelections(form);
        }, 2000); // 2 seconden na laatste wijziging
    };
    
    // Voeg event listeners toe
    for (var i = 0; i < form.elements.length; i++) {
        var element = form.elements[i];
        
        if (element.type === 'text' || element.type === 'textarea') {
            element.addEventListener('input', autoSave);
        } else if (element.type === 'checkbox' || element.type === 'radio') {
            element.addEventListener('change', autoSave);
        } else if (element.tagName === 'SELECT') {
            element.addEventListener('change', autoSave);
        }
    }
    
    // Ook periodiek opslaan
    setInterval(function() {
        saveSelections(form);
    }, interval);
    
    return true;
}

/**
 * Verwijder opgeslagen formulier data
 */
function clearSavedForm(formName) {
    try {
        localStorage.removeItem('form_' + formName);
        
        if (typeof Auth !== 'undefined' && Auth.isLoggedIn()) {
            UserData.remove('form_' + formName);
        }
        
        alert("Opgeslagen data voor formulier '" + formName + "' is verwijderd");
        return true;
    } catch(e) {
        alert("Fout bij verwijderen: " + e.message);
        return false;
    }
}

/**
 * Export formulier data als JSON bestand
 */
function exportFormData(form) {
    if (!form) {
        alert("Geen formulier gevonden om te exporteren");
        return false;
    }
    
    var formName = form.name || 'default_form';
    var storedData = localStorage.getItem('form_' + formName);
    
    if (!storedData) {
        alert("Geen opgeslagen data gevonden");
        return false;
    }
    
    // Maak download link
    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(storedData);
    var downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", formName + "_export.json");
    document.body.appendChild(downloadAnchorNode);
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
    
    return true;
}

/**
 * Import formulier data uit JSON bestand
 */
function importFormData(form, fileInput) {
    if (!form || !fileInput || !fileInput.files || !fileInput.files[0]) {
        alert("Geen bestand geselecteerd");
        return false;
    }
    
    var file = fileInput.files[0];
    var reader = new FileReader();
    
    reader.onload = function(e) {
        try {
            var formName = form.name || 'default_form';
            var data = e.target.result;
            
            // Valideer JSON
            JSON.parse(data);
            
            // Sla op
            localStorage.setItem('form_' + formName, data);
            
            // Laad direct in formulier
            loadSelections(form);
            
            alert("Data succesvol geïmporteerd");
        } catch(error) {
            alert("Fout bij importeren: " + error.message);
        }
    };
    
    reader.readAsText(file);
    return true;
}

// HULPSCHERM FUNCTIES

function hulp_scherm(hoogte, label, msg) {
    var vt0 = "<link rel='stylesheet' href='../css/screen.css' type='text/css' media='Screen' />";
    var vt1 = "<link rel='stylesheet' href='../css/mobile.css' type='text/css' media='handheld' />";
    
    var v1 = "<title>" + label + "</title>";
    var v2 = "<b>toelichting: " + label + "</b><p>";
    var v3 = "</p><form><p style='float:right'><input type=button value='sluit venster' onClick='self.close()'></p></form></body>";
    var speks = "height=" + hoogte + ",width=300,scrollbars=no";
    
    popup = window.open("", "toelichting", speks);
    popup.document.write(vt0 + vt1 + v1 + v2 + msg + v3);
    popup.document.close();
}

// WAARSCHUWING (tijdelijke functie)
function waarschuwing() {
    alert("De velden die u invult worden lokaal op uw apparaat opgeslagen. Gebruik de 's' knop om op te slaan en 'r' om te herstellen.");
}

// FORMULIER VALIDATIE FUNCTIES

/**
 * Valideer email adres
 */
function validateEmail(email) {
    var re = /^([._a-z0-9-]+)@(([a-z0-9-]+\.)+[a-z]{2,})$/i;
    return re.test(email);
}

/**
 * Valideer verplichte velden
 */
function validateRequired(form, requiredFields) {
    var errors = [];
    
    for (var i = 0; i < requiredFields.length; i++) {
        var fieldName = requiredFields[i];
        var field = form.elements[fieldName];
        
        if (!field) {
            errors.push("Veld '" + fieldName + "' niet gevonden");
            continue;
        }
        
        if (field.type === 'checkbox') {
            if (!field.checked) {
                errors.push("'" + (field.title || fieldName) + "' is verplicht");
            }
        } else if (!field.value || field.value.trim() === '') {
            errors.push("'" + (field.title || fieldName) + "' is verplicht");
        }
    }
    
    if (errors.length > 0) {
        alert("Formulier validatie fouten:\n\n" + errors.join("\n"));
        return false;
    }
    
    return true;
}

// COMPATIBILITEIT FUNCTIES

/**
 * Oude bewaartekst functie (nu met localStorage)
 */
function bewaartekst() {
    if (document.forms[0]) {
        saveSelections(document.forms[0]);
    } else {
        alert("Geen formulier gevonden");
    }
}

/**
 * Oude haaloptekst functie (nu met localStorage)
 */
function haaloptekst() {
    if (document.forms[0]) {
        loadSelections(document.forms[0]);
    } else {
        alert("Geen formulier gevonden");
    }
}

// UTILITY FUNCTIES

/**
 * Print preview
 */
function printPreview() {
    window.print();
}

/**
 * Toon/verberg sectie
 */
function toggleSection(sectionId) {
    var section = document.getElementById(sectionId);
    if (section) {
        if (section.style.display === 'none') {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    }
}

/**
 * Scroll naar element
 */
function scrollToElement(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

/**
 * Get URL parameter
 */
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// AUTO-LOAD bij pagina load
if (typeof window !== 'undefined') {
    window.addEventListener('load', function() {
        // Probeer automatisch het eerste formulier te laden
        if (document.forms.length > 0) {
            var form = document.forms[0];
            var formName = form.name || 'default_form';
            
            // Check of er opgeslagen data is
            var hasData = localStorage.getItem('form_' + formName);
            
            if (hasData && confirm("Er is opgeslagen data gevonden. Wilt u deze herstellen?")) {
                loadSelections(form);
            }
        }
    });
}
