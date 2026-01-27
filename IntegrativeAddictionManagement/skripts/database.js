/**
 * database.js - localStorage-based database systeem ter vervanging van MySQL
 * 
 * Dit systeem simuleert een database met localStorage voor client-side data opslag.
 * Alle data wordt lokaal in de browser opgeslagen.
 */

// Database object
var DB = {
    prefix: 'sma_', // prefix voor alle localStorage keys
    
    /**
     * Initialiseer de database structuur
     */
    init: function() {
        if (!this.tableExists('users')) {
            this.createTable('users', {
                id: 'auto',
                user_name: 'string',
                password: 'string',
                emailadres: 'string',
                voornaam: 'string',
                achternaam: 'string',
                gebjaar: 'string',
                gebmaand: 'string',
                gebdag: 'string',
                created: 'date'
            });
        }
        
        if (!this.tableExists('sessions')) {
            this.createTable('sessions', {
                id: 'auto',
                user_id: 'number',
                session_token: 'string',
                created: 'date',
                expires: 'date'
            });
        }
        
        if (!this.tableExists('userdata')) {
            this.createTable('userdata', {
                id: 'auto',
                user_id: 'number',
                key: 'string',
                value: 'text',
                updated: 'date'
            });
        }
    },
    
    /**
     * Maak een nieuwe tabel
     */
    createTable: function(tableName, schema) {
        var tableKey = this.prefix + 'table_' + tableName;
        var table = {
            name: tableName,
            schema: schema,
            data: [],
            autoIncrement: 1
        };
        localStorage.setItem(tableKey, JSON.stringify(table));
        return true;
    },
    
    /**
     * Check of tabel bestaat
     */
    tableExists: function(tableName) {
        var tableKey = this.prefix + 'table_' + tableName;
        return localStorage.getItem(tableKey) !== null;
    },
    
    /**
     * Haal tabel op
     */
    getTable: function(tableName) {
        var tableKey = this.prefix + 'table_' + tableName;
        var tableJson = localStorage.getItem(tableKey);
        if (tableJson) {
            return JSON.parse(tableJson);
        }
        return null;
    },
    
    /**
     * Sla tabel op
     */
    saveTable: function(table) {
        var tableKey = this.prefix + 'table_' + table.name;
        localStorage.setItem(tableKey, JSON.stringify(table));
    },
    
    /**
     * INSERT - voeg nieuwe rij toe
     */
    insert: function(tableName, data) {
        var table = this.getTable(tableName);
        if (!table) {
            console.error('Tabel niet gevonden: ' + tableName);
            return false;
        }
        
        var row = {};
        
        // Auto-increment ID
        if (table.schema.id === 'auto') {
            row.id = table.autoIncrement++;
        }
        
        // Voeg data toe
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                row[key] = data[key];
            }
        }
        
        // Voeg timestamps toe
        if (table.schema.created) {
            row.created = new Date().toISOString();
        }
        if (table.schema.updated) {
            row.updated = new Date().toISOString();
        }
        
        table.data.push(row);
        this.saveTable(table);
        
        return row.id || true;
    },
    
    /**
     * SELECT - haal rijen op met optionele where clause
     */
    select: function(tableName, whereClause, orderBy, limit) {
        var table = this.getTable(tableName);
        if (!table) {
            console.error('Tabel niet gevonden: ' + tableName);
            return [];
        }
        
        var results = table.data;
        
        // Filter met WHERE clause
        if (whereClause) {
            results = results.filter(function(row) {
                for (var key in whereClause) {
                    if (whereClause.hasOwnProperty(key)) {
                        if (row[key] != whereClause[key]) {
                            return false;
                        }
                    }
                }
                return true;
            });
        }
        
        // Sorteer indien opgegeven
        if (orderBy) {
            results.sort(function(a, b) {
                if (a[orderBy] < b[orderBy]) return -1;
                if (a[orderBy] > b[orderBy]) return 1;
                return 0;
            });
        }
        
        // Limiteer resultaten
        if (limit) {
            results = results.slice(0, limit);
        }
        
        return results;
    },
    
    /**
     * SELECT ONE - haal één rij op
     */
    selectOne: function(tableName, whereClause) {
        var results = this.select(tableName, whereClause, null, 1);
        return results.length > 0 ? results[0] : null;
    },
    
    /**
     * UPDATE - update bestaande rijen
     */
    update: function(tableName, data, whereClause) {
        var table = this.getTable(tableName);
        if (!table) {
            console.error('Tabel niet gevonden: ' + tableName);
            return 0;
        }
        
        var updated = 0;
        
        for (var i = 0; i < table.data.length; i++) {
            var row = table.data[i];
            var matches = true;
            
            // Check WHERE clause
            if (whereClause) {
                for (var key in whereClause) {
                    if (whereClause.hasOwnProperty(key)) {
                        if (row[key] != whereClause[key]) {
                            matches = false;
                            break;
                        }
                    }
                }
            }
            
            if (matches) {
                // Update de rij
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        table.data[i][key] = data[key];
                    }
                }
                
                // Update timestamp
                if (table.schema.updated) {
                    table.data[i].updated = new Date().toISOString();
                }
                
                updated++;
            }
        }
        
        if (updated > 0) {
            this.saveTable(table);
        }
        
        return updated;
    },
    
    /**
     * DELETE - verwijder rijen
     */
    delete: function(tableName, whereClause) {
        var table = this.getTable(tableName);
        if (!table) {
            console.error('Tabel niet gevonden: ' + tableName);
            return 0;
        }
        
        var originalLength = table.data.length;
        
        if (whereClause) {
            table.data = table.data.filter(function(row) {
                for (var key in whereClause) {
                    if (whereClause.hasOwnProperty(key)) {
                        if (row[key] == whereClause[key]) {
                            return false; // Verwijder deze rij
                        }
                    }
                }
                return true; // Behoud deze rij
            });
        } else {
            // Zonder WHERE clause: verwijder alles
            table.data = [];
        }
        
        var deleted = originalLength - table.data.length;
        
        if (deleted > 0) {
            this.saveTable(table);
        }
        
        return deleted;
    },
    
    /**
     * COUNT - tel aantal rijen
     */
    count: function(tableName, whereClause) {
        return this.select(tableName, whereClause).length;
    },
    
    /**
     * TRUNCATE - leeg een tabel
     */
    truncate: function(tableName) {
        var table = this.getTable(tableName);
        if (!table) {
            console.error('Tabel niet gevonden: ' + tableName);
            return false;
        }
        
        table.data = [];
        table.autoIncrement = 1;
        this.saveTable(table);
        return true;
    },
    
    /**
     * DROP TABLE - verwijder een tabel
     */
    dropTable: function(tableName) {
        var tableKey = this.prefix + 'table_' + tableName;
        localStorage.removeItem(tableKey);
        return true;
    },
    
    /**
     * Export alle data (voor backup)
     */
    exportAll: function() {
        var data = {};
        for (var i = 0; i < localStorage.length; i++) {
            var key = localStorage.key(i);
            if (key.indexOf(this.prefix) === 0) {
                data[key] = localStorage.getItem(key);
            }
        }
        return JSON.stringify(data);
    },
    
    /**
     * Import data (voor restore)
     */
    importAll: function(jsonData) {
        try {
            var data = JSON.parse(jsonData);
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    localStorage.setItem(key, data[key]);
                }
            }
            return true;
        } catch(e) {
            console.error('Import mislukt: ' + e);
            return false;
        }
    }
};

