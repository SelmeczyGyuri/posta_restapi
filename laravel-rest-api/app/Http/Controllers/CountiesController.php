<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Http\Requests\CountyRequest;

class CountiesController extends Controller
{
    public function index(){
        $counties = County::all();
        return response()->json(['counties' => $counties]);
    }

    public function store(CountyRequest $request)
    {
        $county = County::create($request->all());

        return response()->json(['county' => $county]);
    }

    public function update(CountyRequest $request, $id){
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json(['county' => $county]);
    }

    public function destroy($id){
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'County deleted successfully',
            'id' => $id
        ]);
    }
}
