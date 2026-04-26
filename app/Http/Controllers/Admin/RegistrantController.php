<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrantController extends Controller
{
    public function index(Request $request, DemoSpmbRepository $repository)
    {
        $filters = $request->only(['search', 'path', 'status', 'date_from', 'date_to', 'sort']);

        return view('admin.registrants.index', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
            'statuses' => $repository->statuses(),
            'registrations' => $repository->paginatedRegistrations($filters),
            'filters' => $filters,
        ]);
    }

    public function show(string $id, DemoSpmbRepository $repository)
    {
        $registration = $repository->findRegistration($id);

        abort_if($registration === null, 404);

        return view('admin.registrants.show', [
            'brand' => $repository->branding(),
            'statuses' => $repository->statuses(),
            'registration' => $registration,
        ]);
    }

    public function create(DemoSpmbRepository $repository)
    {
        return view('admin.registrants.form', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
            'statuses' => $repository->statuses(),
            'genders' => config('spmb.genders'),
            'affirmationTypes' => config('spmb.affirmation_types'),
            'achievementTypes' => config('spmb.achievement_types'),
            'achievementLevels' => config('spmb.achievement_levels'),
            'registration' => null,
            'formAction' => route('admin.registrants.store'),
            'formMethod' => 'POST',
        ]);
    }

    public function store(Request $request, DemoSpmbRepository $repository): RedirectResponse
    {
        $registration = $repository->createAdminRegistration(
            $this->validateRegistration($request, $repository)
        );

        return redirect()
            ->route('admin.registrants.show', $registration['id'])
            ->with('registrant_message', 'Data pendaftar berhasil ditambahkan.');
    }

    public function edit(string $id, DemoSpmbRepository $repository)
    {
        $registration = $repository->findRegistration($id);

        abort_if($registration === null, 404);

        return view('admin.registrants.form', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
            'statuses' => $repository->statuses(),
            'genders' => config('spmb.genders'),
            'affirmationTypes' => config('spmb.affirmation_types'),
            'achievementTypes' => config('spmb.achievement_types'),
            'achievementLevels' => config('spmb.achievement_levels'),
            'registration' => $registration,
            'formAction' => route('admin.registrants.update', $registration['id']),
            'formMethod' => 'PUT',
        ]);
    }

    public function update(string $id, Request $request, DemoSpmbRepository $repository): RedirectResponse
    {
        $registration = $repository->findRegistration($id);
        abort_if($registration === null, 404);

        $updated = $repository->updateRegistration(
            $id,
            $this->validateRegistration($request, $repository, $registration['id'])
        );

        return redirect()
            ->route('admin.registrants.show', $updated['id'])
            ->with('registrant_message', 'Data pendaftar berhasil diperbarui.');
    }

    public function destroy(string $id, DemoSpmbRepository $repository): RedirectResponse
    {
        $registration = $repository->findRegistration($id);
        abort_if($registration === null, 404);

        $repository->deleteRegistration($id);

        return redirect()
            ->route('admin.registrants.index')
            ->with('registrant_message', 'Data pendaftar berhasil dihapus.');
    }

    protected function validateRegistration(Request $request, DemoSpmbRepository $repository, string|int|null $exceptId = null): array
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'digits:10'],
            'nik' => ['nullable', 'digits:16'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', Rule::in(array_keys(config('spmb.genders', [])))],
            'address' => ['required', 'string', 'max:500'],
            'previous_school' => ['required', 'string', 'max:255'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'digits_between:10,15'],
            'email' => ['nullable', 'email'],
            'path_code' => ['required', Rule::in(array_keys(config('spmb.paths', [])))],
            'status' => ['required', Rule::in(array_keys(config('spmb.statuses', [])))],
            'admin_note' => ['nullable', 'string', 'max:500'],
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

        if ($repository->registrationExistsByNisnExcept($validated['nisn'], $exceptId)) {
            return validator([], [])->after(function ($validator) {
                $validator->errors()->add('nisn', 'NISN ini sudah digunakan pendaftar lain.');
            })->validate();
        }

        validator($validated, match ($validated['path_code']) {
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
        })->validate();

        return $validated;
    }
}
