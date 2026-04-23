<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index()
    {

        return view('backend.business.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backend.business.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'city_name' => 'required|unique:cities|max:255',
        ]);

        City::create([
            'city_name' => $request->city_name,
            'slug' => Str::slug($request->city_name),
        ]);

        return redirect()->route('cities.index')->with(['message' => 'Cities Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view('backend.business.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {

        $request->validate([
            'city_name' => 'required|max:255|unique:cities,city_name,' . $city->id,
        ]);



        $city->update([
            'city_name' => $request->city_name,
            'slug' => Str::slug($request->city_name),
        ]);

        return redirect()->route('cities.index')->with(['message' => 'Cities Updated Successfully']);
    }

    
    public function destroy(City $city)
    {

        $city->delete();

        return redirect()->route('cities.index')->with(['message' => 'Cities deleted succefully']);
    }
}
