/* This taxonomy was researched and curated by Hans West as part of the KinkAware Coach project - a free, privacy-first toolkit for kink-aware self-reflection and communication. If you find it useful, a small token of appreciation is warmly welcomed: PayPal https://paypal.me/WestCoaching | GitHub Sponsors https://github.com/sponsors/HansWest | IBAN NL77 INGB 0008 2096 84 | Project https://github.com/HansWest/kink_aware_coach - Thank you for your interest and for supporting open, shame-free kink education. */
/**
 * Social Network Reflection Tool
 * Core JavaScript Logic
 */

// --- 1. Database Layer (IndexedDB) ---
class SocialNetworkDB {
    constructor() {
        this.dbName = 'SocialNetworkDB';
        this.version = 1;
        this.db = null;
    }

    async init() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.version);

            request.onerror = (event) => {
                console.error('Database error:', event.target.error);
                reject(event.target.error);
            };

            request.onsuccess = (event) => {
                this.db = event.target.result;
                resolve(this.db);
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;
                // People store
                if (!db.objectStoreNames.contains('people')) {
                    const peopleStore = db.createObjectStore('people', { keyPath: 'id' });
                    peopleStore.createIndex('type', 'type', { unique: false }); // 'me' or 'other'
                }
            };
        });
    }

    async getAllPeople() {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['people'], 'readonly');
            const store = transaction.objectStore('people');
            const request = store.getAll();
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    async savePerson(person) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['people'], 'readwrite');
            const store = transaction.objectStore('people');
            const request = store.put(person);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    async deletePerson(id) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['people'], 'readwrite');
            const store = transaction.objectStore('people');
            const request = store.delete(id);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async reset() {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['people'], 'readwrite');
            const store = transaction.objectStore('people');
            const request = store.clear();
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
}

// --- 2. Physics & Logic ---
class SocialNetworkApp {
    constructor() {
        this.db = new SocialNetworkDB();
        this.canvas = document.getElementById('networkCanvas');
        this.ctx = this.canvas.getContext('2d');

        this.people = [];
        this.me = null;

        // Zones configuration (radii) - responsive
        this.zones = {
            intimate: 100,
            close: 200,
            intermediate: 350,
            far: 500
        };

        // Physics params
        this.damping = 0.9;
        this.centerPull = 0.05;
        this.repulsion = 2000; // anti-gravity
        this.relationshipForce = 0.05; // Strength of peer push/pull

        this.speedFactor = 0.5; // Default 50% speed
        this.minSpeed = 0.1;
        this.maxSpeed = 2.0;

        this.isDragging = false;
        this.draggedPerson = null;
        this.hoveredPerson = null;

        this.bindEvents();
        this.resize();
    }

    async init() {
        await this.db.init();
        await this.loadData();

        if (!this.me) {
            await this.createMe();
        }

        // Initialize time for loop
        this.lastTime = 0;
        requestAnimationFrame((timestamp) => this.loop(timestamp));
    }

    async createMe() {
        this.me = {
            id: 'me',
            name: 'Me',
            type: 'me',
            x: this.canvas.width / 2,
            y: this.canvas.height / 2,
            radius: 10,
            color: '#3b82f6',
            vx: 0,
            vy: 0,
            importance: 'center',
            relationships: {} // Map of id -> 'neutral' | 'push' | 'pull'
        };
        await this.db.savePerson(this.me);
        this.people.push(this.me);
    }

    async loadData() {
        const data = await this.db.getAllPeople();
        if (data.length > 0) {
            // Update radii for existing data
            this.people = data.map(p => {
                if (p.type === 'me') p.radius = 10;
                else p.radius = 7;
                return p;
            });
            this.me = this.people.find(p => p.type === 'me');

            // Save updated sizes back to DB just in case
            this.people.forEach(p => this.db.savePerson(p));
        }
    }

