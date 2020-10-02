<?php

namespace App\Http\Controllers;

use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\UrlGenerator;

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

    public function getPlants(Request $request)
    {
        return response()->json(
            DB::table('plant')
                ->join('category', 'category.ID', "=", 'plant.Category_ID')
                ->select('plant.id', 'plant.Title', 'plant.Price', 'plant.Image')
                ->where([
                    ['Category_ID', '=', $request->Category_ID]
                ])
                ->get()
        );
    }

    public function getPlantDetails(Request $request)
    {
        return response()->json(
            DB::table('plant')
                ->select('plant.ID', 'plant.Title', 'plant.Description', 'plant.Price', 'plant.Image')
                ->where([
                    ['plant.id', '=', $request->Plant_ID]
                ])
                ->get()
        );
    }

    public function createPlants(Request $request)
    {
        $id = DB::table('plant')
            ->insertGetId(
                array(
                    'Title' => $request->Title,
                    'Description' => $request->Description,
                    'Price' => $request->Price,
                    'Image' => $request->Image,
                    'Category_ID' => $request->Category_ID
                )
            );

        return response()->json($id);
    }

    public function uploadPlantImage(Request $request)
    {
        $id = $request->ID;
        $title = DB::table('plant')
            ->where('ID', $id)
            ->value('Title');

        if ($request->hasFile('Image')) {
            $filename = $id . '-' . $title . '.' . $request->file('Image')->getClientOriginalExtension();
            $imagepath = url('/public/images/' . $filename);
            //$url = URL::asset('/' . public_path("/images") . '/' . $filename);
            $path = $request->file('Image')->move('public/images', $filename);

            if ($path) {
                DB::table('plant')
                    ->where('ID', $request->ID)
                    ->update(['Image' => $imagepath]);

                return response()->json($imagepath);
            }
        } else
            dd('Request has no file');

        dd($title);
    }

    public function editPlants(Request $request)
    {
        $plant = Plant::find($request->ID);

        if ($plant) {
            if ($request->Title != $plant->Title && $request->Title != null)
                $plant->Title = $request->Title;
            if ($request->Description != $plant->Description && $request->Description != null)
                $plant->Description = $request->Description;
            if ($request->Image != $plant->Image && $request->Image != null)
                $plant->Image = $request->Image;
            if ($request->Price != $plant->Price && $request->Price != null)
                $plant->Price = $request->Price;

            DB::table('plant')
                ->where('ID', $request->ID)
                ->update(['Title' => $plant->Title, 'Image' => $plant->Image, 'Description' => $plant->Description, 'Price' => $plant->Price]);

            return response()->json($plant);
        } else
            return response()->json("Plant does not exist");
    }

    public function deletePlants(Request $request)
    {
        $plant = Plant::find($request->ID);

        if ($plant) {
            DB::table('plant')
                ->where('ID', $request->ID)
                ->delete();

            return response()->json("Plant deleted successfully");
        } else
            return response()->json("Plant does not exist");
    }
}
