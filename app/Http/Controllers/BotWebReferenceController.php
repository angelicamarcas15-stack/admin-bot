<?php

namespace App\Http\Controllers;

use App\Models\BotWebReference;
use Illuminate\Http\Request;

class BotWebReferenceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|url|max:500'
        ]);

        BotWebReference::create($request->only('title', 'url'));

        return back()->with('success', 'Referencia web agregada.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|url|max:500'
        ]);

        BotWebReference::findOrFail($id)->update($request->only('title', 'url'));

        return back()->with('success', 'Referencia actualizada.');
    }

    public function delete($id)
    {
        BotWebReference::findOrFail($id)->delete();

        return back()->with('success', 'Referencia eliminada.');
    }
}
