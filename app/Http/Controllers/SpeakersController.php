<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use App\Models\SpeakerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeakersController extends Controller
{
    public function allSpeakers(){

        return view('dashboards.admin.allSpeakers');
    }

    public function speakerTypes(){

        return view('dashboards.admin.speakerTypes');
    }

    public function index(Request $request)
    {
        $speakers = Speaker::query();
        
        if ($request->ordered) {
            $speakers->orderBy('order');
        } else {
            $speakers->latest();
        }

        return $speakers->get();
    }


    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Speaker::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Order updated']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'speaker_type_id' => 'nullable|exists:speaker_types,id',
            'show_on_home' => 'nullable|boolean',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048'
        ]);

        $data['image'] = $request->file('image')->store('speakers', 'public');
        $data['show_on_home'] = $request->boolean('show_on_home');

        return Speaker::create($data);
    }

    public function update(Request $request, Speaker $speaker)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'speaker_type_id' => 'nullable|exists:speaker_types,id',
            'show_on_home' => 'nullable|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            Storage::disk('public')->delete($speaker->image);
            $data['image'] = $request->file('image')->store('speakers', 'public');
        }

        $data['show_on_home'] = $request->boolean('show_on_home');

        $speaker->update($data);
        return $speaker;
    }


    public function destroy(Speaker $speaker)
    {
        Storage::disk('public')->delete($speaker->image);
        $speaker->delete();
        return response()->noContent();
    }

    public function types()
    {
        return SpeakerType::all();
    }

    public function byType($typeId)
    {
        $speakers = Speaker::where('speaker_type_id', $typeId)
        ->orderBy('order')
        ->get();

        return response()->json($speakers);
    }
    
//     public function getByType($typeId)
// {
//     $speakers = Speaker::where('speaker_type_id', $typeId)
//         ->orderBy('order') // <== enforce the order
//         ->get();

//     return response()->json($speakers);
// }
}
