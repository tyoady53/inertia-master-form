<?php

namespace App\Http\Controllers\Apps\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketsController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Tickets/Index');
    }

    public function create()
    {
        return Inertia::render('Apps/Tickets/Create');
    }
}
