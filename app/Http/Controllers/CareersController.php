<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CareersController extends Controller
{
    public function manageCareers(){

        return view('dashboards.admin.manageCareers');
    }


    public function index(Request $request)
    {
        $perPage = (int) ($request->integer('per_page') ?: 12);
        $search  = trim((string) $request->get('search', ''));

        $q = Career::query();

        if ($search !== '') {
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('small_description', 'like', "%{$search}%");
            });
        }

        $q->orderByDesc('created_at');

        $p = $q->paginate($perPage);

        return response()->json([
            'data' => $p->items(),
            'meta' => [
                'current_page' => $p->currentPage(),
                'last_page'    => $p->lastPage(),
                'per_page'     => $p->perPage(),
                'total'        => $p->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'small_description' => ['nullable', 'string', 'max:200'],
            'closing_date'      => ['nullable', 'date'],
            'content'           => ['required', 'string'],
            // 'status'            => ['nullable', Rule::in([0,1,true,false])],
        ]);

        $career = Career::create([
            'title'             => $data['title'],
            'small_description' => $data['small_description'] ?? null,
            'closing_date'      => $data['closing_date'] ?? null,
            'content'           => $data['content'],
            // 'status'            => isset($data['status']) ? (bool)$data['status'] : true,
        ]);

        return response()->json($career, 201);
    }

    public function show(Career $career)
    {
        return response()->json($career);
    }

    public function update(Request $request, Career $career)
    {
        $data = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'small_description' => ['nullable', 'string', 'max:200'],
            'closing_date'      => ['nullable', 'date'],
            'content'           => ['required', 'string'],
            // 'status'            => ['nullable', Rule::in([0,1,true,false])],
        ]);

        $career->update([
            'title'             => $data['title'],
            'small_description' => $data['small_description'] ?? null,
            'closing_date'      => $data['closing_date'] ?? null,
            'content'           => $data['content'],
            // 'status'            => isset($data['status']) ? (bool)$data['status'] : $career->status,
        ]);

        return response()->json($career);
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return response()->json(['ok' => true]);
    }

    public function toggleStatus(Career $career)
    {
        $career->status = !$career->status;
        $career->save();

        return response()->json(['status' => $career->status]);
    }
}
