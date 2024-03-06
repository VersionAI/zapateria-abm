<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Dashboard',[
            'productos' => Producto::paginate(5)
        ]);
    }
}
