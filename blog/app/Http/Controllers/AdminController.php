<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Hashing\BcryptHasher;

class AdminController extends Controller
{
    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'Name' => 'required',
            'Password' => 'required',
            'Nursery_ID'=> 'required'
        ]);

        if($validator->fails())
        {
            return array(
                'error' => true,
                'message' => $validator->errors()->all()
            );
        }

        $admin = new Admin();

        $admin->Name = $request->input('Name');
        $admin->Nursery_ID = $request->input('Nursery_ID');
        $admin->Password = (new BcryptHasher())->make($request->input('Password'));

        $admin->save();

        unset($admin->Password);

        return array(
            'error' => false,
            'admin' => $admin
        );
    }

    /*public function loginAdmin(Request $request)
    {
        # code...

        $this->validate($request,[
            'Name'=>'required|string',
            'Password'=>'required|string',
        ]);

        $credentials = $request->only(['Name',''])
    }*/
}