<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;

class HomeController extends Controller
{
    public function __invoke(DemoSpmbRepository $repository)
    {
        return view('public.home', [
            'brand' => $repository->branding(),
            'paths' => $repository->registrationPaths(),
            'stats' => $repository->dashboardStats(),
            'recentRegistrations' => $repository->recentRegistrations(4),
        ]);
    }
}
