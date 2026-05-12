/**
 * Eenvoudig emotie-dynamiekmodel voor experimentele IAM-pilots.
 *
 * Idee:
 * - decay: emotie beweegt geleidelijk terug naar baseline (originalEmotion)
 * - change: gebruiker-input verandert de emotie, met afnemende impact op grotere afstand
 *
 * Deze module is bewust losgekoppeld van actieve formulieren.
 */

function clampNumber(value, min, max) {
  if (!Number.isFinite(value)) return min;
  return Math.min(max, Math.max(min, value));
}

/**
 * @param {object} args
 * @param {number} args.oldEmotion - Huidige emotiewaarde
 * @param {number} args.originalEmotion - Baseline emotiewaarde
 * @param {number} args.delta - Richting/sterkte van user-impact
 * @param {number} args.impact - Gevoeligheid voor user-impact (>= 0)
 * @param {number} [args.decayQuotient=0.1] - Tempo terug naar baseline
 * @param {number} [args.minEmotion=-100] - Ondergrens
 * @param {number} [args.maxEmotion=100] - Bovengrens
 * @returns {{newEmotion:number, decay:number, change:number}}
 */
function updateEmotionState({
  oldEmotion,
  originalEmotion,
  delta,
  impact,
  decayQuotient = 0.1,
  minEmotion = -100,
  maxEmotion = 100
}) {
  const safeOld = Number(oldEmotion) || 0;
  const safeOriginal = Number(originalEmotion) || 0;
  const safeDelta = Number(delta) || 0;
  const safeImpact = Math.max(0, Number(impact) || 0);
  const safeDecayQuotient = clampNumber(Number(decayQuotient) || 0, 0, 1);

  const distance = Math.abs(safeOriginal - safeOld);
  const decay = (safeOriginal - safeOld) * safeDecayQuotient;
  const change = (safeDelta * safeImpact) / (1 + distance * safeImpact);

  const newEmotion = clampNumber(safeOld + decay + change, minEmotion, maxEmotion);

  return {
    newEmotion,
    decay,
    change
  };
}

window.iamEmotionDynamics = {
  updateEmotionState
};
