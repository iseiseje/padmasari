@extends('layouts.app')

@section('title', 'Padmasari Chronicles | Tiga Lembaran Epik')
@section('full_page', true)

@section('content')
<!-- Tailwind & Custom Fonts / Neon Styles for Padmasari Chronicles -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700;800;900&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">

<style>
    .font-display { fontFamily: 'Orbitron', 'ui-sans-serif', 'system-ui', 'sans-serif' !important; }
    .font-sans { fontFamily: 'Rajdhani', 'ui-sans-serif', 'system-ui', 'sans-serif' !important; }

    /* Neon Lighting FX */
    .glow-novel-title { text-shadow: 0 0 15px #ff2a55, 0 0 32px #ff2a55, 0 0 55px #ff0055; }
    .glow-novel-sub { text-shadow: 0 0 10px #ff5e1e, 0 0 25px rgba(255, 94, 30, 0.8); }
    .btn-novel-glow { box-shadow: 0 0 22px rgba(255, 42, 85, 0.65), inset 0 0 12px rgba(255, 42, 85, 0.3); }
    .btn-novel-glow:hover { box-shadow: 0 0 38px #ff2a55, inset 0 0 20px #ff5e1e; text-shadow: 0 0 10px #ffffff, 0 0 20px #ff2a55; border-color: #ff2a55; }

    .glow-manuscript-title { text-shadow: 0 0 15px #ffb703, 0 0 32px #ffd166, 0 0 55px rgba(255, 183, 3, 0.85); }
    .glow-manuscript-sub { text-shadow: 0 0 12px #10b981, 0 0 25px rgba(16, 185, 129, 0.85); }
    .btn-manuscript-glow { box-shadow: 0 0 22px rgba(255, 183, 3, 0.6), inset 0 0 12px rgba(16, 185, 129, 0.3); }
    .btn-manuscript-glow:hover { box-shadow: 0 0 38px #ffb703, inset 0 0 20px #10b981; text-shadow: 0 0 10px #ffffff, 0 0 20px #ffb703; border-color: #ffb703; }

    .glow-drama-title { text-shadow: 0 0 15px #00f0ff, 0 0 32px #00f0ff, 0 0 55px rgba(0, 240, 255, 0.85); }
    .glow-drama-sub { text-shadow: 0 0 12px #c000ff, 0 0 28px rgba(192, 0, 255, 0.85); }
    .btn-drama-glow { box-shadow: 0 0 22px rgba(0, 240, 255, 0.6), inset 0 0 12px rgba(192, 0, 255, 0.3); }
    .btn-drama-glow:hover { box-shadow: 0 0 38px #00f0ff, inset 0 0 20px #c000ff; text-shadow: 0 0 10px #ffffff, 0 0 20px #00f0ff; border-color: #00f0ff; }

    .vignette-sheet {
      background: radial-gradient(circle at 50% 50%, transparent 20%, rgba(5, 5, 10, 0.6) 65%, rgba(5, 5, 10, 0.96) 100%),
                  linear-gradient(to top, rgba(5, 5, 10, 0.98) 0%, rgba(5, 5, 10, 0.45) 30%, transparent 60%, rgba(5, 5, 10, 0.85) 100%);
    }

    .writing-vertical { writing-mode: vertical-rl; transform: rotate(180deg); }
    .sheet-card { transition: flex 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.5s ease, filter 0.5s ease, border-color 0.5s ease; }
</style>

<!-- Safe JSON Data Script -->
<script id="story-data" type="application/json">
{
  "novel": {
    "title": @json($novelDoc['title'] ?? 'Padmasari Edisi Novel'),
    "content": @json($novelDoc['formatted_html'] ?? 'Isi cerita novel sedang dimuat...'),
    "url": "{{ route('documents.novel') }}"
  },
  "naskah": {
    "title": @json($naskahDoc['title'] ?? 'Padmasari Naskah Cerita'),
    "content": @json($naskahDoc['formatted_html'] ?? 'Isi naskah cerita sedang dimuat...'),
    "url": "{{ route('documents.naskah') }}"
  },
  "drama": {
    "title": @json($dramaDoc['title'] ?? 'Padmasari Pentas Drama'),
    "content": @json($dramaDoc['formatted_html'] ?? 'Isi dialog drama sedang dimuat...'),
    "url": "{{ route('documents.drama') }}"
  }
}
</script>

<div class="h-screen w-full overflow-hidden bg-[#05050a] text-white flex flex-col font-sans select-none antialiased" x-data="{ 
    activeModal: null, 
    modalTitle: '', 
    modalFormat: '', 
    modalContent: '',
    modalTheme: '',
    soundEnabled: true,
    bgmOscs: [],
    bgmGain: null,
    bgmPlaying: false,

    getAudioCtx() {
        if (!window.padmaAudioCtx) {
            window.padmaAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (window.padmaAudioCtx.state === 'suspended') {
            window.padmaAudioCtx.resume();
        }
        return window.padmaAudioCtx;
    },

    startBgm() {
        if (this.bgmPlaying || !this.soundEnabled) return;
        try {
            const ctx = this.getAudioCtx();
            const now = ctx.currentTime;

            this.bgmGain = ctx.createGain();
            this.bgmGain.gain.setValueAtTime(0.0001, now);
            this.bgmGain.gain.exponentialRampToValueAtTime(0.04, now + 1.5);

            // Ambient Pad Harmonics (Low A1 drone + E2 + A2 + C#3)
            const freqs = [55.00, 110.00, 164.81, 220.00, 277.18];
            this.bgmOscs = freqs.map((freq, i) => {
                const osc = ctx.createOscillator();
                const oscGain = ctx.createGain();

                osc.type = i === 0 ? 'sine' : (i % 2 === 0 ? 'triangle' : 'sine');
                osc.frequency.setValueAtTime(freq, now);

                // Slow breathing LFO modulation
                const lfo = ctx.createOscillator();
                lfo.frequency.setValueAtTime(0.08 + i * 0.03, now);
                const lfoGain = ctx.createGain();
                lfoGain.gain.setValueAtTime(freq * 0.012, now);
                lfo.connect(osc.frequency);
                lfo.start(now);

                oscGain.gain.setValueAtTime(i === 0 ? 0.35 : 0.15, now);
                osc.connect(oscGain);
                oscGain.connect(this.bgmGain);

                osc.start(now);
                return { osc, lfo, oscGain };
            });

            this.bgmGain.connect(ctx.destination);
            this.bgmPlaying = true;
        } catch(e) {
            console.error('BGM Error:', e);
        }
    },

    stopBgm() {
        if (!this.bgmPlaying || !this.bgmGain) return;
        try {
            const ctx = this.getAudioCtx();
            const now = ctx.currentTime;
            this.bgmGain.gain.exponentialRampToValueAtTime(0.0001, now + 0.8);
            setTimeout(() => {
                if (this.bgmOscs) {
                    this.bgmOscs.forEach(item => {
                        try { item.osc.stop(); item.lfo.stop(); } catch(e){}
                    });
                    this.bgmOscs = [];
                }
                this.bgmPlaying = false;
            }, 850);
        } catch(e) {
            this.bgmPlaying = false;
        }
    },

    setBgmTheme(type) {
        if (!this.soundEnabled) return;
        if (!this.bgmPlaying) {
            this.startBgm();
        }
        if (!this.bgmOscs || !this.bgmOscs.length) return;
        try {
            const ctx = this.getAudioCtx();
            const now = ctx.currentTime;
            let freqs = [55.00, 110.00, 164.81, 220.00, 277.18]; // Novel: Fiery A-Minor
            if (type === 'naskah') freqs = [73.42, 146.83, 220.00, 293.66, 369.99]; // Naskah: Sacred D-Pentatonic
            if (type === 'drama') freqs = [82.41, 164.81, 246.94, 329.63, 392.00]; // Drama: E-Minor Celestial

            this.bgmOscs.forEach((item, idx) => {
                if (freqs[idx]) {
                    item.osc.frequency.exponentialRampToValueAtTime(freqs[idx], now + 1.2);
                }
            });
        } catch(e){}
    },

    toggleSound() {
        this.soundEnabled = !this.soundEnabled;
        if (this.soundEnabled) {
            this.playClickSound();
            this.startBgm();
        } else {
            this.stopBgm();
        }
    },

    playClickSound() {
        if (!this.soundEnabled) return;
        try {
            const ctx = this.getAudioCtx();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(880, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(440, ctx.currentTime + 0.08);
            gain.gain.setValueAtTime(0.12, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.08);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.08);
        } catch(e) {}
    },

    playSheetSynth(type) {
        if (this.soundEnabled) {
            this.setBgmTheme(type);
        }
        if (!this.soundEnabled) return;
        try {
            const ctx = this.getAudioCtx();
            const now = ctx.currentTime;
            let freqs = [220.00, 329.63, 440.00]; // Novel: Fiery A-Minor Synth
            if (type === 'naskah') freqs = [392.00, 493.88, 587.33]; // Naskah: Emerald G-Major Sacred Bell
            if (type === 'drama') freqs = [440.00, 554.37, 659.25]; // Drama: Celestial Cyan Chord

            freqs.forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = i === 0 ? 'triangle' : 'sine';
                osc.frequency.setValueAtTime(freq, now + i * 0.03);
                osc.frequency.exponentialRampToValueAtTime(freq * 1.15, now + 0.25);
                gain.gain.setValueAtTime(0.1 / (i + 1), now + i * 0.03);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.35);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start(now + i * 0.03);
                osc.stop(now + 0.35);
            });
        } catch(e) {}
    },

    playModalSynth() {
        if (!this.soundEnabled) return;
        try {
            const ctx = this.getAudioCtx();
            const now = ctx.currentTime;
            const notes = [523.25, 659.25, 783.99, 1046.50]; // Ascending C Major Arpeggio
            notes.forEach((freq, idx) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, now + idx * 0.05);
                gain.gain.setValueAtTime(0.12, now + idx * 0.05);
                gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.05 + 0.35);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start(now + idx * 0.05);
                osc.stop(now + idx * 0.05 + 0.35);
            });
        } catch(e) {}
    },

    openFormatReader(type) {
        try {
            const rawData = JSON.parse(document.getElementById('story-data').textContent);
            const item = rawData[type];
            if (item) {
                this.modalFormat = type === 'novel' ? 'NOVEL' : (type === 'naskah' ? 'NASKAH CERITA' : 'DRAMA');
                this.modalTitle = item.title;
                this.modalTheme = type === 'naskah' ? 'manuscript' : type;
                this.modalContent = item.content;
                this.activeModal = type;
            }
        } catch(e) {
            console.error('Error loading story data:', e);
        }
        this.playModalSynth();
    },

    init() {
        window.playPadmaSheetSound = (type) => this.playSheetSynth(type);
        const startOnUserGesture = () => {
            if (this.soundEnabled && !this.bgmPlaying) {
                this.startBgm();
            }
            window.removeEventListener('click', startOnUserGesture);
        };
        window.addEventListener('click', startOnUserGesture, { once: true });
    }
}">

    <!-- BEGIN: TopNavigation -->
    <header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-4 backdrop-blur-md bg-[#05050a]/80 border-b border-white/10" data-purpose="site-navigation">
        <div class="flex items-center gap-3 cursor-pointer">
            <div class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_12px_#00f0ff]"></div>
            <span class="font-display font-black tracking-widest text-sm sm:text-base uppercase bg-gradient-to-r from-red-500 via-amber-400 to-cyan-400 bg-clip-text text-transparent">
                Padmasari Chronicles // Kedaulatan Perempuan
            </span>
        </div>

        <!-- Center Quick Switcher Tabs -->
        <nav class="hidden md:flex items-center gap-1.5 p-1 rounded-full border border-white/15 bg-black/60 backdrop-blur-md text-xs font-display tracking-widest">
            <button class="nav-tab px-4 py-1.5 rounded-full transition-all duration-300 text-red-500 bg-red-500/15 border border-red-500/40 shadow-[0_0_12px_rgba(255,42,85,0.4)]" data-sheet-target="0">
                NOVEL
            </button>
            <button class="nav-tab px-4 py-1.5 rounded-full transition-all duration-300 text-gray-400 hover:text-white border-transparent bg-transparent" data-sheet-target="1">
                NASKAH CERITA
            </button>
            <button class="nav-tab px-4 py-1.5 rounded-full transition-all duration-300 text-gray-400 hover:text-white border-transparent bg-transparent" data-sheet-target="2">
                DRAMA
            </button>
        </nav>

        <!-- Right Quick Actions -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="hidden lg:flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-white/20 text-xs font-display text-gray-300 hover:text-white hover:border-cyan-400 transition-colors">
                <i class="fa-solid fa-user-shield text-cyan-400 text-[10px]"></i> Admin
            </a>
            <button @click="toggleSound()" class="flex items-center gap-2 text-xs font-display tracking-wider border border-white/20 px-3 py-1.5 rounded-full hover:border-cyan-400 transition-colors duration-300 group" id="soundToggle">
                <span class="w-2 h-2 rounded-full transition-colors" :class="soundEnabled ? 'bg-cyan-400 shadow-[0_0_8px_#00f0ff]' : 'bg-red-500'"></span>
                <span class="text-gray-300 group-hover:text-white" x-text="soundEnabled ? 'BGM & SOUND: ON' : 'BGM & SOUND: OFF'">BGM &amp; SOUND: ON</span>
            </button>
        </div>
    </header>
    <!-- END: TopNavigation -->

    <!-- BEGIN: 3-Sheet Horizontal Accordion Layout -->
    <main class="relative flex-1 w-full h-screen min-h-[700px] flex flex-col md:flex-row overflow-hidden pt-16 bg-[#05050a]" data-purpose="sheet-accordion" id="sheetContainer">
        
        <!-- ================= SHEET 1: NOVEL (Phase 1, Fire Guardian) ================= -->
        <section class="sheet-card relative flex-[6] md:h-full border-b md:border-b-0 md:border-r border-red-500/30 overflow-hidden cursor-pointer group md:flex-[7]" data-sheet-index="0" id="sheetNovel">
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 bg-[#05050a]">
                    <img alt="Padmasari The Guardian - Edisi Novel" class="w-full h-full object-cover object-center scale-100 group-hover:scale-105 transition-transform duration-700 ease-out opacity-90" src="{{ asset('images/padmasari_novel.jpg') }}">
                </div>
                <div class="absolute inset-0 vignette-sheet opacity-80 pointer-events-none"></div>
                <div class="absolute inset-0 bg-red-500/10 mix-blend-color-dodge opacity-40 pointer-events-none"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#05050a] via-transparent to-[#05050a]/70 pointer-events-none"></div>
            </div>

            <!-- Active Content -->
            <div class="active-content relative z-20 h-full w-full flex flex-col justify-between p-6 sm:p-10 lg:p-14 transition-opacity duration-500 opacity-100">
                <div class="flex justify-start items-center">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/85 border border-red-500 shadow-[0_0_18px_rgba(255,42,85,0.6)] backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <span class="text-[11px] sm:text-xs font-display font-bold tracking-widest text-red-200 uppercase">EDISI NOVEL // MANIFESTO EMANSIPASI &amp; KEDAULATAN</span>
                    </div>
                </div>

                <div class="my-auto sm:my-0 sm:mt-auto sm:mb-8 text-center flex flex-col items-center justify-center pointer-events-none max-w-2xl mx-auto bg-black/85 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border-2 border-red-500/50 shadow-[0_0_35px_rgba(255,42,85,0.4)]">
                    <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl font-black uppercase tracking-wider text-[#ff2a55] glow-novel-title transition-all duration-500 drop-shadow-[0_4px_16px_rgba(0,0,0,1)]">
                        PADMASARI NOVEL
                    </h2>
                    <h3 class="font-display text-base sm:text-xl lg:text-2xl font-bold tracking-widest text-orange-400 glow-novel-sub mt-2 drop-shadow-[0_2px_8px_rgba(0,0,0,1)]">
                        - KRONIK API &amp; KEBERANIAN -
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-200 tracking-wider max-w-lg mt-3 drop-shadow-[0_2px_6px_rgba(0,0,0,1)] line-clamp-2 sm:line-clamp-none">
                        Kisah ksatria perempuan Padmasari yang meruntuhkan hegemoni patriarki feodal. Membangkitkan kobaran api leluhur untuk menegakkan kedaulatan takhta nusantara berlandaskan kesetaraan gender dan kepemimpinan mutlak perempuan pejuang.
                    </p>
                </div>

                <div class="flex items-center justify-center pb-2">
                    <button @click="openFormatReader('novel')" class="btn-novel-glow font-display px-10 py-3 rounded-full text-xs sm:text-sm font-bold tracking-widest uppercase text-white bg-black/85 border-2 border-red-500 hover:bg-red-500/20 transition-all duration-300 pointer-events-auto">
                        BACA NOVEL
                    </button>
                </div>
            </div>

            <!-- Collapsed Peek Ribbon -->
            <div class="collapsed-ribbon absolute inset-0 z-30 hidden flex-col justify-between items-center py-8 px-2 bg-black/75 backdrop-blur-md border-l border-red-500/30 pointer-events-none transition-opacity duration-300">
                <div class="w-8 h-8 rounded-full border border-red-500/60 flex items-center justify-center text-xs font-display font-bold text-red-500 shadow-[0_0_10px_#ff2a55]">
                    01
                </div>
                <div class="writing-vertical flex items-center gap-3">
                    <span class="font-display text-sm font-bold tracking-[0.25em] text-white uppercase group-hover:text-red-500 transition-colors">
                        PADMASARI NOVEL
                    </span>
                    <span class="text-[9px] font-mono tracking-widest text-red-400/80">KRONIK API</span>
                </div>
                <div class="w-1.5 h-6 rounded-full bg-red-500/60"></div>
            </div>
        </section>

        <!-- ================= SHEET 2: NASKAH CERITA (Phase 2, Manuscript / Scholar) ================= -->
        <section class="sheet-card relative flex-1 md:h-full border-b md:border-b-0 md:border-r border-amber-500/30 overflow-hidden cursor-pointer group opacity-75" data-sheet-index="1" id="sheetManuscript">
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 bg-[#05050a]">
                    <img alt="Padmasari The Storyteller - Naskah Cerita" class="w-full h-full object-cover object-center scale-100 group-hover:scale-105 transition-transform duration-700 ease-out opacity-90" src="{{ asset('images/padmasari_naskah.jpg') }}">
                </div>
                <div class="absolute inset-0 vignette-sheet opacity-80 pointer-events-none"></div>
                <div class="absolute inset-0 bg-amber-500/10 mix-blend-color-dodge opacity-40 pointer-events-none"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#05050a] via-transparent to-[#05050a]/70 pointer-events-none"></div>
            </div>

            <!-- Active Content -->
            <div class="active-content relative z-20 h-full w-full flex flex-col justify-between p-6 sm:p-10 lg:p-14 opacity-0 pointer-events-none transition-opacity duration-500">
                <div class="flex justify-start items-center">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/85 border border-amber-400 shadow-[0_0_18px_rgba(255,183,3,0.6)] backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        <span class="text-[11px] sm:text-xs font-display font-bold tracking-widest text-amber-200 uppercase">NASKAH KLASIK // SUARA KRITIS &amp; LITERASI EMANSIPATORI</span>
                    </div>
                </div>

                <div class="my-auto sm:my-0 sm:mt-auto sm:mb-8 text-center flex flex-col items-center justify-center pointer-events-none max-w-2xl mx-auto bg-black/85 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border-2 border-amber-400/50 shadow-[0_0_35px_rgba(255,183,3,0.4)]">
                    <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl font-black uppercase tracking-wider text-[#ffb703] glow-manuscript-title transition-all duration-500 drop-shadow-[0_4px_16px_rgba(0,0,0,1)]">
                        PADMASARI NASKAH CERITA
                    </h2>
                    <h3 class="font-display text-base sm:text-xl lg:text-2xl font-bold tracking-widest text-emerald-400 glow-manuscript-sub mt-2 drop-shadow-[0_2px_8px_rgba(0,0,0,1)]">- OTONOMI PIKIRAN, FILSAFAT &amp; ARSITEK PERADABAN -</h3>
                    <p class="text-xs sm:text-sm text-gray-200 tracking-wider max-w-lg mt-3 drop-shadow-[0_2px_6px_rgba(0,0,0,1)] line-clamp-2 sm:line-clamp-none">Mengungkap manuskrip dan suara perempuan Nusantara yang dibungkam sejarah feodal. Koleksi lontar sakral dan dialektika kritis yang memposisikan perempuan sebagai arsitek peradaban, pemilik hak bersuara setara, serta penentu arah kosmis.</p>
                </div>

                <div class="flex items-center justify-center pb-2">
                    <button @click="openFormatReader('naskah')" class="btn-manuscript-glow font-display px-10 py-3 rounded-full text-xs sm:text-sm font-bold tracking-widest uppercase text-white bg-black/85 border-2 border-amber-400 hover:bg-amber-400/20 transition-all duration-300 pointer-events-auto">
                        PELAJARI NASKAH
                    </button>
                </div>
            </div>

            <!-- Collapsed Peek Ribbon -->
            <div class="collapsed-ribbon absolute inset-0 z-30 flex flex-col justify-between items-center py-8 px-2 bg-black/75 backdrop-blur-md border-l border-amber-500/30 pointer-events-none transition-opacity duration-300">
                <div class="w-8 h-8 rounded-full border border-amber-400/60 flex items-center justify-center text-xs font-display font-bold text-amber-400 shadow-[0_0_10px_#ffb703]">
                    02
                </div>
                <div class="writing-vertical flex items-center gap-3">
                    <span class="font-display text-sm font-bold tracking-[0.25em] text-white uppercase group-hover:text-amber-400 transition-colors">
                        PADMASARI NASKAH CERITA
                    </span>
                    <span class="text-[9px] font-mono tracking-widest text-amber-300/80">EMANSIPASI LITERASI</span>
                </div>
                <div class="w-1.5 h-6 rounded-full bg-amber-400/60"></div>
            </div>
        </section>

        <!-- ================= SHEET 3: DRAMA (Phase 3, The Mystic & Celestial Performance) ================= -->
        <section class="sheet-card relative flex-1 md:h-full border-cyan-500/30 overflow-hidden cursor-pointer group opacity-75" data-sheet-index="2" id="sheetDrama">
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 bg-[#05050a]">
                    <img alt="Padmasari The Mystic - Pentas Drama" class="w-full h-full object-cover object-center scale-100 group-hover:scale-105 transition-transform duration-700 ease-out opacity-90" src="{{ asset('images/padmasari_drama.jpg') }}">
                </div>
                <div class="absolute inset-0 vignette-sheet opacity-80 pointer-events-none"></div>
                <div class="absolute inset-0 bg-cyan-400/10 mix-blend-color-dodge opacity-40 pointer-events-none"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#05050a] via-transparent to-[#05050a]/70 pointer-events-none"></div>
            </div>

            <!-- Active Content -->
            <div class="active-content relative z-20 h-full w-full flex flex-col justify-between p-6 sm:p-10 lg:p-14 opacity-0 pointer-events-none transition-opacity duration-500">
                <div class="flex justify-start items-center">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/85 border border-cyan-400 shadow-[0_0_18px_rgba(0,240,255,0.6)] backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                        <span class="text-[11px] sm:text-xs font-display font-bold tracking-widest text-cyan-200 uppercase">TEATER MISTIK // ARTIKULASI PERLAWANAN SUBORDINASI</span>
                    </div>
                </div>

                <div class="my-auto sm:my-0 sm:mt-auto sm:mb-8 text-center flex flex-col items-center justify-center pointer-events-none max-w-2xl mx-auto bg-black/85 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border-2 border-cyan-400/50 shadow-[0_0_35px_rgba(0,240,255,0.4)]">
                    <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl font-black uppercase tracking-wider text-cyan-400 glow-drama-title transition-all duration-500 drop-shadow-[0_4px_16px_rgba(0,0,0,1)]">
                        PADMASARI DRAMA
                    </h2>
                    <h3 class="font-display text-base sm:text-xl lg:text-2xl font-bold tracking-widest text-purple-400 glow-drama-sub mt-2 drop-shadow-[0_2px_8px_rgba(0,0,0,1)]">
                        - SENI PERTUNJUKAN &amp; TARI CELESTIAL -
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-200 tracking-wider max-w-lg mt-3 drop-shadow-[0_2px_6px_rgba(0,0,0,1)] line-clamp-2 sm:line-clamp-none">Pentas teater revolusioner sebagai medium katarsis menumbangkan relasi kuasa timpang. Menampilkan estetika sakral koreografi wayang kosmik dan kekuatan spiritual perempuan berdaulat yang menolak tunduk pada subordinasi patriarkal.</p>
                </div>

                <div class="flex items-center justify-center pb-2">
                    <button @click="openFormatReader('drama')" class="btn-drama-glow font-display px-10 py-3 rounded-full text-xs sm:text-sm font-bold tracking-widest uppercase text-white bg-black/85 border-2 border-cyan-400 hover:bg-cyan-400/20 transition-all duration-300 pointer-events-auto">
                        BACA DRAMA
                    </button>
                </div>
            </div>

            <!-- Collapsed Peek Ribbon -->
            <div class="collapsed-ribbon absolute inset-0 z-30 flex flex-col justify-between items-center py-8 px-2 bg-black/75 backdrop-blur-md border-l border-cyan-500/30 pointer-events-none transition-opacity duration-300">
                <div class="w-8 h-8 rounded-full border border-cyan-400/60 flex items-center justify-center text-xs font-display font-bold text-cyan-400 shadow-[0_0_10px_#00f0ff]">
                    03
                </div>
                <div class="writing-vertical flex items-center gap-3">
                    <span class="font-display text-sm font-bold tracking-[0.25em] text-white uppercase group-hover:text-cyan-400 transition-colors">
                        PADMASARI DRAMA
                    </span>
                    <span class="text-[9px] font-mono tracking-widest text-cyan-300/80">SUARA PERLAWANAN</span>
                </div>
                <div class="w-1.5 h-6 rounded-full bg-cyan-400/60"></div>
            </div>
        </section>
    </main>
    <!-- END: 3-Sheet Horizontal Accordion Layout -->

    <!-- Interactive Format Reader Modal / Slide-Over -->
    <div x-show="activeModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-xl" style="display: none;">
        <div class="relative w-full max-w-4xl max-h-[90vh] bg-[#090a10] rounded-3xl border shadow-2xl flex flex-col overflow-hidden" 
             :class="{
                'border-red-500/50 shadow-[0_0_35px_rgba(255,42,85,0.3)]': modalTheme === 'novel',
                'border-amber-400/50 shadow-[0_0_35px_rgba(255,183,3,0.3)]': modalTheme === 'manuscript',
                'border-cyan-400/50 shadow-[0_0_35px_rgba(0,240,255,0.3)]': modalTheme === 'drama'
             }">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between bg-black/60">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-display font-bold tracking-widest uppercase"
                          :class="{
                            'bg-red-500/20 text-red-400 border border-red-500/40': modalTheme === 'novel',
                            'bg-amber-400/20 text-amber-300 border border-amber-400/40': modalTheme === 'manuscript',
                            'bg-cyan-400/20 text-cyan-300 border border-cyan-400/40': modalTheme === 'drama'
                          }"
                          x-text="modalFormat">
                    </span>
                    <h3 class="font-display font-extrabold text-base sm:text-lg text-white truncate max-w-md" x-text="modalTitle"></h3>
                </div>
                <button @click="activeModal = null" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Modal Body Content -->
            <div class="p-6 sm:p-10 overflow-y-auto space-y-6 text-gray-200 text-sm sm:text-base leading-relaxed font-sans" x-html="modalContent">
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-white/10 bg-black/60 flex flex-wrap items-center justify-between gap-4">
                <div class="text-xs font-mono text-gray-400 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-cyan-400"></i>
                    <span>PADMASARI AI FILOLOGI ENGINE</span>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="activeModal === 'novel' ? '{{ route('documents.novel') }}' : (activeModal === 'naskah' ? '{{ route('documents.naskah') }}' : '{{ route('documents.drama') }}')" class="px-5 py-2 rounded-full text-xs font-display font-bold text-white bg-white/10 hover:bg-white/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-book-open text-amber-400"></i> Buka Halaman Dokumen Penuh
                    </a>
                    <button @click="activeModal = null" class="px-6 py-2 rounded-full text-xs font-display font-bold text-black bg-white hover:bg-gray-200 transition-all">
                        Tutup Viewer
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- BEGIN: InteractiveScripts -->
<script data-purpose="sheet-accordion-logic">
  document.addEventListener('DOMContentLoaded', () => {
    const sheets = document.querySelectorAll('.sheet-card');
    const navTabs = document.querySelectorAll('.nav-tab');
    let currentIndex = 0;

    const navThemeClasses = [
      {
        active: ['text-red-500', 'bg-red-500/15', 'border', 'border-red-500/40', 'shadow-[0_0_12px_rgba(255,42,85,0.4)]'],
        inactive: ['text-gray-400', 'hover:text-white', 'border-transparent', 'bg-transparent']
      },
      {
        active: ['text-amber-400', 'bg-amber-400/15', 'border', 'border-amber-400/40', 'shadow-[0_0_12px_rgba(255,183,3,0.4)]'],
        inactive: ['text-gray-400', 'hover:text-white', 'border-transparent', 'bg-transparent']
      },
      {
        active: ['text-cyan-400', 'bg-cyan-400/15', 'border', 'border-cyan-400/40', 'shadow-[0_0_12px_rgba(0,240,255,0.4)]'],
        inactive: ['text-gray-400', 'hover:text-white', 'border-transparent', 'bg-transparent']
      }
    ];

    const sheetTypes = ['novel', 'naskah', 'drama'];

    function activateSheet(targetIdx, userTriggered = false) {
      if (targetIdx < 0 || targetIdx >= sheets.length) return;
      currentIndex = targetIdx;

      if (userTriggered && window.playPadmaSheetSound) {
        window.playPadmaSheetSound(sheetTypes[targetIdx]);
      }

      sheets.forEach((sheet, idx) => {
        const activeContent = sheet.querySelector('.active-content');
        const collapsedRibbon = sheet.querySelector('.collapsed-ribbon');

        if (idx === targetIdx) {
          sheet.classList.remove('flex-1');
          sheet.classList.add('flex-[6]', 'md:flex-[7]');
          sheet.classList.remove('opacity-60', 'grayscale-[35%]');

          if (activeContent) {
            activeContent.classList.remove('opacity-0', 'pointer-events-none');
            activeContent.classList.add('opacity-100');
          }
          if (collapsedRibbon) {
            collapsedRibbon.classList.add('hidden');
            collapsedRibbon.classList.remove('flex');
          }
        } else {
          sheet.classList.remove('flex-[6]', 'md:flex-[7]');
          sheet.classList.add('flex-1');
          sheet.classList.add('opacity-75');

          if (activeContent) {
            activeContent.classList.add('opacity-0', 'pointer-events-none');
            activeContent.classList.remove('opacity-100');
          }
          if (collapsedRibbon) {
            collapsedRibbon.classList.remove('hidden');
            collapsedRibbon.classList.add('flex');
          }
        }
      });

      // Update Nav Tabs
      navTabs.forEach((tab, idx) => {
        const conf = navThemeClasses[idx];
        if (idx === targetIdx) {
          tab.classList.remove(...conf.inactive);
          tab.classList.add(...conf.active);
        } else {
          tab.classList.remove(...conf.active);
          tab.classList.add(...conf.inactive);
        }
      });
    }

    sheets.forEach((sheet, idx) => {
      sheet.addEventListener('click', () => {
        activateSheet(idx, true);
      });
    });

    navTabs.forEach((tab) => {
      tab.addEventListener('click', (e) => {
        e.stopPropagation();
        const target = parseInt(tab.getAttribute('data-sheet-target'), 10);
        activateSheet(target, true);
      });
    });

    activateSheet(0, false);
  });
</script>
<!-- END: InteractiveScripts -->
@endsection
