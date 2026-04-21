/**
 * Central Data Store for IAM (Integrative Addiction Management)
 * Handles all localStorage/IndexedDB operations
 * 
 * Privacy-first: All data stays on user's device
 * Multiple pages share this central data pool
 */

class IamDataStore {
  constructor() {
    this.storageKey = 'iam_data';
    this.version = '1.0';
    this.autoSaveInterval = 30000; // 30 seconds
    this.autoSaveTimer = null;
    this.init();
  }

  /**
   * Initialize data store on first load
   */
  init() {
    if (!this.getData()) {
      this.createNewData();
    }
    this.startAutoSave();
  }

  /**
   * Create new empty data structure
   */
  createNewData() {
    const newData = {
      version: this.version,
      userId: this.generateUUID(),
      created: new Date().toISOString(),
      lastModified: new Date().toISOString(),
      forms: {
        'voor-nadelen-balansen': {
          usage: {
            advantages: [],
            disadvantages: []
          },
          change: {
            advantages: [],
            disadvantages: []
          },
          lastUpdated: null
        },
        'plan-van-aanpak': {
          goals: [],
          steps: [],
          lastUpdated: null
        }
      }
    };
    this.saveData(newData);
    return newData;
  }

  /**
   * Get all data
   */
  getData() {
    try {
      const data = localStorage.getItem(this.storageKey);
      return data ? JSON.parse(data) : null;
    } catch (e) {
      console.error('Error reading data:', e);
      return null;
    }
  }

  /**
   * Save all data
   */
  saveData(data) {
    try {
      data.lastModified = new Date().toISOString();
      localStorage.setItem(this.storageKey, JSON.stringify(data));
      return true;
    } catch (e) {
      console.error('Error saving data:', e);
      return false;
    }
  }

  /**
   * Get specific form data
   */
  getFormData(formType) {
    const data = this.getData();
    return data?.forms?.[formType] || null;
  }

  /**
   * Update specific form data
   */
  updateFormData(formType, formData) {
    const data = this.getData();
    if (!data.forms[formType]) {
      data.forms[formType] = {};
    }
    data.forms[formType] = {
      ...data.forms[formType],
      ...formData,
      lastUpdated: new Date().toISOString()
    };
    this.saveData(data);
    return data.forms[formType];
  }

  /**
   * Start auto-save (30 seconds)
   */
  startAutoSave() {
    this.autoSaveTimer = setInterval(() => {
      const data = this.getData();
      if (data) {
        this.saveData(data);
      }
    }, this.autoSaveInterval);
  }

  /**
   * Stop auto-save
   */
  stopAutoSave() {
    if (this.autoSaveTimer) {
      clearInterval(this.autoSaveTimer);
    }
  }

  /**
   * Export data as JSON
   */
  exportJSON() {
    const data = this.getData();
    const jsonString = JSON.stringify(data, null, 2);
    const blob = new Blob([jsonString], { type: 'application/json' });
    return {
      filename: `iam-backup-${new Date().toISOString().split('T')[0]}.json`,
      blob: blob
    };
  }

  /**
   * Export data as CSV (simplified, form-specific)
   */
  exportFormCSV(formType) {
    const formData = this.getFormData(formType);
    if (!formData) return null;

    let csv = 'IAM Data Export\n';
    csv += `Form Type,${formType}\n`;
    csv += `Export Date,${new Date().toISOString()}\n\n`;

    // Generic CSV for array of objects
    if (Array.isArray(formData)) {
      const keys = formData[0] ? Object.keys(formData[0]) : [];
      csv += keys.join(',') + '\n';
      formData.forEach(item => {
        csv += keys.map(key => {
          const val = item[key];
          return typeof val === 'string' && val.includes(',') ? `"${val}"` : val;
        }).join(',') + '\n';
      });
    } else {
      // Key-value pairs
      Object.entries(formData).forEach(([key, value]) => {
        if (typeof value !== 'object') {
          csv += `${key},"${value}"\n`;
        }
      });
    }

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    return {
      filename: `iam-${formType}-${new Date().toISOString().split('T')[0]}.csv`,
      blob: blob
    };
  }

  /**
   * Import JSON data
   */
  importJSON(jsonString) {
    try {
      const data = JSON.parse(jsonString);
      if (data.version && data.forms) {
        this.saveData(data);
        return { success: true, message: 'Data imported successfully' };
      }
      return { success: false, message: 'Invalid data format' };
    } catch (e) {
      return { success: false, message: 'Error parsing JSON: ' + e.message };
    }
  }

  /**
   * Clear all data (with confirmation)
   */
  clearAllData(confirm = false) {
    if (confirm) {
      localStorage.removeItem(this.storageKey);
      this.createNewData();
      return true;
    }
    return false;
  }

  /**
   * Generate UUID
   */
  generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
      const r = Math.random() * 16 | 0;
      const v = c === 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }
}

// Initialize global data store
const iamData = new IamDataStore();
