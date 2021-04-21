<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthEditRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ChangePasswordRequest;
use Carbon\Carbon;

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
            if(!empty($validated['provider']))
                $validated['password'] = '';
            else
                $validated['password'] = bcrypt($request->password);

            $user = User::create($validated)->assignRole($request->role_id);
            send_mail_user($user);

            DB::commit();
            return response([ 'user' => $user, 'access_token' => $user->createToken('authToken')->accessToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response('Ha ocurrido un problema. '.$e->getMessage(), 500);
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
    public function emailChangePassword(Request $request)
    {
        try{
            $data = $request->validate([ 'email' => 'email|required' ]);

            if(User::where('email', $data['email'])->doesntExist())
            {
                return response([
                    'error' => 'Email proporcionado no existe.'
                ], 404);
            }

            $token = Str::random(50);

            DB::table('password_resets')->insert([
                'email' => $data['email'],
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            // Send email
            send_mail_change_pass($data['email'], $token);
            
            return response(['success' => 'Hemos enviado un Email de verificación.']);
        }catch(\Exception $e) {
            return Response('Ha ocurrido un problema. '.$e->getMessage(), 400);
        }
        
    }

    /**
     * Change Password user
     *
     * @return
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        DB::beginTransaction();
        try{
            $validated = $request->validated();
            if(!$reset = DB::table('password_Resets')->where('token', $validated['token'])->first())
            {
                return response([ 'error' => 'El token enviado no es correcto.' ], 400);
            }
            
            User::where('email', $reset->email)->update([ 'password' => bcrypt($validated['password'])]);
            
                // Delete recovery tokens and token access
                DB::delete('delete from password_resets where email = ?', [$reset->email]);
                $user = User::where('email', $reset->email)->first();
                DB::delete('delete from oauth_access_tokens where user_id = ?', [$user->id]);

            DB::commit();
            return response(['success' => 'Contraseña modificada con éxito']);
    
        }catch (\Exception $exception){
            DB::rollBack();
            return Response($exception->getMessage(), 500);
        }
    }
}

