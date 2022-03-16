<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            $data = $request->only(['first_name', 'last_name', 'phone', 'email', 'password']);
            $data['password'] = Hash::make($data['password']);
            User::create($data);
            return response()->json(["status" => 'success', "message" => "Success registration"], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["status" => 'fail', "message" => "Registration error"], Response::HTTP_I_AM_A_TEAPOT);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('password'), $user->password)) {
            $apiToken = base64_encode(Str::random(40));
            User::where('email', $request->input('email'))->update(['api_token' => $apiToken]);
            return response()->json(['status' => 'success','api_token' => $apiToken]);
        } else {
            return response()->json(['status' => 'fail'],401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendRecoverToken(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $recoverPasswordToken = base64_encode(Str::random(40));
        User::where('email', $request->input('email'))->update(
            ['recover_password_token' => $recoverPasswordToken]
        );
        return response()->json(['status' => 'success', 'recover_password_token' => $recoverPasswordToken]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function recoverPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'recover_password_token' => 'required'
        ]);

        $user = User::where('recover_password_token', $request->input('recover_password_token'))->first();
        if ($user->id) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Password was successfully recovered'], RESPONSE::HTTP_OK);
        } else {
            return response()->json(['status' => 'fail'], Response::HTTP_BAD_REQUEST);
        }
    }
}
