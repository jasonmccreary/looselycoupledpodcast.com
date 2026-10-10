// Enhances <podcast-player src="" title="" episode="" duration=""> with a custom audio player.
// The <audio> child is the no-JavaScript fallback.
// Must run at load: document.currentScript is null afterwards.
const coverUrl = new URL('../../img/basecode-cover-small.jpg', document.currentScript.src).href;

const SPEEDS = [1, 1.25, 1.5, 1.75, 2, 0.75];
const players = [];

const icons = {
    play: '<svg viewBox="0 0 24 24"><path d="M8 5.5v13a1 1 0 0 0 1.5.86l11-6.5a1 1 0 0 0 0-1.72l-11-6.5A1 1 0 0 0 8 5.5z"/></svg>',
    pause: '<svg viewBox="0 0 24 24"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>',
    back: '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 6a10 10 0 1 1-10 10"/><path d="M16 1.5 11 6l5 4.5"/><text x="16" y="20.5" text-anchor="middle" font-size="9" font-weight="500" fill="currentColor" stroke="none" font-family="monospace">10</text></svg>',
    forward: '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 6a10 10 0 1 0 10 10"/><path d="M16 1.5 21 6l-5 4.5"/><text x="16" y="20.5" text-anchor="middle" font-size="9" font-weight="500" fill="currentColor" stroke="none" font-family="monospace">30</text></svg>',
    volume: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 9.5v5h3.5l5 4v-13l-5 4z"/><path d="M16 9a4 4 0 0 1 0 6"/><path d="M18.5 6.5a8 8 0 0 1 0 11"/></svg>',
    muted: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 9.5v5h3.5l5 4v-13l-5 4z"/><path d="M16.5 9.5l5 5M21.5 9.5l-5 5"/></svg>',
};

const css = `
    :host { display: block; margin: 1rem 0; }
    * { box-sizing: border-box; }
    .card { display: flex; background: #fff; color: #4a5568; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif; }
    .cover { flex: none; width: 170px; object-fit: cover; background: #f5f5f5; }
    .body { flex: 1; min-width: 0; padding: 16px 20px; }
    .meta { margin: 0; font-size: 12px; letter-spacing: .06em; text-transform: uppercase; color: #8a94a6; }
    .title { margin: 4px 0 14px; font-size: 20px; line-height: 1.25; font-weight: 600; color: #4a5568; }
    .main { display: grid; grid-template-columns: auto minmax(0, 1fr); column-gap: 14px; row-gap: 6px; align-items: center; }
    button { font: inherit; color: inherit; background: none; border: 0; padding: 0; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
    button:focus-visible, input:focus-visible { outline: 2px solid #ed8936; outline-offset: 2px; }
    .play { grid-row: span 2; width: 52px; height: 52px; border-radius: 50%; background: #5f6b7e; color: #fff; }
    .play:hover { background: #4a5568; }
    .play svg { width: 24px; height: 24px; fill: currentColor; }
    .controls { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; color: #8a94a6; }
    .controls svg { width: 26px; height: 26px; }
    .controls button:hover { color: #4a5568; }
    .speed { min-width: 38px; height: 26px; border: 2px solid #8a94a6; border-radius: 5px; font: 500 11px monospace; text-transform: uppercase; }
    .time { margin-left: auto; font: 13px ui-monospace, SFMono-Regular, Menlo, monospace; color: #8a94a6; white-space: nowrap; }
    .time b { font-weight: 400; }
    .time span { padding: 0 4px; color: #cbd5e0; }
    input[type=range] { -webkit-appearance: none; appearance: none; width: 100%; height: 12px; margin: 0; border-radius: 6px; cursor: pointer; background: linear-gradient(to right, #8a94a6 var(--pct, 0%), #e8ecf1 var(--pct, 0%)); }
    input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; width: 0; height: 0; }
    input[type=range]::-moz-range-thumb { width: 0; height: 0; border: 0; }
    @media (max-width: 480px) {
        .cover { width: 84px; }
        .body { padding: 12px; }
        .title { font-size: 16px; margin-bottom: 10px; }
        .play { width: 44px; height: 44px; }
        .controls { gap: 8px; }
        .controls svg { width: 22px; height: 22px; }
    }
`;

