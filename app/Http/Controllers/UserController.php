<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Client;
use App\Models\Questionnaire;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $clients = Client::all();
        $evaluations = Evaluation::all();


        return view('users.panel_users', compact('users', 'clients', 'evaluations'));
    }

    public function read()
    {
        $user = Auth::user();

        if (!$user) {
            abort(404, 'Usuário não encontrado');
        }

        $evaluation = Evaluation::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $avgScore = round(Evaluation::where('user_id', $user->id)->avg('score'), 1);

        $client = Client::all();

        return view('users.user', compact('user', 'evaluation', 'client', 'avgScore'));
    }
    public function details($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.panel_users_details')->with('error', 'Usuário não encontrado.');
        }

        $clientIds = json_decode($user->client_id);
        $clients = Client::all();
        $group = Group::all();
        $evaluation = Evaluation::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $avgScore = round(Evaluation::where('user_id', $user->id)->avg('score'), 1);

        return view('users.panel_users_details', compact('user', 'evaluation', 'clients', 'avgScore', 'group'));
    }
    public function updateName(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        $user->name = $request->input('name');
        $user->save();

        return redirect()->route('users.panel_users_details', ['id' => $user->id])
            ->with('status', 'Nome atualizado com sucesso.');
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
                'phone' => ['nullable', 'string', 'max:255'],
                'group_id' => ['required', Rule::exists('groups', 'id')],
                'client_id' => ['nullable', 'array'],
                'client_id.*' => ['exists:clients,id'],
        ]);


        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        $username = explode('@', $request->email)[0];
        $clientIds = $request->input('client_id', []);

        $user->email = $request->input('email');
        $user->username = $username;
        $user->client_id = json_encode($clientIds);
        $user->group_id = $request->input('group_id');
        $user->phone = $request->input('phone');
        $user->save();

        return redirect()->route('users.panel_users_details', ['id' => $user->id])
            ->with('status', 'Dados atualizados com sucesso.');
    }

}

