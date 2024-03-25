<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use League\Csv\Reader;


class AdminController extends Controller
{
    //

    public function AltaAdmin()
    {
        return Inertia::render('Admin/AltaAdmin');
    }
    public function StoreAdmin(Request $request)
    {
        $val = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'isAdmin' => ['required', 'boolean']
        ]);

        $user = User::create($val);
    }
    public function ListarProvedores(Request $request)
    {
        return Inertia::render('Admin/ListarProvedores', [
            'provedores' => User::where('isAdmin', false)->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate(10),
            'query' => $request->only(['search']),
        ]);
    }
    public function AddDiscount(Request $request, $id)
    {

        $attributes = $request->validate([
            'descuento' => ['required', 'numeric']
        ]);
        $client = User::find($id);

        $client->Descuento = $request->input('descuento');
        $client->save();
    }

    public function LoadCSV()
    {
        return Inertia::render('Admin/CargaCSV');
    }
    public function StoreCSV(Request $request)
    {

        $request->validate([
            'csv' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv');
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Suponiendo que la primera fila son los encabezados

        $bulkWrite = [];

        try {
            foreach ($csv->getRecords() as $record) {

                $bulkWrite[] = [
                    'updateOne' => [
                        ['Articulo' => $record['Articulo']], // Filtro de búsqueda
                        ['$set' => $record], // Datos a actualizar o insertar
                        ['upsert' => true] // Upsert: crea un nuevo documento si no se encuentra
                    ]
                ];
            }

            // Realizar la operación bulkWrite
            Producto::raw(function ($collection) use ($bulkWrite) {
                $collection->bulkWrite($bulkWrite);
            });
        } catch (\Throwable $th) {
            // Manejar la excepción si es necesario
            ddd($th);
        }
    }
}
