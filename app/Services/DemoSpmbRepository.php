<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Throwable;

class DemoSpmbRepository
{
    protected string $pathSettingsCacheKey = 'spmb.path_settings';
    protected string $registrationsCacheKey = 'spmb.registrations';
    protected string $adminCredentialsCacheKey = 'spmb.admin_credentials';

    public function branding(): array
    {
        return [
            'app_name' => config('spmb.app_name'),
            'tagline' => config('spmb.tagline'),
            'support_text' => config('spmb.support_text'),
            'school_name' => config('spmb.school.name'),
            'logo_url' => config('spmb.school.logo_url'),
            'year' => 2026,
        ];
    }

    public function statuses(): array
    {
        return config('spmb.statuses', []);
    }

    public function registrationPaths(): Collection
    {
        $counts = $this->registrations()->countBy('path_code');

        return $this->pathDefinitions()
            ->map(function (array $path, string $code) use ($counts) {
                $registered = (int) $counts->get($code, 0);
                $remaining = max($path['capacity'] - $registered, 0);
                $isSelectable = $path['is_active'] && (! $path['close_when_full'] || $remaining > 0);

                return [
                    'code' => $code,
                    'name' => $path['name'],
                    'description' => $path['description'],
                    'capacity' => $path['capacity'],
                    'registered' => $registered,
                    'remaining' => $remaining,
                    'is_active' => $path['is_active'],
                    'close_when_full' => $path['close_when_full'],
                    'is_selectable' => $isSelectable,
                    'fill_percentage' => $path['capacity'] > 0
                        ? min(100, (int) round(($registered / $path['capacity']) * 100))
                        : 0,
                    'status_text' => ! $path['is_active']
                        ? 'Jalur sedang dinonaktifkan admin'
                        : (($remaining === 0 && $path['close_when_full'])
                            ? 'Kuota Penuh'
                            : 'Kuota Tersedia'),
                ];
            })
            ->values();
    }

    public function updatePathSettings(string $code, array $settings): void
    {
        $paths = $this->pathDefinitions();

        if (! $paths->has($code)) {
            return;
        }

        $overrides = $this->cacheGet($this->pathSettingsCacheKey, []);
        $overrides[$code] = [
            'capacity' => (int) $settings['capacity'],
            'is_active' => (bool) $settings['is_active'],
            'close_when_full' => (bool) $settings['close_when_full'],
        ];

        $this->cacheForever($this->pathSettingsCacheKey, $overrides);
    }

    public function adminCredentials(): array
    {
        $credentials = $this->cacheGet($this->adminCredentialsCacheKey);

        if (! is_array($credentials)) {
            $credentials = [
                'email' => config('spmb.admin.email'),
                'password_hash' => Hash::make(config('spmb.admin.password')),
            ];

            $this->cacheForever($this->adminCredentialsCacheKey, $credentials);
        }

        return $credentials;
    }

    public function validateAdminCredentials(string $email, string $password): bool
    {
        $credentials = $this->adminCredentials();

        return $email === $credentials['email']
            && Hash::check($password, $credentials['password_hash']);
    }

    public function updateAdminPassword(string $password): void
    {
        $credentials = $this->adminCredentials();
        $credentials['password_hash'] = Hash::make($password);

        $this->cacheForever($this->adminCredentialsCacheKey, $credentials);
    }

    public function dashboardStats(): array
    {
        $paths = $this->registrationPaths();
        $registrations = $this->registrations();
        $statusCounts = $registrations->countBy('status');

        return [
            'total_registrations' => $registrations->count(),
            'total_capacity' => $paths->sum('capacity'),
            'remaining_capacity' => $paths->sum('remaining'),
            'path_counts' => $paths->mapWithKeys(fn (array $path) => [$path['code'] => $path['registered']])->all(),
            'status_counts' => collect($this->statuses())->mapWithKeys(
                fn (array $status, string $key) => [$key => (int) $statusCounts->get($key, 0)]
            )->all(),
        ];
    }

