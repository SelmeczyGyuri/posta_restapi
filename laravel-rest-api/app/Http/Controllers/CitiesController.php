<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\CityRequest;

class CitiesController extends Controller
{
    /**
     * @apiDefine AuthHeader
     * @apiHeader {String} Authorization Bearer token (pl. "Bearer 1|xxxxxxxx").
     * @apiHeaderExample {String} Header példa:
     *     Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     * @apiError Unauthenticated Hiányzó vagy érvénytelen token.
     */

    /**
     * @api {get} /api/cities Városok listázása
     * @apiName GetCities
     * @apiGroup Cities
     *
     * @apiParam {String} [search] Keresés városnév szerint (részleges egyezés).
     * @apiParam {Number} [county] Szűrés megye ID szerint.
     * @apiParam {String="city","zip_code","population"} [sort_by=city] Rendezési mező.
     * @apiParam {String="asc","desc"} [sort_dir=asc] Rendezési irány.
     *
     * @apiSuccess {Object[]} cities.data A városok listája (lapozva, 20 elem / oldal).
     * @apiSuccess {Number} cities.data.id Város azonosítója.
     * @apiSuccess {Number} cities.data.zip_code Irányítószám.
     * @apiSuccess {String} cities.data.city Város neve.
     * @apiSuccess {Number} cities.data.population Lakosság.
     * @apiSuccess {Object} cities.data.county A városhoz tartozó megye adatai.
     */

    public function index()
    {
        $sort_by = request()->query('sort_by', 'city');
        $sort_dir = request()->query('sort_dir', 'asc');
        $search = request()->query('search');
        $countyFilter = request()->query('county');

        if (!in_array($sort_by, ['city', 'zip_code', 'population'])) {
            $sort_by = 'city';
        }

        if (!in_array($sort_dir, ['asc', 'desc'])) {
            $sort_dir = 'asc';
        }

        $cities = City::with('county')
            ->when($search, function ($query, $search) {
                $query->where('city', 'like', '%' . $search . '%');
            })
            ->when($countyFilter, function ($query, $countyFilter) {
                $query->where('id_county', $countyFilter);
            })
            ->orderBy($sort_by, $sort_dir)
            ->paginate(20);

        /*return response()->json([
            'cities' => $cities
        ]);*/
        return response()->json($cities);
    }

    /**
     * @api {post} /api/cities Új város létrehozása
     * @apiName CreateCity
     * @apiGroup Cities
     * @apiUse AuthHeader
     *
     * @apiBody {Number} zip_code Irányítószám.
     * @apiBody {String} city Város neve (min. 3, max. 50 karakter).
     * @apiBody {Number} id_county A megye azonosítója.
     * @apiBody {Number} population Lakosság.
     *
     * @apiSuccess {Object} city A létrehozott város adatai.
     * @apiError ValidationError Hiányzó vagy érvénytelen mező (422).
     */

    public function store(CityRequest $request)
    {
        $city = City::create($request->all());

        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {get} /api/cities/:id Egy város adatai
     * @apiName GetCity
     * @apiGroup Cities
     *
     * @apiParam {Number} id Város azonosítója (URL paraméter).
     *
     * @apiSuccess {Number} city.id Város azonosítója.
     * @apiSuccess {Number} city.zip_code Irányítószám.
     * @apiSuccess {String} city.city Város neve.
     * @apiSuccess {Number} city.population Lakosság.
     * @apiSuccess {Object} city.county A városhoz tartozó megye adatai.
     *
     * @apiError CityNotFound A megadott ID-val nem található város (404).
     */

    public function show(string $id)
    {
        $city = City::with('county')->findOrFail($id);
        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {patch} /api/cities/:id Város módosítása
     * @apiName UpdateCity
     * @apiGroup Cities
     * @apiUse AuthHeader
     *
     * @apiParam {Number} id Város azonosítója (URL paraméter).
     * @apiBody {Number} zip_code Irányítószám.
     * @apiBody {String} city Város neve (min. 3, max. 50 karakter).
     * @apiBody {Number} id_county A megye azonosítója.
     * @apiBody {Number} population Lakosság.
     *
     * @apiSuccess {Object} city A módosított város adatai.
     * @apiError CityNotFound A megadott ID-val nem található város (404).
     * @apiError ValidationError Hiányzó vagy érvénytelen mező (422).
     */

    public function update(CityRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {delete} /api/cities/:id Város törlése
     * @apiName DeleteCity
     * @apiGroup Cities
     * @apiUse AuthHeader
     *
     * @apiParam {Number} id Város azonosítója (URL paraméter).
     *
     * @apiSuccess {String} message Visszaigazoló üzenet.
     * @apiError CityNotFound A megadott ID-val nem található város (404).
     */
    
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
