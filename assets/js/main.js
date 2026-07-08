document.addEventListener('DOMContentLoaded', () => {
    if (window.AOS) {
        AOS.init({ duration: 700, once: true, offset: 80 });
    }

    document.querySelectorAll('.btn-ripple').forEach((button) => {
        button.addEventListener('click', (event) => {
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;
            const rect = button.getBoundingClientRect();

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - rect.left - radius}px`;
            circle.style.top = `${event.clientY - rect.top - radius}px`;
            circle.classList.add('ripple');

            const ripple = button.querySelector('.ripple');
            if (ripple) ripple.remove();

            button.appendChild(circle);
        });
    });

    initVotingPage();
    initDashboard();
});

function initVotingPage() {
    const form = document.querySelector('[data-vote-form]');
    if (!form) return;

    const cards = document.querySelectorAll('[data-candidate-card]');
    const chosenInput = document.querySelector('[name="candidate_id"]');
    const chooseButton = document.querySelector('[data-open-confirm]');
    const modal = document.querySelector('[data-confirm-modal]');
    const closeButtons = document.querySelectorAll('[data-close-confirm]');
    const candidateName = document.querySelector('[data-confirm-name]');

    cards.forEach((card) => {
        card.addEventListener('click', () => {
            cards.forEach((item) => item.classList.remove('is-selected'));
            card.classList.add('is-selected');
            chosenInput.value = card.dataset.candidateId;
            chooseButton.disabled = false;
            chooseButton.classList.remove('opacity-50', 'cursor-not-allowed');
            candidateName.textContent = card.dataset.candidateName;
        });
    });

    chooseButton.addEventListener('click', () => {
        if (!chosenInput.value) return;
        modal.classList.add('is-open');
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', () => modal.classList.remove('is-open'));
    });
}

function initDashboard() {
    const dashboard = document.querySelector('[data-admin-dashboard]');
    if (!dashboard) return;

    const canvas = document.querySelector('#voteChart');
    const context = canvas.getContext('2d');

    async function loadStats() {
        try {
            const response = await fetch('../api/stats.php', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            });

            if (!response.ok) throw new Error('Gagal mengambil data.');

            const data = await response.json();
            renderStats(data);
            drawChart(context, canvas, data.candidates);
        } catch (error) {
            const status = document.querySelector('[data-refresh-status]');
            if (status) status.textContent = 'Data belum bisa diperbarui.';
        }
    }

    function renderStats(data) {
        setText('[data-total-voters]', data.total_voters);
        setText('[data-voted]', data.voted);
        setText('[data-not-voted]', data.not_voted);
        setText('[data-participation]', `${data.participation}%`);
        setText('[data-refresh-status]', `Diperbarui ${data.updated_at}`);

        const list = document.querySelector('[data-candidate-results]');
        list.innerHTML = '';

        data.candidates.forEach((candidate) => {
            const item = document.createElement('div');
            item.className = 'rounded-2xl bg-white p-5 text-slate-900 shadow-lg';
            item.innerHTML = `
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Nomor ${candidate.number}</p>
                        <h3 class="text-lg font-bold">${escapeHtml(candidate.chair_name)} & ${escapeHtml(candidate.vice_name)}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-black text-[#07172f]">${candidate.total_votes}</p>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">suara</p>
                    </div>
                </div>
                <div class="mt-4 h-3 overflow-hidden rounded-full progress-track">
                    <div class="h-full rounded-full progress-fill" style="width: ${candidate.percentage}%"></div>
                </div>
                <p class="mt-2 text-sm font-semibold text-slate-600">${candidate.percentage}% dari suara masuk</p>
            `;
            list.appendChild(item);
        });
    }

    loadStats();
    setInterval(loadStats, 5000);
}

function setText(selector, value) {
    const element = document.querySelector(selector);
    if (element) element.textContent = value;
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

function drawChart(context, canvas, candidates) {
    const dpr = window.devicePixelRatio || 1;
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width * dpr;
    canvas.height = rect.height * dpr;
    context.setTransform(dpr, 0, 0, dpr, 0, 0);
    context.clearRect(0, 0, rect.width, rect.height);

    const total = candidates.reduce((sum, candidate) => sum + Number(candidate.total_votes), 0) || 1;
    const colors = ['#54d6ff', '#f6c85f', '#8bffb0'];
    let start = -Math.PI / 2;
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    const radius = Math.min(rect.width, rect.height) * 0.34;

    candidates.forEach((candidate, index) => {
        const slice = (Number(candidate.total_votes) / total) * Math.PI * 2;
        context.beginPath();
        context.moveTo(centerX, centerY);
        context.arc(centerX, centerY, radius, start, start + slice);
        context.closePath();
        context.fillStyle = colors[index % colors.length];
        context.fill();
        start += slice;
    });

    context.beginPath();
    context.arc(centerX, centerY, radius * 0.58, 0, Math.PI * 2);
    context.fillStyle = '#ffffff';
    context.fill();

    context.fillStyle = '#07172f';
    context.font = '700 22px Poppins, sans-serif';
    context.textAlign = 'center';
    context.fillText(String(total), centerX, centerY - 4);
    context.font = '600 12px Poppins, sans-serif';
    context.fillStyle = '#64748b';
    context.fillText('Suara Masuk', centerX, centerY + 18);
}
