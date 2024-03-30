<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    protected $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to find User',
                ],
                401,
            );
        }

        $user = Auth::user();
        return response()->json([
            'auth' => $this->createToken($token)
        ], 200);
    }

    public function register(Request $request)
    {
        $validateUserData = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validateUserData->fails()){
            return response()->json($validateUserData->errors());
            // return response('Registrasi data gagal, silakan periksa kembali', 500);
        }

        $user = $validateUserData->validated();
        $user = User::create([
            'username' => $request->username,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'auth' => $this->createToken($token)
        ], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
       return $this->createToken(auth()->refresh());
    }

    public function detail()
    {
        if(auth()->check()){
            return response()->json(['user' => auth()->user()], 200);
        }
        return response()->json(['user' => 'Unauthorized'], 200);
    }

    private function createToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}
