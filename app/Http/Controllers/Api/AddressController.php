<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // GET /api/addresses
    public function index(Request $request)
    {
        return response()->json($request->user()->addresses()->latest()->get());
    }

    // POST /api/addresses
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['nullable', 'string', 'max:50'],
            'full_address' => ['required', 'string'],
            'landmark' => ['nullable', 'string', 'max:150'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if (! empty($data['is_default'])) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $address = $request->user()->addresses()->create($data);

        return response()->json($address, 201);
    }

    // PUT /api/addresses/{address}
    public function update(Request $request, $id)
    {
        $address = $request->user()->addresses()->findOrFail($id);

        $data = $request->validate([
            'label' => ['nullable', 'string', 'max:50'],
            'full_address' => ['sometimes', 'string'],
            'landmark' => ['nullable', 'string', 'max:150'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if (! empty($data['is_default'])) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $address->update($data);

        return response()->json($address);
    }

    // DELETE /api/addresses/{address}
    public function destroy(Request $request, $id)
    {
        $address = $request->user()->addresses()->findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Address deleted']);
    }
}
