<?php

namespace App\Http\Controllers;

use App\Models\BotConfiguration;
use App\Models\BotKnowledgeFile;
use App\Models\BotWebReference;
use Illuminate\Http\Request;

class BotConfigurationController extends Controller
{
    public function index()
    {
        $config = BotConfiguration::first();
        $files = BotKnowledgeFile::all();
        $webrefs = BotWebReference::all();
        return view('admin.ai_assistant_settings', compact('config', 'files', 'webrefs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'instructions' => 'required|string',
        ]);

        $config = BotConfiguration::create($data);

        return response()->json($config, 201);
    }

   public function update(Request $request, $id)
    {
        $config = BotConfiguration::findOrFail($id);

        $data = $request->validate([
            'instructions' => 'sometimes|string',
        ]);

        $config->update($data);

        return response()->json($config);
    }

    public function destroy($id)
    {
        $config = BotConfiguration::findOrFail($id);
        $config->delete();

        return response()->json(['message' => 'Configuración eliminada']);
    }
}
