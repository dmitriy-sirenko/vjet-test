<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCollection;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(new CompanyCollection(Company::all()), Response::HTTP_OK);
    }
}
