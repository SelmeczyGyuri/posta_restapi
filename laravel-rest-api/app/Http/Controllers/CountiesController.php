<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Http\Requests\CountyRequest;

class CountiesController extends Controller
{
    /**
     * @apiDefine AuthHeader
     * @apiHeader {String} Authorization Bearer token (pl. "Bearer 1|xxxxxxxx").
     * @apiHeaderExample {String} Header példa:
     *     Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     * @apiError Unauthenticated Hiányzó vagy érvénytelen token.
     */

    /**
    * @api {get} /api/counties Megyék listázása
    * @apiName GetCounties
    * @apiGroup Counties
    *
    * @apiParam {String} [search] Keresés megyenév szerint.
    * @apiParam {String="name","id"} [sort_by=name] Rendezési mező.
    * @apiParam {String="asc","desc"} [sort_dir=asc] Rendezési irány.
    *
    * @apiSuccess {Object[]} counties A megyék listája.
    */

    public function index(){

        $sort_by = request()->query('sort_by', 'name');
        $sort_dir = request()->query('sort_dir', 'asc');
        $search = request()->query('search');

        if (!in_array($sort_by, ['name', 'id'])) {
            $sort_by = 'name';
        }

        if (!in_array($sort_dir, ['asc', 'desc'])) {
            $sort_dir = 'asc';
        }

        $counties = County::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_dir)
            ->get();
        
        return response()->json(['counties' => $counties]);
    }

    /**
    * @api {post} /api/counties Új megye létrehozása
    * @apiName CreateCounty
    * @apiGroup Counties
    * @apiUse AuthHeader
    *
    * @apiBody {String} name Megye neve (min. 3, max. 75 karakter).
    * @apiBody {String} [crest_url] A megye címerének URL-je.
    *
    * @apiSuccess {Object} county A létrehozott megye adatai.
    * @apiError ValidationError Hiányzó vagy érvénytelen mező (422).
    */

    public function store(CountyRequest $request)
    {
        $county = County::create($request->all());

        return response()->json(['county' => $county]);
    }

    /**
    * @api {get} /api/counties/:id Egy megye adatai és városai
    * @apiName GetCounty
    * @apiGroup Counties
    *
    * @apiParam {Number} id Megye azonosítója (URL paraméter).
    * @apiParam {String="city","zip_code","population"} [sort_by=city] A városok rendezési mezője.
    * @apiParam {String="asc","desc"} [sort_dir=asc] Rendezési irány.
    *
    * @apiSuccess {Object} county A megye adatai.
    * @apiSuccess {Object} cities A megyéhez tartozó városok listája (lapozva, 10 elem / oldal).
    * @apiError CountyNotFound A megadott ID-val nem található megye (404).
    */

    public function show(string $id)
    {
        $sort_by = request()->query('sort_by', 'city');
        $sort_dir = request()->query('sort_dir', 'asc');

        if (!in_array($sort_by, ['city', 'zip_code', 'population'])) {
            $sort_by = 'city';
        }

        if (!in_array($sort_dir, ['asc', 'desc'])) {
            $sort_dir = 'asc';
        }

        $county = County::findOrFail($id);
        $cities = $county->cities()->orderBy($sort_by, $sort_dir)->paginate(10);

        return response()->json([
            'county' => $county,
            'cities' => $cities,
        ]);
    }

    /**
    * @api {patch} /api/counties/:id Megye módosítása
    * @apiName UpdateCounty
    * @apiGroup Counties
    * @apiUse AuthHeader
    *
    * @apiParam {Number} id Megye azonosítója (URL paraméter).
    * @apiBody {String} name Megye neve (min. 3, max. 75 karakter).
    * @apiBody {String} [crest_url] A megye címerének URL-je.
    *
    * @apiSuccess {Object} county A módosított megye adatai.
    * @apiError CountyNotFound A megadott ID-val nem található megye (404).
    */

    public function update(CountyRequest $request, $id){
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json(['county' => $county]);
    }

    /**
    * @api {delete} /api/counties/:id Megye törlése
    * @apiName DeleteCounty
    * @apiGroup Counties
    * @apiUse AuthHeader
    *
    * @apiParam {Number} id Megye azonosítója (URL paraméter).
    *
    * @apiSuccess {String} message Visszaigazoló üzenet.
    * @apiError CountyNotFound A megadott ID-val nem található megye (404).
    */

    public function destroy($id){
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'County deleted successfully',
            'id' => $id
        ]);
    }
}
