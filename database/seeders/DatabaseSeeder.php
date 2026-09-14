<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Story;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@padmasari.ai'],
            [
                'name' => 'Admin Padmasari AI',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'scholar@padmasari.ai'],
            [
                'name' => 'Sanjaya Scholar',
                'password' => \Illuminate\Support\Facades\Hash::make('scholar123'),
                'email_verified_at' => now(),
            ]
        );



        // Seed Sample AI Generated Stories for 3 Formats
        Story::create([
            'title' => 'Keheningan Guruminda di Rimba Pasir Batang',
            'prompt' => 'Buatkan alur cerita adaptasi Lutung Kasarung dengan penekanan pada dialog batin Guruminda saat turun ke bumi.',
            'theme' => 'Wawacan & Legend',
            'format' => 'novel',
            'target_audience' => 'Remaja & Mahasiswa',
            'moral_lesson' => 'Kesederhanaan wujud fisik tidak pernah memadamkan kemurnian niat dan keagungan budi.',
            'content' => "### Bab I: Turun ka Bumi\n\nAngin leuweung Pasir Batang ngahiliwir tiis nalika Guruminda nangtung dina sela-sela dahan pohon beringin tua. Salira anu biasa dibalut ku cahaya kahyangan ayeuna terbungkus ku wujud rupa lutung berbulu gelap.\n\n'Bumi sanes tempat kakuatan fisik dipamerkeun,' gerentesna dina hate. Purbasari, anu dipicu ku kedengkian saudarana, dukuh di tempat anu sunyi tanpa amarah. Guruminda sadar yén pancén utamana lain ngan sekadar nyalametkeun karajaan, tapi nembongkeun yén kadudukan anu sejati nyaéta kaluhuran budi pekerti.\n\n### Bab II: Papatang & Keberanian\n\nNalika malam tumiba, naskah kuno anu terukir dina lontar seakan berbisik menerusi helaian daun dryas...",
            'reads_count' => 142,
            'is_featured' => true,
        ]);

        Story::create([
            'title' => 'Transkripsi Lontar & Bisikan Citarum',
            'prompt' => 'Cerita sejarah fiksi inspirasi Carita Parahyangan tentang juru tulis naskah kuno abad 16.',
            'theme' => 'Sejarah & Filologi',
            'format' => 'naskah_cerita',
            'target_audience' => 'Akademisi & Umum',
            'moral_lesson' => 'Menjaga warisan budaya adalah menjaga kompas peradaban masa depan.',
            'content' => "### Manuskrip Lontar Folio-07 (Prasasti Sengkala)\n\n**Transkripsi Aksara Kawi Original:**\nᮞ ᮔ᮪ ᮒ ᮔ᮪ ᮛᮨ ᮞᮤ ᮏ ᮚ ᮌᮤ ᮛᮤ\n\n**Terjemahan Bahasa Filologi:**\nTangan Resi Jayagiri bergetar halus saat pisau penoreh (pangot) menyentuh permukaan lembaran lontar yang telah dikeringkan. Di luar padepokan, aliran sungai Citarum mengalir jernih memantulkan sinar rembulan abad ke-16.\n\n**Catatan Filologi & Otonomi Pikiran:**\nIa sedang mencatat silsilah tata kota Pakuan Pajajaran. 'Anak cucu kita kelak mungkin tidak lagi mendengar derap langkah kuda prajurit,' bisiknya kepada murid mudanya, Ki Samud. 'Namun selama goresan aksara ini tetap terbaca, roh kearifan kita tidak akan pernah padam.'",
            'reads_count' => 98,
            'is_featured' => true,
        ]);

        Story::create([
            'title' => 'Pentas Teater Mistik Wayang Kosmik',
            'prompt' => 'Adaptasi drama teater modern dari legenda Nusantara.',
            'theme' => 'Teater & Pertunjukan',
            'format' => 'drama',
            'target_audience' => 'Pencinta Seni & Teater',
            'moral_lesson' => 'Suara perlawanan perempuan berdaulat yang menolak tunduk pada subordinasi patriarkal.',
            'content' => "### Babak I: Tahta di Bawah Sinar Rembulan\n\n**Latar Panggung:** Panggung redup dipenuhi asap kabut mistik (glow neon cyan & purple). Di tengah panggung, Padmasari berdiri memegang mahkota emas tua.\n\n**PADMASARI:** (Dengan suara lantang, menatap penonton)  \n'Takhta ini bukan warisan kemudahan, melainkan sumpah darah untuk menegakkan kedaulatan perempuan Nusantara!'\n\n**PATRIARK FEODAL:** (Maju dua langkah, suara bergetar amarah)  \n'Kau melanggar adat kuno para leluhur, Padmasari!'\n\n**PADMASARI:**  \n'Adat yang membungkam kebenaran bukanlah adat, melainkan belenggu. Dan malam ini, belenggu itu hancur!'\n\n*(Efek Suara: Petir menggelegar dan gamelan kosmik bergelombang)*",
            'reads_count' => 210,
            'is_featured' => true,
        ]);
    }
}
