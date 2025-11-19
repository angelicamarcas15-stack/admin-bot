<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    /**
     * Página principal del chat.
     */
    public function index()
    {
        $users = User::orderBy('nombres')->get();
        return view('admin.chat', compact('users'));
    }

    /**
     * Devuelve los mensajes de un usuario.
     */
    public function fetchMessages($user_id)
    {
        return Message::where('user_id', $user_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Envía y guarda un nuevo mensaje.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'user_id' => $validated['user_id'],
            'message' => $validated['message'],
            'is_bot'  => 0, // 0 = humano, 1 = bot
        ]);

        // Notifica en tiempo real a todos los clientes conectados
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
