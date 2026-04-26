<?php

return [
    'app_name' => 'SPMB SMP Negeri 1 Merbau',
    'tagline' => 'Prapendaftaran murid baru SMP Negeri 1 Merbau.',
    'support_text' => 'Layanan prapendaftaran murid baru SMP Negeri 1 Merbau.',
    'cache_store' => env('SPMB_CACHE_STORE', env('CACHE_STORE', 'file')),
    'fallback_cache_store' => env('SPMB_FALLBACK_CACHE_STORE', 'file'),
    'school' => [
        'name' => 'SMP Negeri 1 Merbau',
        'info' => 'Layanan prapendaftaran murid baru',
        'address' => 'Jl. Yos Sudarso, Kecamatan Merbau, Kab. Kepulauan Meranti.',
        'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/250px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png',
    ],
    'admin' => [
        'email' => 'admin@smpn1merbau.sch.id',
        'password' => 'Admin123!',
    ],
    'seed_sample_data' => false,
    'paths' => [
        'DOM' => [
            'name' => 'Domisili',
            'description' => 'Untuk calon murid berdasarkan wilayah tempat tinggal atau zona domisili.',
            'capacity' => 12,
            'is_active' => true,
            'close_when_full' => true,
        ],
        'AFR' => [
            'name' => 'Afirmasi',
            'description' => 'Untuk calon murid yang memenuhi kriteria afirmasi sesuai ketentuan sekolah.',
            'capacity' => 6,
            'is_active' => true,
            'close_when_full' => true,
        ],
        'PRS' => [
            'name' => 'Prestasi',
            'description' => 'Untuk calon murid yang memiliki prestasi akademik atau non-akademik.',
            'capacity' => 4,
            'is_active' => true,
            'close_when_full' => true,
        ],
        'MUT' => [
            'name' => 'Mutasi',
            'description' => 'Untuk calon murid yang mengikuti perpindahan tugas orang tua/wali.',
            'capacity' => 2,
            'is_active' => true,
            'close_when_full' => true,
        ],
    ],
    'statuses' => [
        'baru' => [
            'label' => 'Baru',
            'description' => 'Data baru masuk dan menunggu pemeriksaan awal.',
        ],
        'dicek' => [
            'label' => 'Dicek',
            'description' => 'Data sedang diperiksa oleh admin sekolah.',
        ],
        'perlu_perbaikan' => [
            'label' => 'Perlu Perbaikan',
            'description' => 'Masih ada data yang perlu dilengkapi secara manual.',
        ],
        'valid' => [
            'label' => 'Valid Prapendaftaran',
            'description' => 'Data sudah valid untuk proses berikutnya.',
        ],
        'ditolak' => [
            'label' => 'Ditolak Prapendaftaran',
            'description' => 'Data tidak memenuhi syarat pada tahap prapendaftaran.',
        ],
    ],
    'genders' => [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ],
    'affirmation_types' => [
        'KIP' => 'Kartu Indonesia Pintar',
        'PKH' => 'Program Keluarga Harapan',
        'DTKS' => 'Terdaftar di DTKS',
        'Lainnya' => 'Afirmasi lainnya',
    ],
    'achievement_types' => [
        'Akademik' => 'Akademik',
        'Non-Akademik' => 'Non-Akademik',
        'Olahraga' => 'Olahraga',
        'Seni' => 'Seni',
    ],
    'achievement_levels' => [
        'Sekolah' => 'Sekolah',
        'Kecamatan' => 'Kecamatan',
        'Kabupaten/Kota' => 'Kabupaten/Kota',
        'Provinsi' => 'Provinsi',
        'Nasional' => 'Nasional',
    ],
];
