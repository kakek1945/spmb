<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(DemoSpmbRepository $repository)
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login', [
            'brand' => $repository->branding(),
        ]);
    }

    public function login(Request $request, DemoSpmbRepository $repository): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! $repository->validateAdminCredentials(
            (string) $request->string('email'),
            (string) $request->string('password')
        )) {
            return back()
                ->withErrors(['email' => 'Email atau password admin tidak sesuai.'])
                ->withInput($request->only('email'));
        }

        $request->session()->put('admin_authenticated', true);
        $request->session()->put('admin_email', (string) $request->string('email'));

        return redirect()
            ->route('admin.dashboard')
            ->with('login_message', 'Login berhasil. Anda masuk ke area admin.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['admin_authenticated', 'admin_email']);

        return redirect()->route('admin.login');
    }
}
