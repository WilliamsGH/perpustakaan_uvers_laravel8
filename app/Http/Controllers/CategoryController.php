<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get_category_list()
    {
        $categories = Category::all();

        return new JsonResponse([
            'data' => [ 
                'category_lists' => ($categories) ? $categories : [] 
            ],
            'error' => ''
        ]);
    }
}
