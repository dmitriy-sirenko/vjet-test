<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return response()->json(new CompanyCollection($user->companies()->get()), Response::HTTP_OK);
    }

    public function store(Request $request) {
        $data = array_merge($request->only(['title', 'phone', 'description']), ['user_id' => Auth::user()->id]);
        $company = Company::create($data);
        return response()->json(new CompanyResource($company), Response::HTTP_OK);
    }
}
