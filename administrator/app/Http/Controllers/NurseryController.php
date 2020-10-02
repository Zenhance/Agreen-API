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

    public function createNurseries(Request $request)
    {

        DB::table('nursery')->insert([
            'Name' => $request->Name,
            'Address' => $request->Address,
            'Phone' => $request->Phone,
            'Location' => DB::raw("GeomFromText('POINT(" . $request->Latitude . " " . $request->Longitude . ")')")
        ]);

        $id = DB::table('nursery')
            ->select('ID')
            ->where('Phone', '=', $request->Phone)
            ->get();

        return  response()->json($id);
    }

    public function editNurseries(Request $request)
    {
        $nursery = Nursery::find($request->ID);

        if ($nursery) {
            if ($request->Name != $nursery->Name && $request->Name != null)
                $nursery->Name = $request->Name;
            if ($request->Address != $nursery->Address && $request->Address != null)
                $nursery->Address = $request->Description;
            if ($request->Banner != $nursery->Banner && $request->Banner != null)
                $nursery->Banner = $request->Banner;
            if ($request->Phone != $nursery->Phone && $request->Phone != null)
                $nursery->Phone = $request->Phone;
            $latitude = DB::table('nursery')
                ->select(DB::raw('X(Location) as latitude'))
                ->where('ID', $request->ID);
            $longitude = DB::table('nursery')
                ->select(DB::raw('Y(Location) as longitude'))
                ->where('ID', $request->ID);
            if ($request->Latitude != $latitude && $request->Latitude != null)
                $latitude = $request->Latitude;
            if ($request->Longitude != $longitude && $request->Longitude != null)
                $longitude = $request->Longitude;

            DB::table('nursery')
                ->where('ID', $request->ID)
                ->update([
                    'Name' => $nursery->Name,
                    'Address' => $nursery->Address,
                    'Phone' => $nursery->Phone,
                    'Banner' => $nursery->Banner,
                    'Location' => DB::raw("GeomFromText('POINT(" . $latitude . " " . $longitude . ")')")
                ]);

            return response()->json(
                DB::table('nursery')
                    ->select(
                        'Name',
                        'Address',
                        'Phone',
                        'Banner',
                        DB::raw('X(Location) as latitude'),
                        DB::raw('Y(Location) as longitude'),
                    )
                    ->where('ID', $request->ID)
                    ->get()
            );
        } else
            return response()->json("No nursery found");
    }
}
