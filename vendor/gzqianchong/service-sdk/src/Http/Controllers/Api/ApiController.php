<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiController extends Controller
{
    protected function responses($data = [])
    {
        throw new HttpResponseException(response()->json($data));
    }
}
