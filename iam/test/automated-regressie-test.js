#!/usr/bin/env node

/**
 * Automated Regression Test Suite for Fase B Cross-Coupling
 * Tests all 10 Fase B pages + 3 crisis pages for:
 * - Cross-suggestion cards present & functional
 * - Max-5 limits enforced
 * - Route-kaarten (urgency/focus) working
 * - Crisis soft warnings active
 * - Data persistence via localStorage
 * 
 * Run: node automated-regressie-test.js
 */

const fs = require('fs');
const path = require('path');
const vm = require('vm');

// Test Configuration
const TEST_PAGES_FASE_B = [
  { file: 'risico-denken.htm', label: 'Risico Denken', hasRoute: false, hasSuggest: true },
  { file: 'risico-gevoelens.htm', label: 'Risico Gevoelens', hasRoute: false, hasSuggest: true },
  { file: 'voor-nadelen-balansen.htm', label: 'Voor-Nadelen Balansen', hasRoute: false, hasSuggest: true },
  { file: 'plan-van-aanpak.htm', label: 'Plan van Aanpak', hasRoute: false, hasSuggest: true },
  { file: 'stimulus-respons.htm', label: 'Stimulus-Respons', hasRoute: false, hasSuggest: true },
  { file: 'lastige-gevoelens.htm', label: 'Lastige Gevoelens', hasRoute: false, hasSuggest: true },
  { file: 'risico-situaties.htm', label: 'Risico Situaties', hasRoute: true, hasSuggest: true },
  { file: 'soorten-trek.htm', label: 'Soorten Trek', hasRoute: true, hasSuggest: true },
  { file: 'risico-activiteiten.htm', label: 'Risico Activiteiten', hasRoute: true, hasSuggest: true },
  { file: 'risico-mensen.htm', label: 'Risico Mensen', hasRoute: true, hasSuggest: true },
];

const TEST_PAGES_CRISIS = [
  { file: 'noodplan-forse-trek.htm', label: 'Noodplan Forse Trek', hasWarning: true },
  { file: 'plan-bij-uitglijden.htm', label: 'Plan bij Uitglijden', hasWarning: true },
  { file: 'noodplan-wegglijden.htm', label: 'Noodplan Wegglijden', hasWarning: true },
];

// Result tracking
let totalTests = 0;
let passedTests = 0;
let failedTests = [];

// Helper: Load and parse HTML file
function loadHTML(filename) {
  const filePath = path.join(__dirname, '..', 'htm', filename);
  if (!fs.existsSync(filePath)) {
    throw new Error(`File not found: ${filename}`);
  }
  const html = fs.readFileSync(filePath, 'utf-8');
  return html;
}

// Helper: Check for pattern in HTML
function hasPattern(html, pattern, description) {
  totalTests++;
  const found = pattern(html);
  if (found) {
    passedTests++;
    console.log(`✓ ${description}`);
  } else {
    failedTests.push(`✗ ${description}`);
    console.log(`✗ ${description}`);
  }
  return found;
}

// Test: Cross-suggestion box present
function testCrossSuggestionBox(html, filename) {
  console.log(`\n📋 Testing: ${filename}`);
  
  // Should have cross-suggest-box or similar
  hasPattern(html, h => h.includes('cross-suggest'), 
    `  → Has cross-suggest component`);
  
  // Should have max-5 slice limit
  hasPattern(html, h => h.includes('slice(0, 5)'),
    `  → Has max-5 suggestion limit`);
  
  // Should have appendUniqueLine or similar deduplication
  hasPattern(html, h => h.includes('appendUniqueLine') || h.includes('appendUniqueToField'),
    `  → Has deduplication logic`);
  
  // Should have "Voeg toe" or similar button text
  hasPattern(html, h => h.includes('Voeg toe') || h.includes('button'),
    `  → Has suggestion interaction button`);
  
  // Should have Bron label (source attribution)
  hasPattern(html, h => h.includes('Bron') || h.includes('source'),
    `  → Has source attribution`);
}

