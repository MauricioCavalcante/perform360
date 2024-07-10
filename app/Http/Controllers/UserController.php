<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        $cliente = Cliente::all();
        $avaliacao = Avaliacao::all();


        return view('user.painel_user', ['users' => $user, 'clientes' => $cliente, 'avaliacaos' => $avaliacao]);
    }

    public function read()
    {
        $cliente = Cliente::all();
        $avaliacao = Avaliacao::all();
        return view("user.user_details", ['avaliacaos' => $avaliacao, 'clientes' => $cliente]);
    }
    public function details($id)
    {
        $user = User::find($id);

        // Decodificar o JSON na coluna cliente para obter um array de IDs de cliente
        $clienteIds = json_decode($user->cliente);

        // Carregar os objetos Cliente com base nos IDs
        $clientes = Cliente::all();
        $avaliacao = Avaliacao::where('id_user', $user->id)->get();

        return view('user.painel_user_details', compact('user', 'avaliacao', 'clientes'));
    }


    public function updateName(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        $user->name = $request->input('name');
        $user->save();

        return redirect()->route('user.painel_user_details', ['id' => $user->id])
            ->with('status', 'Nome atualizado com sucesso.');
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $cliente = Cliente::all();
        $avaliacao = Avaliacao::all();

        $request->validate([
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'num_chamado' => ['nullable', 'string', 'max:255'],
            'titulo' => ['required', 'string', 'max:255'],
            'cliente' => ['nullable', 'exists:clientes,id'],
        ]);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        $user->email = $request->input('email');
        $user->cliente = $request->input('cliente');
        $user->role = $request->input('role');
        $user->ramal = $request->input('ramal');
        $user->save();

        return redirect()->route('user.painel_user_details', ['id' => $user->id, 'avaliacaos' => $avaliacao, 'clientes' => $cliente])
            ->with('status', 'Dados atualizados com sucesso.');
    }
}
