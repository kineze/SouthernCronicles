<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeakersController extends Controller
{
    public function allSpeakers(){

        return view('dashboards.admin.allSpeakers');
    }

     public function index()
    {
        return Speaker::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'image' => 'required|image|max:2048'
        ]);

        $data['image'] = $request->file('image')->store('speakers', 'public');
        return Speaker::create($data);
    }

    public function update(Request $request, Speaker $speaker)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($speaker->image);
            $data['image'] = $request->file('image')->store('speakers', 'public');
        }

        $speaker->update($data);
        return $speaker;
    }

    public function destroy(Speaker $speaker)
    {
        Storage::disk('public')->delete($speaker->image);
        $speaker->delete();
        return response()->noContent();
    }
    
}
