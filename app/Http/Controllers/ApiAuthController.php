<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->only(['first_name', 'last_name', 'phone', 'email', 'password']);
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            return response()->json(["status" => 'success', "message" => "Success registration"], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["status" => 'fail', "message" => "Registration error"], Response::HTTP_I_AM_A_TEAPOT);
        }
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(40));
            User::where('email', $request->input('email'))->update(['api_key' => $apikey]);;
            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }
}
