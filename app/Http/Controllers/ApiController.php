<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => trans('messages.index'),
        ]);
    }
}
