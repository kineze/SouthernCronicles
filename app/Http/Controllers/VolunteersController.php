<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VolunteersController extends Controller
{
    
    public function volunteers()
    {
        return view('dashboards.admin.volunteers');
    }
    

    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 15);
        $search  = (string) $request->get('search', '');

        $q = \App\Models\Volunteer::query();

        if ($search !== '') {
            $q->where(function ($qq) use ($search) {
                $qq->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        return $q->latest()->paginate($perPage);
    }


    // Public create (used by frontend form)
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'          => ['required','email','max:255','unique:volunteers,email'],
            'first_name'     => ['required','string','max:120'],
            'last_name'      => ['required','string','max:120'],
            'contact_number' => ['required','string','max:40'],
            'description'    => ['nullable','string'],
        ]);

        $vol = Volunteer::create($data);
        return response()->json($vol, 201);
    }

    // Optional admin update/delete
    public function update(Request $request, Volunteer $volunteer)
    {
        $data = $request->validate([
            'email'          => ['required','email','max:255', Rule::unique('volunteers','email')->ignore($volunteer->id)],
            'first_name'     => ['required','string','max:120'],
            'last_name'      => ['required','string','max:120'],
            'contact_number' => ['required','string','max:40'],
            'description'    => ['nullable','string'],
        ]);

        $volunteer->update($data);
        return response()->json($volunteer);
    }

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

