/**
 * IAM AI Bridge — Verbinding tussen IAM formulieren en de AI van de cliënt
 * 
 * Privacy-first: 
 * - Werkt volledig lokaal in de browser.
 * - Stelt een respectvolle, niet-oordelende prompt samen op basis van de ingevulde data.
 * - Kopieert met 1 klik naar het klembord voor ChatGPT, Claude, Gemini of een lokale AI.
 */
(function (global) {
  'use strict';

  const IAM_AI_PHILOSOPHY = [
    "### INSTRUCTIE VOOR MIJN AI (IAM HERSTELMODEL):",
    "- Behandel mij zonder oordeel, schuld of schaamte (geen 'karaktergebreken' of moraliserende taal).",
    "- Begrijp dat mijn drang (craving) een biologisch overlevingsalarm is van mijn hersenstam, die per abuis levensbelang toekent aan de molecule/het gedrag.",
    "- Begrijp dat mijn denkende brein gekaapt kan zijn om excuses ('smoezen') te verzinnen. Help mij dit met milde nieuwsgierigheid te observeren.",
    "- Doel van ons gesprek: vertragen, mijn zenuwstelsel kalmeren (zelfregulatie / co-regulatie) en de gevoelde 'belangrijkheid' van de molecule verlagen."
  ].join('\n');

  function getStoredData() {
    if (global.iamData && typeof global.iamData.getAllData === 'function') {
      try {
        return global.iamData.getAllData() || {};
      } catch (e) {
        console.warn('Kon iamData niet uitlezen:', e);
      }
    }
    return {};
  }

  function buildPrompt(options) {
    const opts = options || {};
    const iamData = getStoredData();

    const sections = [];
    sections.push(IAM_AI_PHILOSOPHY);
    sections.push("\n### MIJN ACTUELE STATUS:");

    // Craving of intensiteit
    if (opts.cravingScore !== undefined && opts.cravingScore !== null) {
      sections.push(`- Actuele drang / spanning: ${opts.cravingScore} op een schaal van 1 tot 10.`);
    }

    // Context / Opmerking
    if (opts.note && String(opts.note).trim()) {
      sections.push(`- Wat er nu speelt: "${String(opts.note).trim()}"`);
    }

    // Noodplan / Steunnetwerk data uit localStore
    const noodplan = iamData['noodplan-wegglijden'] || iamData['noodplan-forse-trek'] || {};
    const supportNet = iamData['steunnetwerk'] || iamData['sociaal-netwerk'] || {};

    const primarySupport = supportNet.support1Name || supportNet.reachableSupport || '';
    if (primarySupport) {
      sections.push(`- Mijn steuncontact voor co-regulatie: ${primarySupport}`);
    }

    if (noodplan.noodStap1 || noodplan.crisisAction1) {
      const stap = noodplan.noodStap1 || noodplan.crisisAction1;
      sections.push(`- Een actie uit mijn noodplan: ${stap}`);
    }

    sections.push("\n### MIJN VRAAG AAN JOU:");
    if (opts.question) {
      sections.push(opts.question);
    } else if (Number(opts.cravingScore) >= 7) {
      sections.push("Ik ervaar acute drang/spanning. Help me nu eerst om adem te halen, te aarden en mijn zenuwstelsel te kalmeren. Vraag me daarna wat er emotioneel onder zit.");
    } else {
      sections.push("Help me even te reflecteren op dit moment. Hoe kan ik nu constructief voor mezelf zorgen en de drang laten uitdoven?");
    }

    return sections.join('\n');
  }

  function showBridgeModal(promptText) {
    let existingModal = document.getElementById('iam-ai-bridge-modal');
    if (existingModal) {
      existingModal.remove();
    }

    const modal = document.createElement('div');
    modal.id = 'iam-ai-bridge-modal';
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-labelledby', 'iam-ai-bridge-title');

    modal.innerHTML = `
      <div class="iam-ai-backdrop" style="position:fixed;inset:0;background:rgba(18,30,42,0.65);z-index:99999;display:flex;align-items:center;justify-content:center;padding:1rem;">
        <div class="iam-ai-card" style="background:#fff;border-radius:18px;max-width:580px;width:100%;max-height:90vh;overflow-y:auto;padding:1.5rem;box-shadow:0 20px 45px rgba(0,0,0,0.25);font-family:system-ui,-apple-system,sans-serif;color:#1e293b;position:relative;">
          
          <button id="iam-ai-close-btn" aria-label="Sluiten" style="position:absolute;top:1rem;right:1rem;background:transparent;border:none;font-size:1.5rem;cursor:pointer;color:#64748b;padding:0.25rem 0.5rem;">✕</button>
          
          <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
            <span style="font-size:1.8rem;">🤖</span>
            <div>
              <h2 id="iam-ai-bridge-title" style="margin:0;font-size:1.25rem;font-weight:700;color:#0f172a;">Kopieer voor je AI</h2>
              <p style="margin:0;font-size:0.88rem;color:#64748b;">De tekst is naar je klembord gekopieerd!</p>
            </div>
          </div>

          <div style="background:#f1f5f9;border-left:4px solid #3b82f6;padding:0.75rem 1rem;border-radius:8px;font-size:0.88rem;line-height:1.45;margin-bottom:1rem;color:#334155;">
            <strong>Klaar om te plakken:</strong> Open nu jouw favoriete AI en druk op <strong>Plakken</strong> (<code>Ctrl+V</code> of <code>Cmd+V</code>).
          </div>

          <div style="margin-bottom:1.25rem;">
            <label style="font-size:0.8rem;font-weight:600;color:#475569;display:block;margin-bottom:0.35rem;">Tekst die gekopieerd is:</label>
            <textarea readonly style="width:100%;height:110px;padding:0.6rem;font-size:0.82rem;font-family:monospace;background:#f8fafc;border:1px solid #cbd5e1;border-radius:8px;color:#334155;resize:vertical;box-sizing:border-box;">${promptText.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</textarea>
          </div>

          <div style="display:flex;flex-wrap:wrap;gap:0.6rem;margin-bottom:1.25rem;">
            <a href="https://chatgpt.com" target="_blank" rel="noopener noreferrer" style="flex:1;min-width:140px;background:#10a37f;color:#fff;text-align:center;padding:0.65rem 0.8rem;border-radius:10px;text-decoration:none;font-weight:600;font-size:0.9rem;display:inline-flex;align-items:center;justify-content:center;gap:0.4rem;">
              <span>Open ChatGPT</span> ↗
            </a>
            <a href="https://claude.ai" target="_blank" rel="noopener noreferrer" style="flex:1;min-width:140px;background:#d97706;color:#fff;text-align:center;padding:0.65rem 0.8rem;border-radius:10px;text-decoration:none;font-weight:600;font-size:0.9rem;display:inline-flex;align-items:center;justify-content:center;gap:0.4rem;">
              <span>Open Claude</span> ↗
            </a>
            <a href="https://gemini.google.com" target="_blank" rel="noopener noreferrer" style="flex:1;min-width:140px;background:#2563eb;color:#fff;text-align:center;padding:0.65rem 0.8rem;border-radius:10px;text-decoration:none;font-weight:600;font-size:0.9rem;display:inline-flex;align-items:center;justify-content:center;gap:0.4rem;">
              <span>Open Gemini</span> ↗
            </a>
          </div>

          <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:0.75rem;font-size:0.82rem;color:#64748b;line-height:1.45;">
            🔒 <strong>Jouw Privacy:</strong> Deze data blijft op jouw apparaat. Pas wanneer jij zélf op plakken drukt in jouw AI, wordt de tekst verzonden. IAM heeft geen centrale database en kijkt niet mee.
          </div>

        </div>
      </div>
    `;

    document.body.appendChild(modal);

    const closeBtn = document.getElementById('iam-ai-close-btn');
    const backdrop = modal.querySelector('.iam-ai-backdrop');

    function closeModal() {
      modal.remove();
    }

    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop) closeModal();
    });
  }

  function copyPromptToClipboard(options) {
    const promptText = buildPrompt(options);

    if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
      navigator.clipboard.writeText(promptText)
        .then(() => {
          showBridgeModal(promptText);
        })
        .catch((err) => {
          console.warn('Klembord schrijven mislukt via API, probeer fallback:', err);
          fallbackCopyText(promptText);
        });
    } else {
      fallbackCopyText(promptText);
    }
  }

  function fallbackCopyText(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.top = '-9999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
      document.execCommand('copy');
      showBridgeModal(text);
    } catch (err) {
      alert('Kopiëren niet automatisch gelukt. Je kunt de tekst handmatig selecteren en kopiëren.');
      showBridgeModal(text);
    }
    document.body.removeChild(textArea);
  }

  global.iamAiBridge = {
    buildPrompt: buildPrompt,
    copyPromptToClipboard: copyPromptToClipboard,
    showBridgeModal: showBridgeModal
  };

})(typeof window !== 'undefined' ? window : this);
