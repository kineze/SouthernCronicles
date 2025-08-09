<?php

namespace App\Http\Controllers;

use App\Models\SpeakerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpeakerTypeController extends Controller
{
    public function index()
    {
        return SpeakerType::orderBy('position')->orderBy('id')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);

        $maxPos = SpeakerType::max('position') ?? 0;

        $speakerType = SpeakerType::create([
            'name' => $data['name'],
            'position' => $maxPos + 1,
        ]);

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
        DB::transaction(function () use ($speakerType) {
            $deletedPos = $speakerType->position;
            $speakerType->delete();

            // Compact positions above the deleted one
            SpeakerType::where('position', '>', $deletedPos)
                ->decrement('position');
        });

        return response()->json(['message' => 'Deleted']);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:speaker_types,id',
        ]);

        DB::transaction(function () use ($data) {
            // order = [id1, id2, id3, ...] => position 1..N
            foreach ($data['order'] as $index => $id) {
                SpeakerType::where('id', $id)
                    ->update(['position' => $index + 1]);
            }
        });

        return response()->json(['message' => 'Order updated']);
    }

}
