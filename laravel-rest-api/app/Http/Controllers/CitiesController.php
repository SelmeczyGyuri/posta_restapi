<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\CityRequest;

class CitiesController extends Controller
{
    public function index(){
        $cities = City::all();

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function store(CityRequest $request)
    {
        $city = City::create($request->all());

        return response()->json([
            'city' => $city
        ]);
    }

    public function update(CityRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json([
            'city' => $city
        ]);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => 'City deleted successfully',
            'id' => $id
        ]);
    }
}
