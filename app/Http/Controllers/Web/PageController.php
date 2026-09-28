<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Welcome');
    }

    public function about(): Response
    {
        return Inertia::render('Web/About');
    }

    public function contact(): Response
    {
        return Inertia::render('Web/Contact');
    }

    public function shopping(): Response
    {
        return Inertia::render('Web/carts/Shopping');
    }

    public function checkout(): Response
    {
        return Inertia::render('Web/carts/Checkout');
    }

    public function dashboard(): Response
    {
        return Inertia::render('Dashboard');
    }
}
