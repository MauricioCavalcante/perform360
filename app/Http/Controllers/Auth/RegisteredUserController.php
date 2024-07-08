<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ramal' => ['nullable', 'string', 'max:20'],
            'grupos_id' => ['required', 'exists:grupos,id'],
            'clientes_id' => ['required', 'exists:clientes,id'], // Validação do tipo de cliente
        ]);

        // Configuração automática para username
        $username = explode('@', $request->email)[0];

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $username,
                'password' => Hash::make($request->password),
                'ramal' => $request->ramal,
                'grupos_id' => $request->grupos_id,
                'clientes_id' => $request->clientes_id, // Associa o tipo de cliente ao usuário
            ]);

            // Verifica se o usuário foi criado com sucesso
            if (!$user) {
                throw new \Exception('User not created');
            }

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('index');
        } catch (\Exception $e) {
            // Registra o erro no log e retorna para a página de registro com uma mensagem de erro
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());
            return redirect()->route('register')->withErrors(['error' => 'Erro ao registrar usuário.']);
        }
    }
}
