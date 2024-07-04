<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class IndexController extends Controller
{
    public function showIndex(): Response {
        // TODO: Show a simple landing page advertising Lumetra as a project
        return Inertia::render('Index');
    }
}
