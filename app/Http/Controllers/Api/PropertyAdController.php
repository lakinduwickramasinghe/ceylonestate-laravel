<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PropertyAd;
use Illuminate\Http\Request;

class PropertyAdController extends Controller
{
    public function index()
    {
        return response()->json(PropertyAd::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        return response()->json(PropertyAd::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
