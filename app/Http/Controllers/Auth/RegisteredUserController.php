<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Grupo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $clientes = Cliente::all();
        $grupos = Grupo::all();
        return view('auth.register', compact('clientes', 'grupos'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ramal' => ['nullable', 'string', 'max:20'],
            'grupo_id' => ['nullable', Rule::exists('grupos', 'id')],
            'cliente_id' => ['nullable', 'array'],
            'cliente_id.*' => ['exists:clientes,id'],
        ]);

        // Verificar se o grupo_id existe na tabela grupos
        if ($request->grupo_id && !Grupo::find($request->grupo_id)) {
            return redirect()->route('register')->withErrors(['grupo_id' => 'Grupo selecionado inválido.']);
        }

        // Configuração automática para username
        $username = explode('@', $request->email)[0];

        try {
            // Converte o array de IDs em uma string separada por vírgula
            $clienteIds = implode(',', $request->cliente_id);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $username,
                'password' => Hash::make($request->password),
                'ramal' => $request->ramal,
                'score' => 100, // Valor padrão inicial para score
                'grupo_id' => $request->grupo_id,
                'cliente_id' => $clienteIds, // Salva como string separada por vírgula
            ]);

            if (!$user) {
                throw new \Exception('Erro ao criar usuário.');
            }

            event(new Registered($user));

            return redirect()->route('user.painel_user')->with('success','Usuário criado com sucesso!');
        } catch (\Exception $e) {
            // Registra o erro no log e retorna para a página de registro com uma mensagem de erro
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());
            return redirect()->route('register')->withErrors(['error' => 'Erro ao registrar usuário.']);
        }
    }
}
