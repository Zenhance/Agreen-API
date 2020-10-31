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
                ->select('ID', 'Title', 'Image')
                ->where('Nursery_ID', '=', $request->Nursery_ID)
                ->get()
        );
    }

    public function showCategoryDetails(Request $request)
    {
        return response() -> json(
            DB::table('category')
            ->select('Title','Image')
            ->where('ID','=',$request->Category_ID)
            ->get()
        );
    }

    public function createCategories(Request $request)
    {
        $id = DB::table('category')
            ->insertGetId(
                array(
                    'Title' => $request->Title,
                    'Nursery_ID' => $request->Nursery_ID
                )
            );

        return response()->json($id);
    }

    public function uploadCategoryImage(Request $request)
    {
        $id = $request->ID;
        $title = DB::table('category')
            ->where('ID', $id)
            ->value('Title');

        if ($request->hasFile('Image')) {
            $filename = $id . '-' . $title . '.' . $request->file('Image')->getClientOriginalExtension();
            $imagepath = url('/public/images/' . $filename);
            $path = $request->file('Image')->move('public/images', $filename);

            if ($path) {
                DB::table('category')
                    ->where('ID', $request->ID)
                    ->update(['Image' => $imagepath]);

                return response()->json($imagepath);
            }
        } 
        else
            return response()->json("No file selected");
    }

    public function editCategories(Request $request)
    {
        $category = Category::find($request->ID);

        if ($category) {
            if ($request->Title != $category->Title && $request->Title != null)
                $category->Title = $request->Title;
            
            if($request->hasFile('Image'))
            {
                $filename = $request->ID . '-' . $category->Title . '.' . $request->file('Image')->getClientOriginalExtension();
                $imagepath = url('/public/images/' . $filename);
                $path = $request->file('Image')->move('public/images', $filename);

                if ($path) {
                    DB::table('category')
                        ->where('ID', $request->ID)
                        ->update(['Title' => $category->Title, 'Image' => $imagepath]);
                }
                return response()->json(Category::find($request->ID));
            }

            else {
                DB::table('category')
                    ->where('ID', $request->ID)
                    ->update(['Title' => $category->Title]);

                return response()->json(Category::find($request->ID));
            }
        } 
        else
            return response()->json("Category does not exist");
    }

    public function deleteCategories(Request $request)
    {
        $category = Category::find($request->ID);

        if ($category) {
            DB::table('category')
                ->where('ID', $request->ID)
                ->delete();
            return response()->json('Category removed with all its plants');
        }

        else
            return response()->json('Category not found');
    }
}
