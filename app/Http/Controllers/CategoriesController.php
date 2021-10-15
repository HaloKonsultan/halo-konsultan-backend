<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Helpers\CollectionHelper;
use App\Http\Resources\ParentCategoriesResource;
use App\ParentCategories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    //
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function all()
    {
        try {
            $data = ParentCategories::all();
            $res =  ParentCategoriesResource::collection($data);
            return response()->json([
                'code' => 200,
                'data' => $res
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function random()
    {
        try {
            $data = Categories::inRandomOrder()->limit(5)->get();
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        }  catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function city($city)
    {
        try {
            $data = DB::table('consultants')
                ->leftJoin('categories', 'consultants.category_id', '=', 
                'categories.id')
                ->select('consultants.id', 'consultants.name', 
                'categories.name AS position','consultants.likes_total',
                'consultants.location', 'consultants.photo')
                ->where('consultants.location', 'LIKE', '%' . $city . '%')
                ->get();
            $paginated = CollectionHelper::paginate($data, 10);
            return response()->json([
                'code' => 200,
                'data' => $paginated
            ]);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function consultant($id)
    {
        try {
            $data = DB::table('consultants')
                        ->leftJoin('categories', 'consultants.category_id', '=', 
                        'categories.id')
                        ->select('consultants.id', 'consultants.name', 
                        'categories.name AS position', 'consultants.location', 
                        'consultants.photo')
                        ->where('consultants.category_id', '=', $id)
                        ->get();
            $paginated = CollectionHelper::paginate($data, 10);
            return response()->json([
                'code' => 200,
                'data' => $paginated
            ]);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }
}
