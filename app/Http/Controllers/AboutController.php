<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "data" => ["title" => ["name" => "Сибирская природа"],
                "text" => ["data" => "Озера глубиной в тысячи метров, горные хребты, вековая тайга и северное сияние"],
                "img" => ["url" => "img/siberian.jpeg"]]
        ]);
    }
}
