<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification; // Importe o modelo Notification

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('avaliacoes.notificacao', compact('notifications')); // Alterei de 'notificacoes' para 'notificacao'
    }
}