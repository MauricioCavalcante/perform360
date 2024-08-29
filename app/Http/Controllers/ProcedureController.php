<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        return view('procedures.service_itinerary', compact('procedures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'procedure' => ['nullable', 'string'],
        ]);

        try {
            Procedure::create([
                'text' => $request->input('procedure'),
            ]);
            return back()->with('success', 'Procedimento adicionado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar procedimento: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar procedimento, tente novamente!');
        }
    }

    public function edit($id)
    {
        $procedure = Procedure::findOrFail($id);
        return view('procedures.service_itinerary', compact('procedure'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'procedure' => ['nullable', 'string'],
        ]);

        try {
            $procedure = Procedure::findOrFail($id);
            $procedure->text = $request->input('procedure');
            $procedure->save();
            return back()->with('success', 'Procedimento alterado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar procedimento: ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar procedimento.');
        }
    }

    public function delete($id){

        try{
            $procedure = Procedure::findOrFail($id);
            $procedure->delete();

            return redirect()->route('procedures.index')->with('success', 'Procedimento excluído com sucesso.');
        } catch (\Exception $e){
            Log::error('Erro ao excluir procedimento: ' . $e->getMessage());
            return redirect()->route('procedures.index')->withErrors(['error' => 'Erro ao excluir procedimento.']);
        }



    }
}
