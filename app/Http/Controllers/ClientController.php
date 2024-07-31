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
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        // Criação de um novo cliente
        Client::create([
            'name' => $request->name,
            'codigo' => $request->codigo,
        ]);

        // Redirecionamento com mensagem de sucesso
        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso.');
    }
    public function update(Request $request, $id)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        // Encontrar o cliente e atualizar suas informações
        $client = Client::findOrFail($id);
        $client->update([
            'name' => $request->name,
            'codigo' => $request->codigo,
        ]);

        // Redirecionamento com mensagem de sucesso
        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso.');
    }
}