    public function recentRegistrations(int $limit = 5): Collection
    {
        return $this->registrations()
            ->sortByDesc('submitted_at')
            ->take($limit)
            ->values();
    }

    public function paginatedRegistrations(array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        $page = max((int) request()->integer('page', 1), 1);
        $items = $this->filterRegistrations($this->registrations(), $filters)->values();
        $slice = $items->forPage($page, $perPage)->values();

        return new LengthAwarePaginator(
            $slice,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    public function reportRows(array $filters = []): Collection
    {
        return $this->filterRegistrations($this->registrations(), $filters)->values();
    }

    public function findRegistration(string|int $id): ?array
    {
        return $this->registrations()->first(
            fn (array $registration) => (string) $registration['id'] === (string) $id
                || $registration['registration_number'] === (string) $id
        );
    }

    public function createPreviewRegistration(array $validated): array
    {
        $submittedAt = Carbon::now();

        return $this->storeRegistration([
            'path_code' => $validated['path_code'],
            'full_name' => $validated['full_name'],
            'nisn' => $validated['nisn'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'village' => $validated['village'] ?? null,
            'district' => $validated['district'] ?? null,
            'previous_school' => $validated['previous_school'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'email' => $validated['email'] ?? null,
            'status' => 'valid',
            'admin_note' => 'Pendaftaran langsung ditandai valid.',
            'submitted_at' => $submittedAt->toDateTimeString(),
            'special_data' => match ($validated['path_code']) {
                'DOM' => [
                    'village' => $validated['village'] ?? null,
                    'district' => $validated['district'] ?? null,
                    'distance' => $validated['distance'] ?? null,
                ],
                'AFR' => [
                    'affirmation_type' => $validated['affirmation_type'] ?? null,
                    'card_number' => $validated['card_number'] ?? null,
                    'support_note' => $validated['support_note'] ?? null,
                ],
                'PRS' => [
                    'achievement_type' => $validated['achievement_type'] ?? null,
                    'achievement_level' => $validated['achievement_level'] ?? null,
                    'competition_name' => $validated['competition_name'] ?? null,
                    'achievement_year' => $validated['achievement_year'] ?? null,
                ],
                'MUT' => [
                    'mutation_reason' => $validated['mutation_reason'] ?? null,
                    'parent_workplace' => $validated['parent_workplace'] ?? null,
                ],
            },
        ], false);
    }

    public function createAdminRegistration(array $validated): array
    {
        return $this->storeRegistration([
            'path_code' => $validated['path_code'],
            'full_name' => $validated['full_name'],
            'nisn' => $validated['nisn'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'village' => $validated['village'] ?? null,
            'district' => $validated['district'] ?? null,
            'previous_school' => $validated['previous_school'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'email' => $validated['email'] ?? null,
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? '',
            'special_data' => $this->buildSpecialData($validated),
        ], true);
    }

    public function updateRegistration(string|int $id, array $validated): ?array
    {
        $registrations = $this->registrationsRaw();
        $index = $registrations->search(fn (array $registration) => (string) $registration['id'] === (string) $id);

        if ($index === false) {
            return null;
        }

        $existing = $registrations->get($index);
        $updated = array_merge($existing, [
            'path_code' => $validated['path_code'],
            'full_name' => $validated['full_name'],
            'nisn' => $validated['nisn'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'village' => $validated['village'] ?? null,
            'district' => $validated['district'] ?? null,
            'previous_school' => $validated['previous_school'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'email' => $validated['email'] ?? null,
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? '',
            'special_data' => $this->buildSpecialData($validated),
        ]);

        $registrations->put($index, $updated);
        $this->cacheForever($this->registrationsCacheKey, $registrations->values()->all());

        return $this->decorateRegistration($updated);
    }

    public function deleteRegistration(string|int $id): void
    {
        $registrations = $this->registrationsRaw()
            ->reject(fn (array $registration) => (string) $registration['id'] === (string) $id)
            ->values();

        $this->cacheForever($this->registrationsCacheKey, $registrations->all());
    }

    public function pathOptions(): array
    {
        return $this->registrationPaths()->keyBy('code')->all();
    }

    public function registrationExistsByNisn(string $nisn): bool
    {
        return $this->registrations()->contains(
            fn (array $registration) => (string) $registration['nisn'] === $nisn
        );
    }

    public function registrationExistsByNisnExcept(string $nisn, string|int|null $exceptId = null): bool
    {
        return $this->registrations()->contains(function (array $registration) use ($nisn, $exceptId) {
            if ((string) $registration['nisn'] !== $nisn) {
                return false;
            }

            return $exceptId === null || (string) $registration['id'] !== (string) $exceptId;
        });
    }

    protected function filterRegistrations(Collection $registrations, array $filters): Collection
    {
        $search = strtolower(trim((string) ($filters['search'] ?? '')));
        $path = strtoupper((string) ($filters['path'] ?? ''));
        $status = (string) ($filters['status'] ?? '');
        $dateFrom = (string) ($filters['date_from'] ?? '');
        $dateTo = (string) ($filters['date_to'] ?? '');
        $sort = (string) ($filters['sort'] ?? 'latest');

        $filtered = $registrations->filter(function (array $registration) use ($search, $path, $status, $dateFrom, $dateTo) {
            $matchesSearch = $search === ''
                || str_contains(strtolower($registration['full_name']), $search)
                || str_contains(strtolower($registration['registration_number']), $search)
                || str_contains(strtolower((string) $registration['nisn']), $search)
                || str_contains(strtolower($registration['previous_school']), $search);

            $matchesPath = $path === '' || $registration['path_code'] === $path;
            $matchesStatus = $status === '' || $registration['status'] === $status;

            $submittedDate = Carbon::parse($registration['submitted_at'])->toDateString();
            $matchesDateFrom = $dateFrom === '' || $submittedDate >= $dateFrom;
            $matchesDateTo = $dateTo === '' || $submittedDate <= $dateTo;

            return $matchesSearch && $matchesPath && $matchesStatus && $matchesDateFrom && $matchesDateTo;
        });

        return match ($sort) {
            'oldest' => $filtered->sortBy('submitted_at'),
            'name' => $filtered->sortBy('full_name'),
            default => $filtered->sortByDesc('submitted_at'),
        };
    }

    protected function seedRegistrations(): Collection
    {
        return collect([
            [
                'id' => 1,
                'registration_number' => 'SPMB-2026-DOM-0001',
                'path_code' => 'DOM',
                'full_name' => 'Nadia Putri Maheswari',
                'nisn' => '0068123456',
                'nik' => '3175091202140001',
                'birth_place' => 'Jakarta',
                'birth_date' => '2014-02-12',
                'gender' => 'P',
                'address' => 'Jl. Melati Raya No. 14, RT 03/RW 08',
                'village' => 'Kelurahan Sukamaju',
                'district' => 'Kecamatan Cempaka',
                'previous_school' => 'SDN Sukamaju 02',
                'parent_name' => 'Rina Maheswari',
                'parent_phone' => '081234560101',
                'email' => 'rina.maheswari@example.test',
                'status' => 'baru',
                'admin_note' => 'Menunggu verifikasi alamat domisili.',
                'submitted_at' => '2026-04-24 08:10:00',
                'special_data' => [
                    'distance' => '2.1 km',
                ],
            ],
            [
                'id' => 2,
                'registration_number' => 'SPMB-2026-DOM-0002',
                'path_code' => 'DOM',
                'full_name' => 'Fahri Akbar Ramadhan',
                'nisn' => '0068123457',
                'nik' => '3175091202140002',
                'birth_place' => 'Bekasi',
                'birth_date' => '2013-11-03',
                'gender' => 'L',
                'address' => 'Perum Griya Sejahtera Blok C7',
                'village' => 'Desa Mekarsari',
                'district' => 'Kecamatan Jatiasih',
                'previous_school' => 'SD Islam Cendekia',
                'parent_name' => 'Rudi Ramadhan',
                'parent_phone' => '081234560102',
                'email' => null,
                'status' => 'dicek',
                'admin_note' => 'Dokumen alamat sudah sesuai.',
                'submitted_at' => '2026-04-24 09:15:00',
                'special_data' => [
                    'distance' => '3.4 km',
                ],
            ],
            [
                'id' => 3,
                'registration_number' => 'SPMB-2026-DOM-0003',
                'path_code' => 'DOM',
                'full_name' => 'Salsabila Nadhifa',
                'nisn' => '0068123458',
                'nik' => '3175091202140003',
                'birth_place' => 'Depok',
                'birth_date' => '2014-07-20',
                'gender' => 'P',
                'address' => 'Jl. Dahlia Permai Gang 2 No. 8',
                'village' => 'Kelurahan Cilangkap',
                'district' => 'Kecamatan Tapos',
                'previous_school' => 'SDN Cilangkap 05',
                'parent_name' => 'Dewi Nadhifa',
                'parent_phone' => '081234560103',
                'email' => 'dewi.nadhifa@example.test',
                'status' => 'valid',
                'admin_note' => 'Data lengkap dan valid.',
                'submitted_at' => '2026-04-23 13:44:00',
                'special_data' => [
                    'distance' => '1.8 km',
                ],
            ],
            [
                'id' => 4,
                'registration_number' => 'SPMB-2026-DOM-0004',
                'path_code' => 'DOM',
                'full_name' => 'Raka Aditya Pranata',
                'nisn' => '0068123459',
                'nik' => '3175091202140004',
                'birth_place' => 'Bogor',
                'birth_date' => '2013-12-29',
                'gender' => 'L',
                'address' => 'Jl. Puspa Kencana No. 2',
                'village' => 'Kelurahan Harapan',
                'district' => 'Kecamatan Setu',
                'previous_school' => 'SDN Harapan Jaya',
                'parent_name' => 'Deni Pranata',
                'parent_phone' => '081234560104',
                'email' => null,
                'status' => 'perlu_perbaikan',
                'admin_note' => 'Mohon perjelas RT/RW pada alamat.',
                'submitted_at' => '2026-04-23 10:32:00',
                'special_data' => [
                    'distance' => '4.6 km',
                ],
            ],
            [
                'id' => 5,
                'registration_number' => 'SPMB-2026-DOM-0005',
                'path_code' => 'DOM',
                'full_name' => 'Luthfi Hanif',
                'nisn' => '0068123460',
                'nik' => '3175091202140005',
                'birth_place' => 'Jakarta',
                'birth_date' => '2014-05-15',
                'gender' => 'L',
                'address' => 'Jl. Anggrek Timur No. 11',
                'village' => 'Kelurahan Anggrek',
                'district' => 'Kecamatan Bina Marga',
                'previous_school' => 'SDN Anggrek 01',
                'parent_name' => 'Siti Hanifah',
                'parent_phone' => '081234560105',
                'email' => 'hanifah@example.test',
                'status' => 'baru',
                'admin_note' => 'Menunggu review operator.',
                'submitted_at' => '2026-04-22 11:20:00',
                'special_data' => [
                    'distance' => '1.2 km',
                ],
            ],
            [
                'id' => 6,
                'registration_number' => 'SPMB-2026-DOM-0006',
                'path_code' => 'DOM',
                'full_name' => 'Aulia Rahma Safitri',
                'nisn' => '0068123461',
                'nik' => '3175091202140006',
                'birth_place' => 'Bekasi',
                'birth_date' => '2014-09-08',
                'gender' => 'P',
                'address' => 'Grand Sakura Residence B2/10',
                'village' => 'Desa Sukakarya',
                'district' => 'Kecamatan Tambun',
                'previous_school' => 'MI Al-Hikmah',
                'parent_name' => 'Nur Aulia',
                'parent_phone' => '081234560106',
                'email' => null,
                'status' => 'dicek',
                'admin_note' => 'Alamat dan KK sesuai.',
                'submitted_at' => '2026-04-22 09:02:00',
                'special_data' => [
                    'distance' => '3.0 km',
                ],
            ],
            [
                'id' => 7,
                'registration_number' => 'SPMB-2026-DOM-0007',
                'path_code' => 'DOM',
                'full_name' => 'Rafif Zaky Ramdani',
                'nisn' => '0068123462',
                'nik' => '3175091202140007',
                'birth_place' => 'Depok',
                'birth_date' => '2013-10-18',
                'gender' => 'L',
                'address' => 'Jl. Cemara Ujung No. 7',
                'village' => 'Kelurahan Mulyasari',
                'district' => 'Kecamatan Sawangan',
                'previous_school' => 'SDN Mulyasari 03',
                'parent_name' => 'Feri Ramdani',
                'parent_phone' => '081234560107',
                'email' => null,
                'status' => 'valid',
                'admin_note' => 'Sudah masuk shortlist awal.',
                'submitted_at' => '2026-04-21 15:12:00',
                'special_data' => [
                    'distance' => '2.7 km',
                ],
            ],
            [
                'id' => 8,
                'registration_number' => 'SPMB-2026-DOM-0008',
                'path_code' => 'DOM',
                'full_name' => 'Keisha Anindita',
                'nisn' => '0068123463',
                'nik' => '3175091202140008',
                'birth_place' => 'Jakarta',
                'birth_date' => '2014-01-29',
                'gender' => 'P',
                'address' => 'Jl. Bougenville Tengah No. 5',
                'village' => 'Kelurahan Taman Baru',
                'district' => 'Kecamatan Taman',
                'previous_school' => 'SDN Taman Baru 01',
                'parent_name' => 'Hesti Anindita',
                'parent_phone' => '081234560108',
                'email' => 'keisha.parent@example.test',
                'status' => 'ditolak',
                'admin_note' => 'Alamat di luar rayon prioritas.',
                'submitted_at' => '2026-04-20 14:47:00',
                'special_data' => [
                    'distance' => '7.2 km',
                ],
            ],
            [
                'id' => 9,
                'registration_number' => 'SPMB-2026-AFR-0001',
                'path_code' => 'AFR',
                'full_name' => 'Mira Azzahra',
                'nisn' => '0068123464',
                'nik' => '3175091202140009',
                'birth_place' => 'Bekasi',
                'birth_date' => '2014-06-17',
                'gender' => 'P',
                'address' => 'Jl. Karya Utama No. 3',
                'village' => null,
                'district' => null,
                'previous_school' => 'SDN Jatimurni 04',
                'parent_name' => 'Sulastri',
                'parent_phone' => '081234560109',
                'email' => 'mira@example.test',
                'status' => 'baru',
                'admin_note' => 'Menunggu verifikasi jenis afirmasi.',
                'submitted_at' => '2026-04-24 07:55:00',
                'special_data' => [
                    'affirmation_type' => 'KIP',
                    'card_number' => 'KIP-882718',
                    'support_note' => 'Peserta membawa fotokopi kartu.',
                ],
            ],
            [
                'id' => 10,
                'registration_number' => 'SPMB-2026-AFR-0002',
                'path_code' => 'AFR',
                'full_name' => 'Dimas Alfarizi',
                'nisn' => '0068123465',
                'nik' => '3175091202140010',
                'birth_place' => 'Jakarta',
                'birth_date' => '2013-08-09',
                'gender' => 'L',
                'address' => 'Komp. Permata Asri Blok A12',
                'village' => null,
                'district' => null,
                'previous_school' => 'SDN Asri 06',
                'parent_name' => 'Wawan',
                'parent_phone' => '081234560110',
                'email' => null,
                'status' => 'dicek',
                'admin_note' => 'Sedang dicek kecocokan data kartu bantuan.',
                'submitted_at' => '2026-04-23 16:40:00',
                'special_data' => [
                    'affirmation_type' => 'PKH',
                    'card_number' => 'PKH-220091',
                    'support_note' => 'Butuh verifikasi tambahan.',
                ],
            ],
            [
                'id' => 11,
                'registration_number' => 'SPMB-2026-AFR-0003',
                'path_code' => 'AFR',
                'full_name' => 'Aqila Nur Syifa',
                'nisn' => '0068123466',
                'nik' => '3175091202140011',
                'birth_place' => 'Depok',
                'birth_date' => '2014-04-01',
                'gender' => 'P',
                'address' => 'Jl. Nusantara Baru No. 19',
                'village' => null,
                'district' => null,
                'previous_school' => 'MI Nurul Fikri',
                'parent_name' => 'Nisa Syifa',
                'parent_phone' => '081234560111',
                'email' => null,
                'status' => 'valid',
                'admin_note' => 'Afirmasi terverifikasi.',
                'submitted_at' => '2026-04-22 13:14:00',
                'special_data' => [
                    'affirmation_type' => 'DTKS',
                    'card_number' => 'DTKS-55123',
                    'support_note' => 'Sinkron dengan data sekolah asal.',
                ],
            ],
            [
                'id' => 12,
                'registration_number' => 'SPMB-2026-AFR-0004',
                'path_code' => 'AFR',
                'full_name' => 'Yusuf Al Ghifari',
                'nisn' => '0068123467',
                'nik' => '3175091202140012',
                'birth_place' => 'Bogor',
                'birth_date' => '2013-09-12',
                'gender' => 'L',
                'address' => 'Jl. Panorama Indah No. 1',
                'village' => null,
                'district' => null,
                'previous_school' => 'SDIT Amanah',
                'parent_name' => 'Mulyadi',
                'parent_phone' => '081234560112',
                'email' => 'yusuf.parent@example.test',
                'status' => 'perlu_perbaikan',
                'admin_note' => 'Nomor kartu belum jelas.',
                'submitted_at' => '2026-04-21 08:35:00',
                'special_data' => [
                    'affirmation_type' => 'Lainnya',
                    'card_number' => null,
                    'support_note' => 'Perlu lampiran tambahan saat verifikasi.',
                ],
            ],
            [
                'id' => 13,
                'registration_number' => 'SPMB-2026-PRS-0001',
                'path_code' => 'PRS',
                'full_name' => 'Alden Naufal',
                'nisn' => '0068123468',
                'nik' => '3175091202140013',
                'birth_place' => 'Jakarta',
                'birth_date' => '2014-03-11',
                'gender' => 'L',
                'address' => 'Jl. Garuda Raya No. 27',
                'village' => null,
                'district' => null,
                'previous_school' => 'SD Labschool',
                'parent_name' => 'Teguh Naufal',
                'parent_phone' => '081234560113',
                'email' => null,
                'status' => 'valid',
                'admin_note' => 'Juara olimpiade sains tingkat kota.',
                'submitted_at' => '2026-04-24 10:28:00',
                'special_data' => [
                    'achievement_type' => 'Akademik',
                    'achievement_level' => 'Kabupaten/Kota',
                    'competition_name' => 'Olimpiade Sains Kota',
                    'achievement_year' => '2025',
                ],
            ],
            [
                'id' => 14,
                'registration_number' => 'SPMB-2026-PRS-0002',
                'path_code' => 'PRS',
                'full_name' => 'Naura Khansa',
                'nisn' => '0068123469',
                'nik' => '3175091202140014',
                'birth_place' => 'Bekasi',
                'birth_date' => '2014-10-05',
                'gender' => 'P',
                'address' => 'Jl. Sakura Putih No. 9',
                'village' => null,
                'district' => null,
                'previous_school' => 'SDN Pondok Ranggon 01',
                'parent_name' => 'Ayu Khansa',
                'parent_phone' => '081234560114',
                'email' => 'khansa@example.test',
                'status' => 'dicek',
                'admin_note' => 'Menunggu verifikasi sertifikat lomba.',
                'submitted_at' => '2026-04-23 14:18:00',
                'special_data' => [
                    'achievement_type' => 'Seni',
                    'achievement_level' => 'Provinsi',
                    'competition_name' => 'Festival Tari Pelajar',
                    'achievement_year' => '2025',
                ],
            ],
            [
                'id' => 15,
                'registration_number' => 'SPMB-2026-PRS-0003',
                'path_code' => 'PRS',
                'full_name' => 'Zayn Malik Prasetya',
                'nisn' => '0068123470',
                'nik' => '3175091202140015',
                'birth_place' => 'Depok',
                'birth_date' => '2013-07-24',
                'gender' => 'L',
                'address' => 'Jl. Wijaya Kusuma No. 44',
                'village' => null,
                'district' => null,
                'previous_school' => 'SDN Mekarjaya 07',
                'parent_name' => 'Budi Prasetya',
                'parent_phone' => '081234560115',
                'email' => null,
                'status' => 'baru',
                'admin_note' => 'Dokumen prestasi sedang dipindai.',
                'submitted_at' => '2026-04-22 12:03:00',
                'special_data' => [
                    'achievement_type' => 'Olahraga',
                    'achievement_level' => 'Provinsi',
                    'competition_name' => 'Kejuaraan Renang Junior',
                    'achievement_year' => '2025',
                ],
            ],
            [
                'id' => 16,
                'registration_number' => 'SPMB-2026-PRS-0004',
                'path_code' => 'PRS',
                'full_name' => 'Ghea Larasati',
                'nisn' => '0068123471',
                'nik' => '3175091202140016',
                'birth_place' => 'Bogor',
                'birth_date' => '2014-11-02',
                'gender' => 'P',
                'address' => 'Jl. Rinjani Hijau No. 6',
                'village' => null,
                'district' => null,
                'previous_school' => 'SD Cita Bangsa',
                'parent_name' => 'Mia Larasati',
                'parent_phone' => '081234560116',
                'email' => 'ghea@example.test',
                'status' => 'valid',
                'admin_note' => 'Kuota prestasi sudah terisi penuh.',
                'submitted_at' => '2026-04-21 17:05:00',
                'special_data' => [
                    'achievement_type' => 'Non-Akademik',
                    'achievement_level' => 'Nasional',
                    'competition_name' => 'Lomba Video Kreatif Nasional',
                    'achievement_year' => '2025',
                ],
            ],
        ]);
    }

    protected function decorateRegistration(array $registration): array
    {
        $path = $this->pathDefinitions()->get($registration['path_code']);
        $status = config("spmb.statuses.{$registration['status']}");
        $submittedAt = Carbon::parse($registration['submitted_at']);
        $birthDate = Carbon::parse($registration['birth_date']);

        return array_merge($registration, [
            'path_name' => $path['name'],
            'status_label' => $status['label'],
            'gender_label' => config("spmb.genders.{$registration['gender']}"),
            'submitted_at_human' => $submittedAt->format('d M Y, H:i'),
            'submitted_at_date' => $submittedAt->format('d M Y'),
            'birth_date_human' => $birthDate->format('d M Y'),
            'age' => $birthDate->age,
        ]);
    }

    protected function pathDefinitions(): Collection
    {
        $overrides = $this->cacheGet($this->pathSettingsCacheKey, []);

        return collect(config('spmb.paths', []))
            ->map(function (array $path, string $code) use ($overrides) {
                $override = $overrides[$code] ?? [];

                return array_merge($path, array_filter([
                    'capacity' => isset($override['capacity']) ? (int) $override['capacity'] : null,
                    'is_active' => isset($override['is_active']) ? (bool) $override['is_active'] : null,
                    'close_when_full' => isset($override['close_when_full']) ? (bool) $override['close_when_full'] : null,
                ], fn ($value) => $value !== null));
            });
    }

    protected function registrationsRaw(): Collection
    {
        $registrations = $this->cacheGet($this->registrationsCacheKey);

        if (! is_array($registrations)) {
            $registrations = $this->shouldSeedSampleData()
                ? $this->seedRegistrations()->values()->all()
                : [];
            $this->cacheForever($this->registrationsCacheKey, $registrations);
        }

        return collect($registrations);
    }

    protected function registrations(): Collection
    {
        return $this->registrationsRaw()
            ->map(fn (array $registration) => $this->decorateRegistration($registration));
    }

    protected function storeRegistration(array $attributes, bool $respectProvidedStatus = false): array
    {
        $registrations = $this->registrationsRaw();
        $submittedAt = Carbon::now();
        $nextId = ((int) $registrations->max('id')) + 1;
        $sequence = str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);

        $record = array_merge([
            'id' => $nextId,
            'registration_number' => sprintf('REG-%s', $sequence),
            'status' => 'valid',
            'admin_note' => 'Pendaftaran langsung ditandai valid.',
            'submitted_at' => $submittedAt->toDateTimeString(),
        ], $attributes);

        if (! $respectProvidedStatus) {
            $record['status'] = 'valid';
        }

        $registrations->push($record);
        $this->cacheForever($this->registrationsCacheKey, $registrations->values()->all());

        return $this->decorateRegistration($record);
    }

    protected function buildSpecialData(array $validated): array
    {
        return match ($validated['path_code']) {
            'DOM' => [
                'distance' => $validated['distance'] ?? null,
            ],
            'AFR' => [
                'affirmation_type' => $validated['affirmation_type'] ?? null,
                'card_number' => $validated['card_number'] ?? null,
                'support_note' => $validated['support_note'] ?? null,
            ],
            'PRS' => [
                'achievement_type' => $validated['achievement_type'] ?? null,
                'achievement_level' => $validated['achievement_level'] ?? null,
                'competition_name' => $validated['competition_name'] ?? null,
                'achievement_year' => $validated['achievement_year'] ?? null,
            ],
            'MUT' => [
                'mutation_reason' => $validated['mutation_reason'] ?? null,
                'parent_workplace' => $validated['parent_workplace'] ?? null,
            ],
            default => [],
        };
    }

    protected function shouldSeedSampleData(): bool
    {
        return app()->environment('testing') || (bool) config('spmb.seed_sample_data', false);
    }

    protected function cacheGet(string $key, mixed $default = null): mixed
    {
        foreach ($this->cacheStores() as $store) {
            try {
                return $store->get($key, $default);
            } catch (Throwable) {
                continue;
            }
        }

        return $default;
    }

    protected function cacheForever(string $key, mixed $value): void
    {
        foreach ($this->cacheStores() as $store) {
            try {
                $store->forever($key, $value);
                return;
            } catch (Throwable) {
                continue;
            }
        }
    }

    /**
     * @return array<int, CacheRepository>
     */
    protected function cacheStores(): array
    {
        $stores = [];

        foreach (array_unique([
            (string) config('spmb.cache_store', config('cache.default')),
            (string) config('spmb.fallback_cache_store', 'file'),
        ]) as $storeName) {
            try {
                $stores[] = Cache::store($storeName);
            } catch (Throwable) {
                continue;
            }
        }

        return $stores;
    }
}
