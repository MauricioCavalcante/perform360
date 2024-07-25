<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {

        return view('auth.register', [
            'groups' => \App\Models\Group::all(),
            'clients' => \App\Models\Client::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Dados recebidos para registro:', $request->all());
    
        try {
            // Validação dos dados recebidos
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:255'],
                'group_id' => ['required', Rule::exists('groups', 'id')],
                'client_id' => ['nullable', 'array'],
                'client_id.*' => ['exists:clients,id'],
            ]);
    
            // Extração do nome de usuário a partir do email
            $username = explode('@', $request->email)[0];
            $clientIds = $request->input('client_id', []);

            // Criação do usuário no banco de dados
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'username' => $username,
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
                'score' => 100,
                'group_id' => $validatedData['group_id'],
                'client_id' => json_encode($clientIds),
            ]);
            
            // Log para verificar o usuário criado
            Log::info('Usuário criado com sucesso', ['user_id' => $user->id, 'name' => $user->name]);
    
            // Lançar evento de registro do usuário
            event(new Registered($user));
    
            // Redirecionamento após sucesso
            return redirect()->route('register')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            // Log de erro em caso de falha
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());
    
            // Redirecionamento em caso de erro
            return redirect()->route('register')->withErrors(['error' => 'Erro ao registrar usuário.']);
        }
    
    }

    public function createAdmin(): View
    {
        return view('admin.register', [
            'groups' => \App\Models\Group::all(),
            'clients' => \App\Models\Client::all(),
        ]);
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        Log::info('Dados recebidos para registro:', $request->all());
    
        try {
            // Validação dos dados recebidos
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:255'],
                'group_id' => ['required', Rule::exists('groups', 'id')],
                'client_id' => ['nullable', 'array'],
                'client_id.*' => ['exists:clients,id'],
            ]);
    
            // Extração do nome de usuário a partir do email
            $username = explode('@', $request->email)[0];
            $clientIds = $request->input('client_id', []);

            // Criação do usuário no banco de dados
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'username' => $username,
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
                'score' => 100,
                'group_id' => $validatedData['group_id'],
                'client_id' => json_encode($clientIds),
            ]);
            
            // Log para verificar o usuário criado
            Log::info('Usuário criado com sucesso', ['user_id' => $user->id, 'name' => $user->name]);
    
            // Lançar evento de registro do usuário
            event(new Registered($user));
    
            // Redirecionamento após sucesso
            return redirect()->route('register_admin')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            // Log de erro em caso de falha
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());
    
            // Redirecionamento em caso de erro
            return redirect()->route('register_admin')->withErrors(['error' => 'Erro ao registrar usuário.']);
        }
    }
    
}
