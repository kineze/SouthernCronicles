<?php

namespace App\Http\Controllers;

use App\Models\UsefulLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsefulLinkController extends Controller
{
    public function usefullLinks(){

        return view('dashboards.admin.usefullLinks');
    }

    public function index()
    {
        return UsefulLink::latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'url'   => ['required','url','max:2048'],
            'image' => ['nullable','image','max:4096'], // 4MB
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('links', 'public');
        }

        $link = UsefulLink::create($data);
        return response()->json($link, 201);
    }

    public function show(UsefulLink $usefulLink)
    {
        return $usefulLink;
    }

    public function update(Request $request, UsefulLink $usefulLink)
    {
        $data = $request->validate([
            'title' => ['sometimes','required','string','max:255'],
            'url'   => ['sometimes','required','url','max:2048'],
            'image' => ['nullable','image','max:4096'],
        ]);

        if ($request->hasFile('image')) {
            // delete old if exists
            if ($usefulLink->image && Storage::disk('public')->exists($usefulLink->image)) {
                Storage::disk('public')->delete($usefulLink->image);
            }
            $data['image'] = $request->file('image')->store('links', 'public');
        }

        $usefulLink->update($data);
        return response()->json($usefulLink);
    }

    public function destroy(UsefulLink $usefulLink)
    {
        if ($usefulLink->image && Storage::disk('public')->exists($usefulLink->image)) {
            Storage::disk('public')->delete($usefulLink->image);
        }
        $usefulLink->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