// Test: Route-kaart (nur-doen routing)
function testRouteKaart(html, filename) {
  console.log(`\n📍 Testing Routes: ${filename}`);
  
  // Should have route select elements
  hasPattern(html, h => h.includes('routeUrgency') || h.includes('Urgency'),
    `  → Has urgency selector`);
  
  // Should have focus selector or route hint
  hasPattern(html, h => h.includes('routeFocus') || h.includes('route-hint'),
    `  → Has route-hint or focus selector`);
  
  // Should have route-card
  hasPattern(html, h => h.includes('route-card'),
    `  → Has route-card CSS class`);
  
  // Should have openRecommendedRoute function
  hasPattern(html, h => h.includes('openRecommendedRoute') || h.includes('getRecommendedRoute'),
    `  → Has route function`);
  
  // Should have button to open route
  hasPattern(html, h => h.includes('Open aanbevolen') || h.includes('openRecommendedRoute'),
    `  → Has route action button`);
}

// Test: Crisis soft warnings
function testCrisisWarnings(html, filename) {
  console.log(`\n⚠️  Testing Crisis Warnings: ${filename}`);
  
  // Should have showMessage function (not alert)
  hasPattern(html, h => h.includes('function showMessage'),
    `  → Has showMessage (no alerts)`);
  
  // Should have soft warning rendering
  hasPattern(html, h => h.includes('renderSupportDependencyWarning'),
    `  → Has dependency warning logic`);
  
  // Should NOT have alert() calls in crisis context
  hasPattern(html, h => !h.includes('alert('),
    `  → No blocking alert() calls`);
  
  // Should have localStorage for collapse state
  hasPattern(html, h => h.includes('localStorage') || h.includes('setupCollapsible'),
    `  → Has collapse state persistence`);
}

// Test: Data persistence
function testDataPersistence(html, filename) {
  console.log(`\n💾 Testing Persistence: ${filename}`);
  
  // Should use iamData API
  hasPattern(html, h => h.includes('iamData') || h.includes('window.iamData'),
    `  → Uses iamData API`);
  
  // Should have saveForm or similar
  hasPattern(html, h => h.includes('saveForm') || h.includes('saveData') || h.includes('savePeople') || h.includes('savePerson'),
    `  → Has save function`);
  
  // Should have focus/change listeners
  hasPattern(html, h => h.includes('addEventListener'),
    `  → Has event listeners`);
}

// Test: Crisis crossflow module integration
function testCrisisCrossflow(html, filename) {
  console.log(`\n🔗 Testing Crisis Crossflow: ${filename}`);
  
  // Should import crisisCrossflow.js
  hasPattern(html, h => h.includes('crisisCrossflow.js'),
    `  → Imports crisisCrossflow module`);
  
  // Should have crossflowHelpBox
  hasPattern(html, h => h.includes('crossflowHelpBox') || h.includes('buildCrossflowSuggestions'),
    `  → Has crossflow component`);
  
  // Should render cross-flow suggestions
  hasPattern(html, h => h.includes('renderCrossflowSuggestions'),
    `  → Renders crossflow suggestions`);
}

async function testAiBridge() {
  console.log('\n🤖 Testing AI Bridge\n');

  const bridgeFile = path.join(__dirname, '..', 'js', 'aiBridge.js');
  const bridgeCode = fs.readFileSync(bridgeFile, 'utf-8');
  const elements = new Map();
  const clipboardWrites = [];
  const createElement = () => ({
    style: {},
    listeners: {},
    value: '',
    setAttribute() {},
    addEventListener(name, callback) {
      this.listeners[name] = callback;
    },
    remove() {},
    focus() {},
    select() {}
  });
  const document = {
    body: { appendChild() {} },
    createElement,
    execCommand: () => true,
    getElementById(id) {
      if (!elements.has(id)) elements.set(id, createElement());
      return elements.get(id);
    }
  };
  document.createElement = (tag) => {
    const element = createElement();
    if (tag === 'div') element.querySelector = () => createElement();
    return element;
  };
  const browser = {
    console,
    document,
    navigator: {
      clipboard: {
        async writeText(text) {
          clipboardWrites.push(text);
        }
      }
    }
  };
  browser.window = browser;
  vm.runInNewContext(bridgeCode, browser);

  const prompt = browser.iamAiBridge.buildPrompt({ cravingScore: 8 });
  hasPattern(prompt, text => text.includes('geen diagnose') && text.includes('Vraag eerst'),
    '  → Prompt treats AI as optional reflection, not diagnosis');
  hasPattern(bridgeCode, code => !code.includes('support1Name') && !code.includes('reachableSupport'),
    '  → Does not automatically add stored support contacts');

  browser.iamAiBridge.copyPromptToClipboard({ note: 'Context ter beoordeling' });
  hasPattern(clipboardWrites, writes => writes.length === 0,
    '  → Shows a preview before clipboard access');

  const promptInput = elements.get('iam-ai-prompt-text');
  promptInput.value += '\nAangepast door gebruiker';
  await elements.get('iam-ai-copy-btn').listeners.click();
  hasPattern(clipboardWrites, writes => writes.length === 1 && writes[0].includes('Aangepast door gebruiker'),
    '  → Copies the user-reviewed prompt');
}

