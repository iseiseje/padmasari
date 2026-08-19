<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\MasterNarrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoryGeneratorController extends Controller
{
    public function index()
    {
        $recentStories = Story::latest()->take(6)->get();
        $masterNarrative = MasterNarrative::getActive();
        $hasApiKey = !empty(env('GEMINI_API_KEY'));
        return view('story_generator.index', compact('recentStories', 'masterNarrative', 'hasApiKey'));
    }

    public function generate(Request $request)
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'Hanya Admin yang dapat mempublikasikan dan membuat cerita AI baru.');
        }

        $request->validate([
            'prompt' => 'required|string|min:5',
            'theme' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'moral_lesson' => 'nullable|string',
        ]);

        $masterNarrative = MasterNarrative::getActive();
        $prompt = $request->input('prompt');
        $selectedTheme = $request->input('theme', 'Cyberpunk (Distopia Megakorporat Neo-Nusantara)');
        $targetAudience = $request->input('target_audience', 'Umum');
        $moralLesson = $request->input('moral_lesson', 'Kecerdikan dan ketulusan niat mengalahkan keserakahan.');

        $apiKey = env('GEMINI_API_KEY');
        $generatedContent = null;

        // If Gemini API Key is configured in .env, invoke real Gemini AI API
        if (!empty($apiKey)) {
            try {
                $systemInstruction = $masterNarrative->system_prompt . "\n\n[CERITA MASTER TERKUNCI / NASKAH ACUAN UTAMA]:\n" . $masterNarrative->master_content . "\n\n[ATURAN FILOLOGI & BATASAN ADAPTASI]:\n" . $masterNarrative->world_rules;
                
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "{$systemInstruction}\n\n[PARAMETER ADAPTASI ADMIN]:\n- Tema/Genre Adaptasi: {$selectedTheme}\n- Topik Acuan Master: {$masterNarrative->core_topic}\n- Fokus Adegan/Faset Cerita: {$prompt}\n- Target Pembaca: {$targetAudience}\n- Penekanan Moral: {$moralLesson}\n\nINSTRUKSI TEMA & GENRE DENGAN ALUR KHUSUS:\nSilakan adaptasi naskah master di atas ke dalam genre '{$selectedTheme}'. Pastikan tokoh utama (Padmasari & suaminya Urumaskara) menggunakan siasat spesifik sesuai genre (misal: smart-nano paint & hologram Malaikat Digital untuk Cyberpunk; upgrade software ilegal & System Destroyer untuk Sci-Fi Android; jelaga batu bara & Automaton robot uap untuk Steampunk; atau debu radioaktif bersinar & scrap armor mutan untuk Post-Apocalyptic).\n\nTulis cerita secara PANJANG, LENGKAP, dan MENDALAM (5-7 babak terperinci)."]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 8192,
                        'temperature' => 0.7,
                    ]
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
                        $generatedContent = $json['candidates'][0]['content']['parts'][0]['text'];
                    }
                } else {
                    Log::warning('Gemini API request failed: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('Gemini API exception: ' . $e->getMessage());
            }
        }

        // Fallback Philology AI Engine if API Key is not set or request fails
        if (empty($generatedContent)) {
            $masterTitle = $masterNarrative->title ?? 'Naskah Master Sastra';
            $baseNarrativeText = trim($masterNarrative->master_content);
            $worldRulesText = trim($masterNarrative->world_rules);

            if (str_contains(strtolower($selectedTheme), 'cyberpunk')) {
                $generatedTitle = 'Cyberpunk Neo-Nusantara: Peretasan Hologram Malaikat Digital';
                $generatedContent = "## {$generatedTitle}\n\n" .
                    "**Tema/Genre**: Cyberpunk (Distopia Megakorporat Neo-Nusantara)\n" .
                    "**Naskah Acuan Master**: {$masterTitle}\n" .
                    "**Fokus Adegan**: {$prompt}\n" .
                    "**Pesan Moral**: \"{$moralLesson}\"\n\n" .
                    "---\n\n" .
                    "### [Bab I: Megakota Neo-Nusantara & Tuntutan Megakorporat]\n" .
                    "Di bawah naungan bayang-bayang pencakar langit yang dipenuhi lampu neon menyengat di Megakota Neo-Nusantara, Padmasari bekerja sebagai ahli peretas kode independen di bengkel siberik kumuh. Suaminya, Urumaskara, adalah seorang teknisi perangkat keras (hardware) kelas bawah. Konflik bermula ketika para pejabat eksekutif Megakorporat korup bermaksud 'membeli' keahlian Padmasari menggunakan crypto-credits melimpah dan janji implan siberitik mewah.\n\n" .
                    "### [Bab II: Penolakan Niat Buruk & Siasat Smart-Nano Paint]\n" .
                    "Menolak diperbudak oleh oligarki megakorporat, Padmasari menyusun siasat cerdik. Alih-alih menerima perhiasan siberitik, ia mengoleskan *smart-nano paint* (cat nano pintar ber-virus biometrik) pada bagian tubuh dan pakaian para eksekutif korup dengan dalih 'ritual aktivasi sertifikat siberik'. Tanpa menyadari jebakan tersebut, para pejabat merasa telah memenangkan kesepakatan.\n\n" .
                    "### [Bab III: Peretasan Hologram Malaikat Digital di Apartemen]\n" .
                    "Saat para eksekutif korup mendatangi apartemen Padmasari secara paksa, Urumaskara yang bersembunyi di jaringan kontrol utama segera meretas sistem lampu dan proyeksi ruangan. Suara statis memekakkan telinga menggelegar dari speaker ruangan, bersamaan dengan kemunculan hologram raksasa \"Malaikat Digital\" (Security AI tingkat tinggi) dengan mata berkilat merah yang mengancam membumihanguskan chip memori mereka.\n\n" .
                    "### [Bab IV: Kepanikan Megakorporat & Jejak Nano yang Bersinar]\n" .
                    "Ketakutan setengah mati oleh gertakan hologram Malaikat Digital buatan Urumaskara, para pejabat eksekutif lari terbirit-birit menembus lorong apartemen. *Smart-nano paint* di wajah mereka memancarkan cahaya neon mencolok di tempat umum, menyiarkan bukti kecurangan dan rasa malu mereka secara langsung ke seluruh kanal jaringan media Megakota.\n\n" .
                    "### [Bab V: Kemenangan Integritas & Pesan Filosofis]\n" .
                    "Padmasari dan Urumaskara tersenyum lega di balik layar monitor bengkel mereka. Keberanian dan kecerdikan teknologi telah menumbangkan keserakahan megakorporat. Naskah ini mengabadikan amanat bahwa kebenaran dan ketulusan niat akan selalu menemukan cara untuk meretas kegelapan penindasan.";
            } elseif (str_contains(strtolower($selectedTheme), 'sci-fi') || str_contains(strtolower($selectedTheme), 'android')) {
                $generatedTitle = 'Era Sintetis: System Destroyer di Stasiun Luar Angkasa';
                $generatedContent = "## {$generatedTitle}\n\n" .
                    "**Tema/Genre**: Sci-Fi Android (Era Sintetis)\n" .
                    "**Naskah Acuan Master**: {$masterTitle}\n" .
                    "**Fokus Adegan**: {$prompt}\n" .
                    "**Pesan Moral**: \"{$moralLesson}\"\n\n" .
                    "---\n\n" .
                    "### [Bab I: Stasiun Luar Angkasa & Eksploitasi Android Elit]\n" .
                    "Di batas ruang angkasa di mana batas antara manusia dan mesin Android mulai kabur, para penguasa Cyborg elit bertindak dengan otoritas absolut. Padmasari dan Urumaskara adalah pekerja perawatan teknis kelas bawah di koloni planet yang senantiasa dieksploitasi oleh para Android penguasa.\n\n" .
                    "### [Bab II: Siasat Upgrade Perangkat Lunak Ilegal]\n" .
                    "Menghadapi ancaman eksploitasi, Padmasari secara cerdik menawarkan 'Upgrade Perangkat Lunak Ilegal' yang dijanjikan dapat meningkatkan daya komputasi para Android elit. Penasaran akan janji kekuatan tambahan, para Android penguasa mengunduh berkas modifikasi tersebut langsung ke dalam sistem optik utama mereka.\n\n" .
                    "### [Bab III: Manifestasi Proyeksi Visual System Destroyer]\n" .
                    "Begitu proses pengunduhan selesai, virus visual ciptaan Padmasari meretas sensor penglihatan para Android. Saat mereka menatap Urumaskara yang berdiri mengenakan pakaian pelindung mekanis kusam, visual Urumaskara terdistorsi menjadi sosok raksasa \"System Destroyer\" (Dewa Kehancuran Sistem) yang siap memformat total memori inti mereka.\n\n" .
                    "### [Bab IV: Malfungsi Navigasi & Pelarian Para Cyborg]\n" .
                    "Panik luar biasa melanda prosesor para Android elit. Dengan sistem navigasi optik yang rusak dan terdistorsi parah, para Cyborg penguasa berlarian tak tentu arah, saling menabrak dinding dan pintu baja stasiun luar angkasa dalam pemandangan yang sangat memalu kan.\n\n" .
                    "### [Bab V: Kebebasan Pekerja & Nilai Filosofis]\n" .
                    "Stasiun luar angkasa kembali kondusif di bawah kendali para pekerja yang jujur. Padmasari dan Urumaskara membuktikan bahwa kecerdasan batin manusia selalu lebih unggul dibanding kesombongan mesin dan otoritas sintetis.";
            } elseif (str_contains(strtolower($selectedTheme), 'steampunk')) {
                $generatedTitle = 'Revolusi Industri Mekanik: Automaton Uap di Kota Kabut';
                $generatedContent = "## {$generatedTitle}\n\n" .
                    "**Tema/Genre**: Steampunk (Revolusi Industri Mekanik)\n" .
                    "**Naskah Acuan Master**: {$masterTitle}\n" .
                    "**Fokus Adegan**: {$prompt}\n" .
                    "**Pesan Moral**: \"{$moralLesson}\"\n\n" .
                    "---\n\n" .
                    "### [Bab I: Kota Uap & Monopoli Batu Bara Bangsawan]\n" .
                    "Di tengah kota yang senantiasa diselimuti kabut asap hitam dan gemertak roda gigi kuningan, para Bangsawan Industrialis memonopoli pasokan batu bara. Padmasari adalah istri dari Urumaskara, seorang buruh pemelihara mesin uap yang bersahaja di pabrik utama.\n\n" .
                    "### [Bab II: Siasat Oli Mesin & Jelaga Batu Bara]\n" .
                    "Ketika para bangsawan industrialis mencoba menekan Padmasari, ia mengoleskan ramuan *jelaga batu bara murni dan oli mesin buangan* ke wajah para pejabat dengan alasan 'baluran pelindung radiasi uap panas'. Para bangsawan yang congkak menurut tanpa curiga.\n\n" .
                    "### [Bab III: Penyamaran Automaton Robot Uap di Langit-Langit]\n" .
                    "Malam harinya, Urumaskara melayang dari langit-langit pabrik menggunakan glider kuningan raksasa. Ia mengenakan zirah besi tebal berpiston uap, menyamar menjadi \"Automaton Mekanik Pembunuh\" yang mengerikan. Saat ia mendarat, peluit uap bertekanan tinggi melengking keras memecah keheningan malam.\n\n" .
                    "### [Bab IV: Pelarian Bangsawan Menembus Kabut Kota]\n" .
                    "Mendengar lengkingan seram Automaton uap dan melihat bayangan raksasa Urumaskara, para bangsawan lari ketakutan setengah mati. Dengan wajah belepotan jelaga hitam bersinar oli, mereka berlarian menembus kabut asap jalanan kota, menjadi bahan tertawaan para buruh pabrik.\n\n" .
                    "### [Bab V: Kemenangan Buruh Bersahaja & Pesan Moral]\n" .
                    "Kota uap kini bernapas lebih lega. Kesombongan para pemonopoli berhasil ditumbangkan oleh kecerdikan sederhana dan solidaritas buruh yang tulus.";
            } else { // Post-Apocalyptic
                $generatedTitle = 'Wasteland Pasca-Kiamat: Penjaga Pemurni Air & Debu Radioaktif';
                $generatedContent = "## {$generatedTitle}\n\n" .
                    "**Tema/Genre**: Post-Apocalyptic (Dunia Pasca-Kiamat)\n" .
                    "**Naskah Acuan Master**: {$masterTitle}\n" .
                    "**Fokus Adegan**: {$prompt}\n" .
                    "**Pesan Moral**: \"{$moralLesson}\"\n\n" .
                    "---\n\n" .
                    "### [Bab I: Wasteland Tandus & Perebutan Pasokan Air]\n" .
                    "Di gurun tandus Wasteland pasca-kiamat, air bersih adalah komoditas paling berharga. Para Warlord (Panglima Perang) faksi lokal menguasai pasokan air dengan kejam. Padmasari adalah wanita bijak yang memiliki keahlian langka memurnikan air gurun, sedangkan Urumaskara adalah pelindungnya.\n\n" .
                    "### [Bab II: Siasat Debu Radioaktif Bersinar]\n" .
                    "Para Warlord mencoba memaksa Padmasari bekerja hanya untuk faksi mereka. Dengan tenang, Padmasari menyuruh para Warlord membedaki wajah mereka dengan 'debu radioaktif ringan' yang diklaim sebagai ritual pemurnian air. Para Warlord yang serakah menyetujuinya.\n\n" .
                    "### [Bab III: Kemunculan Monster Mutan Scrap Armor]\n" .
                    "Di tengah kegelapan badai pasir malam hari, Urumaskara muncul mengenakan tumpukan pelindung besi rongsokan (*scrap armor*) tebal, menyerupai monster mutan raksasa dari legenda tanah tandus. Suara dentuman pelat besi dan gertakan rongsokan membuat suasana menjadi sangat mencekam.\n\n" .
                    "### [Bab IV: Warlord Lari Bersinar Menembus Badai Pasir]\n" .
                    "Melihat monster mutan besi berdiri di hadapan mereka, para Warlord yang garang mendadak kehilangan keberanian. Mereka lari terbirit-birit ke tengah gurun pasir. Bedak debu radioaktif di wajah mereka memancarkan cahaya hijau terang di tengah kegelapan, memudahkan warga gurun melihat pelarian mereka yang memalukan.\n\n" .
                    "### [Bab V: Sumber Air untuk Rakyat & Amanat Kebajikan]\n" .
                    "Pasokan air bersih akhirnya dibagikan secara adil kepada seluruh warga Wasteland. Padmasari dan Urumaskara membuktikan bahwa di dunia yang hancur sekalipun, ketulusan dan keberanian akan selalu menyinari kegelapan.";
            }
        } else {
            // Extract first line as title if generated
            $lines = explode("\n", trim($generatedContent));
            $generatedTitle = str_replace(['#', '*', 'TITLE:', 'Judul:'], '', $lines[0]);
            if (strlen($generatedTitle) > 100 || empty($generatedTitle)) {
                $generatedTitle = 'Adaptasi ' . $selectedTheme . ': ' . ucwords(Str::limit($prompt, 40));
            }
        }



        $story = Story::create([
            'title' => $generatedTitle,
            'prompt' => $prompt,
            'theme' => $selectedTheme,
            'target_audience' => $targetAudience,
            'moral_lesson' => $moralLesson,
            'content' => $generatedContent,
            'reads_count' => 1,
            'is_featured' => false,
        ]);


        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'story' => $story,
            ]);
        }

        return redirect()->route('story-generator.show', $story->id)->with('success', 'Cerita AI Padmasari berhasil dibuat!');
    }

    public function show(Story $story)
    {
        $story->increment('reads_count');
        $relatedStories = Story::where('id', '!=', $story->id)->take(3)->get();
        return view('story_generator.show', compact('story', 'relatedStories'));
    }
}
