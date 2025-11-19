<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIAssistantSettingsController extends Controller
{
    public function index()
    {
        return view('admin.ai_assistant_settings');
    }

    public function update(Request $request)
    {
        // Aquí validas y guardas la configuración del Asistente IA
        // Ejemplo:
        // $request->validate([
        //     'model' => 'required',
        //     'temperature' => 'required|numeric',
        // ]);

        // Config::set('ai.settings', $request->all());

        return back()->with('success', 'AI Assistant settings updated successfully.');
    }
}