// Main test execution
async function runTests() {
  console.log('═══════════════════════════════════════════════════════════');
  console.log('AUTOMATED REGRESSION TEST SUITE — Fase B & Crisis');
  console.log('═══════════════════════════════════════════════════════════\n');

  // Test Fase B pages
  console.log('📚 FASE B PAGES (10 pagina\'s)\n');
  
  for (const page of TEST_PAGES_FASE_B) {
    try {
      const html = loadHTML(page.file);
      
      // Core cross-coupling test
      if (page.hasSuggest) {
        testCrossSuggestionBox(html, page.file);
      }
      
      // Route-specific test
      if (page.hasRoute) {
        testRouteKaart(html, page.file);
      }
      
      // General persistence test
      testDataPersistence(html, page.file);
      
    } catch (error) {
      totalTests++;
      failedTests.push(`✗ ${page.file}: ${error.message}`);
      console.log(`✗ ${page.file}: ${error.message}`);
    }
  }

  // Test Crisis pages
  console.log('\n\n🚨 CRISIS PAGES (3 pagina\'s)\n');
  
  for (const page of TEST_PAGES_CRISIS) {
    try {
      const html = loadHTML(page.file);
      
      // Crisis-specific tests
      testCrisisWarnings(html, page.file);
      testCrisisCrossflow(html, page.file);
      testDataPersistence(html, page.file);
      
    } catch (error) {
      totalTests++;
      failedTests.push(`✗ ${page.file}: ${error.message}`);
      console.log(`✗ ${page.file}: ${error.message}`);
    }
  }

  // Test crisisCrossflow.js module
  console.log('\n\n📦 MODULE TEST\n');
  
  try {
    const moduleFile = path.join(__dirname, '..', 'js', 'crisisCrossflow.js');
    if (fs.existsSync(moduleFile)) {
      const moduleCode = fs.readFileSync(moduleFile, 'utf-8');
      
      hasPattern(moduleCode, c => c.includes('buildCrossflowSuggestions'),
        '  → crisisCrossflow.js: Has buildCrossflowSuggestions');
      
      hasPattern(moduleCode, c => c.includes('setupCollapsible'),
        '  → crisisCrossflow.js: Has setupCollapsible');
      
      hasPattern(moduleCode, c => c.includes('splitLines'),
        '  → crisisCrossflow.js: Has splitLines helper');
      
      hasPattern(moduleCode, c => c.includes('uniqueList'),
        '  → crisisCrossflow.js: Has uniqueList deduper');
    } else {
      totalTests++;
      failedTests.push('✗ crisisCrossflow.js not found');
      console.log('✗ crisisCrossflow.js not found');
    }
  } catch (error) {
    totalTests++;
    failedTests.push(`✗ Module test: ${error.message}`);
    console.log(`✗ Module test: ${error.message}`);
  }

  try {
    await testAiBridge();
  } catch (error) {
    totalTests++;
    failedTests.push(`✗ AI Bridge test: ${error.message}`);
    console.log(`✗ AI Bridge test: ${error.message}`);
  }

  // Summary
  console.log('\n═══════════════════════════════════════════════════════════');
  console.log('TEST SUMMARY\n');
  
  const passRate = ((passedTests / totalTests) * 100).toFixed(1);
  console.log(`✓ Passed: ${passedTests}/${totalTests} (${passRate}%)`);
  
  if (failedTests.length > 0) {
    console.log(`\n✗ Failed Tests (${failedTests.length}):`);
    failedTests.forEach(fail => console.log(`  ${fail}`));
  }
  
  console.log('\n═══════════════════════════════════════════════════════════');
  
  if (failedTests.length === 0) {
    console.log('\n🎉 ALL TESTS PASSED! Ready for deployment.\n');
    process.exit(0);
  } else {
    console.log(`\n⚠️  ${failedTests.length} test(s) failed. Review above.\n`);
    process.exit(1);
  }
}

// Run
runTests().catch(err => {
  console.error('Fatal error:', err);
  process.exit(1);
});
