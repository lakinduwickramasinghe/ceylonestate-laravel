<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyAdController extends Controller
{
    public function index()
    {
        return view('property.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('property.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('property.show',compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('property.edit',compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function admin_index(){
        return view('property.admin_index');
    }
    public function admin_view(){
        return view('property.admin_view');
    }
}
