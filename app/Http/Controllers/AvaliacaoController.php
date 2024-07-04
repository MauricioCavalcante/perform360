<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function create(){
        
    }
    public function read(){
        return view('avaliacoes.painel');
    }

    public function store(Request $request){
        return view('avaliacoes.nova_avaliacao');
    }

    public function details($id){
        return view('avaliacoes.details_avaliacao',['id'=>$id]);
    }

}
