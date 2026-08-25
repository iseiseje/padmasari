<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Story;
use App\Models\LearningModule;
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

        User::factory()->create([
            'name' => 'Sanjaya Scholar',
            'email' => 'scholar@padmasari.ai',
        ]);

        // Seed Learning Modules
        LearningModule::create([
            'title' => 'Pengenalan Aksara Sunda Kuno (Sunda Kawi)',
            'category' => 'Filologi & Aksara',
            'description' => 'Memahami struktur visual, konsonan Swara dan Ngalagena dalam naskah abad ke-14 hingga ke-16.',
            'lesson_count' => 8,
            'duration_minutes' => 60,
            'difficulty' => 'Pemula',
            'icon' => 'scroll',
            'progress_percent' => 75,
        ]);

        LearningModule::create([
            'title' => 'Struktur Wawacan & Pupuh Tradisional',
            'category' => 'Sastra Klasik',
            'description' => 'Mempelajari patokan guru lagu, guru wilangan, dan dinamika emosi dalam 17 jenis Pupuh Wawacan.',
            'lesson_count' => 12,
            'duration_minutes' => 90,
            'difficulty' => 'Menengah',
            'icon' => 'book-open',
            'progress_percent' => 40,
        ]);

        LearningModule::create([
            'title' => 'Analisis Kontekstual Berbasis Padmasari AI',
            'category' => 'AI & Humanities',
            'description' => 'Menggunakan LLM dan Computer Vision untuk mengidentifikasi fragmentasi naskah lontar yang rusak.',
            'lesson_count' => 6,
            'duration_minutes' => 45,
            'difficulty' => 'Mahir',
            'icon' => 'sparkles',
            'progress_percent' => 15,
        ]);



        // Seed Sample AI Generated Stories
        Story::create([
            'title' => 'Keheningan Guruminda di Rimba Pasir Batang',
            'prompt' => 'Buatkan alur cerita adaptasi Lutung Kasarung dengan penekanan pada dialog batin Guruminda saat turun ke bumi.',
            'theme' => 'Wawacan & Legend',
            'target_audience' => 'Remaja & Mahasiswa',
            'moral_lesson' => 'Kesederhanaan wujud fisik tidak pernah memadamkan kemurnian niat dan keagungan budi.',
            'content' => "Angin leuweung Pasir Batang ngahiliwir tiis nalika Guruminda nangtung dina sela-sela dahan pohon beringin tua. Salira anu biasa dibalut ku cahaya kahyangan ayeuna terbungkus ku wujud rupa lutung berbulu gelap.

'Bumi sanes tempat kakuatan fisik dipamerkeun,' gerentesna dina hate. Purbasari, anu dipicu ku kedengkian saudarana, dukuh di tempat anu sunyi tanpa amarah. Guruminda sadar yén pancén utamana lain ngan sekadar nyalametkeun karajaan, tapi nembongkeun yén kadudukan anu sejati nyaéta kaluhuran budi pekerti.

Nalika malam tumiba, naskah kuno anu terukir dina lontar seakan berbisik menerusi helaian daun dryas...",
            'reads_count' => 142,
            'is_featured' => true,
        ]);

        Story::create([
            'title' => 'Bisikan Lontar di Tepian Citarum',
            'prompt' => 'Cerita sejarah fiksi inspirasi Carita Parahyangan tentang juru tulis naskah kuno abad 16.',
            'theme' => 'Sejarah & Filologi',
            'target_audience' => 'Umum',
            'moral_lesson' => 'Menjaga warisan budaya adalah menjaga kompas peradaban masa depan.',
            'content' => "Tangan Resi Jayagiri bergetar halus saat pisau pisau penoreh (pisau pangot) menyentuh permukaan lembaran lontar yang telah dikeringkan. Di luar padepokan, aliran sungai Citarum mengalir jernih memantulkan sinar rembulan abad ke-16.

Ia sedang mencatat silsilah tata kota Pakuan Pajajaran. 'Anak cucu kita kelak mungkin tidak lagi mendengar derap langkah kuda prajurit,' bisiknya kepada murid mudanya, Ki Samud. 'Namun selama goresan aksara ini tetap terbaca, roh kearifan kita tidak akan pernah padam.'",
            'reads_count' => 98,
            'is_featured' => true,
        ]);
    }
}
