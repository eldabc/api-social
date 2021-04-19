<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthEditRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    /**
     * List all Users
     *
     * @return \Illuminate\Http\Response
     */
    public function index($paginate = 8)
    {
        return User::with('roles')->orderBy('id', 'DESC')->paginate($paginate);
    }

    /**
     * Insert User
     *
     * @return 
     */
    public function store(AuthRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $validated['password'] = bcrypt($request->password);

            $user = User::create($validated)->assignRole($request->role_id);

            $accessToken = $user->createToken('authToken')->accessToken;
            
            send_mail_user($user);
            DB::commit();
            return response([ 'user' => $user, 'access_token' => $accessToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response('Ha ocurrido un problema. '.$e->getMessage(), 500, ['Content-Type' => 'text/plain']);
        }
    }


    /**
     * Show a user
     *
     * @return 
     */
    public function show($id)
    {

       return User::with('roles')->where('id', $id)->first();
         
    }


    /**
     * Update user
     *
     * @return 
     */
    public function update(AuthEditRequest $request, $id)
    {
        $validated = $request->validated();

        if ($request->hasFile('img')) {
            $chage_img = User::findOrFail($id);
            Storage::delete($chage_img->img);
            $validated['img'] = Storage::put('users', $request->file('img'));
        }
        User::where('id', $id)->update($validated);
        
        return response([ 'success' => 'Usuario modificado con éxito']);

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


        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)){
            return response(['message' => 'Invalid Credentials']);
        }
        
        $accessToken = $user->createToken('authToken')->accessToken;
        
        $user->load('roles');

        return response(['user' => $user, 'access_token' => $accessToken]);

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

