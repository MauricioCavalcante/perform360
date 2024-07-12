<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Cliente;
use App\Models\Questionario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Obter todos os usuários, clientes, avaliações e questionários
        $users = User::all();
        $clientes = Cliente::all();
        $avaliacoes = Avaliacao::all();

        return view('user.painel_user', [
            'users' => $users,
            'clientes' => $clientes,
            'avaliacoes' => $avaliacoes,
        ]);
    }


    public function read()
    {
        $cliente = Cliente::all();
        $avaliacao = Avaliacao::all();
        return view("user.user_details", ['avaliacaos' => $avaliacao, 'clientes' => $cliente]);
    }
    public function details($id)
    {
        $users = User::find($id);
        $clienteIds = json_decode($users->cliente);


        $clientes = Cliente::all();
        $avaliacao = Avaliacao::where('id_user', $users->id)->get();

        return view('user.painel_user_details', compact('users', 'avaliacao', 'clientes'));
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
    public function viewUsuarios(){
        $users = User::all();
        $cliente = Cliente::all();
        $avaliacao = Avaliacao::all();

        return view('user.painel_usuarios', ['avaliacaos' => $avaliacao, 'clientes' => $cliente, 'users'=> $users]);
    }
    
    public function viewClientes(){
  
        $clientes = Cliente::all();
        $avaliacaos = Avaliacao::all();

        return view('user.painel_clientes', ['avaliacaos' => $avaliacaos, 'clientes' => $clientes]);
    }
    
    public function viewQuestionarios(Request $request){

        $clientes = Cliente::all();

        $query = Questionario::query();

        $filtroClienteId = $request->get('cliente_id');
        if ($filtroClienteId) {
            // Filtrar os questionários pelo cliente selecionado
            $query->where('cliente_id', 'like', "%$filtroClienteId%");
        }

        $questionarios = $query->get();
        $somaDasNotas = $questionarios->sum('nota');

        $avaliacaos = Avaliacao::all();
        return view('user.painel_questionarios', [
            'avaliacaos' => $avaliacaos, 
            'clientes' => $clientes,
            'questionarios' => $questionarios,
            'somaDasNotas' => $somaDasNotas,
            'filtroClienteId' => $filtroClienteId,
        ]);
    }

}
    
