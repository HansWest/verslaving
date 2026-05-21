#!/bin/bash
echo "file,viewport,mobileCss,formsCss,hasInputs,hasSlider,hasDataStore,persistSignal,scaleMarker"
total=0
m_vp=0
m_mcss=0
m_fcss=0

for f in iam/htm/*.htm; do
    [[ -e "$f" ]] || continue
    ((total++))
    
    content=$(cat "$f")
    
    # Check for features
    grep -qi 'meta name="viewport"' "$f" && vp=Y || { vp=N; ((m_vp++)); }
    grep -qF "../css/mobile.css" "$f" && mcss=Y || { mcss=N; ((m_mcss++)); }
    grep -qF "../css/forms.css" "$f" && fcss=Y || { fcss=N; ((m_fcss++)); }
    
    if echo "$content" | grep -qiE "<input|<textarea|<select"; then hasInputs=Y; else hasInputs=N; fi
    if echo "$content" | grep -qi 'type="range"'; then hasSlider=Y; else hasSlider=N; fi
    if grep -qF "../js/dataStore.js" "$f"; then hasDataStore=Y; else hasDataStore=N; fi
    
    ps="-"
    sm="-"
    if [[ "$hasSlider" == "Y" ]]; then
        if echo "$content" | grep -qiE "iamData\.|localStorage|export|download|save" && echo "$content" | grep -qi "load"; then
            ps=Y
        else
            ps=N
        fi
        
        if echo "$content" | grep -qiE "0 =|100 =|laag|hoog|schaal"; then
            sm=Y
        else
            sm=N
        fi
    fi
    
    echo "$(basename "$f"),$vp,$mcss,$fcss,$hasInputs,$hasSlider,$hasDataStore,$ps,$sm"
done

echo ""
echo "Summary:"
echo "Total Files: $total"
echo "Missing Viewport: $m_vp"
echo "Missing mobile.css: $m_mcss"
echo "Missing forms.css: $m_fcss"
