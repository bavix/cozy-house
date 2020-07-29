<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        return [
            'app_name' => \config('app.name'),
        ];
    }

}