const format = (seconds) => {
    if (!isFinite(seconds)) return '00:00';
    const s = Math.floor(seconds);
    const h = Math.floor(s / 3600);
    const m = String(Math.floor((s % 3600) / 60)).padStart(h ? 2 : 2, '0');
    return `${h ? h + ':' : ''}${m}:${String(s % 60).padStart(2, '0')}`;
};

const el = (html) => {
    const template = document.createElement('template');
    template.innerHTML = html.trim();
    return template.content.firstChild;
};

const init = (host) => {
    const fallback = host.querySelector('audio');
    const src = host.getAttribute('src') || (fallback && fallback.getAttribute('src'));
    if (!src) return;

    const title = host.getAttribute('title') || '';
    const episode = host.getAttribute('episode');
    const cover = host.getAttribute('cover') || coverUrl;
    const knownDuration = parseFloat(host.getAttribute('duration')) || 0;

    const audio = new Audio();
    audio.preload = 'none';
    audio.src = src;
    players.push(audio);

    const root = host.attachShadow({ mode: 'open' });
    const meta = ['The BaseCode Podcast', episode ? `Episode ${episode}` : ''].filter(Boolean).join(' • ');
    root.innerHTML = `
        <style>${css}</style>
        <div class="card">
            ${cover ? `<img class="cover" alt="" src="${cover}">` : ''}
            <div class="body">
                <p class="meta"></p>
                <h3 class="title"></h3>
                <div class="main">
                    <button class="play" aria-label="Play">${icons.play}</button>
                    <input class="seek" type="range" min="0" max="${knownDuration || 100}" step="1" value="0" aria-label="Seek">
                    <div class="controls">
                        <button class="back" aria-label="Back 10 seconds">${icons.back}</button>
                        <button class="speed" aria-label="Playback speed">1x</button>
                        <button class="forward" aria-label="Forward 30 seconds">${icons.forward}</button>
                        <button class="mute" aria-label="Mute">${icons.volume}</button>
                        <div class="time"><b class="current">00:00</b><span>|</span><b class="total">${format(knownDuration)}</b></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    const $ = (selector) => root.querySelector(selector);
    $('.meta').textContent = meta;
    $('.title').textContent = title;

    const play = $('.play');
    const seek = $('.seek');
    const total = $('.total');
    let seeking = false;
    let speed = 0;

    const duration = () => audio.duration || knownDuration;
    const paint = () => {
        const d = duration();
        seek.max = d || 100;
        if (!seeking) seek.value = audio.currentTime;
        seek.style.setProperty('--pct', d ? `${(seek.value / d) * 100}%` : '0%');
        $('.current').textContent = format(seeking ? seek.value : audio.currentTime);
        total.textContent = format(d);
    };

    play.addEventListener('click', () => {
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    });
    audio.addEventListener('play', () => {
        players.forEach((other) => other !== audio && other.pause());
        play.innerHTML = icons.pause;
        play.setAttribute('aria-label', 'Pause');
    });
    audio.addEventListener('pause', () => {
        play.innerHTML = icons.play;
        play.setAttribute('aria-label', 'Play');
    });
    ['timeupdate', 'loadedmetadata', 'durationchange'].forEach((name) => audio.addEventListener(name, paint));

    seek.addEventListener('input', () => {
        seeking = true;
        paint();
    });
    seek.addEventListener('change', () => {
        audio.currentTime = seek.value;
        seeking = false;
        paint();
    });

    const skip = (seconds) => {
        audio.currentTime = Math.max(0, Math.min(duration() || Infinity, audio.currentTime + seconds));
    };
    $('.back').addEventListener('click', () => skip(-10));
    $('.forward').addEventListener('click', () => skip(30));
    $('.speed').addEventListener('click', (event) => {
        speed = (speed + 1) % SPEEDS.length;
        audio.playbackRate = SPEEDS[speed];
        event.currentTarget.textContent = `${SPEEDS[speed]}x`;
    });
    $('.mute').addEventListener('click', (event) => {
        audio.muted = !audio.muted;
        event.currentTarget.innerHTML = audio.muted ? icons.muted : icons.volume;
        event.currentTarget.setAttribute('aria-label', audio.muted ? 'Unmute' : 'Mute');
    });

    if (fallback) fallback.remove();
    paint();
};

document.querySelectorAll('podcast-player').forEach(init);
