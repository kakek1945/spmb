<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoSpmbRepository;

class ReportController extends Controller
{
    public function __invoke(DemoSpmbRepository $repository)
    {
        return view('admin.reports.index', [
            'brand' => $repository->branding(),
            'rows' => $repository->reportRows(),
        ]);
    }
}