    bindEvents() {
        window.addEventListener('resize', () => this.resize());

        this.canvas.addEventListener('mousedown', (e) => this.inputStart(e));
        this.canvas.addEventListener('mousemove', (e) => this.inputMove(e));
        this.canvas.addEventListener('mouseup', (e) => this.inputEnd(e));

        // Touch events for mobile support
        this.canvas.addEventListener('touchstart', (e) => this.inputStart(e.touches[0]));
        this.canvas.addEventListener('touchmove', (e) => this.inputMove(e.touches[0]));
        this.canvas.addEventListener('touchend', (e) => this.inputEnd(e.changedTouches[0]));

        this.isPaused = false;

        document.getElementById('addPersonBtn').onclick = () => this.showAddPersonModal();
        document.getElementById('shakeBtn').onclick = () => this.shake();
        document.getElementById('pauseBtn').onclick = () => this.togglePause();

        document.getElementById('slowerBtn').onclick = () => this.changeSpeed(-0.1);
        document.getElementById('fasterBtn').onclick = () => this.changeSpeed(0.1);

        // Export/Import Events
        document.getElementById('exportBtn').onclick = () => this.exportData();
        document.getElementById('importBtn').onclick = () => document.getElementById('importFile').click();
        document.getElementById('importFile').onchange = (e) => this.importData(e);

        document.getElementById('resetBtn').onclick = async () => {
            if (confirm("Factory reset? This will delete everyone.")) {
                await this.db.reset();
                this.people = [];
                this.me = null;
                await this.init();
            }
        };

        // Form handling
        const form = document.getElementById('editForm');
        form.onsubmit = (e) => this.handleSavePerson(e);

        document.getElementById('deletePersonBtn').onclick = () => this.handleDeletePerson();
        document.querySelector('.close-btn').onclick = () => this.closeModal();
    }

    async exportData() {
        if (!this.people || this.people.length === 0) {
            alert("No data to export.");
            return;
        }

        const dataStr = JSON.stringify(this.people, null, 2);
        const dataUri = 'data:application/json;charset=utf-8,' + encodeURIComponent(dataStr);

        const exportFileDefaultName = 'West-coaching_social-network-data.json';

        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
    }

    async importData(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = async (e) => {
            try {
                const json = JSON.parse(e.target.result);
                if (!Array.isArray(json)) throw new Error("Invalid data format");

                if (confirm("Importing will overwrite current data. Continue?")) {
                    await this.db.reset();
                    // Restore each person
                    for (const person of json) {
                        await this.db.savePerson(person);
                    }

                    // Reload
                    this.people = [];
                    this.me = null;
                    await this.init();
                    alert("Import successful!");
                }
            } catch (err) {
                alert("Error importing data: " + err.message);
            }
            // Clear input so same file can be selected again if needed
            event.target.value = '';
        };
        reader.readAsText(file);
    }

    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
        // Recalculate radiuses based on screen size
        const minDim = Math.min(this.canvas.width, this.canvas.height);
        this.zones.intimate = minDim * 0.15;
        this.zones.close = minDim * 0.25;
        this.zones.intermediate = minDim * 0.38;
        this.zones.far = minDim * 0.48;

