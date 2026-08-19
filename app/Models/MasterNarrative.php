<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNarrative extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'core_topic',
        'master_content',
        'core_summary',
        'world_rules',
        'system_prompt',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::create([
            'title' => 'Naskah Master: Wawacan Lutung Kasarung & Purbasari',
            'core_topic' => 'Kisah Purbasari & Lutung Kasarung di Pasir Batang',
            'master_content' => "Nalika angin pasir berhembus lembut mengusap dedaunan bukit hulu sungai Pasir Batang, Purbasari dukun ningrat lenggah di saung bambu tua. Manuskrip lontar kuno mengisahkan ujian kesabaran Purbasari ketika Purbararang mengasingkannya ke dalam hutan belantara.\n\nDi tengah rimba, hadir Guruminda yang menjelma sebagai Lutung Kasarung untuk mendampingi dan melindungi Purbasari. Ujian ketabahan, kesederhanaan, dan kejujuran Purbasari akhirnya mengalahkan keangkuhan Purbararang, hingga kebaikan dan kebenaran kembali bertahta di tanah Galuh Pajajaran.",
            'core_summary' => 'Naskah Acuan Utama Sastra Wawacan Lutung Kasarung',
            'world_rules' => 'Seluruh hasil adaptasi cerita HARUS bersumber dan mengakar dari Naskah Master di atas. Tokoh utama (Purbasari, Guruminda/Lutung Kasarung, Purbararang), lokasi (Pasir Batang, Galuh, Pajajaran), dan etika moral Dasa Prasanta tidak boleh menyimpang.',
            'system_prompt' => 'Anda adalah Padmasari AI Adaptation Engine. Tugas Anda adalah menghasilkan turunan naskah/adaptasi cerita sastra baru yang 100% berpatokan pada Naskah Master Cerita Terkunci yang disediakan. Ubah gaya bahasa, sudut pandang, atau penekanan babak berdasarkan parameter masukan Admin tanpa mengubah fakta dasar naskah master.',
            'is_active' => true,
        ]);
    }
}
