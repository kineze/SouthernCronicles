<?php

// app/Http/Controllers/NewsController.php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function allNews() {
        return view('dashboards.admin.allNews');
    }

    public function index(Request $request) {
        $search  = $request->query('search');
        $perPage = (int) $request->query('per_page', 12);

        // guardrails (1..50)
        $perPage = max(1, min($perPage, 50));

        $news = News::when($search, function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            })
            ->orderByDesc('published_at')
            ->paginate($perPage);

        // Laravel pagination returns { data, links, meta } JSON
        return response()->json($news);
    }


    public function store(Request $request) {
        $data = $request->validate([
            'title'         => ['required','string','max:255'],
            'small_description'=> ['nullable','string','max:200'],
            'published_at'  => ['required','date'],
            'content'       => ['required','string'],
            'published_by'  => ['nullable','string','max:255'],
            'status'        => ['boolean'],
            'image'         => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
        ]);

        $data['published_at'] = Carbon::parse($data['published_at']);

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('news', 'public');
            $data['image'] = $path;
        }

        $news = News::create($data);

        return response()->json($news, 201);
    }

    public function update(Request $request, News $news) {
        $data = $request->validate([
            'title'         => ['required','string','max:255'],
            'small_description'=> ['nullable','string','max:200'],
            'published_at'  => ['required','date'],
            'content'       => ['required','string'],
            'published_by'  => ['nullable','string','max:255'],
            'status'        => ['boolean'],
            'image'         => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
        ]);

        $data['published_at'] = Carbon::parse($data['published_at']);


        if ($request->hasFile('image')) {

            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return response()->json(['message' => 'News updated successfully.']);
    }

    public function destroy(News $news) {

        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return response()->json(['message' => 'News deleted successfully.']);
    }

    public function toggleStatus(News $news) {
        $news->update(['status' => !$news->status]);
        return response()->json(['message' => 'Status toggled.']);
    }

    public function show(News $news) {
        return response()->json($news);
    }
}
