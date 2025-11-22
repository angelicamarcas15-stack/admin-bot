<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BotKnowledgeFile;
use Illuminate\Support\Facades\Storage;

class BotKnowledgeFileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:20480', // solo PDF
        ]);

        $file = $request->file('file');

        // Guardar archivo en storage/app/public/bot_knowledge
        $path = $file->store('public/bot_knowledge');

        // Convertir ruta a formato público: storage/bot_knowledge/xxx.pdf
        $publicPath = str_replace('public/', 'storage/', $path);

        BotKnowledgeFile::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $publicPath,
            'file_size' => $file->getSize(),
        ]);

        return back()->with('success', 'Archivo PDF subido correctamente.');
    }

    /**
     * Eliminar archivo
     */
    public function delete($id)
    {
        $file = BotKnowledgeFile::findOrFail($id);

        // Convertir storage/... a public/... antes de borrar
        $storagePath = str_replace('storage/', 'public/', $file->file_path);

        // eliminar archivo físico
        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }

        // eliminar de la BD
        $file->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }
}
