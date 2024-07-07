<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        $cliente = Cliente::all();

        return view('user.painel_user', ['users' => $user, 'clientes'=> $cliente]);
    }
    public function read()
    {

        return view("user.user_details");
    }
    public function details($id)
    {
        $user = User::find($id); // Buscar o usuário pelo ID

        return view('user.painel_user_details', compact('user'));
    }

    public function update()
    {

        return view("user.user_details");
    }
}
