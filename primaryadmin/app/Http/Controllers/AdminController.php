<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    public function getAdmins()
    {
        return response()->json(
            DB::table('admin')
            ->get()
        );
    }

    public function getAdmin(Request $request)
    {
        return response()->json(
            DB::table('admin')
            ->where('ID',$request->ID)
            ->get()
        );
    }

    public function createAdmin(Request $request)
    {
        $pass = Str::random(6);

        $id = DB::table('admin')
            ->insertGetId(
                array(
                    'Name' => $request->Name,
                    'Mobile' => $request->Mobile,
                    'Nursery_ID' => $request->Nursery_ID,
                    'Password' => $pass
                )
            );
        
        return response()->json(array("Admin_ID"=>$id,"Password"=>$pass));
    }
}