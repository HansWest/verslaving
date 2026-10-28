/**
 * IAM AI Bridge — Verbinding tussen IAM formulieren en de AI van de cliënt
 * 
 * The prompt is prepared locally and shown for review before the user chooses to copy it.
 */
(function (global) {
  'use strict';

  const IAM_AI_PHILOSOPHY = [
    "### INSTRUCTIE VOOR MIJN AI (IAM):",
    "- Wees rustig, gelijkwaardig, nieuwsgierig en niet-veroordelend. Vermijd schuld, schaamte, morele oordelen en labels die ik zelf niet kies.",
    "- Mijn eigen doelen en waarden zijn leidend. Neem niet aan dat ik wil stoppen, minderen of een andere vooraf bepaalde uitkomst nastreef.",
    "- Vraag eerst wat ik nu wil: gehoord worden, iets onderzoeken of ideeën voor een kleine volgende stap. Stel hooguit één open vraag tegelijk.",
    "- Presenteer interpretaties als mogelijkheden, niet als feiten of diagnoses. Een IAM-breinmodel kan een helpende metafoor zijn, maar verklaart niet automatisch mijn ervaring.",
    "- Noem mijn gevoelens niet nep en bestempel mijn gedachten niet als smoezen. Help me ze desgewenst met mildheid te onderzoeken.",
    "- Bied opties aan als voorstellen die ik mag weigeren of aanpassen. Forceer geen ademhalingsoefening, plan of contact met anderen.",
    "- Je bent geen behandelaar. Bij direct gevaar of mogelijk medisch riskante ontwenning: moedig passende menselijke of professionele hulp aan; laat mij niet alleen op AI vertrouwen."
  ].join('\n');

  function buildPrompt(options) {
    const opts = options || {};
    const sections = [];
    sections.push(IAM_AI_PHILOSOPHY);
    sections.push("\n### CONTEXT DIE IK WIL DELEN:");

    if (opts.cravingScore !== undefined && opts.cravingScore !== null) {
      sections.push(`- Mijn eigen inschatting van drang/spanning: ${opts.cravingScore} op 10. Dit is geen diagnose of automatische indicatie van acuut gevaar.`);
    }

    if (opts.note && String(opts.note).trim()) {
      sections.push(`- Wat ik hierover wil delen: ${String(opts.note).trim()}`);
    }

    sections.push("\n### MIJN VRAAG AAN JOU:");
    if (opts.question) {
      sections.push("De volgende vraag is een startvoorstel uit IAM. Controleer eerst of deze vraag past bij wat ik wil; als dat onduidelijk is, vraag mij wat ik nodig heb.");
      sections.push(opts.question);
    } else {
      sections.push("Vraag eerst of ik vooral gehoord wil worden, mijn ervaring wil onderzoeken of samen een mogelijke volgende stap wil verkennen. Laat mij bepalen wat nu helpend is.");
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
              <h2 id="iam-ai-bridge-title" style="margin:0;font-size:1.25rem;font-weight:700;color:#0f172a;">Bekijk tekst voor je AI</h2>
              <p style="margin:0;font-size:0.88rem;color:#64748b;">Controleer en pas de tekst aan voordat je die kopieert.</p>
            </div>
          </div>

          <div style="background:#f1f5f9;border-left:4px solid #3b82f6;padding:0.75rem 1rem;border-radius:8px;font-size:0.88rem;line-height:1.45;margin-bottom:1rem;color:#334155;">
            Bekijk de tekst hieronder. Verwijder gegevens die je niet wilt delen. Er wordt niets gekopieerd of naar een AI verzonden totdat je daar zelf voor kiest.
          </div>

          <div style="margin-bottom:1.25rem;">
            <label for="iam-ai-prompt-text" style="font-size:0.8rem;font-weight:600;color:#475569;display:block;margin-bottom:0.35rem;">Tekst die je kunt aanpassen:</label>
            <textarea id="iam-ai-prompt-text" style="width:100%;height:180px;padding:0.6rem;font-size:0.82rem;font-family:monospace;background:#f8fafc;border:1px solid #cbd5e1;border-radius:8px;color:#334155;resize:vertical;box-sizing:border-box;"></textarea>
          </div>

          <div style="display:flex;flex-wrap:wrap;gap:0.6rem;margin-bottom:0.6rem;">
            <button type="button" id="iam-ai-copy-btn" style="background:#1d4ed8;color:#fff;border:0;border-radius:10px;padding:0.65rem 0.8rem;font-weight:600;cursor:pointer;">Kopieer deze tekst</button>
            <button type="button" id="iam-ai-close-action" style="background:#e2e8f0;color:#1e293b;border:0;border-radius:10px;padding:0.65rem 0.8rem;font-weight:600;cursor:pointer;">Annuleren</button>
          </div>
          <p id="iam-ai-copy-status" role="status" aria-live="polite" style="min-height:1.3em;font-size:0.86rem;color:#475569;"></p>

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
            <strong>Privacy:</strong> IAM maakt deze tekst in je browser. Kopiëren zet die op het klembord; pas als je hem in een AI-dienst plakt en verzendt, ontvangt die aanbieder de tekst. De verwerking daarna valt onder het privacybeleid van die aanbieder.
          </div>

        </div>
      </div>
    `;

    document.body.appendChild(modal);

    const closeBtn = document.getElementById('iam-ai-close-btn');
    const closeAction = document.getElementById('iam-ai-close-action');
    const backdrop = modal.querySelector('.iam-ai-backdrop');
    const promptInput = document.getElementById('iam-ai-prompt-text');
    const copyButton = document.getElementById('iam-ai-copy-btn');
    const copyStatus = document.getElementById('iam-ai-copy-status');
    promptInput.value = promptText;

    function closeModal() {
      modal.remove();
    }

    closeBtn.addEventListener('click', closeModal);
    closeAction.addEventListener('click', closeModal);
    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop) closeModal();
    });
    copyButton.addEventListener('click', () => writePromptToClipboard(promptInput.value, copyStatus));
  }

  async function writePromptToClipboard(promptText, statusElement) {
    let copied = false;
    if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
      try {
        await navigator.clipboard.writeText(promptText);
        copied = true;
      } catch (error) {
        console.warn('Kopiëren via de clipboard-API is mislukt; probeer de browserfallback.', error);
      }
    }

    if (!copied) copied = fallbackCopyText(promptText);
    if (statusElement) {
      statusElement.textContent = copied
        ? 'De aangepaste tekst staat op je klembord. Plakken in een AI-dienst en verzenden blijft jouw keuze.'
        : 'Kopiëren is niet gelukt. Selecteer de tekst hierboven en kopieer die handmatig.';
    }
  }

  function fallbackCopyText(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.top = '-9999px';
    document.body.appendChild(textArea);
    try {
      textArea.focus();
      textArea.select();
      return document.execCommand('copy');
    } catch (error) {
      console.error('Kopiëren naar het klembord is mislukt.', error);
      return false;
    } finally {
      textArea.remove();
    }
  }

  function copyPromptToClipboard(options) {
    showBridgeModal(buildPrompt(options));
  }

  global.iamAiBridge = {
    buildPrompt: buildPrompt,
    copyPromptToClipboard: copyPromptToClipboard,
    showBridgeModal: showBridgeModal,
    copyReviewedPrompt: copyPromptToClipboard
  };

})(typeof window !== 'undefined' ? window : this);
