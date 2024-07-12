<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'projeto' => 'required|string|max:255',
        ]);

        // Criação de um novo cliente
        Cliente::create([
            'name' => $request->name,
            'projeto' => $request->projeto,
        ]);

        // Redirecionamento com mensagem de sucesso
        return redirect()->route('user.painel_user')->with('success', 'Cliente criado com sucesso.');
    }
    public function update(Request $request, $id)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'projeto' => 'required|string|max:255',
        ]);

        // Encontrar o cliente e atualizar suas informações
        $cliente = Cliente::findOrFail($id);
        $cliente->update([
            'name' => $request->name,
            'projeto' => $request->projeto,
        ]);

        // Redirecionamento com mensagem de sucesso
        return redirect()->route('user.painel_user')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function show($id)
    {
        // Encontrar o cliente pelo ID e retornar os dados em JSON
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }


    public function destroy($id)
    {

        $cliente = Cliente::findOrFail($id);

        $cliente->delete();


        return redirect()->route('user.painel_user')->with('delete', 'Cliente deletado com sucesso.');
    }
}
