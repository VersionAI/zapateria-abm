<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Return_;

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
            'email' => ['required','email','unique:users,email'],
            'password' => ['required', 'confirmed'],
            'isAdmin' => ['required','boolean']
        ]);      
       
        $user = User::create($val);
       
        
        
    }
    public function ListarProvedores()
    {
        return Inertia::render('Admin/ListarProvedores',[
            'provedores' => User::where('isAdmin',false)->paginate(10),
        ]);
    }
    public function AddDiscount(Request $request)
    {

    }

    public function LoadCSV()
    {

    }
    public function StoreCSV(Request $request)
    {

    }
}
