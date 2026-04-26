<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CapacityController extends Controller
{
    public function __invoke(DemoSpmbRepository $repository)
    {
        return view('admin.capacity', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
        ]);
    }

    public function update(Request $request, DemoSpmbRepository $repository): RedirectResponse
    {
        $pathsData = $request->input('paths', []);
        $rules = [];
        $messages = [];

        foreach ($pathsData as $code => $data) {
            $path = $repository->pathOptions()[$code] ?? null;
            if ($path) {
                $rules["paths.{$code}.capacity"] = ['required', 'integer', 'min:'.$path['registered']];
                $messages["paths.{$code}.capacity.min"] = "Kapasitas {$path['name']} minimal {$path['registered']} karena sudah ada pendaftar.";
            }
        }

        $request->validate($rules, $messages);

        foreach ($pathsData as $code => $data) {
            $path = $repository->pathOptions()[$code] ?? null;
            if ($path) {
                $repository->updatePathSettings($code, [
                    'capacity' => (int) $data['capacity'],
                    'is_active' => !empty($data['is_active']),
                    'close_when_full' => !empty($data['close_when_full']),
                ]);
            }
        }

        return redirect()
            ->route('admin.capacity')
            ->with('capacity_message', "Pengaturan untuk semua jalur berhasil disimpan.");
    }
}
