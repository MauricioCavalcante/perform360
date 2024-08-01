<?php

namespace App\Http\Controllers;

//Models
use App\Models\Client;
use App\Models\Evaluation;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index (){
        $client = Client::all();
        $evaluation = Evaluation::all();

        return view('clients.panel_clients', compact('evaluation', 'client'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        Client::create([
            'name' => $request->name,
            'codigo' => $request->codigo,
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        $client = Client::findOrFail($id);
        $client->update([
            'name' => $request->name,
            'codigo' => $request->codigo,
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso.');
    }
}

