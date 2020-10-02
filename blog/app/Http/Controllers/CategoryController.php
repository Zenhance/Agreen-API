<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function showCategories(Request $request)
    {
        return response()->json(
            DB::table('category')
            ->select('ID','Title','Image')
            ->where('Nursery_ID','=',$request->n_id)
            ->get()
        );
    }
}
