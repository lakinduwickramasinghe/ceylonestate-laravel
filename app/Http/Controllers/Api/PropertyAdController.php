<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PropertyAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PropertyAdController extends Controller
{
    public function index()
    {
        $ads = PropertyAd::with(['residential', 'commercial', 'land', 'industrial', 'user', 'images'])
            ->latest()
            ->paginate(10);

        return response()->json($ads, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'property_type'  => 'required|in:residential,commercial,land,industrial',
            'price'          => 'nullable|numeric|min:0',
            'status'         => 'in:available,sold,inactive',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'nullable|string|max:20',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',

            // Property type specific fields (nested arrays)
            'residential' => 'nullable|array',
            'commercial'  => 'nullable|array',
            'land'        => 'nullable|array',
            'industrial'  => 'nullable|array',

            // Images
            'images.*'    => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        DB::beginTransaction();

        try {
            // 1. Create main property ad
            $property = PropertyAd::create(array_merge(
                $data,
                ['user_id' => $request->user()->id ?? Auth::id()] // Replace 1 with Auth::id() in production
            ));

            // 2. Create related property type record
            switch ($property->property_type) {
                case 'residential':
                    if (!empty($data['residential'])) {
                        $property->residential()->create($data['residential']);
                    }
                    break;

                case 'commercial':
                    if (!empty($data['commercial']['accessibility_features'])) {
                        $data['commercial']['accessibility_features'] = json_encode(
                            (array) $data['commercial']['accessibility_features']
                        );
                    }
                    if (!empty($data['commercial'])) {
                        $property->commercial()->create($data['commercial']);
                    }
                    break;

                case 'land':
                    if (!empty($data['land'])) {
                        $property->land()->create($data['land']);
                    }
                    break;

                case 'industrial':
                    if (!empty($data['industrial'])) {
                        $property->industrial()->create($data['industrial']);
                    }
                    break;
            }

            // 3. Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('property_images'), $filename);

                    $property->images()->create([
                        'imagepath' => 'property_images/' . $filename,
                        'order'     => $index,
                        'is_main'   => $index === 0, // First image as main
                    ]);
                }
            }

            DB::commit();

            return response()->json($property->load(
                'residential',
                'commercial',
                'land',
                'industrial',
                'images'
            )->refresh(), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create property',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    public function show(string $id)
    {
        $ad = PropertyAd::with(['user','residential','commercial','land','industrial','images'])
            ->find($id);

        if (!$ad) {
            return response()->json(['message' => 'Property ad not found'], 404);
        }

        return response()->json($ad, 200);
    }


    public function update(Request $request, $id)
    {
        $property = PropertyAd::with([
            'residential',
            'commercial',
            'industrial',
            'land',
            'images'
        ])->findOrFail($id);

        // Validate
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'property_type' => 'required|in:residential,commercial,industrial,land',
            'status'        => 'required|in:available,sold,rented,inactive',
            'price'         => 'nullable|numeric',
            'address_line_1'=> 'required|string|max:255',
            'address_line_2'=> 'nullable|string|max:255',
            'city'          => 'required|string|max:255',
            'province'      => 'required|string|max:255',
            'postal_code'   => 'nullable|string|max:20',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            // Images
            'images.*'      => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'main_image_id' => 'nullable|exists:property_images,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        // Check if property_type has changed
        $oldPropertyType = $property->property_type;
        $newPropertyType = $validated['property_type'];

        // Update main property
        $property->update($validated);

        // If property_type has changed, delete the old type's record
        if ($oldPropertyType !== $newPropertyType) {
            switch ($oldPropertyType) {
                case 'residential':
                    if ($property->residential) {
                        $property->residential->delete();
                    }
                    break;
                case 'commercial':
                    if ($property->commercial) {
                        $property->commercial->delete();
                    }
                    break;
                case 'industrial':
                    if ($property->industrial) {
                        $property->industrial->delete();
                    }
                    break;
                case 'land':
                    if ($property->land) {
                        $property->land->delete();
                    }
                    break;
            }
        }

        // Update or create type-specific data
        switch ($newPropertyType) {
            case 'residential':
                $data = $request->input('residential', []);
                $property->residential
                    ? $property->residential->update($data)
                    : $property->residential()->create($data);
                break;

            case 'commercial':
                $data = $request->input('commercial', []);
                $property->commercial
                    ? $property->commercial->update($data)
                    : $property->commercial()->create($data);
                break;

            case 'industrial':
                $data = $request->input('industrial', []);
                $property->industrial
                    ? $property->industrial->update($data)
                    : $property->industrial()->create($data);
                break;

            case 'land':
                $data = $request->input('land', []);
                $property->land
                    ? $property->land->update($data)
                    : $property->land()->create($data);
                break;
        }

        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('property_images'), $filename);

                $property->images()->create([
                    'imagepath' => 'property_images/' . $filename,
                    'order'     => $property->images()->count(),
                    'is_main'   => false,
                ]);
            }
        }

        // Update main image selection
        if (!empty($validated['main_image_id'])) {
            $property->images()->update(['is_main' => false]);
            $property->images()
                ->where('id', $validated['main_image_id'])
                ->update(['is_main' => true]);
        }

        return response()->json([
            'message' => 'Property updated successfully',
            'property' => $property->fresh([
                'residential',
                'commercial',
                'industrial',
                'land',
                'images'
            ])
        ]);
    }

    public function destroy($id)
    {
        $property = PropertyAd::with(['residential','commercial','industrial','land'])->findOrFail($id);

        // Delete related type-specific record
        if ($property->residential) {
            $property->residential->delete();
        }
        if ($property->commercial) {
            $property->commercial->delete();
        }
        if ($property->industrial) {
            $property->industrial->delete();
        }
        if ($property->land) {
            $property->land->delete();
        }

        // Delete main property record
        $property->delete();

        return response()->json([
            'message' => 'Property deleted successfully',
        ], 200);
    }

    public function member_property($id)
    {
        $ads = PropertyAd::with([
                'residential',
                'commercial',
                'land',
                'industrial'
            ])
            ->where('user_id', $id)
            ->latest()
            ->get();

        if ($ads->isEmpty()) {
            return response()->json([
                'message' => 'No property ads found for this user.'
            ], 200);
        }

        return response()->json($ads, 200);
    }

    public function all()
    {
        $ads = PropertyAd::with(['residential', 'commercial', 'land', 'industrial', 'user', 'images'])
            ->latest()
            ->paginate(10);

        return response()->json($ads, 200);
    }
    public function viewone(string $id)
    {
        $ad = PropertyAd::with(['user','residential','commercial','land','industrial','images'])
            ->find($id);

        if (!$ad) {
            return response()->json(['message' => 'Property ad not found'], 404);
        }

        return response()->json($ad, 200);
    }

}
