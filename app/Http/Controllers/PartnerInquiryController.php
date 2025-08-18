<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartnerInquiry;

class PartnerInquiryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'   => ['required','string','max:120'],
            'last_name'    => ['required','string','max:120'],
            'brand_name'   => ['required','string','max:180'],
            'email'        => ['required','email','max:190'],
            'phone'        => ['required','string','max:50'],
            'country_iso2' => ['nullable','string','max:4'],
            'dial_code'    => ['nullable','string','max:8'],
            'description'  => ['nullable','string'],
        ]);


        $digits = preg_replace('/\D+/', '', $data['phone']);
        if (!empty($digits)) {

            if (!empty($data['dial_code'])) {
                $dcDigits = preg_replace('/\D+/', '', $data['dial_code']);
 
                if (str_starts_with($digits, $dcDigits)) {
                    $data['phone'] = '+' . $digits;
                } else {
                    $data['phone'] = '+' . $dcDigits . $digits;
                }
            } else {

                $data['phone'] = (str_starts_with($data['phone'], '+')) ? $data['phone'] : '+' . $digits;
            }
        }

        $inq = PartnerInquiry::create($data);

        return response()->json([
            'message' => 'Thanks! Your partnership inquiry has been received.',
            'data'    => $inq,
        ], 201);
    }


    public function index(Request $request)
    {
        $q = PartnerInquiry::query()->latest();

        if ($search = $request->get('q')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('brand_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        if ($status = $request->get('status')) {
            $q->where('status', $status);
        }

        return $q->paginate($request->integer('per_page', 20));
    }


    public function updateStatus(Request $request, PartnerInquiry $partnerInquiry)
    {
        $data = $request->validate([
            'status' => ['required','in:pending,contacted,closed'],
        ]);
        $partnerInquiry->update($data);

        return response()->json(['message' => 'Status updated.','data' => $partnerInquiry]);
    }
}
