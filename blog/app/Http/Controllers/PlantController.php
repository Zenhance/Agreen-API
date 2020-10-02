<?php

namespace App\Http\Controllers;

use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantController extends Controller
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

    public function showPlants(Request $request)
    {
        return response()->json(
            DB::table('plant')
            ->join('category','category.ID',"=",'plant.Category_ID')
            ->select('plant.id','plant.Title','plant.Price','plant.Image')
            ->where([
                ['Category_ID','=',$request->c_id]
            ])
            ->get()
        );
    }

    public function showPlantDetails(Request $request)
    {
        {
            return response()->json(
                DB::table('plant')
                ->select('plant.ID','plant.Title','plant.Description','plant.Price','plant.Image')
                ->where([
                    ['plant.id','=',$request->p_id]
                ])
                ->get()
            );
        }
    }
}