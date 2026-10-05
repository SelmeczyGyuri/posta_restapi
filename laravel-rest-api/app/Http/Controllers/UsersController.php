<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * @apiDefine AuthHeader
     * @apiHeader {String} Authorization Bearer token (pl. "Bearer 1|xxxxxxxx").
     * @apiHeaderExample {String} Header példa:
     *     Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     * @apiError Unauthenticated Hiányzó vagy érvénytelen token.
     */

    /**
    * @api {post} /api/users/login Bejelentkezés
    * @apiName LoginUser
    * @apiGroup Auth
    *
    * @apiBody {String} email Felhasználó email címe.
    * @apiBody {String} password Felhasználó jelszava.
    *
    * @apiSuccess {Object} user A bejelentkezett felhasználó adatai.
    * @apiSuccess {String} user.token Sanctum access token, további kérésekhez szükséges.
    * @apiError InvalidCredentials Hibás email vagy jelszó (401).
    */

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password'); 

        $request->validate([
            'email' => 'required|email', 
            'password' => 'required', 
        ]); 

        $user = User::where('email', $email)->first(); 

        if(!$user || !Hash::check($password, $password ? $user->password : ''))
        {
            return response()->json([
                'message' => 'Invalid email or password', 
            ], 401); 
        }

        $user->tokens()->delete();

        $user->token = $user->createToken('access')->plainTextToken;
        
        return response()->json([
            'user' => $user, 
        ]); 
    }

    /**
    * @api {get} /api/users Felhasználók listázása
    * @apiName GetUsers
    * @apiGroup Auth
    * @apiUse AuthHeader
    *
    * @apiSuccess {Object[]} users A felhasználók listája.
    */

    public function index(){
        $users = User::all();
        return response()->json(['users' => $users]);
    }
}
