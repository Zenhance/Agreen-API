<?php

namespace App\Http\Controllers;

use App\Nursery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

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

    public function getNurseries()
    {
        return response()->json(
            DB::table('nursery')
                ->select(
                    'ID',
                    'Name',
                    'Address',
                    'Phone',
                    'Banner',
                    DB::raw('X(Location) as latitude'),
                    DB::raw('Y(Location) as longitude')
                )
                ->get()
        );
    }

    public function getNursery(Request $request)
    {
        return response()->json(
            DB::table('nursery')
            ->select(
                'Name',
                'Address',
                'Phone',
                'Banner',
                DB::raw('X(Location) as latitude'),
                DB::raw('Y(Location) as longitude')
            )
            ->where('ID',$request->ID)
            ->get()
            );
    }

    public function createNurseries(Request $request)
    {

        $id = DB::table('nursery')->insertGetId(
            array(
                'Name' => $request->Name,
                'Address' => $request->Address,
                'Phone' => $request->Phone,
                'Location' => DB::raw("GeomFromText('POINT(" . $request->Latitude . " " . $request->Longitude . ")')")
            )
        );

        return  response()->json($id);
    }

    public function uploadNurseryBanner(Request $request)
    {
        $id = $request->ID;
        $name = DB::table('nursery')
            ->where('ID', $id)
            ->value('Name');

        if ($request->hasFile('Banner')) {
            $filename = $id . '-' . $name . '-banner' . '.' . $request->file('Banner')->getClientOriginalExtension();
            $imagepath = url('/public/images/' . $filename);
            $path = $request->file('Banner')->move('public/images', $filename);

            if ($path) {
                DB::table('nursery')
                    ->where('ID', $request->ID)
                    ->update(['Banner' => $imagepath]);

                return response()->json($imagepath);
            }
        } else
            return response()->json("No file selected");
    }

    public function editNurseries(Request $request)
    {
        $nursery = Nursery::find($request->ID);

        if ($nursery) {
            if ($request->Name != $nursery->Name && $request->Name != null)
                $nursery->Name = $request->Name;
            if ($request->Address != $nursery->Address && $request->Address != null)
                $nursery->Address = $request->Description;
            if ($request->Phone != $nursery->Phone && $request->Phone != null)
                $nursery->Phone = $request->Phone;
            $latitude = DB::table('nursery')
                ->select(DB::raw('X(Location) as latitude'))
                ->where('ID', $request->ID)
                ->value('X');
            $longitude = DB::table('nursery')
                ->select(DB::raw('Y(Location) as longitude'))
                ->where('ID', $request->ID)
                ->value('Y');
            if ($request->Latitude != $latitude && $request->Latitude != null)
                $latitude = $request->Latitude;
            if ($request->Longitude != $longitude && $request->Longitude != null)
                $longitude = $request->Longitude;

            if ($request->hasFile('Banner')) {
                $filename = $request->ID . '-' . $nursery->Title . '.' . $request->file('Banner')->getClientOriginalExtension();
                $imagepath = url('/public/images/' . $filename);
                $path = $request->file('Banner')->move('public/images', $filename);

                if ($path) {
                    DB::table('nursery')
                        ->where('ID', $request->ID)
                        ->update([
                            'Name' => $nursery->Name,
                            'Address' => $nursery->Address,
                            'Phone' => $nursery->Phone,
                            'Banner' => $imagepath,
                            'Location' => DB::raw("GeomFromText('POINT(" . $latitude . " " . $longitude . ")')")
                        ]);
                }
            } else {
                DB::table('nursery')
                    ->where('ID', $request->ID)
                    ->update([
                        'Name' => $nursery->Name,
                        'Address' => $nursery->Address,
                        'Phone' => $nursery->Phone,
                        'Location' => DB::raw("GeomFromText('POINT(" . $latitude . " " . $longitude . ")')")
                    ]);
            }
            return response()->json(
                DB::table('nursery')
                    ->select(
                        'ID',
                        'Name',
                        DB::raw('X(Location) as latitude'),
                        DB::raw('Y(Location) as longitude'),
                        'Banner'
                    )
                    ->where('ID', $request->ID)
                    ->get()
            );
        } else
            return response()->json("No nursery found");
    }

}
