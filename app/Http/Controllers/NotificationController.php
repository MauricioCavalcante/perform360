<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification; // Importe o modelo Notification
use App\Models\Avaliacoe;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = Notification::with('avaliacao')->orderBy('created_at', 'desc')->get();
    return view('avaliacoes.notificacao', compact('notifications'));
}

}
