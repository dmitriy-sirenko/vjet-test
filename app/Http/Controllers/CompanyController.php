<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCollection;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return response()->json(new CompanyCollection($user->companies()->get()), Response::HTTP_OK);
    }
}