// Authenticatie helper functies
var Auth = {
    /**
     * Hash een wachtwoord (simpele MD5 simulatie)
     */
    hashPassword: function(password) {
        // Voor productie: gebruik een echte crypto library
        // Dit is een simpele hash voor demonstratie
        var hash = 0;
        for (var i = 0; i < password.length; i++) {
            var char = password.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash;
        }
        return 'hash_' + Math.abs(hash).toString(16);
    },
    
    /**
     * Genereer een random token
     */
    generateToken: function() {
        return 'token_' + Math.random().toString(36).substr(2) + Date.now().toString(36);
    },
    
    /**
     * Registreer een nieuwe gebruiker
     */
    register: function(userData) {
        // Check of email al bestaat
        var existing = DB.selectOne('users', { emailadres: userData.emailadres });
        if (existing) {
            return { success: false, message: 'Dit emailadres is al geregistreerd' };
        }
        
        // Check of username al bestaat
        existing = DB.selectOne('users', { user_name: userData.user_name });
        if (existing) {
            return { success: false, message: 'Deze gebruikersnaam is al in gebruik' };
        }
        
        // Hash het wachtwoord
        var hashedPassword = this.hashPassword(userData.password);
        
        // Maak gebruiker aan
        var userId = DB.insert('users', {
            user_name: userData.user_name,
            password: hashedPassword,
            emailadres: userData.emailadres,
            voornaam: userData.voornaam || '',
            achternaam: userData.achternaam || '',
            gebjaar: userData.gebjaar || '',
            gebmaand: userData.gebmaand || '',
            gebdag: userData.gebdag || ''
        });
        
        return { success: true, userId: userId };
    },
    
    /**
     * Login gebruiker
     */
    login: function(username, password) {
        var hashedPassword = this.hashPassword(password);
        
        var user = DB.selectOne('users', { 
            user_name: username, 
            password: hashedPassword 
        });
        
        if (!user) {
            return { success: false, message: 'Ongeldige gebruikersnaam of wachtwoord' };
        }
        
        // Maak sessie aan
        var token = this.generateToken();
        var expires = new Date();
        expires.setDate(expires.getDate() + 7); // 7 dagen geldig
        
        DB.insert('sessions', {
            user_id: user.id,
            session_token: token,
            expires: expires.toISOString()
        });
        
        // Sla token op in cookie/localStorage
        localStorage.setItem(DB.prefix + 'current_session', token);
        
        return { 
            success: true, 
            userId: user.id,
            token: token,
            user: user
        };
    },
    
    /**
     * Check of gebruiker is ingelogd
     */
    isLoggedIn: function() {
        var token = localStorage.getItem(DB.prefix + 'current_session');
        if (!token) {
            return false;
        }
        
        var session = DB.selectOne('sessions', { session_token: token });
        if (!session) {
            return false;
        }
        
        // Check of sessie nog geldig is
        var expires = new Date(session.expires);
        if (expires < new Date()) {
            this.logout();
            return false;
        }
        
        return true;
    },
    
    /**
     * Haal huidige gebruiker op
     */
    getCurrentUser: function() {
        var token = localStorage.getItem(DB.prefix + 'current_session');
        if (!token) {
            return null;
        }
        
        var session = DB.selectOne('sessions', { session_token: token });
        if (!session) {
            return null;
        }
        
        var user = DB.selectOne('users', { id: session.user_id });
        return user;
    },
    
    /**
     * Logout gebruiker
     */
    logout: function() {
        var token = localStorage.getItem(DB.prefix + 'current_session');
        if (token) {
            DB.delete('sessions', { session_token: token });
            localStorage.removeItem(DB.prefix + 'current_session');
        }
        return true;
    },
    
    /**
     * Verander wachtwoord
     */
    changePassword: function(userId, newPassword) {
        var hashedPassword = this.hashPassword(newPassword);
        var updated = DB.update('users', 
            { password: hashedPassword }, 
            { id: userId }
        );
        return updated > 0;
    },
    
    /**
     * Wachtwoord vergeten - genereer nieuw wachtwoord
     */
    resetPassword: function(emailadres) {
        var user = DB.selectOne('users', { emailadres: emailadres });
        if (!user) {
            return { success: false, message: 'Emailadres niet gevonden' };
        }
        
        // Genereer nieuw wachtwoord
        var newPassword = this.generateRandomPassword();
        var hashedPassword = this.hashPassword(newPassword);
        
        DB.update('users', 
            { password: hashedPassword }, 
            { id: user.id }
        );
        
        return { 
            success: true, 
            newPassword: newPassword,
            message: 'Nieuw wachtwoord gegenereerd'
        };
    },
    
    /**
     * Genereer random wachtwoord
     */
    generateRandomPassword: function() {
        var chars = 'abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
        var password = '';
        for (var i = 0; i < 8; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return password;
    }
};

// User data helper functies
var UserData = {
    /**
     * Sla user data op
     */
    set: function(key, value) {
        var user = Auth.getCurrentUser();
        if (!user) {
            console.error('Geen gebruiker ingelogd');
            return false;
        }
        
        // Check of data al bestaat
        var existing = DB.selectOne('userdata', { 
            user_id: user.id, 
            key: key 
        });
        
        if (existing) {
            // Update bestaande data
            DB.update('userdata', 
                { value: JSON.stringify(value) }, 
                { id: existing.id }
            );
        } else {
            // Nieuwe data
            DB.insert('userdata', {
                user_id: user.id,
                key: key,
                value: JSON.stringify(value)
            });
        }
        
        return true;
    },
    
    /**
     * Haal user data op
     */
    get: function(key, defaultValue) {
        var user = Auth.getCurrentUser();
        if (!user) {
            return defaultValue || null;
        }
        
        var data = DB.selectOne('userdata', { 
            user_id: user.id, 
            key: key 
        });
        
        if (!data) {
            return defaultValue || null;
        }
        
        try {
            return JSON.parse(data.value);
        } catch(e) {
            return data.value;
        }
    },
    
    /**
     * Verwijder user data
     */
    remove: function(key) {
        var user = Auth.getCurrentUser();
        if (!user) {
            return false;
        }
        
        DB.delete('userdata', { 
            user_id: user.id, 
            key: key 
        });
        
        return true;
    },
    
    /**
     * Haal alle data van gebruiker op
     */
    getAll: function() {
        var user = Auth.getCurrentUser();
        if (!user) {
            return {};
        }
        
        var allData = DB.select('userdata', { user_id: user.id });
        var result = {};
        
        for (var i = 0; i < allData.length; i++) {
            try {
                result[allData[i].key] = JSON.parse(allData[i].value);
            } catch(e) {
                result[allData[i].key] = allData[i].value;
            }
        }
        
        return result;
    }
};

// Initialiseer database bij laden
if (typeof window !== 'undefined') {
    window.addEventListener('load', function() {
        DB.init();
    });
}
