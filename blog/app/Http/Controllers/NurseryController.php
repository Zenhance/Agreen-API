<?php

namespace App\Http\Controllers;

use App\Nursery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NurseryController extends Controller
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

    //

    public function showNurseryByDistance(Request $request)
    {
        return response()->json(
            DB::table('nursery')
                ->select(
                    'ID',
                    'Name',
                    //DB::raw('X(Location) as latitude'),
                    //DB::raw('Y(Location) as longitude'),
                    'Banner'
                )
                ->whereRaw(
                    "GLength(
                        LineStringFromWKB(
                        LineString(
                            Location,
                            GeomFromText('POINT($request->latitude $request->longitude)')
                            )
                        )
                    )>0.01")
                ->get()
        );
    }

    
}
