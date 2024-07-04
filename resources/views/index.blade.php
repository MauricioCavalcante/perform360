@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <main class="m-5">
        <h3>Bem vindo, {{ Auth::user()->name }} !</h3>
    </main>
@endsection
