<?php

namespace App\Http\Controllers;

use App\Models\SpeakerType;
use Illuminate\Http\Request;

class SpeakerTypeController extends Controller
{
    public function index()
    {
        return SpeakerType::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $speakerType = SpeakerType::create($request->only('name'));
        return response()->json($speakerType, 201);
    }

    public function update(Request $request, SpeakerType $speakerType)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $speakerType->update($request->only('name'));
        return response()->json($speakerType);
    }

    public function destroy(SpeakerType $speakerType)
    {
        $speakerType->delete();
        return response()->json(['message' => 'Deleted']);
    }

}
