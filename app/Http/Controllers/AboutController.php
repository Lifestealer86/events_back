<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "data" => ["title" => ["name" => "Сибирская природа"],
                "text" => ["data" => "Удивительное слияние всех сибирских активностей в одном месте!"],
                "img" => ["url" => "img/siberian.jpeg"]]
        ]);
    }
}