        if (this.me) {
            this.me.x = this.canvas.width / 2;
            this.me.y = this.canvas.height / 2;
        }
    }

    loop(timestamp) {
        if (!this.lastTime) this.lastTime = timestamp;
        const deltaTime = timestamp - this.lastTime;
        this.lastTime = timestamp;

        // Cap deltaTime to prevent explosions on tab switch (max 100ms)
        const dt = Math.min(deltaTime, 100);

        // Calculate time correction (relative to 60fps)
        // If smooth 60fps, dt = 16.66ms, ratio = 1.0
        const frameRatio = dt / 16.666;

        const physicsStep = frameRatio * this.speedFactor;

        this.updatePhysics(physicsStep);
        this.draw();
        requestAnimationFrame((ts) => this.loop(ts));
    }

    updatePhysics(step = 1.0) {
        if (this.isPaused) return;

        // Center "Me" always
        if (this.me) {
            this.me.x = this.canvas.width / 2;
            this.me.y = this.canvas.height / 2;
            this.me.vx = 0;
            this.me.vy = 0;
        }

        // Apply forces to everyone else
        this.people.forEach(p => {
            if (p.type === 'me') return;
            if (p === this.draggedPerson) return; // Don't move if dragging

            // Stop on hover for easier clicking
            if (p === this.hoveredPerson) {
                p.vx = 0;
                p.vy = 0;
                return;
            }

            // 1. Attraction to target zone (importance)
            let targetR = this.zones.far;
            if (p.importance === 'intimate') targetR = this.zones.intimate;
            else if (p.importance === 'close') targetR = this.zones.close;
            else if (p.importance === 'intermediate') targetR = this.zones.intermediate;
            else if (p.importance === 'far') targetR = this.zones.far;

            const dx = p.x - this.me.x;
            const dy = p.y - this.me.y;
            const dist = Math.sqrt(dx * dx + dy * dy) || 1;
            const angle = Math.atan2(dy, dx);

            // Spring force towards target radius ring
            const distErr = dist - targetR;
            // Stronger pull if far off, gentle settle
            const force = distErr * this.centerPull;

            const fx = Math.cos(angle) * force;
            const fy = Math.sin(angle) * force;

            p.vx -= fx * 0.1 * step;
            p.vy -= fy * 0.1 * step;

            // 2. Peer Interactions (Repulsion + Relationships)
            this.people.forEach(other => {
                if (p === other) return;
                const ox = p.x - other.x;
                const oy = p.y - other.y;
                const odist = Math.sqrt(ox * ox + oy * oy) || 1;

                // Base Collision Repulsion (Hard shell)
                const minGap = (p.radius || 7) + (other.radius || 7) + 5;

                if (odist < minGap) {
                    // HARD push if overlapping
                    const pushStr = 5;
                    p.vx += (ox / odist) * pushStr * step;
                    p.vy += (oy / odist) * pushStr * step;
                } else {
                    // Soft repulse for general spreading (Coulomb's law)
                    const f = this.repulsion / (odist * odist);
                    p.vx += (ox / odist) * f * step;
                    p.vy += (oy / odist) * f * step;
                }

                // Peer Relationship Forces (Spring targets)
                // Check if 'p' has a defined relationship with 'other'
                if (p.relationships && p.relationships[other.id]) {
                    let type = p.relationships[other.id];
                    let targetDist = null;
                    const springStrength = 0.03;

                    // Map types to distances (Half of Me-distances)
                    if (type === 'intimate') targetDist = this.zones.intimate * 0.5;
                    else if (type === 'close' || type === 'pull') targetDist = this.zones.close * 0.5;
                    else if (type === 'intermediate') targetDist = this.zones.intermediate * 0.5;
                    else if (type === 'far' || type === 'push') targetDist = this.zones.far * 0.5;

                    if (targetDist !== null) {
                        // Spring force: F = k * (current - target)
                        // Vector (nx, ny) points from other TO p (ox/odist)

                        const nx = ox / odist;
                        const ny = oy / odist;

                        const displacement = odist - targetDist;
                        const force = displacement * springStrength;

                        // If displacement > 0 (too far), force > 0.
                        // We need to pull closer. 
                        // Current vector ox is (p - other). 
                        // To move p towards other (-ox direction), we subtract.

                        p.vx -= nx * force * step;
                        p.vy -= ny * force * step;
                    }
                }
            });

            // 3. Damping (friction)
            // Adjust damping for time step: pow(damping, step)
            // If step is 1 (16ms), damping is 0.9. If step is 0.5 (8ms effective), damping should be sqrt(0.9) approx
            const relativeDamping = Math.pow(this.damping, step);
            p.vx *= relativeDamping;
            p.vy *= relativeDamping;

            // Stop completely if very slow (to allow stillness)
            if (Math.abs(p.vx) < 0.05) p.vx = 0;
            if (Math.abs(p.vy) < 0.05) p.vy = 0;

            // Update pos
            p.x += p.vx * step;
            p.y += p.vy * step;

            // 4. Wall Boundaries (Soft bounce/Constraint)
            const margin = p.radius + 10;
            if (p.x < margin) { p.x = margin; p.vx *= -0.5; }
            if (p.x > this.canvas.width - margin) { p.x = this.canvas.width - margin; p.vx *= -0.5; }
            if (p.y < margin) { p.y = margin; p.vy *= -0.5; }
            if (p.y > this.canvas.height - margin) { p.y = this.canvas.height - margin; p.vy *= -0.5; }
        });
    }

    draw() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Draw Zones (Guides)
        this.ctx.beginPath();
        this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.05)';
        this.ctx.lineWidth = 1;

        // Intimate Zone
        this.ctx.arc(this.me?.x, this.me?.y, this.zones.intimate, 0, Math.PI * 2);
        this.ctx.stroke();

        this.ctx.beginPath();
        this.ctx.arc(this.me?.x, this.me?.y, this.zones.close, 0, Math.PI * 2);
        this.ctx.stroke();

        this.ctx.beginPath();
        this.ctx.arc(this.me?.x, this.me?.y, this.zones.intermediate, 0, Math.PI * 2);
        this.ctx.stroke();

        this.ctx.beginPath();
        this.ctx.arc(this.me?.x, this.me?.y, this.zones.far, 0, Math.PI * 2);
        this.ctx.stroke();

        // Draw Relations (Lines)
        this.people.forEach(p => {
            // 1. Draw line to ME (always exists implicitly)
            if (p.type !== 'me') {
                this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.15)'; // Increased opacity
                this.ctx.lineWidth = 1;
                this.ctx.beginPath();
                this.ctx.moveTo(this.me.x, this.me.y);
                this.ctx.lineTo(p.x, p.y);
                this.ctx.stroke();
            }

            // 2. Draw peer lines
            if (p.relationships) {
                Object.entries(p.relationships).forEach(([targetId, type]) => {
                    const target = this.people.find(t => t.id === targetId);
                    if (target && type !== 'neutral') {
                        this.ctx.beginPath();

                        // Style based on type
                        if (type === 'intimate') {
                            this.ctx.strokeStyle = '#db2777'; // Pink/Magenta
                            this.ctx.lineWidth = 3;
                            this.ctx.setLineDash([]);
                        } else if (type === 'close' || type === 'pull') {
                            this.ctx.strokeStyle = 'rgba(59, 130, 246, 0.4)'; // Blue
                            this.ctx.lineWidth = 2;
                            this.ctx.setLineDash([]);
                        } else if (type === 'intermediate') {
                            this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)'; // White/Grey
                            this.ctx.lineWidth = 1;
                            this.ctx.setLineDash([2, 4]); // Dotted
                        } else if (type === 'far' || type === 'push') {
                            this.ctx.strokeStyle = 'rgba(239, 68, 68, 0.4)'; // Red
                            this.ctx.lineWidth = 1;
                            this.ctx.setLineDash([5, 5]); // Dashed
                        }

                        this.ctx.moveTo(p.x, p.y);
                        this.ctx.lineTo(target.x, target.y);
                        this.ctx.stroke();
                        this.ctx.setLineDash([]);
                    }
                });
            }
        });

        // Draw Nodes
        this.people.forEach(p => {
            this.drawNode(p);
        });
    }

    drawNode(p) {
        const { x, y, radius = 7, color = '#fff', field, energy } = p;

        // Halo for selection
        if (p === this.hoveredPerson || p === this.draggedPerson) {
            this.ctx.beginPath();
            this.ctx.fillStyle = 'rgba(255, 255, 255, 0.2)';
            let r = radius + 6;
            this.ctx.arc(x, y, r, 0, Math.PI * 2);
            this.ctx.fill();
        }

        // Energy Indicator (Ring color)
        let ringColor = 'rgba(255,255,255,0.1)';
        if (energy === 'gives') ringColor = '#4ade80'; // green
        if (energy === 'costs') ringColor = '#f87171'; // red

        this.ctx.beginPath();
        this.ctx.strokeStyle = ringColor;
        this.ctx.lineWidth = 2;
        this.ctx.arc(x, y, radius + 3, 0, Math.PI * 2);
        this.ctx.stroke();

        // Main Body
        this.ctx.beginPath();
        this.ctx.fillStyle = color;
        this.ctx.arc(x, y, radius, 0, Math.PI * 2);
        this.ctx.fill();

        // Name Label
        this.ctx.fillStyle = '#fff';
        this.ctx.font = '500 11px Outfit';
        this.ctx.textAlign = 'center';
        this.ctx.fillText(p.name, x, y + radius + 15);
    }

    // Input Handling
    getMousePos(e) {
        const rect = this.canvas.getBoundingClientRect();
        return {
            x: e.clientX || e.pageX - rect.left,
            y: e.clientY || e.pageY - rect.top
        };
    }

    inputStart(e) {
        // e is either mouse event or touch object
        if (!e) return;

        const pos = this.getMousePos(e);
        const clicked = this.people.find(p => {
            const dx = p.x - pos.x;
            const dy = p.y - pos.y;
            // Increased hit area padding because nodes are small
            return Math.sqrt(dx * dx + dy * dy) < (p.radius || 7) + 15;
        });

        if (clicked) {
            if (clicked.type === 'me') return; // Cannot move Me
            this.isDragging = true;
            this.draggedPerson = clicked;
            this.dragStartNodeX = clicked.x;
            this.dragStartNodeY = clicked.y;
        }
    }

    inputMove(e) {
        if (!e) return;
        const pos = this.getMousePos(e);

        // Hover
        this.hoveredPerson = this.people.find(p => {
            const dx = p.x - pos.x;
            const dy = p.y - pos.y;
            return Math.sqrt(dx * dx + dy * dy) < (p.radius || 7) + 15;
        });

        if (this.canvas) {
            this.canvas.style.cursor = this.hoveredPerson ? 'pointer' : 'default';
        }

        if (this.isDragging && this.draggedPerson) {
            this.draggedPerson.x = pos.x;
            this.draggedPerson.y = pos.y;
            this.draggedPerson.vx = 0;
            this.draggedPerson.vy = 0;
        }
    }

    async inputEnd(e) {
        if (this.isDragging && this.draggedPerson) {
            // Check if we actually moved significantly
            const dx = this.draggedPerson.x - this.dragStartNodeX;
            const dy = this.draggedPerson.y - this.dragStartNodeY;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < 5) {
                // It was a click (tap)!
                this.openEditModal(this.draggedPerson);
            } else {
                // It was a drag, save the new position
                await this.db.savePerson(this.draggedPerson);
            }
        }

        this.isDragging = false;
        this.draggedPerson = null;
    }

    // UI Logic
    showAddPersonModal() {
        document.getElementById('editForm').reset();
        document.getElementById('editId').value = '';
        document.getElementById('deletePersonBtn').style.display = 'none';
        this.renderRelationshipList(); // Empty list for new person
        document.getElementById('editModal').classList.remove('hidden');
    }

    openEditModal(person) {
        const form = document.getElementById('editForm');
        form.editId.value = person.id;
        form.editName.value = person.name;
        // form.editSex.value = person.sex || 'female'; // REMOVED: Element doesn't exist in HTML
        form.editImportance.value = person.importance || 'intermediate';
        form.editField.value = person.field || 'other';
        form.editEnergy.value = person.energy || 'balance';
        form.editColor.value = person.color || '#ffffff';

        this.renderRelationshipList(person);

        document.getElementById('deletePersonBtn').style.display = 'block';
        document.getElementById('editModal').classList.remove('hidden');
    }

    renderRelationshipList(currentPerson = null) {
        const container = document.getElementById('relationshipList');
        container.innerHTML = '';

        // Filter out 'me' and current person
        const others = this.people.filter(p => p.type !== 'me' && (!currentPerson || p.id !== currentPerson.id));

        if (others.length === 0) {
            container.innerHTML = '<p class="empty-state">No other people to relate to yet.</p>';
            return;
        }

        others.forEach(other => {
            const row = document.createElement('div');
            row.className = 'relationship-item';

            // Current status
            let currentVal = 'neutral';
            if (currentPerson && currentPerson.relationships) {
                currentVal = currentPerson.relationships[other.id] || 'neutral';
            }

            row.innerHTML = `
                <span>${other.name}</span>
                <select name="rel_${other.id}">
                    <option value="neutral" ${currentVal === 'neutral' ? 'selected' : ''}>Neutral</option>
                    <option value="intimate" ${currentVal === 'intimate' ? 'selected' : ''}>Intimate 💜</option>
                    <option value="close" ${currentVal === 'close' || currentVal === 'pull' ? 'selected' : ''}>Close 🔵</option>
                    <option value="intermediate" ${currentVal === 'intermediate' ? 'selected' : ''}>Intermediate ⚪</option>
                    <option value="far" ${currentVal === 'far' || currentVal === 'push' ? 'selected' : ''}>Far 🔴</option>
                </select>
            `;
            container.appendChild(row);
        });
    }

    closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    async handleSavePerson(e) {
        e.preventDefault();
        const form = e.target;
        const id = form.editId.value;
        const isNew = !id;

        const person = isNew ? {
            id: crypto.randomUUID(),
            x: this.me.x + (Math.random() - 0.5) * 100,
            y: this.me.y + (Math.random() - 0.5) * 100,
            radius: 7, // Reduced from 20
            vx: 0,
            vy: 0,
            relationships: {}
        } : this.people.find(p => p.id === id);

        person.name = form.editName.value;
        // person.sex = form.editSex.value; // REMOVED
        person.importance = form.editImportance.value;
        person.field = form.editField.value;
        person.energy = form.editEnergy.value;
        person.color = form.editColor.value;

        // Save relationships
        if (!person.relationships) person.relationships = {};

        // Iterate over form elements to find relationship selects
        // We use querySelectorAll here which is safer than FormData logic in case of weird naming
        const selects = form.querySelectorAll('select[name^="rel_"]');
        selects.forEach(select => {
            const targetId = select.name.split('rel_')[1];
            person.relationships[targetId] = select.value;
        });

        await this.db.savePerson(person);

        if (isNew) {
            this.people.push(person);
            // Initial shake
            person.vx = (Math.random() - 0.5) * 5;
            person.vy = (Math.random() - 0.5) * 5;
        }

        // Auto update local physics array ref
        if (!isNew) {
            const idx = this.people.findIndex(p => p.id === id);
            if (idx >= 0) this.people[idx] = person;
        }

        this.closeModal();
    }

    async handleDeletePerson() {
        const id = document.getElementById('editId').value;
        if (id && confirm('Delete this person?')) {
            await this.db.deletePerson(id);
            this.people = this.people.filter(p => p.id !== id);
            this.closeModal();
        }
    }

    togglePause() {
        this.isPaused = !this.isPaused;
        const btn = document.getElementById('pauseBtn');
        if (this.isPaused) {
            btn.innerHTML = "Play ▶️";
            btn.classList.add('active-pause'); // Optional styling
        } else {
            btn.innerHTML = "Pause ⏸️";
            btn.classList.remove('active-pause');
        }
    }

    shake() {
        this.people.forEach(p => {
            if (p.type === 'me') return;
            // Randomize pos within screen
            p.x = Math.random() * this.canvas.width;
            p.y = Math.random() * this.canvas.height;
            p.vx = (Math.random() - 0.5) * 20;
            p.vy = (Math.random() - 0.5) * 20;
        });
    }

    changeSpeed(delta) {
        this.speedFactor += delta;
        // Clamp
        if (this.speedFactor < this.minSpeed) this.speedFactor = this.minSpeed;
        if (this.speedFactor > this.maxSpeed) this.speedFactor = this.maxSpeed;

        // Round to 1 decimal for clean display
        this.speedFactor = Math.round(this.speedFactor * 10) / 10;

        this.updateSpeedLabel();
    }

    updateSpeedLabel() {
        const label = document.getElementById('speedLabel');
        if (label) {
            label.textContent = Math.round(this.speedFactor * 100) + '%';
        }
    }
}

// Start app
const app = new SocialNetworkApp();
window.onload = () => app.init();
