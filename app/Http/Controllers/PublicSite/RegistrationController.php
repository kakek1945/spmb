<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function create(Request $request, DemoSpmbRepository $repository)
    {
        return view('public.register', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
            'selectedPath' => strtoupper((string) $request->query('jalur', old('path_code', ''))),
            'genders' => config('spmb.genders'),
            'affirmationTypes' => config('spmb.affirmation_types'),
            'achievementTypes' => config('spmb.achievement_types'),
            'achievementLevels' => config('spmb.achievement_levels'),
        ]);
    }

    public function store(Request $request, DemoSpmbRepository $repository)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'digits:10'],
            'nik' => ['nullable', 'digits_between:16,16'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', Rule::in(array_keys(config('spmb.genders', [])))],
            'address' => ['required', 'string', 'max:500'],
            'previous_school' => ['required', 'string', 'max:255'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'digits_between:10,15'],
            'email' => ['nullable', 'email'],
            'path_code' => ['required', Rule::in(array_keys(config('spmb.paths', [])))],
            'village' => ['nullable', 'string', 'max:150'],
            'district' => ['nullable', 'string', 'max:150'],
            'distance' => ['nullable', 'string', 'max:50'],
            'affirmation_type' => ['nullable', Rule::in(array_keys(config('spmb.affirmation_types', [])))],
            'card_number' => ['nullable', 'string', 'max:100'],
            'support_note' => ['nullable', 'string', 'max:500'],
            'achievement_type' => ['nullable', Rule::in(array_keys(config('spmb.achievement_types', [])))],
            'achievement_level' => ['nullable', Rule::in(array_keys(config('spmb.achievement_levels', [])))],
            'competition_name' => ['nullable', 'string', 'max:255'],
            'achievement_year' => ['nullable', 'digits:4'],
            'mutation_reason' => ['nullable', 'string', 'max:255'],
            'parent_workplace' => ['nullable', 'string', 'max:255'],
        ]);

        $conditionalRules = match ($validated['path_code']) {
            'DOM' => [
                'village' => ['required', 'string', 'max:150'],
                'district' => ['required', 'string', 'max:150'],
            ],
            'AFR' => [
                'affirmation_type' => ['required', Rule::in(array_keys(config('spmb.affirmation_types', [])))],
            ],
            'PRS' => [
                'achievement_type' => ['required', Rule::in(array_keys(config('spmb.achievement_types', [])))],
                'achievement_level' => ['required', Rule::in(array_keys(config('spmb.achievement_levels', [])))],
                'competition_name' => ['required', 'string', 'max:255'],
                'achievement_year' => ['required', 'digits:4'],
            ],
            'MUT' => [
                'mutation_reason' => ['required', 'string', 'max:255'],
                'parent_workplace' => ['required', 'string', 'max:255'],
            ],
        };

        validator($validated, $conditionalRules)->validate();

        $latestRegistration = $request->session()->get('latest_registration');
        $nisnAlreadyUsedInSession = is_array($latestRegistration)
            && ($latestRegistration['nisn'] ?? null) === $validated['nisn'];

        if ($repository->registrationExistsByNisn($validated['nisn']) || $nisnAlreadyUsedInSession) {
            throw ValidationException::withMessages([
                'nisn' => 'NISN ini sudah pernah digunakan untuk prapendaftaran.',
            ]);
        }

        $selectedPath = Arr::get($repository->pathOptions(), $validated['path_code']);

        if (! $selectedPath || ! $selectedPath['is_active']) {
            throw ValidationException::withMessages([
                'path_code' => 'Jalur yang dipilih sedang tidak aktif.',
            ]);
        }

        if (! $selectedPath['is_selectable']) {
            throw ValidationException::withMessages([
                'path_code' => 'Jalur yang dipilih sudah penuh. Silakan pilih jalur lain.',
            ]);
        }

        $previewRegistration = $repository->createPreviewRegistration($validated);

        $request->session()->put('latest_registration', $previewRegistration);

        return redirect()->route('registration.success', $previewRegistration['registration_number']);
    }

    public function success(string $registrationNumber, Request $request, DemoSpmbRepository $repository)
    {
        $latestRegistration = $request->session()->get('latest_registration');
        $registration = $latestRegistration && $latestRegistration['registration_number'] === $registrationNumber
            ? $latestRegistration
            : $repository->findRegistration($registrationNumber);

        abort_if($registration === null, 404);

        return view('public.success', [
            'brand' => $repository->branding(),
            'registration' => $registration,
        ]);
    }

    public function print(string $registrationNumber, Request $request, DemoSpmbRepository $repository)
    {
        $latestRegistration = $request->session()->get('latest_registration');
        $registration = $latestRegistration && $latestRegistration['registration_number'] === $registrationNumber
            ? $latestRegistration
            : $repository->findRegistration($registrationNumber);

        abort_if($registration === null, 404);

        return view('public.print-card', [
            'brand' => $repository->branding(),
            'registration' => $registration,
        ]);
    }
}
