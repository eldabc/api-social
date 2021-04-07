<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Requests\AuthEditRequest;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    /**
     * List all Users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $users = DB::table('users')->orderBy('id', 'DESC')->get();
    }

    /**
     * Insert User
     *
     * @return 
     */
    public function store(AuthRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = bcrypt($request->password);


        $user = User::create($validated);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }


    /**
     * Show a user
     *
     * @return 
     */
    public function show($id)
    {
        return $users = DB::table('users')->where('id', $id)->get();
    }


    /**
     * Update user
     *
     * @return 
     */
    public function update(AuthEditRequest $request, $id)
    {
        $validated = $request->validated();
        User::where('id', $id)->update($validated);
        
        return response(['success' => 'Usuario modificado con éxito']);

    }

    /**
     * Login user
     *
     * @return 
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData))
            return response(['message' => 'Invalid Credentials']);

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }

    /**
     * Change Password user
     *
     * @return
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = bcrypt($request->password);
        
        User::where('email', $request->email)
                ->update($validated);
        
        return response(['success' => 'Contraseña modificada con éxito']);
        
    }
}

