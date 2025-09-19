<?php

namespace App\Http\Controllers;

use App\Models\PropertyAd;
use Illuminate\Http\Request;

class PropertyAdController extends Controller
{
    public function index()
    {
        return view('property.index');
    }

    public function create()
    {
        return view('property.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        return view('property.show',compact('id'));
    }

    public function edit(string $id)
    {
        return view('property.edit',compact('id'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $propertyAd = PropertyAd::with(['commercial','land','industrial','residential','images'])->find($id);
        if ($propertyAd) {
            if($propertyAd->images())
                $propertyAd->images()->delete();
            if ($propertyAd->commercial) {
                $propertyAd->commercial->delete();
            }
            if ($propertyAd->land) {
                $propertyAd->land->delete();
            }
            if ($propertyAd->industrial) {
                $propertyAd->industrial->delete();
            }
            if ($propertyAd->residential) {
                $propertyAd->residential->delete();
            }
            $propertyAd->delete();
            return redirect()->route('property.index')->with('success', 'Property Ad deleted successfully.');
        } else {
            return redirect()->route('property.index')->with('error', 'Property Ad not found.');
        }
    }
    public function admin_index(){
        return view('property.admin_index');
    }
    public function admin_view(){
        return view('property.admin_show');
    }
}
