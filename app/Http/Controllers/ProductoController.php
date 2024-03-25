<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    //
    public function index(Request $request)
    {
        return Inertia::render('Dashboard', [
            'productos' => Producto::query()->when($request->input('search'), function ($query, $search) {
                $query->where('Categoria', 'like', '%' . $search . '%');
                $query->orWhere('OBS', 'like', '%' . $search . '%');
                $query->orWhere('Color', 'like', '%' . $search . '%');
            })
                ->when($request->input('selectedCategory'), function ($query, $selectedCategory) {
                    $query->where('Categoria', 'like', '%' . $selectedCategory . '%');
                })
                ->paginate(20),
            'query' => $request->only(['search']),
            'categorias' => Producto::groupBy('Categoria')->pluck('Categoria')->toArray()
        ]);
    }
}
