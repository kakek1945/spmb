<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;

class DashboardController extends Controller
{
    public function __invoke(DemoSpmbRepository $repository)
    {
        return view('admin.dashboard', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
            'stats' => $repository->dashboardStats(),
            'recentRegistrations' => $repository->recentRegistrations(6),
        ]);
    }
}
