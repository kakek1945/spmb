<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function edit(DemoSpmbRepository $repository)
    {
        return view('admin.password.edit', [
            'brand' => $repository->branding(),
        ]);
    }

    public function update(Request $request, DemoSpmbRepository $repository): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $adminEmail = (string) ($request->session()->get('admin_email') ?: $repository->adminCredentials()['email']);

        if (! $repository->validateAdminCredentials($adminEmail, $validated['current_password'])) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $repository->updateAdminPassword($validated['password']);

        return redirect()
            ->route('admin.password.edit')
            ->with('password_message', 'Password admin berhasil diperbarui.');
    }
}
